<?php

require __DIR__ . '/vendor/autoload.php';

if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->safeLoad();
}

use App\Core\Database;
use App\Services\NotificationService;

$db = Database::getInstance();

$tomorrow = date('Y-m-d', strtotime('+1 day'));

$reminders = $db->fetchAll(
    "SELECT r.*, m.user_id, u.email, u.nama 
     FROM reminders r 
     JOIN mahasiswa m ON r.mahasiswa_id = m.id 
     JOIN users u ON m.user_id = u.id 
     WHERE r.tanggal_jatuh_tempo = ? AND r.status = 'pending'",
    [$tomorrow]
);

if (empty($reminders)) {
    echo "No reminders to send.\n";
    exit;
}

$notif = new NotificationService();
$sent = 0;
$failed = 0;

foreach ($reminders as $reminder) {
    try {
        $result = $notif->sendReminderNotification(
            $reminder['user_id'],
            $reminder['email'],
            $reminder['nama'],
            $reminder['nama'],
            $reminder['jumlah'],
            $reminder['tanggal_jatuh_tempo']
        );

        if ($result) {
            $db->query(
                "UPDATE reminders SET status = 'sent' WHERE id = ?",
                [$reminder['id']]
            );
            $sent++;
        } else {
            $failed++;
        }
    } catch (Exception $e) {
        $failed++;
        error_log("CRON Reminder Error: " . $e->getMessage());
    }
}

echo "Sent: $sent, Failed: $failed\n";
