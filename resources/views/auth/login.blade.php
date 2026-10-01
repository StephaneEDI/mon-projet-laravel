<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Domaine Viticole</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">Le Domaine</a>
        <div class="navbar-nav ms-auto flex-row gap-3">
            <a class="nav-link" href="{{ route('home') }}">Accueil</a>
            <a class="nav-link" href="{{ route('register') }}">Créer un compte</a>
        </div>
    </div>
</nav>
<div class="container mt-5" style="max-width: 450px;">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h3 class="text-center mb-4">Connexion</h3>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Adresse Email</label>
                    <input type="email" name="Email_utilisateur" class="form-control" value="{{ old('Email_utilisateur') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="Password_utilisateur" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-3">Se connecter</button>
            </form>

            <div class="text-center">
                <small>Pas encore de compte ? <a href="{{ route('register') }}">S'inscrire</a></small>
            </div>
        </div>
    </div>
</div>
</body>
</html>