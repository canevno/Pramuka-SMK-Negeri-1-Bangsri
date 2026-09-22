

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Notifikasi Admin</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Semua pembaruan, data masuk, dan perubahan status pendaftaran muncul di sini.</p>
        </div>
        <form action="<?php echo e(route('admin.notifications.read-all')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="inline-flex items-center rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-700 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-200">
                Tandai semua dibaca
            </button>
        </form>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-950">
        <div class="divide-y divide-slate-200 dark:divide-slate-800">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="block p-4 transition hover:bg-slate-50 dark:hover:bg-slate-900/60">
                    <div class="flex items-start justify-between gap-4">
                        <a href="<?php echo e(route('admin.notifications.visit', $notification)); ?>" class="flex-1 block space-y-2">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex h-2.5 w-2.5 rounded-full <?php echo e($notification->is_read ? 'bg-slate-300' : 'bg-emerald-500'); ?>"></span>
                                <p class="text-sm font-semibold text-slate-900 dark:text-white"><?php echo e($notification->title); ?></p>
                            </div>
                            <p class="text-sm text-slate-600 dark:text-slate-300"><?php echo e($notification->message); ?></p>
                            <div class="flex items-center gap-3 text-xs text-slate-400 dark:text-slate-500">
                                <span><?php echo e($notification->created_at ? $notification->created_at->diffForHumans() : 'Baru saja'); ?></span>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($notification->type): ?>
                                    <span class="rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-medium uppercase tracking-wide text-slate-600 dark:bg-slate-800 dark:text-slate-300"><?php echo e($notification->type); ?></span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </a>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! $notification->is_read): ?>
                            <form action="<?php echo e(route('admin.notifications.read', $notification)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="rounded-lg border border-slate-200 px-2.5 py-1.5 text-[10px] font-semibold text-slate-600 transition hover:border-slate-300 hover:text-slate-900 dark:border-slate-700 dark:text-slate-300 dark:hover:text-white">
                                    Baca
                                </button>
                            </form>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="p-8 text-center text-sm text-slate-500 dark:text-slate-400">
                    Belum ada notifikasi terbaru.
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <div class="mt-4">
        <?php echo e($notifications->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/admin/notifications/index.blade.php ENDPATH**/ ?>