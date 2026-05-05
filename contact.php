<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONTACT | LA FAKH</title>
    
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
            background: #000; z-index: 100; display: flex; flex-direction: column;
            align-items: center; justify-content: center; gap: 30px;
            transition: 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }
        #mobile-menu.open { right: 0; }
        #mobile-menu a { font-size: 32px; font-weight: 900; text-transform: uppercase; font-style: italic; font-family: 'Inter'; }

        /* --- FORMULAIRE FLOTTANT --- */
        .form-group { position: relative; }
        .form-group label {
            position: absolute; top: 18px; left: 20px;
            font-size: 10px; font-weight: 900; text-transform: uppercase;
            letter-spacing: 0.2em; color: rgba(255,255,255,0.3);
            transition: all 0.3s ease; pointer-events: none;
        }
        .form-group input:focus ~ label,
        .form-group input:not(:placeholder-shown) ~ label,
        .form-group textarea:focus ~ label,
        .form-group textarea:not(:placeholder-shown) ~ label {
            top: 6px; font-size: 7px; color: rgba(255,255,255,0.5);
        }
        .form-group input,
        .form-group textarea {
            background: rgba(255,255,255,0.03) !important;
            border: 1px solid rgba(255,255,255,0.08) !important;
            color: white !important;
            transition: border-color 0.3s, background 0.3s;
            padding-top: 22px !important;
        }
        .form-group input:focus,
        .form-group textarea:focus {
            border-color: rgba(255,255,255,0.4) !important;
            background: rgba(255,255,255,0.04) !important;
            outline: none;
        }

        /* Standard input (non-flottant) */
        input, textarea { 
            background: rgba(255,255,255,0.03) !important; 
            border: 1px solid rgba(255,255,255,0.08) !important; 
            color: white !important; 
            transition: 0.3s;
        }
        input:focus, textarea:focus { border-color: rgba(255,255,255,0.4) !important; outline: none; }

        /* --- SCROLL ANIMATIONS --- */
        .reveal { opacity: 0; transform: translateY(30px); transition: opacity 0.7s ease, transform 0.7s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        /* --- CONTACT INFO CARD --- */
        .info-card {
            border: 1px solid rgba(255,255,255,0.06);
            padding: 24px 28px;
            transition: border-color 0.4s;
        }
        .info-card:hover { border-color: rgba(255,255,255,0.2); }

        /* --- SUBMIT BUTTON --- */
        .submit-btn {
            position: relative; overflow: hidden;
            background: #fff; color: #000;
            width: 100%; font-family: 'Inter', sans-serif;
            font-weight: 900; font-size: 11px;
            text-transform: uppercase; letter-spacing: 0.4em;
            padding: 20px; border: none; cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }
        .submit-btn:hover { background: #e8e8e8; transform: scale(1.01); }
        .submit-btn:active { transform: scale(0.99); }
        .submit-btn.loading { background: #333; color: transparent; cursor: not-allowed; }
        .submit-btn.loading::after {
            content: ''; position: absolute; top: 50%; left: 50%;
            width: 20px; height: 20px; margin: -10px 0 0 -10px;
            border: 2px solid rgba(255,255,255,0.2); border-top-color: #fff;
            border-radius: 50%; animation: spin 0.8s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* --- SOCIAL LINKS --- */
        .social-link {
            display: flex; align-items: center; gap: 12px;
            text-decoration: none; color: rgba(255,255,255,0.4);
            font-size: 10px; font-weight: 900; text-transform: uppercase;
            letter-spacing: 0.2em; transition: color 0.3s, gap 0.3s;
            padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .social-link:hover { color: #fff; gap: 18px; }
        .social-link:last-child { border-bottom: none; }
        .social-link i { width: 16px; text-align: center; }

        /* --- FOOTER --- */
        footer { flex-shrink: 0; background-color: #000; border-top: 1px solid rgba(255,255,255,0.05); }
        .footer-link { font-size: 10px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.2em; color: #666; transition: 0.3s; }
        .footer-link:hover { color: #fff; padding-left: 5px; }

        /* Toast notification */
        #toast {
            position: fixed; bottom: 30px; right: 30px;
            background: #fff; color: #000;
            padding: 14px 24px; z-index: 9999;
            font-size: 10px; font-weight: 900; font-family: 'Inter', sans-serif;
            text-transform: uppercase; letter-spacing: 0.2em;
            transform: translateY(100px); opacity: 0;
            transition: transform 0.4s ease, opacity 0.4s ease;
        }
        #toast.show { transform: translateY(0); opacity: 1; }
    </style>
</head>
<body>

    <div id="toast"></div>

    <header class="fixed top-0 w-full z-[110] px-6 md:px-10 h-24 flex justify-between items-center bg-black/70 backdrop-blur-md">
        <a href="index.php">
            <img src="logo.png" alt="Logo" class="h-8 md:h-10 w-auto">
        </a>
        <nav class="hidden md:flex space-x-10 text-[10px] font-bold uppercase tracking-[0.3em]">
            <a href="index.php" class="hover:opacity-50 transition">Accueil</a>
            <a href="portfolio.php" class="hover:opacity-50 transition">Portfolio</a>
            <a href="shop.php" class="hover:opacity-50 transition">Shop</a>
            <a href="contact.php" class="border-b border-white pb-1">Contact</a>
            <a href="a-propos.php" class="hover:opacity-50 transition">À Propos</a>
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

    <main class="max-w-5xl mx-auto pt-40 pb-20 px-6">

        <!-- TITRE -->
        <div class="reveal text-center mb-16">
            <h1 class="text-3xl md:text-6xl font-black brutal-text mb-4">CONTACT</h1>
            <p class="text-zinc-500 text-sm uppercase tracking-widest italic">Une idée ? Un projet ? Parlons-en.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-16">

            <!-- FORMULAIRE -->
            <div class="lg:col-span-3 reveal">
                <form id="contact-form" action="send_message.php" method="POST" class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="text-[10px] uppercase font-bold opacity-30 mb-2 block">Nom complet</label>
                            <input type="text" name="nom" required placeholder=" " class="w-full p-5 text-sm" style="border-radius: 0;">
                        </div>
                        <div>
                            <label class="text-[10px] uppercase font-bold opacity-30 mb-2 block">Email</label>
                            <input type="email" name="email" required placeholder=" " class="w-full p-5 text-sm" style="border-radius: 0;">
                        </div>
                    </div>

                    <!-- TYPE DE PROJET -->
                    <div>
                        <label class="text-[10px] uppercase font-bold opacity-30 mb-3 block">Type de projet</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                            <?php foreach(['Vlog', 'Institutionnel', 'Publicité', 'Autre'] as $type): ?>
                            <label class="cursor-pointer">
                                <input type="radio" name="type_projet" value="<?= $type ?>" class="hidden peer">
                                <div class="text-center py-3 px-2 text-[9px] font-black uppercase tracking-wider border border-white/10 text-white/30 transition peer-checked:border-white peer-checked:text-white peer-checked:bg-white/5 hover:border-white/30 hover:text-white/60">
                                    <?= $type ?>
                                </div>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] uppercase font-bold opacity-30 mb-2 block">Sujet</label>
                        <input type="text" name="sujet" required placeholder=" " class="w-full p-5 text-sm" style="border-radius: 0;">
                    </div>
                    <div>
                        <label class="text-[10px] uppercase font-bold opacity-30 mb-2 block">Message</label>
                        <textarea name="message" rows="6" required placeholder=" " class="w-full p-5 text-sm resize-none" style="border-radius: 0;"></textarea>
                    </div>
                    <button type="submit" id="submit-btn" class="submit-btn">
                        Envoyer le message
                    </button>
                </form>
            </div>

            <!-- INFOS CONTACT -->
            <div class="lg:col-span-2 space-y-6 reveal" style="transition-delay: 0.2s">

                <!-- Coordonnées -->
                <div class="info-card">
                    <h3 class="text-[9px] font-black uppercase tracking-[0.4em] text-white/30 mb-6">Coordonnées</h3>
                    <div class="space-y-5">
                        <div class="flex items-start gap-4">
                            <i class="fas fa-envelope text-white/20 mt-1 w-4"></i>
                            <div>
                                <div class="text-[9px] uppercase tracking-widest text-zinc-600 mb-1">Email</div>
                                <a href="mailto:contact@lafakh.fr" class="text-sm font-bold hover:text-zinc-300 transition">contact@lafakh.fr</a>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <i class="fas fa-phone-alt text-white/20 mt-1 w-4"></i>
                            <div>
                                <div class="text-[9px] uppercase tracking-widest text-zinc-600 mb-1">Téléphone</div>
                                <a href="tel:+33600000000" class="text-sm font-bold hover:text-zinc-300 transition">+33 6 00 00 00 00</a>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <i class="fas fa-map-marker-alt text-white/20 mt-1 w-4"></i>
                            <div>
                                <div class="text-[9px] uppercase tracking-widest text-zinc-600 mb-1">Studio</div>
                                <div class="text-sm font-bold">Reims, France</div>
                                <div class="text-[10px] text-zinc-600 mt-1 italic">Déplacements nationaux & internationaux</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Réseaux sociaux -->
                <div class="info-card">
                    <h3 class="text-[9px] font-black uppercase tracking-[0.4em] text-white/30 mb-4">Suivez-nous</h3>
                    <div>
                        <a href="#" class="social-link">
                            <i class="fab fa-instagram"></i>
                            <span>Instagram</span>
                            <span class="ml-auto text-[8px] opacity-30">→</span>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-tiktok"></i>
                            <span>TikTok</span>
                            <span class="ml-auto text-[8px] opacity-30">→</span>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-vimeo-v"></i>
                            <span>Vimeo</span>
                            <span class="ml-auto text-[8px] opacity-30">→</span>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-youtube"></i>
                            <span>YouTube</span>
                            <span class="ml-auto text-[8px] opacity-30">→</span>
                        </a>
                    </div>
                </div>

                <!-- Délai de réponse -->
                <div class="info-card">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
                        <span class="text-[9px] font-black uppercase tracking-widest text-green-400">Disponible</span>
                    </div>
                    <p class="text-[10px] text-zinc-500 leading-relaxed">
                        Réponse sous <span class="text-white">24h</span> en semaine. Pour les projets urgents, contactez-nous directement par téléphone.
                    </p>
                </div>
            </div>
        </div>
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
            mobileMenu.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    burgerBtn.classList.remove('open');
                    mobileMenu.classList.remove('open');
                    document.body.style.overflow = 'auto';
                });
            });
        });

        // Scroll reveal
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) { entry.target.classList.add('visible'); observer.unobserve(entry.target); }
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        // Toast
        function showToast(msg, success = true) {
            const toast = document.getElementById('toast');
            toast.textContent = msg;
            toast.style.background = success ? '#fff' : '#ff4444';
            toast.style.color = success ? '#000' : '#fff';
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 4000);
        }

        // Form submit
        document.getElementById('contact-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = document.getElementById('submit-btn');
            btn.classList.add('loading');
            btn.disabled = true;

            fetch('send_message.php', {
                method: 'POST',
                body: new FormData(this)
            })
            .then(res => res.text())
            .then(() => {
                showToast('Message envoyé avec succès !');
                this.reset();
            })
            .catch(() => {
                showToast('Erreur lors de l\'envoi. Réessayez.', false);
            })
            .finally(() => {
                btn.classList.remove('loading');
                btn.disabled = false;
            });
        });
    </script>
</body>
</html>
