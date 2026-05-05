<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $type = $_POST['media_type'];
    $link = $_POST['external_link'];
    $upload_dir = 'uploads/';

    // Créer le dossier s'il n'existe pas
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // 1. GESTION DE LA MINIATURE (PHOTO DE COUVERTURE)
    $thumb_path = "";
    if (isset($_FILES['thumbnail_file']) && $_FILES['thumbnail_file']['error'] === 0) {
        $thumb_name = time() . '_thumb_' . $_FILES['thumbnail_file']['name'];
        $thumb_path = $upload_dir . $thumb_name;
        move_uploaded_file($_FILES['thumbnail_file']['tmp_name'], $thumb_path);
    }

    // 2. GESTION DES MÉDIAS MULTIPLES (CONTENU PRINCIPAL)
    $media_paths = [];
    if (isset($_FILES['media_files']) && !empty($_FILES['media_files']['name'][0])) {
        foreach ($_FILES['media_files']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['media_files']['error'][$key] === 0) {
                // On crée un nom unique pour chaque fichier
                $file_name = time() . "_" . $key . "_" . $_FILES['media_files']['name'][$key];
                $dest_path = $upload_dir . $file_name;
                
                if (move_uploaded_file($tmp_name, $dest_path)) {
                    $media_paths[] = $dest_path;
                }
            }
        }
    }

    // On transforme le tableau en texte séparé par des virgules
    // Exemple : "uploads/img1.jpg,uploads/img2.jpg"
    $all_media_paths = implode(",", $media_paths);

    // 3. ENREGISTREMENT DANS LA BASE DE DONNÉES
    try {
        $stmt = $pdo->prepare("INSERT INTO projects (title, thumbnail_path, media_type, media_path, external_link) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $thumb_path, $type, $all_media_paths, $link]);
        
        header("Location: admin.php?success=1");
        exit();
    } catch (PDOException $e) {
        die("Erreur lors de l'enregistrement : " . $e->getMessage());
    }
}