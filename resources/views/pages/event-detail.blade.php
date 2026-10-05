@extends('layouts.frontend')

@section('content')
<style>
    /* ===== Mobile (default): semua rata tengah, bertumpuk ===== */
    .event-header {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    .event-header-info {
        display: flex;
        flex-direction: column;
        align-items: center;
        min-width: 0;
    }
    /* Baris info (lokasi, tanggal, jam): selalu bersampingan, turun baris hanya jika tidak muat */
    .event-meta {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        column-gap: 1rem;
        row-gap: 0.5rem;
    }

    /* ===== Tablet kecil ke atas: jarak info diperlebar ===== */
    @media (min-width: 640px) {
        .event-meta {
            column-gap: 2.5rem;
        }
    }

    /* ===== Desktop (>= 1024px): 2 kolom (kiri: header + tema, kanan: deskripsi) ===== */
    @media (min-width: 1024px) {
        .event-container.event-container {
            margin-top: 0;
            max-width: 80rem;
            padding-left: 2rem;
            padding-right: 2rem;
        }

        /* Layout utama: kiri 5 bagian, kanan 7 bagian */
        .event-layout {
            display: grid;
            grid-template-columns: minmax(0, 5fr) minmax(0, 7fr);
            column-gap: 3rem;
            align-items: start;
        }

        /* Kolom kiri menempel saat deskripsi digulir */
        .event-left {
            position: sticky;
            top: 5.5rem; /* memberi ruang cukup di bawah navbar saat sticky aktif */
            align-self: start;
        }

        .event-header {
            flex-direction: row;
            align-items: center;
            text-align: left;
            gap: 1.5rem;
        }
        .event-header-info {
            align-items: flex-start;
        }
        .event-meta {
            justify-content: flex-start;
            column-gap: 1.25rem; /* dirapatkan agar muat di kolom kiri */
        }
        .event-theme {
            text-align: left;
            border-left: 0;
            padding-left: 0;
        }

        /* Deskripsi di kolom kanan, sejajar dengan bagian atas header */
        .event-description.event-description {
            margin-top: 0;
        }
    }
</style>

<section class="bg-slate-50 pt-4 pb-4 dark:bg-gray-950 sm:pt-5 sm:pb-6 lg:pt-6">
    <div class="event-container mx-auto max-w-4xl px-4 sm:px-6">
        @php
            $locationText = trim((string) ($event->location ?? ''));
            $locationUrl = trim((string) ($event->location_url ?? ''));

            if ($locationUrl === '' && $locationText !== '' && filter_var($locationText, FILTER_VALIDATE_URL)) {
                $locationUrl = $locationText;
            }

            if ($locationUrl === '' && ! empty($event->latitude) && ! empty($event->longitude)) {
                $locationUrl = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($event->latitude . ',' . $event->longitude);
            }

            $logo = $event->logo_path ?? null;
            $logoSrc = $logo ? (preg_match('/^https?:\/\//', $logo) ? $logo : asset('storage/' . ltrim($logo, '/'))) : asset('images/logokegiatan2.png');
        @endphp

        <div class="event-layout">

            {{-- ===== KOLOM KIRI (sticky di desktop): Header + Tema ===== --}}
            <div class="event-left">

                {{-- Header: logo + (judul, info, tombol panduan) --}}
                <div class="event-header">
                    <div class="mb-2 flex h-16 w-16 flex-shrink-0 items-center justify-center overflow-hidden bg-transparent sm:h-20 sm:w-20 lg:mb-0 lg:h-24 lg:w-24">
                        <img src="{{ $logoSrc }}" alt="{{ $event->title }}" class="h-full w-full object-contain" onerror="this.style.display='none'" />
                    </div>

                    <div class="event-header-info">
                        <h1 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-white sm:text-3xl">{{ $event->title }}</h1>

                        <div class="event-meta mt-3 text-sm text-slate-700 dark:text-slate-300">
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4 flex-shrink-0 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                @if(! empty($locationUrl))
                                    <a href="{{ $locationUrl }}" target="_blank" rel="noopener" class="font-medium text-slate-900 hover:underline dark:text-white">{{ $locationText ?: 'Lokasi belum diatur' }}</a>
                                @else
                                    <span class="font-medium text-slate-900 dark:text-white">{{ $locationText ?: 'Lokasi belum diatur' }}</span>
                                @endif
                            </div>

                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4 flex-shrink-0 text-slate-600 dark:text-slate-400" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" fill="none" stroke="currentColor" stroke-width="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6" stroke="currentColor" stroke-width="2"></line>
                                    <line x1="8" y1="2" x2="8" y2="6" stroke="currentColor" stroke-width="2"></line>
                                    <line x1="3" y1="10" x2="21" y2="10" stroke="currentColor" stroke-width="2"></line>
                                </svg>
                                <span class="font-medium text-slate-900 dark:text-white">{{ \Illuminate\Support\Carbon::parse($event->date)->translatedFormat('d F Y') }}</span>
                            </div>

                            @if(! empty($event->time))
                                <div class="flex items-center gap-2">
                                    <svg class="h-4 w-4 flex-shrink-0 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                        <circle cx="12" cy="12" r="9"></circle>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"></path>
                                    </svg>
                                    <span class="font-medium text-slate-900 dark:text-white">{{ $event->time }}</span>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>

                {{-- Tema / Motto --}}
                @if(! empty($event->theme))
                    <div class="event-theme mt-6 text-center text-sm italic leading-6 text-slate-600 dark:text-slate-300 sm:text-base" style="overflow-wrap: anywhere; word-break: break-word;">
                        {!! $event->theme !!}
                    </div>
                @endif
            </div>

            {{-- ===== KOLOM KANAN: Deskripsi (ikut tergulir) ===== --}}
            <div class="event-right">
                <div class="event-description mt-5 sm:mt-4">
                    @if(! empty($event->description))
                        <div class="prose prose-slate max-w-none text-sm leading-6 text-slate-700 dark:prose-invert dark:text-slate-300 sm:text-base sm:leading-7" style="text-align: justify; overflow-wrap: anywhere; word-break: break-word;">
                            {!! nl2br(e($event->description)) !!}
                        </div>
                    @else
                        <p class="text-center text-sm text-slate-600 dark:text-slate-400 lg:text-left">Tidak ada deskripsi untuk kegiatan ini.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</section>
@endsection