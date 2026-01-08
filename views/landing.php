<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KeuanganKu - Sistem Pengelolaan Keuangan Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'navy-dark': '#051933',
                        'navy': '#0A2547',
                        'navy-light': '#0E2A3F',
                        'teal-light': '#00C6FB',
                        'teal': '#00F29C',
                        'section-dark': '#0B1A2E',
                    }
                }
            }
        }
    </script>

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


        .gradient-text {
            background: linear-gradient(to right, #00C6FB, #00F29C);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .bg-hero {
            background: linear-gradient(180deg, #081F33 0%, #0B3148 100%);
        }

        .bg-section-dark {
            background: #0B1A2E;
        }

        .bg-section-wave {
            background: linear-gradient(180deg, #0A2547 0%, #0E3A4F 50%, #0A2547 100%);
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        .float-animation {
            animation: float 4s ease-in-out infinite;
        }
    </style>
</head>

<body class="bg-hero min-h-screen text-white">


    <section class="min-h-screen relative overflow-hidden bg-[#0A1929] flex flex-col justify-between">

        <header class="absolute top-0 left-0 right-0 z-50 px-8 lg:px-20 py-6">
            <div class="flex justify-between items-center">

                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-[linear-gradient(135deg,#4ED4FF,#6AF5C9)] rounded-xl flex items-center justify-center shadow-lg shadow-[#4ED4FF]/20">
                        <span class="text-[#203351] font-bold text-lg">K</span>
                    </div>
                    <span
                        class="text-2xl font-bold bg-gradient-to-r from-[#00C6FB] to-[#00F29C] bg-clip-text text-transparent">KeuanganKu</span>
                </div>

                <a href="/login"
                    class="px-7 py-2 bg-gradient-to-b from-[#00C6FB] to-[#00F29C] text-[#0A1929] rounded font-bold text-sm hover:shadow-lg hover:shadow-[#00C6FB]/40 transition-all">
                    Sign-in
                </a>
            </div>
        </header>


        <div class="container mx-auto px-8 lg:px-20 pt-32 pb-16 flex-grow flex items-center">
            <div class="grid lg:grid-cols-2 gap-16 w-full items-center">

                <div class="z-10 max-w-xl">
                    <h1 class="text-4xl lg:text-5xl font-bold leading-tight mb-6">
                        FINANCE WITH<br>
                        SMART HABBIT AND<br>
                        <span
                            class="bg-gradient-to-r from-[#00C6FB] to-[#00F29C] bg-clip-text text-transparent">FINANCIAL
                            AWARENESS</span>
                    </h1>
                    <p class="text-white/70 text-base leading-relaxed">
                        Kelola uang dengan lebih sadar, pantau pemasukan dan pengeluaran, serta jaga kesehatan finansial
                        agar keuangan tetap stabil dan terkontrol.
                    </p>
                </div>


                <div class="relative h-[450px] lg:h-[500px] flex items-center justify-center">



                    <div class="absolute top-20 left-0 lg:left-5 float-animation z-20 w-20 lg:w-24">
                        <img src="assets/images/landing/uploaded_image_1_1766308187391.png" alt="Calendar"
                            class="w-full drop-shadow-xl">
                    </div>


                    <div class="absolute top-5 left-1/4 lg:left-1/3 float-animation z-20 w-28 lg:w-32"
                        style="animation-delay: 0.3s;">
                        <img src="assets/images/landing/uploaded_image_2_1766308187391.png" alt="Coins"
                            class="w-full drop-shadow-xl">
                    </div>

                    < <div class="absolute top-8 right-5 lg:right-10 float-animation z-20 w-24 lg:w-28"
                        style="animation-delay: 0.6s;">
                        <img src="assets/images/landing/uploaded_image_3_1766308187391.png" alt="Docs"
                            class="w-full drop-shadow-xl">
                </div>


                <div class="relative z-10 w-full max-w-lg mx-auto">
                    <img src="assets/images/landing/uploaded_image_0_1766308187391.png" alt="Financial Dashboard"
                        class="w-full drop-shadow-2xl">
                </div>
            </div>
        </div>
        </div>


        <div class="absolute bottom-0 right-0 w-full lg:w-[70%] z-0 pointer-events-none">
            <svg class="w-full h-auto max-h-[120px] lg:max-h-[280px]" viewBox="0 0 1440 320" fill="none"
                preserveAspectRatio="none">
                <path fill="#1D8072" fill-opacity="0.8"
                    d="M0,320 C100,280 200,160 400,180 C600,200 700,270 900,230 C1100,190 1200,60 1440,100 V320 H0 Z">
                </path>
                <path fill="#2FAE9A" fill-opacity="1"
                    d="M0,320 C100,280 250,120 450,150 C650,180 750,260 950,210 C1150,160 1250,20 1440,70 V320 H0 Z">
                </path>
            </svg>
        </div>


        <div class="w-full bg-[#0E2A3F] py-6 border-t border-white/5 relative z-20">
            <div class="container mx-auto px-8 lg:px-20">
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">

                    <div class="flex items-center justify-center gap-2">
                        <div class="w-10 h-10 flex items-center justify-center rounded bg-white/5 flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <span class="text-white/80 text-xs lg:text-sm font-normal">Catat Setiap Transaksi</span>
                    </div>

                    <div class="flex items-center justify-center gap-2">
                        <div class="w-10 h-10 flex items-center justify-center rounded bg-white/5 flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <span class="text-white/80 text-xs lg:text-sm font-normal">Kelola Pemasukan dan
                            Pengeluaran</span>
                    </div>

                    <div class="flex items-center justify-center gap-2">
                        <div class="w-10 h-10 flex items-center justify-center rounded bg-white/5 flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                            </svg>
                        </div>
                        <span class="text-white/80 text-xs lg:text-sm font-normal">Pantau Grafik Keuangan mu</span>
                    </div>

                    <div class="flex items-center justify-center gap-2">
                        <div class="w-10 h-10 flex items-center justify-center rounded bg-white/5 flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <span class="text-white/80 text-xs lg:text-sm font-normal pr-40">Analitik</span>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="pt-[200px] bg-[#0B1C2E] relative overflow-hidden">



        <div class="container mx-auto px-8 lg:px-20 relative z-10 pb-16">
            <div class="grid lg:grid-cols-2 gap-16 items-center">

                <div class="relative">

                    <img src="assets/images/landing/uploaded_image_0_1766308295458.png" alt="Manage Finances"
                        class="w-full max-w-lg mx-auto drop-shadow-2xl relative z-10">


                </div>


                <div class="space-y-6 relative">




                    <h2 class="text-4xl lg:text-5xl font-bold text-white leading-tight">
                        MANAGE YOUR<br>
                        CHILD'S FINANCES
                    </h2>
                    <h3
                        class="text-2xl lg:text-3xl font-bold bg-gradient-to-r from-[#00C6FB] to-[#00F29C] bg-clip-text text-transparent pb-2">
                        SAFE AND RELIABLE MONITORING
                    </h3>

                    <p class="text-white/70 text-base leading-relaxed max-w-xl">
                        Awasi aktivitas keuangan anak secara real-time, lakukan transfer dengan aman, dan pastikan
                        penggunaan dana tetap terkendali dan bertanggung jawab.
                    </p>
                </div>
            </div>
        </div>


        <div class="w-full bg-[#0E2A3F] py-8 border-t border-white/5 relative z-20">
            <div class="container mx-auto px-8 lg:px-20">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                    <div class="flex items-center justify-center gap-3">
                        <div class="w-10 h-10 flex items-center justify-center rounded bg-white/5 flex-shrink-0">

                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <span class="text-white/80 text-sm font-medium">Transfer dengan Aman</span>
                    </div>

                    <div class="flex items-center justify-center gap-3">
                        <div class="w-10 h-10 flex items-center justify-center rounded bg-white/5 flex-shrink-0">

                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                        </div>
                        <span class="text-white/80 text-sm font-medium">Hubungkan Akun Anda dengan Anak</span>
                    </div>

                    <div class="flex items-center justify-center gap-3">
                        <div class="w-10 h-10 flex items-center justify-center rounded bg-white/5 flex-shrink-0">

                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <span class="text-white/80 text-sm font-medium">Pantau Keuangan Anak Anda</span>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="py-20 bg-[#0B1C2E] relative overflow-hidden">


        <div class="absolute -bottom-20 -left-20 w-64 h-64 border border-[#00C6FB]/20 rounded-full pointer-events-none">
        </div>
        <div class="absolute -bottom-28 -left-28 w-80 h-80 border border-[#00C6FB]/10 rounded-full pointer-events-none">
        </div>


        <div class="absolute -top-20 -right-20 w-64 h-64 border border-[#00C6FB]/20 rounded-full pointer-events-none">
        </div>
        <div class="absolute -top-28 -right-28 w-80 h-80 border border-[#00C6FB]/10 rounded-full pointer-events-none">
        </div>

        <div class="container mx-auto px-8 lg:px-16 relative z-10">

            <h2
                class="text-3xl lg:text-4xl font-bold bg-gradient-to-r from-[#00C6FB] to-[#00F29C] bg-clip-text text-transparent mb-12">
                WHAT WE CAN DO?
            </h2>

            <div class="grid lg:grid-cols-2 gap-16 items-center">

                <div class="relative float-animation">
                    <img src="assets/images/landing/uploaded_image_1766308348436.png" alt="Analytics Dashboard"
                        class="w-full max-w-lg drop-shadow-2xl">
                </div>


                <div class="space-y-4">

                    <div
                        class="bg-[#0E2A3F]/40 border border-[#00C6FB]/30 rounded-lg p-5 hover:bg-[#0E2A3F]/60 transition-colors">
                        <h3 class="text-white font-bold text-lg mb-1">Bantu Pantau Keuangan</h3>
                        <p class="text-[#8FB6C8] text-sm leading-relaxed">
                            Mahasiswa dan Orang Tua bisa memantau keuangan secara real-time dan transparan.
                        </p>
                    </div>


                    <div
                        class="bg-[#0E2A3F]/40 border border-[#00C6FB]/30 rounded-lg p-5 hover:bg-[#0E2A3F]/60 transition-colors">
                        <h3 class="text-white font-bold text-lg mb-1">Tracking Finansial</h3>
                        <p class="text-[#8FB6C8] text-sm leading-relaxed">
                            Lacak setiap pemasukan dan pengeluaran dengan kategori yang detail dan mudah dipahami.
                        </p>
                    </div>


                    <div
                        class="bg-[#0E2A3F]/40 border border-[#00C6FB]/30 rounded-lg p-5 hover:bg-[#0E2A3F]/60 transition-colors">
                        <h3 class="text-white font-bold text-lg mb-1">Mengelola Transaksi</h3>
                        <p class="text-[#8FB6C8] text-sm leading-relaxed">
                            Kelola berbagai jenis transaksi harian dengan pencatatan yang rapi dan terstruktur.
                        </p>
                    </div>


                    <div
                        class="bg-[#0E2A3F]/40 border border-[#00C6FB]/30 rounded-lg p-5 hover:bg-[#0E2A3F]/60 transition-colors">
                        <h3 class="text-white font-bold text-lg mb-1">Transfer Orang Tua Aman</h3>
                        <p class="text-[#8FB6C8] text-sm leading-relaxed">
                            Kirim uang saku dari orang tua ke anak dengan sistem yang aman, cepat, dan terkonfirmasi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="py-36 bg-[#0B1C2E]">
        <div class="container mx-auto px-8 lg:px-16">
            <div class="flex flex-col items-center text-center space-y-8">
                <h2
                    class="text-4xl lg:text-5xl font-bold bg-gradient-to-r from-[#00C6FB] to-[#00F29C] bg-clip-text text-transparent">
                    TUNGGU APALAGI?
                </h2>
                <p class="text-white text-lg">
                    Pantau Finansial Anda Sekarang Juga
                </p>


                <a href="/register"
                    class="group inline-flex items-center gap-4 pl-6 pr-2 py-2 bg-gradient-to-r from-[#00C6FB] to-[#00F29C] rounded-full hover:shadow-lg hover:shadow-[#00C6FB]/40 transition-all">
                    <span class="text-[#051933] font-bold text-sm">Mulai Sekarang</span>
                    <div
                        class="w-8 h-8 bg-[#0B1C2E] rounded-full flex items-center justify-center group-hover:bg-[#0E2A3F] transition-colors">
                        <svg class="w-4 h-4 text-[#00F29C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 12h14m-7-7l7 7-7 7" />
                        </svg>
                    </div>
                </a>
            </div>
        </div>
    </section>


    <footer class="bg-hero pt-[200px] pb-0 relative ">
        <div class="container mx-auto px-8 lg:px-16 pb-[200px] text-center mb-8">

            <div class="flex items-center justify-center gap-3 mb-4">
                <div
                    class="w-14 h-14 bg-gradient-to-br from-[#00C6FB] to-[#00F29C] rounded-2xl flex items-center justify-center shadow-lg">
                    <span class="text-[#051933] font-black text-2xl">K</span>
                </div>
                <span class="text-3xl font-black gradient-text">KeuanganKu</span>
            </div>

            <p class="text-[#B3C9D8] text-sm mb-2">Send Your Feedback : adminoliy@gmail.com</p>
            <p class="text-[#8FB6C8] text-xs">©2025 - Sistem Keuangan Mahasiswa - Kelompok 15</p>
        </div>


        <img src="assets/images/landing/uploaded_image_1_1766308605668.png" alt="Wave" class="w-full">
    </footer>

</body>

</html>