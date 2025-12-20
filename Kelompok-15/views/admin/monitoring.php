<?php
$title = 'Monitoring Sistem';
ob_start();
?>

<div class="py-8 px-6">
    <div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-[#B3C9D8]">Pantau semua aktivitas transaksi dan transfer</p>
        </div>
        <a href="index.php?page=dashboard" class="text-[#00C6FB] hover:text-[#00F29C] text-sm font-medium transition-colors">← Kembali
            ke Dashboard</a>
    </div>
</div>

<!-- Status Trend Chart -->
<div class="bg-[#16304d] border border-white/5 rounded-2xl shadow-lg p-6 mb-6">
    <h3 class="font-bold text-white mb-4 flex items-center gap-2">
        <span class="w-1 h-6 bg-gradient-to-b from-[#00C6FB] to-[#00F29C] rounded-full"></span>
        Tren Status Mahasiswa (6 Bulan Terakhir)
    </h3>
    <canvas id="statusTrendChart" height="100"></canvas>
</div>

<div class="grid lg:grid-cols-2 gap-6">
    <!-- Transaksi Terbaru -->
    <div class="bg-[#16304d] border border-white/5 rounded-2xl shadow-lg p-6">
        <h3 class="font-bold text-white mb-4 flex items-center gap-2">
            <span class="w-1 h-6 bg-gradient-to-b from-[#00C6FB] to-[#00F29C] rounded-full"></span>
            Transaksi Terbaru (50)
        </h3>
        <div class="overflow-x-auto max-h-96 overflow-y-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50/0 sticky top-0 backdrop-blur-md">
                    <tr class="text-[#B3C9D8] border-b border-white/5">
                        <th class="text-left py-2 px-3 font-medium">Mahasiswa</th>
                        <th class="text-left py-2 px-3 font-medium">Kategori</th>
                        <th class="text-left py-2 px-3 font-medium">Tipe</th>
                        <th class="text-right py-2 px-3 font-medium">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allTransaksi as $t): ?>
                        <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                            <td class="py-3 px-3">
                                <p class="font-medium text-white"><?= e($t['mahasiswa_nama']) ?></p>
                                <p class="text-xs text-[#B3C9D8]"><?= e($t['nim']) ?></p>
                            </td>
                            <td class="py-3 px-3 text-[#B3C9D8]"><?= e($t['kategori_nama']) ?></td>
                            <td class="py-3 px-3">
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-medium border
                                    <?= $t['tipe'] === 'pemasukan' ? 'bg-[#00F29C]/20 text-[#00F29C] border-[#00F29C]/30' : 'bg-rose-500/20 text-rose-300 border-rose-500/30' ?>">
                                    <?= e($t['tipe']) ?>
                                </span>
                            </td>
                            <td
                                class="py-3 px-3 text-right font-medium <?= $t['tipe'] === 'pemasukan' ? 'text-[#00F29C]' : 'text-red-400' ?>">
                                <?= format_rupiah($t['jumlah_idr']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Transfer Terbaru -->
    <div class="bg-[#16304d] border border-white/5 rounded-2xl shadow-lg p-6">
        <h3 class="font-bold text-white mb-4 flex items-center gap-2">
            <span class="w-1 h-6 bg-gradient-to-b from-[#00C6FB] to-[#00F29C] rounded-full"></span>
            Riwayat Transfer (50)
        </h3>
        <div class="overflow-x-auto max-h-96 overflow-y-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50/0 sticky top-0 backdrop-blur-md">
                    <tr class="text-[#B3C9D8] border-b border-white/5">
                        <th class="text-left py-2 px-3 font-medium">Dari</th>
                        <th class="text-left py-2 px-3 font-medium">Ke</th>
                        <th class="text-right py-2 px-3 font-medium">Jumlah</th>
                        <th class="text-center py-2 px-3 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allTransfer as $tf): ?>
                        <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                            <td class="py-3 px-3 font-medium text-white"><?= e($tf['orangtua_nama']) ?></td>
                            <td class="py-3 px-3">
                                <p class="text-white"><?= e($tf['mahasiswa_nama']) ?></p>
                                <p class="text-xs text-[#B3C9D8]"><?= e($tf['nim']) ?></p>
                            </td>
                            <td class="py-3 px-3 text-right font-medium text-[#00F29C]">
                                <?= format_rupiah($tf['jumlah_idr']) ?>
                            </td>
                            <td class="py-3 px-3 text-center">
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-medium border
                                    <?= $tf['status'] === 'completed' ? 'bg-[#00F29C]/20 text-[#00F29C] border-[#00F29C]/30' : 'bg-yellow-500/20 text-yellow-500 border-yellow-500/30' ?>">
                                    <?= e($tf['status']) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Chart(document.getElementById('statusTrendChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: <?= json_encode($statusTrend['labels']) ?>,
                datasets: [{
                    label: 'Hemat',
                    data: <?= json_encode($statusTrend['hemat']) ?>,
                    backgroundColor: '#00F29C',
                    borderRadius: 4
                }, {
                    label: 'Normal',
                    data: <?= json_encode($statusTrend['normal']) ?>,
                    backgroundColor: '#f59e0b',
                    borderRadius: 4
                }, {
                    label: 'Boros',
                    data: <?= json_encode($statusTrend['boros']) ?>,
                    backgroundColor: '#F43F5E',
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } },
                scales: {
                    x: { stacked: true },
                    y: { stacked: true, beginAtZero: true }
                }
            }
        });
    });
</script>

<?php
$content = ob_get_clean();
include dirname(__DIR__) . '/layouts/app.php';
?>