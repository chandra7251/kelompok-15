<?php

namespace App\Controllers;

use App\Models\Transaksi;
use App\Models\Kategori;
use App\Models\Mahasiswa;
use App\Services\ExchangeRateService;
use App\Services\AnalyticsService;

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

        $kategori = new Kategori();
        $kat = $kategori->findByIdAndMahasiswa($kategoriId, $mahasiswaId);
        if (!$kat) {
            flash('error', 'Kategori tidak valid');
            redirect('index.php?page=transaksi&action=create');
        }

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

            $mahasiswa = new Mahasiswa();
            $mhs = $mahasiswa->findMahasiswa($mahasiswaId);
            if ($mhs) {
                if ($kat->getTipe() === 'pemasukan') {
                    $mhs->updateSaldo($conversion['converted_amount'], 'add');
                } else {
                    $mhs->updateSaldo($conversion['converted_amount'], 'subtract');
                }
            }

            if ($kat->getTipe() === 'pengeluaran') {
                $analytics = new AnalyticsService($mahasiswaId);
                $analytics->checkAndNotifyBorosStatus();
            }

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

        $oldJumlahIdr = $data->getJumlahIdr();
        $kategoriId = $data->getKategoriId();

        $jumlah = (float) ($_POST['jumlah'] ?? 0);
        $mataUang = strtoupper(trim($_POST['mata_uang'] ?? 'IDR'));

        $exchangeService = new ExchangeRateService();
        $conversion = $exchangeService->convertToIdr($jumlah, $mataUang);

        $kategori = new Kategori();
        $kat = $kategori->find($kategoriId);

        try {
            $data->setJumlah($jumlah)
                ->setMataUang($mataUang)
                ->setJumlahIdr($conversion['converted_amount'])
                ->setKursRate($conversion['rate'])
                ->setTanggal($_POST['tanggal'])
                ->setKeterangan(trim($_POST['keterangan'] ?? ''));
            $data->update();

            $mahasiswa = new Mahasiswa();
            $mhs = $mahasiswa->findMahasiswa($mahasiswaId);

            if ($mhs && $kat) {
                $selisih = $conversion['converted_amount'] - $oldJumlahIdr;

                if ($selisih != 0) {
                    if ($kat->getTipe() === 'pemasukan') {
                        $mhs->updateSaldo(abs($selisih), $selisih > 0 ? 'add' : 'subtract');
                    } else {
                        $mhs->updateSaldo(abs($selisih), $selisih > 0 ? 'subtract' : 'add');
                    }
                }
            }

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
            $kategori = new Kategori();
            $kat = $kategori->find($data->getKategoriId());


            $mahasiswa = new Mahasiswa();
            $mhs = $mahasiswa->findMahasiswa($mahasiswaId);
            if ($mhs && $kat) {
                if ($kat->getTipe() === 'pemasukan') {
                    $mhs->updateSaldo($data->getJumlahIdr(), 'subtract');
                } else {
                    $mhs->updateSaldo($data->getJumlahIdr(), 'add');
                }
            }

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
