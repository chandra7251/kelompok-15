# Diagram Arsitektur - Sistem Keuangan Mahasiswa

## Arsitektur Sistem

```
┌───────────────────────────────────────────────────────────────────┐
│                         CLIENT (Browser)                          │
│   HTML + TailwindCSS + Chart.js                                   │
└───────────────────────────────┬───────────────────────────────────┘
                                │
                                ▼
┌───────────────────────────────────────────────────────────────────┐
│                     public/index.php (Router)                      │
│   - Parse ?page=xxx&action=xxx                                     │
│   - Load Controller                                                │
│   - Execute Method                                                 │
└───────────────────────────────┬───────────────────────────────────┘
                                │
        ┌───────────────────────┼───────────────────────┐
        ▼                       ▼                       ▼
┌───────────────┐     ┌───────────────┐     ┌───────────────┐
│  Controllers  │     │   Services    │     │    Models     │
├───────────────┤     ├───────────────┤     ├───────────────┤
│ Auth          │     │ AuthService   │     │ User          │
│ Dashboard     │     │ ExchangeRate  │     │ Mahasiswa     │
│ Transaksi     │     │ Analytics     │     │ OrangTua      │
│ Kategori      │     │ Notification  │     │ Kategori      │
│ Transfer      │     │ ApiClient     │     │ Transaksi     │
│ Analytics     │◄───►│               │◄───►│ TransferSaldo │
│ Grafik        │     │               │     │               │
│ Profile       │     │               │     │               │
│ Reminder      │     │               │     │               │
│ Export        │     │               │     │               │
└───────────────┘     └───────────────┘     └───────────────┘
                                │                   │
                                ▼                   ▼
                    ┌───────────────────────────────────────┐
                    │        app/Core/Database.php          │
                    │        (Singleton PDO Connection)     │
                    └───────────────────┬───────────────────┘
                                        │
                                        ▼
                    ┌───────────────────────────────────────┐
                    │              MySQL Database           │
                    │         (keuangan_mahasiswa)          │
                    └───────────────────────────────────────┘

┌───────────────────────────────────────────────────────────────────┐
│                      External Services                             │
├───────────────────────────────────────────────────────────────────┤
│  ┌─────────────────┐         ┌─────────────────┐                  │
│  │ Exchange Rate   │         │   Gmail SMTP    │                  │
│  │ API             │         │   (PHPMailer)   │                  │
│  │                 │         │                 │                  │
│  │ USD → IDR       │         │ Notifikasi      │                  │
│  │ EUR → IDR       │         │ Transfer        │                  │
│  │ dll             │         │ Reminder        │                  │
│  └─────────────────┘         └─────────────────┘                  │
└───────────────────────────────────────────────────────────────────┘
```

## Flow Request

```
Browser → index.php → Controller → Service/Model → Database
                                        ↓
                                   View (HTML)
                                        ↓
                                    Browser
```

## Struktur Folder

```
project/
├── public/             # Entry point
│   └── index.php       # Router
├── app/
│   ├── Controllers/    # 10 Controllers
│   ├── Models/         # 7 Models
│   ├── Services/       # 5 Services
│   ├── Core/           # Database class
│   └── Helpers/        # Helper functions
├── views/
│   ├── layouts/        # Layout templates
│   ├── auth/           # Login, Register
│   ├── dashboard/      # Dashboard pages
│   ├── transaksi/      # CRUD Transaksi
│   ├── kategori/       # CRUD Kategori
│   └── transfer/       # Transfer page
├── docs/               # Documentation
├── vendor/             # Composer packages
├── database.sql        # Schema + Seed
└── .env                # Configuration
```
