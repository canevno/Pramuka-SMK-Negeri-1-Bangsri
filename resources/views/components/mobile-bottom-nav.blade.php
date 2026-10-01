@php
    $mobileNavActiveHome = request()->routeIs('home');
    $mobileNavActiveProfil = request()->routeIs('about', 'visi-misi', 'ambalan');
    $mobileNavActiveOrganisasi = request()->routeIs('organisasi', 'pembina', 'dewan-kehormatan', 'dewan-ambalan', 'anggota-dewan');
    $mobileNavActiveAbsensi = request()->routeIs('absensi.*');
@endphp

<div id="mobile-bottom-nav" class="fixed inset-x-0 bottom-0 z-60 lg:hidden transition-transform duration-200 ease-out">
    <div class="flex items-center justify-between gap-1 border-t border-slate-700 bg-[#0D1B2A] px-2 pb-[calc(0.5rem+env(safe-area-inset-bottom))] pt-2 shadow-none" style="padding-bottom: calc(0.5rem + env(safe-area-inset-bottom));">
        <a href="{{ route('home') }}" aria-current="{{ $mobileNavActiveHome ? 'page' : 'false' }}" class="flex flex-1 flex-col items-center justify-center gap-1 rounded-[14px] px-1 py-1.5 text-[10px] font-semibold transition-all duration-200 {{ $mobileNavActiveHome ? 'text-white' : 'text-slate-300' }}">
            <svg class="h-6 w-6 {{ $mobileNavActiveHome ? 'scale-110 drop-shadow-sm' : '' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $mobileNavActiveHome ? '2' : '1.5' }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"></path>
            </svg>
            <span class="{{ $mobileNavActiveHome ? 'font-bold' : 'font-semibold' }}">Beranda</span>
        </a>

        <a href="{{ route('about') }}" aria-current="{{ $mobileNavActiveProfil ? 'page' : 'false' }}" class="flex flex-1 flex-col items-center justify-center gap-1 rounded-[14px] px-1 py-1.5 text-[10px] font-semibold transition-all duration-200 {{ $mobileNavActiveProfil ? 'text-white' : 'text-slate-300' }}">
            <svg class="h-6 w-6 {{ $mobileNavActiveProfil ? 'scale-110 drop-shadow-sm' : '' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $mobileNavActiveProfil ? '2' : '1.5' }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"></path>
            </svg>
            <span class="{{ $mobileNavActiveProfil ? 'font-bold' : 'font-semibold' }}">Profil</span>
        </a>

        <a href="{{ route('absensi.index') }}" aria-current="{{ $mobileNavActiveAbsensi ? 'page' : 'false' }}" class="flex flex-1 flex-col items-center justify-center gap-1 rounded-[14px] px-1 py-1.5 text-[10px] font-semibold transition-all duration-200 {{ $mobileNavActiveAbsensi ? 'text-white' : 'text-slate-300' }}">
            <svg class="h-6 w-6 {{ $mobileNavActiveAbsensi ? 'scale-110 drop-shadow-sm' : '' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $mobileNavActiveAbsensi ? '2' : '1.5' }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75"></path>
            </svg>
            <span class="{{ $mobileNavActiveAbsensi ? 'font-bold' : 'font-semibold' }}">Absensi</span>
        </a>

        <a href="{{ route('pembina') }}" aria-current="{{ $mobileNavActiveOrganisasi ? 'page' : 'false' }}" class="flex flex-1 flex-col items-center justify-center gap-1 rounded-[14px] px-1 py-1.5 text-[10px] font-semibold transition-all duration-200 {{ $mobileNavActiveOrganisasi ? 'text-white' : 'text-slate-300' }}" aria-label="Buka halaman pembina">
            <svg class="h-6 w-6 {{ $mobileNavActiveOrganisasi ? 'scale-110 drop-shadow-sm' : '' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $mobileNavActiveOrganisasi ? '2' : '1.5' }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z"></path>
            </svg>
            <span class="{{ $mobileNavActiveOrganisasi ? 'font-bold' : 'font-semibold' }}">Organisasi</span>
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
</script>