<?php
require 'db.php';

// On définit l'identifiant et le mot de passe EN CLAIR ici
$user = 'admin';
$pass = 'fakh2026'; 

// On génère le hachage manuellement
$hash = password_hash($pass, PASSWORD_DEFAULT);

try {
    // On vide la table pour être sûr
    $pdo->exec("TRUNCATE TABLE users");
    
    // On insère l'utilisateur
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$user, $hash]);
    
    echo "✅ Utilisateur créé avec succès !<br>";
    echo "Identifiant : <b>$user</b><br>";
    echo "Mot de passe : <b>$pass</b><br>";
    echo "<a href='login.php'>Aller à la page de connexion</a>";
} catch (Exception $e) {
    echo "❌ Erreur : " . $e->getMessage();
}
?>