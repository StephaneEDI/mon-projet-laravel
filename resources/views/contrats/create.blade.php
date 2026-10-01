<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un Contrat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
@include('partials.admin-nav')
<div class="container mt-5" style="max-width: 600px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Nouveau Contrat</h2>
        <a href="{{ route('contrats.index') }}" class="btn btn-secondary">Retour</a>
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
            <form action="{{ route('contrats.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Numéro de Contrat</label>
                    <input type="number" class="form-control" name="Num_contrat" value="{{ old('Num_contrat') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="Id_utilisateur">Négociant concerné</label>
                    <select id="Id_utilisateur" name="Id_utilisateur" class="form-select" required @disabled($negociants->isEmpty())>
                        @if ($negociants->isEmpty())
                            <option value="" selected disabled>Aucun compte négociant enregistré</option>
                        @else
                            <option value="" disabled @selected(old('Id_utilisateur') === null)>-- Sélectionner un négociant --</option>
                            @foreach($negociants as $negociant)
                                <option value="{{ $negociant->Id_utilisateur }}" @selected(old('Id_utilisateur') == $negociant->Id_utilisateur)>
                                    {{ $negociant->Nom_utilisateur }} {{ $negociant->Prenom_utilisateur }} · {{ $negociant->Email_utilisateur }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @if ($negociants->isEmpty())
                        <div class="form-text">Aucun compte client avec le rôle négociant n’est enregistré. Le client doit d’abord créer un compte sur la vitrine.</div>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label">Date du Contrat</label>
                    <input type="date" class="form-control" name="Date_contrat" value="{{ old('Date_contrat') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="Date_echeance_contrat">Date d’échéance</label>
                    <input type="date" id="Date_echeance_contrat" class="form-control" name="Date_echeance_contrat" value="{{ old('Date_echeance_contrat') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="Qte_commande">Quantité prévue (kg)</label>
                    <input type="number" id="Qte_commande" step="0.01" min="0.01" class="form-control" name="Qte_commande" value="{{ old('Qte_commande') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="Nom_cepage">Cépage (facultatif)</label>
                    <select id="Nom_cepage" name="Nom_cepage" class="form-select">
                        <option value="">Non précisé</option>
                        @foreach($cepages as $cepage)
                            <option value="{{ $cepage->Nom_cepage }}" @selected(old('Nom_cepage') === $cepage->Nom_cepage)>
                                {{ $cepage->Nom_cepage }} · {{ $cepage->Couleur_cepage }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success w-100">Enregistrer le contrat</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>