<?php
$title = 'Lupa Password';
ob_start();
?>

<h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Lupa Password</h2>

<form action="index.php?page=forgot_password&action=submit" method="POST" class="space-y-5">
    <?= csrf_field() ?>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
        <input type="email" name="email" required
            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
            placeholder="email@example.com">
    </div>

    <button type="submit"
        class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700">Kirim Link
        Reset</button>
</form>

<div class="mt-6 text-center">
    <a href="index.php?page=login" class="text-indigo-600 font-medium hover:text-indigo-700">Kembali ke Login</a>
</div>

<?php
$content = ob_get_clean();
include dirname(__DIR__) . '/layouts/auth.php';
?>