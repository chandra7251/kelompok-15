<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Login') ?> - Sistem Keuangan Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>

<body class="min-h-screen gradient-bg flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-2xl shadow-lg mb-4">
                <span class="text-3xl">💰</span>
            </div>
            <h1 class="text-2xl font-bold text-white">Sistem Keuangan Mahasiswa</h1>
            <p class="text-indigo-200 mt-1">Kelola keuangan dengan mudah</p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <!-- Flash Messages -->
            <?php if (has_flash('success')): ?>
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4">
                    <?= get_flash('success') ?>
                </div>
            <?php endif; ?>

            <?php if (has_flash('error')): ?>
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4">
                    <?= get_flash('error') ?>
                </div>
            <?php endif; ?>

            <?= $content ?? '' ?>
        </div>

        <!-- Footer -->
        <p class="text-center text-indigo-200 text-sm mt-6">
            © <?= date('Y') ?> Kelompok 15
        </p>
    </div>
</body>

</html>