<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CepageController;
use App\Http\Controllers\NegociantController;
use App\Http\Controllers\CuveController;
use App\Http\Controllers\LivraisonController;
use App\Http\Controllers\ContratController;
use App\Http\Controllers\ConcernerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\PanierController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Vitrine Client (Page d'accueil publique)
Route::get('/', [HomeController::class, 'vitrine'])->name('home');

// Modules de gestion : toutes ces routes exigent une session et le rôle administrateur.
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [HomeController::class, 'dashboardAdmin'])->name('admin.dashboard');

    Route::resource('cepages', CepageController::class)->only([
        'index',
        'create',
        'store',
        'edit',
        'update',
    ]);
    Route::resource('negociants', NegociantController::class)->except(['show']);
    Route::resource('cuves', CuveController::class)->except(['show']);
    Route::get('/livraisons', [LivraisonController::class, 'index'])->name('livraisons.index');
    Route::post('/livraisons/suivi', [LivraisonController::class, 'store'])->name('livraisons.suivi.store');
    Route::patch('/livraisons/suivi/{livraisonSuivie}/statut', [LivraisonController::class, 'modifierStatut'])->name('livraisons.suivi.statut');
    Route::resource('contrats', ContratController::class)->except(['show']);
    Route::resource('concerners', ConcernerController::class)->except(['show']);
});



// Formulaires web de connexion, d'inscription client et de déconnexion.
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// L'ajout peut commencer comme visiteur; consultation et confirmation exigent un compte client.
Route::post('/panier/articles', [PanierController::class, 'ajouter'])->name('panier.ajouter');
Route::middleware(['auth', 'client'])->group(function () {
    Route::get('/panier', [PanierController::class, 'index'])->name('panier.index');
    Route::patch('/panier/articles/{nom_cepage}', [PanierController::class, 'modifier'])->name('panier.modifier');
    Route::delete('/panier/articles/{nom_cepage}', [PanierController::class, 'retirer'])->name('panier.retirer');
    Route::post('/panier/confirmer', [PanierController::class, 'confirmer'])->name('panier.confirmer');
});

Route::middleware(['auth', 'admin'])->group(function () {
    // L'administration suit les demandes clients séparément des anciens contrats.
    Route::get('/admin/commandes', [\App\Http\Controllers\AdminCommandeController::class, 'index'])->name('admin.commandes.index');
    Route::patch('/admin/commandes/{commande}/statut', [\App\Http\Controllers\AdminCommandeController::class, 'modifierStatut'])->name('admin.commandes.statut');
});

// Documents PDF réservés aux utilisateurs connectés.
Route::middleware(['auth'])->group(function () {
    Route::get('/livraison/{id}/pdf', [LivraisonController::class, 'telechargerFacture'])->name('livraisondownload.pdf');
});


// Profil, commandes et historique personnel accessibles au client connecté.
Route::middleware(['auth', 'client'])->group(function () {
    Route::get('/mon-compte', [ProfilController::class, 'index'])->name('client.profil');
});