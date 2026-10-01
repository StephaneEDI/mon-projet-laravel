<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une Cuve</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
@include('partials.admin-nav')
<div class="container mt-5" style="max-width: 600px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Nouvelle Cuve</h2>
        <a href="{{ route('cuves.index') }}" class="btn btn-secondary">Retour</a>
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
            <form action="{{ route('cuves.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="Lettre_cuve">Identifiant de la cuve</label>
                    <input type="text" class="form-control" id="Lettre_cuve" name="Lettre_cuve" value="{{ old('Lettre_cuve') }}" maxlength="1" pattern="[A-Za-z]" placeholder="ex. A" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Capacité (en Litres)</label>
                    <input type="number" step="0.01" class="form-control" name="Capacite_cuve" value="{{ old('Capacite_cuve') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="Nom_cepage">Cépage stocké (facultatif)</label>
                    <select id="Nom_cepage" name="Nom_cepage" class="form-select">
                        <option value="">Cuve vide</option>
                        @foreach($cepages as $cepage)
                            <option value="{{ $cepage->Nom_cepage }}" {{ old('Nom_cepage') == $cepage->Nom_cepage ? 'selected' : '' }}>
                                {{ $cepage->Nom_cepage }} ({{ $cepage->Couleur_cepage }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success w-100">Enregistrer la cuve</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>