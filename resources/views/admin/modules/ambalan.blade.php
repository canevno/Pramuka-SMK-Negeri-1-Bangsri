@extends('admin.layouts.app')

@section('title', $title ?? 'Kelola Ambalan')
@section('page-heading', $title ?? 'Kelola Ambalan')
@section('page-description', $description ?? 'Kelola profil ambalan yang tampil di halaman depan.')

@section('content')
<div class="space-y-4 rounded-3xl border border-slate-200 bg-white p-4 shadow-sm sm:space-y-6 sm:rounded-4xl sm:p-6 dark:border-slate-800 dark:bg-slate-900">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400 sm:text-[11px]">Modul Admin</p>
            <h2 class="mt-2 text-xl font-bold text-slate-900 sm:text-2xl dark:text-white">{{ $title ?? 'Kelola Ambalan' }}</h2>
            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400 sm:text-sm">{{ $description ?? 'Kelola profil ambalan yang tampil di halaman depan.' }}</p>
        </div>

        @if(! empty($publicRoute) && ! empty($publicLabel))
            <a href="{{ $publicRoute }}" class="inline-flex items-center rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-100 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300 dark:hover:bg-emerald-500/20">
                {{ $publicLabel }}
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="flex items-start justify-between gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-300">
            <p>{{ session('success') }}</p>
            <button type="button" onclick="this.closest('div').remove()" class="text-lg leading-none opacity-70 transition hover:opacity-100" aria-label="Tutup notifikasi">&times;</button>
        </div>
    @endif

    <div class="grid grid-cols-2 gap-2 sm:gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-2 dark:border-slate-700 dark:bg-slate-800/80 sm:p-4">
            <p class="text-[8px] font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400 sm:text-[10px]">Total Profil</p>
            <p class="mt-2 text-lg font-bold text-slate-900 dark:text-white sm:text-2xl">{{ $stats['total'] ?? 0 }}</p>
            <p class="mt-1 text-[9px] text-slate-500 dark:text-slate-400 sm:text-[11px]">Semua data</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-2 dark:border-slate-700 dark:bg-slate-800/80 sm:p-4">
            <p class="text-[8px] font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400 sm:text-[10px]">Aktif</p>
            <p class="mt-2 text-lg font-bold text-slate-900 dark:text-white sm:text-2xl">{{ $stats['aktif'] ?? 0 }}</p>
            <p class="mt-1 text-[9px] text-slate-500 dark:text-slate-400 sm:text-[11px]">Tampil di halaman</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-2 dark:border-slate-700 dark:bg-slate-800/80 sm:p-4">
            <p class="text-[8px] font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400 sm:text-[10px]">Non-Aktif</p>
            <p class="mt-2 text-lg font-bold text-slate-900 dark:text-white sm:text-2xl">{{ $stats['nonaktif'] ?? 0 }}</p>
            <p class="mt-1 text-[9px] text-slate-500 dark:text-slate-400 sm:text-[11px]">Disembunyikan</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-2 dark:border-slate-700 dark:bg-slate-800/80 sm:p-4">
            <p class="text-[8px] font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400 sm:text-[10px]">Terakhir</p>
            <p class="mt-2 text-base font-bold text-slate-900 dark:text-white sm:text-xl">{{ $stats['terbaru'] ?? '-' }}</p>
            <p class="mt-1 text-[9px] text-slate-500 dark:text-slate-400 sm:text-[11px]">Pembaruan terakhir</p>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-700">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-[11px] text-slate-600 sm:text-sm dark:text-slate-300">
                <thead class="bg-slate-100 text-[9px] uppercase tracking-[0.12em] text-slate-600 sm:text-xs dark:bg-slate-800 dark:text-slate-300">
                    <tr>
                        <th class="px-2 py-2 sm:px-4 sm:py-3">Nama</th>
                        <th class="px-2 py-2 sm:px-4 sm:py-3">Subtitle</th>
                        <th class="px-2 py-2 sm:px-4 sm:py-3">Status</th>
                        <th class="px-2 py-2 sm:px-4 sm:py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-700 dark:bg-slate-950">
                    @forelse($profiles ?? [] as $profile)
                        <tr>
                            <td class="px-2 py-2.5 align-top font-medium text-slate-900 sm:px-4 sm:py-3 dark:text-white">
                                <div class="flex items-center gap-3">
                                    @if(! empty($profile->image_path))
                                        <img src="{{ asset($profile->image_path) }}" alt="{{ $profile->name }}" class="h-10 w-10 rounded-full object-cover ring-2 ring-slate-200 dark:ring-slate-700">
                                    @else
                                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-100 text-xs font-bold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">
                                            {{ strtoupper(substr($profile->name ?? 'A', 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div>{{ $profile->name }}</div>
                                        <div class="text-[10px] text-slate-500 dark:text-slate-400">{{ $profile->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-2 py-2.5 align-top sm:px-4 sm:py-3 dark:text-slate-300">{{ $profile->subtitle ?: '-' }}</td>
                            <td class="px-2 py-2.5 align-top sm:px-4 sm:py-3">
                                <span class="inline-flex rounded-full px-2 py-1 text-[9px] font-semibold sm:text-[10px] {{ $profile->is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300' : 'bg-slate-200 text-slate-700 dark:bg-slate-700 dark:text-slate-200' }}">
                                    {{ $profile->is_active ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </td>
                            <td class="px-2 py-2.5 align-top sm:px-4 sm:py-3">
                                <div class="flex flex-col items-stretch gap-1.5 sm:flex-wrap sm:flex-row sm:items-center sm:gap-2">
                                    <form action="{{ route('admin.ambalan.toggle', $profile) }}" method="POST" class="w-full sm:w-auto">
                                        @csrf
                                        <button type="submit" class="w-full rounded-md border border-amber-200 bg-amber-50 px-2 py-1.5 text-[9px] font-semibold text-amber-700 hover:bg-amber-100 sm:w-auto sm:px-2.5 sm:py-1.5 sm:text-[10px] dark:border-amber-700/50 dark:bg-amber-500/10 dark:text-amber-300 dark:hover:bg-amber-500/20">
                                            {{ $profile->is_active ? 'Non-aktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>

                                    <button type="button" onclick="document.getElementById('edit-ambalan-{{ $profile->id }}').classList.toggle('hidden')" class="w-full rounded-md border border-emerald-200 bg-emerald-50 px-2 py-1.5 text-[9px] font-semibold text-emerald-700 hover:bg-emerald-100 sm:w-auto sm:px-2.5 sm:py-1.5 sm:text-[10px] dark:border-emerald-500/40 dark:bg-emerald-500/10 dark:text-emerald-300 dark:hover:bg-emerald-500/20">
                                        Edit
                                    </button>

                                    <form action="{{ route('admin.ambalan.delete', $profile) }}" method="POST" onsubmit="return confirm('Hapus profil ambalan ini?');" class="w-full sm:w-auto">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full rounded-md border border-rose-200 bg-rose-50 px-2 py-1.5 text-[9px] font-semibold text-rose-700 hover:bg-rose-100 sm:w-auto sm:px-2.5 sm:py-1.5 sm:text-[10px] dark:border-rose-500/40 dark:bg-rose-500/10 dark:text-rose-300 dark:hover:bg-rose-500/20">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <tr id="edit-ambalan-{{ $profile->id }}" class="hidden bg-slate-50 dark:bg-slate-800/50">
                            <td colspan="4" class="px-4 py-4">
                                <form action="{{ route('admin.ambalan.update', $profile) }}" method="POST" enctype="multipart/form-data" class="grid gap-3 md:grid-cols-2">
                                    @csrf
                                    @method('PUT')

                                    <input type="text" name="name" value="{{ old('name', $profile->name) }}" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500" placeholder="Nama ambalan" required>
                                    <input type="text" name="slug" value="{{ old('slug', $profile->slug) }}" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500" placeholder="Slug URL">
                                    <input type="text" name="subtitle" value="{{ old('subtitle', $profile->subtitle) }}" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500" placeholder="Subtitle / pembina">
                                    <input type="number" name="sort_order" value="{{ old('sort_order', $profile->sort_order ?? 0) }}" min="0" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500" placeholder="Urutan">
                                    <textarea name="description" rows="3" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500 md:col-span-2" placeholder="Deskripsi singkat">{{ old('description', $profile->description) }}</textarea>
                                    <textarea name="vision" rows="2" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500" placeholder="Visi">{{ old('vision', $profile->vision) }}</textarea>
                                    <textarea name="mission" rows="2" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500" placeholder="Misi">{{ old('mission', $profile->mission) }}</textarea>
                                    <input type="file" name="image" accept="image/*" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 dark:border-slate-700 dark:bg-slate-900 dark:text-white md:col-span-2">
                                    <label class="inline-flex items-center gap-2 text-sm text-slate-600 dark:text-slate-300 md:col-span-2">
                                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $profile->is_active) ? 'checked' : '' }}>
                                        Aktif dipublikasikan
                                    </label>
                                    <div class="flex justify-end gap-2 md:col-span-2">
                                        <button type="submit" class="rounded-xl bg-emerald-600 px-4 py-2 text-xs font-semibold text-white hover:bg-emerald-500 dark:bg-emerald-500 dark:hover:bg-emerald-400">
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-sm text-slate-500 dark:text-slate-400">Belum ada profil ambalan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-700 dark:bg-slate-800/80 sm:p-5">
        <div class="mb-3 flex items-center justify-between gap-2 sm:mb-4">
            <h3 class="text-base font-semibold text-slate-900 dark:text-white sm:text-lg">Formulir Profil Ambalan</h3>
            <span class="rounded-full bg-emerald-50 px-2 py-1 text-[9px] font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300 sm:text-[10px]">Siap diproses</span>
        </div>

        <form action="{{ route('admin.ambalan.store') }}" method="POST" enctype="multipart/form-data" class="grid gap-4 md:grid-cols-2">
            @csrf

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Nama ambalan</span>
                <input type="text" name="name" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder:text-slate-400" placeholder="Ambalan Putra" required>
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Slug URL</span>
                <input type="text" name="slug" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder:text-slate-400" placeholder="ambalan-putra">
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Subtitle / Pembina</span>
                <input type="text" name="subtitle" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder:text-slate-400" placeholder="KH. Achmad Fauzan">
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Urutan</span>
                <input type="number" name="sort_order" value="0" min="0" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder:text-slate-400">
            </label>

            <label class="block md:col-span-2">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Deskripsi</span>
                <textarea name="description" rows="4" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder:text-slate-400" placeholder="Deskripsi profil ambalan"></textarea>
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Visi</span>
                <textarea name="vision" rows="3" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder:text-slate-400" placeholder="Menjadi..."></textarea>
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Misi</span>
                <textarea name="mission" rows="3" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder:text-slate-400" placeholder="Mendorong..."></textarea>
            </label>

            <label class="block md:col-span-2">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Foto profil</span>
                <input type="file" name="image" accept="image/*" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 dark:border-slate-700 dark:bg-slate-900 dark:text-white">
            </label>

            <label class="inline-flex items-center gap-2 text-sm text-slate-600 dark:text-slate-300 md:col-span-2">
                <input type="checkbox" name="is_active" value="1" checked>
                Tampilkan di halaman publik
            </label>

            <div class="md:col-span-2 flex justify-end">
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-500 dark:bg-emerald-500 dark:hover:bg-emerald-400">
                    Simpan Ambalan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
