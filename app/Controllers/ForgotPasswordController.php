<?php

namespace App\Controllers;

use App\Models\User;
use App\Core\Database;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

            $emailSent = $this->sendResetEmail($email, $userData->getNama(), $token);

            if ($emailSent) {
                flash('success', 'Link reset password telah dikirim ke email Anda. Silakan cek inbox atau folder spam.');
            } else {
                flash('success', 'Jika email terdaftar, link reset password telah dikirim. Silakan cek email Anda.');
            }
        } else {
            flash('success', 'Jika email terdaftar, link reset password telah dikirim. Silakan cek email Anda.');
        }

        redirect('index.php?page=login');
    }

    private function sendResetEmail(string $email, string $nama, string $token): bool
    {
        try {
            $mailer = new PHPMailer(true);
            $mailer->isSMTP();
            $mailer->Host = $_ENV['MAIL_HOST'] ?? 'smtp.gmail.com';
            $mailer->SMTPAuth = true;
            $mailer->Username = $_ENV['MAIL_USERNAME'] ?? '';
            $mailer->Password = $_ENV['MAIL_PASSWORD'] ?? '';
            $mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mailer->Port = (int) ($_ENV['MAIL_PORT'] ?? 587);
            $mailer->setFrom(
                $_ENV['MAIL_FROM_ADDRESS'] ?? 'noreply@example.com',
                $_ENV['MAIL_FROM_NAME'] ?? 'Sistem Keuangan Mahasiswa'
            );
            $mailer->isHTML(true);
            $mailer->CharSet = 'UTF-8';

            $appUrl = $_ENV['APP_URL'] ?? 'http://localhost/Kelompok-15/public';
            $resetLink = $appUrl . "/index.php?page=reset_password&token=" . $token;

            $mailer->addAddress($email);
            $mailer->Subject = 'Reset Password - Sistem Keuangan Mahasiswa';
            $mailer->Body = $this->getResetEmailTemplate($nama, $resetLink);
            $mailer->AltBody = "Halo $nama, klik link berikut untuk reset password: $resetLink (Berlaku 1 jam)";

            $mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Failed to send reset email: " . $e->getMessage());
            return false;
        }
    }

    private function getResetEmailTemplate(string $nama, string $resetLink): string
    {
        $year = date('Y');
        return "
        <div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
            <div style='background:linear-gradient(135deg,#06b6d4,#10b981);color:white;padding:30px;text-align:center;border-radius:8px 8px 0 0;'>
                <h1 style='margin:0;font-size:24px;'>Reset Password</h1>
            </div>
            <div style='padding:30px;background:#f8fafc;'>
                <p>Halo <strong>$nama</strong>,</p>
                <p>Kami menerima permintaan untuk reset password akun Anda. Klik tombol di bawah untuk membuat password baru:</p>
                <div style='text-align:center;margin:30px 0;'>
                    <a href='$resetLink' style='background:linear-gradient(135deg,#06b6d4,#10b981);color:white;padding:15px 40px;text-decoration:none;border-radius:8px;font-weight:bold;display:inline-block;'>
                        Reset Password
                    </a>
                </div>
                <p style='color:#6b7280;font-size:14px;'>Link ini akan kadaluarsa dalam <strong>1 jam</strong>.</p>
                <p style='color:#6b7280;font-size:14px;'>Jika Anda tidak meminta reset password, abaikan email ini.</p>
                <hr style='border:none;border-top:1px solid #e5e7eb;margin:20px 0;'>
                <p style='color:#9ca3af;font-size:12px;'>Atau copy link berikut ke browser Anda:<br>
                    <a href='$resetLink' style='color:#06b6d4;word-break:break-all;'>$resetLink</a>
                </p>
            </div>
            <div style='background:#1e293b;padding:20px;text-align:center;font-size:12px;color:#94a3b8;border-radius:0 0 8px 8px;'>
                Sistem Keuangan Mahasiswa &copy; $year
            </div>
        </div>";
    }
}
