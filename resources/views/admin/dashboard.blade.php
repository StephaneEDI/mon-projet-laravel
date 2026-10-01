<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Administrateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light">
@include('partials.admin-nav')
<div class="container-fluid">
    <div class="row">
        <!-- Main Content -->
        <div class="col-12 p-4">
            <h1 class="mb-4">Vue d'ensemble de l'exploitation</h1>

            <!-- KPIs -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Cépages</h5>
                            <p class="display-6 fw-bold mb-0">{{ $totalCepages }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Contrats Actifs</h5>
                            <p class="display-6 fw-bold mb-0">{{ $totalContrats }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-dark shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Livraisons</h5>
                            <p class="display-6 fw-bold mb-0">{{ $totalLivraisons }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Cuves</h5>
                            <p class="display-6 fw-bold mb-0">{{ $totalCuves }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <a href="{{ route('livraisons.index') }}" class="card border-warning h-100 text-decoration-none text-dark">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <span>Livraisons à effectuer</span>
                            <strong class="fs-4">{{ $livraisonsAEffectuer }}</strong>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('livraisons.index') }}" class="card border-primary h-100 text-decoration-none text-dark">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <span>Livraisons en cours</span>
                            <strong class="fs-4">{{ $livraisonsEnCours }}</strong>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('livraisons.index') }}" class="card border-success h-100 text-decoration-none text-dark">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <span>Livraisons effectuées</span>
                            <strong class="fs-4">{{ $livraisonsEffectuees }}</strong>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Table des derniers contrats -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Derniers Contrats Signés</h5>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>N° Contrat</th>
                                <th>Cépage</th>
                                <th>Quantité</th>
                                <th>Date Contrat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($derniersContrats as $contrat)
                                <tr>
                                    <td><strong>#{{ $contrat->Num_contrat }}</strong></td>
                                    <td>{{ $contrat->Nom_cepage }}</td>
                                    <td>{{ number_format($contrat->Qte_commande, 2) }} kg</td>
                                    <td>{{ $contrat->Date_contrat }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted">Aucun contrat récent.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card shadow-sm mt-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Dernières demandes clients</h5>
                    <a href="{{ route('admin.commandes.index') }}" class="btn btn-sm btn-outline-success">Suivre les commandes</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>N° commande</th>
                                <th>Client</th>
                                <th>Articles</th>
                                <th>Total</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dernieresCommandes as $commande)
                                <tr>
                                    <td><strong>#{{ $commande->Id_commande }}</strong></td>
                                    <td>{{ $commande->client->Nom_utilisateur ?? 'Compte supprimé' }} {{ $commande->client->Prenom_utilisateur ?? '' }}</td>
                                    <td>{{ $commande->lignes->count() }} référence(s)</td>
                                    <td>{{ number_format($commande->Montant_total, 0, ',', ' ') }} FCFA</td>
                                    <td><span class="badge text-bg-secondary">{{ $commande->Statut_commande }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-3">Aucune demande client à suivre.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>