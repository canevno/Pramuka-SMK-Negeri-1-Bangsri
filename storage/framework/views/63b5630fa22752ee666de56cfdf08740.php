

<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('page-heading', $title); ?>
<?php $__env->startSection('page-description', $description); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.modules.partials.module-shell', [
        'title' => $title,
        'description' => $description,
        'stats' => [
            ['label' => 'Status Situs', 'value' => 'Online', 'caption' => 'Website aktif'],
            ['label' => 'Logo', 'value' => '1', 'caption' => 'Brand terpasang'],
            ['label' => 'Badan', 'value' => '2', 'caption' => 'Tema aktif'],
            ['label' => 'Kontak', 'value' => '4', 'caption' => 'Poin informasi'],
        ],
        'table' => [
            'headers' => ['Pengaturan', 'Nilai Saat Ini', 'Status'],
            'rows' => [
                ['Judul Website', 'Scoutmind', 'Aktif'],
                ['Deskripsi', 'Pramuka dan kegiatan komunitas', 'Aktif'],
                ['Kontak Admin', '+62 812-3456-7890', 'Aktif'],
                ['Tema', 'Light / Dark', 'Aktif'],
            ],
        ],
        'formFields' => [
            ['label' => 'Judul website', 'placeholder' => 'Masukkan judul website'],
            ['label' => 'Deskripsi singkat', 'placeholder' => 'Deskripsi singkat organisasi'],
            ['label' => 'Kontak admin', 'placeholder' => 'Nomor telepon atau email'],
            ['label' => 'Tema', 'type' => 'select', 'options' => ['Light', 'Dark', 'Sistem default']],
            ['label' => 'Logo situs', 'type' => 'file'],
            ['label' => 'Catatan pengaturan', 'type' => 'textarea', 'full' => true, 'placeholder' => 'Catatan untuk info admin'],
        ],
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/admin/modules/settings.blade.php ENDPATH**/ ?>