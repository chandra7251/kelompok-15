<?php
$title = 'Dashboard Orang Tua';
ob_start();
?>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Selamat Datang, <?= e($user['nama']) ?>!</h1>
    <p class="text-gray-500">Monitor keuangan anak Anda</p>
</div>

<div class="bg-white rounded-lg shadow-sm p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-semibold text-gray-800">Anak yang Terhubung</h3>
        <a href="index.php?page=transfer"
            class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700">+ Hubungkan
            Anak</a>
    </div>

    <?php if (empty($linkedMahasiswa)): ?>
        <div class="text-center py-8">
            <p class="text-gray-500 mb-3">Belum ada anak yang terhubung</p>
            <a href="index.php?page=transfer" class="text-indigo-600 font-medium">Hubungkan sekarang</a>
        </div>
    <?php else: ?>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($linkedMahasiswa as $mhs): ?>
                <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                <span class="font-bold text-indigo-600"><?= strtoupper(substr($mhs['nama'], 0, 1)) ?></span>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800"><?= e($mhs['nama']) ?></p>
                                <p class="text-sm text-gray-500"><?= e($mhs['nim']) ?></p>
                            </div>
                        </div>
                        <form action="index.php?page=transfer&action=unlink" method="POST"
                            onsubmit="return confirm('Yakin ingin melepas hubungan dengan anak ini?')">
                            <?= csrf_field() ?>
                            <input type="hidden" name="mahasiswa_id" value="<?= $mhs['id'] ?>">
                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Lepas</button>
                        </form>
                    </div>
                    <div class="bg-white rounded-lg p-3">
                        <p class="text-sm text-gray-500">Saldo Saat Ini</p>
                        <p class="text-lg font-bold text-indigo-600"><?= format_rupiah($mhs['saldo']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<div class="grid lg:grid-cols-2 gap-6">
    <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg p-6 text-white">
        <h3 class="font-semibold mb-4">Kirim Saldo Cepat</h3>
        <?php if (!empty($linkedMahasiswa)): ?>
            <form action="index.php?page=transfer&action=send&redirect=dashboard" method="POST" class="space-y-4">
                <?= csrf_field() ?>
                <div>
                    <label class="text-green-100 text-sm">Pilih Anak</label>
                    <select name="mahasiswa_id" required
                        class="w-full mt-1 px-4 py-2 rounded-lg bg-white/20 border border-white/30 text-white">
                        <?php foreach ($linkedMahasiswa as $mhs): ?>
                            <option value="<?= $mhs['id'] ?>" class="text-gray-800"><?= e($mhs['nama']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="text-green-100 text-sm">Jumlah</label>
                        <input type="number" name="jumlah" id="jumlahInput" required min="0.01" step="0.01"
                            placeholder="100"
                            class="w-full mt-1 px-4 py-2 rounded-lg bg-white/20 border border-white/30 text-white placeholder-white/60">
                    </div>
                    <div>
                        <label class="text-green-100 text-sm">Mata Uang</label>
                        <select name="mata_uang" id="currencySelect"
                            class="w-full mt-1 px-4 py-2 rounded-lg bg-white/20 border border-white/30 text-white">
                            <?php foreach ($currencies ?? ['IDR'] as $cur): ?>
                                <option value="<?= $cur ?>" class="text-gray-800" <?= $cur === 'IDR' ? 'selected' : '' ?>>
                                    <?= $cur ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <p id="convertedAmount" class="text-green-100 text-sm hidden"></p>
                <button type="submit"
                    class="w-full bg-white text-green-600 py-2 rounded-lg font-semibold hover:bg-green-50">Kirim
                    Saldo</button>
            </form>
        <?php else: ?>
            <p class="text-green-100">Hubungkan dengan anak terlebih dahulu.</p>
        <?php endif; ?>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="font-semibold text-gray-800 mb-4">Riwayat Transfer</h3>
        <?php if (empty($recentTransfer)): ?>
            <p class="text-gray-500 text-center py-6">Belum ada riwayat transfer</p>
        <?php else: ?>
            <div class="space-y-3">
                <?php foreach (array_slice($recentTransfer, 0, 5) as $tf): ?>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-800">Ke: <?= e($tf['mahasiswa_nama']) ?></p>
                            <p class="text-xs text-gray-500"><?= format_tanggal($tf['created_at']) ?></p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-green-600"><?= format_rupiah($tf['jumlah_idr']) ?></p>
                            <span
                                class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-700"><?= e($tf['status']) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    document.getElementById('currencySelect')?.addEventListener('change', function () {
        const currency = this.value;
        const input = document.getElementById('jumlahInput');
        if (currency === 'IDR') {
            input.min = '1000';
            input.step = '1000';
            input.placeholder = '100000';
        } else {
            input.min = '0.01';
            input.step = '0.01';
            input.placeholder = '10';
        }
    });
</script>

<?php
$content = ob_get_clean();
include dirname(__DIR__) . '/layouts/app.php';
?>