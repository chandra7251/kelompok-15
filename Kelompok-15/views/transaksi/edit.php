<?php
$title = 'Edit Transaksi';
ob_start();
?>

<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <a href="index.php?page=transaksi" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">←
            Kembali</a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Edit Transaksi</h1>
    </div>

    <div class="bg-white rounded-2xl p-8 card-shadow">
        <form action="index.php?page=transaksi&action=update" method="POST" class="space-y-6">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= $transaksi->getId() ?>">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                <select name="kategori_id" required
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    <optgroup label="📥 Pemasukan">
                        <?php foreach ($kategoris as $kat): ?>
                            <?php if ($kat['tipe'] === 'pemasukan'): ?>
                                <option value="<?= $kat['id'] ?>" <?= $kat['id'] == $transaksi->getKategoriId() ? 'selected' : '' ?>>
                                    <?= e($kat['nama']) ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </optgroup>
                    <optgroup label="📤 Pengeluaran">
                        <?php foreach ($kategoris as $kat): ?>
                            <?php if ($kat['tipe'] === 'pengeluaran'): ?>
                                <option value="<?= $kat['id'] ?>" <?= $kat['id'] == $transaksi->getKategoriId() ? 'selected' : '' ?>>
                                    <?= e($kat['nama']) ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </optgroup>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah</label>
                    <input type="number" name="jumlah" required min="1" step="0.01"
                        value="<?= $transaksi->getJumlah() ?>"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mata Uang</label>
                    <select name="mata_uang"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <?php foreach ($currencies as $code => $name): ?>
                            <option value="<?= $code ?>" <?= $code === $transaksi->getMataUang() ? 'selected' : '' ?>>
                                <?= $code ?> - <?= $name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                <input type="date" name="tanggal" required value="<?= $transaksi->getTanggal() ?>"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                <textarea name="keterangan" rows="3"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent"><?= e($transaksi->getKeterangan()) ?></textarea>
            </div>

            <div class="flex space-x-4">
                <button type="submit"
                    class="flex-1 bg-indigo-600 text-white py-3 rounded-xl font-semibold hover:bg-indigo-700 transition">
                    Perbarui Transaksi
                </button>
                <a href="index.php?page=transaksi"
                    class="px-6 py-3 border border-gray-200 rounded-xl font-medium text-gray-600 hover:bg-gray-50 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include dirname(__DIR__) . '/layouts/app.php';
?>