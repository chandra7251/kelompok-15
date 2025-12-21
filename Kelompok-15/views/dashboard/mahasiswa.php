<?php
$title = 'Dashboard Mahasiswa';
ob_start();
?>

<div class="w-full mx-auto px-3 md:px-6 py-4 pb-20 space-y-6 animate-[fadeIn_0.5s_ease-out]">

    <div data-welcome class="mb-8 transition-all duration-500">
        <h1 class="text-2xl font-bold text-[#00C6FB]"><span data-greeting>Selamat Datang</span>, <span
                class="text-[#00F29C]"><?= e($user['nama']) ?></span>!
        </h1>
        <p class="text-gray-400">Kelola keuangan Anda dengan bijak</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-5">
        <div
            class="card bg-gradient-to-r from-[#00C6FB] to-[#00F29C] rounded-2xl p-6 text-[#051933] shadow-lg shadow-[#00C6FB]/20">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[#051933]/80 text-sm font-bold">Saldo Saat Ini</p>
                    <p class="text-3xl font-bold mt-2 counter text-[#051933]" data-prefix="Rp ">
                        <?= number_format($stats['saldo'], 0, ',', '.') ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="card bg-[#0F2942] rounded-2xl p-6 shadow-xl border border-white/5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[#00F29C] text-sm font-medium">Pemasukan Saat Ini</p>
                    <p class="text-2xl font-bold text-white mt-2"><?= format_rupiah($stats['pemasukan_bulan_ini']) ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="card bg-[#0F2942] rounded-2xl p-6 shadow-xl border border-white/5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[#FF6B6B] text-sm font-medium">Pengeluaran Bulan Ini</p>
                    <p class="text-2xl font-bold text-white mt-2"><?= format_rupiah($stats['pengeluaran_bulan_ini']) ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="card bg-[#0F2942] rounded-2xl p-6 shadow-xl border border-white/5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">Status Keuangan</p>
                    <p class="text-2xl font-bold mt-2 capitalize
                        <?php if ($spendingStatus['status'] === 'hemat'): ?> text-[#00F29C]
                        <?php elseif ($spendingStatus['status'] === 'normal'): ?> text-yellow-400
                        <?php else: ?> text-[#FF6B6B] <?php endif; ?>">
                        <?= e($spendingStatus['status']) ?>
                    </p>
                </div>
                <div class="w-12 h-12 rounded-full flex items-center justify-center bg-white shadow-lg">
                    <?php if ($spendingStatus['status'] === 'hemat'): ?>
                        <span class="text-2xl">😊</span>
                    <?php elseif ($spendingStatus['status'] === 'normal'): ?>
                        <span class="text-2xl">😐</span>
                    <?php else: ?>
                        <span class="text-2xl">❗</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="card bg-[#0F2942] rounded-2xl p-6 shadow-xl border border-white/5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">Total Tabungan</p>
                    <p class="text-2xl font-bold text-[#00C6FB] mt-2"><?= format_rupiah($tabungan['total'] ?? 0) ?></p>
                    <p class="text-xs text-gray-500 mt-1">Bulan ini: <?= format_rupiah($tabungan['bulan_ini'] ?? 0) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-[#0F2942] rounded-2xl p-6 border border-white/5 shadow-xl">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h3 class="font-bold text-white mb-1">Kode Pairing Anda</h3>
                <p class="text-sm text-gray-400">Berikan kode ini ke orang tua untuk terhubung</p>
            </div>
            <div
                class="bg-[#0A2238] px-8 py-4 rounded-xl border border-[#00C6FB]/30 shadow-[0_0_15px_rgba(0,198,251,0.1)]">
                <span class="text-2xl font-mono font-bold text-[#00C6FB] tracking-[0.2em]">
                    <?= e($user['pairing_code'] ?? 'N/A') ?>
                </span>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="card bg-[#0F2942] rounded-2xl p-6 shadow-xl border border-white/5">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-bold text-xl text-gray-200">Transaksi Terakhir</h3>
                <a href="index.php?page=transaksi"
                    class="text-[#00C6FB] text-sm font-medium hover:text-[#00F29C] transition-colors">Lihat
                    Semua →</a>
            </div>
            <?php if (empty($recentTransaksi)): ?>
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-[#0A2238] rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <p class="text-gray-500">Belum ada transaksi</p>
                    <a href="index.php?page=transaksi&action=create"
                        class="text-[#00C6FB] text-sm font-medium mt-2 inline-block">Tambah Transaksi</a>
                </div>
            <?php else: ?>
                <div class="space-y-3">
                    <?php foreach ($recentTransaksi as $trx): ?>
                        <div
                            class="flex items-center justify-between p-4 bg-[#0A2238] hover:bg-[#112d4a] rounded-xl transition-all cursor-pointer group border border-white/5">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="w-10 h-10 rounded-full flex items-center justify-center border <?= $trx['tipe'] === 'pemasukan' ? 'border-[#00F29C]/30 text-[#00F29C]' : 'border-[#FF6B6B]/30 text-[#FF6B6B]' ?>">
                                    <?php if ($trx['tipe'] === 'pemasukan'): ?>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                        </svg>
                                    <?php else: ?>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                                        </svg>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <p class="font-semibold text-white group-hover:text-[#00C6FB] transition-colors">
                                        <?= e($trx['kategori_nama']) ?>
                                    </p>
                                    <p class="text-xs text-gray-500"><?= format_tanggal($trx['tanggal']) ?></p>
                                </div>
                            </div>
                            <p class="font-bold <?= $trx['tipe'] === 'pemasukan' ? 'text-[#00F29C]' : 'text-[#FF6B6B]' ?>">
                                <?= $trx['tipe'] === 'pemasukan' ? '+' : '-' ?>         <?= format_rupiah($trx['jumlah_idr']) ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="card bg-[#0F2942] rounded-2xl p-6 shadow-xl border border-white/5">
            <h3 class="font-bold text-xl text-gray-200 mb-6">Transfer Diterima</h3>
            <?php if (empty($recentTransfer)): ?>
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-[#0A2238] rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-gray-500">Belum ada transfer masuk</p>
                </div>
            <?php else: ?>
                <div class="space-y-3">
                    <?php foreach ($recentTransfer as $tf): ?>
                        <div
                            class="flex items-center justify-between p-4 bg-[#0A2238] hover:bg-[#112d4a] rounded-xl transition-all border border-white/5">
                            <div class="flex items-center space-x-4">
                                <div class="hidden sm:flex flex-col items-end min-w-[60px]">
                                    <span class="text-xs text-gray-400">dari :</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-white"><?= e($tf['orangtua_nama']) ?></p>
                                    <p class="text-xs text-gray-500"><?= format_tanggal($tf['created_at']) ?></p>
                                </div>
                            </div>
                            <p class="font-bold text-[#00F29C]">+<?= format_rupiah($tf['jumlah_idr']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include dirname(__DIR__) . '/layouts/app.php';
?>