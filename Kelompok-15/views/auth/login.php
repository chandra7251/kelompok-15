<?php
$title = 'Login';
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

<div class="w-full max-w-[1750px] mx-auto px-8 lg:px-24 min-h-screen flex items-stretch relative z-10">

    <div class="absolute top-12 left-8 lg:left-24 flex items-center gap-3">
        <div
            class="w-10 h-10 bg-[linear-gradient(135deg,#4ED4FF,#6AF5C9)] rounded-xl flex items-center justify-center shadow-lg  shadow-[#4ED4FF]/20">
            <span class="text-[#203351] font-bold text-lg">K</span>
        </div>
        <span
            class="text-xl font-bold bg-gradient-to-r from-[#00C6FB] to-[#00F29C] bg-clip-text text-transparent">KeuanganKu</span>
    </div>

    <div class="grid lg:grid-cols-12 w-full gap-16 lg:gap-24 items-stretch">


        <div class="lg:col-span-7 space-y-6 flex flex-col justify-center pt-20 relative z-20">
            <div class="space-y-2">
                <h1 class="text-[5rem] lg:text-[6rem] leading-tight pb-4 font-[900] tracking-tight"
                    style="background: linear-gradient(to right, #00C6FB, #00F29C); -webkit-background-clip: text; -webkit-text-fill-color: transparent; filter: drop-shadow(0 0 12px rgba(0, 242, 156, 0.22)) drop-shadow(0 0 24px rgba(0, 198, 251, 0.10));">
                    KeuanganKu
                </h1>
                <h2 class="text-2xl lg:text-3xl font-bold text-[#EAF6FF] tracking-normal pl-8">
                    Nama Website nya
                </h2>
                <p class="text-[#EAF6FF] text-sm tracking-widest uppercase opacity-60 mt-8 max-w-xl font-medium pl-10">
                    Deskripsi Singkat Web Lorem Ipsum Eak asjdoajdoeajdoajdoads
                </p>
            </div>

            <br><br>

            <div class="pt-10 space-y-8">
                <h3 class="text-cyan-400 font-bold uppercase pb-4
                
                tracking-[0.1em] relative z-50">WHAT WE CAN DO?</h3>

                <div class="space-y-6">
                    <?php
                    $features = [
                        ['icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'],
                        ['icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                        ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ];
                    foreach ($features as $f):
                        ?>
                        <div class="flex items-start gap-5 group">
                            <div
                                class="w-12 h-12 rounded-xl border border-cyan-500/20 flex items-center justify-center shrink-0 bg-[#0b1324]/80 group-hover:bg-cyan-900/30 transition shadow-lg">
                                <svg class="w-6 h-6 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="<?= $f['icon'] ?>" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-white font-bold text-sm leading-snug">Mahasiswa Bisa Bayar UKT Kata Kata
                                    Lorem ipsum (Bahasa Inggris baris 1)</p>
                                <p class="text-gray-500 text-xs mt-1 leading-snug">Mahasiswa Kata Kata Lorem ipsum (Bahasa
                                    Inggris baris 2)</p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>


        <div class="lg:col-span-5 flex flex-col justify-end items-center pb-0">
            <div class="w-full max-w-[640px] relative transform lg:-translate-x-12">

                <div class="absolute left-1/2 -translate-x-1/2 -top-20 z-20">
                    <div
                        class="w-44 h-44 rounded-[3rem] bg-gradient-to-b from-cyan-400 to-teal-500 p-1 shadow-[0_10px_50px_rgba(6,182,212,0.4)] flex items-center justify-center">
                        <div
                            class="w-full h-full rounded-[2.8rem] bg-gradient-to-b from-cyan-400 to-teal-500 flex items-center justify-center relative overflow-hidden">

                            <svg class="w-24 h-24 text-white drop-shadow-md" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>

                            <div class="absolute top-6 left-6 w-12 h-12 bg-white/20 blur-xl rounded-full"></div>
                        </div>
                    </div>
                </div>


                <div
                    class="bg-[#0E2A3F] rounded-t-[3rem] rounded-b-none px-12 pt-32 pb-12 pr-12 shadow-2xl relative border border-gray-800/20">

                    <h2 class="text-white text-center text-2xl font-bold tracking-[0.2em] mb-12 uppercase">LOGIN</h2>

                    <form action="index.php?page=login&action=submit" method="POST" class="space-y-8">
                        <?= csrf_field() ?>


                        <div class="group">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                                    <svg class="w-7 h-7 text-gray-500/60 stroke-current group-focus-within:text-cyan-400 transition"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <input type="email" name="email" value="<?= old('email') ?>" required
                                    class="w-full h-16 bg-[#0A2E45]/80 text-white border border-[#1B4257] rounded-2xl pl-16 pr-6 focus:ring-1 focus:ring-cyan-500 focus:border-cyan-500 transition-all placeholder-gray-500/50 font-medium tracking-wider text-base"
                                    placeholder="user@example.com">
                            </div>
                        </div>


                        <div class="group">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                                    <svg class="w-7 h-7 text-gray-500/60 stroke-current group-focus-within:text-cyan-400 transition"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input type="password" name="password" required
                                    class="w-full h-16 bg-[#0A2E45]/80 text-white border border-[#1B4257] rounded-2xl pl-16 pr-14 focus:ring-1 focus:ring-cyan-500 focus:border-cyan-500 transition-all placeholder-gray-500/50 font-medium tracking-wider text-base uppercase"
                                    placeholder="PASSWORD ••••">

                                <button type="button"
                                    class="absolute inset-y-0 right-0 pr-6 flex items-center text-[#6e4635] hover:text-cyan-400 transition opacity-60 hover:opacity-100">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>


                        <div class="flex justify-end -mt-4">
                            <a href="index.php?page=forgot_password"
                                class="text-sm font-semibold tracking-wide bg-gradient-to-r from-cyan-400 to-teal-400 bg-clip-text text-transparent hover:brightness-125 transition-all">
                                Lupa Password?
                            </a>
                        </div>


                        <button type="submit"
                            class="w-full h-16 bg-gradient-to-r from-cyan-400 to-teal-500 rounded-2xl text-[#02040a] font-[900] text-xl tracking-[0.1em] hover:shadow-[0_0_30px_rgba(34,211,238,0.4)] transition-all transform hover:-translate-y-0.5 uppercase">
                            Login
                        </button>
                    </form>


                    <div class="mt-8 mb-4">
                        <div class="text-center mb-6">
                            <span class="text-[#EAF6FF] text-lg font-bold tracking-widest">Didn't have account?</span>
                        </div>

                        <div class="flex items-center justify-between gap-4">

                            <div class="h-[2px] w-full bg-black rounded-full"></div>

                            <a href="index.php?page=register"
                                class="text-[#4facfe] hover:text-[#00f2fe] text-sm font-[800] uppercase tracking-widest whitespace-nowrap px-2 transition-colors">
                                SIGN UP
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