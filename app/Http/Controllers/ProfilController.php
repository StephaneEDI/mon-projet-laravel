<?php

namespace App\Http\Controllers;

use App\Models\Contrat;
use App\Models\Livraison;
use App\Models\CommandeClient;
use App\Models\Concerner;
use App\Models\LivraisonSuivie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/** Regroupe les commandes et les livraisons appartenant au client connecté. */
class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Récupérer les contrats/commandes spécifiques au négociant/client connecté
        $mesContrats = Contrat::where(function ($query) use ($user) {
            $query->where('Id_utilisateur', $user->Id_utilisateur)
                ->orWhere('Id_negociant', $user->Id_utilisateur);
        })
            ->orderBy('Date_contrat', 'desc')
            ->get();
        $mesCommandes = CommandeClient::with('lignes')
            ->where('Id_utilisateur', $user->Id_utilisateur)
            ->latest('created_at')
            ->get();

        // Récupérer les numéros de contrats du client
        $contratIds = $mesContrats->pluck('Num_contrat');

        // Récupérer les livraisons associées à ces contrats
        $mesLivraisons = Concerner::with('livraison')
            ->whereIn('Num_contrat', $contratIds)
            ->orderBy('Date_livree', 'desc')
            ->get();

        $mesLivraisonsSuivies = LivraisonSuivie::with('ligne')
            ->whereHas('ligne.commande', function ($query) use ($user) {
                $query->where('Id_utilisateur', $user->Id_utilisateur);
            })
            ->latest('created_at')
            ->get();

        return view('client.profil', compact('user', 'mesContrats', 'mesLivraisons', 'mesLivraisonsSuivies', 'mesCommandes'));
    }
}