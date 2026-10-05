﻿@extends('layouts.frontend')

@section('content')
<section class="bg-white py-4 sm:py-10">
    <div class="mx-auto max-w-[1280px] px-4 sm:px-4 lg:px-5">
        @if(empty($newsItems))
            <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center text-slate-500">
                Belum ada berita yang dipublikasikan.
            </div>
        @else
            @php
                // Pecah teks menjadi paragraf: satu baris (Enter) = satu paragraf.
                // Tag </p> dan <br> diubah dulu menjadi baris baru agar paragraf tidak menyatu.
                $splitParagraphs = function ($text) {
                    $text = preg_replace('/<\/p>|<br\s*\/?>/i', "\n", (string) $text);

                    return collect(preg_split('/\R+/', trim($text)))
                        ->map(fn ($p) => trim(strip_tags((string) $p)))
                        ->filter(fn ($p) => $p !== '')
                        ->values()
                        ->all();
                };

                // Isi lengkap berita: pakai content, kalau kosong baru description.
                $fullText = function ($item) {
                    $content = trim((string) ($item['content'] ?? ''));

                    return $content !== '' ? $content : trim((string) ($item['description'] ?? ''));
                };

                $slugOf = fn ($item) => $item['slug'] ?? Str::slug($item['title']);

                $newsItems = array_values($newsItems);

                // Berita utama dipilih dari ?slug= (mis. dari beranda atau setelah refresh).
                // Bila tidak ada / tidak cocok, pakai berita pertama.
                $requestedSlug = strtolower(trim((string) request('slug', '')));
                $featuredIndex = 0;

                if ($requestedSlug !== '') {
                    foreach ($newsItems as $i => $n) {
                        if (strtolower((string) $slugOf($n)) === $requestedSlug) {
                            $featuredIndex = $i;
                            break;
                        }
                    }
                }

                $featured = $newsItems[$featuredIndex];
                $featuredParagraphs = $splitParagraphs($fullText($featured));

                $newsData = collect($newsItems)->map(fn ($n) => [
                    'slug' => $slugOf($n),
                    'category' => $n['category'],
                    'date' => $n['date'],
                    'title' => $n['title'],
                    'image' => $n['image'],
                    'alt' => $n['alt'],
                    'description' => $fullText($n),
                ])->values();
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

                    <h1 id="featured-title" class="mb-5 text-2xl font-bold leading-[1.1] text-slate-900 sm:text-[2.5rem]">{{ $featured['title'] }}</h1>

                    <div class="mt-5 overflow-hidden rounded-xl bg-slate-100">
                        <img id="featured-image" src="{{ $featured['image'] }}" alt="{{ $featured['alt'] }}" class="h-[220px] w-full object-cover sm:h-[330px]">
                    </div>

                    <div class="mt-4 lg:mt-6" id="description-card-wrapper">
                        <div id="description-wrapper" class="border-0 bg-transparent px-0 py-4">
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
                        <h3 class="shrink-0 text-center text-lg font-semibold text-slate-900 sm:text-left">Berita Lainnya</h3>

                        <div class="related-scroll mt-4 flex flex-col gap-4 lg:min-h-0 lg:flex-1 lg:overflow-y-auto lg:pr-2">
                            @foreach($newsItems as $item)
                                {{-- href ke halaman ini sendiri (?slug=) sebagai cadangan bila JS tidak jalan --}}
                                @php $isActive = $loop->index === $featuredIndex; @endphp
                                <a href="{{ route('news', ['slug' => $slugOf($item)]) }}" data-news-index="{{ $loop->index }}" class="{{ $isActive ? 'hidden' : 'flex' }} shrink-0 items-center gap-3 overflow-hidden rounded-lg border-0 bg-transparent p-0 transition hover:bg-slate-50 sm:border sm:border-slate-100 sm:bg-white sm:p-1.5">
                                    <div class="flex h-[92px] w-[128px] shrink-0 items-center justify-center overflow-hidden rounded-md bg-slate-100">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['alt'] }}" class="h-full w-full object-cover object-center">
                                    </div>
                                    <div class="min-w-0 flex-1 self-center pr-1">
                                        <div class="flex items-center gap-2">
                                            <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-slate-500">{{ $item['category'] }}</p>
                                            <span class="text-[9px] text-slate-400">•</span>
                                            <p class="text-[9px] font-medium text-slate-400">{{ $item['date'] }}</p>
                                        </div>
                                        <h4 class="mt-1.5 text-left text-[0.95rem] font-semibold leading-5 text-slate-900 line-clamp-2">{{ $item['title'] }}</h4>
                                        <p class="mt-1 text-left text-[11px] leading-5 text-slate-600 line-clamp-2">{{ $item['description'] ?? '' }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </aside>
            </div>

            <script>
                (() => {
                    const news = @json($newsData);
                    const $ = (id) => document.getElementById(id);

                    const links = Array.from(document.querySelectorAll('[data-news-index]'));

                    // Sembunyikan berita yang sedang tampil dari daftar "Berita Lainnya"
                    const markActive = (index) => {
                        links.forEach((link) => {
                            const active = Number(link.dataset.newsIndex) === index;
                            link.classList.toggle('hidden', active);
                            link.classList.toggle('flex', !active);
                        });
                    };

                    // Simpan pilihan di URL supaya tetap sama setelah refresh
                    const setUrlSlug = (slug) => {
                        const url = new URL(window.location.href);
                        url.searchParams.set('slug', slug);
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
                            const index = Number(link.dataset.newsIndex);
                            const item = news[index];
                            if (!item) {
                                return;
                            }

                            e.preventDefault();
                            showFeatured(item);
                            markActive(index);
                            setUrlSlug(item.slug);

                            $('featured-title').scrollIntoView({ behavior: 'smooth', block: 'center' });
                        });
                    });
                })();
            </script>

            <style>
                .desc-scroll {
                    scroll-behavior: smooth;
                    overscroll-behavior: contain;
                    scrollbar-width: thin;
                    scrollbar-color: transparent transparent;
                }
                .desc-scroll:hover {
                    scrollbar-color: #94a3b8 transparent;
                }
                .desc-scroll::-webkit-scrollbar {
                    width: 6px;
                }
                .desc-scroll::-webkit-scrollbar-thumb {
                    background: transparent;
                    border-radius: 9999px;
                }
                .desc-scroll:hover::-webkit-scrollbar-thumb {
                    background: #94a3b8;
                }
                @media (hover: none) {
                    .desc-scroll {
                        scrollbar-color: #94a3b8 transparent;
                    }
                    .desc-scroll::-webkit-scrollbar-thumb {
                        background: #94a3b8;
                    }
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
        @endif
    </div>
</section>
@endsection