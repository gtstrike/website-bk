<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../admin/login.php');
    exit();
}

// Get user info from session
$user_name = $_SESSION['user_name'] ?? '';
$user_email = $_SESSION['user_email'] ?? '';
$user_kelas = $_SESSION['user_kelas'] ?? '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Reservasi Sesi Konseling - RuangBK</title>
   <meta name="description" content="Jadwalkan sesi bimbingan dan konseling dengan mudah melalui form reservasi RuangBK.">
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
   <!-- Navbar -->
   <nav class="navbar">
       <div class="container nav-container">
           <a href="../../public/index.html" class="logo">
               <span class="logo-icon">🌿</span>
               <span class="logo-text">Ruang<span>BK</span></span>
           </a>
           <ul class="nav-links">
               <li><a href="../../public/index.html">Kembali ke Beranda</a></li>
               <li><a href="../api/logout.php">Logout</a></li>
           </ul>
           <div class="mobile-menu-btn">
               <span></span>
               <span></span>
               <span></span>
           </div>
       </div>
   </nav>

   <!-- Page Header -->
   <header class="page-header">
       <div class="container">
           <h1 class="page-title">Jadwalkan Sesi Konseling</h1>
           <p class="page-subtitle">Isi formulir di bawah ini untuk mengatur jadwal sesi konselingmu. Jangan khawatir, semua informasi akan dijaga kerahasiaannya.</p>
       </div>
   </header>

   <!-- Form Section -->
   <section class="section-padding" style="padding-top: 0; transform: translateY(-3rem);">
       <div class="container">
           <div class="form-container">
               <form action="process_reservasi.php" method="POST" id="reservasiForm">
                   <div class="form-column">
                       <div class="form-group">
                           <label for="nama" class="form-label">Nama Lengkap</label>
                           <input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan nama lengkapmu" value="<?php echo htmlspecialchars($user_name); ?>" required>
                       </div>
                       <div class="form-group">
                           <label for="email" class="form-label">Email</label>
                           <input type="email" id="email" name="email" class="form-control" placeholder="Contoh: contoh@gmail.com" value="<?php echo htmlspecialchars($user_email); ?>" required>
                       </div>
                       <div class="form-group">
                           <label for="kelas" class="form-label">Kelas / Jurusan</label>
                           <input type="text" id="kelas" name="kelas" class="form-control" placeholder="Contoh: XII IPA 1" value="<?php echo htmlspecialchars($user_kelas); ?>" required>
                       </div>
                   </div>

                   <div class="form-column">
                       <div class="form-group">
                           <label for="layanan" class="form-label">Jenis Layanan</label>
                           <div class="choice-container-grid-2" id="layananContainer">
                               <button type="button" class="choice-btn layanan-btn" data-layanan="Konseling Pribadi">Konseling Pribadi</button>
                               <button type="button" class="choice-btn layanan-btn" data-layanan="Bimbingan Akademik">Bimbingan Akademik</button>
                               <button type="button" class="choice-btn layanan-btn" data-layanan="Perencanaan Karir">Perencanaan Karir</button>
                               <button type="button" class="choice-btn layanan-btn" data-layanan="Konseling Kelompok">Konseling Kelompok</button>
                           </div>
                           <input type="hidden" id="layananInput" name="layanan" required>
                       </div>
                       <div class="form-group">
                           <label for="tanggal" class="form-label">Pilih Tanggal</label>
                           <input type="date" id="tanggal" name="tanggal" class="form-control" required>
                          
                           <div class="choice-container" id="timeSlotContainer">
                               <button type="button" class="choice-btn time-slot-btn" data-time="09:00 - 10:00">09:00 - 10:00</button>
                               <button type="button" class="choice-btn time-slot-btn" data-time="11:00 - 12:00">11:00 - 12:00</button>
                               <button type="button" class="choice-btn time-slot-btn" data-time="13:00 - 14:00">13:00 - 14:00</button>
                           </div>
                           <input type="hidden" id="waktu" name="waktu" required>
                       </div>
                   </div>

                   <div class="form-group">
                       <label for="catatan" class="form-label">Ceritakan Singkat (Opsional)</label>
                       <textarea id="catatan" name="catatan" class="form-control" placeholder="Ceritakan secara singkat apa yang ingin kamu bahas (opsional)"></textarea>
                   </div>

                   <div class="form-group" style="text-align: center; margin-top: 2rem;">
                       <button type="submit" class="btn btn-primary btn-large" style="width: 100%;">Kirim Permintaan Jadwal</button>
                   </div>
               </form>
           </div>
       </div>
   </section>

   <!-- Loading Overlay -->
   <div class="loading-overlay" id="loadingOverlay">
       <div class="loading-spinner">
           <div class="spinner"></div>
           <p>Mengirim data...</p>
       </div>
   </div>

   <!-- Footer -->
   <footer class="footer">
       <div class="container footer-container">
           <div class="footer-info">
               <a href="../../public/index.html" class="logo footer-logo">
                   <span class="logo-icon">🌿</span>
                   <span class="logo-text">Ruang<span>BK</span></span>
               </a>
               <p class="footer-desc">Layanan Bimbingan dan Konseling terpadu untuk mendukung kesejahteraan dan kesuksesan siswa di sekolah.</p>
           </div>
           <div class="footer-links">
               <h4 class="footer-heading">Tautan Cepat</h4>
               <ul>
                   <li><a href="../../public/index.html">Beranda</a></li>
                   <li><a href="../../public/index.html#layanan">Layanan</a></li>
               </ul>
           </div>
           <div class="footer-contact">
               <h4 class="footer-heading">Hubungi Kami</h4>
               <ul>
                   <li>📍 Jl. Pendidikan No. 123, Kota Pelajar</li>
                   <li>📞 (021) 1234-5678</li>
               </ul>
           </div>
       </div>
       <div class="footer-bottom container">
           <p>&copy; 2026 RuangBK Sekolah. Hak Cipta Dilindungi.</p>
       </div>
   </footer>

   <script src="../../public/js/script.js"></script>
   <script>
       // Handle Layanan selection
       const layananBtns = document.querySelectorAll('.layanan-btn');
       const layananInput = document.getElementById('layananInput');

       layananBtns.forEach(btn => {
           btn.addEventListener('click', function() {
               layananBtns.forEach(b => b.classList.remove('selected'));
               this.classList.add('selected');
               layananInput.value = this.getAttribute('data-layanan');
           });
       });

       // Handle time slot selection
       const tanggalInput = document.getElementById('tanggal');
       const timeSlotContainer = document.getElementById('timeSlotContainer');
       const timeSlotBtns = document.querySelectorAll('.time-slot-btn');
       const waktuInput = document.getElementById('waktu');

       tanggalInput.addEventListener('change', function() {
           if (this.value) {
               timeSlotContainer.classList.add('active');
           } else {
               timeSlotContainer.classList.remove('active');
               waktuInput.value = '';
               timeSlotBtns.forEach(btn => btn.classList.remove('selected'));
           }
       });

       timeSlotBtns.forEach(btn => {
           btn.addEventListener('click', function() {
               timeSlotBtns.forEach(b => b.classList.remove('selected'));
               this.classList.add('selected');
               waktuInput.value = this.getAttribute('data-time');
           });
       });

       // Form submission handler
       document.getElementById('reservasiForm').addEventListener('submit', async function(e) {
           e.preventDefault();

           if (!layananInput.value) {
               alert('Silakan pilih jenis layanan!');
               return;
           }

           if (!waktuInput.value) {
               alert('Silakan pilih jam konseling!');
               return;
           }

           // Show loading overlay
           const loadingOverlay = document.getElementById('loadingOverlay');
           loadingOverlay.classList.add('show');

           const formData = new FormData(this);

           try {
               const response = await fetch('../api/process_reservasi.php', {
                   method: 'POST',
                   body: formData
               });

               const result = await response.json();

               // Hide loading overlay
               loadingOverlay.classList.remove('show');

               if (result.success) {
                   alert('Reservasi berhasil dikirim!');
                   this.reset();
                   waktuInput.value = '';
                   layananInput.value = '';
                   timeSlotBtns.forEach(btn => btn.classList.remove('selected'));
                   layananBtns.forEach(btn => btn.classList.remove('selected'));
               } else {
                   alert(result.message || 'Terjadi kesalahan');
               }

           } catch (error) {
               // Hide loading overlay on error
               loadingOverlay.classList.remove('show');
               alert('Gagal mengirim data');
               console.error(error);
           }
       });
   </script>
   
</body>
</html>
