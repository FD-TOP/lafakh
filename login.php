<?php
session_start();
require 'db.php';

if (isset($_SESSION['admin_logged_in'])) {
    header("Location: admin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$user]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($pass, $admin['password'])) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin.php");
        exit();
    } else {
        $error = "Identifiants incorrects.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>LA FAKH | Secure Access</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { background: #000; font-family: 'Inter', sans-serif; color: #fff; }
        .login-card { background: #080808; border: 1px solid #111; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); }
        input { background: #000 !important; border: 1px solid #222 !important; color: #fff !important; transition: 0.3s; }
        input:focus { border-color: #444 !important; outline: none; }
        .toggle-password { cursor: pointer; color: #444; transition: 0.3s; }
        .toggle-password:hover { color: #fff; }
    </style>
</head>
<body class="flex items-center justify-center h-screen px-6">

    <div class="login-card p-10 md:p-14 rounded-[40px] w-full max-w-sm text-center">
        <h1 class="text-4xl font-black italic uppercase tracking-tighter mb-2">LA FAKH</h1>
        <p class="text-[9px] uppercase tracking-[0.4em] text-zinc-600 mb-12 italic font-medium">Restricted Area</p>
        
        <?php if(isset($error)): ?>
            <div class="bg-red-500/10 text-red-500 text-[10px] py-3 rounded-xl mb-8 uppercase font-bold tracking-widest border border-red-500/20">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST" class="space-y-5">
            <div class="text-left">
                <label class="text-[9px] uppercase tracking-widest text-zinc-500 ml-4 mb-2 block font-bold">Identifiant</label>
                <input type="text" name="username" placeholder="votre nom" required 
                       class="w-full p-4 rounded-2xl text-sm">
            </div>

            <div class="text-left relative">
                <label class="text-[9px] uppercase tracking-widest text-zinc-500 ml-4 mb-2 block font-bold">Mot de passe</label>
                <div class="relative">
                    <input type="password" id="passwordField" name="password" placeholder="••••••••" required 
                           class="w-full p-4 rounded-2xl text-sm pr-12">
                    <span class="absolute right-5 top-1/2 -translate-y-1/2 toggle-password" onclick="togglePassword()">
                        <i id="eyeIcon" class="fas fa-eye"></i>
                    </span>
                </div>
            </div>

            <button type="submit" class="w-full bg-white text-black font-black py-5 rounded-full uppercase text-[10px] tracking-[0.2em] hover:bg-zinc-200 transition mt-6 shadow-xl shadow-white/5">
                Authentification
            </button>
        </form>

        <p class="mt-12 text-[8px] uppercase tracking-widest text-zinc-800 font-bold">&copy; 2026 LA FAKH STUDIO</p>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('passwordField');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>