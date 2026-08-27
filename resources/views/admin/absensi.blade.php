@extends('admin.layouts.app')

@section('title', 'Kelola Absensi')
@section('page-heading', 'Kelola Absensi')
@section('page-description', 'Pantau kehadiran peserta, verifikasi petugas, dan ringkas data mingguan/bulanan/tahunan.')

@section('content')
<div class="space-y-6">
    
    <!-- 1. SECTION RINGKASAN STATISTIK -->
    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Total -->
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-5 transition-colors dark:border-slate-700 dark:bg-slate-800/50">
                <p class="text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Total Absensi</p>
                <p class="mt-3 text-3xl font-bold text-slate-900 dark:text-slate-100">{{ number_format($totalCount ?? 0) }}</p>
            </div>
            <!-- Minggu Ini -->
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-5 transition-colors dark:border-slate-700 dark:bg-slate-800/50">
                <p class="text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Minggu Ini</p>
                <p class="mt-3 text-3xl font-bold text-slate-900 dark:text-slate-100">{{ number_format($weeklyCount ?? 0) }}</p>
                <p class="mt-2 text-xs font-medium text-slate-500 dark:text-slate-400">{{ $currentWeekLabel ?? '-' }}</p>
            </div>
            <!-- Bulan Ini -->
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-5 transition-colors dark:border-slate-700 dark:bg-slate-800/50">
                <p class="text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Bulan Ini</p>
                <p class="mt-3 text-3xl font-bold text-slate-900 dark:text-slate-100">{{ number_format($monthlyCount ?? 0) }}</p>
                <p class="mt-2 text-xs font-medium text-slate-500 dark:text-slate-400">{{ $currentMonthKey ?? '-' }}</p>
            </div>
            <!-- Tahun Ini -->
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-5 transition-colors dark:border-slate-700 dark:bg-slate-800/50">
                <p class="text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Tahun Ini</p>
                <p class="mt-3 text-3xl font-bold text-slate-900 dark:text-slate-100">{{ number_format($yearlyCount ?? 0) }}</p>
                <p class="mt-2 text-xs font-medium text-slate-500 dark:text-slate-400">{{ $currentYear ?? '-' }}</p>
            </div>
        </div>
    </section>

    <!-- 2. SECTION REKAM ABSENSI TERBARU -->
    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-lg font-bold text-slate-900 dark:text-slate-100">Rekam Absensi Terbaru</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Ringkasan rekap absensi per tanggal, kelas, dan ambalan.</p>
            </div>
        </div>

        <div class="overflow-hidden rounded-xl border border-slate-200 dark:border-slate-800">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm dark:divide-slate-800">
                    <thead class="bg-slate-50 dark:bg-slate-800/80">
                        <tr>
                            <th class="px-5 py-3.5 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Tanggal</th>
                            <th class="px-5 py-3.5 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Kelas</th>
                            <th class="px-5 py-3.5 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Ambalan</th>
                            <th class="px-5 py-3.5 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Petugas</th>
                            <th class="px-5 py-3.5 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Status</th>
                            <th class="px-5 py-3.5 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-800 dark:bg-slate-900">
                        @forelse($recapRecords ?? [] as $r)
                            <tr class="transition-colors hover:bg-slate-50 dark:hover:bg-slate-800/50">
                                <td class="px-5 py-4 font-medium text-slate-900 dark:text-slate-200">{{ $r['record_date'] }}</td>
                                <td class="px-5 py-4 text-slate-600 dark:text-slate-400">{{ $r['kelas'] }}</td>
                                <td class="px-5 py-4 text-slate-600 dark:text-slate-400">{{ $r['ambalan'] }}</td>
                                <td class="px-5 py-4 text-slate-600 dark:text-slate-400">{{ $r['petugas'] }}</td>
                                <td class="px-5 py-4">
                                    @if(($r['status'] ?? '') === 'Selesai')
                                        <span class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                            <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Selesai
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                                            <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-amber-500"></span> Proses
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <button type="button"
                                            onclick="bukaDetailAbsensi('{{ trim($r['record_date']) }}', '{{ trim($r['kelas']) }}', '{{ trim($r['ambalan']) }}')"
                                            class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-600 transition-colors hover:bg-emerald-100 dark:bg-emerald-500/10 dark:text-emerald-400 dark:hover:bg-emerald-500/20">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Detail
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-8 text-center text-sm text-slate-500 dark:text-slate-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="mb-2 h-8 w-8 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                        Belum ada rekap absensi.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- 3. SECTION REKAM ABSEN BULANAN (POSISI DI ATAS DAFTAR PETUGAS) -->
    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 space-y-6">
        <div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-slate-100">Rekam Absen Bulanan</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Rekapitulasi absensi mingguan per kelas dalam satu bulan.</p>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- AMBALAN PUTRA -->
            <div class="rounded-xl border border-slate-200 bg-slate-50/50 p-4 dark:border-slate-800 dark:bg-slate-800/40">
                <div class="flex items-center justify-between border-b border-slate-200/60 pb-3 dark:border-slate-700/60">
                    <div class="flex items-center gap-2">
                        <span class="inline-block h-2.5 w-2.5 rounded-full bg-blue-500"></span>
                        <h3 class="font-bold text-slate-800 dark:text-slate-100">Ambalan Putra</h3>
                    </div>
                    <span class="text-xs font-semibold text-slate-400 dark:text-slate-400">{{ now()->translatedFormat('F Y') }}</span>
                </div>

                <div class="mt-3 overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-600 dark:text-slate-300">
                        <thead class="bg-slate-100/70 text-[10px] uppercase text-slate-400 dark:bg-slate-800">
                            <tr>
                                <th class="px-3 py-2 rounded-l-lg">Kelas</th>
                                <th class="px-3 py-2 text-center">Jumlah Sesi</th>
                                <th class="px-3 py-2 text-center rounded-r-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse($rekapPutra ?? [] as $row)
                                <tr class="hover:bg-slate-100/50 dark:hover:bg-slate-800/60">
                                    <td class="px-3 py-2.5 font-semibold text-slate-800 dark:text-slate-100">{{ $row->participant_kelas }}</td>
                                    <td class="px-3 py-2.5 text-center">
                                        <span class="rounded-full bg-blue-100/80 px-2.5 py-0.5 text-[10px] font-bold text-blue-600 dark:bg-blue-950/80 dark:text-blue-400">
                                            {{ $row->total_sesi }} Sesi
                                        </span>
                                    </td>
                                    <td class="px-3 py-2.5 text-center">
                                        <button wire:click="openModalBulanan('{{ $row->participant_kelas }}', 'Putra')" class="rounded-lg bg-emerald-50 px-2.5 py-1 text-[11px] font-medium text-emerald-600 hover:bg-emerald-100 dark:bg-emerald-950/40 dark:text-emerald-400 cursor-pointer">
                                            👁 Matriks
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-3 py-4 text-center text-slate-400 dark:text-slate-500">Belum ada rekap Putra bulan ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- AMBALAN PUTRI -->
            <div class="rounded-xl border border-slate-200 bg-slate-50/50 p-4 dark:border-slate-800 dark:bg-slate-800/40">
                <div class="flex items-center justify-between border-b border-slate-200/60 pb-3 dark:border-slate-700/60">
                    <div class="flex items-center gap-2">
                        <span class="inline-block h-2.5 w-2.5 rounded-full bg-pink-500"></span>
                        <h3 class="font-bold text-slate-800 dark:text-slate-100">Ambalan Putri</h3>
                    </div>
                    <span class="text-xs font-semibold text-slate-400 dark:text-slate-400">{{ now()->translatedFormat('F Y') }}</span>
                </div>

                <div class="mt-3 overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-600 dark:text-slate-300">
                        <thead class="bg-slate-100/70 text-[10px] uppercase text-slate-400 dark:bg-slate-800">
                            <tr>
                                <th class="px-3 py-2 rounded-l-lg">Kelas</th>
                                <th class="px-3 py-2 text-center">Jumlah Sesi</th>
                                <th class="px-3 py-2 text-center rounded-r-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse($rekapPutri ?? [] as $row)
                                <tr class="hover:bg-slate-100/50 dark:hover:bg-slate-800/60">
                                    <td class="px-3 py-2.5 font-semibold text-slate-800 dark:text-slate-100">{{ $row->participant_kelas }}</td>
                                    <td class="px-3 py-2.5 text-center">
                                        <span class="rounded-full bg-pink-100/80 px-2.5 py-0.5 text-[10px] font-bold text-pink-600 dark:bg-pink-950/80 dark:text-pink-400">
                                            {{ $row->total_sesi }} Sesi
                                        </span>
                                    </td>
                                    <td class="px-3 py-2.5 text-center">
                                        <button wire:click="openModalBulanan('{{ $row->participant_kelas }}', 'Putri')" class="rounded-lg bg-emerald-50 px-2.5 py-1 text-[11px] font-medium text-emerald-600 hover:bg-emerald-100 dark:bg-emerald-950/40 dark:text-emerald-400 cursor-pointer">
                                            👁 Matriks
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-3 py-4 text-center text-slate-400 dark:text-slate-500">Belum ada rekap Putri bulan ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. SECTION DAFTAR PETUGAS ABSENSI -->
    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-lg font-bold text-slate-900 dark:text-slate-100">Daftar Petugas Absensi</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Ringkasan petugas berdasarkan rekam absensi.</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="hidden sm:inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600 dark:bg-slate-800 dark:text-slate-400">
                    <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Aktif = 14 hari terakhir
                </span>
                <button type="button"
                    onclick="document.getElementById('modalTambahPetugas').classList.remove('hidden')"
                    class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-600 px-4 py-2 text-xs font-semibold text-white shadow-sm transition-colors hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Petugas
                </button>
            </div>
        </div>

        <div class="overflow-hidden rounded-xl border border-slate-200 dark:border-slate-800">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm dark:divide-slate-800">
                <thead class="bg-slate-50 dark:bg-slate-800/80">
                    <tr>
                        <th class="px-5 py-3.5 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Nama Petugas</th>
                        <th class="px-5 py-3.5 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">NTA</th>
                        <th class="px-5 py-3.5 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Kelas</th>
                        <th class="px-5 py-3.5 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Keaktifan</th>
                        <th class="px-5 py-3.5 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Terakhir Melakukan</th>
                        <th class="px-5 py-3.5 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 text-center">Jumlah Rekam</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-800 dark:bg-slate-900">
                    @forelse($petugas ?? $petugasList ?? [] as $item)
                        <tr class="transition-colors hover:bg-slate-50 dark:hover:bg-slate-800/50">
                            <td class="px-5 py-4 font-semibold text-slate-900 dark:text-slate-100">{{ $item->nama }}</td>
                            <td class="px-5 py-4 font-mono text-xs text-slate-500 dark:text-slate-400">{{ $item->nta }}</td>
                            <td class="px-5 py-4 text-slate-600 dark:text-slate-400">{{ $item->kelas_petugas }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <button type="button"
                                        onclick="togglePetugasStatus(this, '{{ $item->id }}')"
                                        data-active="{{ $item->is_active ? '1' : '0' }}"
                                        class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900 {{ $item->is_active ? 'bg-emerald-500' : 'bg-slate-300 dark:bg-slate-700' }}"
                                        role="switch"
                                        aria-checked="{{ $item->is_active ? 'true' : 'false' }}">
                                        <span class="js-switch-thumb pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow-sm ring-0 transition duration-200 ease-in-out {{ $item->is_active ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                    </button>
                                    <span class="js-status-label text-xs font-semibold {{ $item->is_active ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400 dark:text-slate-500' }}">
                                        {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-xs text-slate-500 dark:text-slate-400">
                                {{ $item->terakhir_melakukan ? \Carbon\Carbon::parse($item->terakhir_melakukan)->translatedFormat('d M Y, H:i') : 'Belum Pernah' }}
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="inline-flex items-center justify-center rounded-full bg-slate-100 px-2.5 py-1 text-xs font-bold text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                                    {{ $item->jumlah_rekam ?? $item->rekam_count ?? 0 }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-sm text-slate-500 dark:text-slate-400">
                                Belum ada data petugas terverifikasi di database.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

</div>

<!-- ========================================== -->
<!-- MODAL: Detail Absensi -->
<!-- ========================================== -->
<div id="modalDetailAbsensi" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 p-4 backdrop-blur-sm transition-opacity">
    <div class="w-full max-w-2xl rounded-2xl bg-white shadow-2xl border border-slate-200 flex flex-col max-h-[90vh] dark:bg-slate-900 dark:border-slate-800">
        <!-- Modal Header -->
        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4 dark:border-slate-800">
            <div>
                <h3 class="text-base font-bold text-slate-900 dark:text-slate-100">Rincian Absensi & Iuran</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5" id="mInfoSubheader">Memuat data...</p>
            </div>
            <button type="button" onclick="tutupDetailModal()" class="rounded-lg p-1 text-slate-400 transition-colors hover:bg-slate-100 hover:text-slate-600 dark:hover:bg-slate-800 dark:hover:text-slate-200">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Modal Stats -->
        <div class="grid grid-cols-2 gap-3 px-6 py-4 md:grid-cols-4">
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-700 dark:bg-slate-800/50">
                <p class="text-[11px] font-medium uppercase text-slate-500 dark:text-slate-400">Tanggal</p>
                <p class="mt-1 text-sm font-bold text-slate-900 dark:text-slate-100" id="mTanggal">-</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-700 dark:bg-slate-800/50">
                <p class="text-[11px] font-medium uppercase text-slate-500 dark:text-slate-400">Kelas</p>
                <p class="mt-1 text-sm font-bold text-slate-900 dark:text-slate-100" id="mKelas">-</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-700 dark:bg-slate-800/50">
                <p class="text-[11px] font-medium uppercase text-slate-500 dark:text-slate-400">Ambalan</p>
                <p class="mt-1 text-sm font-bold text-slate-900 dark:text-slate-100" id="mAmbalan">-</p>
            </div>
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-3 dark:border-emerald-800 dark:bg-emerald-900/20">
                <p class="text-[11px] font-medium uppercase text-emerald-700 dark:text-emerald-400">Total Iuran</p>
                <p class="mt-1 text-sm font-extrabold text-emerald-900 dark:text-emerald-300" id="mTotalIuran">Rp 0</p>
            </div>
        </div>

        <!-- Modal Content -->
        <div class="flex-1 overflow-y-auto px-6 pb-4">
            <div id="mLoading" class="py-8 text-center">
                <div class="inline-block h-6 w-6 animate-spin rounded-full border-2 border-emerald-600 border-t-transparent"></div>
                <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">Mengambil data peserta...</p>
            </div>

            <div id="mContent" class="hidden space-y-2">
                <div class="overflow-hidden rounded-xl border border-slate-200 dark:border-slate-800">
                    <table class="min-w-full divide-y divide-slate-200 text-left text-xs dark:divide-slate-800">
                        <thead class="bg-slate-50 text-slate-600 dark:bg-slate-800/80 dark:text-slate-300">
                            <tr>
                                <th class="px-4 py-3 font-semibold">No</th>
                                <th class="px-4 py-3 font-semibold">Nama Peserta</th>
                                <th class="px-4 py-3 font-semibold">Keterangan</th>
                                <th class="px-4 py-3 text-right font-semibold">Uang Iuran</th>
                            </tr>
                        </thead>
                        <tbody id="mTbodyPeserta" class="divide-y divide-slate-200 bg-white dark:divide-slate-800 dark:bg-slate-900 dark:text-slate-300"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="flex items-center justify-end gap-2 border-t border-slate-200 bg-slate-50 px-6 py-4 dark:border-slate-800 dark:bg-slate-800/50">
            @if(isset($absensi) && $absensi->id)
                <a href="{{ route('admin.absensi.exportWord', $absensi->id) }}" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Word
                </a>
            @else
                <a href="#" onclick="exportModalWord()" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Word
                </a>
            @endif

            <a href="{{ route('admin.absensi.export', $absensi->id ?? null) }}" class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-emerald-700">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Excel
            </a>

            <button type="button" onclick="tutupDetailModal()" class="rounded-lg bg-white px-4 py-2 text-sm font-medium text-slate-700 border border-slate-300 transition-colors hover:bg-slate-50 dark:bg-slate-800 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-700">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL: Tambah Petugas -->
<!-- ========================================== -->
<div id="modalTambahPetugas" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 p-4 backdrop-blur-sm">
    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl border border-slate-200 dark:bg-slate-900 dark:border-slate-800">
        <div class="mb-5 flex items-center justify-between">
            <h3 class="text-base font-bold text-slate-900 dark:text-slate-100">Tambah Petugas Absensi</h3>
            <button type="button" onclick="document.getElementById('modalTambahPetugas').classList.add('hidden')" class="rounded-lg p-1 text-slate-400 transition-colors hover:bg-slate-100 hover:text-slate-600 dark:hover:bg-slate-800 dark:hover:text-slate-200">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.petugas.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="mb-1.5 block text-xs font-semibold text-slate-700 dark:text-slate-300">Nama Petugas</label>
                <input type="text" name="nama" required 
                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 transition-colors focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:placeholder-slate-500 dark:focus:border-emerald-500 dark:focus:ring-emerald-500" 
                    placeholder="Contoh: Ahmad Fauzi">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold text-slate-700 dark:text-slate-300">NTA Petugas</label>
                <input type="text" name="nta" required 
                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 transition-colors focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:placeholder-slate-500 dark:focus:border-emerald-500 dark:focus:ring-emerald-500" 
                    placeholder="11.20.03.240409.0001">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold text-slate-700 dark:text-slate-300">Kelas Petugas</label>
                <input type="text" name="kelas_petugas" required 
                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 transition-colors focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:placeholder-slate-500 dark:focus:border-emerald-500 dark:focus:ring-emerald-500" 
                    placeholder="X MPLB 1">
            </div>
            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('modalTambahPetugas').classList.add('hidden')" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition-colors hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                    Batal
                </button>
                <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================== -->
<!-- JAVASCRIPT -->
<!-- ========================================== -->
<script>
var activeDetailParams = { date: '', kelas: '', ambalan: '' };

function bukaDetailAbsensi(tanggal, kelas, ambalan) {
    var cleanTanggal = (tanggal || '').toString().trim();
    var cleanKelas = (kelas || '').toString().trim();
    var cleanAmbalan = (ambalan || '').toString().trim();

    activeDetailParams = { date: cleanTanggal, kelas: cleanKelas, ambalan: cleanAmbalan };

    var modal = document.getElementById('modalDetailAbsensi');
    var loading = document.getElementById('mLoading');
    var content = document.getElementById('mContent');

    document.getElementById('mTanggal').textContent = cleanTanggal;
    document.getElementById('mKelas').textContent = cleanKelas;
    document.getElementById('mAmbalan').textContent = cleanAmbalan;
    document.getElementById('mInfoSubheader').textContent = 'Kelas ' + cleanKelas + ' • ' + cleanAmbalan;

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    loading.classList.remove('hidden');
    content.classList.add('hidden');

    var url = '/admin/absensi/detail-data?date=' + encodeURIComponent(cleanTanggal) + '&kelas=' + encodeURIComponent(cleanKelas) + '&ambalan=' + encodeURIComponent(cleanAmbalan);

    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(function(res) {
        if (!res.ok) throw new Error('HTTP Status: ' + res.status);
        return res.json();
    })
    .then(function(data) {
        loading.classList.add('hidden');
        if (data.success) {
            document.getElementById('mTotalIuran').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(data.total_iuran || 0);
            var tbody = document.getElementById('mTbodyPeserta');
            tbody.innerHTML = '';

            if (data.peserta && data.peserta.length > 0) {
                data.peserta.forEach(function(p, index) {
                    var status = (p.status || '-').toLowerCase();
                    var statusBadge = '<span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-bold text-slate-700 border border-slate-200 dark:text-slate-300 dark:border-slate-700">Alpa</span>';

                    if (status === 'hadir') statusBadge = '<span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-bold text-slate-700 border border-slate-200 dark:text-slate-300 dark:border-slate-700">Hadir</span>';
                    else if (status === 'izin') statusBadge = '<span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-bold text-slate-700 border border-slate-200 dark:text-slate-300 dark:border-slate-700">Izin</span>';
                    else if (status === 'sakit') statusBadge = '<span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-bold text-slate-700 border border-slate-200 dark:text-slate-300 dark:border-slate-700">Sakit</span>';

                    var row = '<tr class="transition-colors hover:bg-slate-50 dark:hover:bg-slate-800/50">' +
                        '<td class="px-4 py-3 font-medium text-slate-500 dark:text-slate-400">' + (index + 1) + '</td>' +
                        '<td class="px-4 py-3 font-semibold text-slate-900 dark:text-slate-200">' + p.nama + '</td>' +
                        '<td class="px-4 py-3">' + statusBadge + '</td>' +
                        '<td class="px-4 py-3 text-right font-semibold text-slate-800 dark:text-slate-200">Rp ' + new Intl.NumberFormat('id-ID').format(p.iuran || 0) + '</td>' +
                    '</tr>';
                    tbody.innerHTML += row;
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="4" class="px-4 py-6 text-center text-slate-400 dark:text-slate-500">Tidak ada daftar siswa untuk rekap ini.</td></tr>';
            }
            content.classList.remove('hidden');
        }
    })
    .catch(function() {
        loading.classList.add('hidden');
        content.classList.remove('hidden');
        document.getElementById('mTbodyPeserta').innerHTML = '<tr><td colspan="4" class="px-4 py-6 text-center text-rose-500 dark:text-rose-400">Gagal mengambil rincian data peserta.</td></tr>';
    });
}

function tutupDetailModal() {
    var modal = document.getElementById('modalDetailAbsensi');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
}

function exportModalWord() {
    if (!activeDetailParams.date) return;
    var url = "/admin/absensi/export-word"
        + "?date=" + encodeURIComponent(activeDetailParams.date)
        + "&kelas=" + encodeURIComponent(activeDetailParams.kelas)
        + "&ambalan=" + encodeURIComponent(activeDetailParams.ambalan);
    window.location.href = url;
}

function togglePetugasStatus(btn, id) {
    var isCurrentlyActive = btn.getAttribute('data-active') === '1';
    var newStatus = !isCurrentlyActive;

    fetch('/admin/petugas/' + id + '/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ is_active: newStatus })
    })
    .then(function(res) { return res.json(); })
    .then(function(data) {
        if (data.success) {
            btn.setAttribute('data-active', newStatus ? '1' : '0');
            var thumb = btn.querySelector('.js-switch-thumb');
            var label = btn.parentElement.querySelector('.js-status-label');

            if (newStatus) {
                btn.classList.remove('bg-slate-300', 'dark:bg-slate-700');
                btn.classList.add('bg-emerald-500');
                thumb.classList.remove('translate-x-0');
                thumb.classList.add('translate-x-5');
                if (label) {
                    label.textContent = 'Aktif';
                    label.className = 'js-status-label text-xs font-semibold text-emerald-600 dark:text-emerald-400';
                }
            } else {
                btn.classList.remove('bg-emerald-500');
                btn.classList.add('bg-slate-300', 'dark:bg-slate-700');
                thumb.classList.remove('translate-x-5');
                thumb.classList.add('translate-x-0');
                if (label) {
                    label.textContent = 'Nonaktif';
                    label.className = 'js-status-label text-xs font-semibold text-slate-400 dark:text-slate-500';
                }
            }
        }
    });
}
</script>
@endsection