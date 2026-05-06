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
        #cursor { width: 10px; height: 10px; background: #fff; border-radius: 50%; position: fixed; pointer-events: none; z-index: 99999; transform: translate(-50%,-50%); transition: width .25s, height .25s; mix-blend-mode: difference; }
        #cursor-ring { width: 36px; height: 36px; border: 1px solid rgba(255,255,255,0.4); border-radius: 50%; position: fixed; pointer-events: none; z-index: 99998; transform: translate(-50%,-50%); transition: left .1s ease, top .1s ease, width .3s, height .3s; }
        #cursor.big { width: 48px; height: 48px; }
        #cursor-ring.big { width: 64px; height: 64px; opacity: .3; }

        /* PRELOADER */
        #preloader { position: fixed; inset: 0; background: #000; z-index: 9999; display: flex; align-items: center; justify-content: center; }
        #preloader.out { opacity: 0; visibility: hidden; transition: opacity .8s ease, visibility .8s; }
        .loader-logo { width: 140px; opacity: 0; animation: logoIn 1.8s cubic-bezier(.3,0,.1,1) forwards; }
        @keyframes logoIn { 0%{opacity:0;transform:scale(.5);filter:blur(12px)} 100%{opacity:1;transform:scale(1.08);filter:blur(0)} }

        /* SLIDES */
        .slide { position: absolute; inset: 0; z-index: 5; opacity: 0; transition: opacity 1s ease; pointer-events: none; }
        .slide.active { opacity: 1; z-index: 10; pointer-events: auto; }
        .slide-bg { position: absolute; inset: 0; background-size: cover; background-position: center; transition: transform 8s ease; }
        .slide.active .slide-bg { transform: scale(1.06); }
        .slide-video { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; display: none; }
        .slide-overlay { position: absolute; inset: 0; background: rgba(0,0,0,.42); z-index: 2; }
        .slide-content { position: absolute; inset: 0; z-index: 20; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 24px; }

        /* TEXT ANIMATION */
        .slide-title { opacity: 0; transform: translateY(28px); transition: opacity .9s ease, transform .9s ease; }
        .slide.active .slide-title { opacity: 1; transform: translateY(0); transition-delay: .25s; }
        .slide-btn-wrap { opacity: 0; transform: translateY(16px); transition: opacity .8s ease, transform .8s ease; }
        .slide.active .slide-btn-wrap { opacity: 1; transform: translateY(0); transition-delay: .5s; }

        /* CTA BUTTON */
        .cta-btn {
            display: inline-block; padding: 16px 42px;
            border: 1.5px solid rgba(255,255,255,.8);
            font-weight: 900; font-size: 10px; letter-spacing: .3em;
            text-transform: uppercase; font-family: 'Inter', sans-serif;
            position: relative; overflow: hidden; transition: color .4s; cursor: none; pointer-events: auto;
        }
        .cta-btn::before { content:''; position:absolute; inset:0; background:#fff; transform:translateX(-101%); transition: transform .4s cubic-bezier(.16,1,.3,1); }
        .cta-btn:hover::before { transform: translateX(0); }
        .cta-btn:hover { color: #000; }
        .cta-btn span { position: relative; z-index: 1; }

        /* TOGGLE BUTTON */
        #mode-toggle {
            position: fixed; top: 50%; right: 28px; transform: translateY(-50%);
            z-index: 120; display: flex; flex-direction: column; align-items: center; gap: 6px;
            cursor: none;
        }
        .toggle-opt {
            width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;
            border: 1px solid rgba(255,255,255,0.15); transition: all .3s; cursor: none;
            font-size: 13px; color: rgba(255,255,255,.35);
        }
        .toggle-opt.active { border-color: #fff; color: #fff; background: rgba(255,255,255,.08); }
        .toggle-label { font-size: 7px; font-weight: 900; text-transform: uppercase; letter-spacing: .2em; color: rgba(255,255,255,.25); writing-mode: vertical-lr; }

        /* NAVIGATION DOTS */
        #slide-nav { position: fixed; bottom: 36px; left: 50%; transform: translateX(-50%); z-index: 120; display: flex; align-items: center; gap: 6px; }
        .nav-dot { width: 6px; height: 6px; border-radius: 50%; background: rgba(255,255,255,.25); cursor: none; transition: all .4s; }
        .nav-dot.active { background: #fff; width: 28px; border-radius: 3px; }

        /* PROGRESS BAR */
        #progress-bar { position: fixed; bottom: 0; left: 0; height: 2px; background: #fff; z-index: 130; width: 0%; transition: width 0s linear; }

        /* SLIDE COUNTER */
        #slide-counter { position: fixed; bottom: 60px; right: 28px; z-index: 120; font-size: 9px; font-weight: 900; font-family: 'Inter', sans-serif; color: rgba(255,255,255,.3); letter-spacing: .15em; }

        /* SOCIAL */
        .social-sidebar { position: fixed; left: 22px; top: 50%; transform: translateY(-50%); display: flex; flex-direction: column; gap: 100px; z-index: 50; }
        .social-block { display: flex; align-items: center; gap: 12px; transform: rotate(-90deg); transform-origin: left center; white-space: nowrap; }
        .social-name { font-size: .65rem; text-transform: lowercase; letter-spacing: .2em; color: rgba(255,255,255,.3); transition: color .3s; }
        .social-block:hover .social-name { color: #fff; }

        /* SCROLL HINT */
        .scroll-hint { position: fixed; right: 28px; bottom: 80px; display: flex; flex-direction: column; align-items: center; gap: 6px; z-index: 50; }
        .scroll-hint span { font-size: 7px; letter-spacing: .3em; text-transform: uppercase; writing-mode: vertical-rl; color: rgba(255,255,255,.25); }
        .scroll-line { width: 1px; height: 50px; background: rgba(255,255,255,.1); position: relative; overflow: hidden; }
        .scroll-line::after { content:''; position:absolute; top:-100%; left:0; width:100%; height:100%; background:rgba(255,255,255,.5); animation: scrollAnim 2s ease infinite; }
        @keyframes scrollAnim { 0%{top:-100%} 100%{top:100%} }

        /* MOBILE MENU */
        #mobile-menu { position: fixed; inset: 0; background: #000; z-index: 105; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 2rem; font-size: 2rem; font-weight: bold; text-transform: uppercase; transform: translateX(100%); transition: transform .5s cubic-bezier(.77,.2,.05,1); }
        #mobile-menu.open { transform: translateX(0); }
        #mobile-menu a { font-family: 'Inter', sans-serif; font-style: italic; }
        .burger-line { width: 24px; height: 2px; background: white; transition: .3s; }
        .open .line1 { transform: rotate(45deg) translate(5px,5px); }
        .open .line2 { opacity: 0; }
        .open .line3 { transform: rotate(-45deg) translate(7px,-6px); }
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

    <!-- SOCIAL SIDEBAR -->
    <div class="social-sidebar hidden md:flex">
        <div class="social-block"><a href="#" class="pointer-events-auto"><i class="fab fa-tiktok text-white/40 hover:text-white transition"></i></a><span class="social-name">tiktok</span></div>
        <div class="social-block"><a href="#" class="pointer-events-auto"><i class="fab fa-instagram text-white/40 hover:text-white transition"></i></a><span class="social-name">instagram</span></div>
        <div class="social-block"><a href="#" class="pointer-events-auto"><i class="fab fa-vimeo-v text-white/40 hover:text-white transition"></i></a><span class="social-name">vimeo</span></div>
    </div>

    <!-- SCROLL HINT -->
    <div class="scroll-hint hidden md:flex">
        <span>Scroll</span>
        <div class="scroll-line"></div>
    </div>

    <!-- TOGGLE VIDÉO / PHOTO -->
    <div id="mode-toggle" class="pointer-events-auto">
        <span class="toggle-label">Mode</span>
        <button class="toggle-opt active" id="btn-video" onclick="setMode('video')" title="Mode Vidéo">
            <i class="fas fa-film"></i>
        </button>
        <button class="toggle-opt" id="btn-photo" onclick="setMode('photo')" title="Mode Photo">
            <i class="fas fa-image"></i>
        </button>
    </div>

    <!-- COUNTER -->
    <div id="slide-counter">01 / 04</div>

    <!-- SLIDES -->
    <main class="relative h-screen w-full overflow-hidden">

        <!-- SLIDE 1 -->
        <div class="slide active" data-index="1">
            <div class="slide-bg" style="background-image:url('https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?q=80&w=1920');"></div>
            <video class="slide-video" src="logofakh.mp4" muted playsinline loop></video>
            <div class="slide-overlay"></div>
            <div class="slide-content">
                <div class="text-[8px] font-black uppercase tracking-[.5em] text-white/40 mb-6 slide-title">Production Audiovisuelle · Reims</div>
                <h1 class="text-[60px] md:text-[120px] font-black brutal-text leading-none mb-10 slide-title" style="transition-delay:.1s">LA FAKH.</h1>
                <div class="slide-btn-wrap">
                    <a href="portfolio.php" class="cta-btn"><span>Découvrir →</span></a>
                </div>
            </div>
        </div>

        <!-- SLIDE 2 -->
        <div class="slide" data-index="2">
            <div class="slide-bg" style="background-image:url('https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?q=80&w=1920');"></div>
            <video class="slide-video" src="Ve1.mp4" muted playsinline loop></video>
            <div class="slide-overlay"></div>
            <div class="slide-content">
                <h2 class="text-[55px] md:text-[110px] font-black brutal-text leading-none mb-10 slide-title">CRÉATIVITÉ<br>PURE.</h2>
                <div class="slide-btn-wrap">
                    <a href="portfolio.php" class="cta-btn"><span>Voir le Portfolio</span></a>
                </div>
            </div>
        </div>

        <!-- SLIDE 3 -->
        <div class="slide" data-index="3">
            <div class="slide-bg" style="background-image:url('https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?q=80&w=1920');"></div>
            <video class="slide-video" src="Ve2.mp4" muted playsinline loop></video>
            <div class="slide-overlay"></div>
            <div class="slide-content">
                <h2 class="text-[55px] md:text-[110px] font-black brutal-text leading-none mb-10 slide-title">VOS<br>PRESETS.</h2>
                <div class="slide-btn-wrap">
                    <a href="shop.php" class="cta-btn"><span>Découvrir le Shop</span></a>
                </div>
            </div>
        </div>

        <!-- SLIDE 4 -->
        <div class="slide" data-index="4">
            <div class="slide-bg" style="background-image:url('https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=1920');"></div>
            <video class="slide-video" src="Ve3.mp4" muted playsinline loop></video>
            <div class="slide-overlay"></div>
            <div class="slide-content">
                <h2 class="text-[55px] md:text-[110px] font-black brutal-text leading-none mb-10 slide-title">PARLONS<br>PROJET.</h2>
                <div class="slide-btn-wrap">
                    <a href="contact.php" class="cta-btn"><span>Nous Contacter</span></a>
                </div>
            </div>
        </div>

    </main>

    <!-- NAVIGATION DOTS -->
    <div id="slide-nav">
        <div class="nav-dot active" onclick="goTo(1)"></div>
        <div class="nav-dot" onclick="goTo(2)"></div>
        <div class="nav-dot" onclick="goTo(3)"></div>
        <div class="nav-dot" onclick="goTo(4)"></div>
    </div>

    <!-- PROGRESS BAR -->
    <div id="progress-bar"></div>

    <script>
    const TOTAL = 4;
    const DURATION = 6000; // ms par slide en mode photo
    let current = 1;
    let mode = 'video'; // 'video' | 'photo'
    let autoTimer = null;
    let progressStart = null;
    let progressRaf = null;
    let swipeX = 0;

    // ============ CURSOR ============
    const cur = document.getElementById('cursor');
    const ring = document.getElementById('cursor-ring');
    document.addEventListener('mousemove', e => {
        cur.style.left = e.clientX + 'px';  cur.style.top = e.clientY + 'px';
        ring.style.left = e.clientX + 'px'; ring.style.top = e.clientY + 'px';
    });
    document.querySelectorAll('a,button,[onclick]').forEach(el => {
        el.addEventListener('mouseenter', () => { cur.classList.add('big'); ring.classList.add('big'); });
        el.addEventListener('mouseleave', () => { cur.classList.remove('big'); ring.classList.remove('big'); });
    });

    // ============ PRELOADER ============
    window.addEventListener('load', () => {
        setTimeout(() => {
            const p = document.getElementById('preloader');
            p.classList.add('out');
            setTimeout(() => p.style.display = 'none', 800);
            startSlide(current);
        }, 2000);
    });

    // ============ MODE TOGGLE ============
    function setMode(m) {
        mode = m;
        document.getElementById('btn-video').classList.toggle('active', m === 'video');
        document.getElementById('btn-photo').classList.toggle('active', m === 'photo');
        applyMode();
        resetAuto();
    }

    function applyMode() {
        document.querySelectorAll('.slide').forEach(slide => {
            const vid = slide.querySelector('.slide-video');
            const bg  = slide.querySelector('.slide-bg');
            if (!vid) return;
            if (mode === 'video') {
                bg.style.display = 'none';
                vid.style.display = 'block';
                if (slide.classList.contains('active')) {
                    vid.play().catch(() => {});
                } else {
                    vid.pause(); vid.currentTime = 0;
                }
            } else {
                bg.style.display = 'block';
                vid.style.display = 'none';
                vid.pause();
            }
        });
    }

    // ============ SLIDESHOW ============
    function startSlide(idx) {
        document.querySelectorAll('.slide').forEach((s, i) => {
            const isActive = (i + 1) === idx;
            s.classList.toggle('active', isActive);
            const vid = s.querySelector('.slide-video');
            if (vid) {
                if (isActive && mode === 'video') {
                    vid.style.display = 'block';
                    vid.play().catch(() => {});
                } else {
                    vid.pause(); vid.currentTime = 0;
                    vid.style.display = mode === 'video' ? 'block' : 'none';
                }
            }
            const bg = s.querySelector('.slide-bg');
            if (bg) bg.style.display = mode === 'photo' ? 'block' : 'none';
        });

        // Dots
        document.querySelectorAll('.nav-dot').forEach((d, i) => d.classList.toggle('active', i + 1 === idx));

        // Counter
        document.getElementById('slide-counter').textContent =
            String(idx).padStart(2,'0') + ' / ' + String(TOTAL).padStart(2,'0');

        startProgress();
    }

    function goTo(idx) {
        current = idx;
        startSlide(current);
        resetAuto();
    }

    function next() { current = (current % TOTAL) + 1; startSlide(current); resetAuto(); }
    function prev() { current = ((current - 2 + TOTAL) % TOTAL) + 1; startSlide(current); resetAuto(); }

    // ============ AUTO-ADVANCE ============
    function resetAuto() {
        if (autoTimer) clearTimeout(autoTimer);
        autoTimer = setTimeout(next, DURATION);
    }

    // ============ PROGRESS BAR ============
    function startProgress() {
        const bar = document.getElementById('progress-bar');
        if (progressRaf) cancelAnimationFrame(progressRaf);
        bar.style.transition = 'none';
        bar.style.width = '0%';
        progressStart = performance.now();
        function tick(ts) {
            const pct = Math.min(((ts - progressStart) / DURATION) * 100, 100);
            bar.style.width = pct + '%';
            if (pct < 100) progressRaf = requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
    }

    // ============ SWIPE ============
    function swipeStart(e) { swipeX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX; }
    function swipeEnd(e) {
        const ex = e.type.includes('mouse') ? e.clientX : e.changedTouches[0].clientX;
        if (Math.abs(swipeX - ex) > 60) { swipeX - ex > 0 ? next() : prev(); }
    }

    // ============ KEYBOARD ============
    document.addEventListener('keydown', e => {
        if (e.key === 'ArrowRight') next();
        if (e.key === 'ArrowLeft')  prev();
        if (e.key === 'v') setMode('video');
        if (e.key === 'p') setMode('photo');
    });

    // ============ BURGER ============
    document.getElementById('burger-btn').addEventListener('click', function() {
        this.classList.toggle('open');
        const m = document.getElementById('mobile-menu');
        m.classList.toggle('open');
    });
    </script>
</body>
</html>
