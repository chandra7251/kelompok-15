<?php

namespace App\Controllers;

use App\Models\Mahasiswa;
use App\Models\OrangTua;
use App\Models\Transaksi;
use App\Models\TransferSaldo;
use App\Services\AnalyticsService;
use App\Services\ExchangeRateService;
use App\Core\Database;

class DashboardController
{
    public function index(): void
    {
        if (!is_logged_in()) {
            redirect('index.php?page=login');
        }

        $user = auth();
        $role = $user['role'];

        if ($role === 'mahasiswa') {
            $this->mahasiswaDashboard();
        } elseif ($role === 'orangtua') {
            $this->orangtuaDashboard();
        } else {
            $this->adminDashboard();
        }
    }

    private function mahasiswaDashboard(): void
    {
        $user = auth();
        $mahasiswaId = $user['mahasiswa_id'] ?? null;

        if (!$mahasiswaId) {
            flash('error', 'Data mahasiswa tidak ditemukan');
            redirect('index.php?page=login');
        }

        $mahasiswa = new Mahasiswa();
        $mhs = $mahasiswa->findMahasiswa($mahasiswaId);

        $analytics = new AnalyticsService($mahasiswaId);
        $stats = $analytics->getDashboardStats();
        $spendingStatus = $analytics->getSpendingStatus();

        $transaksi = new Transaksi();
        $recentTransaksi = $transaksi->getAllByMahasiswa($mahasiswaId, 5);

        $transfer = new TransferSaldo();
        $recentTransfer = $transfer->getAllByMahasiswa($mahasiswaId, 5);

        view('dashboard.mahasiswa', [
            'user' => $user,
            'mahasiswa' => $mhs,
            'stats' => $stats,
            'spendingStatus' => $spendingStatus,
            'recentTransaksi' => $recentTransaksi,
            'recentTransfer' => $recentTransfer
        ]);
    }

    private function orangtuaDashboard(): void
    {
        $user = auth();
        $orangtuaId = $user['orangtua_id'] ?? null;

        if (!$orangtuaId) {
            flash('error', 'Data orangtua tidak ditemukan');
            redirect('index.php?page=login');
        }

        $orangtua = new OrangTua();
        $ortu = $orangtua->findOrangtua($orangtuaId);
        $linkedMahasiswa = $ortu->getMahasiswaLinked();

        $transfer = new TransferSaldo();
        $recentTransfer = $transfer->getAllByOrangtua($orangtuaId, 10);

        $exchangeService = new ExchangeRateService();
        $currencies = $exchangeService->getAvailableCurrencies();

        view('dashboard.orangtua', [
            'user' => $user,
            'orangtua' => $ortu,
            'linkedMahasiswa' => $linkedMahasiswa,
            'recentTransfer' => $recentTransfer,
            'currencies' => $currencies
        ]);
    }

    private function adminDashboard(): void
    {
        $user = auth();
        $db = Database::getInstance();

        $stats = [
            'total_users' => $db->fetch("SELECT COUNT(*) as total FROM users")['total'] ?? 0,
            'total_mahasiswa' => $db->fetch("SELECT COUNT(*) as total FROM mahasiswa")['total'] ?? 0,
            'total_orangtua' => $db->fetch("SELECT COUNT(*) as total FROM orangtua")['total'] ?? 0,
            'total_transaksi' => $db->fetch("SELECT COUNT(*) as total FROM transaksi")['total'] ?? 0,
            'total_transfer' => $db->fetch("SELECT COUNT(*) as total FROM transfer_saldo")['total'] ?? 0,
        ];

        $recentUsers = $db->fetchAll("SELECT u.*, m.nim, m.saldo FROM users u LEFT JOIN mahasiswa m ON u.id = m.user_id ORDER BY u.created_at DESC LIMIT 10");
        $recentTransaksi = $db->fetchAll("SELECT t.*, u.nama as mahasiswa_nama, k.nama as kategori_nama, k.tipe FROM transaksi t JOIN mahasiswa m ON t.mahasiswa_id = m.id JOIN users u ON m.user_id = u.id JOIN kategori k ON t.kategori_id = k.id ORDER BY t.created_at DESC LIMIT 10");

        view('dashboard.admin', [
            'user' => $user,
            'stats' => $stats,
            'recentUsers' => $recentUsers,
            'recentTransaksi' => $recentTransaksi
        ]);
    }
}
