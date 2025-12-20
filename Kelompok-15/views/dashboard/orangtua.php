<?php
$title = 'Dashboard Orang Tua';
ob_start();
?>

<!-- Global Wrapper -->
<div class="w-full p-6 md:p-10 font-sans text-white">

    <!-- Welcome & Header -->
    <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between mb-10 gap-4">
        <div>
            <div class="inline-block bg-[#0C2642] px-4 py-2 rounded-lg mb-4 ml-2 border border-white/5">
                 <p class="text-[#EAF6FF] text-sm">Welcome, <span class="bg-gradient-to-r from-[#00B4FF] to-[#00FFBF] bg-clip-text text-transparent font-bold"><?= e($user['nama']) ?></span> !</p>
            </div>
            <p class="text-[#CDE2EF] text-lg ml-3 font-light">Monitor keuangan dan aktivitas anak anda</p>
        </div>
        
        <!-- Action Button: Download Report -->
        <a href="index.php?page=export&action=transfer_orangtua" 
           class="group flex items-center gap-3 bg-[#133D57] hover:bg-[#1C4E6E] border border-white/10 px-5 py-3 rounded-xl transition-all duration-300 hover:-translate-y-1">
            <div class="p-2 bg-[#00F29C]/10 rounded-lg group-hover:bg-[#00F29C]/20 transition-colors">
                <svg class="w-5 h-5 text-[#00F29C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <span class="font-medium text-[#EAF6FF]">Download Laporan</span>
        </a>
    </div>

    <!-- Exchange Rates Ticker -->
    <div class="bg-gradient-to-r from-[#0F2F46] to-[#133D57] rounded-xl p-1 mb-8 border border-white/5 shadow-lg relative overflow-hidden">
        <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-[#00C6FB] to-[#00F29C]"></div>
        <div class="flex flex-col md:flex-row items-center gap-6 p-4">
            <div class="flex items-center gap-3 text-[#B3C9D8] min-w-max">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                 <span class="font-medium uppercase tracking-wider text-xs">Kurs Hari Ini</span>
            </div>
            <div class="flex-1 w-full grid grid-cols-2 md:grid-cols-4 gap-4">
                 <?php foreach ($exchangeRates ?? [] as $currency => $rate): ?>
                    <div class="flex items-center justify-between bg-[#0C2642] px-4 py-2 rounded-lg border border-white/5">
                        <span class="text-[#00C6FB] font-bold text-sm">1 <?= $currency ?></span>
                        <span class="text-white font-mono text-sm"><?= format_rupiah($rate) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Main Section: Anak yang Terhubung -->
    <div class="bg-[#0F2F46] rounded-[2rem] shadow-2xl border border-white/5 p-6 md:p-10 mb-8 relative overflow-hidden">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-8 pb-6 border-b border-white/5">
            <div>
                 <h3 class="text-xl font-bold text-[#EAF6FF] tracking-wide flex items-center gap-3">
                    <span class="w-1.5 h-6 bg-[#22d3ee] rounded-full"></span>
                    Anak yang terhubung
                 </h3>
            </div>
            <a href="index.php?page=transfer"
                class="mt-4 md:mt-0 flex items-center gap-2 text-[#00C6FB] hover:text-[#00F29C] font-semibold transition-colors">
                <span>+ Hubungkan Anak Baru</span>
            </a>
        </div>

        <?php if (empty($linkedMahasiswa)): ?>
            <div class="text-center py-16 flex flex-col items-center justify-center rounded-2xl bg-[#0C2642]/50 border border-white/5 border-dashed">
                <div class="w-16 h-16 bg-[#133D57] rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-[#B3C9D8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                </div>
                <p class="text-[#CDE2EF] mb-4 text-lg">Belum ada anak yang terhubung</p>
                <a href="index.php?page=transfer" class="px-6 py-2 bg-gradient-to-r from-[#00C6FB] to-[#00F29C] text-[#051933] font-bold rounded-xl hover:shadow-lg hover:shadow-[#00C6FB]/20 transition-all">Hubungkan Sekarang</a>
            </div>
        <?php else: ?>
            <div class="space-y-6">
                <?php foreach ($childrenStats ?? [] as $child): 
                    $mhs = $child['mahasiswa'];
                    $stats = $child['stats'];
                    $status = $child['spendingStatus'];
                    $statusColor = match($status['status']) {
                        'hemat' => 'text-[#00F29C] bg-[#00F29C]/10 border-[#00F29C]/20',
                        'normal' => 'text-yellow-400 bg-yellow-400/10 border-yellow-400/20',
                        'boros' => 'text-rose-400 bg-rose-400/10 border-rose-400/20',
                        default => 'text-gray-400'
                    };
                    $statusEmoji = match($status['status']) { 'hemat' => '✨', 'normal' => '⚖️', 'boros' => '⚠️', default => '' };
                ?>
                
                <div class="bg-[#133D57] rounded-2xl p-6 border border-white/5 hover:border-[#22d3ee]/30 transition-all">
                    <div class="flex flex-col lg:flex-row gap-6">
                        
                        <!-- Profile Section -->
                        <div class="flex items-start gap-4 lg:w-1/4">
                            <div class="w-14 h-14 bg-[#0F2F46] rounded-2xl flex items-center justify-center border border-white/10 shadow-lg shrink-0">
                                <span class="font-bold text-[#22d3ee] text-xl"><?= strtoupper(substr($mhs['nama'], 0, 1)) ?></span>
                            </div>
                            <div>
                                <h4 class="font-bold text-white text-lg leading-tight mb-1"><?= e($mhs['nama']) ?></h4>
                                <p class="text-sm text-[#94a3b8]"><?= e($mhs['nim']) ?></p>
                                <p class="text-xs text-[#64748b] mt-1"><?= e($mhs['jurusan'] ?? 'Mahasiswa') ?></p>
                                
                                <div class="mt-3 inline-flex items-center gap-2 px-3 py-1 rounded-full border text-xs font-semibold <?= $statusColor ?>">
                                    <span><?= $statusEmoji ?> <?= ucfirst($status['status']) ?> (<?= $status['ratio'] ?>%)</span>
                                </div>
                            </div>
                        </div>

                        <!-- Stats Grid -->
                        <div class="flex-1 grid grid-cols-2 md:grid-cols-4 gap-3">
                            <div class="bg-[#0F2F46] p-4 rounded-xl border border-white/5">
                                <p class="text-[#94a3b8] text-xs uppercase tracking-wider mb-1">Saldo</p>
                                <p class="text-white font-bold text-lg"><?= format_rupiah($stats['saldo']) ?></p>
                            </div>
                            <div class="bg-[#0F2F46] p-4 rounded-xl border border-white/5">
                                <p class="text-[#94a3b8] text-xs uppercase tracking-wider mb-1">Masuk (Bulan Ini)</p>
                                <p class="text-[#00F29C] font-bold"><?= format_rupiah($stats['pemasukan_bulan_ini']) ?></p>
                            </div>
                            <div class="bg-[#0F2F46] p-4 rounded-xl border border-white/5">
                                <p class="text-[#94a3b8] text-xs uppercase tracking-wider mb-1">Keluar (Bulan Ini)</p>
                                <p class="text-rose-400 font-bold"><?= format_rupiah($stats['pengeluaran_bulan_ini']) ?></p>
                            </div>
                            <div class="bg-[#0F2F46] p-4 rounded-xl border border-white/5 flex flex-col justify-center items-center gap-2">
                                <p class="text-[#94a3b8] text-xs"><?= $stats['total_transaksi'] ?> Transaksi</p>
                                
                                <!-- Unlink Button -->
                                <form action="index.php?page=transfer&action=unlink" method="POST" onsubmit="return confirm('Yakin ingin melepas hubungan dengan anak ini?')" class="w-full">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="mahasiswa_id" value="<?= $mhs['id'] ?>">
                                    <button type="submit" class="w-full text-xs py-1.5 rounded bg-rose-500/10 text-rose-400 hover:bg-rose-500/20 transition-colors">
                                        Lepas Hubungan
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                    
                    <!-- Status Message Footnote -->
                    <?php if(!empty($status['message'])): ?>
                    <div class="mt-4 pt-4 border-t border-white/5">
                        <p class="text-sm text-[#94a3b8] italic">"<?= $status['message'] ?>"</p>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bottom Grids -->
    <div class="grid lg:grid-cols-2 gap-8">
        
        <!-- Quick Transfer Card -->
        <div class="bg-gradient-to-br from-[#133D57] to-[#0F2F46] rounded-[2rem] p-8 text-white shadow-2xl relative overflow-hidden border border-white/5">
            <!-- Decorative BG -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-[#00C6FB]/5 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none"></div>

            <h3 class="font-bold text-xl mb-2 text-[#EAF6FF] relative z-10">Kirim Saldo Cepat</h3>
            <p class="text-[#9FBFD1] text-sm mb-6 relative z-10">Transfer instan ke dompet anak</p>
            
            <?php if (!empty($linkedMahasiswa)): ?>
                <form action="index.php?page=transfer&action=send&redirect=dashboard" method="POST" class="space-y-4 relative z-10">
                    <?= csrf_field() ?>
                    
                    <!-- Select Anak -->
                    <div class="bg-[#0C2642] p-1 rounded-xl border border-white/10">
                        <select name="mahasiswa_id" required class="w-full bg-transparent text-white px-4 py-3 rounded-lg border-none focus:ring-0 cursor-pointer">
                            <?php foreach ($linkedMahasiswa as $mhs): ?>
                                <option value="<?= $mhs['id'] ?>" class="bg-[#0C2642]"><?= e($mhs['nama']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Input Grid -->
                    <div class="grid grid-cols-3 gap-3">
                        <div class="col-span-2">
                             <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#94a3b8] font-bold">Rp</span>
                                <input type="number" name="jumlah" id="jumlahInput" required min="0.01" step="0.01" placeholder="100.000"
                                class="w-full bg-[#0C2642] pl-12 pr-4 py-4 rounded-xl border border-white/10 text-white placeholder-white/20 focus:outline-none focus:border-[#00C6FB] transition-colors">
                             </div>
                        </div>
                        <div>
                            <select name="mata_uang" id="currencySelect" class="w-full h-full bg-[#0C2642] text-center rounded-xl border border-white/10 text-white focus:outline-none focus:border-[#00C6FB]">
                                <?php foreach ($currencies ?? ['IDR'=>'Rupiah'] as $cur => $name): ?>
                                    <option value="<?= $cur ?>" class="bg-[#0C2642]"><?= $cur ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <p id="convertedAmount" class="text-[#00F29C] text-sm text-center hidden font-medium bg-[#00F29C]/10 py-2 rounded-lg"></p>

                    <button type="submit" class="w-full bg-gradient-to-r from-[#00C6FB] to-[#00F29C] text-[#082235] font-bold py-4 rounded-xl hover:shadow-[0_0_20px_rgba(0,198,251,0.3)] transition-all transform hover:-translate-y-0.5">
                        Kirim Sekarang
                    </button>
                </form>
            <?php else: ?>
                <div class="bg-white/5 rounded-xl p-6 text-center border border-white/5 border-dashed">
                    <p class="text-[#94a3b8]">Silakan hubungkan anak terlebih dahulu untuk melakukan transfer.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- History Card -->
        <div class="bg-[#133D57] rounded-[2rem] shadow-xl p-8 border border-white/5 flex flex-col h-full">
            <h3 class="font-bold text-[#EAF6FF] text-xl mb-6">Riwayat Transfer</h3>

            <div class="flex-1 overflow-y-auto max-h-[400px] space-y-3 pr-2 custom-scrollbar">
                <?php if (empty($recentTransfer)): ?>
                    <div class="h-full flex flex-col items-center justify-center text-[#94a3b8]">
                        <svg class="w-12 h-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <p>Belum ada riwayat transfer</p>
                    </div>
                <?php else: ?>
                    <?php foreach (array_slice($recentTransfer, 0, 5) as $tf): ?>
                        <div class="flex items-center justify-between p-4 bg-[#0F2F46] rounded-2xl border border-white/5 hover:bg-[#163a52] transition-colors group">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-[#133D57] flex items-center justify-center text-[#00F29C] group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-[#EAF6FF] text-sm">Ke: <?= e($tf['mahasiswa_nama']) ?></p>
                                    <p class="text-xs text-[#94a3b8]"><?= format_tanggal($tf['created_at']) ?></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-[#00F29C]"><?= format_rupiah($tf['jumlah_idr']) ?></p>
                                <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded-full bg-[#0F2F46] text-[#00C6FB] border border-[#00C6FB]/30 tracking-wider">
                                    <?= e($tf['status']) ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

    </div>
    
    <!-- Report Table Section -->
    <?php if (!empty($childrenStats)): ?>
    <div class="mt-8 bg-[#133D57] rounded-[2rem] p-8 border border-white/5 shadow-xl">
        <h3 class="font-bold text-[#EAF6FF] text-xl mb-6 flex items-center gap-2">
            <span>📅</span> Laporan Bulanan
        </h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-[#0F2F46] text-[#94a3b8] uppercase tracking-wider text-xs">
                        <th class="px-6 py-4 text-left rounded-l-xl">Anak</th>
                        <?php foreach ($aggregatedMonthlyData['labels'] ?? [] as $label): ?>
                            <th class="px-6 py-4 text-center"><?= $label ?></th>
                        <?php endforeach; ?>
                        <th class="px-6 py-4 rounded-r-xl"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php foreach ($childrenStats as $child): ?>
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-bold text-white"><?= e($child['mahasiswa']['nama']) ?></p>
                            </td>
                            <?php foreach ($child['monthlyData']['pemasukan'] as $idx => $pemasukan): 
                                $pengeluaran = $child['monthlyData']['pengeluaran'][$idx] ?? 0;
                            ?>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex flex-col gap-1">
                                        <span class="text-[#00F29C] text-xs font-mono">+<?= format_rupiah($pemasukan) ?></span>
                                        <span class="text-rose-400 text-xs font-mono">-<?= format_rupiah($pengeluaran) ?></span>
                                    </div>
                                </td>
                            <?php endforeach; ?>
                            <td></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Chart Canvas -->
        <?php if (!empty($aggregatedMonthlyData['labels'])): ?>
        <div class="mt-8 p-6 bg-[#0F2F46] rounded-2xl border border-white/5">
             <canvas id="aggregatedChart" height="80"></canvas>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

</div>

<script>
    // Currency Logic
    document.getElementById('currencySelect')?.addEventListener('change', function () {
        const currency = this.value;
        const input = document.getElementById('jumlahInput');
        if (currency === 'IDR') {
            input.min = '1000';
            input.step = '1000';
            input.placeholder = '100000';
        } else {
            input.min = '0.01';
            input.step = '0.01';
            input.placeholder = '10';
        }
    });

    // Chart.js
    <?php if (!empty($aggregatedMonthlyData['labels'])): ?>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('aggregatedChart').getContext('2d');
        
        // Gradient for Green
        const gradGreen = ctx.createLinearGradient(0, 0, 0, 400);
        gradGreen.addColorStop(0, 'rgba(0, 242, 156, 0.5)');
        gradGreen.addColorStop(1, 'rgba(0, 242, 156, 0)');

        // Gradient for Red
        const gradRed = ctx.createLinearGradient(0, 0, 0, 400);
        gradRed.addColorStop(0, 'rgba(244, 63, 94, 0.5)');
        gradRed.addColorStop(1, 'rgba(244, 63, 94, 0)');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($aggregatedMonthlyData['labels']) ?>,
                datasets: [{
                    label: 'Pemasukan',
                    data: <?= json_encode($aggregatedMonthlyData['pemasukan']) ?>,
                    backgroundColor: '#00F29C',
                    borderRadius: 4,
                    barThickness: 20
                }, {
                    label: 'Pengeluaran',
                    data: <?= json_encode($aggregatedMonthlyData['pengeluaran']) ?>,
                    backgroundColor: '#F43F5E',
                    borderRadius: 4,
                    barThickness: 20
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: { color: '#B3C9D8' }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(255, 255, 255, 0.05)' },
                        ticks: { color: '#B3C9D8' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#B3C9D8' }
                    }
                }
            }
        });
    });
    <?php endif; ?>
</script>

<?php
$content = ob_get_clean();
include dirname(__DIR__) . '/layouts/app.php';
?>