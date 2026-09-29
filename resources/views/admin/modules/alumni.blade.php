@extends('admin.layouts.app')

@section('title', 'Kelola Alumni')

@section('content')
<div class="space-y-6">
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-sky-600">Konten Organisasi</p>
                <h1 class="mt-2 text-3xl font-bold text-slate-900">Kelola Alumni</h1>
                <p class="mt-2 text-sm text-slate-600">{{ $description ?? 'Kelola data alumni yang tampil di halaman depan.' }}</p>
            </div>
            <a href="{{ route('alumni') }}" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-700">
                Lihat halaman alumni
            </a>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        @foreach([
            ['label' => 'Total', 'value' => $stats['total'] ?? 0, 'caption' => 'Data alumni'],
            ['label' => 'Aktif', 'value' => $stats['aktif'] ?? 0, 'caption' => 'Sedang aktif'],
            ['label' => 'Nonaktif', 'value' => $stats['nonaktif'] ?? 0, 'caption' => 'Tidak aktif'],
            ['label' => 'Jabatan', 'value' => $stats['jabatan'] ?? 0, 'caption' => 'Tercatat'],
        ] as $stat)
            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <p class="text-xs uppercase tracking-[0.18em] text-slate-500">{{ $stat['label'] }}</p>
                <div class="mt-3 text-3xl font-bold text-slate-900">{{ $stat['value'] }}</div>
                <p class="mt-1 text-xs text-slate-500">{{ $stat['caption'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900">Tambah Alumni Baru</h2>
        <form action="{{ route('admin.alumni.store') }}" method="POST" enctype="multipart/form-data" class="mt-4 grid gap-4 md:grid-cols-2">
            @csrf
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Nama</label>
                <input type="text" name="name" required class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:outline-none">
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Jabatan</label>
                <input type="text" name="jabatan" required class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:outline-none">
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Status</label>
                <input type="text" name="status" value="Aktif" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:outline-none">
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Urutan</label>
                <input type="number" name="sort_order" value="0" min="0" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:outline-none">
            </div>
            <div class="md:col-span-2">
                <label class="mb-1 block text-sm font-medium text-slate-700">Foto</label>
                <input type="file" name="photo" accept="image/*" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:outline-none">
            </div>
            <div class="md:col-span-2">
                <label class="mb-1 block text-sm font-medium text-slate-700">Biografi</label>
                <textarea name="bio" rows="4" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:outline-none"></textarea>
            </div>
            <div class="md:col-span-2 flex items-center gap-3">
                <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                    <input type="checkbox" name="is_active" value="1" checked class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                    Aktif ditampilkan di halaman publik
                </label>
            </div>
            <div class="md:col-span-2 flex justify-end">
                <button type="submit" class="rounded-xl bg-sky-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-sky-500">Simpan Alumni</button>
            </div>
        </form>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900">Daftar Alumni</h2>
        @if($members->isEmpty())
            <div class="mt-4 rounded-xl border border-dashed border-slate-300 bg-slate-50 p-6 text-sm text-slate-500">Belum ada data alumni.</div>
        @else
            <div class="mt-4 space-y-3">
                @foreach($members as $member)
                    <div class="flex flex-col gap-3 rounded-xl border border-slate-200 p-4 md:flex-row md:items-center md:justify-between">
                        <div class="flex items-center gap-3">
                            @if($member->photo_url)
                                <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" class="h-12 w-12 rounded-full object-cover">
                            @else
                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-slate-200 text-xs font-bold text-slate-600">{{ strtoupper(substr($member->name, 0, 2)) }}</div>
                            @endif
                            <div>
                                <p class="font-semibold text-slate-900">{{ $member->name }}</p>
                                <p class="text-sm text-slate-600">{{ $member->jabatan }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="rounded-full {{ $member->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-700' }} px-2.5 py-1 text-xs font-semibold">
                                {{ $member->is_active ? 'Aktif' : 'Non-Aktif' }}
                            </span>
                            <form action="{{ route('admin.alumni.toggle', $member) }}" method="POST">
                                @csrf
                                <button type="submit" class="rounded-lg border border-slate-300 px-2.5 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-100">
                                    {{ $member->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.alumni.delete', $member) }}" method="POST" onsubmit="return confirm('Hapus alumni ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-lg border border-red-200 bg-red-50 px-2.5 py-1.5 text-xs font-medium text-red-700 hover:bg-red-100">Hapus</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
