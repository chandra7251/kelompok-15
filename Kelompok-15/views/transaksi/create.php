<?php
$title = 'Tambah Transaksi';
ob_start();
?>

<div class="max-w-2xl mx-auto py-8">
    <div class="mb-8 relative">
        <a href="index.php?page=transaksi" class="text-[#00C6FB] hover:text-[#00F29C] text-sm font-medium absolute -top-8 left-0 transition-colors">←
            Kembali</a>
        <h1 class="text-2xl font-bold text-[#00C6FB] mt-2 text-center">Tambah Transaksi</h1>
        <div class="h-px w-full bg-[#00C6FB]/30 mt-4"></div>
    </div>

    <div class="bg-[#0F2942] rounded-2xl p-8 shadow-xl border border-white/5 relative overflow-hidden">
        <form action="index.php?page=transaksi&action=store" method="POST" class="space-y-6">
            <?= csrf_field() ?>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Kategori</label>
                <select name="kategori_id" required
                    class="w-full px-4 py-3 bg-[#0A2238] border border-white/10 rounded-xl text-white focus:ring-2 focus:ring-[#00C6FB] focus:border-transparent outline-none">
                    <option value="">Pilih Kategori</option>
                    <optgroup label="📥 Pemasukan" class="text-[#00F29C] bg-[#0A2238]">
                        <?php foreach ($kategoris as $kat): ?>
                            <?php if ($kat['tipe'] === 'pemasukan'): ?>
                                <option value="<?= $kat['id'] ?>" class="text-white bg-[#0A2238]"><?= e($kat['nama']) ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </optgroup>
                    <optgroup label="📤 Pengeluaran" class="text-[#FF6B6B] bg-[#0A2238]">
                        <?php foreach ($kategoris as $kat): ?>
                            <?php if ($kat['tipe'] === 'pengeluaran'): ?>
                                <option value="<?= $kat['id'] ?>" class="text-white bg-[#0A2238]"><?= e($kat['nama']) ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </optgroup>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Jumlah</label>
                    <input type="number" name="jumlah" required min="1" step="0.01" value="<?= old('jumlah') ?>"
                        class="w-full px-4 py-3 bg-[#0A2238] border border-white/10 rounded-xl text-white focus:ring-2 focus:ring-[#00C6FB] focus:border-transparent outline-none placeholder-gray-600">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Mata Uang</label>
                    <select name="mata_uang"
                        class="w-full px-4 py-3 bg-[#0A2238] border border-white/10 rounded-xl text-white focus:ring-2 focus:ring-[#00C6FB] focus:border-transparent outline-none">
                        <?php foreach ($currencies as $code => $name): ?>
                            <option value="<?= $code ?>" class="bg-[#0A2238]" <?= $code === 'IDR' ? 'selected' : '' ?>><?= $code ?> - <?= $name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Tanggal</label>
                <input type="date" name="tanggal" required value="<?= old('tanggal', date('Y-m-d')) ?>"
                    class="w-full px-4 py-3 bg-[#0A2238] border border-white/10 rounded-xl text-white focus:ring-2 focus:ring-[#00C6FB] focus:border-transparent outline-none [color-scheme:dark]">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Keterangan</label>
                <textarea name="keterangan" rows="3"
                    class="w-full px-4 py-3 bg-[#0A2238] border border-white/10 rounded-xl text-white focus:ring-2 focus:ring-[#00C6FB] focus:border-transparent outline-none placeholder-gray-600"><?= old('keterangan') ?></textarea>
            </div>

            <div class="flex space-x-4 pt-4">
                <button type="submit"
                    class="flex-1 bg-gradient-to-r from-[#00C6FB] to-[#00F29C] text-[#051933] py-3 rounded-xl font-bold hover:shadow-[0_0_20px_rgba(0,198,251,0.4)] transition transform hover:scale-[1.02]">
                    Simpan Transaksi
                </button>
                <a href="index.php?page=transaksi"
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