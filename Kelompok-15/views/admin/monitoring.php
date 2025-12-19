<?php
$title = 'Monitoring Sistem';
ob_start();
?>

<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Monitoring Sistem</h1>
            <p class="text-gray-500">Pantau semua aktivitas transaksi dan transfer</p>
        </div>
        <a href="index.php?page=dashboard" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">← Kembali
            ke Dashboard</a>
    </div>
</div>

<!-- Status Trend Chart -->
<div class="bg-white rounded-lg shadow-sm p-6 mb-6">
    <h3 class="font-semibold text-gray-800 mb-4">📊 Tren Status Mahasiswa (6 Bulan Terakhir)</h3>
    <canvas id="statusTrendChart" height="100"></canvas>
</div>

<div class="grid lg:grid-cols-2 gap-6">
    <!-- Transaksi Terbaru -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="font-semibold text-gray-800 mb-4">💰 Transaksi Terbaru (50)</h3>
        <div class="overflow-x-auto max-h-96 overflow-y-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 sticky top-0">
                    <tr>
                        <th class="text-left py-2 px-3 font-medium text-gray-700">Mahasiswa</th>
                        <th class="text-left py-2 px-3 font-medium text-gray-700">Kategori</th>
                        <th class="text-left py-2 px-3 font-medium text-gray-700">Tipe</th>
                        <th class="text-right py-2 px-3 font-medium text-gray-700">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allTransaksi as $t): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-3">
                                <p class="font-medium text-gray-800"><?= e($t['mahasiswa_nama']) ?></p>
                                <p class="text-xs text-gray-500"><?= e($t['nim']) ?></p>
                            </td>
                            <td class="py-2 px-3 text-gray-600"><?= e($t['kategori_nama']) ?></td>
                            <td class="py-2 px-3">
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-medium
                                    <?= $t['tipe'] === 'pemasukan' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                                    <?= e($t['tipe']) ?>
                                </span>
                            </td>
                            <td
                                class="py-2 px-3 text-right font-medium <?= $t['tipe'] === 'pemasukan' ? 'text-green-600' : 'text-red-600' ?>">
                                <?= format_rupiah($t['jumlah_idr']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Transfer Terbaru -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="font-semibold text-gray-800 mb-4">🔄 Riwayat Transfer (50)</h3>
        <div class="overflow-x-auto max-h-96 overflow-y-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 sticky top-0">
                    <tr>
                        <th class="text-left py-2 px-3 font-medium text-gray-700">Dari</th>
                        <th class="text-left py-2 px-3 font-medium text-gray-700">Ke</th>
                        <th class="text-right py-2 px-3 font-medium text-gray-700">Jumlah</th>
                        <th class="text-center py-2 px-3 font-medium text-gray-700">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allTransfer as $tf): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-3 font-medium text-gray-800"><?= e($tf['orangtua_nama']) ?></td>
                            <td class="py-2 px-3">
                                <p class="text-gray-800"><?= e($tf['mahasiswa_nama']) ?></p>
                                <p class="text-xs text-gray-500"><?= e($tf['nim']) ?></p>
                            </td>
                            <td class="py-2 px-3 text-right font-medium text-green-600">
                                <?= format_rupiah($tf['jumlah_idr']) ?>
                            </td>
                            <td class="py-2 px-3 text-center">
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-medium
                                    <?= $tf['status'] === 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' ?>">
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Chart(document.getElementById('statusTrendChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: <?= json_encode($statusTrend['labels']) ?>,
                datasets: [{
                    label: 'Hemat',
                    data: <?= json_encode($statusTrend['hemat']) ?>,
                    backgroundColor: '#10b981',
                    borderRadius: 4
                }, {
                    label: 'Normal',
                    data: <?= json_encode($statusTrend['normal']) ?>,
                    backgroundColor: '#f59e0b',
                    borderRadius: 4
                }, {
                    label: 'Boros',
                    data: <?= json_encode($statusTrend['boros']) ?>,
                    backgroundColor: '#ef4444',
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