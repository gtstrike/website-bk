# Sistem Autentikasi RuangBK - Dokumentasi

## Ringkasan Perubahan

File `.html` telah dikonversi ke `.php` dengan menambahkan sistem login dan manajemen sesi.

## File yang Dibuat/Dimodifikasi

### User (Siswa)
- **reservasi.php** - Halaman formulir reservasi (sebelumnya reservasi.html)
  - Memerlukan login
  - Menampilkan data user dari sesi
  - Mengirim data ke `process_reservasi.php`
  
- **process_reservasi.php** - Backend untuk proses reservasi
  - Menyimpan data ke `data/reservasi_data.json`
  - Mengembalikan JSON response
  
- **logout.php** - Logout dari sistem
  - Menghancurkan session
  - Redirect ke halaman utama

### Autentikasi
- **login.php** - Halaman login (menggantikan login.html)
  - Form login dengan email dan password
  - Redirect ke `process_login.php`
  
- **process_login.php** - Backend login
  - Verifikasi email dan password
  - Membaca data dari `data/users.json`
  - Membuat session jika login berhasil
  
- **register.php** - Halaman registrasi user baru
  - Form daftar dengan validasi
  - Redirect ke `process_register.php`
  
- **process_register.php** - Backend registrasi
  - Validasi data input
  - Simpan user baru ke `data/users.json`
  - Password di-hash menggunakan bcrypt

### Data Files
- **data/users.json** - Database user (format JSON)
  - Berisi daftar user terdaftar
  - Password di-hash (bcrypt)
  
- **data/reservasi_data.json** - Database reservasi (format JSON)
  - Menyimpan semua data reservasi dari user

## Test Akun

### Admin
- Email: `admin@ruangbk.com`
- Password: `admin123`

### User Biasa
- Email: `john@student.com`
- Password: `admin123`

## Flow Aplikasi

1. User berkunjung ke `/index.html`
2. User klik "Reservasi" → redirect ke `login.php` (jika belum login)
3. User bisa login atau daftar akun baru
4. Setelah login sukses → redirect ke `reservasi.php`
5. User isi form dan submit
6. Loading indicator muncul saat submit
7. Data disimpan ke `data/reservasi_data.json`
8. Loading indicator hilang dan tampil notifikasi sukses
9. User bisa logout melalui link di navbar

## Keamanan

- ✅ Session check di setiap halaman yang butuh login
- ✅ Password di-hash dengan bcrypt
- ✅ Email validation
- ✅ Input sanitization dengan htmlspecialchars()
- ✅ CSRF protection bisa ditambahkan nanti
- ✅ Rate limiting bisa ditambahkan nanti

## Fitur yang Bisa Ditambahkan Nantinya

- [ ] Email verification untuk registrasi
- [ ] Password reset functionality
- [ ] CSRF token protection
- [ ] Rate limiting untuk login attempts
- [ ] Email notification saat reservasi diterima
- [ ] Admin dashboard untuk lihat reservasi
- [ ] Edit/cancel reservasi dari user
- [ ] Database MySQL (ganti JSON files)
- [ ] Two-factor authentication
- [ ] User profile management

## Catatan Penting

- Saat ini menggunakan JSON files untuk penyimpanan data
- Untuk production, gunakan database MySQL/PostgreSQL
- Pastikan folder `data/` writable (chmod 755)
- Session configuration bisa di-customize di php.ini
