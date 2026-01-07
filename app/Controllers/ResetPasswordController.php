<?php

namespace App\Controllers;

use App\Models\User;
use App\Core\Database;

class ResetPasswordController
{
    public function index(): void
    {
        if (is_logged_in()) {
            redirect('index.php?page=dashboard');
        }

        $token = $_GET['token'] ?? '';

        if (empty($token)) {
            flash('error', 'Token reset password tidak valid.');
            redirect('index.php?page=login');
        }

        $db = Database::getInstance();

        $result = $db->fetch(
            "SELECT id, nama, email, reset_expires FROM users WHERE reset_token = ?",
            [$token]
        );

        if (!$result) {
            flash('error', 'Token reset password tidak ditemukan.');
            redirect('index.php?page=login');
        }

        if (strtotime($result['reset_expires']) < time()) {
            flash('error', 'Token reset password sudah kadaluarsa. Silakan request ulang.');
            redirect('index.php?page=forgot_password');
        }

        view('auth.reset_password', [
            'token' => $token,
            'email' => $result['email'],
            'nama' => $result['nama']
        ]);
    }

    public function submit(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf()) {
            redirect('index.php?page=login');
        }

        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if (empty($token) || empty($password) || empty($confirmPassword)) {
            flash('error', 'Semua field harus diisi.');
            redirect('index.php?page=reset_password&token=' . $token);
        }

        if ($password !== $confirmPassword) {
            flash('error', 'Konfirmasi password tidak cocok.');
            redirect('index.php?page=reset_password&token=' . $token);
        }

        if (strlen($password) < 6) {
            flash('error', 'Password minimal 6 karakter.');
            redirect('index.php?page=reset_password&token=' . $token);
        }

        $db = Database::getInstance();
        $result = $db->fetch(
            "SELECT id, reset_expires FROM users WHERE reset_token = ?",
            [$token]
        );

        if (!$result) {
            flash('error', 'Token reset password tidak ditemukan.');
            redirect('index.php?page=login');
        }

        if (strtotime($result['reset_expires']) < time()) {
            flash('error', 'Token reset password sudah kadaluarsa.');
            redirect('index.php?page=forgot_password');
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $db->query(
            "UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL, updated_at = NOW() WHERE id = ?",
            [$hashedPassword, $result['id']]
        );

        flash('success', 'Password berhasil direset! Silakan login dengan password baru.');
        redirect('index.php?page=login');
    }
}
