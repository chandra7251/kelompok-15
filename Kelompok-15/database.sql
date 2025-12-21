DROP DATABASE IF EXISTS `web_keuangan_mahasiswa_dan_kurs_otomatis`;
CREATE DATABASE `web_keuangan_mahasiswa_dan_kurs_otomatis` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `web_keuangan_mahasiswa_dan_kurs_otomatis`;

CREATE TABLE `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nama` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) UNIQUE NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('mahasiswa', 'orangtua', 'admin') NOT NULL,
    `photo` VARCHAR(255) NULL,
    `is_active` TINYINT(1) DEFAULT 1,
    `reset_token` VARCHAR(64) NULL,
    `reset_expires` TIMESTAMP NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_email` (`email`)
) ENGINE=InnoDB;

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

CREATE TABLE `orangtua` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `no_telepon` VARCHAR(20),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `relasi_orangtua_mahasiswa` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `orangtua_id` INT NOT NULL,
    `mahasiswa_id` INT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`orangtua_id`) REFERENCES `orangtua`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa`(`id`) ON DELETE CASCADE,
    UNIQUE KEY `unique_relasi` (`orangtua_id`, `mahasiswa_id`)
) ENGINE=InnoDB;

CREATE TABLE `kategori` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `mahasiswa_id` INT NOT NULL,
    `nama` VARCHAR(50) NOT NULL,
    `tipe` ENUM('pemasukan', 'pengeluaran') NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

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

CREATE TABLE `exchange_rate_log` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `base_currency` VARCHAR(3) NOT NULL,
    `target_currency` VARCHAR(3) NOT NULL,
    `rate` DECIMAL(15,6) NOT NULL,
    `fetched_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `expires_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

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

CREATE TABLE `system_settings` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `setting_key` VARCHAR(50) UNIQUE NOT NULL,
    `setting_value` TEXT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `deleted_users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `original_user_id` INT NOT NULL,
    `nama` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `role` ENUM('mahasiswa', 'orangtua', 'admin') NOT NULL,
    `photo` VARCHAR(255) NULL,
    `deleted_by` INT NOT NULL,
    `deleted_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `original_created_at` TIMESTAMP NULL,
    INDEX `idx_email` (`email`),
    INDEX `idx_role` (`role`),
    INDEX `idx_deleted_at` (`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
