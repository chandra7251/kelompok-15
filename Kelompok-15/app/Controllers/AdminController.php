<?php

namespace App\Controllers;

use App\Core\Database;
use App\Models\User;
use App\Services\AnalyticsService;

class AdminController
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function users(): void
    {
        $this->checkAuth();

        $users = $this->db->fetchAll(
            "SELECT u.*, 
                    CASE 
                        WHEN u.role = 'mahasiswa' THEN m.nim 
                        ELSE NULL 
                    END as nim,
                    CASE 
                        WHEN u.role = 'mahasiswa' THEN m.saldo 
                        ELSE NULL 
                    END as saldo
             FROM users u 
             LEFT JOIN mahasiswa m ON u.id = m.user_id 
             ORDER BY u.created_at DESC"
        );

        view('admin.users', ['users' => $users]);
    }

    public function toggleStatus(): void
    {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf()) {
            redirect('index.php?page=admin&action=users');
        }

        $userId = (int) ($_POST['user_id'] ?? 0);
        $currentUser = auth();

        if ($userId === $currentUser['id']) {
            flash('error', 'Tidak dapat menonaktifkan akun sendiri');
            redirect('index.php?page=admin&action=users');
        }

        $user = $this->db->fetch("SELECT is_active FROM users WHERE id = ?", [$userId]);
        if ($user) {
            $newStatus = $user['is_active'] ? 0 : 1;
            $this->db->update("UPDATE users SET is_active = ? WHERE id = ?", [$newStatus, $userId]);
            flash('success', 'Status user berhasil diubah');
        }

        redirect('index.php?page=admin&action=users');
    }

    public function resetPassword(): void
    {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf()) {
            redirect('index.php?page=admin&action=users');
        }

        $userId = (int) ($_POST['user_id'] ?? 0);
        $newPassword = password_hash('password123', PASSWORD_DEFAULT);

        $this->db->update("UPDATE users SET password = ? WHERE id = ?", [$newPassword, $userId]);
        flash('success', 'Password berhasil direset ke "password123"');

        redirect('index.php?page=admin&action=users');
    }

    public function deleteUser(): void
    {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf()) {
            redirect('index.php?page=admin&action=users');
        }

        $userId = (int) ($_POST['user_id'] ?? 0);
        $currentUser = auth();

        if ($userId === $currentUser['id']) {
            flash('error', 'Tidak dapat menghapus akun sendiri');
            redirect('index.php?page=admin&action=users');
        }

        $user = $this->db->fetch("SELECT role FROM users WHERE id = ?", [$userId]);
        if ($user && $user['role'] === 'admin') {
            flash('error', 'Tidak dapat menghapus akun admin');
            redirect('index.php?page=admin&action=users');
        }

        $this->db->delete("DELETE FROM users WHERE id = ?", [$userId]);
        flash('success', 'User berhasil dihapus');

        redirect('index.php?page=admin&action=users');
    }

    public function monitoring(): void
    {
        $this->checkAuth();

        $allTransaksi = $this->db->fetchAll(
            "SELECT t.*, u.nama as mahasiswa_nama, k.nama as kategori_nama, k.tipe, m.nim
             FROM transaksi t 
             JOIN mahasiswa m ON t.mahasiswa_id = m.id 
             JOIN users u ON m.user_id = u.id 
             JOIN kategori k ON t.kategori_id = k.id 
             ORDER BY t.created_at DESC 
             LIMIT 50"
        );

        $allTransfer = $this->db->fetchAll(
            "SELECT ts.*, 
                    um.nama as mahasiswa_nama, m.nim,
                    uo.nama as orangtua_nama
             FROM transfer_saldo ts 
             JOIN mahasiswa m ON ts.mahasiswa_id = m.id 
             JOIN users um ON m.user_id = um.id 
             JOIN orangtua o ON ts.orangtua_id = o.id 
             JOIN users uo ON o.user_id = uo.id 
             ORDER BY ts.created_at DESC 
             LIMIT 50"
        );

        $statusTrend = $this->getMonthlyStatusTrend();

        view('admin.monitoring', [
            'allTransaksi' => $allTransaksi,
            'allTransfer' => $allTransfer,
            'statusTrend' => $statusTrend
        ]);
    }

    public function settings(): void
    {
        $this->checkAuth();

        $settings = $this->getSettings();

        view('admin.settings', ['settings' => $settings]);
    }

    public function updateSettings(): void
    {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf()) {
            redirect('index.php?page=admin&action=settings');
        }

        $thresholdHemat = (int) ($_POST['threshold_hemat'] ?? 50);
        $thresholdNormal = (int) ($_POST['threshold_normal'] ?? 80);
        $kursTtl = (int) ($_POST['kurs_ttl'] ?? 3600);

        $this->saveSetting('threshold_hemat', $thresholdHemat);
        $this->saveSetting('threshold_normal', $thresholdNormal);
        $this->saveSetting('kurs_ttl', $kursTtl);

        flash('success', 'Pengaturan berhasil disimpan');
        redirect('index.php?page=admin&action=settings');
    }

    private function getSettings(): array
    {
        $rows = $this->db->fetchAll("SELECT setting_key, setting_value FROM system_settings");
        $settings = [];
        foreach ($rows as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }

        return [
            'threshold_hemat' => $settings['threshold_hemat'] ?? 50,
            'threshold_normal' => $settings['threshold_normal'] ?? 80,
            'kurs_ttl' => $settings['kurs_ttl'] ?? 3600
        ];
    }

    private function saveSetting(string $key, $value): void
    {
        $exists = $this->db->fetch("SELECT id FROM system_settings WHERE setting_key = ?", [$key]);
        if ($exists) {
            $this->db->update("UPDATE system_settings SET setting_value = ? WHERE setting_key = ?", [$value, $key]);
        } else {
            $this->db->insert("INSERT INTO system_settings (setting_key, setting_value) VALUES (?, ?)", [$key, $value]);
        }
    }

    private function getMonthlyStatusTrend(): array
    {
        $mahasiswaList = $this->db->fetchAll("SELECT id FROM mahasiswa");

        $labels = [];
        $hemat = [];
        $normal = [];
        $boros = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i months"));
            $labels[] = date('M Y', strtotime("-$i months"));

            $hematCount = 0;
            $normalCount = 0;
            $borosCount = 0;

            foreach ($mahasiswaList as $mhs) {
                $status = $this->getStatusForMonth($mhs['id'], $month);
                if ($status === 'hemat')
                    $hematCount++;
                elseif ($status === 'normal')
                    $normalCount++;
                else
                    $borosCount++;
            }

            $hemat[] = $hematCount;
            $normal[] = $normalCount;
            $boros[] = $borosCount;
        }

        return [
            'labels' => $labels,
            'hemat' => $hemat,
            'normal' => $normal,
            'boros' => $boros
        ];
    }

    private function getStatusForMonth(int $mahasiswaId, string $month): string
    {
        $parts = explode('-', $month);
        $year = $parts[0];
        $mon = $parts[1];

        $results = $this->db->fetchAll(
            "SELECT k.tipe, COALESCE(SUM(t.jumlah_idr), 0) as total 
             FROM transaksi t 
             JOIN kategori k ON t.kategori_id = k.id 
             WHERE t.mahasiswa_id = ? AND YEAR(t.tanggal) = ? AND MONTH(t.tanggal) = ? 
             GROUP BY k.tipe",
            [$mahasiswaId, $year, $mon]
        );

        $pemasukan = 0;
        $pengeluaran = 0;
        foreach ($results as $row) {
            if ($row['tipe'] === 'pemasukan')
                $pemasukan = (float) $row['total'];
            else
                $pengeluaran = (float) $row['total'];
        }

        if ($pemasukan == 0) {
            $ratio = $pengeluaran > 0 ? 100 : 0;
        } else {
            $ratio = ($pengeluaran / $pemasukan) * 100;
        }

        $settings = $this->getSettings();
        $thresholdHemat = (int) $settings['threshold_hemat'];
        $thresholdNormal = (int) $settings['threshold_normal'];

        if ($ratio <= $thresholdHemat)
            return 'hemat';
        elseif ($ratio <= $thresholdNormal)
            return 'normal';
        else
            return 'boros';
    }

    private function checkAuth(): void
    {
        if (!is_logged_in() || !is_role('admin')) {
            flash('error', 'Akses ditolak');
            redirect('index.php?page=login');
        }
    }
}
