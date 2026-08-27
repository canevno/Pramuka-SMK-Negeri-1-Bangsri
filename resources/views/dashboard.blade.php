@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6 p-4 md:p-6">
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Overview</p>
                <h1 class="mt-2 text-2xl font-bold text-slate-900 dark:text-slate-100 md:text-3xl">Dashboard Operasional</h1>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Ringkasan aktifitas presensi, pendaftaran, petugas, dan pengguna secara real-time.</p>
            </div>

            <div class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-400">
                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                Live • update {{ ($lastUpdated ?? now())->translatedFormat('d M Y, H:i') }}
            </div>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500 dark:text-slate-400">Total Absensi</p>
                <span class="rounded-full bg-emerald-50 px-2 py-1 text-[10px] font-bold text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">Aktif</span>
            </div>
            <p class="mt-4 text-3xl font-bold text-slate-900 dark:text-slate-100">{{ number_format($attendanceCount ?? 0) }}</p>
            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">Minggu ini: {{ number_format($attendanceThisWeek ?? 0) }}</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500 dark:text-slate-400">Pendaftar</p>
                <span class="rounded-full bg-blue-50 px-2 py-1 text-[10px] font-bold text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">Baru</span>
            </div>
            <p class="mt-4 text-3xl font-bold text-slate-900 dark:text-slate-100">{{ number_format($registrationCount ?? 0) }}</p>
            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">Terverifikasi: {{ number_format($registrationVerified ?? 0) }}</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500 dark:text-slate-400">Petugas</p>
                <span class="rounded-full bg-violet-50 px-2 py-1 text-[10px] font-bold text-violet-600 dark:bg-violet-500/10 dark:text-violet-400">Tim</span>
            </div>
            <p class="mt-4 text-3xl font-bold text-slate-900 dark:text-slate-100">{{ number_format($petugasTotal ?? 0) }}</p>
            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">Aktif: {{ number_format($petugasAktif ?? 0) }} • Nonaktif: {{ number_format($petugasNonaktif ?? 0) }}</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500 dark:text-slate-400">Pengguna</p>
                <span class="rounded-full bg-amber-50 px-2 py-1 text-[10px] font-bold text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">Akun</span>
            </div>
            <p class="mt-4 text-3xl font-bold text-slate-900 dark:text-slate-100">{{ number_format($usersCount ?? 0) }}</p>
            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">Admin: {{ number_format($adminsCount ?? 0) }} • Aktif 7 hari: {{ number_format($activeThisWeek ?? 0) }}</p>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.25fr_0.75fr]">
        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-lg font-bold text-slate-900 dark:text-slate-100">Tren Kehadiran 7 Hari</h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Pergerakan jumlah absensi terakhir.</p>
                </div>
                <a href="{{ route('admin.absensi') }}" class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">Lihat detail</a>
            </div>

            <div class="mt-6 flex h-40 items-end gap-3">
                @foreach($attendanceTrend ?? [] as $item)
                    @php $barHeight = $maxTrendValue > 0 ? ($item['value'] / $maxTrendValue) * 100 : 0; @endphp
                    <div class="flex flex-1 flex-col items-center gap-2">
                        <div class="flex h-28 w-full items-end justify-center">
                            <div class="w-full rounded-t-xl bg-gradient-to-t from-emerald-500 to-emerald-400/80 transition-all duration-300" style="height: {{ max(8, $barHeight) }}%; min-height: 8px;"></div>
                        </div>
                        <span class="text-[10px] font-medium text-slate-500 dark:text-slate-400">{{ $item['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-bold text-slate-900 dark:text-slate-100">Status Kehadiran</h2>
                <span class="text-xs text-slate-500 dark:text-slate-400">{{ number_format($attendanceCount ?? 0) }} total</span>
            </div>

            <div class="mt-5 space-y-4">
                @php $statusOrder = ['Hadir' => ['color' => 'emerald', 'text' => 'Hadir'], 'Izin' => ['color' => 'amber', 'text' => 'Izin'], 'Sakit' => ['color' => 'sky', 'text' => 'Sakit'], 'Alpha' => ['color' => 'rose', 'text' => 'Alpha']]; @endphp
                @foreach($statusOrder as $key => $meta)
                    @php $value = (int) ($attendanceStatus[$key] ?? 0); $percent = $attendanceCount > 0 ? ($value / $attendanceCount) * 100 : 0; $colorClass = $meta['color']; @endphp
                    <div>
                        <div class="mb-1.5 flex items-center justify-between text-xs font-medium text-slate-600 dark:text-slate-300">
                            <span>{{ $meta['text'] }}</span>
                            <span>{{ number_format($value) }}</span>
                        </div>
                        <div class="h-2.5 overflow-hidden rounded-full bg-slate-100 dark:bg-slate-800">
                            <div class="h-full rounded-full
                                @if($colorClass === 'emerald') bg-emerald-500
                                @elseif($colorClass === 'amber') bg-amber-500
                                @elseif($colorClass === 'sky') bg-sky-500
                                @else bg-rose-500 @endif"
                                style="width: {{ min(100, $percent) }}%;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>

    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-amber-600 dark:text-amber-400">Finance</p>
                <h2 class="mt-2 text-lg font-bold text-slate-900 dark:text-slate-100">Grafik Uang Iuran</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Perkembangan pemasukan iuran dalam 7 hari terakhir.</p>
            </div>
            <div class="rounded-xl border border-amber-200 bg-amber-50 px-3 py-2 text-right dark:border-amber-500/20 dark:bg-amber-500/10">
                <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-amber-700 dark:text-amber-300">Total Iuran</p>
                <p class="mt-1 text-xl font-bold text-amber-800 dark:text-amber-200">Rp {{ number_format($iuranTotal ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="mt-6 grid gap-4 md:grid-cols-3">
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-800/50">
                <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-slate-500 dark:text-slate-400">Bulan Ini</p>
                <p class="mt-2 text-2xl font-bold text-slate-900 dark:text-slate-100">Rp {{ number_format($iuranThisMonth ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-800/50">
                <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-slate-500 dark:text-slate-400">Tahun Ini</p>
                <p class="mt-2 text-2xl font-bold text-slate-900 dark:text-slate-100">Rp {{ number_format($iuranThisYear ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-800/50">
                <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-slate-500 dark:text-slate-400">Rata-rata Harian</p>
                <p class="mt-2 text-2xl font-bold text-slate-900 dark:text-slate-100">Rp {{ number_format($iuranAverageDay ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="mt-6 flex h-40 items-end gap-3">
            @foreach($iuranTrend ?? [] as $item)
                @php $barHeight = (($iuranMaxValue ?? 1) > 0) ? (($item['value'] / ($iuranMaxValue ?? 1)) * 100) : 0; @endphp
                <div class="flex flex-1 flex-col items-center gap-2">
                    <div class="flex h-28 w-full items-end justify-center">
                        <div class="w-full rounded-t-xl bg-gradient-to-t from-amber-500 to-yellow-400 transition-all duration-300" style="height: {{ max(8, $barHeight) }}%; min-height: 8px;"></div>
                    </div>
                    <span class="text-[10px] font-medium text-slate-500 dark:text-slate-400">{{ $item['label'] }}</span>
                </div>
            @endforeach
        </div>
    </section>

    <div class="grid gap-6 xl:grid-cols-[0.95fr_1.05fr]">
        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-lg font-bold text-slate-900 dark:text-slate-100">Petugas Aktif</h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Performa tim kehadiran.</p>
                </div>
                <span class="rounded-full bg-slate-100 px-2 py-1 text-[10px] font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-300">{{ number_format($petugasAktif ?? 0) }} online</span>
            </div>

            <div class="mt-5 space-y-3">
                @forelse($petugasList ?? [] as $petugas)
                    <div class="flex items-center justify-between gap-3 rounded-xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-800 dark:bg-slate-800/40">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-violet-100 text-xs font-bold text-violet-700 dark:bg-violet-500/10 dark:text-violet-400">
                                {{ strtoupper(substr(trim($petugas->nama ?? 'P'), 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-900 dark:text-slate-100">{{ $petugas->nama ?? '-' }}</p>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400">{{ $petugas->kelas_petugas ?? '-' }} • {{ $petugas->nta ?? '-' }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center rounded-full px-2 py-1 text-[10px] font-bold {{ $petugas->is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300' }}">
                            {{ $petugas->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                @empty
                    <div class="rounded-xl border border-dashed border-slate-200 bg-slate-50 p-6 text-center text-sm text-slate-500 dark:border-slate-800 dark:bg-slate-800/30 dark:text-slate-400">
                        Belum ada petugas yang terdaftar.
                    </div>
                @endforelse
            </div>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-lg font-bold text-slate-900 dark:text-slate-100">Pendaftaran Terbaru</h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Status calon anggota dan proses verifikasi.</p>
                </div>
                <span class="rounded-full bg-blue-50 px-2 py-1 text-[10px] font-semibold text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">{{ number_format($registrationPending ?? 0) }} pending</span>
            </div>

            <div class="mt-5 space-y-3">
                @forelse($latestRegistrations ?? [] as $registration)
                    <div class="flex items-center justify-between gap-3 rounded-xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-800 dark:bg-slate-800/40">
                        <div>
                            <p class="text-sm font-semibold text-slate-900 dark:text-slate-100">{{ $registration->nama ?? '-' }}</p>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">{{ $registration->kelas ?? '-' }} • {{ $registration->created_at ? $registration->created_at->translatedFormat('d M Y') : '-' }}</p>
                        </div>
                        <span class="inline-flex items-center rounded-full px-2 py-1 text-[10px] font-bold {{ ($registration->status_verifikasi ?? null) ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400' : 'bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400' }}">
                            {{ $registration->status_verifikasi ?? 'Pending' }}
                        </span>
                    </div>
                @empty
                    <div class="rounded-xl border border-dashed border-slate-200 bg-slate-50 p-6 text-center text-sm text-slate-500 dark:border-slate-800 dark:bg-slate-800/30 dark:text-slate-400">
                        Belum ada pendaftaran baru.
                    </div>
                @endforelse
            </div>
        </section>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.1fr_0.9fr]">
        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-lg font-bold text-slate-900 dark:text-slate-100">Aktivitas Terbaru</h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Log presensi dan pencatatan paling baru.</p>
                </div>
                <a href="{{ route('admin.absensi') }}" class="text-xs font-semibold text-slate-600 dark:text-slate-300">Selengkapnya</a>
            </div>

            <div class="mt-5 space-y-3">
                @forelse($latestAttendanceRecords ?? [] as $record)
                    <div class="flex items-start justify-between gap-4 rounded-xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-800 dark:bg-slate-800/40">
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 7 9 18l-5-5"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-900 dark:text-slate-100">{{ $record->participant_name ?? 'Peserta' }}</p>
                                <p class="mt-0.5 text-[11px] text-slate-500 dark:text-slate-400">{{ $record->participant_kelas ?? '-' }} • {{ $record->participant_ambalan ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center rounded-full px-2 py-1 text-[10px] font-bold {{ strtolower($record->status ?? '') === 'hadir' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400' : 'bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400' }}">
                                {{ $record->status ?? 'Alpha' }}
                            </span>
                            <p class="mt-2 text-[11px] text-slate-500 dark:text-slate-400">{{ $record->record_date ? \Carbon\Carbon::parse($record->record_date)->translatedFormat('d M Y') : '-' }}</p>
                        </div>
                    </div>
                @empty
                    <div class="rounded-xl border border-dashed border-slate-200 bg-slate-50 p-6 text-center text-sm text-slate-500 dark:border-slate-800 dark:bg-slate-800/30 dark:text-slate-400">
                        Belum ada rekam absensi baru.
                    </div>
                @endforelse
            </div>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-slate-900 dark:text-slate-100">Pengguna Aktif</h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Tim yang paling sering berinteraksi.</p>
                </div>
            </div>

            <div class="mt-5 space-y-3">
                @forelse($teamMembers ?? [] as $member)
                    <div class="flex items-center justify-between gap-3 rounded-xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-800 dark:bg-slate-800/40">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-200 text-xs font-bold text-slate-700 dark:bg-slate-700 dark:text-slate-200">
                                {{ strtoupper(substr(trim($member->name ?? 'U'), 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-900 dark:text-slate-100">{{ $member->name ?? '-' }}</p>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400">{{ $member->email ?? '-' }}</p>
                            </div>
                        </div>
                        <span class="rounded-full bg-emerald-50 px-2 py-1 text-[10px] font-bold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                            {{ $member->is_admin ? 'Admin' : 'User' }}
                        </span>
                    </div>
                @empty
                    <div class="rounded-xl border border-dashed border-slate-200 bg-slate-50 p-6 text-center text-sm text-slate-500 dark:border-slate-800 dark:bg-slate-800/30 dark:text-slate-400">
                        Belum ada pengguna aktif.
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</div>

<script>
    setTimeout(function () {
        window.location.reload();
    }, 60000);
</script>
@endsection