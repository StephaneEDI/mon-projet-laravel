<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Espace Client - Domaine Viticole</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<!-- Navbar Client -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">Le Domaine</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#client-navigation" aria-controls="client-navigation" aria-expanded="false" aria-label="Ouvrir le menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="client-navigation">
            <div class="navbar-nav me-auto">
                <a class="nav-link" href="{{ route('home') }}#cepages">Vitrine</a>
                <a class="nav-link" href="{{ route('panier.index') }}">Mon panier · {{ number_format(array_sum(session('panier', [])), 2, ',', ' ') }} kg</a>
            </div>
            <div class="d-flex align-items-center gap-3 text-white">
                <span><i class="bi bi-person-circle"></i> {{ $user->Nom_utilisateur }} {{ $user->Prenom_utilisateur }}</span>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Déconnexion</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<div class="container">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="row">
        <!-- Infos Utilisateur -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-person-bounding-box display-1 text-primary"></i>
                    </div>
                    <h4>{{ $user->Nom_utilisateur }} {{ $user->Prenom_utilisateur }}</h4>
                    <p class="text-muted mb-1">{{ $user->Email_utilisateur }}</p>
                    <span class="badge bg-success">Compte Négociant Active</span>
                </div>
            </div>
        </div>

        <!-- Historique Commandes & Livraisons -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-bold">
                    <i class="bi bi-bag-check me-2"></i> Mes demandes de commande
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Date</th>
                                    <th>Cépages</th>
                                    <th>Montant</th>
                                    <th>Commande</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mesCommandes as $commande)
                                    <tr>
                                        <td>#{{ $commande->Id_commande }}</td>
                                        <td>{{ $commande->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            @foreach($commande->lignes as $ligne)
                                                <div>{{ $ligne->Nom_cepage }} · {{ number_format($ligne->Quantite, 2, ',', ' ') }} kg</div>
                                            @endforeach
                                        </td>
                                        <td>{{ number_format($commande->Montant_total, 0, ',', ' ') }} FCFA</td>
                                        <td><span class="badge bg-secondary">{{ $commande->Statut_commande }}</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center text-muted py-3">Aucune demande de commande.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Section Mes Commandes -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-bold">
                    <i class="bi bi-bag-check me-2"></i> Mes Commandes / Contrats
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>N° Contrat</th>
                                <th>Cépage</th>
                                <th>Quantité</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mesContrats as $contrat)
                                <tr>
                                    <td><strong>#{{ $contrat->Num_contrat }}</strong></td>
                                    <td>{{ $contrat->Nom_cepage }}</td>
                                    <td>{{ number_format($contrat->Qte_commande, 0, ',', ' ') }} Kg</td>
                                    <td>{{ $contrat->Date_contrat }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">Aucune commande enregistrée pour le moment.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-bold">
                    <i class="bi bi-truck me-2"></i> Mes livraisons en cours et à venir
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Commande</th>
                                    <th>Cépage</th>
                                    <th>Quantité</th>
                                    <th>Date prévue</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mesLivraisonsSuivies as $suivi)
                                    <tr>
                                        <td>#{{ $suivi->ligne->Id_commande }}</td>
                                        <td>{{ $suivi->ligne->Nom_cepage }}</td>
                                        <td>{{ number_format($suivi->Qte_prevue, 2, ',', ' ') }} kg</td>
                                        <td>{{ $suivi->Date_reelle?->format('d/m/Y') ?? $suivi->Date_prevue?->format('d/m/Y') ?? 'À confirmer' }}</td>
                                        <td>
                                            @php
                                                $badge = ['a_effectuer' => 'bg-warning text-dark', 'en_cours' => 'bg-primary', 'effectuee' => 'bg-success', 'annulee' => 'bg-secondary'][$suivi->Statut] ?? 'bg-secondary';
                                            @endphp
                                            <span class="badge {{ $badge }}">{{ \App\Models\LivraisonSuivie::STATUTS[$suivi->Statut] ?? $suivi->Statut }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center text-muted py-3">Aucune livraison planifiée pour vos commandes.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Historique des livraisons issues des anciens contrats -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-bold">
                    <i class="bi bi-truck me-2"></i> Suivi des Livraisons & Factures
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>N° Livraison</th>
                                <th>Date effectuée</th>
                                <th>Qté Livrée</th>
                                <th>Contrat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mesLivraisons as $livraison)
                                <tr>
                                    <td><strong>#{{ $livraison->Num_livraison }}</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($livraison->Date_livree)->format('d/m/Y') }}</td>
                                    <td>{{ number_format($livraison->Qte_livree, 2, ',', ' ') }} Kg</td>
                                    <td>#{{ $livraison->Num_contrat }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">Aucune livraison effectuée pour le moment.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>