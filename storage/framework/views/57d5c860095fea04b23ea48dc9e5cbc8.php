

<?php $__env->startSection('title', $title ?? 'Kelola Dewan Ambalan'); ?>
<?php $__env->startSection('page-heading', $title ?? 'Kelola Dewan Ambalan'); ?>
<?php $__env->startSection('page-description', $description ?? 'Kelola data dewan ambalan yang tampil di halaman depan.'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-4 rounded-[1.5rem] border border-slate-200 bg-white p-4 shadow-sm sm:space-y-6 sm:rounded-[2rem] sm:p-6 dark:border-slate-800 dark:bg-slate-900">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400 sm:text-[11px]">Modul Admin</p>
            <h2 class="mt-2 text-xl font-bold text-slate-900 sm:text-2xl dark:text-white"><?php echo e($title ?? 'Kelola Dewan Ambalan'); ?></h2>
            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400 sm:text-sm"><?php echo e($description ?? 'Kelola data dewan ambalan yang tampil di halaman depan.'); ?></p>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! empty($publicRoute) && ! empty($publicLabel)): ?>
            <a href="<?php echo e($publicRoute); ?>" class="inline-flex items-center rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-100 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300 dark:hover:bg-emerald-500/20">
                <?php echo e($publicLabel); ?>

            </a>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="flex items-start justify-between gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-300">
            <p><?php echo e(session('success')); ?></p>
            <button type="button" onclick="this.closest('div').remove()" class="text-lg leading-none opacity-70 transition hover:opacity-100" aria-label="Tutup notifikasi">&times;</button>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="grid grid-cols-2 gap-2 sm:gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-2 dark:border-slate-700 dark:bg-slate-800/80 sm:p-4">
            <p class="text-[8px] font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400 sm:text-[10px]">Total Dewan</p>
            <p class="mt-2 text-lg font-bold text-slate-900 dark:text-white sm:text-2xl"><?php echo e($stats['total'] ?? 0); ?></p>
            <p class="mt-1 text-[9px] text-slate-500 dark:text-slate-400 sm:text-[11px]">Semua data</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-2 dark:border-slate-700 dark:bg-slate-800/80 sm:p-4">
            <p class="text-[8px] font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400 sm:text-[10px]">Aktif</p>
            <p class="mt-2 text-lg font-bold text-slate-900 dark:text-white sm:text-2xl"><?php echo e($stats['aktif'] ?? 0); ?></p>
            <p class="mt-1 text-[9px] text-slate-500 dark:text-slate-400 sm:text-[11px]">Saat ini</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-2 dark:border-slate-700 dark:bg-slate-800/80 sm:p-4">
            <p class="text-[8px] font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400 sm:text-[10px]">Non-Aktif</p>
            <p class="mt-2 text-lg font-bold text-slate-900 dark:text-white sm:text-2xl"><?php echo e($stats['nonaktif'] ?? 0); ?></p>
            <p class="mt-1 text-[9px] text-slate-500 dark:text-slate-400 sm:text-[11px]">Dihentikan</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-2 dark:border-slate-700 dark:bg-slate-800/80 sm:p-4">
            <p class="text-[8px] font-semibold uppercase tracking-[0.16em] text-slate-500 dark:text-slate-400 sm:text-[10px]">Kontak Valid</p>
            <p class="mt-2 text-lg font-bold text-slate-900 dark:text-white sm:text-2xl"><?php echo e($stats['kontak'] ?? 0); ?></p>
            <p class="mt-1 text-[9px] text-slate-500 dark:text-slate-400 sm:text-[11px]">Nomor / email</p>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-700">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-[11px] text-slate-600 sm:text-sm dark:text-slate-300">
                <thead class="bg-slate-100 text-[9px] uppercase tracking-[0.12em] text-slate-600 sm:text-xs dark:bg-slate-800 dark:text-slate-300">
                    <tr>
                        <th class="px-2 py-2 sm:px-4 sm:py-3">Nama</th>
                        <th class="px-2 py-2 sm:px-4 sm:py-3">Jabatan</th>
                        <th class="px-2 py-2 sm:px-4 sm:py-3">Kontak</th>
                        <th class="px-2 py-2 sm:px-4 sm:py-3">Status</th>
                        <th class="px-2 py-2 sm:px-4 sm:py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white dark:divide-slate-700 dark:bg-slate-950">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $members ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="px-2 py-2.5 align-top font-medium text-slate-900 sm:px-4 sm:py-3 dark:text-white"><?php echo e($member->name); ?></td>
                            <td class="px-2 py-2.5 align-top sm:px-4 sm:py-3 dark:text-slate-300"><?php echo e($member->jabatan); ?></td>
                            <td class="px-2 py-2.5 align-top sm:px-4 sm:py-3 dark:text-slate-300"><?php echo e($member->phone ?: ($member->email ?: '-')); ?></td>
                            <td class="px-2 py-2.5 align-top sm:px-4 sm:py-3">
                                <span class="inline-flex rounded-full px-2 py-1 text-[9px] font-semibold sm:text-[10px] <?php echo e($member->is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300' : 'bg-slate-200 text-slate-700 dark:bg-slate-700 dark:text-slate-200'); ?>">
                                    <?php echo e($member->status ?: ($member->is_active ? 'Aktif' : 'Tidak aktif')); ?>

                                </span>
                            </td>
                            <td class="px-2 py-2.5 align-top sm:px-4 sm:py-3">
                                <div class="flex flex-col items-stretch gap-1.5 sm:flex-wrap sm:flex-row sm:items-center sm:gap-2">
                                    <form action="<?php echo e(route('admin.dewan-ambalan.toggle', $member)); ?>" method="POST" class="w-full sm:w-auto">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="w-full rounded-md border border-amber-200 bg-amber-50 px-2 py-1.5 text-[9px] font-semibold text-amber-700 hover:bg-amber-100 sm:w-auto sm:px-2.5 sm:py-1.5 sm:text-[10px] dark:border-amber-700/50 dark:bg-amber-500/10 dark:text-amber-300 dark:hover:bg-amber-500/20">
                                            <?php echo e($member->is_active ? 'Non-aktifkan' : 'Aktifkan'); ?>

                                        </button>
                                    </form>

                                    <button type="button" onclick="document.getElementById('edit-dewan-ambalan-<?php echo e($member->id); ?>').classList.toggle('hidden')" class="w-full rounded-md border border-emerald-200 bg-emerald-50 px-2 py-1.5 text-[9px] font-semibold text-emerald-700 hover:bg-emerald-100 sm:w-auto sm:px-2.5 sm:py-1.5 sm:text-[10px] dark:border-emerald-500/40 dark:bg-emerald-500/10 dark:text-emerald-300 dark:hover:bg-emerald-500/20">
                                        Edit
                                    </button>

                                    <form action="<?php echo e(route('admin.dewan-ambalan.delete', $member)); ?>" method="POST" onsubmit="return confirm('Hapus data dewan ambalan ini?');" class="w-full sm:w-auto">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="w-full rounded-md border border-rose-200 bg-rose-50 px-2 py-1.5 text-[9px] font-semibold text-rose-700 hover:bg-rose-100 sm:w-auto sm:px-2.5 sm:py-1.5 sm:text-[10px] dark:border-rose-500/40 dark:bg-rose-500/10 dark:text-rose-300 dark:hover:bg-rose-500/20">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <tr id="edit-dewan-ambalan-<?php echo e($member->id); ?>" class="hidden bg-slate-50 dark:bg-slate-800/50">
                            <td colspan="5" class="px-4 py-4">
                                <form action="<?php echo e(route('admin.dewan-ambalan.update', $member)); ?>" method="POST" enctype="multipart/form-data" class="grid gap-3 md:grid-cols-2">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>

                                    <input type="text" name="name" value="<?php echo e(old('name', $member->name)); ?>" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500" placeholder="Nama lengkap" required>
                                    <input type="text" name="jabatan" value="<?php echo e(old('jabatan', $member->jabatan)); ?>" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500" placeholder="Jabatan" required>
                                    <input type="text" name="phone" value="<?php echo e(old('phone', $member->phone)); ?>" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500" placeholder="Nomor telepon">
                                    <input type="email" name="email" value="<?php echo e(old('email', $member->email)); ?>" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500" placeholder="Email">
                                    <select name="status" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white">
                                        <option value="Aktif" <?php echo e(old('status', $member->status) === 'Aktif' ? 'selected' : ''); ?>>Aktif</option>
                                        <option value="Tidak aktif" <?php echo e(old('status', $member->status) === 'Tidak aktif' ? 'selected' : ''); ?>>Tidak aktif</option>
                                    </select>
                                    <input type="number" name="sort_order" value="<?php echo e(old('sort_order', $member->sort_order ?? 0)); ?>" min="0" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500" placeholder="Urutan">
                                    <textarea name="bio" rows="3" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500 md:col-span-2" placeholder="Deskripsi singkat"><?php echo e(old('bio', $member->bio)); ?></textarea>
                                    <input type="file" name="photo" accept="image/*" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 dark:border-slate-700 dark:bg-slate-900 dark:text-white md:col-span-2">
                                    <label class="inline-flex items-center gap-2 text-sm text-slate-600 dark:text-slate-300 md:col-span-2">
                                        <input type="checkbox" name="is_active" value="1" <?php echo e(old('is_active', $member->is_active) ? 'checked' : ''); ?>>
                                        Aktif dipublikasikan
                                    </label>
                                    <div class="flex justify-end gap-2 md:col-span-2">
                                        <button type="submit" class="rounded-xl bg-emerald-600 px-4 py-2 text-xs font-semibold text-white hover:bg-emerald-500 dark:bg-emerald-500 dark:hover:bg-emerald-400">
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-sm text-slate-500 dark:text-slate-400">Belum ada data dewan ambalan.</td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-700 dark:bg-slate-800/80 sm:p-5">
        <div class="mb-3 flex items-center justify-between gap-2 sm:mb-4">
            <h3 class="text-base font-semibold text-slate-900 dark:text-white sm:text-lg">Formulir Dewan Ambalan</h3>
            <span class="rounded-full bg-emerald-50 px-2 py-1 text-[9px] font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300 sm:text-[10px]">Siap diproses</span>
        </div>

        <form action="<?php echo e(route('admin.dewan-ambalan.store')); ?>" method="POST" enctype="multipart/form-data" class="grid gap-4 md:grid-cols-2">
            <?php echo csrf_field(); ?>

            <div class="md:col-span-2">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Foto dewan ambalan</span>
                <div id="dewan-ambalan-upload-box" class="group relative cursor-pointer overflow-hidden rounded-2xl border-2 border-dashed border-slate-300 bg-gradient-to-br from-slate-50 via-white to-emerald-50 p-3 transition-all duration-200 hover:border-emerald-400 hover:bg-emerald-50/80 dark:border-slate-600 dark:from-slate-900 dark:via-slate-900 dark:to-slate-800 dark:hover:border-emerald-500 dark:hover:bg-slate-800/70">
                    <div id="dewan-ambalan-empty-state" class="flex min-h-[170px] flex-col items-center justify-center gap-3 rounded-xl border border-slate-200/80 bg-white/70 px-4 py-5 text-center shadow-inner dark:border-slate-700 dark:bg-slate-900/80">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 shadow-sm dark:bg-emerald-500/10 dark:text-emerald-300">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path d="M12 16V4m0 0l-4 4m4-4l4 4M4 16.5V18a2.5 2.5 0 0 0 2.5 2.5h11A2.5 2.5 0 0 0 20 18v-1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">Tarik foto ke sini</p>
                            <p class="mt-1 text-[11px] text-slate-500 dark:text-slate-400">atau klik untuk memilih file</p>
                        </div>
                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-600 dark:bg-slate-700 dark:text-slate-200">PNG • JPG • WEBP</span>
                    </div>

                    <div id="dewan-ambalan-preview-wrap" class="hidden overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
                        <img id="dewan-ambalan-preview" alt="Preview foto dewan ambalan" class="h-[170px] w-full object-cover" />
                        <div class="flex items-center justify-between gap-3 border-t border-slate-200 px-3 py-2 dark:border-slate-700">
                            <span id="dewan-ambalan-file-name" class="truncate text-xs font-medium text-slate-700 dark:text-slate-200"></span>
                            <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-[0.12em] text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">Preview</span>
                        </div>
                    </div>
                </div>

                <input id="dewan-ambalan-photo-input" type="file" name="photo" accept="image/*" class="hidden">
            </div>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Nama lengkap</span>
                <input type="text" name="name" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder:text-slate-400" placeholder="Masukkan nama lengkap" required>
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Jabatan</span>
                <input type="text" name="jabatan" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder:text-slate-400" placeholder="Ketua / Sekretaris / Bendahara" required>
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Kontak</span>
                <input type="text" name="phone" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder:text-slate-400" placeholder="Nomor telepon">
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Email</span>
                <input type="email" name="email" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder:text-slate-400" placeholder="email@example.com">
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Status</span>
                <select name="status" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white">
                    <option value="Aktif">Aktif</option>
                    <option value="Tidak aktif">Tidak aktif</option>
                </select>
            </label>

            <label class="block">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Urutan</span>
                <input type="number" name="sort_order" value="0" min="0" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder:text-slate-400">
            </label>

            <label class="block md:col-span-2">
                <span class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Deskripsi singkat</span>
                <textarea name="bio" rows="4" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none ring-0 transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder:text-slate-400" placeholder="Deskripsi tugas dan peran dewan ambalan"></textarea>
            </label>

            <div class="md:col-span-2 flex justify-end">
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-500 dark:bg-emerald-500 dark:hover:bg-emerald-400">
                    Simpan Dewan Ambalan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const uploadBox = document.getElementById('dewan-ambalan-upload-box');
        const input = document.getElementById('dewan-ambalan-photo-input');
        const fileLabel = document.getElementById('dewan-ambalan-file-name');
        const previewWrap = document.getElementById('dewan-ambalan-preview-wrap');
        const previewImage = document.getElementById('dewan-ambalan-preview');
        const emptyState = document.getElementById('dewan-ambalan-empty-state');

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
                uploadBox.classList.add('border-emerald-400', 'bg-emerald-50/80', 'shadow-md');
                uploadBox.classList.remove('border-slate-300');
            });
        });

        ['dragleave', 'drop'].forEach((eventName) => {
            uploadBox.addEventListener(eventName, function (event) {
                event.preventDefault();
                uploadBox.classList.remove('border-emerald-400', 'bg-emerald-50/80', 'shadow-md');
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

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views\admin\modules\dewan-ambalan.blade.php ENDPATH**/ ?>