

<?php $__env->startSection('title', 'Pengaturan Website'); ?>
<?php $__env->startSection('page-title', 'Pengaturan Website'); ?>
<?php $__env->startSection('page-description', 'Kelola judul, deskripsi, hero, sambutan, dan gambar utama yang sering dipakai di halaman depan.'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-950">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Pengaturan Website</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Atur teks dan gambar utama yang muncul di hero, sambutan, dan section publik umum.</p>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-900 dark:bg-emerald-950/30 dark:text-emerald-300">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <form method="POST" action="<?php echo e(route('admin.settings.store')); ?>" enctype="multipart/form-data" class="space-y-6">
        <?php echo csrf_field(); ?>

        <div class="grid gap-6 md:grid-cols-2">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                <h2 class="mb-4 text-lg font-semibold text-slate-900 dark:text-white">Umum</h2>

                <div class="space-y-4">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Judul Website</label>
                        <input type="text" name="site_title" value="<?php echo e(old('site_title', $settings['site_title'] ?? '')); ?>" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 outline-none ring-0 transition focus:border-slate-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white" placeholder="Scoutmind">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Deskripsi Website</label>
                        <textarea name="site_description" rows="4" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 outline-none transition focus:border-slate-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white" placeholder="Deskripsi umum situs"><?php echo e(old('site_description', $settings['site_description'] ?? '')); ?></textarea>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                <h2 class="mb-4 text-lg font-semibold text-slate-900 dark:text-white">Hero</h2>
                <div class="rounded-xl border border-sky-200 bg-sky-50 p-4 text-sm text-sky-800 dark:border-sky-900 dark:bg-sky-950/30 dark:text-sky-200">
                    Pengaturan hero utama dipindahkan ke halaman admin hero.
                    <a href="http://127.0.0.1:8000/admin/hero" target="_blank" rel="noopener noreferrer" class="ml-1 font-semibold underline underline-offset-2">Buka http://127.0.0.1:8000/admin/hero</a>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                <h2 class="mb-4 text-lg font-semibold text-slate-900 dark:text-white">Sambutan</h2>

                <div class="space-y-4">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Judul Sambutan</label>
                        <input type="text" name="sambutan_title" value="<?php echo e(old('sambutan_title', $settings['sambutan_title'] ?? '')); ?>" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 outline-none transition focus:border-slate-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white" placeholder="Sambutan Ketua Gugus Depan">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Subjudul Sambutan</label>
                        <input type="text" name="sambutan_subtitle" value="<?php echo e(old('sambutan_subtitle', $settings['sambutan_subtitle'] ?? '')); ?>" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 outline-none transition focus:border-slate-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white" placeholder="Jepara, 17 Juni 2026">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Deskripsi Sambutan</label>
                        <textarea name="sambutan_description" rows="5" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 outline-none transition focus:border-slate-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white" placeholder="Tulis isi sambutan secara lengkap"><?php echo e(old('sambutan_description', $settings['sambutan_description'] ?? '')); ?></textarea>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Instagram</label>
                        <input type="url" name="sambutan_instagram" value="<?php echo e(old('sambutan_instagram', $settings['sambutan_instagram'] ?? '')); ?>" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 outline-none transition focus:border-slate-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white" placeholder="https://instagram.com/username">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Facebook</label>
                        <input type="url" name="sambutan_facebook" value="<?php echo e(old('sambutan_facebook', $settings['sambutan_facebook'] ?? '')); ?>" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 outline-none transition focus:border-slate-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white" placeholder="https://facebook.com/username">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Gambar Sambutan</label>
                        <input type="file" name="sambutan_image" accept="image/*" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 outline-none transition focus:border-slate-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($settings['sambutan_image'])): ?>
                            <img src="<?php echo e(asset('storage/' . $settings['sambutan_image'])); ?>" alt="Sambutan" class="mt-3 h-28 w-full rounded-xl object-cover border border-slate-200 dark:border-slate-700">
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-950 md:col-span-2">
                <h2 class="mb-4 text-lg font-semibold text-slate-900 dark:text-white">Organisasi / Section Umum</h2>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Judul Organisasi</label>
                        <input type="text" name="organization_title" value="<?php echo e(old('organization_title', $settings['organization_title'] ?? '')); ?>" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 outline-none transition focus:border-slate-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white" placeholder="Our Organisation">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Deskripsi Organisasi</label>
                        <textarea name="organization_description" rows="3" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 outline-none transition focus:border-slate-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white" placeholder="Deskripsi umum organisasi"><?php echo e(old('organization_description', $settings['organization_description'] ?? '')); ?></textarea>
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [1,2,3,4]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-200">Gambar Card <?php echo e($index); ?></label>
                            <input type="file" name="organization_card_<?php echo e($index); ?>_image" accept="image/*" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 outline-none transition focus:border-slate-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white">
                            <?php $key = 'organization_card_' . $index . '_image'; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($settings[$key])): ?>
                                <img src="<?php echo e(asset('storage/' . $settings[$key])); ?>" alt="Card <?php echo e($index); ?>" class="mt-3 h-24 w-full rounded-xl object-cover border border-slate-200 dark:border-slate-700">
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="inline-flex items-center rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-700 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-200">
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>