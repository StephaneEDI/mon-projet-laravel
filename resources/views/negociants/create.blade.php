<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Négociant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
@include('partials.admin-nav')
<div class="container mt-5" style="max-width: 600px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Nouveau Négociant</h2>
        <a href="{{ route('negociants.index') }}" class="btn btn-secondary">Retour</a>
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
            <form action="{{ route('negociants.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">ID Négociant</label>
                    <input type="number" class="form-control" name="Id_negociant" value="{{ old('Id_negociant') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nom</label>
                    <input type="text" class="form-control" name="Nom_negociant" value="{{ old('Nom_negociant') }}" required maxlength="20">
                </div>
                <div class="mb-3">
                    <label class="form-label">Prénom</label>
                    <input type="text" class="form-control" name="Prenom_negociant" value="{{ old('Prenom_negociant') }}" required maxlength="30">
                </div>
                <div class="mb-3">
                    <label class="form-label">Téléphone</label>
                    <input type="text" class="form-control" name="Telephone_negociant" value="{{ old('Telephone_negociant') }}" required maxlength="15">
                </div>
                <button type="submit" class="btn btn-success w-100">Enregistrer</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>