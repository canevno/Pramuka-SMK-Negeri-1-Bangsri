@extends('layouts.frontend')

@section('title', 'Galeri Visual — Moodboard Exhibition')

@section('content')
@php
    $galleryItems = $galleryItems ?? \App\Models\GalleryItem::query()
        ->where('is_published', true)
        ->orderByDesc('is_featured')
        ->orderByDesc('published_at')
        ->orderByDesc('id')
        ->get();

    $resolveGalleryImage = function ($path) {
        if (empty($path)) {
            return asset('images/gallery/default.jpg');
        }

        $normalized = trim((string) $path);
        $normalized = str_replace('\\', '/', $normalized);
        $normalized = ltrim($normalized, '/');

        if (str_starts_with($normalized, 'http')) {
            return $normalized;
        }

        if (str_starts_with($normalized, 'public/')) {
            $normalized = preg_replace('#^public/#', '', $normalized);
        }

        if (str_starts_with($normalized, 'storage/')) {
            return asset($normalized);
        }

        if (str_starts_with($normalized, 'gallery/')) {
            return \Illuminate\Support\Facades\Storage::url($normalized);
        }

        if (str_contains($normalized, '/storage/')) {
            return asset(ltrim($normalized, '/'));
        }

        if (str_contains($normalized, 'storage/')) {
            return asset($normalized);
        }

        return asset($normalized);
    };
@endphp

<main class="w-full min-h-screen bg-[#f4f3ef] dark:bg-gray-950 text-neutral-900 dark:text-white py-10 px-4 sm:px-6 md:px-10 lg:px-16 transition-colors duration-200">
    <div id="galleryContent" class="mx-auto max-w-6xl">
        <div class="mb-8 text-center">
            <h1 class="mt-3 text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl md:text-5xl">
                Dokumentasi Kegiatan Pramuka
            </h1>
        </div>

        @if($galleryItems->isEmpty())
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white/60 p-10 text-center text-sm text-slate-600 dark:border-slate-700 dark:bg-slate-900/40 dark:text-slate-300">
                Belum ada foto yang dipublikasikan. Silakan unggah foto dari panel admin terlebih dahulu.
            </div>
        @else
            {{-- Layout mosaik: pola berulang tiap 9 foto (foto ke-2 tinggi, foto ke-3 dan ke-9 lebar) --}}
            <div class="grid grid-flow-dense grid-cols-2 auto-rows-[150px] gap-2 sm:auto-rows-[190px] md:grid-cols-4 md:auto-rows-[180px] lg:auto-rows-[210px]">
                @foreach($galleryItems as $item)
                    @php
                        $imageUrl = $resolveGalleryImage($item->image);
                        $caption = $item->title ?: ($item->alt_text ?: 'Galeri Pramuka');
                        $spanClass = match ($loop->index % 9) {
                            1 => 'md:row-span-2',
                            2, 8 => 'md:col-span-2',
                            default => '',
                        };
                    @endphp

                    <div class="group relative cursor-pointer overflow-hidden bg-neutral-200 transition-all duration-300 dark:bg-neutral-800 {{ $spanClass }}"
                         onclick="openGalleryLightbox('{{ $imageUrl }}', '{{ addslashes($caption) }}', '{{ addslashes($item->location ?: '') }}')">
                        <img src="{{ $imageUrl }}"
                             alt="{{ $item->alt_text ?: $item->title }}"
                             class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">

                        {{-- Kartu keterangan efek blur (glass) yang muncul saat hover --}}
                        <div class="pointer-events-none absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-black/40 to-transparent opacity-0 transition-opacity duration-500 group-hover:opacity-100"></div>
                        <div class="pointer-events-none absolute inset-x-1.5 bottom-1.5 translate-y-2 rounded-none border border-white/25 bg-white/15 px-2 py-1.5 text-center opacity-0 shadow-lg shadow-black/10 backdrop-blur-md transition-all duration-500 ease-out group-hover:translate-y-0 group-hover:opacity-100">
                            <svg class="mx-auto mb-0.5 h-3 w-3 text-white/80" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M10 13a5 5 0 007.07 0l3-3a5 5 0 00-7.07-7.07l-1.5 1.5"></path>
                                <path d="M14 11a5 5 0 00-7.07 0l-3 3a5 5 0 007.07 7.07l1.5-1.5"></path>
                            </svg>
                            <p class="line-clamp-2 font-serif text-[10px] leading-snug tracking-wide text-white [text-shadow:0_1px_2px_rgba(0,0,0,0.35)] sm:text-[11px]">{{ $caption }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div id="pgLightbox" class="pg-lb-overlay" onclick="closeGalleryLightbox()">
        <div class="pg-lb-card" role="dialog" aria-modal="true" onclick="event.stopPropagation()">
            <div class="pg-lb-body">
                <img id="pgLightboxImage" src="" alt="">
            </div>

            <div class="pg-lb-heading">
                <h3 id="pgLightboxCaption" class="pg-lb-title"></h3>
                <p id="pgLightboxLocation" class="pg-lb-sub" style="display:none"></p>
            </div>

            <div class="pg-lb-footer">
                <button type="button" class="pg-lb-btn pg-lb-btn-outline" onclick="closeGalleryLightbox()">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                    </svg>
                    <span>Kembali ke Galeri</span>
                </button>
                <button type="button" id="pgLightboxDownload" class="pg-lb-btn pg-lb-btn-primary" onclick="downloadGalleryImage()">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                    </svg>
                    <span>Unduh Gambar</span>
                </button>
            </div>
        </div>
    </div>
</main>

<style>
    /* Galeri di belakang dibuat blur tipis saat detail terbuka */
    #galleryContent {
        transition: filter 0.3s ease;
    }
    #galleryContent.gallery-blur {
        filter: blur(3px);
    }

    /* Detail foto: kartu putih di tengah, latar redup + blur ringan */
    .pg-lb-overlay {
        position: fixed !important;
        top: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        left: 0 !important;
        z-index: 9999 !important;
        display: none !important;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        background: rgba(30, 41, 59, 0.55) !important;
        -webkit-backdrop-filter: blur(2px) !important;
        backdrop-filter: blur(2px) !important;
    }
    .pg-lb-overlay.pg-open { display: flex !important; }

    .pg-lb-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.9rem;
        width: 100%;
        max-width: 960px;
        max-height: calc(100vh - 2rem);
    }
    .pg-lb-body {
        display: flex;
        justify-content: center;
        min-height: 0;
    }
    .pg-lb-body img {
        max-width: 100%;
        max-height: 68vh;
        object-fit: contain;
        border-radius: 4px;
        box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.45);
    }
    .pg-lb-heading { text-align: center; }
    .pg-lb-title {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 500;
        line-height: 1.4;
        color: #fff;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.6);
    }
    .pg-lb-sub {
        margin: 0.25rem 0 0;
        font-size: 0.875rem;
        color: rgba(255, 255, 255, 0.85);
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.6);
    }
    .pg-lb-footer {
        display: flex;
        flex-wrap: nowrap;
        justify-content: center;
        gap: 0.75rem;
        width: 100%;
    }
    .pg-lb-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.1rem;
        font-size: 0.875rem;
        font-weight: 600;
        border-radius: 4px;
        cursor: pointer;
        white-space: nowrap;
        transition: background 0.2s, border-color 0.2s;
    }
    .pg-lb-btn-outline {
        border: 1px solid rgba(255, 255, 255, 0.55);
        background: rgba(255, 255, 255, 0.12);
        color: #fff;
        -webkit-backdrop-filter: blur(6px);
        backdrop-filter: blur(6px);
    }
    .pg-lb-btn-outline:hover { background: rgba(255, 255, 255, 0.25); }
    .pg-lb-btn-primary { border: 1px solid rgba(255, 255, 255, 0.35); background: #0D1B2A; color: #fff; }
    .pg-lb-btn-primary:hover { background: #16283d; }

    /* Layar kecil: dua tombol tetap sejajar dalam satu baris */
    @media (max-width: 480px) {
        .pg-lb-footer { gap: 0.5rem; }
        .pg-lb-btn { padding: 0.55rem 0.8rem; font-size: 0.8rem; gap: 0.4rem; }
    }
</style>

<script>
    // Pindahkan lightbox ke <body> agar tidak tertimpa/terkurung elemen induk dari layout
    document.body.appendChild(document.getElementById('pgLightbox'));

    let pgActiveSrc = '';
    let pgActiveCaption = '';

    function openGalleryLightbox(imageSrc, caption, location = '') {
        const modal = document.getElementById('pgLightbox');
        const modalImg = document.getElementById('pgLightboxImage');
        const pgLightboxCaption = document.getElementById('pgLightboxCaption');
        const pgLightboxLocation = document.getElementById('pgLightboxLocation');

        pgActiveSrc = imageSrc;
        pgActiveCaption = caption;

        modalImg.src = imageSrc;
        pgLightboxCaption.textContent = caption;

        if (location && location.trim()) {
            const cleanLocation = location.trim();
            const compactLocation = cleanLocation.length > 60
                ? cleanLocation.slice(0, 57).trim() + '...'
                : cleanLocation;

            pgLightboxLocation.textContent = 'Lokasi: ' + compactLocation;
            pgLightboxLocation.style.display = '';
        } else {
            pgLightboxLocation.textContent = '';
            pgLightboxLocation.style.display = 'none';
        }

        modal.classList.add('pg-open');
        document.getElementById('galleryContent').classList.add('gallery-blur');
        document.body.classList.add('overflow-hidden');
    }

    function closeGalleryLightbox() {
        const modal = document.getElementById('pgLightbox');
        modal.classList.remove('pg-open');
        document.getElementById('galleryContent').classList.remove('gallery-blur');
        document.body.classList.remove('overflow-hidden');
    }

    async function downloadGalleryImage() {
        if (!pgActiveSrc) return;

        const btn = document.getElementById('pgLightboxDownload');
        const originalText = btn.innerHTML;
        btn.innerText = 'Mengunduh...';

        try {
            const response = await fetch(pgActiveSrc);
            const blob = await response.blob();
            const blobUrl = window.URL.createObjectURL(blob);

            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = blobUrl;

            const filename = (pgActiveCaption ? pgActiveCaption.toLowerCase().replace(/[^a-z0-9]/g, '-') : 'foto-galeri') + '.jpg';
            a.download = filename;

            document.body.appendChild(a);
            a.click();

            window.URL.revokeObjectURL(blobUrl);
            document.body.removeChild(a);
        } catch (error) {
            window.open(pgActiveSrc, '_blank');
        } finally {
            btn.innerHTML = originalText;
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeGalleryLightbox();
    });
</script>
@endsection