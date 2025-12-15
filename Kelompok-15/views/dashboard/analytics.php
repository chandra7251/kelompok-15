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

<!-- Status Akhir Card -->
<div class="bg-white rounded-lg shadow-sm p-6 mb-6">
    <div class="flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold
                <?php if ($detailedCalc['status_akhir'] === 'hemat'): ?> bg-green-100 text-green-600
                <?php elseif ($detailedCalc['status_akhir'] === 'normal'): ?> bg-yellow-100 text-yellow-600
                <?php else: ?> bg-red-100 text-red-600 <?php endif; ?>">
                <?= strtoupper(substr($detailedCalc['status_akhir'], 0, 1)) ?>
            </div>
            <div>
                <h2 class="text-2xl font-bold capitalize
                    <?php if ($detailedCalc['status_akhir'] === 'hemat'): ?> text-green-600
                    <?php elseif ($detailedCalc['status_akhir'] === 'normal'): ?> text-yellow-600
                    <?php else: ?> text-red-600 <?php endif; ?>">
                    <?= e($detailedCalc['status_akhir']) ?>
                </h2>
                <p class="text-gray-600">Status Keuangan Bulan Ini</p>
            </div>
        </div>
        <div class="text-center md:text-right">
            <p class="text-gray-500">Skor Komposit</p>
            <p class="text-3xl font-bold text-gray-800"><?= $detailedCalc['skor_komposit'] ?></p>
            <p class="text-xs text-gray-400">0 = Sangat Hemat, 3 = Sangat Boros</p>
        </div>
    </div>
</div>

<!-- Ringkasan Keuangan -->
<div class="grid md:grid-cols-4 gap-4 mb-6">
    <div class="bg-green-500 rounded-lg p-4 text-white">
        <p class="text-green-100 text-sm">Pemasukan</p>
        <p class="text-xl font-bold"><?= format_rupiah($detailedCalc['pemasukan']) ?></p>
    </div>
    <div class="bg-red-500 rounded-lg p-4 text-white">
        <p class="text-red-100 text-sm">Pengeluaran</p>
        <p class="text-xl font-bold"><?= format_rupiah($detailedCalc['pengeluaran']) ?></p>
    </div>
    <div class="bg-indigo-500 rounded-lg p-4 text-white">
        <p class="text-indigo-100 text-sm">Net Balance</p>
        <p class="text-xl font-bold"><?= format_rupiah($detailedCalc['selisih']) ?></p>
    </div>
    <div class="bg-purple-500 rounded-lg p-4 text-white">
        <p class="text-purple-100 text-sm">Tabungan Bulan Ini</p>
        <p class="text-xl font-bold"><?= format_rupiah($detailedCalc['tabungan']) ?></p>
        <p class="text-purple-100 text-xs"><?= $detailedCalc['tabungan_persentase'] ?>% dari pemasukan</p>
    </div>
</div>

<!-- Detail Perhitungan per Kategori -->
<div class="grid lg:grid-cols-2 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="font-semibold text-gray-800 mb-4">📊 Detail Pengeluaran per Kategori</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b bg-gray-50">
                        <th class="text-left py-2 px-3">Kategori</th>
                        <th class="text-right py-2 px-3">Jumlah</th>
                        <th class="text-right py-2 px-3">%</th>
                        <th class="text-center py-2 px-3">Skor</th>
                        <th class="text-center py-2 px-3">Bobot</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detailedCalc['categories'] as $cat): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-3 font-medium"><?= e($cat['nama']) ?></td>
                            <td class="py-2 px-3 text-right text-red-600"><?= format_rupiah($cat['jumlah']) ?></td>
                            <td class="py-2 px-3 text-right"><?= $cat['persentase'] ?>%</td>
                            <td class="py-2 px-3 text-center">
                                <span class="px-2 py-1 rounded-full text-xs font-bold
                                    <?php if ($cat['skor'] == 0): ?>bg-green-100 text-green-700
                                    <?php elseif ($cat['skor'] == 1): ?>bg-blue-100 text-blue-700
                                    <?php elseif ($cat['skor'] == 2): ?>bg-yellow-100 text-yellow-700
                                    <?php else: ?>bg-red-100 text-red-700<?php endif; ?>">
                                    <?= $cat['skor'] ?>
                                </span>
                            </td>
                            <td class="py-2 px-3 text-center text-gray-500">
                                <?= $cat['bobot'] > 0 ? ($cat['bobot'] * 100) . '%' : '-' ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="bg-purple-50 font-semibold">
                        <td class="py-2 px-3">💰 Tabungan (Bonus)</td>
                        <td class="py-2 px-3 text-right text-green-600"><?= format_rupiah($detailedCalc['tabungan']) ?>
                        </td>
                        <td class="py-2 px-3 text-right"><?= $detailedCalc['tabungan_persentase'] ?>%</td>
                        <td class="py-2 px-3 text-center">
                            <span class="px-2 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-700">
                                -<?= $detailedCalc['tabungan_skor'] ?>
                            </span>
                        </td>
                        <td class="py-2 px-3 text-center text-gray-500">-10%</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-4 p-3 bg-gray-50 rounded-lg">
            <p class="text-xs text-gray-600">
                <strong>Cara Hitung:</strong> Skor Komposit = Σ(Skor × Bobot) - (Skor Tabungan × 10%)<br>
                <strong>Status:</strong> ≤0.9 = Hemat, 0.9-1.8 = Normal, >1.8 = Boros
            </p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="font-semibold text-gray-800 mb-4">🍩 Distribusi Pengeluaran</h3>
        <canvas id="categoryChart" height="200"></canvas>
    </div>
</div>

<!-- Tabungan Summary -->
<div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-lg p-6 mb-6 text-white">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold flex items-center gap-2">
                💰 Total Tabungan Anda
            </h3>
            <p class="text-purple-100 text-sm">Akumulasi tabungan sejak pertama kali</p>
        </div>
        <div class="text-right">
            <p class="text-3xl font-bold"><?= format_rupiah($tabungan['total']) ?></p>
            <p class="text-purple-100 text-sm">Bulan ini: <?= format_rupiah($tabungan['bulan_ini']) ?></p>
        </div>
    </div>
</div>

<!-- Trend Chart -->
<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
        <h3 class="font-semibold text-gray-800">📈 Tren Keuangan</h3>
        <div class="flex gap-2">
            <a href="index.php?page=analytics&period=weekly"
                class="px-4 py-2 rounded-lg text-sm font-medium transition-all <?= $currentPeriod === 'weekly' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?>">
                Mingguan
            </a>
            <a href="index.php?page=analytics&period=monthly"
                class="px-4 py-2 rounded-lg text-sm font-medium transition-all <?= $currentPeriod === 'monthly' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?>">
                Bulanan
            </a>
            <a href="index.php?page=analytics&period=yearly"
                class="px-4 py-2 rounded-lg text-sm font-medium transition-all <?= $currentPeriod === 'yearly' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?>">
                Tahunan
            </a>
        </div>
    </div>
    <canvas id="trendChart" height="100"></canvas>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Trend Chart
        new Chart(document.getElementById('trendChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: <?= json_encode($trendData['labels']) ?>,
                datasets: [{
                    label: 'Pemasukan',
                    data: <?= json_encode($trendData['pemasukan']) ?>,
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    fill: true,
                    tension: 0.4
                }, {
                    label: 'Pengeluaran',
                    data: <?= json_encode($trendData['pengeluaran']) ?>,
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

        // Category Doughnut Chart
        new Chart(document.getElementById('categoryChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: <?= json_encode($categoryChart['labels']) ?>,
                datasets: [{
                    data: <?= json_encode($categoryChart['data']) ?>,
                    backgroundColor: [
                        '#ef4444', '#f97316', '#eab308', '#22c55e',
                        '#06b6d4', '#3b82f6', '#8b5cf6', '#ec4899'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'right' }
                }
            }
        });
    });
</script>

<?php
$content = ob_get_clean();
include dirname(__DIR__) . '/layouts/app.php';
?>