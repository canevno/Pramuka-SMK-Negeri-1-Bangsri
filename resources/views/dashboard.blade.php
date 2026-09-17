@extends('admin.layouts.app')
@section('title', 'Dashboard Admin')
@section('page-heading', 'Dashboard')
@section('page-description', 'Selamat datang kembali, Admin. Panel ini dirancang untuk tata kelola sederhana, profesional, dan fokus.')

@section('content')
<div class="space-y-4">

    {{-- ===== Header ===== --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-zinc-900 dark:text-slate-100">Selamat datang kembali, Admin!</h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-slate-400">Kelola anggota, berita, galeri, dan pendaftaran dengan tampilan yang bersih dan profesional.</p>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" class="inline-flex items-center gap-2 rounded-lg border border-zinc-200 bg-white px-3.5 py-2 text-sm font-medium text-zinc-700 transition hover:border-zinc-300 hover:bg-zinc-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:border-slate-600 dark:hover:bg-slate-800">
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                Export
            </button>
            <button type="button" class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-3.5 py-2 text-sm font-medium text-white transition hover:bg-emerald-700 dark:bg-emerald-500 dark:hover:bg-emerald-400">
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
                Buat Baru
            </button>
        </div>
    </div>



    {{-- ===== Chart + Aktivitas ===== --}}
    <div class="grid gap-3 xl:grid-cols-[1.6fr_1fr]">
        <section class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900/90 dark:shadow-slate-950/30">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-base font-semibold text-zinc-900 dark:text-slate-100">Statistik Pengunjung</h2>
                    <div class="mt-1.5 flex items-center gap-4 text-xs text-zinc-500 dark:text-slate-400">
                        <span class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-emerald-600"></span>Minggu ini</span>
                        <span class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-zinc-400"></span>Minggu lalu</span>
                    </div>
                </div>
                <select class="rounded-lg border border-zinc-200 bg-white px-3 py-1.5 text-sm text-zinc-600 outline-none transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200">
                    <option>7 Hari Terakhir</option>
                    <option>30 Hari Terakhir</option>
                    <option>90 Hari Terakhir</option>
                </select>
            </div>

            <div class="mt-5 flex gap-3">
                <div class="flex h-44 flex-col justify-between text-right text-[10px] leading-none text-zinc-400">
                    <span>400</span><span>300</span><span>200</span><span>100</span><span>0</span>
                </div>
                <div class="flex-1">
                    <svg viewBox="0 0 100 55" preserveAspectRatio="none" class="h-44 w-full">
                        <defs>
                            <pattern id="hatch" width="6" height="6" patternUnits="userSpaceOnUse" patternTransform="rotate(45)">
                                <line x1="0" y1="0" x2="0" y2="6" stroke="#dbeafe" stroke-width="1"/>
                            </pattern>
                        </defs>
                        {{-- area hatch biru muda di bawah garis minggu lalu --}}
                        <path d="M0,38 L16.6,34 L33.3,24 L50,28 L66.6,18 L83.3,22 L100,12 L100,55 L0,55 Z" fill="url(#hatch)" stroke="none"/>
                        {{-- garis solid abu-abu: minggu lalu --}}
                        <path d="M0,38 L16.6,34 L33.3,24 L50,28 L66.6,18 L83.3,22 L100,12" fill="none" stroke="#a1a1aa" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        {{-- garis putus-putus hijau: minggu ini --}}
                        <path d="M0,44 L16.6,40 L33.3,42 L50,30 L66.6,10 L83.3,26 L100,20" fill="none" stroke="#16a34a" stroke-width="1.75" stroke-dasharray="5 4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <div class="mt-2 flex justify-between text-[10px] text-zinc-400">
                        <span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span><span>Min</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="rounded-[1.1rem] border border-zinc-200 bg-white p-3 shadow-sm dark:border-slate-800 dark:bg-slate-900/90 dark:shadow-slate-950/30">
            <div class="mb-3 flex items-center justify-between gap-2">
                <h2 class="text-base font-semibold text-zinc-900 dark:text-slate-100">Petugas Teraktif</h2>
                <a href="{{ route('admin.absensi') }}" class="inline-flex items-center rounded-[6px] border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-[10px] font-semibold text-emerald-700 transition hover:bg-emerald-100 dark:border-emerald-900/60 dark:bg-emerald-950/30 dark:text-emerald-300">
                    Lihat semua
                </a>
            </div>
            <div class="space-y-1.5">
                @forelse($petugasTeraktif as $index => $petugas)
                    <div class="flex items-center justify-between gap-2 rounded-lg bg-[#f5f5f5] px-2.5 py-2 text-zinc-900 dark:bg-[#f5f5f5] dark:text-zinc-900">
                        <div class="flex items-center gap-2.5 min-w-0 flex-1">
                            <div class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-zinc-200 text-[10px] font-semibold text-zinc-700">
                                {{ $index + 1 }}
                            </div>
                            @if(!empty($petugas['photo_url']))
                                <img src="{{ $petugas['photo_url'] }}" alt="{{ $petugas['name'] }}" class="h-8 w-8 shrink-0 rounded-full object-cover ring-2 ring-white shadow-sm">
                            @else
                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-zinc-300 to-zinc-500 text-[11px] font-semibold text-zinc-800 shadow-inner">
                                    {{ $petugas['initial'] }}
                                </div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-[13px] font-medium text-zinc-900">{{ $petugas['name'] }}</p>
                            </div>
                        </div>
                        <div class="ml-auto text-right">
                            <span class="text-[12px] font-semibold text-emerald-600">{{ number_format($petugas['total_records']) }}</span>
                        </div>
                    </div>
                @empty
                    <div class="rounded-lg bg-[#f5f5f5] p-2.5 text-xs text-zinc-600">
                        Belum ada data petugas aktif.
                    </div>
                @endforelse
            </div>
        </section>
    </div>

    {{-- ===== Tabel Pendaftaran + Berita ===== --}}
    <div class="grid gap-3 xl:grid-cols-[1.3fr_0.95fr]">
        <section class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900/90 dark:shadow-slate-950/30">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-base font-semibold text-zinc-900 dark:text-slate-100">Pendaftaran Terbaru</h2>
                <div class="flex items-center gap-2">
                    <label class="relative block">
                        <svg viewBox="0 0 24 24" class="pointer-events-none absolute left-2.5 top-1/2 h-4 w-4 -translate-y-1/2 text-zinc-400" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                        <input type="search" placeholder="Cari" class="w-36 rounded-lg border border-zinc-200 bg-white py-1.5 pl-8 pr-3 text-sm text-zinc-700 placeholder-zinc-400 outline-none transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200 dark:placeholder-slate-500"/>
                    </label>
                    <button type="button" class="rounded-lg border border-zinc-200 bg-white px-3 py-1.5 text-sm font-medium text-zinc-700 transition hover:border-emerald-300 hover:text-emerald-600 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200 dark:hover:border-emerald-500/50 dark:hover:text-emerald-300">Lihat semua</button>
                </div>
            </div>

            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-zinc-200 dark:border-slate-700">
                            <th class="px-3 pb-2 text-[11px] font-semibold uppercase tracking-[0.12em] text-zinc-400 dark:text-slate-400">Nama Lengkap</th>
                            <th class="px-3 pb-2 text-[11px] font-semibold uppercase tracking-[0.12em] text-zinc-400 dark:text-slate-400">Kelas</th>
                            <th class="px-3 pb-2 text-[11px] font-semibold uppercase tracking-[0.12em] text-zinc-400 dark:text-slate-400">Tanggal</th>
                            <th class="px-3 pb-2 text-[11px] font-semibold uppercase tracking-[0.12em] text-zinc-400 dark:text-slate-400">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach([
                            ['name'=>'Siti Aisyah','kelas'=>'XII - A','date'=>'27 Mei 2025','status'=>'Menunggu'],
                            ['name'=>'Andi Pratama','kelas'=>'XI - B','date'=>'27 Mei 2025','status'=>'Disetujui'],
                            ['name'=>'Rizky Maulana','kelas'=>'X - C','date'=>'26 Mei 2025','status'=>'Menunggu'],
                            ['name'=>'Dewi Lestari','kelas'=>'XI - A','date'=>'26 Mei 2025','status'=>'Ditolak'],
                        ] as $item)
                            <tr class="border-b border-zinc-100 last:border-b-0 dark:border-slate-800">
                                <td class="px-3 py-3">
                                    <span class="font-medium text-zinc-900 dark:text-slate-100">{{ $item['name'] }}</span>
                                </td>
                                <td class="px-3 py-3 text-zinc-600 dark:text-slate-300">{{ $item['kelas'] }}</td>
                                <td class="px-3 py-3 text-zinc-600 dark:text-slate-300">{{ $item['date'] }}</td>
                                <td class="px-3 py-3">
                                    <span class="text-sm font-medium text-zinc-700 dark:text-slate-200">{{ $item['status'] }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <section class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900/90 dark:shadow-slate-950/30">
            <div class="flex items-center justify-between gap-2">
                <div>
                    <h2 class="text-base font-semibold text-zinc-900 dark:text-slate-100">Berita Terbaru</h2>
                    <p class="mt-0.5 text-sm text-zinc-500 dark:text-slate-400">Konten terbaru yang dipublikasi.</p>
                </div>
                <button type="button" class="rounded-lg border border-zinc-200 bg-white px-3 py-1.5 text-sm font-medium text-zinc-700 transition hover:border-emerald-300 hover:text-emerald-600 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-200 dark:hover:border-emerald-500/50 dark:hover:text-emerald-300">Lihat semua</button>
            </div>
            <div class="mt-4 space-y-2">
                @foreach([['title'=>'Perkemahan Sabtu-Minggu Gugus Depan','date'=>'27 Mei 2025'],['title'=>'Pramuka SMKN 1 Bangsri Raih Juara Umum','date'=>'25 Mei 2025'],['title'=>'Latihan Rutin Ambalan Soedirman','date'=>'24 Mei 2025']] as $news)
                    <div class="flex items-start gap-3 rounded-lg bg-zinc-50 p-3 dark:bg-slate-800/80">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-300">
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-medium text-zinc-900 dark:text-slate-100">{{ $news['title'] }}</p>
                            <div class="mt-1 flex items-center gap-1.5 text-xs text-zinc-500 dark:text-slate-400">
                                <span>{{ $news['date'] }}</span>
                                <span class="inline-flex h-1.5 w-1.5 rounded-full bg-emerald-600"></span>
                                <span>Dipublikasi</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>

    <section class="mt-3 rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900/90 dark:shadow-slate-950/30">
        <div class="flex items-center justify-between gap-2">
            <div>
                <h2 class="text-base font-semibold text-zinc-900 dark:text-slate-100">Absensi</h2>
                <p class="mt-0.5 text-sm text-zinc-500 dark:text-slate-400">Rekap aktivitas petugas dan kehadiran terbaru.</p>
            </div>
            <a href="{{ route('admin.absensi') }}" class="inline-flex items-center rounded-[6px] border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-[10px] font-semibold text-emerald-700 transition hover:bg-emerald-100 dark:border-emerald-900/60 dark:bg-emerald-950/30 dark:text-emerald-300">
                Lihat semua
            </a>
        </div>

        <div class="mt-4 overflow-hidden rounded-xl border border-zinc-200 dark:border-slate-700">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-zinc-50 dark:bg-slate-800/80">
                    <tr>
                        <th class="px-3 py-2 text-[10px] font-semibold uppercase tracking-[0.12em] text-zinc-500 dark:text-slate-400">No</th>
                        <th class="px-3 py-2 text-[10px] font-semibold uppercase tracking-[0.12em] text-zinc-500 dark:text-slate-400">Sub Sangga</th>
                        <th class="px-3 py-2 text-[10px] font-semibold uppercase tracking-[0.12em] text-zinc-500 dark:text-slate-400">Ambalan</th>
                        <th class="px-3 py-2 text-[10px] font-semibold uppercase tracking-[0.12em] text-zinc-500 dark:text-slate-400">Total Siswa Hadir</th>
                        <th class="px-3 py-2 text-[10px] font-semibold uppercase tracking-[0.12em] text-zinc-500 dark:text-slate-400">Bulan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subSanggaTeraktif as $index => $item)
                        <tr class="border-t border-zinc-200 dark:border-slate-700">
                            <td class="px-3 py-3 text-zinc-700 dark:text-slate-200">{{ $index + 1 }}</td>
                            <td class="px-3 py-3 font-medium text-zinc-900 dark:text-slate-100">{{ $item['nama_sub_sangga'] }}</td>
                            <td class="px-3 py-3 text-zinc-700 dark:text-slate-200">{{ $item['ambalan'] }}</td>
                            <td class="px-3 py-3 text-zinc-700 dark:text-slate-200">{{ number_format($item['total_hadir']) }}</td>
                            <td class="px-3 py-3 text-zinc-700 dark:text-slate-200">{{ $item['bulan'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-3 py-6 text-center text-sm text-zinc-500 dark:text-slate-400">Belum ada data absensi sub sangga.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection