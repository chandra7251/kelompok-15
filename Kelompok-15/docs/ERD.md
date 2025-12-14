# Entity Relationship Diagram (ERD)
## Sistem Keuangan Mahasiswa

---

## Tabel dan Atribut

### 1. users
| Atribut | Tipe Data | Constraint | Keterangan |
|---------|-----------|------------|------------|
| id | INT | PK, AUTO_INCREMENT | Primary Key |
| nama | VARCHAR(100) | NOT NULL | Nama lengkap |
| email | VARCHAR(100) | UNIQUE, NOT NULL | Email login |
| password | VARCHAR(255) | NOT NULL | Hash password |
| role | ENUM | NOT NULL | 'mahasiswa', 'orangtua', 'admin' |
| reset_token | VARCHAR(64) | NULL | Token reset password |
| reset_expires | TIMESTAMP | NULL | Waktu expired token |
| created_at | TIMESTAMP | DEFAULT NOW | Waktu dibuat |
| updated_at | TIMESTAMP | ON UPDATE | Waktu update |

---

### 2. mahasiswa
| Atribut | Tipe Data | Constraint | Keterangan |
|---------|-----------|------------|------------|
| id | INT | PK, AUTO_INCREMENT | Primary Key |
| user_id | INT | FK → users.id | Foreign Key |
| nim | VARCHAR(20) | UNIQUE, NOT NULL | Nomor Induk Mahasiswa |
| jurusan | VARCHAR(100) | NULL | Nama jurusan |
| saldo | DECIMAL(15,2) | DEFAULT 0 | Saldo saat ini |
| pairing_code | VARCHAR(10) | UNIQUE | Kode pairing orang tua |
| created_at | TIMESTAMP | DEFAULT NOW | Waktu dibuat |
| updated_at | TIMESTAMP | ON UPDATE | Waktu update |

---

### 3. orangtua
| Atribut | Tipe Data | Constraint | Keterangan |
|---------|-----------|------------|------------|
| id | INT | PK, AUTO_INCREMENT | Primary Key |
| user_id | INT | FK → users.id | Foreign Key |
| no_telepon | VARCHAR(20) | NULL | Nomor telepon |
| created_at | TIMESTAMP | DEFAULT NOW | Waktu dibuat |
| updated_at | TIMESTAMP | ON UPDATE | Waktu update |

---

### 4. relasi_orangtua_mahasiswa
| Atribut | Tipe Data | Constraint | Keterangan |
|---------|-----------|------------|------------|
| id | INT | PK, AUTO_INCREMENT | Primary Key |
| orangtua_id | INT | FK → orangtua.id | Foreign Key |
| mahasiswa_id | INT | FK → mahasiswa.id | Foreign Key |
| created_at | TIMESTAMP | DEFAULT NOW | Waktu dibuat |

---

### 5. kategori
| Atribut | Tipe Data | Constraint | Keterangan |
|---------|-----------|------------|------------|
| id | INT | PK, AUTO_INCREMENT | Primary Key |
| mahasiswa_id | INT | FK → mahasiswa.id | Foreign Key |
| nama | VARCHAR(50) | NOT NULL | Nama kategori |
| tipe | ENUM | NOT NULL | 'pemasukan', 'pengeluaran' |
| created_at | TIMESTAMP | DEFAULT NOW | Waktu dibuat |
| updated_at | TIMESTAMP | ON UPDATE | Waktu update |

---

### 6. transaksi
| Atribut | Tipe Data | Constraint | Keterangan |
|---------|-----------|------------|------------|
| id | INT | PK, AUTO_INCREMENT | Primary Key |
| mahasiswa_id | INT | FK → mahasiswa.id | Foreign Key |
| kategori_id | INT | FK → kategori.id | Foreign Key |
| jumlah | DECIMAL(15,2) | NOT NULL | Jumlah asli |
| mata_uang | VARCHAR(3) | DEFAULT 'IDR' | Kode mata uang |
| jumlah_idr | DECIMAL(15,2) | NOT NULL | Jumlah dalam IDR |
| kurs_rate | DECIMAL(15,6) | DEFAULT 1 | Nilai kurs |
| keterangan | TEXT | NULL | Catatan |
| tanggal | DATE | NOT NULL | Tanggal transaksi |
| created_at | TIMESTAMP | DEFAULT NOW | Waktu dibuat |
| updated_at | TIMESTAMP | ON UPDATE | Waktu update |

---

### 7. transfer_saldo
| Atribut | Tipe Data | Constraint | Keterangan |
|---------|-----------|------------|------------|
| id | INT | PK, AUTO_INCREMENT | Primary Key |
| orangtua_id | INT | FK → orangtua.id | Foreign Key |
| mahasiswa_id | INT | FK → mahasiswa.id | Foreign Key |
| jumlah | DECIMAL(15,2) | NOT NULL | Jumlah asli |
| mata_uang | VARCHAR(3) | DEFAULT 'IDR' | Kode mata uang |
| jumlah_idr | DECIMAL(15,2) | NOT NULL | Jumlah dalam IDR |
| kurs_rate | DECIMAL(15,6) | DEFAULT 1 | Nilai kurs |
| keterangan | TEXT | NULL | Catatan |
| status | ENUM | DEFAULT 'completed' | 'pending', 'completed', 'failed' |
| created_at | TIMESTAMP | DEFAULT NOW | Waktu dibuat |

---

### 8. reminders
| Atribut | Tipe Data | Constraint | Keterangan |
|---------|-----------|------------|------------|
| id | INT | PK, AUTO_INCREMENT | Primary Key |
| mahasiswa_id | INT | FK → mahasiswa.id | Foreign Key |
| nama | VARCHAR(100) | NOT NULL | Nama tagihan |
| jumlah | DECIMAL(15,2) | NOT NULL | Jumlah tagihan |
| tanggal_jatuh_tempo | DATE | NOT NULL | Tanggal jatuh tempo |
| status | ENUM | DEFAULT 'pending' | 'pending', 'paid' |
| created_at | TIMESTAMP | DEFAULT NOW | Waktu dibuat |

---

### 9. notifications
| Atribut | Tipe Data | Constraint | Keterangan |
|---------|-----------|------------|------------|
| id | INT | PK, AUTO_INCREMENT | Primary Key |
| user_id | INT | FK → users.id | Foreign Key |
| tipe | VARCHAR(50) | NOT NULL | Jenis notifikasi |
| judul | VARCHAR(100) | NOT NULL | Judul notifikasi |
| pesan | TEXT | NOT NULL | Isi pesan |
| status | ENUM | DEFAULT 'pending' | 'pending', 'sent', 'failed' |
| sent_at | TIMESTAMP | NULL | Waktu terkirim |
| created_at | TIMESTAMP | DEFAULT NOW | Waktu dibuat |

---

### 10. exchange_rate_log
| Atribut | Tipe Data | Constraint | Keterangan |
|---------|-----------|------------|------------|
| id | INT | PK, AUTO_INCREMENT | Primary Key |
| base_currency | VARCHAR(3) | NOT NULL | Mata uang asal |
| target_currency | VARCHAR(3) | NOT NULL | Mata uang tujuan |
| rate | DECIMAL(15,6) | NOT NULL | Nilai kurs |
| fetched_at | TIMESTAMP | DEFAULT NOW | Waktu fetch |
| expires_at | TIMESTAMP | NOT NULL | Waktu expired |

---

## Relasi Antar Tabel

| No | Tabel 1 | Relasi | Tabel 2 | Keterangan |
|----|---------|--------|---------|------------|
| 1 | users | 1:1 | mahasiswa | Satu user bisa jadi satu mahasiswa |
| 2 | users | 1:1 | orangtua | Satu user bisa jadi satu orangtua |
| 3 | users | 1:N | notifications | Satu user bisa punya banyak notifikasi |
| 4 | mahasiswa | 1:N | kategori | Satu mahasiswa bisa punya banyak kategori |
| 5 | mahasiswa | 1:N | transaksi | Satu mahasiswa bisa punya banyak transaksi |
| 6 | mahasiswa | 1:N | reminders | Satu mahasiswa bisa punya banyak reminder |
| 7 | kategori | 1:N | transaksi | Satu kategori bisa dipakai banyak transaksi |
| 8 | orangtua | 1:N | mahasiswa | Satu orangtua bisa memantau banyak mahasiswa (via relasi_orangtua_mahasiswa) |
| 9 | orangtua | 1:N | transfer_saldo | Satu orangtua bisa kirim banyak transfer |
| 10 | mahasiswa | 1:N | transfer_saldo | Satu mahasiswa bisa terima banyak transfer |

---

## Diagram ERD

```
┌──────────────┐         ┌──────────────┐         ┌──────────────┐
│    users     │         │  mahasiswa   │         │   orangtua   │
├──────────────┤         ├──────────────┤         ├──────────────┤
│ PK id        │◄──┬────►│ PK id        │◄───┐    │ PK id        │
│ nama         │   │     │ FK user_id   │    │    │ FK user_id   │◄──┐
│ email        │   │     │ nim          │    │    │ no_telepon   │   │
│ password     │   │     │ jurusan      │    │    └──────────────┘   │
│ role         │   │     │ saldo        │    │           │            │
└──────────────┘   │     │ pairing_code │    │           │            │
       │           │     └──────────────┘    │           ▼            │
       │           │            │            │    ┌──────────────┐    │
       │           └────────────┼────────────┼───►│   relasi_    │◄───┘
       │                        │            │    │   orangtua_  │
       │                        │            │    │   mahasiswa  │
       │                        │            │    └──────────────┘
       │                        │            │
       ▼                        ▼            │
┌──────────────┐         ┌──────────────┐    │
│notifications │         │   kategori   │    │
├──────────────┤         ├──────────────┤    │
│ PK id        │         │ PK id        │    │
│ FK user_id   │         │ FK mahasiswa │    │
│ tipe         │         │ nama         │    │
│ judul        │         │ tipe         │    │
│ pesan        │         └──────────────┘    │
└──────────────┘                │            │
                                ▼            │
                         ┌──────────────┐    │    ┌──────────────┐
                         │  transaksi   │    │    │transfer_saldo│
                         ├──────────────┤    │    ├──────────────┤
                         │ PK id        │    └───►│ PK id        │
                         │ FK mahasiswa │         │ FK orangtua  │
                         │ FK kategori  │         │ FK mahasiswa │
                         │ jumlah       │         │ jumlah       │
                         │ mata_uang    │         │ mata_uang    │
                         │ jumlah_idr   │         │ jumlah_idr   │
                         │ kurs_rate    │         │ status       │
                         │ tanggal      │         └──────────────┘
                         └──────────────┘
                         
                         ┌──────────────┐    ┌──────────────┐
                         │  reminders   │    │exchange_rate │
                         ├──────────────┤    ├──────────────┤
                         │ PK id        │    │ PK id        │
                         │ FK mahasiswa │    │ base_currency│
                         │ nama         │    │ target_curr  │
                         │ jumlah       │    │ rate         │
                         │ jatuh_tempo  │    │ fetched_at   │
                         │ status       │    │ expires_at   │
                         └──────────────┘    └──────────────┘
```
