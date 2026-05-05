<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MENTIONS LÉGALES | LA FAKH</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;900&family=Space+Grotesk:wght@300;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        html, body { height: 100%; margin: 0; }
        body { font-family: 'Space Grotesk', sans-serif; background-color: #000; color: #fff; display: flex; flex-direction: column; }
        .brutal-text { font-family: 'Inter', sans-serif; text-transform: uppercase; font-style: italic; }

        /* --- MENU BURGER --- */
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

        /* --- CONTENU --- */
        main { flex: 1 0 auto; margin-bottom: 100px; }
        .legal-section h2 { 
            font-family: 'Inter'; font-weight: 900; text-transform: uppercase; 
            font-size: 12px; letter-spacing: 0.3em; color: #555; margin-bottom: 20px;
            border-left: 2px solid #fff; padding-left: 15px;
        }
        .legal-section p { color: #888; font-size: 14px; line-height: 1.8; margin-bottom: 40px; }


        /* Structure pour coller le footer en bas */
html, body {
    height: 100%;
    margin: 0;
}

body {
    display: flex;
    flex-direction: column;
}

/* Le contenu s'étire et laisse un espace de 100px minimum avant le footer */
main {
    flex: 1 0 auto;
    margin-bottom: 100px; 
}

footer {
    flex-shrink: 0;
    background-color: #000;
    border-t: 1px solid rgba(255,255,255,0.05);
}

.footer-link {
    font-size: 10px;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 0.2em;
    color: #666;
    transition: 0.3s;
}

.footer-link:hover {
    color: #fff;
    padding-left: 5px; /* Petit effet de décalage au survol */
}
    </style>
</head>
<body>

    <header class="flex justify-between items-center px-10 h-24 sticky top-0 bg-black/80 backdrop-blur-md z-[110]">
        <div class="font-black brutal-text italic text-xl">LA FAKH</div>
        <nav class="hidden md:flex gap-10 text-[10px] font-bold uppercase tracking-[0.2em]">
            <a href="index.php" class="opacity-50 hover:opacity-100 transition">Accueil</a>
            <a href="portfolio.php" class="opacity-50 hover:opacity-100 transition">Portfolio</a>
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
        <a href="contact.php">Contact</a>
        <a href="a-propos.php">À Propos</a>
    </div>

    <main class="max-w-3xl mx-auto pt-20 px-6">
        <h1 class="text-5xl md:text-7xl font-black brutal-text italic mb-20">MENTIONS<br>LÉGALES.</h1>

        <div class="legal-section">
            <h2>01. ÉDITEUR DU SITE</h2>
            <p>
                Le présent site est édité par l'agence **LA FAKH STUDIO**, Société par Actions Simplifiée (SAS) au capital de XXX €, immatriculée au Registre du Commerce et des Sociétés de Reims sous le numéro XXX XXX XXX.<br>
                Siège social : [Ton Adresse ici], Reims, France.<br>
                Directeur de la publication : [Ton Nom].
            </p>

            <h2>02. HÉBERGEMENT</h2>
            <p>
                Le site est hébergé par la société **Hostinger International Ltd.**, dont le siège social est situé au 61 Lordou Vironos Street, 6023 Larnaca, Chypre.
            </p>

            <h2>03. PROPRIÉTÉ INTELLECTUELLE</h2>
            <p>
                L'ensemble du contenu de ce site (textes, images, vidéos, logos) est la propriété exclusive de **LA FAKH STUDIO**. Toute reproduction, distribution ou modification de ces éléments est strictement interdite sans accord préalable écrit.
            </p>

            <h2>04. DONNÉES PERSONNELLES</h2>
            <p>
                Conformément au RGPD, vous disposez d'un droit d'accès, de rectification et de suppression des données vous concernant. Les informations collectées via le formulaire de contact sont uniquement destinées à la gestion de vos demandes par notre agence.
            </p>

            <h2>05. COOKIES</h2>
            <p>
                Ce site peut utiliser des cookies pour améliorer votre expérience de navigation. Vous pouvez configurer votre navigateur pour refuser ces cookies à tout moment.
            </p>
        </div>
    </main>

    <footer>
    <div class="max-w-7xl mx-auto px-6 py-20">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-20">
            
            <div class="md:col-span-1">
                <div class="text-xl font-black brutal-text italic mb-6">LA FAKH</div>
                <p class="text-[10px] text-zinc-500 uppercase tracking-widest leading-relaxed">
                    Production audiovisuelle basée à Reims. Nous transformons vos idées en expériences visuelles brutales et mémorables.
                </p>
            </div>

            <div>
                <h4 class="text-[9px] font-black uppercase tracking-[0.4em] text-white/30 mb-8 text-center md:text-left">Services</h4>
                <ul class="space-y-4 flex flex-col items-center md:items-start">
                    <li class="footer-link cursor-default">Vlog & Lifestyle</li>
                    <li class="footer-link cursor-default">Institutionnel</li>
                    <li class="footer-link cursor-default">Publicité Digitale</li>
                    <li class="footer-link cursor-default">Post-Production</li>
                </ul>
            </div>

            <div>
                <h4 class="text-[9px] font-black uppercase tracking-[0.4em] text-white/30 mb-8 text-center md:text-left">Studio</h4>
                <ul class="space-y-4 flex flex-col items-center md:items-start text-center md:text-left">
                    <li><a href="portfolio.php" class="footer-link">Portfolio</a></li>
                    <li><a href="a-propos.php" class="footer-link">L'Agence</a></li>
                    <li><a href="contact.php" class="footer-link">Contact</a></li>
                    <li><a href="mentions-legales.php" class="footer-link">Mentions Légales</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-[9px] font-black uppercase tracking-[0.4em] text-white/30 mb-8 text-center md:text-left">Direct</h4>
                <div class="space-y-4 flex flex-col items-center md:items-start text-center md:text-left">
                    <div class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">
                        <i class="fas fa-phone-alt mr-2 opacity-30"></i> +33 6 00 00 00 00
                    </div>
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
            <div class="text-[8px] uppercase tracking-[0.5em] text-zinc-700">
                © 2026 LA FAKH STUDIO — DESIGNED FOR EXCELLENCE
            </div>
            
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

            function toggleMenu() {
                burgerBtn.classList.toggle('open');
                mobileMenu.classList.toggle('open');
                document.body.style.overflow = mobileMenu.classList.contains('open') ? 'hidden' : 'auto';
            }

            burgerBtn.addEventListener('click', toggleMenu);
        });
    </script>
</body>
</html>