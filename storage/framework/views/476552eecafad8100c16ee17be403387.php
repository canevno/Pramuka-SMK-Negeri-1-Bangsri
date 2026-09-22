<?php
    $galleryItems = \App\Models\GalleryItem::query()
        ->where('is_published', true)
        ->orderByDesc('is_featured')
        ->orderByDesc('published_at')
        ->orderByDesc('id')
        ->limit(10)
        ->get();

    $resolveGalleryImage = function ($path) {
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
?>

<section class="py-10 md:py-16 bg-slate-50 dark:bg-gray-950 transition-colors duration-200">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-6 border-b border-slate-200 pb-4 dark:border-slate-800 sm:flex sm:items-center sm:justify-between">
            <a href="<?php echo e(url('/galeri')); ?>" class="mt-3 hidden items-center justify-center gap-2 rounded-xl bg-[#0D1B2A] px-6 py-3 text-sm font-semibold text-white shadow-sm transition-all hover:bg-[#162b45] sm:mt-0 sm:flex">
                <span>Tampilkan Selengkapnya</span>
                <svg class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                </svg>
            </a>

            <h2 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-right sm:text-3xl">
                Galleri Kegiatan
            </h2>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($galleryItems->isNotEmpty()): ?>
            <div class="mb-6 grid grid-cols-2 gap-3 sm:grid-cols-3 md:gap-4 lg:grid-cols-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $galleryItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $galleryItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $imageUrl = $resolveGalleryImage($galleryItem->image); ?>

                    <div class="group overflow-hidden rounded-2xl border border-slate-200 bg-neutral-200 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md dark:border-gray-800 dark:bg-neutral-800">
                        <div class="aspect-[4/3] overflow-hidden">
                            <img src="<?php echo e($imageUrl); ?>"
                                 alt="<?php echo e($galleryItem->alt_text ?: $galleryItem->title); ?>"
                                 class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php else: ?>
            <div class="mb-12 grid grid-cols-2 gap-3 sm:grid-cols-3 md:gap-4 lg:grid-cols-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = range(1, 6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="aspect-[4/3] overflow-hidden rounded-2xl border border-slate-200 bg-slate-200 shadow-sm dark:border-gray-800 dark:bg-slate-800 animate-pulse"></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="mt-6 flex justify-center sm:hidden">
            <a href="<?php echo e(url('/galeri')); ?>" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#0D1B2A] px-6 py-3 text-sm font-semibold text-white shadow-sm transition-all hover:bg-[#162b45]">
                <span>Tampilkan Selengkapnya</span>
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                </svg>
            </a>
        </div>
    </div>
</section><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/sections/home/gallery.blade.php ENDPATH**/ ?>