<?php
require 'db.php';
$projects = [];
try {
    if ($pdo) {
        $rows = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as &$r) {
            // media_items colonne JSON si elle existe, sinon reconstruire depuis media_path + video_embed
            if (!empty($r['media_items'])) {
                $r['media_items'] = json_decode($r['media_items'], true) ?: [];
            } else {
                $items = [];
                if (!empty($r['video_embed'])) $items[] = ['type'=>'video','embed'=>$r['video_embed'],'thumb'=>$r['thumbnail_path']];
                foreach (array_filter(explode(',', $r['media_path'] ?? '')) as $p) {
                    $t = str_ends_with(strtolower($p), '.mp4') ? 'video_file' : 'photo';
                    $items[] = ['type'=>$t,'src'=>trim($p),'thumb'=>trim($p)];
                }
                if (empty($items)) $items[] = ['type'=>'photo','src'=>$r['thumbnail_path'],'thumb'=>$r['thumbnail_path']];
                $r['media_items'] = $items;
            }
        }
        $projects = $rows;
    }
} catch (\Throwable $e) { $projects = []; }

// Comments
$comments = [];
try {
    if ($pdo) {
        $comments = $pdo->query("SELECT * FROM comments WHERE approved=1 ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (\Throwable $e) { $comments = []; }

// Fonction utilitaire
function yt_embed($url) {
    preg_match('/(?:v=|youtu\.be\/|embed\/)([A-Za-z0-9_-]{11})/', $url, $m);
    return isset($m[1]) ? 'https://www.youtube.com/embed/'.$m[1] : $url;
}

// ===== DEMO PROJETS =====
// Chaque projet a plusieurs médias (photos + vidéos mélangés)
$demo_projects = [
    [
        'id'=>1,'title'=>'REEL 2026','category'=>'Showreel',
        'thumbnail_path'=>'https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?q=80&w=900',
        'media_items'=>[
            ['type'=>'video','embed'=>'https://www.youtube.com/embed/dQw4w9WgXcQ','thumb'=>'https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?q=80&w=900'],
            ['type'=>'photo','src'=>'https://images.unsplash.com/photo-1524712245354-2c4e5e7121c0?q=80&w=1200','thumb'=>'https://images.unsplash.com/photo-1524712245354-2c4e5e7121c0?q=80&w=400'],
            ['type'=>'photo','src'=>'https://images.unsplash.com/photo-1611532736597-de2d4265fba3?q=80&w=1200','thumb'=>'https://images.unsplash.com/photo-1611532736597-de2d4265fba3?q=80&w=400'],
            ['type'=>'video','embed'=>'https://www.youtube.com/embed/dQw4w9WgXcQ','thumb'=>'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?q=80&w=400'],
        ]
    ],
    [
        'id'=>2,'title'=>'URBAN CULTURE','category'=>'Vlog',
        'thumbnail_path'=>'https://images.unsplash.com/photo-1444723121867-7a241cacace9?q=80&w=900',
        'media_items'=>[
            ['type'=>'photo','src'=>'https://images.unsplash.com/photo-1444723121867-7a241cacace9?q=80&w=1200','thumb'=>'https://images.unsplash.com/photo-1444723121867-7a241cacace9?q=80&w=400'],
            ['type'=>'video','embed'=>'https://www.youtube.com/embed/dQw4w9WgXcQ','thumb'=>'https://images.unsplash.com/photo-1444723121867-7a241cacace9?q=80&w=400'],
            ['type'=>'photo','src'=>'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?q=80&w=1200','thumb'=>'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?q=80&w=400'],
        ]
    ],
    [
        'id'=>3,'title'=>'GOLDEN HOUR','category'=>'Cinéma',
        'thumbnail_path'=>'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?q=80&w=900',
        'media_items'=>[
            ['type'=>'video','embed'=>'https://www.youtube.com/embed/dQw4w9WgXcQ','thumb'=>'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?q=80&w=400'],
            ['type'=>'photo','src'=>'https://images.unsplash.com/photo-1501854140801-50d01698950b?q=80&w=1200','thumb'=>'https://images.unsplash.com/photo-1501854140801-50d01698950b?q=80&w=400'],
            ['type'=>'photo','src'=>'https://images.unsplash.com/photo-1509316785289-025f5b846b35?q=80&w=1200','thumb'=>'https://images.unsplash.com/photo-1509316785289-025f5b846b35?q=80&w=400'],
        ]
    ],
    [
        'id'=>4,'title'=>'TRAVEL DOCUMENTARY','category'=>'Documentaire',
        'thumbnail_path'=>'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?q=80&w=900',
        'media_items'=>[
            ['type'=>'photo','src'=>'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?q=80&w=1200','thumb'=>'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?q=80&w=400'],
            ['type'=>'video','embed'=>'https://www.youtube.com/embed/dQw4w9WgXcQ','thumb'=>'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?q=80&w=400'],
            ['type'=>'photo','src'=>'https://images.unsplash.com/photo-1500281781950-6cd80847ebcd?q=80&w=1200','thumb'=>'https://images.unsplash.com/photo-1500281781950-6cd80847ebcd?q=80&w=400'],
            ['type'=>'photo','src'=>'https://images.unsplash.com/photo-1682687982501-1e58ab814714?q=80&w=1200','thumb'=>'https://images.unsplash.com/photo-1682687982501-1e58ab814714?q=80&w=400'],
        ]
    ],
    [
        'id'=>5,'title'=>'BRAND CAMPAIGN','category'=>'Publicité',
        'thumbnail_path'=>'https://images.unsplash.com/photo-1611532736597-de2d4265fba3?q=80&w=900',
        'media_items'=>[
            ['type'=>'video','embed'=>'https://www.youtube.com/embed/dQw4w9WgXcQ','thumb'=>'https://images.unsplash.com/photo-1611532736597-de2d4265fba3?q=80&w=400'],
            ['type'=>'photo','src'=>'https://images.unsplash.com/photo-1611532736597-de2d4265fba3?q=80&w=1200','thumb'=>'https://images.unsplash.com/photo-1611532736597-de2d4265fba3?q=80&w=400'],
        ]
    ],
    [
        'id'=>6,'title'=>'NEON PORTRAITS','category'=>'Portrait',
        'thumbnail_path'=>'https://images.unsplash.com/photo-1514565131-fce0801e6175?q=80&w=900',
        'media_items'=>[
            ['type'=>'photo','src'=>'https://images.unsplash.com/photo-1514565131-fce0801e6175?q=80&w=1200','thumb'=>'https://images.unsplash.com/photo-1514565131-fce0801e6175?q=80&w=400'],
            ['type'=>'photo','src'=>'https://images.unsplash.com/photo-1492446845049-9c50cc313f00?q=80&w=1200','thumb'=>'https://images.unsplash.com/photo-1492446845049-9c50cc313f00?q=80&w=400'],
            ['type'=>'video','embed'=>'https://www.youtube.com/embed/dQw4w9WgXcQ','thumb'=>'https://images.unsplash.com/photo-1514565131-fce0801e6175?q=80&w=400'],
            ['type'=>'photo','src'=>'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?q=80&w=1200','thumb'=>'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?q=80&w=400'],
        ]
    ],
    [
        'id'=>7,'title'=>'MUSIC VIDEO','category'=>'Clip',
        'thumbnail_path'=>'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=900',
        'media_items'=>[
            ['type'=>'video','embed'=>'https://www.youtube.com/embed/dQw4w9WgXcQ','thumb'=>'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=400'],
            ['type'=>'photo','src'=>'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=1200','thumb'=>'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=400'],
            ['type'=>'video','embed'=>'https://www.youtube.com/embed/dQw4w9WgXcQ','thumb'=>'https://images.unsplash.com/photo-1611532736597-de2d4265fba3?q=80&w=400'],
        ]
    ],
    [
        'id'=>8,'title'=>'CORPORATE REIMS','category'=>'Institutionnel',
        'thumbnail_path'=>'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?q=80&w=900',
        'media_items'=>[
            ['type'=>'photo','src'=>'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?q=80&w=1200','thumb'=>'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?q=80&w=400'],
            ['type'=>'video','embed'=>'https://www.youtube.com/embed/dQw4w9WgXcQ','thumb'=>'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?q=80&w=400'],
            ['type'=>'photo','src'=>'https://images.unsplash.com/photo-1444723121867-7a241cacace9?q=80&w=1200','thumb'=>'https://images.unsplash.com/photo-1444723121867-7a241cacace9?q=80&w=400'],
        ]
    ],
];

$demo_comments = [
    ['id'=>1,'project_id'=>1,'author_name'=>'Thomas M.','content'=>'Incroyable travail sur le reel, les transitions sont parfaites !','created_at'=>'2026-04-20 14:30:00'],
    ['id'=>2,'project_id'=>1,'author_name'=>'Sarah L.','content'=>'La colorimétrie est magnifique, quel logiciel tu utilises ?','created_at'=>'2026-04-21 09:15:00'],
    ['id'=>3,'project_id'=>3,'author_name'=>'Karim A.','content'=>'Golden Hour est mon projet préféré, cette lumière est incroyable.','created_at'=>'2026-04-22 16:45:00'],
    ['id'=>4,'project_id'=>6,'author_name'=>'Amina B.','content'=>'Les portraits neon sont 🔥🔥🔥 superbe maîtrise de la lumière.','created_at'=>'2026-05-01 10:00:00'],
];

if (empty($projects)) {
    $projects = $demo_projects;
    $comments = $demo_comments;
}

$cats = array_unique(array_filter(array_column($projects,'category')));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LA FAKH | Portfolio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&family=Space+Grotesk:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        html,body{height:100%;margin:0}
        body{font-family:'Space Grotesk',sans-serif;background:#000;color:#fff;display:flex;flex-direction:column;overflow-x:hidden}
        main{flex:1 0 auto}
        .brutal{font-family:'Inter',sans-serif;text-transform:uppercase;font-style:italic}

        /* Burger */
        .burger-line{width:24px;height:2px;background:#fff;transition:.3s}
        #burger-btn.open .line1{transform:rotate(45deg) translate(5px,6px)}
        #burger-btn.open .line2{opacity:0}
        #burger-btn.open .line3{transform:rotate(-45deg) translate(5px,-6px)}
        #mobile-menu{position:fixed;top:0;right:-100%;width:100%;height:100vh;background:#000;z-index:115;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:30px;transition:.5s cubic-bezier(.16,1,.3,1)}
        #mobile-menu.open{right:0}
        #mobile-menu a{font-size:32px;font-weight:900;text-transform:uppercase;font-style:italic;font-family:'Inter'}

        /* Grid */
        .projects-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:3px}
        @media(min-width:640px){.projects-grid{grid-template-columns:repeat(3,1fr)}}
        @media(min-width:1200px){.projects-grid{grid-template-columns:repeat(4,1fr)}}

        /* Card */
        .proj-card{aspect-ratio:9/12;position:relative;background:#0a0a0a;overflow:hidden;cursor:pointer;opacity:0;transform:translateY(20px);transition:opacity .6s,transform .6s}
        .proj-card.visible{opacity:1;transform:translateY(0)}
        .proj-card .cover{width:100%;height:100%;object-fit:cover;transition:transform .8s cubic-bezier(.16,1,.3,1),filter .5s}
        .proj-card:hover .cover{transform:scale(1.07);filter:brightness(.55)}
        .proj-card .hover-info{position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,.9) 0%,rgba(0,0,0,.1) 50%,transparent 100%);display:flex;flex-direction:column;justify-content:flex-end;padding:20px;opacity:0;transition:opacity .3s}
        .proj-card:hover .hover-info{opacity:1}
        .proj-num{position:absolute;top:12px;right:14px;font-size:8px;font-weight:900;color:rgba(255,255,255,.2);font-family:'Inter';z-index:5}

        /* Media count badge */
        .media-count{position:absolute;top:12px;left:12px;z-index:5;display:flex;gap:5px}
        .mc-badge{font-size:7px;font-weight:900;font-family:'Inter';text-transform:uppercase;letter-spacing:.12em;padding:3px 8px;display:flex;align-items:center;gap:4px}
        .mc-badge.video{background:rgba(255,255,255,.95);color:#000}
        .mc-badge.photo{background:rgba(0,0,0,.65);color:#fff;border:1px solid rgba(255,255,255,.25)}

        /* Filter */
        .filter-btn{font-size:9px;font-weight:900;text-transform:uppercase;letter-spacing:.2em;padding:8px 18px;border:1px solid rgba(255,255,255,.1);color:rgba(255,255,255,.35);cursor:pointer;transition:all .25s;background:transparent;position:relative;overflow:hidden}
        .filter-btn::after{content:'';position:absolute;inset:0;background:#fff;transform:scaleX(0);transform-origin:left;transition:transform .25s;z-index:0}
        .filter-btn.active::after,.filter-btn:hover::after{transform:scaleX(1)}
        .filter-btn span{position:relative;z-index:1}
        .filter-btn.active span,.filter-btn:hover span{color:#000}

        /* =================== LIGHTBOX =================== */
        #lightbox{display:none;position:fixed;inset:0;background:rgba(0,0,0,.98);z-index:9999;flex-direction:column}
        #lightbox.active{display:flex}

        /* TOP BAR */
        .lb-topbar{position:absolute;top:0;left:0;right:0;z-index:50;display:flex;justify-content:space-between;align-items:center;padding:14px 20px;background:linear-gradient(to bottom,rgba(0,0,0,.8),transparent)}
        .lb-proj-title{font-size:11px;font-weight:900;font-family:'Inter';text-transform:uppercase;letter-spacing:.2em}
        .lb-proj-cat{font-size:8px;font-weight:700;text-transform:uppercase;letter-spacing:.3em;color:rgba(255,255,255,.4);margin-top:2px}
        .lb-close-btn{width:36px;height:36px;border:1px solid rgba(255,255,255,.15);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:background .2s;flex-shrink:0}
        .lb-close-btn:hover{background:rgba(255,255,255,.1)}

        /* MAIN STAGE */
        .lb-stage{flex:1;display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden;padding:60px 50px}
        .lb-stage iframe,.lb-stage img,.lb-stage video{max-width:100%;max-height:100%;object-fit:contain;outline:none}
        .lb-stage iframe{width:100%;height:100%;border:none}

        /* ARROWS */
        .lb-arrow{position:absolute;top:50%;transform:translateY(-50%);z-index:20;background:none;border:none;color:#fff;opacity:.2;cursor:pointer;padding:16px;font-size:22px;transition:opacity .2s}
        .lb-arrow:hover{opacity:1}
        #lb-prev{left:0} #lb-next{right:0}

        /* STRIP (thumbnails) */
        .lb-strip{background:rgba(0,0,0,.85);border-top:1px solid rgba(255,255,255,.06);padding:10px 16px;display:flex;gap:6px;overflow-x:auto;flex-shrink:0;scroll-behavior:smooth}
        .lb-strip::-webkit-scrollbar{height:3px}
        .lb-strip::-webkit-scrollbar-thumb{background:rgba(255,255,255,.15)}
        .lb-thumb{width:56px;height:40px;object-fit:cover;cursor:pointer;border:2px solid transparent;transition:border-color .2s,opacity .2s;opacity:.45;flex-shrink:0;position:relative}
        .lb-thumb.active{border-color:#fff;opacity:1}
        .lb-thumb-wrap{position:relative;flex-shrink:0;cursor:pointer}
        .lb-thumb-wrap .vbadge{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,.45)}
        .lb-thumb-wrap .vbadge i{font-size:10px;color:#fff;opacity:.7}
        .lb-thumb-wrap.active-wrap .lb-thumb{border-color:#fff;opacity:1}

        /* BOTTOM BAR */
        .lb-bottombar{background:rgba(0,0,0,.9);border-top:1px solid rgba(255,255,255,.05);padding:10px 20px;display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;flex-shrink:0}
        .lb-counter-wrap{display:flex;align-items:center;gap:8px}
        .lb-item-counter{font-size:9px;font-weight:900;font-family:'Inter';color:rgba(255,255,255,.3);letter-spacing:.15em}
        .lb-item-type{font-size:7px;font-weight:900;font-family:'Inter';text-transform:uppercase;padding:3px 8px;letter-spacing:.15em}
        .lb-item-type.video{background:#fff;color:#000}
        .lb-item-type.photo{border:1px solid rgba(255,255,255,.2);color:rgba(255,255,255,.5)}

        /* Actions */
        .lb-actions{display:flex;align-items:center;gap:8px}
        .lb-btn{display:inline-flex;align-items:center;gap:6px;font-size:8px;font-weight:900;font-family:'Inter';text-transform:uppercase;letter-spacing:.15em;padding:7px 14px;border:1px solid rgba(255,255,255,.12);background:none;color:rgba(255,255,255,.45);cursor:pointer;transition:all .2s}
        .lb-btn:hover{border-color:rgba(255,255,255,.4);color:#fff}
        .lb-btn.liked{border-color:rgba(239,68,68,.5);color:rgb(239,68,68)}
        .lb-btn.commented{border-color:rgba(99,102,241,.5);color:rgb(129,140,248)}

        /* COMMENTS PANEL */
        #comments-panel{background:#060606;border-top:1px solid rgba(255,255,255,.04);flex-shrink:0;max-height:240px;display:flex;flex-direction:column;overflow:hidden}
        #comments-panel.open{display:flex}
        #comments-list{flex:1;overflow-y:auto;padding:12px 18px}
        #comments-list::-webkit-scrollbar{width:3px}
        #comments-list::-webkit-scrollbar-thumb{background:rgba(255,255,255,.1)}
        .c-item{display:flex;gap:10px;padding:9px 0;border-bottom:1px solid rgba(255,255,255,.03)}
        .c-item:last-child{border-bottom:none}
        .c-avatar{width:26px;height:26px;background:#1a1a1a;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:8px;font-weight:900;font-family:'Inter';flex-shrink:0;margin-top:2px}
        .c-form{display:flex;gap:6px;padding:8px 18px;border-top:1px solid rgba(255,255,255,.04);flex-shrink:0}
        .c-form input{flex:1;background:#0d0d0d;border:1px solid rgba(255,255,255,.07);color:#fff;padding:7px 12px;font-size:11px;font-family:'Space Grotesk';outline:none}
        .c-form input:focus{border-color:rgba(255,255,255,.2)}
        .c-form button{background:#fff;color:#000;border:none;padding:7px 16px;font-size:8px;font-weight:900;font-family:'Inter';text-transform:uppercase;letter-spacing:.12em;cursor:pointer;white-space:nowrap}
        .c-form button:hover{background:#e5e5e5}

        /* Reveal */
        .reveal{opacity:0;transform:translateY(24px);transition:opacity .7s,transform .7s}
        .reveal.visible{opacity:1;transform:translateY(0)}

        /* Footer */
        footer{flex-shrink:0;background:#000;border-top:1px solid rgba(255,255,255,.05)}
        .fl{font-size:10px;font-weight:bold;text-transform:uppercase;letter-spacing:.2em;color:#555;transition:.3s}
        .fl:hover{color:#fff}

        /* Spinner */
        .spinner{width:28px;height:28px;border:2px solid rgba(255,255,255,.08);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite;position:absolute}
        @keyframes spin{to{transform:rotate(360deg)}}

        /* Swipe mobile */
        @media(max-width:640px){
            .lb-stage{padding:50px 10px}
            .lb-arrow{padding:10px;font-size:16px}
            .lb-strip{padding:8px 10px}
        }
    </style>
</head>
<body>

<header class="flex justify-between items-center px-6 md:px-10 h-20 sticky top-0 bg-black/90 backdrop-blur-md z-[110] border-b border-white/5">
    <a href="index.php"><img src="logo.png" alt="LA FAKH" class="h-8 md:h-10 w-auto"></a>
    <nav class="hidden md:flex gap-10 text-[10px] font-bold uppercase tracking-[.2em]">
        <a href="index.php"     class="opacity-50 hover:opacity-100 transition">Accueil</a>
        <a href="portfolio.php" class="border-b border-white pb-1">Portfolio</a>
        <a href="shop.php"      class="opacity-50 hover:opacity-100 transition">Shop</a>
        <a href="contact.php"   class="opacity-50 hover:opacity-100 transition">Contact</a>
        <a href="a-propos.php"  class="opacity-50 hover:opacity-100 transition">À Propos</a>
    </nav>
    <button id="burger-btn" class="md:hidden flex flex-col gap-1.5 p-4 z-[120]" aria-label="Menu">
        <div class="burger-line line1"></div><div class="burger-line line2"></div><div class="burger-line line3"></div>
    </button>
</header>

<div id="mobile-menu">
    <a href="index.php">Accueil</a><a href="portfolio.php">Portfolio</a>
    <a href="shop.php">Shop</a><a href="contact.php">Contact</a><a href="a-propos.php">À Propos</a>
</div>

<main class="py-14 px-4 md:px-6">

    <!-- Hero -->
    <div class="text-center mb-10 reveal">
        <div class="text-[8px] font-black uppercase tracking-[.5em] text-zinc-600 mb-3">Since 2019</div>
        <h1 class="text-[50px] md:text-[90px] font-black brutal leading-none mb-4">PORTFOLIO</h1>
        <p class="text-zinc-500 text-sm max-w-md mx-auto">Chaque projet, photos et vidéos réunies — cliquez pour explorer.</p>
    </div>

    <!-- Filtres -->
    <div class="flex flex-wrap justify-center gap-2 mb-10 reveal">
        <button class="filter-btn active" data-filter="all"><span>Tout (<?= count($projects) ?>)</span></button>
        <?php foreach($cats as $cat): ?>
        <button class="filter-btn" data-filter="<?= htmlspecialchars($cat) ?>"><span><?= htmlspecialchars($cat) ?></span></button>
        <?php endforeach; ?>
    </div>

    <!-- Grille -->
    <div class="max-w-[1600px] mx-auto">
    <div class="projects-grid" id="projects-grid">
        <?php foreach($projects as $i => $p):
            $items = $p['media_items'] ?? [];
            $nv = count(array_filter($items, fn($x) => in_array($x['type'],['video','video_file'])));
            $np = count($items) - $nv;
        ?>
        <div class="proj-card"
             data-category="<?= htmlspecialchars($p['category']??'') ?>"
             data-index="<?= $i ?>"
             onclick="openProject(<?= $i ?>)">

            <span class="proj-num"><?= str_pad($i+1,2,'0',STR_PAD_LEFT) ?></span>

            <!-- Badges médias -->
            <div class="media-count">
                <?php if($nv>0): ?><span class="mc-badge video"><i class="fas fa-play text-[6px]"></i><?= $nv ?> vid</span><?php endif; ?>
                <?php if($np>0): ?><span class="mc-badge photo"><i class="fas fa-camera text-[6px]"></i><?= $np ?> photo</span><?php endif; ?>
            </div>

            <img class="cover" src="<?= htmlspecialchars($p['thumbnail_path']) ?>" alt="<?= htmlspecialchars($p['title']) ?>" loading="lazy">

            <div class="hover-info">
                <div class="text-[8px] font-black uppercase tracking-[.3em] text-white/40 mb-1"><?= htmlspecialchars($p['category']??'') ?></div>
                <div class="text-[13px] font-black uppercase tracking-widest" style="font-family:'Inter'"><?= htmlspecialchars($p['title']) ?></div>
                <div class="flex items-center gap-3 mt-3">
                    <span class="text-[8px] text-white/30 font-bold"><?= count($items) ?> élément<?= count($items)>1?'s':'' ?></span>
                    <span class="w-px h-3 bg-white/15"></span>
                    <span class="text-[8px] text-white/30 font-bold"><?= $nv ?> vidéo<?= $nv>1?'s':'' ?> · <?= $np ?> photo<?= $np>1?'s':'' ?></span>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    </div>

</main>

<!-- ==================== LIGHTBOX ==================== -->
<div id="lightbox">

    <!-- TOP BAR -->
    <div class="lb-topbar">
        <div>
            <div class="lb-proj-title" id="lb-proj-title"></div>
            <div class="lb-proj-cat"   id="lb-proj-cat"></div>
        </div>
        <div class="lb-close-btn" onclick="closeLb()"><i class="fas fa-times text-xs"></i></div>
    </div>

    <!-- STAGE -->
    <div class="lb-stage" id="lb-stage">
        <div class="spinner" id="lb-spinner"></div>
    </div>

    <!-- ARROWS -->
    <button class="lb-arrow" id="lb-prev" onclick="lbStep(-1)"><i class="fas fa-chevron-left"></i></button>
    <button class="lb-arrow" id="lb-next" onclick="lbStep(1)"><i class="fas fa-chevron-right"></i></button>

    <!-- THUMBNAIL STRIP -->
    <div class="lb-strip" id="lb-strip"></div>

    <!-- BOTTOM BAR -->
    <div class="lb-bottombar">
        <div class="lb-counter-wrap">
            <span class="lb-item-type" id="lb-item-type">Photo</span>
            <span class="lb-item-counter" id="lb-item-counter">1 / 1</span>
        </div>
        <div class="lb-actions">
            <button class="lb-btn" id="lb-like-btn" onclick="toggleLike()">
                <i class="far fa-heart"></i> <span id="lb-like-n">0</span>
            </button>
            <button class="lb-btn" id="lb-comment-btn" onclick="toggleComments()">
                <i class="far fa-comment"></i> <span id="lb-comment-n">0</span> Commentaires
            </button>
            <button class="lb-btn" onclick="shareProject()"><i class="fas fa-share-alt"></i> Partager</button>
        </div>
    </div>

    <!-- COMMENTS PANEL (hidden by default) -->
    <div id="comments-panel" style="display:none">
        <div id="comments-list"></div>
        <div class="c-form">
            <input id="c-name"    type="text" placeholder="Ton nom" maxlength="50">
            <input id="c-content" type="text" placeholder="Laisse un commentaire..." maxlength="280">
            <button onclick="submitComment()">Envoyer</button>
        </div>
    </div>

</div>

<!-- FOOTER -->
<footer>
    <div class="max-w-7xl mx-auto px-6 py-14">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
            <div><div class="text-xl font-black brutal mb-3">LA FAKH</div><p class="text-[10px] text-zinc-600 uppercase tracking-widest leading-relaxed">Production audiovisuelle · Reims</p></div>
            <div>
                <h4 class="text-[8px] font-black uppercase tracking-[.4em] text-white/20 mb-5">Services</h4>
                <ul class="space-y-3 text-[10px] text-zinc-500 uppercase font-bold">
                    <li>Vlog & Lifestyle</li><li>Institutionnel</li><li>Publicité Digitale</li><li>Post-Production</li>
                </ul>
            </div>
            <div>
                <h4 class="text-[8px] font-black uppercase tracking-[.4em] text-white/20 mb-5">Studio</h4>
                <ul class="space-y-3">
                    <li><a href="portfolio.php" class="fl">Portfolio</a></li>
                    <li><a href="a-propos.php"  class="fl">L'Agence</a></li>
                    <li><a href="contact.php"   class="fl">Contact</a></li>
                    <li><a href="mentions-legales.php" class="fl">Mentions Légales</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-[8px] font-black uppercase tracking-[.4em] text-white/20 mb-5">Réseaux</h4>
                <div class="flex gap-5">
                    <a href="#" class="text-zinc-600 hover:text-white transition text-xl"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-zinc-600 hover:text-white transition text-xl"><i class="fab fa-tiktok"></i></a>
                    <a href="#" class="text-zinc-600 hover:text-white transition text-xl"><i class="fab fa-vimeo-v"></i></a>
                </div>
            </div>
        </div>
        <div class="flex flex-col md:flex-row justify-between items-center border-t border-white/5 pt-6 gap-4">
            <div class="text-[8px] uppercase tracking-[.5em] text-zinc-700">© 2026 LA FAKH STUDIO</div>
            <button onclick="window.scrollTo({top:0,behavior:'smooth'})" class="text-[8px] uppercase tracking-[.3em] text-zinc-600 hover:text-white transition">Back to top <i class="fas fa-arrow-up ml-1"></i></button>
        </div>
    </div>
</footer>

<script>
const PROJECTS  = <?= json_encode($projects) ?>;
const ALL_CMTS  = <?= json_encode($comments) ?>;

let curProj = 0;   // index projet ouvert
let curItem = 0;   // index médias dans le projet
let cmtOpen = false;

// ===== SCROLL REVEAL =====
const io = new IntersectionObserver(es => es.forEach((e,i) => {
    if(e.isIntersecting){ setTimeout(()=>e.target.classList.add('visible'), i*80); io.unobserve(e.target); }
}), {threshold:.05});
document.querySelectorAll('.reveal, .proj-card').forEach(el => io.observe(el));

// ===== BURGER =====
document.getElementById('burger-btn').addEventListener('click', function(){
    this.classList.toggle('open');
    const m = document.getElementById('mobile-menu');
    m.classList.toggle('open');
    document.body.style.overflow = m.classList.contains('open') ? 'hidden' : '';
});

// ===== FILTRES =====
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function(){
        document.querySelectorAll('.filter-btn').forEach(b=>b.classList.remove('active'));
        this.classList.add('active');
        const f = this.dataset.filter;
        document.querySelectorAll('.proj-card').forEach(card => {
            const show = f === 'all' || card.dataset.category === f;
            card.style.display = show ? '' : 'none';
            if(show) setTimeout(()=>card.classList.add('visible'), 60);
        });
    });
});

// ===== LIKES (localStorage) =====
function getLikes()   { try{ return JSON.parse(localStorage.getItem('lf_likes')||'{}'); }catch(e){return{};} }
function getLikeCnt() { try{ return JSON.parse(localStorage.getItem('lf_lc')||'{}'); }catch(e){return{};} }
function saveLikes(o) { localStorage.setItem('lf_likes', JSON.stringify(o)); }
function saveLikeCnt(o){ localStorage.setItem('lf_lc', JSON.stringify(o)); }

function toggleLike(){
    const pid  = PROJECTS[curProj].id;
    const l    = getLikes(); const c = getLikeCnt();
    l[pid]     = !l[pid];
    c[pid]     = Math.max(0, (c[pid]||0) + (l[pid]?1:-1));
    saveLikes(l); saveLikeCnt(c);
    refreshLikeUI();
}
function refreshLikeUI(){
    const pid   = PROJECTS[curProj].id;
    const liked = !!getLikes()[pid];
    const n     = getLikeCnt()[pid]||0;
    const btn   = document.getElementById('lb-like-btn');
    btn.classList.toggle('liked', liked);
    btn.querySelector('i').className = liked ? 'fas fa-heart' : 'far fa-heart';
    document.getElementById('lb-like-n').textContent = n;
}

// ===== COMMENTS =====
function getStoredCmts(pid){ try{ return JSON.parse(localStorage.getItem('lf_c_'+pid)||'[]'); }catch(e){return[];} }
function saveStoredCmts(pid,arr){ localStorage.setItem('lf_c_'+pid, JSON.stringify(arr)); }

function toggleComments(){
    cmtOpen = !cmtOpen;
    const panel = document.getElementById('comments-panel');
    panel.style.display = cmtOpen ? 'flex' : 'none';
    panel.style.flexDirection = 'column';
    document.getElementById('lb-comment-btn').classList.toggle('commented', cmtOpen);
    if(cmtOpen) renderComments();
}

function renderComments(){
    const pid = PROJECTS[curProj].id;
    const srv = ALL_CMTS.filter(c => parseInt(c.project_id)===parseInt(pid));
    const loc = getStoredCmts(pid);
    // dedupe (avoid same content from both sources if already synced)
    const all = [...srv, ...loc].sort((a,b)=>new Date(a.created_at)-new Date(b.created_at));
    const list = document.getElementById('comments-list');
    list.innerHTML = all.length ? all.map(c=>`
        <div class="c-item">
            <div class="c-avatar">${esc(c.author_name).charAt(0).toUpperCase()}</div>
            <div>
                <div style="font-size:9px;font-weight:900;text-transform:uppercase;letter-spacing:.1em;margin-bottom:3px">${esc(c.author_name)}</div>
                <div style="font-size:11px;color:rgba(255,255,255,.5);line-height:1.6">${esc(c.content)}</div>
            </div>
        </div>`).join('')
      : '<p style="font-size:10px;color:rgba(255,255,255,.2);text-align:center;padding:16px 0">Aucun commentaire — sois le premier !</p>';
    refreshCmtCount();
}

function refreshCmtCount(){
    const pid = PROJECTS[curProj].id;
    const n   = ALL_CMTS.filter(c=>parseInt(c.project_id)===parseInt(pid)).length + getStoredCmts(pid).length;
    document.getElementById('lb-comment-n').textContent = n;
}

function submitComment(){
    const name    = document.getElementById('c-name').value.trim();
    const content = document.getElementById('c-content').value.trim();
    if(!name||!content) return;
    const pid = PROJECTS[curProj].id;
    const cmt = {id:Date.now(), project_id:pid, author_name:name, content, created_at:new Date().toISOString()};
    const stored = getStoredCmts(pid);
    stored.push(cmt);
    saveStoredCmts(pid, stored);
    fetch('add_comment.php',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({project_id:pid,author_name:name,content})}).catch(()=>{});
    document.getElementById('c-name').value='';
    document.getElementById('c-content').value='';
    renderComments();
}

// ===== LIGHTBOX =====
function openProject(idx){
    curProj = idx; curItem = 0;
    document.getElementById('lightbox').classList.add('active');
    document.body.style.overflow = 'hidden';
    cmtOpen = false;
    document.getElementById('comments-panel').style.display = 'none';
    renderLb();
}

function renderLb(){
    const p     = PROJECTS[curProj];
    const items = p.media_items || [];

    // Titles
    document.getElementById('lb-proj-title').textContent = p.title    || '';
    document.getElementById('lb-proj-cat').textContent   = p.category || '';

    // Counter
    document.getElementById('lb-item-counter').textContent = (curItem+1) + ' / ' + items.length;

    // Type badge
    const it   = items[curItem] || {};
    const isVid = (it.type==='video'||it.type==='video_file');
    const typEl = document.getElementById('lb-item-type');
    typEl.textContent = isVid ? 'Vidéo' : 'Photo';
    typEl.className   = 'lb-item-type ' + (isVid?'video':'photo');

    // Arrows visibility
    document.getElementById('lb-prev').style.opacity = items.length > 1 ? '' : '0';
    document.getElementById('lb-next').style.opacity = items.length > 1 ? '' : '0';

    // Media
    renderMedia(it);

    // Strip
    renderStrip(items);

    // Like + comments
    refreshLikeUI();
    refreshCmtCount();
    if(cmtOpen) renderComments();
}

function renderMedia(item){
    const stage = document.getElementById('lb-stage');
    // Remove old media elements (keep spinner)
    stage.querySelectorAll('img,iframe,video').forEach(el=>el.remove());
    const sp = document.getElementById('lb-spinner');
    sp.style.display = 'block';

    if(item.type === 'video'){
        const iframe = document.createElement('iframe');
        iframe.src   = (item.embed||'') + '?autoplay=1&rel=0';
        iframe.allow = 'autoplay; fullscreen';
        iframe.onload = ()=>sp.style.display='none';
        stage.appendChild(iframe);
    } else if(item.type === 'video_file'){
        const vid = document.createElement('video');
        vid.src = item.src||''; vid.autoplay=true; vid.controls=true; vid.loop=true;
        vid.style.cssText='max-width:100%;max-height:100%';
        vid.onloadeddata = ()=>sp.style.display='none';
        stage.appendChild(vid);
    } else {
        const img = document.createElement('img');
        img.src = item.src || item.thumb || '';
        img.alt = '';
        img.onload  = ()=>sp.style.display='none';
        img.onerror = ()=>sp.style.display='none';
        stage.appendChild(img);
    }
}

function renderStrip(items){
    const strip = document.getElementById('lb-strip');
    strip.innerHTML = items.map((it,i) => {
        const thumb = it.thumb || it.src || '';
        const isVid = (it.type==='video'||it.type==='video_file');
        return `<div class="lb-thumb-wrap ${i===curItem?'active-wrap':''}" onclick="goToItem(${i})">
            <img class="lb-thumb ${i===curItem?'active':''}" src="${esc(thumb)}" loading="lazy" onerror="this.src=''" alt="">
            ${isVid?'<div class="vbadge"><i class="fas fa-play"></i></div>':''}
        </div>`;
    }).join('');
    // scroll active thumb into view
    const active = strip.querySelector('.active-wrap');
    if(active) active.scrollIntoView({inline:'center', behavior:'smooth', block:'nearest'});
}

function goToItem(i){
    curItem = i;
    renderLb();
}

function lbStep(dir){
    const items = PROJECTS[curProj].media_items || [];
    curItem = (curItem + dir + items.length) % items.length;
    renderLb();
}

function closeLb(){
    document.getElementById('lightbox').classList.remove('active');
    document.getElementById('lb-stage').querySelectorAll('video,iframe').forEach(el=>el.remove());
    document.body.style.overflow = '';
}

function shareProject(){
    navigator.clipboard.writeText(window.location.href).then(()=>{
        const btn = event.currentTarget;
        const orig = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i> Copié !';
        setTimeout(()=>btn.innerHTML=orig, 2000);
    });
}

function esc(t){ return String(t||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }

// Keyboard + swipe
window.addEventListener('keydown', e=>{
    if(!document.getElementById('lightbox').classList.contains('active')) return;
    if(e.key==='Escape')     closeLb();
    if(e.key==='ArrowRight') lbStep(1);
    if(e.key==='ArrowLeft')  lbStep(-1);
});

// Touch swipe on stage
let tx=0;
document.getElementById('lb-stage').addEventListener('touchstart', e=>{ tx=e.touches[0].clientX; }, {passive:true});
document.getElementById('lb-stage').addEventListener('touchend', e=>{
    const dx = e.changedTouches[0].clientX - tx;
    if(Math.abs(dx)>40) lbStep(dx<0?1:-1);
}, {passive:true});
</script>
</body>
</html>
