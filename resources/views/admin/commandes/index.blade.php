<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi des commandes | Administration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
@include('partials.admin-nav')

<main class="container-fluid px-4 py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
        <div>
            <p class="text-uppercase text-success fw-semibold small mb-1">Suivi client</p>
            <h1 class="h3 mb-0">Demandes de commande</h1>
        </div>
        <span class="text-secondary small">{{ $commandes->total() }} demande(s)</span>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <div class="table-responsive bg-white border rounded">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>N°</th>
                    <th>Date</th>
                    <th>Client</th>
                    <th>Articles</th>
                    <th class="text-end">Total</th>
                    <th>Statut</th>
                    <th>Enregistrer</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($commandes as $commande)
                    <tr>
                        <td class="fw-semibold">#{{ $commande->Id_commande }}</td>
                        <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <strong>{{ $commande->client->Nom_utilisateur ?? 'Compte supprimé' }} {{ $commande->client->Prenom_utilisateur ?? '' }}</strong>
                            @if ($commande->client)
                                <small class="d-block text-secondary">{{ $commande->client->Email_utilisateur }}</small>
                            @endif
                        </td>
                        <td>
                            @foreach ($commande->lignes as $ligne)
                                <div>{{ $ligne->Nom_cepage }} · {{ number_format($ligne->Quantite, 2, ',', ' ') }} kg</div>
                            @endforeach
                        </td>
                        <td class="text-end text-nowrap">{{ number_format($commande->Montant_total, 0, ',', ' ') }} FCFA</td>
                        <td>
                            <span class="badge text-bg-secondary">{{ $commande->Statut_commande }}</span>
                        </td>
                        <td>
                            <form action="{{ route('admin.commandes.statut', $commande->Id_commande) }}" method="POST" class="d-flex gap-2">
                                @csrf
                                @method('PATCH')
                                <label class="visually-hidden" for="statut-{{ $commande->Id_commande }}">Statut de la commande {{ $commande->Id_commande }}</label>
                                <select class="form-select form-select-sm" id="statut-{{ $commande->Id_commande }}" name="Statut_commande">
                                    @foreach ($statuts as $statut)
                                        <option value="{{ $statut }}" @selected($commande->Statut_commande === $statut)>{{ $statut }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-sm btn-success text-nowrap" type="submit">Mettre à jour</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-secondary py-5">Aucune demande de commande pour le moment.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $commandes->links() }}</div>
</main>
</body>
</html>