<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Cépages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
@include('partials.admin-nav')

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Liste des Cépages</h1>
        <a href="{{ route('cepages.create') }}" class="btn btn-primary">Ajouter un cépage</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Couleur</th>
                        <th>Région</th>
                        <th>Teneur Sucre (g/L)</th>
                        <th>Prix / kg (FCFA)</th>
                        <th>Stock (kg)</th>
                        <th>Modifier</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cepages as $cepage)
                        <tr>
                            <td><strong>{{ $cepage->Nom_cepage }}</strong></td>
                            <td>{{ $cepage->Couleur_cepage }}</td>
                            <td>{{ $cepage->Region_cepage }}</td>
                            <td>{{ $cepage->Teneur_suc_cepage }}</td>
                            <td>{{ number_format($cepage->Prix_kg_cepage, 2) }}</td>
                            <td>{{ number_format($cepage->Qte_cepage_disponible, 2) }}</td>
                            <td>
                                <a href="{{ route('cepages.edit', $cepage->Nom_cepage) }}" class="btn btn-sm btn-warning">Modifier</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Aucun cépage trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>