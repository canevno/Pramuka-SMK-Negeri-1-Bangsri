@extends('admin.layouts.app')

@section('title', $title ?? 'Kelola Timeline Kegiatan')
@section('page-heading', $title ?? 'Kelola Timeline Kegiatan')
@section('page-description', $description ?? 'Kelola jadwal dan kegiatan yang tampil di homepage.')

@section('content')
<div class="space-y-4 rounded-[1.5rem] border border-slate-200 bg-white p-3 shadow-sm sm:space-y-6 sm:rounded-[2rem] sm:p-6 dark:border-slate-800 dark:bg-slate-900">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400 sm:text-[11px]">Modul Admin</p>
            <h2 class="mt-2 text-xl font-bold text-slate-900 sm:text-2xl dark:text-white">{{ $title ?? 'Kelola Timeline Kegiatan' }}</h2>
            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400 sm:text-sm">{{ $description ?? 'Kelola jadwal dan kegiatan yang tampil di homepage.' }}</p>
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

    <div class="grid grid-cols-2 gap-3 sm:gap-4 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-800 dark:bg-slate-800/40 sm:p-4">
            <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400 sm:text-[10px]">Total Kegiatan</p>
            <p class="mt-2 text-xl font-bold text-slate-900 dark:text-white sm:text-2xl">{{ $stats['total'] ?? 0 }}</p>
            <p class="mt-1 text-[10px] text-slate-500 dark:text-slate-400 sm:text-[11px]">Semua data</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-800 dark:bg-slate-800/40 sm:p-4">
            <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400 sm:text-[10px]">Akan Datang</p>
            <p class="mt-2 text-xl font-bold text-slate-900 dark:text-white sm:text-2xl">{{ $stats['upcoming'] ?? 0 }}</p>
            <p class="mt-1 text-[10px] text-slate-500 dark:text-slate-400 sm:text-[11px]">Menunggu tanggal</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-800 dark:bg-slate-800/40 sm:p-4">
            <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400 sm:text-[10px]">Sedang Aktif</p>
            <p class="mt-2 text-xl font-bold text-slate-900 dark:text-white sm:text-2xl">{{ $stats['active'] ?? 0 }}</p>
            <p class="mt-1 text-[10px] text-slate-500 dark:text-slate-400 sm:text-[11px]">Dipublikasikan</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-800 dark:bg-slate-800/40 sm:p-4">
            <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400 sm:text-[10px]">Selesai</p>
            <p class="mt-2 text-xl font-bold text-slate-900 dark:text-white sm:text-2xl">{{ $stats['completed'] ?? 0 }}</p>
            <p class="mt-1 text-[10px] text-slate-500 dark:text-slate-400 sm:text-[11px]">Terlewati</p>
        </div>
    </div>

    <div class="space-y-3 md:hidden">
        @forelse($events ?? [] as $event)
            <article class="rounded-2xl border border-slate-200 bg-white p-3 shadow-sm dark:border-slate-700 dark:bg-slate-900">
                <div class="mb-3 flex items-start justify-between gap-2">
                    <div class="min-w-0 flex-1">
                        <h4 class="truncate text-sm font-bold text-slate-900 dark:text-white">{{ $event->title }}</h4>
                        <p class="mt-1 text-[11px] text-slate-500 dark:text-slate-400">{{ \Illuminate\Support\Carbon::parse($event->date)->translatedFormat('d F Y') }}</p>
                    </div>
                    <span class="inline-flex shrink-0 rounded-full px-2 py-0.5 text-[9px] font-semibold {{ $event->is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300' : 'bg-slate-200 text-slate-700 dark:bg-slate-700 dark:text-slate-200' }}">
                        {{ $event->status }}
                    </span>
                </div>

                <div class="space-y-1 text-[11px] text-slate-600 dark:text-slate-300">
                    <p><span class="font-semibold text-slate-500 dark:text-slate-400">Lokasi:</span> {{ $event->location }}</p>
                    <p><span class="font-semibold text-slate-500 dark:text-slate-400">Waktu:</span> {{ $event->time ?? 'Waktu belum diatur' }}</p>
                </div>

                <div class="mt-3 grid grid-cols-2 gap-2">
                    <form action="{{ route('admin.timeline.toggle', $event) }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full rounded-lg border border-amber-200 bg-amber-50 px-2 py-1.5 text-[10px] font-semibold text-amber-700 dark:border-amber-700/50 dark:bg-amber-500/10 dark:text-amber-300">
                            {{ $event->is_active ? 'Non-aktifkan' : 'Aktifkan' }}
                        </button>
                    </form>

                    <button type="button" onclick="document.getElementById('edit-timeline-{{ $event->id }}').classList.toggle('hidden')" class="w-full rounded-lg border border-emerald-200 bg-emerald-50 px-2 py-1.5 text-[10px] font-semibold text-emerald-700 dark:border-emerald-500/40 dark:bg-emerald-500/10 dark:text-emerald-300">
                        Edit
                    </button>

                    <form action="{{ route('admin.timeline.delete', $event) }}" method="POST" onsubmit="return confirm('Hapus kegiatan ini?');" class="w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full rounded-lg border border-rose-200 bg-rose-50 px-2 py-1.5 text-[10px] font-semibold text-rose-700 dark:border-rose-500/40 dark:bg-rose-500/10 dark:text-rose-300">
                            Hapus
                        </button>
                    </form>

                    <button type="button" class="w-full rounded-lg border border-slate-200 bg-slate-50 px-2 py-1.5 text-[10px] font-semibold text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200">
                        Detail
                    </button>
                </div>
            </article>
        @empty
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 text-center text-sm text-slate-500 dark:border-slate-700 dark:bg-slate-800/60 dark:text-slate-400">
                Belum ada data timeline kegiatan.
            </div>
        @endforelse
    </div>

    <div class="hidden overflow-hidden rounded-2xl border border-slate-200 md:block dark:border-slate-800">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm text-slate-600 dark:text-slate-300">
                <thead class="bg-slate-100 text-xs uppercase tracking-[0.12em] text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                    <tr>
                        <th class="px-4 py-3">Judul</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Lokasi</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-700 dark:bg-slate-950">
                    @forelse($events ?? [] as $event)
                        <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-800/50">
                            <td class="px-4 py-3 font-medium text-slate-900 dark:text-white">{{ $event->title }}</td>
                            <td class="px-4 py-3 dark:text-slate-300">
                                {{ \Illuminate\Support\Carbon::parse($event->date)->translatedFormat('d F Y') }}
                                <br>
                                <span class="text-[11px] text-slate-500 dark:text-slate-400">{{ $event->time ?? 'Waktu belum diatur' }}</span>
                            </td>
                            <td class="px-4 py-3 dark:text-slate-300">{{ $event->location }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded-full px-2.5 py-1 text-[10px] font-semibold {{ $event->is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300' : 'bg-slate-200 text-slate-700 dark:bg-slate-700 dark:text-slate-200' }}">
                                    {{ $event->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap items-center gap-2">
                                    <form action="{{ route('admin.timeline.toggle', $event) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="rounded-lg border border-amber-200 bg-amber-50 px-2.5 py-1.5 text-[10px] font-semibold text-amber-700 hover:bg-amber-100 dark:border-amber-700/50 dark:bg-amber-500/10 dark:text-amber-300 dark:hover:bg-amber-500/20">
                                            {{ $event->is_active ? 'Non-aktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>

                                    <button type="button" onclick="document.getElementById('edit-timeline-{{ $event->id }}').classList.toggle('hidden')" class="rounded-lg border border-emerald-200 bg-emerald-50 px-2.5 py-1.5 text-[10px] font-semibold text-emerald-700 hover:bg-emerald-100 dark:border-emerald-500/40 dark:bg-emerald-500/10 dark:text-emerald-300 dark:hover:bg-emerald-500/20">
                                        Edit
                                    </button>

                                    <form action="{{ route('admin.timeline.delete', $event) }}" method="POST" onsubmit="return confirm('Hapus kegiatan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg border border-rose-200 bg-rose-50 px-2.5 py-1.5 text-[10px] font-semibold text-rose-700 hover:bg-rose-100 dark:border-rose-500/40 dark:bg-rose-500/10 dark:text-rose-300 dark:hover:bg-rose-500/20">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <tr id="edit-timeline-{{ $event->id }}" class="hidden bg-slate-50 dark:bg-slate-800/50">
                            <td colspan="5" class="px-4 py-4">
                                <form action="{{ route('admin.timeline.update', $event) }}" method="POST" enctype="multipart/form-data" class="grid gap-3 md:grid-cols-2">
                                    @csrf
                                    @method('PUT')

                                    <input type="text" name="title" value="{{ old('title', $event->title) }}" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500" placeholder="Judul kegiatan" required>
                                    <input type="date" name="date" value="{{ old('date', $event->date?->format('Y-m-d') ?? $event->date) }}" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white" required>
                                    <input type="time" name="time" value="{{ old('time', $event->time) }}" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white">
                                    <input type="text" name="location" value="{{ old('location', $event->location) }}" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500" placeholder="Lokasi" required>
                                    <input type="url" name="guide_url" value="{{ old('guide_url', $event->guide_url) }}" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500 md:col-span-2" placeholder="https://...">
                                    <input type="number" name="sort_order" value="{{ old('sort_order', $event->sort_order ?? 0) }}" min="0" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500">
                                    <select name="status" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white">
                                        <option value="upcoming" {{ old('status', $event->status) === 'upcoming' ? 'selected' : '' }}>Akan datang</option>
                                        <option value="ongoing" {{ old('status', $event->status) === 'ongoing' ? 'selected' : '' }}>Sedang berlangsung</option>
                                        <option value="completed" {{ old('status', $event->status) === 'completed' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                    <textarea name="description" rows="3" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500 md:col-span-2" placeholder="Deskripsi singkat kegiatan (maks 500 karakter)">{{ old('description', $event->description) }}</textarea>
                                    <textarea name="theme" rows="3" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500 md:col-span-2" placeholder="Tema kegiatan">{{ old('theme', $event->theme) }}</textarea>

                                    <div class="md:col-span-2">
                                        <label class="block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Logo kegiatan</label>
                                        <div class="mt-2 flex items-center gap-3 rounded-2xl border border-dashed border-slate-300 bg-white p-3 file-drop-zone dark:border-slate-700 dark:bg-slate-900">
                                            <input type="file" name="logo" accept="image/*" class="block w-full text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-emerald-600 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-white dark:text-slate-300">
                                            @if(! empty($event->logo_path))
                                                <img src="{{ asset('storage/' . $event->logo_path) }}" alt="Logo kegiatan" class="h-12 w-12 rounded-xl object-cover border border-slate-200 dark:border-slate-700">
                                            @endif
                                        </div>
                                    </div>

                                    <label class="inline-flex items-center gap-2 text-sm text-slate-600 dark:text-slate-300 md:col-span-2">
                                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $event->is_active) ? 'checked' : '' }}>
                                        Tampilkan di homepage
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
                            <td colspan="5" class="px-4 py-6 text-center text-sm text-slate-500 dark:text-slate-400">Belum ada data timeline kegiatan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5 dark:border-slate-700 dark:bg-slate-800/80">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Formulir Timeline</h3>
            <span class="rounded-full bg-emerald-50 px-2 py-1 text-[10px] font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">Siap diproses</span>
        </div>

        <form action="{{ route('admin.timeline.store') }}" method="POST" enctype="multipart/form-data" class="grid gap-4 md:grid-cols-2">
            @csrf

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Judul kegiatan</span>
                <input type="text" name="title" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder:text-slate-400" placeholder="Masukkan judul acara" required>
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Tanggal</span>
                <input type="date" name="date" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white" required>
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Waktu</span>
                <input type="time" name="time" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white">
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Urutan</span>
                <input type="number" name="sort_order" value="0" min="0" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white">
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Lokasi</span>
                <input type="text" name="location" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder:text-slate-400" placeholder="Masukkan lokasi kegiatan" required>
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Status</span>
                <select name="status" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white">
                    <option value="upcoming">Akan datang</option>
                    <option value="ongoing">Sedang berlangsung</option>
                    <option value="completed">Selesai</option>
                </select>
            </label>

            <label class="block md:col-span-2">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Deskripsi singkat</span>
                <textarea name="description" rows="3" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder:text-slate-400" placeholder="Deskripsi singkat kegiatan (maks 500 karakter)"></textarea>
            </label>

            <label class="block md:col-span-2">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Tema kegiatan</span>
                <textarea name="theme" rows="4" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder:text-slate-400" placeholder="Tuliskan tema atau motto kegiatan"></textarea>
            </label>

            <label class="block md:col-span-2">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Panduan kegiatan (opsional)</span>
                <input type="url" name="guide_url" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder:text-slate-400" placeholder="https://example.com/panduan">
            </label>

            <label class="block md:col-span-2">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Tampilkan di homepage</span>
                <select name="is_active" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white">
                    <option value="1">Ya, tampilkan di homepage</option>
                    <option value="0">Tidak tampilkan</option>
                </select>
            </label>

            <div class="md:col-span-2">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Logo kegiatan</span>
                <div class="mt-2 rounded-2xl border-2 border-dashed border-slate-300 bg-white p-4 transition hover:border-emerald-400 dark:border-slate-700 dark:bg-slate-900">
                    <label class="file-drop-zone flex cursor-pointer flex-col items-center justify-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-6 py-8 text-center dark:border-slate-700 dark:bg-slate-800">
                        <svg class="h-10 w-10 text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M12 16V4m0 0l-4 4m4-4l4 4M5 18.5A2.5 2.5 0 007.5 21h9A2.5 2.5 0 0019 18.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-slate-800 dark:text-slate-100">Seret & lepas logo di sini</p>
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">PNG, JPG, WEBP</p>
                        </div>
                        <input type="file" name="logo" accept="image/*" class="hidden">
                    </label>
                </div>
            </div>

            <div class="md:col-span-2 flex justify-end">
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-500 dark:bg-emerald-500 dark:hover:bg-emerald-400">
                    Simpan Timeline
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.file-drop-zone').forEach(function (zone) {
        var input = zone.querySelector('input[type=file]');
        if (! input) return;

        zone.addEventListener('dragover', function (e) {
            e.preventDefault();
            zone.classList.add('ring-2', 'ring-indigo-300');
        });

        ['dragleave', 'dragend', 'drop'].forEach(function (evt) {
            zone.addEventListener(evt, function (e) {
                e.preventDefault();
                zone.classList.remove('ring-2', 'ring-indigo-300');
            });
        });

        zone.addEventListener('drop', function (e) {
            e.preventDefault();
            var files = e.dataTransfer.files;
            if (! files || files.length === 0) return;
            try {
                var dt = new DataTransfer();
                for (var i = 0; i < files.length; i++) {
                    dt.items.add(files[i]);
                }
                input.files = dt.files;

                var ev = new Event('change', { bubbles: true });
                input.dispatchEvent(ev);

                var file = input.files[0];
                if (file) {
                    var img = zone.querySelector('img');
                    if (! img) {
                        img = document.createElement('img');
                        img.className = 'mt-3 h-12 w-12 rounded-xl object-contain border border-slate-200 dark:border-slate-700';
                        zone.appendChild(img);
                    }
                    img.src = URL.createObjectURL(file);
                }
            } catch (err) {
                console.warn('Could not set dropped files on input', err);
            }
        });

        input.addEventListener('change', function () {
            var f = input.files && input.files[0];
            if (! f) return;
            var img = zone.querySelector('img');
            if (! img) {
                img = document.createElement('img');
                img.className = 'mt-3 h-12 w-12 rounded-xl object-contain border border-slate-200 dark:border-slate-700';
                zone.appendChild(img);
            }
            img.src = URL.createObjectURL(f);
        });
    });
});
</script>
@endpush
