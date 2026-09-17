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
        <div class="text-center max-w-2xl mx-auto mb-6 sm:mb-8 md:mb-10">
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold tracking-tight text-gray-900 dark:text-white mb-3">
                Galleri Kegiatan
            </h2>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 leading-relaxed">
                Dokumentasi momen kebersamaan, keseruan, dan dedikasi seluruh anggota dalam mengikuti berbagai kegiatan pramuka.
            </p>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($galleryItems->isNotEmpty()): ?>
            <div class="mb-6 grid grid-cols-2 gap-3 sm:grid-cols-3 md:gap-4 lg:grid-cols-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $galleryItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $galleryItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php $imageUrl = $resolveGalleryImage($galleryItem->image); ?>

                    <div class="group overflow-hidden rounded-2xl border border-slate-200 bg-neutral-200 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md dark:border-gray-800 dark:bg-neutral-800">
                        <div class="aspect-[4/3] overflow-hidden">
                            <img src="<?php echo e($imageUrl); ?>"
                                 alt="<?php echo e($galleryItem->alt_text ?: $galleryItem->title); ?>"
                                 class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php else: ?>
            <div class="mb-12 grid grid-cols-2 gap-3 sm:grid-cols-3 md:gap-4 lg:grid-cols-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = range(1, 6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="aspect-[4/3] overflow-hidden rounded-2xl border border-slate-200 bg-slate-200 shadow-sm dark:border-gray-800 dark:bg-slate-800 animate-pulse"></div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="flex items-center justify-center">
            <a href="<?php echo e(url('/galeri')); ?>"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-[#0D1B2A] hover:bg-[#162b45] text-white font-semibold text-sm transition-all shadow-sm group">
                <span>Tampilkan Selengkapnya</span>
                <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                </svg>
            </a>
        </div>

    </div>
</section><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/sections/home/gallery.blade.php ENDPATH**/ ?>