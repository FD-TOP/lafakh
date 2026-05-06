<?php 
require 'db.php'; 
try {
    $query = $pdo->query("SELECT * FROM products ORDER BY id DESC");
    $products = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $products = [];
}
$demo_products = [
    [
        'id'=>1,'name'=>'CINEMATIC PACK V1','price'=>28,'category'=>'Preset',
        'image_path'=>'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?q=80&w=800',
        'buy_link'=>'#',
        'description'=>'10 presets cinématographiques pour sublimer vos photos de voyage et lifestyle. Teintes chaudes et froides équilibrées, grain filmique subtil, rendu argentique.',
        'includes'=>'10 Presets Lightroom · Fichiers XMP & DNG · Tutoriel PDF · Guide d\'installation',
        'compat'=>'Lightroom CC / Classic · Lightroom Mobile',
        'badge'=>'new',
    ],
    [
        'id'=>2,'name'=>'GOLDEN HOUR LUT','price'=>18,'category'=>'LUT',
        'image_path'=>'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?q=80&w=800',
        'buy_link'=>'#',
        'description'=>'Pack de 6 LUTs heure dorée pour Premiere Pro, DaVinci Resolve et Final Cut. Rendu cinéma hollywoodien instantané, lumières chaudes, orangés profonds.',
        'includes'=>'6 LUTs .cube · Compatible 4K · Tutoriel vidéo',
        'compat'=>'Premiere Pro · DaVinci Resolve · Final Cut Pro',
        'badge'=>'hot',
    ],
    [
        'id'=>3,'name'=>'URBAN DARK PACK','price'=>22,'category'=>'Preset',
        'image_path'=>'https://images.unsplash.com/photo-1444723121867-7a241cacace9?q=80&w=800',
        'buy_link'=>'#',
        'description'=>'12 presets sombres et contrastés pour photographie urbaine, portraits et mode. Noir profond, ombres bleutées, grain vintage accentué.',
        'includes'=>'12 Presets Lightroom · XMP & DNG · Tutoriel PDF',
        'compat'=>'Lightroom CC / Classic · Mobile',
        'badge'=>'',
    ],
    [
        'id'=>4,'name'=>'FILM EMULATION VOL.2','price'=>32,'category'=>'LUT',
        'image_path'=>'https://images.unsplash.com/photo-1501854140801-50d01698950b?q=80&w=800',
        'buy_link'=>'#',
        'description'=>'8 LUTs émulant les pellicules argentiques légendaires (Kodak, Fuji, Agfa). Le rendu film le plus réaliste du marché, parfait pour les cinéastes exigeants.',
        'includes'=>'8 LUTs .cube · 4K/8K · Profils ICC · Tutoriel avancé',
        'compat'=>'Premiere · DaVinci · Resolve · After Effects',
        'badge'=>'',
    ],
    [
        'id'=>5,'name'=>'TRAVEL VIBES','price'=>20,'category'=>'Preset',
        'image_path'=>'https://images.unsplash.com/photo-1682687982501-1e58ab814714?q=80&w=800',
        'buy_link'=>'#',
        'description'=>'15 presets colorés et vibrants pour photos de voyage, plage et aventure. Couleurs saturées, ciel dramatique, eau turquoise — partez en voyage sans quitter Lightroom.',
        'includes'=>'15 Presets Lightroom · XMP & DNG · Livret de style',
        'compat'=>'Lightroom CC / Classic · Mobile',
        'badge'=>'',
    ],
    [
        'id'=>6,'name'=>'MOODY BLUES','price'=>24,'category'=>'Preset',
        'image_path'=>'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=800',
        'buy_link'=>'#',
        'description'=>'8 presets portraits aux tons froids et mélancoliques. Bleus désaturés, peaux naturelles, ambiance éditoriale mode. Parfait pour le portrait lifestyle et la photographie de rue.',
        'includes'=>'8 Presets Lightroom · XMP & DNG · Guide portrait',
        'compat'=>'Lightroom CC / Classic · Mobile',
        'badge'=>'new',
    ],
    [
        'id'=>7,'name'=>'SUNSET GRADIENT LUT','price'=>19,'category'=>'LUT',
        'image_path'=>'https://images.unsplash.com/photo-1495616811223-4d98c6e9c869?q=80&w=800',
        'buy_link'=>'#',
        'description'=>'5 LUTs inspirées des couchers de soleil de Californie — orangés chauds, violets profonds, rose pastel. Idéales pour les vlogs, clips musicaux et contenus lifestyle.',
        'includes'=>'5 LUTs .cube · 4K · Tutoriel Premiere',
        'compat'=>'Premiere Pro · DaVinci Resolve · Final Cut',
        'badge'=>'',
    ],
    [
        'id'=>8,'name'=>'MONOCHROME MASTER','price'=>22,'category'=>'Preset',
        'image_path'=>'https://images.unsplash.com/photo-1500281781950-6cd80847ebcd?q=80&w=800',
        'buy_link'=>'#',
        'description'=>'10 presets noir & blanc pour photographie d\'art, paysage et portrait. Contrastes dramatiques, ciels nuageux texturés, grain pellicule authentique.',
        'includes'=>'10 Presets Lightroom · XMP & DNG · Guide B&W',
        'compat'=>'Lightroom CC / Classic · Mobile',
        'badge'=>'',
    ],
    [
        'id'=>9,'name'=>'DESERT TONES','price'=>20,'category'=>'Preset',
        'image_path'=>'https://images.unsplash.com/photo-1509316785289-025f5b846b35?q=80&w=800',
        'buy_link'=>'#',
        'description'=>'8 presets aux tons ocres et terracotta inspirés des déserts du monde. Sables chauds, ombres longues, lumière rasante du soir. Un look minimaliste et puissant.',
        'includes'=>'8 Presets Lightroom · XMP & DNG',
        'compat'=>'Lightroom CC / Classic · Mobile',
        'badge'=>'',
    ],
    [
        'id'=>10,'name'=>'NEON NIGHTS','price'=>26,'category'=>'LUT',
        'image_path'=>'https://images.unsplash.com/photo-1514565131-fce0801e6175?q=80&w=800',
        'buy_link'=>'#',
        'description'=>'7 LUTs urbains nocturnes aux reflets néon, bleus électriques et magentas intenses. Parfait pour clips hip-hop, films d\'action et contenus streetwear.',
        'includes'=>'7 LUTs .cube · 4K · Tutoriel DaVinci',
        'compat'=>'Premiere · DaVinci · After Effects',
        'badge'=>'hot',
    ],
    [
        'id'=>11,'name'=>'NOIR CINÉMA BUNDLE','price'=>49,'category'=>'Bundle',
        'image_path'=>'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=800',
        'buy_link'=>'#',
        'description'=>'Le pack ultime : 20 presets + 10 LUTs pour créateurs exigeants. Tout ce qu\'il faut pour une identité visuelle cohérente et professionnelle sur toutes vos plateformes.',
        'includes'=>'20 Presets + 10 LUTs · Toutes plateformes · 3 tutoriels vidéo · Guide de style',
        'compat'=>'Lightroom · Premiere · DaVinci · Final Cut',
        'badge'=>'bundle',
    ],
    [
        'id'=>12,'name'=>'CREATOR PRO BUNDLE','price'=>69,'category'=>'Bundle',
        'image_path'=>'https://images.unsplash.com/photo-1611532736597-de2d4265fba3?q=80&w=800',
        'buy_link'=>'#',
        'description'=>'La collection complète pour les créateurs professionnels : tous les presets + tous les LUTs + accès aux mises à jour futures. Un seul achat, toute la bibliothèque.',
        'includes'=>'Toute la bibliothèque · Mises à jour à vie · 5 tutoriels vidéo · Support prioritaire · Guide complet',
        'compat'=>'Tous logiciels compatibles',
        'badge'=>'bundle',
    ],
];
$display_products = !empty($products) ? $products : $demo_products;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOP | LA FAKH</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&family=Space+Grotesk:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        html, body { height: 100%; margin: 0; }
        body { font-family: 'Space Grotesk', sans-serif; background-color: #000; color: #fff; display: flex; flex-direction: column; overflow-x: hidden; }
        main { flex: 1 0 auto; }
        .brutal-text { font-family: 'Inter', sans-serif; text-transform: uppercase; font-style: italic; }

        /* ========== TICKER ========== */
        .ticker-wrap { background: #fff; color: #000; overflow: hidden; padding: 10px 0; }
        .ticker { display: flex; white-space: nowrap; animation: ticker 32s linear infinite; }
        .ticker-item {
            display: inline-flex; align-items: center; gap: 20px;
            font-size: 9px; font-weight: 900; font-family: 'Inter', sans-serif;
            text-transform: uppercase; letter-spacing: 0.25em; padding-right: 60px;
        }
        .ticker-item::after { content: '✦'; opacity: 0.3; }
        @keyframes ticker { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

        /* ========== BURGER ========== */
        .burger-line { width: 25px; height: 2px; background-color: #fff; transition: 0.3s; }
        #burger-btn.open .line1 { transform: rotate(45deg) translate(5px, 6px); }
        #burger-btn.open .line2 { opacity: 0; }
        #burger-btn.open .line3 { transform: rotate(-45deg) translate(5px, -6px); }
        #mobile-menu {
            position: fixed; top: 0; right: -100%; width: 100%; height: 100vh;
            background: #000; z-index: 115; display: flex; flex-direction: column;
            align-items: center; justify-content: center; gap: 30px;
            transition: 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }
        #mobile-menu.open { right: 0; }
        #mobile-menu a { font-size: 32px; font-weight: 900; text-transform: uppercase; font-style: italic; font-family: 'Inter'; }

        /* ========== HERO ========== */
        .hero-char {
            display: inline-block; opacity: 0; transform: translateY(60px) rotate(3deg);
            animation: charIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        @keyframes charIn { to { opacity: 1; transform: translateY(0) rotate(0); } }

        /* ========== FILTRES ========== */
        .filter-btn {
            font-size: 9px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.25em;
            padding: 9px 22px; border: 1px solid rgba(255,255,255,0.12);
            color: rgba(255,255,255,0.35); cursor: pointer; transition: all 0.3s ease;
            background: transparent; position: relative; overflow: hidden;
        }
        .filter-btn::before {
            content: ''; position: absolute; inset: 0;
            background: #fff; transform: scaleX(0); transform-origin: left;
            transition: transform 0.3s ease;
        }
        .filter-btn:hover::before, .filter-btn.active::before { transform: scaleX(1); }
        .filter-btn span { position: relative; z-index: 1; }
        .filter-btn:hover span, .filter-btn.active span { color: #000; }
        .filter-btn.active { border-color: #fff; }

        /* ========== GRILLE ========== */
        .shop-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.04);
        }
        @media (min-width: 768px)  { .shop-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (min-width: 1024px) { .shop-grid { grid-template-columns: repeat(3, 1fr); } }
        @media (min-width: 1280px) { .shop-grid { grid-template-columns: repeat(4, 1fr); } }

        /* ========== CARTE PRODUIT ========== */
        .product-card {
            position: relative; background: #000; overflow: hidden; cursor: pointer;
            opacity: 0; transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .product-card.visible { opacity: 1; transform: translateY(0); }
        .product-image-wrap { width: 100%; aspect-ratio: 4/5; overflow: hidden; position: relative; }
        .product-image-wrap img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform 1s cubic-bezier(0.16, 1, 0.3, 1), filter 0.6s ease;
            filter: grayscale(10%) brightness(0.88);
        }
        .product-card:hover .product-image-wrap img { transform: scale(1.09); filter: grayscale(0%) brightness(1); }

        /* Badges */
        .badge {
            position: absolute; top: 14px; z-index: 20;
            font-size: 7px; font-weight: 900; font-family: 'Inter', sans-serif;
            text-transform: uppercase; letter-spacing: 0.2em; padding: 5px 12px;
        }
        .badge-new    { left: 14px; background: #fff; color: #000; }
        .badge-bundle { left: 14px; background: #ffd700; color: #000; }
        .badge-hot    { right: 14px; background: #000; color: #fff; border: 1px solid rgba(255,255,255,0.3); }

        /* Hover overlay */
        .product-hover-overlay {
            position: absolute; inset: 0; z-index: 15;
            background: linear-gradient(to top, rgba(0,0,0,0.92) 0%, rgba(0,0,0,0.3) 50%, transparent 100%);
            display: flex; flex-direction: column; justify-content: flex-end;
            padding: 20px; opacity: 0; transition: opacity 0.4s ease;
        }
        .product-card:hover .product-hover-overlay { opacity: 1; }
        .hover-cta {
            display: inline-flex; align-items: center; gap: 8px;
            background: #fff; color: #000; padding: 10px 20px;
            font-size: 9px; font-weight: 900; font-family: 'Inter', sans-serif;
            text-transform: uppercase; letter-spacing: 0.2em;
            transform: translateY(10px); transition: transform 0.3s ease 0.1s, background 0.2s;
            border: none; cursor: pointer; width: fit-content;
        }
        .hover-cta:hover { background: #e5e5e5; }
        .product-card:hover .hover-cta { transform: translateY(0); }

        /* Info produit */
        .product-info {
            padding: 14px 16px 18px;
            border-top: 1px solid rgba(255,255,255,0.05);
        }
        .product-category-tag {
            font-size: 7px; font-weight: 900; font-family: 'Inter', sans-serif;
            text-transform: uppercase; letter-spacing: 0.3em; color: rgba(255,255,255,0.22);
            margin-bottom: 5px;
        }
        .product-title {
            font-size: 12px; font-weight: 900; font-family: 'Inter', sans-serif;
            text-transform: uppercase; letter-spacing: 1px; margin-bottom: 3px;
        }
        .product-sub { font-size: 8px; color: rgba(255,255,255,0.25); text-transform: uppercase; letter-spacing: 0.1em; }
        .product-price { font-size: 15px; font-weight: 900; font-family: 'Inter', sans-serif; }

        /* ========== MODAL ========== */
        #product-modal {
            display: none; position: fixed; inset: 0; z-index: 9999;
            background: rgba(0,0,0,0.96); backdrop-filter: blur(12px);
            align-items: center; justify-content: center; padding: 20px;
        }
        #product-modal.active { display: flex; }
        .modal-inner {
            background: #0a0a0a; border: 1px solid rgba(255,255,255,0.08);
            max-width: 920px; width: 100%;
            display: grid; grid-template-columns: 1fr 1fr;
            max-height: 90vh; overflow: hidden;
        }
        @media (max-width: 768px) { .modal-inner { grid-template-columns: 1fr; max-height: 88vh; overflow-y: auto; } }
        .modal-image-side { position: relative; aspect-ratio: 1/1; overflow: hidden; }
        .modal-image-side img { width: 100%; height: 100%; object-fit: cover; transition: transform 6s ease; }
        .modal-image-side:hover img { transform: scale(1.04); }
        .modal-content-side { padding: 38px; display: flex; flex-direction: column; overflow-y: auto; }
        .modal-close {
            position: absolute; top: 16px; right: 16px;
            width: 36px; height: 36px; background: rgba(0,0,0,0.7);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; z-index: 10; border: 1px solid rgba(255,255,255,0.1);
            transition: background 0.3s;
        }
        .modal-close:hover { background: rgba(255,255,255,0.12); }
        .modal-buy-btn {
            background: #fff; color: #000; padding: 16px;
            font-size: 10px; font-weight: 900; font-family: 'Inter', sans-serif;
            text-transform: uppercase; letter-spacing: 0.3em;
            text-align: center; display: block; text-decoration: none;
            transition: background 0.3s, transform 0.2s;
        }
        .modal-buy-btn:hover { background: #e8e8e8; transform: scale(1.01); }
        .include-item {
            display: flex; align-items: center; gap: 10px;
            font-size: 10px; color: rgba(255,255,255,0.5);
            padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,0.04);
        }
        .include-item:last-child { border-bottom: none; }

        /* ========== FEATURED BANNER ========== */
        .featured-banner {
            position: relative; overflow: hidden;
            aspect-ratio: 21/7;
            cursor: pointer;
        }
        .featured-banner img {
            width: 100%; height: 100%; object-fit: cover;
            filter: brightness(0.55);
            transition: transform 1.2s cubic-bezier(0.16,1,0.3,1), filter 0.6s;
        }
        .featured-banner:hover img { transform: scale(1.04); filter: brightness(0.7); }
        .featured-content {
            position: absolute; inset: 0; z-index: 10;
            display: flex; flex-direction: column;
            align-items: flex-start; justify-content: center;
            padding: 48px 60px;
        }

        /* ========== STATS BAND ========== */
        .stats-band {
            display: flex; flex-wrap: wrap; justify-content: center;
            gap: 0; border-top: 1px solid rgba(255,255,255,0.05);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .stat-item {
            flex: 1; min-width: 140px; text-align: center;
            padding: 28px 20px;
            border-right: 1px solid rgba(255,255,255,0.05);
        }
        .stat-item:last-child { border-right: none; }

        /* ========== STEPS ========== */
        .step-number {
            font-family: 'Inter', sans-serif; font-weight: 900; font-style: italic;
            font-size: 56px; line-height: 1;
            color: rgba(255,255,255,0.06);
        }

        /* ========== AVANT/APRÈS ========== */
        .before-after-container {
            position: relative; overflow: hidden;
            aspect-ratio: 16/9; cursor: col-resize; user-select: none;
        }
        .ba-before, .ba-after { position: absolute; inset: 0; }
        .ba-before img, .ba-after img { width: 100%; height: 100%; object-fit: cover; }
        .ba-after { clip-path: inset(0 0 0 50%); }
        .ba-divider { position: absolute; top: 0; bottom: 0; width: 2px; background: #fff; left: 50%; transform: translateX(-50%); z-index: 10; pointer-events: none; }
        .ba-handle {
            position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
            width: 40px; height: 40px; background: #fff; border-radius: 50%; z-index: 11;
            display: flex; align-items: center; justify-content: center; pointer-events: none;
        }
        .ba-label {
            position: absolute; top: 14px;
            font-size: 8px; font-weight: 900; font-family: 'Inter', sans-serif;
            text-transform: uppercase; letter-spacing: 0.25em; padding: 5px 12px; z-index: 12;
        }
        .ba-label-before { left: 14px; background: rgba(0,0,0,0.7); }
        .ba-label-after  { right: 14px; background: #fff; color: #000; }

        /* ========== REVIEWS ========== */
        .review-card {
            border: 1px solid rgba(255,255,255,0.06); padding: 28px;
            transition: border-color 0.4s;
        }
        .review-card:hover { border-color: rgba(255,255,255,0.2); }
        .stars { color: #ffd700; font-size: 10px; letter-spacing: 2px; }

        /* ========== FAQ ========== */
        .faq-item { border-bottom: 1px solid rgba(255,255,255,0.06); }
        .faq-question {
            width: 100%; text-align: left; padding: 20px 0;
            display: flex; justify-content: space-between; align-items: center;
            font-size: 12px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.1em; cursor: pointer; background: none; border: none; color: #fff;
            transition: opacity 0.3s;
        }
        .faq-question:hover { opacity: 0.7; }
        .faq-icon { font-size: 14px; transition: transform 0.3s ease; flex-shrink: 0; }
        .faq-item.open .faq-icon { transform: rotate(45deg); }
        .faq-answer {
            max-height: 0; overflow: hidden;
            transition: max-height 0.4s cubic-bezier(0.16, 1, 0.3, 1), padding 0.3s;
            font-size: 13px; color: rgba(255,255,255,0.45); line-height: 1.8;
        }
        .faq-item.open .faq-answer { max-height: 220px; padding-bottom: 20px; }

        /* ========== SCROLL REVEAL ========== */
        .reveal { opacity: 0; transform: translateY(30px); transition: opacity 0.7s ease, transform 0.7s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        /* ========== FOOTER ========== */
        footer { flex-shrink: 0; background-color: #000; border-top: 1px solid rgba(255,255,255,0.05); }
        .footer-link { font-size: 10px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.2em; color: #666; transition: 0.3s; }
        .footer-link:hover { color: #fff; padding-left: 5px; }
    </style>
</head>
<body>

    <!-- TICKER -->
    <div class="ticker-wrap">
        <div class="ticker">
            <?php for($i=0;$i<4;$i++): ?>
            <span class="ticker-item">Livraison instantanée</span>
            <span class="ticker-item">Formats Lightroom & Premiere</span>
            <span class="ticker-item">Compatible Mobile</span>
            <span class="ticker-item">DaVinci Resolve Ready</span>
            <span class="ticker-item">Tutoriels inclus</span>
            <span class="ticker-item">Support 7j/7</span>
            <span class="ticker-item">Licence commerciale incluse</span>
            <span class="ticker-item">Mises à jour gratuites</span>
            <?php endfor; ?>
        </div>
    </div>

    <header class="flex justify-between items-center px-6 md:px-10 h-24 sticky top-0 bg-black/90 backdrop-blur-md z-[110] border-b border-white/5">
        <a href="index.php">
            <img src="logo.png" alt="Logo" class="h-8 md:h-10 w-auto">
        </a>
        <nav class="hidden md:flex gap-10 text-[10px] font-bold uppercase tracking-[0.2em]">
            <a href="index.php"     class="opacity-50 hover:opacity-100 transition">Accueil</a>
            <a href="portfolio.php" class="opacity-50 hover:opacity-100 transition">Portfolio</a>
            <a href="shop.php"      class="border-b border-white pb-1">Shop</a>
            <a href="contact.php"   class="opacity-50 hover:opacity-100 transition">Contact</a>
            <a href="a-propos.php"  class="opacity-50 hover:opacity-100 transition">À Propos</a>
        </nav>
        <button id="burger-btn" class="md:hidden flex flex-col gap-1.5 p-4 z-[120]">
            <div class="burger-line line1"></div>
            <div class="burger-line line2"></div>
            <div class="burger-line line3"></div>
        </button>
    </header>

    <div id="mobile-menu">
        <a href="index.php">Accueil</a>
        <a href="portfolio.php">Portfolio</a>
        <a href="shop.php">Shop</a>
        <a href="contact.php">Contact</a>
        <a href="a-propos.php">À Propos</a>
    </div>

    <main>

        <!-- ===== HERO ===== -->
        <section class="text-center py-20 px-6 relative overflow-hidden">
            <div style="position:absolute;inset:0;background:radial-gradient(ellipse 80% 50% at 50% 0%, rgba(255,255,255,0.04) 0%, transparent 70%);pointer-events:none;"></div>
            <div class="relative z-10">
                <div class="text-[9px] font-black uppercase tracking-[0.5em] text-zinc-600 mb-5 reveal">
                    Ressources créatives professionnelles
                </div>
                <h1 class="text-[70px] md:text-[140px] font-black brutal-text leading-none mb-6" id="hero-title">
                    STORE.
                </h1>
                <p class="text-zinc-500 text-sm max-w-md mx-auto mb-10 reveal">
                    Presets Lightroom, LUTs cinématographiques et packs créatifs pour élever votre vision au niveau supérieur.
                </p>
            </div>
        </section>

        <!-- ===== STATS ===== -->
        <div class="stats-band reveal">
            <div class="stat-item">
                <div class="text-2xl font-black brutal-text"><?= count($display_products) ?></div>
                <div class="text-[8px] uppercase tracking-widest text-zinc-600 mt-1">Produits</div>
            </div>
            <div class="stat-item">
                <div class="text-2xl font-black brutal-text">4K</div>
                <div class="text-[8px] uppercase tracking-widest text-zinc-600 mt-1">Résolution</div>
            </div>
            <div class="stat-item">
                <div class="text-2xl font-black brutal-text">∞</div>
                <div class="text-[8px] uppercase tracking-widest text-zinc-600 mt-1">Licences</div>
            </div>
            <div class="stat-item">
                <div class="text-2xl font-black brutal-text">500+</div>
                <div class="text-[8px] uppercase tracking-widest text-zinc-600 mt-1">Créateurs</div>
            </div>
            <div class="stat-item">
                <div class="text-2xl font-black brutal-text">⚡</div>
                <div class="text-[8px] uppercase tracking-widest text-zinc-600 mt-1">Instantané</div>
            </div>
        </div>

        <!-- ===== FEATURED BANNER (Bundle promo) ===== -->
        <section class="max-w-7xl mx-auto px-6 pt-16 pb-4 reveal">
            <div class="featured-banner" onclick="openModal(10)">
                <img src="https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=1400" alt="Noir Cinéma Bundle">
                <div class="featured-content">
                    <div class="text-[8px] font-black uppercase tracking-[0.4em] text-white/40 mb-3">Pack Exclusif</div>
                    <h2 class="text-4xl md:text-6xl font-black brutal-text mb-3">NOIR CINÉMA<br>BUNDLE</h2>
                    <p class="text-zinc-400 text-sm mb-6 max-w-xs">20 Presets + 10 LUTs — Tout ce qu'il faut pour une identité visuelle cohérente.</p>
                    <div class="flex items-center gap-4">
                        <span class="text-3xl font-black" style="font-family:'Inter'">49€</span>
                        <button class="border border-white px-8 py-3 text-[9px] font-black uppercase tracking-[0.3em] hover:bg-white hover:text-black transition">
                            Voir le bundle →
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== FILTRES + GRILLE ===== -->
        <section class="max-w-7xl mx-auto px-6 pb-24 pt-8">

            <div class="flex flex-wrap justify-center gap-3 mb-10 reveal" id="filter-bar">
                <button class="filter-btn active" data-filter="all"><span>Tout (<?= count($display_products) ?>)</span></button>
                <button class="filter-btn" data-filter="Preset"><span>Presets Lightroom</span></button>
                <button class="filter-btn" data-filter="LUT"><span>LUTs Vidéo</span></button>
                <button class="filter-btn" data-filter="Bundle"><span>Bundles</span></button>
            </div>

            <div class="shop-grid" id="shop-grid">
                <?php foreach ($display_products as $idx => $p):
                    $cat     = $p['category']    ?? '';
                    $desc    = $p['description'] ?? 'Pack de ressources créatives professionnelles.';
                    $incl    = $p['includes']    ?? 'Fichiers numériques · Tutoriel inclus';
                    $compat  = $p['compat']      ?? 'Lightroom · Premiere · DaVinci';
                    $badge   = $p['badge']       ?? '';
                ?>
                <div class="product-card"
                     data-category="<?= htmlspecialchars($cat) ?>"
                     data-product="<?= $idx ?>"
                     onclick="openModal(<?= $idx ?>)">

                    <div class="product-image-wrap">
                        <?php if($badge === 'bundle'): ?>
                        <div class="badge badge-bundle">Bundle</div>
                        <?php elseif($badge === 'new'): ?>
                        <div class="badge badge-new">Nouveau</div>
                        <?php endif; ?>
                        <?php if($badge === 'hot'): ?>
                        <div class="badge badge-hot">★ Top</div>
                        <?php endif; ?>

                        <img src="<?= htmlspecialchars($p['image_path']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" loading="lazy">

                        <div class="product-hover-overlay">
                            <button class="hover-cta">
                                <i class="fas fa-eye text-[10px]"></i>
                                Voir le produit
                            </button>
                        </div>
                    </div>

                    <div class="product-info">
                        <div class="product-category-tag"><?= htmlspecialchars($cat) ?></div>
                        <div class="flex justify-between items-start gap-2">
                            <div>
                                <div class="product-title"><?= htmlspecialchars($p['name']) ?></div>
                                <div class="product-sub"><?= htmlspecialchars($compat) ?></div>
                            </div>
                            <div class="product-price flex-shrink-0"><?= number_format($p['price'], 0) ?>€</div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- ===== AVANT / APRÈS ===== -->
        <section class="max-w-5xl mx-auto px-6 mb-32 reveal">
            <div class="text-center mb-10">
                <h2 class="text-3xl md:text-5xl font-black brutal-text mb-3">AVANT / APRÈS</h2>
                <p class="text-zinc-600 text-[10px] uppercase tracking-widest">Faites glisser pour comparer le rendu</p>
            </div>
            <div class="before-after-container" id="ba-container">
                <div class="ba-before">
                    <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?q=80&w=1200" alt="Avant">
                    <div class="ba-label ba-label-before">Avant</div>
                </div>
                <div class="ba-after" id="ba-after">
                    <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?q=80&w=1200" alt="Après"
                         style="filter: saturate(1.7) contrast(1.15) brightness(0.92) sepia(0.18) hue-rotate(-5deg);">
                    <div class="ba-label ba-label-after">Après</div>
                </div>
                <div class="ba-divider" id="ba-divider"></div>
                <div class="ba-handle" id="ba-handle">
                    <i class="fas fa-arrows-alt-h text-black text-xs"></i>
                </div>
            </div>
        </section>

        <!-- ===== COMMENT ÇA MARCHE ===== -->
        <section class="max-w-5xl mx-auto px-6 mb-32 reveal">
            <h2 class="text-3xl md:text-5xl font-black brutal-text text-center mb-16">COMMENT ÇA MARCHE</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-0">
                <div class="p-10 border border-white/5 relative">
                    <div class="step-number">01</div>
                    <h3 class="text-sm font-black uppercase tracking-widest mt-4 mb-3">Choisissez</h3>
                    <p class="text-zinc-500 text-sm leading-relaxed">Parcourez notre catalogue et sélectionnez le pack qui correspond à votre style créatif.</p>
                    <div style="position:absolute;top:20px;right:20px;font-size:24px;opacity:0.06;"><i class="fas fa-shopping-bag"></i></div>
                </div>
                <div class="p-10 border border-white/5 relative" style="border-left:none;">
                    <div class="step-number">02</div>
                    <h3 class="text-sm font-black uppercase tracking-widest mt-4 mb-3">Achetez</h3>
                    <p class="text-zinc-500 text-sm leading-relaxed">Paiement sécurisé. Vous recevez un lien de téléchargement instantanément par email.</p>
                    <div style="position:absolute;top:20px;right:20px;font-size:24px;opacity:0.06;"><i class="fas fa-lock"></i></div>
                </div>
                <div class="p-10 border border-white/5 relative" style="border-left:none;">
                    <div class="step-number">03</div>
                    <h3 class="text-sm font-black uppercase tracking-widest mt-4 mb-3">Appliquez</h3>
                    <p class="text-zinc-500 text-sm leading-relaxed">Importez en un clic dans Lightroom, Premiere ou DaVinci. Tutoriel vidéo inclus.</p>
                    <div style="position:absolute;top:20px;right:20px;font-size:24px;opacity:0.06;"><i class="fas fa-magic"></i></div>
                </div>
            </div>
        </section>

        <!-- ===== TÉMOIGNAGES ===== -->
        <section class="max-w-6xl mx-auto px-6 mb-32 reveal">
            <h2 class="text-3xl md:text-5xl font-black brutal-text text-center mb-4">ILS NOUS FONT CONFIANCE</h2>
            <p class="text-zinc-600 text-[10px] uppercase tracking-widest text-center mb-14">+500 créateurs satisfaits</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="review-card">
                    <div class="stars mb-4">★★★★★</div>
                    <p class="text-zinc-400 text-sm leading-relaxed mb-6">"Le pack Cinematic V1 a transformé ma façon de traiter mes photos. Les couleurs sont incroyables, rendu ultra professionnel."</p>
                    <div class="flex items-center gap-3">
                        <div style="width:32px;height:32px;background:#1a1a1a;border:1px solid rgba(255,255,255,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:900;font-family:'Inter'">TM</div>
                        <div>
                            <div class="text-[10px] font-black uppercase tracking-widest">Thomas M.</div>
                            <div class="text-[9px] text-zinc-600 uppercase">Photographe</div>
                        </div>
                    </div>
                </div>
                <div class="review-card">
                    <div class="stars mb-4">★★★★★</div>
                    <p class="text-zinc-400 text-sm leading-relaxed mb-6">"Les LUTs Golden Hour sont mes préférées ! Je les utilise sur toutes mes vidéos YouTube. Le rendu chaud et cinématographique est parfait."</p>
                    <div class="flex items-center gap-3">
                        <div style="width:32px;height:32px;background:#1a1a1a;border:1px solid rgba(255,255,255,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:900;font-family:'Inter'">SL</div>
                        <div>
                            <div class="text-[10px] font-black uppercase tracking-widest">Sarah L.</div>
                            <div class="text-[9px] text-zinc-600 uppercase">Content Creator</div>
                        </div>
                    </div>
                </div>
                <div class="review-card">
                    <div class="stars mb-4">★★★★★</div>
                    <p class="text-zinc-400 text-sm leading-relaxed mb-6">"Le Creator Pro Bundle vaut chaque centime. Une bibliothèque complète, des tutos clairs et un support réactif. Je recommande à 100%."</p>
                    <div class="flex items-center gap-3">
                        <div style="width:32px;height:32px;background:#1a1a1a;border:1px solid rgba(255,255,255,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:900;font-family:'Inter'">KA</div>
                        <div>
                            <div class="text-[10px] font-black uppercase tracking-widest">Karim A.</div>
                            <div class="text-[9px] text-zinc-600 uppercase">Vidéaste</div>
                        </div>
                    </div>
                </div>
                <div class="review-card">
                    <div class="stars mb-4">★★★★★</div>
                    <p class="text-zinc-400 text-sm leading-relaxed mb-6">"Moody Blues est exactement ce que je cherchais pour mes portraits. Atmosphère froide et éditoriale, mes clients adorent."</p>
                    <div class="flex items-center gap-3">
                        <div style="width:32px;height:32px;background:#1a1a1a;border:1px solid rgba(255,255,255,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:900;font-family:'Inter'">ML</div>
                        <div>
                            <div class="text-[10px] font-black uppercase tracking-widest">Marie L.</div>
                            <div class="text-[9px] text-zinc-600 uppercase">Photographe Mode</div>
                        </div>
                    </div>
                </div>
                <div class="review-card">
                    <div class="stars mb-4">★★★★★</div>
                    <p class="text-zinc-400 text-sm leading-relaxed mb-6">"Neon Nights pour mes clips — rendu incroyable. Les couleurs sont intenses, les noirs sont profonds. Exactement l'ambiance que je voulais."</p>
                    <div class="flex items-center gap-3">
                        <div style="width:32px;height:32px;background:#1a1a1a;border:1px solid rgba(255,255,255,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:900;font-family:'Inter'">RD</div>
                        <div>
                            <div class="text-[10px] font-black uppercase tracking-widest">Rayan D.</div>
                            <div class="text-[9px] text-zinc-600 uppercase">Réalisateur</div>
                        </div>
                    </div>
                </div>
                <div class="review-card">
                    <div class="stars mb-4">★★★★★</div>
                    <p class="text-zinc-400 text-sm leading-relaxed mb-6">"Desert Tones a complètement transformé mes photos de voyage. Le rendu ocre et chaud est addictif, tout le monde me demande comment je fais."</p>
                    <div class="flex items-center gap-3">
                        <div style="width:32px;height:32px;background:#1a1a1a;border:1px solid rgba(255,255,255,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:900;font-family:'Inter'">AS</div>
                        <div>
                            <div class="text-[10px] font-black uppercase tracking-widest">Amira S.</div>
                            <div class="text-[9px] text-zinc-600 uppercase">Travel Blogger</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== FAQ ===== -->
        <section class="max-w-3xl mx-auto px-6 mb-32 reveal">
            <h2 class="text-3xl md:text-5xl font-black brutal-text text-center mb-14">FAQ</h2>
            <div id="faq-list">
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        Comment installer les presets Lightroom ?
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        Dans Lightroom, allez dans le panneau "Développement", clic droit sur "Préréglages utilisateurs" → "Importer les préréglages". Sélectionnez les fichiers .xmp ou le dossier téléchargé. Un tutoriel PDF et vidéo est inclus dans chaque pack.
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        Les LUTs sont-elles compatibles avec mon logiciel ?
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        Nos LUTs au format .cube sont compatibles avec Adobe Premiere Pro, DaVinci Resolve, Final Cut Pro X, After Effects, et tout logiciel supportant les LUTs .cube (format universel).
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        Puis-je utiliser ces presets sur mon téléphone ?
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        Oui ! Les presets Lightroom incluent des fichiers DNG compatibles avec l'application Lightroom Mobile (iOS & Android). Importez simplement le DNG dans votre photothèque et copiez les réglages.
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        Puis-je utiliser ces ressources pour mes clients ?
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        Oui, la licence incluse couvre l'usage commercial personnel. Vous pouvez livrer des photos et vidéos traitées à vos clients. La revente ou redistribution des fichiers eux-mêmes est interdite.
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        Y a-t-il des mises à jour ?
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        Le Creator Pro Bundle inclut les mises à jour à vie : chaque nouveau preset ou LUT que nous publions vous est envoyé automatiquement. Pour les autres packs, les mises à jour mineures (corrections, ajustements) sont gratuites.
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        Quelle est la politique de remboursement ?
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        En raison de la nature des produits numériques, nous n'offrons pas de remboursement après téléchargement. En cas de problème technique, notre support est disponible 7j/7 pour vous aider.
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== CTA FINAL ===== -->
        <section class="border-t border-b border-white/5 py-20 px-6 text-center reveal">
            <div class="text-[9px] font-black uppercase tracking-[0.5em] text-zinc-600 mb-4">Une question ? Un projet ?</div>
            <h2 class="text-3xl md:text-5xl font-black brutal-text mb-8">PARLONS-EN.</h2>
            <a href="contact.php" class="inline-block border border-white px-12 py-5 text-[10px] font-black uppercase tracking-[0.3em] hover:bg-white hover:text-black transition">
                Nous Contacter →
            </a>
        </section>

    </main>

    <!-- ===== MODAL ===== -->
    <div id="product-modal">
        <div class="modal-inner">
            <div class="modal-image-side">
                <img id="modal-img" src="" alt="">
                <div class="modal-close" onclick="closeModal()">
                    <i class="fas fa-times text-xs"></i>
                </div>
            </div>
            <div class="modal-content-side">
                <div id="modal-category" class="text-[8px] font-black uppercase tracking-[0.4em] text-zinc-600 mb-3"></div>
                <h2 id="modal-title" class="text-xl font-black uppercase tracking-widest mb-2" style="font-family:'Inter'"></h2>
                <div id="modal-price" class="text-3xl font-black mb-6" style="font-family:'Inter'"></div>
                <div id="modal-desc" class="text-zinc-400 text-sm leading-relaxed mb-6"></div>
                <div class="mb-6">
                    <div class="text-[9px] font-black uppercase tracking-[0.3em] text-zinc-600 mb-3">Ce qui est inclus</div>
                    <div id="modal-includes" class="space-y-0"></div>
                </div>
                <div class="mb-8">
                    <div class="text-[9px] font-black uppercase tracking-[0.3em] text-zinc-600 mb-2">Compatibilité</div>
                    <div id="modal-compat" class="text-xs text-zinc-400"></div>
                </div>
                <div class="mt-auto">
                    <a id="modal-buy-link" href="#" target="_blank" class="modal-buy-btn">
                        Acheter maintenant — <span id="modal-buy-price"></span>
                    </a>
                    <div class="flex items-center justify-center gap-6 mt-4">
                        <div class="text-[8px] uppercase tracking-widest text-zinc-600 flex items-center gap-2">
                            <i class="fas fa-lock opacity-50"></i> Paiement sécurisé
                        </div>
                        <div class="text-[8px] uppercase tracking-widest text-zinc-600 flex items-center gap-2">
                            <i class="fas fa-bolt opacity-50"></i> Livraison instantanée
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="max-w-7xl mx-auto px-6 py-20">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-20">
                <div class="md:col-span-1">
                    <div class="text-xl font-black brutal-text mb-6">LA FAKH</div>
                    <p class="text-[10px] text-zinc-500 uppercase tracking-widest leading-relaxed">
                        Production audiovisuelle & ressources créatives basées à Reims.
                    </p>
                </div>
                <div>
                    <h4 class="text-[9px] font-black uppercase tracking-[0.4em] text-white/30 mb-8">Produits</h4>
                    <ul class="space-y-4">
                        <li class="footer-link cursor-default">Presets Lightroom</li>
                        <li class="footer-link cursor-default">LUTs Cinématiques</li>
                        <li class="footer-link cursor-default">Bundles Créatifs</li>
                        <li class="footer-link cursor-default">Tutoriels</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-[9px] font-black uppercase tracking-[0.4em] text-white/30 mb-8">Studio</h4>
                    <ul class="space-y-4">
                        <li><a href="portfolio.php"    class="footer-link">Portfolio</a></li>
                        <li><a href="a-propos.php"     class="footer-link">L'Agence</a></li>
                        <li><a href="contact.php"      class="footer-link">Contact</a></li>
                        <li><a href="mentions-legales.php" class="footer-link">Mentions Légales</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-[9px] font-black uppercase tracking-[0.4em] text-white/30 mb-8">Direct</h4>
                    <div class="space-y-4">
                        <div class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">
                            <i class="fas fa-envelope mr-2 opacity-30"></i> contact@lafakh.fr
                        </div>
                        <div class="flex gap-6 mt-4">
                            <a href="#" class="text-zinc-500 hover:text-white transition"><i class="fab fa-instagram text-lg"></i></a>
                            <a href="#" class="text-zinc-500 hover:text-white transition"><i class="fab fa-tiktok text-lg"></i></a>
                            <a href="#" class="text-zinc-500 hover:text-white transition"><i class="fab fa-vimeo-v text-lg"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col md:flex-row justify-between items-center border-t border-white/5 pt-10 gap-6">
                <div class="text-[8px] uppercase tracking-[0.5em] text-zinc-700">© 2026 LA FAKH STORE — SECURE DIGITAL DELIVERY</div>
                <button onclick="window.scrollTo({top:0,behavior:'smooth'})" class="text-[8px] uppercase tracking-[0.3em] text-zinc-500 hover:text-white transition flex items-center">
                    BACK TO TOP <i class="fas fa-arrow-up ml-3"></i>
                </button>
            </div>
        </div>
    </footer>

    <script>
    const productsData = <?= json_encode($display_products) ?>;

    // BURGER
    document.getElementById('burger-btn').addEventListener('click', function() {
        this.classList.toggle('open');
        const m = document.getElementById('mobile-menu');
        m.classList.toggle('open');
        document.body.style.overflow = m.classList.contains('open') ? 'hidden' : 'auto';
    });

    // HERO ANIMATION
    document.addEventListener('DOMContentLoaded', () => {
        const title = document.getElementById('hero-title');
        const text = title.textContent;
        title.innerHTML = '';
        text.split('').forEach((char, i) => {
            const s = document.createElement('span');
            s.className = 'hero-char';
            s.textContent = char === ' ' ? '\u00A0' : char;
            s.style.animationDelay = (i * 60) + 'ms';
            title.appendChild(s);
        });
    });

    // SCROLL REVEAL
    const ro = new IntersectionObserver(entries => {
        entries.forEach(e => { if(e.isIntersecting){ e.target.classList.add('visible'); ro.unobserve(e.target); } });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach(el => ro.observe(el));

    const co = new IntersectionObserver(entries => {
        entries.forEach((e, i) => {
            if(e.isIntersecting){ setTimeout(() => e.target.classList.add('visible'), i * 70); co.unobserve(e.target); }
        });
    }, { threshold: 0.05 });
    document.querySelectorAll('.product-card').forEach(el => co.observe(el));

    // FILTRES
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const filter = this.dataset.filter;
            document.querySelectorAll('.product-card').forEach(card => {
                const show = filter === 'all' || card.dataset.category === filter;
                if(show) {
                    card.style.display = '';
                    setTimeout(() => card.classList.add('visible'), 50);
                } else {
                    card.classList.remove('visible');
                    setTimeout(() => card.style.display = 'none', 400);
                }
            });
        });
    });

    // MODAL
    function openModal(idx) {
        const p = productsData[idx];
        document.getElementById('modal-img').src = p.image_path;
        document.getElementById('modal-category').textContent = p.category || '';
        document.getElementById('modal-title').textContent = p.name;
        document.getElementById('modal-price').textContent = parseFloat(p.price).toFixed(2) + '€';
        document.getElementById('modal-desc').textContent = p.description || '';
        document.getElementById('modal-buy-link').href = p.buy_link || '#';
        document.getElementById('modal-buy-price').textContent = parseFloat(p.price).toFixed(2) + '€';
        document.getElementById('modal-compat').textContent = p.compat || '';
        const items = (p.includes || '').split('·').map(s => s.trim()).filter(Boolean);
        document.getElementById('modal-includes').innerHTML = items.map(item =>
            `<div class="include-item"><i class="fas fa-check text-[8px] opacity-40"></i>${item}</div>`
        ).join('');
        document.getElementById('product-modal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    function closeModal() {
        document.getElementById('product-modal').classList.remove('active');
        document.body.style.overflow = 'auto';
    }
    document.getElementById('product-modal').addEventListener('click', function(e) {
        if(e.target === this) closeModal();
    });
    window.addEventListener('keydown', e => { if(e.key === 'Escape') closeModal(); });

    // AVANT / APRÈS
    const baC = document.getElementById('ba-container');
    const baA = document.getElementById('ba-after');
    const baD = document.getElementById('ba-divider');
    const baH = document.getElementById('ba-handle');
    let drag = false;
    function setBA(x) {
        const r = baC.getBoundingClientRect();
        let p = Math.max(5, Math.min(95, ((x - r.left) / r.width) * 100));
        baA.style.clipPath = `inset(0 ${100-p}% 0 0)`;
        baD.style.left = p + '%';
        baH.style.left = p + '%';
    }
    baC.addEventListener('mousedown',  e => { drag = true; setBA(e.clientX); });
    window.addEventListener('mousemove', e => { if(drag) setBA(e.clientX); });
    window.addEventListener('mouseup',   () => drag = false);
    baC.addEventListener('touchstart', e => { drag = true; setBA(e.touches[0].clientX); }, { passive:true });
    window.addEventListener('touchmove', e => { if(drag) setBA(e.touches[0].clientX); }, { passive:true });
    window.addEventListener('touchend',  () => drag = false);

    // FAQ
    function toggleFaq(btn) {
        const item = btn.closest('.faq-item');
        const open = item.classList.contains('open');
        document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
        if(!open) item.classList.add('open');
    }
    </script>
</body>
</html>
