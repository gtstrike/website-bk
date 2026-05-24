<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin/login.php?error=' . urlencode('Invalid request method'));
    exit();
}

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Validate input
if (empty($email) || empty($password)) {
    header('Location: ../admin/login.php?error=' . urlencode('Email dan password harus diisi'));
    exit();
}

// Load user data from JSON file
$users_file = '../../data/users.json';

if (!file_exists($users_file)) {
    header('Location: ../admin/login.php?error=' . urlencode('Database user tidak ditemukan'));
    exit();
}

$users_data = json_decode(file_get_contents($users_file), true) ?: [];
$updated = false;
$user_found = false;

foreach ($users_data as $index => $user) {
    if ($user['email'] === $email) {
        $stored = $user['password'] ?? '';
        // If stored value is a bcrypt hash, use password_verify
        if (!empty($stored) && password_verify($password, $stored)) {
            $user_found = true;
        } elseif ($stored === $password) {
            // Legacy plaintext password — rehash and save
            $users_data[$index]['password'] = password_hash($password, PASSWORD_BCRYPT);
            $updated = true;
            $user_found = true;
        }

        if ($user_found) {
            // Set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nama'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_kelas'] = $user['kelas'] ?? '';
            $_SESSION['user_role'] = $user['role'] ?? 'user';

            // Save updated users file if we rehashed a plaintext password
            if ($updated) {
                file_put_contents($users_file, json_encode($users_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            }

            // Redirect based on role
            if (($user['role'] ?? 'user') === 'admin') {
                header('Location: ../admin/dashboard.html');
            } else {
                header('Location: ../pages/reservasi.php');
            }
            exit();
        }
    }
}

// Login failed
header('Location: ../admin/login.php?error=' . urlencode('Email atau password salah'));
exit();
?>
