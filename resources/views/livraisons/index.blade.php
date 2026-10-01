<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi des livraisons | Administration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { color: #26332a; background: #f4f5f1; }
        .page-header { padding: 26px 0 22px; }
        .eyebrow { color: #57745b; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .section-title { font-size: 17px; font-weight: 700; }
        .table th { color: #617065; font-size: 11px; font-weight: 700; text-transform: uppercase; white-space: nowrap; }
        .table td { font-size: 13px; }
        .summary { border: 1px solid #e0e4dc; border-radius: 5px; }
        .summary-label { color: #68736b; font-size: 12px; }
        .summary-value { font-size: 27px; font-weight: 700; }
        .small-muted { color: #68736b; font-size: 12px; }
        .schedule-form { display: grid; grid-template-columns: 110px 145px auto; gap: 8px; align-items: end; }
        @media (max-width: 700px) { .schedule-form { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
@include('partials.admin-nav')

<main class="container-fluid px-4 pb-5">
    <div class="page-header d-flex flex-wrap justify-content-between align-items-end gap-3">
        <div>
            <p class="eyebrow mb-1">Exécution & historique</p>
            <h1 class="h3 mb-0">Suivi des livraisons</h1>
        </div>
        <span class="small-muted">Les quantités planifiées sont déduites du restant à livrer.</span>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    @if ($commandesAConfirmer > 0)
        <div class="alert alert-info d-flex flex-wrap justify-content-between align-items-center gap-2" role="status">
            <span>{{ $commandesAConfirmer }} commande(s) client attend(ent) une confirmation. Elles apparaîtront ici après confirmation.</span>
            <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.commandes.index') }}">Ouvrir les commandes</a>
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-6 col-xl-3"><div class="summary bg-white p-3"><div class="summary-label">Commandes à planifier</div><div class="summary-value">{{ $aPlanifier->count() }}</div></div></div>
        <div class="col-6 col-xl-3"><div class="summary bg-white p-3"><div class="summary-label">À effectuer</div><div class="summary-value">{{ $aEffectuer->count() }}</div></div></div>
        <div class="col-6 col-xl-3"><div class="summary bg-white p-3"><div class="summary-label">En cours</div><div class="summary-value">{{ $enCours->count() }}</div></div></div>
        <div class="col-6 col-xl-3"><div class="summary bg-white p-3"><div class="summary-label">Effectuées</div><div class="summary-value">{{ $effectuees->count() + $historiqueAncien->count() }}</div></div></div>
    </div>

    <section class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h2 class="section-title mb-1">Commandes à planifier</h2>
            <p class="small-muted mb-0">Une ligne apparaît tant qu’il reste une quantité à livrer.</p>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr><th>Commande</th><th>Client</th><th>Cépage</th><th>Commandée</th><th>Restant</th><th>Planifier une livraison</th></tr></thead>
                <tbody>
                    @forelse ($aPlanifier as $ligne)
                        @php
                            $dejaPlanifiee = (float) $ligne->livraisons->where('Statut', '!=', 'annulee')->sum('Qte_prevue');
                            $restante = max(0, (float) $ligne->Quantite - $dejaPlanifiee);
                        @endphp
                        <tr>
                            <td class="fw-semibold">#{{ $ligne->commande->Id_commande }}</td>
                            <td>{{ $ligne->commande->client->Nom_utilisateur ?? 'Client' }} {{ $ligne->commande->client->Prenom_utilisateur ?? '' }}</td>
                            <td>{{ $ligne->Nom_cepage }}</td>
                            <td>{{ number_format($ligne->Quantite, 2, ',', ' ') }} kg</td>
                            <td class="fw-semibold">{{ number_format($restante, 2, ',', ' ') }} kg</td>
                            <td>
                                <form action="{{ route('livraisons.suivi.store') }}" method="POST" class="schedule-form">
                                    @csrf
                                    <input type="hidden" name="Id_ligne" value="{{ $ligne->Id_ligne }}">
                                    <div>
                                        <label class="form-label small mb-1" for="qte-{{ $ligne->Id_ligne }}">Quantité (kg)</label>
                                        <input class="form-control form-control-sm" id="qte-{{ $ligne->Id_ligne }}" type="number" name="Qte_prevue" min="0.01" max="{{ number_format($restante, 2, '.', '') }}" step="0.01" required>
                                    </div>
                                    <div>
                                        <label class="form-label small mb-1" for="date-{{ $ligne->Id_ligne }}">Date prévue</label>
                                        <input class="form-control form-control-sm" id="date-{{ $ligne->Id_ligne }}" type="date" name="Date_prevue" min="{{ now()->toDateString() }}" required>
                                    </div>
                                    <button class="btn btn-sm btn-success" type="submit">Planifier</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-secondary py-4">Aucune commande en attente de planification.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    @foreach ([['titre' => 'À effectuer', 'items' => $aEffectuer, 'next' => 'en_cours', 'button' => 'Démarrer la livraison', 'badge' => 'text-bg-warning'], ['titre' => 'En cours', 'items' => $enCours, 'next' => 'effectuee', 'button' => 'Marquer comme effectuée', 'badge' => 'text-bg-primary']] as $section)
        <section class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3"><h2 class="section-title mb-0">{{ $section['titre'] }} <span class="badge {{ $section['badge'] }}">{{ $section['items']->count() }}</span></h2></div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead><tr><th>Suivi</th><th>Prévue</th><th>Commande</th><th>Client</th><th>Cépage</th><th>Quantité</th><th>Action</th></tr></thead>
                    <tbody>
                        @forelse ($section['items'] as $suivi)
                            <tr>
                                <td class="fw-semibold">#{{ $suivi->Id_suivi }}</td>
                                <td>{{ $suivi->Date_prevue?->format('d/m/Y') ?? 'À définir' }}</td>
                                <td>#{{ $suivi->ligne->commande->Id_commande }}</td>
                                <td>{{ $suivi->ligne->commande->client->Nom_utilisateur ?? 'Client' }} {{ $suivi->ligne->commande->client->Prenom_utilisateur ?? '' }}</td>
                                <td>{{ $suivi->ligne->Nom_cepage }}</td>
                                <td>{{ number_format($suivi->Qte_prevue, 2, ',', ' ') }} kg</td>
                                <td>
                                    <form class="d-flex gap-2" action="{{ route('livraisons.suivi.statut', $suivi->Id_suivi) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm {{ $section['next'] === 'effectuee' ? 'btn-success' : 'btn-primary' }}" type="submit" name="Statut" value="{{ $section['next'] }}">{{ $section['button'] }}</button>
                                        <button class="btn btn-sm btn-outline-danger" type="submit" name="Statut" value="annulee">Annuler</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-secondary py-4">Aucune livraison {{ \Illuminate\Support\Str::lower($section['titre']) }}.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    @endforeach

    <section class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3"><h2 class="section-title mb-0">Historique des livraisons effectuées</h2></div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr><th>Suivi</th><th>Date effectuée</th><th>Commande</th><th>Client</th><th>Cépage</th><th>Quantité</th><th>Statut</th></tr></thead>
                <tbody>
                    @forelse ($effectuees as $suivi)
                        <tr>
                            <td>#{{ $suivi->Id_suivi }}</td>
                            <td>{{ $suivi->Date_reelle?->format('d/m/Y') ?? '—' }}</td>
                            <td>#{{ $suivi->ligne->commande->Id_commande }}</td>
                            <td>{{ $suivi->ligne->commande->client->Nom_utilisateur ?? 'Client' }} {{ $suivi->ligne->commande->client->Prenom_utilisateur ?? '' }}</td>
                            <td>{{ $suivi->ligne->Nom_cepage }}</td>
                            <td>{{ number_format($suivi->Qte_prevue, 2, ',', ' ') }} kg</td>
                            <td><span class="badge text-bg-success">Effectuée</span></td>
                        </tr>
                    @empty
                        @if ($historiqueAncien->isEmpty())
                            <tr><td colspan="7" class="text-center text-secondary py-4">Aucune livraison effectuée pour le moment.</td></tr>
                        @endif
                    @endforelse
                    @foreach ($historiqueAncien as $item)
                        <tr>
                            <td>Historique #{{ $item->Num_livraison }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->Date_livree)->format('d/m/Y') }}</td>
                            <td>Contrat #{{ $item->Num_contrat }}</td>
                            <td>{{ $item->contrat->negociant->Nom_negociant ?? '—' }}</td>
                            <td>{{ $item->contrat->Nom_cepage ?? '—' }}</td>
                            <td>{{ number_format($item->Qte_livree, 2, ',', ' ') }} kg</td>
                            <td><span class="badge text-bg-success">Historique</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</main>
</body>
</html>