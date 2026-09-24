@extends('admin.layouts.app')

@section('title', $title ?? 'Manajemen Galeri')
@section('page-heading', $title ?? 'Manajemen Galeri')
@section('page-description', $description ?? 'Kelola album galeri, status publikasi, dan tampilan beranda.')

@section('content')
<style>
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
</style>

@php
    $resolveImage = function ($path) {
        if (empty($path)) {
            return asset('images/gallery/default.jpg');
        }

        $normalized = trim((string) $path);
        $normalized = str_replace('\\', '/', $normalized);
        $normalized = ltrim($normalized, '/');

        if (str_starts_with($normalized, 'http')) {
            return $normalized;
        }

        if (str_starts_with($normalized, 'public/')) {
            $normalized = preg_replace('#^public/#', '', $normalized);
        }

        if (str_starts_with($normalized, 'storage/')) {
            return asset($normalized);
        }

        if (str_starts_with($normalized, 'gallery/')) {
            return \Illuminate\Support\Facades\Storage::url($normalized);
        }

        if (str_contains($normalized, '/storage/')) {
            return asset(ltrim($normalized, '/'));
        }

        if (str_contains($normalized, 'storage/')) {
            return asset($normalized);
        }

        return asset($normalized);
    };
@endphp

<div class="space-y-4">

    {{-- Success Alert --}}
    @if(session('success'))
        <div class="flex items-start justify-between gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-900 dark:bg-emerald-950/40 dark:text-emerald-300">
            <p>{{ session('success') }}</p>
            <button
                type="button"
                onclick="this.closest('div').remove()"
                class="text-lg leading-none opacity-70 transition hover:opacity-100"
                aria-label="Tutup notifikasi"
            >
                &times;
            </button>
        </div>
    @endif

    {{-- Toolbar --}}
    <div class="flex flex-col gap-3 rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-900 sm:flex-row sm:items-center sm:justify-between">
        <div class="relative w-full sm:max-w-xs">
            <input
                type="text"
                id="searchInput"
                placeholder="Cari judul, alt text, atau kategori..."
                class="w-full rounded-lg border border-gray-200 bg-gray-50 py-2 pl-9 pr-4 text-xs text-gray-900 outline-none focus:ring-2 focus:ring-emerald-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
            >
            <svg class="absolute left-3 top-2.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
            </svg>
        </div>

        <button
            type="button"
            onclick="openFormModal()"
            class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-emerald-700"
        >
            + Tambah Album
        </button>
    </div>

    {{-- Table --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
        <div class="scrollbar-hide overflow-x-auto">
            <table id="galleryTable" class="w-full min-w-[760px] text-left text-xs">
                <thead class="border-b border-gray-200 bg-gray-50 uppercase tracking-wider text-gray-500 dark:border-gray-800 dark:bg-gray-800/50 dark:text-gray-400">
                    <tr>
                        <th class="w-20 p-4">Media</th>
                        <th class="p-4">Judul</th>
                        <th class="p-4">Kategori</th>
                        <th class="p-4">Lokasi</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-center">Tampilan</th>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 text-gray-700 dark:divide-gray-800 dark:text-gray-300">
                    @forelse($items as $item)
                        <tr
                            class="transition hover:bg-gray-50/60 dark:hover:bg-gray-800/30"
                            data-search="{{ strtolower(trim(($item->title ?? '') . ' ' . ($item->alt_text ?? '') . ' ' . ($item->category ?? '') . ' ' . ($item->location ?? '') . ' ' . ($item->is_published ? 'publik' : 'draft') . ' ' . ($item->is_featured ? 'beranda' : ''))) }}"
                        >
                            <td class="p-4">
                                <button
                                    type="button"
                                    data-preview-image="{{ e($resolveImage($item->image)) }}"
                                    data-preview-title="{{ e($item->title) }}"
                                    class="group relative block h-10 w-14 overflow-hidden rounded-lg border border-gray-200 bg-gray-100 dark:border-gray-700 dark:bg-gray-800"
                                    aria-label="Lihat gambar {{ $item->title }}"
                                >
                                    <img
                                        src="{{ $resolveImage($item->image) }}"
                                        alt="{{ $item->alt_text ?: $item->title }}"
                                        loading="lazy"
                                        class="h-full w-full object-cover"
                                    >
                                </button>
                            </td>

                            <td class="p-4">
                                <div class="font-semibold text-gray-900 dark:text-white">{{ $item->title }}</div>
                                <div class="mt-1 text-[10px] text-gray-400">Alt: {{ $item->alt_text ?: $item->title }}</div>
                            </td>

                            <td class="p-4">
                                <span class="rounded-md border border-emerald-200 bg-emerald-50 px-2.5 py-1 font-medium text-emerald-600 dark:border-emerald-900 dark:bg-emerald-950/40 dark:text-emerald-400">
                                    {{ ucfirst($item->category) }}
                                </span>
                            </td>

                            <td class="p-4">
                                <span class="text-gray-600 dark:text-gray-300">
                                    {{ $item->location ?: '—' }}
                                </span>
                            </td>

                            <td class="p-4 text-center">
                                <span class="rounded px-2 py-1 text-[10px] font-bold {{ $item->is_published ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-950/40 dark:text-emerald-400' : 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400' }}">
                                    {{ $item->is_published ? 'Publik' : 'Draft' }}
                                </span>
                            </td>

                            <td class="p-4 text-center">
                                @if($item->is_featured)
                                    <span class="rounded-md border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-[10px] font-semibold text-emerald-600 dark:border-emerald-900 dark:bg-emerald-950/40 dark:text-emerald-400">
                                        Beranda
                                    </span>
                                @else
                                    <span class="text-gray-300 dark:text-gray-600">—</span>
                                @endif
                            </td>

                            <td class="whitespace-nowrap p-4 text-gray-500 dark:text-gray-400">
                                {{ \Carbon\Carbon::parse($item->published_at ?? $item->created_at)->translatedFormat('d M Y') }}
                            </td>

                            <td class="p-4">
                                <div class="flex items-center justify-end gap-1">
                                    <button
                                        type="button"
                                        data-copy-link="{{ e($resolveImage($item->image)) }}"
                                        class="rounded-lg p-2 text-gray-500 transition hover:bg-emerald-50 hover:text-emerald-600 dark:hover:bg-emerald-950/40 dark:hover:text-emerald-400"
                                        title="Salin URL gambar"
                                        aria-label="Salin URL gambar"
                                    >
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5"/>
                                        </svg>
                                    </button>

                                    <button
                                        type="button"
                                        data-edit-item="{{ json_encode([
                                            'id' => $item->id,
                                            'title' => $item->title,
                                            'category' => $item->category,
                                            'location' => $item->location,
                                            'image' => $item->image,
                                            'description' => $item->description,
                                            'alt_text' => $item->alt_text,
                                            'published_at' => $item->published_at ? $item->published_at->format('Y-m-d') : '',
                                            'is_published' => (bool) $item->is_published,
                                            'is_featured' => (bool) $item->is_featured,
                                            'edit_url' => route('admin.gallery.update', $item->id),
                                        ]) }}"
                                        class="rounded-lg p-2 text-gray-500 transition hover:bg-emerald-50 hover:text-emerald-600 dark:hover:bg-emerald-950/40 dark:hover:text-emerald-400"
                                        title="Edit album"
                                        aria-label="Edit album"
                                    >
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.684.708.708-2.684a4.5 4.5 0 011.13-1.897L16.862 4.487zm0 0L19.5 7.125"/>
                                        </svg>
                                    </button>

                                    <form
                                        method="POST"
                                        action="{{ route('admin.gallery.duplicate', $item->id) }}"
                                        class="inline"
                                        onsubmit="return confirm('Duplikasi album ini?')"
                                    >
                                        @csrf
                                        <button
                                            type="submit"
                                            class="rounded-lg p-2 text-gray-500 transition hover:bg-amber-50 hover:text-amber-600 dark:hover:bg-amber-950/40 dark:hover:text-amber-400"
                                            title="Duplikat album"
                                            aria-label="Duplikat album"
                                        >
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75A1.125 1.125 0 013.75 20.625V8.625c0-.621.504-1.125 1.125-1.125h3.375m7.5 0h3.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-9.75A1.125 1.125 0 019.75 18.375v-3.375m6.75-10.5v6.75m-3.375-3.375h6.75"/>
                                            </svg>
                                        </button>
                                    </form>

                                    <form
                                        method="POST"
                                        action="{{ route('admin.gallery.delete', $item->id) }}"
                                        class="inline"
                                        onsubmit="return confirm('Hapus album ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="rounded-lg p-2 text-gray-500 transition hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-950/40 dark:hover:text-red-400"
                                            title="Hapus album"
                                            aria-label="Hapus album"
                                        >
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-10 text-center">
                                <svg class="mx-auto h-10 w-10 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.586-5.586a2.25 2.25 0 013.182 0l2.756 2.756a2.25 2.25 0 003.182 0L21.75 7.5M2.25 19.5h19.5M18.75 5.25h.008v.008h-.008V5.25Z"/>
                                </svg>
                                <p class="mt-3 text-sm font-semibold text-gray-700 dark:text-gray-300">Belum ada album galeri</p>
                                <p class="mt-1 text-xs text-gray-400">Klik tombol di bawah ini untuk menambahkan album pertama.</p>
                                <button
                                    type="button"
                                    onclick="openFormModal()"
                                    class="mt-4 rounded-lg bg-emerald-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-emerald-700"
                                >
                                    Tambah Album
                                </button>
                            </td>
                        </tr>
                    @endforelse

                    @if(count($items ?? []) > 0)
                        <tr id="noSearchResultRow" class="hidden">
                            <td colspan="7" class="p-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                Tidak ada hasil yang cocok dengan pencarian.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Form Modal --}}
<div id="formModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4" role="dialog" aria-modal="true" aria-labelledby="formModalTitle">
    <div class="absolute inset-0 bg-slate-950/60" onclick="closeFormModal()"></div>

    <div class="relative flex max-h-[90vh] w-full max-w-2xl flex-col overflow-hidden rounded-xl border border-gray-200 bg-white shadow-2xl dark:border-gray-800 dark:bg-gray-900">
        <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4 dark:border-gray-800">
            <div>
                <h3 id="formModalTitle" class="text-sm font-bold text-gray-900 dark:text-white">Tambah Album Galeri</h3>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Lengkapi data album lalu simpan.</p>
            </div>

            <button
                type="button"
                onclick="closeFormModal()"
                class="rounded-lg p-1 text-gray-400 transition hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-800 dark:hover:text-gray-300"
                aria-label="Tutup form"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="scrollbar-hide overflow-y-auto p-5">
            @if($errors->any())
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-xs text-red-700 dark:border-red-900 dark:bg-red-950/40 dark:text-red-300">
                    <p class="mb-1 font-semibold">Form belum valid:</p>
                    <ul class="list-inside list-disc space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                id="galleryForm"
                method="POST"
                action="{{ route('admin.gallery.store') }}"
                enctype="multipart/form-data"
                class="grid grid-cols-1 gap-4 text-xs md:grid-cols-2"
            >
                @csrf
                <input type="hidden" name="_method" id="galleryFormMethod" value="POST">

                <div class="md:col-span-2">
                    <label for="title" class="mb-2 block font-semibold text-gray-700 dark:text-gray-300">
                        Judul Album <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title') }}"
                        placeholder="Masukkan judul album"
                        required
                        class="w-full rounded-xl border border-gray-200 bg-gray-50 p-3 text-gray-900 outline-none focus:ring-2 focus:ring-emerald-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                    >
                    @error('title')
                        <p class="mt-1 text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category" class="mb-2 block font-semibold text-gray-700 dark:text-gray-300">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="category"
                        name="category"
                        required
                        class="w-full rounded-xl border border-gray-200 bg-gray-50 p-3 text-gray-900 outline-none focus:ring-2 focus:ring-emerald-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                    >
                        <option value="kegiatan" {{ old('category', 'kegiatan') == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                        <option value="pelatihan" {{ old('category') == 'pelatihan' ? 'selected' : '' }}>Pelatihan</option>
                        <option value="acara" {{ old('category') == 'acara' ? 'selected' : '' }}>Event</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="location" class="mb-2 block font-semibold text-gray-700 dark:text-gray-300">Lokasi</label>
                    <input
                        type="text"
                        id="location"
                        name="location"
                        value="{{ old('location') }}"
                        placeholder="Contoh: Lapangan SMK Negeri 1 Bangsri"
                        class="w-full rounded-xl border border-gray-200 bg-gray-50 p-3 text-gray-900 outline-none focus:ring-2 focus:ring-emerald-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                    >
                    @error('location')
                        <p class="mt-1 text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="published_at" class="mb-2 block font-semibold text-gray-700 dark:text-gray-300">Tanggal</label>
                    <input
                        type="date"
                        id="published_at"
                        name="published_at"
                        value="{{ old('published_at') }}"
                        class="w-full rounded-xl border border-gray-200 bg-gray-50 p-3 text-gray-900 outline-none focus:ring-2 focus:ring-emerald-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                    >
                    @error('published_at')
                        <p class="mt-1 text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="alt_text" class="mb-2 block font-semibold text-gray-700 dark:text-gray-300">Alt Text</label>
                    <input
                        type="text"
                        id="alt_text"
                        name="alt_text"
                        value="{{ old('alt_text') }}"
                        placeholder="Deskripsi ringkas gambar untuk aksesibilitas dan SEO"
                        class="w-full rounded-xl border border-gray-200 bg-gray-50 p-3 text-gray-900 outline-none focus:ring-2 focus:ring-emerald-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                    >
                    @error('alt_text')
                        <p class="mt-1 text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="is_published" class="mb-2 block font-semibold text-gray-700 dark:text-gray-300">Status Publikasi</label>
                    <select
                        id="is_published"
                        name="is_published"
                        class="w-full rounded-xl border border-gray-200 bg-gray-50 p-3 text-gray-900 outline-none focus:ring-2 focus:ring-emerald-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                    >
                        <option value="1" {{ old('is_published', '1') == '1' ? 'selected' : '' }}>Publik</option>
                        <option value="0" {{ old('is_published', '1') == '0' ? 'selected' : '' }}>Draft</option>
                    </select>
                    @error('is_published')
                        <p class="mt-1 text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-gray-200 bg-gray-50 p-3 dark:border-gray-700 dark:bg-gray-800">
                    <input
                        type="checkbox"
                        name="is_featured"
                        value="1"
                        {{ old('is_featured') ? 'checked' : '' }}
                        class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 dark:border-gray-600"
                    >
                    <span class="font-medium text-gray-700 dark:text-gray-300">Tampilkan di Beranda</span>
                </label>

                {{-- Upload Gambar (Drag & Drop) --}}
                <div class="md:col-span-2">
                    <span class="mb-2 block font-semibold text-gray-700 dark:text-gray-300">Gambar Album</span>

                    <div
                        id="imageDropzone"
                        tabindex="0"
                        role="button"
                        aria-label="Unggah gambar album"
                        class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 p-5 text-center transition hover:border-emerald-500 hover:bg-emerald-50/40 dark:border-gray-700 dark:bg-gray-800 dark:hover:border-emerald-500 dark:hover:bg-emerald-950/20"
                    >
                        <input
                            type="file"
                            id="imageFileInput"
                            name="image"
                            class="hidden"
                        >

                        {{-- Placeholder --}}
                        <div id="dropzonePlaceholder" class="flex flex-col items-center gap-2">
                            <div class="flex h-11 w-11 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z"/>
                                </svg>
                            </div>
                            <p class="text-xs font-semibold text-gray-900 dark:text-white">Tarik & lepas gambar di sini</p>
                            <p class="text-[10px] text-gray-400">atau klik untuk memilih file gambar dari perangkat Anda</p>
                        </div>

                        {{-- Preview File Terpilih --}}
                        <div id="dropzonePreview" class="hidden w-full flex-col items-center gap-2">
                            <img
                                id="dropzonePreviewImage"
                                src=""
                                alt="Pratinjau gambar"
                                class="h-28 w-full rounded-lg object-cover"
                            >
                            <div class="flex w-full items-center justify-between gap-2">
                                <p id="dropzoneFileName" class="truncate text-[10px] text-gray-500 dark:text-gray-400"></p>
                                <button
                                    type="button"
                                    id="dropzoneRemoveBtn"
                                    class="shrink-0 rounded-md px-2 py-1 text-[10px] font-semibold text-red-600 transition hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/40"
                                >
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>

                    @error('image')
                        <p class="mt-1 text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="mb-2 block font-semibold text-gray-700 dark:text-gray-300">Deskripsi Album</label>
                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        placeholder="Tuliskan deskripsi album..."
                        class="w-full rounded-xl border border-gray-200 bg-gray-50 p-3 text-gray-900 outline-none focus:ring-2 focus:ring-emerald-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-2 border-t border-gray-100 pt-4 dark:border-gray-800 md:col-span-2">
                    <button
                        type="button"
                        onclick="closeFormModal()"
                        class="rounded-lg px-4 py-2 font-semibold text-gray-600 transition hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200"
                    >
                        Batal
                    </button>
                    <button
                        id="gallerySubmitButton"
                        type="submit"
                        class="rounded-lg bg-emerald-600 px-5 py-2 font-semibold text-white shadow-sm transition hover:bg-emerald-700"
                    >
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Image Preview Modal --}}
<div id="imagePreviewModal" class="fixed inset-0 z-60 hidden items-center justify-center p-4" role="dialog" aria-modal="true" aria-labelledby="imagePreviewTitle">
    <div class="absolute inset-0 bg-slate-950/70" onclick="closeImagePreview()"></div>

    <div class="relative w-full max-w-3xl overflow-hidden rounded-xl border border-gray-200 bg-white shadow-2xl dark:border-gray-800 dark:bg-gray-900">
        <div class="flex items-center justify-between border-b border-gray-100 px-4 py-3 dark:border-gray-800">
            <h3 id="imagePreviewTitle" class="text-sm font-bold text-gray-900 dark:text-white">Pratinjau Gambar</h3>
            <button
                type="button"
                onclick="closeImagePreview()"
                class="rounded-lg p-1 text-gray-400 transition hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-800 dark:hover:text-gray-300"
                aria-label="Tutup pratinjau"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="flex items-center justify-center bg-gray-50 p-4 dark:bg-gray-950/40">
            <img
                id="imagePreviewSource"
                src=""
                alt="Pratinjau gambar"
                class="max-h-[70vh] rounded-lg object-contain"
            >
        </div>
    </div>
</div>

{{-- Toast --}}
<div id="toast" class="fixed bottom-5 right-5 z-70 hidden rounded-lg bg-emerald-600 px-4 py-3 text-xs font-semibold text-white shadow-lg"></div>

<script>
    const defaultImage = @json($resolveImage(null));

    const searchInput = document.getElementById('searchInput');
    const galleryTable = document.getElementById('galleryTable');
    const formModal = document.getElementById('formModal');
    const imagePreviewModal = document.getElementById('imagePreviewModal');
    const imagePreviewSource = document.getElementById('imagePreviewSource');
    const imagePreviewTitle = document.getElementById('imagePreviewTitle');

    const imageDropzone = document.getElementById('imageDropzone');
    const imageFileInput = document.getElementById('imageFileInput');
    const dropzonePlaceholder = document.getElementById('dropzonePlaceholder');
    const dropzonePreview = document.getElementById('dropzonePreview');
    const dropzonePreviewImage = document.getElementById('dropzonePreviewImage');
    const dropzoneFileName = document.getElementById('dropzoneFileName');
    const dropzoneRemoveBtn = document.getElementById('dropzoneRemoveBtn');
    const galleryForm = document.getElementById('galleryForm');
    const galleryFormMethod = document.getElementById('galleryFormMethod');
    const formModalTitle = document.getElementById('formModalTitle');
    const gallerySubmitButton = document.getElementById('gallerySubmitButton');

    let previewObjectUrl = null;
    let toastTimer = null;

    function resetGalleryForm() {
        if (!galleryForm) return;

        galleryForm.reset();
        galleryForm.action = '{{ route('admin.gallery.store') }}';

        if (galleryFormMethod) {
            galleryFormMethod.value = 'POST';
        }

        if (gallerySubmitButton) {
            gallerySubmitButton.textContent = 'Simpan';
        }

        if (formModalTitle) {
            formModalTitle.textContent = 'Tambah Album Galeri';
        }

        clearImageFile();
    }

    function populateGalleryForm(item) {
        if (!galleryForm || !item) return;

        const fieldMap = {
            title: item.title ?? '',
            category: item.category ?? 'kegiatan',
            location: item.location ?? '',
            published_at: item.published_at ?? '',
            alt_text: item.alt_text ?? '',
            description: item.description ?? '',
        };

        Object.entries(fieldMap).forEach(([name, value]) => {
            const field = galleryForm.querySelector(`[name="${name}"]`);
            if (field) {
                field.value = value ?? '';
            }
        });

        const isPublishedField = galleryForm.querySelector('[name="is_published"]');
        if (isPublishedField) {
            isPublishedField.value = item.is_published === true || item.is_published === '1' || item.is_published === 1 ? '1' : '0';
        }

        const featuredField = galleryForm.querySelector('[name="is_featured"]');
        if (featuredField) {
            featuredField.checked = !!item.is_featured;
        }

        if (galleryFormMethod) {
            galleryFormMethod.value = 'PUT';
        }

        if (gallerySubmitButton) {
            gallerySubmitButton.textContent = 'Perbarui';
        }

        if (formModalTitle) {
            formModalTitle.textContent = 'Edit Album Galeri';
        }

        if (item.image) {
            const imageUrl = @json($resolveImage(null));
            const currentImage = item.image && item.image.startsWith('http') ? item.image : '{{ url('/') }}' + '/' + item.image.replace(/^\/+/, '');
            dropzonePreviewImage.src = currentImage;
            dropzoneFileName.textContent = item.title || 'Gambar album';
            dropzonePlaceholder.classList.add('hidden');
            dropzonePreview.classList.remove('hidden');
            dropzonePreview.classList.add('flex');
            imageFileInput.value = '';
        } else {
            clearImageFile();
        }

        if (item.edit_url) {
            galleryForm.action = item.edit_url;
        }
    }

    function openFormModal() {
        if (!formModal) return;
        resetGalleryForm();
        formModal.classList.remove('hidden');
        formModal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeFormModal() {
        if (!formModal) return;
        resetGalleryForm();
        formModal.classList.add('hidden');
        formModal.classList.remove('flex');

        if (imagePreviewModal && imagePreviewModal.classList.contains('hidden')) {
            document.body.style.overflow = '';
        }
    }

    function openImagePreview(url, title) {
        if (!imagePreviewModal || !imagePreviewSource) return;

        imagePreviewSource.src = url || defaultImage;
        imagePreviewSource.alt = title || 'Pratinjau gambar';
        imagePreviewTitle.textContent = title || 'Pratinjau Gambar';

        imagePreviewModal.classList.remove('hidden');
        imagePreviewModal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeImagePreview() {
        if (!imagePreviewModal) return;

        imagePreviewModal.classList.add('hidden');
        imagePreviewModal.classList.remove('flex');

        if (formModal && formModal.classList.contains('hidden')) {
            document.body.style.overflow = '';
        }
    }

    function copyImageUrl(url) {
        if (!url) return;

        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(url)
                .then(() => showToast('Tautan gambar berhasil disalin.'))
                .catch(() => fallbackCopy(url));
        } else {
            fallbackCopy(url);
        }
    }

    function fallbackCopy(url) {
        const textarea = document.createElement('textarea');
        textarea.value = url;
        textarea.style.position = 'fixed';
        textarea.style.opacity = '0';

        document.body.appendChild(textarea);
        textarea.select();

        try {
            document.execCommand('copy');
            showToast('Tautan gambar berhasil disalin.');
        } catch (error) {
            showToast('Gagal menyalin tautan.', 'error');
        }

        document.body.removeChild(textarea);
    }

    function showToast(message, type = 'success') {
        const toast = document.getElementById('toast');
        if (!toast) return;

        toast.textContent = message;
        toast.className = 'fixed bottom-5 right-5 z-70 rounded-lg px-4 py-3 text-xs font-semibold text-white shadow-lg transition';
        toast.classList.add(type === 'error' ? 'bg-red-600' : 'bg-emerald-600');

        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => {
            toast.classList.add('hidden');
        }, 2500);
    }

    function filterTable() {
        if (!galleryTable || !searchInput) return;

        const keyword = searchInput.value.toLowerCase().trim();
        const rows = galleryTable.querySelectorAll('tbody tr[data-search]');
        let visibleCount = 0;

        rows.forEach(row => {
            const searchValue = (row.dataset.search || '').toLowerCase();
            const isMatch = searchValue.includes(keyword);

            row.classList.toggle('hidden', !isMatch);

            if (isMatch) {
                visibleCount++;
            }
        });

        const noSearchResultRow = document.getElementById('noSearchResultRow');
        if (noSearchResultRow) {
            noSearchResultRow.classList.toggle('hidden', visibleCount > 0);
        }
    }

    function formatFileSize(bytes) {
        if (!bytes) return '0 B';

        const k = 1024;
        const sizes = ['B', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));

        return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
    }

    function handleImageFile(file) {
        if (!file) return;

        if (previewObjectUrl) {
            URL.revokeObjectURL(previewObjectUrl);
        }

        previewObjectUrl = URL.createObjectURL(file);
        dropzonePreviewImage.src = previewObjectUrl;
        dropzoneFileName.textContent = file.name + ' • ' + formatFileSize(file.size);

        dropzonePlaceholder.classList.add('hidden');
        dropzonePreview.classList.remove('hidden');
        dropzonePreview.classList.add('flex');
    }

    function clearImageFile() {
        if (imageFileInput) imageFileInput.value = '';

        if (previewObjectUrl) {
            URL.revokeObjectURL(previewObjectUrl);
            previewObjectUrl = null;
        }

        if (dropzonePreviewImage) dropzonePreviewImage.src = '';
        if (dropzoneFileName) dropzoneFileName.textContent = '';

        if (dropzonePreview) {
            dropzonePreview.classList.add('hidden');
            dropzonePreview.classList.remove('flex');
        }

        if (dropzonePlaceholder) dropzonePlaceholder.classList.remove('hidden');
    }

    if (imageDropzone && imageFileInput) {
        imageDropzone.addEventListener('click', function(event) {
            if (event.target.closest('#dropzoneRemoveBtn')) return;
            imageFileInput.click();
        });

        imageDropzone.addEventListener('keydown', function(event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                imageFileInput.click();
            }
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            imageDropzone.addEventListener(eventName, function(event) {
                event.preventDefault();
                event.stopPropagation();
                imageDropzone.classList.add('border-emerald-500', 'bg-emerald-50/70', 'dark:bg-emerald-950/20');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            imageDropzone.addEventListener(eventName, function(event) {
                event.preventDefault();
                event.stopPropagation();
                imageDropzone.classList.remove('border-emerald-500', 'bg-emerald-50/70', 'dark:bg-emerald-950/20');
            });
        });

        imageDropzone.addEventListener('drop', function(event) {
            const file = event.dataTransfer.files && event.dataTransfer.files[0];
            if (!file) return;

            try {
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                imageFileInput.files = dataTransfer.files;
            } catch (error) {
                console.warn('Tidak dapat mengatur file input dari drag & drop.', error);
            }

            handleImageFile(file);
        });

        imageFileInput.addEventListener('change', function() {
            handleImageFile(this.files[0]);
        });

        if (dropzoneRemoveBtn) {
            dropzoneRemoveBtn.addEventListener('click', function(event) {
                event.stopPropagation();
                clearImageFile();
            });
        }
    }

    document.addEventListener('click', function(event) {
        const previewButton = event.target.closest('[data-preview-image]');
        if (previewButton) {
            openImagePreview(previewButton.dataset.previewImage, previewButton.dataset.previewTitle);
            return;
        }

        const editButton = event.target.closest('[data-edit-item]');
        if (editButton) {
            try {
                const item = JSON.parse(editButton.dataset.editItem);
                populateGalleryForm(item);
                openFormModal();
            } catch (error) {
                console.error('Gagal memuat data album untuk edit.', error);
            }
            return;
        }

        const copyButton = event.target.closest('[data-copy-link]');
        if (copyButton) {
            copyImageUrl(copyButton.dataset.copyLink);
        }
    });

    if (searchInput) {
        searchInput.addEventListener('input', filterTable);
    }

    if (imagePreviewSource) {
        imagePreviewSource.onerror = function() {
            this.onerror = null;
            this.src = defaultImage;
        };
    }

    document.addEventListener('keydown', function(event) {
        if (event.key !== 'Escape') return;

        if (imagePreviewModal && !imagePreviewModal.classList.contains('hidden')) {
            closeImagePreview();
            return;
        }

        if (formModal && !formModal.classList.contains('hidden')) {
            closeFormModal();
        }
    });

    filterTable();
</script>
@endsection