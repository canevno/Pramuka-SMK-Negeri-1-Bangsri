@extends('admin.layouts.app')
@section('title', 'Daftar Petugas')
@section('page-heading', 'Daftar Petugas')
@section('page-description', 'Melihat nama petugas, NTA, kelas, dan keaktifan terakhir berdasarkan absensi.')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-slate-950">Tambah Petugas</h2>
                <p class="mt-1 text-sm text-slate-500">Tambah petugas baru untukke absensi dan pengelolaan rekam.</p>
            </div>
        </div>

        <form action="{{ route('admin.petugas.store') }}" method="POST" class="mt-6 grid gap-4 md:grid-cols-5">
            @csrf
            <div class="md:col-span-1">
                <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Nama</label>
                <input type="text" name="nama" required class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 focus:border-emerald-500" placeholder="Nama petugas">
            </div>
            <div class="md:col-span-1">
                <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">NTA</label>
                <input type="text" name="nta" required class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 focus:border-emerald-500" placeholder="NTA">
            </div>
            <div class="md:col-span-1">
                <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Kelas</label>
                <input type="text" name="kelas_petugas" required class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 focus:border-emerald-500" placeholder="Contoh: XII RPL 1">
            </div>
            <div class="md:col-span-1">
                <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 focus:border-emerald-500">
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div class="md:col-span-1 flex items-end">
                <button type="submit" class="w-full rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-emerald-700">Tambah Petugas</button>
            </div>
        </form>
    </section>

    <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-slate-950">Daftar Petugas</h2>
                <p class="mt-1 text-sm text-slate-500">Data petugas yang sudah terdaftar di sistem.</p>
            </div>
        </div>

        <div class="mt-6 overflow-hidden rounded-[1.75rem] border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm text-slate-700">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Nama Petugas</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">NTA</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Kelas Petugas</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Jenis Kelamin</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Status</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($registeredPetugas as $item)
                        <tr>
                            <td class="px-4 py-4">{{ $item->nama }}</td>
                            <td class="px-4 py-4">{{ $item->nta }}</td>
                            <td class="px-4 py-4">{{ $item->kelas_petugas }}</td>
                            <td class="px-4 py-4">{{ $item->jenis_kelamin === 'P' ? 'Perempuan' : 'Laki-laki' }}</td>
                            <td class="px-4 py-4">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $item->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ $item->is_active ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <form action="{{ route('admin.petugas.toggle', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                        {{ $item->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>
                            </td>
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
