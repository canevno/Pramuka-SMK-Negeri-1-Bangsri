@extends('admin.layouts.app')

@section('title', 'Detail Absensi')
@section('page-heading', 'Detail Absensi')
@section('page-description', 'Rincian daftar hadir peserta pada tanggal tertentu.')

@section('content')
<div class="space-y-6">
    <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-slate-950">Detail Absensi</h2>
                <p class="mt-1 text-sm text-slate-500">{{ $recordDate }} • {{ $participantKelas }} • {{ $participantAmbalan }} • Petugas: {{ $petugasName }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.absensi.export.excel', request()->query()) }}" class="inline-flex items-center rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-medium text-emerald-700 hover:bg-emerald-100">Export Excel</a>
                <a href="{{ route('admin.absensi.export.pdf', request()->query()) }}" class="inline-flex items-center rounded-xl border border-rose-200 bg-rose-50 px-4 py-2 text-sm font-medium text-rose-700 hover:bg-rose-100">Export PDF</a>
                <a href="{{ route('admin.absensi') }}" class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Kembali</a>
            </div>
        </div>

        <div class="mt-6 overflow-hidden rounded-[1.75rem] border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm text-slate-700">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Nama Lengkap</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Kelas Asal</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Ambalan</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Sangga</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Keterangan</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Iuran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($records as $record)
                        <tr>
                            <td class="px-4 py-4">{{ $record->participant_name }}</td>
                            <td class="px-4 py-4">{{ $record->participant_kelas }}</td>
                            <td class="px-4 py-4">{{ $record->participant_ambalan }}</td>
                            <td class="px-4 py-4">
                                @php
                                    $sanggaLabel = trim((string) ($record->participant_sangga ?? ''));
                                    if ($sanggaLabel === '' || preg_match('/^\d+$/', $sanggaLabel)) {
                                        $sanggaLabel = trim((string) ($record->participant_ambalan ?? '')) . ' ' . $sanggaLabel;
                                    }
                                @endphp
                                {{ $sanggaLabel !== '' ? $sanggaLabel : '-' }}
                            </td>
                            <td class="px-4 py-4">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $record->status === 'Hadir' ? 'bg-emerald-100 text-emerald-700' : ($record->status === 'Izin' ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700') }}">
                                    {{ $record->status }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                @php
                                    $amount = (int) ($record->iuran_amount ?? 0);
                                    $iuranLabel = $amount > 0 ? 'Rp ' . number_format($amount, 0, ',', '.') : 'Belum bayar';
                                @endphp
                                {{ $iuranLabel }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-sm text-slate-500">Belum ada data pada detail absensi ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
