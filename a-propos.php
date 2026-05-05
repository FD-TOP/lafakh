<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À PROPOS | LA FAKH</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;900&family=Space+Grotesk:wght@300;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        html, body { height: 100%; margin: 0; }
        body { font-family: 'Space Grotesk', sans-serif; background-color: #000; color: #fff; display: flex; flex-direction: column; overflow-x: hidden; }
        main { flex: 1 0 auto; }
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

        /* --- SCROLL ANIMATIONS --- */
        .reveal {
            opacity: 0; transform: translateY(40px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        .reveal-left { opacity: 0; transform: translateX(-40px); transition: opacity 0.8s ease, transform 0.8s ease; }
        .reveal-left.visible { opacity: 1; transform: translateX(0); }
        .reveal-right { opacity: 0; transform: translateX(40px); transition: opacity 0.8s ease, transform 0.8s ease; }
        .reveal-right.visible { opacity: 1; transform: translateX(0); }

        /* --- STATS --- */
        .stat-number {
            font-family: 'Inter', sans-serif; font-weight: 900; font-style: italic;
            font-size: clamp(48px, 8vw, 80px); line-height: 1;
            background: linear-gradient(135deg, #fff 60%, rgba(255,255,255,0.3));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }

        /* --- TEAM CARD --- */
        .team-card { cursor: pointer; }
        .team-card .card-inner {
            aspect-ratio: 3/4; overflow: hidden; position: relative;
            background: #0d0d0d;
            border: 1px solid rgba(255,255,255,0.06);
        }
        .team-card .card-inner::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(to bottom, transparent 50%, rgba(0,0,0,0.8) 100%);
            z-index: 5; transition: opacity 0.4s;
        }
        .team-card:hover .card-inner::before { opacity: 0.5; }
        .team-card .avatar {
            width: 100%; height: 100%; object-fit: cover;
            filter: grayscale(100%);
            transition: all 0.6s ease;
        }
        .team-card .avatar-placeholder {
            width: 100%; height: 100%;
            display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, #111 0%, #1a1a1a 100%);
            font-family: 'Inter', sans-serif; font-weight: 900; font-style: italic;
            font-size: 48px; color: rgba(255,255,255,0.08);
            text-transform: uppercase;
            transition: all 0.6s ease;
        }
        .team-card:hover .avatar { filter: grayscale(0%); transform: scale(1.05); }
        .team-card:hover .avatar-placeholder { background: linear-gradient(135deg, #1a1a1a 0%, #222 100%); }
        .team-info { text-align: center; transition: opacity 0.4s; opacity: 0.6; }
        .team-card:hover .team-info { opacity: 1; }

        /* --- TIMELINE --- */
        .timeline-item { position: relative; padding-left: 30px; }
        .timeline-item::before {
            content: ''; position: absolute; left: 0; top: 6px;
            width: 6px; height: 6px; border-radius: 50%; background: rgba(255,255,255,0.3);
            transition: background 0.3s;
        }
        .timeline-item:hover::before { background: #fff; }
        .timeline-item::after {
            content: ''; position: absolute; left: 2.5px; top: 12px;
            width: 1px; bottom: -20px; background: rgba(255,255,255,0.06);
        }
        .timeline-item:last-child::after { display: none; }

        /* --- SERVICES GRID --- */
        .service-item {
            border: 1px solid rgba(255,255,255,0.06);
            padding: 28px; transition: border-color 0.4s, background 0.4s;
        }
        .service-item:hover { border-color: rgba(255,255,255,0.2); background: rgba(255,255,255,0.02); }

        /* --- FOOTER --- */
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
            <a href="portfolio.php" class="opacity-50 hover:opacity-100 transition">Portfolio</a>
            <a href="shop.php" class="opacity-50 hover:opacity-100 transition">Shop</a>
            <a href="contact.php" class="opacity-50 hover:opacity-100 transition">Contact</a>
            <a href="a-propos.php" class="border-b border-white pb-1">À Propos</a>
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

    <main class="py-20 px-6">

        <!-- HERO -->
        <section class="max-w-5xl mx-auto mb-24 reveal">
            <h1 class="text-3xl md:text-6xl font-black brutal-text mb-12 text-center">L'AGENCE.</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-start">
                <div class="text-zinc-400 text-lg leading-relaxed space-y-6 reveal-left">
                    <p>
                        Fondée en 2019, <span class="text-white font-bold">LA FAKH</span> est née d'une vision simple : repousser les limites de la création audiovisuelle pour offrir une identité visuelle unique et inoubliable.
                    </p>
                    <p>
                        Basée à Reims, notre agence accompagne marques et artistes dans la création de contenus percutants — du vlog lifestyle aux productions institutionnelles de haute qualité.
                    </p>
                    <p>
                        Chaque projet est traité comme une œuvre : une attention particulière portée à chaque plan, chaque coupe, chaque détail.
                    </p>
                    <a href="contact.php" class="inline-block mt-4 text-[10px] font-black uppercase tracking-widest border border-white px-8 py-4 hover:bg-white hover:text-black transition">
                        Démarrer un projet →
                    </a>
                </div>
                <div class="border-l border-white/10 pl-8 space-y-10 reveal-right">
                    <div>
                        <h3 class="text-xs font-black uppercase tracking-widest text-white mb-2">Expertise</h3>
                        <p class="text-zinc-500 text-sm">Vlog, Lifestyle, Institutionnel, Publicité & Contenu Digital.</p>
                    </div>
                    <div>
                        <h3 class="text-xs font-black uppercase tracking-widest text-white mb-2">Localisation</h3>
                        <p class="text-zinc-500 text-sm italic">Reims, France & International.</p>
                    </div>
                    <div>
                        <h3 class="text-xs font-black uppercase tracking-widest text-white mb-2">Équipement</h3>
                        <p class="text-zinc-500 text-sm">Sony FX3, DJI Ronin, Drones certifiés, Studio son.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- STATS -->
        <section class="max-w-5xl mx-auto mb-24 py-16 border-t border-b border-white/5 reveal">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="stat-number">6+</div>
                    <div class="text-[9px] uppercase tracking-[0.3em] text-zinc-500 mt-3">Années d'expérience</div>
                </div>
                <div>
                    <div class="stat-number">50+</div>
                    <div class="text-[9px] uppercase tracking-[0.3em] text-zinc-500 mt-3">Projets réalisés</div>
                </div>
                <div>
                    <div class="stat-number">30+</div>
                    <div class="text-[9px] uppercase tracking-[0.3em] text-zinc-500 mt-3">Clients satisfaits</div>
                </div>
                <div>
                    <div class="stat-number">4K</div>
                    <div class="text-[9px] uppercase tracking-[0.3em] text-zinc-500 mt-3">Qualité standard</div>
                </div>
            </div>
        </section>

        <!-- SERVICES -->
        <section class="max-w-5xl mx-auto mb-24 reveal">
            <h2 class="text-3xl md:text-4xl font-black brutal-text mb-12 text-center">NOS SERVICES</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="service-item">
                    <div class="text-[9px] font-black uppercase tracking-[0.4em] text-zinc-600 mb-3">01</div>
                    <h3 class="text-sm font-black uppercase tracking-widest mb-3">Vlog & Lifestyle</h3>
                    <p class="text-zinc-500 text-sm leading-relaxed">Contenus authentiques et dynamiques pour réseaux sociaux et plateformes digitales.</p>
                </div>
                <div class="service-item">
                    <div class="text-[9px] font-black uppercase tracking-[0.4em] text-zinc-600 mb-3">02</div>
                    <h3 class="text-sm font-black uppercase tracking-widest mb-3">Institutionnel</h3>
                    <p class="text-zinc-500 text-sm leading-relaxed">Films d'entreprise, présentations corporate et communications officielles.</p>
                </div>
                <div class="service-item">
                    <div class="text-[9px] font-black uppercase tracking-[0.4em] text-zinc-600 mb-3">03</div>
                    <h3 class="text-sm font-black uppercase tracking-widest mb-3">Publicité Digitale</h3>
                    <p class="text-zinc-500 text-sm leading-relaxed">Spots publicitaires percutants optimisés pour Instagram, TikTok et YouTube.</p>
                </div>
                <div class="service-item">
                    <div class="text-[9px] font-black uppercase tracking-[0.4em] text-zinc-600 mb-3">04</div>
                    <h3 class="text-sm font-black uppercase tracking-widest mb-3">Post-Production</h3>
                    <p class="text-zinc-500 text-sm leading-relaxed">Montage, étalonnage colorimétrique, motion design et mixage son professionnel.</p>
                </div>
            </div>
        </section>

        <!-- TIMELINE -->
        <section class="max-w-5xl mx-auto mb-24 reveal">
            <h2 class="text-3xl md:text-4xl font-black brutal-text mb-16 text-center">PARCOURS</h2>
            <div class="max-w-2xl mx-auto space-y-10">
                <div class="timeline-item">
                    <div class="text-[9px] font-black text-zinc-600 uppercase tracking-widest mb-1">2019</div>
                    <h3 class="text-sm font-black uppercase tracking-widest mb-2">Fondation de LA FAKH</h3>
                    <p class="text-zinc-500 text-sm">Création du studio à Reims avec une vision : produire des contenus d'exception.</p>
                </div>
                <div class="timeline-item">
                    <div class="text-[9px] font-black text-zinc-600 uppercase tracking-widest mb-1">2021</div>
                    <h3 class="text-sm font-black uppercase tracking-widest mb-2">Expansion des Services</h3>
                    <p class="text-zinc-500 text-sm">Intégration de la production institutionnelle et de la publicité digitale haut de gamme.</p>
                </div>
                <div class="timeline-item">
                    <div class="text-[9px] font-black text-zinc-600 uppercase tracking-widest mb-1">2023</div>
                    <h3 class="text-sm font-black uppercase tracking-widest mb-2">Lancement du Shop</h3>
                    <p class="text-zinc-500 text-sm">Mise en ligne de nos presets et LUTs cinématographiques pour créateurs indépendants.</p>
                </div>
                <div class="timeline-item">
                    <div class="text-[9px] font-black text-zinc-600 uppercase tracking-widest mb-1">2026</div>
                    <h3 class="text-sm font-black uppercase tracking-widest mb-2">Aujourd'hui</h3>
                    <p class="text-zinc-500 text-sm">Plus de 50 projets réalisés, une clientèle nationale et une signature visuelle reconnaissable.</p>
                </div>
            </div>
        </section>

        <!-- ÉQUIPE -->
        <section class="max-w-5xl mx-auto reveal">
            <h2 class="text-3xl md:text-4xl font-black brutal-text mb-16 text-center">L'ÉQUIPE</h2>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                
                <div class="team-card group">
                    <div class="card-inner mb-5 rounded-xl overflow-hidden">
                        <div class="avatar-placeholder">RF</div>
                    </div>
                    <div class="team-info">
                        <h4 class="font-black text-sm uppercase tracking-widest">Réalisateur</h4>
                        <p class="text-[10px] text-zinc-500 uppercase mt-1 italic">Direction Artistique</p>
                    </div>
                </div>

                <div class="team-card group">
                    <div class="card-inner mb-5 rounded-xl overflow-hidden">
                        <div class="avatar-placeholder">DP</div>
                    </div>
                    <div class="team-info">
                        <h4 class="font-black text-sm uppercase tracking-widest">Directeur Photo</h4>
                        <p class="text-[10px] text-zinc-500 uppercase mt-1 italic">Image & Lumière</p>
                    </div>
                </div>

                <div class="team-card group">
                    <div class="card-inner mb-5 rounded-xl overflow-hidden">
                        <div class="avatar-placeholder">ED</div>
                    </div>
                    <div class="team-info">
                        <h4 class="font-black text-sm uppercase tracking-widest">Monteur</h4>
                        <p class="text-[10px] text-zinc-500 uppercase mt-1 italic">Post-Production</p>
                    </div>
                </div>

                <div class="team-card group">
                    <div class="card-inner mb-5 rounded-xl overflow-hidden">
                        <div class="avatar-placeholder">CM</div>
                    </div>
                    <div class="team-info">
                        <h4 class="font-black text-sm uppercase tracking-widest">Communication</h4>
                        <p class="text-[10px] text-zinc-500 uppercase mt-1 italic">Stratégie Digitale</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="max-w-7xl mx-auto px-6 py-20">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-20">
                <div class="md:col-span-1">
                    <div class="text-xl font-black brutal-text mb-6">LA FAKH</div>
                    <p class="text-[10px] text-zinc-500 uppercase tracking-widest leading-relaxed">
                        Production audiovisuelle basée à Reims.
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
        document.addEventListener('DOMContentLoaded', function() {
            const burgerBtn = document.getElementById('burger-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            burgerBtn.addEventListener('click', () => {
                burgerBtn.classList.toggle('open');
                mobileMenu.classList.toggle('open');
                document.body.style.overflow = mobileMenu.classList.contains('open') ? 'hidden' : 'auto';
            });
        });

        // Scroll reveal
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal, .reveal-left, .reveal-right').forEach(el => observer.observe(el));

        // Compteur animé pour les stats
        const counters = document.querySelectorAll('.stat-number');
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const text = el.textContent;
                    const num = parseInt(text);
                    if (!isNaN(num)) {
                        const suffix = text.replace(num.toString(), '');
                        let current = 0;
                        const step = Math.ceil(num / 40);
                        const timer = setInterval(() => {
                            current = Math.min(current + step, num);
                            el.textContent = current + suffix;
                            if (current >= num) clearInterval(timer);
                        }, 40);
                    }
                    counterObserver.unobserve(el);
                }
            });
        }, { threshold: 0.5 });
        counters.forEach(el => counterObserver.observe(el));
    </script>
</body>
</html>
