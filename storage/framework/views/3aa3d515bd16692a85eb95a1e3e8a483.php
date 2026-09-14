
<?php $__env->startSection('content'); ?>
<?php
$achievements = App\Support\AchievementStore::byLevel('cabang');
?>
<section class="bg-slate-50 py-16 dark:bg-slate-950">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-10 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div class="text-center md:text-left">
                <p class="text-xs font-bold uppercase tracking-[0.25em] text-slate-900 dark:text-white">Prestasi Cabang</p>
                <h1 class="mt-3 text-4xl font-black tracking-tight text-slate-900 dark:text-white">Capaian Tingkat Cabang</h1>
            </div>
            <a href="<?php echo e(route('achievement')); ?>" class="hidden md:inline-flex items-center rounded-lg bg-slate-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-200">
                Kembali ke Semua Prestasi
            </a>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($achievements): ?>
            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $achievements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $achievement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <article class="overflow-hidden rounded-lg border border-slate-200 bg-white transition hover:border-slate-900 dark:border-slate-800 dark:bg-black dark:hover:border-white">
                        <div class="h-52 overflow-hidden bg-slate-100 dark:bg-slate-900">
                            <img src="<?php echo e(asset($achievement['image'] ?? 'images/achievement/prestasi1.jpg')); ?>" alt="<?php echo e($achievement['title']); ?>" class="h-full w-full object-cover grayscale hover:grayscale-0 transition duration-500" />
                        </div>
                        <div class="space-y-3 p-5">
                            <div class="flex items-center justify-between gap-3">
                                <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.12em] text-slate-700 dark:bg-slate-900 dark:text-slate-300">
                                    <?php echo e($achievement['category'] ?? 'Prestasi'); ?>

                                </span>
                                <span class="text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400"><?php echo e($achievement['year'] ?? now()->year); ?></span>
                            </div>
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white"><?php echo e($achievement['title']); ?></h2>
                            <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Pemenang: <?php echo e($achievement['winner'] ?? 'Anggota'); ?></p>
                            <p class="text-sm leading-6 text-slate-600 dark:text-slate-400"><?php echo e($achievement['description'] ?? 'Prestasi yang membanggakan.'); ?></p>
                        </div>
                    </article>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php else: ?>
            <div class="rounded-lg border border-dashed border-slate-300 bg-white p-8 text-center text-slate-500 dark:border-slate-800 dark:bg-black dark:text-slate-400">
                Belum ada data prestasi tingkat cabang.
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <!-- Tombol Kembali Khusus Mobile (Paling Bawah) -->
        <div class="mt-10 flex justify-center md:hidden">
            <a href="<?php echo e(route('achievement')); ?>" class="inline-flex items-center rounded-lg bg-slate-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-200">
                Kembali ke Semua Prestasi
            </a>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/pages/prestasi/cabang.blade.php ENDPATH**/ ?>