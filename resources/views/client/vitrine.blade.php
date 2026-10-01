<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Découvrez les cépages et les produits viticoles de notre domaine.">
    <title>Le Domaine | Nos cépages</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --ink: #202c23;
            --muted: #68736b;
            --forest: #263f32;
            --leaf: #c9d4b8;
            --paper: #f6f5ef;
            --white: #fffefa;
            --wine: #8f463d;
            --line: #e1e2d9;
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { margin: 0; color: var(--ink); background: var(--paper); font-family: 'DM Sans', sans-serif; }
        a { color: inherit; text-decoration: none; }
        button, input { font: inherit; }
        .visually-hidden { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0; }
        .shell { width: min(1160px, calc(100% - 48px)); margin: 0 auto; }

        .topbar { min-height: 78px; display: flex; align-items: center; background: var(--white); border-bottom: 1px solid var(--line); }
        .topbar-inner { display: flex; align-items: center; justify-content: space-between; gap: 24px; }
        .brand { display: inline-flex; align-items: center; gap: 12px; font-size: 16px; font-weight: 700; letter-spacing: 0; }
        .brand-mark { display: grid; place-items: center; width: 38px; height: 38px; color: var(--white); background: var(--forest); border-radius: 50%; font-family: 'Playfair Display', serif; font-size: 19px; }
        .brand-copy small { display: block; margin-top: 2px; color: var(--muted); font-size: 10px; font-weight: 500; text-transform: uppercase; }
        .nav-actions { display: flex; align-items: center; gap: 10px; }
        .nav-link { padding: 10px 13px; color: var(--ink); font-size: 13px; font-weight: 600; }
        .cart-link { padding: 9px 12px; border: 1px solid #cbd0c7; border-radius: 4px; color: var(--forest); font-size: 12px; font-weight: 700; white-space: nowrap; }
        .cart-link:hover { background: #eef0e9; }
        .button { display: inline-flex; align-items: center; justify-content: center; min-height: 42px; padding: 0 16px; border: 1px solid transparent; border-radius: 4px; cursor: pointer; font-size: 13px; font-weight: 700; transition: background .18s ease, color .18s ease, transform .18s ease; }
        .button:hover { transform: translateY(-1px); }
        .button-dark { color: var(--white); background: var(--forest); }
        .button-dark:hover { color: var(--white); background: #172c21; }
        .button-light { color: var(--forest); background: transparent; border-color: #cbd0c7; }
        .button-light:hover { background: #eef0e9; }
        .logout-form { margin: 0; }

        .hero { position: relative; display: flex; align-items: center; min-height: 590px; overflow: hidden; color: white; background: #233b2d url('https://images.unsplash.com/photo-1506377247377-2a5b3b417ebb?auto=format&fit=crop&w=2200&q=85') center 52% / cover no-repeat; }
        .hero::before { position: absolute; inset: 0; background: linear-gradient(90deg, rgba(19, 35, 26, .84) 0%, rgba(25, 42, 30, .62) 45%, rgba(25, 42, 30, .10) 100%); content: ''; }
        .hero-content { position: relative; z-index: 1; width: min(1160px, calc(100% - 48px)); margin: 0 auto; padding: 84px 0 96px; }
        .eyebrow { display: flex; align-items: center; gap: 11px; margin: 0 0 22px; color: #d7dfcb; font-size: 11px; font-weight: 700; letter-spacing: 0; text-transform: uppercase; }
        .eyebrow::before { width: 30px; height: 1px; background: #d7dfcb; content: ''; }
        .hero h1 { max-width: 650px; margin: 0; font-family: 'Playfair Display', Georgia, serif; font-size: 72px; font-weight: 500; line-height: 1.04; }
        .hero p { max-width: 450px; margin: 22px 0 28px; color: #e7e9e1; font-size: 16px; line-height: 1.75; }
        .hero .button { min-height: 48px; padding: 0 21px; color: var(--ink); background: #e7d9b8; }
        .hero .button:hover { background: #f2e7ce; }
        .hero-note { position: absolute; right: max(24px, calc((100% - 1160px) / 2)); bottom: 28px; color: rgba(255,255,255,.82); font-size: 11px; }
        .catalog-notice { margin-top: 20px; padding: 13px 16px; border: 1px solid #d3dfcc; border-radius: 4px; color: var(--forest); background: #e7eee3; font-size: 13px; }
        .catalog-notice-error { border-color: #e8c8c0; color: #7b3029; background: #f5e6e2; }

        .intro { display: flex; align-items: end; justify-content: space-between; gap: 24px; padding: 76px 0 30px; }
        .section-kicker { margin: 0 0 10px; color: var(--wine); font-size: 11px; font-weight: 700; letter-spacing: 0; text-transform: uppercase; }
        .intro h2 { margin: 0; font-family: 'Playfair Display', Georgia, serif; font-size: 42px; font-weight: 500; line-height: 1.15; }
        .intro-copy { max-width: 360px; margin: 0 0 4px; color: var(--muted); font-size: 14px; line-height: 1.7; }

        .catalog-tools { display: flex; align-items: center; justify-content: space-between; gap: 20px; padding: 20px 0; border-top: 1px solid var(--line); border-bottom: 1px solid var(--line); }
        .filters { display: flex; flex-wrap: wrap; gap: 8px; }
        .filter-button { min-height: 36px; padding: 0 13px; border: 1px solid transparent; border-radius: 3px; color: var(--muted); background: transparent; cursor: pointer; font-size: 12px; font-weight: 600; }
        .filter-button[aria-pressed="true"] { border-color: #cbd2c6; color: var(--forest); background: #e9ede4; }
        .search { width: min(100%, 270px); height: 40px; padding: 0 13px; border: 1px solid #d9ddd4; border-radius: 3px; outline: none; color: var(--ink); background: var(--white); font-size: 13px; }
        .search:focus { border-color: var(--forest); box-shadow: 0 0 0 3px rgba(38, 63, 50, .12); }

        .product-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 26px; padding: 28px 0 86px; }
        .product { min-width: 0; overflow: hidden; background: var(--white); border: 1px solid var(--line); border-radius: 5px; transition: transform .2s ease, box-shadow .2s ease; }
        .product:hover { transform: translateY(-3px); box-shadow: 0 14px 32px rgba(33, 45, 35, .08); }
        .product-image-wrap { position: relative; aspect-ratio: 4 / 3; overflow: hidden; background: #d6ddce; }
        .product-image { width: 100%; height: 100%; object-fit: cover; transition: transform .35s ease; }
        .product:hover .product-image { transform: scale(1.035); }
        .product-label { position: absolute; top: 14px; left: 14px; padding: 7px 10px; border-radius: 2px; color: var(--forest); background: rgba(255,254,250,.94); font-size: 10px; font-weight: 700; text-transform: uppercase; }
        .product-body { padding: 20px 20px 18px; }
        .product-meta { display: flex; align-items: center; justify-content: space-between; gap: 12px; color: var(--muted); font-size: 11px; }
        .product-meta span:first-child { color: var(--wine); font-weight: 700; text-transform: uppercase; }
        .product h3 { margin: 11px 0 8px; font-family: 'Playfair Display', Georgia, serif; font-size: 26px; font-weight: 600; }
        .product-description { min-height: 44px; margin: 0; color: var(--muted); font-size: 13px; line-height: 1.65; }
        .product-facts { display: flex; gap: 20px; margin: 18px 0; padding: 14px 0; border-top: 1px solid var(--line); border-bottom: 1px solid var(--line); }
        .fact { color: var(--muted); font-size: 10px; }
        .fact strong { display: block; margin-top: 4px; color: var(--ink); font-size: 12px; }
        .product-bottom { display: flex; align-items: center; justify-content: space-between; gap: 12px; }
        .price { font-size: 11px; color: var(--muted); }
        .price strong { display: block; color: var(--ink); font-size: 17px; }
        .price small { font-size: 10px; }
        .out-of-stock { color: var(--wine); font-size: 11px; font-weight: 700; }

        .empty-state { grid-column: 1 / -1; display: grid; grid-template-columns: minmax(200px, .8fr) 1.2fr; align-items: center; min-height: 300px; overflow: hidden; background: #e8ebdf; border-radius: 5px; }
        .empty-image { width: 100%; height: 100%; min-height: 300px; object-fit: cover; }
        .empty-copy { padding: 35px clamp(24px, 5vw, 64px); }
        .empty-copy h3 { margin: 0 0 12px; font-family: 'Playfair Display', Georgia, serif; font-size: 30px; font-weight: 500; }
        .empty-copy p { max-width: 450px; margin: 0; color: var(--muted); font-size: 14px; line-height: 1.7; }
        .no-results { grid-column: 1 / -1; padding: 50px 20px; color: var(--muted); text-align: center; }
        .no-results[hidden], .product[hidden] { display: none; }

        .footer { padding: 25px 0; color: #e6e9e1; background: var(--forest); font-size: 12px; }
        .footer-inner { display: flex; align-items: center; justify-content: space-between; gap: 20px; }
        .footer p { margin: 0; }
        .contact-band { padding: 44px 0; background: #e9ece3; border-top: 1px solid var(--line); }
        .contact-inner { display: flex; align-items: center; justify-content: space-between; gap: 24px; }
        .contact-title { margin: 0; font-family: 'Playfair Display', Georgia, serif; font-size: 30px; font-weight: 500; }
        .contact-copy { margin: 7px 0 0; color: var(--muted); font-size: 13px; }
        .contact-actions { display: flex; flex-wrap: wrap; gap: 10px; }
        .contact-actions .button { gap: 9px; }
        .contact-actions .bi { font-size: 18px; }
        .contact-whatsapp { color: #fff; background: #168653; }
        .contact-whatsapp:hover { color: #fff; background: #116d43; }

        @media (max-width: 760px) {
            .shell { width: min(100% - 32px, 560px); }
            .topbar { min-height: 70px; }
            .topbar-inner { gap: 10px; }
            .brand { gap: 8px; font-size: 14px; }
            .brand-mark { width: 34px; height: 34px; }
            .brand-copy small { display: none; }
            .nav-actions { gap: 4px; }
            .nav-link { padding: 8px; font-size: 12px; }
            .button { min-height: 38px; padding: 0 11px; font-size: 12px; }
            .hero { min-height: 540px; background-position: 60% center; }
            .hero::before { background: linear-gradient(90deg, rgba(19, 35, 26, .82), rgba(19, 35, 26, .38)); }
            .hero-content { width: min(100% - 32px, 560px); padding: 72px 0 88px; }
            .hero h1 { font-size: 46px; }
            .hero p { max-width: 390px; font-size: 14px; }
            .hero-note { right: 16px; bottom: 17px; font-size: 10px; }
            .intro { display: block; padding: 55px 0 24px; }
            .intro h2 { font-size: 34px; }
            .intro-copy { margin-top: 12px; }
            .catalog-tools { align-items: stretch; flex-direction: column; gap: 12px; }
            .search { width: 100%; }
            .product-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; padding-bottom: 56px; }
            .product-body { padding: 15px; }
            .product h3 { font-size: 22px; }
            .product-description { min-height: 64px; }
            .product-facts { gap: 12px; }
            .product-bottom { align-items: flex-start; flex-direction: column; }
            .product-bottom .button { width: 100%; }
            .empty-state { grid-template-columns: 1fr; }
            .empty-image { min-height: 190px; max-height: 230px; }
            .empty-copy { padding: 25px; }
            .contact-inner { align-items: flex-start; flex-direction: column; }
            .contact-title { font-size: 26px; }
        }

        @media (max-width: 420px) {
            .topbar-inner { flex-wrap: wrap; padding: 10px 0; }
            .nav-actions { width: 100%; justify-content: flex-end; flex-wrap: wrap; }
            .hero h1 { font-size: 40px; }
            .product-grid { grid-template-columns: 1fr; }
            .product-description { min-height: 0; }
            .product-bottom { align-items: center; flex-direction: row; }
            .product-bottom .button { width: auto; }
            .footer-inner { align-items: flex-start; flex-direction: column; gap: 8px; }
        }
    </style>
</head>
<body>
<header class="topbar">
    <div class="shell topbar-inner">
        <a class="brand" href="{{ route('home') }}" aria-label="Le Domaine, accueil">
            <span class="brand-mark" aria-hidden="true">V</span>
            <span class="brand-copy">Le Domaine<small>Vigne & terroir</small></span>
        </a>
        <nav class="nav-actions" aria-label="Navigation principale">
            <a class="nav-link" href="#cepages">Nos cépages</a>
            @if (filled(config('contact.email')) || filled(config('contact.whatsapp')))
                <a class="nav-link" href="#contact">Contact</a>
            @endif
            @auth
                @if (auth()->user() instanceof \App\Models\User && auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="button button-light">Espace admin</a>
                @else
                    <a class="cart-link" href="{{ route('panier.index') }}">Panier · {{ number_format(array_sum(session('panier', [])), 2, ',', ' ') }} kg</a>
                    <a href="{{ route('client.profil') }}" class="button button-light">Mon compte</a>
                @endif
                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit" class="button button-dark">Déconnexion</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="button button-light">Connexion</a>
                <a href="{{ route('register') }}" class="button button-dark">Créer un compte</a>
            @endauth
        </nav>
    </div>
</header>

<main>
    @if (session('success'))
        <div class="shell catalog-notice" role="status">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="shell catalog-notice catalog-notice-error" role="alert">{{ $errors->first() }}</div>
    @endif
    <section class="hero" aria-labelledby="hero-title">
        <div class="hero-content">
            <p class="eyebrow">Le goût du terroir</p>
            <h1 id="hero-title">Les cépages du Domaine</h1>
            <p>Des variétés choisies avec soin, façonnées par leur région et cultivées pour révéler leur caractère.</p>
            <a href="#cepages" class="button">Explorer la sélection</a>
        </div>
        <span class="hero-note">Du vignoble à votre table</span>
    </section>

    <section class="shell" id="cepages" aria-labelledby="catalog-title">
        <div class="intro">
            <div>
                <p class="section-kicker">La sélection du Domaine</p>
                <h2 id="catalog-title">Nos cépages</h2>
            </div>
            <p class="intro-copy">Chaque variété raconte une région, une couleur et un équilibre qui lui sont propres.</p>
        </div>

        @if ($cepages->isNotEmpty() && (!auth()->check() || !auth()->user()->isAdmin()))
            <div class="catalog-tools">
                <div class="filters" role="group" aria-label="Filtrer les cépages par couleur">
                    <button class="filter-button" type="button" data-filter="all" aria-pressed="true">Tous les cépages</button>
                    <button class="filter-button" type="button" data-filter="rouge" aria-pressed="false">Rouges</button>
                    <button class="filter-button" type="button" data-filter="blanc" aria-pressed="false">Blancs</button>
                </div>
                <label>
                    <span class="visually-hidden">Rechercher un cépage ou une région</span>
                    <input class="search" type="search" placeholder="Rechercher un cépage ou une région" data-search>
                </label>
            </div>
        @endif

        <div class="product-grid" data-product-grid>
            @forelse($cepages as $cepage)
                @php
                    $imagePath = trim((string) $cepage->Image_cepage);
                    $imageUrl = $imagePath
                        ? (\Illuminate\Support\Str::startsWith($imagePath, ['http://', 'https://']) ? $imagePath : asset('storage/' . ltrim($imagePath, '/')))
                        : 'https://images.unsplash.com/photo-1516594915697-87eb3b1c14ea?auto=format&fit=crop&w=1000&q=80';
                    $color = \Illuminate\Support\Str::lower((string) $cepage->Couleur_cepage);
                @endphp
                <article class="product" data-product data-color="{{ $color }}" data-search-text="{{ \Illuminate\Support\Str::lower($cepage->Nom_cepage . ' ' . $cepage->Region_cepage . ' ' . $cepage->Couleur_cepage) }}">
                    <div class="product-image-wrap">
                        <img class="product-image" src="{{ $imageUrl }}" alt="{{ $cepage->Nom_cepage }} du terroir de {{ $cepage->Region_cepage }}" loading="lazy">
                        <span class="product-label">{{ $cepage->Couleur_cepage }}</span>
                    </div>
                    <div class="product-body">
                        <div class="product-meta">
                            <span>{{ $cepage->Region_cepage }}</span>
                            <span>{{ number_format($cepage->Qte_cepage_disponible, 0, ',', ' ') }} kg disponibles</span>
                        </div>
                        <h3>{{ $cepage->Nom_cepage }}</h3>
                        <p class="product-description">{{ \Illuminate\Support\Str::limit($cepage->Description_cepage, 110) }}</p>
                        <div class="product-facts">
                            <div class="fact">Teneur en sucre<strong>{{ number_format($cepage->Teneur_suc_cepage, 1, ',', ' ') }} g/L</strong></div>
                            <div class="fact">Disponibilité<strong>{{ $cepage->Qte_cepage_disponible > 0 ? 'En stock' : 'Épuisé' }}</strong></div>
                        </div>
                        <div class="product-bottom">
                            <div class="price">
                                @if ($cepage->Prix_kg_cepage > 0)
                                    <strong>{{ number_format($cepage->Prix_kg_cepage, 0, ',', ' ') }} FCFA</strong>
                                    <small>par kilogramme</small>
                                @else
                                    <strong>Prix sur demande</strong>
                                @endif
                            </div>
                            @if ($cepage->Qte_cepage_disponible > 0)
                                @if (!auth()->check() || !auth()->user()->isAdmin())
                                    <form action="{{ route('panier.ajouter') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="Nom_cepage" value="{{ $cepage->Nom_cepage }}">
                                        <input type="hidden" name="quantite" value="1">
                                        <button class="button button-dark" type="submit">Ajouter au panier · 1 kg</button>
                                    </form>
                                @endif
                            @else
                                <span class="out-of-stock">Indisponible actuellement</span>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <div class="empty-state">
                    <img class="empty-image" src="https://images.unsplash.com/photo-1516594915697-87eb3b1c14ea?auto=format&fit=crop&w=1000&q=80" alt="Rangées de vignes au Domaine" loading="lazy">
                    <div class="empty-copy">
                        <p class="section-kicker">Le catalogue se prépare</p>
                        <h3>Les premières fiches arrivent bientôt.</h3>
                        <p>Les cépages disponibles seront présentés ici avec leur région, leurs caractéristiques et leur prix dès leur publication par le Domaine.</p>
                    </div>
                </div>
            @endforelse
            @if ($cepages->isNotEmpty())
                <p class="no-results" data-no-results hidden>Aucun cépage ne correspond à cette recherche.</p>
            @endif
        </div>
    </section>
</main>

@if (filled(config('contact.email')) || filled(config('contact.whatsapp')))
    <section class="contact-band" id="contact" aria-labelledby="contact-title">
        <div class="shell contact-inner">
            <div>
                <p class="section-kicker">Une question ?</p>
                <h2 class="contact-title" id="contact-title">Contactez le Domaine</h2>
                <p class="contact-copy">Notre équipe est à votre écoute pour vous renseigner.</p>
            </div>
            <div class="contact-actions">
                @if (filled(config('contact.email')))
                    <a class="button button-light" href="mailto:{{ config('contact.email') }}" aria-label="Envoyer un courriel à {{ config('contact.email') }}">
                        <i class="bi bi-envelope" aria-hidden="true"></i>
                        <span>{{ config('contact.email') }}</span>
                    </a>
                @endif
                @if (filled(config('contact.whatsapp')))
                    <a class="button contact-whatsapp" href="https://wa.me/{{ preg_replace('/\D+/', '', config('contact.whatsapp')) }}?text={{ rawurlencode(config('contact.whatsapp_message')) }}" target="_blank" rel="noopener noreferrer" aria-label="Contacter le Domaine sur WhatsApp">
                        <i class="bi bi-whatsapp" aria-hidden="true"></i>
                        <span>WhatsApp</span>
                    </a>
                @endif
            </div>
        </div>
    </section>
@endif

<footer class="footer">
    <div class="shell footer-inner">
        <p>Le Domaine · Vigne & terroir</p>
        <p>Des cépages choisis avec soin.</p>
    </div>
</footer>

@if ($cepages->isNotEmpty() && (!auth()->check() || !auth()->user()->isAdmin()))
    <script>
        const productCards = [...document.querySelectorAll('[data-product]')];
        const filterButtons = [...document.querySelectorAll('[data-filter]')];
        const searchInput = document.querySelector('[data-search]');
        const noResults = document.querySelector('[data-no-results]');
        let activeColor = 'all';

        function updateCatalog() {
            const term = searchInput.value.trim().toLocaleLowerCase('fr');
            let visibleCount = 0;

            productCards.forEach((card) => {
                const color = card.dataset.color;
                const matchesColor = activeColor === 'all' || color.includes(activeColor);
                const matchesSearch = card.dataset.searchText.includes(term);
                const visible = matchesColor && matchesSearch;
                card.hidden = !visible;
                visibleCount += visible ? 1 : 0;
            });

            noResults.hidden = visibleCount > 0;
        }

        filterButtons.forEach((button) => {
            button.addEventListener('click', () => {
                activeColor = button.dataset.filter;
                filterButtons.forEach((filter) => filter.setAttribute('aria-pressed', String(filter === button)));
                updateCatalog();
            });
        });

        searchInput.addEventListener('input', updateCatalog);
    </script>
@endif
</body>
</html>