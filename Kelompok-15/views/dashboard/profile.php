<?php
$title = 'Profile';
ob_start();
?>

<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Profile Saya</h1>

    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex items-center space-x-4 mb-6">
            <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center">
                <span class="text-2xl font-bold text-indigo-600"><?= strtoupper(substr(auth()['nama'], 0, 1)) ?></span>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-800"><?= e(auth()['nama']) ?></h2>
                <p class="text-gray-500 capitalize"><?= e(auth()['role']) ?></p>
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
        <h3 class="font-semibold text-gray-800 mb-4">Ubah Password</h3>
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
                class="w-full bg-indigo-600 text-white py-2 rounded-lg font-medium hover:bg-indigo-700">Ubah
                Password</button>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include dirname(__DIR__) . '/layouts/app.php';
?>