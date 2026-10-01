
<?php $__env->startSection('title', 'Daftar Petugas'); ?>
<?php $__env->startSection('page-heading', 'Daftar Petugas'); ?>
<?php $__env->startSection('page-description', 'Melihat nama petugas, NTA, kelas, dan keaktifan terakhir berdasarkan absensi.'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-900/80">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-slate-900 dark:text-white">Tambah Petugas</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Tambah petugas baru untukke absensi dan pengelolaan rekam.</p>
            </div>
        </div>

        <form action="<?php echo e(route('admin.petugas.store')); ?>" method="POST" enctype="multipart/form-data" class="mt-6 grid gap-4 md:grid-cols-6">
            <?php echo csrf_field(); ?>
            <div class="md:col-span-1">
                <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Nama</label>
                <input type="text" name="nama" required class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 focus:border-emerald-500" placeholder="Nama petugas">
            </div>
            <div class="md:col-span-1">
                <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">NTA</label>
                <input type="text" name="nta" required class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 focus:border-emerald-500" placeholder="NTA">
            </div>
            <div class="md:col-span-1">
                <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Kelas</label>
                <input type="text" name="kelas_petugas" required class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 focus:border-emerald-500" placeholder="Contoh: XII RPL 1">
            </div>
            <div class="md:col-span-1">
                <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 focus:border-emerald-500">
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Foto Profil</label>
                <input type="file" name="photo" accept="image/*" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 file:mr-3 file:rounded file:border-0 file:bg-emerald-100 file:px-2.5 file:py-1.5 file:text-xs file:font-semibold file:text-emerald-700 focus:border-emerald-500">
            </div>
            <div class="md:col-span-6 flex items-end">
                <button type="submit" class="w-full rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-emerald-700">Tambah Petugas</button>
            </div>
        </form>
    </section>

    <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-900/80">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-slate-900 dark:text-white">Daftar Petugas</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Data petugas yang sudah terdaftar di sistem.</p>
            </div>
        </div>

        <div class="mt-6 overflow-hidden rounded-[1.75rem] border border-slate-200 dark:border-slate-700">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm text-slate-700 dark:divide-slate-700 dark:text-slate-200">
                <thead class="bg-slate-50 dark:bg-slate-800/80">
                    <tr>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500 dark:text-slate-300">Profil</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500 dark:text-slate-300">Nama Petugas</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500 dark:text-slate-300">NTA</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500 dark:text-slate-300">Kelas Petugas</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500 dark:text-slate-300">Jenis Kelamin</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500 dark:text-slate-300">Status</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500 dark:text-slate-300">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-700 dark:bg-slate-900/40">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $registeredPetugas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="px-4 py-4">
                                <?php
                                    $initials = strtoupper(substr($item->nama, 0, 2));
                                ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($item->photo_url)): ?>
                                    <img src="<?php echo e(asset($item->photo_url)); ?>" alt="Foto <?php echo e($item->nama); ?>" class="h-11 w-11 rounded-full object-cover ring-2 ring-slate-200">
                                <?php else: ?>
                                    <div class="flex h-11 w-11 items-center justify-center rounded-full bg-slate-200 text-xs font-bold text-slate-700 ring-2 ring-slate-200">
                                        <?php echo e($initials); ?>

                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="px-4 py-4"><?php echo e($item->nama); ?></td>
                            <td class="px-4 py-4"><?php echo e($item->nta); ?></td>
                            <td class="px-4 py-4"><?php echo e($item->kelas_petugas); ?></td>
                            <td class="px-4 py-4"><?php echo e($item->jenis_kelamin === 'P' ? 'Perempuan' : 'Laki-laki'); ?></td>
                            <td class="px-4 py-4">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold <?php echo e($item->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700'); ?>">
                                    <?php echo e($item->is_active ? 'Aktif' : 'Non-Aktif'); ?>

                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-2">
                                    <form action="<?php echo e(route('admin.petugas.toggle', $item->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                            <?php echo e($item->is_active ? 'Nonaktifkan' : 'Aktifkan'); ?>

                                        </button>
                                    </form>

                                    <form action="<?php echo e(route('admin.petugas.destroy', $item->id)); ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus petugas ini?')">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-100">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-sm text-slate-500 dark:text-slate-400">Belum ada data petugas.</td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views\admin\petugas.blade.php ENDPATH**/ ?>