<?php
$title = 'Reminder Pembayaran';
ob_start();
?>

<div
    class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 sm:mb-6 gap-3 sm:gap-4 animate-fadeInDown px-3 sm:px-0">
    <div>
        <h1 class="text-2xl font-bold text-[#00C6FB]"> Reminder Pembayaran</h1>
        <p class="text-gray-400 text-sm mt-1">Kelola pengingat SPP, kos, dan tagihan lainnya</p>
    </div>
</div>

<div class="px-3 sm:px-0 mb-4">
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <p class="text-blue-800 text-sm">
            <strong>Info:</strong> Email reminder akan dikirim otomatis <strong>H-1</strong> sebelum tanggal jatuh
            tempo.
        </p>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-4 sm:gap-6 px-3 sm:px-0">
    <div class="lg:col-span-1 animate-fadeInUp stagger-1" style="animation-fill-mode: both;">
        <div class="bg-white rounded-lg shadow-sm p-6 card-animated hover-glow">
            <h3 class="font-semibold text-gray-800 mb-4">Tambah Reminder</h3>
            <form action="/reminder/store" method="POST" class="space-y-4">
                <?= csrf_field() ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Tagihan</label>
                    <input type="text" name="nama" required placeholder="SPP Semester, Kos, dll"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent input-animated">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah (Rp)</label>
                    <input type="number" name="jumlah" required min="1000" step="1000" placeholder="1000000"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent input-animated">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Jatuh Tempo</label>
                    <input type="date" name="tanggal_jatuh_tempo" required
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent input-animated">
                </div>
                <button type="submit"
                    class="w-full bg-indigo-600 text-white py-2 rounded-lg font-medium hover:bg-indigo-700 btn-animated">Tambah
                    Reminder</button>
            </form>
        </div>
    </div>

    <div class="lg:col-span-2 animate-fadeInUp stagger-2" style="animation-fill-mode: both;">
        <div class="bg-white rounded-lg shadow-sm p-6 card-animated">
            <h3 class="font-semibold text-gray-800 mb-4">Daftar Reminder</h3>
            <?php if (empty($reminders)): ?>
                <p class="text-gray-500 text-center py-8">Belum ada reminder</p>
            <?php else: ?>
                <div class="space-y-3">
                    <?php foreach ($reminders as $index => $r): ?>
                        <?php
                        $isOverdue = strtotime($r['tanggal_jatuh_tempo']) < time();
                        $isSent = $r['status'] === 'sent';
                        $bgClass = $isOverdue ? 'bg-red-50 border-red-200' : ($isSent ? 'bg-green-50 border-green-200' : 'bg-gray-50');
                        ?>
                        <div class="flex items-center justify-between p-4 <?= $bgClass ?> border rounded-lg hover-lift animate-fadeInUp"
                            style="animation-delay: <?= 0.1 * $index ?>s; animation-fill-mode: both;">
                            <div>
                                <p class="font-medium text-gray-800"><?= e($r['nama']) ?></p>
                                <p class="text-sm text-gray-500">Jatuh tempo: <?= format_tanggal($r['tanggal_jatuh_tempo']) ?>
                                </p>
                                <p class="text-lg font-semibold text-indigo-600"><?= format_rupiah($r['jumlah']) ?></p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <?php if ($isSent): ?>
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-sm">Terkirim</span>
                                <?php elseif ($isOverdue): ?>
                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-sm">Lewat</span>
                                <?php else: ?>
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-sm">Menunggu</span>
                                <?php endif; ?>
                                <form action="/reminder/delete" method="POST" onsubmit="return confirm('Hapus reminder ini?')">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= $r['id'] ?>">
                                    <button type="submit"
                                        class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-sm hover:bg-red-200 btn-animated">Hapus</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include dirname(__DIR__) . '/layouts/app.php';
?>