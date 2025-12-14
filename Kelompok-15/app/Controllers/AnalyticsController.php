<?php

namespace App\Controllers;

use App\Services\AnalyticsService;

class AnalyticsController
{
    public function index(): void
    {
        $this->checkAuth();
        $mahasiswaId = auth()['mahasiswa_id'];

        $analytics = new AnalyticsService($mahasiswaId);
        $stats = $analytics->getDashboardStats();
        $spendingStatus = $analytics->getSpendingStatus();
        $monthlyData = $analytics->getMonthlyChartData(6);

        view('dashboard.analytics', [
            'stats' => $stats,
            'spendingStatus' => $spendingStatus,
            'monthlyData' => $monthlyData
        ]);
    }

    private function checkAuth(): void
    {
        if (!is_logged_in() || !is_role('mahasiswa')) {
            redirect('index.php?page=login');
        }
    }
}
