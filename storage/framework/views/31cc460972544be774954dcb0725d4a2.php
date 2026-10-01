

<?php $__env->startSection('title', $title ?? 'Kelola Hero'); ?>
<?php $__env->startSection('page-heading', $title ?? 'Kelola Hero'); ?>
<?php $__env->startSection('page-description', $description ?? 'Atur 3 gambar utama hero frontend.'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="mb-4 flex items-center justify-between gap-3">
            <div>
                <h3 class="text-lg font-semibold text-slate-900">Hero Frontend</h3>
                <p class="text-sm text-slate-500">Cukup upload 3 gambar utama homepage. Jika ingin menghapus, centang hapus gambar.</p>
            </div>
            <a href="<?php echo e($publicRoute ?? route('home')); ?>" class="rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                <?php echo e($publicLabel ?? 'Lihat Halaman Depan'); ?>

            </a>
        </div>

        <form action="<?php echo e(route('admin.hero.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-5">
            <?php echo csrf_field(); ?>

            <div class="grid gap-5 md:grid-cols-3">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [1, 2, 3]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $key = 'hero_image_' . $slot; ?>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <div class="mb-3 flex items-center justify-between">
                            <h4 class="text-sm font-semibold uppercase tracking-[0.12em] text-slate-600">Gambar <?php echo e($slot); ?></h4>
                        </div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! empty($settings[$key] ?? null)): ?>
                            <div class="mb-3 overflow-hidden rounded-xl border border-slate-200 bg-white">
                                <img src="<?php echo e(asset('storage/' . $settings[$key])); ?>" alt="Hero <?php echo e($slot); ?>" class="h-40 w-full object-cover">
                            </div>
                            <label class="inline-flex items-center gap-2 text-sm text-red-600">
                                <input type="checkbox" name="remove_hero_image_<?php echo e($slot); ?>" value="1" class="h-4 w-4 rounded border-slate-300 text-red-600 focus:ring-red-500">
                                Hapus gambar
                            </label>
                        <?php else: ?>
                            <div class="mb-3 flex h-40 items-center justify-center rounded-xl border border-dashed border-slate-300 bg-white text-sm text-slate-400">
                                Belum ada gambar
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <div class="mt-3">
                            <label class="mb-1 block text-xs font-medium uppercase tracking-[0.12em] text-slate-500">Upload gambar</label>
                            <input type="file" name="hero_image_<?php echo e($slot); ?>" accept="image/*" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 file:mr-3 file:rounded file:border-0 file:bg-slate-900 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-white">
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-700">
                    Simpan 3 Gambar Hero
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views\admin\modules\hero.blade.php ENDPATH**/ ?>