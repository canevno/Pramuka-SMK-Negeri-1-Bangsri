@extends('admin.layouts.app')
@section('title', 'Kelola Absensi')
@section('page-heading', 'Kelola Absensi')
@section('page-description', 'Pantau kehadiran peserta, verifikasi petugas, dan ringkas data mingguan/bulanan/tahunan.')

@section('content')
<div class="space-y-6">
    <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="grid gap-5 lg:grid-cols-4">
            <div class="rounded-[1.75rem] border border-slate-200 bg-slate-50 p-5">
                <p class="text-xs uppercase tracking-[0.18em] text-slate-500">Total Absensi</p>
                <p class="mt-4 text-3xl font-semibold text-slate-950">{{ number_format($totalCount) }}</p>
            </div>
            <div class="rounded-[1.75rem] border border-slate-200 bg-slate-50 p-5">
                <p class="text-xs uppercase tracking-[0.18em] text-slate-500">Minggu ini</p>
                <p class="mt-4 text-3xl font-semibold text-slate-950">{{ number_format($weeklyCount) }}</p>
                <p class="mt-2 text-sm text-slate-500">{{ $currentWeekLabel }}</p>
            </div>
            <div class="rounded-[1.75rem] border border-slate-200 bg-slate-50 p-5">
                <p class="text-xs uppercase tracking-[0.18em] text-slate-500">Bulan ini</p>
                <p class="mt-4 text-3xl font-semibold text-slate-950">{{ number_format($monthlyCount) }}</p>
                <p class="mt-2 text-sm text-slate-500">{{ $currentMonthKey }}</p>
            </div>
            <div class="rounded-[1.75rem] border border-slate-200 bg-slate-50 p-5">
                <p class="text-xs uppercase tracking-[0.18em] text-slate-500">Tahun ini</p>
                <p class="mt-4 text-3xl font-semibold text-slate-950">{{ number_format($yearlyCount) }}</p>
                <p class="mt-2 text-sm text-slate-500">{{ $currentYear }}</p>
            </div>
        </div>
    </section>

    <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-slate-950">Rekam Absensi Terbaru</h2>
                <p class="mt-1 text-sm text-slate-500">10 entri terakhir dari database.</p>
            </div>
            <!-- filter removed per request -->
        </div>

        <div class="mt-6 overflow-hidden rounded-[1.75rem] border border-slate-200 bg-white">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm text-slate-700">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">No</th>
                            <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Sangga</th>
                            <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Ambalan</th>
                            <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Petugas</th>
                            <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Tanggal</th>
                            <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Minggu-ke</th>
                            <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse($recapRecords ?? [] as $index => $r)
                            <tr>
                                <td class="px-4 py-4">{{ $index + 1 }}</td>
                                <td class="px-4 py-4">{{ $r['sangga'] ?? $r['kelas'] }}</td>
                                <td class="px-4 py-4">{{ $r['ambalan'] }}</td>
                                <td class="px-4 py-4">{{ $r['petugas'] }}</td>
                                <td class="px-4 py-4">{{ $r['record_date'] }}</td>
                                <td class="px-4 py-4">{{ $r['minggu_ke'] }}</td>
                                <td class="px-4 py-4">
                                    <a href="{{ route('admin.absensi.detail', [
                                        'record_date' => $r['record_date'],
                                        'participant_kelas' => $r['kelas'],
                                        'participant_ambalan' => $r['ambalan'],
                                        'petugas_name' => $r['petugas'],
                                    ]) }}" class="text-emerald-600 hover:underline">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-sm text-slate-500">Belum ada rekap absensi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-slate-950">Daftar Petugas Absensi</h2>
                <p class="mt-1 text-sm text-slate-500">Ringkasan petugas berdasarkan rekam absensi.</p>
            </div>
            <div class="inline-flex rounded-2xl bg-slate-50 px-4 py-2 text-sm font-medium text-slate-600">
                Aktif = dalam 14 hari terakhir
            </div>
        </div>

        <div class="mt-6 overflow-hidden rounded-[1.75rem] border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm text-slate-700">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Nama Petugas</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">NTA</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Kelas Petugas</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Keaktifan</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Terakhir Melakukan</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Jumlah Rekam</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($petugasSummary as $petugas)
                        <tr>
                            <td class="px-4 py-4">{{ $petugas['name'] }}</td>
                            <td class="px-4 py-4">{{ $petugas['nta'] }}</td>
                            <td class="px-4 py-4">{{ $petugas['kelas'] }}</td>
                            <td class="px-4 py-4">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $petugas['status'] === 'Aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ $petugas['status'] }}
                                </span>
                            </td>
                            <td class="px-4 py-4">{{ $petugas['last_seen'] }}</td>
                            <td class="px-4 py-4">{{ $petugas['total_records'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-sm text-slate-500">Belum ada data petugas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
