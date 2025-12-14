<?php
$title = 'Login';
ob_start();
?>

<h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Masuk ke Akun</h2>

<form action="index.php?page=login&action=submit" method="POST" class="space-y-5">
    <?= csrf_field() ?>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
        <input type="email" name="email" value="<?= old('email') ?>" required
            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
            placeholder="email@example.com">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
        <input type="password" name="password" required
            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
            placeholder="••••••••">
    </div>

    <div class="flex justify-end">
        <a href="index.php?page=forgot_password" class="text-sm text-indigo-600 hover:text-indigo-700">Lupa
            Password?</a>
    </div>

    <button type="submit"
        class="w-full bg-indigo-600 text-white py-3 rounded-xl font-semibold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
        Masuk
    </button>
</form>

<div class="mt-6 text-center">
    <p class="text-gray-600">Belum punya akun?</p>
    <a href="index.php?page=register" class="text-indigo-600 font-medium hover:text-indigo-700">Daftar Sekarang</a>
</div>

<?php
$content = ob_get_clean();
include dirname(__DIR__) . '/layouts/auth.php';
?>