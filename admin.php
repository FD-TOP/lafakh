<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php"); exit();
}
require 'db.php';

// ===== ACTIONS =====
// Supprimer message
if (isset($_GET['del_msg']) && $pdo) {
    $pdo->prepare("DELETE FROM messages WHERE id=?")->execute([$_GET['del_msg']]);
    header("Location: admin.php#messages"); exit();
}
// Supprimer projet
if (isset($_GET['del_proj']) && $pdo) {
    $stmt = $pdo->prepare("SELECT thumbnail_path FROM projects WHERE id=?");
    $stmt->execute([$_GET['del_proj']]);
    $proj = $stmt->fetch();
    if ($proj && $proj['thumbnail_path'] && file_exists($proj['thumbnail_path'])) @unlink($proj['thumbnail_path']);
    $pdo->prepare("DELETE FROM projects WHERE id=?")->execute([$_GET['del_proj']]);
    $pdo->prepare("DELETE FROM comments WHERE project_id=?")->execute([$_GET['del_proj']]);
    header("Location: admin.php#portfolio"); exit();
}
// Supprimer produit
if (isset($_GET['del_prod']) && $pdo) {
    $stmt = $pdo->prepare("SELECT image_path FROM products WHERE id=?");
    $stmt->execute([$_GET['del_prod']]);
    $prod = $stmt->fetch();
    if ($prod && $prod['image_path'] && file_exists($prod['image_path'])) @unlink($prod['image_path']);
    $pdo->prepare("DELETE FROM products WHERE id=?")->execute([$_GET['del_prod']]);
    header("Location: admin.php#shop"); exit();
}
// Supprimer commentaire
if (isset($_GET['del_comment']) && $pdo) {
    $pdo->prepare("DELETE FROM comments WHERE id=?")->execute([$_GET['del_comment']]);
    header("Location: admin.php#comments"); exit();
}
// Approuver/désapprouver commentaire
if (isset($_GET['toggle_comment']) && $pdo) {
    $stmt = $pdo->prepare("SELECT approved FROM comments WHERE id=?");
    $stmt->execute([$_GET['toggle_comment']]);
    $c = $stmt->fetch();
    if ($c) $pdo->prepare("UPDATE comments SET approved=? WHERE id=?")->execute([($c['approved']?0:1), $_GET['toggle_comment']]);
    header("Location: admin.php#comments"); exit();
}
// Ajouter produit
if (isset($_POST['add_product']) && $pdo) {
    $dir = "uploads/shop/";
    if (!is_dir($dir)) mkdir($dir, 0777, true);
    $img_path = '';
    if (!empty($_FILES['image']['name'])) {
        $fn = time() . '_' . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $dir.$fn)) $img_path = $dir.$fn;
    }
    $stmt = $pdo->prepare("INSERT INTO products (name,price,category,buy_link,image_path,description,`includes`,compat,badge) VALUES (?,?,?,?,?,?,?,?,?)");
    $stmt->execute([
        $_POST['name'], $_POST['price'], $_POST['category'],
        $_POST['buy_link'] ?? '', $img_path,
        $_POST['description'] ?? '', $_POST['includes'] ?? '',
        $_POST['compat'] ?? '', $_POST['badge'] ?? ''
    ]);
    header("Location: admin.php#shop"); exit();
}

// ===== DATA FETCH =====
$projects = $messages = $products = $comments = [];
try {
    if ($pdo) {
        $projects = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
        $messages = $pdo->query("SELECT * FROM messages  ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
        $products = $pdo->query("SELECT * FROM products  ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
        $comments = $pdo->query("SELECT c.*, p.title as project_title FROM comments c LEFT JOIN projects p ON c.project_id=p.id ORDER BY c.created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (\Throwable $e) {}

$unread_msg      = count(array_filter($messages, fn($m) => ($m['read_at'] ?? null) === null));
$pending_comment = count(array_filter($comments, fn($c) => !$c['approved']));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LA FAKH | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background: #040404; color: #fff; min-height: 100vh; }
        .brutal { font-family: 'Inter', sans-serif; text-transform: uppercase; font-style: italic; }
        .panel { background: #0a0a0a; border: 1px solid rgba(255,255,255,.07); }
        input, select, textarea { background: #0d0d0d !important; border: 1px solid #1c1c1c !important; color: #fff !important; outline: none; transition: border-color .2s; }
        input:focus, select:focus, textarea:focus { border-color: #444 !important; }
        .tab-btn { font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: .12em; padding: 22px 0; border-bottom: 2px solid transparent; opacity: .35; transition: all .3s; cursor: pointer; background: none; border-left: none; border-right: none; border-top: none; color: #fff; }
        .tab-btn.active { opacity: 1; border-bottom-color: #fff; }
        .tab-content { display: none; }
        .tab-content.active { display: block; animation: fadeUp .35s ease; }
        @keyframes fadeUp { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
        .badge-count { background: #fff; color: #000; font-size: 7px; font-weight: 900; padding: 2px 6px; border-radius: 20px; margin-left: 6px; }
        .badge-orange { background: #f97316; color: #000; }
        .action-btn { font-size: 8px; font-weight: 900; text-transform: uppercase; letter-spacing: .15em; padding: 6px 14px; border: 1px solid rgba(255,255,255,.15); background: none; color: rgba(255,255,255,.6); cursor: pointer; transition: all .2s; }
        .action-btn:hover { background: #fff; color: #000; border-color: #fff; }
        .action-btn.danger { border-color: rgba(239,68,68,.3); color: rgba(239,68,68,.6); }
        .action-btn.danger:hover { background: rgb(239,68,68); color: #fff; border-color: rgb(239,68,68); }
        .stat-card { background: #0a0a0a; border: 1px solid rgba(255,255,255,.06); padding: 20px 24px; }
        .db-warning { background: rgba(251,191,36,.05); border: 1px solid rgba(251,191,36,.2); color: rgba(251,191,36,.8); font-size: 10px; font-weight: 700; padding: 12px 20px; letter-spacing: .05em; }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="sticky top-0 z-50 bg-black/95 backdrop-blur-md border-b border-white/5 px-6 md:px-10 flex justify-between items-center h-16">
    <div class="flex items-center gap-8">
        <div class="text-sm font-black brutal">LA FAKH <span class="opacity-30">ADMIN</span></div>
        <div class="hidden md:flex gap-6">
            <button onclick="switchTab('portfolio')" id="tab-portfolio" class="tab-btn active">
                <i class="fas fa-film mr-1.5 opacity-50"></i> Portfolio
                <span class="badge-count"><?= count($projects) ?></span>
            </button>
            <button onclick="switchTab('shop')" id="tab-shop" class="tab-btn">
                <i class="fas fa-store mr-1.5 opacity-50"></i> Shop
                <span class="badge-count"><?= count($products) ?></span>
            </button>
            <button onclick="switchTab('messages')" id="tab-messages" class="tab-btn">
                <i class="fas fa-inbox mr-1.5 opacity-50"></i> Messages
                <?php if($unread_msg > 0): ?><span class="badge-count badge-orange"><?= $unread_msg ?></span><?php else: ?><span class="badge-count"><?= count($messages) ?></span><?php endif; ?>
            </button>
            <button onclick="switchTab('comments')" id="tab-comments" class="tab-btn">
                <i class="fas fa-comments mr-1.5 opacity-50"></i> Commentaires
                <?php if($pending_comment > 0): ?><span class="badge-count badge-orange"><?= $pending_comment ?></span><?php else: ?><span class="badge-count"><?= count($comments) ?></span><?php endif; ?>
            </button>
        </div>
    </div>
    <div class="flex items-center gap-4">
        <a href="index.php" target="_blank" class="text-[9px] font-bold uppercase opacity-30 hover:opacity-100 transition">Voir le site ↗</a>
        <a href="logout.php" class="action-btn danger"><i class="fas fa-power-off mr-1.5"></i> Déconnexion</a>
    </div>
</nav>

<!-- Mobile tabs -->
<div class="md:hidden flex border-b border-white/5 px-4 overflow-x-auto gap-4">
    <button onclick="switchTab('portfolio')" id="tab-m-portfolio" class="tab-btn active whitespace-nowrap">Portfolio</button>
    <button onclick="switchTab('shop')"      id="tab-m-shop"      class="tab-btn whitespace-nowrap">Shop</button>
    <button onclick="switchTab('messages')"  id="tab-m-messages"  class="tab-btn whitespace-nowrap">Messages</button>
    <button onclick="switchTab('comments')"  id="tab-m-comments"  class="tab-btn whitespace-nowrap">Commentaires</button>
</div>

<?php if (!$pdo): ?>
<div class="db-warning mx-6 mt-4 flex items-center gap-3">
    <i class="fas fa-exclamation-triangle"></i>
    Base de données non connectée — les données ne seront pas sauvegardées. Configure les variables d'environnement DB_HOST, DB_NAME, DB_USER, DB_PASS.
</div>
<?php endif; ?>

<main class="max-w-7xl mx-auto px-4 md:px-8 py-8">

    <!-- ==================== PORTFOLIO ==================== -->
    <div class="tab-content active" id="content-portfolio">

        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-8">
            <div class="stat-card"><div class="text-2xl font-black"><?= count($projects) ?></div><div class="text-[9px] text-zinc-500 uppercase tracking-widest mt-1">Projets total</div></div>
            <div class="stat-card"><div class="text-2xl font-black"><?= count(array_filter($projects, fn($p) => ($p['type']??'photo')==='video')) ?></div><div class="text-[9px] text-zinc-500 uppercase tracking-widest mt-1">Vidéos</div></div>
            <div class="stat-card"><div class="text-2xl font-black"><?= count(array_filter($projects, fn($p) => ($p['type']??'photo')==='photo')) ?></div><div class="text-[9px] text-zinc-500 uppercase tracking-widest mt-1">Photos</div></div>
            <div class="stat-card"><div class="text-2xl font-black"><?= count(array_unique(array_column($projects,'category'))) ?></div><div class="text-[9px] text-zinc-500 uppercase tracking-widest mt-1">Catégories</div></div>
        </div>

        <!-- Formulaire ajout -->
        <div class="panel p-6 md:p-8 mb-8">
            <h2 class="text-sm font-black uppercase tracking-widest mb-6 flex items-center gap-3">
                <i class="fas fa-plus-circle opacity-50"></i> Ajouter un projet
            </h2>
            <form action="save_project.php" method="POST" enctype="multipart/form-data">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="md:col-span-2">
                        <label class="text-[9px] uppercase text-zinc-500 font-bold block mb-1.5">Titre du projet *</label>
                        <input type="text" name="title" required placeholder="ex: REEL SUMMER 2026" class="w-full p-3 text-sm rounded">
                    </div>
                    <div>
                        <label class="text-[9px] uppercase text-zinc-500 font-bold block mb-1.5">Catégorie</label>
                        <input type="text" name="category" placeholder="Vlog, Cinéma, Clip..." class="w-full p-3 text-sm rounded">
                    </div>
                    <div>
                        <label class="text-[9px] uppercase text-zinc-500 font-bold block mb-1.5">Type de média *</label>
                        <select name="media_type" class="w-full p-3 text-sm rounded">
                            <option value="photo">Photo / Image</option>
                            <option value="video">Vidéo (YouTube / MP4)</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-[9px] uppercase text-zinc-500 font-bold block mb-1.5">Lien vidéo (YouTube embed)</label>
                        <input type="url" name="video_embed" placeholder="https://www.youtube.com/embed/ID" class="w-full p-3 text-sm rounded">
                    </div>
                    <div>
                        <label class="text-[9px] uppercase text-zinc-500 font-bold block mb-1.5">Lien externe (optionnel)</label>
                        <input type="url" name="external_link" placeholder="https://youtube.com/watch?v=..." class="w-full p-3 text-sm rounded">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="text-[9px] uppercase font-black block mb-1.5">Photo de couverture *</label>
                        <input type="file" name="thumbnail_file" required accept="image/*" class="w-full text-xs text-zinc-400 file:mr-3 file:py-2 file:px-4 file:border-0 file:bg-white file:text-black file:font-bold file:text-xs file:cursor-pointer">
                    </div>
                    <div>
                        <label class="text-[9px] uppercase text-zinc-500 font-bold block mb-1.5">Médias supplémentaires (optionnel)</label>
                        <input type="file" name="media_files[]" multiple accept="image/*,video/mp4" class="w-full text-xs text-zinc-400 file:mr-3 file:py-2 file:px-4 file:border-0 file:bg-zinc-800 file:text-white file:font-bold file:text-xs file:cursor-pointer">
                    </div>
                </div>
                <button type="submit" class="w-full bg-white text-black font-black uppercase text-[10px] tracking-widest py-3.5 hover:bg-zinc-200 transition">
                    <i class="fas fa-cloud-upload-alt mr-2"></i> Publier le projet
                </button>
            </form>
        </div>

        <!-- Liste projets -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            <?php if(empty($projects)): ?>
            <div class="col-span-4 text-center py-20 text-zinc-600">
                <i class="fas fa-folder-open text-3xl block mb-3 opacity-20"></i>
                <p class="text-xs uppercase tracking-widest">Aucun projet — ajoutes-en un ci-dessus</p>
            </div>
            <?php else: foreach($projects as $p): ?>
            <div class="panel overflow-hidden group">
                <div class="aspect-video relative overflow-hidden bg-zinc-900">
                    <img src="<?= htmlspecialchars($p['thumbnail_path']??'') ?>" class="w-full h-full object-cover opacity-70 group-hover:opacity-100 transition duration-500" loading="lazy">
                    <div class="absolute inset-0 bg-black/70 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-3">
                        <a href="edit_project.php?id=<?= $p['id'] ?>" class="action-btn"><i class="fas fa-pen"></i></a>
                        <a href="admin.php?del_proj=<?= $p['id'] ?>" onclick="return confirm('Supprimer ce projet ?')" class="action-btn danger"><i class="fas fa-trash"></i></a>
                    </div>
                    <?php if(($p['type']??'photo')==='video'): ?>
                    <div class="absolute bottom-2 left-2 bg-white text-black text-[7px] font-black uppercase px-2 py-0.5"><i class="fas fa-play mr-1"></i>Vidéo</div>
                    <?php endif; ?>
                </div>
                <div class="p-4 flex justify-between items-center">
                    <div>
                        <div class="text-[10px] font-black uppercase tracking-widest truncate"><?= htmlspecialchars($p['title']??'') ?></div>
                        <div class="text-[8px] text-zinc-600 mt-0.5 uppercase"><?= htmlspecialchars($p['category']??'') ?></div>
                    </div>
                    <div class="text-[8px] text-zinc-700">#<?= $p['id'] ?></div>
                </div>
            </div>
            <?php endforeach; endif; ?>
        </div>
    </div>

    <!-- ==================== SHOP ==================== -->
    <div class="tab-content" id="content-shop">

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

            <!-- Formulaire -->
            <div class="lg:col-span-2">
                <div class="panel p-6 sticky top-24">
                    <h2 class="text-sm font-black uppercase tracking-widest mb-6 flex items-center gap-3">
                        <i class="fas fa-plus-circle opacity-50"></i> Nouveau produit
                    </h2>
                    <form action="admin.php" method="POST" enctype="multipart/form-data" class="space-y-4">
                        <div>
                            <label class="text-[9px] uppercase text-zinc-500 font-bold block mb-1.5">Nom *</label>
                            <input type="text" name="name" required placeholder="CINEMATIC PACK V3" class="w-full p-3 text-sm rounded">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-[9px] uppercase text-zinc-500 font-bold block mb-1.5">Prix (€) *</label>
                                <input type="number" step="0.01" name="price" required class="w-full p-3 text-sm rounded">
                            </div>
                            <div>
                                <label class="text-[9px] uppercase text-zinc-500 font-bold block mb-1.5">Catégorie</label>
                                <select name="category" class="w-full p-3 text-sm rounded">
                                    <option>Preset</option><option>LUT</option><option>Bundle</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="text-[9px] uppercase text-zinc-500 font-bold block mb-1.5">Badge</label>
                            <select name="badge" class="w-full p-3 text-sm rounded">
                                <option value="">Aucun</option>
                                <option value="new">Nouveau</option>
                                <option value="hot">Top</option>
                                <option value="bundle">Bundle</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-[9px] uppercase text-zinc-500 font-bold block mb-1.5">Description</label>
                            <textarea name="description" rows="2" placeholder="Description du produit..." class="w-full p-3 text-sm rounded resize-none"></textarea>
                        </div>
                        <div>
                            <label class="text-[9px] uppercase text-zinc-500 font-bold block mb-1.5">Ce qui est inclus (séparé par ·)</label>
                            <input type="text" name="includes" placeholder="10 Presets · XMP & DNG · Tutoriel" class="w-full p-3 text-sm rounded">
                        </div>
                        <div>
                            <label class="text-[9px] uppercase text-zinc-500 font-bold block mb-1.5">Compatibilité</label>
                            <input type="text" name="compat" placeholder="Lightroom CC · Premiere Pro" class="w-full p-3 text-sm rounded">
                        </div>
                        <div>
                            <label class="text-[9px] uppercase text-zinc-500 font-bold block mb-1.5">Lien d'achat</label>
                            <input type="url" name="buy_link" placeholder="https://gumroad.com/..." class="w-full p-3 text-sm rounded">
                        </div>
                        <div>
                            <label class="text-[9px] uppercase font-black block mb-1.5">Image de couverture *</label>
                            <input type="file" name="image" required accept="image/*" class="w-full text-xs text-zinc-400 file:mr-3 file:py-2 file:px-4 file:border-0 file:bg-white file:text-black file:font-bold file:cursor-pointer">
                        </div>
                        <button type="submit" name="add_product" class="w-full bg-white text-black font-black uppercase text-[10px] tracking-widest py-3.5 hover:bg-zinc-200 transition">
                            <i class="fas fa-cloud-upload-alt mr-2"></i> Mettre en ligne
                        </button>
                    </form>
                </div>
            </div>

            <!-- Liste produits -->
            <div class="lg:col-span-3 space-y-3">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-black uppercase tracking-widest"><?= count($products) ?> produits</h2>
                </div>
                <?php if(empty($products)): ?>
                <div class="text-center py-20 text-zinc-600">
                    <i class="fas fa-store text-3xl block mb-3 opacity-20"></i>
                    <p class="text-xs uppercase tracking-widest">Aucun produit</p>
                </div>
                <?php else: foreach($products as $p): ?>
                <div class="panel p-4 flex items-center gap-4 group hover:border-white/15 transition">
                    <img src="<?= htmlspecialchars($p['image_path']??'') ?>" class="w-14 h-14 object-cover flex-shrink-0 rounded" loading="lazy" onerror="this.style.display='none'">
                    <div class="flex-1 min-w-0">
                        <div class="text-[10px] font-black uppercase truncate"><?= htmlspecialchars($p['name']) ?></div>
                        <div class="text-[8px] text-zinc-600 mt-0.5"><?= $p['price'] ?>€ — <?= htmlspecialchars($p['category']??'') ?></div>
                        <?php if(!empty($p['description'])): ?>
                        <div class="text-[8px] text-zinc-700 mt-1 truncate"><?= htmlspecialchars($p['description']) ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition flex-shrink-0">
                        <a href="edit_project.php?type=product&id=<?= $p['id'] ?>" class="action-btn"><i class="fas fa-pen"></i></a>
                        <a href="admin.php?del_prod=<?= $p['id'] ?>" onclick="return confirm('Supprimer ce produit ?')" class="action-btn danger"><i class="fas fa-trash"></i></a>
                    </div>
                </div>
                <?php endforeach; endif; ?>
            </div>
        </div>
    </div>

    <!-- ==================== MESSAGES ==================== -->
    <div class="tab-content" id="content-messages">

        <div class="flex items-center gap-4 mb-6">
            <h2 class="text-sm font-black uppercase tracking-widest">Boîte de réception</h2>
            <span class="text-[9px] text-zinc-600"><?= count($messages) ?> message<?= count($messages)>1?'s':'' ?></span>
        </div>

        <?php if(empty($messages)): ?>
        <div class="text-center py-24 text-zinc-600 panel">
            <i class="fas fa-inbox text-3xl block mb-3 opacity-20"></i>
            <p class="text-xs uppercase tracking-widest">Aucun message pour le moment</p>
        </div>
        <?php else: foreach($messages as $m): ?>
        <div class="panel p-6 mb-4 hover:border-white/12 transition">
            <div class="flex flex-col md:flex-row md:items-start gap-4">
                <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-3 mb-2">
                        <span class="text-[11px] font-black uppercase"><?= htmlspecialchars($m['nom']) ?></span>
                        <span class="text-[9px] text-zinc-500"><?= htmlspecialchars($m['email']) ?></span>
                        <span class="text-[8px] text-zinc-700 font-mono"><?= $m['created_at'] ?></span>
                    </div>
                    <div class="text-[10px] font-bold uppercase text-zinc-400 mb-3 tracking-wide italic">
                        <?= htmlspecialchars($m['sujet']) ?>
                    </div>
                    <div class="bg-black/30 border border-white/5 p-4 text-xs text-zinc-400 leading-relaxed rounded">
                        <?= nl2br(htmlspecialchars($m['message'])) ?>
                    </div>
                </div>
                <div class="flex md:flex-col gap-2 flex-shrink-0">
                    <a href="mailto:<?= htmlspecialchars($m['email']) ?>?subject=Re: <?= urlencode($m['sujet']) ?>"
                       class="action-btn flex items-center gap-2">
                        <i class="fas fa-reply text-[9px]"></i> Répondre
                    </a>
                    <a href="admin.php?del_msg=<?= $m['id'] ?>" onclick="return confirm('Supprimer ce message ?')" class="action-btn danger">
                        <i class="fas fa-trash text-[9px]"></i>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; endif; ?>
    </div>

    <!-- ==================== COMMENTAIRES ==================== -->
    <div class="tab-content" id="content-comments">

        <div class="flex items-center gap-4 mb-6">
            <h2 class="text-sm font-black uppercase tracking-widest">Commentaires</h2>
            <?php if($pending_comment > 0): ?>
            <span class="bg-orange-500 text-black text-[8px] font-black px-2 py-0.5 rounded"><?= $pending_comment ?> en attente</span>
            <?php endif; ?>
        </div>

        <!-- Filtres -->
        <div class="flex gap-3 mb-5 flex-wrap">
            <button onclick="filterComments('all')"     class="action-btn" id="cf-all">Tous (<?= count($comments) ?>)</button>
            <button onclick="filterComments('pending')" class="action-btn" id="cf-pending">En attente (<?= $pending_comment ?>)</button>
            <button onclick="filterComments('approved')" class="action-btn" id="cf-approved">Approuvés (<?= count($comments)-$pending_comment ?>)</button>
        </div>

        <?php if(empty($comments)): ?>
        <div class="text-center py-24 text-zinc-600 panel">
            <i class="fas fa-comments text-3xl block mb-3 opacity-20"></i>
            <p class="text-xs uppercase tracking-widest">Aucun commentaire</p>
        </div>
        <?php else: foreach($comments as $c): ?>
        <div class="panel p-5 mb-3 comment-row <?= $c['approved'] ? 'approved' : 'pending' ?> hover:border-white/12 transition">
            <div class="flex flex-col md:flex-row md:items-start gap-4">
                <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-3 mb-2">
                        <span class="w-7 h-7 bg-zinc-800 rounded-full flex items-center justify-center text-[9px] font-black flex-shrink-0"><?= mb_strtoupper(mb_substr($c['author_name'],0,1)) ?></span>
                        <span class="text-[10px] font-black uppercase"><?= htmlspecialchars($c['author_name']) ?></span>
                        <span class="text-[8px] text-zinc-600">sur <em><?= htmlspecialchars($c['project_title'] ?? '#'.$c['project_id']) ?></em></span>
                        <span class="text-[8px] text-zinc-700 font-mono"><?= $c['created_at'] ?></span>
                        <?php if(!$c['approved']): ?>
                        <span class="text-[7px] bg-orange-500/20 text-orange-400 px-2 py-0.5 font-black uppercase tracking-widest">En attente</span>
                        <?php else: ?>
                        <span class="text-[7px] bg-green-500/20 text-green-400 px-2 py-0.5 font-black uppercase tracking-widest">Approuvé</span>
                        <?php endif; ?>
                    </div>
                    <div class="text-sm text-zinc-400 leading-relaxed pl-10"><?= htmlspecialchars($c['content']) ?></div>
                </div>
                <div class="flex gap-2 flex-shrink-0">
                    <a href="admin.php?toggle_comment=<?= $c['id'] ?>" class="action-btn">
                        <?= $c['approved'] ? '<i class="fas fa-eye-slash"></i>' : '<i class="fas fa-check"></i> Approuver' ?>
                    </a>
                    <a href="admin.php?del_comment=<?= $c['id'] ?>" onclick="return confirm('Supprimer ce commentaire ?')" class="action-btn danger">
                        <i class="fas fa-trash text-[9px]"></i>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; endif; ?>
    </div>

</main>

<script>
function switchTab(name) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
    document.getElementById('content-' + name).classList.add('active');
    document.getElementById('tab-' + name).classList.add('active');
    const mTab = document.getElementById('tab-m-' + name);
    if (mTab) mTab.classList.add('active');
    history.replaceState(null,'','#'+name);
}

function filterComments(type) {
    document.querySelectorAll('.comment-row').forEach(row => {
        const show = type === 'all' || row.classList.contains(type);
        row.style.display = show ? '' : 'none';
    });
    document.querySelectorAll('[id^="cf-"]').forEach(b => b.style.background='');
    const active = document.getElementById('cf-' + type);
    if (active) { active.style.background = '#fff'; active.style.color = '#000'; }
}

window.addEventListener('load', () => {
    const h = location.hash.replace('#','');
    if (['portfolio','shop','messages','comments'].includes(h)) switchTab(h);
});
</script>
</body>
</html>
