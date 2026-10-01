
<?php $__env->startSection('title', 'Kelola Absensi'); ?>
<?php $__env->startSection('page-heading', 'Kelola Absensi'); ?>
<?php $__env->startSection('page-description', 'Pantau kehadiran peserta, verifikasi petugas, dan ringkas data mingguan/bulanan/tahunan.'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="grid gap-2 sm:gap-5 grid-cols-2 md:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-[1.75rem] border border-slate-200 bg-slate-50 p-2 dark:border-slate-700 dark:bg-slate-800/80 sm:p-5">
                <p class="text-[8px] font-semibold uppercase tracking-[0.18em] text-slate-500 dark:text-slate-400 sm:text-xs">Total Absensi</p>
                <p class="mt-2 text-lg font-bold text-slate-950 dark:text-white sm:mt-4 sm:text-3xl"><?php echo e(number_format($totalCount)); ?></p>
            </div>
            <div class="rounded-[1.75rem] border border-slate-200 bg-slate-50 p-2 dark:border-slate-700 dark:bg-slate-800/80 sm:p-5">
                <p class="text-[8px] font-semibold uppercase tracking-[0.18em] text-slate-500 dark:text-slate-400 sm:text-xs">Minggu ini</p>
                <p class="mt-2 text-lg font-bold text-slate-950 dark:text-white sm:mt-4 sm:text-3xl"><?php echo e(number_format($weeklyCount)); ?></p>
                <p class="mt-1 text-[9px] text-slate-500 dark:text-slate-400 sm:mt-2 sm:text-sm"><?php echo e($currentWeekLabel); ?></p>
            </div>
            <div class="rounded-[1.75rem] border border-slate-200 bg-slate-50 p-2 dark:border-slate-700 dark:bg-slate-800/80 sm:p-5">
                <p class="text-[8px] font-semibold uppercase tracking-[0.18em] text-slate-500 dark:text-slate-400 sm:text-xs">Bulan ini</p>
                <p class="mt-2 text-lg font-bold text-slate-950 dark:text-white sm:mt-4 sm:text-3xl"><?php echo e(number_format($monthlyCount)); ?></p>
                <p class="mt-1 text-[9px] text-slate-500 dark:text-slate-400 sm:mt-2 sm:text-sm"><?php echo e($currentMonthKey); ?></p>
            </div>
            <div class="rounded-[1.75rem] border border-slate-200 bg-slate-50 p-2 dark:border-slate-700 dark:bg-slate-800/80 sm:p-5">
                <p class="text-[8px] font-semibold uppercase tracking-[0.18em] text-slate-500 dark:text-slate-400 sm:text-xs">Tahun ini</p>
                <p class="mt-2 text-lg font-bold text-slate-950 dark:text-white sm:mt-4 sm:text-3xl"><?php echo e(number_format($yearlyCount)); ?></p>
                <p class="mt-1 text-[9px] text-slate-500 dark:text-slate-400 sm:mt-2 sm:text-sm"><?php echo e($currentYear); ?></p>
            </div>
        </div>
    </section>

    <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-900/80">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-slate-900 dark:text-white">Rekam Absensi Terbaru</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Menampilkan 10 rekaman terbaru.</p>
            </div>
        </div>

        <?php
            $allRecapRecords = $recapRecords ?? collect();
            $visibleRecapRecords = $allRecapRecords->take(10);
            $hiddenRecapRecords = $allRecapRecords->skip(10);
        ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
            <div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
            <div class="mt-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="mt-6 overflow-hidden rounded-[1.75rem] border border-slate-200 bg-white dark:border-slate-700 dark:bg-slate-900/60">
            <div class="overflow-x-auto">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($recapRecords ?? collect())->isNotEmpty()): ?>
                    <form method="POST" action="<?php echo e(route('admin.absensi.destroy-selected')); ?>" id="bulk-delete-form">
                        <?php echo csrf_field(); ?>
                        <div class="flex items-center justify-between border-b border-slate-200 bg-slate-50 px-4 py-3 dark:border-slate-700 dark:bg-slate-800/80">
                            <label class="inline-flex items-center gap-2 text-sm font-medium text-slate-700 dark:text-slate-200">
                                <input type="checkbox" id="select-all-records" class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                                Pilih semua
                            </label>
                            <button type="submit" class="inline-flex items-center rounded-xl border border-rose-200 bg-rose-50 px-3 py-2 text-sm font-medium text-rose-700 hover:bg-rose-100" onclick="return confirm('Apakah Anda yakin ingin menghapus rekaman yang dipilih?')">
                                Hapus yang Dipilih
                            </button>
                        </div>

                        <table class="min-w-full divide-y divide-slate-200 text-left text-sm text-slate-700 dark:divide-slate-700 dark:text-slate-200">
                            <thead class="bg-slate-50 dark:bg-slate-800/80">
                                <tr>
                                    <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500 dark:text-slate-300">Pilih</th>
                                    <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500 dark:text-slate-300">No</th>
                                    <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500 dark:text-slate-300">Sangga</th>
                                    <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500 dark:text-slate-300">Ambalan</th>
                                    <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500 dark:text-slate-300">Petugas</th>
                                    <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500 dark:text-slate-300">Tanggal</th>
                                    <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500 dark:text-slate-300">Minggu-ke</th>
                                    <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500 dark:text-slate-300">Detail</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-700 dark:bg-slate-900/40">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $visibleRecapRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="px-4 py-4">
                                            <input type="checkbox" name="selected_records[]" value="<?php echo e($r['group_key'] ?? ''); ?>" class="record-checkbox h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                                        </td>
                                        <td class="px-4 py-4"><?php echo e($index + 1); ?></td>
                                        <td class="px-4 py-4"><?php echo e($r['sangga'] ?? $r['kelas']); ?></td>
                                        <td class="px-4 py-4"><?php echo e($r['ambalan']); ?></td>
                                        <td class="px-4 py-4"><?php echo e($r['petugas']); ?></td>
                                        <td class="px-4 py-4"><?php echo e($r['record_date']); ?></td>
                                        <td class="px-4 py-4"><?php echo e($r['minggu_ke']); ?></td>
                                        <td class="px-4 py-4">
                                            <a href="<?php echo e(route('admin.absensi.detail', [
                                                'record_date' => $r['record_date'],
                                                'participant_kelas' => $r['kelas'],
                                                'participant_sangga' => $r['sangga'],
                                                'participant_ambalan' => $r['ambalan'],
                                                'petugas_name' => $r['petugas'],
                                            ])); ?>" class="text-emerald-600 hover:underline dark:text-emerald-400">Detail</a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $hiddenRecapRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="more-records hidden">
                                        <td class="px-4 py-4">
                                            <input type="checkbox" name="selected_records[]" value="<?php echo e($r['group_key'] ?? ''); ?>" class="record-checkbox h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                                        </td>
                                        <td class="px-4 py-4"><?php echo e($index + 11); ?></td>
                                        <td class="px-4 py-4"><?php echo e($r['sangga'] ?? $r['kelas']); ?></td>
                                        <td class="px-4 py-4"><?php echo e($r['ambalan']); ?></td>
                                        <td class="px-4 py-4"><?php echo e($r['petugas']); ?></td>
                                        <td class="px-4 py-4"><?php echo e($r['record_date']); ?></td>
                                        <td class="px-4 py-4"><?php echo e($r['minggu_ke']); ?></td>
                                        <td class="px-4 py-4">
                                            <a href="<?php echo e(route('admin.absensi.detail', [
                                                'record_date' => $r['record_date'],
                                                'participant_kelas' => $r['kelas'],
                                                'participant_sangga' => $r['sangga'],
                                                'participant_ambalan' => $r['ambalan'],
                                                'petugas_name' => $r['petugas'],
                                            ])); ?>" class="text-emerald-600 hover:underline dark:text-emerald-400">Detail</a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tbody>
                        </table>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hiddenRecapRecords->isNotEmpty()): ?>
                            <div class="border-t border-slate-200 px-4 py-3 text-center dark:border-slate-700">
                                <button type="button" id="toggle-more-records" class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">
                                    Tampilkan selengkapnya
                                </button>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </form>
                <?php else: ?>
                    <div class="px-4 py-6 text-center text-sm text-slate-500 dark:text-slate-400">Belum ada rekap absensi.</div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </section>

    <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-900/80">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-slate-900 dark:text-white">Daftar Petugas Absensi</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Ringkasan petugas berdasarkan rekam absensi.</p>
            </div>
            <div class="inline-flex rounded-2xl bg-slate-50 px-4 py-2 text-sm font-medium text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                Aktif = dalam 14 hari terakhir
            </div>
        </div>

        <div class="mt-6 overflow-hidden rounded-[1.75rem] border border-slate-200 dark:border-slate-700">
            <div class="overflow-x-auto [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                <table class="min-w-[720px] divide-y divide-slate-200 text-left text-sm text-slate-700 dark:divide-slate-700 dark:text-slate-200">
                    <thead class="bg-slate-50 dark:bg-slate-800/80">
                        <tr>
                            <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500 dark:text-slate-300">Nama Petugas</th>
                            <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500 dark:text-slate-300">NTA</th>
                            <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500 dark:text-slate-300">Kelas Petugas</th>
                            <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500 dark:text-slate-300">Keaktifan</th>
                            <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500 dark:text-slate-300">Terakhir Melakukan</th>
                            <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500 dark:text-slate-300">Jumlah Rekam</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-700 dark:bg-slate-900/40">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $petugasSummary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $petugas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-sm text-slate-500 dark:text-slate-400">Belum ada data petugas.</td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAll = document.getElementById('select-all-records');
        if (selectAll) {
            selectAll.addEventListener('change', function () {
                document.querySelectorAll('.record-checkbox').forEach(function (checkbox) {
                    checkbox.checked = selectAll.checked;
                });
            });
        }

        const toggleButton = document.getElementById('toggle-more-records');
        if (!toggleButton) return;

        const hiddenRows = document.querySelectorAll('.more-records');
        const toggleRows = function (showAll) {
            hiddenRows.forEach(function (row) {
                row.classList.toggle('hidden', !showAll);
            });
            toggleButton.textContent = showAll ? 'Sembunyikan' : 'Tampilkan selengkapnya';
        };

        toggleButton.addEventListener('click', function () {
            const expanded = toggleButton.dataset.expanded === 'true';
            toggleButton.dataset.expanded = String(!expanded);
            toggleRows(!expanded);
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/admin/absensi.blade.php ENDPATH**/ ?>