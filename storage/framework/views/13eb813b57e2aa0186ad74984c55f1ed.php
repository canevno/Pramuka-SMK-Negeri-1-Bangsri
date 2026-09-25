

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
            ['label' => 'Total Pendaftar', 'value' => '42', 'caption' => 'Bulan ini'],
            ['label' => 'Disetujui', 'value' => '28', 'caption' => 'Sudah lolos'],
            ['label' => 'Pending', 'value' => '11', 'caption' => 'Menunggu review'],
            ['label' => 'Ditolak', 'value' => '3', 'caption' => 'Perlu koreksi'],
        ],
        'table' => [
            'headers' => ['Nama', 'Golongan', 'Asal', 'Status'],
            'rows' => [
                ['Rafi Hidayat', 'Laksana', 'SMK 1', 'Disetujui'],
                ['Alya Nuraeni', 'Laksana', 'SMA 2', 'Pending'],
                ['Dian Kusuma', 'Laksana', 'SMA 5', 'Ditolak'],
            ],
        ],
        'formFields' => [
            ['label' => 'Nama lengkap', 'placeholder' => 'Masukkan nama lengkap'],
            ['label' => 'Golongan', 'placeholder' => 'Contoh: Laksana'],
            ['label' => 'Asal sekolah', 'placeholder' => 'Masukkan sekolah / gugus'],
            ['label' => 'Status verifikasi', 'type' => 'select', 'options' => ['Pending', 'Disetujui', 'Ditolak']],
            ['label' => 'Catatan admin', 'type' => 'textarea', 'full' => true, 'placeholder' => 'Catatan atau keterangan verifikasi'],
        ],
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views\admin\modules\pendaftaran-laksana.blade.php ENDPATH**/ ?>