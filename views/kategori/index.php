<?php
$title = 'Kategori';
ob_start();
?>

<div class="w-full mx-auto px-3 md:px-6 py-4 pb-20 space-y-6 animate-[fadeIn_0.5s_ease-out]">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-[#00C6FB]">Kategori</h1>
            <p class="text-gray-400 text-sm mt-1">Kelola Kategori Pemasukan dan Pengeluaran</p>
        </div>
        <a href="/kategori/create"
            class="bg-[#00C6FB] text-[#051933] px-4 sm:px-6 py-2.5 rounded-xl font-bold hover:bg-[#00F29C] transition shadow-[0_0_15px_rgba(0,198,251,0.3)] flex items-center justify-center gap-2 text-sm sm:text-base">
            <span>+</span> Tambah Kategori
        </a>
    </div>

    <div class="grid md:grid-cols-2 gap-8">

        <div class="bg-[#0F2942] rounded-2xl p-6 shadow-xl border border-white/5">
            <h3 class="font-bold text-[#00F29C] mb-6 flex items-center text-lg">
                <span
                    class="w-8 h-8 rounded-full border border-[#00F29C] flex items-center justify-center mr-3 bg-[#00F29C]/10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                    </svg>
                </span>
                Pemasukan
            </h3>
            <div class="space-y-4">
                <?php
                $pemasukanCount = 0;
                foreach ($kategoris as $kat):
                    if ($kat['tipe'] === 'pemasukan'):
                        $pemasukanCount++;
                        ?>
                        <div
                            class="flex items-center justify-between p-4 bg-[#0A2238] rounded-xl border border-[#00F29C]/30 hover:border-[#00F29C] transition group">
                            <div>
                                <p class="font-bold text-white"><?= e($kat['nama']) ?></p>
                                <p class="text-xs text-gray-400 mt-1"><?= $kat['transaksi_count'] ?> Transaksi</p>
                            </div>
                            <div class="flex space-x-2 opacity-100 sm:opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="/kategori/edit?id=<?= $kat['id'] ?>"
                                    class="p-2 text-white hover:text-[#00C6FB] transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                        </path>
                                    </svg>
                                </a>
                                <form action="/kategori/delete" method="POST" class="inline"
                                    onsubmit="return confirm('Hapus kategori ini? <?= $kat['transaksi_count'] > 0 ? $kat['transaksi_count'] . ' transaksi akan menjadi tanpa kategori.' : '' ?>')">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= $kat['id'] ?>">
                                    <button type="submit" class="p-2 text-white hover:text-[#FF6B6B] transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <?php
                    endif;
                endforeach;
                if ($pemasukanCount === 0):
                    ?>
                    <p class="text-gray-500 text-center py-4 italic">Belum ada kategori pemasukan</p>
                <?php endif; ?>
            </div>
        </div>


        <div class="bg-[#0F2942] rounded-2xl p-6 shadow-xl border border-white/5">
            <h3 class="font-bold text-[#FF6B6B] mb-6 flex items-center text-lg">
                <span
                    class="w-8 h-8 rounded-full border border-[#FF6B6B] flex items-center justify-center mr-3 bg-[#FF6B6B]/10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </span>
                Pengeluaran
            </h3>
            <div class="space-y-4">
                <?php
                $pengeluaranCount = 0;
                foreach ($kategoris as $kat):
                    if ($kat['tipe'] === 'pengeluaran'):
                        $pengeluaranCount++;
                        ?>
                        <div
                            class="flex items-center justify-between p-4 bg-[#0A2238] rounded-xl border border-[#FF6B6B]/30 hover:border-[#FF6B6B] transition group">
                            <div>
                                <p class="font-bold text-white"><?= e($kat['nama']) ?></p>
                                <p class="text-xs text-gray-400 mt-1"><?= $kat['transaksi_count'] ?> Transaksi</p>
                            </div>
                            <div class="flex space-x-2 opacity-100 sm:opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="/kategori/edit?id=<?= $kat['id'] ?>"
                                    class="p-2 text-white hover:text-[#00C6FB] transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                        </path>
                                    </svg>
                                </a>
                                <form action="/kategori/delete" method="POST" class="inline"
                                    onsubmit="return confirm('Hapus kategori ini? <?= $kat['transaksi_count'] > 0 ? $kat['transaksi_count'] . ' transaksi akan menjadi tanpa kategori.' : '' ?>')">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= $kat['id'] ?>">
                                    <button type="submit" class="p-2 text-white hover:text-[#FF6B6B] transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <?php
                    endif;
                endforeach;
                if ($pengeluaranCount === 0):
                    ?>
                    <p class="text-gray-500 text-center py-4 italic">Belum ada kategori pengeluaran</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include dirname(__DIR__) . '/layouts/app.php';
?>