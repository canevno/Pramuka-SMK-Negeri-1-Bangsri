{{-- 1. GANTI BARIS INI SESUAI PEMBUKA FILE PENDAFTARAN LAKSANA --}}
@extends('admin.layouts.app') {{-- atau <x-admin-layout> --}}

@section('content') {{-- Hapuskan baris ini jika menggunakan <x-admin-layout> --}}

<div class="p-6">
    

    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-lg font-bold text-gray-900">Daftar Pendaftar Bantara</h3>
            <p class="text-sm text-gray-500">Kelola dan verifikasi berkas calon pendaftar Bantara.</p>
        </div>
    </div>

    <!-- Detail Modal is rendered via the layout modal stack (@stack('modals')) -->

    <!-- Tabel Data Pendaftar -->
    <div class="overflow-x-auto relative shadow-md sm:rounded-lg hide-scrollbar">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                <tr>
                    <th scope="col" class="py-3 px-4">No</th>
                    <th scope="col" class="py-3 px-4">Nama Lengkap</th>
                    <th scope="col" class="py-3 px-4">Kelas</th>
                    <th scope="col" class="py-3 px-4">WhatsApp</th>
                    <th scope="col" class="py-3 px-4">Surat Izin</th>
                    <th scope="col" class="py-3 px-4">Status</th>
                    <th scope="col" class="py-3 px-4 text-center">Aksi Status</th>
                    <th scope="col" class="py-3 px-4 text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($registrations as $index => $item)
                    @php
                        // Normalize DB status_verifikasi to frontend values used by the select
                        $currentStatus = 'pending';
                        if (isset($item->status_verifikasi)) {
                            if ($item->status_verifikasi === 'disetujui') $currentStatus = 'approved';
                            elseif ($item->status_verifikasi === 'ditolak') $currentStatus = 'rejected';
                            else $currentStatus = 'pending';
                        }
                    @endphp
                    <tr data-rt="{{ e($item->rt) }}" data-rw="{{ e($item->rw) }}" data-kecamatan="{{ e($item->kecamatan) }}" data-kabupaten="{{ e($item->kabupaten) }}" data-ttl="{{ e($item->tempat_tanggal_lahir) }}" data-motivasi="{{ e($item->motivasi) }}" class="bg-white border-b hover:bg-gray-50">
                        <td class="py-4 px-4 font-medium text-gray-900">
                            {{ $registrations->firstItem() + $index }}
                        </td>
                        <td class="py-4 px-4 font-semibold text-gray-900 align-middle">
                            <div class="max-w-[220px] min-w-0">
                                <a href="#" class="show-detail text-gray-900 hover:underline block whitespace-nowrap truncate" data-id="{{ $item->id }}">{{ $item->nama }}</a>
                            </div>
                        </td>
                        <td class="py-4 px-4 whitespace-nowrap">{{ $item->kelas }}</td>
                        <td class="py-4 px-4">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->whatsapp) }}" target="_blank" class="text-blue-600 hover:underline">
                                {{ $item->whatsapp }}
                            </a>
                        </td>
                        <td class="py-4 px-4 align-middle">
                            @php
                                $hasSurat = false;
                                try {
                                    $hasSurat = $item->surat_izin_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($item->surat_izin_path);
                                } catch (\Throwable $e) {
                                    $hasSurat = false;
                                }
                            @endphp
                                @if($hasSurat)
                                <a href="{{ route('admin.pendaftaran.surat.download', $item->id) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-100 rounded hover:bg-blue-200 whitespace-nowrap min-w-[96px]">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v12m0 0l-4-4m4 4l4-4"/></svg>
                                    Download Berkas
                                </a>
                            @else
                                <span class="text-xs text-gray-400">Tidak ada berkas</span>
                            @endif
                        </td>
                        <td class="py-4 px-4">
                            @if($currentStatus === 'approved')
                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-green-200">Disetujui</span>
                            @elseif($currentStatus === 'rejected')
                                <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-red-200">Ditolak</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-yellow-200">Pending</span>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-center">
                            <form action="{{ route('admin.pendaftaran.update-status', $item->id) }}" method="POST" class="inline-flex items-center space-x-1">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="text-xs rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 py-1 px-2">
                                    <option value="pending" {{ $currentStatus === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $currentStatus === 'approved' ? 'selected' : '' }}>Setujui</option>
                                    <option value="rejected" {{ $currentStatus === 'rejected' ? 'selected' : '' }}>Tolak</option>
                                </select>
                            </form>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <form action="{{ route('admin.pendaftaran.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pendaftaran ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-semibold text-xs bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded transition">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-6 px-4 text-center text-gray-500">
                            Belum ada data pendaftaran Bantara.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $registrations->links() }}
    </div>
</div>

{{-- 2. GANTI BARIS INI SESUAI PENUTUP FILE PENDAFTARAN LAKSANA --}}
@endsection {{-- atau </x-admin-layout> --}}

@push('modals')
<div id="pendaftaran-detail-backdrop" class="fixed inset-0 hidden items-center justify-center" style="z-index: 2147483647 !important;">
    <div id="pendaftaran-detail-overlay" class="absolute inset-0 bg-black/40 backdrop-blur-sm" style="z-index: 2147483646 !important;"></div>

    <div id="pendaftaran-detail-card" class="relative mx-4 w-full max-w-3xl" style="z-index: 2147483647 !important; position: relative;">
        <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-lg" style="position: relative; z-index: 2147483647 !important;">
            <div class="flex items-start justify-between">
                <div>
                    <h4 class="text-md font-semibold text-gray-800">Detail Pendaftar</h4>
                    <p id="detail-nama" class="text-sm text-gray-500 mt-1"></p>
                </div>
                <button id="detail-close" class="text-2xl leading-none text-gray-400 hover:text-gray-700">×</button>
            </div>

            <div class="mt-5 space-y-5">
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <h5 class="mb-3 text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Identitas Alamat</h5>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <span class="block text-[11px] font-medium uppercase tracking-wide text-slate-500">RT</span>
                            <div id="detail-rt" class="mt-1 text-base font-semibold text-slate-800"></div>
                        </div>
                        <div>
                            <span class="block text-[11px] font-medium uppercase tracking-wide text-slate-500">RW</span>
                            <div id="detail-rw" class="mt-1 text-base font-semibold text-slate-800"></div>
                        </div>
                        <div class="sm:col-span-2">
                            <span class="block text-[11px] font-medium uppercase tracking-wide text-slate-500">Kecamatan</span>
                            <div id="detail-kecamatan" class="mt-1 text-base font-semibold text-slate-800"></div>
                        </div>
                        <div>
                            <span class="block text-[11px] font-medium uppercase tracking-wide text-slate-500">Kabupaten</span>
                            <div id="detail-kabupaten" class="mt-1 text-base font-semibold text-slate-800"></div>
                        </div>
                        <div>
                            <span class="block text-[11px] font-medium uppercase tracking-wide text-slate-500">Tempat, Tanggal Lahir</span>
                            <div id="detail-ttl" class="mt-1 text-base font-semibold text-slate-800"></div>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-4">
                    <h5 class="mb-3 text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Motivasi</h5>
                    <div id="detail-motivasi" class="text-sm leading-6 text-slate-700 whitespace-pre-line"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var backdrop = document.getElementById('pendaftaran-detail-backdrop');
    var overlay = document.getElementById('pendaftaran-detail-overlay');
    var card = document.getElementById('pendaftaran-detail-card');
    var closeBtn = document.getElementById('detail-close');

    function openModal() {
        if (!backdrop) return;
        backdrop.classList.remove('hidden');
        backdrop.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        if (!backdrop) return;
        backdrop.classList.add('hidden');
        backdrop.classList.remove('flex');
        document.body.style.overflow = '';
    }

    function showDetailFromRow(row, name) {
        if (!row) return;
        document.getElementById('detail-nama').textContent = name || '';
        document.getElementById('detail-rt').textContent = row.getAttribute('data-rt') || '';
        document.getElementById('detail-rw').textContent = row.getAttribute('data-rw') || '';
        document.getElementById('detail-kecamatan').textContent = row.getAttribute('data-kecamatan') || '';
        document.getElementById('detail-kabupaten').textContent = row.getAttribute('data-kabupaten') || '';
        document.getElementById('detail-ttl').textContent = row.getAttribute('data-ttl') || '';
        document.getElementById('detail-motivasi').textContent = row.getAttribute('data-motivasi') || '';
        openModal();
    }

    document.querySelectorAll('.show-detail').forEach(function(el){
        el.addEventListener('click', function(e){
            e.preventDefault();
            var row = el.closest('tr');
            showDetailFromRow(row, el.textContent.trim());
        });
    });

    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (overlay) overlay.addEventListener('click', closeModal);

    // close on ESC
    document.addEventListener('keydown', function(e){ if (e.key === 'Escape') closeModal(); });
});
</script>
@endpush