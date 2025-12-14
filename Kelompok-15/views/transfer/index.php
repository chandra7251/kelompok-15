<?php
$title = 'Transfer Saldo';
ob_start();
?>

<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800">Transfer Saldo</h1>
    <p class="text-gray-500">Kirim saldo ke anak dan kelola hubungan</p>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1 space-y-6">
        <div class="card bg-white rounded-2xl p-6 shadow-sm">
            <h3 class="font-semibold text-gray-800 mb-4">Hubungkan Anak</h3>
            <form action="index.php?page=transfer&action=link" method="POST" class="space-y-4">
                <?= csrf_field() ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kode Pairing</label>
                    <input type="text" name="pairing_code" required maxlength="10" placeholder="XXXXXXXX"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent uppercase tracking-widest font-mono input-focus">
                </div>
                <button type="submit"
                    class="btn w-full gradient-bg text-white py-3 rounded-xl font-medium">Hubungkan</button>
            </form>
        </div>

        <div class="card bg-white rounded-2xl p-6 shadow-sm">
            <h3 class="font-semibold text-gray-800 mb-4">Anak Terhubung</h3>
            <?php if (empty($linkedMahasiswa)): ?>
                <p class="text-gray-500 text-sm text-center py-4">Belum ada anak yang terhubung</p>
            <?php else: ?>
                <div class="space-y-3">
                    <?php foreach ($linkedMahasiswa as $mhs): ?>
                        <div
                            class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 gradient-bg rounded-xl flex items-center justify-center">
                                    <span class="text-white font-semibold"><?= strtoupper(substr($mhs['nama'], 0, 1)) ?></span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800"><?= e($mhs['nama']) ?></p>
                                    <p class="text-xs text-gray-500"><?= e($mhs['nim']) ?></p>
                                </div>
                            </div>
                            <form action="index.php?page=transfer&action=unlink" method="POST"
                                onsubmit="return confirm('Lepaskan hubungan?')">
                                <?= csrf_field() ?>
                                <input type="hidden" name="mahasiswa_id" value="<?= $mhs['id'] ?>">
                                <button type="submit" class="text-red-500 hover:text-red-700 p-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="lg:col-span-2 space-y-6">
        <div
            class="bg-gradient-to-br from-green-500 via-emerald-500 to-teal-600 rounded-2xl p-8 text-white shadow-lg shadow-green-500/30">
            <h3 class="font-semibold text-xl mb-6">Kirim Saldo</h3>

            <?php if (empty($linkedMahasiswa)): ?>
                <div class="bg-white/15 backdrop-blur rounded-xl p-6 text-center">
                    <svg class="w-12 h-12 mx-auto mb-3 text-green-100" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                    </svg>
                    <p class="text-green-100">Hubungkan dengan anak terlebih dahulu</p>
                </div>
            <?php else: ?>
                <form action="index.php?page=transfer&action=send" method="POST" class="space-y-5">
                    <?= csrf_field() ?>
                    <div>
                        <label class="text-green-100 text-sm font-medium">Pilih Anak</label>
                        <select name="mahasiswa_id" required
                            class="w-full mt-2 px-4 py-3 rounded-xl bg-white text-gray-800 border-0 focus:ring-2 focus:ring-green-300">
                            <?php foreach ($linkedMahasiswa as $mhs): ?>
                                <option value="<?= $mhs['id'] ?>"><?= e($mhs['nama']) ?> (<?= e($mhs['nim']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-green-100 text-sm font-medium">Jumlah</label>
                            <input type="number" name="jumlah" id="transferAmount" required min="0.01" step="0.01"
                                placeholder="100000"
                                class="w-full mt-2 px-4 py-3 rounded-xl bg-white text-gray-800 border-0 focus:ring-2 focus:ring-green-300">
                        </div>
                        <div>
                            <label class="text-green-100 text-sm font-medium">Mata Uang</label>
                            <select name="mata_uang" id="transferCurrency"
                                class="w-full mt-2 px-4 py-3 rounded-xl bg-white text-gray-800 border-0 focus:ring-2 focus:ring-green-300">
                                <?php foreach ($currencies as $code => $name): ?>
                                    <option value="<?= $code ?>" <?= $code === 'IDR' ? 'selected' : '' ?>><?= $code ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="text-green-100 text-sm font-medium">Keterangan (opsional)</label>
                        <input type="text" name="keterangan" placeholder="Uang bulanan, dll"
                            class="w-full mt-2 px-4 py-3 rounded-xl bg-white text-gray-800 border-0 focus:ring-2 focus:ring-green-300">
                    </div>
                    <button type="submit"
                        class="btn w-full bg-white text-green-600 py-4 rounded-xl font-bold hover:bg-green-50 text-lg shadow-lg">
                        Kirim Saldo
                    </button>
                </form>
            <?php endif; ?>
        </div>

        <div class="card bg-white rounded-2xl p-6 shadow-sm">
            <h3 class="font-semibold text-gray-800 mb-4">Riwayat Transfer</h3>
            <?php if (empty($history)): ?>
                <p class="text-gray-500 text-center py-8">Belum ada riwayat transfer</p>
            <?php else: ?>
                <div class="space-y-3">
                    <?php foreach ($history as $h): ?>
                        <div
                            class="flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 rounded-xl transition-all">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Ke: <?= e($h['mahasiswa_nama']) ?></p>
                                    <p class="text-xs text-gray-500"><?= format_tanggal($h['created_at']) ?></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-green-600"><?= format_rupiah($h['jumlah_idr']) ?></p>
                                <span
                                    class="text-xs px-2 py-0.5 rounded-full <?= $h['status'] === 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' ?>">
                                    <?= e($h['status']) ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    document.getElementById('transferCurrency')?.addEventListener('change', function () {
        const currency = this.value;
        const input = document.getElementById('transferAmount');
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