@extends('admin.layouts.app')
@section('title', 'Dashboard Admin')
@section('page-heading', 'Dashboard')
@section('page-description', 'Selamat datang kembali, Admin. Panel ini dirancang untuk tata kelola kegiatan kepramukaan.')

@section('content')
<div class="space-y-2.5 sm:space-y-4">

    {{-- ===== Header ===== --}}
    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-lg font-semibold tracking-tight text-zinc-900 dark:text-slate-100 sm:text-2xl">Selamat datang kembali, Admin!</h1>
            <p class="mt-1 text-[11px] text-zinc-500 dark:text-slate-400 sm:text-sm">Kelola seluruh kegiatan kepramukaan dengan baik dan aman.</p>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" class="inline-flex items-center gap-1.5 rounded-lg bg-zinc-900 px-2 py-1.5 text-[10px] font-medium text-white transition hover:bg-zinc-700 dark:bg-slate-100 dark:text-slate-900 dark:hover:bg-slate-300 sm:gap-2 sm:px-3.5 sm:py-2 sm:text-sm">
                <svg viewBox="0 0 24 24" class="h-3.5 w-3.5 sm:h-4 sm:w-4" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
                Buat Baru
            </button>
        </div>
    </div>

    {{-- ===== Chart + Aktivitas ===== --}}
    <div class="grid gap-2.5 xl:grid-cols-[1.6fr_1fr]">

        {{-- ----- Statistik Pengunjung ----- --}}
        <section class="rounded-xl border border-zinc-200 bg-white p-3 dark:border-slate-800 dark:bg-slate-900/90 sm:p-5">
            @php
                $chartValues = collect($visitorStats)->pluck('count')->all();
                $prevValues = collect($visitorStats)->pluck('prev_count')->all();
                $dataMax = max(array_merge($chartValues, $prevValues, [0]));
                $chartMax = max(4, (int) (ceil($dataMax / 4) * 4)); // kelipatan 4 agar garis bantu rapi

                $n = max(count($visitorStats), 1);
                $padX = 4;                                   // jarak kiri/kanan (%)
                $step = $n > 1 ? (100 - 2 * $padX) / ($n - 1) : 0;

                $thisPts = [];
                $prevPts = [];
                foreach ($visitorStats as $i => $stat) {
                    $x = $n > 1 ? $padX + $i * $step : 50;
                    $thisPts[] = ['x' => $x, 'v' => ($stat['count'] / $chartMax) * 100, 'stat' => $stat];
                    $prevPts[] = ['x' => $x, 'v' => ($stat['prev_count'] / $chartMax) * 100];
                }

                $toSvg = fn ($pts) => collect($pts)->map(fn ($p) => round($p['x'], 2) . ',' . round(100 - $p['v'], 2))->implode(' ');
                $linePoints = $toSvg($thisPts);
                $prevPoints = $toSvg($prevPts);
                $areaPoints = $linePoints . ' ' . round($thisPts[count($thisPts) - 1]['x'] ?? 100, 2) . ',100 ' . round($thisPts[0]['x'] ?? 0, 2) . ',100';
                $lastIndex = count($thisPts) - 1;
            @endphp

            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-sm font-semibold text-zinc-900 dark:text-slate-100 sm:text-base">Statistik Pengunjung</h2>
                    <div class="mt-1.5 flex items-center gap-3 text-[10px] text-zinc-500 dark:text-slate-400 sm:gap-4 sm:text-xs">
                        <span class="flex items-center gap-1.5"><span class="h-0 w-3.5 border-t-2 border-zinc-900 dark:border-slate-100"></span>Minggu ini</span>
                        <span class="flex items-center gap-1.5"><span class="h-0 w-3.5 border-t-2 border-dashed border-zinc-400 dark:border-slate-500"></span>Minggu lalu</span>
                    </div>
                </div>
                <select class="w-full rounded-lg border border-zinc-200 bg-white px-2.5 py-1.5 text-[11px] text-zinc-600 outline-none transition focus:border-zinc-900 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200 dark:focus:border-slate-300 sm:w-auto sm:px-3 sm:text-sm">
                    <option>7 Hari Terakhir</option>
                    <option>30 Hari Terakhir</option>
                    <option>90 Hari Terakhir</option>
                </select>
            </div>

            <div class="mt-4 flex gap-2 sm:mt-5 sm:gap-3">
                {{-- Sumbu Y --}}
                <div class="relative h-32 w-6 shrink-0 text-[9px] tabular-nums text-zinc-400 dark:text-slate-500 sm:h-44 sm:text-[10px]">
                    @for ($level = 0; $level <= 4; $level++)
                        <span class="absolute right-0 translate-y-1/2 leading-none" style="bottom: {{ $level * 25 }}%">{{ (int) round(($chartMax / 4) * $level) }}</span>
                    @endfor
                </div>

                <div class="min-w-0 flex-1">
                    {{-- Area plot --}}
                    <div class="relative h-32 sm:h-44">
                        @for ($level = 0; $level <= 4; $level++)
                            <div class="absolute inset-x-0 border-t {{ $level === 0 ? 'border-zinc-300 dark:border-slate-600' : 'border-zinc-100 dark:border-slate-800' }}" style="bottom: {{ $level * 25 }}%"></div>
                        @endfor

                        <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="absolute inset-0 h-full w-full overflow-visible text-zinc-900 dark:text-slate-100">
                            <defs>
                                <linearGradient id="visitorFill" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="currentColor" stop-opacity="0.10"/>
                                    <stop offset="100%" stop-color="currentColor" stop-opacity="0"/>
                                </linearGradient>
                            </defs>
                            <polygon points="{{ $areaPoints }}" fill="url(#visitorFill)" stroke="none"/>
                            <polyline points="{{ $prevPoints }}" fill="none" stroke="#a1a1aa" stroke-width="1.25" stroke-dasharray="4 3" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke"/>
                            <polyline points="{{ $linePoints }}" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke"/>
                        </svg>

                        {{-- Titik data dan jumlah pengunjung --}}
                        @foreach ($thisPts as $i => $p)
                            <span class="pointer-events-none absolute -translate-x-1/2 translate-y-1/2 rounded-full bg-zinc-900 ring-2 ring-white dark:bg-slate-100 dark:ring-slate-900 {{ $i === $lastIndex ? 'h-2 w-2' : 'h-1.5 w-1.5' }}" style="left: {{ round($p['x'], 2) }}%; bottom: {{ round($p['v'], 2) }}%"></span>
                            <span class="pointer-events-none absolute -translate-x-1/2 -translate-y-full whitespace-nowrap rounded-full border border-zinc-200 bg-white px-1.5 py-0.5 text-[8px] font-semibold text-zinc-700 shadow-sm dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200" style="left: {{ round($p['x'], 2) }}%; bottom: {{ min(96, round($p['v'], 2) + 8) }}%">
                                {{ number_format($p['stat']['count']) }}
                            </span>
                        @endforeach

                        {{-- Area hover / tooltip --}}
                        @foreach ($thisPts as $p)
                            <div class="absolute inset-y-0 -translate-x-1/2" style="left: {{ round($p['x'], 2) }}%; width: {{ round($step ?: 100, 2) }}%" title="{{ $p['stat']['label'] }} {{ $p['stat']['day'] }}: {{ number_format($p['stat']['count']) }} (minggu lalu: {{ number_format($p['stat']['prev_count']) }})"></div>
                        @endforeach
                    </div>

                    {{-- Label hari --}}
                    <div class="relative mt-2 h-6 text-[9px] text-zinc-400 dark:text-slate-500 sm:text-[10px]">
                        @foreach ($thisPts as $p)
                            <span class="absolute -translate-x-1/2 text-center leading-tight" style="left: {{ round($p['x'], 2) }}%">
                                <span class="block font-medium">{{ $p['stat']['label'] }}</span>
                                <span class="block tabular-nums">{{ $p['stat']['day'] }}</span>
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        {{-- ----- Petugas Teraktif ----- --}}
        <section class="rounded-xl border border-zinc-200 bg-white p-3 dark:border-slate-800 dark:bg-slate-900/90 sm:p-5">
            <div class="mb-2 flex items-center justify-between gap-2 sm:mb-3">
                <h2 class="text-sm font-semibold text-zinc-900 dark:text-slate-100 sm:text-base">Petugas Teraktif</h2>
                <a href="{{ route('admin.absensi') }}" class="inline-flex items-center rounded-md border border-zinc-200 px-2 py-1 text-[9px] font-semibold text-zinc-700 transition hover:bg-zinc-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800 sm:text-[10px]">
                    Lihat semua
                </a>
            </div>
            <div class="divide-y divide-zinc-100 dark:divide-slate-800">
                @forelse($petugasTeraktif as $index => $petugas)
                    <div class="flex items-center justify-between gap-2 py-2">
                        <div class="flex min-w-0 flex-1 items-center gap-2 sm:gap-2.5">
                            <span class="w-4 shrink-0 text-[10px] font-medium tabular-nums text-zinc-400 dark:text-slate-500 sm:text-[11px]">{{ $index + 1 }}</span>
                            @if(!empty($petugas['photo_url']))
                                <img src="{{ $petugas['photo_url'] }}" alt="{{ $petugas['name'] }}" class="h-7 w-7 shrink-0 rounded-full object-cover ring-1 ring-zinc-200 dark:ring-slate-700 sm:h-8 sm:w-8">
                            @else
                                <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-zinc-100 text-[10px] font-semibold text-zinc-600 ring-1 ring-zinc-200 dark:bg-slate-800 dark:text-slate-300 dark:ring-slate-700 sm:h-8 sm:w-8 sm:text-[11px]">
                                    {{ $petugas['initial'] }}
                                </div>
                            @endif
                            <p class="min-w-0 flex-1 truncate text-[11px] font-medium text-zinc-900 dark:text-slate-100 sm:text-[13px]">{{ $petugas['name'] }}</p>
                        </div>
                        <span class="ml-auto text-[11px] font-semibold tabular-nums text-zinc-900 dark:text-slate-100 sm:text-[12px]">{{ number_format($petugas['total_records']) }}</span>
                    </div>
                @empty
                    <div class="py-3 text-[11px] text-zinc-500 dark:text-slate-400 sm:text-xs">
                        Belum ada data petugas aktif.
                    </div>
                @endforelse
            </div>
        </section>
    </div>

    {{-- ===== Tabel Pendaftaran + Berita ===== --}}
    <div class="grid gap-2.5 xl:grid-cols-[1.3fr_0.95fr]">
        <section class="rounded-xl border border-zinc-200 bg-white p-3 dark:border-slate-800 dark:bg-slate-900/90 sm:p-5">
            <div class="flex items-center justify-between gap-2 sm:items-center">
                <h2 class="text-sm font-semibold text-zinc-900 dark:text-slate-100 sm:text-base">Pendaftaran Terbaru</h2>
                <span class="rounded-md border border-zinc-200 px-2 py-0.5 text-[9px] font-medium text-zinc-600 dark:border-slate-700 dark:text-slate-300 sm:text-[10px]">Semua</span>
            </div>

            <div class="mt-4 overflow-hidden rounded-lg border border-zinc-200 dark:border-slate-800">
                <div class="hidden sm:block">
                    <div class="max-h-[21rem] overflow-y-auto overflow-x-auto overscroll-x-contain scrollbar-thin scrollbar-thumb-zinc-300 scrollbar-track-transparent dark:scrollbar-thumb-slate-600">
                        <table class="min-w-[560px] w-full text-left text-[11px] sm:text-sm">
                            <thead class="bg-zinc-50 dark:bg-slate-800/60">
                                <tr>
                                    <th class="px-3 py-2.5 text-[9px] font-semibold uppercase tracking-[0.12em] text-zinc-500 dark:text-slate-400 sm:text-[10px]">Nama</th>
                                    <th class="px-3 py-2.5 text-[9px] font-semibold uppercase tracking-[0.12em] text-zinc-500 dark:text-slate-400 sm:text-[10px]">Kelas</th>
                                    <th class="px-3 py-2.5 text-[9px] font-semibold uppercase tracking-[0.12em] text-zinc-500 dark:text-slate-400 sm:text-[10px]">Jenis</th>
                                    <th class="px-3 py-2.5 text-[9px] font-semibold uppercase tracking-[0.12em] text-zinc-500 dark:text-slate-400 sm:text-[10px]">Tanggal</th>
                                    <th class="px-3 py-2.5 text-[9px] font-semibold uppercase tracking-[0.12em] text-zinc-500 dark:text-slate-400 sm:text-[10px]">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestRegistrations as $item)
                                    @php
                                        $statusClass = match (strtolower(trim($item['status']))) {
                                            'disetujui' => 'bg-zinc-900 text-white ring-zinc-900 dark:bg-slate-100 dark:text-slate-900 dark:ring-slate-100',
                                            'pending' => 'bg-white text-zinc-700 ring-zinc-300 dark:bg-transparent dark:text-slate-200 dark:ring-slate-600',
                                            'ditolak' => 'bg-zinc-100 text-zinc-500 ring-zinc-200 line-through dark:bg-slate-800 dark:text-slate-400 dark:ring-slate-700',
                                            default => 'bg-zinc-100 text-zinc-700 ring-zinc-200 dark:bg-slate-800 dark:text-slate-200 dark:ring-slate-700',
                                        };
                                    @endphp
                                    <tr class="border-t border-zinc-100 first:border-t-0 dark:border-slate-800">
                                        <td class="px-3 py-3">
                                            <div class="flex flex-col">
                                                <span class="font-semibold text-zinc-900 dark:text-slate-100">{{ $item['name'] }}</span>
                                                <span class="mt-0.5 text-[10px] text-zinc-500 dark:text-slate-400">{{ $item['type'] }}</span>
                                            </div>
                                        </td>
                                        <td class="px-3 py-3 text-zinc-700 dark:text-slate-200">{{ $item['kelas'] }}</td>
                                        <td class="px-3 py-3 text-zinc-700 dark:text-slate-200">{{ $item['type'] }}</td>
                                        <td class="px-3 py-3 tabular-nums text-zinc-700 dark:text-slate-200">{{ $item['date'] }}</td>
                                        <td class="px-3 py-3">
                                            <span class="inline-flex rounded-md px-2 py-0.5 text-[10px] font-semibold ring-1 {{ $statusClass }}">
                                                {{ $item['status'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-3 py-5 text-center text-[11px] text-zinc-500 dark:text-slate-400 sm:text-sm">Belum ada data pendaftaran.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="max-h-[16rem] overflow-y-auto px-2 py-2 sm:hidden">
                    @forelse($latestRegistrations as $item)
                        @php
                            $statusClass = match (strtolower(trim($item['status']))) {
                                'disetujui' => 'bg-zinc-900 text-white ring-zinc-900 dark:bg-slate-100 dark:text-slate-900 dark:ring-slate-100',
                                'pending' => 'bg-white text-zinc-700 ring-zinc-300 dark:bg-transparent dark:text-slate-200 dark:ring-slate-600',
                                'ditolak' => 'bg-zinc-100 text-zinc-500 ring-zinc-200 line-through dark:bg-slate-800 dark:text-slate-400 dark:ring-slate-700',
                                default => 'bg-zinc-100 text-zinc-700 ring-zinc-200 dark:bg-slate-800 dark:text-slate-200 dark:ring-slate-700',
                            };
                        @endphp
                        <div class="mb-2 rounded-lg border border-zinc-200 p-2.5 last:mb-0 dark:border-slate-800">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-[11px] font-semibold text-zinc-900 dark:text-slate-100">{{ $item['name'] }}</p>
                                    <p class="mt-0.5 text-[10px] text-zinc-500 dark:text-slate-400">{{ $item['type'] }}</p>
                                </div>
                                <span class="inline-flex rounded-md px-2 py-0.5 text-[9px] font-semibold ring-1 {{ $statusClass }}">
                                    {{ $item['status'] }}
                                </span>
                            </div>

                            <div class="mt-2 grid grid-cols-2 gap-2 text-[10px] text-zinc-600 dark:text-slate-300">
                                <div>
                                    <span class="block text-[9px] uppercase tracking-[0.1em] text-zinc-400 dark:text-slate-500">Kelas</span>
                                    <span class="mt-0.5 block font-medium text-zinc-800 dark:text-slate-200">{{ $item['kelas'] }}</span>
                                </div>
                                <div>
                                    <span class="block text-[9px] uppercase tracking-[0.1em] text-zinc-400 dark:text-slate-500">Tanggal</span>
                                    <span class="mt-0.5 block font-medium text-zinc-800 dark:text-slate-200">{{ $item['date'] }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-2 py-4 text-center text-[11px] text-zinc-500 dark:text-slate-400">Belum ada data pendaftaran.</div>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="min-w-0 rounded-xl border border-zinc-200 bg-white p-3 dark:border-slate-800 dark:bg-slate-900/90 sm:p-5">
            <div class="flex items-center justify-between gap-2">
                <div class="min-w-0">
                    <h2 class="text-sm font-semibold text-zinc-900 dark:text-slate-100 sm:text-base">Berita Terbaru</h2>
                    <p class="mt-0.5 text-[10px] text-zinc-500 dark:text-slate-400 sm:text-sm">Konten terbaru yang dipublikasi.</p>
                </div>
            </div>
            <div class="mt-2.5 divide-y divide-zinc-100 dark:divide-slate-800 sm:mt-4">
                @forelse($latestNews as $news)
                    <div class="flex min-w-0 items-start gap-2.5 py-2.5 first:pt-0 last:pb-0 sm:gap-3 sm:py-3">
                        @if(!empty($news['image']))
                            <img src="{{ $news['image'] }}" alt="{{ $news['title'] }}" class="h-8 w-8 shrink-0 rounded-lg object-cover ring-1 ring-zinc-200 dark:ring-slate-700 sm:h-9 sm:w-9">
                        @else
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-zinc-100 text-zinc-500 ring-1 ring-zinc-200 dark:bg-slate-800 dark:text-slate-300 dark:ring-slate-700 sm:h-9 sm:w-9">
                                <svg viewBox="0 0 24 24" class="h-3.5 w-3.5 sm:h-4 sm:w-4" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
                            </div>
                        @endif
                        <div class="min-w-0 flex-1 overflow-hidden">
                            <p class="truncate text-[11px] font-medium text-zinc-900 dark:text-slate-100 sm:text-sm">{{ $news['title'] }}</p>
                            <div class="mt-1 flex min-w-0 flex-wrap items-center gap-1.5 text-[9px] text-zinc-500 dark:text-slate-400 sm:text-xs">
                                <span class="truncate">{{ $news['date'] }}</span>
                                <span class="inline-flex h-1 w-1 rounded-full bg-zinc-400 dark:bg-slate-500"></span>
                                <span class="truncate">{{ $news['type'] ?? 'Dipublikasi' }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-3 text-[11px] text-zinc-500 dark:text-slate-400 sm:text-sm">
                        Belum ada berita yang dipublikasikan.
                    </div>
                @endforelse
            </div>
        </section>
    </div>

    {{-- ===== Absensi ===== --}}
    <section class="rounded-xl border border-zinc-200 bg-white p-3 dark:border-slate-800 dark:bg-slate-900/90 sm:p-5">
        <div class="flex items-center justify-between gap-2">
            <div>
                <h2 class="text-sm font-semibold text-zinc-900 dark:text-slate-100 sm:text-base">Absensi</h2>
                <p class="mt-0.5 text-[10px] text-zinc-500 dark:text-slate-400 sm:text-sm">Rekap aktivitas petugas dan kehadiran terbaru.</p>
            </div>
            <a href="{{ route('admin.absensi') }}" class="inline-flex items-center rounded-md border border-zinc-200 px-2 py-1 text-[9px] font-semibold text-zinc-700 transition hover:bg-zinc-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800 sm:text-[10px]">Lihat semua</a>
        </div>

        <div class="mt-3 overflow-hidden rounded-lg border border-zinc-200 dark:border-slate-800 sm:mt-4">
            <div class="overflow-x-auto">
                <table class="min-w-[620px] w-full text-left text-[10px] sm:min-w-full sm:text-sm">
                    <thead class="bg-zinc-50 dark:bg-slate-800/60">
                        <tr>
                            <th class="px-2 py-2 text-[9px] font-semibold uppercase tracking-[0.12em] text-zinc-500 dark:text-slate-400 sm:px-3 sm:text-[10px]">No</th>
                            <th class="px-2 py-2 text-[9px] font-semibold uppercase tracking-[0.12em] text-zinc-500 dark:text-slate-400 sm:px-3 sm:text-[10px]">Sub Sangga</th>
                            <th class="px-2 py-2 text-[9px] font-semibold uppercase tracking-[0.12em] text-zinc-500 dark:text-slate-400 sm:px-3 sm:text-[10px]">Ambalan</th>
                            <th class="px-2 py-2 text-[9px] font-semibold uppercase tracking-[0.12em] text-zinc-500 dark:text-slate-400 sm:px-3 sm:text-[10px]">Total</th>
                            <th class="px-2 py-2 text-[9px] font-semibold uppercase tracking-[0.12em] text-zinc-500 dark:text-slate-400 sm:px-3 sm:text-[10px]">Bulan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subSanggaTeraktif as $index => $item)
                            <tr class="border-t border-zinc-100 first:border-t-0 dark:border-slate-800">
                                <td class="px-2 py-2 tabular-nums text-zinc-500 dark:text-slate-400 sm:px-3 sm:py-3">{{ $index + 1 }}</td>
                                <td class="px-2 py-2 font-medium text-zinc-900 dark:text-slate-100 sm:px-3 sm:py-3">{{ $item['nama_sub_sangga'] }}</td>
                                <td class="px-2 py-2 text-zinc-700 dark:text-slate-200 sm:px-3 sm:py-3">{{ $item['ambalan'] }}</td>
                                <td class="px-2 py-2 font-semibold tabular-nums text-zinc-900 dark:text-slate-100 sm:px-3 sm:py-3">{{ number_format($item['total_hadir']) }}</td>
                                <td class="px-2 py-2 text-zinc-700 dark:text-slate-200 sm:px-3 sm:py-3">{{ $item['bulan'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-3 py-6 text-center text-[11px] text-zinc-500 dark:text-slate-400 sm:text-sm">Belum ada data absensi sub sangga.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection