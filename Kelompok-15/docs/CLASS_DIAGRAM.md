# Class Diagram
## Sistem Keuangan Mahasiswa

---

## Daftar Class

### 1. User (Abstract/Base Class)
**Lokasi:** `app/Models/User.php`

| Atribut | Tipe | Visibility | Keterangan |
|---------|------|------------|------------|
| id | int | private | Primary key |
| nama | string | private | Nama lengkap |
| email | string | private | Email login |
| password | string | private | Hash password |
| role | string | private | Role user |
| createdAt | string | private | Timestamp |
| updatedAt | string | private | Timestamp |

| Method | Return | Visibility | Keterangan |
|--------|--------|------------|------------|
| getId() | int | public | Getter id |
| getNama() | string | public | Getter nama |
| getEmail() | string | public | Getter email |
| getRole() | string | public | Getter role |
| setNama(string) | self | public | Setter nama |
| setEmail(string) | self | public | Setter email |
| setPassword(string) | self | public | Hash & set password |
| verifyPassword(string) | bool | public | Verifikasi password |
| find(int) | User|null | public | Cari by ID |
| findByEmail(string) | User|null | public | Cari by email |
| create() | int | public | Insert ke DB |
| update() | bool | public | Update di DB |
| delete() | bool | public | Hapus dari DB |

---

### 2. Mahasiswa (extends User)
**Lokasi:** `app/Models/Mahasiswa.php`

| Atribut | Tipe | Visibility | Keterangan |
|---------|------|------------|------------|
| mahasiswaId | int | private | ID di tabel mahasiswa |
| nim | string | private | Nomor Induk Mahasiswa |
| jurusan | string | private | Nama jurusan |
| saldo | float | private | Saldo saat ini |
| pairingCode | string | private | Kode pairing |

| Method | Return | Visibility | Keterangan |
|--------|--------|------------|------------|
| getMahasiswaId() | int | public | Getter mahasiswa_id |
| getNim() | string | public | Getter NIM |
| getJurusan() | string | public | Getter jurusan |
| getSaldo() | float | public | Getter saldo |
| getPairingCode() | string | public | Getter pairing code |
| findMahasiswa(int) | Mahasiswa | public | Cari by mahasiswa_id |
| findByPairingCode(string) | Mahasiswa | public | Cari by pairing code |
| updateSaldo(float) | bool | public | Update saldo |
| addSaldo(float) | bool | public | Tambah saldo |
| generatePairingCode() | string | public | Generate kode baru |
| createDefaultKategori() | void | public | Buat kategori default |

---

### 3. OrangTua (extends User)
**Lokasi:** `app/Models/OrangTua.php`

| Atribut | Tipe | Visibility | Keterangan |
|---------|------|------------|------------|
| orangtuaId | int | private | ID di tabel orangtua |
| userId | int | private | FK ke users.id |
| noTelepon | string | private | Nomor telepon |

| Method | Return | Visibility | Keterangan |
|--------|--------|------------|------------|
| getOrangtuaId() | int | public | Getter orangtua_id |
| getUserId() | int | public | Getter user_id |
| getNoTelepon() | string | public | Getter no_telepon |
| setNoTelepon(string) | self | public | Setter no_telepon |
| findOrangtua(int) | OrangTua | public | Cari by orangtua_id |
| findByUserId(int) | OrangTua | public | Cari by user_id |
| createOrangtua() | int | public | Insert orangtua baru |
| updateOrangtua() | bool | public | Update data orangtua |
| linkMahasiswa(int) | bool | public | Hubungkan dengan mahasiswa |
| unlinkMahasiswa(int) | bool | public | Lepaskan hubungan |
| getMahasiswaLinked() | array | public | Daftar anak terhubung |
| isMahasiswaLinked(int) | bool | public | Cek apakah terhubung |
| getTransferHistory(int) | array | public | Riwayat transfer |

---

### 4. Admin (extends User)
**Lokasi:** `app/Models/Admin.php`

| Atribut | Tipe | Visibility | Keterangan |
|---------|------|------------|------------|
| *(inherit dari User)* | - | - | Menggunakan atribut User |

| Method | Return | Visibility | Keterangan |
|--------|--------|------------|------------|
| findAdmin(int) | Admin | public | Cari admin by user_id |
| getStatistics() | array | public | Statistik sistem (total users, transaksi, dll) |
| getRecentActivities(int) | array | public | Aktivitas terbaru |
| getAllUsers() | array | public | Semua user di sistem |

---

### 5. Kategori
**Lokasi:** `app/Models/Kategori.php`

| Atribut | Tipe | Visibility | Keterangan |
|---------|------|------------|------------|
| id | int | private | Primary key |
| mahasiswaId | int | private | FK mahasiswa |
| nama | string | private | Nama kategori |
| tipe | string | private | pemasukan/pengeluaran |

| Method | Return | Visibility | Keterangan |
|--------|--------|------------|------------|
| getId() | int | public | Getter id |
| getNama() | string | public | Getter nama |
| getTipe() | string | public | Getter tipe |
| find(int) | Kategori | public | Cari by ID |
| getAllByMahasiswa(int) | array | public | Semua kategori mahasiswa |
| create() | int | public | Insert ke DB |
| update() | bool | public | Update di DB |
| delete() | bool | public | Hapus dari DB |
| isUsedInTransaksi() | bool | public | Cek dipakai transaksi |

---

### 6. Transaksi
**Lokasi:** `app/Models/Transaksi.php`

| Atribut | Tipe | Visibility | Keterangan |
|---------|------|------------|------------|
| id | int | private | Primary key |
| mahasiswaId | int | private | FK mahasiswa |
| kategoriId | int | private | FK kategori |
| jumlah | float | private | Jumlah asli |
| mataUang | string | private | Kode mata uang |
| jumlahIdr | float | private | Jumlah dalam IDR |
| kursRate | float | private | Nilai kurs |
| keterangan | string | private | Catatan |
| tanggal | string | private | Tanggal transaksi |

| Method | Return | Visibility | Keterangan |
|--------|--------|------------|------------|
| find(int) | Transaksi | public | Cari by ID |
| getAllByMahasiswa(int) | array | public | Semua transaksi |
| getMonthlySummary(int,int,int) | array | public | Ringkasan bulanan |
| getCategorySummary(int) | array | public | Ringkasan per kategori |
| create() | int | public | Insert ke DB |
| update() | bool | public | Update di DB |
| delete() | bool | public | Hapus dari DB |

---

### 7. TransferSaldo
**Lokasi:** `app/Models/TransferSaldo.php`

| Atribut | Tipe | Visibility | Keterangan |
|---------|------|------------|------------|
| id | int | private | Primary key |
| orangtuaId | int | private | FK orangtua |
| mahasiswaId | int | private | FK mahasiswa |
| jumlah | float | private | Jumlah asli |
| mataUang | string | private | Kode mata uang |
| jumlahIdr | float | private | Jumlah dalam IDR |
| kursRate | float | private | Nilai kurs |
| status | string | private | Status transfer |

| Method | Return | Visibility | Keterangan |
|--------|--------|------------|------------|
| getAllByOrangtua(int) | array | public | Riwayat dari orangtua |
| getAllByMahasiswa(int) | array | public | Riwayat ke mahasiswa |
| create() | int | public | Insert & update saldo |

---

### 8. Database (Singleton)
**Lokasi:** `app/Core/Database.php`

| Atribut | Tipe | Visibility | Keterangan |
|---------|------|------------|------------|
| instance | Database | private static | Singleton instance |
| connection | PDO | private | Koneksi PDO |

| Method | Return | Visibility | Keterangan |
|--------|--------|------------|------------|
| getInstance() | Database | public static | Get singleton |
| getConnection() | PDO | public | Get PDO |
| query(string, array) | PDOStatement | public | Execute query |
| fetch(string, array) | array|null | public | Fetch satu row |
| fetchAll(string, array) | array | public | Fetch semua |
| insert(string, array) | int | public | Insert & get ID |
| update(string, array) | int | public | Update & get rows |
| delete(string, array) | int | public | Delete & get rows |
| beginTransaction() | bool | public | Start transaction |
| commit() | bool | public | Commit |
| rollback() | bool | public | Rollback |

---

### 9. AuthService
**Lokasi:** `app/Services/AuthService.php`

| Method | Return | Visibility | Keterangan |
|--------|--------|------------|------------|
| login(string, string) | bool | public | Login user |
| register(array) | int | public | Register user baru |
| logout() | void | public | Logout user |
| isLoggedIn() | bool | public | Cek login status |
| getUser() | array | public | Get user session |

---

### 10. ExchangeRateService
**Lokasi:** `app/Services/ExchangeRateService.php`

| Method | Return | Visibility | Keterangan |
|--------|--------|------------|------------|
| getRate(string) | float | public | Get kurs ke IDR |
| convertToIdr(float, string) | array | public | Konversi ke IDR |
| getAvailableCurrencies() | array | public | Daftar mata uang |

---

### 11. AnalyticsService
**Lokasi:** `app/Services/AnalyticsService.php`

| Method | Return | Visibility | Keterangan |
|--------|--------|------------|------------|
| getDashboardStats() | array | public | Statistik dashboard |
| getSpendingStatus() | array | public | Status keuangan |
| getMonthlyData() | array | public | Data grafik bulanan |
| getCategoryData() | array | public | Data grafik kategori |

---

### 12. ApiClient
**Lokasi:** `app/Services/ApiClient.php`

| Atribut | Tipe | Visibility | Keterangan |
|---------|------|------------|------------|
| timeout | int | private | Timeout request (default: 30s) |
| defaultHeaders | array | private | Header default untuk request |

| Method | Return | Visibility | Keterangan |
|--------|--------|------------|------------|
| setTimeout(int) | self | public | Set timeout request |
| setHeader(string, string) | self | public | Set custom header |
| get(string, array) | array | public | HTTP GET request |
| post(string, array) | array | public | HTTP POST request |
| request(string, string, array) | array | private | Execute cURL request |

---

### 13. NotificationService
**Lokasi:** `app/Services/NotificationService.php`

| Method | Return | Visibility | Keterangan |
|--------|--------|------------|------------|
| sendTransferNotification(int, string, string, float, string) | bool | public | Notif transfer masuk |
| sendReminderNotification(int, string, string, string, float, string) | bool | public | Notif reminder |

---

## Relasi Antar Class (untuk StarUML)

### Tabel Relasi UML

| No | Class Asal | Tipe Relasi | Line UML | Class Tujuan | Multiplicity | Keterangan |
|----|------------|-------------|----------|--------------|--------------|------------|
| 1 | **Mahasiswa** | Inheritance | ──▷ (Generalization) | **User** | - | Mahasiswa extends User |
| 2 | **OrangTua** | Inheritance | ──▷ (Generalization) | **User** | - | OrangTua extends User |
| 3 | **Admin** | Inheritance | ──▷ (Generalization) | **User** | - | Admin extends User |
| 4 | **OrangTua** | Association | ── (Directed) | **Mahasiswa** | 1 → * | Satu orangtua memantau banyak mahasiswa |
| 5 | **Mahasiswa** | Composition | ◆── (Filled Diamond) | **Kategori** | 1 → * | Kategori tidak bisa ada tanpa Mahasiswa |
| 6 | **Mahasiswa** | Composition | ◆── (Filled Diamond) | **Transaksi** | 1 → * | Transaksi milik Mahasiswa |
| 7 | **Kategori** | Association | ── (Directed) | **Transaksi** | 1 → * | Satu kategori untuk banyak transaksi |
| 8 | **OrangTua** | Composition | ◆── (Filled Diamond) | **TransferSaldo** | 1 → * | Transfer milik OrangTua |
| 9 | **Mahasiswa** | Association | ── (Directed) | **TransferSaldo** | 1 → * | Mahasiswa menerima transfer |
| 10 | **Transaksi** | Dependency | - - -▷ (Dashed) | **ExchangeRateService** | - | Transaksi uses ExchangeRateService |
| 11 | **TransferSaldo** | Dependency | - - -▷ (Dashed) | **ExchangeRateService** | - | TransferSaldo uses ExchangeRateService |
| 12 | **ExchangeRateService** | Dependency | - - -▷ (Dashed) | **ApiClient** | - | ExchangeRateService uses ApiClient |
| 13 | **AuthService** | Dependency | - - -▷ (Dashed) | **User** | - | AuthService uses User |
| 14 | **AuthService** | Dependency | - - -▷ (Dashed) | **Mahasiswa** | - | AuthService uses Mahasiswa |
| 15 | **AuthService** | Dependency | - - -▷ (Dashed) | **OrangTua** | - | AuthService uses OrangTua |
| 16 | **AnalyticsService** | Dependency | - - -▷ (Dashed) | **Transaksi** | - | AnalyticsService uses Transaksi |
| 17 | **NotificationService** | Dependency | - - -▷ (Dashed) | **User** | - | NotificationService uses User |
| 18 | **All Models** | Dependency | - - -▷ (Dashed) | **Database** | - | Semua model uses Database (Singleton) |

---

### Legenda Tipe Line UML untuk StarUML

| Simbol | Nama | Keterangan |
|--------|------|------------|
| ──▷ | **Generalization (Inheritance)** | Garis solid dengan segitiga kosong. Child class mewarisi dari Parent class. |
| ── | **Association** | Garis solid biasa. Menunjukkan hubungan antar class. |
| ◆── | **Composition** | Garis solid dengan diamond hitam (filled). Part tidak bisa exist tanpa Whole. |
| ◇── | **Aggregation** | Garis solid dengan diamond putih (empty). Part bisa exist tanpa Whole. |
| - - -▷ | **Dependency** | Garis putus-putus dengan panah. Class A uses/depends on Class B. |
| ─○ | **Realization** | Garis putus-putus dengan segitiga. Implementasi interface. |

---

### Multiplicity Notation

| Notasi | Arti |
|--------|------|
| 1 | Tepat satu |
| 0..1 | Nol atau satu |
| * | Nol atau lebih (banyak) |
| 1..* | Satu atau lebih |
| 1 → * | One-to-Many |
| * → * | Many-to-Many |

---

### Diagram Visual (ASCII)

```
                         ┌─────────────┐
                         │    User     │ (Abstract)
                         ├─────────────┤
                         │ -id         │
                         │ -nama       │
                         │ -email      │
                         │ -password   │
                         │ -role       │
                         └──────▲──────┘
                                │ Inheritance (──▷)
              ┌─────────────────┼─────────────────┐
              │                                   │
    ┌─────────┴─────────┐               ┌─────────┴─────────┐
    │    Mahasiswa      │               │     OrangTua      │
    ├───────────────────┤               ├───────────────────┤
    │ -nim              │◄──────────────│ -noTelepon        │
    │ -jurusan          │  Association  │ -orangtuaId       │
    │ -saldo            │  (1 → *)      └─────────┬─────────┘
    │ -pairingCode      │                         │
    └─────────┬─────────┘                         │ Composition (◆──)
              │                                   │ 1 → *
              │ Composition (◆──)                 ▼
              │ 1 → *                   ┌─────────────────┐
              ▼                         │  TransferSaldo  │
    ┌─────────────────┐                 ├─────────────────┤
    │    Kategori     │                 │ -jumlah         │
    ├─────────────────┤                 │ -mataUang       │
    │ -nama           │                 │ -jumlahIdr      │
    │ -tipe           │                 │ -status         │
    └─────────┬───────┘                 └────────┬────────┘
              │                                  │
              │ Association (──)                 │ Dependency (- - -▷)
              │ 1 → *                            ▼
              ▼                         ┌─────────────────────┐
    ┌─────────────────┐                 │ ExchangeRateService │
    │   Transaksi     │- - - - - - - - ▷├─────────────────────┤
    ├─────────────────┤   Dependency    │ +getRate()          │
    │ -jumlah         │                 │ +convertToIdr()     │
    │ -mataUang       │                 └──────────┬──────────┘
    │ -jumlahIdr      │                            │
    │ -kursRate       │                            │ Dependency (- - -▷)
    └─────────────────┘                            ▼
                                        ┌─────────────────┐
                                        │    ApiClient    │
                                        ├─────────────────┤
                                        │ +get()          │
                                        │ +post()         │
                                        └─────────────────┘

    ┌─────────────────────────────────────────────────────────────────┐
    │                        SERVICE LAYER                            │
    ├─────────────────┬─────────────────┬─────────────────────────────┤
    │  AuthService    │ AnalyticsService│   NotificationService       │
    │  - - - ▷ User   │  - - - ▷ Trans  │   - - - ▷ User              │
    │  - - - ▷ Mhs    │                 │                             │
    │  - - - ▷ Ortu   │                 │                             │
    └─────────────────┴─────────────────┴─────────────────────────────┘
                                │
                                │ All Dependency (- - -▷)
                                ▼
                      ┌─────────────────┐
                      │    Database     │ (Singleton)
                      ├─────────────────┤
                      │ -instance       │
                      │ -connection     │
                      ├─────────────────┤
                      │ +getInstance()  │
                      │ +query()        │
                      └─────────────────┘
```

---

## Design Patterns

| Pattern | Class | Keterangan |
|---------|-------|------------|
| Singleton | Database | Satu instance PDO untuk seluruh aplikasi |
| Inheritance | User → Mahasiswa, OrangTua | Pewarisan properti dan method |
| Service Layer | AuthService, AnalyticsService, etc. | Memisahkan business logic |
| MVC | Controllers + Models + Views | Arsitektur aplikasi |

---

## Ringkasan Relasi untuk StarUML

**Inheritance (Generalization):** 2 relasi
- Mahasiswa ──▷ User
- OrangTua ──▷ User

**Composition:** 4 relasi
- Mahasiswa ◆── Kategori (1:*)
- Mahasiswa ◆── Transaksi (1:*)
- OrangTua ◆── TransferSaldo (1:*)
- Kategori ◆── TransferSaldo (via Kategori)

**Association:** 2 relasi
- OrangTua ── Mahasiswa (1:*)
- Kategori ── Transaksi (1:*)

**Dependency:** 8 relasi
- Transaksi - - -▷ ExchangeRateService
- TransferSaldo - - -▷ ExchangeRateService
- ExchangeRateService - - -▷ ApiClient
- AuthService - - -▷ User, Mahasiswa, OrangTua
- AnalyticsService - - -▷ Transaksi
- NotificationService - - -▷ User
- All Models - - -▷ Database
