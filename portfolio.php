<?php 
require 'db.php';
$projects = [];
try {
    if ($pdo) {
        $projects = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (\Throwable $e) { $projects = []; }

// Comments
$comments = [];
try {
    if ($pdo) {
        $comments = $pdo->query("SELECT * FROM comments WHERE approved=1 ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (\Throwable $e) { $comments = []; }

// Demo projects — mix photos + vidéos
$demo_projects = [
    ['id'=>1,'title'=>'REEL 2026',         'category'=>'Showreel',    'type'=>'video',
     'thumbnail_path'=>'https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?q=80&w=800',
     'video_embed'=>'https://www.youtube.com/embed/dQw4w9WgXcQ', 'media_path'=>'','external_link'=>''],
    ['id'=>2,'title'=>'URBAN CULTURE',      'category'=>'Vlog',        'type'=>'photo',
     'thumbnail_path'=>'https://images.unsplash.com/photo-1444723121867-7a241cacace9?q=80&w=1200',
     'video_embed'=>'','media_path'=>'','external_link'=>''],
    ['id'=>3,'title'=>'GOLDEN HOUR',        'category'=>'Cinéma',      'type'=>'video',
     'thumbnail_path'=>'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?q=80&w=800',
     'video_embed'=>'https://www.youtube.com/embed/dQw4w9WgXcQ','media_path'=>'','external_link'=>''],
    ['id'=>4,'title'=>'TRAVEL DOCUMENTARY', 'category'=>'Documentaire','type'=>'photo',
     'thumbnail_path'=>'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?q=80&w=1200',
     'video_embed'=>'','media_path'=>'','external_link'=>''],
    ['id'=>5,'title'=>'BRAND CAMPAIGN',     'category'=>'Publicité',   'type'=>'video',
     'thumbnail_path'=>'https://images.unsplash.com/photo-1611532736597-de2d4265fba3?q=80&w=800',
     'video_embed'=>'https://www.youtube.com/embed/dQw4w9WgXcQ','media_path'=>'','external_link'=>''],
    ['id'=>6,'title'=>'NEON PORTRAITS',     'category'=>'Portrait',    'type'=>'photo',
     'thumbnail_path'=>'https://images.unsplash.com/photo-1514565131-fce0801e6175?q=80&w=1200',
     'video_embed'=>'','media_path'=>'','external_link'=>''],
    ['id'=>7,'title'=>'DESERT ROAD TRIP',   'category'=>'Vlog',        'type'=>'video',
     'thumbnail_path'=>'https://images.unsplash.com/photo-1509316785289-025f5b846b35?q=80&w=800',
     'video_embed'=>'https://www.youtube.com/embed/dQw4w9WgXcQ','media_path'=>'','external_link'=>''],
    ['id'=>8,'title'=>'MONOCHROME CITY',    'category'=>'Cinéma',      'type'=>'photo',
     'thumbnail_path'=>'https://images.unsplash.com/photo-1500281781950-6cd80847ebcd?q=80&w=1200',
     'video_embed'=>'','media_path'=>'','external_link'=>''],
    ['id'=>9,'title'=>'MUSIC VIDEO',        'category'=>'Clip',        'type'=>'video',
     'thumbnail_path'=>'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=800',
     'video_embed'=>'https://www.youtube.com/embed/dQw4w9WgXcQ','media_path'=>'','external_link'=>''],
    ['id'=>10,'title'=>'LIFESTYLE SERIES',  'category'=>'Vlog',        'type'=>'photo',
     'thumbnail_path'=>'https://images.unsplash.com/photo-1682687982501-1e58ab814714?q=80&w=1200',
     'video_embed'=>'','media_path'=>'','external_link'=>''],
    ['id'=>11,'title'=>'FILM EMULATION',    'category'=>'Cinéma',      'type'=>'video',
     'thumbnail_path'=>'https://images.unsplash.com/photo-1501854140801-50d01698950b?q=80&w=800',
     'video_embed'=>'https://www.youtube.com/embed/dQw4w9WgXcQ','media_path'=>'','external_link'=>''],
    ['id'=>12,'title'=>'CORPORATE REIMS',   'category'=>'Institutionnel','type'=>'photo',
     'thumbnail_path'=>'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?q=80&w=1200',
     'video_embed'=>'','media_path'=>'','external_link'=>''],
];

if (empty($projects)) {
    $projects = $demo_projects;
    $demo_comments = [
        ['id'=>1,'project_id'=>1,'author_name'=>'Thomas M.','content'=>'Incroyable travail sur le reel, les transitions sont parfaites !','created_at'=>'2026-04-20 14:30:00'],
        ['id'=>2,'project_id'=>1,'author_name'=>'Sarah L.','content'=>'La colorimétrie est magnifique, quel logiciel tu utilises ?','created_at'=>'2026-04-21 09:15:00'],
        ['id'=>3,'project_id'=>3,'author_name'=>'Karim A.','content'=>'Golden Hour est mon projet préféré, cette lumière est incroyable.','created_at'=>'2026-04-22 16:45:00'],
    ];
    $comments = $demo_comments;
}
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
        .brutal-text{font-family:'Inter',sans-serif;text-transform:uppercase;font-style:italic}

        /* BURGER */
        .burger-line{width:25px;height:2px;background:#fff;transition:.3s}
        #burger-btn.open .line1{transform:rotate(45deg) translate(5px,6px)}
        #burger-btn.open .line2{opacity:0}
        #burger-btn.open .line3{transform:rotate(-45deg) translate(5px,-6px)}
        #mobile-menu{position:fixed;top:0;right:-100%;width:100%;height:100vh;background:#000;z-index:115;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:30px;transition:.5s cubic-bezier(.16,1,.3,1)}
        #mobile-menu.open{right:0}
        #mobile-menu a{font-size:32px;font-weight:900;text-transform:uppercase;font-style:italic;font-family:'Inter'}

        /* GRID */
        .projects-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:3px}
        @media(min-width:768px){.projects-grid{grid-template-columns:repeat(3,1fr)}}
        @media(min-width:1280px){.projects-grid{grid-template-columns:repeat(4,1fr)}}

        /* CARD */
        .proj-card{aspect-ratio:16/9;position:relative;background:#0a0a0a;overflow:hidden;cursor:pointer;opacity:0;transform:translateY(20px);transition:opacity .6s ease,transform .6s ease}
        .proj-card.visible{opacity:1;transform:translateY(0)}
        .proj-card img{width:100%;height:100%;object-fit:cover;transition:transform .8s cubic-bezier(.16,1,.3,1),filter .5s}
        .proj-card:hover img{transform:scale(1.08);filter:brightness(.6)}
        .proj-card .overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,.85) 0%,transparent 60%);display:flex;flex-direction:column;justify-content:flex-end;padding:16px;opacity:0;transition:opacity .35s}
        .proj-card:hover .overlay{opacity:1}
        .proj-num{position:absolute;top:12px;right:12px;font-size:8px;font-weight:900;color:rgba(255,255,255,.2);font-family:'Inter';z-index:11;transition:color .3s}
        .proj-card:hover .proj-num{color:rgba(255,255,255,.7)}

        /* TYPE BADGE */
        .type-badge{position:absolute;top:12px;left:12px;z-index:11;font-size:7px;font-weight:900;font-family:'Inter';text-transform:uppercase;letter-spacing:.2em;padding:4px 10px}
        .type-badge.video{background:rgba(255,255,255,.95);color:#000}
        .type-badge.photo{background:rgba(0,0,0,.6);color:#fff;border:1px solid rgba(255,255,255,.25)}

        /* FILTER */
        .filter-btn{font-size:9px;font-weight:900;text-transform:uppercase;letter-spacing:.25em;padding:8px 20px;border:1px solid rgba(255,255,255,.12);color:rgba(255,255,255,.35);cursor:pointer;transition:all .3s;background:transparent;position:relative;overflow:hidden}
        .filter-btn::before{content:'';position:absolute;inset:0;background:#fff;transform:scaleX(0);transform-origin:left;transition:transform .3s}
        .filter-btn:hover::before,.filter-btn.active::before{transform:scaleX(1)}
        .filter-btn span{position:relative;z-index:1}
        .filter-btn:hover span,.filter-btn.active span{color:#000}

        /* LIGHTBOX */
        #lightbox{display:none;position:fixed;inset:0;background:rgba(0,0,0,.97);backdrop-filter:blur(12px);z-index:9999;flex-direction:column}
        #lightbox.active{display:flex}
        .lb-main{flex:1;display:flex;align-items:center;justify-content:center;position:relative;padding:60px 60px 0;min-height:0}
        .lb-main iframe{width:100%;height:100%;border:none;border-radius:2px}
        .lb-main img{max-width:100%;max-height:100%;object-fit:contain}
        .lb-main video{max-width:100%;max-height:100%;object-fit:contain}
        .lb-arrow{position:absolute;top:50%;transform:translateY(-50%);font-size:18px;opacity:.2;cursor:pointer;transition:.3s;padding:20px;z-index:10;background:none;border:none;color:#fff}
        .lb-arrow:hover{opacity:1}
        .lb-close{position:absolute;top:16px;right:16px;z-index:200;width:40px;height:40px;display:flex;align-items:center;justify-content:center;border:1px solid rgba(255,255,255,.15);cursor:pointer;transition:background .3s}
        .lb-close:hover{background:rgba(255,255,255,.1)}

        /* LB INFOBAR */
        .lb-infobar{background:rgba(0,0,0,.9);border-top:1px solid rgba(255,255,255,.06);padding:14px 24px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;flex-shrink:0}

        /* LIKE BTN */
        .like-btn{display:inline-flex;align-items:center;gap:6px;font-size:9px;font-weight:900;font-family:'Inter';text-transform:uppercase;letter-spacing:.15em;padding:8px 18px;border:1px solid rgba(255,255,255,.15);background:none;color:rgba(255,255,255,.5);cursor:pointer;transition:all .3s}
        .like-btn.liked{border-color:rgba(239,68,68,.6);color:rgb(239,68,68)}
        .like-btn:hover{border-color:rgba(255,255,255,.4);color:#fff}

        /* COMMENTS PANEL */
        #comments-panel{background:#050505;border-top:1px solid rgba(255,255,255,.05);padding:24px;max-height:260px;overflow-y:auto;flex-shrink:0}
        .comment-item{padding:10px 0;border-bottom:1px solid rgba(255,255,255,.04);display:flex;gap:10px}
        .comment-item:last-child{border-bottom:none}
        .comment-avatar{width:28px;height:28px;background:#1a1a1a;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:900;font-family:'Inter';flex-shrink:0}
        .comment-form{display:flex;gap:8px;margin-top:12px}
        .comment-form input{flex:1;background:#0d0d0d;border:1px solid rgba(255,255,255,.08);color:#fff;padding:8px 14px;font-size:11px;font-family:'Space Grotesk';outline:none}
        .comment-form input:focus{border-color:rgba(255,255,255,.25)}
        .comment-form button{background:#fff;color:#000;border:none;padding:8px 18px;font-size:9px;font-weight:900;font-family:'Inter';text-transform:uppercase;letter-spacing:.15em;cursor:pointer;transition:background .2s;flex-shrink:0}
        .comment-form button:hover{background:#e5e5e5}

        /* REVEAL */
        .reveal{opacity:0;transform:translateY(28px);transition:opacity .7s ease,transform .7s ease}
        .reveal.visible{opacity:1;transform:translateY(0)}

        /* FOOTER */
        footer{flex-shrink:0;background:#000;border-top:1px solid rgba(255,255,255,.05)}
        .footer-link{font-size:10px;font-weight:bold;text-transform:uppercase;letter-spacing:.2em;color:#666;transition:.3s}
        .footer-link:hover{color:#fff;padding-left:5px}

        /* SPINNER */
        .spinner{width:28px;height:28px;border:2px solid rgba(255,255,255,.1);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite}
        @keyframes spin{to{transform:rotate(360deg)}}
    </style>
</head>
<body>

<header class="flex justify-between items-center px-6 md:px-10 h-24 sticky top-0 bg-black/90 backdrop-blur-md z-[110] border-b border-white/5">
    <a href="index.php"><img src="logo.png" alt="Logo" class="h-8 md:h-10 w-auto"></a>
    <nav class="hidden md:flex gap-10 text-[10px] font-bold uppercase tracking-[.2em]">
        <a href="index.php"     class="opacity-50 hover:opacity-100 transition">Accueil</a>
        <a href="portfolio.php" class="border-b border-white pb-1">Portfolio</a>
        <a href="shop.php"      class="opacity-50 hover:opacity-100 transition">Shop</a>
        <a href="contact.php"   class="opacity-50 hover:opacity-100 transition">Contact</a>
        <a href="a-propos.php"  class="opacity-50 hover:opacity-100 transition">À Propos</a>
    </nav>
    <button id="burger-btn" class="md:hidden flex flex-col gap-1.5 p-4 z-[120]">
        <div class="burger-line line1"></div><div class="burger-line line2"></div><div class="burger-line line3"></div>
    </button>
</header>
<div id="mobile-menu">
    <a href="index.php">Accueil</a><a href="portfolio.php">Portfolio</a>
    <a href="shop.php">Shop</a><a href="contact.php">Contact</a><a href="a-propos.php">À Propos</a>
</div>

<main class="py-16 px-4 md:px-6">

    <!-- HERO -->
    <div class="text-center mb-12 reveal">
        <div class="text-[8px] font-black uppercase tracking-[.5em] text-zinc-600 mb-3">Since 2019</div>
        <h1 class="text-[50px] md:text-[100px] font-black brutal-text leading-none mb-4">PORTFOLIO</h1>
        <p class="text-zinc-500 text-sm max-w-xl mx-auto">Productions audiovisuelles, vlogs, clips et campagnes pour marques et artistes.</p>
    </div>

    <!-- STATS -->
    <div class="flex flex-wrap justify-center gap-12 mb-14 reveal">
        <div class="text-center"><div class="text-2xl font-black brutal-text"><?= count($projects) ?></div><div class="text-[8px] uppercase tracking-widest text-zinc-600 mt-1">Projets</div></div>
        <div class="w-px bg-white/10"></div>
        <div class="text-center"><div class="text-2xl font-black brutal-text"><?= count(array_filter($projects, fn($p) => ($p['type']??'photo') === 'video')) ?></div><div class="text-[8px] uppercase tracking-widest text-zinc-600 mt-1">Vidéos</div></div>
        <div class="w-px bg-white/10"></div>
        <div class="text-center"><div class="text-2xl font-black brutal-text"><?= count(array_unique(array_column($projects,'category'))) ?></div><div class="text-[8px] uppercase tracking-widest text-zinc-600 mt-1">Catégories</div></div>
    </div>

    <!-- FILTRES -->
    <?php $cats = array_unique(array_filter(array_column($projects,'category'))); ?>
    <div class="flex flex-wrap justify-center gap-3 mb-10 reveal">
        <button class="filter-btn active" data-filter="all"><span>Tout</span></button>
        <button class="filter-btn" data-filter="__video"><span><i class="fas fa-film mr-1"></i> Vidéos</span></button>
        <button class="filter-btn" data-filter="__photo"><span><i class="fas fa-image mr-1"></i> Photos</span></button>
        <?php foreach($cats as $cat): ?>
        <button class="filter-btn" data-filter="<?= htmlspecialchars($cat) ?>"><span><?= htmlspecialchars($cat) ?></span></button>
        <?php endforeach; ?>
    </div>

    <!-- GRILLE -->
    <div class="max-w-[1600px] mx-auto">
        <div class="projects-grid" id="projects-grid">
            <?php foreach($projects as $i => $p):
                $type = $p['type'] ?? 'photo';
            ?>
            <div class="proj-card"
                 data-category="<?= htmlspecialchars($p['category'] ?? '') ?>"
                 data-type="<?= $type ?>"
                 data-index="<?= $i ?>"
                 onclick="openLightbox(<?= $i ?>)">
                <span class="proj-num"><?= str_pad($i+1,2,'0',STR_PAD_LEFT) ?></span>
                <span class="type-badge <?= $type ?>"><?= $type === 'video' ? '<i class="fas fa-play mr-1"></i>Vidéo' : '<i class="fas fa-camera mr-1"></i>Photo' ?></span>
                <img src="<?= htmlspecialchars($p['thumbnail_path']) ?>" alt="<?= htmlspecialchars($p['title']) ?>" loading="lazy">
                <div class="overlay">
                    <div class="text-[8px] font-black uppercase tracking-[.25em] text-white/50 mb-1"><?= htmlspecialchars($p['category']??'') ?></div>
                    <div class="text-[12px] font-black uppercase tracking-widest" style="font-family:'Inter'"><?= htmlspecialchars($p['title']) ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

</main>

<!-- ========== LIGHTBOX ========== -->
<div id="lightbox">

    <div class="lb-close" onclick="closeLightbox()"><i class="fas fa-times text-xs"></i></div>
    <button class="lb-arrow" style="left:0"  onclick="lbPrev()"><i class="fas fa-chevron-left"></i></button>
    <button class="lb-arrow" style="right:0" onclick="lbNext()"><i class="fas fa-chevron-right"></i></button>

    <!-- MEDIA -->
    <div class="lb-main" id="lb-media">
        <div class="spinner" id="lb-spinner"></div>
    </div>

    <!-- INFOBAR -->
    <div class="lb-infobar">
        <div class="flex items-center gap-4 flex-wrap">
            <span id="lb-title" class="text-[11px] font-black uppercase tracking-widest" style="font-family:'Inter'"></span>
            <span id="lb-cat"   class="text-[8px] uppercase tracking-[.3em] text-zinc-600"></span>
            <span id="lb-counter" class="text-[8px] font-mono text-zinc-700"></span>
        </div>
        <div class="flex items-center gap-3">
            <button class="like-btn" id="lb-like-btn" onclick="toggleLike()">
                <i class="far fa-heart"></i>
                <span id="lb-like-count">0</span>
            </button>
            <button onclick="toggleComments()" class="like-btn" id="lb-comment-btn">
                <i class="far fa-comment"></i>
                <span id="lb-comment-count">0</span>
            </button>
            <button onclick="shareProject()" class="like-btn">
                <i class="fas fa-share-alt"></i> Partager
            </button>
        </div>
    </div>

    <!-- COMMENTS PANEL -->
    <div id="comments-panel" style="display:none">
        <div id="comments-list"></div>
        <div class="comment-form">
            <input type="text" id="comment-name"    placeholder="Ton nom" maxlength="50">
            <input type="text" id="comment-content" placeholder="Laisse un commentaire..." maxlength="300">
            <button onclick="submitComment()">Envoyer</button>
        </div>
    </div>

</div>

<footer>
    <div class="max-w-7xl mx-auto px-6 py-16">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
            <div><div class="text-xl font-black brutal-text mb-4">LA FAKH</div><p class="text-[10px] text-zinc-500 uppercase tracking-widest leading-relaxed">Production audiovisuelle basée à Reims.</p></div>
            <div>
                <h4 class="text-[9px] font-black uppercase tracking-[.4em] text-white/30 mb-6">Services</h4>
                <ul class="space-y-3">
                    <li class="footer-link cursor-default">Vlog & Lifestyle</li>
                    <li class="footer-link cursor-default">Institutionnel</li>
                    <li class="footer-link cursor-default">Publicité Digitale</li>
                    <li class="footer-link cursor-default">Post-Production</li>
                </ul>
            </div>
            <div>
                <h4 class="text-[9px] font-black uppercase tracking-[.4em] text-white/30 mb-6">Studio</h4>
                <ul class="space-y-3">
                    <li><a href="portfolio.php" class="footer-link">Portfolio</a></li>
                    <li><a href="a-propos.php"  class="footer-link">L'Agence</a></li>
                    <li><a href="contact.php"   class="footer-link">Contact</a></li>
                    <li><a href="mentions-legales.php" class="footer-link">Mentions Légales</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-[9px] font-black uppercase tracking-[.4em] text-white/30 mb-6">Direct</h4>
                <div class="text-[10px] font-bold uppercase tracking-widest text-zinc-400 mb-4"><i class="fas fa-envelope mr-2 opacity-30"></i> contact@lafakh.fr</div>
                <div class="flex gap-5">
                    <a href="#" class="text-zinc-500 hover:text-white transition"><i class="fab fa-instagram text-lg"></i></a>
                    <a href="#" class="text-zinc-500 hover:text-white transition"><i class="fab fa-tiktok text-lg"></i></a>
                    <a href="#" class="text-zinc-500 hover:text-white transition"><i class="fab fa-vimeo-v text-lg"></i></a>
                </div>
            </div>
        </div>
        <div class="flex flex-col md:flex-row justify-between items-center border-t border-white/5 pt-8 gap-4">
            <div class="text-[8px] uppercase tracking-[.5em] text-zinc-700">© 2026 LA FAKH STUDIO</div>
            <button onclick="window.scrollTo({top:0,behavior:'smooth'})" class="text-[8px] uppercase tracking-[.3em] text-zinc-500 hover:text-white transition flex items-center">BACK TO TOP <i class="fas fa-arrow-up ml-2"></i></button>
        </div>
    </div>
</footer>

<script>
const PROJECTS = <?= json_encode($projects) ?>;
const ALL_COMMENTS = <?= json_encode($comments) ?>;
let lbIdx = 0;

// ===== SCROLL REVEAL =====
const ro = new IntersectionObserver(entries => {
    entries.forEach((e,i) => { if(e.isIntersecting){ setTimeout(()=>e.target.classList.add('visible'),i*60); ro.unobserve(e.target); } });
}, {threshold:.05});
document.querySelectorAll('.reveal').forEach(el=>ro.observe(el));

const co = new IntersectionObserver(entries => {
    entries.forEach((e,i) => { if(e.isIntersecting){ setTimeout(()=>e.target.classList.add('visible'),i*70); co.unobserve(e.target); } });
}, {threshold:.05});
document.querySelectorAll('.proj-card').forEach(el=>co.observe(el));

// ===== BURGER =====
document.getElementById('burger-btn').addEventListener('click', function() {
    this.classList.toggle('open');
    const m = document.getElementById('mobile-menu');
    m.classList.toggle('open');
    document.body.style.overflow = m.classList.contains('open') ? 'hidden' : 'auto';
});

// ===== FILTRES =====
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        const f = this.dataset.filter;
        document.querySelectorAll('.proj-card').forEach(card => {
            const show = f === 'all'
                || (f === '__video' && card.dataset.type === 'video')
                || (f === '__photo' && card.dataset.type === 'photo')
                || card.dataset.category === f;
            card.style.display = show ? '' : 'none';
            if(show) setTimeout(()=>card.classList.add('visible'),50);
        });
    });
});

// ===== LIKES (localStorage) =====
function getLikes() { try { return JSON.parse(localStorage.getItem('lf_likes')||'{}'); } catch(e){ return {}; } }
function setLikes(obj) { localStorage.setItem('lf_likes', JSON.stringify(obj)); }
function getLikeCounts() { try { return JSON.parse(localStorage.getItem('lf_like_counts')||'{}'); } catch(e){ return {}; } }
function setLikeCounts(obj) { localStorage.setItem('lf_like_counts', JSON.stringify(obj)); }

function toggleLike() {
    const p = PROJECTS[lbIdx];
    const pid = p.id;
    const likes = getLikes();
    const counts = getLikeCounts();
    const liked = likes[pid];
    likes[pid] = !liked;
    counts[pid] = Math.max(0, (counts[pid]||0) + (liked ? -1 : 1));
    setLikes(likes); setLikeCounts(counts);
    updateLikeUI(pid);
}

function updateLikeUI(pid) {
    const likes  = getLikes();
    const counts = getLikeCounts();
    const btn    = document.getElementById('lb-like-btn');
    const icon   = btn.querySelector('i');
    const liked  = !!likes[pid];
    btn.classList.toggle('liked', liked);
    icon.className = liked ? 'fas fa-heart' : 'far fa-heart';
    document.getElementById('lb-like-count').textContent = counts[pid] || 0;
}

// ===== COMMENTS =====
let commentsVisible = false;

function toggleComments() {
    commentsVisible = !commentsVisible;
    document.getElementById('comments-panel').style.display = commentsVisible ? 'block' : 'none';
    document.getElementById('lb-comment-btn').classList.toggle('liked', commentsVisible);
    if(commentsVisible) renderComments();
}

function renderComments() {
    const p   = PROJECTS[lbIdx];
    const pid = p.id;
    // Merge stored + demo comments
    const stored = getStoredComments(pid);
    const demo   = ALL_COMMENTS.filter(c => parseInt(c.project_id) === parseInt(pid));
    const all    = [...demo, ...stored].sort((a,b) => new Date(a.created_at) - new Date(b.created_at));

    const list = document.getElementById('comments-list');
    list.innerHTML = all.length === 0
        ? '<p style="font-size:10px;color:rgba(255,255,255,.2);text-align:center;padding:12px 0">Aucun commentaire — sois le premier !</p>'
        : all.map(c => `
            <div class="comment-item">
                <div class="comment-avatar">${c.author_name.charAt(0).toUpperCase()}</div>
                <div>
                    <div style="font-size:9px;font-weight:900;text-transform:uppercase;letter-spacing:.1em;margin-bottom:3px">${escHtml(c.author_name)}</div>
                    <div style="font-size:11px;color:rgba(255,255,255,.55);line-height:1.5">${escHtml(c.content)}</div>
                </div>
            </div>`).join('');
    document.getElementById('lb-comment-count').textContent = all.length;
}

function getStoredComments(pid) {
    try { return JSON.parse(localStorage.getItem('lf_comments_'+pid)||'[]'); } catch(e){ return []; }
}

function submitComment() {
    const name    = document.getElementById('comment-name').value.trim();
    const content = document.getElementById('comment-content').value.trim();
    if(!name || !content) return;
    const p   = PROJECTS[lbIdx];
    const pid = p.id;
    const comment = {
        id: Date.now(), project_id: pid,
        author_name: name, content: content,
        created_at: new Date().toISOString()
    };
    // Save locally
    const stored = getStoredComments(pid);
    stored.push(comment);
    localStorage.setItem('lf_comments_'+pid, JSON.stringify(stored));
    // Try to save to server
    fetch('add_comment.php', {
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body: JSON.stringify({project_id:pid, author_name:name, content:content})
    }).catch(()=>{});
    document.getElementById('comment-name').value = '';
    document.getElementById('comment-content').value = '';
    renderComments();
}

function escHtml(t) {
    return (t||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

// ===== LIGHTBOX =====
function openLightbox(idx) {
    lbIdx = idx;
    renderLightbox();
    document.getElementById('lightbox').classList.add('active');
    document.body.style.overflow = 'hidden';
    commentsVisible = false;
    document.getElementById('comments-panel').style.display = 'none';
}

function renderLightbox() {
    const p   = PROJECTS[lbIdx];
    const pid = p.id;
    const med = document.getElementById('lb-media');

    document.getElementById('lb-spinner').style.display = 'block';
    med.querySelectorAll(':not(#lb-spinner)').forEach(el=>el.remove());

    document.getElementById('lb-title').textContent   = p.title   || '';
    document.getElementById('lb-cat').textContent     = p.category|| '';
    document.getElementById('lb-counter').textContent = (lbIdx+1) + ' / ' + PROJECTS.length;
    updateLikeUI(pid);

    // Count comments
    const stored = getStoredComments(pid);
    const demo   = ALL_COMMENTS.filter(c => parseInt(c.project_id) === parseInt(pid));
    document.getElementById('lb-comment-count').textContent = stored.length + demo.length;

    const type  = p.type || 'photo';
    const embed = p.video_embed || '';
    const media = (p.media_path||'').split(',').map(s=>s.trim()).filter(Boolean);

    if(type === 'video' && embed) {
        const iframe = document.createElement('iframe');
        iframe.src  = embed + '?autoplay=1&rel=0';
        iframe.allow = 'autoplay; fullscreen';
        iframe.style.cssText = 'width:100%;height:100%;border:none';
        iframe.onload = () => { document.getElementById('lb-spinner').style.display='none'; };
        med.appendChild(iframe);
    } else if(media.length > 0 && media[0].endsWith('.mp4')) {
        const vid = document.createElement('video');
        vid.src = media[0]; vid.autoplay = true; vid.controls = true; vid.loop = true;
        vid.style.cssText = 'max-width:100%;max-height:100%';
        vid.onloadeddata = () => { document.getElementById('lb-spinner').style.display='none'; };
        med.appendChild(vid);
    } else {
        const img = document.createElement('img');
        img.src = media.length > 0 ? media[0] : p.thumbnail_path;
        img.alt = p.title||'';
        img.style.cssText = 'max-width:100%;max-height:100%;object-fit:contain';
        img.onload = () => { document.getElementById('lb-spinner').style.display='none'; };
        med.appendChild(img);
    }

    if(commentsVisible) renderComments();
}

function closeLightbox() {
    const lb = document.getElementById('lightbox');
    lb.classList.remove('active');
    document.getElementById('lb-media').querySelectorAll('video,iframe').forEach(el=>el.remove());
    document.body.style.overflow = 'auto';
}
function lbNext() { lbIdx = (lbIdx+1) % PROJECTS.length; renderLightbox(); }
function lbPrev() { lbIdx = (lbIdx-1+PROJECTS.length) % PROJECTS.length; renderLightbox(); }

function shareProject() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        const btn = event.currentTarget;
        const orig = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i> Copié !';
        setTimeout(()=>btn.innerHTML=orig, 2000);
    });
}

// Keyboard
window.addEventListener('keydown', e => {
    if(!document.getElementById('lightbox').classList.contains('active')) return;
    if(e.key==='Escape')     closeLightbox();
    if(e.key==='ArrowRight') lbNext();
    if(e.key==='ArrowLeft')  lbPrev();
});
</script>
</body>
</html>
