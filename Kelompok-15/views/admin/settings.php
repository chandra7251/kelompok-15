<?php
$title = 'Pengaturan Sistem';
ob_start();
?>

<div class="py-8 px-6">
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <p class="text-[#B3C9D8]">Konfigurasi parameter sistem</p>
            </div>
            <a href="index.php?page=dashboard"
                class="text-[#00C6FB] hover:text-[#00F29C] text-sm font-medium transition-colors">←
                Kembali
                ke Dashboard</a>
        </div>
    </div>

    <div class="max-w-2xl mx-auto">
        <form action="index.php?page=admin&action=update_settings" method="POST">
            <?= csrf_field() ?>


            <div class="bg-[#16304d] border border-white/5 rounded-2xl shadow-lg p-6 mb-6">
                <h3 class="font-bold text-white mb-4 flex items-center gap-2">
                    <span class="w-1 h-6 bg-gradient-to-b from-[#00C6FB] to-[#00F29C] rounded-full"></span>
                    Threshold Scoring Status
                </h3>
                <p class="text-sm text-[#B3C9D8] mb-4">Atur batas rasio pengeluaran untuk menentukan status keuangan
                    mahasiswa</p>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-[#B3C9D8] mb-2">
                            Batas Hemat (%)
                            <span class="text-slate-400 font-normal">- Status HEMAT jika rasio ≤ nilai ini</span>
                        </label>
                        <div class="flex items-center gap-3">
                            <input type="number" name="threshold_hemat" value="<?= e($settings['threshold_hemat']) ?>"
                                min="0" max="100" required
                                class="w-32 px-4 py-2 bg-[#0A2238] border border-white/10 text-white rounded-lg focus:ring-2 focus:ring-[#00C6FB] focus:border-transparent">
                            <span class="text-[#B3C9D8]">%</span>
                            <div class="flex-1 h-3 bg-white/5 rounded-full overflow-hidden">
                                <div class="h-full bg-emerald-500" style="width: <?= $settings['threshold_hemat'] ?>%">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#B3C9D8] mb-2">
                            Batas Normal (%)
                            <span class="text-slate-400 font-normal">- Status NORMAL jika rasio ≤ nilai ini (dan >
                                Hemat)</span>
                        </label>
                        <div class="flex items-center gap-3">
                            <input type="number" name="threshold_normal" value="<?= e($settings['threshold_normal']) ?>"
                                min="0" max="100" required
                                class="w-32 px-4 py-2 bg-[#0A2238] border border-white/10 text-white rounded-lg focus:ring-2 focus:ring-[#00C6FB] focus:border-transparent">
                            <span class="text-[#B3C9D8]">%</span>
                            <div class="flex-1 h-3 bg-white/5 rounded-full overflow-hidden">
                                <div class="h-full bg-yellow-500" style="width: <?= $settings['threshold_normal'] ?>%">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-rose-500/10 border border-rose-500/20 rounded-lg p-3">
                        <p class="text-sm text-rose-300">
                            <strong>BOROS:</strong> Status BOROS jika rasio > <?= $settings['threshold_normal'] ?>%
                        </p>
                    </div>
                </div>
            </div>


            <div class="bg-[#16304d] border border-white/5 rounded-2xl shadow-lg p-6 mb-6">
                <h3 class="font-bold text-white mb-4 flex items-center gap-2">
                    <span class="w-1 h-6 bg-gradient-to-b from-[#00C6FB] to-[#00F29C] rounded-full"></span>
                    Pengaturan Kurs
                </h3>
                <p class="text-sm text-[#B3C9D8] mb-4">Atur interval refresh nilai kurs mata uang</p>

                <div>
                    <label class="block text-sm font-medium text-[#B3C9D8] mb-2">
                        TTL Cache Kurs (detik)
                        <span class="text-slate-400 font-normal">- Berapa lama kurs di-cache sebelum di-refresh</span>
                    </label>
                    <div class="flex items-center gap-3">
                        <input type="number" name="kurs_ttl" value="<?= e($settings['kurs_ttl']) ?>" min="60"
                            max="86400" required
                            class="w-40 px-4 py-2 bg-[#0A2238] border border-white/10 text-white rounded-lg focus:ring-2 focus:ring-[#00C6FB] focus:border-transparent">
                        <span class="text-[#B3C9D8]">detik</span>
                        <span class="text-sm text-slate-400">
                            (<?= round($settings['kurs_ttl'] / 60) ?> menit /
                            <?= round($settings['kurs_ttl'] / 3600, 1) ?>
                            jam)
                        </span>
                    </div>
                </div>
            </div>



            <div class="bg-[#00C6FB]/10 border border-[#00C6FB]/20 rounded-lg p-4 mb-6">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-[#00C6FB] mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                    </svg>
                    <div>
                        <h4 class="font-medium text-[#00C6FB]">Cara Kerja Status</h4>
                        <p class="text-sm text-[#B3C9D8] mt-1">
                            Status keuangan dihitung berdasarkan rasio: <code
                                class="bg-[#00C6FB]/20 px-1 rounded text-white">(Pengeluaran / Pemasukan) × 100%</code>
                        </p>
                        <ul class="text-sm text-[#B3C9D8] mt-2 list-disc list-inside">
                            <li><strong>Hemat:</strong> Rasio ≤ <?= $settings['threshold_hemat'] ?>%</li>
                            <li><strong>Normal:</strong> Rasio <?= $settings['threshold_hemat'] ?>% -
                                <?= $settings['threshold_normal'] ?>%
                            </li>
                            <li><strong>Boros:</strong> Rasio > <?= $settings['threshold_normal'] ?>%</li>
                        </ul>
                    </div>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-gradient-to-r from-[#00C6FB] to-[#00F29C] text-[#0A2238] py-3 rounded-lg font-bold hover:shadow-lg hover:shadow-[#00C6FB]/20 transition-all duration-300">
                Simpan Pengaturan
            </button>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include dirname(__DIR__) . '/layouts/app.php';
?>