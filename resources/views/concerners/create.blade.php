<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Associer Contrat et Livraison</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
@include('partials.admin-nav')
<div class="container mt-5" style="max-width: 600px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Lier une Livraison</h2>
        <a href="{{ route('concerners.index') }}" class="btn btn-secondary">Retour</a>
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
            <form action="{{ route('concerners.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Contrat</label>
                    <select name="Num_contrat" class="form-select" required>
                        <option value="">-- Choisir un contrat --</option>
                        @foreach($contrats as $contrat)
                            <option value="{{ $contrat->Num_contrat }}" {{ old('Num_contrat') == $contrat->Num_contrat ? 'selected' : '' }}>
                                Contrat n°{{ $contrat->Num_contrat }} (Cépage : {{ $contrat->Nom_cepage }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Livraison</label>
                    <select name="Num_livraison" class="form-select" required>
                        <option value="">-- Choisir une livraison --</option>
                        @foreach($livraisons as $livraison)
                            <option value="{{ $livraison->Num_livraison }}" {{ old('Num_livraison') == $livraison->Num_livraison ? 'selected' : '' }}>
                                Livraison n°{{ $livraison->Num_livraison }} (du {{ $livraison->Date_reel_livraison }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Quantité Livrée (Kg)</label>
                    <input type="number" step="0.01" class="form-control" name="Qte_livree" value="{{ old('Qte_livree') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date Effective de Livraison</label>
                    <input type="date" class="form-control" name="Date_livree" value="{{ old('Date_livree') }}" required>
                </div>

                <button type="submit" class="btn btn-success w-100">Enregistrer</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>