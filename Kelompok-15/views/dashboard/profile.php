<?php
$title = 'Profile';
ob_start();
?>

<div class="max-w-4xl mx-auto mt-8 px-4">
    <!-- Header Title -->
    <h1 class="text-2xl font-bold text-[#00C6FB] mb-6 tracking-wide">Profile Saya</h1>

    <!-- Single Profile Card -->
    <div class="relative w-full max-w-3xl bg-[#0F2942] rounded-2xl overflow-hidden shadow-2xl border border-white/5 mb-10">
        
        <!-- Top Banner (Blue Gradient) -->
        <div class="h-40 bg-gradient-to-r from-[#00C6FB] via-[#00A3FF] to-[#0082D5]"></div>

        <!-- Profile Content -->
        <div class="px-8 pb-10 relative">
            
            <!-- Avatar & Identity Section -->
            <div class="flex flex-col sm:flex-row items-center sm:items-center mt-6 mb-12 sm:space-x-4 -ml-4">
                <!-- Avatar Circle -->
                <div class="relative z-10 flex-shrink-0">
                    <div class="w-32 h-32 rounded-full border-4 border-[#0F2942] overflow-hidden bg-white shadow-lg flex items-center justify-center">
                        <?php if (isset(auth()['foto']) && !empty(auth()['foto'])): ?>
                            <img src="<?= e(auth()['foto']) ?>" alt="Profile" class="w-full h-full object-cover">
                        <?php else: ?>
                            <!-- Fallback Initials matching design style -->
                            <div class="w-full h-full bg-slate-200 flex items-center justify-center">
                                <span class="text-4xl font-bold text-gray-600"><?= strtoupper(substr(auth()['nama'], 0, 1)) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Name & Role -->
                <div class="mt-4 sm:mt-0 text-center sm:text-left">
                    <h2 class="text-3xl font-bold text-white tracking-wide"><?= e(auth()['nama']) ?></h2>
                    <p class="text-[#B3C9D8] text-sm font-medium mt-1"><?= e(auth()['role']) ?></p>
                </div>
            </div>

            <!-- Information List -->
            <div class="space-y-6">
                <!-- Email -->
                <div class="flex justify-between items-center border-b border-white/10 pb-4">
                    <span class="text-white font-bold text-lg">Email</span>
                    <span class="text-[#B3C9D8] text-right text-lg"><?= e(auth()['email']) ?></span>
                </div>

                <!-- No. Telepon (Orangtua) -->
                <?php if (is_role('orangtua') && isset(auth()['no_telepon'])): ?>
                    <div class="flex justify-between items-center border-b border-white/10 pb-4">
                        <span class="text-white font-bold text-lg">No. Telepon</span>
                        <span class="text-[#B3C9D8] text-right text-lg"><?= e(auth()['no_telepon']) ?></span>
                    </div>
                <?php endif; ?>

                <!-- Mahasiswa Specifics (Keeping logic present but styled) -->
                <?php if (is_role('mahasiswa') && isset(auth()['nim'])): ?>
                    <div class="flex justify-between items-center border-b border-white/10 pb-4">
                        <span class="text-white font-bold text-lg">NIM</span>
                        <span class="text-[#B3C9D8] text-right text-lg"><?= e(auth()['nim']) ?></span>
                    </div>
                    <div class="flex justify-between items-center border-b border-white/10 pb-4">
                        <span class="text-white font-bold text-lg">Jurusan</span>
                        <span class="text-[#B3C9D8] text-right text-lg"><?= e(auth()['jurusan'] ?? '-') ?></span>
                    </div>
                    <div class="flex justify-between items-center border-b border-white/10 pb-4">
                        <span class="text-white font-bold text-lg">Saldo</span>
                        <span class="text-[#00F29C] font-bold text-right text-lg"><?= format_rupiah(auth()['saldo'] ?? 0) ?></span>
                    </div>
                     <div class="flex justify-between items-center border-b border-white/10 pb-4">
                        <span class="text-white font-bold text-lg">Kode Pairing</span>
                        <span class="text-[#00C6FB] font-mono text-right text-lg tracking-wider"><?= e(auth()['pairing_code'] ?? '-') ?></span>
                    </div>
                <?php endif; ?>
                
                <!-- Ubah Password Placeholder/Trigger -->
                <div class="pt-2">
                    <button type="button" onclick="document.getElementById('passwordModal').classList.remove('hidden')" class="text-[#00C6FB] hover:text-[#00F29C] font-medium text-sm transition-colors cursor-pointer outline-none">
                        Ubah Password
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Password Change Modal -->
<div id="passwordModal" class="hidden fixed inset-0 z-[100] overflow-y-auto" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity" onclick="document.getElementById('passwordModal').classList.add('hidden')"></div>

    <!-- Modal Panel -->
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative w-full max-w-md transform overflow-hidden rounded-2xl bg-[#0F2942] border border-white/10 p-8 text-left shadow-2xl transition-all">
            <h3 class="text-2xl font-bold text-white mb-6">Ubah Password</h3>
            
            <form action="index.php?page=profile&action=update_password" method="POST" class="space-y-5">
                <?= csrf_field() ?>
                
                <div>
                    <label class="block text-sm font-medium text-[#B3C9D8] mb-2">Password Lama</label>
                    <input type="password" name="old_password" required minlength="6"
                        class="w-full px-4 py-3 bg-[#0A1F2E] border border-white/10 rounded-xl focus:ring-2 focus:ring-[#00C6FB] focus:border-transparent text-white placeholder-gray-500 transition-all outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#B3C9D8] mb-2">Password Baru</label>
                    <input type="password" name="new_password" required minlength="6"
                        class="w-full px-4 py-3 bg-[#0A1F2E] border border-white/10 rounded-xl focus:ring-2 focus:ring-[#00C6FB] focus:border-transparent text-white placeholder-gray-500 transition-all outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#B3C9D8] mb-2">Konfirmasi Password</label>
                    <input type="password" name="confirm_password" required minlength="6"
                        class="w-full px-4 py-3 bg-[#0A1F2E] border border-white/10 rounded-xl focus:ring-2 focus:ring-[#00C6FB] focus:border-transparent text-white placeholder-gray-500 transition-all outline-none">
                </div>

                <div class="flex gap-3 pt-4">
                     <button type="button" onclick="document.getElementById('passwordModal').classList.add('hidden')" 
                            class="flex-1 px-5 py-3 rounded-xl bg-white/5 text-white font-bold hover:bg-white/10 transition-all border border-white/10">
                        Batal
                    </button>
                    <button type="submit" 
                            class="flex-1 px-5 py-3 rounded-xl bg-gradient-to-r from-[#00C6FB] to-[#00F29C] text-[#051933] font-bold hover:shadow-[0_0_20px_rgba(0,198,251,0.3)] transition-all transform hover:scale-[1.02]">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include dirname(__DIR__) . '/layouts/app.php';
?>