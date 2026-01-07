<?php
$title = 'Edit Transaksi';
ob_start();
?>

<div class="max-w-2xl mx-auto px-4 sm:px-0 py-6 sm:py-8">
    <div class="mb-6 sm:mb-8 relative">
        <a href="/transaksi" class="text-[#00C6FB] hover:text-[#00F29C] text-sm font-medium transition-colors">←
            Kembali</a>
        <h1 class="text-xl sm:text-2xl font-bold text-[#00C6FB] mt-4 text-center">Edit Transaksi</h1>
        <div class="h-px w-full bg-[#00C6FB]/30 mt-4"></div>
    </div>

    <div class="bg-[#0F2942] rounded-2xl p-5 sm:p-8 shadow-xl border border-white/5 relative overflow-hidden">
        <form action="/transaksi/update" method="POST" class="space-y-6">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= $transaksi->getId() ?>">

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Kategori</label>
                <select name="kategori_id" required
                    class="w-full px-4 py-3 bg-[#0A2238] border border-white/10 rounded-xl text-white focus:ring-2 focus:ring-[#00C6FB] focus:border-transparent outline-none">
                    <optgroup label="📥 Pemasukan" class="text-[#00F29C] bg-[#0A2238]">
                        <?php foreach ($kategoris as $kat): ?>
                            <?php if ($kat['tipe'] === 'pemasukan'): ?>
                                <option value="<?= $kat['id'] ?>" class="text-white bg-[#0A2238]"
                                    <?= $kat['id'] == $transaksi->getKategoriId() ? 'selected' : '' ?>>
                                    <?= e($kat['nama']) ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </optgroup>
                    <optgroup label="📤 Pengeluaran" class="text-[#FF6B6B] bg-[#0A2238]">
                        <?php foreach ($kategoris as $kat): ?>
                            <?php if ($kat['tipe'] === 'pengeluaran'): ?>
                                <option value="<?= $kat['id'] ?>" class="text-white bg-[#0A2238]"
                                    <?= $kat['id'] == $transaksi->getKategoriId() ? 'selected' : '' ?>>
                                    <?= e($kat['nama']) ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </optgroup>
                </select>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Jumlah</label>
                    <input type="number" name="jumlah" required min="1" step="0.01"
                        value="<?= $transaksi->getJumlah() ?>"
                        class="w-full px-4 py-3 bg-[#0A2238] border border-white/10 rounded-xl text-white focus:ring-2 focus:ring-[#00C6FB] focus:border-transparent outline-none placeholder-gray-600">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Mata Uang</label>
                    <select name="mata_uang"
                        class="w-full px-4 py-3 bg-[#0A2238] border border-white/10 rounded-xl text-white focus:ring-2 focus:ring-[#00C6FB] focus:border-transparent outline-none">
                        <?php foreach ($currencies as $code => $name): ?>
                            <option value="<?= $code ?>" class="bg-[#0A2238]" <?= $code === $transaksi->getMataUang() ? 'selected' : '' ?>>
                                <?= $code ?> - <?= $name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Tanggal</label>
                <input type="date" name="tanggal" required value="<?= $transaksi->getTanggal() ?>"
                    class="w-full px-4 py-3 bg-[#0A2238] border border-white/10 rounded-xl text-white focus:ring-2 focus:ring-[#00C6FB] focus:border-transparent outline-none [color-scheme:dark]">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Keterangan</label>
                <textarea name="keterangan" rows="3"
                    class="w-full px-4 py-3 bg-[#0A2238] border border-white/10 rounded-xl text-white focus:ring-2 focus:ring-[#00C6FB] focus:border-transparent outline-none placeholder-gray-600"><?= e($transaksi->getKeterangan()) ?></textarea>
            </div>

            <div class="flex space-x-4 pt-4">
                <button type="submit"
                    class="flex-1 bg-gradient-to-r from-[#00C6FB] to-[#00F29C] text-[#051933] py-3 rounded-xl font-bold hover:shadow-[0_0_20px_rgba(0,198,251,0.4)] transition transform hover:scale-[1.02]">
                    Perbarui Transaksi
                </button>
                <a href="/transaksi"
                    class="px-8 py-3 border border-white/20 rounded-xl font-medium text-white hover:bg-white/5 transition text-center">
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