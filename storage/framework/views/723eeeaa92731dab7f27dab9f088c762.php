<?php
    use Illuminate\Support\Str;
?>



<?php $__env->startSection('title', 'Pengelola API'); ?>
<?php $__env->startSection('page-title', 'Pengelola API'); ?>
<?php $__env->startSection('page-description', 'Pantau perangkat yang pernah mengunjungi website dan blokir perangkat yang mencurigakan.'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-4 sm:space-y-6">
    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-950 sm:rounded-2xl sm:p-5">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-xl font-bold text-slate-900 dark:text-white sm:text-2xl">Pengelola API</h1>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400 sm:text-sm">Daftar perangkat yang telah mengunjungi website Anda dan status blokirnya.</p>
            </div>
            <span class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-1 text-[10px] font-semibold text-emerald-700 dark:bg-emerald-950/30 dark:text-emerald-300 sm:px-3 sm:text-xs">
                <?php echo e($visitorDevices->count()); ?> perangkat tercatat
            </span>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-2.5 text-xs text-emerald-700 dark:border-emerald-900 dark:bg-emerald-950/30 dark:text-emerald-300 sm:px-4 sm:py-3 sm:text-sm">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="grid gap-3 md:grid-cols-3">
        <div class="rounded-xl border border-slate-200 bg-white p-3 shadow-sm dark:border-slate-800 dark:bg-slate-950 sm:rounded-2xl sm:p-4">
            <p class="text-[10px] font-medium uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400 sm:text-xs">Total perangkat</p>
            <p class="mt-2 text-xl font-bold text-slate-900 dark:text-white sm:text-2xl"><?php echo e($visitorDevices->count()); ?></p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-3 shadow-sm dark:border-slate-800 dark:bg-slate-950 sm:rounded-2xl sm:p-4">
            <p class="text-[10px] font-medium uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400 sm:text-xs">Aktif saat ini</p>
            <p class="mt-2 text-xl font-bold text-emerald-600 dark:text-emerald-300 sm:text-2xl"><?php echo e($visitorDevices->whereNull('blocked_at')->count()); ?></p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-3 shadow-sm dark:border-slate-800 dark:bg-slate-950 sm:rounded-2xl sm:p-4">
            <p class="text-[10px] font-medium uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400 sm:text-xs">Diblokir</p>
            <p class="mt-2 text-xl font-bold text-rose-600 dark:text-rose-300 sm:text-2xl"><?php echo e($visitorDevices->whereNotNull('blocked_at')->count()); ?></p>
        </div>
    </div>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-950 sm:rounded-2xl">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800">
                <thead class="bg-slate-50 dark:bg-slate-900/80">
                    <tr>
                        <th class="px-3 py-2.5 text-left text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400 sm:px-4 sm:py-3 sm:text-xs">Perangkat</th>
                        <th class="px-3 py-2.5 text-left text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400 sm:px-4 sm:py-3 sm:text-xs">Browser / Platform</th>
                        <th class="px-3 py-2.5 text-left text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400 sm:px-4 sm:py-3 sm:text-xs">IP</th>
                        <th class="px-3 py-2.5 text-left text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400 sm:px-4 sm:py-3 sm:text-xs">Terakhir dilihat</th>
                        <th class="px-3 py-2.5 text-left text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400 sm:px-4 sm:py-3 sm:text-xs">Kunjungan</th>
                        <th class="px-3 py-2.5 text-left text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400 sm:px-4 sm:py-3 sm:text-xs">Status</th>
                        <th class="px-3 py-2.5 text-left text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400 sm:px-4 sm:py-3 sm:text-xs">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $visitorDevices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $device): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="align-top">
                            <td class="px-4 py-3">
                                <div class="font-semibold text-slate-900 dark:text-white"><?php echo e($device->device_label ?: 'Perangkat'); ?></div>
                                <div class="mt-1 text-xs text-slate-500 dark:text-slate-400"><?php echo e(Str::limit($device->user_agent ?: 'User-agent tidak tersedia', 70)); ?></div>
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-700 dark:text-slate-300">
                                <div><?php echo e($device->browser ?: '-'); ?></div>
                                <div class="mt-1 text-xs text-slate-500 dark:text-slate-400"><?php echo e($device->platform ?: '-'); ?></div>
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-700 dark:text-slate-300"><?php echo e($device->ip_address ?: '-'); ?></td>
                            <td class="px-4 py-3 text-sm text-slate-700 dark:text-slate-300">
                                <?php echo e($device->last_seen_at ? $device->last_seen_at->translatedFormat('d M Y, H:i') : '-'); ?>

                            </td>
                            <td class="px-4 py-3 text-sm text-slate-700 dark:text-slate-300"><?php echo e($device->visit_count ?? 0); ?></td>
                            <td class="px-4 py-3">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($device->is_blocked): ?>
                                    <span class="inline-flex rounded-full bg-rose-100 px-2.5 py-1 text-xs font-semibold text-rose-700 dark:bg-rose-950/30 dark:text-rose-300">Diblokir</span>
                                <?php else: ?>
                                    <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-950/30 dark:text-emerald-300">Aktif</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="px-4 py-3">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($device->is_blocked): ?>
                                    <form method="POST" action="<?php echo e(route('admin.settings.device.unblock', $device)); ?>">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-100 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">Buka blokir</button>
                                    </form>
                                <?php else: ?>
                                    <form method="POST" action="<?php echo e(route('admin.settings.device.block', $device)); ?>">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="rounded-lg border border-rose-200 bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-700 transition hover:bg-rose-100 dark:border-rose-900 dark:bg-rose-950/30 dark:text-rose-300 dark:hover:bg-rose-950/50">Blokir Perangkat</button>
                                    </form>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center text-sm text-slate-500 dark:text-slate-400">
                                Belum ada perangkat yang tercatat mengunjungi website.
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>