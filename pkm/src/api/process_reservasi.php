<?php
session_start();
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Anda harus login terlebih dahulu'
    ]);
    exit();
}

// Validate form data
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
    exit();
}

// Get form data
$nama = $_POST['nama'] ?? '';
$email = $_POST['email'] ?? '';
$kelas = $_POST['kelas'] ?? '';
$layanan = $_POST['layanan'] ?? '';
$tanggal = $_POST['tanggal'] ?? '';
$waktu = $_POST['waktu'] ?? '';
$catatan = $_POST['catatan'] ?? '';

// Validate required fields
if (empty($nama) || empty($email) || empty($kelas) || empty($layanan) || empty($tanggal) || empty($waktu)) {
    echo json_encode([
        'success' => false,
        'message' => 'Semua field yang wajib diisi harus dilengkapi'
    ]);
    exit();
}

// Create data directory if it doesn't exist
$data_dir = '../../data';
if (!is_dir($data_dir)) {
    mkdir($data_dir, 0755, true);
}

// Prepare data for storage
$reservasi_data = [
    'id' => uniqid('RES-'),
    'user_id' => $_SESSION['user_id'],
    'nama' => $nama,
    'email' => $email,
    'kelas' => $kelas,
    'layanan' => $layanan,
    'tanggal' => $tanggal,
    'waktu' => $waktu,
    'catatan' => $catatan,
    'status' => 'pending',
    'created_at' => date('Y-m-d H:i:s'),
    'updated_at' => date('Y-m-d H:i:s')
];

// Store data in JSON file (alternative to database)
$reservasi_file = $data_dir . '/reservasi_data.json';

// Read existing data
$existing_data = [];
if (file_exists($reservasi_file)) {
    $json_data = file_get_contents($reservasi_file);
    $existing_data = json_decode($json_data, true) ?? [];
}

// Add new reservation
$existing_data[] = $reservasi_data;

// Write back to file
if (file_put_contents($reservasi_file, json_encode($existing_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
    
    // Optional: Send email notification to admin or user
    // (You can implement this later)
    
    echo json_encode([
        'success' => true,
        'message' => 'Reservasi berhasil dikirim!',
        'reservation_id' => $reservasi_data['id']
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Gagal menyimpan data reservasi'
    ]);
}
?>
