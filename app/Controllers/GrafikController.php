<?php

namespace App\Controllers;

use App\Services\AnalyticsService;

class GrafikController
{
    public function index(): void
    {
        $this->checkAuth();
        $mahasiswaId = auth()['mahasiswa_id'];

        $analytics = new AnalyticsService($mahasiswaId);
        $monthlyData = $analytics->getMonthlyChartData(6);
        $categoryData = $analytics->getCategoryChartData('pengeluaran');

        view('dashboard.grafik', [
            'monthlyData' => $monthlyData,
            'categoryData' => $categoryData
        ]);
    }

    public function getChartData(): void
    {
        $this->checkAuth();
        $mahasiswaId = auth()['mahasiswa_id'];

        $type = $_GET['type'] ?? 'monthly';
        $analytics = new AnalyticsService($mahasiswaId);

        header('Content-Type: application/json');

        if ($type === 'monthly') {
            echo json_encode($analytics->getMonthlyChartData(6));
        } else {
            echo json_encode($analytics->getCategoryChartData('pengeluaran'));
        }
        exit;
    }

    private function checkAuth(): void
    {
        if (!is_logged_in() || !is_role('mahasiswa')) {
            redirect('index.php?page=login');
        }
    }
}
