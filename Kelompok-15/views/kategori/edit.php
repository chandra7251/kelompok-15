<?php
$title = 'Edit Kategori';
ob_start();
?>

<div class="max-w-xl mx-auto">
    <div class="mb-8">
        <a href="index.php?page=kategori" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">←
            Kembali</a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Edit Kategori</h1>
    </div>

    <div class="bg-white rounded-2xl p-8 card-shadow">
        <form action="index.php?page=kategori&action=update" method="POST" class="space-y-6">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= $kategori->getId() ?>">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori</label>
                <input type="text" name="nama" required value="<?= e($kategori->getNama()) ?>" maxlength="50"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipe</label>
                <div class="grid grid-cols-2 gap-4">
                    <label
                        class="flex items-center p-4 border-2 rounded-xl cursor-pointer transition
                        <?= $kategori->getTipe() === 'pemasukan' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-green-400' ?>">
                        <input type="radio" name="tipe" value="pemasukan" class="hidden" required
                            <?= $kategori->getTipe() === 'pemasukan' ? 'checked' : '' ?>>
                        <span class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">📥</span>
                        <span class="font-medium text-gray-700">Pemasukan</span>
                    </label>
                    <label
                        class="flex items-center p-4 border-2 rounded-xl cursor-pointer transition
                        <?= $kategori->getTipe() === 'pengeluaran' ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-red-400' ?>">
                        <input type="radio" name="tipe" value="pengeluaran" class="hidden" required
                            <?= $kategori->getTipe() === 'pengeluaran' ? 'checked' : '' ?>>
                        <span class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3">📤</span>
                        <span class="font-medium text-gray-700">Pengeluaran</span>
                    </label>
                </div>
            </div>

            <div class="flex space-x-4">
                <button type="submit"
                    class="flex-1 bg-indigo-600 text-white py-3 rounded-xl font-semibold hover:bg-indigo-700 transition">
                    Perbarui Kategori
                </button>
                <a href="index.php?page=kategori"
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