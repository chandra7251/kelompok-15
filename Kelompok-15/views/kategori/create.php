<?php
$title = 'Tambah Kategori';
ob_start();
?>

<div class="max-w-xl mx-auto px-4 sm:px-0 py-6 sm:py-8">
    <div class="mb-6 sm:mb-8 relative">
        <a href="/kategori" class="text-[#00C6FB] hover:text-[#00F29C] text-sm font-medium transition-colors">←
            Kembali</a>
        <h1 class="text-xl sm:text-2xl font-bold text-[#00C6FB] mt-4 text-center">Kategori</h1>
        <div class="h-px w-full bg-[#00C6FB]/30 mt-4"></div>
    </div>

    <div class="bg-[#0F2942] rounded-2xl p-5 sm:p-8 shadow-xl border border-white/5 relative overflow-hidden">
        <h2 class="text-lg sm:text-xl font-bold text-[#00F29C] text-center mb-6 sm:mb-8">Tambah Kategori</h2>

        <form action="/kategori/store" method="POST" class="space-y-6">
            <?= csrf_field() ?>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Nama kategori</label>
                <input type="text" name="nama" required value="<?= old('nama') ?>" maxlength="50"
                    class="w-full px-4 py-3 bg-[#0A2238] border border-white/10 rounded-xl text-white focus:ring-2 focus:ring-[#00C6FB] focus:border-transparent outline-none placeholder-gray-600"
                    placeholder="Pilih Kategori">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Tipe</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <label
                        class="flex items-center justify-center p-4 border border-white/10 bg-[#0A2238] rounded-xl cursor-pointer hover:border-[#0096C7] transition has-[:checked]:border-[#00C6FB] has-[:checked]:bg-[#00C6FB]/10 group relative overflow-hidden">
                        <input type="radio" name="tipe" value="pemasukan" class="hidden" required>
                        <span
                            class="w-8 h-8 rounded-full border border-[#00C6FB] flex items-center justify-center mr-3 bg-[#00C6FB]/10 group-has-[:checked]:bg-[#00C6FB] group-has-[:checked]:text-[#051933] text-[#00C6FB] transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                            </svg>
                        </span>
                        <span class="font-bold text-gray-300 group-has-[:checked]:text-white">Pemasukan</span>
                    </label>
                    <label
                        class="flex items-center justify-center p-4 border border-white/10 bg-[#0A2238] rounded-xl cursor-pointer hover:border-[#E05252] transition has-[:checked]:border-[#FF6B6B] has-[:checked]:bg-[#FF6B6B]/10 group relative overflow-hidden">
                        <input type="radio" name="tipe" value="pengeluaran" class="hidden" required>
                        <span
                            class="w-8 h-8 rounded-full border border-[#FF6B6B] flex items-center justify-center mr-3 bg-[#FF6B6B]/10 group-has-[:checked]:bg-[#FF6B6B] group-has-[:checked]:text-[#051933] text-[#FF6B6B] transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                            </svg>
                        </span>
                        <span class="font-bold text-gray-300 group-has-[:checked]:text-white">Pengeluaran</span>
                    </label>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 pt-4">
                <button type="submit"
                    class="flex-1 bg-gradient-to-r from-[#00C6FB] to-[#00F29C] text-[#051933] py-3 rounded-xl font-bold hover:shadow-[0_0_20px_rgba(0,198,251,0.4)] transition transform hover:scale-[1.02]">
                    Simpan Kategori
                </button>
                <a href="/kategori"
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