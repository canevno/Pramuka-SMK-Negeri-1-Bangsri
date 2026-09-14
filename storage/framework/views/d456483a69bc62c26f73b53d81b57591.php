

<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('page-heading', $title); ?>
<?php $__env->startSection('page-description', $description); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.modules.partials.module-shell', [
        'title' => $title,
        'description' => $description,
        'stats' => [
            ['label' => 'Total Komentar', 'value' => '29', 'caption' => 'Semua komentar'],
            ['label' => 'Baru', 'value' => '8', 'caption' => 'Belum dibaca'],
            ['label' => 'Disetujui', 'value' => '15', 'caption' => 'Sudah tampil'],
            ['label' => 'Ditolak', 'value' => '6', 'caption' => 'Dihapus atau dihindari'],
        ],
        'table' => [
            'headers' => ['Nama', 'Email', 'Pesan', 'Status'],
            'rows' => [
                ['Sinta', 'sinta@mail.com', 'Kegiatan sangat bermanfaat', 'Disetujui'],
                ['Dimas', 'dimas@mail.com', 'Tolong tambah materi camp', 'Baru'],
                ['Ayu', 'ayu@mail.com', 'Poster kurang jelas', 'Ditolak'],
            ],
        ],
        'formFields' => [
            ['label' => 'Nama pengirim', 'placeholder' => 'Masukkan nama'],
            ['label' => 'Email', 'type' => 'email', 'placeholder' => 'email@domain.com'],
            ['label' => 'Status moderasi', 'type' => 'select', 'options' => ['Baru', 'Disetujui', 'Ditolak']],
            ['label' => 'Balasan admin', 'type' => 'textarea', 'full' => true, 'placeholder' => 'Tulis respon atau catatan moderasi'],
        ],
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/admin/modules/comments.blade.php ENDPATH**/ ?>