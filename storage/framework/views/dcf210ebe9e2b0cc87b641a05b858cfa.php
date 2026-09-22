<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pramuka SMK Negeri 1 Bangsri</title>
    <link rel="icon" href="/images/logos/smklogo.png" type="image/png" sizes="32x32">
    <link rel="apple-touch-icon" href="/images/logos/smklogo.png">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" media="print" onload="this.media='all'">

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    <style>
        [x-cloak] { display: none !important; }
        html { background: #ffffff; }
        body {
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.12s ease, visibility 0.12s ease;
        }
        body.ready {
            opacity: 1;
            visibility: visible;
        }
    </style>
</head>
<body class="min-h-screen overflow-x-hidden bg-white dark:bg-gray-950 text-gray-900 dark:text-gray-100">

    <?php echo $__env->make('components.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <?php echo $__env->make('components.back-to-top', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('components.mobile-bottom-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->yieldPushContent('scripts'); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const reveal = () => document.body.classList.add('ready');
            if (document.readyState === 'complete') {
                reveal();
            } else {
                window.addEventListener('load', reveal, { once: true });
            }
            setTimeout(reveal, 80);
        });
    </script>
</body>
</html><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/layouts/frontend.blade.php ENDPATH**/ ?>