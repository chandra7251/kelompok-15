<?php
$title = 'Dashboard Admin';
ob_start();
?>

<div class="py-8 px-6">
    <div class="mb-6">
    <p class="text-[#B3C9D8] ml-2">Monitoring seluruh pengguna sistem</p>
</div>

<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
    <div class="bg-[#16304d] border border-white/5 rounded-2xl shadow-lg p-5 hover:scale-[1.02] transition-transform duration-300">
        <p class="text-[#B3C9D8] text-sm font-medium">Total Users</p>
        <p class="text-3xl font-bold text-white mt-2"><?= $stats['total_users'] ?? 0 ?></p>
    </div>
    <div class="bg-[#16304d] border border-white/5 rounded-2xl shadow-lg p-5 hover:scale-[1.02] transition-transform duration-300">
        <p class="text-[#B3C9D8] text-sm font-medium">Mahasiswa</p>
        <p class="text-3xl font-bold text-[#00C6FB] mt-2"><?= $stats['total_mahasiswa'] ?? 0 ?></p>
    </div>
    <div class="bg-[#16304d] border border-white/5 rounded-2xl shadow-lg p-5 hover:scale-[1.02] transition-transform duration-300">
        <p class="text-[#B3C9D8] text-sm font-medium">Orang Tua</p>
        <p class="text-3xl font-bold text-[#00F29C] mt-2"><?= $stats['total_orangtua'] ?? 0 ?></p>
    </div>
    <div class="bg-[#16304d] border border-white/5 rounded-2xl shadow-lg p-5 hover:scale-[1.02] transition-transform duration-300">
        <p class="text-[#B3C9D8] text-sm font-medium">Transaksi</p>
        <p class="text-3xl font-bold text-[#f472b6] mt-2"><?= $stats['total_transaksi'] ?? 0 ?></p>
    </div>
    <div class="bg-[#16304d] border border-white/5 rounded-2xl shadow-lg p-5 hover:scale-[1.02] transition-transform duration-300">
        <p class="text-[#B3C9D8] text-sm font-medium">Transfer</p>
        <p class="text-3xl font-bold text-[#fbbf24] mt-2"><?= $stats['total_transfer'] ?? 0 ?></p>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-6">
    <div class="bg-[#16304d] border border-white/5 rounded-2xl shadow-lg p-6">
        <h3 class="font-bold text-white mb-6 flex items-center gap-2">
            <span class="w-1 h-6 bg-gradient-to-b from-[#00C6FB] to-[#00F29C] rounded-full"></span>
            User Terbaru
        </h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-white/5 text-[#B3C9D8]">
                        <th class="text-left py-3 px-4 font-medium">Nama</th>
                        <th class="text-left py-3 px-4 font-medium">Email</th>
                        <th class="text-left py-3 px-4 font-medium">Role</th>
                        <th class="text-right py-3 px-4 font-medium">Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentUsers ?? [] as $u): ?>
                        <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                            <td class="py-3 px-4 text-white font-medium"><?= e($u['nama']) ?></td>
                            <td class="py-3 px-4 text-[#B3C9D8] text-sm"><?= e($u['email']) ?></td>
                            <td class="py-2 px-2">
                                <span class="px-2 py-1 rounded-full text-xs 
                                <?php if ($u['role'] === 'admin'): ?>bg-rose-500/20 text-rose-300 border border-rose-500/30
                                <?php elseif ($u['role'] === 'mahasiswa'): ?>bg-[#00C6FB]/20 text-[#00C6FB] border border-[#00C6FB]/30
                                <?php else: ?>bg-[#00F29C]/20 text-[#00F29C] border border-[#00F29C]/30<?php endif; ?>">
                                    <?= e($u['role']) ?>
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right text-white font-medium whitespace-nowrap"><?= $u['saldo'] ? format_rupiah($u['saldo']) : '-' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-[#16304d] border border-white/5 rounded-2xl shadow-lg p-6">
        <h3 class="font-bold text-white mb-6 flex items-center gap-2">
            <span class="w-1 h-6 bg-gradient-to-b from-[#00C6FB] to-[#00F29C] rounded-full"></span>
            Transaksi Terbaru
        </h3>
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