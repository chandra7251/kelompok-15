# Sistem Keuangan Mahasiswa dengan Kurs Otomatis

Sistem web untuk mengelola keuangan mahasiswa dengan fitur konversi mata uang otomatis dan monitoring dari orang tua.

## Fitur Utama

- Login/Register dengan role (Mahasiswa/Orang Tua/Admin)
- Dashboard dengan statistik keuangan
- CRUD Kategori (Pemasukan/Pengeluaran)
- CRUD Transaksi dengan konversi mata uang otomatis
- Transfer saldo dari orang tua ke mahasiswa
- Pairing code untuk menghubungkan akun
- Grafik pemasukan & pengeluaran (Chart.js)
- Analytics keuangan (Hemat/Normal/Boros)
- Reminder pembayaran (SPP/Kos)
- Export laporan CSV
- Notifikasi email (PHPMailer)

## Teknologi

- Backend: PHP 7.4+ (Native OOP)
- Database: MySQL 5.7+
- Frontend: TailwindCSS (CDN)
- Grafik: Chart.js
- Email: PHPMailer
- API: Exchange Rate API

## Instalasi

### 1. Clone Project
```bash
cd c:\laragon\www\Kelompok-15
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Konfigurasi Environment
```bash
copy .env.example .env
```

Edit `.env`:
```env
DB_HOST=localhost
DB_DATABASE=keuangan_mahasiswa
DB_USERNAME=root
DB_PASSWORD=

EXCHANGE_RATE_API_KEY=your_api_key

MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
```

### 4. Import Database
```bash
mysql -u root -p < database.sql
```

### 5. Akses Aplikasi
```
http://localhost/Kelompok-15/public/
```

## Demo Akun

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@keuangan.com | admin123 |
| Mahasiswa | ahmad@student.ac.id | admin123 |
| Mahasiswa | budi@student.ac.id | admin123 |
| Orang Tua | hasan@gmail.com | admin123 |

## Struktur Folder

```
project/
├── public/index.php      # Router
├── app/
│   ├── Controllers/      # 10 Controllers
│   ├── Models/           # 7 Models
│   ├── Services/         # 5 Services
│   ├── Core/             # Database
│   └── Helpers/          # Helper functions
├── views/                # View templates
├── docs/                 # ERD & Architecture
├── database.sql          # Schema + Seed Data
└── .env                  # Configuration
```

## Database (10 Tabel)

1. users - Data user
2. mahasiswa - Data mahasiswa
3. orangtua - Data orang tua
4. relasi_orangtua_mahasiswa - Relasi N:N
5. kategori - Kategori transaksi
6. transaksi - Catatan transaksi
7. transfer_saldo - Riwayat transfer
8. exchange_rate_log - Cache kurs
9. notifications - Log notifikasi
10. reminders - Pengingat pembayaran

## Dokumentasi

- [ERD Diagram](docs/ERD.md)
- [Architecture Diagram](docs/ARCHITECTURE.md)

## Keamanan

- Password hashing (bcrypt)
- PDO Prepared Statements
- CSRF Token validation
- XSS Protection
- Input validation

## Kelompok 15
