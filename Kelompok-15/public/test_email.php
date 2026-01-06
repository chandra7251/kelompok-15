<?php
/**
 * Script untuk test konfigurasi email
 * HAPUS FILE INI SETELAH SELESAI TESTING!
 */

require_once __DIR__ . '/../vendor/autoload.php';

// Load .env
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '#') === 0)
            continue;
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value, '"\'');
        }
    }
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

echo "<h1>🔧 Email Configuration Test</h1>";
echo "<pre>";

// Show current config
echo "=== KONFIGURASI SAAT INI ===\n";
echo "MAIL_HOST: " . ($_ENV['MAIL_HOST'] ?? 'NOT SET') . "\n";
echo "MAIL_PORT: " . ($_ENV['MAIL_PORT'] ?? 'NOT SET') . "\n";
echo "MAIL_USERNAME: " . ($_ENV['MAIL_USERNAME'] ?? 'NOT SET') . "\n";
echo "MAIL_PASSWORD: " . (isset($_ENV['MAIL_PASSWORD']) ? str_repeat('*', strlen($_ENV['MAIL_PASSWORD'])) : 'NOT SET') . "\n";
echo "MAIL_FROM_ADDRESS: " . ($_ENV['MAIL_FROM_ADDRESS'] ?? 'NOT SET') . "\n";
echo "\n";

// Test SMTP Connection
echo "=== TEST KONEKSI SMTP ===\n";

try {
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
    $mail->isSMTP();
    $mail->Host = $_ENV['MAIL_HOST'] ?? 'mail.keuanganku.xyz';
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['MAIL_USERNAME'] ?? '';
    $mail->Password = $_ENV['MAIL_PASSWORD'] ?? '';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // SSL
    $mail->Port = (int) ($_ENV['MAIL_PORT'] ?? 465);
    $mail->CharSet = 'UTF-8';

    $mail->setFrom($_ENV['MAIL_FROM_ADDRESS'] ?? 'noreply@keuanganku.xyz', $_ENV['MAIL_FROM_NAME'] ?? 'Test');

    // Ganti dengan email tujuan untuk test
    $testEmail = $_GET['to'] ?? 'test@example.com';
    $mail->addAddress($testEmail);

    $mail->isHTML(true);
    $mail->Subject = '🧪 Test Email dari KeuanganKu';
    $mail->Body = '<h1>Test Berhasil!</h1><p>Jika Anda menerima email ini, konfigurasi SMTP sudah benar.</p>';
    $mail->AltBody = 'Test Berhasil! Jika Anda menerima email ini, konfigurasi SMTP sudah benar.';

    echo "\nMengirim email ke: $testEmail\n\n";

    $mail->send();

    echo "\n\n✅ EMAIL BERHASIL TERKIRIM!\n";

} catch (Exception $e) {
    echo "\n\n❌ GAGAL MENGIRIM EMAIL\n";
    echo "Error: " . $mail->ErrorInfo . "\n";
}

echo "</pre>";

echo "<hr><p style='color:red;font-weight:bold;'>⚠️ HAPUS FILE INI SETELAH SELESAI TESTING!</p>";
?>