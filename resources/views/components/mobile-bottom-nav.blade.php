@php
    $mobileNavActiveHome = request()->routeIs('home');
    $mobileNavActivePrestasi = request()->routeIs('prestasi.*', 'achievement') || request()->is('prestasi*');
    $mobileNavActiveProfil = request()->routeIs('about', 'visi-misi', 'ambalan', 'pembina', 'dewan-kehormatan', 'dewan-ambalan', 'anggota-dewan', 'mitra');
    $mobileNavActiveOrganisasi = request()->routeIs('organisasi', 'pembina');
    $mobileNavActiveAbsensi = request()->routeIs('absensi.*');
@endphp

<div class="fixed inset-x-0 bottom-0 z-[60] lg:hidden">
    <div class="flex items-center justify-between gap-1 border-t border-slate-700 bg-[#0D1B2A] px-2 pb-[calc(0.5rem+env(safe-area-inset-bottom))] pt-2 shadow-[0_-8px_20px_rgba(15,23,42,0.28)]" style="padding-bottom: calc(0.5rem + env(safe-area-inset-bottom));">
        <a href="{{ route('home') }}" aria-current="{{ $mobileNavActiveHome ? 'page' : 'false' }}" class="flex flex-1 flex-col items-center justify-center gap-1 rounded-[14px] px-1 py-1.5 text-[10px] font-semibold transition-all duration-200 {{ $mobileNavActiveHome ? 'text-white' : 'text-slate-300 hover:text-white' }}">
            <svg class="h-5 w-5 {{ $mobileNavActiveHome ? 'scale-110 drop-shadow-sm' : '' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $mobileNavActiveHome ? '2.2' : '1.9' }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M3 10.5 12 3l9 7.5"></path>
                <path d="M5 9.5V20h14V9.5"></path>
            </svg>
            <span class="{{ $mobileNavActiveHome ? 'font-bold' : 'font-semibold' }}">Beranda</span>
        </a>

        <a href="{{ route('prestasi.ranting') }}" aria-current="{{ $mobileNavActivePrestasi ? 'page' : 'false' }}" class="flex flex-1 flex-col items-center justify-center gap-1 rounded-[14px] px-1 py-1.5 text-[10px] font-semibold transition-all duration-200 {{ $mobileNavActivePrestasi ? 'text-white' : 'text-slate-300 hover:text-white' }}">
            <svg class="h-5 w-5 {{ $mobileNavActivePrestasi ? 'scale-110 drop-shadow-sm' : '' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $mobileNavActivePrestasi ? '2.2' : '1.9' }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M7 4h10v4a5 5 0 0 1-10 0V4Z"></path>
                <path d="M17 5h2a2 2 0 0 1 2 2v1a3 3 0 0 1-3 3h-1"></path>
                <path d="M7 5H5a2 2 0 0 0-2 2v1a3 3 0 0 0 3 3h1"></path>
                <path d="M12 17v4"></path>
                <path d="M8 21h8"></path>
            </svg>
            <span class="{{ $mobileNavActivePrestasi ? 'font-bold' : 'font-semibold' }}">Prestasi</span>
        </a>

        <a href="{{ route('about') }}" aria-current="{{ $mobileNavActiveProfil ? 'page' : 'false' }}" class="flex flex-1 flex-col items-center justify-center gap-1 rounded-[14px] px-1 py-1.5 text-[10px] font-semibold transition-all duration-200 {{ $mobileNavActiveProfil ? 'text-white' : 'text-slate-300 hover:text-white' }}">
            <svg class="h-5 w-5 {{ $mobileNavActiveProfil ? 'scale-110 drop-shadow-sm' : '' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $mobileNavActiveProfil ? '2.2' : '1.9' }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M16 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"></path>
                <circle cx="9.5" cy="7" r="4"></circle>
                <path d="M20 8v6"></path>
                <path d="M23 11h-6"></path>
            </svg>
            <span class="{{ $mobileNavActiveProfil ? 'font-bold' : 'font-semibold' }}">Profil</span>
        </a>

        <a href="{{ route('absensi.index') }}" aria-current="{{ $mobileNavActiveAbsensi ? 'page' : 'false' }}" class="flex flex-1 flex-col items-center justify-center gap-1 rounded-[14px] px-1 py-1.5 text-[10px] font-semibold transition-all duration-200 {{ $mobileNavActiveAbsensi ? 'text-white' : 'text-slate-300 hover:text-white' }}">
            <svg class="h-5 w-5 {{ $mobileNavActiveAbsensi ? 'scale-110 drop-shadow-sm' : '' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $mobileNavActiveAbsensi ? '2.2' : '1.9' }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M7 3h9l4 4v13a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"></path>
                <path d="M14 3v4h4"></path>
                <path d="M8 12h8M8 16h8"></path>
            </svg>
            <span class="{{ $mobileNavActiveAbsensi ? 'font-bold' : 'font-semibold' }}">Absensi</span>
        </a>

        <a href="{{ route('pembina') }}" aria-current="{{ $mobileNavActiveOrganisasi ? 'page' : 'false' }}" class="flex flex-1 flex-col items-center justify-center gap-1 rounded-[14px] px-1 py-1.5 text-[10px] font-semibold transition-all duration-200 {{ $mobileNavActiveOrganisasi ? 'text-white' : 'text-slate-300 hover:text-white' }}" aria-label="Buka halaman pembina">
            <svg class="h-5 w-5 {{ $mobileNavActiveOrganisasi ? 'scale-110 drop-shadow-sm' : '' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $mobileNavActiveOrganisasi ? '2.2' : '1.9' }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M16 3.128a4 4 0 0 1 0 7.744"></path>
                <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M2 21v-2a4 4 0 0 1 4-4h6a4 4 0 0 1 4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
            </svg>
            <span class="{{ $mobileNavActiveOrganisasi ? 'font-bold' : 'font-semibold' }}">Organisasi</span>
        </a>
    </div>
</div>