{{-- 1. GANTI BARIS INI SESUAI PEMBUKA FILE PENDAFTARAN LAKSANA --}}
@extends('admin.layouts.app') {{-- atau <x-admin-layout> --}}

@section('content') {{-- Hapuskan baris ini jika menggunakan <x-admin-layout> --}}

<div class="p-6">
    <!-- Alert Notifikasi Sukses -->
    @if (session('success'))
        <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg border border-green-200" role="alert">
            <span class="font-medium">Berhasil!</span> {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-lg font-bold text-gray-900">Daftar Pendaftar Bantara</h3>
            <p class="text-sm text-gray-500">Kelola dan verifikasi berkas calon pendaftar Bantara.</p>
        </div>
    </div>

    <!-- Tabel Data Pendaftar -->
    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
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
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="py-4 px-4 font-medium text-gray-900">
                            {{ $registrations->firstItem() + $index }}
                        </td>
                        <td class="py-4 px-4 font-semibold text-gray-900">
                            {{ $item->nama }}
                            <div class="text-xs text-gray-400 font-normal">
                                {{ $item->tempat_tanggal_lahir }}
                            </div>
                        </td>
                        <td class="py-4 px-4">{{ $item->kelas }}</td>
                        <td class="py-4 px-4">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->whatsapp) }}" target="_blank" class="text-blue-600 hover:underline">
                                {{ $item->whatsapp }}
                            </a>
                        </td>
                        <td class="py-4 px-4">
                            @if($item->surat_izin_path)
                                <a href="{{ asset('storage/' . $item->surat_izin_path) }}" target="_blank" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-blue-700 bg-blue-100 rounded hover:bg-blue-200">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Berkas
                                </a>
                            @else
                                <span class="text-xs text-gray-400">Tidak ada berkas</span>
                            @endif
                        </td>
                        <td class="py-4 px-4">
                            @if($item->status === 'approved')
                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-green-200">Disetujui</span>
                            @elseif($item->status === 'rejected')
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
                                    <option value="pending" {{ $item->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $item->status === 'approved' ? 'selected' : '' }}>Setujui</option>
                                    <option value="rejected" {{ $item->status === 'rejected' ? 'selected' : '' }}>Tolak</option>
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