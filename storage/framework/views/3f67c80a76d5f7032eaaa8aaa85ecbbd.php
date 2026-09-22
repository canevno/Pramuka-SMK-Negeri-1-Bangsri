

<?php $__env->startSection('title', $title ?? 'Kelola Pembina'); ?>
<?php $__env->startSection('page-heading', $title ?? 'Kelola Pembina'); ?>
<?php $__env->startSection('page-description', $description ?? 'Kelola data pembina dan penanggung jawab acara.'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6 rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Modul Admin</p>
            <h2 class="mt-2 text-2xl font-bold text-slate-900 dark:text-white"><?php echo e($title ?? 'Kelola Pembina'); ?></h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400"><?php echo e($description ?? 'Kelola data pembina dan penanggung jawab acara.'); ?></p>
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
            <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500">Total Pembina</p>
            <p class="mt-2 text-2xl font-bold text-slate-900"><?php echo e($stats['total'] ?? 0); ?></p>
            <p class="mt-1 text-[11px] text-slate-500">Semua data</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500">Aktif</p>
            <p class="mt-2 text-2xl font-bold text-slate-900"><?php echo e($stats['aktif'] ?? 0); ?></p>
            <p class="mt-1 text-[11px] text-slate-500">Saat ini</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500">Non-Aktif</p>
            <p class="mt-2 text-2xl font-bold text-slate-900"><?php echo e($stats['nonaktif'] ?? 0); ?></p>
            <p class="mt-1 text-[11px] text-slate-500">Dihentikan</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-500">Kontak Valid</p>
            <p class="mt-2 text-2xl font-bold text-slate-900"><?php echo e($stats['kontak'] ?? 0); ?></p>
            <p class="mt-1 text-[11px] text-slate-500">Nomor / email</p>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-100 text-xs uppercase tracking-[0.12em] text-slate-600">
                    <tr>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Jabatan</th>
                        <th class="px-4 py-3">Kontak</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $pembinas ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pembina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="px-4 py-3 font-medium text-slate-900"><?php echo e($pembina->name); ?></td>
                            <td class="px-4 py-3"><?php echo e($pembina->jabatan); ?></td>
                            <td class="px-4 py-3"><?php echo e($pembina->phone ?: ($pembina->email ?: '-')); ?></td>
                            <td class="px-4 py-3">
                                <span class="rounded-full px-2.5 py-1 text-[10px] font-semibold <?php echo e($pembina->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-700'); ?>">
                                    <?php echo e($pembina->status ?: ($pembina->is_active ? 'Aktif' : 'Tidak aktif')); ?>

                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap items-center gap-2">
                                    <form action="<?php echo e(route('admin.pembina.toggle', $pembina)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="rounded-lg border border-amber-200 bg-amber-50 px-2.5 py-1.5 text-[10px] font-semibold text-amber-700 hover:bg-amber-100">
                                            <?php echo e($pembina->is_active ? 'Non-aktifkan' : 'Aktifkan'); ?>

                                        </button>
                                    </form>

                                    <button type="button" onclick="document.getElementById('edit-pembina-<?php echo e($pembina->id); ?>').classList.toggle('hidden')" class="rounded-lg border border-indigo-200 bg-indigo-50 px-2.5 py-1.5 text-[10px] font-semibold text-indigo-700 hover:bg-indigo-100">
                                        Edit
                                    </button>

                                    <form action="<?php echo e(route('admin.pembina.delete', $pembina)); ?>" method="POST" onsubmit="return confirm('Hapus pembina ini?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="rounded-lg border border-rose-200 bg-rose-50 px-2.5 py-1.5 text-[10px] font-semibold text-rose-700 hover:bg-rose-100">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <tr id="edit-pembina-<?php echo e($pembina->id); ?>" class="hidden bg-slate-50">
                            <td colspan="5" class="px-4 py-4">
                                <form action="<?php echo e(route('admin.pembina.update', $pembina)); ?>" method="POST" enctype="multipart/form-data" class="grid gap-3 md:grid-cols-2">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>

                                    <input type="text" name="name" value="<?php echo e(old('name', $pembina->name)); ?>" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm" placeholder="Nama lengkap" required>
                                    <input type="text" name="jabatan" value="<?php echo e(old('jabatan', $pembina->jabatan)); ?>" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm" placeholder="Jabatan" required>
                                    <input type="text" name="phone" value="<?php echo e(old('phone', $pembina->phone)); ?>" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm" placeholder="Nomor telepon">
                                    <input type="email" name="email" value="<?php echo e(old('email', $pembina->email)); ?>" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm" placeholder="Email">
                                    <select name="status" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm">
                                        <option value="Aktif" <?php echo e(old('status', $pembina->status) === 'Aktif' ? 'selected' : ''); ?>>Aktif</option>
                                        <option value="Tidak aktif" <?php echo e(old('status', $pembina->status) === 'Tidak aktif' ? 'selected' : ''); ?>>Tidak aktif</option>
                                    </select>
                                    <input type="number" name="sort_order" value="<?php echo e(old('sort_order', $pembina->sort_order ?? 0)); ?>" min="0" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm" placeholder="Urutan">
                                    <textarea name="bio" rows="3" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm md:col-span-2" placeholder="Deskripsi singkat"><?php echo e(old('bio', $pembina->bio)); ?></textarea>
                                    <input type="file" name="photo" accept="image/*" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm md:col-span-2">
                                    <label class="inline-flex items-center gap-2 text-sm text-slate-600 md:col-span-2">
                                        <input type="checkbox" name="is_active" value="1" <?php echo e(old('is_active', $pembina->is_active) ? 'checked' : ''); ?>>
                                        Aktif dipublikasikan
                                    </label>
                                    <div class="flex justify-end gap-2 md:col-span-2">
                                        <button type="submit" class="rounded-xl bg-indigo-600 px-4 py-2 text-xs font-semibold text-white hover:bg-indigo-500">
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-sm text-slate-500">Belum ada data pembina.</td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-slate-900">Formulir Pembina</h3>
            <span class="rounded-full bg-emerald-50 px-2 py-1 text-[10px] font-semibold text-emerald-700">Siap diproses</span>
        </div>

        <form action="<?php echo e(route('admin.pembina.store')); ?>" method="POST" enctype="multipart/form-data" class="grid gap-4 md:grid-cols-2">
            <?php echo csrf_field(); ?>

            <div class="md:col-span-2">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Foto pembina</span>
                <div id="pembina-upload-box" class="group relative cursor-pointer overflow-hidden rounded-2xl border-2 border-dashed border-slate-300 bg-gradient-to-br from-slate-50 via-white to-indigo-50 p-3 transition-all duration-200 hover:border-indigo-400 hover:bg-indigo-50/80">
                    <div id="pembina-empty-state" class="flex min-h-[170px] flex-col items-center justify-center gap-3 rounded-xl border border-slate-200/80 bg-white/70 px-4 py-5 text-center shadow-inner">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600 shadow-sm">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path d="M12 16V4m0 0l-4 4m4-4l4 4M4 16.5V18a2.5 2.5 0 0 0 2.5 2.5h11A2.5 2.5 0 0 0 20 18v-1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-700">Tarik foto ke sini</p>
                            <p class="mt-1 text-[11px] text-slate-500">atau klik untuk memilih file</p>
                        </div>
                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-600">PNG • JPG • WEBP</span>
                    </div>

                    <div id="pembina-preview-wrap" class="hidden overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                        <img id="pembina-preview" alt="Preview foto pembina" class="h-[170px] w-full object-cover" />
                        <div class="flex items-center justify-between gap-3 border-t border-slate-200 px-3 py-2">
                            <span id="pembina-file-name" class="truncate text-xs font-medium text-slate-700"></span>
                            <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-[0.12em] text-emerald-700">Preview</span>
                        </div>
                    </div>
                </div>

                <input id="pembina-photo-input" type="file" name="photo" accept="image/*" class="hidden">
            </div>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Nama pembina</span>
                <input type="text" name="name" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-indigo-500" placeholder="Masukkan nama lengkap" required>
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Jabatan</span>
                <input type="text" name="jabatan" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-indigo-500" placeholder="Pembina / Koordinator / Mentor" required>
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Kontak</span>
                <input type="text" name="phone" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-indigo-500" placeholder="Nomor telepon">
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Email</span>
                <input type="email" name="email" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-indigo-500" placeholder="email@example.com">
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Status</span>
                <select name="status" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-indigo-500">
                    <option value="Aktif">Aktif</option>
                    <option value="Tidak aktif">Tidak aktif</option>
                </select>
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Urutan</span>
                <input type="number" name="sort_order" value="0" min="0" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-indigo-500">
            </label>

            <label class="block md:col-span-2">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Catatan</span>
                <textarea name="bio" rows="4" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-indigo-500" placeholder="Deskripsi tugas dan pengalaman pembina"></textarea>
            </label>

            <div class="md:col-span-2 flex justify-end">
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500">
                    Simpan Pembina
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const uploadBox = document.getElementById('pembina-upload-box');
        const input = document.getElementById('pembina-photo-input');
        const fileLabel = document.getElementById('pembina-file-name');
        const previewWrap = document.getElementById('pembina-preview-wrap');
        const previewImage = document.getElementById('pembina-preview');
        const emptyState = document.getElementById('pembina-empty-state');

        if (!uploadBox || !input || !fileLabel || !previewWrap || !previewImage || !emptyState) {
            return;
        }

        const updatePreview = (file) => {
            if (!file || !file.type.startsWith('image/')) {
                previewWrap.classList.add('hidden');
                emptyState.classList.remove('hidden');
                fileLabel.textContent = '';
                return;
            }

            const objectUrl = URL.createObjectURL(file);
            previewImage.src = objectUrl;
            previewWrap.classList.remove('hidden');
            emptyState.classList.add('hidden');
            fileLabel.textContent = file.name;

            previewImage.onload = function () {
                URL.revokeObjectURL(objectUrl);
            };
        };

        uploadBox.addEventListener('click', function (event) {
            if (event.target.closest('button') || event.target.closest('a')) {
                return;
            }
            input.click();
        });

        ['dragenter', 'dragover'].forEach((eventName) => {
            uploadBox.addEventListener(eventName, function (event) {
                event.preventDefault();
                uploadBox.classList.add('border-indigo-400', 'bg-indigo-50/80', 'shadow-md');
                uploadBox.classList.remove('border-slate-300');
            });
        });

        ['dragleave', 'drop'].forEach((eventName) => {
            uploadBox.addEventListener(eventName, function (event) {
                event.preventDefault();
                uploadBox.classList.remove('border-indigo-400', 'bg-indigo-50/80', 'shadow-md');
                uploadBox.classList.add('border-slate-300');
            });
        });

        uploadBox.addEventListener('drop', function (event) {
            event.preventDefault();
            const files = event.dataTransfer && event.dataTransfer.files;
            if (files && files.length) {
                const file = files[0];
                if (!file.type.startsWith('image/')) {
                    return;
                }
                input.files = files;
                updatePreview(file);
            }
        });

        input.addEventListener('change', function () {
            updatePreview(this.files && this.files[0]);
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/admin/modules/pembina.blade.php ENDPATH**/ ?>