@extends('admin.layouts.app')
@section('title', 'Dashboard Admin')
@section('page-heading', 'Dashboard')
@section('page-description', 'Selamat datang kembali, Admin. Panel ini dirancang untuk tata kelola sederhana, profesional, dan fokus.')

@section('content')
<div class="space-y-3 sm:space-y-4">

    {{-- ===== Header ===== --}}
    <div class="flex flex-col gap-2.5 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-xl font-semibold tracking-tight text-zinc-900 dark:text-slate-100 sm:text-2xl">Selamat datang kembali, Admin!</h1>
            <p class="mt-1 text-xs text-zinc-500 dark:text-slate-400 sm:text-sm">Kelola anggota, berita, galeri, dan pendaftaran dengan tampilan yang bersih dan profesional.</p>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" class="inline-flex items-center gap-1.5 rounded-lg border border-zinc-200 bg-white px-2.5 py-1.5 text-[11px] font-medium text-zinc-700 transition hover:border-zinc-300 hover:bg-zinc-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:border-slate-600 dark:hover:bg-slate-800 sm:gap-2 sm:px-3.5 sm:py-2 sm:text-sm">
                <svg viewBox="0 0 24 24" class="h-3.5 w-3.5 sm:h-4 sm:w-4" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                Export
            </button>
            <button type="button" class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-600 px-2.5 py-1.5 text-[11px] font-medium text-white transition hover:bg-emerald-700 dark:bg-emerald-500 dark:hover:bg-emerald-400 sm:gap-2 sm:px-3.5 sm:py-2 sm:text-sm">
                <svg viewBox="0 0 24 24" class="h-3.5 w-3.5 sm:h-4 sm:w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
                Buat Baru
            </button>
        </div>
    </div>

    {{-- ===== Chart + Aktivitas ===== --}}
    <div class="grid gap-3 xl:grid-cols-[1.6fr_1fr]">
        <section class="rounded-xl border border-zinc-200 bg-white p-3 shadow-sm dark:border-slate-800 dark:bg-slate-900/90 dark:shadow-slate-950/30 sm:p-5">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-sm font-semibold text-zinc-900 dark:text-slate-100 sm:text-base">Statistik Pengunjung</h2>
                    <div class="mt-1.5 flex items-center gap-3 text-[10px] text-zinc-500 dark:text-slate-400 sm:gap-4 sm:text-xs">
                        <span class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-emerald-600"></span>Minggu ini</span>
                        <span class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-zinc-400"></span>Minggu lalu</span>
                    </div>
                </div>
                <select class="w-full rounded-lg border border-zinc-200 bg-white px-2.5 py-1.5 text-[11px] text-zinc-600 outline-none transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200 sm:w-auto sm:px-3 sm:text-sm">
                    <option>7 Hari Terakhir</option>
                    <option>30 Hari Terakhir</option>
                    <option>90 Hari Terakhir</option>
                </select>
            </div>

            @php
                $chartValues = collect($visitorStats)->pluck('count')->all();
                $chartMax = max($chartValues ?: [0]);
                $chartMax = $chartMax > 0 ? $chartMax : 1;
                $points = [];

                foreach ($chartValues as $index => $value) {
                    $x = count($chartValues) > 1 ? ($index / (count($chartValues) - 1)) * 100 : 50;
                    $y = 55 - (($value / $chartMax) * 42);
                    $points[] = ['x' => $x, 'y' => $y];
                }

                $linePoints = collect($points)->map(fn ($point) => $point['x'] . ',' . $point['y'])->implode(' ');
                $areaPoints = collect($points)->map(fn ($point) => $point['x'] . ',' . $point['y'])->implode(' ');
                $areaPoints .= ' 100,55 0,55';
            @endphp

            <div class="mt-4 flex gap-2 sm:mt-5 sm:gap-3">
                <div class="flex h-32 flex-col justify-between text-right text-[9px] leading-none text-zinc-400 sm:h-44 sm:text-[10px]">
                    @for ($level = 4; $level >= 0; $level--)
                        <span>{{ (int) round(($chartMax / 4) * $level) }}</span>
                    @endfor
                </div>
                <div class="flex-1 min-w-0">
                    <svg viewBox="0 0 100 55" preserveAspectRatio="none" class="h-32 w-full sm:h-44">
                        <defs>
                            <pattern id="hatch" width="6" height="6" patternUnits="userSpaceOnUse" patternTransform="rotate(45)">
                                <line x1="0" y1="0" x2="0" y2="6" stroke="#dbeafe" stroke-width="1"/>
                            </pattern>
                        </defs>
                        <polygon points="{{ $areaPoints }}" fill="url(#hatch)" stroke="none"/>
                        <polyline points="{{ $linePoints }}" fill="none" stroke="#16a34a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <div class="mt-2 flex justify-between text-[9px] text-zinc-400 sm:text-[10px]">
                        @foreach ($visitorStats as $stat)
                            <span>{{ $stat['label'] }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="rounded-xl border border-zinc-200 bg-white p-3 shadow-sm dark:border-slate-800 dark:bg-slate-900/90 dark:shadow-slate-950/30 sm:p-3">
            <div class="mb-2.5 flex items-center justify-between gap-2 sm:mb-3">
                <h2 class="text-sm font-semibold text-zinc-900 dark:text-slate-100 sm:text-base">Petugas Teraktif</h2>
                <a href="{{ route('admin.absensi') }}" class="inline-flex items-center rounded-[6px] border border-emerald-200 bg-emerald-50 px-2 py-1 text-[9px] font-semibold text-emerald-700 transition hover:bg-emerald-100 dark:border-emerald-900/60 dark:bg-emerald-950/30 dark:text-emerald-300 sm:text-[10px]">
                    Lihat semua
                </a>
            </div>
            <div class="space-y-1.5">
                @forelse($petugasTeraktif as $index => $petugas)
                    <div class="flex items-center justify-between gap-2 rounded-lg bg-[#f5f5f5] px-2 py-1.5 text-zinc-900 dark:bg-[#f5f5f5] dark:text-zinc-900 sm:px-2.5 sm:py-2">
                        <div class="flex min-w-0 flex-1 items-center gap-2 sm:gap-2.5">
                            <div class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-zinc-200 text-[9px] font-semibold text-zinc-700 sm:text-[10px]">
                                {{ $index + 1 }}
                            </div>
                            @if(!empty($petugas['photo_url']))
                                <img src="{{ $petugas['photo_url'] }}" alt="{{ $petugas['name'] }}" class="h-7 w-7 shrink-0 rounded-full object-cover ring-2 ring-white shadow-sm sm:h-8 sm:w-8">
                            @else
                                <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-zinc-300 to-zinc-500 text-[10px] font-semibold text-zinc-800 shadow-inner sm:h-8 sm:w-8 sm:text-[11px]">
                                    {{ $petugas['initial'] }}
                                </div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-[11px] font-medium text-zinc-900 sm:text-[13px]">{{ $petugas['name'] }}</p>
                            </div>
                        </div>
                        <div class="ml-auto text-right">
                            <span class="text-[11px] font-semibold text-emerald-600 sm:text-[12px]">{{ number_format($petugas['total_records']) }}</span>
                        </div>
                    </div>
                @empty
                    <div class="rounded-lg bg-[#f5f5f5] p-2.5 text-[11px] text-zinc-600 sm:text-xs">
                        Belum ada data petugas aktif.
                    </div>
                @endforelse
            </div>
        </section>
    </div>

    {{-- ===== Tabel Pendaftaran + Berita ===== --}}
    <div class="grid gap-3 xl:grid-cols-[1.3fr_0.95fr]">
        <section class="rounded-xl border border-zinc-200 bg-white p-3 shadow-sm dark:border-slate-800 dark:bg-slate-900/90 dark:shadow-slate-950/30 sm:p-5">
            <div class="flex items-center justify-between gap-2 sm:items-center">
                <h2 class="text-sm font-semibold text-zinc-900 dark:text-slate-100 sm:text-base">Pendaftaran Terbaru</h2>
                <span class="rounded-full border border-zinc-200 bg-zinc-50 px-2 py-0.5 text-[9px] font-medium text-zinc-600 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-300 sm:text-[10px]">Semua</span>
            </div>

            <div class="mt-4 overflow-hidden rounded-xl border border-zinc-200 dark:border-slate-700">
                <div class="hidden sm:block">
                    <div class="max-h-[21rem] overflow-y-auto overflow-x-auto overscroll-x-contain scrollbar-thin scrollbar-thumb-zinc-300 scrollbar-track-transparent dark:scrollbar-thumb-slate-600">
                        <table class="min-w-[560px] w-full text-left text-[11px] sm:text-sm">
                            <thead class="bg-zinc-50 dark:bg-slate-800/80">
                                <tr>
                                    <th class="px-3 py-3 text-[9px] font-semibold uppercase tracking-[0.12em] text-zinc-500 dark:text-slate-400 sm:text-[10px]">Nama</th>
                                    <th class="px-3 py-3 text-[9px] font-semibold uppercase tracking-[0.12em] text-zinc-500 dark:text-slate-400 sm:text-[10px]">Kelas</th>
                                    <th class="px-3 py-3 text-[9px] font-semibold uppercase tracking-[0.12em] text-zinc-500 dark:text-slate-400 sm:text-[10px]">Jenis</th>
                                    <th class="px-3 py-3 text-[9px] font-semibold uppercase tracking-[0.12em] text-zinc-500 dark:text-slate-400 sm:text-[10px]">Tanggal</th>
                                    <th class="px-3 py-3 text-[9px] font-semibold uppercase tracking-[0.12em] text-zinc-500 dark:text-slate-400 sm:text-[10px]">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestRegistrations as $item)
                                    @php
                                        $statusClass = match (strtolower(trim($item['status']))) {
                                            'disetujui' => 'bg-emerald-100 text-emerald-700 ring-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-300 dark:ring-emerald-500/20',
                                            'pending' => 'bg-amber-100 text-amber-700 ring-amber-200 dark:bg-amber-500/10 dark:text-amber-300 dark:ring-amber-500/20',
                                            'ditolak' => 'bg-red-100 text-red-700 ring-red-200 dark:bg-red-500/10 dark:text-red-300 dark:ring-red-500/20',
                                            default => 'bg-zinc-100 text-zinc-700 ring-zinc-200 dark:bg-slate-700 dark:text-slate-200 dark:ring-slate-600',
                                        };
                                    @endphp
                                    <tr class="border-t border-zinc-200 last:border-b-0 dark:border-slate-700">
                                        <td class="px-3 py-3">
                                            <div class="flex flex-col">
                                                <span class="font-semibold text-zinc-900 dark:text-slate-100">{{ $item['name'] }}</span>
                                                <span class="mt-1 text-[10px] text-zinc-500 dark:text-slate-400">{{ $item['type'] }}</span>
                                            </div>
                                        </td>
                                        <td class="px-3 py-3 text-zinc-700 dark:text-slate-200">{{ $item['kelas'] }}</td>
                                        <td class="px-3 py-3 text-zinc-700 dark:text-slate-200">{{ $item['type'] }}</td>
                                        <td class="px-3 py-3 text-zinc-700 dark:text-slate-200">{{ $item['date'] }}</td>
                                        <td class="px-3 py-3">
                                            <span class="inline-flex rounded-full px-2.5 py-1 text-[10px] font-semibold ring-1 {{ $statusClass }}">
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
                                'disetujui' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300',
                                'pending' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-300',
                                'ditolak' => 'bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-300',
                                default => 'bg-zinc-100 text-zinc-700 dark:bg-slate-700 dark:text-slate-200',
                            };
                        @endphp
                        <div class="mb-2 rounded-lg border border-zinc-200 bg-zinc-50 p-2.5 last:mb-0 dark:border-slate-700 dark:bg-slate-800/80">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-[11px] font-semibold text-zinc-900 dark:text-slate-100">{{ $item['name'] }}</p>
                                    <p class="mt-0.5 text-[10px] text-zinc-500 dark:text-slate-400">{{ $item['type'] }}</p>
                                </div>
                                <span class="inline-flex rounded-full px-2 py-0.5 text-[9px] font-semibold {{ $statusClass }}">
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

        <section class="min-w-0 rounded-xl border border-zinc-200 bg-white p-3 shadow-sm dark:border-slate-800 dark:bg-slate-900/90 dark:shadow-slate-950/30 sm:p-5">
            <div class="flex items-center justify-between gap-2">
                <div class="min-w-0">
                    <h2 class="text-sm font-semibold text-zinc-900 dark:text-slate-100 sm:text-base">Berita Terbaru</h2>
                    <p class="mt-0.5 text-[10px] text-zinc-500 dark:text-slate-400 sm:text-sm">Konten terbaru yang dipublikasi.</p>
                </div>
            </div>
            <div class="mt-3 space-y-2 sm:mt-4">
                @forelse($latestNews as $news)
                    <div class="flex min-w-0 items-start gap-2.5 rounded-lg bg-zinc-50 p-2.5 dark:bg-slate-800/80 sm:gap-3 sm:p-3">
                        @if(!empty($news['image']))
                            <img src="{{ $news['image'] }}" alt="{{ $news['title'] }}" class="h-8 w-8 shrink-0 rounded-lg object-cover ring-1 ring-zinc-200 dark:ring-slate-700 sm:h-9 sm:w-9">
                        @else
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-300 sm:h-9 sm:w-9">
                                <svg viewBox="0 0 24 24" class="h-3.5 w-3.5 sm:h-4 sm:w-4" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
                            </div>
                        @endif
                        <div class="min-w-0 flex-1 overflow-hidden">
                            <p class="truncate text-[11px] font-medium text-zinc-900 dark:text-slate-100 sm:text-sm">{{ $news['title'] }}</p>
                            <div class="mt-1 flex min-w-0 flex-wrap items-center gap-1.5 text-[9px] text-zinc-500 dark:text-slate-400 sm:text-xs">
                                <span class="truncate">{{ $news['date'] }}</span>
                                <span class="inline-flex h-1.5 w-1.5 rounded-full bg-emerald-600"></span>
                                <span class="truncate">{{ $news['type'] ?? 'Dipublikasi' }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-lg bg-zinc-50 p-3 text-[11px] text-zinc-600 dark:bg-slate-800/80 dark:text-slate-300 sm:text-sm">
                        Belum ada berita yang dipublikasikan.
                    </div>
                @endforelse
            </div>
        </section>
    </div>

    <section class="rounded-xl border border-zinc-200 bg-white p-3 shadow-sm dark:border-slate-800 dark:bg-slate-900/90 dark:shadow-slate-950/30 sm:p-5">
        <div class="flex items-center justify-between gap-2">
            <div>
                <h2 class="text-sm font-semibold text-zinc-900 dark:text-slate-100 sm:text-base">Absensi</h2>
                <p class="mt-0.5 text-[10px] text-zinc-500 dark:text-slate-400 sm:text-sm">Rekap aktivitas petugas dan kehadiran terbaru.</p>
            </div>
            <a href="{{ route('admin.absensi') }}" class="inline-flex items-center rounded-[6px] border border-emerald-200 bg-emerald-50 px-2 py-1 text-[9px] font-semibold text-emerald-700 transition hover:bg-emerald-100 dark:border-emerald-900/60 dark:bg-emerald-950/30 dark:text-emerald-300 sm:text-[10px]">Lihat semua</a>
        </div>

        <div class="mt-3 overflow-hidden rounded-xl border border-zinc-200 dark:border-slate-700 sm:mt-4">
            <div class="overflow-x-auto">
                <table class="min-w-[620px] text-left text-[10px] sm:min-w-full sm:text-sm">
                    <thead class="bg-zinc-50 dark:bg-slate-800/80">
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
                            <tr class="border-t border-zinc-200 dark:border-slate-700">
                                <td class="px-2 py-2 text-zinc-700 dark:text-slate-200 sm:px-3 sm:py-3">{{ $index + 1 }}</td>
                                <td class="px-2 py-2 font-medium text-zinc-900 dark:text-slate-100 sm:px-3 sm:py-3">{{ $item['nama_sub_sangga'] }}</td>
                                <td class="px-2 py-2 text-zinc-700 dark:text-slate-200 sm:px-3 sm:py-3">{{ $item['ambalan'] }}</td>
                                <td class="px-2 py-2 text-zinc-700 dark:text-slate-200 sm:px-3 sm:py-3">{{ number_format($item['total_hadir']) }}</td>
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