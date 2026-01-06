<?php

namespace App\Services;

use App\Core\Database;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class NotificationService
{
    private Database $db;
    private ?PHPMailer $mailer = null;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->initMailer();
    }

    private function initMailer(): void
    {
        try {
            $this->mailer = new PHPMailer(true);
            $this->mailer->isSMTP();
            $this->mailer->Host = $_ENV['MAIL_HOST'] ?? 'smtp.gmail.com';
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = $_ENV['MAIL_USERNAME'] ?? '';
            $this->mailer->Password = $_ENV['MAIL_PASSWORD'] ?? '';
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $this->mailer->Port = (int) ($_ENV['MAIL_PORT'] ?? 465);
            $this->mailer->setFrom($_ENV['MAIL_FROM_ADDRESS'] ?? 'noreply@example.com', $_ENV['MAIL_FROM_NAME'] ?? 'Sistem Keuangan Mahasiswa');
            $this->mailer->isHTML(true);
            $this->mailer->CharSet = 'UTF-8';
        } catch (Exception $e) {
            $this->mailer = null;
        }
    }

    public function sendTransferNotification(int $userId, string $email, string $nama, float $jumlah, string $pengirim): bool
    {
        $subject = 'Notifikasi Saldo Masuk';
        $body = $this->getTransferEmailTemplate($nama, $jumlah, $pengirim);
        return $this->send($userId, $email, $subject, $body, 'transfer_saldo');
    }

    public function sendReminderNotification(int $userId, string $email, string $nama, string $tipe, float $jumlah, string $jatuhTempo): bool
    {
        $subject = "Pengingat Pembayaran $tipe";
        $body = $this->getReminderEmailTemplate($nama, $tipe, $jumlah, $jatuhTempo);
        return $this->send($userId, $email, $subject, $body, 'reminder');
    }

    public function sendBorosNotification(int $userId, string $email, string $namaOrangtua, string $namaMahasiswa, array $status): bool
    {
        $subject = "⚠️ Peringatan: {$namaMahasiswa} dalam Status Boros";
        $body = $this->getBorosEmailTemplate($namaOrangtua, $namaMahasiswa, $status);
        return $this->send($userId, $email, $subject, $body, 'boros_alert');
    }

    private function send(int $userId, string $email, string $subject, string $body, string $tipe): bool
    {
        $notifId = $this->createNotification($userId, $tipe, $subject, strip_tags($body));

        if (!$this->mailer) {
            $this->updateNotificationStatus($notifId, 'failed');
            return false;
        }

        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($email);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;
            $this->mailer->AltBody = strip_tags($body);
            $this->mailer->send();
            $this->updateNotificationStatus($notifId, 'sent');
            return true;
        } catch (Exception $e) {
            $this->updateNotificationStatus($notifId, 'failed');
            return false;
        }
    }

    private function createNotification(int $userId, string $tipe, string $judul, string $pesan): int
    {
        return $this->db->insert(
            "INSERT INTO notifications (user_id, tipe, judul, pesan, status) VALUES (:user_id, :tipe, :judul, :pesan, 'pending')",
            ['user_id' => $userId, 'tipe' => $tipe, 'judul' => $judul, 'pesan' => $pesan]
        );
    }

    private function updateNotificationStatus(int $id, string $status): void
    {
        $this->db->update("UPDATE notifications SET status = :status, sent_at = NOW() WHERE id = :id", ['status' => $status, 'id' => $id]);
    }

    public function getNotificationsByUser(int $userId, int $limit = 20): array
    {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM notifications WHERE user_id = :user_id ORDER BY created_at DESC LIMIT :limit");
        $stmt->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    private function getTransferEmailTemplate(string $nama, float $jumlah, string $pengirim): string
    {
        $j = format_rupiah($jumlah);
        $y = date('Y');
        return "<div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
            <div style='background:#3b82f6;color:white;padding:20px;text-align:center;'><h1 style='margin:0;'>Saldo Masuk!</h1></div>
            <div style='padding:30px;background:#f8fafc;'>
                <p>Halo <strong>$nama</strong>,</p>
                <p>Anda menerima transfer saldo sebesar:</p>
                <div style='background:white;padding:20px;border-radius:8px;text-align:center;margin:20px 0;'>
                    <h2 style='color:#10b981;margin:0;'>$j</h2>
                </div>
                <p>Dari: <strong>$pengirim</strong></p>
                <p>Saldo telah ditambahkan ke akun Anda.</p>
            </div>
            <div style='background:#e2e8f0;padding:15px;text-align:center;font-size:12px;color:#64748b;'>Sistem Keuangan Mahasiswa &copy; $y</div>
        </div>";
    }

    private function getReminderEmailTemplate(string $nama, string $tipe, float $jumlah, string $jatuhTempo): string
    {
        $j = format_rupiah($jumlah);
        return "<div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
            <div style='background:#f59e0b;color:white;padding:20px;text-align:center;'><h1 style='margin:0;'>Pengingat Pembayaran</h1></div>
            <div style='padding:30px;background:#f8fafc;'>
                <p>Halo <strong>$nama</strong>,</p>
                <p>Ini adalah pengingat untuk pembayaran <strong>$tipe</strong>:</p>
                <div style='background:white;padding:20px;border-radius:8px;margin:20px 0;'>
                    <p><strong>Jumlah:</strong> $j</p>
                    <p><strong>Jatuh Tempo:</strong> $jatuhTempo</p>
                </div>
                <p>Pastikan untuk melakukan pembayaran tepat waktu.</p>
            </div>
        </div>";
    }

    private function getBorosEmailTemplate(string $namaOrangtua, string $namaMahasiswa, array $status): string
    {
        $pemasukan = format_rupiah($status['pemasukan'] ?? 0);
        $pengeluaran = format_rupiah($status['pengeluaran'] ?? 0);
        $ratio = $status['ratio'] ?? 0;
        $y = date('Y');
        return "<div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
            <div style='background:#ef4444;color:white;padding:20px;text-align:center;'><h1 style='margin:0;'>⚠️ Peringatan Status Keuangan</h1></div>
            <div style='padding:30px;background:#f8fafc;'>
                <p>Halo <strong>{$namaOrangtua}</strong>,</p>
                <p>Kami ingin menginformasikan bahwa anak Anda <strong>{$namaMahasiswa}</strong> saat ini berada dalam status <strong style='color:#ef4444;'>BOROS</strong>.</p>
                <div style='background:white;padding:20px;border-radius:8px;margin:20px 0;border-left:4px solid #ef4444;'>
                    <h3 style='margin-top:0;color:#374151;'>Ringkasan Keuangan Bulan Ini:</h3>
                    <p><strong>Pemasukan:</strong> <span style='color:#10b981;'>{$pemasukan}</span></p>
                    <p><strong>Pengeluaran:</strong> <span style='color:#ef4444;'>{$pengeluaran}</span></p>
                    <p><strong>Rasio Pengeluaran:</strong> <span style='color:#ef4444;font-weight:bold;'>{$ratio}%</span></p>
                </div>
                <p style='color:#6b7280;font-size:14px;'>Status boros terjadi ketika rasio pengeluaran melebihi 80% dari pemasukan. Kami menyarankan untuk berdiskusi dengan anak Anda mengenai pengelolaan keuangan yang lebih bijak.</p>
                <p>Anda dapat memantau detail keuangan anak di dashboard orang tua.</p>
            </div>
            <div style='background:#e2e8f0;padding:15px;text-align:center;font-size:12px;color:#64748b;'>Sistem Keuangan Mahasiswa &copy; {$y}</div>
        </div>";
    }
}
