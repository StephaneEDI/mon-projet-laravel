<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Cépage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
@include('partials.admin-nav')

<div class="container mt-5 mb-5" style="max-width: 700px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Modifier le Cépage : {{ $cepage->Nom_cepage }}</h2>
        <a href="{{ route('cepages.index') }}" class="btn btn-secondary">Retour à la liste</a>
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
            <form action="{{ route('cepages.update', $cepage->Nom_cepage) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="Nom_cepage" class="form-label">Nom du cépage (Non modifiable)</label>
                    <input type="text" class="form-control" id="Nom_cepage" value="{{ $cepage->Nom_cepage }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="Couleur_cepage" class="form-label">Couleur</label>
                    <select class="form-select" id="Couleur_cepage" name="Couleur_cepage" required>
                        <option value="" disabled>Choisir une couleur</option>
                        @foreach ($couleurs as $couleur)
                            <option value="{{ $couleur }}" @selected(old('Couleur_cepage', $cepage->Couleur_cepage) === $couleur)>{{ $couleur }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="Region_cepage" class="form-label">Région</label>
                    <input type="text" class="form-control" id="Region_cepage" name="Region_cepage" value="{{ old('Region_cepage', $cepage->Region_cepage) }}" required maxlength="30">
                </div>

                <div class="mb-3">
                    <label for="Image_cepage" class="form-label">Remplacer la photo</label>
                    <input type="file" class="form-control" id="Image_cepage" name="Image_cepage" accept="image/jpeg,image/png,image/webp">
                    <div class="form-text">JPG, PNG ou WebP, 5 Mo maximum. Laissez vide pour conserver la photo actuelle.</div>
                    @if ($cepage->Image_cepage)
                        @php
                            $imagePath = trim((string) $cepage->Image_cepage);
                            $imageUrl = \Illuminate\Support\Str::startsWith($imagePath, ['http://', 'https://'])
                                ? $imagePath
                                : asset('storage/' . ltrim($imagePath, '/'));
                        @endphp
                        <img src="{{ $imageUrl }}" alt="Photo actuelle de {{ $cepage->Nom_cepage }}" class="img-thumbnail mt-2" style="max-width: 220px; max-height: 160px; object-fit: cover;">
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="Teneur_suc_cepage" class="form-label">Teneur sucre (g/L)</label>
                        <input type="number" step="0.01" class="form-control" id="Teneur_suc_cepage" name="Teneur_suc_cepage" value="{{ old('Teneur_suc_cepage', $cepage->Teneur_suc_cepage) }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="Prix_kg_cepage" class="form-label">Prix / kg (FCFA)</label>
                        <input type="number" step="0.01" class="form-control" id="Prix_kg_cepage" name="Prix_kg_cepage" value="{{ old('Prix_kg_cepage', $cepage->Prix_kg_cepage) }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="Qte_cepage_disponible" class="form-label">Stock disponible (kg)</label>
                        <input type="number" step="0.01" class="form-control" id="Qte_cepage_disponible" name="Qte_cepage_disponible" value="{{ old('Qte_cepage_disponible', $cepage->Qte_cepage_disponible) }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="Description_cepage" class="form-label">Description</label>
                    <textarea class="form-control" id="Description_cepage" name="Description_cepage" rows="3" required>{{ old('Description_cepage', $cepage->Description_cepage) }}</textarea>
                </div>

                <button type="submit" class="btn btn-warning w-100">Mettre à jour le cépage</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>