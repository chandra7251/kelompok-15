<?php
$title = 'Dashboard Mahasiswa';
ob_start();
?>

<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800"><span data-greeting>Selamat Datang</span>, <?= e($user['nama']) ?>!
    </h1>
    <p class="text-gray-500">Kelola keuangan Anda dengan bijak</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div
        class="card bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-2xl p-6 text-white shadow-lg shadow-indigo-500/30">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-indigo-100 text-sm font-medium">Saldo Saat Ini</p>
                <p class="text-2xl font-bold mt-2 counter" data-prefix="Rp ">
                    <?= number_format($stats['saldo'], 0, ',', '.') ?></p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="card bg-white rounded-2xl p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Pemasukan Bulan Ini</p>
                <p class="text-2xl font-bold text-green-600 mt-2"><?= format_rupiah($stats['pemasukan_bulan_ini']) ?>
                </p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 11l5-5m0 0l5 5m-5-5v12" />
                </svg>
            </div>
        </div>
    </div>

    <div class="card bg-white rounded-2xl p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Pengeluaran Bulan Ini</p>
                <p class="text-2xl font-bold text-red-600 mt-2"><?= format_rupiah($stats['pengeluaran_bulan_ini']) ?>
                </p>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                </svg>
            </div>
        </div>
    </div>

    <div class="card bg-white rounded-2xl p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-medium">Status Keuangan</p>
                <p class="text-xl font-bold mt-2 capitalize
                    <?php if ($spendingStatus['status'] === 'hemat'): ?> text-green-600
                    <?php elseif ($spendingStatus['status'] === 'normal'): ?> text-yellow-600
                    <?php else: ?> text-red-600 <?php endif; ?>">
                    <?= e($spendingStatus['status']) ?>
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl flex items-center justify-center
                <?php if ($spendingStatus['status'] === 'hemat'): ?> bg-green-100
                <?php elseif ($spendingStatus['status'] === 'normal'): ?> bg-yellow-100
                <?php else: ?> bg-red-100 <?php endif; ?>">
                <?php if ($spendingStatus['status'] === 'hemat'): ?>
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                <?php elseif ($spendingStatus['status'] === 'normal'): ?>
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                <?php else: ?>
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="card bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl p-6 mb-8 border border-indigo-100">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h3 class="font-semibold text-gray-800">Kode Pairing Anda</h3>
            <p class="text-sm text-gray-500">Berikan kode ini ke orang tua untuk terhubung</p>
        </div>
        <div class="bg-white px-6 py-3 rounded-xl border-2 border-dashed border-indigo-300 shadow-inner">
            <span class="text-2xl font-mono font-bold gradient-text tracking-widest">
                <?= e($user['pairing_code'] ?? 'N/A') ?>
            </span>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-6">
    <div class="card bg-white rounded-2xl p-6 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-semibold text-gray-800">Transaksi Terakhir</h3>
            <a href="index.php?page=transaksi" class="text-indigo-600 text-sm font-medium hover:text-indigo-700">Lihat
                Semua →</a>
        </div>
        <?php if (empty($recentTransaksi)): ?>
            <div class="text-center py-8">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <p class="text-gray-500">Belum ada transaksi</p>
                <a href="index.php?page=transaksi&action=create"
                    class="text-indigo-600 text-sm font-medium mt-2 inline-block">Tambah Transaksi</a>
            </div>
        <?php else: ?>
            <div class="space-y-3">
                <?php foreach ($recentTransaksi as $trx): ?>
                    <div
                        class="flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 rounded-xl transition-all cursor-pointer group">
                        <div class="flex items-center space-x-4">
                            <div
                                class="w-10 h-10 rounded-xl flex items-center justify-center <?= $trx['tipe'] === 'pemasukan' ? 'bg-green-100' : 'bg-red-100' ?>">
                                <?php if ($trx['tipe'] === 'pemasukan'): ?>
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                    </svg>
                                <?php else: ?>
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                                    </svg>
                                <?php endif; ?>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800 group-hover:text-indigo-600 transition-colors">
                                    <?= e($trx['kategori_nama']) ?></p>
                                <p class="text-xs text-gray-500"><?= format_tanggal($trx['tanggal']) ?></p>
                            </div>
                        </div>
                        <p class="font-semibold <?= $trx['tipe'] === 'pemasukan' ? 'text-green-600' : 'text-red-600' ?>">
                            <?= $trx['tipe'] === 'pemasukan' ? '+' : '-' ?>        <?= format_rupiah($trx['jumlah_idr']) ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="card bg-white rounded-2xl p-6 shadow-sm">
        <h3 class="font-semibold text-gray-800 mb-6">Transfer Diterima</h3>
        <?php if (empty($recentTransfer)): ?>
            <div class="text-center py-8">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-gray-500">Belum ada transfer masuk</p>
            </div>
        <?php else: ?>
            <div class="space-y-3">
                <?php foreach ($recentTransfer as $tf): ?>
                    <div class="flex items-center justify-between p-4 bg-green-50 hover:bg-green-100 rounded-xl transition-all">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">Dari: <?= e($tf['orangtua_nama']) ?></p>
                                <p class="text-xs text-gray-500"><?= format_tanggal($tf['created_at']) ?></p>
                            </div>
                        </div>
                        <p class="font-semibold text-green-600">+<?= format_rupiah($tf['jumlah_idr']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
include dirname(__DIR__) . '/layouts/app.php';
?>