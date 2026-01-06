<?php
$title = 'Reset Password';
$waveFrom = '#10b981';
$waveTo = '#06b6d4';
ob_start();
?>

<style>
    .no-scrollbar::-webkit-scrollbar,
    ::-webkit-scrollbar {
        display: none;
    }

    .no-scrollbar,
    html,
    body {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<div class="w-full max-w-[1750px] mx-auto px-4 sm:px-8 lg:px-24 min-h-screen flex items-stretch relative z-10">
    <div class="absolute top-6 sm:top-12 left-4 sm:left-8 lg:left-24 flex items-center gap-2 sm:gap-3">
        <div
            class="w-10 h-10 bg-[linear-gradient(135deg,#10b981,#06b6d4)] rounded-xl flex items-center justify-center shadow-lg shadow-[#10b981]/20">
            <span class="text-[#203351] font-bold text-lg">K</span>
        </div>
        <span
            class="text-xl font-bold bg-gradient-to-r from-[#10b981] to-[#06b6d4] bg-clip-text text-transparent">KeuanganKu</span>
    </div>

    <div class="grid lg:grid-cols-12 w-full gap-16 lg:gap-24 items-stretch">
        <div class="hidden lg:flex lg:col-span-7 space-y-6 flex-col justify-center pt-[10rem]">
            <div class="space-y-2">
                <h1 class="text-[5rem] lg:text-[6rem] leading-[1.0] font-[900] tracking-tight"
                    style="background: linear-gradient(to right, #10b981, #06b6d4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; filter: drop-shadow(0 0 12px rgba(16, 185, 129, 0.3)) drop-shadow(0 0 24px rgba(6, 182, 212, 0.2));">
                    KeuanganKu
                </h1>
                <h2 class="text-2xl lg:text-3xl font-bold text-[#EAF6FF] tracking-normal pl-8">
                    Reset Password
                </h2>
                <p class="text-[#EAF6FF] text-sm tracking-widest uppercase opacity-60 mt-8 max-w-xl font-medium pl-10">
                    Buat password baru untuk akun Anda.
                </p>
            </div>

            <br><br>

            <div class="pt-10 space-y-12">
                <h3 class="text-emerald-400 font-bold uppercase tracking-[0.1em]">HAMPIR SELESAI</h3>

                <div class="space-y-6">
                    <div class="flex items-start gap-5 group">
                        <div
                            class="w-12 h-12 rounded-xl border border-emerald-500/20 flex items-center justify-center shrink-0 bg-[#0b1324]/80 group-hover:bg-emerald-900/30 transition shadow-lg">
                            <svg class="w-6 h-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-white font-bold text-sm leading-snug">Langkah Terakhir</p>
                            <p class="text-gray-500 text-xs mt-1 leading-snug">Masukkan password baru Anda dan
                                konfirmasi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-5 flex flex-col justify-center lg:justify-end items-center pb-8 lg:pb-0 pt-24 lg:pt-0">
            <div class="w-full max-w-[400px] lg:max-w-[640px] relative lg:transform lg:-translate-x-12">

                <div class="absolute left-1/2 -translate-x-1/2 -top-14 sm:-top-20 z-20">
                    <div
                        class="w-28 h-28 sm:w-44 sm:h-44 rounded-[2rem] sm:rounded-[3rem] bg-gradient-to-b from-emerald-400 to-cyan-500 p-1 shadow-[0_10px_50px_rgba(16,185,129,0.4)] flex items-center justify-center">
                        <div
                            class="w-full h-full rounded-[1.8rem] sm:rounded-[2.8rem] bg-gradient-to-b from-emerald-400 to-cyan-500 flex items-center justify-center relative overflow-hidden">
                            <svg class="w-16 h-16 sm:w-24 sm:h-24 text-white drop-shadow-md" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <div class="absolute top-6 left-6 w-12 h-12 bg-white/20 blur-xl rounded-full"></div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-[#0E2A3F] rounded-t-[2rem] sm:rounded-t-[3rem] rounded-b-none px-6 sm:px-12 pt-20 sm:pt-32 pb-8 sm:pb-12 shadow-2xl relative border border-gray-800/20">

                    <h2
                        class="text-white text-center text-xl sm:text-2xl font-bold tracking-[0.15em] sm:tracking-[0.2em] mb-4 uppercase">
                        RESET PASSWORD</h2>
                    <p class="text-gray-400 text-center text-xs sm:text-sm mb-8 sm:mb-12">
                        Halo <strong class="text-emerald-400">
                            <?= htmlspecialchars($nama ?? '') ?>
                        </strong>, masukkan password baru Anda.
                    </p>

                    <form action="/reset_password/submit" method="POST" class="space-y-6">
                        <?= csrf_field() ?>
                        <input type="hidden" name="token" value="<?= htmlspecialchars($token ?? '') ?>">

                        <!-- Password Baru -->
                        <div class="group">
                            <label class="text-gray-400 text-xs uppercase tracking-wider mb-2 block">Password
                                Baru</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                                    <svg class="w-6 h-6 text-gray-500/60 stroke-current group-focus-within:text-emerald-400 transition"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input type="password" name="password" id="password" required minlength="6"
                                    class="w-full h-14 sm:h-16 bg-[#0A2E45]/80 text-white text-sm sm:text-base border border-[#1B4257] rounded-xl sm:rounded-2xl pl-14 sm:pl-16 pr-4 sm:pr-6 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition-all placeholder-gray-500/50 font-medium"
                                    placeholder="Minimal 6 karakter">
                            </div>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="group">
                            <label class="text-gray-400 text-xs uppercase tracking-wider mb-2 block">Konfirmasi
                                Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                                    <svg class="w-6 h-6 text-gray-500/60 stroke-current group-focus-within:text-emerald-400 transition"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <input type="password" name="confirm_password" id="confirm_password" required
                                    minlength="6"
                                    class="w-full h-14 sm:h-16 bg-[#0A2E45]/80 text-white text-sm sm:text-base border border-[#1B4257] rounded-xl sm:rounded-2xl pl-14 sm:pl-16 pr-4 sm:pr-6 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition-all placeholder-gray-500/50 font-medium"
                                    placeholder="Ulangi password baru">
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full h-14 sm:h-16 bg-gradient-to-r from-emerald-400 to-cyan-500 rounded-xl sm:rounded-2xl text-white font-[900] text-lg sm:text-xl tracking-[0.08em] sm:tracking-[0.1em] hover:shadow-[0_0_30px_rgba(16,185,129,0.4)] transition-all transform hover:-translate-y-0.5 uppercase">
                            Simpan Password Baru
                        </button>
                    </form>

                    <div class="mt-8 mb-4">
                        <div class="flex items-center justify-between gap-4">
                            <div class="h-[2px] w-full bg-black rounded-full"></div>
                            <a href="/login"
                                class="text-gray-400 hover:text-white text-sm font-[800] uppercase tracking-widest whitespace-nowrap px-2 transition-colors flex items-center gap-2">
                                <span>←</span> KEMBALI KE LOGIN
                            </a>
                            <div class="h-[2px] w-full bg-black rounded-full"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<?php
$content = ob_get_clean();
include dirname(__DIR__) . '/layouts/auth.php';
?>