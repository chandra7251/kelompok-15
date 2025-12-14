# Laporan Praktikum
## Sistem Keuangan Mahasiswa dengan Kurs Otomatis dan Monitoring Orang Tua
### Kelompok 15

---

# A. CLASS DIAGRAM

## Total Class: 13 Class

---

## 1. User (Abstract/Base Class)
**Lokasi:** `app/Models/User.php`

### Atribut dan Tipe Data
| No | Atribut | Tipe Data | Visibility | Keterangan |
|----|---------|-----------|------------|------------|
| 1 | id | int | private | Primary key user |
| 2 | nama | string | private | Nama lengkap user |
| 3 | email | string | private | Email untuk login |
| 4 | password | string | private | Hash password (bcrypt) |
| 5 | role | string | private | Role: mahasiswa/orangtua/admin |
| 6 | createdAt | string | private | Timestamp dibuat |
| 7 | updatedAt | string | private | Timestamp update |

### Method/Operasi
| No | Method | Return Type | Visibility | Keterangan |
|----|--------|-------------|------------|------------|
| 1 | getId() | int | public | Getter untuk id |
| 2 | getNama() | string | public | Getter untuk nama |
| 3 | getEmail() | string | public | Getter untuk email |
| 4 | getRole() | string | public | Getter untuk role |
| 5 | setNama(string) | self | public | Setter untuk nama dengan validasi |
| 6 | setEmail(string) | self | public | Setter untuk email dengan validasi |
| 7 | setPassword(string) | self | public | Hash dan set password |
| 8 | verifyPassword(string) | bool | public | Verifikasi password |
| 9 | find(int) | User/null | public | Cari user berdasarkan ID |
| 10 | findByEmail(string) | User/null | public | Cari user berdasarkan email |
| 11 | create() | int | public | Insert user baru ke database |
| 12 | update() | bool | public | Update data user |
| 13 | delete() | bool | public | Hapus user dari database |

---

## 2. Mahasiswa (extends User)
**Lokasi:** `app/Models/Mahasiswa.php`

### Atribut dan Tipe Data
| No | Atribut | Tipe Data | Visibility | Keterangan |
|----|---------|-----------|------------|------------|
| 1 | mahasiswaId | int | private | ID di tabel mahasiswa |
| 2 | userId | int | private | FK ke tabel users |
| 3 | nim | string | private | Nomor Induk Mahasiswa |
| 4 | jurusan | string | private | Nama jurusan |
| 5 | saldo | float | private | Saldo keuangan saat ini |
| 6 | pairingCode | string | private | Kode unik untuk pairing dengan orangtua |

### Method/Operasi
| No | Method | Return Type | Visibility | Keterangan |
|----|--------|-------------|------------|------------|
| 1 | getMahasiswaId() | int | public | Getter mahasiswa_id |
| 2 | getNim() | string | public | Getter NIM |
| 3 | getJurusan() | string | public | Getter jurusan |
| 4 | getSaldo() | float | public | Getter saldo |
| 5 | getPairingCode() | string | public | Getter kode pairing |
| 6 | findMahasiswa(int) | Mahasiswa | public | Cari by mahasiswa_id |
| 7 | findByPairingCode(string) | Mahasiswa | public | Cari by kode pairing |
| 8 | updateSaldo(float, string) | bool | public | Update saldo (add/subtract) |
| 9 | generateUniquePairingCode() | string | public | Generate kode pairing baru |
| 10 | createDefaultCategories(int) | void | public | Buat kategori default |

---

## 3. OrangTua (extends User)
**Lokasi:** `app/Models/OrangTua.php`

### Atribut dan Tipe Data
| No | Atribut | Tipe Data | Visibility | Keterangan |
|----|---------|-----------|------------|------------|
| 1 | orangtuaId | int | private | ID di tabel orangtua |
| 2 | userId | int | private | FK ke tabel users |
| 3 | noTelepon | string | private | Nomor telepon orangtua |

### Method/Operasi
| No | Method | Return Type | Visibility | Keterangan |
|----|--------|-------------|------------|------------|
| 1 | getOrangtuaId() | int | public | Getter orangtua_id |
| 2 | getUserId() | int | public | Getter user_id |
| 3 | getNoTelepon() | string | public | Getter no_telepon |
| 4 | setNoTelepon(string) | self | public | Setter no_telepon |
| 5 | findOrangtua(int) | OrangTua | public | Cari by orangtua_id |
| 6 | findByUserId(int) | OrangTua | public | Cari by user_id |
| 7 | createOrangtua() | int | public | Insert orangtua baru |
| 8 | updateOrangtua() | bool | public | Update data orangtua |
| 9 | linkMahasiswa(int) | bool | public | Hubungkan dengan mahasiswa |
| 10 | unlinkMahasiswa(int) | bool | public | Lepaskan hubungan |
| 11 | getMahasiswaLinked() | array | public | Daftar anak yang terhubung |
| 12 | isMahasiswaLinked(int) | bool | public | Cek apakah sudah terhubung |
| 13 | getTransferHistory(int) | array | public | Riwayat transfer |

---

## 4. Admin (extends User)
**Lokasi:** `app/Models/Admin.php`

### Atribut dan Tipe Data
| No | Atribut | Tipe Data | Visibility | Keterangan |
|----|---------|-----------|------------|------------|
| - | *(inherit dari User)* | - | - | Menggunakan semua atribut User |

### Method/Operasi
| No | Method | Return Type | Visibility | Keterangan |
|----|--------|-------------|------------|------------|
| 1 | findAdmin(int) | Admin | public | Cari admin by user_id |
| 2 | getStatistics() | array | public | Statistik sistem keseluruhan |
| 3 | getRecentActivities(int) | array | public | Aktivitas terbaru di sistem |
| 4 | getAllUsers() | array | public | Daftar semua user |

---

## 5. Kategori
**Lokasi:** `app/Models/Kategori.php`

### Atribut dan Tipe Data
| No | Atribut | Tipe Data | Visibility | Keterangan |
|----|---------|-----------|------------|------------|
| 1 | id | int | private | Primary key |
| 2 | mahasiswaId | int | private | FK ke mahasiswa |
| 3 | nama | string | private | Nama kategori |
| 4 | tipe | string | private | pemasukan / pengeluaran |

### Method/Operasi
| No | Method | Return Type | Visibility | Keterangan |
|----|--------|-------------|------------|------------|
| 1 | getId() | int | public | Getter id |
| 2 | getNama() | string | public | Getter nama |
| 3 | getTipe() | string | public | Getter tipe |
| 4 | find(int) | Kategori | public | Cari by ID |
| 5 | getAllByMahasiswa(int) | array | public | Semua kategori mahasiswa |
| 6 | create() | int | public | Insert ke database |
| 7 | update() | bool | public | Update di database |
| 8 | delete() | bool | public | Hapus dari database |
| 9 | isUsedInTransaksi() | bool | public | Cek dipakai di transaksi |

---

## 6. Transaksi
**Lokasi:** `app/Models/Transaksi.php`

### Atribut dan Tipe Data
| No | Atribut | Tipe Data | Visibility | Keterangan |
|----|---------|-----------|------------|------------|
| 1 | id | int | private | Primary key |
| 2 | mahasiswaId | int | private | FK ke mahasiswa |
| 3 | kategoriId | int | private | FK ke kategori |
| 4 | jumlah | float | private | Jumlah dalam mata uang asli |
| 5 | mataUang | string | private | Kode mata uang (IDR, USD, dll) |
| 6 | jumlahIdr | float | private | Jumlah terkonversi ke IDR |
| 7 | kursRate | float | private | Nilai kurs saat transaksi |
| 8 | keterangan | string | private | Catatan transaksi |
| 9 | tanggal | string | private | Tanggal transaksi |

### Method/Operasi
| No | Method | Return Type | Visibility | Keterangan |
|----|--------|-------------|------------|------------|
| 1 | find(int) | Transaksi | public | Cari by ID |
| 2 | getAllByMahasiswa(int) | array | public | Semua transaksi mahasiswa |
| 3 | getMonthlySummary(int,int,int) | array | public | Ringkasan per bulan |
| 4 | getCategorySummary(int) | array | public | Ringkasan per kategori |
| 5 | create() | int | public | Insert ke database |
| 6 | update() | bool | public | Update di database |
| 7 | delete() | bool | public | Hapus dari database |

---

## 7. TransferSaldo
**Lokasi:** `app/Models/TransferSaldo.php`

### Atribut dan Tipe Data
| No | Atribut | Tipe Data | Visibility | Keterangan |
|----|---------|-----------|------------|------------|
| 1 | id | int | private | Primary key |
| 2 | orangtuaId | int | private | FK ke orangtua |
| 3 | mahasiswaId | int | private | FK ke mahasiswa |
| 4 | jumlah | float | private | Jumlah transfer asli |
| 5 | mataUang | string | private | Kode mata uang |
| 6 | jumlahIdr | float | private | Jumlah dalam IDR |
| 7 | kursRate | float | private | Nilai kurs |
| 8 | status | string | private | pending/completed/failed |

### Method/Operasi
| No | Method | Return Type | Visibility | Keterangan |
|----|--------|-------------|------------|------------|
| 1 | getAllByOrangtua(int) | array | public | Riwayat dari orangtua |
| 2 | getAllByMahasiswa(int) | array | public | Riwayat ke mahasiswa |
| 3 | create() | int | public | Insert & update saldo mahasiswa |

---

## 8. Database (Singleton)
**Lokasi:** `app/Core/Database.php`

### Atribut dan Tipe Data
| No | Atribut | Tipe Data | Visibility | Keterangan |
|----|---------|-----------|------------|------------|
| 1 | instance | Database | private static | Singleton instance |
| 2 | connection | PDO | private | Koneksi PDO ke MySQL |

### Method/Operasi
| No | Method | Return Type | Visibility | Keterangan |
|----|--------|-------------|------------|------------|
| 1 | getInstance() | Database | public static | Get singleton instance |
| 2 | getConnection() | PDO | public | Get koneksi PDO |
| 3 | query(string, array) | PDOStatement | public | Execute query |
| 4 | fetch(string, array) | array/null | public | Fetch satu row |
| 5 | fetchAll(string, array) | array | public | Fetch semua row |
| 6 | insert(string, array) | int | public | Insert & return ID |
| 7 | update(string, array) | int | public | Update & return affected rows |
| 8 | delete(string, array) | int | public | Delete & return affected rows |
| 9 | beginTransaction() | bool | public | Start transaction |
| 10 | commit() | bool | public | Commit transaction |
| 11 | rollback() | bool | public | Rollback transaction |

---

## 9. AuthService
**Lokasi:** `app/Services/AuthService.php`

### Method/Operasi
| No | Method | Return Type | Visibility | Keterangan |
|----|--------|-------------|------------|------------|
| 1 | login(string, string) | bool | public | Login dengan email & password |
| 2 | register(array) | int | public | Register user baru |
| 3 | logout() | void | public | Logout user |
| 4 | isLoggedIn() | bool | public | Cek status login |
| 5 | getUser() | array | public | Get data user dari session |

---

## 10. ExchangeRateService
**Lokasi:** `app/Services/ExchangeRateService.php`

### Method/Operasi
| No | Method | Return Type | Visibility | Keterangan |
|----|--------|-------------|------------|------------|
| 1 | getRate(string) | float | public | Get kurs mata uang ke IDR |
| 2 | convertToIdr(float, string) | array | public | Konversi ke IDR |
| 3 | getAvailableCurrencies() | array | public | Daftar mata uang tersedia |

---

## 11. AnalyticsService
**Lokasi:** `app/Services/AnalyticsService.php`

### Method/Operasi
| No | Method | Return Type | Visibility | Keterangan |
|----|--------|-------------|------------|------------|
| 1 | getDashboardStats() | array | public | Statistik untuk dashboard |
| 2 | getSpendingStatus() | array | public | Status keuangan (sehat/warning) |
| 3 | getMonthlyData() | array | public | Data untuk grafik bulanan |
| 4 | getCategoryData() | array | public | Data untuk grafik kategori |

---

## 12. ApiClient
**Lokasi:** `app/Services/ApiClient.php`

### Atribut dan Tipe Data
| No | Atribut | Tipe Data | Visibility | Keterangan |
|----|---------|-----------|------------|------------|
| 1 | timeout | int | private | Timeout request (default: 30s) |
| 2 | defaultHeaders | array | private | Header default untuk request |

### Method/Operasi
| No | Method | Return Type | Visibility | Keterangan |
|----|--------|-------------|------------|------------|
| 1 | setTimeout(int) | self | public | Set timeout request |
| 2 | setHeader(string, string) | self | public | Set custom header |
| 3 | get(string, array) | array | public | HTTP GET request |
| 4 | post(string, array) | array | public | HTTP POST request |
| 5 | request(string, string, array) | array | private | Execute cURL request |

---

## 13. NotificationService
**Lokasi:** `app/Services/NotificationService.php`

### Method/Operasi
| No | Method | Return Type | Visibility | Keterangan |
|----|--------|-------------|------------|------------|
| 1 | sendTransferNotification(...) | bool | public | Kirim notifikasi transfer masuk |
| 2 | sendReminderNotification(...) | bool | public | Kirim notifikasi reminder |

---

## Relasi Antar Class

### Tabel Relasi UML (untuk StarUML)

| No | Class Asal | Tipe Relasi | Simbol UML | Class Tujuan | Multiplicity | Keterangan |
|----|------------|-------------|------------|--------------|--------------|------------|
| 1 | Mahasiswa | **Inheritance** | ──▷ | User | - | Mahasiswa mewarisi User |
| 2 | OrangTua | **Inheritance** | ──▷ | User | - | OrangTua mewarisi User |
| 3 | Admin | **Inheritance** | ──▷ | User | - | Admin mewarisi User |
| 4 | OrangTua | **Association** | ── | Mahasiswa | 1 → * | Satu orangtua memantau banyak mahasiswa |
| 5 | Mahasiswa | **Composition** | ◆── | Kategori | 1 → * | Kategori tidak bisa exist tanpa Mahasiswa |
| 6 | Mahasiswa | **Composition** | ◆── | Transaksi | 1 → * | Transaksi milik Mahasiswa |
| 7 | Kategori | **Association** | ── | Transaksi | 1 → * | Satu kategori untuk banyak transaksi |
| 8 | OrangTua | **Composition** | ◆── | TransferSaldo | 1 → * | Transfer milik OrangTua |
| 9 | Mahasiswa | **Association** | ── | TransferSaldo | 1 → * | Mahasiswa menerima transfer |
| 10 | Transaksi | **Dependency** | - - -▷ | ExchangeRateService | - | Transaksi uses ExchangeRateService |
| 11 | TransferSaldo | **Dependency** | - - -▷ | ExchangeRateService | - | TransferSaldo uses ExchangeRateService |
| 12 | ExchangeRateService | **Dependency** | - - -▷ | ApiClient | - | ExchangeRateService uses ApiClient |
| 13 | AuthService | **Dependency** | - - -▷ | User | - | AuthService uses User |
| 14 | AuthService | **Dependency** | - - -▷ | Mahasiswa | - | AuthService uses Mahasiswa |
| 15 | AuthService | **Dependency** | - - -▷ | OrangTua | - | AuthService uses OrangTua |
| 16 | AnalyticsService | **Dependency** | - - -▷ | Transaksi | - | AnalyticsService uses Transaksi |
| 17 | NotificationService | **Dependency** | - - -▷ | User | - | NotificationService uses User |
| 18 | All Models | **Dependency** | - - -▷ | Database | - | Semua model uses Database |

### Legenda Tipe Relasi

| Simbol | Nama | Keterangan |
|--------|------|------------|
| ──▷ | **Generalization (Inheritance)** | Garis solid + segitiga kosong. Child mewarisi Parent. |
| ── | **Association** | Garis solid biasa. Hubungan antar class. |
| ◆── | **Composition** | Garis solid + diamond hitam. Part tidak bisa exist tanpa Whole. |
| ◇── | **Aggregation** | Garis solid + diamond putih. Part bisa exist tanpa Whole. |
| - - -▷ | **Dependency** | Garis putus-putus + panah. Class A uses Class B. |

---

# B. ENTITY RELATIONSHIP DIAGRAM (ERD)

## Total Tabel: 10 Tabel

---

## 1. users
| No | Atribut | Tipe Data | Constraint | Keterangan |
|----|---------|-----------|------------|------------|
| 1 | id | INT | PK, AUTO_INCREMENT | Primary Key |
| 2 | nama | VARCHAR(100) | NOT NULL | Nama lengkap |
| 3 | email | VARCHAR(100) | UNIQUE, NOT NULL | Email login |
| 4 | password | VARCHAR(255) | NOT NULL | Hash password |
| 5 | role | ENUM | NOT NULL | mahasiswa/orangtua/admin |
| 6 | reset_token | VARCHAR(64) | NULL | Token reset password |
| 7 | reset_expires | TIMESTAMP | NULL | Waktu expired token |
| 8 | created_at | TIMESTAMP | DEFAULT NOW | Waktu dibuat |
| 9 | updated_at | TIMESTAMP | ON UPDATE | Waktu update |

---

## 2. mahasiswa
| No | Atribut | Tipe Data | Constraint | Keterangan |
|----|---------|-----------|------------|------------|
| 1 | id | INT | PK, AUTO_INCREMENT | Primary Key |
| 2 | user_id | INT | FK → users.id | Foreign Key |
| 3 | nim | VARCHAR(20) | UNIQUE, NOT NULL | Nomor Induk Mahasiswa |
| 4 | jurusan | VARCHAR(100) | NULL | Nama jurusan |
| 5 | saldo | DECIMAL(15,2) | DEFAULT 0 | Saldo keuangan |
| 6 | pairing_code | VARCHAR(10) | UNIQUE | Kode pairing orangtua |
| 7 | created_at | TIMESTAMP | DEFAULT NOW | Waktu dibuat |
| 8 | updated_at | TIMESTAMP | ON UPDATE | Waktu update |

---

## 3. orangtua
| No | Atribut | Tipe Data | Constraint | Keterangan |
|----|---------|-----------|------------|------------|
| 1 | id | INT | PK, AUTO_INCREMENT | Primary Key |
| 2 | user_id | INT | FK → users.id | Foreign Key |
| 3 | no_telepon | VARCHAR(20) | NULL | Nomor telepon |
| 4 | created_at | TIMESTAMP | DEFAULT NOW | Waktu dibuat |
| 5 | updated_at | TIMESTAMP | ON UPDATE | Waktu update |

---

## 4. relasi_orangtua_mahasiswa (Junction Table)
| No | Atribut | Tipe Data | Constraint | Keterangan |
|----|---------|-----------|------------|------------|
| 1 | id | INT | PK, AUTO_INCREMENT | Primary Key |
| 2 | orangtua_id | INT | FK → orangtua.id | Foreign Key |
| 3 | mahasiswa_id | INT | FK → mahasiswa.id | Foreign Key |
| 4 | created_at | TIMESTAMP | DEFAULT NOW | Waktu dibuat |

---

## 5. kategori
| No | Atribut | Tipe Data | Constraint | Keterangan |
|----|---------|-----------|------------|------------|
| 1 | id | INT | PK, AUTO_INCREMENT | Primary Key |
| 2 | mahasiswa_id | INT | FK → mahasiswa.id | Foreign Key |
| 3 | nama | VARCHAR(50) | NOT NULL | Nama kategori |
| 4 | tipe | ENUM | NOT NULL | pemasukan/pengeluaran |
| 5 | created_at | TIMESTAMP | DEFAULT NOW | Waktu dibuat |
| 6 | updated_at | TIMESTAMP | ON UPDATE | Waktu update |

---

## 6. transaksi
| No | Atribut | Tipe Data | Constraint | Keterangan |
|----|---------|-----------|------------|------------|
| 1 | id | INT | PK, AUTO_INCREMENT | Primary Key |
| 2 | mahasiswa_id | INT | FK → mahasiswa.id | Foreign Key |
| 3 | kategori_id | INT | FK → kategori.id | Foreign Key |
| 4 | jumlah | DECIMAL(15,2) | NOT NULL | Jumlah asli |
| 5 | mata_uang | VARCHAR(3) | DEFAULT 'IDR' | Kode mata uang |
| 6 | jumlah_idr | DECIMAL(15,2) | NOT NULL | Jumlah dalam IDR |
| 7 | kurs_rate | DECIMAL(15,6) | DEFAULT 1 | Nilai kurs |
| 8 | keterangan | TEXT | NULL | Catatan |
| 9 | tanggal | DATE | NOT NULL | Tanggal transaksi |
| 10 | created_at | TIMESTAMP | DEFAULT NOW | Waktu dibuat |
| 11 | updated_at | TIMESTAMP | ON UPDATE | Waktu update |

---

## 7. transfer_saldo
| No | Atribut | Tipe Data | Constraint | Keterangan |
|----|---------|-----------|------------|------------|
| 1 | id | INT | PK, AUTO_INCREMENT | Primary Key |
| 2 | orangtua_id | INT | FK → orangtua.id | Foreign Key |
| 3 | mahasiswa_id | INT | FK → mahasiswa.id | Foreign Key |
| 4 | jumlah | DECIMAL(15,2) | NOT NULL | Jumlah asli |
| 5 | mata_uang | VARCHAR(3) | DEFAULT 'IDR' | Kode mata uang |
| 6 | jumlah_idr | DECIMAL(15,2) | NOT NULL | Jumlah dalam IDR |
| 7 | kurs_rate | DECIMAL(15,6) | DEFAULT 1 | Nilai kurs |
| 8 | keterangan | TEXT | NULL | Catatan |
| 9 | status | ENUM | DEFAULT 'completed' | pending/completed/failed |
| 10 | created_at | TIMESTAMP | DEFAULT NOW | Waktu dibuat |

---

## 8. reminders
| No | Atribut | Tipe Data | Constraint | Keterangan |
|----|---------|-----------|------------|------------|
| 1 | id | INT | PK, AUTO_INCREMENT | Primary Key |
| 2 | mahasiswa_id | INT | FK → mahasiswa.id | Foreign Key |
| 3 | nama | VARCHAR(100) | NOT NULL | Nama tagihan |
| 4 | jumlah | DECIMAL(15,2) | NOT NULL | Jumlah tagihan |
| 5 | tanggal_jatuh_tempo | DATE | NOT NULL | Tanggal jatuh tempo |
| 6 | status | ENUM | DEFAULT 'pending' | pending/paid |
| 7 | created_at | TIMESTAMP | DEFAULT NOW | Waktu dibuat |

---

## 9. notifications
| No | Atribut | Tipe Data | Constraint | Keterangan |
|----|---------|-----------|------------|------------|
| 1 | id | INT | PK, AUTO_INCREMENT | Primary Key |
| 2 | user_id | INT | FK → users.id | Foreign Key |
| 3 | tipe | VARCHAR(50) | NOT NULL | Jenis notifikasi |
| 4 | judul | VARCHAR(100) | NOT NULL | Judul notifikasi |
| 5 | pesan | TEXT | NOT NULL | Isi pesan |
| 6 | status | ENUM | DEFAULT 'pending' | pending/sent/failed |
| 7 | sent_at | TIMESTAMP | NULL | Waktu terkirim |
| 8 | created_at | TIMESTAMP | DEFAULT NOW | Waktu dibuat |

---

## 10. exchange_rate_log
| No | Atribut | Tipe Data | Constraint | Keterangan |
|----|---------|-----------|------------|------------|
| 1 | id | INT | PK, AUTO_INCREMENT | Primary Key |
| 2 | base_currency | VARCHAR(3) | NOT NULL | Mata uang asal |
| 3 | target_currency | VARCHAR(3) | NOT NULL | Mata uang tujuan |
| 4 | rate | DECIMAL(15,6) | NOT NULL | Nilai kurs |
| 5 | fetched_at | TIMESTAMP | DEFAULT NOW | Waktu fetch |
| 6 | expires_at | TIMESTAMP | NOT NULL | Waktu expired |

---

## Relasi Antar Tabel ERD

| No | Tabel 1 | Relasi | Tabel 2 | Keterangan |
|----|---------|--------|---------|------------|
| 1 | users | **1:1** | mahasiswa | Satu user bisa jadi satu mahasiswa |
| 2 | users | **1:1** | orangtua | Satu user bisa jadi satu orangtua |
| 3 | users | **1:N** | notifications | Satu user punya banyak notifikasi |
| 4 | mahasiswa | **1:N** | kategori | Satu mahasiswa punya banyak kategori |
| 5 | mahasiswa | **1:N** | transaksi | Satu mahasiswa punya banyak transaksi |
| 6 | mahasiswa | **1:N** | reminders | Satu mahasiswa punya banyak reminder |
| 7 | kategori | **1:N** | transaksi | Satu kategori dipakai banyak transaksi |
| 8 | orangtua | **1:N** | mahasiswa | Satu orangtua memantau banyak mahasiswa |
| 9 | orangtua | **1:N** | transfer_saldo | Satu orangtua kirim banyak transfer |
| 10 | mahasiswa | **1:N** | transfer_saldo | Satu mahasiswa terima banyak transfer |

---

## Design Patterns yang Digunakan

| Pattern | Class | Keterangan |
|---------|-------|------------|
| **Singleton** | Database | Satu instance PDO untuk seluruh aplikasi |
| **Inheritance** | User → Mahasiswa, OrangTua, Admin | Pewarisan properti dan method |
| **Service Layer** | AuthService, AnalyticsService, etc. | Memisahkan business logic dari controller |
| **MVC** | Controllers + Models + Views | Arsitektur aplikasi web |

---

## Ringkasan

| Komponen | Jumlah |
|----------|--------|
| **Class Diagram** | 13 class |
| **Tabel ERD** | 10 tabel |
| **Relasi Class (UML)** | 18 relasi |
| **Relasi Tabel (ERD)** | 10 relasi |
| **Design Patterns** | 4 patterns |
