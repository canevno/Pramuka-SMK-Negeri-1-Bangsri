<?php
    $mobileNavActiveHome = request()->routeIs('home');
    $mobileNavActiveProfil = request()->routeIs('about', 'visi-misi', 'ambalan');
    $mobileNavActiveOrganisasi = request()->routeIs('organisasi', 'pembina', 'dewan-kehormatan', 'dewan-ambalan', 'anggota-dewan', 'mitra');
    $mobileNavActiveAbsensi = request()->routeIs('absensi.*');
?>

<div id="mobile-bottom-nav" class="fixed inset-x-0 bottom-0 z-60 lg:hidden transition-transform duration-200 ease-out">
    <div class="flex items-center justify-between gap-1 border-t border-slate-700 bg-[#0D1B2A] px-2 pb-[calc(0.5rem+env(safe-area-inset-bottom))] pt-2 shadow-none" style="padding-bottom: calc(0.5rem + env(safe-area-inset-bottom));">
        <a href="<?php echo e(route('home')); ?>" aria-current="<?php echo e($mobileNavActiveHome ? 'page' : 'false'); ?>" class="flex flex-1 flex-col items-center justify-center gap-1 rounded-[14px] px-1 py-1.5 text-[10px] font-semibold transition-all duration-200 <?php echo e($mobileNavActiveHome ? 'text-white' : 'text-slate-300'); ?>">
            <svg class="h-5 w-5 <?php echo e($mobileNavActiveHome ? 'scale-110 drop-shadow-sm' : ''); ?>" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="<?php echo e($mobileNavActiveHome ? '2.2' : '1.9'); ?>" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M3 10.5 12 3l9 7.5"></path>
                <path d="M5 9.5V20h14V9.5"></path>
            </svg>
            <span class="<?php echo e($mobileNavActiveHome ? 'font-bold' : 'font-semibold'); ?>">Beranda</span>
        </a>

        <a href="<?php echo e(route('about')); ?>" aria-current="<?php echo e($mobileNavActiveProfil ? 'page' : 'false'); ?>" class="flex flex-1 flex-col items-center justify-center gap-1 rounded-[14px] px-1 py-1.5 text-[10px] font-semibold transition-all duration-200 <?php echo e($mobileNavActiveProfil ? 'text-white' : 'text-slate-300'); ?>">
            <svg class="h-5 w-5 <?php echo e($mobileNavActiveProfil ? 'scale-110 drop-shadow-sm' : ''); ?>" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="<?php echo e($mobileNavActiveProfil ? '2.2' : '1.9'); ?>" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M16 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"></path>
                <circle cx="9.5" cy="7" r="4"></circle>
                <path d="M20 8v6"></path>
                <path d="M23 11h-6"></path>
            </svg>
            <span class="<?php echo e($mobileNavActiveProfil ? 'font-bold' : 'font-semibold'); ?>">Profil</span>
        </a>

        <a href="<?php echo e(route('absensi.index')); ?>" aria-current="<?php echo e($mobileNavActiveAbsensi ? 'page' : 'false'); ?>" class="flex flex-1 flex-col items-center justify-center gap-1 rounded-[14px] px-1 py-1.5 text-[10px] font-semibold transition-all duration-200 <?php echo e($mobileNavActiveAbsensi ? 'text-white' : 'text-slate-300'); ?>">
            <svg class="h-5 w-5 <?php echo e($mobileNavActiveAbsensi ? 'scale-110 drop-shadow-sm' : ''); ?>" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="<?php echo e($mobileNavActiveAbsensi ? '2.2' : '1.9'); ?>" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M7 3h9l4 4v13a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"></path>
                <path d="M14 3v4h4"></path>
                <path d="M8 12h8M8 16h8"></path>
            </svg>
            <span class="<?php echo e($mobileNavActiveAbsensi ? 'font-bold' : 'font-semibold'); ?>">Absensi</span>
        </a>

        <a href="<?php echo e(route('pembina')); ?>" aria-current="<?php echo e($mobileNavActiveOrganisasi ? 'page' : 'false'); ?>" class="flex flex-1 flex-col items-center justify-center gap-1 rounded-[14px] px-1 py-1.5 text-[10px] font-semibold transition-all duration-200 <?php echo e($mobileNavActiveOrganisasi ? 'text-white' : 'text-slate-300'); ?>" aria-label="Buka halaman pembina">
            <svg class="h-5 w-5 <?php echo e($mobileNavActiveOrganisasi ? 'scale-110 drop-shadow-sm' : ''); ?>" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="<?php echo e($mobileNavActiveOrganisasi ? '2.2' : '1.9'); ?>" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M16 3.128a4 4 0 0 1 0 7.744"></path>
                <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M2 21v-2a4 4 0 0 1 4-4h6a4 4 0 0 1 4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
            </svg>
            <span class="<?php echo e($mobileNavActiveOrganisasi ? 'font-bold' : 'font-semibold'); ?>">Organisasi</span>
        </a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nav = document.getElementById('mobile-bottom-nav');
        if (!nav) return;

        const updateKeyboardState = () => {
            if (!window.visualViewport) {
                return;
            }

            const keyboardOpen = window.visualViewport.height < window.innerHeight - 120;
            nav.classList.toggle('hidden', keyboardOpen);
            nav.classList.toggle('translate-y-full', keyboardOpen);
        };

        if (window.visualViewport) {
            updateKeyboardState();
            window.visualViewport.addEventListener('resize', updateKeyboardState);
            window.visualViewport.addEventListener('scroll', updateKeyboardState);
        }
    });
</script><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/components/mobile-bottom-nav.blade.php ENDPATH**/ ?>