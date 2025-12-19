<?php
$title = 'Reminder Pembayaran';
ob_start();
?>

<div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4 animate-fadeInDown">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Reminder Pembayaran</h1>
        <p class="text-gray-500">Kelola pengingat SPP, kos, dan tagihan lainnya</p>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1 animate-fadeInUp stagger-1" style="animation-fill-mode: both;">
        <div class="bg-white rounded-lg shadow-sm p-6 card-animated hover-glow">
            <h3 class="font-semibold text-gray-800 mb-4">Tambah Reminder</h3>
            <form action="index.php?page=reminder&action=store" method="POST" class="space-y-4">
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
                        $bgClass = $isOverdue ? 'bg-red-50 border-red-200' : 'bg-gray-50';
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
                                <a href="index.php?page=reminder&action=send&id=<?= $r['id'] ?>"
                                    class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-sm hover:bg-blue-200 btn-animated">Kirim
                                    Email</a>
                                <form action="index.php?page=reminder&action=delete" method="POST"
                                    onsubmit="return confirm('Hapus reminder ini?')">
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