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
                                    <div class="max-h-64 overflow-y-auto" id="reminderList">
                                        <p class="px-4 py-4 text-gray-400 text-sm text-center">Memuat...</p>
                                    </div>
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
                <?php endif; ?>
            </div>
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
            </div>
        <?php endif; ?>
    </nav>

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
        </div>
    <?php endif; ?>

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
        </div>
    <?php endif; ?>

    <main class="flex-1 max-w-7xl w-full mx-auto px-4 py-8 animate-[fadeIn_0.4s_ease-out]">
        <?= $content ?? '' ?>
    </main>

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
                <p class="text-sm text-gray-400">Sistem Keuangan Mahasiswa - Kelompok 15</p>
            </div>
        </div>
    </footer>

    <script>
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