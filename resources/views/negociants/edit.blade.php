<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le négociant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
@include('partials.admin-nav')
<div class="container mt-5 mb-5" style="max-width: 600px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Modifier le négociant</h1>
        <a href="{{ route('negociants.index') }}" class="btn btn-outline-secondary">Retour à la liste</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('negociants.update', $negociant->Id_negociant) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label" for="Id_negociant">Identifiant</label>
                    <input class="form-control" id="Id_negociant" value="{{ $negociant->Id_negociant }}" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="Nom_negociant">Nom</label>
                    <input class="form-control" id="Nom_negociant" name="Nom_negociant" maxlength="20" value="{{ old('Nom_negociant', $negociant->Nom_negociant) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="Prenom_negociant">Prénom</label>
                    <input class="form-control" id="Prenom_negociant" name="Prenom_negociant" maxlength="30" value="{{ old('Prenom_negociant', $negociant->Prenom_negociant) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="Telephone_negociant">Téléphone</label>
                    <input class="form-control" id="Telephone_negociant" name="Telephone_negociant" maxlength="15" value="{{ old('Telephone_negociant', $negociant->Telephone_negociant) }}" required>
                </div>
                <button class="btn btn-success w-100" type="submit">Enregistrer les modifications</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
