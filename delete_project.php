<?php


session_start();

// Si l'utilisateur n'est pas connecté, on le redirige vers le login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}


require 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. On récupère le chemin du fichier pour le supprimer du dossier uploads
    $stmt = $pdo->prepare("SELECT media_path FROM projects WHERE id = ?");
    $stmt->execute([$id]);
    $project = $stmt->fetch();

    if ($project) {
        if (file_exists($project['media_path'])) {
            unlink($project['media_path']); // Supprime le fichier physique
        }

        // 2. On supprime la ligne dans la base de données
        $delete = $pdo->prepare("DELETE FROM projects WHERE id = ?");
        $delete->execute([$id]);
    }
}

header("Location: admin.php#projets"); // Retour à l'admin
exit();