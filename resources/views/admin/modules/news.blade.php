@extends('admin.layouts.app')

@section('title', $title)
@section('page-heading', $title)
@section('page-description', $description)

@section('content')
    <section class="space-y-4 rounded-[1.5rem] border border-slate-200 bg-white p-3 shadow-sm dark:border-slate-800 dark:bg-slate-900 dark:shadow-slate-950/30 sm:space-y-6 sm:rounded-[2rem] sm:p-6">
        <div class="flex flex-col gap-3 sm:gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 sm:text-[11px] dark:text-slate-400">Modul Admin</p>
                <h2 class="mt-2 text-xl font-bold text-slate-900 sm:text-2xl dark:text-slate-100">{{ $title }}</h2>
                <p class="mt-1 text-xs text-slate-500 sm:text-sm dark:text-slate-400">{{ $description }}</p>
            </div>

            @if(!empty($publicRoute) && !empty($publicLabel))
                <a href="{{ $publicRoute }}" class="inline-flex items-center justify-center rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-2 text-xs font-semibold text-emerald-700 transition hover:bg-emerald-100 dark:border-emerald-800/70 dark:bg-emerald-500/10 dark:text-emerald-300 dark:hover:bg-emerald-500/15 sm:px-4 sm:text-sm">
                    {{ $publicLabel }}
                </a>
            @endif
        </div>

        @if(!empty($stats))
            <div class="grid grid-cols-2 gap-3 sm:gap-4 xl:grid-cols-4">
                @foreach($stats as $stat)
                    <div class="min-h-[110px] rounded-2xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-700 dark:bg-slate-800/80 sm:p-4">
                        <p class="text-[9px] font-semibold uppercase tracking-[0.16em] text-slate-500 sm:text-[10px] dark:text-slate-400">{{ $stat['label'] }}</p>
                        <p class="mt-2 text-xl font-bold text-slate-900 sm:text-2xl dark:text-slate-100">{{ $stat['value'] }}</p>
                        <p class="mt-1 text-[10px] text-slate-500 sm:text-[11px] dark:text-slate-400">{{ $stat['caption'] ?? 'Terbaru' }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        @if(session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-800/80 dark:bg-emerald-500/10 dark:text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-red-800/80 dark:bg-red-500/10 dark:text-red-300">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-700 dark:bg-slate-800/70 sm:p-5">
            <div class="mb-3 flex flex-col gap-2 sm:mb-4 sm:flex-row sm:items-center sm:justify-between">
                <h3 id="news-form-title" class="text-base font-semibold text-slate-900 sm:text-lg dark:text-slate-100">Formulir Berita</h3>
                <span class="inline-flex w-fit rounded-full bg-emerald-50 px-2 py-1 text-[9px] font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300 sm:text-[10px]">Siap diproses</span>
            </div>

            <form id="news-form" action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="grid gap-3 sm:gap-4 md:grid-cols-2">
                @csrf
                <input type="hidden" name="_method" id="news-form-method" value="POST">
                <input type="hidden" name="news_id" id="news-id" value="">
                <input type="hidden" name="current_image_path" id="news-current-image-path" value="">

                <label class="block">
                    <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Judul berita</span>
                    <input id="news-title" type="text" name="title" required class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100 dark:placeholder:text-slate-500" placeholder="Masukkan judul berita" />
                </label>

                <label class="block">
                    <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Kategori</span>
                    <input id="news-type" type="text" name="type" required class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100 dark:placeholder:text-slate-500" placeholder="Sosial / Prestasi / Kegiatan" />
                </label>

                <label class="block">
                    <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Tanggal publikasi</span>
                    <input id="news-published-at" type="date" name="published_at" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100" />
                </label>

                <label class="block">
                    <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Urutan tampil</span>
                    <input id="news-sort-order" type="number" name="sort_order" min="0" value="{{ $posts->max('sort_order') + 1 ?? 0 }}" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100" />
                </label>

                <label class="block">
                    <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Status</span>
                    <select id="news-status" name="is_published" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100">
                        <option value="1">Terbit</option>
                        <option value="0">Draft</option>
                    </select>
                </label>

                <label class="block md:col-span-2">
                    <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Ringkasan</span>
                    <textarea id="news-excerpt" name="excerpt" rows="3" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100 dark:placeholder:text-slate-500" placeholder="Tuliskan ringkasan berita"></textarea>
                </label>

                <label class="block md:col-span-2">
                    <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Konten utama</span>
                    <textarea id="news-content" name="content" rows="6" required class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100 dark:placeholder:text-slate-500" placeholder="Tulis isi berita..."></textarea>
                </label>

                <label class="block md:col-span-2">
                    <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Gambar utama</span>
                    <input type="file" name="image" accept="image/*" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100" />
                </label>

                <div class="md:col-span-2 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end sm:gap-3">
                    <button id="cancel-edit-news" type="button" class="hidden items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700 sm:px-5 sm:py-2.5">
                        Batal
                    </button>
                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-xl bg-[#0D1B2A] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800 dark:bg-emerald-600 dark:hover:bg-emerald-500 sm:w-auto sm:px-5 sm:py-2.5">
                        <span id="news-submit-label">Simpan Berita</span>
                    </button>
                </div>
            </form>
        </div>

        @if($posts->isNotEmpty())
            <div class="space-y-3 md:hidden">
                @foreach($posts as $post)
                    <article class="rounded-2xl border border-slate-200 bg-white p-3 shadow-sm dark:border-slate-700 dark:bg-slate-800/80 dark:shadow-slate-950/30">
                        <div class="mb-3 flex items-start justify-between gap-2">
                            <div class="min-w-0 flex-1">
                                <h4 class="truncate text-sm font-bold text-slate-900 dark:text-slate-100">{{ $post->title }}</h4>
                                <p class="mt-1 text-[11px] text-slate-500 dark:text-slate-400">{{ $post->type }}</p>
                            </div>
                            <span class="inline-flex shrink-0 rounded-full px-2 py-0.5 text-[9px] font-semibold {{ $post->is_published ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300' : 'bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-300' }}">
                                {{ $post->is_published ? 'Terbit' : 'Draft' }}
                            </span>
                        </div>

                        <div class="mb-3 space-y-1 text-[11px] text-slate-600 dark:text-slate-300">
                            <p><span class="font-semibold text-slate-500 dark:text-slate-400">Tanggal:</span> {{ $post->published_at?->translatedFormat('d M Y') ?? '-' }}</p>
                            <p class="line-clamp-2">{{ $post->excerpt ?: Str::limit(strip_tags($post->content), 90) }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('news') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-slate-50 px-2 py-1.5 text-[10px] font-semibold text-slate-700 dark:border-slate-600 dark:bg-slate-900 dark:text-slate-200">Lihat</a>
                            <form action="{{ route('admin.news.duplicate', $post) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full rounded-lg border border-emerald-200 bg-emerald-50 px-2 py-1.5 text-[10px] font-semibold text-emerald-700 dark:border-emerald-800/70 dark:bg-emerald-500/10 dark:text-emerald-300">Duplikat</button>
                            </form>
                            <button type="button" data-post-id="{{ $post->id }}" data-title="{{ $post->title }}" data-type="{{ $post->type }}" data-excerpt="{{ $post->excerpt }}" data-content="{{ $post->content }}" data-is-published="{{ $post->is_published ? '1' : '0' }}" data-published-at="{{ $post->published_at?->format('Y-m-d') ?? '' }}" data-sort-order="{{ $post->sort_order ?? 0 }}" data-image-path="{{ $post->image_path ?? '' }}" class="js-edit-news rounded-lg border border-amber-200 bg-amber-50 px-2 py-1.5 text-[10px] font-semibold text-amber-700 dark:border-amber-800/70 dark:bg-amber-500/10 dark:text-amber-300">Edit</button>
                            <form action="{{ route('admin.news.delete', $post) }}" method="POST" onsubmit="return confirm('Hapus berita ini?')" class="w-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full rounded-lg border border-rose-200 bg-rose-50 px-2 py-1.5 text-[10px] font-semibold text-rose-700 dark:border-rose-800/70 dark:bg-rose-500/10 dark:text-rose-300">Hapus</button>
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="hidden overflow-hidden rounded-2xl border border-slate-200 md:block dark:border-slate-700">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm text-slate-600 dark:text-slate-300">
                        <thead class="bg-slate-100 text-[10px] uppercase tracking-[0.12em] text-slate-600 sm:text-xs dark:bg-slate-800 dark:text-slate-300">
                            <tr>
                                <th class="px-3 py-2.5 sm:px-4 sm:py-3">Judul</th>
                                <th class="px-3 py-2.5 sm:px-4 sm:py-3">Kategori</th>
                                <th class="px-3 py-2.5 sm:px-4 sm:py-3">Status</th>
                                <th class="px-3 py-2.5 sm:px-4 sm:py-3">Tanggal</th>
                                <th class="px-3 py-2.5 sm:px-4 sm:py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-700 dark:bg-slate-900/60">
                            @foreach($posts as $post)
                                <tr>
                                    <td class="px-3 py-2.5 font-medium text-slate-900 sm:px-4 sm:py-3 dark:text-slate-100">{{ $post->title }}</td>
                                    <td class="px-3 py-2.5 sm:px-4 sm:py-3">{{ $post->type }}</td>
                                    <td class="px-3 py-2.5 sm:px-4 sm:py-3">
                                        <span class="inline-flex rounded-full px-2 py-1 text-[10px] font-semibold {{ $post->is_published ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300' : 'bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-300' }}">
                                            {{ $post->is_published ? 'Terbit' : 'Draft' }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2.5 sm:px-4 sm:py-3">{{ $post->published_at?->translatedFormat('d M Y') ?? '-' }}</td>
                                    <td class="px-3 py-2.5 sm:px-4 sm:py-3">
                                        <div class="flex flex-wrap items-center gap-1.5 sm:gap-2">
                                            <a href="{{ route('news') }}" class="text-[11px] font-semibold text-slate-600 hover:text-slate-900 sm:text-xs dark:text-slate-300 dark:hover:text-slate-100">Lihat</a>
                                            <form action="{{ route('admin.news.duplicate', $post) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-[11px] font-semibold text-emerald-600 hover:text-emerald-700 sm:text-xs dark:text-emerald-300 dark:hover:text-emerald-200">Duplikat</button>
                                            </form>
                                            <button type="button" data-post-id="{{ $post->id }}" data-title="{{ $post->title }}" data-type="{{ $post->type }}" data-excerpt="{{ $post->excerpt }}" data-content="{{ $post->content }}" data-is-published="{{ $post->is_published ? '1' : '0' }}" data-published-at="{{ $post->published_at?->format('Y-m-d') ?? '' }}" data-sort-order="{{ $post->sort_order ?? 0 }}" data-image-path="{{ $post->image_path ?? '' }}" class="js-edit-news text-[11px] font-semibold text-amber-600 hover:text-amber-700 sm:text-xs dark:text-amber-300 dark:hover:text-amber-200">Edit</button>
                                            <form action="{{ route('admin.news.delete', $post) }}" method="POST" onsubmit="return confirm('Hapus berita ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-[11px] font-semibold text-red-600 hover:text-red-700 sm:text-xs dark:text-red-300 dark:hover:text-red-200">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('news-form');
            const formTitle = document.getElementById('news-form-title');
            const submitLabel = document.getElementById('news-submit-label');
            const cancelBtn = document.getElementById('cancel-edit-news');
            const methodInput = document.getElementById('news-form-method');
            const idInput = document.getElementById('news-id');
            const titleInput = document.getElementById('news-title');
            const typeInput = document.getElementById('news-type');
            const excerptInput = document.getElementById('news-excerpt');
            const contentInput = document.getElementById('news-content');
            const publishedAtInput = document.getElementById('news-published-at');
            const statusInput = document.getElementById('news-status');
            const sortInput = document.getElementById('news-sort-order');
            const currentImageInput = document.getElementById('news-current-image-path');

            const resetForm = () => {
                form.action = '{{ route('admin.news.store') }}';
                methodInput.value = 'POST';
                idInput.value = '';
                currentImageInput.value = '';
                formTitle.textContent = 'Formulir Berita';
                submitLabel.textContent = 'Simpan Berita';
                cancelBtn.classList.add('hidden');
                cancelBtn.classList.remove('inline-flex');
                form.reset();
                sortInput.value = '{{ $posts->max('sort_order') + 1 ?? 0 }}';
                statusInput.value = '1';
            };

            cancelBtn.addEventListener('click', resetForm);

            document.querySelectorAll('.js-edit-news').forEach(function (button) {
                button.addEventListener('click', function () {
                    const postId = button.dataset.postId;
                    const title = button.dataset.title || '';
                    const type = button.dataset.type || '';
                    const excerpt = button.dataset.excerpt || '';
                    const content = button.dataset.content || '';
                    const publishedAt = button.dataset.publishedAt || '';
                    const isPublished = button.dataset.isPublished || '1';
                    const sortOrder = button.dataset.sortOrder || '0';
                    const imagePath = button.dataset.imagePath || '';

                    form.action = '{{ url('/admin/news') }}/' + postId;
                    methodInput.value = 'PUT';
                    idInput.value = postId;
                    currentImageInput.value = imagePath;
                    formTitle.textContent = 'Edit Berita';
                    submitLabel.textContent = 'Perbarui Berita';
                    cancelBtn.classList.remove('hidden');
                    cancelBtn.classList.add('inline-flex');

                    titleInput.value = title;
                    typeInput.value = type;
                    excerptInput.value = excerpt;
                    contentInput.value = content;
                    publishedAtInput.value = publishedAt;
                    statusInput.value = isPublished;
                    sortInput.value = sortOrder;

                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            });

            form.addEventListener('submit', function () {
                methodInput.value = methodInput.value || 'POST';
            });
        });
    </script>
@endsection
