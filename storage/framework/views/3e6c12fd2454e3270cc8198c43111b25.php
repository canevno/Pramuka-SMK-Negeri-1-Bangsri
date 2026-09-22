

<?php $__env->startSection('content'); ?>
<section class="bg-slate-50 py-16 dark:bg-gray-950">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="mb-10 text-center">
            <h1 class="mt-4 text-3xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-4xl">Timeline Kegiatan Pramuka</h1>
            <p class="mx-auto mt-3 max-w-2xl text-sm text-slate-600 dark:text-slate-300">
                Daftar kegiatan, jadwal, dan momen penting yang tengah atau akan dilaksanakan oleh ambalan kami.
            </p>
        </div>

        <?php
            $now = \Illuminate\Support\Carbon::now()->startOfDay();
            $allEvents = ($events ?? collect())->sortBy('date');
            $upcoming = $allEvents->filter(fn($e) => \Illuminate\Support\Carbon::parse($e->date)->startOfDay()->greaterThanOrEqualTo($now));
            $past = $allEvents->filter(fn($e) => \Illuminate\Support\Carbon::parse($e->date)->startOfDay()->lessThan($now));
        ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($upcoming->isNotEmpty()): ?>
            <div class="mb-8">
                <h2 class="mb-4 text-xl font-bold text-slate-900 dark:text-white">Upcoming Events</h2>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $upcoming; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <article class="group overflow-hidden rounded-2xl border border-slate-300 bg-white transition hover:shadow-lg dark:border-slate-800 dark:bg-slate-900">
                            <div class="flex items-center justify-center py-6 bg-white">
                                <div class="w-20 h-20 sm:w-24 sm:h-24 md:w-32 md:h-32 flex items-center justify-center flex-shrink-0 overflow-hidden rounded-2xl border border-slate-300 bg-white p-1 shadow-sm dark:border-slate-600 dark:bg-slate-900">
                                    <?php
                                        $eventLogo = $event->logo_path ?? $event->image ?? null;
                                    ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! empty($eventLogo)): ?>
                                        <?php
                                            $logoSrc = preg_match('/^https?:\/\//', $eventLogo) ? $eventLogo : asset('storage/' . ltrim($eventLogo, '/'));
                                        ?>
                                        <img src="<?php echo e($logoSrc); ?>" alt="Logo Kegiatan" class="w-full h-full object-contain" onerror="this.style.display='none'" />
                                    <?php else: ?>
                                        <img src="<?php echo e(asset('images/logokegiatan2.png')); ?>" alt="Logo Kegiatan" class="w-full h-full object-contain" onerror="this.style.display='none'" />
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="text-sm font-bold text-slate-900 dark:text-white"><?php echo e($event->title); ?></h3>
                                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400"><?php echo e(\Illuminate\Support\Str::limit($event->description ?? $event->excerpt ?? $event->theme ?? '', 120)); ?></p>
                                <p class="mt-2 text-xs text-slate-500 dark:text-slate-400"><?php echo e(\Illuminate\Support\Carbon::parse($event->date)->translatedFormat('d F Y')); ?> • <?php echo e($event->time ?? 'Waktu'); ?></p>
                                <div class="mt-3 flex items-center gap-2">
                                    <a href="<?php echo e(route('event.show', ['id' => $event->id])); ?>" class="inline-flex items-center gap-2 rounded-md bg-[#0D1B2A] px-3 py-1.5 text-xs font-semibold text-white hover:bg-[#162b45]">[Informasi Lengkap]</a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($past->isNotEmpty()): ?>
            <div class="mt-10">
                <h2 class="mb-4 text-xl font-bold text-slate-900 dark:text-white">Past events</h2>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $past; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <article class="overflow-hidden rounded-lg border border-slate-300 bg-white dark:border-slate-800 dark:bg-slate-900">
                            <div class="p-3">
                                <div class="flex items-center justify-between">
                                    <div class="min-w-0">
                                        <h4 class="text-sm font-semibold text-slate-900 dark:text-white"><?php echo e($event->title); ?></h4>
                                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400"><?php echo e(\Illuminate\Support\Carbon::parse($event->date)->translatedFormat('d F Y')); ?></p>
                                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400"><?php echo e(\Illuminate\Support\Str::limit($event->description ?? $event->excerpt ?? $event->theme ?? '', 120)); ?></p>
                                    </div>
                                    <div class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 flex items-center justify-center flex-shrink-0 overflow-hidden rounded-xl border border-slate-200 bg-slate-50 shadow-sm dark:border-slate-700 dark:bg-slate-900 ml-4">
                                        <?php
                                            $eventLogo = $event->logo_path ?? $event->image ?? null;
                                        ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! empty($eventLogo)): ?>
                                            <?php
                                                $logoSrc = preg_match('/^https?:\/\//', $eventLogo) ? $eventLogo : asset('storage/' . ltrim($eventLogo, '/'));
                                            ?>
                                            <img src="<?php echo e($logoSrc); ?>" alt="Logo Kegiatan" class="w-full h-full object-contain" onerror="this.style.display='none'" />
                                        <?php else: ?>
                                            <img src="<?php echo e(asset('images/logokegiatan2.png')); ?>" alt="Logo Kegiatan" class="w-full h-full object-contain" onerror="this.style.display='none'" />
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                                <div class="mt-3 text-xs text-slate-600 dark:text-slate-400 flex gap-2">
                                    <a href="<?php echo e(route('event.show', ['id' => $event->id])); ?>" class="inline-flex items-center gap-2 rounded-md bg-[#0D1B2A] px-3 py-1 text-xs font-semibold text-white hover:bg-[#162b45]">[Informasi Lengkap]</a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</section>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/pages/event.blade.php ENDPATH**/ ?>