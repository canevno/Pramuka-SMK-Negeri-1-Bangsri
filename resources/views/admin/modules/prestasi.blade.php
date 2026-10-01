@extends('admin.layouts.app')

@section('title', $title)
@section('page-heading', $title)
@section('page-description', $description)

@section('content')
    <style>
        .prestasi-scrollbar-hidden {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .prestasi-scrollbar-hidden::-webkit-scrollbar {
            display: none;
        }
    </style>

    @php
        $stats = [
            ['label' => 'Total Prestasi', 'value' => count($achievements ?? []), 'caption' => 'Data tersimpan', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
            ['label' => 'Tahun Terbaru', 'value' => (count($achievements ?? []) > 0 ? (string) ($achievements[0]['year'] ?? now()->year) : '-'), 'caption' => 'Pencapaian terakhir', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
            ['label' => 'Kategori', 'value' => count(array_unique(array_column($achievements ?? [], 'category'))), 'caption' => 'Jenis prestasi', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
            ['label' => 'Status', 'value' => 'Aktif', 'caption' => 'Publikasi berjalan', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ];

        $labelClass = 'mb-1.5 block text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400';
        $inputClass = 'w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-base text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-900 focus:ring-4 focus:ring-slate-900/10 sm:text-sm dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:placeholder-slate-500 dark:focus:border-white dark:focus:ring-white/10';
        $mobileLabelClass = 'text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-400 md:hidden dark:text-slate-500';
    @endphp

    <div class="space-y-5 sm:space-y-6">

        {{-- Statistik --}}
        <div class="grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-4">
            @foreach($stats as $stat)
                <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5 dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex items-start justify-between gap-2">
                        <p class="min-w-0 text-[10px] font-semibold uppercase leading-snug tracking-[0.14em] text-slate-500 sm:text-[11px] sm:tracking-[0.2em] dark:text-slate-400">{{ $stat['label'] }}</p>
                        <div class="shrink-0 rounded-xl bg-slate-100 p-2 text-slate-600 sm:p-2.5 dark:bg-slate-800 dark:text-slate-300">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"></path></svg>
                        </div>
                    </div>
                    <p class="mt-3 text-2xl font-bold text-slate-900 sm:mt-4 sm:text-3xl dark:text-white">{{ $stat['value'] }}</p>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ $stat['caption'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="space-y-5 sm:space-y-6">

            {{-- Daftar Prestasi --}}
            <div class="min-w-0 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 px-4 py-4 sm:px-5 dark:border-slate-800">
                    <div class="min-w-0">
                        <h3 class="text-base font-semibold text-slate-900 dark:text-white">Daftar Prestasi</h3>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Kelola data pencapaian yang sudah masuk.</p>
                    </div>
                    <span class="inline-flex shrink-0 items-center rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                        {{ count($achievements ?? []) }} Item
                    </span>
                </div>

                <div class="prestasi-scrollbar-hidden md:overflow-x-auto">
                    <table class="block w-full text-left text-sm text-slate-600 md:table dark:text-slate-300">
                        <thead class="hidden bg-slate-50 text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-500 md:table-header-group dark:bg-slate-800/50 dark:text-slate-400">
                            <tr>
                                <th class="px-5 py-3">Judul</th>
                                <th class="px-5 py-3">Kategori</th>
                                <th class="px-5 py-3">Tahun</th>
                                <th class="px-5 py-3">Pemenang</th>
                                <th class="px-5 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="block divide-y divide-slate-200 md:table-row-group dark:divide-slate-800">
                            @forelse($achievements ?? [] as $achievement)
                                <tr class="block px-4 py-4 align-top transition hover:bg-slate-50/70 md:table-row md:p-0 dark:hover:bg-slate-800/40">
                                    <td class="block pb-2 md:table-cell md:px-5 md:py-4">
                                        <div class="font-semibold leading-snug text-slate-900 dark:text-white">{{ $achievement['title'] }}</div>
                                    </td>
                                    <td class="flex items-center justify-between gap-3 py-1.5 md:table-cell md:px-5 md:py-4">
                                        <span class="{{ $mobileLabelClass }}">Kategori</span>
                                        <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                                            {{ $achievement['category'] }}
                                        </span>
                                    </td>
                                    <td class="flex items-center justify-between gap-3 py-1.5 md:table-cell md:whitespace-nowrap md:px-5 md:py-4">
                                        <span class="{{ $mobileLabelClass }}">Tahun</span>
                                        <span>{{ $achievement['year'] }}</span>
                                    </td>
                                    <td class="flex items-center justify-between gap-3 py-1.5 text-slate-700 md:table-cell md:px-5 md:py-4 dark:text-slate-300">
                                        <span class="{{ $mobileLabelClass }}">Pemenang</span>
                                        <span class="text-right md:text-left">{{ $achievement['winner'] }}</span>
                                    </td>
                                    <td class="block pt-3 md:table-cell md:px-5 md:py-4 md:text-right">
                                        <div class="flex gap-2 md:justify-end">
                                            <button type="button"
                                                title="Edit"
                                                data-edit-id="{{ $achievement['id'] }}"
                                                data-edit-title="{{ $achievement['title'] }}"
                                                data-edit-category="{{ $achievement['category'] }}"
                                                data-edit-year="{{ $achievement['year'] }}"
                                                data-edit-date="{{ $achievement['date'] ?? '' }}"
                                                data-edit-location="{{ $achievement['location'] ?? '' }}"
                                                data-edit-winner="{{ $achievement['winner'] }}"
                                                data-edit-winner-link="{{ $achievement['winner_social_link'] ?? '' }}"
                                                data-edit-description="{{ $achievement['description'] ?? '' }}"
                                                class="js-edit-achievement inline-flex flex-1 items-center justify-center gap-1.5 rounded-lg border border-slate-900 bg-slate-900 px-2.5 py-2 text-[11px] font-medium text-white transition hover:border-slate-700 hover:bg-slate-700 md:flex-none md:py-1.5 dark:border-white dark:bg-white dark:text-slate-900 dark:hover:bg-slate-200">
                                                <svg class="h-3.5 w-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-9.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 7.5-7.5z"></path></svg>
                                                <span class="md:sr-only lg:not-sr-only">Edit</span>
                                            </button>

                                            <form method="POST" action="{{ route('admin.prestasi.duplicate', $achievement['id']) }}" class="flex flex-1 md:flex-none">
                                                @csrf
                                                <button type="submit" title="Duplikat" class="inline-flex w-full items-center justify-center gap-1.5 rounded-lg border border-slate-300 bg-white px-2.5 py-2 text-[11px] font-medium text-slate-700 transition hover:border-slate-400 hover:bg-slate-100 md:w-auto md:py-1.5 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">
                                                    <svg class="h-3.5 w-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                                    <span class="md:sr-only lg:not-sr-only">Duplikat</span>
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('admin.prestasi.delete', $achievement['id']) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus prestasi ini? Tindakan ini tidak dapat dibatalkan.')" class="flex flex-1 md:flex-none">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Hapus" class="inline-flex w-full items-center justify-center gap-1.5 rounded-lg border border-slate-300 bg-white px-2.5 py-2 text-[11px] font-medium text-slate-900 transition hover:border-slate-900 hover:bg-slate-900 hover:text-white md:w-auto md:py-1.5 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:hover:border-white dark:hover:bg-white dark:hover:text-slate-900">
                                                    <svg class="h-3.5 w-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    <span class="md:sr-only lg:not-sr-only">Hapus</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="block md:table-row">
                                    <td colspan="5" class="block px-6 py-12 text-center md:table-cell">
                                        <div class="mx-auto h-12 w-12 rounded-full bg-slate-100 p-3 dark:bg-slate-800">
                                            <svg class="h-6 w-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                        </div>
                                        <p class="mt-3 text-sm font-medium text-slate-900 dark:text-white">Belum ada data prestasi</p>
                                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Mulai tambahkan prestasi baru menggunakan formulir di bawah ini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Form Tambah / Edit Prestasi --}}
            <div id="achievement-form-card" class="scroll-mt-24 min-w-0 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="border-b border-slate-200 px-4 py-4 sm:px-5 dark:border-slate-800">
                    <h3 class="text-base font-semibold text-slate-900 dark:text-white">Tambah Prestasi</h3>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Isi detail pencapaian baru.</p>
                </div>

                <form method="POST" action="{{ route('admin.prestasi.store') }}" enctype="multipart/form-data" class="grid gap-5 p-4 sm:p-5 lg:grid-cols-2 lg:gap-x-6" id="achievement-form">
                    @csrf
                    <input type="hidden" name="edit_id" id="edit_id" value="">

                    <div class="lg:col-span-2">
                        <label for="achievement_title" class="{{ $labelClass }}">Judul Prestasi <span class="text-slate-900 dark:text-white">*</span></label>
                        <input id="achievement_title" type="text" name="title" required class="{{ $inputClass }}" placeholder="Contoh: Juara 1 Lomba Pionering" />
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="achievement_category" class="{{ $labelClass }}">Kategori <span class="text-slate-900 dark:text-white">*</span></label>
                            <select id="achievement_category" name="category" required class="{{ $inputClass }}">
                                <option value="">Pilih tingkat prestasi</option>
                                <option value="Tingkat Ranting">Tingkat Ranting</option>
                                <option value="Tingkat Cabang">Tingkat Cabang</option>
                                <option value="Tingkat Jateng">Tingkat Jateng</option>
                                <option value="Tingkat Nasional">Tingkat Nasional</option>
                            </select>
                        </div>
                        <div>
                            <label for="achievement_year" class="{{ $labelClass }}">Tahun <span class="text-slate-900 dark:text-white">*</span></label>
                            <input id="achievement_year" type="number" name="year" value="{{ now()->year }}" required min="2000" max="2100" class="{{ $inputClass }}" />
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="achievement_date" class="{{ $labelClass }}">Tanggal <span class="text-slate-900 dark:text-white">*</span></label>
                            <input id="achievement_date" type="date" name="date" required class="{{ $inputClass }}" />
                        </div>
                        <div>
                            <label for="achievement_location" class="{{ $labelClass }}">Lokasi <span class="text-slate-900 dark:text-white">*</span></label>
                            <input id="achievement_location" type="text" name="location" required class="{{ $inputClass }}" placeholder="Contoh: Jepara, Semarang" />
                        </div>
                    </div>

                    <div>
                        <label for="achievement_winner" class="{{ $labelClass }}">Pemenang / Peserta <span class="text-slate-900 dark:text-white">*</span></label>
                        <input id="achievement_winner" type="text" name="winner" required class="{{ $inputClass }}" placeholder="Nama anggota atau regu" />
                    </div>

                    <div>
                        <label for="achievement_winner_link" class="{{ $labelClass }}">Instagram / Link Media Sosial</label>
                        <input id="achievement_winner_link" type="url" name="winner_social_link" class="{{ $inputClass }}" placeholder="https://instagram.com/username" />
                        <p class="mt-1.5 text-[11px] text-slate-400">Kosongkan jika tidak ingin menampilkan instagram.</p>
                    </div>

                    <div class="flex flex-col">
                        <label for="achievement_description" class="{{ $labelClass }}">Deskripsi <span class="text-slate-900 dark:text-white">*</span></label>
                        <textarea id="achievement_description" rows="6" name="description" required class="{{ $inputClass }} resize-y lg:min-h-[10rem] lg:flex-1" placeholder="Tuliskan deskripsi singkat pencapaian..."></textarea>
                    </div>

                    <div>
                        <input type="hidden" name="image_path" value="images/achievement/prestasi1.jpg">
                        <label class="{{ $labelClass }}">Gambar Prestasi</label>

                        <div id="prestasi-upload-box" class="group relative cursor-pointer overflow-hidden rounded-2xl border-2 border-dashed border-slate-300 bg-slate-50 p-3 transition-all duration-200 hover:border-slate-500 hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-800/60 dark:hover:border-slate-400 dark:hover:bg-slate-800">
                            <div id="prestasi-empty-state" class="flex min-h-[170px] flex-col items-center justify-center gap-3 rounded-xl border border-slate-200/80 bg-white/70 px-4 py-5 text-center shadow-inner dark:border-slate-700 dark:bg-slate-950/30">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-slate-900 text-white shadow-sm dark:bg-white dark:text-slate-900">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-700 dark:text-slate-100">Tarik gambar ke sini</p>
                                    <p class="mt-1 text-[11px] text-slate-500 dark:text-slate-400">atau klik untuk memilih file</p>
                                </div>
                                <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-600 dark:bg-slate-800 dark:text-slate-300">JPG • PNG • WEBP</span>
                            </div>

                            <div id="prestasi-preview-wrap" class="hidden overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-950/40">
                                <img id="prestasi-preview" alt="Preview prestasi" class="h-[170px] w-full object-cover" />
                                <div class="flex items-center justify-between gap-3 border-t border-slate-200 px-3 py-2 dark:border-slate-700">
                                    <span id="prestasi-file-name" class="truncate text-xs font-medium text-slate-700 dark:text-slate-200"></span>
                                    <span class="shrink-0 rounded-full bg-slate-900 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-[0.12em] text-white dark:bg-white dark:text-slate-900">Preview</span>
                                </div>
                            </div>
                        </div>

                        <input id="prestasi-image-input" type="file" name="image" accept="image/*" class="hidden" />
                        <p class="mt-2 text-[11px] text-slate-400">Biarkan default jika tidak ada gambar khusus.</p>
                    </div>

                    <div class="flex justify-end border-t border-slate-200 pt-5 lg:col-span-2 dark:border-slate-800">
                        <button type="submit" id="achievement-submit-button" class="flex w-full items-center justify-center gap-2 rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:ring-offset-2 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-200 dark:focus:ring-white sm:w-auto sm:min-w-52 sm:py-2.5 dark:focus:ring-offset-slate-900">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            <span id="achievement-submit-label">Simpan Prestasi</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('achievement-form');
        const formCard = document.getElementById('achievement-form-card');
        const submitLabel = document.getElementById('achievement-submit-label');
        const editId = document.getElementById('edit_id');
        const titleInput = document.getElementById('achievement_title');
        const categoryInput = document.getElementById('achievement_category');
        const yearInput = document.getElementById('achievement_year');
        const dateInput = document.getElementById('achievement_date');
        const locationInput = document.getElementById('achievement_location');
        const winnerInput = document.getElementById('achievement_winner');
        const winnerLinkInput = document.getElementById('achievement_winner_link');
        const descriptionInput = document.getElementById('achievement_description');

        document.querySelectorAll('.js-edit-achievement').forEach(function (button) {
            button.addEventListener('click', function () {
                const id = button.dataset.editId;
                const title = button.dataset.editTitle || '';
                const category = button.dataset.editCategory || '';
                const year = button.dataset.editYear || '{{ now()->year }}';
                const date = button.dataset.editDate || '';
                const location = button.dataset.editLocation || '';
                const winner = button.dataset.editWinner || '';
                const winnerLink = button.dataset.editWinnerLink || '';
                const description = button.dataset.editDescription || '';

                editId.value = id;
                titleInput.value = title;
                categoryInput.value = category;
                yearInput.value = year;
                dateInput.value = date;
                locationInput.value = location;
                winnerInput.value = winner;
                winnerLinkInput.value = winnerLink;
                descriptionInput.value = description;

                form.action = '{{ route('admin.prestasi.store') }}';
                submitLabel.textContent = 'Perbarui Prestasi';
                titleInput.focus({ preventScroll: true });
                if (formCard) {
                    formCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
                } else {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            });
        });

        form.addEventListener('submit', function () {
            if (!editId.value) {
                form.action = '{{ route('admin.prestasi.store') }}';
                return;
            }

            form.action = '{{ route('admin.prestasi.store') }}';
        });
        const uploadBox = document.getElementById('prestasi-upload-box');
        const input = document.getElementById('prestasi-image-input');
        const fileLabel = document.getElementById('prestasi-file-name');
        const previewWrap = document.getElementById('prestasi-preview-wrap');
        const previewImage = document.getElementById('prestasi-preview');
        const emptyState = document.getElementById('prestasi-empty-state');

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
                uploadBox.classList.add('border-slate-500', 'bg-slate-100', 'dark:bg-slate-800', 'shadow-md');
                uploadBox.classList.remove('border-slate-300');
            });
        });

        ['dragleave', 'drop'].forEach((eventName) => {
            uploadBox.addEventListener(eventName, function (event) {
                event.preventDefault();
                uploadBox.classList.remove('border-slate-500', 'bg-slate-100', 'dark:bg-slate-800', 'shadow-md');
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