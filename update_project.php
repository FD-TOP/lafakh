<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $external_link = $_POST['external_link'];
    $upload_dir = 'uploads/';

    // 1. Récupérer les données actuelles
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
    $stmt->execute([$id]);
    $project = $stmt->fetch();

    $thumbnail_path = $project['thumbnail_path'];
    $media_paths = array_filter(explode(',', $project['media_path']));

    // 2. Modifier la Miniature si un nouveau fichier est choisi
    if (!empty($_FILES['new_thumbnail']['name'])) {
        // Optionnel : supprimer l'ancienne miniature physique
        if (file_exists($thumbnail_path)) { unlink($thumbnail_path); }
        
        $thumb_name = time() . "_thumb_" . $_FILES['new_thumbnail']['name'];
        $thumbnail_path = $upload_dir . $thumb_name;
        move_uploaded_file($_FILES['new_thumbnail']['tmp_name'], $thumbnail_path);
    }

    // 3. Ajouter de nouveaux médias à la liste existante
    if (!empty($_FILES['new_media_files']['name'][0])) {
        foreach ($_FILES['new_media_files']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['new_media_files']['error'][$key] === 0) {
                $file_name = time() . "_" . $key . "_" . $_FILES['new_media_files']['name'][$key];
                $dest = $upload_dir . $file_name;
                if (move_uploaded_file($tmp_name, $dest)) {
                    $media_paths[] = $dest;
                }
            }
        }
    }

    $final_media_string = implode(',', $media_paths);

    // 4. Mise à jour SQL
    $sql = "UPDATE projects SET title = ?, thumbnail_path = ?, media_path = ?, external_link = ? WHERE id = ?";
    $pdo->prepare($sql)->execute([$title, $thumbnail_path, $final_media_string, $external_link, $id]);

    header("Location: admin.php?success=updated");
    exit();
}