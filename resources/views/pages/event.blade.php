@extends('layouts.frontend')

@section('content')
<section class="bg-slate-50 py-16 dark:bg-gray-950">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="mb-10 text-center">
            <h1 class="mt-4 text-3xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-4xl">Timeline Kegiatan Pramuka</h1>
            <p class="mx-auto mt-3 max-w-2xl text-sm text-slate-600 dark:text-slate-300">
                Daftar kegiatan, jadwal, dan momen penting yang tengah atau akan dilaksanakan oleh ambalan kami.
            </p>
        </div>

        @php
            $now = \Illuminate\Support\Carbon::now()->startOfDay();
            $allEvents = ($events ?? collect())->sortBy('date');
            $upcoming = $allEvents->filter(fn($e) => \Illuminate\Support\Carbon::parse($e->date)->startOfDay()->greaterThanOrEqualTo($now));
            $past = $allEvents->filter(fn($e) => \Illuminate\Support\Carbon::parse($e->date)->startOfDay()->lessThan($now));
        @endphp

        @if($upcoming->isNotEmpty())
            <div class="mb-8">
                <h2 class="mb-4 text-xl font-bold text-slate-900 dark:text-white">Upcoming Events</h2>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($upcoming as $event)
                        <article class="group overflow-hidden rounded-2xl border border-slate-300 bg-white transition hover:shadow-lg dark:border-slate-800 dark:bg-slate-900">
                            <div class="flex items-center justify-center py-6 bg-white">
                                <div class="w-20 h-20 sm:w-24 sm:h-24 md:w-32 md:h-32 flex items-center justify-center flex-shrink-0 overflow-hidden rounded-2xl border border-slate-300 bg-white p-1 shadow-sm dark:border-slate-600 dark:bg-slate-900">
                                    @php
                                        $eventLogo = $event->logo_path ?? $event->image ?? null;
                                    @endphp
                                    @if(! empty($eventLogo))
                                        @php
                                            $logoSrc = preg_match('/^https?:\/\//', $eventLogo) ? $eventLogo : asset('storage/' . ltrim($eventLogo, '/'));
                                        @endphp
                                        <img src="{{ $logoSrc }}" alt="Logo Kegiatan" class="w-full h-full object-contain" onerror="this.style.display='none'" />
                                    @else
                                        <img src="{{ asset('images/logokegiatan2.png') }}" alt="Logo Kegiatan" class="w-full h-full object-contain" onerror="this.style.display='none'" />
                                    @endif
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="text-sm font-bold text-slate-900 dark:text-white">{{ $event->title }}</h3>
                                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">{{ \Illuminate\Support\Str::limit($event->description ?? $event->excerpt ?? $event->theme ?? '', 120) }}</p>
                                <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">{{ \Illuminate\Support\Carbon::parse($event->date)->translatedFormat('d F Y') }} • {{ $event->time ?? 'Waktu' }}</p>
                                <div class="mt-3 flex items-center gap-2">
                                    <a href="{{ route('event.show', ['id' => $event->id]) }}" class="inline-flex items-center gap-2 rounded-md bg-[#0D1B2A] px-3 py-1.5 text-xs font-semibold text-white hover:bg-[#162b45]">[Informasi Lengkap]</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif

        @if($past->isNotEmpty())
            <div class="mt-10">
                <h2 class="mb-4 text-xl font-bold text-slate-900 dark:text-white">Past events</h2>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($past as $event)
                        <article class="overflow-hidden rounded-lg border border-slate-300 bg-white dark:border-slate-800 dark:bg-slate-900">
                            <div class="p-3">
                                <div class="flex items-center justify-between">
                                    <div class="min-w-0">
                                        <h4 class="text-sm font-semibold text-slate-900 dark:text-white">{{ $event->title }}</h4>
                                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ \Illuminate\Support\Carbon::parse($event->date)->translatedFormat('d F Y') }}</p>
                                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">{{ \Illuminate\Support\Str::limit($event->description ?? $event->excerpt ?? $event->theme ?? '', 120) }}</p>
                                    </div>
                                    <div class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 flex items-center justify-center flex-shrink-0 overflow-hidden rounded-xl border border-slate-200 bg-slate-50 shadow-sm dark:border-slate-700 dark:bg-slate-900 ml-4">
                                        @php
                                            $eventLogo = $event->logo_path ?? $event->image ?? null;
                                        @endphp
                                        @if(! empty($eventLogo))
                                            @php
                                                $logoSrc = preg_match('/^https?:\/\//', $eventLogo) ? $eventLogo : asset('storage/' . ltrim($eventLogo, '/'));
                                            @endphp
                                            <img src="{{ $logoSrc }}" alt="Logo Kegiatan" class="w-full h-full object-contain" onerror="this.style.display='none'" />
                                        @else
                                            <img src="{{ asset('images/logokegiatan2.png') }}" alt="Logo Kegiatan" class="w-full h-full object-contain" onerror="this.style.display='none'" />
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-3 text-xs text-slate-600 dark:text-slate-400 flex gap-2">
                                    <a href="{{ route('event.show', ['id' => $event->id]) }}" class="inline-flex items-center gap-2 rounded-md bg-[#0D1B2A] px-3 py-1 text-xs font-semibold text-white hover:bg-[#162b45]">[Informasi Lengkap]</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@endsection

