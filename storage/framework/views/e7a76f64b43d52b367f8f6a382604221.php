<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Petugas Absensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-xl shadow-md dark:bg-slate-900 dark:text-slate-100">
        <h1 class="text-2xl font-bold mb-6 text-slate-900 dark:text-white">Manajemen Petugas Absensi</h1>

        <!-- Form Tambah Petugas (Updated: Grid 5 kolom) -->
        <form action="<?php echo e(route('admin.petugas.store')); ?>" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
            <?php echo csrf_field(); ?>
            <input type="text" name="nama" placeholder="Nama Petugas" required class="border p-2 rounded">
            <input type="text" name="nta" placeholder="NTA Petugas" required class="border p-2 rounded">
            <input type="text" name="kelas_petugas" placeholder="Kelas (misal: XII MIPA 1)" required class="border p-2 rounded">
            
            <!-- Tambahan Input Jenis Kelamin -->
            <select name="jenis_kelamin" required class="border p-2 rounded bg-white text-gray-700">
                <option value="" disabled selected>Pilih Gender / Ambalan</option>
                <option value="L">Laki-laki (Ambalan PA)</option>
                <option value="P">Perempuan (Ambalan PI)</option>
            </select>

            <button type="submit" class="bg-emerald-600 text-white rounded font-bold hover:bg-emerald-700 py-2">Tambah Petugas</button>
        </form>

        <!-- Tabel Daftar Petugas -->
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="p-3">NTA</th>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Kelas</th>
                    <th class="p-3">Gender / Ambalan</th>
                    <th class="p-3">Total Rekam</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $petugas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3 font-mono text-sm"><?php echo e($p->nta); ?></td>
                        <td class="p-3 font-semibold"><?php echo e($p->nama); ?></td>
                        <td class="p-3 text-sm"><?php echo e($p->kelas_petugas); ?></td>
                        
                        <!-- Tambahan Kolom Tampilan Jenis Kelamin/Ambalan -->
                        <td class="p-3 text-sm">
                            <span class="px-2 py-1 text-xs rounded font-bold <?php echo e($p->jenis_kelamin == 'L' ? 'bg-emerald-100 text-emerald-700' : ($p->jenis_kelamin == 'P' ? 'bg-pink-100 text-pink-700' : 'bg-gray-100 text-gray-600')); ?>">
                                <?php echo e($p->jenis_kelamin == 'L' ? 'Laki-laki (PA)' : ($p->jenis_kelamin == 'P' ? 'Perempuan (PI)' : 'Belum diatur')); ?>

                            </span>
                        </td>

                        <td class="p-3 text-sm"><?php echo e($p->jumlah_rekam); ?> kali</td>
                        <td class="p-3">
                            <span class="px-2 py-1 text-xs rounded font-bold <?php echo e($p->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'); ?>">
                                <?php echo e($p->is_active ? 'Aktif' : 'Non-Aktif'); ?>

                            </span>
                        </td>
                        <td class="p-3">
                            <form action="<?php echo e(route('admin.petugas.toggle', $p->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="text-xs px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded font-semibold">
                                    <?php echo e($p->is_active ? 'Nonaktifkan' : 'Aktifkan'); ?>

                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views\admin\petugas\index.blade.php ENDPATH**/ ?>