<?php

namespace App\Services;

use App\Core\Database;

class AnalyticsService
{
    private Database $db;
    private int $mahasiswaId;

    public function __construct(int $mahasiswaId)
    {
        $this->db = Database::getInstance();
        $this->mahasiswaId = $mahasiswaId;
    }

    public function getSpendingStatus(): array
    {
        $summary = $this->getMonthlySummary(date('Y-m'));
        $pemasukan = $summary['pemasukan'];
        $pengeluaran = $summary['pengeluaran'];

        if ($pemasukan == 0) {
            $ratio = $pengeluaran > 0 ? 100 : 0;
        } else {
            $ratio = ($pengeluaran / $pemasukan) * 100;
        }

        if ($ratio <= 50) {
            $status = 'hemat';
            $color = 'green';
            $message = 'Keuangan Anda sangat sehat! Pertahankan!';
        } elseif ($ratio <= 80) {
            $status = 'normal';
            $color = 'yellow';
            $message = 'Keuangan Anda cukup baik. Tetap bijak dalam pengeluaran.';
        } else {
            $status = 'boros';
            $color = 'red';
            $message = 'Perhatian! Pengeluaran Anda melebihi batas wajar.';
        }

        return [
            'status' => $status,
            'color' => $color,
            'message' => $message,
            'ratio' => round($ratio, 1),
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'selisih' => $pemasukan - $pengeluaran
        ];
    }

    public function getMonthlySummary(string $month): array
    {
        $parts = explode('-', $month);
        $year = $parts[0];
        $mon = $parts[1];

        $results = $this->db->fetchAll(
            "SELECT k.tipe, COALESCE(SUM(t.jumlah_idr), 0) as total FROM transaksi t JOIN kategori k ON t.kategori_id = k.id WHERE t.mahasiswa_id = :id AND YEAR(t.tanggal) = :year AND MONTH(t.tanggal) = :month GROUP BY k.tipe",
            ['id' => $this->mahasiswaId, 'year' => $year, 'month' => $mon]
        );

        $summary = ['pemasukan' => 0.0, 'pengeluaran' => 0.0];
        foreach ($results as $row) {
            $summary[$row['tipe']] = (float) $row['total'];
        }
        return $summary;
    }

    public function getMonthlyChartData(int $months = 6): array
    {
        $labels = [];
        $pemasukan = [];
        $pengeluaran = [];

        for ($i = $months - 1; $i >= 0; $i--) {
            $labels[] = date('M Y', strtotime("-$i months"));
            $summary = $this->getMonthlySummary(date('Y-m', strtotime("-$i months")));
            $pemasukan[] = $summary['pemasukan'];
            $pengeluaran[] = $summary['pengeluaran'];
        }

        return ['labels' => $labels, 'pemasukan' => $pemasukan, 'pengeluaran' => $pengeluaran];
    }

    public function getCategoryChartData(string $tipe = 'pengeluaran'): array
    {
        $results = $this->db->fetchAll(
            "SELECT k.nama, COALESCE(SUM(t.jumlah_idr), 0) as total FROM kategori k LEFT JOIN transaksi t ON k.id = t.kategori_id WHERE k.mahasiswa_id = :id AND k.tipe = :tipe GROUP BY k.id, k.nama HAVING total > 0 ORDER BY total DESC",
            ['id' => $this->mahasiswaId, 'tipe' => $tipe]
        );

        $labels = [];
        $data = [];
        foreach ($results as $row) {
            $labels[] = $row['nama'];
            $data[] = (float) $row['total'];
        }
        return ['labels' => $labels, 'data' => $data];
    }

    public function getDashboardStats(): array
    {
        $summary = $this->getMonthlySummary(date('Y-m'));
        $saldo = $this->db->fetch("SELECT saldo FROM mahasiswa WHERE id = :id", ['id' => $this->mahasiswaId]);
        $count = $this->db->fetch("SELECT COUNT(*) as c FROM transaksi WHERE mahasiswa_id = :id", ['id' => $this->mahasiswaId]);

        return [
            'saldo' => (float) ($saldo['saldo'] ?? 0),
            'pemasukan_bulan_ini' => $summary['pemasukan'],
            'pengeluaran_bulan_ini' => $summary['pengeluaran'],
            'total_transaksi' => (int) ($count['c'] ?? 0)
        ];
    }
}
