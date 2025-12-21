<?php
$title = 'Register';
ob_start();


$currentRole = old('role', 'mahasiswa'); 
?>




<style>
    
    /* Menghilangkan Scroll Bar pada browser */

    .no-scrollbar::-webkit-scrollbar, ::-webkit-scrollbar {
        display: none;
    }
    
    .no-scrollbar, html, body {
        -ms-overflow-style: none;  
        scrollbar-width: none;  
    }
</style>

<!-- Main Container -->
<div class="min-h-screen w-full bg-gradient-to-b from-[#051933] to-[#0A2547] flex relative overflow-hidden font-sans text-[#EAF6FF]">
    
    <!-- Vector Wave Bottom (Right Aligned, max width limited to illustration area) -->
    <div class="absolute bottom-0 right-0 w-full lg:w-[50%] z-0 pointer-events-none">
        <svg class="w-full h-auto max-h-[180px] lg:max-h-[300px]" viewBox="0 0 1440 320" fill="none" preserveAspectRatio="none">
            
            <path fill="#1D8072" fill-opacity="0.8" d="M0,320 C100,280 200,160 400,180 C600,200 700,270 900,230 C1100,190 1200,60 1440,100 V320 H0 Z"></path>
            
            <path fill="#2FAE9A" fill-opacity="1" d="M0,320 C100,280 250,120 450,150 C650,180 750,260 950,210 C1150,160 1250,20 1440,70 V320 H0 Z"></path>
        </svg>
    </div>

    <!-- Logo Kiri atas -->
    <div class="absolute top-8 left-8 lg:left-12 z-20 flex items-center gap-3">
        <div class="w-10 h-10 bg-[linear-gradient(135deg,#4ED4FF,#6AF5C9)] rounded-xl flex items-center justify-center shadow-lg  shadow-[#4ED4FF]/20">
            <span class="text-[#203351] font-bold text-lg">K</span>
        </div>
        <span class="text-xl font-bold bg-gradient-to-r from-[#00C6FB] to-[#00F29C] bg-clip-text text-transparent">KeuanganKu</span>
    </div>

    <!-- Section Form sign-up di kiri -->
    <div class="w-full lg:w-[45%] xl:w-[40%] flex flex-col justify-center px-8 lg:px-20 z-10 py-14 relative overflow-y-auto no-scrollbar">
        <div class="w-full max-w-md mx-auto mt-10 lg:mt-0">

            <h1 class="text-4xl lg:text-5xl font-black mb-8 text-center pt-12 pb-2 tracking-wide leading-normal" style="background: linear-gradient(to right, #00C6FB, #00F29C); -webkit-background-clip: text; -webkit-text-fill-color: transparent; filter: drop-shadow(0 0 12px rgba(0, 242, 156, 0.22)) drop-shadow(0 0 24px rgba(0, 198, 251, 0.10));">Sign-up to website</h1>

            <!-- Role Toggle -->
            <div class="flex bg-[#123C52] rounded-full p-1 mb-2 w-64 ml-auto relative cursor-pointer">
                <button type="button" onclick="switchRole('mahasiswa')" id="tab-mahasiswa"
                    class="flex-1 py-2 text-sm font-bold rounded-full transition-all duration-300 relative z-10 text-[#0B2A4A] bg-[#21E6D3]">
                    Student
                </button>
                <button type="button" onclick="switchRole('orangtua')" id="tab-orangtua"
                    class="flex-1 py-2 text-sm font-bold rounded-full transition-all duration-300 relative z-10 text-[#8FB6C8]">
                    Parent
                </button>
            </div>

            <!-- Form Sign-up -->
            <form action="index.php?page=register&action=submit" method="POST" class="space-y-5">
                <?= csrf_field() ?>
                <input type="hidden" name="role" id="role-input" value="<?= $currentRole ?>">

                <!-- SLOT 1: Name (Always Static) -->
                <div class="space-y-1 h-[76px]">
                    <label class="text-sm font-medium text-[#EAF6FF]/80 ml-1">Name</label>
                    <input type="text" name="nama" value="<?= old('nama') ?>" required
                        class="w-full h-12 px-4 bg-[#0E3A4F] border border-[#1b4b66] rounded-lg text-white placeholder-[#8FB6C8]/50 focus:outline-none focus:ring-2 focus:ring-[#21E6D3] focus:border-transparent transition-all shadow-inner"
                        placeholder="Enter Your Name">
                </div>

                <!-- SLOT 2: Email (Always Static) -->
                <div class="space-y-1 h-[76px]">
                    <label class="text-sm font-medium text-[#EAF6FF]/80 ml-1">Email Address</label>
                    <input type="email" name="email" value="<?= old('email') ?>" required
                        class="w-full h-12 px-4 bg-[#0E3A4F] border border-[#1b4b66] rounded-lg text-white placeholder-[#8FB6C8]/50 focus:outline-none focus:ring-2 focus:ring-[#21E6D3] focus:border-transparent transition-all shadow-inner"
                        placeholder="Enter Your Email Address">
                </div>

                <!-- SLOT 3: DYNAMIC 1 (NIM or No. Telepon) -->
                <div class="space-y-1 h-[76px]">
                    <label id="label-dynamic-1" class="text-sm font-medium text-[#EAF6FF]/80 ml-1">NIM (Nomor Induk Mahasiswa)</label>
                    <input type="text" id="input-dynamic-1" name="nim" 
                        class="w-full h-12 px-4 bg-[#0E3A4F] border border-[#1b4b66] rounded-lg text-white placeholder-[#8FB6C8]/50 focus:outline-none focus:ring-2 focus:ring-[#21E6D3] focus:border-transparent transition-all shadow-inner"
                        placeholder="Enter Your NIM">
                </div>

                <!-- SLOT 4: DYNAMIC 2 (Jurusan or Unused) -->
                <div class="space-y-1 h-[76px] transition-opacity duration-300" id="container-dynamic-2">
                    <label id="label-dynamic-2" class="text-sm font-medium text-[#EAF6FF]/80 ml-1">Jurusan</label>
                    <input type="text" id="input-dynamic-2" name="jurusan" 
                        class="w-full h-12 px-4 bg-[#0E3A4F] border border-[#1b4b66] rounded-lg text-white placeholder-[#8FB6C8]/50 focus:outline-none focus:ring-2 focus:ring-[#21E6D3] focus:border-transparent transition-all shadow-inner"
                        placeholder="Enter Your Jurusan">
                </div>

                <!-- SLOT 5: Password (Static) -->
                <div class="space-y-1 h-[76px]">
                    <label class="text-sm font-medium text-[#EAF6FF]/80 ml-1">Password</label>
                    <input type="password" name="password" required minlength="6"
                        class="w-full h-12 px-4 bg-[#0E3A4F] border border-[#1b4b66] rounded-lg text-white placeholder-[#8FB6C8]/50 focus:outline-none focus:ring-2 focus:ring-[#21E6D3] focus:border-transparent transition-all shadow-inner"
                        placeholder="Enter Your Password">
                </div>

                <!-- SLOT 6: Confirm Password (Static) -->
                <div class="space-y-1 h-[76px]">
                    <label class="text-sm font-medium text-[#EAF6FF]/80 ml-1">Password Confirm</label>
                    <input type="password" name="password_confirm" required
                        class="w-full h-12 px-4 bg-[#0E3A4F] border border-[#1b4b66] rounded-lg text-white placeholder-[#8FB6C8]/50 focus:outline-none focus:ring-2 focus:ring-[#21E6D3] focus:border-transparent transition-all shadow-inner"
                        placeholder="Confirm Your Password">
                </div>

                <!-- Submit Button ROW (Static) -->
                <div class="h-[76px] pt-4"> 
                    <button type="submit"
                        class="w-full h-14 bg-gradient-to-r from-[#00C6FB] to-[#00F29C] rounded-xl text-[#0B2A4A] font-extrabold text-xl tracking-wide uppercase hover:shadow-[0_0_20px_rgba(33,230,211,0.4)] transition-all transform hover:-translate-y-0.5">
                        Sign-up
                    </button>
                </div>

                 <div class="mt-6 text-center text-sm h-6">
                    <span class="text-[#8FB6C8] opacity-80">Already have account?</span>
                    <a href="index.php?page=login" class="text-[#00C6FB] font-bold hover:text-[#21E6D3] transition ml-1 uppercase">LOGIN</a>
                </div>

            </form>
        </div>
    </div>

    <!-- Bagian kanan: Illustration & Text -->
    <div class="hidden lg:flex flex-1 flex-col justify-center items-center relative z-10 pr-12">
        
        <!-- Text area di atas-->
        <div class="w-full max-w-2xl mb-12 absolute top-24 left-36">
            <div class="inline-block text-left">
                <div class="flex items-start gap-4 ">
                    <span class="text-[#21E6D3] text-5xl font-serif leading-none mt-[-10px]">“</span>
                    <p class="text-white text-[19px] font-normal leading-relaxed tracking-wide max-w-2xl">
                        Solusi digital untuk <span class="bg-gradient-to-r from-[#00C6FB] to-[#00F29C] text-[#0B2A4A] font-extrabold px-2 py-0.5 rounded-md mx-1">mencatat, menganalisis, dan memantau</span> pengeluaran mahasiswa secara cerdas.
                    </p>
                    <span class="text-[#21E6D3] text-5xl font-serif leading-none self-end mt-4 ml-[-5px]">”</span>
                </div>
            </div>
        </div>

        <!-- Illustration -->
        <div class="relative w-full max-w-2xl mt-20">
            <!-- Glow effect -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-[#00F29C]/10 blur-[100px] rounded-full"></div>
            
            <img src="assets/images/register-hero.png" alt="Registration Illustration" 
                class="w-full h-auto object-contain drop-shadow-[0_0_30px_rgba(0,242,156,0.1)] relative z-10">
        </div>

    </div>

</div>


<script>
    const oldData = {
        nim: "<?= old('nim') ?>",
        no_telepon: "<?= old('no_telepon') ?>",
        jurusan: "<?= old('jurusan') ?>"
    };

    function switchRole(role) {
        const roleInput = document.getElementById('role-input');
        roleInput.value = role;

        
        const tabM = document.getElementById('tab-mahasiswa');
        const tabO = document.getElementById('tab-orangtua');
        
        
        const baseClass = 'flex-1 py-2 text-sm font-bold rounded-full transition-all duration-300 relative z-10';
        tabM.className = baseClass;
        tabO.className = baseClass;

        const activeClass = ['bg-[#21E6D3]', 'text-[#0B2A4A]'];
        const inactiveClass = ['text-[#8FB6C8]', 'hover:text-[#EAF6FF]'];

        
        const label1 = document.getElementById('label-dynamic-1');
        const input1 = document.getElementById('input-dynamic-1');
        
        const container2 = document.getElementById('container-dynamic-2');
        const label2 = document.getElementById('label-dynamic-2');
        const input2 = document.getElementById('input-dynamic-2');

        if (role === 'mahasiswa') {
           
            tabM.classList.add(...activeClass);
            tabO.classList.add(...inactiveClass);

            
            label1.textContent = 'NIM (Nomor Induk Mahasiswa)';
            input1.name = 'nim';
            input1.placeholder = 'Enter Your NIM';
            input1.value = oldData.nim; 

            // Slot 2 -> Jurusan (Active)
            container2.classList.remove('opacity-30', 'grayscale');
            label2.textContent = 'Jurusan';
            input2.name = 'jurusan';
            input2.disabled = false;
            input2.placeholder = 'Enter Your Jurusan';
            input2.value = oldData.jurusan;

        } else {
            
            tabO.classList.add(...activeClass);
            tabM.classList.add(...inactiveClass);

            
            label1.textContent = 'No. Telepon';
            input1.name = 'no_telepon';
            input1.placeholder = 'Enter Phone Number';
            input1.value = oldData.no_telepon;

            
            container2.classList.add('opacity-30', 'grayscale');
            label2.textContent = 'Not Applicable'; 
            input2.name = 'unused_field'; 
            input2.disabled = true;
            input2.placeholder = '-';
            input2.value = '';
        }
    }
    

    switchRole("<?= $currentRole ?>");
</script>

<?php
$content = ob_get_clean();
include dirname(__DIR__) . '/layouts/auth.php';
?>