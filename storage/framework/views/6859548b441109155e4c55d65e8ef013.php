<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="h-full bg-slate-50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo $__env->yieldContent('title', 'Autentikasi'); ?></title>

        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    </head>
    <body class="min-h-full bg-slate-50 text-slate-900 antialiased">
        <main class="min-h-screen">
            <?php echo e($slot); ?>

        </main>
    </body>
</html>
<?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views\layouts\auth.blade.php ENDPATH**/ ?>