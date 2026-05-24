<?php
session_start();

// If already logged in, redirect
if (isset($_SESSION['user_id'])) {
    header('Location: ../page/reservasi.php');
    exit();
}

$error = '';
$success = '';

if (isset($_GET['error'])) {
    $error = urldecode($_GET['error']);
}

if (isset($_GET['success'])) {
    $success = urldecode($_GET['success']);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - RuangBK</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/admin-style.css">
</head>
<body class="login-page">
    <div class="login-card" style="max-width: 500px;">
        <div class="login-header">
            <div class="login-logo">
                <span>🌿</span> Ruang<span>BK</span>
            </div>
            <h1 class="login-title">Daftar Akun</h1>
            <p class="login-subtitle">Buat akun untuk mengakses layanan reservasi</p>
        </div>
        
        <?php if ($error): ?>
        <div class="alert alert-error">
            <?php echo htmlspecialchars($error); ?>
        </div>
        <?php endif; ?>

        <?php if ($success): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($success); ?>
        </div>
        <?php endif; ?>
        
        <form id="registerForm" action="../api/process_register.php" method="POST">
            <div class="form-group">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
            </div>
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan email" required>
            </div>
            <div class="form-group">
                <label for="kelas" class="form-label">Kelas / Jurusan</label>
                <input type="text" id="kelas" name="kelas" class="form-control" placeholder="Contoh: XII IPA 1" required>
            </div>
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>
            <div class="form-group">
                <label for="password_confirm" class="form-label">Konfirmasi Password</label>
                <input type="password" id="password_confirm" name="password_confirm" class="form-control" placeholder="Konfirmasi password" required>
            </div>
            <button type="submit" class="btn btn-primary">Daftar</button>
        </form>
        
        <p style="text-align: center; margin-top: 1rem; font-size: 0.9rem;">
            Sudah punya akun? <a href="login.php" style="color: var(--primary-color); text-decoration: underline;">Login di sini</a>
        </p>
        
        <a href="../../public/index.html" class="back-link">← Kembali ke Beranda</a>
    </div>

    <script src="admin-script.js"></script>
</body>
</html>
