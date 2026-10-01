

<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('page-heading', $title); ?>
<?php $__env->startSection('page-description', $description); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.modules.partials.module-shell', [
        'title' => $title,
        'description' => $description,
        'stats' => [
            ['label' => 'Total Akun', 'value' => '48', 'caption' => 'Semua pengguna'],
            ['label' => 'Admin', 'value' => '6', 'caption' => 'Akses penuh'],
            ['label' => 'User', 'value' => '42', 'caption' => 'Akses terbatas'],
            ['label' => 'Aktif', 'value' => '44', 'caption' => 'Login terkini'],
        ],
        'table' => [
            'headers' => ['Nama', 'Email', 'Role', 'Status'],
            'rows' => [
                ['Admin Utama', 'admin@scoutmind.id', 'Administrator', 'Aktif'],
                ['Rina Amalia', 'rina@scoutmind.id', 'Pengguna', 'Aktif'],
                ['Dedi Pratama', 'dedi@scoutmind.id', 'Pengguna', 'Nonaktif'],
            ],
        ],
        'formFields' => [
            ['label' => 'Nama lengkap', 'placeholder' => 'Masukkan nama'],
            ['label' => 'Email', 'type' => 'email', 'placeholder' => 'nama@domain.com'],
            ['label' => 'Password', 'type' => 'password', 'placeholder' => 'Minimal 8 karakter'],
            ['label' => 'Role', 'type' => 'select', 'options' => ['Administrator', 'Pengguna', 'Moderator']],
            ['label' => 'Status', 'type' => 'select', 'options' => ['Aktif', 'Nonaktif']],
        ],
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views\admin\modules\users.blade.php ENDPATH**/ ?>