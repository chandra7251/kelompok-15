<?php

namespace App\Controllers;

use App\Models\User;
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
}
