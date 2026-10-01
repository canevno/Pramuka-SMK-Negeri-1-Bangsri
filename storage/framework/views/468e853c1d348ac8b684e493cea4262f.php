

<?php $__env->startSection('content'); ?>
<section class="bg-white py-8 sm:py-10">
    <div class="mx-auto max-w-[1280px] px-4 sm:px-4 lg:px-5">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(empty($newsItems)): ?>
            <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center text-slate-500">
                Belum ada berita yang dipublikasikan.
            </div>
        <?php else: ?>
            <?php
                $featured = $newsItems[0];
                $related = array_slice($newsItems, 1);
                $newsData = collect($newsItems)->map(fn ($n) => [
                    'category' => $n['category'],
                    'date' => $n['date'],
                    'title' => $n['title'],
                    'image' => $n['image'],
                    'alt' => $n['alt'],
                    'description' => $n['description'],
                    'url' => route('berita.show', ['slug' => $n['slug'] ?? Str::slug($n['title'])]),
                ])->values();
            ?>

            <div class="mx-auto grid max-w-[1180px] gap-8 lg:grid-cols-[minmax(0,1.2fr)_420px]">
                <article class="max-w-[760px]">
                    <div class="mb-3 flex items-center justify-between gap-3">
                        <div id="featured-category" class="text-[11px] font-medium text-slate-600">
                            <?php echo e($featured['category']); ?>

                        </div>

                        <div class="inline-flex items-center gap-1.5 text-[11px] font-medium text-slate-500">
                            <svg class="h-3.5 w-3.5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <span id="featured-date"><?php echo e($featured['date']); ?></span>
                        </div>
                    </div>

                    <a href="<?php echo e(route('berita.show', ['slug' => $featured['slug'] ?? Str::slug($featured['title'])])); ?>" class="block" data-featured-link>
                        <h1 id="featured-title" class="mb-5 text-2xl font-bold leading-[1.1] text-slate-900 sm:text-[2.5rem]"><?php echo e($featured['title']); ?></h1>
                    </a>

                    <a href="<?php echo e(route('berita.show', ['slug' => $featured['slug'] ?? Str::slug($featured['title'])])); ?>" class="block" data-featured-link>
                        <div class="mt-5 overflow-hidden rounded-xl bg-slate-100">
                            <img id="featured-image" src="<?php echo e($featured['image']); ?>" alt="<?php echo e($featured['alt']); ?>" class="h-[220px] w-full object-cover sm:h-[330px]">
                        </div>
                    </a>

                    <div class="mt-6 space-y-6 text-base leading-6 text-slate-700">
                        <p id="featured-description" class="text-justify sm:text-left">
                            <?php echo e($featured['description']); ?>

                        </p>
                        <p class="text-justify sm:text-left">
                            Berita ini menampilkan kegiatan, prestasi, dan dinamika terbaru yang sedang berkembang di lingkungan sekolah dan organisasi Pramuka. Informasi ini menjadi referensi penting bagi siswa, orang tua, dan pemangku kepentingan dalam mengikuti kegiatan yang telah berlangsung.
                        </p>
                    </div>
                </article>

                <aside class="space-y-6">
                    <div class="rounded-none border-0 bg-transparent p-0 shadow-none sm:rounded-xl sm:border sm:border-slate-200 sm:bg-white sm:p-4 sm:shadow-sm">
                        <h3 class="text-center text-lg font-semibold text-slate-900 sm:text-left">Berita Lainnya</h3>

                        <div class="related-scroll mt-4 space-y-4 lg:max-h-[600px] lg:overflow-y-auto lg:pr-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('berita.show', ['slug' => $item['slug'] ?? Str::slug($item['title'])])); ?>" data-news-index="<?php echo e($loop->index + 1); ?>" class="flex items-center gap-3 overflow-hidden rounded-lg border-0 bg-transparent p-0 transition hover:bg-slate-50 sm:border sm:border-slate-100 sm:bg-white sm:p-1.5">
                                    <div class="flex h-[92px] w-[128px] shrink-0 items-center justify-center overflow-hidden rounded-md bg-slate-100">
                                        <img src="<?php echo e($item['image']); ?>" alt="<?php echo e($item['alt']); ?>" class="h-full w-full object-cover object-center">
                                    </div>
                                    <div class="min-w-0 flex-1 self-center pr-1">
                                        <div class="flex items-center gap-2">
                                            <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-slate-500"><?php echo e($item['category']); ?></p>
                                            <span class="text-[9px] text-slate-400">•</span>
                                            <p class="text-[9px] font-medium text-slate-400"><?php echo e($item['date']); ?></p>
                                        </div>
                                        <h4 class="mt-1.5 text-left text-[0.95rem] font-semibold leading-5 text-slate-900 line-clamp-2"><?php echo e($item['title']); ?></h4>
                                        <p class="mt-1 text-left text-[11px] leading-5 text-slate-600 line-clamp-2"><?php echo e($item['description']); ?></p>
                                    </div>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </aside>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <script>
            (() => {
                const news = <?php echo json_encode($newsData, 15, 512) ?>;
                const $ = (id) => document.getElementById(id);

                const showFeatured = (item) => {
                    $('featured-category').textContent = item.category;
                    $('featured-date').textContent = item.date;
                    $('featured-title').textContent = item.title;
                    $('featured-description').textContent = item.description;

                    const img = $('featured-image');
                    img.src = item.image;
                    img.alt = item.alt;

                    document.querySelectorAll('[data-featured-link]').forEach((a) => {
                        a.href = item.url;
                    });
                };

                document.querySelectorAll('[data-news-index]').forEach((link) => {
                    link.addEventListener('click', (e) => {
                        const item = news[Number(link.dataset.newsIndex)];
                        if (!item) {
                            return;
                        }

                        e.preventDefault();
                        showFeatured(item);

                        // Di mobile, naik ke artikel utama supaya perubahannya terlihat
                        if (window.innerWidth < 1024) {
                            $('featured-title').scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    });
                });
            })();
        </script>

        <style>
            @media (min-width: 1024px) {
                .related-scroll {
                    scrollbar-width: none;
                    -ms-overflow-style: none;
                }
                .related-scroll::-webkit-scrollbar {
                    display: none;
                }
            }
        </style>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/pages/news.blade.php ENDPATH**/ ?>