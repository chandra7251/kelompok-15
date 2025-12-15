<?php

namespace App\Controllers;

use App\Core\Database;
use App\Services\NotificationService;

class ReminderController
{
    public function index(): void
    {
        if (!is_logged_in() || !is_role('mahasiswa')) {
            redirect('index.php?page=login');
        }

        $mahasiswaId = auth()['mahasiswa_id'];
        $db = Database::getInstance();

        try {
            $reminders = $db->fetchAll(
                "SELECT * FROM reminders WHERE mahasiswa_id = ? ORDER BY tanggal_jatuh_tempo ASC",
                [$mahasiswaId]
            );
        } catch (\Exception $e) {
            $reminders = [];
        }

        view('dashboard.reminder', ['reminders' => $reminders]);
    }

    public function json(): void
    {
        header('Content-Type: application/json');

        if (!is_logged_in() || !is_role('mahasiswa')) {
            echo json_encode([]);
            exit;
        }

        try {
            $mahasiswaId = auth()['mahasiswa_id'];
            $db = Database::getInstance();
            $reminders = $db->fetchAll(
                "SELECT * FROM reminders WHERE mahasiswa_id = ? AND status = 'pending' ORDER BY tanggal_jatuh_tempo ASC LIMIT 5",
                [$mahasiswaId]
            );
            echo json_encode($reminders ?: []);
        } catch (\Exception $e) {
            echo json_encode([]);
        }
        exit;
    }

    public function store(): void
    {
        if (!is_logged_in() || !is_role('mahasiswa')) {
            redirect('index.php?page=login');
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf()) {
            redirect('index.php?page=reminder');
        }

        $mahasiswaId = auth()['mahasiswa_id'];
        $nama = trim($_POST['nama'] ?? '');
        $jumlah = (float) ($_POST['jumlah'] ?? 0);
        $tanggal = $_POST['tanggal_jatuh_tempo'] ?? '';

        if (empty($nama) || $jumlah <= 0 || empty($tanggal)) {
            flash('error', 'Data tidak valid');
            redirect('index.php?page=reminder');
        }

        try {
            $db = Database::getInstance();
            $db->insertRow('reminders', [
                'mahasiswa_id' => $mahasiswaId,
                'nama' => $nama,
                'jumlah' => $jumlah,
                'tanggal_jatuh_tempo' => $tanggal,
                'status' => 'pending'
            ]);
            flash('success', 'Reminder berhasil ditambahkan');
        } catch (\Exception $e) {
            flash('error', 'Gagal menambahkan reminder');
        }

        redirect('index.php?page=reminder');
    }

    public function delete(): void
    {
        if (!is_logged_in() || !is_role('mahasiswa')) {
            redirect('index.php?page=login');
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf()) {
            redirect('index.php?page=reminder');
        }

        $id = (int) ($_POST['id'] ?? 0);
        $mahasiswaId = auth()['mahasiswa_id'];

        try {
            $db = Database::getInstance();
            $db->query("DELETE FROM reminders WHERE id = ? AND mahasiswa_id = ?", [$id, $mahasiswaId]);
            flash('success', 'Reminder berhasil dihapus');
        } catch (\Exception $e) {
            flash('error', 'Gagal menghapus reminder');
        }

        redirect('index.php?page=reminder');
    }

    public function send(): void
    {
        if (!is_logged_in() || !is_role('mahasiswa')) {
            redirect('index.php?page=login');
        }

        $id = (int) ($_GET['id'] ?? 0);
        $mahasiswaId = auth()['mahasiswa_id'];

        try {
            $db = Database::getInstance();
            $reminder = $db->fetch(
                "SELECT * FROM reminders WHERE id = ? AND mahasiswa_id = ?",
                [$id, $mahasiswaId]
            );

            if ($reminder) {
                $notif = new NotificationService();
                $notif->sendReminderNotification(
                    auth()['id'],
                    auth()['email'],
                    auth()['nama'],
                    $reminder['nama'],
                    $reminder['jumlah'],
                    $reminder['tanggal_jatuh_tempo']
                );
                flash('success', 'Reminder telah dikirim ke email Anda');
            }
        } catch (\Exception $e) {
            flash('error', 'Gagal mengirim reminder');
        }

        redirect('index.php?page=reminder');
    }
}
