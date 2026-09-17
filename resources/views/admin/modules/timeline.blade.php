@extends('admin.layouts.app')

@section('title', $title ?? 'Kelola Timeline Kegiatan')
@section('page-heading', $title ?? 'Kelola Timeline Kegiatan')
@section('page-description', $description ?? 'Kelola jadwal dan kegiatan yang tampil di homepage.')

@section('content')
<div class="space-y-6 rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Modul Admin</p>
            <h2 class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">{{ $title ?? 'Kelola Timeline Kegiatan' }}</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $description ?? 'Kelola jadwal dan kegiatan yang tampil di homepage.' }}</p>
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

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500">Total Kegiatan</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $stats['total'] ?? 0 }}</p>
            <p class="mt-1 text-[11px] text-slate-500">Semua data</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500">Akan Datang</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $stats['upcoming'] ?? 0 }}</p>
            <p class="mt-1 text-[11px] text-slate-500">Menunggu tanggal</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500">Sedang Aktif</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $stats['active'] ?? 0 }}</p>
            <p class="mt-1 text-[11px] text-slate-500">Dipublikasikan</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500">Selesai</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $stats['completed'] ?? 0 }}</p>
            <p class="mt-1 text-[11px] text-slate-500">Terlewati</p>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-100 text-xs uppercase tracking-[0.12em] text-slate-600">
                    <tr>
                        <th class="px-4 py-3">Judul</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Lokasi</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($events ?? [] as $event)
                        <tr>
                            <td class="px-4 py-3 font-medium text-slate-900">{{ $event->title }}</td>
                            <td class="px-4 py-3">{{ \Illuminate\Support\Carbon::parse($event->date)->translatedFormat('d F Y') }}<br><span class="text-[11px] text-slate-500">{{ $event->time ?? 'Waktu belum diatur' }}</span></td>
                            <td class="px-4 py-3">{{ $event->location }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded-full px-2.5 py-1 text-[10px] font-semibold {{ $event->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-700' }}">
                                    {{ $event->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap items-center gap-2">
                                    <form action="{{ route('admin.timeline.toggle', $event) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="rounded-lg border border-amber-200 bg-amber-50 px-2.5 py-1.5 text-[10px] font-semibold text-amber-700 hover:bg-amber-100">
                                            {{ $event->is_active ? 'Non-aktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>

                                    <button type="button" onclick="document.getElementById('edit-timeline-{{ $event->id }}').classList.toggle('hidden')" class="rounded-lg border border-indigo-200 bg-indigo-50 px-2.5 py-1.5 text-[10px] font-semibold text-indigo-700 hover:bg-indigo-100">
                                        Edit
                                    </button>

                                    <form action="{{ route('admin.timeline.delete', $event) }}" method="POST" onsubmit="return confirm('Hapus kegiatan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg border border-rose-200 bg-rose-50 px-2.5 py-1.5 text-[10px] font-semibold text-rose-700 hover:bg-rose-100">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <tr id="edit-timeline-{{ $event->id }}" class="hidden bg-slate-50">
                            <td colspan="5" class="px-4 py-4">
                                <form action="{{ route('admin.timeline.update', $event) }}" method="POST" enctype="multipart/form-data" class="grid gap-3 md:grid-cols-2">
                                    @csrf
                                    @method('PUT')

                                    <input type="text" name="title" value="{{ old('title', $event->title) }}" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm" placeholder="Judul kegiatan" required>
                                    <input type="date" name="date" value="{{ old('date', $event->date?->format('Y-m-d') ?? $event->date) }}" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm" required>
                                    <input type="time" name="time" value="{{ old('time', $event->time) }}" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm">
                                    <input type="text" name="location" value="{{ old('location', $event->location) }}" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm" placeholder="Lokasi" required>
                                    <input type="url" name="guide_url" value="{{ old('guide_url', $event->guide_url) }}" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm md:col-span-2" placeholder="https://...">
                                    <input type="number" name="sort_order" value="{{ old('sort_order', $event->sort_order ?? 0) }}" min="0" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm">
                                    <select name="status" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm">
                                        <option value="upcoming" {{ old('status', $event->status) === 'upcoming' ? 'selected' : '' }}>Akan datang</option>
                                        <option value="ongoing" {{ old('status', $event->status) === 'ongoing' ? 'selected' : '' }}>Sedang berlangsung</option>
                                        <option value="completed" {{ old('status', $event->status) === 'completed' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                    <textarea name="theme" rows="3" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm md:col-span-2" placeholder="Tema kegiatan">{{ old('theme', $event->theme) }}</textarea>

                                    <div class="md:col-span-2">
                                        <label class="block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Logo kegiatan</label>
                                        <div class="mt-2 flex items-center gap-3 rounded-2xl border border-dashed border-slate-300 bg-white p-3">
                                            <input type="file" name="logo" accept="image/*" class="block w-full text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-indigo-600 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-white">
                                            @if(! empty($event->logo_path))
                                                <img src="{{ asset('storage/' . $event->logo_path) }}" alt="Logo kegiatan" class="h-12 w-12 rounded-xl object-cover border border-slate-200">
                                            @endif
                                        </div>
                                    </div>

                                    <label class="inline-flex items-center gap-2 text-sm text-slate-600 md:col-span-2">
                                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $event->is_active) ? 'checked' : '' }}>
                                        Tampilkan di homepage
                                    </label>
                                    <div class="flex justify-end gap-2 md:col-span-2">
                                        <button type="submit" class="rounded-xl bg-indigo-600 px-4 py-2 text-xs font-semibold text-white hover:bg-indigo-500">
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-sm text-slate-500">Belum ada data timeline kegiatan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Formulir Timeline</h3>
            <span class="rounded-full bg-emerald-50 px-2 py-1 text-[10px] font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">Siap diproses</span>
        </div>

        <form action="{{ route('admin.timeline.store') }}" method="POST" enctype="multipart/form-data" class="grid gap-4 md:grid-cols-2">
            @csrf

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Judul kegiatan</span>
                <input type="text" name="title" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-indigo-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100" placeholder="Masukkan judul acara" required>
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Tanggal</span>
                <input type="date" name="date" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-indigo-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100" required>
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Waktu</span>
                <input type="time" name="time" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-indigo-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100">
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Urutan</span>
                <input type="number" name="sort_order" value="0" min="0" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-indigo-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100">
            </label>

            <label class="block md:col-span-2">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Lokasi</span>
                <input type="text" name="location" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-indigo-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100" placeholder="Masukkan lokasi kegiatan" required>
            </label>

            <label class="block md:col-span-2">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Panduan kegiatan (opsional)</span>
                <input type="url" name="guide_url" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-indigo-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100" placeholder="https://example.com/panduan">
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Status</span>
                <select name="status" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-indigo-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100">
                    <option value="upcoming">Akan datang</option>
                    <option value="ongoing">Sedang berlangsung</option>
                    <option value="completed">Selesai</option>
                </select>
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Tampilkan</span>
                <select name="is_active" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-indigo-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100">
                    <option value="1">Ya, tampilkan di homepage</option>
                    <option value="0">Tidak tampilkan</option>
                </select>
            </label>

            <label class="block md:col-span-2">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Tema kegiatan</span>
                <textarea name="theme" rows="4" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-indigo-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100" placeholder="Tuliskan tema atau motto kegiatan"></textarea>
            </label>

            <div class="md:col-span-2">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Logo kegiatan mendatang</span>
                <div class="mt-2 rounded-2xl border-2 border-dashed border-slate-300 bg-white p-4 transition hover:border-indigo-400 dark:border-slate-700 dark:bg-slate-900">
                    <label class="flex cursor-pointer flex-col items-center justify-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-6 py-8 text-center dark:border-slate-700 dark:bg-slate-800">
                        <svg class="h-10 w-10 text-indigo-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 16V4m0 0l-4 4m4-4l4 4M5 18.5A2.5 2.5 0 007.5 21h9A2.5 2.5 0 0019 18.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <div>
                            <p class="text-sm font-semibold text-slate-800 dark:text-slate-100">Seret & lepas logo di sini</p>
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">PNG, JPG, WEBP hingga 2 MB</p>
                        </div>
                        <input type="file" name="logo" accept="image/*" class="hidden">
                    </label>
                </div>
            </div>

            <div class="md:col-span-2 flex justify-end">
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500">
                    Simpan Timeline
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
