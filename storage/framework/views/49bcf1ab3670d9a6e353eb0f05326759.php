
 

<?php $__env->startSection('content'); ?> 

<div class="p-6">
    <!-- Alert Notifikasi Sukses -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg border border-green-200" role="alert">
            <span class="font-medium">Berhasil!</span> <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-lg font-bold text-gray-900">Daftar Pendaftar Bantara</h3>
            <p class="text-sm text-gray-500">Kelola dan verifikasi berkas calon pendaftar Bantara.</p>
        </div>
    </div>

    <!-- Tabel Data Pendaftar -->
    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                <tr>
                    <th scope="col" class="py-3 px-4">No</th>
                    <th scope="col" class="py-3 px-4">Nama Lengkap</th>
                    <th scope="col" class="py-3 px-4">Kelas</th>
                    <th scope="col" class="py-3 px-4">WhatsApp</th>
                    <th scope="col" class="py-3 px-4">Surat Izin</th>
                    <th scope="col" class="py-3 px-4">Status</th>
                    <th scope="col" class="py-3 px-4 text-center">Aksi Status</th>
                    <th scope="col" class="py-3 px-4 text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $registrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="py-4 px-4 font-medium text-gray-900">
                            <?php echo e($registrations->firstItem() + $index); ?>

                        </td>
                        <td class="py-4 px-4 font-semibold text-gray-900">
                            <?php echo e($item->nama); ?>

                            <div class="text-xs text-gray-400 font-normal">
                                <?php echo e($item->tempat_tanggal_lahir); ?>

                            </div>
                        </td>
                        <td class="py-4 px-4"><?php echo e($item->kelas); ?></td>
                        <td class="py-4 px-4">
                            <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $item->whatsapp)); ?>" target="_blank" class="text-blue-600 hover:underline">
                                <?php echo e($item->whatsapp); ?>

                            </a>
                        </td>
                        <td class="py-4 px-4">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->surat_izin_path): ?>
                                <a href="<?php echo e(asset('storage/' . $item->surat_izin_path)); ?>" target="_blank" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-blue-700 bg-blue-100 rounded hover:bg-blue-200">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Berkas
                                </a>
                            <?php else: ?>
                                <span class="text-xs text-gray-400">Tidak ada berkas</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td class="py-4 px-4">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->status === 'approved'): ?>
                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-green-200">Disetujui</span>
                            <?php elseif($item->status === 'rejected'): ?>
                                <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-red-200">Ditolak</span>
                            <?php else: ?>
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-yellow-200">Pending</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <form action="<?php echo e(route('admin.pendaftaran.update-status', $item->id)); ?>" method="POST" class="inline-flex items-center space-x-1">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <select name="status" onchange="this.form.submit()" class="text-xs rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 py-1 px-2">
                                    <option value="pending" <?php echo e($item->status === 'pending' ? 'selected' : ''); ?>>Pending</option>
                                    <option value="approved" <?php echo e($item->status === 'approved' ? 'selected' : ''); ?>>Setujui</option>
                                    <option value="rejected" <?php echo e($item->status === 'rejected' ? 'selected' : ''); ?>>Tolak</option>
                                </select>
                            </form>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <form action="<?php echo e(route('admin.pendaftaran.destroy', $item->id)); ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pendaftaran ini?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 hover:text-red-900 font-semibold text-xs bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded transition">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="8" class="py-6 px-4 text-center text-gray-500">
                            Belum ada data pendaftaran Bantara.
                        </td>
                    </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        <?php echo e($registrations->links()); ?>

    </div>
</div>


<?php $__env->stopSection(); ?> 
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/admin/pendaftaran/index.blade.php ENDPATH**/ ?>