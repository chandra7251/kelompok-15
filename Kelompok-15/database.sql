-- ===========================================
-- Database: Sistem Keuangan Mahasiswa
-- Kelompok 15
-- ===========================================

-- Drop database jika ada (untuk fresh install)
DROP DATABASE IF EXISTS `web_keuangan_mahasiswa_dan_kurs_otomatis`;
CREATE DATABASE `web_keuangan_mahasiswa_dan_kurs_otomatis` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `web_keuangan_mahasiswa_dan_kurs_otomatis`;

-- ===========================================
-- TABEL STRUKTUR
-- ===========================================

-- Table: users
CREATE TABLE `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nama` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) UNIQUE NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('mahasiswa', 'orangtua', 'admin') NOT NULL,
    `reset_token` VARCHAR(64) NULL,
    `reset_expires` TIMESTAMP NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_email` (`email`)
) ENGINE=InnoDB;

-- Table: mahasiswa
CREATE TABLE `mahasiswa` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `nim` VARCHAR(20) UNIQUE NOT NULL,
    `jurusan` VARCHAR(100),
    `saldo` DECIMAL(15,2) DEFAULT 0.00,
    `pairing_code` VARCHAR(10) UNIQUE,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table: orangtua
CREATE TABLE `orangtua` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `no_telepon` VARCHAR(20),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table: relasi_orangtua_mahasiswa
CREATE TABLE `relasi_orangtua_mahasiswa` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `orangtua_id` INT NOT NULL,
    `mahasiswa_id` INT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`orangtua_id`) REFERENCES `orangtua`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa`(`id`) ON DELETE CASCADE,
    UNIQUE KEY `unique_relasi` (`orangtua_id`, `mahasiswa_id`)
) ENGINE=InnoDB;

-- Table: kategori
CREATE TABLE `kategori` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `mahasiswa_id` INT NOT NULL,
    `nama` VARCHAR(50) NOT NULL,
    `tipe` ENUM('pemasukan', 'pengeluaran') NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table: transaksi
CREATE TABLE `transaksi` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `mahasiswa_id` INT NOT NULL,
    `kategori_id` INT NOT NULL,
    `jumlah` DECIMAL(15,2) NOT NULL,
    `mata_uang` VARCHAR(3) DEFAULT 'IDR',
    `jumlah_idr` DECIMAL(15,2) NOT NULL,
    `kurs_rate` DECIMAL(15,6) DEFAULT 1.000000,
    `keterangan` TEXT,
    `tanggal` DATE NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`kategori_id`) REFERENCES `kategori`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table: transfer_saldo
CREATE TABLE `transfer_saldo` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `orangtua_id` INT NOT NULL,
    `mahasiswa_id` INT NOT NULL,
    `jumlah` DECIMAL(15,2) NOT NULL,
    `mata_uang` VARCHAR(3) DEFAULT 'IDR',
    `jumlah_idr` DECIMAL(15,2) NOT NULL,
    `kurs_rate` DECIMAL(15,6) DEFAULT 1.000000,
    `keterangan` TEXT,
    `status` ENUM('pending', 'completed', 'failed') DEFAULT 'completed',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`orangtua_id`) REFERENCES `orangtua`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table: exchange_rate_log
CREATE TABLE `exchange_rate_log` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `base_currency` VARCHAR(3) NOT NULL,
    `target_currency` VARCHAR(3) NOT NULL,
    `rate` DECIMAL(15,6) NOT NULL,
    `fetched_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `expires_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Table: notifications
CREATE TABLE `notifications` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `tipe` VARCHAR(50) NOT NULL,
    `judul` VARCHAR(100) NOT NULL,
    `pesan` TEXT NOT NULL,
    `status` ENUM('pending', 'sent', 'failed') DEFAULT 'pending',
    `sent_at` TIMESTAMP NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table: reminders
CREATE TABLE `reminders` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `mahasiswa_id` INT NOT NULL,
    `nama` VARCHAR(100) NOT NULL,
    `jumlah` DECIMAL(15,2) NOT NULL,
    `tanggal_jatuh_tempo` DATE NOT NULL,
    `status` ENUM('pending', 'paid') DEFAULT 'pending',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ===========================================
-- SEED DATA
-- ===========================================

-- Password untuk semua akun: admin123
-- Hash: $2y$10$KUPl50iX7fJecrphcXMU./HD80Q061UaBCf9h5X9gJBwwzzh6lBp6

-- Seed: Admin (id=1)
INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`) VALUES
(1, 'Administrator', 'admin@keuangan.com', '$2y$10$KUPl50iX7fJecrphcXMU./HD80Q061UaBCf9h5X9gJBwwzzh6lBp6', 'admin');

-- Seed: Mahasiswa (id=2,3)
INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`) VALUES
(2, 'Ahmad Fauzi', 'ahmad@student.ac.id', '$2y$10$KUPl50iX7fJecrphcXMU./HD80Q061UaBCf9h5X9gJBwwzzh6lBp6', 'mahasiswa'),
(3, 'Budi Santoso', 'budi@student.ac.id', '$2y$10$KUPl50iX7fJecrphcXMU./HD80Q061UaBCf9h5X9gJBwwzzh6lBp6', 'mahasiswa');

INSERT INTO `mahasiswa` (`id`, `user_id`, `nim`, `jurusan`, `saldo`, `pairing_code`) VALUES
(1, 2, '2024001', 'Teknik Informatika', 1500000.00, 'AHMAD123'),
(2, 3, '2024002', 'Sistem Informasi', 750000.00, 'BUDI1234');

-- Seed: Orang Tua (id=4)
INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`) VALUES
(4, 'Pak Hasan', 'hasan@gmail.com', '$2y$10$KUPl50iX7fJecrphcXMU./HD80Q061UaBCf9h5X9gJBwwzzh6lBp6', 'orangtua');

INSERT INTO `orangtua` (`id`, `user_id`, `no_telepon`) VALUES
(1, 4, '081234567890');

-- Relasi: Pak Hasan -> Ahmad
INSERT INTO `relasi_orangtua_mahasiswa` (`orangtua_id`, `mahasiswa_id`) VALUES
(1, 1);

-- Seed: Kategori untuk Ahmad (mahasiswa_id=1)
INSERT INTO `kategori` (`id`, `mahasiswa_id`, `nama`, `tipe`) VALUES
(1, 1, 'Uang Saku', 'pemasukan'),
(2, 1, 'Transfer Ortu', 'pemasukan'),
(3, 1, 'Makan', 'pengeluaran'),
(4, 1, 'Transportasi', 'pengeluaran'),
(5, 1, 'Hiburan', 'pengeluaran'),
(6, 1, 'Pendidikan', 'pengeluaran');

-- Seed: Transaksi untuk Ahmad (12 transaksi)
INSERT INTO `transaksi` (`mahasiswa_id`, `kategori_id`, `jumlah`, `mata_uang`, `jumlah_idr`, `kurs_rate`, `keterangan`, `tanggal`) VALUES
(1, 1, 500000, 'IDR', 500000, 1, 'Uang saku mingguan', DATE_SUB(CURDATE(), INTERVAL 30 DAY)),
(1, 3, 150000, 'IDR', 150000, 1, 'Makan di kantin', DATE_SUB(CURDATE(), INTERVAL 28 DAY)),
(1, 4, 50000, 'IDR', 50000, 1, 'Ongkos ojol', DATE_SUB(CURDATE(), INTERVAL 25 DAY)),
(1, 1, 500000, 'IDR', 500000, 1, 'Uang saku mingguan', DATE_SUB(CURDATE(), INTERVAL 23 DAY)),
(1, 3, 200000, 'IDR', 200000, 1, 'Makan di luar', DATE_SUB(CURDATE(), INTERVAL 20 DAY)),
(1, 5, 100000, 'IDR', 100000, 1, 'Nonton bioskop', DATE_SUB(CURDATE(), INTERVAL 18 DAY)),
(1, 1, 500000, 'IDR', 500000, 1, 'Uang saku mingguan', DATE_SUB(CURDATE(), INTERVAL 16 DAY)),
(1, 6, 250000, 'IDR', 250000, 1, 'Beli buku kuliah', DATE_SUB(CURDATE(), INTERVAL 14 DAY)),
(1, 3, 175000, 'IDR', 175000, 1, 'Makan siang', DATE_SUB(CURDATE(), INTERVAL 10 DAY)),
(1, 1, 500000, 'IDR', 500000, 1, 'Uang saku mingguan', DATE_SUB(CURDATE(), INTERVAL 7 DAY)),
(1, 4, 75000, 'IDR', 75000, 1, 'Bensin motor', DATE_SUB(CURDATE(), INTERVAL 5 DAY)),
(1, 3, 180000, 'IDR', 180000, 1, 'Makan malam', DATE_SUB(CURDATE(), INTERVAL 2 DAY));

-- Seed: Transfer dari Ortu
INSERT INTO `transfer_saldo` (`orangtua_id`, `mahasiswa_id`, `jumlah`, `mata_uang`, `jumlah_idr`, `kurs_rate`, `keterangan`, `status`) VALUES
(1, 1, 1000000, 'IDR', 1000000, 1, 'Uang bulanan', 'completed');

-- Seed: Reminder untuk Ahmad
INSERT INTO `reminders` (`mahasiswa_id`, `nama`, `jumlah`, `tanggal_jatuh_tempo`, `status`) VALUES
(1, 'SPP Semester Genap', 5000000, DATE_ADD(CURDATE(), INTERVAL 14 DAY), 'pending'),
(1, 'Uang Kos Bulan Depan', 1500000, DATE_ADD(CURDATE(), INTERVAL 20 DAY), 'pending');

-- ===========================================
-- DEMO ACCOUNTS
-- ===========================================
-- | Role       | Email               | Password  |
-- |------------|---------------------|-----------|
-- | Admin      | admin@keuangan.com  | admin123  |
-- | Mahasiswa  | ahmad@student.ac.id | admin123  |
-- | Mahasiswa  | budi@student.ac.id  | admin123  |
-- | Orang Tua  | hasan@gmail.com     | admin123  |
-- ===========================================
