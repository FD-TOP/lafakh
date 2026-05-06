<?php 
require 'db.php';
$projects = [];
try {
    if ($pdo) {
        $query = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC");
        $projects = $query->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (\Throwable $e) {
    $projects = [];
}

$demo_projects = [
    ['id'=>1,'title'=>'REEL 2026','category'=>'Showreel','thumbnail_path'=>'https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?q=80&w=800','media_path'=>'','external_link'=>''],
    ['id'=>2,'title'=>'URBAN CULTURE','category'=>'Vlog','thumbnail_path'=>'https://images.unsplash.com/photo-1444723121867-7a241cacace9?q=80&w=800','media_path'=>'','external_link'=>''],
    ['id'=>3,'title'=>'GOLDEN HOUR','category'=>'Cinéma','thumbnail_path'=>'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?q=80&w=800','media_path'=>'','external_link'=>''],
    ['id'=>4,'title'=>'TRAVEL DOCUMENTARY','category'=>'Documentaire','thumbnail_path'=>'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?q=80&w=800','media_path'=>'','external_link'=>''],
    ['id'=>5,'title'=>'BRAND CAMPAIGN','category'=>'Publicité','thumbnail_path'=>'https://images.unsplash.com/photo-1611532736597-de2d4265fba3?q=80&w=800','media_path'=>'','external_link'=>''],
    ['id'=>6,'title'=>'NEON PORTRAITS','category'=>'Portrait','thumbnail_path'=>'https://images.unsplash.com/photo-1514565131-fce0801e6175?q=80&w=800','media_path'=>'','external_link'=>''],
    ['id'=>7,'title'=>'DESERT ROAD TRIP','category'=>'Vlog','thumbnail_path'=>'https://images.unsplash.com/photo-1509316785289-025f5b846b35?q=80&w=800','media_path'=>'','external_link'=>''],
    ['id'=>8,'title'=>'MONOCHROME CITY','category'=>'Cinéma','thumbnail_path'=>'https://images.unsplash.com/photo-1500281781950-6cd80847ebcd?q=80&w=800','media_path'=>'','external_link'=>''],
    ['id'=>9,'title'=>'MUSIC VIDEO','category'=>'Clip','thumbnail_path'=>'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=800','media_path'=>'','external_link'=>''],
    ['id'=>10,'title'=>'LIFESTYLE SERIES','category'=>'Vlog','thumbnail_path'=>'https://images.unsplash.com/photo-1682687982501-1e58ab814714?q=80&w=800','media_path'=>'','external_link'=>''],
    ['id'=>11,'title'=>'FILM EMULATION','category'=>'Cinéma','thumbnail_path'=>'https://images.unsplash.com/photo-1501854140801-50d01698950b?q=80&w=800','media_path'=>'','external_link'=>''],
    ['id'=>12,'title'=>'CORPORATE REIMS','category'=>'Institutionnel','thumbnail_path'=>'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?q=80&w=800','media_path'=>'','external_link'=>''],
];
$projects = !empty($projects) ? $projects : $demo_projects;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LA FAKH | Portfolio</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;900&family=Space+Grotesk:wght@300;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body { font-family: 'Space Grotesk', sans-serif; background-color: #000; color: #fff; margin: 0; overflow-x: hidden; }
        .brutal-text { font-family: 'Inter', sans-serif; text-transform: uppercase; font-style: italic; }

        /* --- BURGER --- */
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

        /* --- FILTRES --- */
        .filter-btn {
            font-size: 9px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.25em;
            padding: 8px 20px; border: 1px solid rgba(255,255,255,0.15);
            color: rgba(255,255,255,0.4); cursor: pointer; transition: all 0.3s ease;
            background: transparent;
        }
        .filter-btn:hover { border-color: rgba(255,255,255,0.6); color: rgba(255,255,255,0.8); }
        .filter-btn.active { border-color: #fff; color: #fff; background: rgba(255,255,255,0.05); }

        /* --- GRILLE PROJETS --- */
        .projects-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        @media (min-width: 1024px) {
            .projects-grid { grid-template-columns: repeat(3, 1fr); gap: 16px; }
        }

        .item-project {
            aspect-ratio: 16 / 9;
            position: relative;
            background: #0d0d0d;
            overflow: hidden;
            cursor: pointer;
        }
        .item-project img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform 0.7s cubic-bezier(0.16, 1, 0.3, 1), filter 0.6s ease;
        }
        .item-project .overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.2) 50%, transparent 100%);
            display: flex; flex-direction: column; align-items: flex-start; justify-content: flex-end;
            padding: 20px; opacity: 0; transition: opacity 0.4s ease; z-index: 10;
        }
        .item-project .project-name {
            font-family: 'Inter', sans-serif; font-weight: 900; font-style: italic;
            text-transform: uppercase; font-size: 13px; letter-spacing: 2px;
            transform: translateY(8px); transition: transform 0.4s ease;
        }
        .item-project .project-tag {
            font-size: 9px; text-transform: uppercase; letter-spacing: 0.2em;
            color: rgba(255,255,255,0.5); margin-bottom: 6px;
            transform: translateY(8px); transition: transform 0.4s ease 0.05s;
        }
        .item-project:hover img { filter: blur(4px) brightness(0.7); transform: scale(1.08); }
        .item-project:hover .overlay { opacity: 1; }
        .item-project:hover .project-name,
        .item-project:hover .project-tag { transform: translateY(0); }

        /* Numéro de projet */
        .item-project .project-num {
            position: absolute; top: 16px; right: 16px;
            font-size: 9px; font-weight: 900; color: rgba(255,255,255,0.2);
            font-family: 'Inter', sans-serif; letter-spacing: 0.1em; z-index: 11;
            transition: color 0.4s;
        }
        .item-project:hover .project-num { color: rgba(255,255,255,0.7); }

        /* Animation entrée scroll */
        .item-project {
            opacity: 0; transform: translateY(30px);
            transition: opacity 0.7s ease, transform 0.7s ease, filter 0.6s ease;
        }
        .item-project.visible { opacity: 1; transform: translateY(0); }

        /* MASQUER éléments filtrés */
        .item-project.hidden-item {
            opacity: 0 !important; transform: scale(0.95) !important;
            pointer-events: none; position: absolute; visibility: hidden;
        }

        /* --- LIGHTBOX --- */
        #lightbox {
            display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.97); z-index: 9999;
            flex-direction: column; align-items: center; justify-content: center;
        }
        #lightbox.active { display: flex; }
        #media-holder { 
            width: 100%; height: calc(100vh - 100px);
            display: flex; align-items: center; justify-content: center; 
            padding: 0 80px;
        }
        #media-holder img, #media-holder video { 
            max-width: 100%; max-height: 100%; object-fit: contain; 
            border-radius: 2px;
        }

        .nav-arrow { 
            position: absolute; top: 50%; transform: translateY(-50%);
            font-size: 22px; opacity: 0.2; cursor: pointer; transition: 0.3s; padding: 30px; z-index: 100;
        }
        .nav-arrow:hover { opacity: 1; }

        /* Info bar lightbox */
        #lb-infobar {
            position: absolute; bottom: 0; left: 0; right: 0;
            background: rgba(0,0,0,0.9);
            border-top: 1px solid rgba(255,255,255,0.06);
            padding: 14px 30px;
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 12px;
        }
        #lb-title { font-family: 'Inter', sans-serif; font-weight: 900; font-style: italic; text-transform: uppercase; font-size: 12px; letter-spacing: 2px; }

        /* Loading overlay */
        #lb-loading {
            position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;
            background: #000; z-index: 50; opacity: 0; pointer-events: none; transition: opacity 0.3s;
        }
        #lb-loading.show { opacity: 1; pointer-events: auto; }
        .spinner { width: 30px; height: 30px; border: 2px solid rgba(255,255,255,0.1); border-top-color: #fff; border-radius: 50%; animation: spin 0.8s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* Footer */
        html, body { height: 100%; margin: 0; }
        body { display: flex; flex-direction: column; }
        main { flex: 1 0 auto; margin-bottom: 60px; }
        footer { flex-shrink: 0; background-color: #000; border-top: 1px solid rgba(255,255,255,0.05); }
        .footer-link { font-size: 10px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.2em; color: #666; transition: 0.3s; }
        .footer-link:hover { color: #fff; padding-left: 5px; }
    </style>
</head>
<body>

    <header class="flex justify-between items-center px-10 h-24 sticky top-0 bg-black/80 backdrop-blur-md z-[110]">
        <a href="index.php">
            <img src="logo.png" alt="Logo" class="h-8 md:h-10 w-auto">
        </a>
        <nav class="hidden md:flex gap-10 text-[10px] font-bold uppercase tracking-[0.2em]">
            <a href="index.php" class="opacity-50 hover:opacity-100 transition">Accueil</a>
            <a href="portfolio.php" class="border-b border-white pb-1">Portfolio</a>
            <a href="shop.php" class="opacity-50 hover:opacity-100 transition">Shop</a>
            <a href="contact.php" class="opacity-50 hover:opacity-100 transition">Contact</a>
            <a href="a-propos.php" class="opacity-50 hover:opacity-100 transition">À Propos</a>
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

    <main class="text-center py-20 px-6">
        <!-- HERO TITRE -->
        <h1 class="text-3xl md:text-6xl font-black brutal-text mb-4">PORTFOLIO</h1>
        <p class="text-zinc-500 text-sm max-w-2xl mx-auto mb-12">
            Depuis 2019, nous créons des contenus percutants pour marques et artistes — du vlog lifestyle aux productions institutionnelles.
        </p>

        <!-- FILTRES CATÉGORIES -->
        <?php
        $categories = array_unique(array_filter(array_map(function($p) {
            return trim($p['category'] ?? '');
        }, $projects)));
        ?>
        <?php if(!empty($categories)): ?>
        <div class="flex flex-wrap justify-center gap-3 mb-16" id="filter-bar">
            <button class="filter-btn active" data-filter="all">Tout</button>
            <?php foreach($categories as $cat): ?>
            <button class="filter-btn" data-filter="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></button>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="mb-16"></div>
        <?php endif; ?>

        <!-- GRILLE -->
        <div class="max-w-7xl mx-auto">
            <div class="projects-grid" id="projects-grid">
                <?php foreach ($projects as $index => $p): ?>
                <div class="item-project" 
                     data-category="<?= htmlspecialchars($p['category'] ?? '') ?>"
                     onclick="openLightbox(<?= $index ?>)">
                    <span class="project-num"><?= str_pad($index + 1, 2, '0', STR_PAD_LEFT) ?></span>
                    <img src="<?= htmlspecialchars($p['thumbnail_path']) ?>" alt="<?= htmlspecialchars($p['title']) ?>" loading="lazy">
                    <div class="overlay">
                        <?php if(!empty($p['category'])): ?>
                        <span class="project-tag"><?= htmlspecialchars($p['category']) ?></span>
                        <?php endif; ?>
                        <span class="project-name"><?= htmlspecialchars($p['title']) ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php if(empty($projects)): ?>
                <div class="col-span-2 lg:col-span-3 text-center py-32 text-zinc-600">
                    <i class="fas fa-film text-4xl mb-4 block opacity-20"></i>
                    <p class="text-sm uppercase tracking-widest">Aucun projet pour le moment</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- LIGHTBOX -->
    <div id="lightbox">
        <div id="lb-loading"><div class="spinner"></div></div>
        
        <div class="absolute top-6 right-6 z-[200] cursor-pointer w-10 h-10 flex items-center justify-center border border-white/20 hover:border-white transition" onclick="closeLightbox()">
            <i class="fas fa-times text-sm"></i>
        </div>
        
        <div class="nav-arrow left-0" onclick="prev()"><i class="fas fa-chevron-left"></i></div>
        <div class="nav-arrow right-0" onclick="next()"><i class="fas fa-chevron-right"></i></div>

        <div id="media-holder"></div>

        <div id="lb-infobar">
            <div class="flex items-center gap-6">
                <span id="lb-title"></span>
                <span id="lb-counter" class="text-[9px] font-mono opacity-30"></span>
            </div>
            <div class="flex items-center gap-4">
                <button onclick="toggleLike(this)" class="text-[9px] font-black uppercase flex items-center gap-2 opacity-40 hover:opacity-100 hover:text-red-400 transition">
                    <i class="far fa-heart"></i> Like
                </button>
                <button onclick="shareProject()" class="text-[9px] font-black uppercase flex items-center gap-2 opacity-40 hover:opacity-100 hover:text-blue-400 transition">
                    <i class="fas fa-share-alt"></i> Partager
                </button>
                <a href="#" id="lb-link" target="_blank" class="bg-white text-black px-5 py-2 text-[9px] font-black uppercase tracking-widest hover:bg-zinc-200 transition" style="display:none;">
                    Watch ↗
                </a>
            </div>
        </div>
    </div>

    <footer>
        <div class="max-w-7xl mx-auto px-6 py-20">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-20">
                <div class="md:col-span-1">
                    <div class="text-xl font-black brutal-text mb-6">LA FAKH</div>
                    <p class="text-[10px] text-zinc-500 uppercase tracking-widest leading-relaxed">
                        Production audiovisuelle basée à Reims. Nous transformons vos idées en expériences visuelles mémorables.
                    </p>
                </div>
                <div>
                    <h4 class="text-[9px] font-black uppercase tracking-[0.4em] text-white/30 mb-8">Services</h4>
                    <ul class="space-y-4">
                        <li class="footer-link cursor-default">Vlog & Lifestyle</li>
                        <li class="footer-link cursor-default">Institutionnel</li>
                        <li class="footer-link cursor-default">Publicité Digitale</li>
                        <li class="footer-link cursor-default">Post-Production</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-[9px] font-black uppercase tracking-[0.4em] text-white/30 mb-8">Studio</h4>
                    <ul class="space-y-4">
                        <li><a href="portfolio.php" class="footer-link">Portfolio</a></li>
                        <li><a href="a-propos.php" class="footer-link">L'Agence</a></li>
                        <li><a href="contact.php" class="footer-link">Contact</a></li>
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
                <div class="text-[8px] uppercase tracking-[0.5em] text-zinc-700">© 2026 LA FAKH STUDIO — DESIGNED FOR EXCELLENCE</div>
                <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="text-[8px] uppercase tracking-[0.3em] text-zinc-500 hover:text-white transition group flex items-center">
                    BACK TO TOP <i class="fas fa-arrow-up ml-3 group-hover:-translate-y-1 transition"></i>
                </button>
            </div>
        </div>
    </footer>

    <script>
    // --- MENU BURGER ---
    document.addEventListener('DOMContentLoaded', function() {
        const burgerBtn = document.getElementById('burger-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        burgerBtn.addEventListener('click', () => {
            burgerBtn.classList.toggle('open');
            mobileMenu.classList.toggle('open');
            document.body.style.overflow = mobileMenu.classList.contains('open') ? 'hidden' : 'auto';
        });
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                burgerBtn.classList.remove('open');
                mobileMenu.classList.remove('open');
                document.body.style.overflow = 'auto';
            });
        });
    });

    // --- SCROLL ANIMATIONS ---
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, i) => {
            if (entry.isIntersecting) {
                setTimeout(() => entry.target.classList.add('visible'), i * 80);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.item-project').forEach(el => observer.observe(el));

    // --- FILTRES CATÉGORIES ---
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const filter = this.dataset.filter;
            
            const grid = document.getElementById('projects-grid');
            grid.style.position = 'relative';

            document.querySelectorAll('.item-project').forEach(item => {
                const cat = item.dataset.category;
                if (filter === 'all' || cat === filter) {
                    item.style.display = '';
                    item.style.position = '';
                    item.style.visibility = '';
                    setTimeout(() => item.classList.add('visible'), 50);
                } else {
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.95)';
                    setTimeout(() => { item.style.display = 'none'; }, 400);
                }
            });
        });
    });

    // --- LIGHTBOX ---
    const projects = <?= json_encode($projects) ?>;
    let currentIdx = 0;
    let currentSubIdx = 0;

    function openLightbox(idx) {
        currentIdx = idx;
        currentSubIdx = 0;
        render();
        document.getElementById('lightbox').classList.add('active');
        document.body.style.overflow = "hidden";
    }

    function render() {
        const p = projects[currentIdx];
        const holder = document.getElementById('media-holder');
        const loading = document.getElementById('lb-loading');
        const counter = document.getElementById('lb-counter');
        const titleEl = document.getElementById('lb-title');
        const link = document.getElementById('lb-link');

        const allMedias = p.media_path ? p.media_path.split(',').filter(m => m.trim() !== "") : [];
        const totalSubMedias = allMedias.length;
        if (currentSubIdx >= totalSubMedias) currentSubIdx = 0;
        const currentMedia = allMedias.length > 0 ? allMedias[currentSubIdx].trim() : p.thumbnail_path;

        titleEl.textContent = p.title || '';
        counter.textContent = totalSubMedias > 1 ? `${currentSubIdx + 1} / ${totalSubMedias}` : '';
        
        if(p.external_link && p.external_link !== '') {
            link.href = p.external_link; link.style.display = 'block';
        } else {
            link.style.display = 'none';
        }

        loading.classList.add('show');
        holder.innerHTML = '';

        if(currentMedia.toLowerCase().endsWith('.mp4')) {
            const vid = document.createElement('video');
            vid.src = currentMedia; vid.autoplay = true; vid.controls = true; vid.loop = true;
            vid.style.maxWidth = '100%'; vid.style.maxHeight = '100%';
            vid.addEventListener('loadeddata', () => loading.classList.remove('show'));
            holder.appendChild(vid);
        } else {
            const img = document.createElement('img');
            img.src = currentMedia; img.alt = p.title || 'View';
            img.style.maxWidth = '100%'; img.style.maxHeight = '100%'; img.style.objectFit = 'contain';
            img.addEventListener('load', () => loading.classList.remove('show'));
            holder.appendChild(img);
        }
    }

    function next() {
        const p = projects[currentIdx];
        const allMedias = p.media_path ? p.media_path.split(',').filter(m => m.trim() !== "") : [];
        if (currentSubIdx < allMedias.length - 1) { currentSubIdx++; }
        else { currentIdx = (currentIdx + 1) % projects.length; currentSubIdx = 0; }
        render();
    }

    function prev() {
        if (currentSubIdx > 0) { currentSubIdx--; }
        else {
            currentIdx = (currentIdx - 1 + projects.length) % projects.length;
            const prevP = projects[currentIdx];
            const prevMedias = prevP.media_path ? prevP.media_path.split(',').filter(m => m.trim() !== "") : [];
            currentSubIdx = Math.max(prevMedias.length - 1, 0);
        }
        render();
    }

    function closeLightbox() {
        document.getElementById('lightbox').classList.remove('active');
        document.getElementById('media-holder').innerHTML = "";
        document.body.style.overflow = "auto";
    }

    function toggleLike(btn) {
        const icon = btn.querySelector('i');
        icon.classList.toggle('fas'); icon.classList.toggle('far');
        btn.classList.toggle('text-red-400');
        btn.classList.toggle('opacity-40');
    }

    function shareProject() {
        navigator.clipboard.writeText(window.location.href).then(() => {
            const btn = event.currentTarget;
            const orig = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check"></i> Copié !';
            setTimeout(() => btn.innerHTML = orig, 2000);
        });
    }

    window.onkeydown = (e) => {
        if(!document.getElementById('lightbox').classList.contains('active')) return;
        if(e.key === "Escape") closeLightbox();
        if(e.key === "ArrowRight") next();
        if(e.key === "ArrowLeft") prev();
    };
    </script>
</body>
</html>
