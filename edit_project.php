<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin_logged_in'])) { header("Location: login.php"); exit(); }

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$id]);
$project = $stmt->fetch();

if (!$project) { die("Projet introuvable."); }

// Logique de suppression d'un média spécifique (Lightbox)
if (isset($_GET['delete_media'])) {
    $media_to_delete = $_GET['delete_media'];
    $current_medias = explode(',', $project['media_path']);
    $updated_medias = array_filter($current_medias, function($m) use ($media_to_delete) {
        return trim($m) !== trim($media_to_delete);
    });

    if (file_exists($media_to_delete)) { unlink($media_to_delete); }

    $new_path_string = implode(',', $updated_medias);
    $upd = $pdo->prepare("UPDATE projects SET media_path = ? WHERE id = ?");
    $upd->execute([$new_path_string, $id]);

    header("Location: edit_project.php?id=$id");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Projet | LA FAKH</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { background: #050505; color: #fff; font-family: 'Inter', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255,255,255,0.05); backdrop-filter: blur(10px); }
        input, select { background: #000 !important; border: 1px solid #222 !important; color: #fff !important; }
    </style>
</head>
<body class="p-6 md:p-12">

    <div class="max-w-6xl mx-auto">
        <a href="admin.php" class="text-[10px] uppercase tracking-widest opacity-50 hover:opacity-100 transition"><i class="fas fa-arrow-left mr-2"></i> Dashboard</a>
        
        <h1 class="text-3xl font-black italic uppercase mt-6 mb-10">Modifier Projet</h1>

        <form action="update_project.php" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <input type="hidden" name="id" value="<?= $project['id'] ?>">
            
            <div class="lg:col-span-2 space-y-6">
                <div class="glass p-8 rounded-3xl space-y-6">
                    <div>
                        <label class="text-[10px] uppercase text-zinc-500 font-bold block mb-2">Titre</label>
                        <input type="text" name="title" value="<?= htmlspecialchars($project['title']) ?>" class="w-full p-4 rounded-xl text-sm outline-none">
                    </div>

                    <div>
                        <label class="text-[10px] uppercase text-zinc-500 font-bold block mb-2">Lien Externe (YouTube/Vimeo)</label>
                        <input type="url" name="external_link" value="<?= htmlspecialchars($project['external_link']) ?>" class="w-full p-4 rounded-xl text-sm outline-none">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-[10px] uppercase text-white font-bold block mb-4">Modifier la Miniature</label>
                            <div class="aspect-video mb-4 rounded-xl overflow-hidden border border-white/10 bg-zinc-900">
                                <img src="<?= $project['thumbnail_path'] ?>" class="w-full h-full object-cover">
                            </div>
                            <input type="file" name="new_thumbnail" class="text-[10px] text-zinc-500">
                        </div>
                        <div>
                            <label class="text-[10px] uppercase text-zinc-500 font-bold block mb-4">Ajouter des Médias (Lightbox)</label>
                            <div class="p-8 border-2 border-dashed border-zinc-800 rounded-xl text-center">
                                <i class="fas fa-cloud-upload-alt mb-2 opacity-20"></i>
                                <input type="file" name="new_media_files[]" multiple class="text-[10px] text-zinc-500 block w-full">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-white text-black font-black py-4 rounded-full uppercase text-[10px] tracking-widest hover:bg-zinc-200 transition">Mettre à jour le projet</button>
                </div>
            </div>

            <div class="space-y-6">
                <h3 class="text-[10px] uppercase font-black tracking-widest text-zinc-500">Médias du Portfolio</h3>
                <div class="grid grid-cols-1 gap-4">
                    <?php 
                    $medias = array_filter(explode(',', $project['media_path']));
                    foreach ($medias as $m): 
                    ?>
                    <div class="glass p-2 rounded-2xl relative group border border-white/5">
                        <?php if(strpos($m, '.mp4') !== false): ?>
                            <video src="<?= $m ?>" class="w-full aspect-video object-cover rounded-xl opacity-40"></video>
                        <?php else: ?>
                            <img src="<?= $m ?>" class="w-full aspect-video object-cover rounded-xl opacity-40">
                        <?php endif; ?>

                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                            <a href="edit_project.php?id=<?= $id ?>&delete_media=<?= urlencode($m) ?>" 
                               onclick="return confirm('Supprimer ce média ?')"
                               class="bg-red-600 text-white w-8 h-8 rounded-full flex items-center justify-center shadow-xl hover:scale-110 transition">
                                <i class="fas fa-times text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </form>
    </div>

</body>
</html>