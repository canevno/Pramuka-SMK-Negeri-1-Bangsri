@extends('layouts.frontend')

@section('content')
<section class="bg-white py-8 sm:py-10">
    <div class="mx-auto max-w-[1280px] px-4 sm:px-4 lg:px-5">
        <article class="mx-auto max-w-[980px]">
            <div class="mb-3 flex items-center justify-between gap-3">
                <div class="text-[11px] font-medium text-slate-600">
                    {{ $article['category'] }}
                </div>

                <div class="inline-flex items-center gap-1.5 text-[11px] font-medium text-slate-500">
                    <svg class="h-3.5 w-3.5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    <span>{{ $article['date'] }}</span>
                </div>
            </div>

            <h1 class="mb-5 text-2xl font-bold leading-[1.1] text-slate-900 sm:text-[2.5rem]">{{ $article['title'] }}</h1>

            <div class="mb-6 overflow-hidden rounded-xl bg-slate-100">
                <img src="{{ $article['image'] }}" alt="{{ $article['alt'] }}" class="h-[220px] w-full object-cover sm:h-[360px]">
            </div>

            <div class="prose prose-slate max-w-none prose-headings:font-bold prose-p:leading-8 prose-p:text-slate-700 prose-a:text-[#0D1B2A]">
                <div class="text-justify sm:text-left">
                    {!! nl2br(e($article['content'])) !!}
                </div>
            </div>

            @if(!empty($related))
                <div class="mt-10 rounded-xl border border-slate-200 bg-white p-3 shadow-sm sm:p-4">
                    <h3 class="text-xl font-semibold text-slate-900">Berita Lainnya</h3>
                    <div class="mt-4 space-y-4">
                        @foreach($related as $item)
                            <a href="{{ route('berita.show', ['slug' => $item['slug']]) }}" class="flex items-center gap-3 overflow-hidden rounded-lg border border-slate-100 bg-white p-2 transition hover:bg-slate-50 sm:p-1.5">
                                <div class="flex h-[92px] w-[128px] shrink-0 items-center justify-center overflow-hidden rounded-md bg-slate-100">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['alt'] }}" class="h-full w-full object-cover object-center">
                                </div>
                                <div class="min-w-0 flex-1 self-center pr-1">
                                    <div class="flex items-center gap-2">
                                        <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-slate-500">{{ $item['category'] }}</p>
                                        <span class="text-[9px] text-slate-400">•</span>
                                        <p class="text-[9px] font-medium text-slate-400">{{ $item['date'] }}</p>
                                    </div>
                                    <h4 class="mt-1.5 text-[0.95rem] font-semibold leading-5 text-slate-900 line-clamp-2">{{ $item['title'] }}</h4>
                                    <p class="mt-1 text-[11px] leading-5 text-slate-600 line-clamp-2">{{ $item['description'] }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </article>
    </div>
</section>
@endsection
