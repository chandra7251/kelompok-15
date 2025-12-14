<?php
$title = 'Analytics';
ob_start();
?>

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Analytics Keuangan</h1>
        <p class="text-gray-500">Analisis pola keuangan Anda</p>
    </div>
    <div class="flex gap-2">
        <a href="index.php?page=export&action=transaksi"
            class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700">Download CSV</a>
        <a href="index.php?page=export&action=laporan"
            class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700">Laporan Bulanan</a>
    </div>
</div>

<div class="bg-white rounded-lg shadow-sm p-6 mb-6">
    <div class="flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold
                <?php if ($spendingStatus['status'] === 'hemat'): ?> bg-green-100 text-green-600
                <?php elseif ($spendingStatus['status'] === 'normal'): ?> bg-yellow-100 text-yellow-600
                <?php else: ?> bg-red-100 text-red-600 <?php endif; ?>">
                <?= strtoupper(substr($spendingStatus['status'], 0, 1)) ?>
            </div>
            <div>
                <h2 class="text-2xl font-bold capitalize
                    <?php if ($spendingStatus['status'] === 'hemat'): ?> text-green-600
                    <?php elseif ($spendingStatus['status'] === 'normal'): ?> text-yellow-600
                    <?php else: ?> text-red-600 <?php endif; ?>">
                    <?= e($spendingStatus['status']) ?>
                </h2>
                <p class="text-gray-600"><?= e($spendingStatus['message']) ?></p>
            </div>
        </div>
        <div class="text-center md:text-right">
            <p class="text-gray-500">Rasio Pengeluaran</p>
            <p class="text-3xl font-bold text-gray-800"><?= $spendingStatus['ratio'] ?>%</p>
        </div>
    </div>
</div>

<div class="grid md:grid-cols-3 gap-4 mb-6">
    <div class="bg-green-500 rounded-lg p-4 text-white">
        <p class="text-green-100 text-sm">Pemasukan Bulan Ini</p>
        <p class="text-2xl font-bold"><?= format_rupiah($spendingStatus['pemasukan']) ?></p>
    </div>
    <div class="bg-red-500 rounded-lg p-4 text-white">
        <p class="text-red-100 text-sm">Pengeluaran Bulan Ini</p>
        <p class="text-2xl font-bold"><?= format_rupiah($spendingStatus['pengeluaran']) ?></p>
    </div>
    <div class="bg-indigo-500 rounded-lg p-4 text-white">
        <p class="text-indigo-100 text-sm">Selisih</p>
        <p class="text-2xl font-bold"><?= format_rupiah($spendingStatus['selisih']) ?></p>
    </div>
</div>

<div class="bg-white rounded-lg shadow-sm p-6">
    <h3 class="font-semibold text-gray-800 mb-4">Tren 6 Bulan Terakhir</h3>
    <canvas id="trendChart" height="100"></canvas>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Chart(document.getElementById('trendChart').getContext('2d'), {
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