<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // On récupère les données du formulaire
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $sujet = $_POST['sujet'];
    $message = $_POST['message'];

    try {
        // Préparation de la requête SQL
        $stmt = $pdo->prepare("INSERT INTO messages (nom, email, sujet, message, created_at) VALUES (?, ?, ?, ?, NOW())");
        
        // Exécution
        $stmt->execute([$nom, $email, $sujet, $message]);

        // Redirection vers la page contact avec un message de succès
        header("Location: contact.php?success=1");
        exit();

    } catch (PDOException $e) {
        die("Erreur lors de l'envoi du message : " . $e->getMessage());
    }
} else {
    // Si on accède au fichier sans poster de formulaire, on redirige
    header("Location: contact.php");
    exit();
}