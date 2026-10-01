<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Cuves</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
@include('partials.admin-nav')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Liste des Cuves</h1>
        <a href="{{ route('cuves.create') }}" class="btn btn-primary">Ajouter une Cuve</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Cuve</th>
                        <th>Capacité (L)</th>
                        <th>Affectation</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cuves as $cuve)
                        <tr>
                            <td><strong>Cuve {{ $cuve->Lettre_cuve }}</strong></td>
                            <td>{{ number_format($cuve->Capacite_cuve, 2) }}</td>
                            <td>
                                @if ($cuve->cepage)
                                    <span class="badge bg-info text-dark">{{ $cuve->cepage->Nom_cepage }}</span>
                                    <span class="text-muted">{{ $cuve->cepage->Couleur_cepage }}</span>
                                @else
                                    <span class="badge bg-secondary">Libre</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('cuves.edit', $cuve->Lettre_cuve) }}" class="btn btn-sm btn-warning">Modifier</a>
                                <form action="{{ route('cuves.destroy', $cuve->Lettre_cuve) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette cuve ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted">Aucune cuve enregistrée.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>