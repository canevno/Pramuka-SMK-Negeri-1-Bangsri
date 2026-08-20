@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="rounded-[2rem] border border-slate-200 bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 p-6 text-white shadow-[0_18px_45px_rgba(15,23,42,0.14)]">
            <div class="flex flex-col gap-5 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.22em] text-slate-300">Overview</p>
                    <h1 class="mt-3 text-3xl font-bold tracking-tight text-white">Dashboard</h1>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 backdrop-blur-sm">
                    <p class="text-[11px] uppercase tracking-[0.2em] text-slate-300">Rekap</p>
                    <p class="mt-2 text-base font-semibold text-slate-50">{{ count($latestAttendanceRecords ?? []) }} aktivitas</p>
                </div>
            </div>
        </div>

        <!-- Activity List Section -->
        <div class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between gap-2 border-b border-slate-100 pb-3">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Aktivitas Absensi</h2>
                    <p class="mt-1 text-xs text-slate-500">Ringkasan presensi terbaru.</p>
                </div>
                <a href="{{ route('admin.absensi') }}" class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-100">
                    Lihat semua
                </a>
            </div>

            <div class="mt-4 space-y-2.5">
                @forelse($latestAttendanceRecords ?? [] as $record)
                    <div class="flex items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-slate-50/80 p-3 transition hover:border-slate-300 hover:bg-white">
                        <div class="flex items-center gap-3 overflow-hidden">
                            <div class="h-2.5 w-2.5 shrink-0 rounded-full bg-emerald-500"></div>
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-slate-900">
                                    {{ $record->kegiatan ?? 'Absensi Kegiatan' }}
                                </p>
                                <p class="text-[11px] text-slate-500">
                                    {{ $record->created_at ? $record->created_at->translatedFormat('d M Y • H:i') : '-' }}
                                </p>
                            </div>
                        </div>

                        <button type="button"
                                onclick="bukaModalAbsensi({{ $record->id }})"
                                class="shrink-0 rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700 transition hover:bg-emerald-100">
                            Detail
                        </button>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-6 text-center text-xs text-slate-500">
                        Belum ada data absensi terbaru.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Modal Absensi -->
    <div id="vModalAbsensi" 
         onclick="handleBackdropClick(event)"
         class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4 backdrop-blur-sm" 
         style="display: none;">
        <div class="flex max-h-[85vh] w-full max-w-lg flex-col rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-2xl">
            <div class="flex items-start justify-between border-b border-slate-100 pb-3">
                <div>
                    <h3 id="vKegiatan" class="text-base font-bold text-slate-900">Detail Absensi</h3>
                    <p id="vSubJudul" class="mt-0.5 text-xs text-slate-500">-</p>
                </div>
                <button type="button" onclick="tutupModalAbsensi()" class="text-2xl font-bold leading-none text-slate-400 transition hover:text-slate-600">&times;</button>
            </div>

            <div id="vLoading" class="py-10 text-center">
                <div class="inline-block h-6 w-6 animate-spin rounded-full border-2 border-emerald-600 border-t-transparent"></div>
                <p class="mt-2 text-xs text-slate-500">Memuat data...</p>
            </div>

            <div id="vError" class="my-4 rounded-xl border border-rose-200 bg-rose-50 p-3 text-xs text-rose-700" style="display: none;"></div>

            <div id="vContent" class="my-4 space-y-4 overflow-y-auto pr-1" style="display: none;">
                <div class="grid grid-cols-2 gap-3">
                    <div class="rounded-2xl border border-emerald-100 bg-emerald-50 p-3">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-emerald-700">Total Iuran</p>
                        <p id="vTotalIuran" class="mt-1 text-lg font-bold text-emerald-900">Rp 0</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-slate-600">Kehadiran</p>
                        <p id="vKehadiran" class="mt-1 text-lg font-bold text-slate-900">0 / 0 Orang</p>
                    </div>
                </div>

                <div>
                    <p class="mb-2 text-xs font-bold uppercase tracking-[0.12em] text-slate-800">Daftar Kehadiran & Iuran</p>
                    <div class="overflow-hidden rounded-xl border border-slate-200">
                        <table class="min-w-full divide-y divide-slate-200 text-left text-xs">
                            <thead class="bg-slate-50 font-semibold text-slate-600">
                                <tr>
                                    <th class="px-3 py-2.5">Nama</th>
                                    <th class="px-3 py-2.5">Kelas</th>
                                    <th class="px-3 py-2.5">Status</th>
                                    <th class="px-3 py-2.5 text-right">Iuran</th>
                                </tr>
                            </thead>
                            <tbody id="vTbody" class="divide-y divide-slate-100 bg-white text-slate-700"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-100 pt-3 text-right">
                <button type="button" onclick="tutupModalAbsensi()" class="rounded-xl bg-slate-100 px-4 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-200">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
    const API_BASE_URL = "{{ url('admin/absensi') }}";

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function bukaModalAbsensi(id) {
        var modal = document.getElementById('vModalAbsensi');
        var loading = document.getElementById('vLoading');
        var content = document.getElementById('vContent');
        var errorBox = document.getElementById('vError');

        modal.style.display = 'flex';
        loading.style.display = 'block';
        content.style.display = 'none';
        errorBox.style.display = 'none';

        fetch(API_BASE_URL + '/' + id, {
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
            loading.style.display = 'none';

            if (data.success) {
                document.getElementById('vKegiatan').textContent = data.kegiatan || 'Detail Absensi';
                document.getElementById('vSubJudul').textContent = 'Petugas: ' + (data.petugas || 'Admin') + ' • ' + (data.tanggal || '-');
                document.getElementById('vTotalIuran').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(data.total_iuran || 0);
                document.getElementById('vKehadiran').textContent = (data.total_hadir || 0) + ' / ' + (data.total_peserta || 0) + ' Orang';

                var tbody = document.getElementById('vTbody');
                tbody.innerHTML = '';

                if (data.participants && data.participants.length > 0) {
                    var rowsHtml = '';
                    data.participants.forEach(function(p) {
                        var isHadir = (p.status || '').toLowerCase() === 'hadir';
                        var statusClass = isHadir ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700';

                        rowsHtml += '<tr class="hover:bg-slate-50/80 transition">' +
                            '<td class="px-3 py-2 font-medium text-slate-900">' + escapeHtml(p.nama) + '</td>' +
                            '<td class="px-3 py-2 text-slate-500">' + escapeHtml(p.kelas) + '</td>' +
                            '<td class="px-3 py-2"><span class="px-2 py-0.5 rounded-full text-[10px] font-bold ' + statusClass + '">' + escapeHtml(p.status) + '</span></td>' +
                            '<td class="px-3 py-2 text-right font-semibold text-slate-900">Rp ' + new Intl.NumberFormat('id-ID').format(p.iuran || 0) + '</td>' +
                        '</tr>';
                    });
                    tbody.innerHTML = rowsHtml;
                } else {
                    tbody.innerHTML = '<tr><td colspan="4" class="text-center py-4 text-slate-400">Tidak ada rincian peserta.</td></tr>';
                }

                content.style.display = 'block';
            } else {
                errorBox.textContent = data.message || 'Gagal memuat detail.';
                errorBox.style.display = 'block';
            }
        })
        .catch(function(err) {
            loading.style.display = 'none';
            errorBox.textContent = 'Gagal memuat data. ' + err.message;
            errorBox.style.display = 'block';
        });
    }

    function tutupModalAbsensi() {
        document.getElementById('vModalAbsensi').style.display = 'none';
    }

    function handleBackdropClick(e) {
        if (e.target.id === 'vModalAbsensi') {
            tutupModalAbsensi();
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            tutupModalAbsensi();
        }
    });
    </script>
@endsection