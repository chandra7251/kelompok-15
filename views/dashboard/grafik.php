<?php
$title = 'Grafik';
ob_start();
?>

<div class="max-w-7xl mx-auto px-6 sm:px-8 py-10 space-y-8">
    <div class="mb-8">
        <p class="text-[#B3C9D8] mt-2">Visualisasi data keuangan Anda</p>
    </div>

    <div class="grid lg:grid-cols-2 gap-8">
        <div class="bg-[#0F2942] rounded-2xl p-6 border border-white/5 shadow-xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-[#00C6FB]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                </svg>
            </div>
            <h3 class="font-bold text-white text-lg mb-6 flex items-center gap-2">
                <span class="w-1 h-6 bg-[#00C6FB] rounded-full"></span>
                Tren Pemasukan & Pengeluaran
            </h3>
            <div class="relative z-10">
                <canvas id="lineChart" height="200"></canvas>
            </div>
        </div>

        <div class="bg-[#0F2942] rounded-2xl p-6 border border-white/5 shadow-xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-[#00F29C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                </svg>
            </div>
            <h3 class="font-bold text-white text-lg mb-6 flex items-center gap-2">
                <span class="w-1 h-6 bg-[#00F29C] rounded-full"></span>
                Distribusi Pengeluaran
            </h3>
            <div class="relative z-10">
                <?php if (empty($categoryData['labels'])): ?>
                    <div class="text-center py-12 flex flex-col items-center justify-center">
                        <div class="w-16 h-16 bg-white/5 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                            </svg>
                        </div>
                        <p class="text-[#B3C9D8]">Belum ada data pengeluaran</p>
                    </div>
                <?php else: ?>
                    <canvas id="pieChart" height="200"></canvas>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="bg-[#0F2942] rounded-2xl p-6 border border-white/5 shadow-xl relative overflow-hidden group">
        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
            <svg class="w-16 h-16 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
        </div>
        <h3 class="font-bold text-white text-lg mb-6 flex items-center gap-2">
            <span class="w-1 h-6 bg-indigo-500 rounded-full"></span>
            Perbandingan Bulanan
        </h3>
        <div class="relative z-10">
            <canvas id="barChart" height="100"></canvas>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const colors = ['#00C6FB', '#00F29C', '#4ED4FF', '#6AF5C9', '#6366f1', '#8b5cf6', '#d946ef', '#f43f5e'];

        Chart.defaults.color = '#B3C9D8';
        Chart.defaults.borderColor = 'rgba(255, 255, 255, 0.1)';
        Chart.defaults.font.family = "'Inter', sans-serif";

        new Chart(document.getElementById('lineChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: <?= json_encode($monthlyData['labels']) ?>,
                datasets: [{
                    label: 'Pemasukan',
                    data: <?= json_encode($monthlyData['pemasukan']) ?>,
                    borderColor: '#00F29C',
                    backgroundColor: 'rgba(0, 242, 156, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#00F29C',
                    pointBorderColor: '#0F2942',
                    pointBorderWidth: 2,
                    pointHoverRadius: 6
                }, {
                    label: 'Pengeluaran',
                    data: <?= json_encode($monthlyData['pengeluaran']) ?>,
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#ef4444',
                    pointBorderColor: '#0F2942',
                    pointBorderWidth: 2,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: { usePointStyle: true, boxWidth: 8, color: '#fff' }
                    }
                },
                scales: {
                    y: { grid: { color: 'rgba(255, 255, 255, 0.05)' } },
                    x: { grid: { display: false } }
                }
            }
        });

        <?php if (!empty($categoryData['labels'])): ?>
            new Chart(document.getElementById('pieChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: <?= json_encode($categoryData['labels']) ?>,
                    datasets: [{
                        data: <?= json_encode($categoryData['data']) ?>,
                        backgroundColor: colors,
                        borderColor: '#0F2942',
                        borderWidth: 4,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: { usePointStyle: true, boxWidth: 8, color: '#fff', padding: 20 }
                        }
                    },
                    cutout: '70%'
                }
            });
        <?php endif; ?>

        new Chart(document.getElementById('barChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: <?= json_encode($monthlyData['labels']) ?>,
                datasets: [{
                    label: 'Pemasukan',
                    data: <?= json_encode($monthlyData['pemasukan']) ?>,
                    backgroundColor: '#00F29C',
                    borderRadius: 4,
                    barPercentage: 0.6
                }, {
                    label: 'Pengeluaran',
                    data: <?= json_encode($monthlyData['pengeluaran']) ?>,
                    backgroundColor: '#ef4444',
                    borderRadius: 4,
                    barPercentage: 0.6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: { usePointStyle: true, boxWidth: 8, color: '#fff' }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(255, 255, 255, 0.05)' }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    });
</script>

<?php
$content = ob_get_clean();
include dirname(__DIR__) . '/layouts/app.php';
?>