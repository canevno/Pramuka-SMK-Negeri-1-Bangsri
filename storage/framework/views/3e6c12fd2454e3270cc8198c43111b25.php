

<?php $__env->startSection('content'); ?>
<section class="bg-slate-50 py-16 dark:bg-gray-950">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="mb-10 text-center">
            <p class="text-[11px] font-bold uppercase tracking-[0.28em] text-slate-500 dark:text-slate-400">Agenda & Kegiatan</p>
            <h1 class="mt-4 text-3xl font-black tracking-tight text-slate-900 dark:text-white sm:text-4xl">Timeline Kegiatan Pramuka</h1>
            <p class="mx-auto mt-3 max-w-2xl text-sm text-slate-600 dark:text-slate-300">
                Daftar kegiatan, jadwal, dan momen penting yang tengah atau akan dilaksanakan oleh ambalan kami.
            </p>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($events ?? collect())->isNotEmpty()): ?>
            <div class="space-y-6">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ($events ?? collect()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md dark:border-slate-800 dark:bg-slate-900">
                        <div class="flex flex-col gap-5 md:flex-row md:items-start md:justify-between">
                            <div class="flex-1">
                                <div class="mb-3 flex flex-wrap items-center gap-2">
                                    <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.16em] text-emerald-700">
                                        <?php echo e(ucfirst($event->status ?? 'upcoming')); ?>

                                    </span>
                                    <span class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-400">
                                        <?php echo e(\Illuminate\Support\Carbon::parse($event->date)->translatedFormat('d F Y')); ?>

                                    </span>
                                </div>

                                <h2 class="text-2xl font-bold text-slate-900 dark:text-white"><?php echo e($event->title); ?></h2>

                                <div class="mt-4 space-y-2 text-sm text-slate-600 dark:text-slate-300">
                                    <div class="flex items-center gap-3">
                                        <svg class="h-4 w-4 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 6v6l4 2M12 22a10 10 0 100-20 10 10 0 000 20z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        <span><?php echo e($event->time ?? 'Waktu belum ditentukan'); ?></span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <svg class="h-4 w-4 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21s-6-5.686-8.5-9A5.5 5.5 0 0112 6.5 5.5 5.5 0 0120.5 12c-2.5 3.314-8.5 9-8.5 9z" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="2.5"/></svg>
                                        <span><?php echo e($event->location); ?></span>
                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! empty($event->guide_url)): ?>
                                        <div class="flex items-center gap-3">
                                            <svg class="h-4 w-4 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 13a3 3 0 100-6 3 3 0 000 6zm-7 7a7 7 0 0114 0M5 20h14" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            <a href="<?php echo e($event->guide_url); ?>" target="_blank" rel="noopener noreferrer" class="font-medium text-emerald-600 underline decoration-emerald-400 underline-offset-4 hover:text-emerald-500">
                                                Lihat panduan kegiatan
                                            </a>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! empty($event->theme)): ?>
                                <div class="max-w-sm rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm italic text-slate-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                                    <?php echo e($event->theme); ?>

                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </article>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php else: ?>
            <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-10 text-center dark:border-slate-700 dark:bg-slate-900">
                <p class="text-lg font-semibold text-slate-900 dark:text-white">Belum ada timeline kegiatan.</p>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Silakan tambahkan jadwal kegiatan di panel admin untuk menampilkannya di sini.</p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</section>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/pages/event.blade.php ENDPATH**/ ?>