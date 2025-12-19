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
        /* Animation Keyframes */
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

        /* Animation Classes */
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

        /* Staggered Animations */
        .stagger-1 {
            animation-delay: 0.1s;
        }

        .stagger-2 {
            animation-delay: 0.2s;
        }

        .stagger-3 {
            animation-delay: 0.3s;
        }

        .stagger-4 {
            animation-delay: 0.4s;
        }

        .stagger-5 {
            animation-delay: 0.5s;
        }

        /* Hover Animations */
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .hover-glow {
            transition: box-shadow 0.3s ease;
        }

        .hover-glow:hover {
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.4);
        }

        .hover-scale {
            transition: transform 0.2s ease;
        }

        .hover-scale:hover {
            transform: scale(1.05);
        }

        /* Card Animations */
        .card-animated {
            animation: fadeInUp 0.5s ease-out both;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-animated:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        }

        /* Button Animations */
        .btn-animated {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-animated:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
        }

        .btn-animated:active {
            transform: translateY(0);
        }

        /* Input Focus Animation */
        .input-animated {
            transition: all 0.3s ease;
        }

        .input-animated:focus {
            transform: scale(1.01);
        }

        /* Loading Skeleton */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        /* Gradient Text Animation */
        .gradient-text-animated {
            background: linear-gradient(90deg, #6366f1, #8b5cf6, #6366f1);
            background-size: 200% auto;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shimmer 3s linear infinite;
        }

        /* Page Transition */
        .page-enter {
            opacity: 0;
            transform: translateY(20px);
        }

        .page-enter-active {
            opacity: 1;
            transform: translateY(0);
            transition: opacity 0.4s ease, transform 0.4s ease;
        }
    </style>
</head>

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

<body class="bg-gradient-to-b from-[#051933] to-[#0A2547] h-screen flex font-sans overflow-hidden">

    <?php if (is_logged_in()): ?>
    <!-- Sidebar (Desktop) -->
    <aside class="w-52 bg-[#0A2238] hidden md:flex flex-col flex-shrink-0 border-r border-white/5">
        <div class="h-16 flex items-center px-6 gap-3 border-b border-white/5">
             <svg class="w-6 h-6 text-[#00C6FB]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
             </svg>
             <span class="font-bold bg-gradient-to-r from-[#00C6FB] to-[#00F29C] bg-clip-text text-transparent tracking-wider">DISINI LOGO</span>
        </div>
        
        <nav class="flex-1 px-3 py-6 space-y-2 overflow-y-auto">
            <?php if (is_role('mahasiswa')): ?>
                <a href="index.php?page=dashboard" class="flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-xl transition-all hover:text-[#00C6FB]">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
                <a href="index.php?page=transaksi" class="flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-xl transition-all hover:text-[#00C6FB]">
                     <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Transaksi
                </a>
                <a href="index.php?page=kategori" class="flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-xl transition-all hover:text-[#00C6FB]">
                     <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    Kategori
                </a>
                 <a href="index.php?page=grafik" class="flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-xl transition-all hover:text-[#00C6FB]">
                     <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                    Grafik
                </a>
                 <a href="index.php?page=analytics" class="flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-xl transition-all hover:text-[#00C6FB]">
                     <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Analytics
                </a>
            <?php elseif (is_role('orangtua')): ?>
                <a href="index.php?page=dashboard" class="flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-xl transition-all hover:text-[#00C6FB]">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
                <a href="index.php?page=transfer" class="flex items-center gap-3 px-4 py-3 text-white hover:bg-white/10 rounded-xl transition-all hover:text-[#00C6FB]">
                     <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Transfer
                </a>
            <?php endif; ?>
        </nav>
    </aside>
    <?php endif; ?>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col h-full overflow-y-auto w-full relative">
        <nav class="bg-[#051933]/90 backdrop-blur-lg shadow-sm border-b border-[#22d3ee]/20 sticky top-0 z-40 bg-[linear-gradient(to_right,#051933,#0A2547)]">
            <div class="max-w-screen-2xl mx-auto px-4">
                <div class="flex justify-between h-20 items-center">
                    
                    <!-- Left: Current Page Title -->
                    <div class="flex items-center">
                        <h1 class="text-2xl font-bold bg-gradient-to-r from-[#00C6FB] to-[#00F29C] bg-clip-text text-transparent tracking-wider uppercase">
                            <?= strtoupper($title ?? 'DASHBOARD') ?>
                        </h1>
                    </div>

                    <!-- Right Section: Clock & Profile -->
                    <div class="flex items-center gap-6">
                        
                        <!-- Realtime Clock -->
                        <div class="hidden lg:flex items-center gap-3 text-[#00C6FB] font-medium text-sm tracking-wide">
                            <span id="clock-day"></span>
                            <span class="text-[#00F29C]/50">|</span>
                            <span id="clock-date"></span>
                            <span class="text-[#00F29C]/50">|</span>
                            <span id="clock-time" class="w-16 text-center"></span>
                        </div>

                        <!-- Profile & Logout -->
                         <?php if (is_logged_in()): ?>
                            <div class="flex items-center gap-4 border-l border-white/10 pl-6">
                                <!-- Profile -->
                                <a href="index.php?page=profile" class="flex items-center gap-3 group">
                                    <!-- New Gradient: #4ED4FF -> #6AF5C9 (Diagonal) -->
                                    <div class="w-11 h-11 bg-[linear-gradient(135deg,#4ED4FF,#6AF5C9)] rounded-xl flex items-center justify-center shadow-[0_0_15px_rgba(78,212,255,0.3)] group-hover:scale-105 transition-transform duration-300">
                                        <span class="text-white font-bold text-lg drop-shadow-md"><?= strtoupper(substr(auth()['nama'], 0, 1)) ?></span>
<body class="bg-gradient-to-br from-slate-50 to-indigo-50 min-h-screen flex flex-col font-sans">

    <nav class="bg-white/80 backdrop-blur-lg shadow-sm border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="index.php?page=dashboard" class="flex items-center space-x-3 group">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/30 group-hover:shadow-indigo-500/50 transition-all duration-300">
                            <span class="text-white font-bold text-lg">K</span>
                        </div>
                        <div class="hidden sm:block">
                            <span
                                class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">KeuanganKu</span>
                            <p class="text-xs text-gray-400 -mt-1">Kelola Uangmu</p>
                        </div>
                    </a>
                </div>

                <?php if (is_logged_in()): ?>
                    <div class="hidden md:flex items-center space-x-1">
                        <?php if (is_role('mahasiswa')): ?>
                            <a href="index.php?page=dashboard"
                                class="text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200">Dashboard</a>
                            <a href="index.php?page=transaksi"
                                class="text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200">Transaksi</a>
                            <a href="index.php?page=kategori"
                                class="text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200">Kategori</a>
                            <a href="index.php?page=grafik"
                                class="text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200">Grafik</a>
                            <a href="index.php?page=analytics"
                                class="text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200">Analytics</a>
                        <?php elseif (is_role('orangtua')): ?>
                            <a href="index.php?page=dashboard"
                                class="text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200">Dashboard</a>
                            <a href="index.php?page=transfer"
                                class="text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200">Transfer</a>
                        <?php elseif (is_role('admin')): ?>
                            <a href="index.php?page=dashboard"
                                class="text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200">Dashboard</a>
                            <a href="index.php?page=admin&action=users"
                                class="text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200">Users</a>
                            <a href="index.php?page=admin&action=monitoring"
                                class="text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200">Monitoring</a>
                            <a href="index.php?page=admin&action=settings"
                                class="text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200">Settings</a>
                        <?php endif; ?>
                    </div>

                    <div class="flex items-center space-x-3">
                        <?php if (is_role('mahasiswa')): ?>
                            <div class="relative">
                                <button id="notifBtn"
                                    class="relative p-2 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all duration-200">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    <span id="notifBadge"
                                        class="hidden absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center animate-pulse"></span>
                                </button>
                                <div id="notifDropdown"
                                    class="hidden absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50 opacity-0 scale-95 transition-all duration-200 origin-top-right">
                                    <div class="px-4 py-3 border-b border-gray-100 flex justify-between items-center">
                                        <span class="font-semibold text-gray-800">Reminder</span>
                                        <a href="index.php?page=reminder"
                                            class="text-indigo-600 text-sm hover:underline">Kelola</a>
                                    </div>
                                    <div class="text-right hidden xl:block">
                                        <p class="text-[15px] font-bold text-[#EAF6FF] leading-tight"><?= e(auth()['nama']) ?></p>
                                        <p class="text-xs text-[#00C6FB] font-medium opacity-80"><?= ucwords(auth()['role']) ?></p>
                                    </div>
                                </a>

                                <!-- Logout -->
                                <a href="index.php?page=logout" onclick="return confirm('Yakin ingin logout?')" class="bg-[#fce7f3] text-[#ef4444] hover:bg-white hover:text-red-600 px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-200 hover:-translate-y-0.5 shadow-sm">
                                    Logout
                                </a>
                            </div>
                         <?php endif; ?>

                        <!-- Mobile Menu Button -->
                        <button id="mobileMenuBtn" class="md:hidden p-2 rounded-xl text-gray-300 hover:bg-white/5 transition-all">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                </div>
                            </div>
                        <?php endif; ?>

                        <a href="index.php?page=profile"
                            class="hidden sm:flex items-center space-x-3 hover:bg-gray-50 px-3 py-2 rounded-xl transition-all duration-200 group">
                            <div
                                class="w-9 h-9 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg transition-all duration-300">
                                <span
                                    class="text-white font-semibold text-sm"><?= strtoupper(substr(auth()['nama'], 0, 1)) ?></span>
                            </div>
                            <div class="text-right hidden lg:block">
                                <p class="text-sm font-semibold text-gray-700"><?= e(auth()['nama']) ?></p>
                                <p class="text-xs text-gray-400 capitalize"><?= e(auth()['role']) ?></p>
                            </div>
                        </a>
                        <a href="index.php?page=logout" onclick="return confirm('Yakin ingin logout?')"
                            class="bg-red-50 text-red-600 hover:bg-red-100 px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 hover:-translate-y-0.5">Logout</a>
                        <button id="mobileMenuBtn"
                            class="md:hidden p-2 rounded-xl hover:bg-gray-100 transition-all duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <?php if (is_logged_in()): ?>
                <div id="mobileMenu" class="hidden md:hidden border-t border-white/10 bg-[#051933]/95 backdrop-blur animate-[slideDown_0.2s_ease-out]">
                    <div class="px-4 py-4 space-y-1">
                        <?php if (is_role('mahasiswa')): ?>
                            <a href="index.php?page=dashboard" class="block px-4 py-3 rounded-xl text-gray-300 hover:bg-[#00C6FB]/10 hover:text-[#00C6FB] font-medium transition-all">Dashboard</a>
                            <a href="index.php?page=transaksi" class="block px-4 py-3 rounded-xl text-gray-300 hover:bg-[#00C6FB]/10 hover:text-[#00C6FB] font-medium transition-all">Transaksi</a>
                            <a href="index.php?page=kategori" class="block px-4 py-3 rounded-xl text-gray-300 hover:bg-[#00C6FB]/10 hover:text-[#00C6FB] font-medium transition-all">Kategori</a>
                            <a href="index.php?page=reminder" class="block px-4 py-3 rounded-xl text-gray-300 hover:bg-[#00C6FB]/10 hover:text-[#00C6FB] font-medium transition-all">Reminder</a>
                            <a href="index.php?page=grafik" class="block px-4 py-3 rounded-xl text-gray-300 hover:bg-[#00C6FB]/10 hover:text-[#00C6FB] font-medium transition-all">Grafik</a>
                            <a href="index.php?page=analytics" class="block px-4 py-3 rounded-xl text-gray-300 hover:bg-[#00C6FB]/10 hover:text-[#00C6FB] font-medium transition-all">Analytics</a>
                        <?php elseif (is_role('orangtua')): ?>
                            <a href="index.php?page=dashboard" class="block px-4 py-3 rounded-xl text-gray-300 hover:bg-[#00C6FB]/10 hover:text-[#00C6FB] font-medium transition-all">Dashboard</a>
                            <a href="index.php?page=transfer" class="block px-4 py-3 rounded-xl text-gray-300 hover:bg-[#00C6FB]/10 hover:text-[#00C6FB] font-medium transition-all">Transfer</a>
                        <?php endif; ?>
                         <a href="index.php?page=profile" class="block px-4 py-3 rounded-xl text-gray-300 hover:bg-[#00C6FB]/10 hover:text-[#00C6FB] font-medium transition-all">Profile</a>
                    </div>
        <?php if (is_logged_in()): ?>
            <div id="mobileMenu"
                class="hidden md:hidden border-t border-gray-100 bg-white/95 backdrop-blur animate-[slideDown_0.2s_ease-out]">
                <div class="px-4 py-4 space-y-1">
                    <?php if (is_role('mahasiswa')): ?>
                        <a href="index.php?page=dashboard"
                            class="block px-4 py-3 rounded-xl text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 font-medium transition-all duration-200">Dashboard</a>
                        <a href="index.php?page=transaksi"
                            class="block px-4 py-3 rounded-xl text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 font-medium transition-all duration-200">Transaksi</a>
                        <a href="index.php?page=kategori"
                            class="block px-4 py-3 rounded-xl text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 font-medium transition-all duration-200">Kategori</a>
                        <a href="index.php?page=reminder"
                            class="block px-4 py-3 rounded-xl text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 font-medium transition-all duration-200">Reminder</a>
                        <a href="index.php?page=grafik"
                            class="block px-4 py-3 rounded-xl text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 font-medium transition-all duration-200">Grafik</a>
                        <a href="index.php?page=analytics"
                            class="block px-4 py-3 rounded-xl text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 font-medium transition-all duration-200">Analytics</a>
                    <?php elseif (is_role('orangtua')): ?>
                        <a href="index.php?page=dashboard"
                            class="block px-4 py-3 rounded-xl text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 font-medium transition-all duration-200">Dashboard</a>
                        <a href="index.php?page=transfer"
                            class="block px-4 py-3 rounded-xl text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 font-medium transition-all duration-200">Transfer</a>
                    <?php elseif (is_role('admin')): ?>
                        <a href="index.php?page=dashboard"
                            class="block px-4 py-3 rounded-xl text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 font-medium transition-all duration-200">Dashboard</a>
                        <a href="index.php?page=admin&action=users"
                            class="block px-4 py-3 rounded-xl text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 font-medium transition-all duration-200">Users</a>
                        <a href="index.php?page=admin&action=monitoring"
                            class="block px-4 py-3 rounded-xl text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 font-medium transition-all duration-200">Monitoring</a>
                        <a href="index.php?page=admin&action=settings"
                            class="block px-4 py-3 rounded-xl text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 font-medium transition-all duration-200">Settings</a>
                    <?php endif; ?>
                    <a href="index.php?page=profile"
                        class="block px-4 py-3 rounded-xl text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 font-medium transition-all duration-200">Profile</a>
                </div>
            <?php endif; ?>
        </nav>

        <?php if (has_flash('success')): ?>
            <div class="max-w-screen-2xl mx-auto px-4 mt-4 animate-[slideDown_0.3s_ease-out]">
                <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-xl flex items-center space-x-3">
                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span><?= get_flash('success') ?></span>
                </div>
    <?php if (has_flash('success')): ?>
        <div class="max-w-7xl mx-auto px-4 mt-4 animate-[slideDown_0.3s_ease-out]">
            <div
                class="bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-xl flex items-center space-x-3">
                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span><?= get_flash('success') ?></span>
            </div>
        <?php endif; ?>

        <?php if (has_flash('error')): ?>
            <div class="max-w-screen-2xl mx-auto px-4 mt-4 animate-[slideDown_0.3s_ease-out]">
                <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl flex items-center space-x-3">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                    <span><?= get_flash('error') ?></span>
                </div>
    <?php if (has_flash('error')): ?>
        <div class="max-w-7xl mx-auto px-4 mt-4 animate-[slideDown_0.3s_ease-out]">
            <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl flex items-center space-x-3">
                <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
                <span><?= get_flash('error') ?></span>
            </div>
        <?php endif; ?>

        <main class="flex-1 max-w-screen-2xl w-full mx-auto px-4 animate-[fadeIn_0.4s_ease-out]">
            <?= $content ?? '' ?>
        </main>

        <footer class="bg-[#0A1F2E] border-t border-white/5 mt-auto">
            <div class="max-w-screen-2xl mx-auto px-4 py-8">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center space-x-3">
                         <!-- Logo Kept As Is (KeuanganKu) -->
                        <div class="w-10 h-10 bg-[linear-gradient(135deg,#4ED4FF,#6AF5C9)] rounded-xl flex items-center justify-center shadow-lg  shadow-[#4ED4FF]/20">
                            <span class="text-white font-bold text-lg">K</span>
                        </div>
                        <span class="text-lg font-bold bg-gradient-to-r from-[#00C6FB] to-[#00F29C] bg-clip-text text-transparent">KeuanganKu</span>
                    </div>
                    <p class="text-sm font-medium text-[#B3C9D8]">Sistem Keuangan Mahasiswa - Kelompok 15</p>
    <footer class="bg-white/80 backdrop-blur border-t border-gray-100 mt-auto">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center space-x-2">
                    <div
                        class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">K</span>
                    </div>
                    <span
                        class="font-semibold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">KeuanganKu</span>
                </div>
            </div>
        </footer>
    </div>
    <script>
    // Realtime Clock
    function updateClock() {
        const now = new Date();
        const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        
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
        
        if(dayEl) dayEl.textContent = day;
        if(dateEl) dateEl.textContent = `${date} ${month} ${year}`;
        if(timeEl) timeEl.textContent = `${h}:${m}:${s}`;
    }
    
    setInterval(updateClock, 1000);
    updateClock(); // Initial call

    document.getElementById('mobileMenuBtn')?.addEventListener('click', function() {
        document.getElementById('mobileMenu').classList.toggle('hidden');
    });
    
    document.getElementById('notifBtn')?.addEventListener('click', function(e) {
        e.stopPropagation();
        const dropdown = document.getElementById('notifDropdown');
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
                    list.innerHTML = '<p class="px-4 py-4 text-gray-400 text-sm text-center">Tidak ada reminder</p>';
                    badge?.classList.add('hidden');
                } else {
                    if (badge) {
                        badge.textContent = data.length;
                        badge.classList.remove('hidden');
                    }
                    list.innerHTML = data.map(r => {
                        const isOverdue = new Date(r.tanggal_jatuh_tempo) < new Date();
                        return `<div class="px-4 py-3 hover:bg-gray-50 border-b border-gray-50 transition-all duration-200 ${isOverdue ? 'bg-red-50' : ''}">
        document.getElementById('mobileMenuBtn')?.addEventListener('click', function () {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        });

        document.getElementById('notifBtn')?.addEventListener('click', function (e) {
            e.stopPropagation();
            const dropdown = document.getElementById('notifDropdown');
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
                        list.innerHTML = '<p class="px-4 py-4 text-gray-400 text-sm text-center">Tidak ada reminder</p>';
                        badge?.classList.add('hidden');
                    } else {
                        if (badge) {
                            badge.textContent = data.length;
                            badge.classList.remove('hidden');
                        }
                        list.innerHTML = data.map(r => {
                            const isOverdue = new Date(r.tanggal_jatuh_tempo) < new Date();
                            return `<div class="px-4 py-3 hover:bg-gray-50 border-b border-gray-50 transition-all duration-200 ${isOverdue ? 'bg-red-50' : ''}">
                            <p class="font-medium text-gray-800">${r.nama}</p>
                            <p class="text-sm text-gray-500">Jatuh tempo: ${r.tanggal_jatuh_tempo}</p>
                            <p class="text-sm font-semibold text-indigo-600">Rp ${Number(r.jumlah).toLocaleString('id-ID')}</p>
                        </div>`;
                        }).join('');
                    }
                })
                .catch(() => {
                    document.getElementById('reminderList').innerHTML = '<p class="px-4 py-4 text-gray-400 text-sm text-center">Tidak ada reminder</p>';
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

        // Dynamic greeting
        const greetingEl = document.querySelector('[data-greeting]');
        if (greetingEl) {
            const hour = new Date().getHours();
            let greeting = 'Selamat Datang';
            if (hour >= 5 && hour < 12) greeting = 'Selamat Pagi';
            else if (hour >= 12 && hour < 15) greeting = 'Selamat Siang';
            else if (hour >= 15 && hour < 18) greeting = 'Selamat Sore';
            else greeting = 'Selamat Malam';
            greetingEl.textContent = greeting;
        }
    </script>
</body>

</html>