<?php
$title = 'Transaksi';
ob_start();
?>

<div
    class="w-full mx-auto px-3 md:px-6 py-4 pb-20 space-y-6 animate-[fadeIn_0.5s_ease-out] max-w-full overflow-x-hidden">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-[#00C6FB]">Transaksi</h1>
            <p class="text-gray-400 text-sm mt-1">Kelola Pemasukan dan Pengeluaran</p>
        </div>
        <a href="/transaksi/create"
            class="bg-[#00C6FB] text-[#051933] px-4 sm:px-6 py-2.5 rounded-xl font-bold hover:bg-[#00F29C] transition shadow-[0_0_15px_rgba(0,198,251,0.3)] flex items-center justify-center gap-2 text-sm sm:text-base">
            <span>+</span> Tambah Transaksi
        </a>
    </div>

    <div class="bg-[#0F2942] rounded-2xl shadow-xl border border-white/5 overflow-hidden">
        <?php if (empty($transaksis)): ?>
            <div class="text-center py-16">
                <div
                    class="w-20 h-20 bg-[#0A2238] rounded-full flex items-center justify-center mx-auto mb-4 border border-white/5">
                    <span class="text-4xl">ðŸ“‹</span>
                </div>
                <p class="text-gray-400 mb-4">Belum ada transaksi</p>
                <a href="/transaksi/create" class="text-[#00C6FB] font-medium hover:text-[#00F29C]">Tambah transaksi pertama
                    â†’</a>
            </div>
        <?php else: ?>
            <!-- Mobile Card Layout -->
            <div class="md:hidden divide-y divide-white/5">
                <?php foreach ($transaksis as $trx): ?>
                    <div class="p-4 hover:bg-[#0A2238] transition">
                        <div class="flex items-start justify-between gap-3 mb-3">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium border
                                        <?= $trx['tipe'] === 'pemasukan' ? 'border-[#00F29C] text-[#00F29C]' : 'border-[#FF6B6B] text-[#FF6B6B]' ?>">
                                        <?= $trx['tipe'] === 'pemasukan' ? 'â†‘' : 'â†“' ?>         <?= e($trx['kategori_nama']) ?>
                                    </span>
                                </div>
                                <p class="text-xs text-gray-400"><?= format_tanggal($trx['tanggal']) ?></p>
                            </div>
                            <span
                                class="font-bold text-sm <?= $trx['tipe'] === 'pemasukan' ? 'text-[#00F29C]' : 'text-[#FF6B6B]' ?>">
                                <?= $trx['tipe'] === 'pemasukan' ? '+' : '-' ?>        <?= format_rupiah($trx['jumlah_idr']) ?>
                            </span>
                        </div>
                        <?php if ($trx['keterangan']): ?>
                            <p class="text-xs text-gray-300 mb-2 truncate"><?= e($trx['keterangan']) ?></p>
                        <?php endif; ?>
                        <div class="flex items-center gap-3 pt-2 border-t border-white/5">
                            <a href="/transaksi/edit?id=<?= $trx['id'] ?>"
                                class="text-xs text-[#00C6FB] hover:text-[#00F29C] font-medium">Edit</a>
                            <form action="/transaksi/delete" method="POST" class="inline"
                                onsubmit="return confirm('Hapus transaksi ini?')">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id" value="<?= $trx['id'] ?>">
                                <button type="submit"
                                    class="text-xs text-[#FF6B6B] hover:text-red-400 font-medium">Hapus</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Desktop Table Layout -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-[#0A2238]/50 border-b border-white/5">
                        <tr>
                            <th class="text-left py-4 px-6 text-sm font-bold text-white">Tanggal</th>
                            <th class="text-left py-4 px-6 text-sm font-bold text-white">Kategori</th>
                            <th class="text-left py-4 px-6 text-sm font-bold text-white">Keterangan</th>
                            <th class="text-right py-4 px-6 text-sm font-bold text-white">Jumlah</th>
                            <th class="text-center py-4 px-6 text-sm font-bold text-white">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        <?php foreach ($transaksis as $trx): ?>
                            <tr class="hover:bg-[#0A2238] transition border-b border-white/5">
                                <td class="py-4 px-6">
                                    <span class="text-sm text-gray-300"><?= format_tanggal($trx['tanggal']) ?></span>
                                </td>
                                <td class="py-4 px-6">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border
                                        <?= $trx['tipe'] === 'pemasukan' ? 'border-[#00F29C] text-[#00F29C]' : 'border-[#FF6B6B] text-[#FF6B6B]' ?>">
                                        <?= $trx['tipe'] === 'pemasukan' ? 'â†‘' : 'â†“' ?>         <?= e($trx['kategori_nama']) ?>
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="text-sm text-gray-300"><?= e($trx['keterangan'] ?: '-') ?></span>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <span
                                        class="font-bold <?= $trx['tipe'] === 'pemasukan' ? 'text-[#00F29C]' : 'text-[#FF6B6B]' ?>">
                                        <?= $trx['tipe'] === 'pemasukan' ? '+' : '-' ?>         <?= format_rupiah($trx['jumlah_idr']) ?>
                                    </span>
                                    <?php if ($trx['mata_uang'] !== 'IDR'): ?>
                                        <br><span class="text-xs text-gray-500"><?= e($trx['mata_uang']) ?>
                                            <?= number_format($trx['jumlah'], 2) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-center space-x-3">
                                        <a href="/transaksi/edit?id=<?= $trx['id'] ?>"
                                            class="p-2 text-white hover:text-[#00C6FB] transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                        <form action="/transaksi/delete" method="POST" class="inline"
                                            onsubmit="return confirm('Hapus transaksi ini?')">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="id" value="<?= $trx['id'] ?>">
                                            <button type="submit" class="p-2 text-white hover:text-[#FF6B6B] transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
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
</div>

<?php
$content = ob_get_clean();
include dirname(__DIR__) . '/layouts/app.php';
?>