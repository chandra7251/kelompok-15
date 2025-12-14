<?php
$title = 'Dashboard Admin';
ob_start();
?>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>
    <p class="text-gray-500">Monitoring seluruh pengguna sistem</p>
</div>

<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow-sm p-4">
        <p class="text-gray-500 text-sm">Total Users</p>
        <p class="text-2xl font-bold text-indigo-600"><?= $stats['total_users'] ?? 0 ?></p>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-4">
        <p class="text-gray-500 text-sm">Mahasiswa</p>
        <p class="text-2xl font-bold text-blue-600"><?= $stats['total_mahasiswa'] ?? 0 ?></p>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-4">
        <p class="text-gray-500 text-sm">Orang Tua</p>
        <p class="text-2xl font-bold text-green-600"><?= $stats['total_orangtua'] ?? 0 ?></p>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-4">
        <p class="text-gray-500 text-sm">Transaksi</p>
        <p class="text-2xl font-bold text-purple-600"><?= $stats['total_transaksi'] ?? 0 ?></p>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-4">
        <p class="text-gray-500 text-sm">Transfer</p>
        <p class="text-2xl font-bold text-orange-600"><?= $stats['total_transfer'] ?? 0 ?></p>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="font-semibold text-gray-800 mb-4">User Terbaru</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-2 px-2">Nama</th>
                        <th class="text-left py-2 px-2">Email</th>
                        <th class="text-left py-2 px-2">Role</th>
                        <th class="text-right py-2 px-2">Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentUsers ?? [] as $u): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-2 font-medium"><?= e($u['nama']) ?></td>
                            <td class="py-2 px-2 text-gray-500"><?= e($u['email']) ?></td>
                            <td class="py-2 px-2">
                                <span class="px-2 py-1 rounded-full text-xs 
                                <?php if ($u['role'] === 'admin'): ?>bg-red-100 text-red-700
                                <?php elseif ($u['role'] === 'mahasiswa'): ?>bg-blue-100 text-blue-700
                                <?php else: ?>bg-green-100 text-green-700<?php endif; ?>">
                                    <?= e($u['role']) ?>
                                </span>
                            </td>
                            <td class="py-2 px-2 text-right"><?= $u['saldo'] ? format_rupiah($u['saldo']) : '-' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="font-semibold text-gray-800 mb-4">Transaksi Terbaru</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-2 px-2">Mahasiswa</th>
                        <th class="text-left py-2 px-2">Kategori</th>
                        <th class="text-left py-2 px-2">Tipe</th>
                        <th class="text-right py-2 px-2">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentTransaksi ?? [] as $t): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-2 font-medium"><?= e($t['mahasiswa_nama']) ?></td>
                            <td class="py-2 px-2 text-gray-500"><?= e($t['kategori_nama']) ?></td>
                            <td class="py-2 px-2">
                                <span
                                    class="px-2 py-1 rounded-full text-xs <?= $t['tipe'] === 'pemasukan' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                                    <?= e($t['tipe']) ?>
                                </span>
                            </td>
                            <td
                                class="py-2 px-2 text-right font-medium <?= $t['tipe'] === 'pemasukan' ? 'text-green-600' : 'text-red-600' ?>">
                                <?= format_rupiah($t['jumlah_idr']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include dirname(__DIR__) . '/layouts/app.php';
?>