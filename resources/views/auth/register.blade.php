<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Domaine Viticole</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">Le Domaine</a>
        <div class="navbar-nav ms-auto flex-row gap-3">
            <a class="nav-link" href="{{ route('home') }}">Accueil</a>
            <a class="nav-link" href="{{ route('login') }}">Connexion</a>
        </div>
    </div>
</nav>
<div class="container mt-5 mb-5" style="max-width: 500px;">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h3 class="text-center mb-4">Créer un compte Client</h3>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" name="Nom_utilisateur" class="form-control" value="{{ old('Nom_utilisateur') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Prénom</label>
                        <input type="text" name="Prenom_utilisateur" class="form-control" value="{{ old('Prenom_utilisateur') }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Adresse Email</label>
                    <input type="email" name="Email_utilisateur" class="form-control" value="{{ old('Email_utilisateur') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="Telephone_utilisateur" class="form-control" value="{{ old('Telephone_utilisateur') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="Password_utilisateur" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirmer le mot de passe</label>
                    <input type="password" name="Password_utilisateur_confirmation" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success w-100 mb-3">S'inscrire</button>
            </form>

            <div class="text-center">
                <small>Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a></small>
            </div>
        </div>
    </div>
</div>
</body>
</html>