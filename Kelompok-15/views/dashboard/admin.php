<?php
$title = 'Dashboard Admin';
ob_start();
?>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>
    <p class="text-gray-500">Monitoring dan pengelolaan sistem</p>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <a href="index.php?page=admin&action=users"
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

    <a href="index.php?page=admin&action=monitoring"
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

    <a href="index.php?page=admin&action=settings"
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

<!-- Stats Grid -->
<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-indigo-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Users</p>
                <p class="text-3xl font-bold text-indigo-600"><?= $stats['total_users'] ?? 0 ?></p>
            </div>
            <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Mahasiswa</p>
                <p class="text-3xl font-bold text-blue-600"><?= $stats['total_mahasiswa'] ?? 0 ?></p>
            </div>
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path
                        d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                </svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Orang Tua</p>
                <p class="text-3xl font-bold text-green-600"><?= $stats['total_orangtua'] ?? 0 ?></p>
            </div>
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Transaksi</p>
                <p class="text-3xl font-bold text-purple-600"><?= $stats['total_transaksi'] ?? 0 ?></p>
            </div>
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-orange-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Transfer</p>
                <p class="text-3xl font-bold text-orange-600"><?= $stats['total_transfer'] ?? 0 ?></p>
            </div>
            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b">
            <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                <span>👥</span> User Terbaru
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left py-3 px-4 font-medium text-gray-600">Nama</th>
                        <th class="text-left py-3 px-4 font-medium text-gray-600">Email</th>
                        <th class="text-left py-3 px-4 font-medium text-gray-600">Role</th>
                        <th class="text-right py-3 px-4 font-medium text-gray-600">Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentUsers ?? [] as $u): ?>
                        <tr class="border-b hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-4 font-medium text-gray-800"><?= e($u['nama']) ?></td>
                            <td class="py-3 px-4 text-gray-500"><?= e($u['email']) ?></td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                <?php if ($u['role'] === 'admin'): ?>bg-red-100 text-red-700
                                <?php elseif ($u['role'] === 'mahasiswa'): ?>bg-blue-100 text-blue-700
                                <?php else: ?>bg-green-100 text-green-700<?php endif; ?>">
                                    <?= ucfirst(e($u['role'])) ?>
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right font-medium text-indigo-600">
                                <?= $u['saldo'] ? format_rupiah($u['saldo']) : '-' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b">
            <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                <span>💰</span> Transaksi Terbaru
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left py-3 px-4 font-medium text-gray-600">Mahasiswa</th>
                        <th class="text-left py-3 px-4 font-medium text-gray-600">Kategori</th>
                        <th class="text-left py-3 px-4 font-medium text-gray-600">Tipe</th>
                        <th class="text-right py-3 px-4 font-medium text-gray-600">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentTransaksi ?? [] as $t): ?>
                        <tr class="border-b hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-4 font-medium text-gray-800"><?= e($t['mahasiswa_nama']) ?></td>
                            <td class="py-3 px-4 text-gray-500"><?= e($t['kategori_nama']) ?></td>
                            <td class="py-3 px-4">
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-medium <?= $t['tipe'] === 'pemasukan' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                                    <?= ucfirst(e($t['tipe'])) ?>
                                </span>
                            </td>
                            <td
                                class="py-3 px-4 text-right font-medium <?= $t['tipe'] === 'pemasukan' ? 'text-green-600' : 'text-red-600' ?>">
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