<?php
$title = 'Dashboard Orang Tua';
ob_start();
?>


<!-- Global Wrapper -->
<div class="w-full p-6 md:p-10 font-sans text-white">

    

    <!-- Welcome & Subtitle -->
    <div class="mb-10">
        <div class="inline-block bg-[#0C2642] px-4 py-2 rounded-lg mb-4">
             <p class="text-[#EAF6FF] text-sm">Welcome, <span class="bg-gradient-to-r from-[#00B4FF] to-[#00FFBF] bg-clip-text text-transparent font-bold"><?= e($user['nama']) ?></span> !</p>
        </div>
        <p class="text-[#CDE2EF] text-lg ml-1 font-light">Monitor keuangan anak anda</p>
    </div>

    <!-- Main Card: Anak yang Terhubung -->
    <!-- Background: #0F2F46 (Deep Blue specific) -->
    <div class="bg-[#0F2F46] rounded-[2rem] shadow-2xl border border-white/5 p-10 mb-8 relative overflow-hidden">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-8">
            <div>
                 <h3 class="text-xl font-bold text-[#EAF6FF] tracking-wide border-b-2 border-[#22d3ee] pb-1 inline-block">Anak yang terhubung</h3>
            </div>
            <a href="index.php?page=transfer"
                class="mt-4 md:mt-0 bg-[#133D57] px-6 py-2.5 rounded-xl text-sm font-bold transition-all">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-[#00C6FB] to-[#00F29C]">+ Hubungkan Anak</span>
            </a>
        </div>

        <?php if (empty($linkedMahasiswa)): ?>
            <div class="text-center py-20 flex flex-col items-center justify-center rounded-2xl">
                <p class="text-[#CDE2EF] mb-6 text-lg tracking-wide">Belum ada anak yang terhubung</p>
                <a href="index.php?page=transfer" class="text-transparent bg-clip-text bg-gradient-to-r from-[#00C6FB] to-[#00F29C] font-bold text-xl hover:text-white transition-colors cursor-pointer tracking-wide">Hubungkan Sekarang</a>
            </div>
        <?php else: ?>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($linkedMahasiswa as $mhs): ?>
                    <div class="bg-[#133D57] rounded-2xl p-6 border border-white/10 hover:border-[#22d3ee]/50 transition-all group relative">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-[#0F2F46] rounded-full flex items-center justify-center border border-white/20 group-hover:border-[#22d3ee] transition-colors">
                                    <span class="font-bold text-[#22d3ee] text-lg"><?= strtoupper(substr($mhs['nama'], 0, 1)) ?></span>
                                </div>
                                <div>
                                    <p class="font-bold text-white text-lg tracking-wide"><?= e($mhs['nama']) ?></p>
                                    <p class="text-sm text-gray-400"><?= e($mhs['nim']) ?></p>
                                </div>
                            </div>
                            
                            <form action="index.php?page=transfer&action=unlink" method="POST"
                                onsubmit="return confirm('Yakin ingin melepas hubungan dengan anak ini?')">
                                <?= csrf_field() ?>
                                <input type="hidden" name="mahasiswa_id" value="<?= $mhs['id'] ?>">
                                <button type="submit" class="text-red-400 hover:text-red-300 text-xs font-semibold bg-red-900/20 px-3 py-1 rounded-full transition-colors">Lepas</button>
                            </form>
                        </div>
                        <div class="bg-[#0A2639]/50 rounded-xl p-4 border border-white/5">
                            <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">Saldo Saat Ini</p>
                            <p class="text-2xl font-bold text-[#22d3ee]"><?= format_rupiah($mhs['saldo']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bottom Section: Grid 2 Columns -->
    <div class="grid lg:grid-cols-2 gap-8">
        
        <!-- Card: Kirim Saldo Cepat (Specific Green Gradient #10C98B -> #0FAE7A) -->
        <div class="bg-[linear-gradient(75deg,#00EE88_0%,#0FAF8E_35%)] rounded-[2rem] p-8 text-white shadow-2xl relative overflow-hidden group">
            
            <h3 class="font-bold text-xl mb-8 flex items-center gap-2">
                Kirim Saldo Cepat
            </h3>
            <p class="text-white/80 text-sm mb-6 -mt-6">Hubungkan dengan anak terlebih dahulu</p>
            
            <?php if (!empty($linkedMahasiswa)): ?>
                <form action="index.php?page=transfer&action=send&redirect=dashboard" method="POST" class="space-y-6 relative z-10">
                    <?= csrf_field() ?>
                    <div>
                        <select name="mahasiswa_id" required
                            class="w-full px-5 py-4 rounded-xl bg-white/20 border border-white/30 text-white placeholder-white focus:outline-none focus:ring-2 focus:ring-white/50 transition-all backdrop-blur-sm text-lg font-medium">
                            <?php foreach ($linkedMahasiswa as $mhs): ?>
                                <option value="<?= $mhs['id'] ?>" class="text-gray-900"><?= e($mhs['nama']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <input type="number" name="jumlah" id="jumlahInput" required min="0.01" step="0.01"
                                placeholder="100"
                                class="w-full px-5 py-4 rounded-xl bg-white/20 border border-white/30 text-white placeholder-white/80 focus:outline-none focus:ring-2 focus:ring-white/50 transition-all backdrop-blur-sm text-lg font-medium">
                        </div>
                        <div>
                            <select name="mata_uang" id="currencySelect"
                                class="w-full px-5 py-4 rounded-xl bg-white/20 border border-white/30 text-white focus:outline-none focus:ring-2 focus:ring-white/50 transition-all backdrop-blur-sm text-lg font-medium">
                                <?php foreach ($currencies ?? ['IDR'] as $cur): ?>
                                    <option value="<?= $cur ?>" class="text-gray-900" <?= $cur === 'IDR' ? 'selected' : '' ?>>
                                        <?= $cur ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <p id="convertedAmount" class="text-green-100 text-sm hidden bg-white/10 p-2 rounded-lg"></p>
                    
                    <button type="submit"
                        class="w-full bg-white text-[#0FAE7A] py-4 rounded-xl font-bold text-lg hover:shadow-lg hover:bg-green-50 transition-all transform hover:-translate-y-1 mt-4">
                        Kirim Saldo
                    </button>
                </form>
            <?php else: ?>
                <!-- If no student, keep the card visual but empty/disabled state implied by logic -->
            <?php endif; ?>
        </div>

        <!-- Card: Riwayat Transfer (Light Blueish Gray #EAF6FF) -->
        <div class="bg-[#EAF1F7] rounded-[2rem] shadow-xl p-8 border border-white/50">
            <h3 class="font-bold text-[#133D57] text-xl mb-8">
                Riwayat Transfer
            </h3>

            <?php if (empty($recentTransfer)): ?>
                <div class="flex flex-col items-center justify-center py-12 text-[#5A7C92]">
                    <p class="text-base font-medium">Belum Ada riwayat transfer</p>
                </div>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach (array_slice($recentTransfer, 0, 5) as $tf): ?>
                        <div class="flex items-center justify-between p-4 bg-white rounded-2xl shadow-sm border border-[#DCEBF5] hover:shadow-md transition-shadow">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-[#EAF1F7] flex items-center justify-center text-[#133D57]">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-[#133D57] text-sm md:text-base">Ke: <?= e($tf['mahasiswa_nama']) ?></p>
                                    <p class="text-xs text-gray-500 font-medium"><?= format_tanggal($tf['created_at']) ?></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-[#10C98B]"><?= format_rupiah($tf['jumlah_idr']) ?></p>
                                <span
                                    class="text-[10px] uppercase font-bold px-2 py-0.5 rounded-full bg-[#DCEBF5] text-[#133D57] tracking-wider"><?= e($tf['status']) ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
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