@extends('layouts.frontend')

@section('content')
<section class="bg-slate-50 pt-5 pb-12 dark:bg-gray-950 sm:pt-6">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-6 text-center">
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-4xl">Timeline Kegiatan Pramuka</h1>
            <p class="mx-auto mt-2 max-w-2xl text-sm text-slate-600 dark:text-slate-300">
                Daftar kegiatan, jadwal, dan momen penting yang tengah atau akan dilaksanakan oleh ambalan kami.
            </p>
        </div>

        @php
            $now = \Illuminate\Support\Carbon::now()->startOfDay();
            $allEvents = ($events ?? collect())->sortBy('date');
            $upcoming = $allEvents->filter(fn($e) => \Illuminate\Support\Carbon::parse($e->date)->startOfDay()->greaterThanOrEqualTo($now));
            $past = $allEvents->filter(fn($e) => \Illuminate\Support\Carbon::parse($e->date)->startOfDay()->lessThan($now));
        @endphp

        @foreach([$upcoming, $past] as $group)
            @if($group->isNotEmpty())
                <div class="{{ $loop->first ? 'mb-8' : 'mt-10' }}">
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach($group as $item)
                            @php
                                $eventLogo = $item->logo_path ?? $item->image ?? null;
                                $logoSrc = ! empty($eventLogo)
                                    ? (preg_match('/^https?:\/\//', $eventLogo) ? $eventLogo : asset('storage/' . ltrim($eventLogo, '/')))
                                    : asset('images/logokegiatan2.png');
                            @endphp

                            <article class="group flex flex-col overflow-hidden rounded-lg border border-slate-400 bg-white shadow-sm transition duration-200 hover:shadow-lg dark:border-slate-600 dark:bg-slate-900">
                                <div class="flex items-center justify-center bg-transparent py-5">
                                    <div class="flex h-24 w-24 items-center justify-center overflow-hidden p-1 sm:h-28 sm:w-28">
                                        <img src="{{ $logoSrc }}" alt="Logo Kegiatan" class="h-full w-full object-contain" onerror="this.style.display='none'" />
                                    </div>
                                </div>
                                <div class="flex flex-1 flex-col p-3.5 sm:p-4">
                                    <h3 class="text-sm font-bold leading-snug text-slate-900 dark:text-white">{{ $item->title }}</h3>
                                    <p class="mt-2 text-[13px] leading-relaxed text-slate-600 dark:text-slate-400">{{ \Illuminate\Support\Str::limit($item->description ?? $item->excerpt ?? $item->theme ?? '', 110) }}</p>
                                    <p class="mt-3 text-[11px] text-slate-500 dark:text-slate-400 sm:text-[12px]">{{ \Illuminate\Support\Carbon::parse($item->date)->translatedFormat('d F Y') }} • {{ $item->time ?? 'Waktu' }}</p>
                                    <div class="mt-auto pt-4">
                                        <a href="{{ route('event.show', ['id' => $item->id]) }}" class="inline-flex items-center gap-2 rounded-md bg-[#0D1B2A] px-3 py-1.5 text-[11px] font-semibold text-white hover:bg-[#162b45] sm:text-xs">[Informasi Lengkap]</a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</section>
@endsection