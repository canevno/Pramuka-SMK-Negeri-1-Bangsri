

<?php $__env->startSection('title', $title ?? 'Kelola Timeline Kegiatan'); ?>
<?php $__env->startSection('page-heading', $title ?? 'Kelola Timeline Kegiatan'); ?>
<?php $__env->startSection('page-description', $description ?? 'Kelola jadwal dan kegiatan yang tampil di homepage.'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6 rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Modul Admin</p>
            <h2 class="mt-2 text-2xl font-bold text-slate-900 dark:text-white"><?php echo e($title ?? 'Kelola Timeline Kegiatan'); ?></h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400"><?php echo e($description ?? 'Kelola jadwal dan kegiatan yang tampil di homepage.'); ?></p>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! empty($publicRoute) && ! empty($publicLabel)): ?>
            <a href="<?php echo e($publicRoute); ?>" class="inline-flex items-center rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-100 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300 dark:hover:bg-emerald-500/20">
                <?php echo e($publicLabel); ?>

            </a>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="flex items-start justify-between gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            <p><?php echo e(session('success')); ?></p>
            <button type="button" onclick="this.closest('div').remove()" class="text-lg leading-none opacity-70 transition hover:opacity-100" aria-label="Tutup notifikasi">&times;</button>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500">Total Kegiatan</p>
            <p class="mt-2 text-2xl font-bold text-slate-900"><?php echo e($stats['total'] ?? 0); ?></p>
            <p class="mt-1 text-[11px] text-slate-500">Semua data</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500">Akan Datang</p>
            <p class="mt-2 text-2xl font-bold text-slate-900"><?php echo e($stats['upcoming'] ?? 0); ?></p>
            <p class="mt-1 text-[11px] text-slate-500">Menunggu tanggal</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500">Sedang Aktif</p>
            <p class="mt-2 text-2xl font-bold text-slate-900"><?php echo e($stats['active'] ?? 0); ?></p>
            <p class="mt-1 text-[11px] text-slate-500">Dipublikasikan</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500">Selesai</p>
            <p class="mt-2 text-2xl font-bold text-slate-900"><?php echo e($stats['completed'] ?? 0); ?></p>
            <p class="mt-1 text-[11px] text-slate-500">Terlewati</p>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-100 text-xs uppercase tracking-[0.12em] text-slate-600">
                    <tr>
                        <th class="px-4 py-3">Judul</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Lokasi</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $events ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td class="px-4 py-3 font-medium text-slate-900"><?php echo e($event->title); ?></td>
                            <td class="px-4 py-3"><?php echo e(\Illuminate\Support\Carbon::parse($event->date)->translatedFormat('d F Y')); ?><br><span class="text-[11px] text-slate-500"><?php echo e($event->time ?? 'Waktu belum diatur'); ?></span></td>
                            <td class="px-4 py-3"><?php echo e($event->location); ?></td>
                            <td class="px-4 py-3">
                                <span class="rounded-full px-2.5 py-1 text-[10px] font-semibold <?php echo e($event->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-700'); ?>">
                                    <?php echo e($event->status); ?>

                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap items-center gap-2">
                                    <form action="<?php echo e(route('admin.timeline.toggle', $event)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="rounded-lg border border-amber-200 bg-amber-50 px-2.5 py-1.5 text-[10px] font-semibold text-amber-700 hover:bg-amber-100">
                                            <?php echo e($event->is_active ? 'Non-aktifkan' : 'Aktifkan'); ?>

                                        </button>
                                    </form>

                                    <button type="button" onclick="document.getElementById('edit-timeline-<?php echo e($event->id); ?>').classList.toggle('hidden')" class="rounded-lg border border-indigo-200 bg-indigo-50 px-2.5 py-1.5 text-[10px] font-semibold text-indigo-700 hover:bg-indigo-100">
                                        Edit
                                    </button>

                                    <form action="<?php echo e(route('admin.timeline.delete', $event)); ?>" method="POST" onsubmit="return confirm('Hapus kegiatan ini?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="rounded-lg border border-rose-200 bg-rose-50 px-2.5 py-1.5 text-[10px] font-semibold text-rose-700 hover:bg-rose-100">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <tr id="edit-timeline-<?php echo e($event->id); ?>" class="hidden bg-slate-50">
                            <td colspan="5" class="px-4 py-4">
                                <form action="<?php echo e(route('admin.timeline.update', $event)); ?>" method="POST" enctype="multipart/form-data" class="grid gap-3 md:grid-cols-2">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>

                                    <input type="text" name="title" value="<?php echo e(old('title', $event->title)); ?>" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm" placeholder="Judul kegiatan" required>
                                    <input type="date" name="date" value="<?php echo e(old('date', $event->date?->format('Y-m-d') ?? $event->date)); ?>" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm" required>
                                    <input type="time" name="time" value="<?php echo e(old('time', $event->time)); ?>" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm">
                                    <input type="text" name="location" value="<?php echo e(old('location', $event->location)); ?>" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm" placeholder="Lokasi" required>
                                    <input type="url" name="guide_url" value="<?php echo e(old('guide_url', $event->guide_url)); ?>" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm md:col-span-2" placeholder="https://...">
                                    <input type="number" name="sort_order" value="<?php echo e(old('sort_order', $event->sort_order ?? 0)); ?>" min="0" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm">
                                    <select name="status" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm">
                                        <option value="upcoming" <?php echo e(old('status', $event->status) === 'upcoming' ? 'selected' : ''); ?>>Akan datang</option>
                                        <option value="ongoing" <?php echo e(old('status', $event->status) === 'ongoing' ? 'selected' : ''); ?>>Sedang berlangsung</option>
                                        <option value="completed" <?php echo e(old('status', $event->status) === 'completed' ? 'selected' : ''); ?>>Selesai</option>
                                    </select>
                                    <textarea name="theme" rows="3" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm md:col-span-2" placeholder="Tema kegiatan"><?php echo e(old('theme', $event->theme)); ?></textarea>

                                    <div class="md:col-span-2">
                                        <label class="block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Logo kegiatan</label>
                                        <div class="mt-2 flex items-center gap-3 rounded-2xl border border-dashed border-slate-300 bg-white p-3">
                                            <input type="file" name="logo" accept="image/*" class="block w-full text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-indigo-600 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-white">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! empty($event->logo_path)): ?>
                                                <img src="<?php echo e(asset('storage/' . $event->logo_path)); ?>" alt="Logo kegiatan" class="h-12 w-12 rounded-xl object-cover border border-slate-200">
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>

                                    <label class="inline-flex items-center gap-2 text-sm text-slate-600 md:col-span-2">
                                        <input type="checkbox" name="is_active" value="1" <?php echo e(old('is_active', $event->is_active) ? 'checked' : ''); ?>>
                                        Tampilkan di homepage
                                    </label>
                                    <div class="flex justify-end gap-2 md:col-span-2">
                                        <button type="submit" class="rounded-xl bg-indigo-600 px-4 py-2 text-xs font-semibold text-white hover:bg-indigo-500">
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-sm text-slate-500">Belum ada data timeline kegiatan.</td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Formulir Timeline</h3>
            <span class="rounded-full bg-emerald-50 px-2 py-1 text-[10px] font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">Siap diproses</span>
        </div>

        <form action="<?php echo e(route('admin.timeline.store')); ?>" method="POST" enctype="multipart/form-data" class="grid gap-4 md:grid-cols-2">
            <?php echo csrf_field(); ?>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Judul kegiatan</span>
                <input type="text" name="title" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-indigo-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100" placeholder="Masukkan judul acara" required>
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Tanggal</span>
                <input type="date" name="date" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-indigo-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100" required>
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Waktu</span>
                <input type="time" name="time" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-indigo-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100">
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Urutan</span>
                <input type="number" name="sort_order" value="0" min="0" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-indigo-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100">
            </label>

            <label class="block md:col-span-2">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Lokasi</span>
                <input type="text" name="location" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-indigo-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100" placeholder="Masukkan lokasi kegiatan" required>
            </label>

            <label class="block md:col-span-2">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Panduan kegiatan (opsional)</span>
                <input type="url" name="guide_url" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-indigo-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100" placeholder="https://example.com/panduan">
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Status</span>
                <select name="status" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-indigo-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100">
                    <option value="upcoming">Akan datang</option>
                    <option value="ongoing">Sedang berlangsung</option>
                    <option value="completed">Selesai</option>
                </select>
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Tampilkan</span>
                <select name="is_active" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-indigo-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100">
                    <option value="1">Ya, tampilkan di homepage</option>
                    <option value="0">Tidak tampilkan</option>
                </select>
            </label>

            <label class="block md:col-span-2">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Tema kegiatan</span>
                <textarea name="theme" rows="4" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-indigo-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100" placeholder="Tuliskan tema atau motto kegiatan"></textarea>
            </label>

            <div class="md:col-span-2">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Logo kegiatan mendatang</span>
                <div class="mt-2 rounded-2xl border-2 border-dashed border-slate-300 bg-white p-4 transition hover:border-indigo-400 dark:border-slate-700 dark:bg-slate-900">
                    <label class="flex cursor-pointer flex-col items-center justify-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-6 py-8 text-center dark:border-slate-700 dark:bg-slate-800">
                        <svg class="h-10 w-10 text-indigo-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 16V4m0 0l-4 4m4-4l4 4M5 18.5A2.5 2.5 0 007.5 21h9A2.5 2.5 0 0019 18.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <div>
                            <p class="text-sm font-semibold text-slate-800 dark:text-slate-100">Seret & lepas logo di sini</p>
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">PNG, JPG, WEBP hingga 2 MB</p>
                        </div>
                        <input type="file" name="logo" accept="image/*" class="hidden">
                    </label>
                </div>
            </div>

            <div class="md:col-span-2 flex justify-end">
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500">
                    Simpan Timeline
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/admin/modules/timeline.blade.php ENDPATH**/ ?>