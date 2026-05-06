<?php 
require_once 'db.php'; 
$site_name = "LA FAKH"; 
?>
<!DOCTYPE html>
<html lang="fr" class="bg-black">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_name; ?> | Portfolio Audiovisuel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@900&family=Space+Grotesk:wght@300;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Space Grotesk', sans-serif; background: #000; color: #fff; margin: 0; overflow: hidden; user-select: none; cursor: none; }
        .brutal-text { font-family: 'Inter', sans-serif; text-transform: uppercase; letter-spacing: -0.03em; }

        /* CURSOR */
        #cursor { width: 10px; height: 10px; background: #fff; border-radius: 50%; position: fixed; pointer-events: none; z-index: 99999; transform: translate(-50%,-50%); mix-blend-mode: difference; transition: width .25s, height .25s; }
        #cursor-ring { width: 36px; height: 36px; border: 1px solid rgba(255,255,255,.4); border-radius: 50%; position: fixed; pointer-events: none; z-index: 99998; transform: translate(-50%,-50%); transition: left .1s ease, top .1s ease, width .3s, height .3s; }
        #cursor.big { width: 48px; height: 48px; }
        #cursor-ring.big { width: 64px; height: 64px; opacity: .3; }

        /* PRELOADER */
        #preloader { position: fixed; inset: 0; background: #000; z-index: 9999; display: flex; align-items: center; justify-content: center; }
        #preloader.out { opacity: 0; visibility: hidden; transition: opacity .8s ease, visibility .8s; }
        .loader-logo { width: 140px; opacity: 0; animation: logoIn 1.8s cubic-bezier(.3,0,.1,1) forwards; }
        @keyframes logoIn { 0%{opacity:0;transform:scale(.5);filter:blur(12px)} 100%{opacity:1;transform:scale(1.08);filter:blur(0)} }

        /* SLIDES */
        .slide { position: absolute; inset: 0; z-index: 5; opacity: 0; transition: opacity 1.2s ease; pointer-events: none; }
        .slide.active { opacity: 1; z-index: 10; pointer-events: auto; }
        .slide.leaving { opacity: 0; z-index: 8; }

        /* PHOTO BACKGROUND */
        .slide-bg {
            position: absolute; inset: 0;
            background-size: cover; background-position: center;
            transform: scale(1); transition: transform 7s ease;
        }
        .slide.active .slide-bg { transform: scale(1.07); }

        /* VIDEO */
        .slide-video {
            position: absolute; inset: 0;
            width: 100%; height: 100%; object-fit: cover;
        }

        /* OVERLAY */
        .slide-overlay { position: absolute; inset: 0; background: rgba(0,0,0,.38); z-index: 2; }

        /* CONTENT */
        .slide-content {
            position: absolute; inset: 0; z-index: 20;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            text-align: center; padding: 24px;
        }

        /* TEXT ANIMATIONS */
        .anim-up {
            opacity: 0; transform: translateY(32px);
            transition: opacity .9s ease, transform .9s ease;
        }
        .slide.active .anim-up { opacity: 1; transform: translateY(0); }
        .slide.active .anim-up:nth-child(1) { transition-delay: .2s; }
        .slide.active .anim-up:nth-child(2) { transition-delay: .4s; }
        .slide.active .anim-up:nth-child(3) { transition-delay: .6s; }

        /* CTA */
        .cta-btn {
            display: inline-block; padding: 16px 44px;
            border: 1.5px solid rgba(255,255,255,.8);
            font-weight: 900; font-size: 10px; letter-spacing: .3em;
            text-transform: uppercase; font-family: 'Inter', sans-serif;
            position: relative; overflow: hidden; transition: color .4s;
            cursor: none; pointer-events: auto;
        }
        .cta-btn::before { content:''; position:absolute; inset:0; background:#fff; transform:translateX(-101%); transition:transform .4s cubic-bezier(.16,1,.3,1); }
        .cta-btn:hover::before { transform:translateX(0); }
        .cta-btn:hover { color:#000; }
        .cta-btn span { position:relative; z-index:1; }

        /* SLIDE TYPE INDICATOR */
        #slide-type {
            position: fixed; top: 50%; left: 50%; transform: translate(-50%,-50%);
            font-size: 8px; font-weight: 900; font-family: 'Inter'; text-transform: uppercase;
            letter-spacing: .4em; color: rgba(255,255,255,0);
            pointer-events: none; z-index: 200;
            transition: color .3s, opacity .3s;
        }

        /* NAVIGATION DOTS */
        #slide-nav {
            position: fixed; bottom: 32px; left: 50%; transform: translateX(-50%);
            z-index: 120; display: flex; align-items: center; gap: 8px;
        }
        .nav-dot {
            width: 5px; height: 5px; border-radius: 50%;
            background: rgba(255,255,255,.25); cursor: none;
            transition: all .4s ease; flex-shrink: 0;
        }
        .nav-dot.active { background: #fff; width: 24px; border-radius: 3px; }
        .nav-dot.video-dot { border: 1px solid rgba(255,255,255,.4); background: transparent; }
        .nav-dot.video-dot.active { background: #fff; border-color: #fff; }

        /* PROGRESS BAR */
        #progress-bar { position: fixed; bottom: 0; left: 0; height: 2px; background: rgba(255,255,255,.8); z-index: 130; width: 0%; }

        /* COUNTER */
        #slide-counter { position: fixed; bottom: 56px; right: 28px; z-index: 120; font-size: 9px; font-weight: 900; font-family:'Inter'; color:rgba(255,255,255,.3); letter-spacing:.15em; }

        /* SLIDE TYPE TAG (photo / video) */
        .type-tag {
            position: fixed; top: 50%; right: 28px; transform: translateY(-50%);
            z-index: 120; writing-mode: vertical-lr;
            font-size: 7px; font-weight: 900; text-transform: uppercase;
            letter-spacing: .3em; color: rgba(255,255,255,.2);
            font-family: 'Inter'; display: flex; flex-direction: column;
            align-items: center; gap: 8px;
        }
        .type-icon { font-size: 14px; color: rgba(255,255,255,.25); transition: color .4s; }
        .type-icon.active-icon { color: rgba(255,255,255,.8); }

        /* SOCIAL */
        .social-sidebar { position:fixed; left:22px; top:50%; transform:translateY(-50%); display:flex; flex-direction:column; gap:100px; z-index:50; }
        .social-block { display:flex; align-items:center; gap:12px; transform:rotate(-90deg); transform-origin:left center; white-space:nowrap; }
        .social-name { font-size:.65rem; text-transform:lowercase; letter-spacing:.2em; color:rgba(255,255,255,.3); transition:color .3s; }
        .social-block:hover .social-name { color:#fff; }

        /* ARROWS */
        .nav-arrow {
            position: fixed; top: 50%; transform: translateY(-50%);
            z-index: 120; width: 44px; height: 44px;
            display: flex; align-items: center; justify-content: center;
            border: 1px solid rgba(255,255,255,.12);
            color: rgba(255,255,255,.3); cursor: none;
            transition: border-color .3s, color .3s, background .3s;
        }
        .nav-arrow:hover { border-color: rgba(255,255,255,.6); color: #fff; background: rgba(255,255,255,.06); }
        #arrow-prev { left: 20px; }
        #arrow-next { right: 20px; }

        /* MOBILE MENU */
        #mobile-menu { position:fixed; inset:0; background:#000; z-index:105; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:2rem; font-size:2rem; font-weight:bold; text-transform:uppercase; transform:translateX(100%); transition:transform .5s cubic-bezier(.77,.2,.05,1); }
        #mobile-menu.open { transform:translateX(0); }
        #mobile-menu a { font-family:'Inter'; font-style:italic; }
        .burger-line { width:24px; height:2px; background:white; transition:.3s; }
        .open .line1 { transform:rotate(45deg) translate(5px,5px); }
        .open .line2 { opacity:0; }
        .open .line3 { transform:rotate(-45deg) translate(7px,-6px); }
    </style>
</head>
<body onmousedown="swipeStart(event)" onmouseup="swipeEnd(event)" ontouchstart="swipeStart(event)" ontouchend="swipeEnd(event)">

    <div id="cursor"></div>
    <div id="cursor-ring"></div>

    <!-- PRELOADER -->
    <div id="preloader">
        <img src="logo.png" alt="LA FAKH" class="loader-logo">
    </div>

    <!-- HEADER -->
    <header class="fixed top-0 w-full z-[110] px-6 md:px-10 h-24 flex justify-between items-center pointer-events-none">
        <a href="index.php" class="pointer-events-auto">
            <img src="logo.png" alt="Logo" class="h-8 md:h-10 w-auto">
        </a>
        <nav class="hidden md:flex space-x-10 text-[10px] font-bold uppercase tracking-[.3em] pointer-events-auto">
            <a href="index.php"     class="border-b border-white pb-1">Accueil</a>
            <a href="portfolio.php" class="opacity-50 hover:opacity-100 transition">Portfolio</a>
            <a href="shop.php"      class="opacity-50 hover:opacity-100 transition">Shop</a>
            <a href="contact.php"   class="opacity-50 hover:opacity-100 transition">Contact</a>
            <a href="a-propos.php"  class="opacity-50 hover:opacity-100 transition">À Propos</a>
        </nav>
        <button id="burger-btn" class="md:hidden flex flex-col gap-1.5 pointer-events-auto p-4 z-[120]">
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

    <!-- SOCIAL -->
    <div class="social-sidebar hidden md:flex">
        <div class="social-block"><a href="#" class="pointer-events-auto"><i class="fab fa-tiktok text-white/40 hover:text-white transition"></i></a><span class="social-name">tiktok</span></div>
        <div class="social-block"><a href="#" class="pointer-events-auto"><i class="fab fa-instagram text-white/40 hover:text-white transition"></i></a><span class="social-name">instagram</span></div>
        <div class="social-block"><a href="#" class="pointer-events-auto"><i class="fab fa-vimeo-v text-white/40 hover:text-white transition"></i></a><span class="social-name">vimeo</span></div>
    </div>

    <!-- ARROWS -->
    <button class="nav-arrow pointer-events-auto" id="arrow-prev" onclick="prev()"><i class="fas fa-chevron-left text-xs"></i></button>
    <button class="nav-arrow pointer-events-auto" id="arrow-next" onclick="next()"><i class="fas fa-chevron-right text-xs"></i></button>

    <!-- TYPE TAG (photo/video indicator) -->
    <div class="type-tag hidden md:flex" id="type-tag">
        <i class="fas fa-film type-icon" id="icon-video"></i>
        <i class="fas fa-image type-icon" id="icon-photo"></i>
    </div>

    <!-- COUNTER -->
    <div id="slide-counter">01 / 07</div>

    <!-- =================== SLIDES =================== -->
    <main class="relative h-screen w-full overflow-hidden">

        <!-- SLIDE 1 — VIDÉO logofakh.mp4 (intro) -->
        <div class="slide active" data-type="video" data-index="0">
            <video class="slide-video" src="logofakh.mp4" autoplay muted playsinline></video>
            <div class="slide-overlay"></div>
            <div class="slide-content">
                <div class="text-[8px] font-black uppercase tracking-[.5em] text-white/40 mb-6 anim-up">Production Audiovisuelle · Reims</div>
                <h1 class="text-[60px] md:text-[120px] font-black brutal-text leading-none mb-10 anim-up">LA FAKH.</h1>
                <div class="anim-up">
                    <a href="portfolio.php" class="cta-btn"><span>Découvrir →</span></a>
                </div>
            </div>
        </div>

        <!-- SLIDE 2 — PHOTO -->
        <div class="slide" data-type="photo" data-index="1">
            <div class="slide-bg" style="background-image:url('https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?q=80&w=1920');"></div>
            <div class="slide-overlay"></div>
            <div class="slide-content">
                <h2 class="text-[55px] md:text-[110px] font-black brutal-text leading-none mb-10 anim-up">CRÉATIVITÉ<br>PURE.</h2>
                <div class="anim-up">
                    <a href="portfolio.php" class="cta-btn"><span>Voir le Portfolio</span></a>
                </div>
            </div>
        </div>

        <!-- SLIDE 3 — VIDÉO Ve1.mp4 -->
        <div class="slide" data-type="video" data-index="2">
            <video class="slide-video" src="Ve1.mp4" muted playsinline></video>
            <div class="slide-overlay"></div>
            <div class="slide-content">
                <h2 class="text-[55px] md:text-[110px] font-black brutal-text leading-none mb-10 anim-up">NOS<br>RÉALISATIONS.</h2>
                <div class="anim-up">
                    <a href="portfolio.php" class="cta-btn"><span>Voir le Portfolio</span></a>
                </div>
            </div>
        </div>

        <!-- SLIDE 4 — PHOTO -->
        <div class="slide" data-type="photo" data-index="3">
            <div class="slide-bg" style="background-image:url('https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?q=80&w=1920');"></div>
            <div class="slide-overlay"></div>
            <div class="slide-content">
                <h2 class="text-[55px] md:text-[110px] font-black brutal-text leading-none mb-10 anim-up">VOS<br>PRESETS.</h2>
                <div class="anim-up">
                    <a href="shop.php" class="cta-btn"><span>Découvrir le Shop</span></a>
                </div>
            </div>
        </div>

        <!-- SLIDE 5 — VIDÉO Ve2.mp4 -->
        <div class="slide" data-type="video" data-index="4">
            <video class="slide-video" src="Ve2.mp4" muted playsinline></video>
            <div class="slide-overlay"></div>
            <div class="slide-content">
                <h2 class="text-[55px] md:text-[110px] font-black brutal-text leading-none mb-10 anim-up">CHAQUE<br>INSTANT.</h2>
                <div class="anim-up">
                    <a href="portfolio.php" class="cta-btn"><span>Notre Travail</span></a>
                </div>
            </div>
        </div>

        <!-- SLIDE 6 — PHOTO -->
        <div class="slide" data-type="photo" data-index="5">
            <div class="slide-bg" style="background-image:url('https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=1920');"></div>
            <div class="slide-overlay"></div>
            <div class="slide-content">
                <h2 class="text-[55px] md:text-[110px] font-black brutal-text leading-none mb-10 anim-up">PARLONS<br>PROJET.</h2>
                <div class="anim-up">
                    <a href="contact.php" class="cta-btn"><span>Nous Contacter</span></a>
                </div>
            </div>
        </div>

        <!-- SLIDE 7 — VIDÉO Ve3.mp4 -->
        <div class="slide" data-type="video" data-index="6">
            <video class="slide-video" src="Ve3.mp4" muted playsinline></video>
            <div class="slide-overlay"></div>
            <div class="slide-content">
                <h2 class="text-[55px] md:text-[110px] font-black brutal-text leading-none mb-10 anim-up">L'IMAGE<br>AU CŒUR.</h2>
                <div class="anim-up">
                    <a href="a-propos.php" class="cta-btn"><span>À Propos</span></a>
                </div>
            </div>
        </div>

    </main>

    <!-- DOTS NAV -->
    <div id="slide-nav"></div>

    <!-- PROGRESS BAR -->
    <div id="progress-bar"></div>

    <script>
    const SLIDES = Array.from(document.querySelectorAll('.slide'));
    const TOTAL  = SLIDES.length;
    const PHOTO_DURATION = 5500; // ms pour les slides photo

    let current = 0;
    let photoTimer = null;
    let progressRaf = null;
    let progressStart = null;
    let currentDuration = PHOTO_DURATION;
    let swipeX = 0;

    // ====== CURSOR ======
    const cur  = document.getElementById('cursor');
    const ring = document.getElementById('cursor-ring');
    document.addEventListener('mousemove', e => {
        cur.style.left  = e.clientX + 'px'; cur.style.top  = e.clientY + 'px';
        ring.style.left = e.clientX + 'px'; ring.style.top = e.clientY + 'px';
    });
    document.querySelectorAll('a, button, [onclick]').forEach(el => {
        el.addEventListener('mouseenter', () => { cur.classList.add('big'); ring.classList.add('big'); });
        el.addEventListener('mouseleave', () => { cur.classList.remove('big'); ring.classList.remove('big'); });
    });

    // ====== BUILD DOTS ======
    const navEl = document.getElementById('slide-nav');
    SLIDES.forEach((s, i) => {
        const d = document.createElement('div');
        d.className = 'nav-dot' + (s.dataset.type === 'video' ? ' video-dot' : '');
        if (i === 0) d.classList.add('active');
        d.onclick = () => goTo(i);
        navEl.appendChild(d);
    });

    // ====== PRELOADER ======
    window.addEventListener('load', () => {
        setTimeout(() => {
            const p = document.getElementById('preloader');
            p.classList.add('out');
            setTimeout(() => p.style.display = 'none', 800);
            activateSlide(0);
        }, 2000);
    });

    // ====== CORE ACTIVATE ======
    function activateSlide(idx) {
        // Désactiver l'ancien
        SLIDES[current].classList.remove('active');
        SLIDES[current].classList.add('leaving');
        stopVideo(current);
        setTimeout(() => SLIDES[current] && SLIDES[current].classList.remove('leaving'), 1200);

        current = ((idx % TOTAL) + TOTAL) % TOTAL;
        const slide = SLIDES[current];

        // Mettre à jour dots
        document.querySelectorAll('.nav-dot').forEach((d, i) => d.classList.toggle('active', i === current));

        // Compteur
        document.getElementById('slide-counter').textContent =
            String(current + 1).padStart(2, '0') + ' / ' + String(TOTAL).padStart(2, '0');

        // Type indicator
        const isVideo = slide.dataset.type === 'video';
        document.getElementById('icon-video').classList.toggle('active-icon',  isVideo);
        document.getElementById('icon-photo').classList.toggle('active-icon', !isVideo);

        // Activer slide
        slide.classList.add('active');

        if (isVideo) {
            playVideo(current);
        } else {
            startPhotoTimer();
        }
    }

    function playVideo(idx) {
        clearPhotoTimer();
        const vid = SLIDES[idx].querySelector('video');
        if (!vid) { startPhotoTimer(); return; }
        vid.currentTime = 0;
        vid.play().catch(() => {});
        stopProgress();

        // Avancer quand la vidéo se termine (avec fallback 60s max)
        vid.onended = () => next();
        const fallback = setTimeout(() => next(), 60000);
        vid._fallback = fallback;
    }

    function stopVideo(idx) {
        const vid = SLIDES[idx] && SLIDES[idx].querySelector('video');
        if (!vid) return;
        vid.pause();
        vid.onended = null;
        if (vid._fallback) { clearTimeout(vid._fallback); vid._fallback = null; }
        stopProgress();
    }

    function startPhotoTimer() {
        clearPhotoTimer();
        currentDuration = PHOTO_DURATION;
        startProgress(PHOTO_DURATION);
        photoTimer = setTimeout(() => next(), PHOTO_DURATION);
    }

    function clearPhotoTimer() {
        if (photoTimer) { clearTimeout(photoTimer); photoTimer = null; }
        stopProgress();
    }

    // ====== PROGRESS BAR (only for photo slides) ======
    function startProgress(duration) {
        const bar = document.getElementById('progress-bar');
        if (progressRaf) cancelAnimationFrame(progressRaf);
        bar.style.transition = 'none';
        bar.style.width = '0%';
        progressStart = performance.now();
        function tick(ts) {
            const pct = Math.min(((ts - progressStart) / duration) * 100, 100);
            bar.style.width = pct + '%';
            if (pct < 100) progressRaf = requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
    }

    function stopProgress() {
        const bar = document.getElementById('progress-bar');
        if (progressRaf) { cancelAnimationFrame(progressRaf); progressRaf = null; }
        bar.style.width = '0%';
    }

    // ====== NAVIGATION ======
    function next() { activateSlide(current + 1); }
    function prev() { activateSlide(current - 1); }
    function goTo(idx) { activateSlide(idx); }

    // ====== SWIPE ======
    function swipeStart(e) { swipeX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX; }
    function swipeEnd(e) {
        const ex = e.type.includes('mouse') ? e.clientX : e.changedTouches[0].clientX;
        if (Math.abs(swipeX - ex) > 60) swipeX - ex > 0 ? next() : prev();
    }

    // ====== KEYBOARD ======
    document.addEventListener('keydown', e => {
        if (e.key === 'ArrowRight') next();
        if (e.key === 'ArrowLeft')  prev();
    });

    // ====== BURGER ======
    document.getElementById('burger-btn').addEventListener('click', function() {
        this.classList.toggle('open');
        document.getElementById('mobile-menu').classList.toggle('open');
    });
    </script>
</body>
</html>
