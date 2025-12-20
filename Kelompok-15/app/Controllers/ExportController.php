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
        // BOM for UTF-8
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        // Use semicolon for better Excel compatibility in non-English regions
        fputcsv($output, ['Tanggal', 'Kategori', 'Tipe', 'Jumlah', 'Mata Uang', 'Jumlah IDR', 'Kurs', 'Keterangan'], ';');

        foreach ($data as $row) {
            fputcsv($output, [
                $row['tanggal'],
                $row['kategori_nama'],
                $row['tipe'],
                number_format((float) $row['jumlah'], 0, ',', '.'),
                $row['mata_uang'],
                number_format((float) $row['jumlah_idr'], 0, ',', '.'),
                $row['kurs_rate'],
                $row['keterangan'] ?? ''
            ], ';');
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

        fputcsv($output, ['Bulan', 'Total Pemasukan', 'Total Pengeluaran', 'Selisih'], ';');

        foreach ($summary as $row) {
            $pemasukan = (float) ($row['pemasukan'] ?? 0);
            $pengeluaran = (float) ($row['pengeluaran'] ?? 0);
            $selisih = $pemasukan - $pengeluaran;
            fputcsv($output, [
                $row['bulan'],
                number_format($pemasukan, 0, ',', '.'),
                number_format($pengeluaran, 0, ',', '.'),
                number_format($selisih, 0, ',', '.')
            ], ';');
        }

        fclose($output);
        exit;
    }

    public function transferOrangtua(): void
    {
        if (!is_logged_in() || !is_role('orangtua')) {
            redirect('index.php?page=login');
        }

        $orangtuaId = auth()['orangtua_id'];
        $db = Database::getInstance();

        $sql = "SELECT ts.*, u.nama as mahasiswa_nama, m.nim 
                FROM transfer_saldo ts 
                JOIN mahasiswa m ON ts.mahasiswa_id = m.id 
                JOIN users u ON m.user_id = u.id 
                WHERE ts.orangtua_id = ? 
                ORDER BY ts.created_at DESC";

        $data = $db->fetchAll($sql, [$orangtuaId]);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=riwayat_transfer_' . date('Y-m-d') . '.csv');

        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        fputcsv($output, ['Tanggal', 'Penerima', 'NIM', 'Jumlah', 'Mata Uang', 'Jumlah IDR', 'Kurs', 'Keterangan', 'Status']);

        foreach ($data as $row) {
            fputcsv($output, [
                $row['created_at'],
                $row['mahasiswa_nama'],
                $row['nim'],
                $row['jumlah'],
                $row['mata_uang'],
                $row['jumlah_idr'],
                $row['kurs_rate'],
                $row['keterangan'],
                $row['status']
            ]);
        }

        fclose($output);
        exit;
    }
}
