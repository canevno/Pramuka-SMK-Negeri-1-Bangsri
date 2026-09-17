

<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('page-heading', $title); ?>
<?php $__env->startSection('page-description', $description); ?>

<?php $__env->startSection('content'); ?>
    <section class="space-y-6 rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Modul Admin</p>
                <h2 class="mt-2 text-2xl font-bold text-slate-900"><?php echo e($title); ?></h2>
                <p class="mt-1 text-sm text-slate-500"><?php echo e($description); ?></p>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($publicRoute) && !empty($publicLabel)): ?>
                <a href="<?php echo e($publicRoute); ?>" class="inline-flex items-center rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-100">
                    <?php echo e($publicLabel); ?>

                </a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($stats)): ?>
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500"><?php echo e($stat['label']); ?></p>
                        <p class="mt-2 text-2xl font-bold text-slate-900"><?php echo e($stat['value']); ?></p>
                        <p class="mt-1 text-[11px] text-slate-500"><?php echo e($stat['caption'] ?? 'Terbaru'); ?></p>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
            <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <ul class="list-disc space-y-1 pl-5">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <li><?php echo e($error); ?></li>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </ul>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
            <div class="mb-4 flex items-center justify-between">
                <h3 id="news-form-title" class="text-lg font-semibold text-slate-900">Formulir Berita</h3>
                <span class="rounded-full bg-emerald-50 px-2 py-1 text-[10px] font-semibold text-emerald-700">Siap diproses</span>
            </div>

            <form id="news-form" action="<?php echo e(route('admin.news.store')); ?>" method="POST" enctype="multipart/form-data" class="grid gap-4 md:grid-cols-2">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="_method" id="news-form-method" value="POST">
                <input type="hidden" name="news_id" id="news-id" value="">
                <input type="hidden" name="current_image_path" id="news-current-image-path" value="">

                <label class="block">
                    <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Judul berita</span>
                    <input id="news-title" type="text" name="title" required class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500" placeholder="Masukkan judul berita" />
                </label>

                <label class="block">
                    <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Kategori</span>
                    <input id="news-type" type="text" name="type" required class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500" placeholder="Sosial / Prestasi / Kegiatan" />
                </label>

                <label class="block">
                    <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Tanggal publikasi</span>
                    <input id="news-published-at" type="date" name="published_at" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500" />
                </label>

                <label class="block">
                    <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Urutan tampil</span>
                    <input id="news-sort-order" type="number" name="sort_order" min="0" value="<?php echo e($posts->max('sort_order') + 1 ?? 0); ?>" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500" />
                </label>

                <label class="block">
                    <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Status</span>
                    <select id="news-status" name="is_published" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500">
                        <option value="1">Terbit</option>
                        <option value="0">Draft</option>
                    </select>
                </label>

                <label class="block md:col-span-2">
                    <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Ringkasan</span>
                    <textarea id="news-excerpt" name="excerpt" rows="3" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500" placeholder="Tuliskan ringkasan berita"></textarea>
                </label>

                <label class="block md:col-span-2">
                    <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Konten utama</span>
                    <textarea id="news-content" name="content" rows="6" required class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500" placeholder="Tulis isi berita..."></textarea>
                </label>

                <label class="block md:col-span-2">
                    <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Gambar utama</span>
                    <input type="file" name="image" accept="image/*" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500" />
                </label>

                <div class="md:col-span-2 flex justify-end gap-3">
                    <button id="cancel-edit-news" type="button" class="hidden items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                        Batal
                    </button>
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-[#0D1B2A] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
                        <span id="news-submit-label">Simpan Berita</span>
                    </button>
                </div>
            </form>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($posts->isNotEmpty()): ?>
            <div class="overflow-hidden rounded-2xl border border-slate-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-100 text-xs uppercase tracking-[0.12em] text-slate-600">
                            <tr>
                                <th class="px-4 py-3">Judul</th>
                                <th class="px-4 py-3">Kategori</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr>
                                    <td class="px-4 py-3 font-medium text-slate-900"><?php echo e($post->title); ?></td>
                                    <td class="px-4 py-3"><?php echo e($post->type); ?></td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex rounded-full px-2 py-1 text-[10px] font-semibold <?php echo e($post->is_published ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700'); ?>">
                                            <?php echo e($post->is_published ? 'Terbit' : 'Draft'); ?>

                                        </span>
                                    </td>
                                    <td class="px-4 py-3"><?php echo e($post->published_at?->translatedFormat('d M Y') ?? '-'); ?></td>
                                    <td class="px-4 py-3">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <a href="<?php echo e(route('news')); ?>" class="text-xs font-semibold text-slate-600 hover:text-slate-900">Lihat</a>
                                            <form action="<?php echo e(route('admin.news.duplicate', $post)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700">Duplikat</button>
                                            </form>
                                            <button type="button" data-post-id="<?php echo e($post->id); ?>" data-title="<?php echo e($post->title); ?>" data-type="<?php echo e($post->type); ?>" data-excerpt="<?php echo e($post->excerpt); ?>" data-content="<?php echo e($post->content); ?>" data-is-published="<?php echo e($post->is_published ? '1' : '0'); ?>" data-published-at="<?php echo e($post->published_at?->format('Y-m-d') ?? ''); ?>" data-sort-order="<?php echo e($post->sort_order ?? 0); ?>" data-image-path="<?php echo e($post->image_path ?? ''); ?>" class="js-edit-news text-xs font-semibold text-amber-600 hover:text-amber-700">Edit</button>
                                            <form action="<?php echo e(route('admin.news.delete', $post)); ?>" method="POST" onsubmit="return confirm('Hapus berita ini?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="text-xs font-semibold text-red-600 hover:text-red-700">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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