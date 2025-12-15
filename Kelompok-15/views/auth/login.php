<?php
$title = 'Login';
ob_start();
?>

<div class="animate-fadeInUp">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Masuk ke Akun</h2>
</div>

<form action="index.php?page=login&action=submit" method="POST" class="space-y-5">
    <?= csrf_field() ?>

    <div class="animate-fadeInUp stagger-1" style="animation-fill-mode: both;">
        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
        <input type="email" name="email" value="<?= old('email') ?>" required
            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition input-animated"
            placeholder="email@example.com">
    </div>

    <div class="animate-fadeInUp stagger-2" style="animation-fill-mode: both;">
        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
        <input type="password" name="password" required
            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition input-animated"
            placeholder="••••••••">
    </div>

    <div class="flex justify-end animate-fadeInUp stagger-3" style="animation-fill-mode: both;">
        <a href="index.php?page=forgot_password"
            class="text-sm text-indigo-600 hover:text-indigo-700 hover-scale inline-block">Lupa
            Password?</a>
    </div>

    <div class="animate-fadeInUp stagger-4" style="animation-fill-mode: both;">
        <button type="submit"
            class="w-full bg-indigo-600 text-white py-3 rounded-xl font-semibold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 btn-animated">
            Masuk
        </button>
    </div>
</form>

<div class="mt-6 text-center animate-fadeInUp stagger-5" style="animation-fill-mode: both;">
    <p class="text-gray-600">Belum punya akun?</p>
    <a href="index.php?page=register"
        class="text-indigo-600 font-medium hover:text-indigo-700 hover-scale inline-block">Daftar Sekarang</a>
</div>

<?php
$content = ob_get_clean();
include dirname(__DIR__) . '/layouts/auth.php';
?>