<?php

namespace App\Controllers;

use App\Models\User;
use App\Core\Database;

class ForgotPasswordController
{
    public function index(): void
    {
        if (is_logged_in()) {
            redirect('index.php?page=dashboard');
        }
        view('auth.forgot_password');
    }

    public function submit(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf()) {
            redirect('index.php?page=forgot_password');
        }

        $email = trim($_POST['email'] ?? '');

        if (!validate_email($email)) {
            flash('error', 'Format email tidak valid');
            redirect('index.php?page=forgot_password');
        }

        $user = new User();
        $userData = $user->findByEmail($email);

        if ($userData) {
            $token = bin2hex(random_bytes(32));
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $db = Database::getInstance();
            $db->query("UPDATE users SET reset_token = ?, reset_expires = ? WHERE id = ?", [$token, $expiry, $userData->getId()]);

            flash('success', 'Jika email terdaftar, link reset password telah dikirim. Silakan cek email Anda.');
        } else {
            flash('success', 'Jika email terdaftar, link reset password telah dikirim. Silakan cek email Anda.');
        }

        redirect('index.php?page=login');
    }
}
