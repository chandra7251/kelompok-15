<?php
$title = 'Pengaturan Sistem';
ob_start();
?>

<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Pengaturan Sistem</h1>
            <p class="text-gray-500">Konfigurasi parameter sistem</p>
        </div>
        <a href="index.php?page=dashboard" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">← Kembali
            ke Dashboard</a>
    </div>
</div>

<div class="max-w-2xl">
    <form action="index.php?page=admin&action=update_settings" method="POST">
        <?= csrf_field() ?>

        <!-- Threshold Settings -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h3 class="font-semibold text-gray-800 mb-4">📊 Threshold Scoring Status</h3>
            <p class="text-sm text-gray-500 mb-4">Atur batas rasio pengeluaran untuk menentukan status keuangan
                mahasiswa</p>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Batas Hemat (%)
                        <span class="text-gray-400 font-normal">- Status HEMAT jika rasio ≤ nilai ini</span>
                    </label>
                    <div class="flex items-center gap-3">
                        <input type="number" name="threshold_hemat" value="<?= e($settings['threshold_hemat']) ?>"
                            min="0" max="100" required
                            class="w-32 px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <span class="text-gray-500">%</span>
                        <div class="flex-1 h-3 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-green-500" style="width: <?= $settings['threshold_hemat'] ?>%"></div>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Batas Normal (%)
                        <span class="text-gray-400 font-normal">- Status NORMAL jika rasio ≤ nilai ini (dan >
                            Hemat)</span>
                    </label>
                    <div class="flex items-center gap-3">
                        <input type="number" name="threshold_normal" value="<?= e($settings['threshold_normal']) ?>"
                            min="0" max="100" required
                            class="w-32 px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <span class="text-gray-500">%</span>
                        <div class="flex-1 h-3 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-yellow-500" style="width: <?= $settings['threshold_normal'] ?>%">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-red-50 border border-red-100 rounded-lg p-3">
                    <p class="text-sm text-red-700">
                        <strong>BOROS:</strong> Status BOROS jika rasio > <?= $settings['threshold_normal'] ?>%
                    </p>
                </div>
            </div>
        </div>

        <!-- Exchange Rate Settings -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h3 class="font-semibold text-gray-800 mb-4">💱 Pengaturan Kurs</h3>
            <p class="text-sm text-gray-500 mb-4">Atur interval refresh nilai kurs mata uang</p>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    TTL Cache Kurs (detik)
                    <span class="text-gray-400 font-normal">- Berapa lama kurs di-cache sebelum di-refresh</span>
                </label>
                <div class="flex items-center gap-3">
                    <input type="number" name="kurs_ttl" value="<?= e($settings['kurs_ttl']) ?>" min="60" max="86400"
                        required
                        class="w-40 px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    <span class="text-gray-500">detik</span>
                    <span class="text-sm text-gray-400">
                        (<?= round($settings['kurs_ttl'] / 60) ?> menit / <?= round($settings['kurs_ttl'] / 3600, 1) ?>
                        jam)
                    </span>
                </div>
            </div>
        </div>

        <!-- Info Box -->
        <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 mb-6">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd" />
                </svg>
                <div>
                    <h4 class="font-medium text-blue-800">Cara Kerja Status</h4>
                    <p class="text-sm text-blue-700 mt-1">
                        Status keuangan dihitung berdasarkan rasio: <code
                            class="bg-blue-100 px-1 rounded">(Pengeluaran / Pemasukan) × 100%</code>
                    </p>
                    <ul class="text-sm text-blue-700 mt-2 list-disc list-inside">
                        <li><strong>Hemat:</strong> Rasio ≤ <?= $settings['threshold_hemat'] ?>%</li>
                        <li><strong>Normal:</strong> Rasio <?= $settings['threshold_hemat'] ?>% -
                            <?= $settings['threshold_normal'] ?>%</li>
                        <li><strong>Boros:</strong> Rasio > <?= $settings['threshold_normal'] ?>%</li>
                    </ul>
                </div>
            </div>
        </div>

        <button type="submit"
            class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
            💾 Simpan Pengaturan
        </button>
    </form>
</div>

<?php
$content = ob_get_clean();
include dirname(__DIR__) . '/layouts/app.php';
?>