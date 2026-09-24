@extends('admin.layouts.app')

@section('title', $title ?? 'Kelola Pembina')
@section('page-heading', $title ?? 'Kelola Pembina')
@section('page-description', $description ?? 'Kelola data pembina dan penanggung jawab acara.')

@section('content')
<div class="space-y-4 rounded-[1.5rem] border border-slate-200 bg-white p-4 shadow-sm sm:space-y-6 sm:rounded-[2rem] sm:p-6 dark:border-slate-800 dark:bg-slate-900">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400 sm:text-[11px]">Modul Admin</p>
            <h2 class="mt-2 text-xl font-bold text-slate-900 sm:text-2xl dark:text-white">{{ $title ?? 'Kelola Pembina' }}</h2>
            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400 sm:text-sm">{{ $description ?? 'Kelola data pembina dan penanggung jawab acara.' }}</p>
        </div>

        @if(! empty($publicRoute) && ! empty($publicLabel))
            <a href="{{ $publicRoute }}" class="inline-flex items-center rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-100 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300 dark:hover:bg-emerald-500/20">
                {{ $publicLabel }}
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="flex items-start justify-between gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            <p>{{ session('success') }}</p>
            <button type="button" onclick="this.closest('div').remove()" class="text-lg leading-none opacity-70 transition hover:opacity-100" aria-label="Tutup notifikasi">&times;</button>
        </div>
    @endif

    <div class="grid grid-cols-2 gap-2 sm:gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-2 dark:border-slate-700 dark:bg-slate-800/80 sm:p-4">
            <p class="text-[8px] font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400 sm:text-[10px]">Total Pembina</p>
            <p class="mt-2 text-lg font-bold text-slate-900 dark:text-white sm:text-2xl">{{ $stats['total'] ?? 0 }}</p>
            <p class="mt-1 text-[9px] text-slate-500 dark:text-slate-400 sm:text-[11px]">Semua data</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-2 dark:border-slate-700 dark:bg-slate-800/80 sm:p-4">
            <p class="text-[8px] font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400 sm:text-[10px]">Aktif</p>
            <p class="mt-2 text-lg font-bold text-slate-900 dark:text-white sm:text-2xl">{{ $stats['aktif'] ?? 0 }}</p>
            <p class="mt-1 text-[9px] text-slate-500 dark:text-slate-400 sm:text-[11px]">Saat ini</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-2 dark:border-slate-700 dark:bg-slate-800/80 sm:p-4">
            <p class="text-[8px] font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400 sm:text-[10px]">Non-Aktif</p>
            <p class="mt-2 text-lg font-bold text-slate-900 dark:text-white sm:text-2xl">{{ $stats['nonaktif'] ?? 0 }}</p>
            <p class="mt-1 text-[9px] text-slate-500 dark:text-slate-400 sm:text-[11px]">Dihentikan</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-2 dark:border-slate-700 dark:bg-slate-800/80 sm:p-4">
            <p class="text-[8px] font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400 sm:text-[10px]">Kontak Valid</p>
            <p class="mt-2 text-lg font-bold text-slate-900 dark:text-white sm:text-2xl">{{ $stats['kontak'] ?? 0 }}</p>
            <p class="mt-1 text-[9px] text-slate-500 dark:text-slate-400 sm:text-[11px]">Nomor / email</p>
        </div>
    </div>

    <div class="space-y-2">
        <div class="flex items-center justify-end">
            <button type="button" id="toggle-pembina-list" class="hidden md:inline-flex items-center rounded-lg border border-emerald-200 bg-white px-2.5 py-1.5 text-[9px] font-semibold text-emerald-700 shadow-sm transition hover:bg-emerald-50 sm:text-[10px] dark:border-emerald-500/40 dark:bg-slate-900 dark:text-emerald-300 dark:hover:bg-slate-800" aria-expanded="false" aria-controls="pembina-list-card">
                Tampilkan daftar
            </button>
        </div>

        <!-- Mobile Cards View -->
        <div class="grid grid-cols-1 gap-3 md:hidden">
            @forelse($pembinas ?? [] as $pembina)
                <div class="rounded-xl border border-slate-200 bg-white p-3 dark:border-slate-700 dark:bg-slate-900">
                    <div class="flex items-start justify-between gap-2 mb-3">
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-slate-900 dark:text-white truncate">{{ $pembina->name }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 truncate">{{ $pembina->jabatan }}</p>
                        </div>
                        <span class="rounded-full px-2 py-0.5 text-[9px] font-semibold flex-shrink-0 {{ $pembina->is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300' : 'bg-slate-200 text-slate-700 dark:bg-slate-700 dark:text-slate-200' }}">
                            {{ $pembina->status ?: ($pembina->is_active ? 'Aktif' : 'Tidak aktif') }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-600 dark:text-slate-400 mb-3 truncate">{{ $pembina->phone ?: ($pembina->email ?: '-') }}</p>
                    <div class="flex flex-col gap-1.5">
                        <form action="{{ route('admin.pembina.toggle', $pembina) }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="w-full rounded-md border border-amber-200 bg-amber-50 px-2 py-1.5 text-[9px] font-semibold text-amber-700 hover:bg-amber-100 dark:border-amber-700/50 dark:bg-amber-500/10 dark:text-amber-300 dark:hover:bg-amber-500/20">
                                {{ $pembina->is_active ? 'Non-aktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                        <button type="button" onclick="document.getElementById('edit-pembina-{{ $pembina->id }}').classList.toggle('hidden')" class="w-full rounded-md border border-emerald-200 bg-emerald-50 px-2 py-1.5 text-[9px] font-semibold text-emerald-700 hover:bg-emerald-100 dark:border-emerald-500/40 dark:bg-emerald-500/10 dark:text-emerald-300 dark:hover:bg-emerald-500/20">
                            Edit
                        </button>
                        <form action="{{ route('admin.pembina.delete', $pembina) }}" method="POST" onsubmit="return confirm('Hapus pembina ini?');" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full rounded-md border border-rose-200 bg-rose-50 px-2 py-1.5 text-[9px] font-semibold text-rose-700 hover:bg-rose-100 dark:border-rose-500/40 dark:bg-rose-500/10 dark:text-rose-300 dark:hover:bg-rose-500/20">
                                Hapus
                            </button>
                        </form>
                    </div>

                    <div id="edit-pembina-{{ $pembina->id }}" class="hidden mt-3 pt-3 border-t border-slate-200 dark:border-slate-700">
                        <form action="{{ route('admin.pembina.update', $pembina) }}" method="POST" enctype="multipart/form-data" class="grid gap-2">
                            @csrf
                            @method('PUT')
                            <input type="text" name="name" value="{{ old('name', $pembina->name) }}" class="rounded-lg border border-slate-200 bg-white px-2 py-1.5 text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500" placeholder="Nama lengkap" required>
                            <input type="text" name="jabatan" value="{{ old('jabatan', $pembina->jabatan) }}" class="rounded-lg border border-slate-200 bg-white px-2 py-1.5 text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500" placeholder="Jabatan" required>
                            <input type="text" name="phone" value="{{ old('phone', $pembina->phone) }}" class="rounded-lg border border-slate-200 bg-white px-2 py-1.5 text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500" placeholder="Nomor telepon">
                            <button type="submit" class="rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-emerald-500 dark:bg-emerald-500 dark:hover:bg-emerald-400">
                                Simpan
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 text-center text-sm text-slate-500 dark:border-slate-700 dark:bg-slate-800/50 dark:text-slate-400">
                    Belum ada data pembina.
                </div>
            @endforelse
        </div>

        <!-- Desktop Table View -->
        <div id="pembina-list-card" class="hidden md:block overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900">
            <div class="w-full overflow-x-auto [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                <table class="w-full text-left text-[11px] text-slate-600 sm:text-sm dark:text-slate-300">
                <thead class="bg-slate-100 text-[9px] uppercase tracking-[0.12em] text-slate-600 sm:text-xs dark:bg-slate-800 dark:text-slate-300">
                    <tr>
                        <th class="px-2 py-2 sm:px-4 sm:py-3 w-1/4">Nama</th>
                        <th class="px-2 py-2 sm:px-4 sm:py-3 w-1/5">Jabatan</th>
                        <th class="px-2 py-2 sm:px-4 sm:py-3 w-1/5">Kontak</th>
                        <th class="px-2 py-2 sm:px-4 sm:py-3 w-1/6">Status</th>
                        <th class="px-2 py-2 sm:px-4 sm:py-3 w-1/5">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-700 dark:bg-slate-950">
                    @forelse($pembinas ?? [] as $pembina)
                        <tr>
                            <td class="px-2 py-2.5 align-top font-medium text-slate-900 sm:px-4 sm:py-3 dark:text-white break-words">{{ $pembina->name }}</td>
                            <td class="px-2 py-2.5 align-top sm:px-4 sm:py-3 dark:text-slate-300 break-words">{{ $pembina->jabatan }}</td>
                            <td class="px-2 py-2.5 align-top sm:px-4 sm:py-3 dark:text-slate-300 break-words">{{ $pembina->phone ?: ($pembina->email ?: '-') }}</td>
                            <td class="px-2 py-2.5 align-top sm:px-4 sm:py-3">
                                <span class="inline-flex rounded-full px-2 py-1 text-[9px] font-semibold sm:text-[10px] {{ $pembina->is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300' : 'bg-slate-200 text-slate-700 dark:bg-slate-700 dark:text-slate-200' }}">
                                    {{ $pembina->status ?: ($pembina->is_active ? 'Aktif' : 'Tidak aktif') }}
                                </span>
                            </td>
                            <td class="px-2 py-2.5 align-top sm:px-4 sm:py-3">
                                <div class="flex flex-col items-stretch gap-1.5 sm:flex-wrap sm:flex-row sm:items-center sm:gap-2">
                                    <form action="{{ route('admin.pembina.toggle', $pembina) }}" method="POST" class="w-full sm:w-auto">
                                        @csrf
                                        <button type="submit" class="w-full rounded-md border border-amber-200 bg-amber-50 px-2 py-1.5 text-[9px] font-semibold text-amber-700 hover:bg-amber-100 sm:w-auto sm:px-2.5 sm:py-1.5 sm:text-[10px] dark:border-amber-700/50 dark:bg-amber-500/10 dark:text-amber-300 dark:hover:bg-amber-500/20">
                                            {{ $pembina->is_active ? 'Non-aktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>

                                    <button type="button" onclick="document.getElementById('edit-pembina-{{ $pembina->id }}').classList.toggle('hidden')" class="w-full rounded-md border border-emerald-200 bg-emerald-50 px-2 py-1.5 text-[9px] font-semibold text-emerald-700 hover:bg-emerald-100 sm:w-auto sm:px-2.5 sm:py-1.5 sm:text-[10px] dark:border-emerald-500/40 dark:bg-emerald-500/10 dark:text-emerald-300 dark:hover:bg-emerald-500/20">
                                        Edit
                                    </button>

                                    <form action="{{ route('admin.pembina.delete', $pembina) }}" method="POST" onsubmit="return confirm('Hapus pembina ini?');" class="w-full sm:w-auto">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full rounded-md border border-rose-200 bg-rose-50 px-2 py-1.5 text-[9px] font-semibold text-rose-700 hover:bg-rose-100 sm:w-auto sm:px-2.5 sm:py-1.5 sm:text-[10px] dark:border-rose-500/40 dark:bg-rose-500/10 dark:text-rose-300 dark:hover:bg-rose-500/20">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <tr id="edit-pembina-{{ $pembina->id }}" class="hidden bg-slate-50 dark:bg-slate-800/50">
                            <td colspan="5" class="px-4 py-4">
                                <form action="{{ route('admin.pembina.update', $pembina) }}" method="POST" enctype="multipart/form-data" class="grid gap-3 md:grid-cols-2">
                                    @csrf
                                    @method('PUT')

                                    <input type="text" name="name" value="{{ old('name', $pembina->name) }}" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500" placeholder="Nama lengkap" required>
                                    <input type="text" name="jabatan" value="{{ old('jabatan', $pembina->jabatan) }}" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500" placeholder="Jabatan" required>
                                    <input type="text" name="phone" value="{{ old('phone', $pembina->phone) }}" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500" placeholder="Nomor telepon">
                                    <input type="email" name="email" value="{{ old('email', $pembina->email) }}" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500" placeholder="Email">
                                    <select name="status" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white">
                                        <option value="Aktif" {{ old('status', $pembina->status) === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Tidak aktif" {{ old('status', $pembina->status) === 'Tidak aktif' ? 'selected' : '' }}>Tidak aktif</option>
                                    </select>
                                    <input type="number" name="sort_order" value="{{ old('sort_order', $pembina->sort_order ?? 0) }}" min="0" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500" placeholder="Urutan">
                                    <textarea name="bio" rows="3" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500 md:col-span-2" placeholder="Deskripsi singkat">{{ old('bio', $pembina->bio) }}</textarea>
                                    <input type="file" name="photo" accept="image/*" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 dark:border-slate-700 dark:bg-slate-900 dark:text-white md:col-span-2">
                                    <label class="inline-flex items-center gap-2 text-sm text-slate-600 dark:text-slate-300 md:col-span-2">
                                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $pembina->is_active) ? 'checked' : '' }}>
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
                            <td colspan="5" class="px-4 py-6 text-center text-sm text-slate-500 dark:text-slate-400">Belum ada data pembina.</td>
                        </tr>
                    @endforelse
                </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-700 dark:bg-slate-800/80 sm:p-5">
        <div class="mb-3 flex items-center justify-between gap-2 sm:mb-4">
            <h3 class="text-base font-semibold text-slate-900 dark:text-white sm:text-lg">Formulir Pembina</h3>
            <span class="rounded-full bg-emerald-50 px-2 py-1 text-[9px] font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300 sm:text-[10px]">Siap diproses</span>
        </div>

        <div class="block sm:block">
            <form action="{{ route('admin.pembina.store') }}" method="POST" enctype="multipart/form-data" class="grid gap-4 md:grid-cols-2">
                @csrf

            <div class="md:col-span-2">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Foto pembina</span>
                <div id="pembina-upload-box" class="group relative cursor-pointer overflow-hidden rounded-2xl border-2 border-dashed border-slate-300 bg-gradient-to-br from-slate-50 via-white to-emerald-50 p-3 transition-all duration-200 hover:border-emerald-400 hover:bg-emerald-50/80 dark:border-slate-600 dark:from-slate-900 dark:via-slate-900 dark:to-slate-800 dark:hover:border-emerald-500 dark:hover:bg-slate-800/70">
                    <div id="pembina-empty-state" class="flex min-h-[170px] flex-col items-center justify-center gap-3 rounded-xl border border-slate-200/80 bg-white/70 px-4 py-5 text-center shadow-inner dark:border-slate-700 dark:bg-slate-900/80">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 shadow-sm dark:bg-emerald-500/10 dark:text-emerald-300">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path d="M12 16V4m0 0l-4 4m4-4l4 4M4 16.5V18a2.5 2.5 0 0 0 2.5 2.5h11A2.5 2.5 0 0 0 20 18v-1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">Tarik foto ke sini</p>
                            <p class="mt-1 text-[11px] text-slate-500 dark:text-slate-400">atau klik untuk memilih file</p>
                        </div>
                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-600 dark:bg-slate-700 dark:text-slate-200">PNG • JPG • WEBP</span>
                    </div>

                    <div id="pembina-preview-wrap" class="hidden overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
                        <img id="pembina-preview" alt="Preview foto pembina" class="h-[170px] w-full object-cover" />
                        <div class="flex items-center justify-between gap-3 border-t border-slate-200 px-3 py-2 dark:border-slate-700">
                            <span id="pembina-file-name" class="truncate text-xs font-medium text-slate-700 dark:text-slate-200"></span>
                            <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-[0.12em] text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">Preview</span>
                        </div>
                    </div>
                </div>

                <input id="pembina-photo-input" type="file" name="photo" accept="image/*" class="hidden">
            </div>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Nama pembina</span>
                <input type="text" name="name" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder:text-slate-400" placeholder="Masukkan nama lengkap" required>
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Jabatan</span>
                <input type="text" name="jabatan" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder:text-slate-400" placeholder="Pembina / Koordinator / Mentor" required>
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Kontak</span>
                <input type="text" name="phone" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder:text-slate-400" placeholder="Nomor telepon">
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Email</span>
                <input type="email" name="email" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder:text-slate-400" placeholder="email@example.com">
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Status</span>
                <select name="status" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white">
                    <option value="Aktif">Aktif</option>
                    <option value="Tidak aktif">Tidak aktif</option>
                </select>
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Urutan</span>
                <input type="number" name="sort_order" value="0" min="0" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder:text-slate-400">
            </label>

            <label class="block md:col-span-2">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Catatan</span>
                <textarea name="bio" rows="4" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder:text-slate-400" placeholder="Deskripsi tugas dan pengalaman pembina"></textarea>
            </label>

                <div class="md:col-span-2 flex justify-end">
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-500 dark:bg-emerald-500 dark:hover:bg-emerald-400">
                        Simpan Pembina
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const listToggle = document.getElementById('toggle-pembina-list');
        const listCard = document.getElementById('pembina-list-card');

        if (listToggle && listCard) {
            const updateToggleState = () => {
                const isHidden = listCard.classList.contains('hidden');
                listToggle.textContent = isHidden ? 'Tampilkan daftar' : 'Sembunyikan daftar';
                listToggle.setAttribute('aria-expanded', String(!isHidden));
            };

            if (window.innerWidth < 640) {
                listCard.classList.add('hidden');
                updateToggleState();
            }

            listToggle.addEventListener('click', function () {
                listCard.classList.toggle('hidden');
                updateToggleState();
            });

            window.addEventListener('resize', function () {
                if (window.innerWidth >= 640) {
                    listCard.classList.remove('hidden');
                    listToggle.setAttribute('aria-expanded', 'true');
                    listToggle.textContent = 'Sembunyikan daftar';
                } else if (!listCard.classList.contains('hidden')) {
                    listToggle.textContent = 'Sembunyikan daftar';
                    listToggle.setAttribute('aria-expanded', 'true');
                } else {
                    listToggle.textContent = 'Tampilkan daftar';
                    listToggle.setAttribute('aria-expanded', 'false');
                }
            });
        }

        const uploadBox = document.getElementById('pembina-upload-box');
        const input = document.getElementById('pembina-photo-input');
        const fileLabel = document.getElementById('pembina-file-name');
        const previewWrap = document.getElementById('pembina-preview-wrap');
        const previewImage = document.getElementById('pembina-preview');
        const emptyState = document.getElementById('pembina-empty-state');

        if (!uploadBox || !input || !fileLabel || !previewWrap || !previewImage || !emptyState) {
            return;
        }

        const updatePreview = (file) => {
            if (!file || !file.type.startsWith('image/')) {
                previewWrap.classList.add('hidden');
                emptyState.classList.remove('hidden');
                fileLabel.textContent = '';
                return;
            }

            const objectUrl = URL.createObjectURL(file);
            previewImage.src = objectUrl;
            previewWrap.classList.remove('hidden');
            emptyState.classList.add('hidden');
            fileLabel.textContent = file.name;

            previewImage.onload = function () {
                URL.revokeObjectURL(objectUrl);
            };
        };

        uploadBox.addEventListener('click', function (event) {
            if (event.target.closest('button') || event.target.closest('a')) {
                return;
            }
            input.click();
        });

        ['dragenter', 'dragover'].forEach((eventName) => {
            uploadBox.addEventListener(eventName, function (event) {
                event.preventDefault();
                uploadBox.classList.add('border-emerald-400', 'bg-emerald-50/80', 'shadow-md');
                uploadBox.classList.remove('border-slate-300');
            });
        });

        ['dragleave', 'drop'].forEach((eventName) => {
            uploadBox.addEventListener(eventName, function (event) {
                event.preventDefault();
                uploadBox.classList.remove('border-emerald-400', 'bg-emerald-50/80', 'shadow-md');
                uploadBox.classList.add('border-slate-300');
            });
        });

        uploadBox.addEventListener('drop', function (event) {
            event.preventDefault();
            const files = event.dataTransfer && event.dataTransfer.files;
            if (files && files.length) {
                const file = files[0];
                if (!file.type.startsWith('image/')) {
                    return;
                }
                input.files = files;
                updatePreview(file);
            }
        });

        input.addEventListener('change', function () {
            updatePreview(this.files && this.files[0]);
        });
    });
</script>
@endsection
