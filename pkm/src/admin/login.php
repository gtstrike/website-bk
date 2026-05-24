<?php
session_start();

// If already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.html');
    exit();
}

$error = '';
if (isset($_GET['error'])) {
    $error = urldecode($_GET['error']);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RuangBK</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/admin-style.css">
</head>
<body class="login-page">
    <div class="login-card">
        <div class="login-header">
            <div class="login-logo">
                <span>🌿</span> Ruang<span>BK</span>
            </div>
            <h1 class="login-title">Selamat Datang</h1>
            <p class="login-subtitle">Silakan login untuk mengakses layanan reservasi</p>
        </div>
        
        <?php if ($error): ?>
        <div class="alert alert-error">
            <?php echo htmlspecialchars($error); ?>
        </div>
        <?php endif; ?>
        
        <form id="loginForm" action="../api/process_login.php" method="POST">
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan email" required>
            </div>
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>
            <button type="submit" class="btn btn-primary">Masuk</button>
        </form>
        
        <p style="text-align: center; margin-top: 1rem; font-size: 0.9rem;">
            Belum punya akun? <a href="register.php" style="color: var(--primary-color); text-decoration: underline;">Daftar di sini</a>
        </p>
        
        <a href="../../public/index.html" class="back-link">← Kembali ke Beranda</a>
    </div>

    <script src="admin-script.js"></script>
</body>
</html>
