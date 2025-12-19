<?php
$title = 'Manajemen User';
ob_start();
?>

<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen User</h1>
            <p class="text-gray-500">Kelola semua pengguna sistem</p>
        </div>
        <a href="index.php?page=dashboard" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">← Kembali
            ke Dashboard</a>
    </div>
</div>

<div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">ID</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Nama</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Email</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Role</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">NIM</th>
                    <th class="text-right py-3 px-4 font-semibold text-gray-700">Saldo</th>
                    <th class="text-center py-3 px-4 font-semibold text-gray-700">Status</th>
                    <th class="text-center py-3 px-4 font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4 text-gray-500"><?= $u['id'] ?></td>
                        <td class="py-3 px-4 font-medium text-gray-800"><?= e($u['nama']) ?></td>
                        <td class="py-3 px-4 text-gray-600"><?= e($u['email']) ?></td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                <?php if ($u['role'] === 'admin'): ?>bg-red-100 text-red-700
                                <?php elseif ($u['role'] === 'mahasiswa'): ?>bg-blue-100 text-blue-700
                                <?php else: ?>bg-green-100 text-green-700<?php endif; ?>">
                                <?= ucfirst(e($u['role'])) ?>
                            </span>
                        </td>
                        <td class="py-3 px-4 text-gray-600"><?= $u['nim'] ?? '-' ?></td>
                        <td class="py-3 px-4 text-right font-medium text-indigo-600">
                            <?= $u['saldo'] ? format_rupiah($u['saldo']) : '-' ?>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <?php if (($u['is_active'] ?? 1) == 1): ?>
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Aktif</span>
                            <?php else: ?>
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <td class="py-3 px-4">
                            <?php if ($u['role'] !== 'admin'): ?>
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Toggle Status -->
                                    <form action="index.php?page=admin&action=toggle_status" method="POST" class="inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                        <button type="submit"
                                            class="text-xs px-2 py-1 rounded border
                                            <?= ($u['is_active'] ?? 1) ? 'border-yellow-400 text-yellow-600 hover:bg-yellow-50' : 'border-green-400 text-green-600 hover:bg-green-50' ?>">
                                            <?= ($u['is_active'] ?? 1) ? 'Nonaktifkan' : 'Aktifkan' ?>
                                        </button>
                                    </form>

                                    <!-- Reset Password -->
                                    <form action="index.php?page=admin&action=reset_password" method="POST" class="inline"
                                        onsubmit="return confirm('Reset password user ini ke password123?')">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                        <button type="submit"
                                            class="text-xs px-2 py-1 rounded border border-blue-400 text-blue-600 hover:bg-blue-50">
                                            Reset Pass
                                        </button>
                                    </form>

                                    <!-- Delete -->
                                    <form action="index.php?page=admin&action=delete_user" method="POST" class="inline"
                                        onsubmit="return confirm('Yakin ingin menghapus user ini? Semua data terkait akan ikut terhapus!')">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                        <button type="submit"
                                            class="text-xs px-2 py-1 rounded border border-red-400 text-red-600 hover:bg-red-50">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <span class="text-gray-400 text-xs">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$content = ob_get_clean();
include dirname(__DIR__) . '/layouts/app.php';
?>