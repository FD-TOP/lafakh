<?php
session_start();

// 1. SÉCURITÉ : Vérifier si l'admin est connecté
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

require 'db.php';

// --- LOGIQUE PORTFOLIO ---
$query_projets = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC");
$projects = $query_projets->fetchAll(PDO::FETCH_ASSOC);

// --- LOGIQUE MESSAGES ---
$query_messages = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC");
$messages = $query_messages->fetchAll(PDO::FETCH_ASSOC);

if(isset($_GET['del_msg'])) {
    $stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->execute([$_GET['del_msg']]);
    header("Location: admin.php#messages");
    exit();
}

// --- LOGIQUE BOUTIQUE (PRODUITS) ---
if (isset($_POST['add_product'])) {
    $name = htmlspecialchars($_POST['name']);
    $price = $_POST['price'];
    $category = $_POST['category'];
    $buy_link = $_POST['buy_link'];
    
    $target_dir = "uploads/shop/";
    if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
    
    $image_name = time() . "_" . basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image_name;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $stmt = $pdo->prepare("INSERT INTO products (name, price, category, buy_link, image_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $price, $category, $buy_link, $target_file]);
        header("Location: admin.php#shop");
        exit();
    }
}

if (isset($_GET['delete_prod'])) {
    $id = $_GET['delete_prod'];
    $stmt = $pdo->prepare("SELECT image_path FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $prod = $stmt->fetch();
    
    if ($prod && file_exists($prod['image_path'])) {
        unlink($prod['image_path']);
    }

    $pdo->prepare("DELETE FROM products WHERE id = ?")->execute([$id]);
    header("Location: admin.php#shop");
    exit();
}

$products = $pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>LA FAKH | Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #050505; color: #fff; scroll-behavior: smooth; }
        .brutal-text { font-family: 'Inter', sans-serif; text-transform: uppercase; font-style: italic; }
        .glass { background: rgba(15, 15, 15, 0.8); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.05); }
        
        /* Onglets */
        .admin-tab { 
            font-size: 11px; font-weight: 900; text-transform: uppercase; font-style: italic; 
            letter-spacing: 0.1em; padding-bottom: 28px; padding-top: 28px; transition: 0.3s; 
            border-bottom: 2px solid transparent; opacity: 0.4;
        }
        .admin-tab.active { border-color: white; opacity: 1; }
        
        .tab-content { display: none; animation: fadeIn 0.4s ease; }
        .tab-content.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        input, select, textarea { background: #0f0f0f !important; border: 1px solid #1a1a1a !important; color: white !important; outline: none; }
        input:focus { border-color: #333 !important; }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    <nav class="glass sticky top-0 z-[100] border-b border-white/5 px-8 flex justify-between items-center">
        <div class="flex items-center gap-12">
            <div class="text-xl font-black tracking-tighter uppercase italic">LA FAKH</div>
            <div class="hidden md:flex gap-8">
                <button onclick="switchTab('projets')" id="tab-btn-projets" class="admin-tab active">Portfolio</button>
                <button onclick="switchTab('messages')" id="tab-btn-messages" class="admin-tab flex items-center gap-2">
                    Messages <span class="bg-white text-black px-1.5 py-0.5 rounded-full text-[8px] font-black"><?= count($messages) ?></span>
                </button>
                <button onclick="switchTab('shop')" id="tab-btn-shop" class="admin-tab">Boutique</button>
            </div>
        </div>

        <div class="flex items-center gap-6">
            <a href="index.php" target="_blank" class="text-[10px] font-bold uppercase opacity-40 hover:opacity-100 transition">Voir Site</a>
            <a href="logout.php" class="bg-red-600/10 text-red-500 border border-red-500/20 px-4 py-2 rounded-full text-[9px] font-black uppercase tracking-widest hover:bg-red-600 hover:text-white transition">
                <i class="fas fa-power-off mr-2"></i> Déconnexion
            </a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto w-full p-8 md:p-12">

        <div id="content-projets" class="tab-content active space-y-16">
            <section class="glass p-10 rounded-3xl">
                <h2 class="text-2xl font-black mb-8 uppercase italic underline underline-offset-8 decoration-1">Nouveau projet</h2>
                <form action="save_project.php" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                    <div class="md:col-span-2">
                        <label class="text-[9px] uppercase text-zinc-500 font-bold">Titre</label>
                        <input type="text" name="title" required class="w-full p-4 rounded-xl text-xs">
                    </div>
                    <div>
                        <label class="text-[9px] uppercase text-zinc-500 font-bold">Format Média</label>
                        <select name="media_type" class="w-full p-4 rounded-xl text-xs">
                            <option value="image">IMAGE / PHOTO</option>
                            <option value="video">VIDÉO / MP4</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-[9px] uppercase text-zinc-500 font-bold">Lien Externe</label>
                        <input type="url" name="external_link" placeholder="YouTube" class="w-full p-4 rounded-xl text-xs">
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-[10px] uppercase text-white font-black block mb-2 underline">1. Photo de couverture</label>
                        <input type="file" name="thumbnail_file" required class="text-[10px] text-zinc-500 block w-full file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-white file:text-black">
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-[10px] uppercase text-zinc-500 font-bold block mb-2">2. Médias principaux (multiples)</label>
                        <input type="file" name="media_files[]" multiple required class="text-[10px] text-zinc-500 block w-full file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-zinc-800 file:text-white">
                    </div>
                    <button type="submit" class="md:col-span-4 bg-white text-black font-black uppercase text-[10px] py-4 rounded-full tracking-widest mt-4 hover:bg-zinc-200 transition">Publier le projet</button>
                </form>
            </section>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach($projects as $p): ?>
                <div class="glass rounded-2xl overflow-hidden group">
                    <div class="aspect-video relative overflow-hidden bg-zinc-900">
                        <img src="<?= htmlspecialchars($p['thumbnail_path']) ?>" class="w-full h-full object-cover opacity-70 group-hover:opacity-100 transition duration-700">
                        <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-4">
                            <a href="edit_project.php?id=<?= $p['id'] ?>" class="bg-white text-black w-10 h-10 rounded-full flex items-center justify-center hover:scale-110 transition"><i class="fas fa-pen text-[10px]"></i></a>
                            <a href="delete_project.php?id=<?= $p['id'] ?>" onclick="return confirm('Confirmer ?')" class="bg-red-600 text-white w-10 h-10 rounded-full flex items-center justify-center hover:scale-110 transition"><i class="fas fa-trash-alt text-[10px]"></i></a>
                        </div>
                    </div>
                    <div class="p-5 flex justify-between items-center">
                        <p class="text-[10px] font-black uppercase tracking-widest truncate w-32"><?= htmlspecialchars($p['title']) ?></p>
                        <span class="text-[8px] text-zinc-400 border border-zinc-800 px-2 py-0.5 rounded uppercase italic">PROJET</span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div id="content-messages" class="tab-content space-y-10">
            <h2 class="text-3xl font-black brutal-text italic">BOÎTE DE RÉCEPTION</h2>
            <?php if(empty($messages)): ?>
                <div class="glass p-20 text-center rounded-3xl opacity-30 italic text-xs uppercase tracking-widest">Aucun message</div>
            <?php else: ?>
                <div class="grid grid-cols-1 gap-6">
                    <?php foreach($messages as $m): ?>
                    <div class="glass p-8 rounded-3xl flex flex-col md:flex-row justify-between items-start md:items-center gap-8 hover:border-white/10 transition">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <p class="text-xs font-black uppercase text-white"><?= htmlspecialchars($m['nom']) ?></p>
                                <span class="text-[9px] text-zinc-600 font-mono"><?= $m['created_at'] ?></span>
                            </div>
                            <p class="text-[11px] text-zinc-400 font-bold uppercase mb-3 tracking-wide italic"><?= htmlspecialchars($m['sujet']) ?></p>
                            <div class="bg-black/20 p-4 rounded-xl border border-white/5 text-xs text-zinc-500 leading-relaxed"><?= nl2br(htmlspecialchars($m['message'])) ?></div>
                            <p class="text-[10px] text-zinc-600 mt-4 italic"><?= htmlspecialchars($m['email'] )?></p>
                        </div>
                        <div class="flex md:flex-col gap-4">
                            <a href="mailto:<?= $m['email'] ?>" class="text-[10px] font-bold uppercase tracking-widest bg-white/5 px-6 py-3 rounded-full hover:bg-white hover:text-black transition">Répondre</a>
                            <a href="admin.php?del_msg=<?= $m['id'] ?>" onclick="return confirm('Effacer ?')" class="text-red-500/40 hover:text-red-500 transition text-center p-2"><i class="fas fa-trash"></i></a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div id="content-shop" class="tab-content space-y-16">
            <div class="flex items-center gap-6 mb-10">
                <h2 class="text-3xl font-black brutal-text italic">BOUTIQUE</h2>
                <div class="h-[1px] flex-1 bg-white/10"></div>
                <button onclick="document.getElementById('add-prod-form').scrollIntoView({behavior: 'smooth'})" class="hidden md:block text-[10px] font-black uppercase tracking-widest border border-white/20 px-6 py-2 rounded-full hover:bg-white hover:text-black transition">
                    + Nouveau Asset
                </button>
                <span class="text-[10px] font-bold opacity-30 uppercase tracking-widest"><?= count($products) ?> Éléments</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                <div class="lg:col-span-4" id="add-prod-form">
                    <div class="bg-zinc-900/50 p-8 rounded-3xl border border-white/5 sticky top-32">
                        <h3 class="text-xs font-black uppercase tracking-[0.3em] mb-8 opacity-50">Ajouter un Asset</h3>
                        <form action="admin.php" method="POST" enctype="multipart/form-data" class="space-y-5">
                            <div>
                                <label class="text-[10px] uppercase font-bold opacity-30 mb-2 block">Nom du produit</label>
                                <input type="text" name="name" required class="w-full p-4 rounded-xl text-sm">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-[10px] uppercase font-bold opacity-30 mb-2 block">Prix (€)</label>
                                    <input type="number" step="0.01" name="price" required class="w-full p-4 rounded-xl text-sm">
                                </div>
                                <div>
                                    <label class="text-[10px] uppercase font-bold opacity-30 mb-2 block">Catégorie</label>
                                    <select name="category" class="w-full p-4 rounded-xl text-sm">
                                        <option value="LUTs">LUTs</option>
                                        <option value="Presets">Presets</option>
                                        <option value="Assets">Assets</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="text-[10px] uppercase font-bold opacity-30 mb-2 block">Lien d'achat URL</label>
                                <input type="url" name="buy_link" placeholder="https://..." required class="w-full p-4 rounded-xl text-sm">
                            </div>
                            <div>
                                <label class="text-[10px] uppercase font-bold opacity-30 mb-2 block">Couverture</label>
                                <input type="file" name="image" required class="text-[10px] text-zinc-500 block w-full file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-white file:text-black">
                            </div>
                            <button type="submit" name="add_product" class="w-full bg-white text-black font-black py-4 rounded-xl uppercase text-[10px] tracking-[0.2em] hover:bg-zinc-200 transition">Mettre en ligne</button>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php foreach ($products as $p): ?>
                        <div class="group bg-zinc-900/30 border border-white/5 p-4 rounded-2xl flex items-center gap-5 hover:border-white/20 transition">
                            <img src="<?= $p['image_path'] ?>" class="w-20 h-20 rounded-xl object-cover">
                            <div class="flex-1">
                                <h4 class="text-xs font-black uppercase truncate"><?= htmlspecialchars($p['name']) ?></h4>
                                <p class="text-[9px] mt-1 text-white/40 font-bold"><?= $p['price'] ?>€ — <?= $p['category'] ?></p>
                            </div>
                            <a href="admin.php?delete_prod=<?= $p['id'] ?>" onclick="return confirm('Supprimer ?')" class="opacity-0 group-hover:opacity-100 p-3 text-zinc-600 hover:text-red-500 transition"><i class="fas fa-trash-alt"></i></a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function switchTab(tabName) {
            // Masquer tous les contenus
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });

            // Désactiver tous les boutons
            document.querySelectorAll('.admin-tab').forEach(tab => {
                tab.classList.remove('active');
            });

            // Afficher le contenu et activer le bouton
            document.getElementById('content-' + tabName).classList.add('active');
            document.getElementById('tab-btn-' + tabName).classList.add('active');
            
            // Mettre à jour l'URL sans recharger
            window.location.hash = tabName;
        }

        // Gestion du chargement initial via le Hash (#)
        window.onload = () => {
            const hash = window.location.hash.replace('#', '');
            if (hash === 'messages') switchTab('messages');
            else if (hash === 'shop') switchTab('shop');
            else switchTab('projets');
        }
    </script>
</body>
</html>