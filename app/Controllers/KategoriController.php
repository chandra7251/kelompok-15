<?php

namespace App\Controllers;

use App\Models\Kategori;

class KategoriController
{
    public function index(): void
    {
        $this->checkAuth();
        $mahasiswaId = auth()['mahasiswa_id'];

        $kategori = new Kategori();
        $list = $kategori->getWithTransaksiCount($mahasiswaId);

        view('kategori.index', ['kategoris' => $list]);
    }

    public function create(): void
    {
        $this->checkAuth();
        view('kategori.create');
    }

    public function store(): void
    {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf()) {
            redirect('index.php?page=kategori');
        }

        $mahasiswaId = auth()['mahasiswa_id'];
        $nama = trim($_POST['nama'] ?? '');
        $tipe = $_POST['tipe'] ?? '';

        if (empty($nama) || !in_array($tipe, ['pemasukan', 'pengeluaran'])) {
            flash('error', 'Data tidak valid');
            set_old_input($_POST);
            redirect('index.php?page=kategori&action=create');
        }

        try {
            $kategori = new Kategori();
            $kategori->setMahasiswaId($mahasiswaId)
                ->setNama($nama)
                ->setTipe($tipe);
            $kategori->create();

            flash('success', 'Kategori berhasil ditambahkan');
        } catch (\Exception $e) {
            flash('error', $e->getMessage());
        }

        redirect('index.php?page=kategori');
    }

    public function edit(): void
    {
        $this->checkAuth();

        $id = (int) ($_GET['id'] ?? 0);
        $mahasiswaId = auth()['mahasiswa_id'];

        $kategori = new Kategori();
        $data = $kategori->findByIdAndMahasiswa($id, $mahasiswaId);

        if (!$data) {
            flash('error', 'Kategori tidak ditemukan');
            redirect('index.php?page=kategori');
        }

        view('kategori.edit', ['kategori' => $data]);
    }

    public function update(): void
    {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf()) {
            redirect('index.php?page=kategori');
        }

        $id = (int) ($_POST['id'] ?? 0);
        $mahasiswaId = auth()['mahasiswa_id'];

        $kategori = new Kategori();
        $data = $kategori->findByIdAndMahasiswa($id, $mahasiswaId);

        if (!$data) {
            flash('error', 'Kategori tidak ditemukan');
            redirect('index.php?page=kategori');
        }

        try {
            $data->setNama(trim($_POST['nama'] ?? ''))
                ->setTipe($_POST['tipe'] ?? '');
            $data->update();

            flash('success', 'Kategori berhasil diperbarui');
        } catch (\Exception $e) {
            flash('error', $e->getMessage());
        }

        redirect('index.php?page=kategori');
    }

    public function delete(): void
    {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf()) {
            redirect('index.php?page=kategori');
        }

        $id = (int) ($_POST['id'] ?? 0);
        $mahasiswaId = auth()['mahasiswa_id'];

        $kategori = new Kategori();
        $data = $kategori->findByIdAndMahasiswa($id, $mahasiswaId);

        if (!$data) {
            flash('error', 'Kategori tidak ditemukan');
            redirect('index.php?page=kategori');
        }

        try {
            $data->delete();
            flash('success', 'Kategori berhasil dihapus');
        } catch (\Exception $e) {
            flash('error', $e->getMessage());
        }

        redirect('index.php?page=kategori');
    }

    private function checkAuth(): void
    {
        if (!is_logged_in() || !is_role('mahasiswa')) {
            redirect('index.php?page=login');
        }
    }
}
