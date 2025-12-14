<?php

namespace App\Controllers;

use App\Models\Transaksi;
use App\Core\Database;

class ExportController
{
    public function transaksi(): void
    {
        if (!is_logged_in() || !is_role('mahasiswa')) {
            redirect('index.php?page=login');
        }

        $mahasiswaId = auth()['mahasiswa_id'];
        $transaksi = new Transaksi();
        $data = $transaksi->getAllByMahasiswa($mahasiswaId, 1000);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=transaksi_' . date('Y-m-d') . '.csv');

        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        fputcsv($output, ['Tanggal', 'Kategori', 'Tipe', 'Jumlah', 'Mata Uang', 'Jumlah IDR', 'Kurs', 'Keterangan']);

        foreach ($data as $row) {
            fputcsv($output, [
                $row['tanggal'],
                $row['kategori_nama'],
                $row['tipe'],
                $row['jumlah'],
                $row['mata_uang'],
                $row['jumlah_idr'],
                $row['kurs_rate'],
                $row['keterangan']
            ]);
        }

        fclose($output);
        exit;
    }

    public function laporan(): void
    {
        if (!is_logged_in() || !is_role('mahasiswa')) {
            redirect('index.php?page=login');
        }

        $mahasiswaId = auth()['mahasiswa_id'];
        $db = Database::getInstance();

        $sql = "SELECT 
                    DATE_FORMAT(t.tanggal, '%Y-%m') as bulan,
                    SUM(CASE WHEN k.tipe = 'pemasukan' THEN t.jumlah_idr ELSE 0 END) as pemasukan,
                    SUM(CASE WHEN k.tipe = 'pengeluaran' THEN t.jumlah_idr ELSE 0 END) as pengeluaran
                FROM transaksi t
                JOIN kategori k ON t.kategori_id = k.id
                WHERE t.mahasiswa_id = ?
                GROUP BY DATE_FORMAT(t.tanggal, '%Y-%m')
                ORDER BY bulan DESC
                LIMIT 12";

        $summary = $db->fetchAll($sql, [$mahasiswaId]);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=laporan_bulanan_' . date('Y-m-d') . '.csv');

        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        fputcsv($output, ['Bulan', 'Total Pemasukan', 'Total Pengeluaran', 'Selisih']);

        foreach ($summary as $row) {
            $selisih = ($row['pemasukan'] ?? 0) - ($row['pengeluaran'] ?? 0);
            fputcsv($output, [
                $row['bulan'],
                $row['pemasukan'] ?? 0,
                $row['pengeluaran'] ?? 0,
                $selisih
            ]);
        }

        fclose($output);
        exit;
    }
}
