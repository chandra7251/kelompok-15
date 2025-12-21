<?php

namespace App\Controllers;

use App\Models\OrangTua;
use App\Models\Mahasiswa;
use App\Models\TransferSaldo;
use App\Services\ExchangeRateService;
use App\Services\NotificationService;

class TransferController
{
    public function index(): void
    {
        $this->checkAuth();
        $user = auth();
        $orangtuaId = $user['orangtua_id'];

        $orangtua = new OrangTua();
        $ortu = $orangtua->findOrangtua($orangtuaId);
        $linkedMahasiswa = $ortu->getMahasiswaLinked();

        $transfer = new TransferSaldo();
        $history = $transfer->getAllByOrangtua($orangtuaId, 20);

        $exchangeService = new ExchangeRateService();
        $currencies = $exchangeService->getAvailableCurrencies();

        view('transfer.index', [
            'linkedMahasiswa' => $linkedMahasiswa,
            'history' => $history,
            'currencies' => $currencies
        ]);
    }

    public function store(): void
    {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf()) {
            redirect('index.php?page=transfer');
        }

        $user = auth();
        $orangtuaId = $user['orangtua_id'];

        $mahasiswaId = (int) ($_POST['mahasiswa_id'] ?? 0);
        $jumlah = (float) ($_POST['jumlah'] ?? 0);
        $mataUang = strtoupper(trim($_POST['mata_uang'] ?? 'IDR'));
        $keterangan = trim($_POST['keterangan'] ?? '');

        if ($jumlah < 0.01 || $mahasiswaId <= 0) {
            flash('error', 'Data tidak valid');
            redirect('index.php?page=transfer');
        }

        $orangtua = new OrangTua();
        $ortu = $orangtua->findOrangtua($orangtuaId);

        if (!$ortu->isMahasiswaLinked($mahasiswaId)) {
            flash('error', 'Mahasiswa tidak terhubung dengan akun Anda');
            redirect('index.php?page=transfer');
        }

        $exchangeService = new ExchangeRateService();
        $conversion = $exchangeService->convertToIdr($jumlah, $mataUang);

        try {
            $transfer = new TransferSaldo();
            $transfer->setOrangtuaId($orangtuaId)
                ->setMahasiswaId($mahasiswaId)
                ->setJumlah($jumlah)
                ->setMataUang($mataUang)
                ->setJumlahIdr($conversion['converted_amount'])
                ->setKursRate($conversion['rate'])
                ->setKeterangan($keterangan)
                ->setStatus('completed');
            $transfer->create();

            $db = \App\Core\Database::getInstance();
            $kategoriTransfer = $db->fetch(
                "SELECT id FROM kategori WHERE mahasiswa_id = ? AND nama LIKE '%Transfer%' AND tipe = 'pemasukan' LIMIT 1",
                [$mahasiswaId]
            );

            if (!$kategoriTransfer) {
                $kategoriId = $db->insert(
                    "INSERT INTO kategori (mahasiswa_id, nama, tipe) VALUES (?, ?, ?)",
                    [$mahasiswaId, 'Transfer Ortu', 'pemasukan']
                );
            } else {
                $kategoriId = $kategoriTransfer['id'];
            }

            $db->insert(
                "INSERT INTO transaksi (mahasiswa_id, kategori_id, jumlah, mata_uang, jumlah_idr, kurs_rate, keterangan, tanggal) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
                [
                    $mahasiswaId,
                    $kategoriId,
                    $jumlah,
                    $mataUang,
                    $conversion['converted_amount'],
                    $conversion['rate'],
                    'Transfer dari ' . $user['nama'] . ($keterangan ? ': ' . $keterangan : ''),
                    date('Y-m-d')
                ]
            );


            $mahasiswa = new Mahasiswa();
            $mhs = $mahasiswa->findMahasiswa($mahasiswaId);
            if ($mhs) {
                $notif = new NotificationService();
                $notif->sendTransferNotification(
                    $mhs->getId(),
                    $mhs->getEmail(),
                    $mhs->getNama(),
                    $conversion['converted_amount'],
                    $user['nama']
                );
            }

            flash('success', 'Transfer berhasil! Saldo telah dikirim.');
        } catch (\Exception $e) {
            flash('error', $e->getMessage());
        }

        $redirectTo = ($_GET['redirect'] ?? '') === 'dashboard' ? 'index.php?page=dashboard' : 'index.php?page=transfer';
        redirect($redirectTo);
    }

    public function linkMahasiswa(): void
    {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf()) {
            redirect('index.php?page=transfer');
        }

        $pairingCode = strtoupper(trim($_POST['pairing_code'] ?? ''));
        $orangtuaId = auth()['orangtua_id'];

        if (empty($pairingCode)) {
            flash('error', 'Kode pairing tidak boleh kosong');
            redirect('index.php?page=transfer');
        }

        $mahasiswa = new Mahasiswa();
        $mhs = $mahasiswa->findByPairingCode($pairingCode);

        if (!$mhs) {
            flash('error', 'Kode pairing tidak ditemukan');
            redirect('index.php?page=transfer');
        }

        $orangtua = new OrangTua();
        $ortu = $orangtua->findOrangtua($orangtuaId);
        $ortu->linkMahasiswa($mhs->getMahasiswaId());

        flash('success', 'Berhasil terhubung dengan ' . e($mhs->getNama()));
        redirect('index.php?page=transfer');
    }

    public function unlinkMahasiswa(): void
    {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf()) {
            redirect('index.php?page=transfer');
        }

        $mahasiswaId = (int) ($_POST['mahasiswa_id'] ?? 0);
        $orangtuaId = auth()['orangtua_id'];

        $orangtua = new OrangTua();
        $ortu = $orangtua->findOrangtua($orangtuaId);
        $ortu->unlinkMahasiswa($mahasiswaId);

        flash('success', 'Mahasiswa berhasil dilepas');
        redirect('index.php?page=transfer');
    }

    private function checkAuth(): void
    {
        if (!is_logged_in() || !is_role('orangtua')) {
            redirect('index.php?page=login');
        }
    }
}
