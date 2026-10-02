

<?php $__env->startSection('content'); ?>
<?php
    $imageBase = '/images/achievement/prestasi1.jpg';
?>
<section class="bg-white py-8 sm:py-10">
    <div class="mx-auto max-w-[1280px] px-4 sm:px-4 lg:px-5">

        <div class="mb-8 flex flex-wrap items-center justify-center gap-3">
            <form method="GET" action="<?php echo e(route('prestasi')); ?>" class="flex flex-wrap items-center gap-3">
                <label class="sr-only" for="tahun-filter">Filter tahun</label>
                <select id="tahun-filter" name="tahun" class="rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 shadow-sm focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900/10">
                    <option value="">Semua Tahun</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($year = now()->year; $year >= 2020; $year--): ?>
                        <option value="<?php echo e($year); ?>" <?php echo e($tahun == $year ? 'selected' : ''); ?>><?php echo e($year); ?></option>
                    <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>

                <button type="submit" class="rounded-xl bg-[#0D1B2A] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-700">
                    Filter
                </button>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tahun): ?>
                    <a href="<?php echo e(route('prestasi')); ?>" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:border-slate-300 hover:bg-slate-50">
                        Reset
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </form>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($success): ?>
            <div class="mb-6 text-sm text-slate-500">
                Menampilkan <span class="font-semibold text-slate-900"><?php echo e(count($prestasi)); ?></span> data prestasi publik
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($prestasi) > 0): ?>
            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $prestasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $title = $item['title'] ?? '-';
                        $category = $item['category'] ?? 'Prestasi';
                        $winner = $item['winner'] ?? 'Anggota';
                        $image = $item['image'] ?? $imageBase;
                        $detailUrl = ! empty($item['detail_url']) ? $item['detail_url'] : '#';
                        $imageUrl = str_starts_with($image, 'http')
                            ? $image
                            : (str_starts_with($image, 'images/')
                                ? asset($image)
                                : asset('storage/' . ltrim($image, '/')));
                    ?>
                    <article class="flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:shadow-md">
                        <div class="relative aspect-[16/11] overflow-hidden bg-slate-100">
                            <img src="<?php echo e($imageUrl); ?>" alt="<?php echo e($title); ?>" class="h-full w-full object-cover transition duration-300 hover:scale-105">
                        </div>

                        <div class="flex flex-1 flex-col p-4 sm:p-5">
                            <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-[#0D1B2A]"><?php echo e($category); ?></p>
                            <h2 class="mt-2 text-lg font-bold leading-snug text-slate-900 line-clamp-2"><?php echo e($title); ?></h2>

                            <div class="mt-4 rounded-xl border border-slate-100 bg-slate-50 p-3">
                                <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-slate-500">Pemenang</p>
                                <p class="mt-1 text-base font-bold text-slate-900"><?php echo e($winner); ?></p>
                            </div>

                            <div class="mt-4 space-y-2 text-sm text-slate-600">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! empty($item['date'])): ?>
                                    <p><span class="font-semibold text-slate-800">Tanggal:</span> <?php echo e($item['date']); ?></p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! empty($item['location'])): ?>
                                    <p><span class="font-semibold text-slate-800">Lokasi:</span> <?php echo e($item['location']); ?></p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! empty($item['description'])): ?>
                                <p class="mt-4 text-sm leading-6 text-slate-600"><?php echo e(Str::limit(strip_tags($item['description']), 140)); ?></p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <div class="mt-5 pt-4">
                                <a href="<?php echo e($detailUrl); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex w-full items-center justify-center rounded-xl bg-[#0D1B2A] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-700">
                                    Lihat Detail SIPRES
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php else: ?>
            <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center">
                <p class="text-lg font-semibold text-slate-900">Belum ada prestasi</p>
                <p class="mt-2 text-sm text-slate-500">Belum ada prestasi yang dipublikasikan.</p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($pagination) && ($pagination['last_page'] ?? 1) > 1): ?>
            <div class="mt-10 flex items-center justify-center gap-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($pagination['current_page'] ?? 1) > 1): ?>
                    <a href="<?php echo e(route('prestasi', ['page' => $pagination['current_page'] - 1, 'tahun' => $tahun])); ?>" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:border-slate-300 hover:bg-slate-50">
                        Sebelumnya
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <span class="px-3 py-2 text-sm text-slate-500">
                    Halaman <?php echo e($pagination['current_page'] ?? 1); ?> dari <?php echo e($pagination['last_page'] ?? 1); ?>

                </span>

                <?php if(($pagination['current_page'] ?? 1) < ($pagination['last_page'] ?? 1)): ?>
                    <a href="<?php echo e(route('prestasi', ['page' => $pagination['current_page'] + 1, 'tahun' => $tahun])); ?>" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:border-slate-300 hover:bg-slate-50">
                        Berikutnya
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/pages/prestasi/index.blade.php ENDPATH**/ ?>