<?php
$title = 'Transfer Saldo';
ob_start();
?>

<div class="mb-8 mt-8">
    <p class="text-gray-500">Kirim saldo ke anak dan kelola hubungan</p>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1 space-y-6">
        <div class="card bg-[#133D57] rounded-2xl p-6 shadow-sm">
            <h3 class="font-semibold text-[#EAF6FF] mb-4">Hubungkan Anak</h3>
            <form action="index.php?page=transfer&action=link" method="POST" class="space-y-4">
                <?= csrf_field() ?>
                <div>
                    <label class="block text-sm font-medium text-[#CDE2EF] mb-2">Kode Pairing</label>
                    <input type="text" name="pairing_code" required maxlength="10" placeholder="XXXXXXXX"
                        class="w-full px-4 py-3 bg-[#0F2F46] border border-transparent rounded-xl text-[#EAF6FF] placeholder-[#7FAFC6] focus:ring-0 uppercase tracking-widest font-mono">
                </div>
                <button type="submit"
                    class="btn w-full bg-[#0F2F46] text-[#EAF6FF] py-3 rounded-xl font-medium">Hubungkan</button>
            </form>
        </div>

        <div class="card bg-[#133D57] rounded-2xl p-6 shadow-sm">
            <h3 class="font-semibold text-[#EAF6FF] mb-4">Anak Terhubung</h3>
            <?php if (empty($linkedMahasiswa)): ?>
                <p class="text-[#9FBFD1] text-sm text-center py-4">Belum ada anak yang terhubung</p>
            <?php else: ?>
                <div class="space-y-3">
                    <?php foreach ($linkedMahasiswa as $mhs): ?>
                        <div
                            class="flex items-center justify-between p-3 bg-[#0F2F46] rounded-xl hover:bg-[#0F2F46]/80 transition-all">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-[#133D57] rounded-xl flex items-center justify-center">
                                    <span class="text-[#EAF6FF] font-semibold"><?= strtoupper(substr($mhs['nama'], 0, 1)) ?></span>
                                </div>
                                <div>
                                    <p class="font-medium text-[#EAF6FF]"><?= e($mhs['nama']) ?></p>
                                    <p class="text-xs text-[#9FBFD1]"><?= e($mhs['nim']) ?></p>
                                </div>
                            </div>
                            <form action="index.php?page=transfer&action=unlink" method="POST"
                                onsubmit="return confirm('Lepaskan hubungan?')">
                                <?= csrf_field() ?>
                                <input type="hidden" name="mahasiswa_id" value="<?= $mhs['id'] ?>">
                                <button type="submit" class="text-[#FF6B6B] hover:text-red-400 p-1">
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
            class="bg-gradient-to-r from-[#0F2F46] to-[#133D57] rounded-2xl p-8 text-white shadow-lg">
            <h3 class="font-semibold text-xl mb-6 text-[#EAF6FF]">Kirim Saldo</h3>

            <?php if (empty($linkedMahasiswa)): ?>
                <div class="bg-[#0F2F46] rounded-xl p-6 text-center">
                    <svg class="w-12 h-12 mx-auto mb-3 text-[#6AF5C9]" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                    </svg>
                    <p class="text-[#CDE2EF]">Hubungkan dengan anak terlebih dahulu</p>
                </div>
            <?php else: ?>
                <form action="index.php?page=transfer&action=send" method="POST" class="space-y-5">
                    <?= csrf_field() ?>
                    <div>
                        <label class="text-[#CDE2EF] text-sm font-medium">Pilih Anak</label>
                        <select name="mahasiswa_id" required
                            class="w-full mt-2 px-4 py-3 rounded-xl bg-[#0F2F46] text-[#EAF6FF] border-0 focus:ring-0">
                            <?php foreach ($linkedMahasiswa as $mhs): ?>
                                <option value="<?= $mhs['id'] ?>"><?= e($mhs['nama']) ?> (<?= e($mhs['nim']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[#CDE2EF] text-sm font-medium">Jumlah</label>
                            <input type="number" name="jumlah" id="transferAmount" required min="0.01" step="0.01"
                                placeholder="100000"
                                class="w-full mt-2 px-4 py-3 rounded-xl bg-[#0F2F46] text-[#EAF6FF] placeholder-[#7FAFC6] border-0 focus:ring-0">
                        </div>
                        <div>
                            <label class="text-[#CDE2EF] text-sm font-medium">Mata Uang</label>
                            <select name="mata_uang" id="transferCurrency"
                                class="w-full mt-2 px-4 py-3 rounded-xl bg-[#0F2F46] text-[#EAF6FF] border-0 focus:ring-0">
                                <?php foreach ($currencies as $code => $name): ?>
                                    <option value="<?= $code ?>" <?= $code === 'IDR' ? 'selected' : '' ?>><?= $code ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="text-[#CDE2EF] text-sm font-medium">Keterangan (opsional)</label>
                        <input type="text" name="keterangan" placeholder="Uang bulanan, dll"
                            class="w-full mt-2 px-4 py-3 rounded-xl bg-[#0F2F46] text-[#EAF6FF] placeholder-[#7FAFC6] border-0 focus:ring-0">
                    </div>
                    <button type="submit"
                        class="btn w-full bg-gradient-to-r from-[#00B4FF] to-[#00FFBF] text-[#082235] py-4 rounded-xl font-bold hover:shadow-lg transition-all">
                        Kirim Saldo
                    </button>
                </form>
            <?php endif; ?>
        </div>

        <div class="card bg-[#133D57] rounded-2xl p-6 shadow-sm">
            <h3 class="font-semibold text-[#EAF6FF] mb-4">Riwayat Transfer</h3>
            <?php if (empty($history)): ?>
                <p class="text-[#9FBFD1] text-center py-8">Belum ada riwayat transfer</p>
            <?php else: ?>
                <div class="space-y-3">
                    <?php foreach ($history as $h): ?>
                        <div
                            class="flex items-center justify-between p-4 bg-[#0F2F46] hover:bg-[#0F2F46]/80 rounded-xl transition-all">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 bg-[#133D57] rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-[#6AF5C9]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-[#EAF6FF]">Ke: <?= e($h['mahasiswa_nama']) ?></p>
                                    <p class="text-xs text-[#9FBFD1]"><?= format_tanggal($h['created_at']) ?></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-[#6AF5C9]"><?= format_rupiah($h['jumlah_idr']) ?></p>
                                <span
                                    class="text-xs px-2 py-0.5 rounded-full <?= $h['status'] === 'completed' ? 'bg-[#133D57] text-[#6AF5C9] border border-[#6AF5C9]' : 'bg-[#133D57] text-[#9FBFD1]' ?>">
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