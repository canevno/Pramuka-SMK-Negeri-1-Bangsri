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
            'guide_url' => '#',
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
            'guide_url' => '#',
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

        <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between md:text-left">

            {{-- ── LEFT: Title + Meta ── --}}
            <div class="order-1 flex-1 min-w-0 w-full md:w-auto">

                {{-- Event title --}}
                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white leading-tight mb-3 md:mb-4 tracking-tight text-center md:text-left">
                    {{ is_array($nextEvent) ? ($nextEvent['title'] ?? 'Kegiatan') : ($nextEvent->title ?? 'Kegiatan') }}
                </h2>

                {{-- Meta row (inline) --}}
                <div class="flex flex-col items-center gap-2.5 sm:flex-row sm:flex-wrap sm:items-center sm:justify-center md:justify-start sm:gap-x-8 sm:gap-y-2">

                    {{-- Location --}}
                    <div class="flex items-center gap-2.5 text-sm text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="font-medium">{{ is_array($nextEvent) ? ($nextEvent['location'] ?? '-') : ($nextEvent->location ?? '-') }}</span>
                    </div>

                    <div class="flex flex-col items-center gap-2.5 sm:flex-row sm:items-center"> 
                        {{-- Date --}}
                        <div class="flex items-center gap-2.5 text-sm text-gray-700 dark:text-gray-300">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" fill="none" stroke="currentColor" stroke-width="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6" stroke="currentColor" stroke-width="2"></line>
                                <line x1="8" y1="2" x2="8" y2="6" stroke="currentColor" stroke-width="2"></line>
                                <line x1="3" y1="10" x2="21" y2="10" stroke="currentColor" stroke-width="2"></line>
                            </svg>
                            <span class="font-medium">{{ is_array($nextEvent) ? ($nextEvent['date_formatted'] ?? '-') : ($nextEvent->date_formatted ?? '-') }}</span>
                        </div>

                        {{-- Guide --}}
                        @if (is_array($nextEvent) ? ! empty($nextEvent['guide_url']) : ! empty($nextEvent->guide_url))
                        <a href="{{ is_array($nextEvent) ? ($nextEvent['guide_url'] ?? '#') : ($nextEvent->guide_url ?? '#') }}" class="flex items-center gap-2.5 text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">
                            <div class="w-5 h-5 rounded-full border-2 border-slate-300 dark:border-slate-500 flex items-center justify-center flex-shrink-0">
                                <span class="text-xs font-bold text-gray-600 dark:text-gray-400">?</span>
                            </div>
                            <span class="font-medium">Panduan Kegiatan</span>
                        </a>
                        @endif
                    </div>

                </div>
            </div>

            {{-- ── RIGHT: Label + Countdown ── --}}
            <div class="order-2 flex-shrink-0 w-full md:w-auto">
                <p class="text-sm font-bold text-gray-600 dark:text-gray-300 mb-3 tracking-wide text-center md:text-left">Kegiatan Mendatang</p>

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
            <div class="order-3 flex-shrink-0 flex items-center justify-center gap-4 md:flex-col md:items-center w-full md:w-auto">
                <div class="w-20 h-20 sm:w-24 sm:h-24 md:w-32 md:h-32 flex items-center justify-center flex-shrink-0 overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 shadow-sm dark:border-slate-700 dark:bg-slate-900">
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

                const pad = n => String(n).padStart(1, '0');

                const d = document.getElementById('cd-days');
                const h = document.getElementById('cd-hours');
                const m = document.getElementById('cd-minutes');
                const s = document.getElementById('cd-seconds');

                if (d) d.textContent = pad(days);
                if (h) h.textContent = pad(hours);
                if (m) m.textContent = pad(minutes);
                if (s) s.textContent = pad(seconds);
            }

            tick();
            setInterval(tick, 1000);
        })();
    </script>

@endif