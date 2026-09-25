

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
            ['label' => 'Agenda Bulan Ini', 'value' => '8', 'caption' => 'Kegiatan terjadwal'],
            ['label' => 'Belum Mulai', 'value' => '3', 'caption' => 'Jadwal menunggu'],
            ['label' => 'Sedang Berjalan', 'value' => '2', 'caption' => 'Aktif hari ini'],
            ['label' => 'Selesai', 'value' => '11', 'caption' => 'Telah dilaksanakan'],
        ],
        'table' => [
            'headers' => ['Judul', 'Tanggal', 'Lokasi', 'Status'],
            'rows' => [
                ['Pelantikan Bantara', '12 Jan 2025', 'Lapangan Sekolah', 'Akan Datang'],
                ['Latihan PBB', '18 Jan 2025', 'Halaman Gudep', 'Aktif'],
                ['Camp Out', '25 Jan 2025', 'Hutan Kareta', 'Akan Datang'],
            ],
        ],
        'formFields' => [
            ['label' => 'Judul kegiatan', 'placeholder' => 'Masukkan judul acara'],
            ['label' => 'Lokasi', 'placeholder' => 'Masukkan lokasi'],
            ['label' => 'Tanggal', 'type' => 'date'],
            ['label' => 'Status', 'type' => 'select', 'options' => ['Akan Datang', 'Aktif', 'Selesai']],
            ['label' => 'Deskripsi kegiatan', 'type' => 'textarea', 'full' => true, 'placeholder' => 'Tuliskan deskripsi dan tujuan kegiatan'],
        ],
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views\admin\modules\agenda.blade.php ENDPATH**/ ?>