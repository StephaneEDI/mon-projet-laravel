<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Suivi des Livraisons par Contrat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
@include('partials.admin-nav')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Suivi Contrats - Livraisons</h1>
        <a href="{{ route('concerners.create') }}" class="btn btn-primary">Associer une Livraison à un Contrat</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Contrat</th>
                        <th>Livraison</th>
                        <th>Quantité Livrée (Kg)</th>
                        <th>Date de Livraison</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($concerners as $item)
                        <tr>
                            <td>{{ $item->numero }}</td>
                            <td><strong>Contrat n°{{ $item->Num_contrat }}</strong></td>
                            <td><span class="badge bg-secondary">Livraison n°{{ $item->Num_livraison }}</span></td>
                            <td>{{ number_format($item->Qte_livree, 2) }} kg</td>
                            <td>{{ \Carbon\Carbon::parse($item->Date_livree)->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('concerners.edit', $item->numero) }}" class="btn btn-sm btn-warning">Modifier</a>
                                <form action="{{ route('concerners.destroy', $item->numero) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette association ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted">Aucune association enregistrée.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>