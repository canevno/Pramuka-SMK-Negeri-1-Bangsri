

<?php $__env->startSection('content'); ?>
<?php
    $activeMembers = collect($dewanAnggota ?? [])->where('is_active', true)->sortBy(fn ($item) => [$item->sort_order ?? 0, $item->nama ?? ''])->values();
?>

<div class="min-h-screen bg-slate-50 px-4 py-10 text-slate-900 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">
        <div class="mb-8 text-center">
            <p class="text-xs font-bold uppercase tracking-[0.28em] text-emerald-700">Struktur Organisasi</p>
            <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Anggota Dewan</h1>
            <p class="mx-auto mt-3 max-w-2xl text-sm text-slate-600 sm:text-base">
                Daftar anggota dewan yang aktif dan terdaftar dalam struktur kepengurusan periode berjalan.
            </p>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeMembers->isEmpty()): ?>
            <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-10 text-center text-slate-500 shadow-sm">
                Belum ada data anggota dewan yang aktif untuk ditampilkan.
            </div>
        <?php else: ?>
            <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $activeMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php
                        $image = $item->photo_url ?: 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=800';
                    ?>

                    <article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-md">
                        <div class="relative h-64 overflow-hidden bg-slate-100">
                            <img src="<?php echo e($image); ?>" alt="<?php echo e($item->nama); ?>" class="h-full w-full object-cover">
                            <span class="absolute right-3 top-3 rounded-full bg-emerald-500/90 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-white">
                                <?php echo e($item->status ?? 'Aktif'); ?>

                            </span>
                        </div>

                        <div class="space-y-3 p-5">
                            <div>
                                <h2 class="text-xl font-bold text-slate-900"><?php echo e($item->nama); ?></h2>
                                <p class="mt-1 text-sm font-medium text-emerald-700"><?php echo e($item->jabatan ?: 'Anggota Dewan'); ?></p>
                            </div>

                            <div class="space-y-1 text-sm text-slate-600">
                                <p><span class="font-semibold text-slate-800">Kelas:</span> <?php echo e($item->kelas_asal ?: '-'); ?></p>
                                <p><span class="font-semibold text-slate-800">Sangga:</span> <?php echo e($item->sangga ?: '-'); ?></p>
                                <p><span class="font-semibold text-slate-800">Sub Sangga:</span> <?php echo e($item->sub_sangga ?: '-'); ?></p>
                            </div>
                        </div>
                    </article>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/pages/anggota-dewan.blade.php ENDPATH**/ ?>