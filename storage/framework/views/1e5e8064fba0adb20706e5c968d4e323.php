

<?php $__env->startSection('title', $title ?? 'Kelola Visi & Misi'); ?>
<?php $__env->startSection('page-heading', $title ?? 'Kelola Visi & Misi'); ?>
<?php $__env->startSection('page-description', $description ?? 'Atur konten visi dan misi yang tampil di halaman profil.'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 dark:border-emerald-900/60 dark:bg-emerald-950/30 dark:text-emerald-300">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php echo $__env->make('admin.modules.partials.module-shell', [
            'title' => $title ?? 'Kelola Visi & Misi',
            'description' => $description ?? 'Atur isi visi dan misi agar dapat dikelola dengan cepat dan tampil secara real-time di halaman profil.',
            'publicRoute' => $publicRoute ?? route('visi-misi'),
            'publicLabel' => $publicLabel ?? 'Lihat Halaman Visi & Misi',
            'stats' => $stats ?? [
                ['label' => 'Kwarnas', 'value' => '1', 'caption' => 'Konten utama'],
                ['label' => 'Pangkalan', 'value' => '1', 'caption' => 'Konten utama'],
                ['label' => 'Tampilan', 'value' => 'Live', 'caption' => 'Update persis di frontend'],
                ['label' => 'Status', 'value' => 'Aktif', 'caption' => 'Siap dipublikasi'],
            ],
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <form action="<?php echo e(route('admin.visi-misi.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <?php echo csrf_field(); ?>

            <?php
                $defaultSections = [
                    'visi_misi_kwarnas' => [
                        'title' => 'Visi, Misi, Dan Tujuan Kwartir Nasional (Kwarnas)',
                        'description' => 'Gerakan Pramuka sebagai organisasi pendidikan nonformal yang turut berperan dalam pendidikan kaum muda Indonesia. Tanggung jawab utama yang dihadapi adalah bagaimana menempatkan Pramuka sebagai bagian penting dalam lingkungan strategis Indonesia serta memposisikan kegiatan Pramuka sebagai centre of excellence bagi para pemuda.',
                    ],
                    'visi_misi_pangkalan' => [
                        'title' => 'Visi, Misi, Dan Tujuan Ambalan Pangkalan',
                        'description' => 'Mewujudkan Pramuka Penegak yang berkarakter luhur, cerdas, mandiri, berwawasan global, serta berlandaskan Tri Satya dan Dasa Darma.',
                    ],
                ];
            ?>

            <div class="grid gap-6 lg:grid-cols-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['visi_misi_kwarnas' => 'Kwarnas', 'visi_misi_pangkalan' => 'Pangkalan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $logoValue = old($key . '_logo', $settings[$key . '_logo'] ?? null);
                    ?>

                    <div class="rounded-[2rem] border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-6">
                        <div class="mb-5 flex items-center justify-between gap-3">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900 dark:text-white"><?php echo e($label); ?></h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400">Ubah judul, logo, dan deskripsi yang tampil di bagian ini.</p>
                            </div>
                            <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.14em] text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">Live</span>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Judul</label>
                                <input
                                    type="text"
                                    name="<?php echo e($key); ?>_title"
                                    value="<?php echo e(old($key . '_title', $settings[$key . '_title'] ?? $defaultSections[$key]['title'])); ?>"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white"
                                >
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Logo</label>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($logoValue)): ?>
                                    <div class="mb-3 flex items-center justify-center rounded-xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-700 dark:bg-slate-800/60">
                                        <img src="<?php echo e(Str::startsWith($logoValue, 'http') ? $logoValue : asset('storage/' . $logoValue)); ?>" alt="Logo <?php echo e($label); ?>" class="max-h-24 w-auto object-contain">
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <input
                                    type="file"
                                    name="<?php echo e($key); ?>_logo"
                                    accept="image/*"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition file:mr-3 file:rounded-md file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-sm file:font-medium file:text-slate-700 hover:file:bg-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:file:bg-slate-800 dark:file:text-slate-200"
                                >
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Deskripsi</label>
                                <textarea
                                    name="<?php echo e($key); ?>_description"
                                    rows="8"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white"
                                ><?php echo e(old($key . '_description', $settings[$key . '_description'] ?? $defaultSections[$key]['description'])); ?></textarea>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-700 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-200">
                    Simpan Visi & Misi
                </button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/admin/modules/visi-misi.blade.php ENDPATH**/ ?>