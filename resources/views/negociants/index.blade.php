<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Négociants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
@include('partials.admin-nav')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Liste des Négociants</h1>
        <div>
            <a href="{{ route('cepages.index') }}" class="btn btn-outline-secondary me-2">Voir Cépages</a>
            <a href="{{ route('negociants.create') }}" class="btn btn-primary">Ajouter un Négociant</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Téléphone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($negociants as $negociant)
                        <tr>
                            <td>{{ $negociant->Id_negociant }}</td>
                            <td>{{ $negociant->Nom_negociant }}</td>
                            <td>{{ $negociant->Prenom_negociant }}</td>
                            <td>{{ $negociant->Telephone_negociant }}</td>
                            <td>
                                <a href="{{ route('negociants.edit', $negociant->Id_negociant) }}" class="btn btn-sm btn-warning">Modifier</a>
                                <form action="{{ route('negociants.destroy', $negociant->Id_negociant) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce négociant ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted">Aucun négociant trouvé.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>