<?php

namespace App\Http\Controllers;

use App\Models\Cepage;
use App\Models\CommandeClient;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/** Gère le panier de session et transforme sa confirmation en demande de commande. */
class PanierController extends Controller
{
    public function index(Request $request): View
    {
        $panier = $request->session()->get('panier', []);
        $cepages = Cepage::whereIn('Nom_cepage', array_keys($panier))->get()->keyBy('Nom_cepage');
        $lignes = [];
        $total = 0;
        $quantiteTotale = 0;

        foreach ($panier as $nom => $quantite) {
            $cepage = $cepages->get($nom);
            if (!$cepage) {
                unset($panier[$nom]);
                continue;
            }

            $sousTotal = (float) $cepage->Prix_kg_cepage * (float) $quantite;
            $lignes[] = [
                'cepage' => $cepage,
                'quantite' => (float) $quantite,
                'sousTotal' => $sousTotal,
            ];
            $total += $sousTotal;
            $quantiteTotale += (float) $quantite;
        }

        $request->session()->put('panier', $panier);

        return view('client.panier', compact('lignes', 'total', 'quantiteTotale'));
    }

    public function ajouter(Request $request): RedirectResponse
    {
        if ($request->user() instanceof User && $request->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $validated = $request->validate([
            'Nom_cepage' => ['required', 'string', 'exists:cepages,Nom_cepage'],
            'quantite' => ['required', 'numeric', 'min:0.01'],
        ]);

        $cepage = Cepage::findOrFail($validated['Nom_cepage']);
        $panier = $request->session()->get('panier', []);
        $nouvelleQuantite = (float) ($panier[$cepage->Nom_cepage] ?? 0) + (float) $validated['quantite'];

        if ($nouvelleQuantite > (float) $cepage->Qte_cepage_disponible) {
            return back()->withErrors([
                'quantite' => 'La quantité demandée dépasse le stock disponible (' . number_format($cepage->Qte_cepage_disponible, 2, ',', ' ') . ' kg).',
            ]);
        }

        $panier[$cepage->Nom_cepage] = $nouvelleQuantite;
        $request->session()->put('panier', $panier);

        if (!$request->user()) {
            $request->session()->put('url.intended', route('panier.index'));

            return redirect()->route('register')->with(
                'success',
                'Votre sélection est gardée. Créez votre compte client pour consulter et confirmer le panier.'
            );
        }

        return redirect()->route('panier.index')->with('success', $cepage->Nom_cepage . ' a été ajouté au panier.');
    }

    public function modifier(Request $request, string $nom_cepage): RedirectResponse
    {
        $validated = $request->validate([
            'quantite' => ['required', 'numeric', 'min:0.01'],
        ]);

        $cepage = Cepage::findOrFail($nom_cepage);
        $quantite = (float) $validated['quantite'];

        if ($quantite > (float) $cepage->Qte_cepage_disponible) {
            return back()->withErrors([
                'quantite' => 'La quantité demandée dépasse le stock disponible (' . number_format($cepage->Qte_cepage_disponible, 2, ',', ' ') . ' kg).',
            ]);
        }

        $panier = $request->session()->get('panier', []);
        $panier[$cepage->Nom_cepage] = $quantite;
        $request->session()->put('panier', $panier);

        return redirect()->route('panier.index')->with('success', 'La quantité a été mise à jour.');
    }

    public function retirer(Request $request, string $nom_cepage): RedirectResponse
    {
        $panier = $request->session()->get('panier', []);
        unset($panier[$nom_cepage]);
        $request->session()->put('panier', $panier);

        return redirect()->route('panier.index')->with('success', 'Le cépage a été retiré du panier.');
    }

    public function confirmer(Request $request): RedirectResponse
    {
        $panier = $request->session()->get('panier', []);
        if (!$panier) {
            return redirect()->route('panier.index')->withErrors([
                'panier' => 'Ajoutez au moins un cépage avant de confirmer la demande.',
            ]);
        }

        // Relire prix et stocks dans une transaction pour ne pas faire confiance aux données du navigateur.
        $commande = DB::transaction(function () use ($request, $panier) {
            $cepages = Cepage::whereIn('Nom_cepage', array_keys($panier))
                ->lockForUpdate()
                ->get()
                ->keyBy('Nom_cepage');

            if ($cepages->count() !== count($panier)) {
                throw ValidationException::withMessages([
                    'panier' => 'Un cépage de votre panier n’est plus disponible. Vérifiez votre sélection.',
                ]);
            }

            $lignes = [];
            $total = 0;

            foreach ($panier as $nom => $quantite) {
                $cepage = $cepages->get($nom);
                $quantite = (float) $quantite;

                if ($quantite <= 0 || $quantite > (float) $cepage->Qte_cepage_disponible) {
                    throw ValidationException::withMessages([
                        'panier' => 'Le stock de ' . $cepage->Nom_cepage . ' a changé. Ajustez la quantité avant de confirmer.',
                    ]);
                }

                $prix = (float) $cepage->Prix_kg_cepage;
                $sousTotal = $quantite * $prix;
                $lignes[] = [
                    'Nom_cepage' => $cepage->Nom_cepage,
                    'Quantite' => $quantite,
                    'Prix_unitaire' => $prix,
                    'Sous_total' => $sousTotal,
                ];
                $total += $sousTotal;
            }

            $commande = CommandeClient::create([
                'Id_utilisateur' => $request->user()->Id_utilisateur,
                'Montant_total' => $total,
                'Statut_commande' => 'En attente',
            ]);

            foreach ($lignes as $ligne) {
                $commande->lignes()->create($ligne);
            }

            return $commande;
        });

        $request->session()->forget('panier');

        return redirect()->route('client.profil')->with(
            'success',
            'Votre demande de commande n°' . $commande->Id_commande . ' a été transmise au Domaine.'
        );
    }
}
