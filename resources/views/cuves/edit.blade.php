<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la cuve {{ $cuve->Lettre_cuve }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
@include('partials.admin-nav')
<div class="container mt-5 mb-5" style="max-width: 600px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Modifier la cuve {{ $cuve->Lettre_cuve }}</h1>
        <a href="{{ route('cuves.index') }}" class="btn btn-outline-secondary">Retour aux cuves</a>
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
            <form action="{{ route('cuves.update', $cuve->Lettre_cuve) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label" for="Capacite_cuve">Capacité (litres)</label>
                    <input class="form-control" id="Capacite_cuve" type="number" name="Capacite_cuve" min="0.01" step="0.01" value="{{ old('Capacite_cuve', $cuve->Capacite_cuve) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="Nom_cepage">Cépage stocké</label>
                    <select class="form-select" id="Nom_cepage" name="Nom_cepage">
                        <option value="">Cuve vide</option>
                        @foreach ($cepages as $cepage)
                            <option value="{{ $cepage->Nom_cepage }}" @selected(old('Nom_cepage', $cuve->Nom_cepage) === $cepage->Nom_cepage)>
                                {{ $cepage->Nom_cepage }} · {{ $cepage->Couleur_cepage }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success w-100">Enregistrer les modifications</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
