-- Migration: Admin Features
-- Run this script to add admin features to existing database

-- Add is_active column to users if not exists
ALTER TABLE `users` 
ADD COLUMN IF NOT EXISTS `is_active` TINYINT(1) DEFAULT 1 AFTER `role`;

-- Create system_settings table if not exists
CREATE TABLE IF NOT EXISTS `system_settings` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `setting_key` VARCHAR(50) UNIQUE NOT NULL,
    `setting_value` TEXT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Insert default settings
INSERT INTO `system_settings` (`setting_key`, `setting_value`) VALUES
    ('threshold_hemat', '50'),
    ('threshold_normal', '80'),
    ('kurs_ttl', '3600')
ON DUPLICATE KEY UPDATE `setting_key` = `setting_key`;
