<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le contrat #{{ $contrat->Num_contrat }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
@include('partials.admin-nav')
<div class="container mt-5 mb-5" style="max-width: 650px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Modifier le contrat #{{ $contrat->Num_contrat }}</h1>
        <a href="{{ route('contrats.index') }}" class="btn btn-outline-secondary">Retour à la liste</a>
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
            <form action="{{ route('contrats.update', $contrat->Num_contrat) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label" for="Id_utilisateur">Négociant concerné</label>
                    <select id="Id_utilisateur" name="Id_utilisateur" class="form-select" required @disabled($negociants->isEmpty())>
                        @if ($negociants->isEmpty())
                            <option value="" selected disabled>Aucun compte négociant enregistré</option>
                        @else
                            @foreach($negociants as $negociant)
                                <option value="{{ $negociant->Id_utilisateur }}" @selected(old('Id_utilisateur', $contrat->Id_utilisateur) == $negociant->Id_utilisateur)>
                                    {{ $negociant->Nom_utilisateur }} {{ $negociant->Prenom_utilisateur }} · {{ $negociant->Email_utilisateur }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="Date_contrat">Date du contrat</label>
                        <input id="Date_contrat" class="form-control" type="date" name="Date_contrat" value="{{ old('Date_contrat', $contrat->Date_contrat) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="Date_echeance_contrat">Date d’échéance</label>
                        <input id="Date_echeance_contrat" class="form-control" type="date" name="Date_echeance_contrat" value="{{ old('Date_echeance_contrat', $contrat->Date_echeance_contrat) }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="Qte_commande">Quantité prévue (kg)</label>
                    <input id="Qte_commande" class="form-control" type="number" name="Qte_commande" min="0.01" step="0.01" value="{{ old('Qte_commande', $contrat->Qte_commande) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="Nom_cepage">Cépage (facultatif)</label>
                    <select id="Nom_cepage" name="Nom_cepage" class="form-select">
                        <option value="">Non précisé</option>
                        @foreach($cepages as $cepage)
                            <option value="{{ $cepage->Nom_cepage }}" @selected(old('Nom_cepage', $contrat->Nom_cepage) === $cepage->Nom_cepage)>
                                {{ $cepage->Nom_cepage }} · {{ $cepage->Couleur_cepage }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-success w-100" type="submit">Enregistrer les modifications</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
