<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Login') ?> - Sistem Keuangan Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,100..1000&display=swap"
        rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            950: '#02040a',
                            900: '#0b1324',
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
            font-family: 'DM Sans', sans-serif;
        }
    </style>
</head>

<body
    class="min-h-screen relative text-white overflow-x-hidden selection:bg-cyan-500 selection:text-white flex flex-col justify-between"
    style="background: linear-gradient(to bottom, #051933, #0A2547); background-attachment: fixed;">


    <?php if (has_flash('success')): ?>
        <div data-flash class="fixed top-32 left-1/2 -translate-x-1/2 z-[100] w-full max-w-md transition-all duration-500">
            <div class="bg-emerald-500 text-white px-6 py-3 rounded-xl shadow-2xl font-semibold text-center mx-4">
                <?= get_flash('success') ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (has_flash('error')): ?>
        <div data-flash class="fixed top-32 left-1/2 -translate-x-1/2 z-[100] w-full max-w-md transition-all duration-500">
            <div class="bg-rose-500 text-white px-6 py-3 rounded-xl shadow-2xl font-semibold text-center mx-4">
                <?= get_flash('error') ?>
            </div>
        </div>
    <?php endif; ?>


    <main class="relative z-10 min-h-screen flex flex-col justify-center w-full">
        <?= $content ?? '' ?>
    </main>

    <div class="absolute bottom-0 left-0 w-full h-full pointer-events-none z-0 overflow-hidden flex items-end">
        <svg class="w-full h-[65vh] lg:h-[75vh]" viewBox="0 0 1440 600" preserveAspectRatio="none" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path d="M0 600V285C300 280 600 360 900 310C1200 260 1380 180 1440 200V600H0Z" fill="url(#wave_gradient)" />
            <defs>
                <linearGradient id="wave_gradient" x1="0" y1="0" x2="1440" y2="0" gradientUnits="userSpaceOnUse">
                    <stop offset="0" stop-color="<?= $waveFrom ?? '#22d3ee' ?>" />
                    <stop offset="1" stop-color="<?= $waveTo ?? '#2dd4bf' ?>" />
                </linearGradient>
            </defs>
        </svg>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const flashMessages = document.querySelectorAll('[data-flash]');
            flashMessages.forEach(function (msg) {
                setTimeout(function () {
                    msg.style.opacity = '0';
                    msg.style.transform = 'translateY(-20px)';
                    setTimeout(function () {
                        msg.style.display = 'none';
                    }, 500);
                }, 4000);
            });
        });
    </script>

</body>

</html>