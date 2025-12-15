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

        // Get dynamic thresholds from settings
        $thresholds = $this->getThresholdSettings();
        $thresholdHemat = $thresholds['threshold_hemat'];
        $thresholdNormal = $thresholds['threshold_normal'];

        if ($ratio <= $thresholdHemat) {
            $status = 'hemat';
            $color = 'green';
            $message = 'Keuangan Anda sangat sehat! Pertahankan!';
        } elseif ($ratio <= $thresholdNormal) {
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

    private function getThresholdSettings(): array
    {
        $rows = $this->db->fetchAll("SELECT setting_key, setting_value FROM system_settings WHERE setting_key IN ('threshold_hemat', 'threshold_normal')");
        $settings = [];
        foreach ($rows as $row) {
            $settings[$row['setting_key']] = (int) $row['setting_value'];
        }
        return [
            'threshold_hemat' => $settings['threshold_hemat'] ?? 50,
            'threshold_normal' => $settings['threshold_normal'] ?? 80
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

    public function getWeeklyChartData(int $weeks = 8): array
    {
        $labels = [];
        $pemasukan = [];
        $pengeluaran = [];

        for ($i = $weeks - 1; $i >= 0; $i--) {
            $startDate = date('Y-m-d', strtotime("-$i weeks monday"));
            $endDate = date('Y-m-d', strtotime("-$i weeks sunday"));
            $weekNum = date('W', strtotime($startDate));
            $labels[] = 'Minggu ' . $weekNum;

            $results = $this->db->fetchAll(
                "SELECT k.tipe, COALESCE(SUM(t.jumlah_idr), 0) as total 
                 FROM transaksi t 
                 JOIN kategori k ON t.kategori_id = k.id 
                 WHERE t.mahasiswa_id = :id AND t.tanggal BETWEEN :start AND :end 
                 GROUP BY k.tipe",
                ['id' => $this->mahasiswaId, 'start' => $startDate, 'end' => $endDate]
            );

            $weekData = ['pemasukan' => 0.0, 'pengeluaran' => 0.0];
            foreach ($results as $row) {
                $weekData[$row['tipe']] = (float) $row['total'];
            }
            $pemasukan[] = $weekData['pemasukan'];
            $pengeluaran[] = $weekData['pengeluaran'];
        }

        return ['labels' => $labels, 'pemasukan' => $pemasukan, 'pengeluaran' => $pengeluaran];
    }

    public function getYearlyChartData(int $years = 3): array
    {
        $labels = [];
        $pemasukan = [];
        $pengeluaran = [];

        for ($i = $years - 1; $i >= 0; $i--) {
            $year = date('Y', strtotime("-$i years"));
            $labels[] = $year;

            $results = $this->db->fetchAll(
                "SELECT k.tipe, COALESCE(SUM(t.jumlah_idr), 0) as total 
                 FROM transaksi t 
                 JOIN kategori k ON t.kategori_id = k.id 
                 WHERE t.mahasiswa_id = :id AND YEAR(t.tanggal) = :year 
                 GROUP BY k.tipe",
                ['id' => $this->mahasiswaId, 'year' => $year]
            );

            $yearData = ['pemasukan' => 0.0, 'pengeluaran' => 0.0];
            foreach ($results as $row) {
                $yearData[$row['tipe']] = (float) $row['total'];
            }
            $pemasukan[] = $yearData['pemasukan'];
            $pengeluaran[] = $yearData['pengeluaran'];
        }

        return ['labels' => $labels, 'pemasukan' => $pemasukan, 'pengeluaran' => $pengeluaran];
    }

    public function getTrendData(string $period = 'monthly'): array
    {
        switch ($period) {
            case 'weekly':
                return $this->getWeeklyChartData(8);
            case 'yearly':
                return $this->getYearlyChartData(3);
            case 'monthly':
            default:
                return $this->getMonthlyChartData(6);
        }
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

    public function checkAndNotifyBorosStatus(): void
    {
        $status = $this->getSpendingStatus();

        if ($status['status'] !== 'boros') {
            return;
        }

        $linkedParents = $this->db->fetchAll(
            "SELECT o.id as orangtua_id, u.id as user_id, u.nama, u.email 
             FROM orangtua o 
             JOIN users u ON o.user_id = u.id 
             JOIN relasi_orangtua_mahasiswa r ON o.id = r.orangtua_id 
             WHERE r.mahasiswa_id = :mahasiswa_id",
            ['mahasiswa_id' => $this->mahasiswaId]
        );

        if (empty($linkedParents)) {
            return;
        }

        $mahasiswaData = $this->db->fetch(
            "SELECT u.nama FROM mahasiswa m JOIN users u ON m.user_id = u.id WHERE m.id = :id",
            ['id' => $this->mahasiswaId]
        );
        $namaMahasiswa = $mahasiswaData['nama'] ?? 'Anak Anda';

        $notifService = new \App\Services\NotificationService();

        foreach ($linkedParents as $parent) {
            $notifService->sendBorosNotification(
                $parent['user_id'],
                $parent['email'],
                $parent['nama'],
                $namaMahasiswa,
                $status
            );
        }
    }

    public function getDetailedCalculation(): array
    {
        $month = date('Y-m');
        $parts = explode('-', $month);
        $year = $parts[0];
        $mon = $parts[1];

        // Get total pemasukan (excluding tabungan)
        $pemasukanResult = $this->db->fetch(
            "SELECT COALESCE(SUM(t.jumlah_idr), 0) as total 
             FROM transaksi t 
             JOIN kategori k ON t.kategori_id = k.id 
             WHERE t.mahasiswa_id = :id 
             AND k.tipe = 'pemasukan' 
             AND k.nama != 'Tabungan'
             AND YEAR(t.tanggal) = :year AND MONTH(t.tanggal) = :month",
            ['id' => $this->mahasiswaId, 'year' => $year, 'month' => $mon]
        );
        $totalPemasukan = (float) ($pemasukanResult['total'] ?? 0);

        // Get tabungan amount
        $tabunganResult = $this->db->fetch(
            "SELECT COALESCE(SUM(t.jumlah_idr), 0) as total 
             FROM transaksi t 
             JOIN kategori k ON t.kategori_id = k.id 
             WHERE t.mahasiswa_id = :id 
             AND k.nama = 'Tabungan'
             AND YEAR(t.tanggal) = :year AND MONTH(t.tanggal) = :month",
            ['id' => $this->mahasiswaId, 'year' => $year, 'month' => $mon]
        );
        $totalTabungan = (float) ($tabunganResult['total'] ?? 0);

        // Get per-category pengeluaran
        $kategoris = $this->db->fetchAll(
            "SELECT k.nama, COALESCE(SUM(t.jumlah_idr), 0) as total 
             FROM kategori k 
             LEFT JOIN transaksi t ON k.id = t.kategori_id 
                AND YEAR(t.tanggal) = :year AND MONTH(t.tanggal) = :month
             WHERE k.mahasiswa_id = :id AND k.tipe = 'pengeluaran'
             GROUP BY k.id, k.nama",
            ['id' => $this->mahasiswaId, 'year' => $year, 'month' => $mon]
        );

        $totalPengeluaran = 0;
        $categoryDetails = [];

        // Define category weights and scoring thresholds
        $categoryWeights = [
            'Makanan' => 0.35,
            'Biaya Kos' => 0.25,
            'Transportasi' => 0.15,
            'Kebutuhan Lain' => 0.15
        ];

        foreach ($kategoris as $kat) {
            $nama = $kat['nama'];
            $jumlah = (float) $kat['total'];
            $totalPengeluaran += $jumlah;

            // Calculate percentage of income
            $persentase = $totalPemasukan > 0 ? ($jumlah / $totalPemasukan) * 100 : 0;

            // Calculate score (0-3) based on percentage
            $skor = $this->calculateCategoryScore($nama, $persentase);

            $categoryDetails[] = [
                'nama' => $nama,
                'jumlah' => $jumlah,
                'persentase' => round($persentase, 1),
                'skor' => $skor,
                'bobot' => $categoryWeights[$nama] ?? 0
            ];
        }

        // Calculate tabungan percentage and score
        $tabunganPersentase = $totalPemasukan > 0 ? ($totalTabungan / $totalPemasukan) * 100 : 0;
        $tabunganSkor = $this->calculateTabunganScore($tabunganPersentase);

        // Calculate composite score
        $skorKomposit = 0;
        foreach ($categoryDetails as $cat) {
            if (isset($categoryWeights[$cat['nama']])) {
                $skorKomposit += $cat['skor'] * $categoryWeights[$cat['nama']];
            }
        }
        // Subtract tabungan effect (bonus for saving)
        $skorKomposit -= ($tabunganSkor * 0.10);
        $skorKomposit = max(0, $skorKomposit);

        // Determine status from composite score
        if ($skorKomposit <= 0.9) {
            $statusAkhir = 'hemat';
            $statusColor = 'green';
        } elseif ($skorKomposit <= 1.8) {
            $statusAkhir = 'normal';
            $statusColor = 'yellow';
        } else {
            $statusAkhir = 'boros';
            $statusColor = 'red';
        }

        return [
            'pemasukan' => $totalPemasukan,
            'pengeluaran' => $totalPengeluaran,
            'tabungan' => $totalTabungan,
            'tabungan_persentase' => round($tabunganPersentase, 1),
            'tabungan_skor' => $tabunganSkor,
            'selisih' => $totalPemasukan - $totalPengeluaran,
            'net_balance' => $totalPemasukan - $totalPengeluaran + $totalTabungan,
            'categories' => $categoryDetails,
            'skor_komposit' => round($skorKomposit, 2),
            'status_akhir' => $statusAkhir,
            'status_color' => $statusColor
        ];
    }

    private function calculateCategoryScore(string $kategori, float $persentase): int
    {
        // Scoring based on document specifications
        // Lower percentage = better score (0), higher = worse (3)

        $thresholds = [
            'Makanan' => [40, 60, 80],      // ≤40%=0, 40-60%=1, 60-80%=2, >80%=3
            'Biaya Kos' => [30, 45, 60],    // ≤30%=0, 30-45%=1, 45-60%=2, >60%=3
            'Transportasi' => [15, 25, 40], // ≤15%=0, 15-25%=1, 25-40%=2, >40%=3
            'Kebutuhan Lain' => [15, 25, 40]
        ];

        $limits = $thresholds[$kategori] ?? [25, 50, 75];

        if ($persentase <= $limits[0])
            return 0;
        if ($persentase <= $limits[1])
            return 1;
        if ($persentase <= $limits[2])
            return 2;
        return 3;
    }

    private function calculateTabunganScore(float $persentase): int
    {
        // Higher savings = lower (better) score
        // This will be subtracted from composite score
        if ($persentase >= 20)
            return 3; // Excellent
        if ($persentase >= 10)
            return 2; // Good
        if ($persentase >= 5)
            return 1;  // Fair
        return 0; // Poor
    }

    public function getTabunganSummary(): array
    {
        // Get all-time tabungan
        $result = $this->db->fetch(
            "SELECT COALESCE(SUM(t.jumlah_idr), 0) as total 
             FROM transaksi t 
             JOIN kategori k ON t.kategori_id = k.id 
             WHERE t.mahasiswa_id = :id AND k.nama = 'Tabungan'",
            ['id' => $this->mahasiswaId]
        );
        $totalTabungan = (float) ($result['total'] ?? 0);

        // Get this month tabungan
        $month = date('Y-m');
        $parts = explode('-', $month);
        $monthResult = $this->db->fetch(
            "SELECT COALESCE(SUM(t.jumlah_idr), 0) as total 
             FROM transaksi t 
             JOIN kategori k ON t.kategori_id = k.id 
             WHERE t.mahasiswa_id = :id AND k.nama = 'Tabungan'
             AND YEAR(t.tanggal) = :year AND MONTH(t.tanggal) = :month",
            ['id' => $this->mahasiswaId, 'year' => $parts[0], 'month' => $parts[1]]
        );

        return [
            'total' => $totalTabungan,
            'bulan_ini' => (float) ($monthResult['total'] ?? 0)
        ];
    }
}
