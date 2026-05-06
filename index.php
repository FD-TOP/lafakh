<?php 
require_once 'db.php'; 
$site_name = "LA FAKH"; 
?>
<!DOCTYPE html>
<html lang="fr" class="bg-black overflow-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_name; ?> | Portfolio Audiovisuel</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@900&family=Space+Grotesk:wght@300;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body { 
            font-family: 'Space Grotesk', sans-serif; 
            overflow: hidden; 
            background-color: #000; 
            color: #fff; 
            cursor: none;
            user-select: none;
        }
        .brutal-text { font-family: 'Inter', sans-serif; text-transform: uppercase; letter-spacing: -0.05em; }

        /* --- CUSTOM CURSOR --- */
        #cursor {
            width: 12px; height: 12px;
            background: #fff;
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 99999;
            transform: translate(-50%, -50%);
            transition: transform 0.1s, width 0.3s, height 0.3s, background 0.3s;
            mix-blend-mode: difference;
        }
        #cursor-follower {
            width: 40px; height: 40px;
            border: 1px solid rgba(255,255,255,0.4);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 99998;
            transform: translate(-50%, -50%);
            transition: left 0.12s ease, top 0.12s ease, width 0.3s, height 0.3s, opacity 0.3s;
        }
        #cursor.expanded { width: 50px; height: 50px; }
        #cursor-follower.expanded { width: 70px; height: 70px; opacity: 0.3; }

        /* --- PRELOADER --- */
        #preloader {
            position: fixed; inset: 0; background: #000; z-index: 9999;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
        }
        #preloader.fade-out { opacity: 0; visibility: hidden; transition: opacity 0.8s ease, visibility 0.8s; }

        .loader-logo-img {
            width: 150px;
            height: auto;
            opacity: 0;
            animation: logoZoomEntrance 1.8s cubic-bezier(0.3, 0, 0.1, 1) forwards;
        }
        @keyframes logoZoomEntrance {
            0% { opacity: 0; transform: scale(0.5); filter: blur(10px); }
            100% { opacity: 1; transform: scale(1.1); filter: blur(0px); }
        }
        
        /* --- SLIDES --- */
        .slide { 
            opacity: 0; transition: opacity 1s ease-in-out; 
            position: absolute; inset: 0; z-index: 5; pointer-events: none; 
        }
        .slide.active { opacity: 1; z-index: 10; }
        .video-overlay { position: absolute; inset: 0; background: rgba(0,0,0,0.4); z-index: 15; pointer-events: none; }

        /* --- CTA BUTTON --- */
        .cta-btn {
            display: inline-block;
            padding: 18px 44px;
            border: 1.5px solid rgba(255,255,255,0.8);
            text-transform: uppercase;
            font-weight: 900;
            font-size: 10px;
            letter-spacing: 0.3em;
            font-family: 'Inter', sans-serif;
            position: relative;
            overflow: hidden;
            transition: color 0.4s ease;
            cursor: none;
            pointer-events: auto;
        }
        .cta-btn::before {
            content: '';
            position: absolute; inset: 0;
            background: #fff;
            transform: translateX(-101%);
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .cta-btn:hover::before { transform: translateX(0); }
        .cta-btn:hover { color: #000; }
        .cta-btn span { position: relative; z-index: 1; }

        /* Slide text entrance */
        .slide-text { opacity: 0; transform: translateY(30px); transition: opacity 0.8s ease, transform 0.8s ease; }
        .slide.active .slide-text { opacity: 1; transform: translateY(0); transition-delay: 0.3s; }
        .slide-btn { opacity: 0; transform: translateY(20px); transition: opacity 0.8s ease, transform 0.8s ease; }
        .slide.active .slide-btn { opacity: 1; transform: translateY(0); transition-delay: 0.55s; }

        /* --- SOCIAL SIDEBAR VERTICALE --- */
        .social-sidebar {
            position: fixed; left: 25px; top: 50%; transform: translateY(-50%);
            display: flex; flex-direction: column; gap: 110px; z-index: 50;
        }
        .social-block {
            display: flex; align-items: center; gap: 15px;
            transform: rotate(-90deg); transform-origin: left center; white-space: nowrap;
        }
        .social-name {
            font-size: 0.7rem; text-transform: lowercase; letter-spacing: 0.2em;
            color: rgba(255, 255, 255, 0.4); transition: color 0.3s;
        }
        .social-block:hover .social-name { color: #fff; }

        /* --- NAVIGATION MOBILE --- */
        #mobile-menu {
            position: fixed; inset: 0; background: black; z-index: 105;
            display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 2rem;
            font-size: 2rem; font-weight: bold; text-transform: uppercase;
            transform: translateX(100%); transition: transform 0.5s cubic-bezier(0.77,0.2,0.05,1.0);
        }
        #mobile-menu.open { transform: translateX(0); }
        #mobile-menu a { font-family: 'Inter', sans-serif; font-style: italic; }
        .burger-line { width: 24px; height: 2px; background: white; transition: 0.3s; }
        .open .line1 { transform: rotate(45deg) translate(5px, 5px); }
        .open .line2 { opacity: 0; }
        .open .line3 { transform: rotate(-45deg) translate(7px, -6px); }

        /* --- PAGINATION & BARRE --- */
        .nav-num { font-size: 10px; font-weight: bold; color: rgba(255,255,255,0.2); cursor: none; padding: 5px; transition: 0.3s; }
        .nav-num.active { color: #fff; }
        .progress-wrapper { width: 0; height: 1.5px; background: rgba(255,255,255,0.1); position: relative; overflow: hidden; transition: width 0.5s ease; }
        .progress-wrapper.visible { width: 50px; margin: 0 5px; }
        .progress-bar { height: 100%; width: 0%; background: #fff; position: absolute; }

        /* --- SCROLL HINT --- */
        .scroll-hint {
            position: absolute; right: 30px; top: 50%; transform: translateY(-50%);
            display: flex; flex-direction: column; align-items: center; gap: 8px;
            z-index: 50;
        }
        .scroll-hint span {
            font-size: 8px; letter-spacing: 0.3em; text-transform: uppercase;
            writing-mode: vertical-rl; color: rgba(255,255,255,0.3);
        }
        .scroll-line {
            width: 1px; height: 60px; background: rgba(255,255,255,0.15); position: relative; overflow: hidden;
        }
        .scroll-line::after {
            content: ''; position: absolute; top: -100%; left: 0; width: 100%; height: 100%;
            background: rgba(255,255,255,0.6);
            animation: scrollDown 2s ease infinite;
        }
        @keyframes scrollDown { 0% { top: -100%; } 100% { top: 100%; } }
    </style>
</head>
<body onmousedown="handleStart(event)" onmouseup="handleEnd(event)" ontouchstart="handleStart(event)" ontouchend="handleEnd(event)">

    <!-- CUSTOM CURSOR -->
    <div id="cursor"></div>
    <div id="cursor-follower"></div>

    <!-- PRELOADER -->
    <div id="preloader">
        <div class="loader-container">
            <img src="logo.png" alt="Logo" class="loader-logo-img">
            <div class="mt-8 text-[8px] uppercase tracking-[0.5em] opacity-40 italic text-center">Production</div>
        </div>
    </div>

    <header class="fixed top-0 w-full z-[110] px-6 md:px-10 h-24 flex justify-between items-center pointer-events-none">
        <a href="index.php" class="pointer-events-auto">
            <img src="logo.png" alt="Logo" class="h-8 md:h-10 w-auto">
        </a>
        <nav class="hidden md:flex space-x-10 text-[10px] font-bold uppercase tracking-[0.3em] pointer-events-auto">
            <a href="index.php" class="border-b border-white pb-1">Accueil</a>
            <a href="portfolio.php" class="hover:opacity-50 transition">Portfolio</a>
            <a href="shop.php" class="hover:opacity-50 transition">Shop</a>
            <a href="contact.php" class="hover:opacity-50 transition">Contact</a>
            <a href="a-propos.php" class="hover:opacity-50 transition">À Propos</a>
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

    <div class="social-sidebar hidden md:flex">
        <div class="social-block"><a href="#" class="pointer-events-auto"><i class="fab fa-tiktok text-white/50 hover:text-white transition"></i></a><span class="social-name">tiktok</span></div>
        <div class="social-block"><a href="#" class="pointer-events-auto"><i class="fab fa-instagram text-white/50 hover:text-white transition"></i></a><span class="social-name">instagram</span></div>
        <div class="social-block"><a href="#" class="pointer-events-auto"><i class="fab fa-vimeo-v text-white/50 hover:text-white transition"></i></a><span class="social-name">vimeo</span></div>
    </div>

    <!-- SCROLL HINT -->
    <div class="scroll-hint hidden md:flex pointer-events-none">
        <span>Scroll</span>
        <div class="scroll-line"></div>
    </div>

    <main class="relative h-screen w-full">
        <div class="slide active" data-index="1">
            <div class="video-overlay"></div>
            <video class="w-full h-full object-cover" autoplay muted playsinline onended="nextSlide()">
                <source src="logofakh.mp4" type="video/mp4">
            </video>
            <div class="absolute inset-0" style="background:url('https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?q=80&w=1920') center/cover no-repeat;z-index:-1;"></div>
        </div>

        <div class="slide" data-index="2">
            <div class="video-overlay"></div>
            <video class="w-full h-full object-cover" muted playsinline onended="nextSlide()">
                <source src="Ve1.mp4" type="video/mp4">
            </video>
            <div class="absolute inset-0" style="background:url('https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?q=80&w=1920') center/cover no-repeat;z-index:-1;"></div>
            <div class="absolute inset-0 flex flex-col items-center justify-center z-20 text-center px-6">
                <h2 class="text-5xl md:text-[100px] font-black brutal-text mb-8 slide-text">CRÉATIVITÉ <br> PURE.</h2>
                <div class="slide-btn">
                    <a href="portfolio.php" class="cta-btn"><span>Voir le Portfolio</span></a>
                </div>
            </div>
        </div>

        <div class="slide" data-index="3">
            <div class="video-overlay"></div>
            <video class="w-full h-full object-cover" muted playsinline onended="nextSlide()">
                <source src="Ve2.mp4" type="video/mp4">
            </video>
            <div class="absolute inset-0" style="background:url('https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?q=80&w=1920') center/cover no-repeat;z-index:-1;"></div>
            <div class="absolute inset-0 flex flex-col items-center justify-center z-20 text-center px-6">
                <h2 class="text-5xl md:text-[100px] font-black brutal-text mb-8 slide-text">VOS <br> PRESETS.</h2>
                <div class="slide-btn">
                    <a href="shop.php" class="cta-btn"><span>Découvrir le Shop</span></a>
                </div>
            </div>
        </div>

        <div class="slide" data-index="4">
            <div class="video-overlay"></div>
            <video class="w-full h-full object-cover" muted playsinline onended="nextSlide()">
                <source src="Ve3.mp4" type="video/mp4">
            </video>
            <div class="absolute inset-0" style="background:url('https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=1920') center/cover no-repeat;z-index:-1;"></div>
            <div class="absolute inset-0 flex flex-col items-center justify-center z-20 text-center px-6">
                <h2 class="text-5xl md:text-[100px] font-black brutal-text mb-8 slide-text">PARLONS <br> PROJET.</h2>
                <div class="slide-btn">
                    <a href="contact.php" class="cta-btn"><span>Nous Contacter</span></a>
                </div>
            </div>
        </div>

        <div class="absolute bottom-12 w-full z-[120] flex justify-center">
            <div class="flex items-center gap-2 pointer-events-auto">
                <span class="nav-num active" id="n1" onclick="goToSlide(1)">01</span>
                <div id="w1" class="progress-wrapper visible"><div id="p1" class="progress-bar"></div></div>
                <span class="nav-num" id="n2" onclick="goToSlide(2)">02</span>
                <div id="w2" class="progress-wrapper"><div id="p2" class="progress-bar"></div></div>
                <span class="nav-num" id="n3" onclick="goToSlide(3)">03</span>
                <div id="w3" class="progress-wrapper"><div id="p3" class="progress-bar"></div></div>
                <span class="nav-num" id="n4" onclick="goToSlide(4)">04</span>
            </div>
        </div>
    </main>

    <script>
        let currentIdx = 1; const totalSlides = 4; let progressInterval; let startX = 0;

        // --- CUSTOM CURSOR ---
        const cursor = document.getElementById('cursor');
        const follower = document.getElementById('cursor-follower');
        document.addEventListener('mousemove', (e) => {
            cursor.style.left = e.clientX + 'px';
            cursor.style.top = e.clientY + 'px';
            follower.style.left = e.clientX + 'px';
            follower.style.top = e.clientY + 'px';
        });
        document.querySelectorAll('a, button, [onclick]').forEach(el => {
            el.addEventListener('mouseenter', () => { cursor.classList.add('expanded'); follower.classList.add('expanded'); });
            el.addEventListener('mouseleave', () => { cursor.classList.remove('expanded'); follower.classList.remove('expanded'); });
        });

        // --- PRELOADER (single handler) ---
        window.addEventListener('load', () => {
            setTimeout(() => {
                const preloader = document.getElementById('preloader');
                preloader.classList.add('fade-out');
                setTimeout(() => { preloader.style.display = 'none'; }, 800);
                updateSlider();
            }, 2200);
        });

        // --- SWIPE LOGIC ---
        function handleStart(e) { startX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX; }
        function handleEnd(e) {
            const endX = e.type.includes('mouse') ? e.clientX : e.changedTouches[0].clientX;
            const diff = startX - endX;
            if (Math.abs(diff) > 60) { diff > 0 ? nextSlide() : prevSlide(); }
        }

        // --- KEYBOARD NAV ---
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowRight') nextSlide();
            if (e.key === 'ArrowLeft') prevSlide();
        });

        // --- SLIDER ENGINE ---
        function updateSlider() {
            if (progressInterval) clearInterval(progressInterval);
            document.querySelectorAll('.slide').forEach(s => {
                s.classList.remove('active');
                const v = s.querySelector('video'); if(v) { v.pause(); v.currentTime = 0; }
            });
            const activeSlide = document.querySelector(`.slide[data-index="${currentIdx}"]`);
            activeSlide.classList.add('active');
            const video = activeSlide.querySelector('video');

            document.querySelectorAll('.nav-num, .progress-wrapper').forEach(el => el.classList.remove('active', 'visible'));
            document.querySelectorAll('.progress-bar').forEach(b => b.style.width = '0%');
            document.getElementById(`n${currentIdx}`).classList.add('active');
            
            if (currentIdx < totalSlides) {
                const wrapper = document.getElementById(`w${currentIdx}`);
                const bar = document.getElementById(`p${currentIdx}`);
                wrapper.classList.add('visible');
                if(video) {
                    video.play();
                    progressInterval = setInterval(() => {
                        if(video.duration) bar.style.width = (video.currentTime / video.duration * 100) + '%';
                    }, 50);
                }
            } else {
                if(video) {
                    video.play();
                    const bar = document.getElementById(`p${currentIdx - 1}`);
                    const wrapper = document.getElementById(`w${currentIdx - 1}`);
                    if(wrapper) wrapper.classList.add('visible');
                    if(video && bar) {
                        progressInterval = setInterval(() => {
                            if(video.duration) bar.style.width = (video.currentTime / video.duration * 100) + '%';
                        }, 50);
                    }
                }
            }
        }

        function nextSlide() { currentIdx = (currentIdx % totalSlides) + 1; updateSlider(); }
        function prevSlide() { currentIdx = (currentIdx - 2 + totalSlides) % totalSlides + 1; updateSlider(); }
        function goToSlide(idx) { currentIdx = idx; updateSlider(); }

        // --- MENU MOBILE ---
        const burgerBtn = document.getElementById('burger-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        burgerBtn.addEventListener('click', () => {
            burgerBtn.classList.toggle('open');
            mobileMenu.classList.toggle('open');
        });
    </script>
</body>
</html>
