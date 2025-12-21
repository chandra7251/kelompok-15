<?php
$title = 'Analytics';
ob_start();
?>

<div class="max-w-7xl mx-auto px-4 sm:px-8 py-6 md:py-10 space-y-6 md:space-y-8">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 md:mb-8">
        <div>
            <p class="text-[#B3C9D8] mt-2 text-sm md:text-base">Analisis pola keuangan Anda</p>
        </div>
        <div class="flex gap-3 w-full sm:w-auto">
            <a href="index.php?page=export&action=transaksi"
                class="flex-1 sm:flex-none justify-center px-4 md:px-5 py-2.5 rounded-xl bg-[#0F2942] border border-[#00F29C]/30 text-[#00F29C] font-semibold hover:bg-[#00F29C]/10 transition-all flex items-center gap-2 text-sm md:text-base">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Download CSV
            </a>
            <a href="index.php?page=export&action=laporan"
                class="flex-1 sm:flex-none justify-center px-4 md:px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#00C6FB] to-[#00F29C] text-[#051933] font-bold hover:shadow-[0_0_20px_rgba(0,198,251,0.3)] transition-all flex items-center gap-2 text-sm md:text-base">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Laporan
            </a>
        </div>
    </div>


    <div class="bg-[#0F2942] rounded-2xl p-6 md:p-8 border border-white/5 shadow-xl relative overflow-hidden">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6 md:gap-8 relative z-10">
            <div class="flex items-center gap-4 md:gap-6">

                <div class="w-12 h-12 md:w-16 md:h-16 rounded-2xl flex items-center justify-center text-2xl md:text-3xl font-bold shadow-lg
                    <?php if ($spendingStatus['status'] === 'hemat'): ?> bg-green-500/10 text-green-400 ring-1 ring-green-500/50
                    <?php elseif ($spendingStatus['status'] === 'normal'): ?> bg-yellow-500/10 text-yellow-400 ring-1 ring-yellow-500/50
                    <?php else: ?> bg-red-500/10 text-red-400 ring-1 ring-red-500/50 <?php endif; ?>">
                    <?= strtoupper(substr($spendingStatus['status'], 0, 1)) ?>
                </div>
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold capitalize mb-1
                        <?php if ($spendingStatus['status'] === 'hemat'): ?> text-green-400
                        <?php elseif ($spendingStatus['status'] === 'normal'): ?> text-yellow-400
                        <?php else: ?> text-red-400 <?php endif; ?>">
                        <?= e($spendingStatus['status']) ?>
                    </h2>
                    <p class="text-[#B3C9D8] text-base md:text-lg"><?= e($spendingStatus['message']) ?></p>
                </div>
            </div>


            <div
                class="bg-[#051933] px-6 md:px-8 py-4 md:py-5 rounded-2xl border border-white/5 shadow-inner w-full md:w-auto md:min-w-[200px] text-center">
                <p class="text-[#B3C9D8] text-xs md:text-sm font-medium mb-1">Rasio Pengeluaran</p>
                <p class="text-3xl md:text-4xl font-bold text-white tracking-tight"><?= $spendingStatus['ratio'] ?>%</p>
            </div>
        </div>
    </div>


    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">

        <div
            class="bg-gradient-to-br from-emerald-900/50 to-emerald-800/20 rounded-2xl p-5 md:p-6 border border-emerald-500/20 shadow-lg relative overflow-hidden group">
            <div
                class="absolute -right-6 -top-6 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl group-hover:bg-emerald-500/20 transition-all duration-500">
            </div>
            <div class="flex items-center gap-4 mb-4 relative z-10">
                <div
                    class="w-10 h-10 md:w-12 md:h-12 rounded-xl bg-emerald-500/20 flex items-center justify-center border border-emerald-500/30">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-emerald-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 11l5-5m0 0l5 5m-5-5v12" />
                    </svg>
                </div>
                <div>
                    <p class="text-emerald-100/70 text-xs md:text-sm font-medium">Pemasukan Bulan Ini</p>
                    <p class="text-xl md:text-2xl font-bold text-white mt-1">
                        <?= format_rupiah($spendingStatus['pemasukan']) ?>
                    </p>
                </div>
            </div>
        </div>


        <div
            class="bg-gradient-to-br from-rose-900/50 to-rose-800/20 rounded-2xl p-5 md:p-6 border border-rose-500/20 shadow-lg relative overflow-hidden group">
            <div
                class="absolute -right-6 -top-6 w-32 h-32 bg-rose-500/10 rounded-full blur-3xl group-hover:bg-rose-500/20 transition-all duration-500">
            </div>
            <div class="flex items-center gap-4 mb-4 relative z-10">
                <div
                    class="w-10 h-10 md:w-12 md:h-12 rounded-xl bg-rose-500/20 flex items-center justify-center border border-rose-500/30">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-rose-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                    </svg>
                </div>
                <div>
                    <p class="text-rose-100/70 text-xs md:text-sm font-medium">Pengeluaran Bulan Ini</p>
                    <p class="text-xl md:text-2xl font-bold text-white mt-1">
                        <?= format_rupiah($spendingStatus['pengeluaran']) ?>
                    </p>
                </div>
            </div>
        </div>


        <div
            class="bg-gradient-to-br from-indigo-900/50 to-indigo-800/20 rounded-2xl p-5 md:p-6 border border-indigo-500/20 shadow-lg relative overflow-hidden group">
            <div
                class="absolute -right-6 -top-6 w-32 h-32 bg-indigo-500/10 rounded-full blur-3xl group-hover:bg-indigo-500/20 transition-all duration-500">
            </div>
            <div class="flex items-center gap-4 mb-4 relative z-10">
                <div
                    class="w-10 h-10 md:w-12 md:h-12 rounded-xl bg-indigo-500/20 flex items-center justify-center border border-indigo-500/30">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-indigo-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-indigo-100/70 text-xs md:text-sm font-medium">Selisih (Net Balance)</p>
                    <p class="text-xl md:text-2xl font-bold text-white mt-1">
                        <?= format_rupiah($spendingStatus['selisih']) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>


    <div class="grid lg:grid-cols-12 gap-6 md:gap-8">

        <div class="lg:col-span-8 space-y-6 md:space-y-8">

            <div class="bg-[#0F2942] rounded-2xl shadow-xl border border-white/5 overflow-hidden">
                <div class="p-4 md:p-6 border-b border-white/5 flex justify-between items-center">
                    <h3 class="font-bold text-base md:text-lg text-white flex items-center gap-2">
                        <span class="w-1 h-5 bg-[#00F29C] rounded-full"></span>
                        Detail Pengeluaran
                    </h3>
                    <span class="text-[10px] md:text-xs text-[#B3C9D8] bg-white/5 px-2 md:px-3 py-1 rounded-full">per
                        Kategori</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-xs md:text-sm text-left">
                        <thead class="bg-[#0A2238] text-[#B3C9D8] uppercase text-[10px] md:text-xs tracking-wider">
                            <tr>
                                <th class="py-3 md:py-4 px-4 md:px-6 font-semibold">Kategori</th>
                                <th class="text-right py-3 md:py-4 px-4 md:px-6 font-semibold">Jumlah</th>
                                <th class="text-right py-3 md:py-4 px-4 md:px-6 font-semibold">%</th>
                                <th class="text-center py-3 md:py-4 px-4 md:px-6 font-semibold">Skor</th>
                                <th class="text-center py-3 md:py-4 px-4 md:px-6 font-semibold">Bobot</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            <?php foreach ($detailedCalc['categories'] as $cat): ?>
                                <tr class="hover:bg-white/[0.02] transition-colors">
                                    <td class="py-3 md:py-4 px-4 md:px-6 font-medium text-white"><?= e($cat['nama']) ?></td>
                                    <td class="py-3 md:py-4 px-4 md:px-6 text-right text-rose-400 font-medium">
                                        <?= format_rupiah($cat['jumlah']) ?>
                                    </td>
                                    <td class="py-3 md:py-4 px-4 md:px-6 text-right text-[#B3C9D8]">
                                        <?= $cat['persentase'] ?>%
                                    </td>
                                    <td class="py-3 md:py-4 px-4 md:px-6 text-center">
                                        <span class="px-2 md:px-2.5 py-0.5 md:py-1 rounded-lg text-[10px] md:text-xs font-bold border
                                            <?php if ($cat['skor'] == 0): ?>bg-green-500/10 text-green-400 border-green-500/20
                                            <?php elseif ($cat['skor'] == 1): ?>bg-blue-500/10 text-blue-400 border-blue-500/20
                                            <?php elseif ($cat['skor'] == 2): ?>bg-yellow-500/10 text-yellow-400 border-yellow-500/20
                                            <?php else: ?>bg-red-500/10 text-red-400 border-red-500/20<?php endif; ?>">
                                            <?= $cat['skor'] ?>
                                        </span>
                                    </td>
                                    <td class="py-3 md:py-4 px-4 md:px-6 text-center text-[#B3C9D8]/50">
                                        <?= $cat['bobot'] > 0 ? ($cat['bobot'] * 100) . '%' : '-' ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="bg-indigo-500/5">
                                <td class="py-3 md:py-4 px-4 md:px-6 font-medium text-indigo-300">💰 Tabungan (Bonus)
                                </td>
                                <td class="py-3 md:py-4 px-4 md:px-6 text-right text-green-400 font-bold">
                                    <?= format_rupiah($detailedCalc['tabungan']) ?>
                                </td>
                                <td class="py-3 md:py-4 px-4 md:px-6 text-right text-indigo-300">
                                    <?= $detailedCalc['tabungan_persentase'] ?>%
                                </td>
                                <td class="py-3 md:py-4 px-4 md:px-6 text-center">
                                    <span
                                        class="px-2 md:px-2.5 py-0.5 md:py-1 rounded-lg text-[10px] md:text-xs font-bold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">
                                        -<?= $detailedCalc['tabungan_skor'] ?>
                                    </span>
                                </td>
                                <td class="py-3 md:py-4 px-4 md:px-6 text-center text-[#B3C9D8]/50">-10%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="px-4 md:px-6 py-3 md:py-4 bg-[#0A2238] border-t border-white/5">
                    <p class="text-[10px] md:text-xs text-[#B3C9D8]/60">
                        <strong>Cara Hitung:</strong> Skor Komposit = Σ(Skor × Bobot) - (Skor Tabungan × 10%)<br>
                        <strong>Status:</strong> ≤0.9 = Hemat, 0.9-1.8 = Normal, >1.8 = Boros
                    </p>
                </div>
            </div>


            <div class="bg-[#0F2942] rounded-2xl shadow-xl border border-white/5 p-4 md:p-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 md:mb-6 gap-4">
                    <h3 class="font-bold text-base md:text-lg text-white flex items-center gap-2">
                        <span class="w-1 h-5 bg-[#00C6FB] rounded-full"></span>
                        Tren Keuangan
                    </h3>
                    <div class="flex bg-[#0A2238] p-1 rounded-xl border border-white/5 overflow-x-auto max-w-full">
                        <a href="index.php?page=analytics&period=weekly"
                            class="px-3 md:px-4 py-1.5 rounded-lg text-xs font-bold transition-all whitespace-nowrap <?= $currentPeriod === 'weekly' ? 'bg-[#00C6FB] text-[#051933]' : 'text-[#B3C9D8] hover:text-white' ?>">
                            Mingguan
                        </a>
                        <a href="index.php?page=analytics&period=monthly"
                            class="px-3 md:px-4 py-1.5 rounded-lg text-xs font-bold transition-all whitespace-nowrap <?= $currentPeriod === 'monthly' ? 'bg-[#00C6FB] text-[#051933]' : 'text-[#B3C9D8] hover:text-white' ?>">
                            Bulanan
                        </a>
                        <a href="index.php?page=analytics&period=yearly"
                            class="px-3 md:px-4 py-1.5 rounded-lg text-xs font-bold transition-all whitespace-nowrap <?= $currentPeriod === 'yearly' ? 'bg-[#00C6FB] text-[#051933]' : 'text-[#B3C9D8] hover:text-white' ?>">
                            Tahunan
                        </a>
                    </div>
                </div>
                <div class="h-[250px] md:h-[300px] w-full">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
        </div>


        <div class="lg:col-span-4 space-y-6 md:space-y-8">

            <div
                class="bg-gradient-to-br from-[#0A2238] to-[#0F2942] rounded-2xl p-6 border border-white/5 shadow-xl text-center relative overflow-hidden">
                <div class="relative z-10">
                    <p class="text-[#B3C9D8] text-xs md:text-sm font-medium mb-2 uppercase tracking-wider">Skor
                        Kesehatan</p>
                    <div
                        class="text-5xl md:text-6xl font-[900] bg-gradient-to-r from-[#00C6FB] to-[#00F29C] bg-clip-text text-transparent mb-2">
                        <?= $detailedCalc['skor_komposit'] ?>
                    </div>
                    <div
                        class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/5 border border-white/10 mb-4">
                        <span class="w-2 h-2 rounded-full 
                             <?php if ($detailedCalc['skor_komposit'] <= 0.9): ?> bg-green-400
                             <?php elseif ($detailedCalc['skor_komposit'] <= 1.8): ?> bg-yellow-400
                             <?php else: ?> bg-red-400 <?php endif; ?>"></span>
                        <span
                            class="text-[10px] md:text-xs font-bold text-white uppercase"><?= e($detailedCalc['status_akhir']) ?></span>
                    </div>
                    <p class="text-[10px] md:text-xs text-[#B3C9D8]/60 max-w-[200px] mx-auto leading-relaxed">
                        0 = Sangat Hemat<br>3 = Sangat Boros
                    </p>
                </div>
            </div>


            <div class="bg-[#0F2942] rounded-2xl p-4 md:p-6 border border-white/5 shadow-xl">
                <h3 class="font-bold text-base md:text-lg text-white mb-4 md:mb-6 text-center">Distribusi Pengeluaran
                </h3>
                <div class="relative h-[200px] md:h-[250px] flex items-center justify-center">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>


            <div
                class="bg-gradient-to-br from-purple-900/60 to-indigo-900/60 rounded-2xl p-6 border border-purple-500/20 shadow-xl">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-purple-200/70 text-sm font-medium mb-1">Total Tabungan</p>
                        <p class="text-2xl font-bold text-white"><?= format_rupiah($tabungan['total']) ?></p>
                    </div>
                    <div class="p-3 rounded-xl bg-purple-500/20 text-purple-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-white/10 flex justify-between items-center text-xs">
                    <span class="text-[#B3C9D8]">Bulan ini</span>
                    <span class="text-[#00F29C] font-bold">+<?= format_rupiah($tabungan['bulan_ini']) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        Chart.defaults.color = '#B3C9D8';
        Chart.defaults.borderColor = 'rgba(255, 255, 255, 0.05)';
        Chart.defaults.font.family = "'Inter', sans-serif";

        new Chart(document.getElementById('trendChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: <?= json_encode($trendData['labels']) ?>,
                datasets: [{
                    label: 'Pemasukan',
                    data: <?= json_encode($trendData['pemasukan']) ?>,
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

        new Chart(document.getElementById('categoryChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: <?= json_encode($categoryChart['labels']) ?>,
                datasets: [{
                    data: <?= json_encode($categoryChart['data']) ?>,
                    backgroundColor: [
                        '#ef4444', '#f97316', '#eab308', '#22c55e',
                        '#06b6d4', '#3b82f6', '#8b5cf6', '#ec4899'
                    ],
                    borderColor: '#0F2942',
                    borderWidth: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                }
            }
        });
    });
</script>

<?php
$content = ob_get_clean();
include dirname(__DIR__) . '/layouts/app.php';
?>