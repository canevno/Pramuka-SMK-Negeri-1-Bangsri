@extends('layouts.frontend')

@section('content')
<section class="bg-white py-4 sm:py-10">
    <div class="mx-auto max-w-[1280px] px-4 sm:px-4 lg:px-5">

        @if (count($prestasi) > 0)
            @php
                // URL gambar: mendukung URL penuh, images/..., dan storage/...
                $imageUrl = function ($path) {
                    $image = (string) ($path ?: 'images/achievement/prestasi1.jpg');
                    $image = preg_replace('#^/?public/?#i', '', $image, 1) ?? $image;
                    $image = preg_replace('#^/?storage/?#i', '', $image, 1) ?? $image;
                    $image = preg_replace('#^/?storage/?#i', '', $image, 1) ?? $image;
                    $image = ltrim($image, '/');

                    return match (true) {
                        empty($image) => asset('images/achievement/prestasi1.jpg'),
                        filter_var($image, FILTER_VALIDATE_URL) => $image,
                        str_starts_with($image, 'storage/') => asset($image),
                        str_starts_with($image, 'images/') => asset($image),
                        default => asset('storage/' . ltrim($image, '/')),
                    };
                };

                // Tanggal: pakai 'date' bila ada, kalau tidak tampilkan tahun
                $formatDate = function ($item) {
                    try {
                        return ! empty($item['date'])
                            ? \Illuminate\Support\Carbon::parse($item['date'])->translatedFormat('d F Y')
                            : (string) ($item['year'] ?? now()->year);
                    } catch (\Throwable $e) {
                        return (string) ($item['date'] ?? ($item['year'] ?? now()->year));
                    }
                };

                // Satu baris (Enter) = satu paragraf. Tag </p> dan <br> diubah dulu menjadi baris baru.
                $splitParagraphs = function ($text) {
                    $text = preg_replace('/<\/p>|<br\s*\/?>/i', "\n", (string) $text);

                    return collect(preg_split('/\R+/', trim($text)))
                        ->map(fn ($p) => trim(strip_tags((string) $p)))
                        ->filter(fn ($p) => $p !== '')
                        ->values()
                        ->all();
                };

                // Satu sumber data untuk tampilan server dan JavaScript
                $items = collect($prestasi)->map(fn ($item) => [
                    'id' => (string) ($item['id'] ?? ''),
                    'category' => $item['category'] ?? 'Prestasi',
                    'date' => $formatDate($item),
                    'title' => $item['title'] ?? '-',
                    'location' => $item['location'] ?? null,
                    'description' => trim((string) ($item['description'] ?? '')),
                    'image' => $imageUrl($item['image'] ?? null),
                    'alt' => $item['title'] ?? 'Prestasi',
                ])->values()->all();

                // Prestasi utama dipilih dari ?id= (mis. dari beranda atau setelah refresh).
                // Bila kosong / tidak cocok, pakai prestasi pertama.
                $requestedId = trim((string) request('id', ''));
                $featuredIndex = 0;

                if ($requestedId !== '') {
                    foreach ($items as $i => $it) {
                        if ($it['id'] === $requestedId) {
                            $featuredIndex = $i;
                            break;
                        }
                    }
                }

                $featured = $items[$featuredIndex];
                $featuredParagraphs = $splitParagraphs($featured['description']);
                $tahunParam = ! empty($tahun) ? ['tahun' => $tahun] : [];
            @endphp

            <div class="mx-auto grid max-w-[1180px] gap-8 lg:grid-cols-[minmax(0,1.2fr)_420px]">
                <article class="min-w-0 max-w-[760px]">
                    <div class="mb-3 flex items-center justify-between gap-3">
                        <div id="featured-category" class="text-[11px] font-medium text-slate-600">
                            {{ $featured['category'] }}
                        </div>

                        <div class="inline-flex items-center gap-1.5 text-[11px] font-medium text-slate-500">
                            <svg class="h-3.5 w-3.5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <span id="featured-date">{{ $featured['date'] }}</span>
                        </div>
                    </div>

                    <h1 id="featured-title" class="mb-5 text-2xl font-semibold tracking-tight text-slate-900 sm:text-3xl">{{ $featured['title'] }}</h1>

                    <div class="mt-5 overflow-hidden rounded-xl bg-slate-100">
                        <img id="featured-image" src="{{ $featured['image'] }}" alt="{{ $featured['alt'] }}" class="h-[220px] w-full object-cover sm:h-[330px]">
                    </div>

                    <div class="mt-4 lg:mt-6" id="description-card-wrapper">
                        <div id="description-wrapper" class="border-0 bg-transparent px-0 py-4">
                            {{-- Mobile: tampil penuh. Desktop (lg): tinggi dibatasi dan bisa di-scroll --}}
                            <div id="featured-description" class="desc-scroll space-y-4 text-justify lg:max-h-[320px] lg:overflow-y-auto text-base leading-7 text-slate-700">
                                @foreach ($featuredParagraphs as $paragraph)
                                    <p class="break-words text-justify [hyphens:auto]">{{ $paragraph }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </article>

                <aside class="relative">
                    <div class="flex flex-col rounded-none border-0 bg-transparent p-0 shadow-none sm:rounded-xl sm:border sm:border-slate-200 sm:bg-white sm:p-4 sm:shadow-sm lg:absolute lg:inset-0">
                        <h3 class="shrink-0 text-center text-lg font-semibold tracking-tight text-slate-900 sm:text-left sm:text-xl">Prestasi Lainnya</h3>

                        <div class="related-scroll mt-4 flex flex-col gap-3 lg:min-h-0 lg:flex-1 lg:overflow-y-auto lg:pr-2">
                            @foreach ($items as $item)
                                {{-- href ke halaman ini sendiri (?id=) sebagai cadangan bila JS tidak jalan --}}
                                @php $isActive = $loop->index === $featuredIndex; @endphp
                                <a href="{{ route('prestasi', array_merge(['id' => $item['id']], $tahunParam)) }}" data-prestasi-index="{{ $loop->index }}" class="{{ $isActive ? 'hidden' : 'block' }} shrink-0 transition hover:opacity-80">
                                    <div class="flex items-start gap-3 overflow-hidden p-0">
                                        <div class="flex h-[82px] w-[110px] shrink-0 items-center justify-center overflow-hidden rounded-md bg-slate-100 sm:h-[92px] sm:w-[128px]">
                                            <img src="{{ $item['image'] }}" alt="{{ $item['alt'] }}" class="h-full w-full object-cover object-center">
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="flex flex-wrap items-center gap-1.5 text-[9px] sm:text-[10px]">
                                                <p class="font-semibold uppercase tracking-[0.12em] text-slate-500">{{ $item['category'] }}</p>
                                                <span class="text-slate-300">•</span>
                                                <p class="font-medium text-slate-400">{{ $item['date'] }}</p>
                                            </div>
                                            <h4 class="mt-1.5 text-left text-[0.9rem] font-semibold tracking-tight leading-5 text-slate-900 line-clamp-2 sm:text-[0.95rem]">{{ $item['title'] }}</h4>
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
                    const prestasi = @json($items);
                    const $ = (id) => document.getElementById(id);
                    const links = Array.from(document.querySelectorAll('[data-prestasi-index]'));

                    // Sembunyikan prestasi yang sedang tampil dari daftar "Prestasi Lainnya"
                    const markActive = (index) => {
                        links.forEach((link) => {
                            const active = Number(link.dataset.prestasiIndex) === index;
                            link.classList.toggle('hidden', active);
                            link.classList.toggle('block', !active);
                        });
                    };

                    // Simpan pilihan di URL supaya tetap sama setelah refresh
                    const setUrlId = (id) => {
                        const url = new URL(window.location.href);
                        url.searchParams.set('id', id);
                        window.history.replaceState({}, '', url);
                    };

                    // Bangun ulang paragraf (satu baris = satu paragraf), class sama seperti Blade
                    const renderDescription = (text) => {
                        const box = $('featured-description');
                        if (!box) return;

                        box.innerHTML = '';
                        String(text || '')
                            .replace(/<\/p>|<br\s*\/?>/gi, '\n')
                            .split(/\r\n|\n|\r/)
                            .map((p) => p.replace(/<[^>]*>/g, '').trim())
                            .filter(Boolean)
                            .forEach((p) => {
                                const el = document.createElement('p');
                                el.className = 'break-words text-justify [hyphens:auto]';
                                el.textContent = p;
                                box.appendChild(el);
                            });

                        box.scrollTop = 0;
                    };

                    const showFeatured = (item) => {
                        $('featured-category').textContent = item.category;
                        $('featured-date').textContent = item.date;
                        $('featured-title').textContent = item.title;
                        renderDescription(item.description);

                        const img = $('featured-image');
                        img.src = item.image;
                        img.alt = item.alt;
                    };

                    links.forEach((link) => {
                        link.addEventListener('click', (e) => {
                            const index = Number(link.dataset.prestasiIndex);
                            const item = prestasi[index];
                            if (!item) {
                                return;
                            }

                            e.preventDefault();
                            showFeatured(item);
                            markActive(index);
                            setUrlId(item.id);

                            $('featured-title').scrollIntoView({ behavior: 'smooth', block: 'center' });
                        });
                    });
                })();
            </script>

            <style>
                .desc-scroll {
                    scroll-behavior: smooth;
                    overscroll-behavior: contain;
                    scrollbar-width: none;
                    -ms-overflow-style: none;
                }
                .desc-scroll::-webkit-scrollbar {
                    display: none;
                    width: 0;
                    height: 0;
                }

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

        @if (! empty($pagination) && ($pagination['last_page'] ?? 1) > 1)
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