<?php
$title = 'Lupa Password';
// Define Wave Gradient Colors for Layout (Rose to Pink)
$waveFrom = '#fb7185';
$waveTo = '#ec4899';
ob_start();
?>

<style>
    /* Menghilangkan Scroll Bar pada browser */
    .no-scrollbar::-webkit-scrollbar, ::-webkit-scrollbar {
        display: none;
    }
    
    .no-scrollbar, html, body {
        -ms-overflow-style: none;  
        scrollbar-width: none;  
    }
</style>

<div class="w-full max-w-[1750px] mx-auto px-8 lg:px-24 min-h-screen flex items-stretch relative z-10">
    <!-- Logo Header -->
    <div class="absolute top-12 left-8 lg:left-24 flex items-center gap-3">
        <div class="w-10 h-10 bg-[linear-gradient(135deg,#fb7185,#ec4899)] rounded-xl flex items-center justify-center shadow-lg shadow-[#fb7185]/20">
            <span class="text-[#203351] font-bold text-lg">K</span>
        </div>
        <span class="text-xl font-bold bg-gradient-to-r from-[#fb7185] to-[#ec4899] bg-clip-text text-transparent">KeuanganKu</span>
    </div>

    <div class="grid lg:grid-cols-12 w-full gap-16 lg:gap-24 items-stretch">
        
        <!-- Bagian kiri: Konten Branding -->
        <div class="lg:col-span-7 space-y-6 flex flex-col justify-center pt-[10rem]">
            <div class="space-y-2">
                <!-- Branding Text Gradient: Rose to Pink -->
                <h1 class="text-[5rem] lg:text-[6rem] leading-[1.0] font-[900] tracking-tight" 
                    style="background: linear-gradient(to right, #fb7185, #ec4899); -webkit-background-clip: text; -webkit-text-fill-color: transparent; filter: drop-shadow(0 0 12px rgba(251, 113, 133, 0.3)) drop-shadow(0 0 24px rgba(236, 72, 153, 0.2));">
                    KeuanganKu
                </h1>
                <h2 class="text-2xl lg:text-3xl font-bold text-[#EAF6FF] tracking-normal pl-8">
                    Recovery Center
                </h2>
                <p class="text-[#EAF6FF] text-sm tracking-widest uppercase opacity-60 mt-8 max-w-xl font-medium pl-10">
                    Kami akan membantu memulihkan akses akun anda dengan aman.
                </p>
            </div>

            <br><br>

            <!-- Fitur List -->
            <div class="pt-10 space-y-12">
                <h3 class="text-rose-400 font-bold uppercase tracking-[0.1em]">SECURITY FIRST</h3>
                
                <div class="space-y-6">
                    <div class="flex items-start gap-5 group">
                        <!-- Icon Box: Rose Accents -->
                        <div class="w-12 h-12 rounded-xl border border-rose-500/20 flex items-center justify-center shrink-0 bg-[#0b1324]/80 group-hover:bg-rose-900/30 transition shadow-lg">
                            <svg class="w-6 h-6 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-white font-bold text-sm leading-snug">Secure Account Recovery</p>
                            <p class="text-gray-500 text-xs mt-1 leading-snug">Proses reset password terenkripsi end-to-end.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Forgot Password Card -->
        <div class="lg:col-span-5 flex flex-col justify-end items-center pb-0">
            <div class="w-full max-w-[640px] relative transform lg:-translate-x-12">
                
                <!-- Floating Icon: Rose/Pink Gradient -->
                <div class="absolute left-1/2 -translate-x-1/2 -top-20 z-20">
                    <div class="w-44 h-44 rounded-[3rem] bg-gradient-to-b from-rose-400 to-pink-500 p-1 shadow-[0_10px_50px_rgba(244,63,94,0.4)] flex items-center justify-center">
                        <div class="w-full h-full rounded-[2.8rem] bg-gradient-to-b from-rose-400 to-pink-500 flex items-center justify-center relative overflow-hidden">
                             <svg class="w-24 h-24 text-white drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                            <div class="absolute top-6 left-6 w-12 h-12 bg-white/20 blur-xl rounded-full"></div>
                        </div>
                    </div>
                </div>

                <!-- Body Card -->
                <div class="bg-[#0E2A3F] rounded-t-[3rem] rounded-b-none px-12 pt-32 pb-12 pr-12 shadow-2xl relative border border-gray-800/20">
                    
                    <h2 class="text-white text-center text-2xl font-bold tracking-[0.2em] mb-4 uppercase">FORGOT PASSWORD</h2>
                    <p class="text-gray-400 text-center text-sm mb-12">Masukkan email yang terdaftar untuk menerima link reset.</p>

                    <form action="index.php?page=forgot_password&action=submit" method="POST" class="space-y-8">
                        <?= csrf_field() ?>

                        <!-- Input Field Email -->
                        <div class="group">
                             <div class="relative">
                                <!-- Icon Container: Rose on Focus -->
                                <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                                    <svg class="w-7 h-7 text-gray-500/60 stroke-current group-focus-within:text-rose-400 transition" fill="none" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                                <input type="email" name="email" required
                                    class="w-full h-16 bg-[#0A2E45]/80 text-white border border-[#1B4257] rounded-2xl pl-16 pr-6 focus:ring-1 focus:ring-rose-500 focus:border-rose-500 transition-all placeholder-gray-500/50 font-medium tracking-wider text-base"
                                    placeholder="email@example.com">
                            </div>
                        </div>

                        <!-- Submit Button: Rose/Pink Gradient -->
                         <button type="submit" class="w-full h-16 bg-gradient-to-r from-rose-400 to-pink-500 rounded-2xl text-white font-[900] text-xl tracking-[0.1em] hover:shadow-[0_0_30px_rgba(244,63,94,0.4)] transition-all transform hover:-translate-y-0.5 uppercase">
                            Kirim Link Reset
                        </button>
                    </form>

                    <div class="mt-8 mb-4">
                        <div class="flex items-center justify-between gap-4">
                            <div class="h-[2px] w-full bg-black rounded-full"></div>
                            <a href="index.php?page=login" class="text-gray-400 hover:text-white text-sm font-[800] uppercase tracking-widest whitespace-nowrap px-2 transition-colors flex items-center gap-2">
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