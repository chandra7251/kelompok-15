# 📚 Dokumentasi Lengkap Proyek Sistem Keuangan Mahasiswa

Proyek ini adalah **Sistem Keuangan Mahasiswa dengan Kurs Otomatis dan Monitoring Orang Tua** - aplikasi web berbasis PHP yang memungkinkan mahasiswa mencatat transaksi keuangan, orang tua memantau dan mengirim uang, serta admin mengelola sistem.

---

## 📁 Struktur Folder Proyek

```
Kelompok-15/
├── app/                    # 📂 Folder utama logika aplikasi (Backend)
│   ├── Controllers/        # Controller untuk menangani request
│   ├── Core/               # Komponen inti sistem
│   ├── Helpers/            # Fungsi-fungsi bantuan (helper)
│   ├── Models/             # Model untuk akses database
│   └── Services/           # Service untuk logika bisnis
├── docs/                   # 📂 Dokumentasi proyek
├── public/                 # 📂 Folder publik (entry point)
│   ├── assets/             # CSS dan JavaScript
│   └── index.php           # Entry point aplikasi
├── vendor/                 # 📂 Library pihak ketiga (Composer)
├── views/                  # 📂 File tampilan (HTML/PHP)
│   ├── auth/               # View untuk authentication
│   ├── dashboard/          # View untuk dashboard
│   ├── kategori/           # View untuk kategori
│   ├── layouts/            # Template layout
│   ├── transaksi/          # View untuk transaksi
│   └── transfer/           # View untuk transfer
├── .env                    # Konfigurasi environment (rahasia)
├── .env.example            # Contoh konfigurasi environment
├── .gitignore              # Daftar file yang diabaikan Git
├── composer.json           # Definisi dependensi Composer
├── composer.lock           # Lock file untuk Composer
├── database.sql            # Skema database SQL
└── README.md               # Dokumentasi proyek
```

---

## 🌊 ALUR APLIKASI (Application Flow)

### 1. Entry Point - `public/index.php`

Semua request HTTP masuk melalui file ini. Berikut adalah alur lengkapnya:

```
User Request → public/index.php → Routing → Controller → Model → Database
                                      ↓
                              View ← Controller ← Response
```

### 2. Cara Kerja Routing

```php
// File: public/index.php

// 1. Mengambil parameter dari URL
$page = $_GET['page'] ?? 'login';    // Halaman yang diminta
$action = $_GET['action'] ?? 'index'; // Aksi yang dilakukan

// 2. Definisi routes
$routes = [
    'login' => ['controller' => 'AuthController', 'actions' => ['index' => 'showLogin', 'submit' => 'login']],
    'dashboard' => ['controller' => 'DashboardController', 'actions' => ['index' => 'index']],
    // ...dll
];

// 3. Memanggil controller yang sesuai
$controllerName = "App\\Controllers\\" . $route['controller'];
$controller = new $controllerName();
$controller->$methodName();
```

**Penjelasan Syntax Asing:**
- `$page = $_GET['page'] ?? 'login'` → **Null Coalescing Operator**: Jika `$_GET['page']` tidak ada atau null, gunakan nilai default `'login'`
- `"App\\Controllers\\"` → Double backslash karena backslash adalah karakter escape di PHP

### 3. Pola MVC (Model-View-Controller)

```
┌─────────────┐     ┌────────────┐     ┌───────────┐
│   Browser   │────▶│ Controller │────▶│   Model   │
│  (Request)  │     │            │     │           │
└─────────────┘     └────────────┘     └───────────┘
                          │                  │
                          ▼                  ▼
                    ┌────────────┐     ┌───────────┐
                    │    View    │     │  Database │
                    │   (HTML)   │     │           │
                    └────────────┘     └───────────┘
```

---

## 📂 PENJELASAN DETAIL TIAP FOLDER

---

### 📁 `app/Core/` - Komponen Inti

#### `Database.php`

Kelas untuk koneksi dan operasi database menggunakan **PDO** (PHP Data Objects).

```php
class Database
{
    // Property dengan tipe data dan visibility
    private static ?Database $instance = null;  // Singleton instance
    private PDO $connection;                     // Koneksi PDO

    // Constructor private untuk Singleton Pattern
    private function __construct()
    {
        $dsn = "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4";
        $this->connection = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,        // Throw exception jika error
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,   // Return array asosiatif
            PDO::ATTR_EMULATE_PREPARES => false                 // Prepared statement asli
        ]);
    }

    // Singleton: Mendapatkan instance tunggal
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
```

**Penjelasan Syntax Asing:**

| Syntax | Penjelasan |
|--------|------------|
| `private static ?Database $instance = null` | Property statis dengan nullable type. `?Database` artinya bisa `Database` atau `null` |
| `self::$instance` | Mengakses property statis dari dalam kelas |
| `: self` | Return type declaration - method mengembalikan instance dari kelas itu sendiri |
| `PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION` | Konstanta kelas PDO untuk konfigurasi |
| `$this->connection` | `$this` merujuk ke instance objek saat ini |

**Apa itu Singleton Pattern?**
> Design pattern yang memastikan hanya ada SATU instance dari kelas Database. Ini menghemat memori karena koneksi database tidak dibuat berulang-ulang.

---

### 📁 `app/Helpers/` - Fungsi Bantuan

#### `helpers.php`

File ini berisi fungsi-fungsi global yang bisa dipanggil dari mana saja.

#### 🔒 Fungsi Keamanan

```php
// 1. Escape HTML untuk mencegah XSS Attack
function escape(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

// Shorthand untuk escape
function e(?string $value): string
{
    return escape($value);
}
```

**Apa itu XSS (Cross-Site Scripting)?**
> Serangan di mana penyerang menyuntikkan script berbahaya ke website. Contoh:
> ```html
> <!-- Input berbahaya -->
> <script>alert('Hacked!')</script>
> 
> <!-- Setelah di-escape menjadi aman -->
> &lt;script&gt;alert('Hacked!')&lt;/script&gt;
> ```

#### 🔐 CSRF Token Functions

```php
// Membuat CSRF token baru
function csrf_token(): string
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Membuat hidden input field dengan CSRF token
function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
}

// Memverifikasi CSRF token
function verify_csrf(): bool
{
    $token = $_POST['csrf_token'] ?? '';
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
```

### 🛡️ Apa itu CSRF Token?

**CSRF (Cross-Site Request Forgery)** adalah serangan di mana penyerang mengelabui pengguna untuk melakukan aksi yang tidak diinginkan.

**Analogi Sederhana:**
> Bayangkan Anda sudah login di bank online. Penyerang mengirim email dengan tombol "Lihat Foto Kucing" yang sebenarnya adalah link transfer uang. Karena Anda sudah login, bank akan mengira request itu dari Anda.

**Cara CSRF Token Melindungi:**

```
┌─────────────────────────────────────────────────────────────────┐
│                        TANPA CSRF TOKEN                         │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  User login ───▶ Penyerang kirim link ───▶ Form submit         │
│                  berbahaya                   langsung!          │
│                  (tanpa sepengetahuan user)                     │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│                       DENGAN CSRF TOKEN                         │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  User login ───▶ Server buat ───▶ Token disimpan di session    │
│                  token unik                                      │
│                       │                                          │
│                       ▼                                          │
│  Form submit ───▶ Token dikirim ───▶ Server cocokkan           │
│                   bersama form        dengan session             │
│                                           │                      │
│                                    ┌──────┴──────┐              │
│                                    │             │               │
│                                  COCOK      TIDAK COCOK          │
│                                    │             │               │
│                                    ▼             ▼               │
│                                 PROSES        TOLAK!             │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

**Penjelasan Fungsi:**
- `bin2hex(random_bytes(32))` → Membuat 32 byte random, lalu dikonversi ke hexadecimal (64 karakter)
- `hash_equals()` → Membandingkan string dengan cara yang aman (timing-safe) untuk mencegah timing attacks

---

#### 🔄 Fungsi Navigasi

```php
function redirect(string $url): void
{
    header("Location: $url");  // Mengirim header redirect
    exit;                        // Menghentikan eksekusi script
}

function back(): void
{
    $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php?page=dashboard';
    redirect($referer);
}
```

#### 💾 Fungsi Session

```php
// Menyimpan input lama untuk form (jika ada error)
function old(string $key, string $default = ''): string
{
    return escape($_SESSION['old_input'][$key] ?? $default);
}

// Flash message - pesan yang muncul sekali
function flash(string $key, string $message): void
{
    $_SESSION['flash'][$key] = $message;
}

function get_flash(string $key): ?string
{
    $message = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);  // Hapus setelah diambil
    return $message;
}
```

#### 💰 Fungsi Format

```php
// Format angka ke Rupiah
function format_rupiah(float $amount): string
{
    return 'Rp ' . number_format($amount, 0, ',', '.');
    // Contoh: format_rupiah(1500000) → "Rp 1.500.000"
}

// Format tanggal ke Bahasa Indonesia
function format_tanggal(string $date): string
{
    $bulan = [1 => 'Januari', 'Februari', ...];
    // Contoh: format_tanggal('2024-12-14') → "14 Desember 2024"
}
```

#### 🔗 Fungsi View

```php
function view(string $viewPath, array $data = []): void
{
    extract($data);  // Mengubah array menjadi variabel
    $viewFile = dirname(__DIR__, 2) . '/views/' . str_replace('.', '/', $viewPath) . '.php';
    require $viewFile;
}
```

**Penjelasan `extract()`:**
```php
$data = ['user' => 'John', 'age' => 25];
extract($data);
// Sekarang tersedia variabel:
// $user = 'John'
// $age = 25
```

---

### 📁 `app/Models/` - Model Database

Model adalah representasi tabel database dalam bentuk kelas PHP.

#### `User.php` - Model Dasar User

```php
namespace App\Models;

use App\Core\Database;

class User
{
    protected Database $db;           // Koneksi database
    private ?int $id = null;          // ID user (nullable)
    private string $nama = '';        // Nama user
    private string $email = '';       // Email user
    private string $password = '';    // Password (hashed)
    private string $role = '';        // Role: mahasiswa/orangtua/admin

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // Getter - Mengambil nilai property
    public function getId(): ?int { return $this->id; }
    public function getNama(): string { return $this->nama; }
    
    // Setter dengan validasi
    public function setNama(string $nama): self
    {
        $nama = trim($nama);
        if (empty($nama))
            throw new \InvalidArgumentException("Nama tidak boleh kosong");
        if (strlen($nama) > 100)
            throw new \InvalidArgumentException("Nama maksimal 100 karakter");
        $this->nama = $nama;
        return $this;  // Return $this untuk method chaining
    }

    // Password dengan hashing
    public function setPassword(string $password, bool $hash = true): self
    {
        if ($hash) {
            if (strlen($password) < 6)
                throw new \InvalidArgumentException("Password minimal 6 karakter");
            $this->password = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $this->password = $password;
        }
        return $this;
    }

    // Mencari user berdasarkan ID
    public function find(int $id): ?self
    {
        $data = $this->db->fetch("SELECT * FROM users WHERE id = :id", ['id' => $id]);
        return $data ? $this->hydrate($data) : null;
    }

    // Membuat user baru
    public function create(): int
    {
        return $this->db->insert(
            "INSERT INTO users (nama, email, password, role) VALUES (:nama, :email, :password, :role)",
            ['nama' => $this->nama, 'email' => $this->email, 'password' => $this->password, 'role' => $this->role]
        );
    }

    // Mengisi property dari data database
    protected function hydrate(array $data): self
    {
        $this->id = (int) $data['id'];
        $this->nama = $data['nama'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->role = $data['role'];
        return $this;
    }
}
```

**Penjelasan Syntax Asing:**

| Syntax | Penjelasan |
|--------|------------|
| `namespace App\Models` | Namespace untuk mengorganisir kode, seperti folder virtual |
| `use App\Core\Database` | Mengimpor kelas dari namespace lain |
| `protected Database $db` | Property yang bisa diakses oleh kelas turunan |
| `private ?int $id = null` | `?int` = nullable integer, bisa int atau null |
| `: self` | Method mengembalikan instance dari kelas itu sendiri |
| `return $this` | Mengembalikan objek saat ini (untuk method chaining) |
| `password_hash()` | Fungsi PHP untuk hash password dengan bcrypt |

**Apa itu Method Chaining?**
```php
// Tanpa chaining (verbose)
$user->setNama('John');
$user->setEmail('john@email.com');
$user->setPassword('123456');

// Dengan chaining (elegan)
$user->setNama('John')
     ->setEmail('john@email.com')
     ->setPassword('123456');
```

**Apa itu Hydrate?**
> Pattern untuk mengisi property objek dari array (biasanya hasil query database).

---

#### `Mahasiswa.php` - Extends User

```php
class Mahasiswa extends User  // Inheritance dari User
{
    private ?int $mahasiswaId = null;
    private string $nim = '';
    private string $jurusan = '';
    private float $saldo = 0;
    private ?string $pairingCode = null;

    public function __construct()
    {
        parent::__construct();  // Memanggil constructor parent
    }

    // Membuat mahasiswa baru dengan transaksi
    public function createMahasiswa(): int
    {
        $this->db->beginTransaction();  // Mulai transaksi
        try {
            $this->setRole('mahasiswa');
            $userId = $this->create();  // Buat user dulu
            $this->userId = $userId;
            $this->pairingCode = $this->generateUniquePairingCode();

            // Buat record mahasiswa
            $mahasiswaId = $this->db->insert(
                "INSERT INTO mahasiswa (...) VALUES (...)",
                [...]
            );

            $this->createDefaultCategories($mahasiswaId);  // Buat kategori default
            $this->db->commit();  // Commit jika sukses
            return $mahasiswaId;
        } catch (\Exception $e) {
            $this->db->rollback();  // Rollback jika gagal
            throw $e;
        }
    }
}
```

**Apa itu Database Transaction?**
> Serangkaian operasi yang harus SEMUA berhasil atau SEMUA dibatalkan.

```
┌─────────────────────────────────────────────────────────────────┐
│                     DATABASE TRANSACTION                        │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  beginTransaction()                                             │
│       │                                                         │
│       ▼                                                         │
│  ┌─ INSERT ke tabel users ────────────────┐                    │
│  │                                         │                    │
│  │  ┌─ INSERT ke tabel mahasiswa ───────┐ │                    │
│  │  │                                    │ │                    │
│  │  │  ┌─ INSERT kategori default ────┐ │ │                    │
│  │  │  │                               │ │ │                    │
│  │  │  └───────────────────────────────┘ │ │                    │
│  │  └────────────────────────────────────┘ │                    │
│  └─────────────────────────────────────────┘                    │
│       │                              │                          │
│       ▼                              ▼                          │
│    SUKSES                         ERROR                         │
│       │                              │                          │
│       ▼                              ▼                          │
│   commit()                      rollback()                      │
│  (Simpan semua)               (Batalkan semua)                  │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

---

#### `OrangTua.php` - Model Orang Tua

```php
class OrangTua extends User
{
    private ?int $orangtuaId = null;
    private ?string $noTelepon = null;

    // Mendapatkan daftar mahasiswa yang terhubung
    public function getMahasiswaLinked(): array
    {
        return $this->db->fetchAll(
            "SELECT m.*, u.nama, u.email 
             FROM mahasiswa m 
             JOIN users u ON m.user_id = u.id 
             JOIN relasi_orangtua_mahasiswa r ON m.id = r.mahasiswa_id 
             WHERE r.orangtua_id = :orangtua_id",
            ['orangtua_id' => $this->orangtuaId]
        );
    }

    // Menghubungkan dengan mahasiswa
    public function linkMahasiswa(int $mahasiswaId): bool
    {
        // Cek apakah sudah terhubung
        $exists = $this->db->fetch(
            "SELECT COUNT(*) as count FROM relasi_orangtua_mahasiswa 
             WHERE orangtua_id = :orangtua_id AND mahasiswa_id = :mahasiswa_id",
            ['orangtua_id' => $this->orangtuaId, 'mahasiswa_id' => $mahasiswaId]
        );
        if ($exists['count'] > 0) return true;

        // Buat relasi baru
        $this->db->insert(
            "INSERT INTO relasi_orangtua_mahasiswa (orangtua_id, mahasiswa_id) VALUES (:orangtua_id, :mahasiswa_id)",
            ['orangtua_id' => $this->orangtuaId, 'mahasiswa_id' => $mahasiswaId]
        );
        return true;
    }
}
```

---

#### `Kategori.php` - Model Kategori

```php
class Kategori
{
    private string $tipe = '';  // 'pemasukan' atau 'pengeluaran'

    public function setTipe(string $tipe): self
    {
        if (!in_array($tipe, ['pemasukan', 'pengeluaran'])) {
            throw new \InvalidArgumentException("Tipe harus 'pemasukan' atau 'pengeluaran'");
        }
        $this->tipe = $tipe;
        return $this;
    }

    // Cek duplikat sebelum create
    public function create(): int
    {
        if ($this->isDuplicate()) {
            throw new \InvalidArgumentException("Kategori dengan nama dan tipe yang sama sudah ada");
        }
        return $this->db->insert(...);
    }

    // Cek apakah kategori bisa dihapus
    public function delete(): bool
    {
        $count = $this->db->fetch("SELECT COUNT(*) as count FROM transaksi WHERE kategori_id = :id", ['id' => $this->id]);
        if ($count['count'] > 0) {
            throw new \InvalidArgumentException("Kategori tidak dapat dihapus karena masih digunakan");
        }
        return $this->db->delete(...);
    }
}
```

---

#### `Transaksi.php` - Model Transaksi

```php
class Transaksi
{
    private float $jumlah;        // Jumlah dalam mata uang asli
    private string $mataUang = 'IDR';
    private float $jumlahIdr;     // Jumlah setelah dikonversi ke IDR
    private float $kursRate = 1;  // Rate konversi

    // Mendapatkan ringkasan per bulan
    public function getMonthlySummary(int $mahasiswaId, int $year, int $month): array
    {
        return $this->db->fetchAll(
            "SELECT k.tipe, SUM(t.jumlah_idr) as total 
             FROM transaksi t 
             JOIN kategori k ON t.kategori_id = k.id 
             WHERE t.mahasiswa_id = :mahasiswa_id 
               AND YEAR(t.tanggal) = :year 
               AND MONTH(t.tanggal) = :month 
             GROUP BY k.tipe",
            ['mahasiswa_id' => $mahasiswaId, 'year' => $year, 'month' => $month]
        );
    }
}
```

---

#### `TransferSaldo.php` - Model Transfer

```php
class TransferSaldo
{
    public function create(): int
    {
        $this->db->beginTransaction();
        try {
            // Insert record transfer
            $id = $this->db->insert(...);

            // Update saldo mahasiswa jika completed
            if ($this->status === 'completed') {
                $this->db->update(
                    "UPDATE mahasiswa SET saldo = saldo + :amount WHERE id = :id",
                    ['amount' => $this->jumlahIdr, 'id' => $this->mahasiswaId]
                );
            }

            $this->db->commit();
            return $id;
        } catch (\Exception $e) {
            $this->db->rollback();
            throw $e;
        }
    }
}
```

---

#### `Admin.php` - Model Admin

```php
class Admin extends User
{
    // Mendapatkan statistik sistem
    public function getStatistics(): array
    {
        $stats = [];
        $stats['total_users'] = $this->db->fetch("SELECT COUNT(*) as c FROM users")['c'];
        $stats['total_mahasiswa'] = $this->db->fetch("SELECT COUNT(*) as c FROM mahasiswa")['c'];
        $stats['total_orangtua'] = $this->db->fetch("SELECT COUNT(*) as c FROM orangtua")['c'];
        $stats['total_transaksi'] = $this->db->fetch("SELECT COUNT(*) as c FROM transaksi")['c'];
        return $stats;
    }

    // Mendapatkan semua user dengan info tambahan
    public function getAllUsers(): array
    {
        return $this->db->fetchAll(
            "SELECT u.*, 
                CASE 
                    WHEN u.role = 'mahasiswa' THEN m.nim 
                    WHEN u.role = 'orangtua' THEN o.no_telepon 
                    ELSE NULL 
                END as extra_info 
             FROM users u 
             LEFT JOIN mahasiswa m ON u.id = m.user_id 
             LEFT JOIN orangtua o ON u.id = o.user_id"
        );
    }
}
```

---

### 📁 `app/Services/` - Logika Bisnis

#### `ExchangeRateService.php` - Konversi Mata Uang

```php
class ExchangeRateService
{
    private int $cacheTtl;  // Time To Live untuk cache

    public function __construct()
    {
        $this->cacheTtl = (int) ($_ENV['EXCHANGE_RATE_CACHE_TTL'] ?? 3600);
    }

    public function getRate(string $from, string $to = 'IDR'): float
    {
        if ($from === $to) return 1.0;

        // Coba ambil dari cache dulu
        $cached = $this->getCachedRate($from, $to);
        if ($cached !== null) return $cached;

        // Kalau tidak ada di cache, ambil dari API
        $rate = $this->fetchRateFromApi($from, $to);
        if ($rate > 0) $this->cacheRate($from, $to, $rate);

        return $rate;
    }

    private function getCachedRate(string $from, string $to): ?float
    {
        $result = $this->db->fetch(
            "SELECT rate FROM exchange_rate_log 
             WHERE base_currency = :from 
               AND target_currency = :to 
               AND expires_at > NOW() 
             ORDER BY fetched_at DESC LIMIT 1",
            ['from' => $from, 'to' => $to]
        );
        return $result ? (float) $result['rate'] : null;
    }

    private function cacheRate(string $from, string $to, float $rate): void
    {
        $expiresAt = date('Y-m-d H:i:s', time() + $this->cacheTtl);
        $this->db->insert(
            "INSERT INTO exchange_rate_log (...) VALUES (...)",
            ['from' => $from, 'to' => $to, 'rate' => $rate, 'expires_at' => $expiresAt]
        );
    }
}
```

### ⏱️ Apa itu TTL Cache?

**TTL (Time To Live)** adalah waktu hidup sebuah data cache sebelum dianggap kadaluarsa.

```
┌─────────────────────────────────────────────────────────────────┐
│                         TTL CACHE FLOW                          │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  Request Kurs USD → IDR                                         │
│           │                                                     │
│           ▼                                                     │
│  ┌────────────────────────┐                                    │
│  │ Cek di Database Cache  │                                    │
│  │ expires_at > NOW()     │                                    │
│  └────────────────────────┘                                    │
│           │                                                     │
│     ┌─────┴─────┐                                              │
│     │           │                                               │
│   ADA &      TIDAK ADA /                                        │
│   VALID      KADALUARSA                                         │
│     │           │                                               │
│     ▼           ▼                                               │
│  Return      Call API                                           │
│  Cache         │                                                │
│                ▼                                                │
│         Simpan ke DB                                            │
│         dengan expires_at                                       │
│         = NOW + TTL                                             │
│                │                                                │
│                ▼                                                │
│           Return Rate                                           │
│                                                                 │
│  ════════════════════════════════════════════════════════════  │
│                                                                 │
│  TTL = 3600 detik (1 jam)                                      │
│                                                                 │
│  TIMELINE:                                                      │
│  ──────────────────────────────────────────────────────────    │
│  12:00    Cache dibuat, expires_at = 13:00                     │
│  12:30    Request → Cache VALID → Return cache                 │
│  12:59    Request → Cache VALID → Return cache                 │
│  13:01    Request → Cache KADALUARSA → Call API                │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

**Mengapa Menggunakan Cache?**
1. **Menghemat quota API** - API exchange rate biasanya berbayar per request
2. **Lebih cepat** - Baca dari database lokal lebih cepat dari HTTP request
3. **Reliability** - Jika API down, masih bisa pakai data lama

---

#### `AnalyticsService.php` - Analisis Keuangan

```php
class AnalyticsService
{
    public function getSpendingStatus(): array
    {
        $summary = $this->getMonthlySummary(date('Y-m'));
        $ratio = ($summary['pengeluaran'] / $summary['pemasukan']) * 100;

        // Kategori status keuangan
        if ($ratio <= 50) {
            $status = 'hemat';
            $color = 'green';
            $message = 'Keuangan Anda sangat sehat!';
        } elseif ($ratio <= 80) {
            $status = 'normal';
            $color = 'yellow';
        } else {
            $status = 'boros';
            $color = 'red';
        }

        return [...];
    }

    // Data untuk Chart.js
    public function getMonthlyChartData(int $months = 6): array
    {
        for ($i = $months - 1; $i >= 0; $i--) {
            $labels[] = date('M Y', strtotime("-$i months"));
            $summary = $this->getMonthlySummary(date('Y-m', strtotime("-$i months")));
            $pemasukan[] = $summary['pemasukan'];
            $pengeluaran[] = $summary['pengeluaran'];
        }
        return ['labels' => $labels, 'pemasukan' => $pemasukan, 'pengeluaran' => $pengeluaran];
    }
}
```

---

#### `AuthService.php` - Autentikasi

```php
class AuthService
{
    public function login(string $email, string $password): array
    {
        $user = $this->userModel->findByEmail($email);

        if (!$user) {
            return ['success' => false, 'message' => 'Email tidak terdaftar'];
        }
        if (!$user->verifyPassword($password)) {
            return ['success' => false, 'message' => 'Password salah'];
        }

        // Tambahkan data role-specific
        if ($user->getRole() === 'mahasiswa') {
            $mahasiswa = $this->mahasiswaModel->findByUserId($user->getId());
            $userData['mahasiswa_id'] = $mahasiswa->getMahasiswaId();
            $userData['saldo'] = $mahasiswa->getSaldo();
        }

        $this->setSession($userData);
        return ['success' => true, 'user' => $userData];
    }

    private function setSession(array $userData): void
    {
        $_SESSION['user'] = $userData;
        $_SESSION['login_time'] = time();
        session_regenerate_id(true);  // Regenerate session ID untuk keamanan
    }

    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
    }
}
```

**Apa itu `session_regenerate_id(true)`?**
> Membuat session ID baru setelah login untuk mencegah **Session Fixation Attack** - serangan di mana penyerang mencoba menggunakan session ID yang sudah diketahui.

---

#### `NotificationService.php` - Pengiriman Email

```php
use PHPMailer\PHPMailer\PHPMailer;

class NotificationService
{
    private ?PHPMailer $mailer = null;

    private function initMailer(): void
    {
        $this->mailer = new PHPMailer(true);
        $this->mailer->isSMTP();  // Gunakan SMTP
        $this->mailer->Host = $_ENV['MAIL_HOST'];
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $_ENV['MAIL_USERNAME'];
        $this->mailer->Password = $_ENV['MAIL_PASSWORD'];
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = 587;
    }

    public function sendTransferNotification(...): bool
    {
        // Simpan ke database dulu
        $notifId = $this->createNotification($userId, $tipe, $subject, $body);

        // Kirim email
        try {
            $this->mailer->addAddress($email);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;
            $this->mailer->send();
            $this->updateNotificationStatus($notifId, 'sent');
            return true;
        } catch (Exception $e) {
            $this->updateNotificationStatus($notifId, 'failed');
            return false;
        }
    }
}
```

---

#### `ApiClient.php` - HTTP Client

```php
class ApiClient
{
    private function request(string $method, string $url, array $data = []): array
    {
        $ch = curl_init();  // Inisialisasi cURL

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,  // Return response sebagai string
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER => true,  // Verifikasi SSL
            CURLOPT_FOLLOWLOCATION => true   // Ikuti redirect
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return [
            'success' => $httpCode >= 200 && $httpCode < 300,
            'data' => json_decode($response, true)
        ];
    }
}
```

---

### 📁 `app/Controllers/` - Controller

Controller menerima request dan mengarahkan ke Model/View yang sesuai.

#### `AuthController.php`

```php
class AuthController
{
    private AuthService $authService;

    public function login(): void
    {
        // 1. Cek method POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('index.php?page=login');
        }

        // 2. Verifikasi CSRF
        if (!verify_csrf()) {
            flash('error', 'Token tidak valid');
            redirect('index.php?page=login');
        }

        // 3. Ambil dan validasi input
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            flash('error', 'Email dan password wajib diisi');
            set_old_input($_POST);  // Simpan input lama
            redirect('index.php?page=login');
        }

        // 4. Proses login
        $result = $this->authService->login($email, $password);

        if ($result['success']) {
            clear_old_input();
            flash('success', 'Selamat datang!');
            redirect('index.php?page=dashboard');
        } else {
            flash('error', $result['message']);
            set_old_input($_POST);
            redirect('index.php?page=login');
        }
    }
}
```

---

#### `DashboardController.php`

```php
class DashboardController
{
    public function index(): void
    {
        if (!is_logged_in()) {
            redirect('index.php?page=login');
        }

        $user = auth();
        $role = $user['role'];

        // Arahkan ke dashboard sesuai role
        if ($role === 'mahasiswa') {
            $this->mahasiswaDashboard();
        } elseif ($role === 'orangtua') {
            $this->orangtuaDashboard();
        } else {
            $this->adminDashboard();
        }
    }

    private function mahasiswaDashboard(): void
    {
        // Ambil data dari berbagai model
        $mahasiswa = (new Mahasiswa())->findMahasiswa($mahasiswaId);
        $analytics = new AnalyticsService($mahasiswaId);
        $stats = $analytics->getDashboardStats();
        $spendingStatus = $analytics->getSpendingStatus();

        // Kirim ke view
        view('dashboard.mahasiswa', [
            'user' => $user,
            'mahasiswa' => $mhs,
            'stats' => $stats,
            'spendingStatus' => $spendingStatus
        ]);
    }
}
```

---

#### `TransaksiController.php`

```php
class TransaksiController
{
    public function store(): void
    {
        $this->checkAuth();

        // 1. Validasi CSRF dan method
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf()) {
            redirect('index.php?page=transaksi');
        }

        // 2. Ambil dan validasi input
        $kategoriId = (int) ($_POST['kategori_id'] ?? 0);
        $jumlah = (float) ($_POST['jumlah'] ?? 0);
        $mataUang = strtoupper(trim($_POST['mata_uang'] ?? 'IDR'));

        // 3. Verifikasi kepemilikan kategori
        $kat = (new Kategori())->findByIdAndMahasiswa($kategoriId, $mahasiswaId);
        if (!$kat) {
            flash('error', 'Kategori tidak valid');
            redirect('...');
        }

        // 4. Konversi mata uang
        $exchangeService = new ExchangeRateService();
        $conversion = $exchangeService->convertToIdr($jumlah, $mataUang);

        // 5. Buat transaksi dengan method chaining
        try {
            $transaksi = new Transaksi();
            $transaksi->setMahasiswaId($mahasiswaId)
                ->setKategoriId($kategoriId)
                ->setJumlah($jumlah)
                ->setMataUang($mataUang)
                ->setJumlahIdr($conversion['converted_amount'])
                ->setKursRate($conversion['rate'])
                ->setTanggal($tanggal);
            $transaksi->create();

            flash('success', 'Transaksi berhasil ditambahkan');
        } catch (\Exception $e) {
            flash('error', $e->getMessage());
        }
    }

    private function checkAuth(): void
    {
        if (!is_logged_in() || !is_role('mahasiswa')) {
            redirect('index.php?page=login');
        }
    }
}
```

---

### 📁 `views/` - Tampilan

#### `layouts/app.php` - Layout Utama

```html
<!DOCTYPE html>
<html lang="id">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <!-- Navbar dengan PHP logic -->
    <?php if (is_logged_in()): ?>
        <!-- Menu untuk user yang login -->
        <?php if (is_role('mahasiswa')): ?>
            <a href="index.php?page=transaksi">Transaksi</a>
        <?php elseif (is_role('orangtua')): ?>
            <a href="index.php?page=transfer">Transfer</a>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Flash messages -->
    <?php if (has_flash('success')): ?>
        <div class="bg-green-50">
            <?= get_flash('success') ?>
        </div>
    <?php endif; ?>

    <!-- Content dari view child -->
    <main>
        <?= $content ?? '' ?>
    </main>
</body>
</html>
```

**Short Echo Tag:**
- `<?= ... ?>` sama dengan `<?php echo ... ?>`

---

### 📁 `public/` - File Publik

#### `index.php` - Entry Point

```php
<?php
// 1. Konfigurasi error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 2. Mulai session
session_start();

// 3. Set base path
define('BASE_PATH', dirname(__DIR__));

// 4. Autoload Composer
require BASE_PATH . '/vendor/autoload.php';

// 5. Load .env file
$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->safeLoad();

// 6. Routing
$page = $_GET['page'] ?? 'login';
$action = $_GET['action'] ?? 'index';

// ... routing logic ...
```

---

### 📁 File Konfigurasi

#### `.env.example`

```env
# Database Configuration
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=keuangan_mahasiswa
DB_USERNAME=root
DB_PASSWORD=

# Application
APP_NAME="Web Keuangan Mahasiswa"
APP_URL=http://localhost/Kelompok-15/public
APP_DEBUG=true

# Exchange Rate API
EXCHANGE_RATE_API_KEY=your_api_key_here
EXCHANGE_RATE_API_URL=https://v6.exchangerate-api.com/v6

# SMTP Mail
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password

# Cache TTL (in seconds)
EXCHANGE_RATE_CACHE_TTL=3600
```

#### `database.sql`

Skema database dengan tabel:
1. `users` - Data user (semua role)
2. `mahasiswa` - Data mahasiswa (extends users)
3. `orangtua` - Data orang tua (extends users)
4. `relasi_orangtua_mahasiswa` - Junction table untuk relasi many-to-many
5. `kategori` - Kategori transaksi
6. `transaksi` - Transaksi keuangan
7. `transfer_saldo` - Transfer dari orang tua ke mahasiswa
8. `exchange_rate_log` - Cache kurs mata uang
9. `notifications` - Notifikasi email
10. `reminders` - Pengingat pembayaran

---

## 🔑 Konsep Penting untuk Pemula

### 1. Namespace

```php
namespace App\Models;  // Deklarasi namespace

use App\Core\Database;  // Import dari namespace lain

class User { ... }
```

**Analogi:** Namespace seperti folder virtual. `App\Models\User` seperti file `App/Models/User.php`

### 2. Type Declaration

```php
function setNama(string $nama): self  // Parameter dan return type
private ?int $id = null;              // Nullable type
public function find(): ?User         // Nullable return
```

### 3. Null Coalescing Operator

```php
$value = $_POST['key'] ?? 'default';
// Sama dengan:
$value = isset($_POST['key']) ? $_POST['key'] : 'default';
```

### 4. Arrow Functions

```php
$names = array_map(fn($user) => $user->getName(), $users);
```

### 5. Prepared Statements

```php
// SALAH (rentan SQL Injection):
$sql = "SELECT * FROM users WHERE id = " . $_GET['id'];

// BENAR (aman):
$sql = "SELECT * FROM users WHERE id = :id";
$stmt->execute(['id' => $_GET['id']]);
```

---

## 📊 Diagram Alur Request

```
┌─────────────────────────────────────────────────────────────────┐
│                    ALUR REQUEST LOGIN                           │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  User klik "Login"                                              │
│       │                                                         │
│       ▼                                                         │
│  GET index.php?page=login                                       │
│       │                                                         │
│       ▼                                                         │
│  ┌────────────────────────────────────────┐                    │
│  │ public/index.php                        │                    │
│  │ - Parse URL                             │                    │
│  │ - Route ke AuthController::showLogin()  │                    │
│  └────────────────────────────────────────┘                    │
│       │                                                         │
│       ▼                                                         │
│  ┌────────────────────────────────────────┐                    │
│  │ AuthController::showLogin()             │                    │
│  │ - view('auth.login')                    │                    │
│  └────────────────────────────────────────┘                    │
│       │                                                         │
│       ▼                                                         │
│  ┌────────────────────────────────────────┐                    │
│  │ views/auth/login.php + layouts/auth.php │                    │
│  │ - Render form dengan csrf_field()       │                    │
│  └────────────────────────────────────────┘                    │
│       │                                                         │
│       ▼                                                         │
│  HTML Response ke Browser                                       │
│                                                                 │
│  ════════════════════════════════════════════════════════════  │
│                                                                 │
│  User isi form & submit                                         │
│       │                                                         │
│       ▼                                                         │
│  POST index.php?page=login&action=submit                        │
│       │         (dengan csrf_token)                             │
│       ▼                                                         │
│  ┌────────────────────────────────────────┐                    │
│  │ AuthController::login()                 │                    │
│  │ 1. verify_csrf()                        │                    │
│  │ 2. Validasi input                       │                    │
│  │ 3. AuthService::login()                 │                    │
│  └────────────────────────────────────────┘                    │
│       │                                                         │
│       ▼                                                         │
│  ┌────────────────────────────────────────┐                    │
│  │ AuthService::login()                    │                    │
│  │ 1. User::findByEmail()                  │                    │
│  │ 2. verifyPassword()                     │                    │
│  │ 3. Load role-specific data              │                    │
│  │ 4. setSession()                         │                    │
│  └────────────────────────────────────────┘                    │
│       │                                                         │
│       ▼                                                         │
│  ┌─────────┬─────────┐                                         │
│  │ SUCCESS │ FAILED  │                                         │
│  └────┬────┴────┬────┘                                         │
│       │         │                                               │
│       ▼         ▼                                               │
│  redirect    redirect                                           │
│  dashboard   login + error                                      │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

---

## ✅ Ringkasan

| Folder/File | Fungsi |
|-------------|--------|
| `public/index.php` | Entry point, routing |
| `app/Core/Database.php` | Koneksi database (Singleton) |
| `app/Helpers/helpers.php` | Fungsi global (CSRF, redirect, format) |
| `app/Models/` | Representasi tabel database |
| `app/Services/` | Logika bisnis kompleks |
| `app/Controllers/` | Penghubung request-model-view |
| `views/` | Tampilan HTML + PHP |
| `.env` | Konfigurasi sensitif |
| `database.sql` | Skema database |

---

## 👥 Kelompok 15

Sistem Keuangan Mahasiswa dengan Kurs Otomatis dan Monitoring Orang Tua
