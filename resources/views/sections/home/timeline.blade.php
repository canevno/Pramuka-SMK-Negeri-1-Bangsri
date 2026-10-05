@php
use Carbon\Carbon;

Carbon::setLocale('id');

$normalizeEventDateTime = function ($dateValue, $timeValue = '00:00') {
    $dateString = $dateValue instanceof \DateTimeInterface
        ? $dateValue->format('Y-m-d')
        : (string) $dateValue;

    $timeString = trim((string) ($timeValue ?? '00:00'));
    if ($timeString === '') {
        $timeString = '00:00';
    }

    return Carbon::parse($dateString . ' ' . $timeString);
};

$events = \Illuminate\Support\Facades\Schema::hasTable('timeline_events')
    ? \App\Models\TimelineEvent::query()
        ->where('is_active', true)
        ->orderBy('date')
        ->orderBy('sort_order')
        ->get()
        ->map(function ($event) use ($normalizeEventDateTime) {
            $eventDateTime = $normalizeEventDateTime($event->date, $event->time);
            $event->date_formatted = $eventDateTime->translatedFormat('d F Y');
            $event->datetime_js = $eventDateTime->toIso8601String();

            return $event;
        })
        ->all()
    : [
        [
            'id' => 1,
            'title' => 'Kemah Penerimaan Tamu Ambalan',
            'date' => '2026-06-24',
            'time' => '08:00',
            'location' => 'Jl. KH. Achmad Fauzan, Krasak, Jepara',
            'status' => 'upcoming',
            'theme' => 'Satya Muda Penjaga Dharma,<br/>Wujud Nyata Praja Muda<br/>Karana',
            'date_formatted' => '24 Juni 2026',
            'datetime_js' => '2026-06-24T08:00:00+00:00',
        ],
        [
            'id' => 3,
            'title' => 'Penerimaan Ambalan Tahunan',
            'date' => '2026-07-24',
            'time' => '07:00',
            'location' => 'SMK Negeri 1 Bangsri',
            'status' => 'upcoming',
            'theme' => 'Satya Muda Penjaga Dharma,<br/>Wujud Nyata Praja Muda',
            'date_formatted' => '24 Juli 2026',
            'datetime_js' => '2026-07-24T07:00:00+00:00',
        ],
    ];

$nextEvent = null;
$latestEvent = null;

foreach ($events as $event) {
    $eventDate = is_array($event) ? ($event['date'] ?? null) : ($event->date ?? null);
    $eventTime = is_array($event) ? ($event['time'] ?? '00:00') : ($event->time ?? '00:00');

    if (! $eventDate) {
        continue;
    }

    $eventDateTime = $normalizeEventDateTime($eventDate, $eventTime);
    $eventData = $event;

    if (is_array($eventData)) {
        $eventData['date_formatted'] = $eventData['date_formatted'] ?? $eventDateTime->translatedFormat('d F Y');
        $eventData['datetime_js'] = $eventData['datetime_js'] ?? $eventDateTime->toIso8601String();
    } else {
        $eventData->date_formatted = $eventData->date_formatted ?? $eventDateTime->translatedFormat('d F Y');
        $eventData->datetime_js = $eventData->datetime_js ?? $eventDateTime->toIso8601String();
    }

    if ($eventDateTime->isFuture() && $nextEvent === null) {
        $nextEvent = $eventData;
    }

    $latestDateValue = is_array($latestEvent) ? ($latestEvent['date'] ?? null) : ($latestEvent?->date ?? null);
    $latestTimeValue = is_array($latestEvent) ? ($latestEvent['time'] ?? '00:00') : ($latestEvent?->time ?? '00:00');
    $latestDateTime = $latestDateValue ? $normalizeEventDateTime($latestDateValue, $latestTimeValue) : null;

    if ($latestEvent === null || $eventDateTime->greaterThan($latestDateTime)) {
        $latestEvent = $eventData;
    }
}

if ($nextEvent === null && $latestEvent !== null) {
    $nextEvent = $latestEvent;
}
@endphp

@if ($nextEvent)
<div class="w-full">
    {{-- ═══════════════════════════════════════════════════
         TIMELINE CARD  —  3-area layout (countdown | title+meta | logo)
    ═══════════════════════════════════════════════════ --}}
    <div class="w-full bg-white dark:bg-gray-950 border-0 rounded-lg shadow-sm px-4 md:px-8 py-4 md:py-6">

        {{-- ═══════════════════════════════════════════════════
             DESKTOP LAYOUT (tidak diubah) — disembunyikan di mobile
        ═══════════════════════════════════════════════════ --}}
        <div class="hidden gap-6 md:flex md:flex-row md:items-center md:justify-between md:text-left">

            {{-- ── LEFT: Title + Meta ── --}}
            <div class="order-1 flex-1 min-w-0 w-full md:w-auto">

                {{-- Event title --}}
                <h2 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-white sm:text-3xl text-center md:text-left mb-3 md:mb-4">
                    {{ is_array($nextEvent) ? ($nextEvent['title'] ?? 'Kegiatan') : ($nextEvent->title ?? 'Kegiatan') }}
                </h2>

                @php
                    $locationText = is_array($nextEvent) ? ($nextEvent['location'] ?? '-') : ($nextEvent->location ?? '-');
                    $locationHref = null;

                    if (is_array($nextEvent)) {
                        $locationHref = trim((string) ($nextEvent['location_url'] ?? '')) ?: null;
                    } else {
                        $locationHref = trim((string) ($nextEvent->location_url ?? '')) ?: null;
                    }

                    if (empty($locationHref) && is_string($locationText) && $locationText !== '-') {
                        if (filter_var($locationText, FILTER_VALIDATE_URL)) {
                            $locationHref = $locationText;
                        } elseif (! empty($nextEvent['latitude'] ?? null) && ! empty($nextEvent['longitude'] ?? null)) {
                            $locationHref = 'https://www.google.com/maps/search/?api=1&query=' . urlencode(($nextEvent['latitude'] ?? '') . ',' . ($nextEvent['longitude'] ?? ''));
                        } elseif (! empty($nextEvent->latitude ?? null) && ! empty($nextEvent->longitude ?? null)) {
                            $locationHref = 'https://www.google.com/maps/search/?api=1&query=' . urlencode(($nextEvent->latitude ?? '') . ',' . ($nextEvent->longitude ?? ''));
                        }
                    }
                @endphp

                {{-- Mobile-only metadata row: location and date --}}
                <div class="flex flex-row flex-wrap items-center justify-center gap-2.5 text-center md:hidden">
                    <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                        <svg class="w-4 h-4 text-gray-600 dark:text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        @if(! empty($locationHref))
                            <a href="{{ $locationHref }}" target="_blank" rel="noopener" class="font-medium text-slate-900 hover:underline dark:text-white">{{ $locationText }}</a>
                        @else
                            <span class="font-medium text-slate-900 dark:text-white">{{ $locationText }}</span>
                        @endif
                    </div>

                    <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                        <svg class="w-4 h-4 text-gray-600 dark:text-gray-400 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" fill="none" stroke="currentColor" stroke-width="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6" stroke="currentColor" stroke-width="2"></line>
                            <line x1="8" y1="2" x2="8" y2="6" stroke="currentColor" stroke-width="2"></line>
                            <line x1="3" y1="10" x2="21" y2="10" stroke="currentColor" stroke-width="2"></line>
                        </svg>
                        <span class="font-medium">{{ is_array($nextEvent) ? ($nextEvent['date_formatted'] ?? '-') : ($nextEvent->date_formatted ?? '-') }}</span>
                    </div>

                </div>

                {{-- Desktop metadata row remains unchanged --}}
                <div class="hidden md:flex md:flex-wrap md:items-center md:justify-start md:gap-x-8 md:gap-y-2">
                    <div class="flex items-center gap-2.5 text-sm text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        @if(! empty($locationHref))
                            <a href="{{ $locationHref }}" target="_blank" rel="noopener" class="font-medium text-slate-900 hover:underline dark:text-white">{{ $locationText }}</a>
                        @else
                            <span class="font-medium text-slate-900 dark:text-white">{{ $locationText }}</span>
                        @endif
                    </div>

                    <div class="flex items-center gap-2.5 text-sm text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-400 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" fill="none" stroke="currentColor" stroke-width="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6" stroke="currentColor" stroke-width="2"></line>
                            <line x1="8" y1="2" x2="8" y2="6" stroke="currentColor" stroke-width="2"></line>
                            <line x1="3" y1="10" x2="21" y2="10" stroke="currentColor" stroke-width="2"></line>
                        </svg>
                        <span class="font-medium">{{ is_array($nextEvent) ? ($nextEvent['date_formatted'] ?? '-') : ($nextEvent->date_formatted ?? '-') }}</span>
                    </div>

                </div>
            </div>

            {{-- ── RIGHT: Label + Countdown ── --}}
            <div class="order-2 md:order-2 flex-shrink-0 w-full md:w-auto">
                <p class="hidden md:block text-sm font-bold text-gray-600 dark:text-gray-300 mb-3 tracking-wide text-center md:text-left">Kegiatan Mendatang</p>

                {{-- Countdown digits --}}
                <div class="flex items-baseline justify-center md:justify-start gap-1.5 font-mono">
                    <span class="text-4xl md:text-5xl font-bold text-gray-800 dark:text-gray-300 leading-none tabular-nums" id="cd-days">00</span>
                    <span class="text-3xl md:text-4xl text-gray-400 dark:text-gray-500 leading-none mb-1">:</span>
                    <span class="text-4xl md:text-5xl font-bold text-gray-800 dark:text-gray-300 leading-none tabular-nums" id="cd-hours">00</span>
                    <span class="text-3xl md:text-4xl text-gray-400 dark:text-gray-500 leading-none mb-1">:</span>
                    <span class="text-4xl md:text-5xl font-bold text-gray-800 dark:text-gray-300 leading-none tabular-nums" id="cd-minutes">00</span>
                    <span class="text-3xl md:text-4xl text-gray-400 dark:text-gray-500 leading-none mb-1">:</span>
                    <span class="text-4xl md:text-5xl font-bold text-gray-800 dark:text-gray-300 leading-none tabular-nums" id="cd-seconds">00</span>
                </div>
            </div>

            {{-- ── RIGHT: Logo + Theme ── --}}
            <div class="order-3 md:order-3 flex-shrink-0 flex items-center justify-center gap-4 md:flex-col md:items-center w-full md:w-auto">
                <div class="w-20 h-20 sm:w-24 sm:h-24 md:w-32 md:h-32 flex items-center justify-center flex-shrink-0 overflow-hidden rounded-2xl border border-transparent bg-transparent shadow-none dark:border-transparent dark:bg-transparent">
                    @php
                        $eventLogo = is_array($nextEvent) ? ($nextEvent['logo_path'] ?? null) : ($nextEvent->logo_path ?? null);
                    @endphp
                    @if($eventLogo)
                        <img src="{{ asset('storage/' . $eventLogo) }}" alt="Logo Kegiatan" class="w-full h-full object-cover" onerror="this.style.display='none'" />
                    @else
                        <img src="{{ asset('images/logokegiatan2.png') }}" alt="Logo Kegiatan" class="w-full h-full object-contain" onerror="this.style.display='none'" />
                    @endif
                </div>
                {{-- Theme - visible on mobile/tablet, hidden on desktop --}}
                <p class="text-sm md:text-base text-gray-700 dark:text-gray-300 leading-tight font-extrabold md:hidden text-center">
                    {!! is_array($nextEvent) ? ($nextEvent['theme'] ?? '') : ($nextEvent->theme ?? '') !!}
                </p>
            </div>

        </div>
        {{-- ═════════════ END DESKTOP LAYOUT ═════════════ --}}


        {{-- ═══════════════════════════════════════════════════
             MOBILE CARD (baru) — hanya tampil di bawah breakpoint md
             Countdown dalam kotak terpisah, meta berupa daftar vertikal
        ═══════════════════════════════════════════════════ --}}
        @php
            $mTitle      = is_array($nextEvent) ? ($nextEvent['title'] ?? 'Kegiatan') : ($nextEvent->title ?? 'Kegiatan');
            $mLocation   = is_array($nextEvent) ? ($nextEvent['location'] ?? '-') : ($nextEvent->location ?? '-');
            $mDate       = is_array($nextEvent) ? ($nextEvent['date_formatted'] ?? '-') : ($nextEvent->date_formatted ?? '-');
            $mTheme      = is_array($nextEvent) ? ($nextEvent['theme'] ?? '') : ($nextEvent->theme ?? '');
            $mLogoPath   = is_array($nextEvent) ? ($nextEvent['logo_path'] ?? null) : ($nextEvent->logo_path ?? null);
            $mLocationHref = $locationHref ?? null;
        @endphp

        <div class="md:hidden">

            {{-- Logo + Label + Judul --}}
            <div class="flex items-center gap-3">
                <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center overflow-hidden rounded-lg">
                    @if($mLogoPath)
                        <img src="{{ asset('storage/' . $mLogoPath) }}" alt="Logo Kegiatan" class="h-full w-full object-cover" onerror="this.style.display='none'" />
                    @else
                        <img src="{{ asset('images/logokegiatan2.png') }}" alt="Logo Kegiatan" class="h-full w-full object-contain" onerror="this.style.display='none'" />
                    @endif
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Kegiatan Mendatang</p>
                    <h2 class="text-base font-semibold leading-snug tracking-tight text-slate-900 dark:text-white">{{ $mTitle }}</h2>
                </div>
            </div>

            {{-- Countdown: satu kotak per satuan, tanpa pembungkus tambahan --}}
            <div class="mt-3 grid grid-cols-4 gap-1.5 text-center">
                @foreach ([['days', 'Hari'], ['hours', 'Jam'], ['minutes', 'Menit'], ['seconds', 'Detik']] as [$cdKey, $cdLabel])
                    <div class="rounded-lg bg-[#f1f5f9] py-1.5 dark:bg-gray-800">
                        <span id="cd-m-{{ $cdKey }}" class="block font-mono text-xl font-bold leading-none tabular-nums text-slate-900 dark:text-white">00</span>
                        <span class="mt-1 block text-[10px] font-semibold uppercase leading-none tracking-wide text-slate-500 dark:text-gray-400">{{ $cdLabel }}</span>
                    </div>
                @endforeach
            </div>

            {{-- Tema --}}
            @if (! empty($mTheme))
                <p class="mt-2.5 text-center text-xs font-extrabold leading-tight text-gray-700 dark:text-gray-300">
                    {!! $mTheme !!}
                </p>
            @endif

            {{-- Meta: lokasi + tanggal --}}
            <div class="mt-3 flex flex-col items-center text-[13px] text-gray-700 dark:text-gray-300" style="row-gap: 0.875rem;">
                <div class="flex flex-wrap items-center justify-center" style="column-gap: 1.75rem; row-gap: 0.25rem;">
                    <div class="flex items-center gap-1.5">
                        <svg class="h-4 w-4 flex-shrink-0 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        @if (! empty($mLocationHref))
                            <a href="{{ $mLocationHref }}" target="_blank" rel="noopener" class="font-medium text-slate-900 hover:underline dark:text-white">{{ $mLocation }}</a>
                        @else
                            <span class="font-medium text-slate-900 dark:text-white">{{ $mLocation }}</span>
                        @endif
                    </div>

                    <div class="flex items-center gap-1.5">
                        <svg class="h-4 w-4 flex-shrink-0 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" fill="none" stroke="currentColor" stroke-width="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6" stroke="currentColor" stroke-width="2"></line>
                            <line x1="8" y1="2" x2="8" y2="6" stroke="currentColor" stroke-width="2"></line>
                            <line x1="3" y1="10" x2="21" y2="10" stroke="currentColor" stroke-width="2"></line>
                        </svg>
                        <span class="font-medium">{{ $mDate }}</span>
                    </div>
                </div>
            </div>
        </div>
        {{-- ═════════════ END MOBILE CARD ═════════════ --}}

    </div>

    {{-- ── JS: real-time countdown tick (no page reload) ── --}}
    <script>
        (function () {
            const target = new Date("{{ is_array($nextEvent) ? ($nextEvent['datetime_js'] ?? '') : ($nextEvent->datetime_js ?? '') }}");

            function tick() {
                const now  = new Date();
                const diff = target - now;
                if (diff <= 0) return;

                const days    = Math.floor(diff / 86400000);
                const hours   = Math.floor((diff % 86400000) / 3600000);
                const minutes = Math.floor((diff % 3600000)  / 60000);
                const seconds = Math.floor((diff % 60000)    / 1000);

                // Desktop: tanpa nol di depan (perilaku asli)
                const pad = n => String(n).padStart(1, '0');
                // Mobile: dua digit agar kotak countdown rapi
                const pad2 = n => String(n).padStart(2, '0');

                const d = document.getElementById('cd-days');
                const h = document.getElementById('cd-hours');
                const m = document.getElementById('cd-minutes');
                const s = document.getElementById('cd-seconds');

                if (d) d.textContent = pad(days);
                if (h) h.textContent = pad(hours);
                if (m) m.textContent = pad(minutes);
                if (s) s.textContent = pad(seconds);

                const md = document.getElementById('cd-m-days');
                const mh = document.getElementById('cd-m-hours');
                const mm = document.getElementById('cd-m-minutes');
                const ms = document.getElementById('cd-m-seconds');

                if (md) md.textContent = pad2(days);
                if (mh) mh.textContent = pad2(hours);
                if (mm) mm.textContent = pad2(minutes);
                if (ms) ms.textContent = pad2(seconds);
            }

            tick();
            setInterval(tick, 1000);
        })();
    </script>
</div>
@endif