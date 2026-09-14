

<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('page-heading', $title); ?>
<?php $__env->startSection('page-description', $description); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.modules.partials.module-shell', [
        'title' => $title,
        'description' => $description,
        'publicRoute' => $publicRoute ?? null,
        'publicLabel' => $publicLabel ?? null,
        'stats' => [
            ['label' => 'Total Berita', 'value' => '24', 'caption' => 'Artikel aktif'],
            ['label' => 'Draft', 'value' => '6', 'caption' => 'Belum diterbitkan'],
            ['label' => 'Terbit', 'value' => '18', 'caption' => 'Sudah publik'],
            ['label' => 'Kunjungan', 'value' => '3.2k', 'caption' => 'Bulan ini'],
        ],
        'table' => [
            'headers' => ['Judul', 'Kategori', 'Status', 'Tanggal'],
            'rows' => [
                ['Pramuka Peduli Lingkungan', 'Sosial', 'Terbit', '08 Jan 2024'],
                ['Latihan Navigasi Darat', 'Skills', 'Draft', '14 Jan 2024'],
                ['Pelatihan Dasar Bantara', 'Training', 'Terbit', '21 Jan 2024'],
            ],
        ],
        'formFields' => [
            ['label' => 'Judul berita', 'placeholder' => 'Masukkan judul berita'],
            ['label' => 'Kategori', 'placeholder' => 'Sosial / Akademik / Event'],
            ['label' => 'Tanggal publikasi', 'type' => 'date'],
            ['label' => 'Status', 'type' => 'select', 'options' => ['Draft', 'Terbit', 'Arsip']],
            ['label' => 'Ringkasan', 'type' => 'textarea', 'full' => true, 'placeholder' => 'Tuliskan ringkasan berita'],
        ],
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/admin/modules/news.blade.php ENDPATH**/ ?>