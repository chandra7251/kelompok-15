<?php
$title = 'Dashboard Orang Tua';
ob_start();
?>

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Selamat Datang, <?= e($user['nama']) ?>!</h1>
        <p class="text-gray-500">Monitor keuangan anak Anda</p>
    </div>
    <a href="index.php?page=export&action=transfer_orangtua"
        class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 btn-animated flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        Download Laporan
    </a>
</div>

<!-- Exchange Rates Card -->
<div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg p-4 mb-6 text-white">
    <div class="flex items-center justify-between mb-3">
        <h3 class="font-semibold flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Nilai Kurs Saat Ini
        </h3>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <?php foreach ($exchangeRates ?? [] as $currency => $rate): ?>
            <div class="bg-white/20 rounded-lg p-3 backdrop-blur">
                <p class="text-white/80 text-xs">1 <?= $currency ?></p>
                <p class="font-bold text-lg"><?= format_rupiah($rate) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Anak Terhubung dengan Statistik -->
<div class="bg-white rounded-lg shadow-sm p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-semibold text-gray-800">👨‍👩‍👧‍👦 Anak yang Terhubung</h3>
        <a href="index.php?page=transfer"
            class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700">+ Hubungkan
            Anak</a>
    </div>

    <?php if (empty($childrenStats)): ?>
        <div class="text-center py-8">
            <p class="text-gray-500 mb-3">Belum ada anak yang terhubung</p>
            <a href="index.php?page=transfer" class="text-indigo-600 font-medium">Hubungkan sekarang</a>
        </div>
    <?php else: ?>
        <div class="space-y-4">
            <?php foreach ($childrenStats as $child): ?>
                <?php
                $mhs = $child['mahasiswa'];
                $stats = $child['stats'];
                $status = $child['spendingStatus'];
                $statusColors = [
                    'hemat' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'border' => 'border-green-300'],
                    'normal' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'border' => 'border-yellow-300'],
                    'boros' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'border' => 'border-red-300']
                ];
                $colors = $statusColors[$status['status']] ?? $statusColors['normal'];
                ?>
                <div class="border <?= $colors['border'] ?> rounded-xl p-4 <?= $colors['bg'] ?>">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                        <!-- Info Anak -->
                        <div class="flex items-center space-x-4">
                            <div class="w-14 h-14 bg-indigo-500 rounded-full flex items-center justify-center shadow-lg">
                                <span class="font-bold text-white text-xl"><?= strtoupper(substr($mhs['nama'], 0, 1)) ?></span>
                            </div>
                            <div>
                                <p class="font-bold text-gray-800 text-lg"><?= e($mhs['nama']) ?></p>
                                <p class="text-sm text-gray-600"><?= e($mhs['nim']) ?> - <?= e($mhs['jurusan'] ?? 'N/A') ?></p>
                                <span
                                    class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-semibold <?= $colors['bg'] ?> <?= $colors['text'] ?> mt-1">
                                    <?php if ($status['status'] === 'hemat'): ?>
                                        ✅ Hemat
                                    <?php elseif ($status['status'] === 'normal'): ?>
                                        ⚠️ Normal
                                    <?php else: ?>
                                        🔴 Boros
                                    <?php endif; ?>
                                    (<?= $status['ratio'] ?>%)
                                </span>
                            </div>
                        </div>

                        <!-- Statistik -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 flex-1 lg:max-w-2xl">
                            <div class="bg-white rounded-lg p-3 shadow-sm">
                                <p class="text-xs text-gray-500">Saldo</p>
                                <p class="font-bold text-indigo-600"><?= format_rupiah($stats['saldo']) ?></p>
                            </div>
                            <div class="bg-white rounded-lg p-3 shadow-sm">
                                <p class="text-xs text-gray-500">Pemasukan Bulan Ini</p>
                                <p class="font-bold text-green-600"><?= format_rupiah($stats['pemasukan_bulan_ini']) ?></p>
                            </div>
                            <div class="bg-white rounded-lg p-3 shadow-sm">
                                <p class="text-xs text-gray-500">Pengeluaran Bulan Ini</p>
                                <p class="font-bold text-red-600"><?= format_rupiah($stats['pengeluaran_bulan_ini']) ?></p>
                            </div>
                            <div class="bg-white rounded-lg p-3 shadow-sm">
                                <p class="text-xs text-gray-500">Total Transaksi</p>
                                <p class="font-bold text-gray-800"><?= $stats['total_transaksi'] ?> Transaksi</p>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-2">
                            <form action="index.php?page=transfer&action=unlink" method="POST"
                                onsubmit="return confirm('Yakin ingin melepas hubungan dengan anak ini?')">
                                <?= csrf_field() ?>
                                <input type="hidden" name="mahasiswa_id" value="<?= $mhs['id'] ?>">
                                <button type="submit"
                                    class="text-red-500 hover:text-red-700 text-sm px-3 py-1 border border-red-300 rounded-lg hover:bg-red-50">Lepas</button>
                            </form>
                        </div>
                    </div>

                    <!-- Status Message -->
                    <div class="mt-3 p-2 bg-white/80 rounded-lg">
                        <p class="text-sm <?= $colors['text'] ?>"><?= $status['message'] ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Grafik Agregat -->
<?php if (!empty($aggregatedMonthlyData['labels'])): ?>
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <h3 class="font-semibold text-gray-800 mb-4">📊 Grafik Keuangan Semua Anak (6 Bulan Terakhir)</h3>
        <canvas id="aggregatedChart" height="100"></canvas>
    </div>
<?php endif; ?>

<div class="grid lg:grid-cols-2 gap-6">
    <!-- Transfer Cepat -->
    <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg p-6 text-white">
        <h3 class="font-semibold mb-4">💸 Kirim Saldo Cepat</h3>
        <?php if (!empty($linkedMahasiswa)): ?>
            <form action="index.php?page=transfer&action=send&redirect=dashboard" method="POST" class="space-y-4">
                <?= csrf_field() ?>
                <div>
                    <label class="text-green-100 text-sm">Pilih Anak</label>
                    <select name="mahasiswa_id" required
                        class="w-full mt-1 px-4 py-2 rounded-lg bg-white/20 border border-white/30 text-white">
                        <?php foreach ($linkedMahasiswa as $mhs): ?>
                            <option value="<?= $mhs['id'] ?>" class="text-gray-800"><?= e($mhs['nama']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="text-green-100 text-sm">Jumlah</label>
                        <input type="number" name="jumlah" id="jumlahInput" required min="0.01" step="0.01"
                            placeholder="100"
                            class="w-full mt-1 px-4 py-2 rounded-lg bg-white/20 border border-white/30 text-white placeholder-white/60">
                    </div>
                    <div>
                        <label class="text-green-100 text-sm">Mata Uang</label>
                        <select name="mata_uang" id="currencySelect"
                            class="w-full mt-1 px-4 py-2 rounded-lg bg-white/20 border border-white/30 text-white">
                            <?php foreach ($currencies ?? ['IDR'] as $cur => $name): ?>
                                <option value="<?= $cur ?>" class="text-gray-800" <?= $cur === 'IDR' ? 'selected' : '' ?>>
                                    <?= $cur ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <p id="convertedAmount" class="text-green-100 text-sm hidden"></p>
                <button type="submit"
                    class="w-full bg-white text-green-600 py-2 rounded-lg font-semibold hover:bg-green-50">Kirim
                    Saldo</button>
            </form>
        <?php else: ?>
            <p class="text-green-100">Hubungkan dengan anak terlebih dahulu.</p>
        <?php endif; ?>
    </div>

    <!-- Riwayat Transfer -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="font-semibold text-gray-800 mb-4">📝 Riwayat Transfer</h3>
        <?php if (empty($recentTransfer)): ?>
            <p class="text-gray-500 text-center py-6">Belum ada riwayat transfer</p>
        <?php else: ?>
            <div class="space-y-3 max-h-64 overflow-y-auto">
                <?php foreach (array_slice($recentTransfer, 0, 5) as $tf): ?>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-800">Ke: <?= e($tf['mahasiswa_nama']) ?></p>
                            <p class="text-xs text-gray-500"><?= format_tanggal($tf['created_at']) ?></p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-green-600"><?= format_rupiah($tf['jumlah_idr']) ?></p>
                            <span
                                class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-700"><?= e($tf['status']) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Laporan Bulanan per Anak -->
<?php if (!empty($childrenStats)): ?>
    <div class="bg-white rounded-lg shadow-sm p-6 mt-6">
        <h3 class="font-semibold text-gray-800 mb-4">📅 Laporan Bulanan per Anak</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Anak</th>
                        <?php
                        $labels = $aggregatedMonthlyData['labels'] ?? [];
                        foreach ($labels as $label):
                            ?>
                            <th class="px-4 py-3 text-center font-semibold text-gray-700"><?= $label ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($childrenStats as $child): ?>
                        <tr class="border-b">
                            <td class="px-4 py-3">
                                <p class="font-medium text-gray-800"><?= e($child['mahasiswa']['nama']) ?></p>
                                <p class="text-xs text-gray-500"><?= e($child['mahasiswa']['nim']) ?></p>
                            </td>
                            <?php foreach ($child['monthlyData']['pemasukan'] as $idx => $pemasukan): ?>
                                <?php $pengeluaran = $child['monthlyData']['pengeluaran'][$idx] ?? 0; ?>
                                <td class="px-4 py-3 text-center">
                                    <p class="text-green-600 text-xs">+<?= format_rupiah($pemasukan) ?></p>
                                    <p class="text-red-600 text-xs">-<?= format_rupiah($pengeluaran) ?></p>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<script>
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

    <?php if (!empty($aggregatedMonthlyData['labels'])): ?>
        document.addEventListener('DOMContentLoaded', function () {
            new Chart(document.getElementById('aggregatedChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: <?= json_encode($aggregatedMonthlyData['labels']) ?>,
                    datasets: [{
                        label: 'Total Pemasukan',
                        data: <?= json_encode($aggregatedMonthlyData['pemasukan']) ?>,
                        backgroundColor: '#10b981',
                        borderRadius: 8
                    }, {
                        label: 'Total Pengeluaran',
                        data: <?= json_encode($aggregatedMonthlyData['pengeluaran']) ?>,
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
    <?php endif; ?>
</script>

<?php
$content = ob_get_clean();
include dirname(__DIR__) . '/layouts/app.php';
?>