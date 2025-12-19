<?php
$title = 'Analytics';
ob_start();
?>

<div class="max-w-7xl mx-auto px-6 sm:px-8 py-10 space-y-8">
    <!-- Header & Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-[#00C6FB] to-[#00F29C] bg-clip-text text-transparent">Analytics Keuangan</h1>
            <p class="text-[#B3C9D8] mt-2">Analisis pola keuangan Anda</p>
        </div>
        <div class="flex gap-3">
            <a href="index.php?page=export&action=transaksi"
                class="px-5 py-2.5 rounded-xl bg-[#0F2942] border border-[#00F29C]/30 text-[#00F29C] font-semibold hover:bg-[#00F29C]/10 transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Download CSV
            </a>
            <a href="index.php?page=export&action=laporan"
                class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#00C6FB] to-[#00F29C] text-[#051933] font-bold hover:shadow-[0_0_20px_rgba(0,198,251,0.3)] transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Laporan Bulanan
            </a>
        </div>
    </div>

    <!-- Spending Status Card -->
    <div class="bg-[#0F2942] rounded-2xl p-8 border border-white/5 shadow-xl relative overflow-hidden">
        
        <div class="flex flex-col md:flex-row items-center justify-between gap-8 relative z-10">
            <div class="flex items-center gap-6">
                <!-- Status Icon with Ring -->
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl font-bold shadow-lg
                    <?php if ($spendingStatus['status'] === 'hemat'): ?> bg-green-500/10 text-green-400 ring-1 ring-green-500/50
                    <?php elseif ($spendingStatus['status'] === 'normal'): ?> bg-yellow-500/10 text-yellow-400 ring-1 ring-yellow-500/50
                    <?php else: ?> bg-red-500/10 text-red-400 ring-1 ring-red-500/50 <?php endif; ?>">
                    <?= strtoupper(substr($spendingStatus['status'], 0, 1)) ?>
                </div>
                <div>
                    <h2 class="text-3xl font-bold capitalize mb-1
                        <?php if ($spendingStatus['status'] === 'hemat'): ?> text-green-400
                        <?php elseif ($spendingStatus['status'] === 'normal'): ?> text-yellow-400
                        <?php else: ?> text-red-400 <?php endif; ?>">
                        <?= e($spendingStatus['status']) ?>
                    </h2>
                    <p class="text-[#B3C9D8] text-lg"><?= e($spendingStatus['message']) ?></p>
                </div>
            </div>

            <!-- Rasio Box -->
            <div class="bg-[#051933] px-8 py-5 rounded-2xl border border-white/5 shadow-inner min-w-[200px] text-center">
                <p class="text-[#B3C9D8] text-sm font-medium mb-1">Rasio Pengeluaran</p>
                <p class="text-4xl font-bold text-white tracking-tight"><?= $spendingStatus['ratio'] ?>%</p>
            </div>
        </div>
    </div>

    <!-- Summary Cards Grid -->
    <div class="grid md:grid-cols-3 gap-6">
        <!-- Pemasukan -->
        <div class="bg-gradient-to-br from-emerald-900/50 to-emerald-800/20 rounded-2xl p-6 border border-emerald-500/20 shadow-lg">
            <div class="flex items-center gap-4 mb-3">
                 <div class="w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                 </div>
                 <p class="text-emerald-100/80 font-medium">Pemasukan Bulan Ini</p>
            </div>
            <p class="text-3xl font-bold text-white"><?= format_rupiah($spendingStatus['pemasukan']) ?></p>
        </div>

        <!-- Pengeluaran -->
        <div class="bg-gradient-to-br from-rose-900/50 to-rose-800/20 rounded-2xl p-6 border border-rose-500/20 shadow-lg">
            <div class="flex items-center gap-4 mb-3">
                 <div class="w-10 h-10 rounded-full bg-rose-500/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                 </div>
                 <p class="text-rose-100/80 font-medium">Pengeluaran Bulan Ini</p>
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
            <p class="text-3xl font-bold text-white"><?= format_rupiah($spendingStatus['pengeluaran']) ?></p>
        </div>

        <!-- Selisih -->
        <div class="bg-gradient-to-br from-indigo-900/50 to-indigo-800/20 rounded-2xl p-6 border border-indigo-500/20 shadow-lg">
            <div class="flex items-center gap-4 mb-3">
                 <div class="w-10 h-10 rounded-full bg-indigo-500/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                 </div>
                 <p class="text-indigo-100/80 font-medium">Selisih</p>
            </div>
            <p class="text-3xl font-bold text-white"><?= format_rupiah($spendingStatus['selisih']) ?></p>
        <div class="text-center md:text-right">
            <p class="text-gray-500">Skor Komposit</p>
            <p class="text-3xl font-bold text-gray-800"><?= $detailedCalc['skor_komposit'] ?></p>
            <p class="text-xs text-gray-400">0 = Sangat Hemat, 3 = Sangat Boros</p>
        </div>
    </div>

    <!-- Trend Chart Card -->
    <div class="bg-[#0F2942] rounded-2xl p-6 border border-white/5 shadow-xl relative overflow-hidden group">
         <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
            <svg class="w-16 h-16 text-[#00C6FB]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
        </div>
        <h3 class="font-bold text-white text-lg mb-6 flex items-center gap-2">
            <span class="w-1 h-6 bg-[#00C6FB] rounded-full"></span>
            Tren 6 Bulan Terakhir
        </h3>
        <div class="relative z-10">
            <canvas id="trendChart" height="120"></canvas>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        Chart.defaults.color = '#B3C9D8';
        Chart.defaults.borderColor = 'rgba(255, 255, 255, 0.1)';
        Chart.defaults.font.family = "'Inter', sans-serif";

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
                    data: <?= json_encode($monthlyData['pemasukan']) ?>,
                    borderColor: '#00F29C',
                    backgroundColor: 'rgba(0, 242, 156, 0.1)',
                    data: <?= json_encode($trendData['pemasukan']) ?>,
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#00F29C',
                    pointBorderColor: '#0F2942',
                    pointBorderWidth: 2,
                    pointHoverRadius: 6
                }, {
                    label: 'Pengeluaran',
                    data: <?= json_encode($trendData['pengeluaran']) ?>,
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
                    y: { 
                        beginAtZero: true,
                        grid: { color: 'rgba(255, 255, 255, 0.05)' }
                    },
                    x: { grid: { display: false } }
                }
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