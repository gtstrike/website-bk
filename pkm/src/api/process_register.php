<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin/register.php?error=' . urlencode('Invalid request method'));
    exit();
}

$nama = $_POST['nama'] ?? '';
$email = $_POST['email'] ?? '';
$kelas = $_POST['kelas'] ?? '';
$password = $_POST['password'] ?? '';
$password_confirm = $_POST['password_confirm'] ?? '';

// Validate input
if (empty($nama) || empty($email) || empty($kelas) || empty($password) || empty($password_confirm)) {
    header('Location: ../admin/register.php?error=' . urlencode('Semua field harus diisi'));
    exit();
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../admin/register.php?error=' . urlencode('Format email tidak valid'));
    exit();
}

// Validate password match
if ($password !== $password_confirm) {
    header('Location: ../admin/register.php?error=' . urlencode('Password tidak cocok'));
    exit();
}

// Validate password length
if (strlen($password) < 6) {
    header('Location: ../admin/register.php?error=' . urlencode('Password minimal 6 karakter'));
    exit();
}

// Create data directory if it doesn't exist
$data_dir = '../../data';
if (!is_dir($data_dir)) {
    mkdir($data_dir, 0755, true);
}

$users_file = $data_dir . '/users.json';

// Read existing users
$existing_users = [];
if (file_exists($users_file)) {
    $json_data = file_get_contents($users_file);
    $existing_users = json_decode($json_data, true) ?? [];
}

// Check if email already exists
foreach ($existing_users as $user) {
    if ($user['email'] === $email) {
        header('Location: ../admin/register.php?error=' . urlencode('Email sudah terdaftar'));
        exit();
    }
}

// Create new user
$new_user = [
    'id' => uniqid('USER-'),
    'nama' => $nama,
    'email' => $email,
    'kelas' => $kelas,
    'password' => password_hash($password, PASSWORD_BCRYPT),
    'role' => 'user',
    'status' => 'active',
    'created_at' => date('Y-m-d H:i:s'),
    'updated_at' => date('Y-m-d H:i:s')
];

// Add new user to array
$existing_users[] = $new_user;

// Write to file
if (file_put_contents($users_file, json_encode($existing_users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
    header('Location: ../admin/login.php?success=' . urlencode('Akun berhasil dibuat. Silakan login.'));
    exit();
} else {
    header('Location: ../admin/register.php?error=' . urlencode('Gagal membuat akun'));
    exit();
}
?>
