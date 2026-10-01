

<?php $__env->startSection('title', 'Surat Pendaftaran ' . ($registration->nama ?? '')); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-lg font-semibold mb-4">Surat Pendaftaran <?php echo e($registration->nama); ?></h1>
        <div class="border rounded-lg overflow-hidden">
            <iframe src="<?php echo e($fileUrl); ?>" class="w-full h-[80vh]" frameborder="0"></iframe>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views\admin\pendaftaran\surat.blade.php ENDPATH**/ ?>