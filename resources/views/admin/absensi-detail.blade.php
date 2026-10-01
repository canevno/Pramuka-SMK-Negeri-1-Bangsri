@extends('admin.layouts.app')

@section('title', 'Detail Absensi')
@section('page-heading', 'Detail Absensi')
@section('page-description', 'Rincian daftar hadir peserta pada tanggal tertentu.')

@section('content')
<div class="space-y-6">
    <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-900/80">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-slate-950 dark:text-white">Detail Absensi</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">{{ $recordDate }} • {{ $participantKelas }} • {{ $participantAmbalan }} • Petugas: {{ $petugasName }}</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.absensi.export.excel', request()->query()) }}" class="inline-flex h-8 items-center justify-center rounded-lg border border-slate-300 bg-white px-2.5 text-[10px] font-medium leading-none text-slate-700 transition hover:bg-slate-50">Export Excel</a>
                <a href="{{ route('admin.absensi') }}" class="inline-flex h-8 items-center justify-center rounded-lg border border-slate-300 bg-white px-2.5 text-[10px] font-medium leading-none text-slate-700 transition hover:bg-slate-50">Kembali</a>
            </div>
        </div>

        <div class="mt-6 overflow-hidden rounded-[1.75rem] border border-slate-200 dark:border-slate-700">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm text-slate-700 dark:divide-slate-700 dark:text-slate-200">
                <thead class="bg-slate-50 dark:bg-slate-800/80">
                    <tr>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500 dark:text-slate-300">Nama Lengkap</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500 dark:text-slate-300">Kelas Asal</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500 dark:text-slate-300">Ambalan</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500 dark:text-slate-300">Sangga</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500 dark:text-slate-300">Keterangan</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500 dark:text-slate-300">Iuran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-700 dark:bg-slate-900/60">
                    @forelse($records as $record)
                        <tr>
                            <td class="px-4 py-4 text-slate-700 dark:text-slate-100">{{ $record->participant_name }}</td>
                            <td class="px-4 py-4 text-slate-700 dark:text-slate-100">{{ $record->participant_kelas }}</td>
                            <td class="px-4 py-4 text-slate-700 dark:text-slate-100">{{ $record->participant_ambalan }}</td>
                            <td class="px-4 py-4 text-slate-700 dark:text-slate-100">
                                @php
                                    $sanggaLabel = trim((string) ($record->participant_sangga ?? ''));
                                    if ($sanggaLabel === '' || preg_match('/^\d+$/', $sanggaLabel)) {
                                        $sanggaLabel = trim((string) ($record->participant_ambalan ?? '')) . ' ' . $sanggaLabel;
                                    }
                                @endphp
                                {{ $sanggaLabel !== '' ? $sanggaLabel : '-' }}
                            </td>
                            <td class="px-4 py-4">
                                <span class="inline-flex h-8 min-w-[82px] items-center justify-center rounded-lg border border-slate-300 bg-white px-2.5 text-[10px] font-medium leading-none text-slate-700 shadow-sm">
                                    {{ $record->status }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-slate-700 dark:text-slate-100">
                                @php
                                    $amount = (int) ($record->iuran_amount ?? 0);
                                    $iuranLabel = $amount > 0 ? 'Rp ' . number_format($amount, 0, ',', '.') : 'Belum bayar';
                                @endphp
                                {{ $iuranLabel }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-sm text-slate-500 dark:text-slate-300">Belum ada data pada detail absensi ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
