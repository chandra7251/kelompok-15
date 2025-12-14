<?php

namespace App\Controllers;

use App\Models\Transaksi;
use App\Models\Kategori;
use App\Services\ExchangeRateService;

class TransaksiController
{
    public function index(): void
    {
        $this->checkAuth();
        $mahasiswaId = auth()['mahasiswa_id'];

        $transaksi = new Transaksi();
        $list = $transaksi->getAllByMahasiswa($mahasiswaId, 50);

        view('transaksi.index', ['transaksis' => $list]);
    }

    public function create(): void
    {
        $this->checkAuth();
        $mahasiswaId = auth()['mahasiswa_id'];

        $kategori = new Kategori();
        $kategoris = $kategori->getAllByMahasiswa($mahasiswaId);

        $exchangeService = new ExchangeRateService();
        $currencies = $exchangeService->getAvailableCurrencies();

        view('transaksi.create', ['kategoris' => $kategoris, 'currencies' => $currencies]);
    }

    public function store(): void
    {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf()) {
            redirect('index.php?page=transaksi');
        }

        $mahasiswaId = auth()['mahasiswa_id'];

        // Validate inputs
        $kategoriId = (int) ($_POST['kategori_id'] ?? 0);
        $jumlah = (float) ($_POST['jumlah'] ?? 0);
        $mataUang = strtoupper(trim($_POST['mata_uang'] ?? 'IDR'));
        $tanggal = $_POST['tanggal'] ?? '';
        $keterangan = trim($_POST['keterangan'] ?? '');

        if ($jumlah <= 0 || $kategoriId <= 0 || !validate_date($tanggal)) {
            flash('error', 'Data tidak valid');
            set_old_input($_POST);
            redirect('index.php?page=transaksi&action=create');
        }

        // Verify kategori ownership
        $kategori = new Kategori();
        $kat = $kategori->findByIdAndMahasiswa($kategoriId, $mahasiswaId);
        if (!$kat) {
            flash('error', 'Kategori tidak valid');
            redirect('index.php?page=transaksi&action=create');
        }

        // Convert currency
        $exchangeService = new ExchangeRateService();
        $conversion = $exchangeService->convertToIdr($jumlah, $mataUang);

        try {
            $transaksi = new Transaksi();
            $transaksi->setMahasiswaId($mahasiswaId)
                ->setKategoriId($kategoriId)
                ->setJumlah($jumlah)
                ->setMataUang($mataUang)
                ->setJumlahIdr($conversion['converted_amount'])
                ->setKursRate($conversion['rate'])
                ->setTanggal($tanggal)
                ->setKeterangan($keterangan);
            $transaksi->create();

            flash('success', 'Transaksi berhasil ditambahkan');
        } catch (\Exception $e) {
            flash('error', $e->getMessage());
        }

        redirect('index.php?page=transaksi');
    }

    public function edit(): void
    {
        $this->checkAuth();

        $id = (int) ($_GET['id'] ?? 0);
        $mahasiswaId = auth()['mahasiswa_id'];

        $transaksi = new Transaksi();
        $data = $transaksi->findByIdAndMahasiswa($id, $mahasiswaId);

        if (!$data) {
            flash('error', 'Transaksi tidak ditemukan');
            redirect('index.php?page=transaksi');
        }

        $kategori = new Kategori();
        $kategoris = $kategori->getAllByMahasiswa($mahasiswaId);

        $exchangeService = new ExchangeRateService();
        $currencies = $exchangeService->getAvailableCurrencies();

        view('transaksi.edit', [
            'transaksi' => $data,
            'kategoris' => $kategoris,
            'currencies' => $currencies
        ]);
    }

    public function update(): void
    {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf()) {
            redirect('index.php?page=transaksi');
        }

        $id = (int) ($_POST['id'] ?? 0);
        $mahasiswaId = auth()['mahasiswa_id'];

        $transaksi = new Transaksi();
        $data = $transaksi->findByIdAndMahasiswa($id, $mahasiswaId);

        if (!$data) {
            flash('error', 'Transaksi tidak ditemukan');
            redirect('index.php?page=transaksi');
        }

        $jumlah = (float) ($_POST['jumlah'] ?? 0);
        $mataUang = strtoupper(trim($_POST['mata_uang'] ?? 'IDR'));

        $exchangeService = new ExchangeRateService();
        $conversion = $exchangeService->convertToIdr($jumlah, $mataUang);

        try {
            $data->setKategoriId((int) $_POST['kategori_id'])
                ->setJumlah($jumlah)
                ->setMataUang($mataUang)
                ->setJumlahIdr($conversion['converted_amount'])
                ->setKursRate($conversion['rate'])
                ->setTanggal($_POST['tanggal'])
                ->setKeterangan(trim($_POST['keterangan'] ?? ''));
            $data->update();

            flash('success', 'Transaksi berhasil diperbarui');
        } catch (\Exception $e) {
            flash('error', $e->getMessage());
        }

        redirect('index.php?page=transaksi');
    }

    public function delete(): void
    {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf()) {
            redirect('index.php?page=transaksi');
        }

        $id = (int) ($_POST['id'] ?? 0);
        $mahasiswaId = auth()['mahasiswa_id'];

        $transaksi = new Transaksi();
        $data = $transaksi->findByIdAndMahasiswa($id, $mahasiswaId);

        if ($data) {
            $data->delete();
            flash('success', 'Transaksi berhasil dihapus');
        }

        redirect('index.php?page=transaksi');
    }

    private function checkAuth(): void
    {
        if (!is_logged_in() || !is_role('mahasiswa')) {
            redirect('index.php?page=login');
        }
    }
}
