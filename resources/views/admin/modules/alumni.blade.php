@extends('admin.layouts.app')

@section('title', $title ?? 'Kelola Alumni')
@section('page-heading', $title ?? 'Kelola Alumni')
@section('page-description', $description ?? 'Kelola data alumni yang tampil di halaman depan.')

@section('content')
<div class="space-y-6 rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Modul Admin</p>
            <h2 class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">{{ $title ?? 'Kelola Alumni' }}</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $description ?? 'Kelola data alumni yang tampil di halaman depan.' }}</p>
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
            <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500">Total Alumni</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $stats['total'] ?? 0 }}</p>
            <p class="mt-1 text-[11px] text-slate-500">Semua data</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500">Aktif</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $stats['aktif'] ?? 0 }}</p>
            <p class="mt-1 text-[11px] text-slate-500">Saat ini</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500">Non-Aktif</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $stats['nonaktif'] ?? 0 }}</p>
            <p class="mt-1 text-[11px] text-slate-500">Dihentikan</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500">Jabatan</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $stats['jabatan'] ?? 0 }}</p>
            <p class="mt-1 text-[11px] text-slate-500">Terisi</p>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-100 text-xs uppercase tracking-[0.12em] text-slate-600">
                    <tr>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Jabatan</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($members ?? [] as $member)
                        <tr>
                            <td class="px-4 py-3 font-medium text-slate-900">{{ $member->name }}</td>
                            <td class="px-4 py-3">{{ $member->jabatan }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded-full px-2.5 py-1 text-[10px] font-semibold {{ $member->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-700' }}">
                                    {{ $member->status ?: ($member->is_active ? 'Aktif' : 'Tidak aktif') }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap items-center gap-2">
                                    <form action="{{ route('admin.alumni.toggle', $member) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="rounded-lg border border-amber-200 bg-amber-50 px-2.5 py-1.5 text-[10px] font-semibold text-amber-700 hover:bg-amber-100">
                                            {{ $member->is_active ? 'Non-aktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>

                                    <button type="button" onclick="document.getElementById('edit-alumni-{{ $member->id }}').classList.toggle('hidden')" class="rounded-lg border border-indigo-200 bg-indigo-50 px-2.5 py-1.5 text-[10px] font-semibold text-indigo-700 hover:bg-indigo-100">
                                        Edit
                                    </button>

                                    <form action="{{ route('admin.alumni.delete', $member) }}" method="POST" onsubmit="return confirm('Hapus alumni ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg border border-rose-200 bg-rose-50 px-2.5 py-1.5 text-[10px] font-semibold text-rose-700 hover:bg-rose-100">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <tr id="edit-alumni-{{ $member->id }}" class="hidden bg-slate-50">
                            <td colspan="4" class="px-4 py-4">
                                <form action="{{ route('admin.alumni.update', $member) }}" method="POST" enctype="multipart/form-data" class="grid gap-3 md:grid-cols-2">
                                    @csrf
                                    @method('PUT')

                                    <input type="text" name="name" value="{{ old('name', $member->name) }}" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm" placeholder="Nama lengkap" required>
                                    <input type="text" name="jabatan" value="{{ old('jabatan', $member->jabatan) }}" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm" placeholder="Jabatan" required>
                                    <select name="status" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm">
                                        <option value="Aktif" {{ old('status', $member->status) === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Tidak aktif" {{ old('status', $member->status) === 'Tidak aktif' ? 'selected' : '' }}>Tidak aktif</option>
                                    </select>
                                    <input type="number" name="sort_order" value="{{ old('sort_order', $member->sort_order ?? 0) }}" min="0" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm" placeholder="Urutan">
                                    <textarea name="bio" rows="3" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm md:col-span-2" placeholder="Deskripsi singkat">{{ old('bio', $member->bio) }}</textarea>
                                    <input type="file" name="photo" accept="image/*" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm md:col-span-2">
                                    <label class="inline-flex items-center gap-2 text-sm text-slate-600 md:col-span-2">
                                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $member->is_active) ? 'checked' : '' }}>
                                        Aktif dipublikasikan
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
                            <td colspan="4" class="px-4 py-6 text-center text-sm text-slate-500">Belum ada data alumni.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-slate-900">Formulir Alumni</h3>
            <span class="rounded-full bg-emerald-50 px-2 py-1 text-[10px] font-semibold text-emerald-700">Siap diproses</span>
        </div>

        <form action="{{ route('admin.alumni.store') }}" method="POST" enctype="multipart/form-data" class="grid gap-4 md:grid-cols-2">
            @csrf

            <div class="md:col-span-2">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Foto alumni</span>
                <div id="alumni-upload-box" class="group relative cursor-pointer overflow-hidden rounded-2xl border-2 border-dashed border-slate-300 bg-gradient-to-br from-slate-50 via-white to-indigo-50 p-3 transition-all duration-200 hover:border-indigo-400 hover:bg-indigo-50/80">
                    <div id="alumni-empty-state" class="flex min-h-[170px] flex-col items-center justify-center gap-3 rounded-xl border border-slate-200/80 bg-white/70 px-4 py-5 text-center shadow-inner">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600 shadow-sm">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path d="M12 16V4m0 0l-4 4m4-4l4 4M4 16.5V18a2.5 2.5 0 0 0 2.5 2.5h11A2.5 2.5 0 0 0 20 18v-1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-700">Tarik foto ke sini</p>
                            <p class="mt-1 text-[11px] text-slate-500">atau klik untuk memilih file</p>
                        </div>
                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-600">PNG • JPG • WEBP</span>
                    </div>

                    <div id="alumni-preview-wrap" class="hidden overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                        <img id="alumni-preview" alt="Preview foto alumni" class="h-[170px] w-full object-cover" />
                        <div class="flex items-center justify-between gap-3 border-t border-slate-200 px-3 py-2">
                            <span id="alumni-file-name" class="truncate text-xs font-medium text-slate-700"></span>
                            <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-[0.12em] text-emerald-700">Preview</span>
                        </div>
                    </div>
                </div>

                <input id="alumni-photo-input" type="file" name="photo" accept="image/*" class="hidden">
            </div>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Nama alumni</span>
                <input type="text" name="name" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-indigo-500" placeholder="Masukkan nama lengkap" required>
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Jabatan</span>
                <input type="text" name="jabatan" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-indigo-500" placeholder="Ketua Alumni / Koordinator" required>
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Status</span>
                <select name="status" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-indigo-500">
                    <option value="Aktif">Aktif</option>
                    <option value="Tidak aktif">Tidak aktif</option>
                </select>
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Urutan</span>
                <input type="number" name="sort_order" value="0" min="0" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-indigo-500">
            </label>

            <label class="block md:col-span-2">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Deskripsi singkat</span>
                <textarea name="bio" rows="4" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-indigo-500" placeholder="Deskripsi peran alumni dalam mendukung Pramuka"></textarea>
            </label>

            <div class="md:col-span-2 flex justify-end">
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500">
                    Simpan Alumni
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const uploadBox = document.getElementById('alumni-upload-box');
        const input = document.getElementById('alumni-photo-input');
        const fileLabel = document.getElementById('alumni-file-name');
        const previewWrap = document.getElementById('alumni-preview-wrap');
        const previewImage = document.getElementById('alumni-preview');
        const emptyState = document.getElementById('alumni-empty-state');

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
                uploadBox.classList.add('border-indigo-400', 'bg-indigo-50/80', 'shadow-md');
                uploadBox.classList.remove('border-slate-300');
            });
        });

        ['dragleave', 'drop'].forEach((eventName) => {
            uploadBox.addEventListener(eventName, function (event) {
                event.preventDefault();
                uploadBox.classList.remove('border-indigo-400', 'bg-indigo-50/80', 'shadow-md');
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
