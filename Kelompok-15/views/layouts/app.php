<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Sistem Keuangan Mahasiswa') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.4s ease-out;
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.5s ease-out;
        }

        .animate-fadeInDown {
            animation: fadeInDown 0.5s ease-out;
        }

        .animate-slideDown {
            animation: slideDown 0.3s ease-out;
        }

        .animate-slideUp {
            animation: slideUp 0.3s ease-out;
        }

        .animate-scaleIn {
            animation: scaleIn 0.3s ease-out;
        }

        .animate-bounce {
            animation: bounce 0.6s ease-in-out;
        }

        .animate-pulse {
            animation: pulse 2s ease-in-out infinite;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

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
</head>

<body class="bg-gradient-to-b from-[#051933] to-[#0A2547] h-screen flex font-sans overflow-hidden">

    <?php if (is_logged_in()): ?>

        <aside class="w-52 bg-[#0A2238] hidden md:flex flex-col flex-shrink-0 border-r border-white/5">
            <div class="h-16 flex items-center px-6 gap-3 border-b border-white/5">
                <div
                    class="w-10 h-10 bg-[linear-gradient(135deg,#4ED4FF,#6AF5C9)] rounded-xl flex items-center justify-center shadow-lg  shadow-[#4ED4FF]/20">
                    <span class="text-[#203351] font-bold text-lg">K</span>
                </div>
                <span
                    class="text-lg font-bold bg-gradient-to-r from-[#00C6FB] to-[#00F29C] bg-clip-text text-transparent">KeuanganKu</span>
            </div>

            <nav class="flex-1 px-3 py-6 space-y-2 overflow-y-auto">
                <?php if (is_role('admin')): ?>
                    <a href="index.php?page=dashboard"
                        class="flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-xl transition-all hover:text-[#00C6FB]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="index.php?page=admin&action=users"
                        class="flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-xl transition-all hover:text-[#00C6FB]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Users
                    </a>
                    <a href="index.php?page=admin&action=monitoring"
                        class="flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-xl transition-all hover:text-[#00C6FB]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Monitoring
                    </a>
                    <a href="index.php?page=admin&action=settings"
                        class="flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-xl transition-all hover:text-[#00C6FB]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Settings
                    </a>
                <?php elseif (is_role('mahasiswa')): ?>
                    <a href="index.php?page=dashboard"
                        class="flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-xl transition-all hover:text-[#00C6FB]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="index.php?page=transaksi"
                        class="flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-xl transition-all hover:text-[#00C6FB]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Transaksi
                    </a>
                    <a href="index.php?page=kategori"
                        class="flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-xl transition-all hover:text-[#00C6FB]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        Kategori
                    </a>
                    <a href="index.php?page=grafik"
                        class="flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-xl transition-all hover:text-[#00C6FB]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                        </svg>
                        Grafik
                    </a>
                    <a href="index.php?page=analytics"
                        class="flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-xl transition-all hover:text-[#00C6FB]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Analytics
                    </a>
                <?php elseif (is_role('orangtua')): ?>
                    <a href="index.php?page=dashboard"
                        class="flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-xl transition-all hover:text-[#00C6FB]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="index.php?page=transfer"
                        class="flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-xl transition-all hover:text-[#00C6FB]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Transfer
                    </a>
                <?php endif; ?>
            </nav>
        </aside>


        <div id="mobileSidebarOverlay" class="fixed inset-0 bg-black/50 z-40 md:hidden hidden"
            onclick="toggleMobileSidebar()"></div>


        <aside id="mobileSidebar"
            class="fixed top-0 left-0 h-full w-64 bg-[#0A2238] z-50 md:hidden transform -translate-x-full transition-transform duration-300 ease-in-out">
            <div class="h-16 flex items-center px-6 gap-3 border-b border-white/5">
                <div
                    class="w-10 h-10 bg-[linear-gradient(135deg,#4ED4FF,#6AF5C9)] rounded-xl flex items-center justify-center shadow-lg  shadow-[#4ED4FF]/20">
                    <span class="text-[#203351] font-bold text-lg">K</span>
                </div>
                <span
                    class="text-lg font-bold bg-gradient-to-r from-[#00C6FB] to-[#00F29C] bg-clip-text text-transparent">KeuanganKu</span>
            </div>

            <nav class="flex-1 px-3 py-6 space-y-2 overflow-y-auto">
                <?php if (is_role('admin')): ?>
                    <a href="index.php?page=dashboard"
                        class="flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-xl transition-all hover:text-[#00C6FB]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="index.php?page=admin&action=users"
                        class="flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-xl transition-all hover:text-[#00C6FB]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Users
                    </a>
                    <a href="index.php?page=admin&action=monitoring"
                        class="flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-xl transition-all hover:text-[#00C6FB]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Monitoring
                    </a>
                    <a href="index.php?page=admin&action=settings"
                        class="flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-xl transition-all hover:text-[#00C6FB]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Settings
                    </a>
                <?php elseif (is_role('mahasiswa')): ?>
                    <a href="index.php?page=dashboard"
                        class="flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-xl transition-all hover:text-[#00C6FB]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="index.php?page=transaksi"
                        class="flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-xl transition-all hover:text-[#00C6FB]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Transaksi
                    </a>
                    <a href="index.php?page=kategori"
                        class="flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-xl transition-all hover:text-[#00C6FB]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        Kategori
                    </a>
                    <a href="index.php?page=grafik"
                        class="flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-xl transition-all hover:text-[#00C6FB]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                        </svg>
                        Grafik
                    </a>
                    <a href="index.php?page=analytics"
                        class="flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-xl transition-all hover:text-[#00C6FB]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Analytics
                    </a>
                <?php elseif (is_role('orangtua')): ?>
                    <a href="index.php?page=dashboard"
                        class="flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-xl transition-all hover:text-[#00C6FB]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="index.php?page=transfer"
                        class="flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-xl transition-all hover:text-[#00C6FB]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Transfer
                    </a>
                <?php endif; ?>
            </nav>
        </aside>
    <?php endif; ?>


    <div class="flex-1 flex flex-col h-full overflow-y-auto w-full relative">
        <nav
            class="bg-[#051933]/90 backdrop-blur-lg shadow-sm border-b border-[#22d3ee]/20 sticky top-0 z-40 bg-[linear-gradient(to_right,#051933,#0A2547)]">
            <div class="max-w-screen-2xl mx-auto px-4">
                <div class="flex justify-between h-20 items-center">


                    <div class="flex items-center gap-4">

                        <?php if (is_logged_in()): ?>
                            <button onclick="toggleMobileSidebar()"
                                class="md:hidden p-2 text-[#00C6FB] hover:bg-white/10 rounded-lg transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                        <?php endif; ?>

                        <h1
                            class="text-2xl font-bold bg-gradient-to-r from-[#00C6FB] to-[#00F29C] bg-clip-text text-transparent tracking-wider uppercase">
                            <?= strtoupper($title ?? 'DASHBOARD') ?>
                        </h1>
                    </div>


                    <div class="flex items-center gap-6">


                        <?php if (is_logged_in() && is_role('mahasiswa')): ?>
                            <div class="relative">
                                <button id="notifBtn"
                                    class="relative p-2 text-[#B3C9D8] hover:text-[#00C6FB] hover:bg-white/10 rounded-xl transition-all duration-200">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    <span id="notifBadge"
                                        class="hidden absolute -top-1 -right-1 bg-rose-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center animate-pulse"></span>
                                </button>

                                <div id="notifDropdown"
                                    class="hidden absolute right-0 mt-2 w-80 bg-[#0A2238] rounded-xl shadow-xl border border-white/10 py-2 z-50 opacity-0 scale-95 transition-all duration-200 origin-top-right">
                                    <div class="px-4 py-3 border-b border-white/10 flex justify-between items-center">
                                        <span class="font-semibold text-white">Reminder</span>
                                        <a href="index.php?page=reminder"
                                            class="text-[#00C6FB] text-sm hover:underline">Kelola</a>
                                    </div>
                                    <div id="reminderList" class="max-h-60 overflow-y-auto">

                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>


                        <div class="hidden lg:flex items-center gap-3 text-[#00C6FB] font-medium text-sm tracking-wide">
                            <span id="clock-day"></span>
                            <span class="text-[#00F29C]/50">|</span>
                            <span id="clock-date"></span>
                            <span class="text-[#00F29C]/50">|</span>
                            <span id="clock-time" class="w-16 text-center"></span>
                        </div>


                        <?php if (is_logged_in()): ?>
                            <div class="flex items-center gap-4 border-l border-white/10 pl-6">

                                <a href="index.php?page=profile" class="flex items-center gap-3 group">
                                    <div
                                        class="w-11 h-11 bg-[linear-gradient(135deg,#4ED4FF,#6AF5C9)] rounded-xl flex items-center justify-center shadow-[0_0_15px_rgba(78,212,255,0.3)] group-hover:scale-105 transition-transform duration-300 overflow-hidden">
                                        <?php if (isset(auth()['photo']) && !empty(auth()['photo'])): ?>
                                            <img src="uploads/photos/<?= e(auth()['photo']) ?>" alt="Profile"
                                                class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <span
                                                class="text-white font-bold text-lg drop-shadow-md"><?= strtoupper(substr(auth()['nama'], 0, 1)) ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="text-right hidden xl:block">
                                        <p class="text-[15px] font-bold text-[#EAF6FF] leading-tight">
                                            <?= e(auth()['nama']) ?>
                                        </p>
                                        <p class="text-xs text-[#00C6FB] font-medium opacity-80">
                                            <?= ucwords(auth()['role']) ?>
                                        </p>
                                    </div>
                                </a>


                                <a href="index.php?page=logout" onclick="return confirm('Yakin ingin logout?')"
                                    class="bg-[#fce7f3] text-[#ef4444] hover:bg-white hover:text-red-600 px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-200 hover:-translate-y-0.5 shadow-sm">
                                    Logout
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>

        <?php if (has_flash('success')): ?>
            <div data-flash
                class="max-w-screen-2xl mx-auto px-4 mt-4 animate-[slideDown_0.3s_ease-out] transition-all duration-500">
                <div
                    class="bg-[#00F29C]/10 border border-[#00F29C]/30 text-[#00F29C] px-5 py-4 rounded-xl flex items-center space-x-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span><?= get_flash('success') ?></span>
                </div>
            </div>
        <?php endif; ?>

        <?php if (has_flash('error')): ?>
            <div data-flash
                class="max-w-screen-2xl mx-auto px-4 mt-4 animate-[slideDown_0.3s_ease-out] transition-all duration-500">
                <div
                    class="bg-red-500/10 border border-red-500/30 text-red-400 px-5 py-4 rounded-xl flex items-center space-x-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                    <span><?= get_flash('error') ?></span>
                </div>
            </div>
        <?php endif; ?>

        <main class="flex-1 max-w-screen-2xl w-full mx-auto px-4 animate-[fadeIn_0.4s_ease-out]">
            <?= $content ?? '' ?>
        </main>

        <footer class="bg-[#0A1F2E] border-t border-white/5 mt-auto">
            <div class="max-w-screen-2xl mx-auto px-4 py-8">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-10 h-10 bg-[linear-gradient(135deg,#4ED4FF,#6AF5C9)] rounded-xl flex items-center justify-center shadow-lg  shadow-[#4ED4FF]/20">
                            <span class="text-[#203351] font-bold text-lg">K</span>
                        </div>
                        <span
                            class="text-lg font-bold bg-gradient-to-r from-[#00C6FB] to-[#00F29C] bg-clip-text text-transparent">KeuanganKu</span>
                    </div>
                    <p class="text-sm font-medium text-[#B3C9D8]">©2025 - Sistem Keuangan Mahasiswa - Kelompok 15</p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            const day = days[now.getDay()];
            const date = now.getDate();
            const month = months[now.getMonth()];
            const year = now.getFullYear();

            const h = String(now.getHours()).padStart(2, '0');
            const m = String(now.getMinutes()).padStart(2, '0');
            const s = String(now.getSeconds()).padStart(2, '0');

            const dayEl = document.getElementById('clock-day');
            const dateEl = document.getElementById('clock-date');
            const timeEl = document.getElementById('clock-time');

            if (dayEl) dayEl.textContent = day;
            if (dateEl) dateEl.textContent = `${date} ${month} ${year}`;
            if (timeEl) timeEl.textContent = `${h}:${m}:${s}`;
        }

        setInterval(updateClock, 1000);
        updateClock();

        document.getElementById('notifBtn')?.addEventListener('click', function (e) {
            e.stopPropagation();
            const dropdown = document.getElementById('notifDropdown');
            if (!dropdown) return;

            const isHidden = dropdown.classList.contains('hidden');
            if (isHidden) {
                dropdown.classList.remove('hidden');
                setTimeout(() => {
                    dropdown.classList.remove('opacity-0', 'scale-95');
                    dropdown.classList.add('opacity-100', 'scale-100');
                }, 10);
                loadReminders();
            } else {
                dropdown.classList.add('opacity-0', 'scale-95');
                dropdown.classList.remove('opacity-100', 'scale-100');
                setTimeout(() => dropdown.classList.add('hidden'), 200);
            }
        });

        function loadReminders() {
            fetch('index.php?page=reminder&action=json')
                .then(r => r.json())
                .then(data => {
                    const list = document.getElementById('reminderList');
                    const badge = document.getElementById('notifBadge');
                    if (data.length === 0) {
                        list.innerHTML = '<p class="px-4 py-4 text-[#B3C9D8] text-sm text-center">Tidak ada reminder aktif</p>';
                        badge?.classList.add('hidden');
                    } else {
                        if (badge) {
                            badge.textContent = data.length;
                            badge.classList.remove('hidden');
                        }
                        list.innerHTML = data.map(r => {
                            const isOverdue = new Date(r.tanggal_jatuh_tempo) < new Date();
                            return `<div class="px-4 py-3 hover:bg-white/5 border-b border-white/5 transition-all duration-200">
                        <div class="flex justify-between items-start">
                             <div>
                                <p class="font-medium text-white text-sm">${r.nama}</p>
                                <p class="text-xs text-[#B3C9D8] mt-0.5">Jatuh tempo: ${r.tanggal_jatuh_tempo}</p>
                             </div>
                             <p class="text-xs font-semibold text-[#00F29C]">Rp ${Number(r.jumlah).toLocaleString('id-ID')}</p>
                        </div>
                    </div>`;
                        }).join('');
                    }
                })
                .catch(() => {
                    document.getElementById('reminderList').innerHTML = '<p class="px-4 py-4 text-red-400 text-sm text-center">Gagal memuat reminder</p>';
                });
        }

        document.addEventListener('click', function (e) {
            const dropdown = document.getElementById('notifDropdown');
            const notifBtn = document.getElementById('notifBtn');
            if (dropdown && !dropdown.contains(e.target) && e.target !== notifBtn) {
                dropdown.classList.add('opacity-0', 'scale-95');
                dropdown.classList.remove('opacity-100', 'scale-100');
                setTimeout(() => dropdown.classList.add('hidden'), 200);
            }
        });

        function toggleMobileSidebar() {
            const sidebar = document.getElementById('mobileSidebar');
            const overlay = document.getElementById('mobileSidebarOverlay');

            if (sidebar && overlay) {
                const isOpen = !sidebar.classList.contains('-translate-x-full');

                if (isOpen) {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                } else {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const flashMessages = document.querySelectorAll('[data-flash], [data-welcome]');
            flashMessages.forEach(function (msg) {
                setTimeout(function () {
                    msg.style.opacity = '0';
                    msg.style.transform = 'translateY(-10px)';
                    setTimeout(function () {
                        msg.style.display = 'none';
                    }, 500);
                }, 4000);
            });
        });
    </script>
</body>

</html>