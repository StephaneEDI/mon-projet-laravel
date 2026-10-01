<?php

namespace App\Http\Controllers;

use App\Models\Cepage;
use App\Models\Contrat;
use App\Models\Livraison;
use App\Models\Cuve;
use App\Models\CommandeClient;
use App\Models\LivraisonSuivie;
use Illuminate\Http\Request;

/** Prépare les données de la vitrine et du tableau de bord administrateur. */
class HomeController extends Controller
{
    // Vitrine publique pour les clients
    public function vitrine()
    {
        // Récupère tous les cépages ou une collection vide si la table est vide
        $cepages = Cepage::all();
        return view('client.vitrine', compact('cepages'));
    }

    // Dashboard Administrateur
    public function dashboardAdmin()
    {
        // Compte sécurisé des enregistrements
        $totalCepages = class_exists(Cepage::class) ? Cepage::count() : 0;
        $totalContrats = class_exists(Contrat::class) ? Contrat::count() : 0;
        $totalLivraisons = class_exists(Livraison::class) ? Livraison::count() : 0;
        $totalCuves = class_exists(Cuve::class) ? Cuve::count() : 0;

        // Récupération des derniers contrats (sans filtre latest si la colonne date varie)
        $derniersContrats = class_exists(Contrat::class) ? Contrat::take(5)->get() : [];
        $dernieresCommandes = CommandeClient::with(['client', 'lignes'])->latest('created_at')->take(5)->get();
        $livraisonsAEffectuer = LivraisonSuivie::where('Statut', 'a_effectuer')->count();
        $livraisonsEnCours = LivraisonSuivie::where('Statut', 'en_cours')->count();
        $livraisonsEffectuees = LivraisonSuivie::where('Statut', 'effectuee')->count();

        return view('admin.dashboard', compact(
            'totalCepages', 
            'totalContrats', 
            'totalLivraisons', 
            'totalCuves', 
            'derniersContrats',
            'dernieresCommandes',
            'livraisonsAEffectuer',
            'livraisonsEnCours',
            'livraisonsEffectuees'
        ));
    }
}