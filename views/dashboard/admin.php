<?php
$title = 'Dashboard Admin';
ob_start();
?>

<div class="py-6 sm:py-8 px-3 sm:px-6 max-w-full overflow-x-hidden">
    <div class="mb-6">
        <p class="text-[#B3C9D8] ml-2 text-sm sm:text-base">Monitoring seluruh pengguna sistem</p>
    </div>


    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 sm:gap-4 mb-6">
        <a href="/admin/users"
            class="group bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-5 text-white hover:shadow-xl transition-all hover:-translate-y-1">
            <div class="flex items-center gap-4">
                <div
                    class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-blue-100 text-sm">Kelola</p>
                    <p class="text-xl font-bold">User Management</p>
                    <p class="text-blue-200 text-xs mt-1">Toggle status, reset password, hapus user</p>
                </div>
            </div>
        </a>

        <a href="/admin/monitoring"
            class="group bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-5 text-white hover:shadow-xl transition-all hover:-translate-y-1">
            <div class="flex items-center gap-4">
                <div
                    class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-purple-100 text-sm">Lihat</p>
                    <p class="text-xl font-bold">Monitoring</p>
                    <p class="text-purple-200 text-xs mt-1">Transaksi, transfer, tren status</p>
                </div>
            </div>
        </a>

        <a href="/admin/settings"
            class="group bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-5 text-white hover:shadow-xl transition-all hover:-translate-y-1">
            <div class="flex items-center gap-4">
                <div
                    class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-green-100 text-sm">Konfigurasi</p>
                    <p class="text-xl font-bold">Settings</p>
                    <p class="text-green-200 text-xs mt-1">Threshold scoring, TTL kurs</p>
                </div>
            </div>
        </a>
    </div>


    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
        <div
            class="bg-[#16304d] border border-white/5 rounded-2xl shadow-lg p-4 sm:p-5 hover:scale-[1.02] transition-transform duration-300">
            <p class="text-[#B3C9D8] text-xs sm:text-sm font-medium">Total Users</p>
            <p class="text-xl sm:text-3xl font-bold text-white mt-2"><?= $stats['total_users'] ?? 0 ?></p>
        </div>
        <div
            class="bg-[#16304d] border border-white/5 rounded-2xl shadow-lg p-4 sm:p-5 hover:scale-[1.02] transition-transform duration-300">
            <p class="text-[#B3C9D8] text-xs sm:text-sm font-medium">Mahasiswa</p>
            <p class="text-xl sm:text-3xl font-bold text-[#00C6FB] mt-2"><?= $stats['total_mahasiswa'] ?? 0 ?></p>
        </div>
        <div
            class="bg-[#16304d] border border-white/5 rounded-2xl shadow-lg p-4 sm:p-5 hover:scale-[1.02] transition-transform duration-300">
            <p class="text-[#B3C9D8] text-xs sm:text-sm font-medium">Orang Tua</p>
            <p class="text-xl sm:text-3xl font-bold text-[#00F29C] mt-2"><?= $stats['total_orangtua'] ?? 0 ?></p>
        </div>
        <div
            class="bg-[#16304d] border border-white/5 rounded-2xl shadow-lg p-4 sm:p-5 hover:scale-[1.02] transition-transform duration-300">
            <p class="text-[#B3C9D8] text-xs sm:text-sm font-medium">Transaksi</p>
            <p class="text-xl sm:text-3xl font-bold text-[#f472b6] mt-2"><?= $stats['total_transaksi'] ?? 0 ?></p>
        </div>
        <div
            class="bg-[#16304d] border border-white/5 rounded-2xl shadow-lg p-4 sm:p-5 hover:scale-[1.02] transition-transform duration-300">
            <p class="text-[#B3C9D8] text-xs sm:text-sm font-medium">Transfer</p>
            <p class="text-xl sm:text-3xl font-bold text-[#fbbf24] mt-2"><?= $stats['total_transfer'] ?? 0 ?></p>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="bg-[#16304d] border border-white/5 rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6 pb-0">
                <h3 class="font-bold text-white mb-6 flex items-center gap-2">
                    <span class="w-1 h-6 bg-gradient-to-b from-[#00C6FB] to-[#00F29C] rounded-full"></span>
                    User Terbaru
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-white/5 text-[#B3C9D8]">
                            <th class="text-left py-3 px-4 font-medium whitespace-nowrap">Nama</th>
                            <th class="text-left py-3 px-4 font-medium whitespace-nowrap">Email</th>
                            <th class="text-left py-3 px-4 font-medium whitespace-nowrap">Role</th>
                            <th class="text-right py-3 px-4 font-medium whitespace-nowrap">Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentUsers ?? [] as $u): ?>
                            <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                                <td class="py-3 px-4 text-white font-medium whitespace-nowrap"><?= e($u['nama']) ?></td>
                                <td class="py-3 px-4 text-[#B3C9D8] text-sm whitespace-nowrap"><?= e($u['email']) ?></td>
                                <td class="py-2 px-2">
                                    <span
                                        class="px-2 py-1 rounded-full text-xs 
                                <?php if ($u['role'] === 'admin'): ?>bg-rose-500/20 text-rose-300 border border-rose-500/30
                                <?php elseif ($u['role'] === 'mahasiswa'): ?>bg-[#00C6FB]/20 text-[#00C6FB] border border-[#00C6FB]/30
                                <?php else: ?>bg-[#00F29C]/20 text-[#00F29C] border border-[#00F29C]/30<?php endif; ?>">
                                        <?= e($u['role']) ?>
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-right text-white font-medium whitespace-nowrap">
                                    <?= $u['saldo'] ? format_rupiah($u['saldo']) : '-' ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-[#16304d] border border-white/5 rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6 pb-0">
                <h3 class="font-bold text-white mb-6 flex items-center gap-2">
                    <span class="w-1 h-6 bg-gradient-to-b from-[#00C6FB] to-[#00F29C] rounded-full"></span>
                    Transaksi Terbaru
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-white/5 text-[#B3C9D8]">
                            <th class="text-left py-3 px-4 font-medium">Mahasiswa</th>
                            <th class="text-left py-3 px-4 font-medium">Kategori</th>
                            <th class="text-left py-3 px-4 font-medium">Tipe</th>
                            <th class="text-right py-3 px-4 font-medium">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentTransaksi ?? [] as $t): ?>
                            <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                                <td class="py-3 px-4 text-white font-medium"><?= e($t['mahasiswa_nama']) ?></td>
                                <td class="py-3 px-4 text-[#B3C9D8] text-sm"><?= e($t['kategori_nama']) ?></td>
                                <td class="py-2 px-2">
                                    <span
                                        class="px-2 py-1 rounded-full text-xs <?= $t['tipe'] === 'pemasukan' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-rose-500/20 text-rose-300 border border-rose-500/30' ?>">
                                        <?= e($t['tipe']) ?>
                                    </span>
                                </td>
                                <td
                                    class="py-3 px-4 text-right font-bold <?= $t['tipe'] === 'pemasukan' ? 'text-[#00F29C]' : 'text-red-400' ?>">
                                    <?= format_rupiah($t['jumlah_idr']) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include dirname(__DIR__) . '/layouts/app.php';
?>