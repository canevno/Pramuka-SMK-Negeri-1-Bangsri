@extends('layouts.frontend')

@section('content')
@php
    $imageBase = '/images/achievement/prestasi1.jpg';
@endphp
<section class="bg-white py-8 sm:py-10">
    <div class="mx-auto max-w-[1280px] px-4 sm:px-4 lg:px-5">

        @if (count($prestasi) > 0)
            @php
                $featured = $prestasi[0];
                $related = array_slice($prestasi, 1);

                $prestasiData = collect($prestasi)->map(function ($item) {
                    $title = $item['title'] ?? '-';
                    $category = $item['category'] ?? 'Prestasi';
                    $winner = $item['winner'] ?? 'Anggota';
                    $year = $item['year'] ?? now()->year;
                    $date = $item['date'] ?? ($year ? (string) $year : 'Tanggal belum diatur');
                    $location = $item['location'] ?? null;
                    $description = trim((string) ($item['description'] ?? ''));
                    $image = $item['image'] ?? '/images/achievement/prestasi1.jpg';
                    $image = preg_replace('#^/?public/?#i', '', $image, 1) ?? $image;
                    $image = preg_replace('#^/?storage/?#i', '', $image, 1) ?? $image;
                    $image = preg_replace('#^/?storage/?#i', '', $image, 1) ?? $image;
                    $image = ltrim($image, '/');
                    $imageUrl = match (true) {
                        empty($image) => asset('images/achievement/prestasi1.jpg'),
                        filter_var($image, FILTER_VALIDATE_URL) => $image,
                        str_starts_with($image, 'storage/') => asset($image),
                        str_starts_with($image, 'images/') => asset($image),
                        default => asset('storage/' . ltrim($image, '/')),
                    };

                    return [
                        'category' => $category,
                        'date' => $date,
                        'title' => $title,
                        'winner' => $winner,
                        'location' => $location,
                        'description' => $description !== '' ? $description : 'Prestasi yang membanggakan dari sekolah kami.',
                        'image' => $imageUrl,
                        'alt' => $title,
                        'year' => $year,
                    ];
                })->values();
            @endphp

            <div class="mx-auto grid max-w-[1180px] gap-8 lg:grid-cols-[minmax(0,1.2fr)_420px]">
                <article class="max-w-[760px]">
                    <div class="mb-3 flex items-center justify-between gap-3">
                        <div id="featured-category" class="text-[11px] font-medium text-slate-600">
                            {{ $featured['category'] ?? 'Prestasi' }}
                        </div>
                    </div>

                    <a href="#" class="block" data-featured-link>
                        <h1 id="featured-title" class="mb-5 text-2xl font-bold leading-[1.1] text-slate-900 sm:text-[2.5rem]">{{ $featured['title'] ?? '-' }}</h1>
                    </a>

                    <a href="#" class="block" data-featured-link>
                        <div class="mt-5 overflow-hidden rounded-xl bg-slate-100">
                            <img id="featured-image" src="{{ $featured['image'] ? (filter_var($featured['image'], FILTER_VALIDATE_URL) ? $featured['image'] : (str_starts_with($featured['image'], 'storage/') ? asset($featured['image']) : (str_starts_with($featured['image'], 'images/') ? asset($featured['image']) : asset('storage/' . ltrim($featured['image'], '/'))))) : asset('images/achievement/prestasi1.jpg') }}" alt="{{ $featured['title'] ?? 'Prestasi' }}" class="h-[220px] w-full object-cover sm:h-[330px]">
                        </div>
                    </a>

                    <div class="mt-6 space-y-6 text-base leading-6 text-slate-700">
                        <p id="featured-description" class="whitespace-pre-line break-words text-justify sm:text-left">
                            {{ $featured['description'] ?? 'Prestasi yang membanggakan dari sekolah kami.' }}
                        </p>
                    </div>
                </article>

                <aside class="space-y-6">
                    <div class="rounded-none border-0 bg-transparent p-0 shadow-none sm:rounded-xl sm:border sm:border-slate-200 sm:bg-white sm:p-4 sm:shadow-sm">
                        <h3 class="text-center text-lg font-semibold text-slate-900 sm:text-left">Prestasi Lainnya</h3>

                        <div class="related-scroll mt-4 space-y-3 overflow-y-auto pr-1 sm:max-h-[600px] lg:pr-2">
                            @foreach($related as $item)
                                @php
                                    $itemImage = $item['image'] ?? '/images/achievement/prestasi1.jpg';
                                    $itemImage = preg_replace('#^/?public/?#i', '', $itemImage, 1) ?? $itemImage;
                                    $itemImage = preg_replace('#^/?storage/?#i', '', $itemImage, 1) ?? $itemImage;
                                    $itemImage = preg_replace('#^/?storage/?#i', '', $itemImage, 1) ?? $itemImage;
                                    $itemImage = ltrim($itemImage, '/');
                                    $itemImageUrl = match (true) {
                                        empty($itemImage) => asset('images/achievement/prestasi1.jpg'),
                                        filter_var($itemImage, FILTER_VALIDATE_URL) => $itemImage,
                                        str_starts_with($itemImage, 'storage/') => asset($itemImage),
                                        str_starts_with($itemImage, 'images/') => asset($itemImage),
                                        default => asset('storage/' . ltrim($itemImage, '/')),
                                    };
                                @endphp

                                <a href="#" data-prestasi-index="{{ $loop->index + 1 }}" class="block transition hover:opacity-80">
                                    <div class="flex items-start gap-3 overflow-hidden p-0 sm:p-0">
                                        <div class="flex h-[82px] w-[110px] shrink-0 items-center justify-center overflow-hidden rounded-md bg-slate-100 sm:h-[92px] sm:w-[128px]">
                                            <img src="{{ $itemImageUrl }}" alt="{{ $item['title'] ?? 'Prestasi' }}" class="h-full w-full object-cover object-center">
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="flex flex-wrap items-center gap-1.5 text-[9px] sm:text-[10px]">
                                                <p class="font-semibold uppercase tracking-[0.12em] text-slate-500">{{ $item['category'] ?? 'Prestasi' }}</p>
                                                <span class="text-slate-300">•</span>
                                                <p class="font-medium text-slate-400">{{ $item['date'] ?? ($item['year'] ?? now()->year) }}</p>
                                            </div>
                                            <h4 class="mt-1.5 text-left text-[0.9rem] font-semibold leading-5 text-slate-900 line-clamp-2 sm:text-[0.95rem]">{{ $item['title'] ?? '-' }}</h4>
                                            @if (! empty($item['location']))
                                                <div class="mt-1 flex items-center gap-1.5 text-[10px] text-slate-500 sm:text-[10.5px]">
                                                    <svg class="h-3 w-3 shrink-0 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                        <path d="M12 21s6-5.686 6-11a6 6 0 10-12 0c0 5.314 6 11 6 11z"/>
                                                        <circle cx="12" cy="10" r="2.5"/>
                                                    </svg>
                                                    <span class="line-clamp-1">{{ $item['location'] }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </aside>
            </div>

            <script>
                (() => {
                    const prestasi = @json($prestasiData);
                    const $ = (id) => document.getElementById(id);

                    const showFeatured = (item) => {
                        const categoryEl = $('featured-category');
                        if (categoryEl) {
                            categoryEl.textContent = item.category;
                        }

                        const dateEl = $('featured-date');
                        if (dateEl) {
                            dateEl.textContent = item.date;
                        }

                        const titleEl = $('featured-title');
                        if (titleEl) {
                            titleEl.textContent = item.title;
                        }

                        const descriptionEl = $('featured-description');
                        if (descriptionEl) {
                            descriptionEl.textContent = item.description;
                        }

                        const winnerEl = $('featured-winner');
                        if (winnerEl) {
                            winnerEl.textContent = item.winner;
                        }

                        const locationEl = $('featured-location');
                        if (locationEl) {
                            if (item.location) {
                                locationEl.textContent = item.location;
                                locationEl.classList.remove('hidden');
                            } else {
                                locationEl.textContent = '';
                                locationEl.classList.add('hidden');
                            }
                        }

                        const img = $('featured-image');
                        if (img) {
                            img.src = item.image;
                            img.alt = item.alt;
                        }

                        document.querySelectorAll('[data-featured-link]').forEach((a) => {
                            a.href = '#';
                        });
                    };

                    document.querySelectorAll('[data-prestasi-index]').forEach((link) => {
                        link.addEventListener('click', (e) => {
                            const item = prestasi[Number(link.dataset.prestasiIndex)];
                            if (!item) {
                                return;
                            }

                            e.preventDefault();
                            showFeatured(item);

                            if (window.innerWidth < 1024) {
                                $('featured-title').scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                        });
                    });
                })();
            </script>

            <style>
                @media (min-width: 1024px) {
                    .related-scroll {
                        scrollbar-width: none;
                        -ms-overflow-style: none;
                    }
                    .related-scroll::-webkit-scrollbar {
                        display: none;
                    }
                }
            </style>
        @else
            <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center">
                <p class="text-lg font-semibold text-slate-900">Belum ada prestasi</p>
                <p class="mt-2 text-sm text-slate-500">Belum ada prestasi yang dipublikasikan.</p>
            </div>
        @endif

        @if (!empty($pagination) && ($pagination['last_page'] ?? 1) > 1)
            <div class="mt-10 flex items-center justify-center gap-2">
                @if (($pagination['current_page'] ?? 1) > 1)
                    <a href="{{ route('prestasi', ['page' => $pagination['current_page'] - 1, 'tahun' => $tahun]) }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:border-slate-300 hover:bg-slate-50">
                        Sebelumnya
                    </a>
                @endif

                <span class="px-3 py-2 text-sm text-slate-500">
                    Halaman {{ $pagination['current_page'] ?? 1 }} dari {{ $pagination['last_page'] ?? 1 }}
                </span>

                @if (($pagination['current_page'] ?? 1) < ($pagination['last_page'] ?? 1))
                    <a href="{{ route('prestasi', ['page' => $pagination['current_page'] + 1, 'tahun' => $tahun]) }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:border-slate-300 hover:bg-slate-50">
                        Berikutnya
                    </a>
                @endif
            </div>
        @endif
    </div>
</section>
@endsection