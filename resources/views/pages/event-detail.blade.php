@extends('layouts.frontend')

@section('content')
<section class="bg-slate-50 py-16 dark:bg-gray-950">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white">{{ $event->title }}</h1>
            <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">{{ \Illuminate\Support\Carbon::parse($event->date)->translatedFormat('d F Y') }} • {{ $event->time ?? 'Waktu' }}</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="flex flex-col gap-6 md:flex-row md:items-start">
                <div class="md:w-1/3">
                    <div class="w-full rounded-2xl border border-slate-200 bg-slate-50 p-4 flex items-center justify-center dark:border-slate-700 dark:bg-slate-900">
                        @php
                            $logo = $event->logo_path ?? null;
                            $logoSrc = $logo ? (preg_match('/^https?:\/\//', $logo) ? $logo : asset('storage/' . ltrim($logo, '/'))) : asset('images/logokegiatan2.png');
                        @endphp
                        <img src="{{ $logoSrc }}" alt="{{ $event->title }}" class="h-40 w-40 object-contain" onerror="this.style.display='none'" />
                    </div>
                    <div class="mt-4 text-sm text-slate-600 dark:text-slate-400">
                        <p><strong>Lokasi:</strong> {{ $event->location }}</p>
                        @if(! empty($event->guide_url))
                            <p class="mt-2"><a href="{{ $event->guide_url }}" class="text-emerald-600 hover:underline">Panduan kegiatan</a></p>
                        @endif
                    </div>
                </div>

                <div class="md:flex-1">
                    @if(! empty($event->description))
                        <div class="prose max-w-none text-slate-700 dark:text-slate-300">
                            {!! nl2br(e($event->description)) !!}
                        </div>
                    @else
                        <p class="text-sm text-slate-600 dark:text-slate-400">Tidak ada deskripsi untuk kegiatan ini.</p>
                    @endif

                    @if(! empty($event->theme))
                        <div class="mt-6 rounded-lg border border-slate-100 bg-slate-50 p-4 text-sm italic text-slate-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                            {!! $event->theme !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
