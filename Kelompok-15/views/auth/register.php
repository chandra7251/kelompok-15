<?php
$title = 'Register';
ob_start();
?>

<h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Buat Akun Baru</h2>

<!-- Role Tabs -->
<div class="flex bg-gray-100 rounded-xl p-1 mb-6">
    <button type="button" onclick="switchRole('mahasiswa')" id="tab-mahasiswa"
        class="flex-1 py-2 text-sm font-medium rounded-lg transition role-tab active">
        Mahasiswa
    </button>
    <button type="button" onclick="switchRole('orangtua')" id="tab-orangtua"
        class="flex-1 py-2 text-sm font-medium rounded-lg transition role-tab">
        Orang Tua
    </button>
</div>

<form action="index.php?page=register&action=submit" method="POST" class="space-y-4">
    <?= csrf_field() ?>
    <input type="hidden" name="role" id="role-input" value="mahasiswa">

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
        <input type="text" name="nama" value="<?= old('nama') ?>" required
            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input type="email" name="email" value="<?= old('email') ?>" required
            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
    </div>

    <!-- Mahasiswa Fields -->
    <div id="mahasiswa-fields">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">NIM</label>
            <input type="text" name="nim" value="<?= old('nim') ?>"
                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
            <input type="text" name="jurusan" value="<?= old('jurusan') ?>"
                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
        </div>
    </div>

    <!-- Orangtua Fields -->
    <div id="orangtua-fields" class="hidden">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
            <input type="text" name="no_telepon" value="<?= old('no_telepon') ?>"
                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input type="password" name="password" required minlength="6"
            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
        <input type="password" name="password_confirm" required
            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
    </div>

    <button type="submit"
        class="w-full bg-indigo-600 text-white py-3 rounded-xl font-semibold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
        Daftar
    </button>
</form>

<div class="mt-6 text-center">
    <p class="text-gray-600">Sudah punya akun?</p>
    <a href="index.php?page=login" class="text-indigo-600 font-medium hover:text-indigo-700">Masuk Sekarang</a>
</div>

<script>
    function switchRole(role) {
        document.getElementById('role-input').value = role;
        document.getElementById('mahasiswa-fields').classList.toggle('hidden', role !== 'mahasiswa');
        document.getElementById('orangtua-fields').classList.toggle('hidden', role !== 'orangtua');

        document.querySelectorAll('.role-tab').forEach(tab => {
            tab.classList.remove('bg-white', 'shadow', 'text-indigo-600');
            tab.classList.add('text-gray-500');
        });
        document.getElementById('tab-' + role).classList.add('bg-white', 'shadow', 'text-indigo-600');
        document.getElementById('tab-' + role).classList.remove('text-gray-500');
    }
    switchRole('mahasiswa');
</script>

<?php
$content = ob_get_clean();
include dirname(__DIR__) . '/layouts/auth.php';
?>