<?php
$title = 'Manajemen User';
ob_start();
?>

<div class="py-8 px-6">
    <div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-[#B3C9D8]">Kelola semua pengguna sistem</p>
        </div>
        <a href="index.php?page=dashboard" class="text-[#00C6FB] hover:text-[#00F29C] text-sm font-medium transition-colors">← Kembali
            ke Dashboard</a>
    </div>
</div>

<div class="bg-[#16304d] border border-white/5 rounded-2xl shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50/0 border-b border-white/5">
                <tr class="text-[#B3C9D8]">
                    <th class="text-left py-3 px-4 font-medium">ID</th>
                    <th class="text-left py-3 px-4 font-medium">Nama</th>
                    <th class="text-left py-3 px-4 font-medium">Email</th>
                    <th class="text-left py-3 px-4 font-medium">Role</th>
                    <th class="text-left py-3 px-4 font-medium">NIM</th>
                    <th class="text-right py-3 px-4 font-medium">Saldo</th>
                    <th class="text-center py-3 px-4 font-medium">Status</th>
                    <th class="text-center py-3 px-4 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                        <td class="py-3 px-4 text-[#B3C9D8]"><?= $u['id'] ?></td>
                        <td class="py-3 px-4 font-medium text-white"><?= e($u['nama']) ?></td>
                        <td class="py-3 px-4 text-[#B3C9D8]"><?= e($u['email']) ?></td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 rounded-full text-xs font-medium border
                                <?php if ($u['role'] === 'admin'): ?>bg-rose-500/20 text-rose-300 border-rose-500/30
                                <?php elseif ($u['role'] === 'mahasiswa'): ?>bg-[#00C6FB]/20 text-[#00C6FB] border-[#00C6FB]/30
                                <?php else: ?>bg-[#00F29C]/20 text-[#00F29C] border-[#00F29C]/30<?php endif; ?>">
                                <?= ucfirst(e($u['role'])) ?>
                            </span>
                        </td>
                        <td class="py-3 px-4 text-[#B3C9D8]"><?= $u['nim'] ?? '-' ?></td>
                        <td class="py-3 px-4 text-right font-medium text-white whitespace-nowrap">
                            <?= $u['saldo'] ? format_rupiah($u['saldo']) : '-' ?>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <?php if (($u['is_active'] ?? 1) == 1): ?>
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-medium bg-[#00F29C]/20 text-[#00F29C] border border-[#00F29C]/30">Aktif</span>
                            <?php else: ?>
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-medium bg-[#B3C9D8]/20 text-[#B3C9D8] border border-white/20">Nonaktif</span>
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
                                            class="text-xs px-2 py-1 rounded border transition-colors
                                            <?= ($u['is_active'] ?? 1) ? 'border-yellow-500/50 text-yellow-400 hover:bg-yellow-500/10' : 'border-[#00F29C]/50 text-[#00F29C] hover:bg-[#00F29C]/10' ?>">
                                            <?= ($u['is_active'] ?? 1) ? 'Nonaktifkan' : 'Aktifkan' ?>
                                        </button>
                                    </form>

                                    <!-- Reset Password -->
                                    <form action="index.php?page=admin&action=reset_password" method="POST" class="inline"
                                        onsubmit="return confirm('Reset password user ini ke password123?')">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                        <button type="submit"
                                            class="text-xs px-2 py-1 rounded border border-[#00C6FB]/50 text-[#00C6FB] hover:bg-[#00C6FB]/10 transition-colors">
                                            Reset Pass
                                        </button>
                                    </form>

                                    <!-- Delete -->
                                    <form action="index.php?page=admin&action=delete_user" method="POST" class="inline"
                                        onsubmit="return confirm('Yakin ingin menghapus user ini? Semua data terkait akan ikut terhapus!')">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                        <button type="submit"
                                            class="text-xs px-2 py-1 rounded border border-red-500/50 text-red-400 hover:bg-red-500/10 transition-colors">
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
</div>

<?php
$content = ob_get_clean();
include dirname(__DIR__) . '/layouts/app.php';
?>