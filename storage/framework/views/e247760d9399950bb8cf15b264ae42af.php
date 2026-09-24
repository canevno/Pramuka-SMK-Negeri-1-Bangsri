

<?php $__env->startSection('title', $title ?? 'Kelola Profil'); ?>
<?php $__env->startSection('page-heading', $title ?? 'Kelola Profil'); ?>
<?php $__env->startSection('page-description', $description ?? 'Kelola konten profil untuk semua section di halaman tentang kami.'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="mb-4 flex items-center justify-between gap-3">
            <div>
                <h3 class="text-lg font-semibold text-slate-900">Kelola Profil</h3>
                <p class="text-sm text-slate-500">Mengatur semua 7 section halaman profil: sejarah, lambang, hymne, dan UU Pramuka.</p>
            </div>
            <a href="<?php echo e($publicRoute ?? route('about')); ?>" class="rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                <?php echo e($publicLabel ?? 'Lihat Halaman Profil'); ?>

            </a>
        </div>

        <form action="<?php echo e(route('admin.profile.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <?php echo csrf_field(); ?>

            <?php
                $sections = [
                    [
                        'group' => 'Kepanduan Dunia',
                        'title_key' => 'profile_kepanduan_dunia_title',
                        'content_key' => 'profile_kepanduan_dunia_content',
                        'image_key' => 'profile_kepanduan_dunia_image',
                        'default_title' => 'Kepanduan Dunia',
                        'default_content' => 'Kepanduan dunia berawal dari ...',
                        'has_image' => true,
                    ],
                    [
                        'group' => 'Kepanduan Indonesia',
                        'title_key' => 'profile_kepanduan_indonesia_title',
                        'content_key' => 'profile_kepanduan_indonesia_content',
                        'image_key' => 'profile_kepanduan_indonesia_image',
                        'default_title' => 'Kepanduan Indonesia',
                        'default_content' => 'Gerakan pendidikan kepanduan di Tanah Air ...',
                        'has_image' => true,
                    ],
                    [
                        'group' => 'Gerakan Pramuka',
                        'title_key' => 'profile_gerakan_pramuka_title',
                        'content_key' => 'profile_gerakan_pramuka_content',
                        'image_key' => 'profile_gerakan_pramuka_image',
                        'default_title' => 'Gerakan Pramuka',
                        'default_content' => 'Gerakan Pramuka adalah organisasi pendidikan nonformal ...',
                        'has_image' => true,
                    ],
                    [
                        'group' => 'AD - ART Munas 2023',
                        'title_key' => 'profile_adart_title',
                        'content_key' => 'profile_adart_content',
                        'pdf_key' => 'profile_adart_pdf_url',
                        'default_title' => 'AD - ART Munas 2023',
                        'default_content' => 'Dokumen AD - ART dapat diubah melalui admin ...',
                        'has_image' => false,
                        'has_pdf' => true,
                    ],
                    [
                        'group' => 'Lambang',
                        'title_key' => 'profile_lambang_title',
                        'content_key' => 'profile_lambang_content',
                        'image_key' => 'profile_lambang_image',
                        'default_title' => 'Lambang',
                        'default_content' => 'Lambang Gerakan Pramuka adalah tunas kelapa ...',
                        'has_image' => true,
                    ],
                    [
                        'group' => 'Hymne & Mars',
                        'title_key' => 'profile_hymne_mars_title',
                        'content_key' => 'profile_hymne_mars_content',
                        'default_title' => 'Hymne & Mars',
                        'default_content' => 'Hymne dan Mars Pramuka ...',
                        'has_image' => false,
                    ],
                    [
                        'group' => 'UU Pramuka',
                        'title_key' => 'profile_uu_title',
                        'content_key' => 'profile_uu_content',
                        'pdf_key' => 'profile_uu_pdf_url',
                        'default_title' => 'Undang-undang Nomor 12 Tahun 2010 Tentang Gerakan Pramuka',
                        'default_content' => 'Pendidikan kepramukaan merupakan ...',
                        'has_image' => false,
                        'has_pdf' => true,
                    ],
                ];
            ?>

            <div class="grid gap-6 xl:grid-cols-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <div class="mb-4">
                            <h4 class="text-base font-semibold text-slate-900"><?php echo e($section['group']); ?></h4>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="mb-1 block text-xs font-medium uppercase tracking-[0.12em] text-slate-500">Judul section</label>
                                <input type="text" name="<?php echo e($section['title_key']); ?>" value="<?php echo e(old($section['title_key'], $settings[$section['title_key']] ?? $section['default_title'])); ?>" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-slate-500 focus:outline-none">
                            </div>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($section['image_key'])): ?>
                                <div>
                                    <label class="mb-1 block text-xs font-medium uppercase tracking-[0.12em] text-slate-500">Gambar utama</label>
                                    <input type="file" name="<?php echo e($section['image_key']); ?>" accept="image/*" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 file:mr-3 file:rounded file:border-0 file:bg-slate-900 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-white">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($settings[$section['image_key']])): ?>
                                        <div class="mt-3 overflow-hidden rounded-xl border border-slate-200 bg-white">
                                            <img src="<?php echo e(asset('storage/' . $settings[$section['image_key']])); ?>" alt="<?php echo e($section['group']); ?>" class="h-28 w-full object-cover">
                                        </div>
                                        <label class="mt-2 inline-flex items-center gap-2 text-sm text-red-600">
                                            <input type="checkbox" name="remove_<?php echo e($section['image_key']); ?>" value="1" class="h-4 w-4 rounded border-slate-300 text-red-600 focus:ring-red-500">
                                            Hapus gambar
                                        </label>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($section['pdf_key'])): ?>
                                <div>
                                    <label class="mb-1 block text-xs font-medium uppercase tracking-[0.12em] text-slate-500">URL PDF</label>
                                    <input type="url" name="<?php echo e($section['pdf_key']); ?>" value="<?php echo e(old($section['pdf_key'], $settings[$section['pdf_key']] ?? '')); ?>" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-slate-500 focus:outline-none" placeholder="https://..."></input>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <div>
                                <label class="mb-1 block text-xs font-medium uppercase tracking-[0.12em] text-slate-500">Isi konten</label>
                                <textarea name="<?php echo e($section['content_key']); ?>" rows="10" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-slate-500 focus:outline-none"><?php echo e(old($section['content_key'], $settings[$section['content_key']] ?? $section['default_content'])); ?></textarea>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-700">
                    Simpan Semua Section Profil
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/admin/modules/profile.blade.php ENDPATH**/ ?>