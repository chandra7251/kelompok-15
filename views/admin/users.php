<?php
$title = 'Manajemen User';
ob_start();
?>

<div class="py-6 sm:py-8 px-3 sm:px-6 max-w-full overflow-x-hidden">
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <p class="text-[#B3C9D8] text-sm sm:text-base">Kelola semua pengguna sistem</p>
            </div>
            <a href="/dashboard" class="text-[#00C6FB] hover:text-[#00F29C] text-sm font-medium transition-colors">←
                Kembali
                ke Dashboard</a>
        </div>
    </div>

    <!-- Mobile Card Layout -->
    <div class="md:hidden space-y-4">
        <?php foreach ($users as $u): ?>
            <div class="bg-[#16304d] border border-white/5 rounded-xl p-4 shadow-lg">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-gradient-to-br from-[#00C6FB] to-[#00F29C] flex items-center justify-center text-white font-bold">
                            <?= strtoupper(substr($u['nama'], 0, 1)) ?>
                        </div>
                        <div>
                            <p class="font-medium text-white text-sm"><?= e($u['nama']) ?></p>
                            <p class="text-[#B3C9D8] text-xs"><?= e($u['email']) ?></p>
                        </div>
                    </div>
                    <span class="px-2 py-1 rounded-full text-xs font-medium border
                        <?php if ($u['role'] === 'admin'): ?>bg-rose-500/20 text-rose-300 border-rose-500/30
                        <?php elseif ($u['role'] === 'mahasiswa'): ?>bg-[#00C6FB]/20 text-[#00C6FB] border-[#00C6FB]/30
                        <?php else: ?>bg-[#00F29C]/20 text-[#00F29C] border-[#00F29C]/30<?php endif; ?>">
                        <?= ucfirst(e($u['role'])) ?>
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-2 text-xs mb-3">
                    <?php if ($u['nim'] ?? null): ?>
                        <div>
                            <span class="text-[#B3C9D8]">NIM:</span>
                            <span class="text-white ml-1"><?= e($u['nim']) ?></span>
                        </div>
                    <?php endif; ?>
                    <div>
                        <span class="text-[#B3C9D8]">Saldo:</span>
                        <span
                            class="text-[#00F29C] font-medium ml-1"><?= $u['saldo'] ? format_rupiah($u['saldo']) : '-' ?></span>
                    </div>
                    <div>
                        <span class="text-[#B3C9D8]">Status:</span>
                        <?php if (($u['is_active'] ?? 1) == 1): ?>
                            <span class="text-[#00F29C] ml-1">Aktif</span>
                        <?php else: ?>
                            <span class="text-gray-400 ml-1">Nonaktif</span>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($u['role'] !== 'admin'): ?>
                    <div class="flex flex-wrap gap-2 pt-3 border-t border-white/10">
                        <form action="/admin/toggle_status" method="POST" class="inline">
                            <?= csrf_field() ?>
                            <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                            <button type="submit"
                                class="text-xs px-3 py-1.5 rounded-lg border transition-colors
                                <?= ($u['is_active'] ?? 1) ? 'border-yellow-500/50 text-yellow-400 hover:bg-yellow-500/10' : 'border-[#00F29C]/50 text-[#00F29C] hover:bg-[#00F29C]/10' ?>">
                                <?= ($u['is_active'] ?? 1) ? 'Nonaktifkan' : 'Aktifkan' ?>
                            </button>
                        </form>
                        <form action="/admin/reset_password" method="POST" class="inline"
                            onsubmit="return confirm('Reset password ke password123?')">
                            <?= csrf_field() ?>
                            <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                            <button type="submit"
                                class="text-xs px-3 py-1.5 rounded-lg border border-[#00C6FB]/50 text-[#00C6FB] hover:bg-[#00C6FB]/10 transition-colors">
                                Reset Pass
                            </button>
                        </form>
                        <form action="/admin/delete_user" method="POST" class="inline"
                            onsubmit="return confirm('Yakin hapus user ini?')">
                            <?= csrf_field() ?>
                            <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                            <button type="submit"
                                class="text-xs px-3 py-1.5 rounded-lg border border-red-500/50 text-red-400 hover:bg-red-500/10 transition-colors">
                                Hapus
                            </button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Desktop Table Layout -->
    <div class="hidden md:block bg-[#16304d] border border-white/5 rounded-2xl shadow-lg overflow-hidden">
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
                                        <form action="/admin/toggle_status" method="POST" class="inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                            <button type="submit"
                                                class="text-xs px-2 py-1 rounded border transition-colors
                                                <?= ($u['is_active'] ?? 1) ? 'border-yellow-500/50 text-yellow-400 hover:bg-yellow-500/10' : 'border-[#00F29C]/50 text-[#00F29C] hover:bg-[#00F29C]/10' ?>">
                                                <?= ($u['is_active'] ?? 1) ? 'Nonaktifkan' : 'Aktifkan' ?>
                                            </button>
                                        </form>
                                        <form action="/admin/reset_password" method="POST" class="inline"
                                            onsubmit="return confirm('Reset password user ini ke password123?')">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                            <button type="submit"
                                                class="text-xs px-2 py-1 rounded border border-[#00C6FB]/50 text-[#00C6FB] hover:bg-[#00C6FB]/10 transition-colors">
                                                Reset Pass
                                            </button>
                                        </form>
                                        <form action="/admin/delete_user" method="POST" class="inline"
                                            onsubmit="return confirm('Yakin ingin menghapus user ini?')">
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