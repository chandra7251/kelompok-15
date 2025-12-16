<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Login') ?> - Sistem Keuangan Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,100..1000&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            950: '#02040a', // Main Background
                            900: '#0b1324', // Card Background
                        },
                        cyan: {
                            400: '#22d3ee',
                            500: '#06b6d4',
                        },
                        teal: {
                            400: '#2dd4bf',
                            500: '#14b8a6',
                        }
                    },
                    fontFamily: {
                        sans: ['DM Sans', 'sans-serif'],
                    }
                }
            },
            plugins: [],
        }
    </script>
    <style>
        body {
            /* background-color: #02040a; */
            font-family: 'DM Sans', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen relative text-white overflow-x-hidden selection:bg-cyan-500 selection:text-white flex flex-col justify-between" style="background: linear-gradient(to bottom, #051933, #0A2547); background-attachment: fixed;">

    <!-- Navbar Removed -->

    <!-- Flash Messages -->
    <?php if (has_flash('success')): ?>
        <div class="fixed top-32 left-1/2 -translate-x-1/2 z-[100] w-full max-w-md">
            <div class="bg-emerald-500 text-white px-6 py-3 rounded-xl shadow-2xl font-semibold text-center mx-4">
                <?= get_flash('success') ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (has_flash('error')): ?>
        <div class="fixed top-32 left-1/2 -translate-x-1/2 z-[100] w-full max-w-md">
            <div class="bg-rose-500 text-white px-6 py-3 rounded-xl shadow-2xl font-semibold text-center mx-4">
                <?= get_flash('error') ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <main class="relative z-10 min-h-screen flex flex-col justify-center w-full">
        <?= $content ?? '' ?>
    </main>

    <!-- Background Wave (SVG) -->
    <!-- REVISI FINAL 2: Coverage List Presisi (y=285) -->
    <div class="absolute bottom-0 left-0 w-full h-full pointer-events-none z-0 overflow-hidden flex items-end">
        <!-- Height raised to 75vh to ensure complete list coverage -->
        <svg class="w-full h-[65vh] lg:h-[75vh]" viewBox="0 0 1440 600" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
            <!-- Start y=285: Raised slightly to cover 'Disini Tulisan' header -->
            <!-- Control point 1 (300, 280) keeps it high on the left -->
            <path d="M0 600V285C300 280 600 360 900 310C1200 260 1380 180 1440 200V600H0Z" fill="url(#wave_gradient)"/>
            <defs>
                <linearGradient id="wave_gradient" x1="0" y1="0" x2="1440" y2="0" gradientUnits="userSpaceOnUse">
                    <stop offset="0" stop-color="#22d3ee"/> <!-- Cyan-400 -->
                    <stop offset="1" stop-color="#2dd4bf"/> <!-- Teal-400 -->
                </linearGradient>
            </defs>
        </svg>
    </div>

</body>
</html>