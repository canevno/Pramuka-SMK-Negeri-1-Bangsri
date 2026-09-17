

<?php $__env->startSection('title', 'Detail Absensi'); ?>
<?php $__env->startSection('page-heading', 'Detail Absensi'); ?>
<?php $__env->startSection('page-description', 'Rincian daftar hadir peserta pada tanggal tertentu.'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-slate-950">Detail Absensi</h2>
                <p class="mt-1 text-sm text-slate-500"><?php echo e($recordDate); ?> • <?php echo e($participantKelas); ?> • <?php echo e($participantAmbalan); ?> • Petugas: <?php echo e($petugasName); ?></p>
            </div>
            <div class="flex gap-2">
                <a href="<?php echo e(route('admin.absensi.export.excel', request()->query())); ?>" class="inline-flex items-center rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-medium text-emerald-700 hover:bg-emerald-100">Export Excel</a>
                <a href="<?php echo e(route('admin.absensi.export.pdf', request()->query())); ?>" class="inline-flex items-center rounded-xl border border-rose-200 bg-rose-50 px-4 py-2 text-sm font-medium text-rose-700 hover:bg-rose-100">Export PDF</a>
                <a href="<?php echo e(route('admin.absensi')); ?>" class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Kembali</a>
            </div>
        </div>

        <div class="mt-6 overflow-hidden rounded-[1.75rem] border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm text-slate-700">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Nama Lengkap</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Kelas Asal</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Ambalan</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Sangga</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Keterangan</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Iuran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td class="px-4 py-4"><?php echo e($record->participant_name); ?></td>
                            <td class="px-4 py-4"><?php echo e($record->participant_kelas); ?></td>
                            <td class="px-4 py-4"><?php echo e($record->participant_ambalan); ?></td>
                            <td class="px-4 py-4">
                                <?php
                                    $sanggaLabel = trim((string) ($record->participant_sangga ?? ''));
                                    if ($sanggaLabel === '' || preg_match('/^\d+$/', $sanggaLabel)) {
                                        $sanggaLabel = trim((string) ($record->participant_ambalan ?? '')) . ' ' . $sanggaLabel;
                                    }
                                ?>
                                <?php echo e($sanggaLabel !== '' ? $sanggaLabel : '-'); ?>

                            </td>
                            <td class="px-4 py-4">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold <?php echo e($record->status === 'Hadir' ? 'bg-emerald-100 text-emerald-700' : ($record->status === 'Izin' ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700')); ?>">
                                    <?php echo e($record->status); ?>

                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <?php
                                    $amount = (int) ($record->iuran_amount ?? 0);
                                    $iuranLabel = $amount > 0 ? 'Rp ' . number_format($amount, 0, ',', '.') : 'Belum bayar';
                                ?>
                                <?php echo e($iuranLabel); ?>

                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-sm text-slate-500">Belum ada data pada detail absensi ini.</td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/admin/absensi-detail.blade.php ENDPATH**/ ?>