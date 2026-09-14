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

    $groupedGalleryItems = [
        'putra' => $galleryItems->where('group', 'putra')->values(),
        'putri' => $galleryItems->where('group', 'putri')->values(),
        'umum' => $galleryItems->whereIn('group', ['umum', null, ''])->values(),
    ];

    $resolveGalleryImage = function ($path) {
        if (empty($path)) {
            return asset('images/gallery/default.jpg');
        }

        if (str_starts_with($path, 'http')) {
            return $path;
        }

        if (str_starts_with($path, 'storage/')) {
            return asset($path);
        }

        if (str_starts_with($path, 'gallery/')) {
            return \Illuminate\Support\Facades\Storage::url($path);
        }

        return asset($path);
    };
@endphp

<main class="w-full min-h-screen bg-[#f4f3ef] dark:bg-gray-950 text-neutral-900 dark:text-white py-10 px-4 sm:px-6 md:px-10 lg:px-16 transition-colors duration-200">
    <div class="mx-auto max-w-6xl">
        <div class="mb-8 text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.28rem] text-amber-600 dark:text-amber-400">Galeri</p>
            <h1 class="mt-3 text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl md:text-5xl">
                Dokumentasi Kegiatan Pramuka
            </h1>
        </div>

        @if($galleryItems->isEmpty())
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white/60 p-10 text-center text-sm text-slate-600 dark:border-slate-700 dark:bg-slate-900/40 dark:text-slate-300">
                Belum ada foto yang dipublikasikan. Silakan unggah foto dari panel admin terlebih dahulu.
            </div>
        @else
            @foreach(['putra' => 'Ambalan Putra', 'putri' => 'Ambalan Putri', 'umum' => 'Galeri Umum'] as $groupKey => $groupLabel)
                @php $items = $groupedGalleryItems[$groupKey] ?? collect(); @endphp
                @if($items->isNotEmpty())
                    <div class="mb-10">
                        <div class="mb-5 flex items-center justify-between gap-3">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white md:text-2xl">{{ $groupLabel }}</h2>
                            <span class="rounded-full border border-slate-200 bg-white/70 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-600 dark:border-slate-700 dark:bg-slate-900/50 dark:text-slate-300">
                                {{ $items->count() }} foto
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-4 items-start">
                            @foreach([0, 1, 2] as $columnIndex)
                                <div class="flex flex-col gap-3 md:gap-4">
                                    @foreach($items as $index => $item)
                                        @if($index % 3 !== $columnIndex)
                                            @continue
                                        @endif

                                        @php
                                            $imageUrl = $resolveGalleryImage($item->image);
                                            $aspectClasses = [
                                                'aspect-[4/3]',
                                                'aspect-[3/4]',
                                                'aspect-[4/5]',
                                                'aspect-[16/10]',
                                                'aspect-square',
                                                'aspect-[16/9]',
                                            ];
                                            $aspectClass = $aspectClasses[$index % count($aspectClasses)];
                                        @endphp

                                        <div class="overflow-hidden bg-neutral-200 dark:bg-neutral-800 rounded-lg cursor-pointer group" onclick="openModal('{{ $imageUrl }}', '{{ addslashes($item->title ?: ($item->alt_text ?: 'Galeri Pramuka')) }}')">
                                            <img src="{{ $imageUrl }}"
                                                 alt="{{ $item->alt_text ?: $item->title }}"
                                                 class="w-full {{ $aspectClass }} object-cover group-hover:scale-105 transition-transform duration-500">
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>

    <div id="imageModal" class="fixed inset-0 z-50 hidden bg-black/90 backdrop-blur-md flex items-center justify-center p-4 md:p-8" onclick="closeModal()">
        <button type="button" class="absolute top-6 right-8 text-white/70 hover:text-white text-4xl font-light focus:outline-none z-10" onclick="closeModal()">
            &times;
        </button>

        <div class="relative max-w-5xl max-h-[90vh] flex flex-col items-center justify-center" onclick="event.stopPropagation()">
            <img id="modalImage" src="" alt="" class="max-w-full max-h-[75vh] object-contain shadow-2xl rounded-sm">
            <div class="mt-4 flex flex-col sm:flex-row items-center gap-4 text-center">
                <p id="modalCaption" class="text-white/80 font-serif italic text-xs md:text-sm tracking-widest uppercase"></p>
                <button type="button" id="downloadBtn" onclick="triggerDownload()" class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 hover:bg-white/20 text-white text-xs font-mono uppercase tracking-wider rounded-md border border-white/20 backdrop-blur-sm transition-all cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                    </svg>
                    <span>Unduh Gambar</span>
                </button>
            </div>
        </div>
    </div>
</main>

<script>
    let activeImageSrc = '';
    let activeCaption = '';

    function openModal(imageSrc, caption) {
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        const modalCaption = document.getElementById('modalCaption');

        activeImageSrc = imageSrc;
        activeCaption = caption;

        modalImg.src = imageSrc;
        modalCaption.textContent = caption;

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    async function triggerDownload() {
        if (!activeImageSrc) return;

        const btn = document.getElementById('downloadBtn');
        const originalText = btn.innerHTML;
        btn.innerText = 'Mengunduh...';

        try {
            const response = await fetch(activeImageSrc);
            const blob = await response.blob();
            const blobUrl = window.URL.createObjectURL(blob);

            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = blobUrl;

            const filename = (activeCaption ? activeCaption.toLowerCase().replace(/[^a-z0-9]/g, '-') : 'foto-galeri') + '.jpg';
            a.download = filename;

            document.body.appendChild(a);
            a.click();

            window.URL.revokeObjectURL(blobUrl);
            document.body.removeChild(a);
        } catch (error) {
            window.open(activeImageSrc, '_blank');
        } finally {
            btn.innerHTML = originalText;
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeModal();
    });
</script>
@endsection