@extends('admin.layouts.app')

@section('title', $title ?? 'Kelola Timeline Kegiatan')
@section('page-heading', $title ?? 'Kelola Timeline Kegiatan')
@section('page-description', $description ?? 'Kelola jadwal dan kegiatan yang tampil di homepage.')

@php
    $statusLabels = [
        'upcoming' => 'Akan datang',
        'ongoing' => 'Berlangsung',
        'completed' => 'Selesai',
    ];
    $statusClasses = [
        'upcoming' => 'bg-sky-100 text-sky-700 dark:bg-sky-500/10 dark:text-sky-300',
        'ongoing' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-300',
        'completed' => 'bg-slate-200 text-slate-700 dark:bg-slate-700 dark:text-slate-200',
    ];
    $openEditId = (str_starts_with((string) old('_form'), 'edit-')) ? substr(old('_form'), 5) : null;
@endphp

@section('content')
<div class="space-y-4 rounded-[1.5rem] border border-slate-200 bg-white p-3 shadow-sm sm:space-y-6 sm:rounded-[2rem] sm:p-6 dark:border-slate-800 dark:bg-slate-900">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400 sm:text-[11px]">Modul Admin</p>
            <h2 class="mt-2 text-xl font-bold text-slate-900 sm:text-2xl dark:text-white">{{ $title ?? 'Kelola Timeline Kegiatan' }}</h2>
            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400 sm:text-sm">{{ $description ?? 'Kelola jadwal dan kegiatan yang tampil di homepage.' }}</p>
        </div>

        <div class="flex flex-wrap gap-2">
            <a href="#form-tambah" class="inline-flex items-center rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-500">
                Tambah kegiatan
            </a>
            @if(! empty($publicRoute) && ! empty($publicLabel))
                <a href="{{ $publicRoute }}" target="_blank" rel="noopener" class="inline-flex items-center rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-100 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300 dark:hover:bg-emerald-500/20">
                    {{ $publicLabel }}
                </a>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="flex items-start justify-between gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-300">
            <p>{{ session('success') }}</p>
            <button type="button" onclick="this.parentElement.remove()" class="text-lg leading-none opacity-70 transition hover:opacity-100" aria-label="Tutup notifikasi">&times;</button>
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700 dark:border-rose-500/30 dark:bg-rose-500/10 dark:text-rose-300">
            <p class="mb-1 font-semibold">Data belum tersimpan. Periksa bagian berikut:</p>
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700 dark:border-rose-500/30 dark:bg-rose-500/10 dark:text-rose-300">
            {{ session('error') }}
        </div>
    @endif

    {{-- ───────── Statistik ───────── --}}
    <div class="grid grid-cols-2 gap-3 sm:gap-4 xl:grid-cols-4">
        @foreach([
            ['Total kegiatan', $stats['total'] ?? 0, 'Semua data'],
            ['Akan datang', $stats['upcoming'] ?? 0, 'Menunggu tanggal'],
            ['Tampil di publik', $stats['active'] ?? 0, 'Status aktif'],
            ['Selesai', $stats['completed'] ?? 0, 'Sudah terlaksana'],
        ] as [$statLabel, $statValue, $statCaption])
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-800 dark:bg-slate-800/40 sm:p-4">
                <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400 sm:text-[10px]">{{ $statLabel }}</p>
                <p class="mt-2 text-xl font-bold text-slate-900 dark:text-white sm:text-2xl">{{ $statValue }}</p>
                <p class="mt-1 text-[10px] text-slate-500 dark:text-slate-400 sm:text-[11px]">{{ $statCaption }}</p>
            </div>
        @endforeach
    </div>

    {{-- ───────── Daftar (mobile: kartu) ───────── --}}
    <div class="space-y-3 md:hidden">
        @forelse($events ?? [] as $event)
            <article class="rounded-2xl border border-slate-200 bg-white p-3 shadow-sm dark:border-slate-700 dark:bg-slate-900">
                <div class="mb-3 flex items-start justify-between gap-2">
                    <div class="min-w-0 flex-1">
                        <h4 class="text-sm font-bold text-slate-900 dark:text-white">{{ $event->title }}</h4>
                        <p class="mt-1 text-[11px] text-slate-500 dark:text-slate-400">
                            {{ \Illuminate\Support\Carbon::parse($event->date)->translatedFormat('d F Y') }}
                            @if($event->time) &middot; {{ substr($event->time, 0, 5) }} @endif
                        </p>
                    </div>
                    <div class="flex shrink-0 flex-col items-end gap-1">
                        <span class="inline-flex rounded-full px-2 py-0.5 text-[9px] font-semibold {{ $statusClasses[$event->status] ?? $statusClasses['upcoming'] }}">
                            {{ $statusLabels[$event->status] ?? $event->status }}
                        </span>
                        @unless($event->is_active)
                            <span class="inline-flex rounded-full bg-rose-100 px-2 py-0.5 text-[9px] font-semibold text-rose-700 dark:bg-rose-500/10 dark:text-rose-300">Disembunyikan</span>
                        @endunless
                    </div>
                </div>

                <div class="space-y-1 text-[11px] text-slate-600 dark:text-slate-300">
                    <p>
                        <span class="font-semibold text-slate-500 dark:text-slate-400">Lokasi:</span>
                        @if(! empty($event->location_url))
                            <a href="{{ $event->location_url }}" target="_blank" rel="noopener" class="text-emerald-600 hover:underline dark:text-emerald-400">{{ $event->location }}</a>
                        @else
                            {{ $event->location }}
                        @endif
                    </p>
                    <p><span class="font-semibold text-slate-500 dark:text-slate-400">Waktu:</span> {{ $event->time ? substr($event->time, 0, 5) : 'Belum diatur' }}</p>
                </div>

                <div class="mt-3 grid grid-cols-2 gap-2">
                    <form action="{{ route('admin.timeline.toggle', $event) }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full rounded-lg border border-amber-200 bg-amber-50 px-2 py-1.5 text-[10px] font-semibold text-amber-700 dark:border-amber-700/50 dark:bg-amber-500/10 dark:text-amber-300">
                            {{ $event->is_active ? 'Sembunyikan' : 'Tampilkan' }}
                        </button>
                    </form>

                    <button type="button" data-modal-open="edit-timeline-{{ $event->id }}" class="w-full rounded-lg border border-emerald-200 bg-emerald-50 px-2 py-1.5 text-[10px] font-semibold text-emerald-700 dark:border-emerald-500/40 dark:bg-emerald-500/10 dark:text-emerald-300">
                        Edit
                    </button>

                    <a href="{{ route('event.show', $event->id) }}" target="_blank" rel="noopener" class="w-full rounded-lg border border-slate-200 bg-slate-50 px-2 py-1.5 text-center text-[10px] font-semibold text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200">
                        Lihat detail
                    </a>

                    <form action="{{ route('admin.timeline.delete', $event) }}" method="POST" data-confirm="Hapus kegiatan &quot;{{ $event->title }}&quot;? Tindakan ini tidak bisa dibatalkan." class="w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full rounded-lg border border-rose-200 bg-rose-50 px-2 py-1.5 text-[10px] font-semibold text-rose-700 dark:border-rose-500/40 dark:bg-rose-500/10 dark:text-rose-300">
                            Hapus
                        </button>
                    </form>
                </div>
            </article>
        @empty
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 text-center text-sm text-slate-500 dark:border-slate-700 dark:bg-slate-800/60 dark:text-slate-400">
                Belum ada kegiatan. Tambahkan kegiatan pertama lewat formulir di bawah.
            </div>
        @endforelse
    </div>

    {{-- ───────── Daftar (desktop: tabel) ───────── --}}
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
                            <td class="px-4 py-3 font-medium text-slate-900 dark:text-white">
                                <div class="flex items-center gap-3">
                                    @if(! empty($event->logo_path))
                                        <img src="{{ preg_match('/^https?:\/\//', $event->logo_path) ? $event->logo_path : asset('storage/' . ltrim($event->logo_path, '/')) }}" alt="" class="h-10 w-10 shrink-0 rounded-lg border border-slate-200 bg-white object-contain dark:border-slate-700">
                                    @endif
                                    <span>{{ $event->title }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 dark:text-slate-300">
                                {{ \Illuminate\Support\Carbon::parse($event->date)->translatedFormat('d F Y') }}
                                <br>
                                <span class="text-[11px] text-slate-500 dark:text-slate-400">{{ $event->time ? substr($event->time, 0, 5) : 'Waktu belum diatur' }}</span>
                            </td>
                            <td class="px-4 py-3 dark:text-slate-300">
                                @if(! empty($event->location_url))
                                    <a href="{{ $event->location_url }}" target="_blank" rel="noopener" class="text-emerald-600 hover:underline dark:text-emerald-400">{{ $event->location }}</a>
                                @else
                                    {{ $event->location }}
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-1">
                                    <span class="rounded-full px-2.5 py-1 text-[10px] font-semibold {{ $statusClasses[$event->status] ?? $statusClasses['upcoming'] }}">
                                        {{ $statusLabels[$event->status] ?? $event->status }}
                                    </span>
                                    @unless($event->is_active)
                                        <span class="rounded-full bg-rose-100 px-2.5 py-1 text-[10px] font-semibold text-rose-700 dark:bg-rose-500/10 dark:text-rose-300">Disembunyikan</span>
                                    @endunless
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap items-center gap-2">
                                    <form action="{{ route('admin.timeline.toggle', $event) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="rounded-lg border border-amber-200 bg-amber-50 px-2.5 py-1.5 text-[10px] font-semibold text-amber-700 hover:bg-amber-100 dark:border-amber-700/50 dark:bg-amber-500/10 dark:text-amber-300 dark:hover:bg-amber-500/20">
                                            {{ $event->is_active ? 'Sembunyikan' : 'Tampilkan' }}
                                        </button>
                                    </form>

                                    <button type="button" data-modal-open="edit-timeline-{{ $event->id }}" class="rounded-lg border border-emerald-200 bg-emerald-50 px-2.5 py-1.5 text-[10px] font-semibold text-emerald-700 hover:bg-emerald-100 dark:border-emerald-500/40 dark:bg-emerald-500/10 dark:text-emerald-300 dark:hover:bg-emerald-500/20">
                                        Edit
                                    </button>

                                    <a href="{{ route('event.show', $event->id) }}" target="_blank" rel="noopener" class="rounded-lg border border-slate-200 bg-slate-50 px-2.5 py-1.5 text-[10px] font-semibold text-slate-700 hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">
                                        Lihat
                                    </a>

                                    <form action="{{ route('admin.timeline.delete', $event) }}" method="POST" data-confirm="Hapus kegiatan &quot;{{ $event->title }}&quot;? Tindakan ini tidak bisa dibatalkan.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg border border-rose-200 bg-rose-50 px-2.5 py-1.5 text-[10px] font-semibold text-rose-700 hover:bg-rose-100 dark:border-rose-500/40 dark:bg-rose-500/10 dark:text-rose-300 dark:hover:bg-rose-500/20">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-sm text-slate-500 dark:text-slate-400">Belum ada kegiatan. Tambahkan kegiatan pertama lewat formulir di bawah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ───────── Formulir tambah ───────── --}}
    <div id="form-tambah" class="scroll-mt-24 rounded-2xl border border-slate-200 bg-slate-50 p-4 sm:p-5 dark:border-slate-700 dark:bg-slate-800/80">
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Tambah kegiatan</h3>
            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Kegiatan terdekat yang berstatus tampil akan muncul di kartu hitung mundur homepage.</p>
        </div>

        @include('admin.modules.partials.timeline-form', ['action' => route('admin.timeline.store')])
    </div>
</div>

{{-- ───────── Modal edit (satu per kegiatan; bekerja di mobile & desktop) ───────── --}}
@foreach($events ?? [] as $event)
    <div id="edit-timeline-{{ $event->id }}" data-modal class="fixed inset-0 z-[70] hidden items-start justify-center overflow-y-auto p-3 sm:p-6" role="dialog" aria-modal="true" aria-labelledby="edit-title-{{ $event->id }}">
        <div class="fixed inset-0 bg-slate-900/60" data-modal-close></div>
        <div class="relative my-4 w-full max-w-3xl rounded-2xl bg-white p-4 shadow-2xl sm:p-6 dark:bg-slate-900">
            <div class="mb-4 flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <h3 id="edit-title-{{ $event->id }}" class="text-lg font-semibold text-slate-900 dark:text-white">Edit kegiatan</h3>
                    <p class="truncate text-xs text-slate-500 dark:text-slate-400">{{ $event->title }}</p>
                </div>
                <button type="button" data-modal-close class="rounded-lg p-1.5 text-slate-500 transition hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800" aria-label="Tutup">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18" stroke-linecap="round"/></svg>
                </button>
            </div>

            @include('admin.modules.partials.timeline-form', [
                'action' => route('admin.timeline.update', $event),
                'event' => $event,
            ])
        </div>
    </div>
@endforeach
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    /* ───────── Konfirmasi hapus ───────── */
    document.querySelectorAll('form[data-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            if (! window.confirm(form.getAttribute('data-confirm'))) {
                e.preventDefault();
            }
        });
    });

    /* ───────── Modal edit ───────── */
    function openModal(id) {
        var modal = document.getElementById(id);
        if (! modal) return;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal(modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        if (! document.querySelector('[data-modal].flex')) {
            document.body.classList.remove('overflow-hidden');
        }
    }

    document.querySelectorAll('[data-modal-open]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            openModal(btn.getAttribute('data-modal-open'));
        });
    });

    document.querySelectorAll('[data-modal]').forEach(function (modal) {
        modal.querySelectorAll('[data-modal-close]').forEach(function (el) {
            el.addEventListener('click', function () { closeModal(modal); });
        });
    });

    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;
        document.querySelectorAll('[data-modal].flex').forEach(closeModal);
    });

    @if($openEditId)
        // Validasi gagal saat edit: buka kembali modal yang bersangkutan
        openModal('edit-timeline-{{ $openEditId }}');
    @endif

    /* ───────── Cegah browser membuka file yang dijatuhkan di luar dropzone ───────── */
    ['dragover', 'drop'].forEach(function (evt) {
        window.addEventListener(evt, function (e) {
            if (! e.target.closest || ! e.target.closest('[data-logo-zone]')) e.preventDefault();
        });
    });

    /* ───────── Dropzone logo + preview ───────── */
    var MAX_BYTES = 4 * 1024 * 1024;
    var ALLOWED = ['image/png', 'image/jpeg', 'image/webp'];

    function formatSize(bytes) {
        if (bytes >= 1024 * 1024) return (bytes / 1024 / 1024).toFixed(2) + ' MB';
        return Math.max(1, Math.round(bytes / 1024)) + ' KB';
    }

    document.querySelectorAll('[data-logo-zone]').forEach(function (zone) {
        var input = zone.querySelector('[data-input]');
        var removeFlag = zone.querySelector('[data-remove]');
        var emptyBox = zone.querySelector('[data-empty]');
        var filledBox = zone.querySelector('[data-filled]');
        var preview = zone.querySelector('[data-preview]');
        var nameEl = zone.querySelector('[data-name]');
        var metaEl = zone.querySelector('[data-meta]');
        var badge = zone.querySelector('[data-badge]');
        var errorEl = zone.querySelector('[data-error]');
        var clearBtn = zone.querySelector('[data-clear]');
        var currentUrl = zone.getAttribute('data-current') || '';
        var objectUrl = null;

        function showError(msg) {
            errorEl.textContent = msg;
            errorEl.classList.toggle('hidden', ! msg);
        }

        function showEmpty() {
            emptyBox.classList.remove('hidden');
            filledBox.classList.add('hidden');
            preview.removeAttribute('src');
        }

        function showFilled(src, name, meta, isNew) {
            preview.src = src;
            nameEl.textContent = name;
            metaEl.textContent = meta;
            badge.textContent = isNew ? 'Baru' : 'Logo saat ini';
            emptyBox.classList.add('hidden');
            filledBox.classList.remove('hidden');
        }

        function releaseObjectUrl() {
            if (objectUrl) {
                URL.revokeObjectURL(objectUrl);
                objectUrl = null;
            }
        }

        function handleFile(file) {
            showError('');

            if (ALLOWED.indexOf(file.type) === -1) {
                input.value = '';
                showError('Format tidak didukung. Gunakan PNG, JPG, atau WEBP.');
                return;
            }

            if (file.size > MAX_BYTES) {
                input.value = '';
                showError('Ukuran file ' + formatSize(file.size) + ' melebihi batas 4 MB.');
                return;
            }

            releaseObjectUrl();
            objectUrl = URL.createObjectURL(file);
            removeFlag.value = '0';

            var img = new Image();
            img.onload = function () {
                showFilled(objectUrl, file.name, img.naturalWidth + ' × ' + img.naturalHeight + ' px · ' + formatSize(file.size), true);
            };
            img.onerror = function () {
                input.value = '';
                releaseObjectUrl();
                showError('File tidak dapat dibaca sebagai gambar.');
                if (currentUrl) {
                    showFilled(currentUrl, 'Logo saat ini', '', false);
                } else {
                    showEmpty();
                }
            };
            img.src = objectUrl;
        }

        // Keadaan awal: tampilkan logo yang sudah tersimpan (mode edit)
        if (currentUrl) {
            showFilled(currentUrl, 'Logo saat ini', 'Pilih file baru untuk menggantinya', false);
        }

        input.addEventListener('change', function () {
            if (input.files && input.files[0]) {
                handleFile(input.files[0]);
            }
        });

        clearBtn.addEventListener('click', function () {
            input.value = '';
            releaseObjectUrl();
            showError('');

            // Bila yang dihapus adalah logo tersimpan, minta server menghapusnya saat disimpan.
            removeFlag.value = currentUrl ? '1' : '0';
            showEmpty();
        });

        ['dragenter', 'dragover'].forEach(function (evt) {
            zone.addEventListener(evt, function (e) {
                e.preventDefault();
                zone.classList.add('ring-2', 'ring-emerald-400');
            });
        });

        ['dragleave', 'dragend', 'drop'].forEach(function (evt) {
            zone.addEventListener(evt, function (e) {
                e.preventDefault();
                zone.classList.remove('ring-2', 'ring-emerald-400');
            });
        });

        zone.addEventListener('drop', function (e) {
            var files = e.dataTransfer && e.dataTransfer.files;
            if (! files || files.length === 0) return;

            try {
                var dt = new DataTransfer();
                dt.items.add(files[0]);
                input.files = dt.files;
                handleFile(files[0]);
            } catch (err) {
                showError('Browser Anda tidak mendukung seret & lepas. Klik area ini untuk memilih file.');
            }
        });
    });
});
</script>
@endpush