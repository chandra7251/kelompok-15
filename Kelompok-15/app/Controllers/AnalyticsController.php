<?php

namespace App\Controllers;

use App\Services\AnalyticsService;

class AnalyticsController
{
    public function index(): void
    {
        $this->checkAuth();
        $mahasiswaId = auth()['mahasiswa_id'];
        $period = $_GET['period'] ?? 'monthly';

        // Validate period
        if (!in_array($period, ['weekly', 'monthly', 'yearly'])) {
            $period = 'monthly';
        }

        $analytics = new AnalyticsService($mahasiswaId);
        $stats = $analytics->getDashboardStats();
        $spendingStatus = $analytics->getSpendingStatus();
        $trendData = $analytics->getTrendData($period);
        $detailedCalc = $analytics->getDetailedCalculation();
        $tabungan = $analytics->getTabunganSummary();
        $categoryChart = $analytics->getCategoryChartData('pengeluaran');

        view('dashboard.analytics', [
            'stats' => $stats,
            'spendingStatus' => $spendingStatus,
            'trendData' => $trendData,
            'currentPeriod' => $period,
            'detailedCalc' => $detailedCalc,
            'tabungan' => $tabungan,
            'categoryChart' => $categoryChart
        ]);
    }

    private function checkAuth(): void
    {
        if (!is_logged_in() || !is_role('mahasiswa')) {
            redirect('index.php?page=login');
        }
    }
}
