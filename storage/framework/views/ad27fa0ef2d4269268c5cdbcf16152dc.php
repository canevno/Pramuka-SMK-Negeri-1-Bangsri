

<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('page-heading', $title); ?>
<?php $__env->startSection('page-description', $description); ?>

<?php $__env->startSection('content'); ?>
    <?php
        // Kelas bersama agar tampilan form seragam
        $inputClass = 'w-full rounded-lg border border-zinc-200 bg-white px-3 py-2.5 text-sm text-zinc-900 outline-none transition placeholder:text-zinc-400 focus:border-zinc-900 focus:ring-0 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100 dark:placeholder:text-slate-500 dark:focus:border-slate-300';
        $labelClass = 'mb-1.5 block text-[10px] font-semibold uppercase tracking-[0.14em] text-zinc-500 dark:text-slate-400 sm:text-[11px]';
        $btnOutline = 'inline-flex items-center justify-center rounded-lg border border-zinc-200 bg-white px-2 py-1.5 text-[10px] font-semibold text-zinc-700 transition hover:border-zinc-900 hover:text-zinc-900 dark:border-slate-700 dark:bg-transparent dark:text-slate-200 dark:hover:border-slate-300 dark:hover:text-slate-100';
    ?>

    <div class="space-y-3 sm:space-y-4">

        
        <div class="flex flex-col gap-3 sm:gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="min-w-0">
                <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-zinc-500 dark:text-slate-400 sm:text-[11px]">Modul Admin</p>
                <h2 class="mt-1.5 text-xl font-semibold tracking-tight text-zinc-900 dark:text-slate-100 sm:text-2xl"><?php echo e($title); ?></h2>
                <p class="mt-1 text-xs text-zinc-500 dark:text-slate-400 sm:text-sm"><?php echo e($description); ?></p>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($publicRoute) && !empty($publicLabel)): ?>
                <a href="<?php echo e($publicRoute); ?>" class="inline-flex w-full items-center justify-center rounded-lg border border-zinc-200 bg-white px-3 py-2 text-xs font-semibold text-zinc-700 transition hover:border-zinc-900 hover:text-zinc-900 dark:border-slate-700 dark:bg-transparent dark:text-slate-200 dark:hover:border-slate-300 dark:hover:text-slate-100 sm:w-auto sm:px-4 sm:text-sm">
                    <?php echo e($publicLabel); ?>

                </a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($stats)): ?>
            <div class="grid grid-cols-2 gap-2.5 sm:gap-4 xl:grid-cols-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="min-w-0 rounded-xl border border-zinc-200 bg-white p-3 dark:border-slate-800 dark:bg-slate-900/90 sm:p-4">
                        <p class="truncate text-[9px] font-semibold uppercase tracking-[0.16em] text-zinc-500 dark:text-slate-400 sm:text-[10px]"><?php echo e($stat['label']); ?></p>
                        <p class="mt-2 text-xl font-semibold tabular-nums tracking-tight text-zinc-900 dark:text-slate-100 sm:text-2xl"><?php echo e($stat['value']); ?></p>
                        <p class="mt-1 truncate text-[10px] text-zinc-500 dark:text-slate-400 sm:text-[11px]"><?php echo e($stat['caption'] ?? 'Terbaru'); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
            <div class="flex items-start gap-2.5 rounded-lg border border-zinc-200 border-l-2 border-l-zinc-900 bg-white px-3 py-2.5 text-xs text-zinc-800 dark:border-slate-800 dark:border-l-slate-100 dark:bg-slate-900/90 dark:text-slate-200 sm:px-4 sm:py-3 sm:text-sm">
                <svg viewBox="0 0 24 24" class="mt-0.5 h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="m5 12.5 4.5 4.5L19 7.5"/></svg>
                <span class="min-w-0"><?php echo e(session('success')); ?></span>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
            <div class="rounded-lg border border-zinc-300 border-l-2 border-l-zinc-900 bg-zinc-50 px-3 py-2.5 text-xs text-zinc-800 dark:border-slate-700 dark:border-l-slate-100 dark:bg-slate-800/60 dark:text-slate-200 sm:px-4 sm:py-3 sm:text-sm">
                <ul class="list-disc space-y-1 pl-5">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </ul>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <section class="rounded-xl border border-zinc-200 bg-white p-3 dark:border-slate-800 dark:bg-slate-900/90 sm:p-5 lg:p-6">
            <div class="mb-3 flex flex-col gap-2 sm:mb-5 sm:flex-row sm:items-center sm:justify-between sm:border-b sm:border-zinc-100 sm:pb-4 dark:sm:border-slate-800">
                <h3 id="news-form-title" class="text-sm font-semibold text-zinc-900 dark:text-slate-100 sm:text-base">Formulir Berita</h3>
                <span class="inline-flex w-fit items-center gap-1.5 rounded-md border border-zinc-200 px-2 py-0.5 text-[9px] font-medium text-zinc-600 dark:border-slate-700 dark:text-slate-300 sm:text-[10px]">
                    <span class="h-1 w-1 rounded-full bg-zinc-900 dark:bg-slate-100"></span>
                    Siap diproses
                </span>
            </div>

            
            <form id="news-form" action="<?php echo e(route('admin.news.store')); ?>" method="POST" enctype="multipart/form-data" class="grid gap-4 lg:grid-cols-3 lg:gap-8">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="_method" id="news-form-method" value="POST">
                <input type="hidden" name="news_id" id="news-id" value="">
                <input type="hidden" name="current_image_path" id="news-current-image-path" value="">

                
                <div class="min-w-0 space-y-3 sm:space-y-4 lg:col-span-2">
                    <label class="block">
                        <span class="<?php echo e($labelClass); ?>">Judul berita</span>
                        <input id="news-title" type="text" name="title" required class="<?php echo e($inputClass); ?>" placeholder="Masukkan judul berita" />
                    </label>

                    <label class="block">
                        <span class="<?php echo e($labelClass); ?>">Ringkasan</span>
                        <textarea id="news-excerpt" name="excerpt" rows="3" class="<?php echo e($inputClass); ?> resize-y" placeholder="Tuliskan ringkasan berita"></textarea>
                    </label>

                    <label class="block">
                        <span class="<?php echo e($labelClass); ?>">Konten utama</span>
                        <textarea id="news-content" name="content" rows="6" required class="<?php echo e($inputClass); ?> resize-y lg:min-h-[16rem]" placeholder="Tulis isi berita..."></textarea>
                    </label>
                </div>

                
                <div class="min-w-0 lg:border-l lg:border-zinc-100 lg:pl-8 dark:lg:border-slate-800">
                    <div class="grid gap-3 sm:grid-cols-2 sm:gap-4 lg:grid-cols-1">
                        <label class="block min-w-0">
                            <span class="<?php echo e($labelClass); ?>">Kategori</span>
                            <input id="news-type" type="text" name="type" required class="<?php echo e($inputClass); ?>" placeholder="Sosial / Prestasi / Kegiatan" />
                        </label>

                        <label class="block min-w-0">
                            <span class="<?php echo e($labelClass); ?>">Status</span>
                            <select id="news-status" name="is_published" class="<?php echo e($inputClass); ?>">
                                <option value="1">Terbit</option>
                                <option value="0">Draft</option>
                            </select>
                        </label>

                        <label class="block min-w-0">
                            <span class="<?php echo e($labelClass); ?>">Tanggal publikasi</span>
                            <input id="news-published-at" type="date" name="published_at" class="<?php echo e($inputClass); ?>" />
                        </label>

                        <label class="block min-w-0">
                            <span class="<?php echo e($labelClass); ?>">Urutan tampil</span>
                            <input id="news-sort-order" type="number" name="sort_order" min="0" value="<?php echo e($posts->max('sort_order') + 1 ?? 0); ?>" class="<?php echo e($inputClass); ?>" />
                        </label>

                        <label class="block min-w-0 sm:col-span-2 lg:col-span-1">
                            <span class="<?php echo e($labelClass); ?>">Gambar utama</span>
                            <input type="file" name="image" accept="image/*" class="<?php echo e($inputClass); ?> file:mr-3 file:rounded-md file:border-0 file:bg-zinc-100 file:px-3 file:py-1 file:text-xs file:font-semibold file:text-zinc-700 hover:file:bg-zinc-200 dark:file:bg-slate-800 dark:file:text-slate-200 dark:hover:file:bg-slate-700" />
                        </label>
                    </div>
                </div>

                
                <div class="flex flex-col-reverse gap-2 border-t border-zinc-100 pt-3 dark:border-slate-800 sm:flex-row sm:justify-end sm:gap-3 sm:pt-4 lg:col-span-3">
                    <button id="cancel-edit-news" type="button" class="hidden w-full items-center justify-center rounded-lg border border-zinc-200 bg-white px-4 py-2.5 text-sm font-semibold text-zinc-700 transition hover:border-zinc-900 hover:text-zinc-900 dark:border-slate-700 dark:bg-transparent dark:text-slate-200 dark:hover:border-slate-300 sm:w-auto sm:px-5">
                        Batal
                    </button>
                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-zinc-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-zinc-700 dark:bg-slate-100 dark:text-slate-900 dark:hover:bg-slate-300 sm:w-auto sm:px-6">
                        <span id="news-submit-label">Simpan Berita</span>
                    </button>
                </div>
            </form>
        </section>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($posts->isNotEmpty()): ?>
            
            <div class="grid gap-2.5 sm:grid-cols-2 sm:gap-3 md:hidden">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <article class="flex min-w-0 flex-col rounded-xl border border-zinc-200 bg-white p-3 dark:border-slate-800 dark:bg-slate-900/90">
                        <div class="mb-3 flex items-start justify-between gap-2">
                            <div class="min-w-0 flex-1">
                                <h4 class="truncate text-sm font-semibold text-zinc-900 dark:text-slate-100"><?php echo e($post->title); ?></h4>
                                <p class="mt-0.5 truncate text-[11px] text-zinc-500 dark:text-slate-400"><?php echo e($post->type); ?></p>
                            </div>
                            <span class="inline-flex shrink-0 rounded-md px-2 py-0.5 text-[9px] font-semibold ring-1 <?php echo e($post->is_published ? 'bg-zinc-900 text-white ring-zinc-900 dark:bg-slate-100 dark:text-slate-900 dark:ring-slate-100' : 'bg-white text-zinc-700 ring-zinc-300 dark:bg-transparent dark:text-slate-200 dark:ring-slate-600'); ?>">
                                <?php echo e($post->is_published ? 'Terbit' : 'Draft'); ?>

                            </span>
                        </div>

                        <div class="mb-3 flex-1 space-y-1 text-[11px] text-zinc-600 dark:text-slate-300">
                            <p><span class="font-semibold text-zinc-500 dark:text-slate-400">Tanggal:</span> <span class="tabular-nums"><?php echo e($post->published_at?->translatedFormat('d M Y') ?? '-'); ?></span></p>
                            <p class="line-clamp-2 text-zinc-500 dark:text-slate-400"><?php echo e($post->excerpt ?: Str::limit(strip_tags($post->content), 90)); ?></p>
                        </div>

                        <div class="grid grid-cols-2 gap-2 border-t border-zinc-100 pt-3 dark:border-slate-800">
                            <a href="<?php echo e(route('news')); ?>" class="<?php echo e($btnOutline); ?>">Lihat</a>
                            <form action="<?php echo e(route('admin.news.duplicate', $post)); ?>" method="POST" class="w-full">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="<?php echo e($btnOutline); ?> w-full">Duplikat</button>
                            </form>
                            <button type="button" data-post-id="<?php echo e($post->id); ?>" data-title="<?php echo e($post->title); ?>" data-type="<?php echo e($post->type); ?>" data-excerpt="<?php echo e($post->excerpt); ?>" data-content="<?php echo e($post->content); ?>" data-is-published="<?php echo e($post->is_published ? '1' : '0'); ?>" data-published-at="<?php echo e($post->published_at?->format('Y-m-d') ?? ''); ?>" data-sort-order="<?php echo e($post->sort_order ?? 0); ?>" data-image-path="<?php echo e($post->image_path ?? ''); ?>" class="js-edit-news <?php echo e($btnOutline); ?>">Edit</button>
                            <form action="<?php echo e(route('admin.news.delete', $post)); ?>" method="POST" onsubmit="return confirm('Hapus berita ini?')" class="w-full">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="<?php echo e($btnOutline); ?> w-full">Hapus</button>
                            </form>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            
            <div class="hidden overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-slate-800 dark:bg-slate-900/90 md:block">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm text-zinc-600 dark:text-slate-300">
                        <thead class="bg-zinc-50 dark:bg-slate-800/60">
                            <tr class="text-[10px] font-semibold uppercase tracking-[0.12em] text-zinc-500 dark:text-slate-400">
                                <th class="px-3 py-2.5 lg:px-4 lg:py-3">Judul</th>
                                <th class="px-3 py-2.5 lg:px-4 lg:py-3">Kategori</th>
                                <th class="px-3 py-2.5 lg:px-4 lg:py-3">Status</th>
                                <th class="px-3 py-2.5 lg:px-4 lg:py-3">Tanggal</th>
                                <th class="px-3 py-2.5 lg:px-4 lg:py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-slate-800">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="transition hover:bg-zinc-50/70 dark:hover:bg-slate-800/40">
                                    <td class="max-w-[14rem] px-3 py-3 font-medium text-zinc-900 dark:text-slate-100 lg:max-w-sm lg:px-4 xl:max-w-lg">
                                        <span class="block truncate" title="<?php echo e($post->title); ?>"><?php echo e($post->title); ?></span>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-3 lg:px-4"><?php echo e($post->type); ?></td>
                                    <td class="px-3 py-3 lg:px-4">
                                        <span class="inline-flex rounded-md px-2 py-0.5 text-[10px] font-semibold ring-1 <?php echo e($post->is_published ? 'bg-zinc-900 text-white ring-zinc-900 dark:bg-slate-100 dark:text-slate-900 dark:ring-slate-100' : 'bg-white text-zinc-700 ring-zinc-300 dark:bg-transparent dark:text-slate-200 dark:ring-slate-600'); ?>">
                                            <?php echo e($post->is_published ? 'Terbit' : 'Draft'); ?>

                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-3 tabular-nums lg:px-4"><?php echo e($post->published_at?->translatedFormat('d M Y') ?? '-'); ?></td>
                                    <td class="px-3 py-3 lg:px-4">
                                        <div class="flex flex-wrap items-center gap-x-3 gap-y-1">
                                            <a href="<?php echo e(route('news')); ?>" class="text-xs font-semibold text-zinc-500 transition hover:text-zinc-900 dark:text-slate-400 dark:hover:text-slate-100">Lihat</a>
                                            <form action="<?php echo e(route('admin.news.duplicate', $post)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="text-xs font-semibold text-zinc-500 transition hover:text-zinc-900 dark:text-slate-400 dark:hover:text-slate-100">Duplikat</button>
                                            </form>
                                            <button type="button" data-post-id="<?php echo e($post->id); ?>" data-title="<?php echo e($post->title); ?>" data-type="<?php echo e($post->type); ?>" data-excerpt="<?php echo e($post->excerpt); ?>" data-content="<?php echo e($post->content); ?>" data-is-published="<?php echo e($post->is_published ? '1' : '0'); ?>" data-published-at="<?php echo e($post->published_at?->format('Y-m-d') ?? ''); ?>" data-sort-order="<?php echo e($post->sort_order ?? 0); ?>" data-image-path="<?php echo e($post->image_path ?? ''); ?>" class="js-edit-news text-xs font-semibold text-zinc-900 underline decoration-zinc-300 underline-offset-4 transition hover:decoration-zinc-900 dark:text-slate-100 dark:decoration-slate-600 dark:hover:decoration-slate-100">Edit</button>
                                            <form action="<?php echo e(route('admin.news.delete', $post)); ?>" method="POST" onsubmit="return confirm('Hapus berita ini?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="text-xs font-semibold text-zinc-500 transition hover:text-zinc-900 dark:text-slate-400 dark:hover:text-slate-100">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

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
                form.action = '<?php echo e(route('admin.news.store')); ?>';
                methodInput.value = 'POST';
                idInput.value = '';
                currentImageInput.value = '';
                formTitle.textContent = 'Formulir Berita';
                submitLabel.textContent = 'Simpan Berita';
                cancelBtn.classList.add('hidden');
                cancelBtn.classList.remove('inline-flex');
                form.reset();
                sortInput.value = '<?php echo e($posts->max('sort_order') + 1 ?? 0); ?>';
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

                    form.action = '<?php echo e(url('/admin/news')); ?>/' + postId;
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/admin/modules/news.blade.php ENDPATH**/ ?>