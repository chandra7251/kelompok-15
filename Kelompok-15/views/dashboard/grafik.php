<?php
$title = 'Grafik Keuangan';
ob_start();
?>

<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800">Grafik Keuangan</h1>
    <p class="text-gray-500 mt-1">Visualisasi data keuangan Anda</p>
</div>

<div class="grid lg:grid-cols-2 gap-8">
    <!-- Line Chart - Monthly Trend -->
    <div class="bg-white rounded-2xl p-6 card-shadow">
        <h3 class="font-semibold text-gray-800 mb-6">📈 Tren Pemasukan & Pengeluaran</h3>
        <canvas id="lineChart" height="200"></canvas>
    </div>

    <!-- Pie Chart - Category -->
    <div class="bg-white rounded-2xl p-6 card-shadow">
        <h3 class="font-semibold text-gray-800 mb-6">🥧 Distribusi Pengeluaran</h3>
        <?php if (empty($categoryData['labels'])): ?>
            <div class="text-center py-12">
                <p class="text-gray-500">Belum ada data pengeluaran</p>
            </div>
        <?php else: ?>
            <canvas id="pieChart" height="200"></canvas>
        <?php endif; ?>
    </div>
</div>

<!-- Bar Chart -->
<div class="bg-white rounded-2xl p-6 card-shadow mt-8">
    <h3 class="font-semibold text-gray-800 mb-6">📊 Perbandingan Bulanan</h3>
    <canvas id="barChart" height="100"></canvas>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const colors = ['#6366f1', '#8b5cf6', '#a855f7', '#d946ef', '#ec4899', '#f43f5e', '#f97316', '#eab308'];

        // Line Chart
        new Chart(document.getElementById('lineChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: <?= json_encode($monthlyData['labels']) ?>,
                datasets: [{
                    label: 'Pemasukan',
                    data: <?= json_encode($monthlyData['pemasukan']) ?>,
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    fill: true,
                    tension: 0.4
                }, {
                    label: 'Pengeluaran',
                    data: <?= json_encode($monthlyData['pengeluaran']) ?>,
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });

        <?php if (!empty($categoryData['labels'])): ?>
            // Pie Chart
            new Chart(document.getElementById('pieChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: <?= json_encode($categoryData['labels']) ?>,
                    datasets: [{
                        data: <?= json_encode($categoryData['data']) ?>,
                        backgroundColor: colors.slice(0, <?= count($categoryData['labels']) ?>),
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'bottom' } }
                }
            });
        <?php endif; ?>

        // Bar Chart
        new Chart(document.getElementById('barChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: <?= json_encode($monthlyData['labels']) ?>,
                datasets: [{
                    label: 'Pemasukan',
                    data: <?= json_encode($monthlyData['pemasukan']) ?>,
                    backgroundColor: '#10b981',
                    borderRadius: 8
                }, {
                    label: 'Pengeluaran',
                    data: <?= json_encode($monthlyData['pengeluaran']) ?>,
                    backgroundColor: '#ef4444',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } },
                scales: { y: { beginAtZero: true } }
            }
        });
    });
</script>

<?php
$content = ob_get_clean();
include dirname(__DIR__) . '/layouts/app.php';
?>