<?php
$title = 'Profile';
ob_start();
$photoPath = (auth()['photo'] ?? null) ? 'uploads/photos/' . auth()['photo'] : null;
?>

<div class="max-w-4xl mx-auto mt-6 sm:mt-8 px-3 sm:px-4">

    <h1 class="text-xl sm:text-2xl font-bold text-[#00C6FB] mb-4 sm:mb-6 tracking-wide">Profile Saya</h1>


    <div
        class="relative w-full max-w-3xl bg-[#0F2942] rounded-2xl overflow-hidden shadow-2xl border border-white/5 mb-10">


        <div class="h-40 bg-gradient-to-r from-[#00C6FB] via-[#00A3FF] to-[#0082D5]"></div>


        <div class="px-8 pb-10 relative">


            <div class="flex flex-col sm:flex-row items-center sm:items-center mt-6 mb-12 sm:space-x-4 -ml-4">

                <div class="flex flex-col items-center gap-3 relative z-10 flex-shrink-0">
                    <div class="relative group">
                        <div
                            class="w-32 h-32 rounded-full border-4 border-[#0F2942] overflow-hidden bg-white shadow-lg flex items-center justify-center transition-transform group-hover:scale-105">
                            <?php if (isset(auth()['photo']) && !empty(auth()['photo'])): ?>
                                <img src="/uploads/photos/<?= e(auth()['photo']) ?>?v=<?= time() ?>" alt="Profile"
                                    class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full bg-slate-200 flex items-center justify-center">
                                    <span
                                        class="text-4xl font-bold text-gray-600"><?= strtoupper(substr(auth()['nama'], 0, 1)) ?></span>
                                </div>
                            <?php endif; ?>


                            <label for="photoInput"
                                class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 cursor-pointer transition-all duration-300">
                                <span class="text-white text-xs font-bold uppercase tracking-wider">
                                    <svg class="w-8 h-8 mx-auto mb-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Ubah
                                </span>
                            </label>

                            <form id="photoForm" action="/profile/update_photo" method="POST"
                                enctype="multipart/form-data" class="hidden">
                                <?= csrf_field() ?>
                                <input type="file" name="photo" id="photoInput" accept="image/*" class="hidden"
                                    onchange="document.getElementById('photoForm').submit()">
                            </form>
                        </div>
                    </div>


                    <?php if (isset(auth()['photo']) && !empty(auth()['photo'])): ?>
                        <form action="/profile/delete_photo" method="POST" onsubmit="return confirm('Hapus foto profil?')">
                            <?= csrf_field() ?>
                            <button type="submit"
                                class="text-rose-400 hover:text-rose-300 text-xs font-bold uppercase tracking-wider flex items-center gap-1 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                                Hapus
                            </button>
                        </form>
                    <?php endif; ?>
                </div>



                <div class="mt-4 sm:mt-0 text-center sm:text-left">
                    <h2 class="text-3xl font-bold text-white tracking-wide"><?= e(auth()['nama']) ?></h2>
                    <p class="text-[#B3C9D8] text-sm font-medium mt-1"><?= e(auth()['role']) ?></p>
                    <p class="text-[10px] text-cyan-200/60 mt-1 font-medium tracking-wide">Upload Photo max 2 mb</p>
                </div>
            </div>


            <div class="space-y-6">

                <div class="flex justify-between items-center border-b border-white/10 pb-4">
                    <span class="text-white font-bold text-lg">Email</span>
                    <span class="text-[#B3C9D8] text-right text-lg"><?= e(auth()['email']) ?></span>
                </div>


                <?php if (is_role('orangtua') && isset(auth()['no_telepon'])): ?>
                    <div class="flex justify-between items-center border-b border-white/10 pb-4">
                        <span class="text-white font-bold text-lg">No. Telepon</span>
                        <span class="text-[#B3C9D8] text-right text-lg"><?= e(auth()['no_telepon']) ?></span>
                    </div>
                <?php endif; ?>


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
                        <span
                            class="text-[#00F29C] font-bold text-right text-lg"><?= format_rupiah(auth()['saldo'] ?? 0) ?></span>
                    </div>
                    <div class="flex justify-between items-center border-b border-white/10 pb-4">
                        <span class="text-white font-bold text-lg">Kode Pairing</span>
                        <span
                            class="text-[#00C6FB] font-mono text-right text-lg tracking-wider"><?= e(auth()['pairing_code'] ?? '-') ?></span>
                    </div>
                <?php endif; ?>


                <div class="pt-2">
                    <button type="button" onclick="document.getElementById('passwordModal').classList.remove('hidden')"
                        class="text-[#00C6FB] hover:text-[#00F29C] font-medium text-sm transition-colors cursor-pointer outline-none">
                        Ubah Password
                    </button>
                </div>



                <div id="passwordModal" class="hidden fixed inset-0 z-[100] overflow-y-auto" role="dialog"
                    aria-modal="true">

                    <div class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity"
                        onclick="document.getElementById('passwordModal').classList.add('hidden')"></div>


                    <div class="flex min-h-screen items-center justify-center p-4">
                        <div
                            class="relative w-full max-w-md transform overflow-hidden rounded-2xl bg-[#0F2942] border border-white/10 p-8 text-left shadow-2xl transition-all">
                            <h3 class="text-2xl font-bold text-white mb-6">Ubah Password</h3>

                            <form action="/profile/update_password" method="POST" class="space-y-5">
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
                                    <label class="block text-sm font-medium text-[#B3C9D8] mb-2">Konfirmasi
                                        Password</label>
                                    <input type="password" name="confirm_password" required minlength="6"
                                        class="w-full px-4 py-3 bg-[#0A1F2E] border border-white/10 rounded-xl focus:ring-2 focus:ring-[#00C6FB] focus:border-transparent text-white placeholder-gray-500 transition-all outline-none">
                                </div>

                                <div class="flex gap-3 pt-4">
                                    <button type="button"
                                        onclick="document.getElementById('passwordModal').classList.add('hidden')"
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

            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include dirname(__DIR__) . '/layouts/app.php';
?>