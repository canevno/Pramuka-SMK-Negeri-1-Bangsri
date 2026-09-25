

<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('page-heading', $title); ?>
<?php $__env->startSection('page-description', $description); ?>

<?php $__env->startSection('content'); ?>
    <style>
        .prestasi-scrollbar-hidden {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .prestasi-scrollbar-hidden::-webkit-scrollbar {
            display: none;
        }
    </style>

    <?php
        $stats = [
            ['label' => 'Total Prestasi', 'value' => count($achievements ?? []), 'caption' => 'Data tersimpan', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
            ['label' => 'Tahun Terbaru', 'value' => (count($achievements ?? []) > 0 ? (string) ($achievements[0]['year'] ?? now()->year) : '-'), 'caption' => 'Pencapaian terakhir', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
            ['label' => 'Kategori', 'value' => count(array_unique(array_column($achievements ?? [], 'category'))), 'caption' => 'Jenis prestasi', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
            ['label' => 'Status', 'value' => 'Aktif', 'caption' => 'Publikasi berjalan', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ];
    ?>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center justify-between">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400"><?php echo e($stat['label']); ?></p>
                    <div class="rounded-xl bg-slate-100 p-2.5 text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($stat['icon']); ?>"></path></svg>
                    </div>
                </div>
                <p class="mt-4 text-3xl font-bold text-slate-900 dark:text-white"><?php echo e($stat['value']); ?></p>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400"><?php echo e($stat['caption']); ?></p>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.6fr_0.9fr]">
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4 dark:border-slate-800">
                <div>
                    <h3 class="text-base font-semibold text-slate-900 dark:text-white">Daftar Prestasi</h3>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Kelola data pencapaian yang sudah masuk.</p>
                </div>
                <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                    <?php echo e(count($achievements ?? [])); ?> Item
                </span>
            </div>

            <div class="prestasi-scrollbar-hidden overflow-x-auto">
                <table class="min-w-full text-left text-sm text-slate-600 dark:text-slate-300">
                    <thead class="bg-slate-50 text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-500 dark:bg-slate-800/50 dark:text-slate-400">
                        <tr>
                            <th class="px-5 py-3">Judul</th>
                            <th class="px-5 py-3">Kategori</th>
                            <th class="px-5 py-3">Tahun</th>
                            <th class="px-5 py-3">Pemenang</th>
                            <th class="px-5 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $achievements ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $achievement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="align-top dark:hover:bg-slate-800/40">
                                <td class="px-5 py-4">
                                    <div class="font-semibold text-slate-900 dark:text-white"><?php echo e($achievement['title']); ?></div>
                                </td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                                        <?php echo e($achievement['category']); ?>

                                    </span>
                                </td>
                                <td class="px-5 py-4"><?php echo e($achievement['year']); ?></td>
                                <td class="px-5 py-4 text-slate-700 dark:text-slate-300"><?php echo e($achievement['winner']); ?></td>
                                <td class="px-5 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <button type="button"
                                            data-edit-id="<?php echo e($achievement['id']); ?>"
                                            data-edit-title="<?php echo e($achievement['title']); ?>"
                                            data-edit-category="<?php echo e($achievement['category']); ?>"
                                            data-edit-year="<?php echo e($achievement['year']); ?>"
                                            data-edit-winner="<?php echo e($achievement['winner']); ?>"
                                            data-edit-winner-link="<?php echo e($achievement['winner_social_link'] ?? ''); ?>"
                                            data-edit-description="<?php echo e($achievement['description'] ?? ''); ?>"
                                            class="js-edit-achievement inline-flex items-center gap-1.5 rounded-lg border border-amber-200 bg-amber-50 px-2.5 py-1.5 text-[11px] font-medium text-amber-700 transition hover:border-amber-300 hover:bg-amber-100 dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-300 dark:hover:bg-amber-500/15">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-9.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 7.5-7.5z"></path></svg>
                                            Edit
                                        </button>

                                        <form method="POST" action="<?php echo e(route('admin.prestasi.duplicate', $achievement['id'])); ?>" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg border border-emerald-200 bg-emerald-50 px-2.5 py-1.5 text-[11px] font-medium text-emerald-700 transition hover:border-emerald-300 hover:bg-emerald-100 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300 dark:hover:bg-emerald-500/15">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                                Duplikat
                                            </button>
                                        </form>

                                        <form method="POST" action="<?php echo e(route('admin.prestasi.delete', $achievement['id'])); ?>" onsubmit="return confirm('Apakah Anda yakin ingin menghapus prestasi ini? Tindakan ini tidak dapat dibatalkan.')" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg border border-red-200 bg-red-50 px-2.5 py-1.5 text-[11px] font-medium text-red-600 transition hover:border-red-300 hover:bg-red-100 dark:border-red-500/20 dark:bg-red-500/10 dark:text-red-300 dark:hover:bg-red-500/15">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="mx-auto h-12 w-12 rounded-full bg-slate-100 p-3 dark:bg-slate-800">
                                        <svg class="h-6 w-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    </div>
                                    <p class="mt-3 text-sm font-medium text-slate-900 dark:text-white">Belum ada data prestasi</p>
                                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Mulai tambahkan prestasi baru menggunakan formulir di samping.</p>
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="border-b border-slate-200 px-5 py-4 dark:border-slate-800">
                <h3 class="text-base font-semibold text-slate-900 dark:text-white">Tambah Prestasi</h3>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Isi detail pencapaian baru.</p>
            </div>

            <form method="POST" action="<?php echo e(route('admin.prestasi.store')); ?>" enctype="multipart/form-data" class="space-y-5 p-5" id="achievement-form">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="edit_id" id="edit_id" value="">

                <div>
                    <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Judul Prestasi <span class="text-red-500">*</span></label>
                    <input id="achievement_title" type="text" name="title" required class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:placeholder-slate-500" placeholder="Contoh: Juara 1 Lomba Pionering" />
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Kategori <span class="text-red-500">*</span></label>
                        <select id="achievement_category" name="category" required class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                            <option value="">Pilih tingkat prestasi</option>
                            <option value="Tingkat Ranting">Tingkat Ranting</option>
                            <option value="Tingkat Cabang">Tingkat Cabang</option>
                            <option value="Tingkat Jateng">Tingkat Jateng</option>
                            <option value="Tingkat Nasional">Tingkat Nasional</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Tahun <span class="text-red-500">*</span></label>
                        <input id="achievement_year" type="number" name="year" value="<?php echo e(now()->year); ?>" required min="2000" max="2100" class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Pemenang / Peserta <span class="text-red-500">*</span></label>
                    <input id="achievement_winner" type="text" name="winner" required class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:placeholder-slate-500" placeholder="Nama anggota atau regu" />
                </div>

                <div>
                    <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Link Media Sosial Pemenang</label>
                    <input id="achievement_winner_link" type="url" name="winner_social_link" class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:placeholder-slate-500" placeholder="https://instagram.com/username" />
                    <p class="mt-1 text-[11px] text-slate-400">Kosongkan jika tidak ingin dihubungkan ke media sosial.</p>
                </div>

                <div>
                    <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Deskripsi <span class="text-red-500">*</span></label>
                    <textarea id="achievement_description" rows="4" name="description" required class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:placeholder-slate-500" placeholder="Tuliskan deskripsi singkat pencapaian..."></textarea>
                </div>

                <div>
                    <input type="hidden" name="image_path" value="images/achievement/prestasi1.jpg">
                    <label class="mb-1.5 block text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Gambar Prestasi</label>

                    <div id="prestasi-upload-box" class="group relative cursor-pointer overflow-hidden rounded-2xl border-2 border-dashed border-slate-300 bg-gradient-to-br from-slate-50 via-white to-emerald-50 p-3 transition-all duration-200 hover:border-emerald-400 hover:bg-emerald-50/80 dark:border-slate-700 dark:from-slate-800/90 dark:via-slate-900 dark:to-emerald-950/60 dark:hover:border-emerald-500">
                        <div id="prestasi-empty-state" class="flex min-h-[170px] flex-col items-center justify-center gap-3 rounded-xl border border-slate-200/80 bg-white/70 px-4 py-5 text-center shadow-inner dark:border-slate-700 dark:bg-slate-950/30">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 shadow-sm dark:bg-emerald-500/10 dark:text-emerald-300">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-700 dark:text-slate-100">Tarik gambar ke sini</p>
                                <p class="mt-1 text-[11px] text-slate-500 dark:text-slate-400">atau klik untuk memilih file</p>
                            </div>
                            <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-600 dark:bg-slate-800 dark:text-slate-300">JPG • PNG • WEBP</span>
                        </div>

                        <div id="prestasi-preview-wrap" class="hidden overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-950/40">
                            <img id="prestasi-preview" alt="Preview prestasi" class="h-[170px] w-full object-cover" />
                            <div class="flex items-center justify-between gap-3 border-t border-slate-200 px-3 py-2 dark:border-slate-700">
                                <span id="prestasi-file-name" class="truncate text-xs font-medium text-slate-700 dark:text-slate-200"></span>
                                <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-[0.12em] text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">Preview</span>
                            </div>
                        </div>
                    </div>

                    <input id="prestasi-image-input" type="file" name="image" accept="image/*" class="hidden" />
                    <p class="mt-2 text-[11px] text-slate-400">Biarkan default jika tidak ada gambar khusus.</p>
                </div>

                <button type="submit" id="achievement-submit-button" class="flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span id="achievement-submit-label">Simpan Prestasi</span>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('achievement-form');
        const submitLabel = document.getElementById('achievement-submit-label');
        const editId = document.getElementById('edit_id');
        const titleInput = document.getElementById('achievement_title');
        const categoryInput = document.getElementById('achievement_category');
        const yearInput = document.getElementById('achievement_year');
        const winnerInput = document.getElementById('achievement_winner');
        const winnerLinkInput = document.getElementById('achievement_winner_link');
        const descriptionInput = document.getElementById('achievement_description');

        document.querySelectorAll('.js-edit-achievement').forEach(function (button) {
            button.addEventListener('click', function () {
                const id = button.dataset.editId;
                const title = button.dataset.editTitle || '';
                const category = button.dataset.editCategory || '';
                const year = button.dataset.editYear || '<?php echo e(now()->year); ?>';
                const winner = button.dataset.editWinner || '';
                const winnerLink = button.dataset.editWinnerLink || '';
                const description = button.dataset.editDescription || '';

                editId.value = id;
                titleInput.value = title;
                categoryInput.value = category;
                yearInput.value = year;
                winnerInput.value = winner;
                winnerLinkInput.value = winnerLink;
                descriptionInput.value = description;

                form.action = '<?php echo e(route('admin.prestasi.store')); ?>';
                submitLabel.textContent = 'Perbarui Prestasi';
                titleInput.focus();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });

        form.addEventListener('submit', function () {
            if (!editId.value) {
                form.action = '<?php echo e(route('admin.prestasi.store')); ?>';
                return;
            }

            form.action = '<?php echo e(route('admin.prestasi.store')); ?>';
        });
        const uploadBox = document.getElementById('prestasi-upload-box');
        const input = document.getElementById('prestasi-image-input');
        const fileLabel = document.getElementById('prestasi-file-name');
        const previewWrap = document.getElementById('prestasi-preview-wrap');
        const previewImage = document.getElementById('prestasi-preview');
        const emptyState = document.getElementById('prestasi-empty-state');

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
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views\admin\modules\prestasi.blade.php ENDPATH**/ ?>