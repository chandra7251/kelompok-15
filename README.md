# KeuanganKu

Web keuangan mahasiswa + monitoring ortu.

## Setup

Clone repo, install composer:
```
composer install
```

Import `database.sql` ke MySQL, buat database `web_keuangan_mahasiswa_dan_kurs_otomatis`.

Copy `.env.example` jadi `.env`, isi sesuai config database kamu.

Akses di `http://localhost/Kelompok-15/public/`

## Akun Test

Password semua: `password123`

**Admin:**
- admin@keuangan.com

**Mahasiswa:**
- chandraaditiyaputra80@gmail.com
- chandraaditiya725@gmail.com
- princecain011@gmail.com
- kelvin.hartono@gmail.com
- rizky.maulana@gmail.com
- ahmad.fauzi@gmail.com
- budi.santoso@gmail.com
- citra.dewi@gmail.com
- dika.pratama@gmail.com
- eka.putri@gmail.com

**Orang Tua:**
- hasan.wijaya@gmail.com
- siti.rahayu@gmail.com
- rahman.hidayat@gmail.com
- dewi.kusuma@gmail.com
- andi.permana@gmail.com

## Endpoint

### Public
- `/` - landing page
- `/login` - login
- `/register` - daftar akun
- `/logout` - keluar
- `/forgot_password` - lupa password
- `/reset_password` - reset password dari email

### Dashboard
- `/dashboard` - halaman utama setelah login
- `/profile` - edit profil & foto

### Transaksi (Mahasiswa)
- `/transaksi` - list transaksi
- `/transaksi/create` - tambah transaksi
- `/transaksi/edit?id=x` - edit
- `/transaksi/delete` - hapus

### Kategori (Mahasiswa)
- `/kategori` - list kategori
- `/kategori/create` - tambah
- `/kategori/edit?id=x` - edit
- `/kategori/delete` - hapus

### Transfer (Ortu)
- `/transfer` - kirim saldo ke anak
- `/transfer/link` - pairing sama anak pakai kode
- `/transfer/unlink` - lepas pairing

### Fitur Lain
- `/analytics` - statistik keuangan
- `/grafik` - chart pemasukan/pengeluaran
- `/reminder` - pengingat bayar SPP/kos

### Export
- `/export/transaksi` - download CSV transaksi
- `/export/laporan` - download laporan
- `/export/transfer_orangtua` - riwayat transfer ortu
- `/export/laporan_anak_pdf` - laporan anak PDF

### Admin
- `/admin/users` - kelola user
- `/admin/monitoring` - monitoring semua transaksi
- `/admin/settings` - pengaturan sistem

## Stack
PHP, MySQL, TailwindCSS, Chart.js, PHPMailer

---
Kelompok 15
