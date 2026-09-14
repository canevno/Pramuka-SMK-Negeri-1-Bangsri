
<?php $__env->startSection('title', 'Kelola Absensi'); ?>
<?php $__env->startSection('page-heading', 'Kelola Absensi'); ?>
<?php $__env->startSection('page-description', 'Pantau kehadiran peserta, verifikasi petugas, dan ringkas data mingguan/bulanan/tahunan.'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="grid gap-5 lg:grid-cols-4">
            <div class="rounded-[1.75rem] border border-slate-200 bg-slate-50 p-5">
                <p class="text-xs uppercase tracking-[0.18em] text-slate-500">Total Absensi</p>
                <p class="mt-4 text-3xl font-semibold text-slate-950"><?php echo e(number_format($totalCount)); ?></p>
            </div>
            <div class="rounded-[1.75rem] border border-slate-200 bg-slate-50 p-5">
                <p class="text-xs uppercase tracking-[0.18em] text-slate-500">Minggu ini</p>
                <p class="mt-4 text-3xl font-semibold text-slate-950"><?php echo e(number_format($weeklyCount)); ?></p>
                <p class="mt-2 text-sm text-slate-500"><?php echo e($currentWeekLabel); ?></p>
            </div>
            <div class="rounded-[1.75rem] border border-slate-200 bg-slate-50 p-5">
                <p class="text-xs uppercase tracking-[0.18em] text-slate-500">Bulan ini</p>
                <p class="mt-4 text-3xl font-semibold text-slate-950"><?php echo e(number_format($monthlyCount)); ?></p>
                <p class="mt-2 text-sm text-slate-500"><?php echo e($currentMonthKey); ?></p>
            </div>
            <div class="rounded-[1.75rem] border border-slate-200 bg-slate-50 p-5">
                <p class="text-xs uppercase tracking-[0.18em] text-slate-500">Tahun ini</p>
                <p class="mt-4 text-3xl font-semibold text-slate-950"><?php echo e(number_format($yearlyCount)); ?></p>
                <p class="mt-2 text-sm text-slate-500"><?php echo e($currentYear); ?></p>
            </div>
        </div>
    </section>

    <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-slate-950">Rekam Absensi Terbaru</h2>
                <p class="mt-1 text-sm text-slate-500">10 entri terakhir dari database.</p>
            </div>
            <!-- filter removed per request -->
        </div>

        <div class="mt-6 overflow-hidden rounded-[1.75rem] border border-slate-200 bg-white">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm text-slate-700">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Tanggal</th>
                            <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Sangga</th>
                            <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Ambalan</th>
                            <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Petugas</th>
                            <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Status</th>
                            <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recapRecords ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td class="px-4 py-4"><?php echo e($r['record_date']); ?></td>
                                <td class="px-4 py-4"><?php echo e($r['sangga'] ?? $r['kelas']); ?></td>
                                <td class="px-4 py-4"><?php echo e($r['ambalan']); ?></td>
                                <td class="px-4 py-4"><?php echo e($r['petugas']); ?></td>
                                <td class="px-4 py-4">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($r['status'] === 'Selesai'): ?>
                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold bg-emerald-100 text-emerald-700"><?php echo e($r['status']); ?></span>
                                    <?php else: ?>
                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold bg-amber-100 text-amber-700"><?php echo e($r['status']); ?></span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td class="px-4 py-4">
                                    <a href="<?php echo e(route('admin.absensi.detail', [
                                        'record_date' => $r['record_date'],
                                        'participant_kelas' => $r['kelas'],
                                        'participant_ambalan' => $r['ambalan'],
                                        'petugas_name' => $r['petugas'],
                                    ])); ?>" class="text-emerald-600 hover:underline">Detail</a>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-sm text-slate-500">Belum ada rekap absensi.</td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-slate-950">Daftar Petugas Absensi</h2>
                <p class="mt-1 text-sm text-slate-500">Ringkasan petugas berdasarkan rekam absensi.</p>
            </div>
            <div class="inline-flex rounded-2xl bg-slate-50 px-4 py-2 text-sm font-medium text-slate-600">
                Aktif = dalam 14 hari terakhir
            </div>
        </div>

        <div class="mt-6 overflow-hidden rounded-[1.75rem] border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm text-slate-700">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Nama Petugas</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">NTA</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Kelas Petugas</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Keaktifan</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Terakhir Melakukan</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Jumlah Rekam</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $petugasSummary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $petugas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td class="px-4 py-4"><?php echo e($petugas['name']); ?></td>
                            <td class="px-4 py-4"><?php echo e($petugas['nta']); ?></td>
                            <td class="px-4 py-4"><?php echo e($petugas['kelas']); ?></td>
                            <td class="px-4 py-4">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold <?php echo e($petugas['status'] === 'Aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700'); ?>">
                                    <?php echo e($petugas['status']); ?>

                                </span>
                            </td>
                            <td class="px-4 py-4"><?php echo e($petugas['last_seen']); ?></td>
                            <td class="px-4 py-4"><?php echo e($petugas['total_records']); ?></td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-sm text-slate-500">Belum ada data petugas.</td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/admin/absensi.blade.php ENDPATH**/ ?>