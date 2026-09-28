<?php
    $posts = \App\Models\Post::query()
        ->where('is_published', true)
        ->orderByDesc('published_at')
        ->orderByDesc('id')
        ->limit(8)
        ->get();

    $newsItems = $posts->map(function ($post) {
        $date = $post->published_at ? $post->published_at->translatedFormat('l, d F Y') : 'Tanggal belum diatur';

        $image = $post->image_path;
        if (empty($image)) {
            $image = 'images/logokegiatan1.png';
        } elseif (! filter_var($image, FILTER_VALIDATE_URL)) {
            $image = str_starts_with($image, 'storage/') ? asset($image) : asset('storage/' . ltrim($image, '/'));
        }

        return [
            'category' => $post->type ?: 'Berita',
            'title' => $post->title,
            'date' => $date,
            'description' => $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->content ?? ''), 140),
            'image' => $image,
            'alt' => $post->title,
            'badge' => $post->published_at && $post->published_at->isToday() ? 'BARU' : 'SOROTAN',
        ];
    })->all();
?>

<section class="bg-[#f8fafc] py-10 dark:bg-slate-950 transition-colors duration-200">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-6 border-b border-slate-200 pb-4 text-center dark:border-slate-800 sm:flex sm:items-center sm:justify-between sm:text-left">
            <h2 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                Berita &amp; Pengumuman Terkini
            </h2>

            <a href="<?php echo e(route('news')); ?>" class="mt-3 hidden items-center justify-center gap-2 rounded-xl bg-[#0D1B2A] px-6 py-3 text-sm font-semibold text-white shadow-sm transition-all hover:bg-[#162b45] sm:mt-0 sm:flex">
                <span>tampilkan Selengkapnya</span>
                <svg class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                </svg>
            </a>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(empty($newsItems)): ?>
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-8 text-center text-sm text-slate-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-400">
                Belum ada berita yang dipublikasikan.
            </div>
        <?php else: ?>
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $newsItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $news): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <article class="flex flex-col overflow-hidden rounded-lg border border-slate-400 bg-white transition duration-200 shadow-sm dark:border-slate-600 dark:bg-slate-900">
                        <a href="<?php echo e(route('berita.show', ['slug' => $news['slug'] ?? Str::slug($news['title'])])); ?>" class="block">
                            <div class="relative aspect-[16/11] w-full overflow-hidden rounded-t-lg bg-slate-100 dark:bg-slate-800">
                                <div class="absolute left-3 top-3 z-10 rounded bg-[#0D1B2A] px-2 py-1 text-[10px] font-black uppercase tracking-wider text-white">
                                    <?php echo e($news['badge']); ?>

                                </div>

                                <img src="<?php echo e($news['image']); ?>" alt="<?php echo e($news['alt']); ?>" class="h-full w-full object-cover">
                            </div>
                        </a>

                        <div class="flex flex-1 flex-col justify-between p-3.5 sm:p-4">
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider text-[#0D1B2A] dark:text-[#b9d6ff]">
                                    <?php echo e($news['category']); ?>

                                </p>

                                <a href="<?php echo e(route('berita.show', ['slug' => $news['slug'] ?? Str::slug($news['title'])])); ?>" class="block">
                                    <h3 class="mt-2 text-sm font-bold leading-snug text-slate-900 line-clamp-2 dark:text-white sm:text-[0.96rem]">
                                        <?php echo e($news['title']); ?>

                                    </h3>
                                </a>

                                <p class="mt-2 text-[11px] leading-relaxed text-slate-500 line-clamp-3 dark:text-slate-400">
                                    <?php echo e($news['description']); ?>

                                </p>
                            </div>

                            <div class="mt-4 flex items-center justify-between gap-2 border-t border-slate-300 pt-2 text-[10px] text-slate-500 dark:border-slate-600 dark:text-slate-400">
                                <div class="flex items-center gap-1.5">
                                    <svg class="h-3.5 w-3.5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    <span><?php echo e($news['date']); ?></span>
                                </div>

                                <a href="<?php echo e(route('berita.show', ['slug' => $news['slug'] ?? Str::slug($news['title'])])); ?>" class="flex items-center font-bold text-[#0D1B2A] transition hover:text-slate-700 dark:text-white dark:hover:text-[#b9d6ff]">
                                    Baca <span class="ml-1 text-xs leading-none">&rsaquo;</span>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="mt-6 flex justify-center sm:hidden">
            <a href="<?php echo e(route('news')); ?>" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#0D1B2A] px-6 py-3 text-sm font-semibold text-white shadow-sm transition-all hover:bg-[#162b45]">
                <span>Tampilkan Selengkapnya</span>
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>
<?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/sections/home/news.blade.php ENDPATH**/ ?>