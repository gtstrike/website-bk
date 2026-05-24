# RuangBK - Sistem Bimbingan dan Konseling Sekolah

Platform digital untuk reservasi dan manajemen layanan bimbingan serta konseling sekolah.

## 📁 Struktur Folder

```
pkm/
├── public/                           # Entry point & static assets
│   ├── index.html                   # Homepage
│   ├── css/
│   │   └── style.css               # Main stylesheet
│   └── js/
│       └── script.js               # Main scripts
│
├── src/                            # Source code (PHP & pages)
│   ├── pages/                      # Public pages
│   │   ├── reservasi.php          # Booking form (requires login)
│   │   ├── layanan-pribadi.html
│   │   ├── layanan-akademik.html
│   │   ├── layanan-karir.html
│   │   └── layanan-kelompok.html
│   │
│   ├── admin/                      # Admin panel
│   │   ├── login.php              # Login page
│   │   ├── register.php           # Registration page
│   │   ├── dashboard.html         # Admin dashboard
│   │   ├── layanan.html           # Manage services
│   │   ├── pengguna.html          # User management
│   │   └── css/
│   │       └── admin-style.css
│   │
│   └── api/                        # API endpoints
│       ├── process_login.php      # Handle login
│       ├── process_register.php   # Handle registration
│       ├── process_reservasi.php  # Handle booking
│       └── logout.php             # Handle logout
│
├── data/                           # Data storage (JSON)
│   ├── users.json                 # User database
│   └── reservasi_data.json        # Booking records
│
├── docs/
│   └── DOKUMENTASI_LOGIN.md       # Authentication documentation
│
├── .gitignore                      # Git ignore rules
├── .htaccess                       # Apache rewrite rules
└── README.md                       # This file
```

## 🚀 Quick Start

### Prerequisites
- PHP 7.4 atau lebih tinggi
- Apache server dengan mod_rewrite enabled (atau gunakan PHP built-in server)

### Installation

1. **Clone/Download project**
   ```bash
   cd /path/to/website-bk-1/pkm
   ```

2. **Jalankan dengan PHP Built-in Server**
   ```bash
   php -S localhost:8000
   ```

3. **Akses di browser**
   - Homepage: `http://localhost:8000`
   - Login: `http://localhost:8000/src/admin/login.php`
   - Register: `http://localhost:8000/src/admin/register.php`

### Test Account

**Admin:**
- Email: `admin@ruangbk.com`
- Password: `admin123`

**User (Siswa):**
- Email: `john@student.com`
- Password: `admin123`

## 🔐 Authentication

### User Roles
- **Admin**: Akses penuh ke dashboard dan manajemen
- **User**: Akses ke halaman reservasi

### Security Features
✅ Password hashing dengan bcrypt
✅ Session-based authentication
✅ Input validation
✅ HTML sanitization

### Login Flow
1. User diarahkan ke `src/admin/login.php`
2. Submit form → `src/api/process_login.php`
3. Verifikasi kredensial dari `data/users.json`
4. Jika valid → buat session dan redirect ke `src/pages/reservasi.php`
5. Jika gagal → tampil error message

## 📝 Feature - Reservasi Sesi

1. **User harus login** sebelum bisa reservasi
2. **Form auto-filled** dengan data dari session
3. **Loading indicator** saat submit
4. **Data disimpan** ke `data/reservasi_data.json`
5. **Konfirmasi** tampil setelah submit sukses

## 💾 Data Storage

Saat ini menggunakan **JSON files**. Untuk production, migrate ke:
- MySQL
- PostgreSQL
- MongoDB

## 📚 File Links

- 📄 [Dokumentasi Login](docs/DOKUMENTASI_LOGIN.md)
- 🎨 [CSS Utama](public/css/style.css)
- 🔧 [JavaScript](public/js/script.js)

## 🔄 Deployment Notes

### Apache Setup
1. Pastikan `mod_rewrite` enabled
2. Letakkan project di `public_html` atau `www` folder
3. File `.htaccess` akan handle routing otomatis

### Permissions
```bash
chmod 755 data/
chmod 644 data/*.json
```

### Environment
Buat `.env` file untuk konfigurasi (opsional):
```
DB_TYPE=json
DB_PATH=../data
DEBUG=false
```

## 🛠️ Development

### Technologies
- **Frontend**: HTML, CSS, JavaScript (Vanilla)
- **Backend**: PHP (Pure/OOP-ready)
- **Storage**: JSON (temporary)
- **Styling**: Custom CSS + Responsive Design

### Browser Support
- Chrome/Edge ✅
- Firefox ✅
- Safari ✅
- Mobile browsers ✅

## 📋 TODO/Future Features

- [ ] Migrate to MySQL database
- [ ] Email notifications
- [ ] Admin dashboard fully functional
- [ ] Edit/cancel reservasi dari user
- [ ] Password reset functionality
- [ ] Two-factor authentication
- [ ] Rate limiting
- [ ] CSRF protection

## 📞 Support

Untuk pertanyaan atau issue, silakan buat issue di repository.

## 📄 License

Private project - Sekolah BK

---

**Last Updated**: May 24, 2026
