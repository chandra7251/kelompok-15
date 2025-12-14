<?php
$title = 'Kategori';
ob_start();
?>

<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Kategori</h1>
        <p class="text-gray-500 mt-1">Kelola kategori pemasukan dan pengeluaran</p>
    </div>
    <a href="index.php?page=kategori&action=create"
        class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-medium hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
        + Tambah Kategori
    </a>
</div>

<div class="grid md:grid-cols-2 gap-8">
    <!-- Pemasukan -->
    <div class="bg-white rounded-2xl p-6 card-shadow">
        <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
            <span class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-2">📥</span>
            Pemasukan
        </h3>
        <div class="space-y-3">
            <?php
            $pemasukanCount = 0;
            foreach ($kategoris as $kat):
                if ($kat['tipe'] === 'pemasukan'):
                    $pemasukanCount++;
                    ?>
                    <div class="flex items-center justify-between p-4 bg-green-50 rounded-xl">
                        <div>
                            <p class="font-medium text-gray-800"><?= e($kat['nama']) ?></p>
                            <p class="text-xs text-gray-500"><?= $kat['transaksi_count'] ?> transaksi</p>
                        </div>
                        <div class="flex space-x-2">
                            <a href="index.php?page=kategori&action=edit&id=<?= $kat['id'] ?>"
                                class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition">✏️</a>
                            <?php if ($kat['transaksi_count'] == 0): ?>
                                <form action="index.php?page=kategori&action=delete" method="POST" class="inline"
                                    onsubmit="return confirm('Hapus kategori ini?')">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= $kat['id'] ?>">
                                    <button type="submit"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">🗑️</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php
                endif;
            endforeach;
            if ($pemasukanCount === 0):
                ?>
                <p class="text-gray-500 text-center py-4">Belum ada kategori pemasukan</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Pengeluaran -->
    <div class="bg-white rounded-2xl p-6 card-shadow">
        <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
            <span class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-2">📤</span>
            Pengeluaran
        </h3>
        <div class="space-y-3">
            <?php
            $pengeluaranCount = 0;
            foreach ($kategoris as $kat):
                if ($kat['tipe'] === 'pengeluaran'):
                    $pengeluaranCount++;
                    ?>
                    <div class="flex items-center justify-between p-4 bg-red-50 rounded-xl">
                        <div>
                            <p class="font-medium text-gray-800"><?= e($kat['nama']) ?></p>
                            <p class="text-xs text-gray-500"><?= $kat['transaksi_count'] ?> transaksi</p>
                        </div>
                        <div class="flex space-x-2">
                            <a href="index.php?page=kategori&action=edit&id=<?= $kat['id'] ?>"
                                class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition">✏️</a>
                            <?php if ($kat['transaksi_count'] == 0): ?>
                                <form action="index.php?page=kategori&action=delete" method="POST" class="inline"
                                    onsubmit="return confirm('Hapus kategori ini?')">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= $kat['id'] ?>">
                                    <button type="submit"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">🗑️</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php
                endif;
            endforeach;
            if ($pengeluaranCount === 0):
                ?>
                <p class="text-gray-500 text-center py-4">Belum ada kategori pengeluaran</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include dirname(__DIR__) . '/layouts/app.php';
?>