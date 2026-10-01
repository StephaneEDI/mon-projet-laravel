<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon panier | Le Domaine</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --ink: #202c23; --muted: #68736b; --forest: #263f32; --paper: #f6f5ef; --white: #fffefa; --wine: #8f463d; --line: #e1e2d9; }
        * { box-sizing: border-box; }
        body { margin: 0; color: var(--ink); background: var(--paper); font-family: 'DM Sans', sans-serif; }
        a { color: inherit; text-decoration: none; }
        button, input { font: inherit; }
        .visually-hidden { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0; }
        .shell { width: min(100% - 40px, 1060px); margin: 0 auto; }
        .topbar { min-height: 72px; display: flex; align-items: center; background: var(--white); border-bottom: 1px solid var(--line); }
        .topbar-inner { display: flex; align-items: center; justify-content: space-between; gap: 20px; }
        .brand { font-size: 15px; font-weight: 700; }
        .nav { display: flex; align-items: center; gap: 16px; color: var(--muted); font-size: 13px; font-weight: 600; }
        .main { padding: 55px 0 80px; }
        .eyebrow { margin: 0 0 10px; color: var(--wine); font-size: 11px; font-weight: 700; text-transform: uppercase; }
        h1 { margin: 0; font-family: 'Playfair Display', Georgia, serif; font-size: 42px; font-weight: 500; }
        .lead { margin: 10px 0 30px; color: var(--muted); font-size: 14px; }
        .notice { margin: 0 0 16px; padding: 13px 16px; color: var(--forest); background: #e7eee3; border: 1px solid #d3dfcc; border-radius: 4px; font-size: 13px; }
        .errors { color: #7b3029; background: #f5e6e2; border-color: #e8c8c0; }
        .cart-layout { display: grid; grid-template-columns: minmax(0, 1fr) 300px; align-items: start; gap: 24px; }
        .line-list, .summary, .empty { background: var(--white); border: 1px solid var(--line); border-radius: 5px; }
        .line { display: grid; grid-template-columns: 112px minmax(0, 1fr) auto; align-items: center; gap: 18px; padding: 18px; border-bottom: 1px solid var(--line); }
        .line:last-child { border-bottom: 0; }
        .line img { width: 112px; height: 92px; border-radius: 3px; object-fit: cover; background: #e5e9df; }
        .meta { color: var(--wine); font-size: 10px; font-weight: 700; text-transform: uppercase; }
        h2 { margin: 5px 0; font-family: 'Playfair Display', Georgia, serif; font-size: 21px; font-weight: 600; }
        .unit { color: var(--muted); font-size: 12px; }
        .quantity-form { display: flex; align-items: center; gap: 7px; margin-top: 12px; }
        .quantity { width: 92px; height: 36px; padding: 0 9px; border: 1px solid #cbd1c7; border-radius: 3px; }
        .button { min-height: 37px; display: inline-flex; align-items: center; justify-content: center; padding: 0 13px; border: 1px solid transparent; border-radius: 3px; cursor: pointer; font-size: 12px; font-weight: 700; }
        .button-dark { color: white; background: var(--forest); }
        .button-dark:hover { background: #172c21; }
        .button-light { color: var(--forest); background: transparent; border-color: #cbd1c7; }
        .remove { display: block; margin-top: 8px; padding: 0; border: 0; color: var(--wine); background: none; cursor: pointer; font-size: 11px; }
        .line-total { text-align: right; white-space: nowrap; }
        .line-total strong { display: block; font-size: 15px; }
        .line-total small { color: var(--muted); font-size: 11px; }
        .summary { padding: 20px; }
        .summary h2 { margin: 0 0 18px; font-size: 22px; }
        .summary-row { display: flex; justify-content: space-between; gap: 16px; margin: 12px 0; color: var(--muted); font-size: 13px; }
        .summary-total { margin-top: 18px; padding-top: 17px; border-top: 1px solid var(--line); color: var(--ink); font-weight: 700; }
        .summary-total strong { font-size: 20px; }
        .summary-note { margin: 16px 0 0; color: var(--muted); font-size: 11px; line-height: 1.6; }
        .empty { padding: 50px 24px; text-align: center; }
        .empty h2 { font-size: 28px; }
        .empty p { margin: 8px 0 22px; color: var(--muted); font-size: 14px; }
        @media (max-width: 760px) {
            .main { padding: 38px 0 55px; }
            .cart-layout { grid-template-columns: 1fr; }
            .summary { grid-row: 1; }
        }
        @media (max-width: 500px) {
            .shell { width: min(100% - 28px, 430px); }
            h1 { font-size: 35px; }
            .line { grid-template-columns: 76px minmax(0, 1fr); align-items: start; gap: 12px; padding: 13px; }
            .line img { width: 76px; height: 74px; }
            .line-total { grid-column: 2; display: flex; align-items: center; justify-content: space-between; text-align: left; }
            .quantity-form { flex-wrap: wrap; }
        }
    </style>
</head>
<body>
<header class="topbar">
    <div class="shell topbar-inner">
        <a class="brand" href="{{ route('home') }}">Le Domaine · Vigne & terroir</a>
        <nav class="nav" aria-label="Navigation principale">
            <a href="{{ route('home') }}#cepages">Nos cépages</a>
            <a href="{{ route('panier.index') }}" aria-current="page">Mon panier · {{ number_format(array_sum(session('panier', [])), 2, ',', ' ') }} kg</a>
            <a href="{{ route('client.profil') }}">Mon compte</a>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button class="button button-light" type="submit">Déconnexion</button>
            </form>
        </nav>
    </div>
</header>

<main class="shell main">
    <p class="eyebrow">Votre sélection</p>
    <h1>Mon panier</h1>
    <p class="lead">Les quantités et prix sont vérifiés à partir du stock actuel du Domaine.</p>

    @if (session('success'))
        <div class="notice" role="status">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="notice errors" role="alert">{{ $errors->first() }}</div>
    @endif

    @if (count($lignes))
        <div class="cart-layout">
            <section class="line-list" aria-label="Articles du panier">
                @foreach ($lignes as $ligne)
                    @php
                        $cepage = $ligne['cepage'];
                        $imagePath = trim((string) $cepage->Image_cepage);
                        $imageUrl = $imagePath
                            ? (\Illuminate\Support\Str::startsWith($imagePath, ['http://', 'https://']) ? $imagePath : asset('storage/' . ltrim($imagePath, '/')))
                            : 'https://images.unsplash.com/photo-1516594915697-87eb3b1c14ea?auto=format&fit=crop&w=500&q=80';
                    @endphp
                    <article class="line">
                        <img src="{{ $imageUrl }}" alt="{{ $cepage->Nom_cepage }}" loading="lazy">
                        <div>
                            <span class="meta">{{ $cepage->Couleur_cepage }} · {{ $cepage->Region_cepage }}</span>
                            <h2>{{ $cepage->Nom_cepage }}</h2>
                            <span class="unit">{{ number_format($cepage->Prix_kg_cepage, 0, ',', ' ') }} FCFA / kg · Stock : {{ number_format($cepage->Qte_cepage_disponible, 2, ',', ' ') }} kg</span>
                            <form class="quantity-form" action="{{ route('panier.modifier', $cepage->Nom_cepage) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <label class="visually-hidden" for="quantite-{{ $loop->index }}">Quantité en kilogrammes pour {{ $cepage->Nom_cepage }}</label>
                                <input class="quantity" id="quantite-{{ $loop->index }}" type="number" name="quantite" min="0.01" max="{{ $cepage->Qte_cepage_disponible }}" step="0.01" value="{{ number_format($ligne['quantite'], 2, '.', '') }}" required>
                                <button class="button button-light" type="submit">Mettre à jour</button>
                            </form>
                            <form action="{{ route('panier.retirer', $cepage->Nom_cepage) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="remove" type="submit">Retirer du panier</button>
                            </form>
                        </div>
                        <div class="line-total">
                            <strong>{{ number_format($ligne['sousTotal'], 0, ',', ' ') }} FCFA</strong>
                            <small>Sous-total</small>
                        </div>
                    </article>
                @endforeach
            </section>

            <aside class="summary" aria-label="Résumé du panier">
                <h2>Résumé</h2>
                <div class="summary-row"><span>Quantité totale</span><strong>{{ number_format($quantiteTotale, 2, ',', ' ') }} kg</strong></div>
                <div class="summary-row"><span>Références</span><strong>{{ count($lignes) }}</strong></div>
                <div class="summary-row summary-total"><span>Total estimé</span><strong>{{ number_format($total, 0, ',', ' ') }} FCFA</strong></div>
                <p class="summary-note">Cette action transmet une demande au Domaine. Le stock n’est pas réservé ; l’administrateur confirmera ensuite la commande.</p>
                <form action="{{ route('panier.confirmer') }}" method="POST" class="mt-3">
                    @csrf
                    <button class="button button-dark" style="width: 100%;" type="submit">Transmettre ma demande</button>
                </form>
                <a class="button button-dark" style="width: 100%; margin-top: 14px;" href="{{ route('home') }}#cepages">Continuer mes achats</a>
            </aside>
        </div>
    @else
        <section class="empty">
            <h2>Votre panier est vide.</h2>
            <p>Parcourez les cépages du Domaine et ajoutez ceux qui vous intéressent.</p>
            <a class="button button-dark" href="{{ route('home') }}#cepages">Voir les cépages</a>
        </section>
    @endif
</main>
</body>
</html>
