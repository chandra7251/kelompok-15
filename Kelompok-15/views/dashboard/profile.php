<?php
$title = 'Profile';
ob_start();
$photoPath = auth()['photo'] ? 'uploads/photos/' . auth()['photo'] : null;
?>

<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Profile Saya</h1>

    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-center gap-6 mb-6">
            <!-- Profile Photo -->
            <div class="relative group">
                <?php if ($photoPath): ?>
                    <img src="<?= e($photoPath) ?>" alt="Profile Photo"
                        class="w-24 h-24 rounded-full object-cover border-4 border-indigo-100">
                <?php else: ?>
                    <div
                        class="w-24 h-24 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center border-4 border-indigo-100">
                        <span class="text-3xl font-bold text-white"><?= strtoupper(substr(auth()['nama'], 0, 1)) ?></span>
                    </div>
                <?php endif; ?>

                <!-- Edit overlay -->
                <label
                    class="absolute inset-0 bg-black/50 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 cursor-pointer transition-opacity">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <form id="photoForm" action="index.php?page=profile&action=update_photo" method="POST"
                        enctype="multipart/form-data" class="hidden">
                        <?= csrf_field() ?>
                        <input type="file" name="photo" id="photoInput" accept="image/*"
                            onchange="document.getElementById('photoForm').submit()">
                    </form>
                </label>
            </div>

            <div class="text-center sm:text-left">
                <h2 class="text-xl font-semibold text-gray-800"><?= e(auth()['nama']) ?></h2>
                <p class="text-gray-500 capitalize"><?= e(auth()['role']) ?></p>

                <!-- Photo Actions -->
                <div class="flex gap-2 mt-3">
                    <label for="photoInput"
                        class="text-sm text-indigo-600 hover:text-indigo-700 cursor-pointer font-medium">
                        📷 Ubah Foto
                    </label>
                    <?php if ($photoPath): ?>
                        <form action="index.php?page=profile&action=delete_photo" method="POST" class="inline"
                            onsubmit="return confirm('Hapus foto profil?')">
                            <?= csrf_field() ?>
                            <button type="submit" class="text-sm text-red-600 hover:text-red-700 font-medium">
                                🗑️ Hapus
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
                <p class="text-xs text-gray-400 mt-1">Max 2MB (JPG, PNG, GIF, WebP)</p>
            </div>
        </div>

        <div class="space-y-4">
            <div class="flex justify-between py-3 border-b">
                <span class="text-gray-600">Email</span>
                <span class="font-medium"><?= e(auth()['email']) ?></span>
            </div>
            <?php if (is_role('mahasiswa') && isset(auth()['nim'])): ?>
                <div class="flex justify-between py-3 border-b">
                    <span class="text-gray-600">NIM</span>
                    <span class="font-medium"><?= e(auth()['nim']) ?></span>
                </div>
                <div class="flex justify-between py-3 border-b">
                    <span class="text-gray-600">Jurusan</span>
                    <span class="font-medium"><?= e(auth()['jurusan'] ?? '-') ?></span>
                </div>
                <div class="flex justify-between py-3 border-b">
                    <span class="text-gray-600">Saldo</span>
                    <span class="font-medium text-green-600"><?= format_rupiah(auth()['saldo'] ?? 0) ?></span>
                </div>
                <div class="flex justify-between py-3 border-b">
                    <span class="text-gray-600">Kode Pairing</span>
                    <span class="font-mono font-bold text-indigo-600"><?= e(auth()['pairing_code'] ?? '-') ?></span>
                </div>
            <?php endif; ?>
            <?php if (is_role('orangtua') && isset(auth()['no_telepon'])): ?>
                <div class="flex justify-between py-3 border-b">
                    <span class="text-gray-600">No. Telepon</span>
                    <span class="font-medium"><?= e(auth()['no_telepon']) ?></span>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="font-semibold text-gray-800 mb-4">🔒 Ubah Password</h3>
        <form action="index.php?page=profile&action=update_password" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Lama</label>
                <input type="password" name="old_password" required minlength="6"
                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                <input type="password" name="new_password" required minlength="6"
                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                <input type="password" name="confirm_password" required minlength="6"
                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>
            <button type="submit"
                class="w-full bg-indigo-600 text-white py-2 rounded-lg font-medium hover:bg-indigo-700 transition-colors">
                Ubah Password
            </button>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include dirname(__DIR__) . '/layouts/app.php';
?>