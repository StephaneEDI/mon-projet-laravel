<?php

namespace App\Http\Controllers;

use App\Models\CommandeClient;
use App\Models\CommandeLigne;
use App\Models\Concerner;
use App\Models\LivraisonSuivie;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB as DBFacade;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

/** Planifie les livraisons de commandes, suit leur progression et conserve l'historique des contrats. */
class LivraisonController extends Controller
{
    // Afficher la liste des livraisons (côté Admin)
    public function index()
    {
        $commandesAConfirmer = CommandeClient::where('Statut_commande', 'En attente')->count();
        $lignesCommande = CommandeLigne::with(['commande.client', 'cepage', 'livraisons'])
            ->whereHas('commande', function ($query) {
                $query->whereIn('Statut_commande', ['Confirmée', 'En préparation', 'Expédiée']);
            })
            ->get();

        $aPlanifier = $lignesCommande->filter(fn ($ligne) => $this->quantiteRestante($ligne) > 0);
        $aEffectuer = LivraisonSuivie::with(['ligne.commande.client', 'ligne.cepage'])
            ->where('Statut', 'a_effectuer')
            ->orderBy('Date_prevue')
            ->get();
        $enCours = LivraisonSuivie::with(['ligne.commande.client', 'ligne.cepage'])
            ->where('Statut', 'en_cours')
            ->orderBy('Date_prevue')
            ->get();
        $effectuees = LivraisonSuivie::with(['ligne.commande.client', 'ligne.cepage'])
            ->where('Statut', 'effectuee')
            ->latest('Date_reelle')
            ->get();
        $historiqueAncien = Concerner::with(['livraison', 'contrat.cepage', 'contrat.negociant'])
            ->orderByDesc('Date_livree')
            ->get();

        return view('livraisons.index', compact(
            'aPlanifier',
            'aEffectuer',
            'enCours',
            'effectuees',
            'historiqueAncien',
            'commandesAConfirmer'
        ));
    }

    // Formulaire de création d'une livraison
    public function create()
    {
        return redirect()->route('livraisons.index');
    }

    // Enregistrer une livraison
    public function store(Request $request)
    {
        $validated = $request->validate([
            'Id_ligne' => ['required', 'integer', 'exists:commande_lignes,Id_ligne'],
            'Qte_prevue' => ['required', 'numeric', 'gt:0'],
            'Date_prevue' => ['required', 'date', 'after_or_equal:today'],
        ]);

        DBFacade::transaction(function () use ($validated) {
            $ligne = CommandeLigne::with('livraisons')->lockForUpdate()->findOrFail($validated['Id_ligne']);
            $commande = CommandeClient::findOrFail($ligne->Id_commande);

            if (!in_array($commande->Statut_commande, ['Confirmée', 'En préparation', 'Expédiée'], true)) {
                throw ValidationException::withMessages([
                    'Id_ligne' => 'La commande doit être confirmée avant de planifier une livraison.',
                ]);
            }

            $dejaPlanifiee = (float) $ligne->livraisons
                ->where('Statut', '!=', 'annulee')
                ->sum('Qte_prevue');
            $restante = (float) $ligne->Quantite - $dejaPlanifiee;

            if ((float) $validated['Qte_prevue'] > $restante) {
                throw ValidationException::withMessages([
                    'Qte_prevue' => 'La quantité dépasse le restant à livrer (' . number_format(max(0, $restante), 2, ',', ' ') . ' kg).',
                ]);
            }

            LivraisonSuivie::create([
                'Id_ligne' => $ligne->Id_ligne,
                'Qte_prevue' => $validated['Qte_prevue'],
                'Date_prevue' => $validated['Date_prevue'],
                'Statut' => 'a_effectuer',
            ]);
        });

        return redirect()->route('livraisons.index')->with('success', 'Livraison planifiée.');
    }

    public function modifierStatut(Request $request, LivraisonSuivie $livraisonSuivie)
    {
        $validated = $request->validate([
            'Statut' => ['required', Rule::in(['en_cours', 'effectuee', 'annulee'])],
        ]);

        $transitions = [
            'a_effectuer' => ['en_cours', 'annulee'],
            'en_cours' => ['effectuee', 'annulee'],
        ];

        if (!in_array($validated['Statut'], $transitions[$livraisonSuivie->Statut] ?? [], true)) {
            throw ValidationException::withMessages([
                'Statut' => 'Cette transition de statut n’est pas autorisée.',
            ]);
        }

        $livraisonSuivie->update([
            'Statut' => $validated['Statut'],
            'Date_reelle' => $validated['Statut'] === 'effectuee' ? now()->toDateString() : null,
        ]);

        return redirect()->route('livraisons.index')->with('success', 'Le suivi de la livraison a été mis à jour.');
    }

    private function quantiteRestante(CommandeLigne $ligne): float
    {
        $planifiee = (float) $ligne->livraisons
            ->where('Statut', '!=', 'annulee')
            ->sum('Qte_prevue');

        return max(0, (float) $ligne->Quantite - $planifiee);
    }

    // Télécharger la facture / bon de livraison en PDF
    public function telechargerFacture(int $num_livraison)
    {
        $livraison = Concerner::with(['livraison', 'contrat.cepage', 'contrat.negociant'])
            ->where('Num_livraison', $num_livraison)
            ->firstOrFail();

        $pdf = Pdf::loadView('pdf.facture', compact('livraison'));

        return $pdf->download('Facture_Livraison_' . $livraison->Num_livraison . '.pdf');
    }
}