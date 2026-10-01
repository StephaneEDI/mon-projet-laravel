<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Contrats</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
@include('partials.admin-nav')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Liste des Contrats</h1>
        <a href="{{ route('contrats.create') }}" class="btn btn-primary">Nouveau Contrat</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>N° Contrat</th>
                        <th>Date</th>
                        <th>Négociant</th>
                        <th>Cépage</th>
                        <th>Quantité (kg)</th>
                        <th>Échéance</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contrats as $contrat)
                        <tr>
                            <td><strong>#{{ $contrat->Num_contrat }}</strong></td>
                            <td>{{ \Carbon\Carbon::parse($contrat->Date_contrat)->format('d/m/Y') }}</td>
                            <td>
                                @if ($contrat->client)
                                    {{ $contrat->client->Nom_utilisateur }} {{ $contrat->client->Prenom_utilisateur }}
                                    <small class="d-block text-muted">{{ $contrat->client->Email_utilisateur }}</small>
                                @elseif ($contrat->negociant)
                                    {{ $contrat->negociant->Nom_negociant }} {{ $contrat->negociant->Prenom_negociant }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $contrat->Nom_cepage ?? 'Non précisé' }}</td>
                            <td>{{ number_format($contrat->Qte_commande, 2, ',', ' ') }} kg</td>
                            <td>{{ \Carbon\Carbon::parse($contrat->Date_echeance_contrat)->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('contrats.edit', $contrat->Num_contrat) }}" class="btn btn-sm btn-warning">Modifier</a>
                                <form action="{{ route('contrats.destroy', $contrat->Num_contrat) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce contrat ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted">Aucun contrat enregistré.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>