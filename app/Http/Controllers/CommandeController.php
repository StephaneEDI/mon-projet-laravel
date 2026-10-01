<?php

namespace App\Http\Controllers;

use App\Models\Cepage;
use App\Models\Contrat;
use App\Services\PaiementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/** Ancien parcours de commande directe conservé pour référence; le panier est le flux web actuel. */
class CommandeController extends Controller
{
    protected PaiementService $paiementService;

    public function __construct(PaiementService $paiementService)
    {
        $this->paiementService = $paiementService;
    }

    // Afficher le formulaire de commande pour un cépage
    public function commanderForm(string $nom_cepage)
    {
        $cepage = Cepage::where('Nom_cepage', $nom_cepage)->firstOrFail();
        return view('client.commander', compact('cepage'));
    }

    // Traiter la commande et rediriger vers le paiement
    public function passerCommande(Request $request)
    {
        $request->validate([
            'Nom_cepage' => 'required|exists:cepages,Nom_cepage',
            'Qte_commande' => 'required|numeric|min:1',
            'Prix_unitaire' => 'required|numeric|min:1',
        ]);

        $user = Auth::user();
        $montantTotal = $request->Qte_commande * $request->Prix_unitaire;
        $maxNum = Contrat::max('Num_contrat') ?? 0;
        $numContrat = $maxNum + 1;

        $contrat = Contrat::create([
            'Num_contrat' => $numContrat,
            'Date_contrat' => now()->toDateString(),
            'Qte_commande' => $request->Qte_commande,
            'Nom_cepage' => $request->Nom_cepage,
            'Num_negociant' => $user ? $user->Id_utilisateur : 1,
        ]);

        $paiementData = [
            'transaction_id' => 'CMD-' . $numContrat . '-' . time(),
            'montant' => $montantTotal,
            'cepage' => $request->Nom_cepage,
            'client_nom' => $user ? $user->Nom_utilisateur : 'Client',
            'client_prenom' => $user ? $user->Prenom_utilisateur : 'Invité',
            'client_email' => $user ? $user->Email_utilisateur : 'client@example.com',
        ];

        $reponsePaiement = $this->paiementService->initialiserPaiement($paiementData);

        if (isset($reponsePaiement['code']) && $reponsePaiement['code'] === '201') {
            return redirect($reponsePaiement['data']['payment_url']);
        }

        return redirect()->route('home')->with('success', 'Commande #' . $numContrat . ' enregistrée avec succès !');
    }
}
