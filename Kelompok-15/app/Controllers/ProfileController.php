<?php

namespace App\Controllers;

use App\Models\User;
use App\Core\Database;
use App\Services\AuthService;

class ProfileController
{
    public function index(): void
    {
        if (!is_logged_in()) {
            redirect('index.php?page=login');
        }
        view('dashboard.profile');
    }

    public function updatePassword(): void
    {
        if (!is_logged_in()) {
            redirect('index.php?page=login');
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf()) {
            redirect('index.php?page=profile');
        }

        $oldPassword = $_POST['old_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if (strlen($newPassword) < 6) {
            flash('error', 'Password baru minimal 6 karakter');
            redirect('index.php?page=profile');
        }

        if ($newPassword !== $confirmPassword) {
            flash('error', 'Konfirmasi password tidak cocok');
            redirect('index.php?page=profile');
        }

        $user = new User();
        $userData = $user->find(auth()['id']);

        if (!$userData || !$userData->verifyPassword($oldPassword)) {
            flash('error', 'Password lama salah');
            redirect('index.php?page=profile');
        }

        $userData->updatePassword($newPassword);
        flash('success', 'Password berhasil diubah');
        redirect('index.php?page=profile');
    }

    public function updatePhoto(): void
    {
        if (!is_logged_in()) {
            redirect('index.php?page=login');
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf()) {
            redirect('index.php?page=profile');
        }

        if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
            flash('error', 'Gagal mengupload foto');
            redirect('index.php?page=profile');
        }

        $file = $_FILES['photo'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 2 * 1024 * 1024; // 2MB

        // Validate file type
        if (!in_array($file['type'], $allowedTypes)) {
            flash('error', 'Format foto tidak valid. Gunakan JPG, PNG, GIF, atau WebP');
            redirect('index.php?page=profile');
        }

        // Validate file size
        if ($file['size'] > $maxSize) {
            flash('error', 'Ukuran foto maksimal 2MB');
            redirect('index.php?page=profile');
        }

        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'photo_' . auth()['id'] . '_' . time() . '.' . $extension;
        $uploadDir = __DIR__ . '/../../public/uploads/photos/';
        $uploadPath = $uploadDir . $filename;

        // Create directory if not exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Delete old photo if exists
        $userId = auth()['id'];
        $db = Database::getInstance();
        $oldPhoto = $db->fetch("SELECT photo FROM users WHERE id = ?", [$userId]);
        if ($oldPhoto && $oldPhoto['photo']) {
            $oldPath = $uploadDir . $oldPhoto['photo'];
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            // Update database
            $db->update("UPDATE users SET photo = ? WHERE id = ?", [$filename, $userId]);

            // Update session
            $_SESSION['user']['photo'] = $filename;

            flash('success', 'Foto profil berhasil diubah');
        } else {
            flash('error', 'Gagal menyimpan foto');
        }

        redirect('index.php?page=profile');
    }

    public function deletePhoto(): void
    {
        if (!is_logged_in()) {
            redirect('index.php?page=login');
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf()) {
            redirect('index.php?page=profile');
        }

        $userId = auth()['id'];
        $db = Database::getInstance();

        // Get old photo
        $oldPhoto = $db->fetch("SELECT photo FROM users WHERE id = ?", [$userId]);
        if ($oldPhoto && $oldPhoto['photo']) {
            $uploadDir = __DIR__ . '/../../public/uploads/photos/';
            $oldPath = $uploadDir . $oldPhoto['photo'];
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        // Update database
        $db->update("UPDATE users SET photo = NULL WHERE id = ?", [$userId]);

        // Update session
        $_SESSION['user']['photo'] = null;

        flash('success', 'Foto profil berhasil dihapus');
        redirect('index.php?page=profile');
    }
}
