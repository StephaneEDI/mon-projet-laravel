<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Enregistrer une Livraison</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 500px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Nouvelle Livraison</h2>
        <a href="{{ route('livraisons.index') }}" class="btn btn-secondary">Retour</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('livraisons.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Numéro de Livraison</label>
                    <input type="number" class="form-control" name="Num_livraison" value="{{ old('Num_livraison') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Date Réelle de Livraison</label>
                    <input type="date" class="form-control" name="Date_reel_livraison" value="{{ old('Date_reel_livraison') }}" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Enregistrer</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>