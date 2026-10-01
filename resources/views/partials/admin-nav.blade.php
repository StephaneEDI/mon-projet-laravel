<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm" aria-label="Navigation administration">
    <div class="container-fluid px-3 px-lg-4">
        <a class="navbar-brand fw-semibold" href="{{ route('admin.dashboard') }}">Domaine <span class="text-success">/</span> Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#admin-navigation" aria-controls="admin-navigation" aria-expanded="false" aria-label="Ouvrir le menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="admin-navigation">
            <div class="navbar-nav me-auto my-2 my-lg-0">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" @if(request()->routeIs('admin.dashboard')) aria-current="page" @endif href="{{ route('admin.dashboard') }}">Tableau de bord</a>
                <a class="nav-link {{ request()->routeIs('cepages.*') ? 'active' : '' }}" @if(request()->routeIs('cepages.*')) aria-current="page" @endif href="{{ route('cepages.index') }}">Cépages</a>
                <a class="nav-link {{ request()->routeIs('negociants.*') ? 'active' : '' }}" @if(request()->routeIs('negociants.*')) aria-current="page" @endif href="{{ route('negociants.index') }}">Négociants</a>
                <a class="nav-link {{ request()->routeIs('cuves.*') ? 'active' : '' }}" @if(request()->routeIs('cuves.*')) aria-current="page" @endif href="{{ route('cuves.index') }}">Cuves</a>
                <a class="nav-link {{ request()->routeIs('contrats.*') ? 'active' : '' }}" @if(request()->routeIs('contrats.*')) aria-current="page" @endif href="{{ route('contrats.index') }}">Contrats</a>
                <a class="nav-link {{ request()->routeIs('admin.commandes.*') ? 'active' : '' }}" @if(request()->routeIs('admin.commandes.*')) aria-current="page" @endif href="{{ route('admin.commandes.index') }}">Commandes</a>
                <a class="nav-link {{ request()->routeIs('livraisons.*') ? 'active' : '' }}" @if(request()->routeIs('livraisons.*')) aria-current="page" @endif href="{{ route('livraisons.index') }}">Livraisons</a>
                <a class="nav-link {{ request()->routeIs('concerners.*') ? 'active' : '' }}" @if(request()->routeIs('concerners.*')) aria-current="page" @endif href="{{ route('concerners.index') }}">Suivi contrats</a>
            </div>
            <div class="d-flex align-items-center gap-2 pb-2 pb-lg-0">
                <a class="btn btn-outline-light btn-sm" href="{{ route('home') }}">Voir la vitrine</a>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button class="btn btn-success btn-sm" type="submit">Déconnexion</button>
                </form>
            </div>
        </div>
    </div>
</nav>

@once
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endonce
