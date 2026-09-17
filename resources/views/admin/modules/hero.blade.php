@extends('admin.layouts.app')

@section('title', $title ?? 'Kelola Hero')
@section('page-heading', $title ?? 'Kelola Hero')
@section('page-description', $description ?? 'Atur konten banner utama yang tampil di halaman depan website.')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-4 md:grid-cols-3">
        @foreach(($stats ?? []) as $stat)
            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="text-xs uppercase tracking-[0.12em] text-slate-400">{{ $stat['label'] }}</div>
                <div class="mt-2 text-2xl font-bold text-slate-900">{{ $stat['value'] }}</div>
                <div class="mt-1 text-xs text-slate-500">{{ $stat['caption'] }}</div>
            </div>
        @endforeach
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="mb-4 flex items-center justify-between gap-3">
            <div>
                <h3 class="text-lg font-semibold text-slate-900">Daftar Slide Hero</h3>
                <p class="text-sm text-slate-500">Slide aktif akan otomatis tampil di bagian hero home.</p>
            </div>
            <a href="{{ $publicRoute ?? route('home') }}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                {{ $publicLabel ?? 'Lihat Halaman Depan' }}
            </a>
        </div>

        <div class="space-y-4">
            @forelse($slides as $slide)
                <div class="flex flex-col gap-4 rounded-2xl border border-slate-200 p-4 md:flex-row md:items-center">
                    <div class="h-28 w-full overflow-hidden rounded-xl bg-slate-100 md:w-52">
                        @if($slide->image)
                            <img src="{{ str_starts_with($slide->image, 'http') ? $slide->image : asset($slide->image) }}" alt="{{ $slide->title }}" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full items-center justify-center text-sm text-slate-400">No image</div>
                        @endif
                    </div>

                    <div class="flex-1 space-y-2">
                        <div class="flex flex-wrap items-center gap-2">
                            <h4 class="text-lg font-semibold text-slate-900">{{ $slide->title }}</h4>
                            <span class="rounded-full px-2 py-1 text-[10px] font-semibold {{ $slide->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600' }}">
                                {{ $slide->is_active ? 'Aktif' : 'Draft' }}
                            </span>
                            <span class="text-[10px] uppercase tracking-[0.12em] text-slate-400">Urutan {{ $slide->sort_order ?? 0 }}</span>
                        </div>
                        <p class="text-sm text-slate-600">{{ $slide->excerpt ?: 'Tidak ada deskripsi.' }}</p>
                        <p class="text-xs text-slate-400">Link: {{ $slide->href ?: route('news') }}</p>
                    </div>

                    <div class="flex items-center gap-2 md:flex-col">
                        <form method="POST" action="{{ route('admin.hero.toggle', $slide) }}">
                            @csrf
                            <button type="submit" class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                {{ $slide->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>

                        <button type="button"
                                data-edit-slide="{{ json_encode([
                                    'id' => $slide->id,
                                    'title' => $slide->title,
                                    'excerpt' => $slide->excerpt,
                                    'href' => $slide->href,
                                    'image' => $slide->image,
                                    'is_active' => (bool) $slide->is_active,
                                    'sort_order' => (int) ($slide->sort_order ?? 0),
                                    'update_url' => route('admin.hero.update', $slide),
                                ]) }}"
                                class="js-edit-slide rounded-lg bg-slate-900 px-3 py-2 text-xs font-semibold text-white hover:bg-slate-700">
                            Edit
                        </button>

                        <form method="POST" action="{{ route('admin.hero.delete', $slide) }}" onsubmit="return confirm('Hapus slide ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-100">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-8 text-center text-slate-500">
                    Belum ada slide hero. Tambahkan slide pertama untuk tampil di halaman depan.
                </div>
            @endforelse
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="mb-4">
            <h3 id="hero-form-title" class="text-lg font-semibold text-slate-900">Tambah Slide Hero</h3>
        </div>

        <form id="hero-form" action="{{ route('admin.hero.store') }}" method="POST" enctype="multipart/form-data" class="grid gap-4 md:grid-cols-2">
            @csrf
            <input type="hidden" name="_method" id="hero-method" value="POST">

            <div class="md:col-span-2">
                <label class="mb-1 block text-sm font-medium text-slate-700">Judul</label>
                <input type="text" name="title" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm outline-none ring-0 focus:border-slate-500">
            </div>

            <div class="md:col-span-2">
                <label class="mb-1 block text-sm font-medium text-slate-700">Deskripsi</label>
                <textarea name="excerpt" rows="3" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm outline-none focus:border-slate-500"></textarea>
            </div>

            <div class="md:col-span-2">
                <label class="mb-1 block text-sm font-medium text-slate-700">Link tujuan</label>
                <input type="text" name="href" value="{{ route('news') }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm outline-none focus:border-slate-500">
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Gambar</label>
                <input type="file" name="image" accept="image/*" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm file:mr-3 file:rounded file:border-0 file:bg-slate-900 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-white">
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Urutan</label>
                <input type="number" name="sort_order" min="0" value="0" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm outline-none focus:border-slate-500">
            </div>

            <div class="md:col-span-2 flex items-center gap-2">
                <input type="checkbox" id="hero_is_active" name="is_active" value="1" checked class="h-4 w-4 rounded border-slate-300 text-slate-900 focus:ring-slate-500">
                <label for="hero_is_active" class="text-sm text-slate-700">Tampilkan di homepage</label>
            </div>

            <div class="md:col-span-2 flex justify-end gap-3">
                <button type="button" id="cancel-edit-hero" class="hidden rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</button>
                <button type="submit" class="rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-700">Simpan Slide</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('#hero-form');
        const methodInput = document.querySelector('#hero-method');
        const formTitle = document.querySelector('#hero-form-title');
        const cancelBtn = document.querySelector('#cancel-edit-hero');

        document.querySelectorAll('.js-edit-slide').forEach(button => {
            button.addEventListener('click', function () {
                const slide = JSON.parse(this.dataset.editSlide);
                form.action = slide.update_url;
                methodInput.value = 'PUT';
                formTitle.textContent = 'Edit Slide Hero';
                cancelBtn.classList.remove('hidden');

                form.querySelector('[name="title"]').value = slide.title || '';
                form.querySelector('[name="excerpt"]').value = slide.excerpt || '';
                form.querySelector('[name="href"]').value = slide.href || '{{ route('news') }}';
                form.querySelector('[name="sort_order"]').value = slide.sort_order ?? 0;
                form.querySelector('[name="is_active"]').checked = slide.is_active === true;
            });
        });

        cancelBtn.addEventListener('click', function () {
            form.action = '{{ route('admin.hero.store') }}';
            methodInput.value = 'POST';
            formTitle.textContent = 'Tambah Slide Hero';
            cancelBtn.classList.add('hidden');
            form.reset();
            form.querySelector('[name="is_active"]').checked = true;
        });
    });
</script>
@endsection
