@php
use Carbon\Carbon;

Carbon::setLocale('id');

$events = [
    [
        'id'        => 1,
        'title'     => 'Kemah Penerimaan Tamu Ambalan',
        'date'      => '2026-06-24',
        'time'      => '08:00',
        'location'  => 'Jl. KH. Achmad Fauzan, Krasak, Jepara',
        'guide_url' => '#',
        'status'    => 'upcoming',
        'theme'     => 'Satya Muda Penjaga Dharma,<br/>Wujud Nyata Praja Muda<br/>Karana',
    ],
 
    [
        'id'        => 3,
        'title'     => 'Penerimaan Ambalan Tahunan',
        'date'      => '2026-07-24',
        'time'      => '07:00',
        'location'  => 'SMK Negeri 1 Bangsri',
        'guide_url' => '#',
        'status'    => 'upcoming',
        'theme'     => 'Satya Muda Penjaga Dharma,<br/>Wujud Nyata Praja Muda',
    ],
];

// Get nearest upcoming event
$nextEvent = null;
$now = Carbon::now();

foreach ($events as $event) {
    $eventDateTime = Carbon::parse($event['date'] . ' ' . $event['time']);
    if ($eventDateTime->isFuture()) {
        $nextEvent = $event;
        $nextEvent['date_formatted'] = $eventDateTime->translatedFormat('d F Y');
        $nextEvent['datetime_js'] = $eventDateTime->toIso8601String();
        break;
    }
}
@endphp

@if ($nextEvent)
<div class="w-full">
    {{-- ═══════════════════════════════════════════════════
         TIMELINE CARD  —  3-area layout (countdown | title+meta | logo)
    ═══════════════════════════════════════════════════ --}}
    <div class="w-full bg-white dark:bg-gray-950 border-0 rounded-lg shadow-sm px-4 md:px-8 py-6 md:py-8">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 md:gap-12">

            {{-- ── LEFT: Label + Countdown ── --}}
            <div class="flex-shrink-0">
                <p class="text-sm font-bold text-gray-600 dark:text-gray-300 mb-3 tracking-wide">Kegiatan mendatang</p>

                {{-- Countdown digits --}}
                <div class="flex items-baseline gap-1.5 font-mono">
                    <span class="text-4xl md:text-5xl font-bold text-gray-800 dark:text-gray-300 leading-none tabular-nums" id="cd-days">00</span>
                    <span class="text-3xl md:text-4xl text-gray-400 dark:text-gray-500 leading-none mb-1">:</span>
                    <span class="text-4xl md:text-5xl font-bold text-gray-800 dark:text-gray-300 leading-none tabular-nums" id="cd-hours">00</span>
                    <span class="text-3xl md:text-4xl text-gray-400 dark:text-gray-500 leading-none mb-1">:</span>
                    <span class="text-4xl md:text-5xl font-bold text-gray-800 dark:text-gray-300 leading-none tabular-nums" id="cd-minutes">00</span>
                    <span class="text-3xl md:text-4xl text-gray-400 dark:text-gray-500 leading-none mb-1">:</span>
                    <span class="text-4xl md:text-5xl font-bold text-gray-800 dark:text-gray-300 leading-none tabular-nums" id="cd-seconds">00</span>
                </div>
            </div>

            {{-- ── CENTER: Title + Meta ── --}}
            <div class="flex-1 min-w-0">

                {{-- Event title --}}
                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white leading-tight mb-3 md:mb-4 tracking-tight">
                    {{ $nextEvent['title'] }}
                </h2>

                {{-- Meta row (inline) --}}
                <div class="flex flex-col sm:flex-row sm:flex-wrap sm:items-center gap-3 sm:gap-x-8 sm:gap-y-2">

                    {{-- Location --}}
                    <div class="flex items-center gap-2.5 text-sm text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="font-medium">{{ $nextEvent['location'] }}</span>
                    </div>

                    {{-- Date --}}
                    <div class="flex items-center gap-2.5 text-sm text-gray-700 dark:text-gray-300">
                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-400 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" fill="none" stroke="currentColor" stroke-width="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6" stroke="currentColor" stroke-width="2"></line>
                            <line x1="8" y1="2" x2="8" y2="6" stroke="currentColor" stroke-width="2"></line>
                            <line x1="3" y1="10" x2="21" y2="10" stroke="currentColor" stroke-width="2"></line>
                        </svg>
                        <span class="font-medium">{{ $nextEvent['date_formatted'] }}</span>
                    </div>

                    {{-- Guide --}}
                    @if ($nextEvent['guide_url'])
                    <a href="{{ $nextEvent['guide_url'] }}" class="flex items-center gap-2.5 text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">
                        <div class="w-5 h-5 rounded-full border-2 border-slate-300 dark:border-slate-500 flex items-center justify-center flex-shrink-0">
                            <span class="text-xs font-bold text-gray-600 dark:text-gray-400">?</span>
                        </div>
                        <span class="font-medium">Panduan Kegiatan</span>
                    </a>
                    @endif

                </div>
            </div>

            {{-- ── RIGHT: Logo + Theme ── --}}
            <div class="flex-shrink-0 flex items-center gap-4 md:flex-col md:items-center">
                <div class="w-20 h-20 sm:w-24 sm:h-24 md:w-32 md:h-32 flex items-center justify-center flex-shrink-0">
                    <img src="{{ asset('images/logokegiatan2.png') }}" 
                         alt="Logo Kegiatan" 
                         class="w-full h-full object-contain"
                         onerror="this.style.display='none'" />
                </div>
                {{-- Theme - visible on mobile/tablet, hidden on desktop --}}
                <p class="text-sm md:text-base text-gray-700 dark:text-gray-300 leading-tight font-extrabold md:hidden text-center">
                    {!! $nextEvent['theme'] !!}
                </p>
            </div>

        </div>
    </div>

    {{-- ── JS: real-time countdown tick (no page reload) ── --}}
    <script>
        (function () {
            const target = new Date("{{ $nextEvent['datetime_js'] }}");

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