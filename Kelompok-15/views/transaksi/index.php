<?php
$title = 'Transaksi';
ob_start();
?>

<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Transaksi</h1>
        <p class="text-gray-500 mt-1">Kelola pemasukan dan pengeluaran</p>
    </div>
    <a href="index.php?page=transaksi&action=create"
        class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-medium hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
        + Tambah Transaksi
    </a>
</div>

<div class="bg-white rounded-2xl card-shadow overflow-hidden">
    <?php if (empty($transaksis)): ?>
        <div class="text-center py-16">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-4xl">📋</span>
            </div>
            <p class="text-gray-500 mb-4">Belum ada transaksi</p>
            <a href="index.php?page=transaksi&action=create" class="text-indigo-600 font-medium">Tambah transaksi pertama
                →</a>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Tanggal</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Kategori</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Keterangan</th>
                        <th class="text-right py-4 px-6 text-sm font-semibold text-gray-600">Jumlah</th>
                        <th class="text-center py-4 px-6 text-sm font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($transaksis as $trx): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-4 px-6">
                                <span class="text-sm text-gray-800"><?= format_tanggal($trx['tanggal']) ?></span>
                            </td>
                            <td class="py-4 px-6">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                            <?= $trx['tipe'] === 'pemasukan' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                                    <?= $trx['tipe'] === 'pemasukan' ? '📥' : '📤' ?>         <?= e($trx['kategori_nama']) ?>
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-sm text-gray-600"><?= e($trx['keterangan'] ?: '-') ?></span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <span
                                    class="font-semibold <?= $trx['tipe'] === 'pemasukan' ? 'text-green-600' : 'text-red-600' ?>">
                                    <?= $trx['tipe'] === 'pemasukan' ? '+' : '-' ?>        <?= format_rupiah($trx['jumlah_idr']) ?>
                                </span>
                                <?php if ($trx['mata_uang'] !== 'IDR'): ?>
                                    <br><span class="text-xs text-gray-400"><?= e($trx['mata_uang']) ?>
                                        <?= number_format($trx['jumlah'], 2) ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="index.php?page=transaksi&action=edit&id=<?= $trx['id'] ?>"
                                        class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition">✏️</a>
                                    <form action="index.php?page=transaksi&action=delete" method="POST" class="inline"
                                        onsubmit="return confirm('Hapus transaksi ini?')">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="id" value="<?= $trx['id'] ?>">
                                        <button type="submit"
                                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">🗑️</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include dirname(__DIR__) . '/layouts/app.php';
?>