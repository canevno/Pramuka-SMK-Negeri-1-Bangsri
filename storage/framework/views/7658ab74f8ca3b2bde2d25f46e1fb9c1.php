

<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('page-heading', $title); ?>
<?php $__env->startSection('page-description', $description); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.modules.partials.module-shell', [
        'title' => $title,
        'description' => $description,
        'stats' => [
            ['label' => 'Total File', 'value' => '17', 'caption' => 'Dokumen tersedia'],
            ['label' => 'PDF', 'value' => '9', 'caption' => 'Berkas dokumen'],
            ['label' => 'Gambar', 'value' => '4', 'caption' => 'Poster dan banner'],
            ['label' => 'Format Lain', 'value' => '4', 'caption' => 'Dokumen tambahan'],
        ],
        'table' => [
            'headers' => ['Judul', 'Jenis', 'Ukuran', 'Tanggal'],
            'rows' => [
                ['Panduan Bantara', 'PDF', '1.2 MB', '12 Jan 2025'],
                ['Poster Kegiatan', 'Image', '640 KB', '18 Jan 2025'],
                ['Formulir Registrasi', 'DOCX', '230 KB', '22 Jan 2025'],
            ],
        ],
        'formFields' => [
            ['label' => 'Judul berkas', 'placeholder' => 'Masukkan judul file'],
            ['label' => 'Kategori', 'placeholder' => 'Dokumen / Poster / Formulir'],
            ['label' => 'Tanggal publikasi', 'type' => 'date'],
            ['label' => 'File upload', 'type' => 'file'],
            ['label' => 'Deskripsi', 'type' => 'textarea', 'full' => true, 'placeholder' => 'Keterangan singkat tentang file'],
        ],
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views\admin\modules\downloads.blade.php ENDPATH**/ ?>