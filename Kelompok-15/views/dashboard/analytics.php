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

        new Chart(document.getElementById('trendChart').getContext('2d'), {
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