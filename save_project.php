<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: admin.php"); exit();
}

if (!$pdo) {
    die("Erreur : base de données non disponible.");
}

$title    = htmlspecialchars(trim($_POST['title']   ?? ''));
$category = htmlspecialchars(trim($_POST['category'] ?? ''));
$ext_link = trim($_POST['external_link'] ?? '');
$upload_dir = 'uploads/portfolio/';
if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

// ── 1. Miniature de couverture ──────────────────────────────────────────────
$thumb_path = '';
if (!empty($_FILES['thumbnail_file']['name']) && $_FILES['thumbnail_file']['error'] === 0) {
    $fn = time() . '_thumb_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $_FILES['thumbnail_file']['name']);
    if (move_uploaded_file($_FILES['thumbnail_file']['tmp_name'], $upload_dir.$fn))
        $thumb_path = $upload_dir.$fn;
}

// ── 2. Media items (JSON array) ─────────────────────────────────────────────
// Format stocké : [{"type":"video","embed":"…","thumb":"…"}, {"type":"photo","src":"…","thumb":"…"}, …]
$media_items = [];

// 2a. Liens YouTube ajoutés manuellement
$yt_links  = array_filter(array_map('trim', $_POST['yt_links']  ?? []));
$yt_thumbs = array_map('trim', $_POST['yt_thumbs'] ?? []);
foreach ($yt_links as $k => $url) {
    if (!$url) continue;
    // Convertir en embed URL
    preg_match('/(?:v=|youtu\.be\/|embed\/)([A-Za-z0-9_-]{11})/', $url, $m);
    $embed = isset($m[1]) ? 'https://www.youtube.com/embed/'.$m[1] : $url;
    $thumb = $yt_thumbs[$k] ?? (isset($m[1]) ? 'https://img.youtube.com/vi/'.$m[1].'/mqdefault.jpg' : '');
    $media_items[] = ['type'=>'video', 'embed'=>$embed, 'thumb'=>$thumb];
}

// 2b. Fichiers uploadés (photos + mp4)
if (!empty($_FILES['media_files']['name'][0])) {
    foreach ($_FILES['media_files']['tmp_name'] as $k => $tmp) {
        if ($_FILES['media_files']['error'][$k] !== 0) continue;
        $orig = $_FILES['media_files']['name'][$k];
        $fn   = time() . '_' . $k . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $orig);
        $dest = $upload_dir . $fn;
        if (move_uploaded_file($tmp, $dest)) {
            $type = str_ends_with(strtolower($fn), '.mp4') ? 'video_file' : 'photo';
            $media_items[] = ['type'=>$type, 'src'=>$dest, 'thumb'=>$dest];
        }
    }
}

// Fallback si aucun media
if (empty($media_items) && $thumb_path) {
    $media_items[] = ['type'=>'photo', 'src'=>$thumb_path, 'thumb'=>$thumb_path];
}

try {
    $stmt = $pdo->prepare(
        "INSERT INTO projects (title, category, thumbnail_path, media_items, external_link, created_at)
         VALUES (?, ?, ?, ?, ?, NOW())"
    );
    $stmt->execute([$title, $category, $thumb_path, json_encode($media_items), $ext_link]);
    header("Location: admin.php?success=1#portfolio"); exit();
} catch (\Throwable $e) {
    die("Erreur : " . $e->getMessage());
}
