<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Scoutmind — Admin Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    <style>
        [x-cloak]{ display:none !important; }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f2f2f5;
            background-image:
                linear-gradient(rgba(120, 130, 145, 0.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(120, 130, 145, 0.08) 1px, transparent 1px),
                radial-gradient(circle, rgba(135, 135, 150, 0.12) 1px, transparent 1px);
            background-size: 36px 36px, 36px 36px, 12px 12px;
            background-position: center center, center center, 0 0;
        }
    </style>
</head>
<body class="antialiased min-h-screen overflow-hidden selection:bg-amber-200 selection:text-slate-900">
    <div class="min-h-screen flex items-center justify-center px-3 py-2" x-data="{
        showPassword: false,
        selectedRole: '<?php echo e(old('role', '')); ?>',
        isSubmitting: false
    }">
        <div class="w-full max-w-[390px] rounded-[26px] bg-white/90 shadow-[0_18px_50px_rgba(15,23,42,0.08)] border border-slate-200/80 px-6 py-4 sm:px-7 sm:py-5 backdrop-blur-sm">
            <div class="mx-auto flex w-full max-w-[220px] flex-col items-center text-center">
                <div class="mb-2 flex items-center justify-center gap-2.5">
                    <img src="<?php echo e(asset('images/logos/aflogo.png')); ?>" alt="AF Logo" class="h-10 w-10 object-contain">
                    <img src="<?php echo e(asset('images/logos/dslogo.png')); ?>" alt="DS Logo" class="h-10 w-10 object-contain">
                </div>
            </div>

            <div class="mt-4 text-center">
                <h1 class="text-[1.65rem] font-semibold tracking-[-0.06em] text-slate-900 leading-tight">Selamat Datang</h1>
                <p class="mt-1.5 text-xs leading-5 text-slate-600 font-normal">
                    Akses dashboard admin pangkalan SMKN 1 Bangsri SCOUTMIND
                </p>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                <div class="mt-4 rounded-2xl border border-rose-200 bg-rose-50 px-3.5 py-2.5 text-xs text-rose-600">
                    <?php echo e($errors->first()); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <form method="POST" action="<?php echo e(url('/admin/login')); ?>" @submit="isSubmitting = true" class="mt-5 space-y-3">
                <?php echo csrf_field(); ?>

                <div>
                    <label class="mb-1.5 block text-[12px] font-medium text-slate-700">Email</label>
                    <input type="email" name="email" value="<?php echo e(old('email')); ?>" required
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200 transition"
                        placeholder="Enter Your Email" />
                </div>

                <div>
                    <label class="mb-1.5 block text-[12px] font-medium text-slate-700">Passwords</label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" name="password" required
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 pr-10 text-sm text-slate-800 placeholder:text-slate-400 focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200 transition"
                            placeholder="Enter Your Passwords" />

                        <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-3 flex items-center text-slate-400 transition hover:text-slate-600" aria-label="Toggle password visibility">
                            <svg x-show="!showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg x-show="showPassword" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                <path d="M3 3l18 18"/>
                                <path d="M10.58 10.58A2 2 0 0 0 13.42 13.42"/>
                                <path d="M9.88 5.08A9.94 9.94 0 0 1 12 5c6.5 0 10 7 10 7a17.78 17.78 0 0 1-4.75 5.73M6.61 6.61A17.96 17.96 0 0 0 2 12s3.5 7 10 7c2.03 0 3.82-.56 5.39-1.61"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" :disabled="isSubmitting"
                    class="mt-1 flex w-full items-center justify-center rounded-full bg-[#0D1B2A] py-3 text-sm font-semibold text-white transition hover:bg-slate-800 disabled:opacity-70">
                    <span x-show="!isSubmitting">Login</span>
                    <span x-show="isSubmitting" x-cloak class="flex items-center gap-2">
                        <svg class="h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.37 0 0 5.37 0 12h4zm2.93 7.07A8 8 0 014 12H0c0 3.04 1.22 5.8 3.17 7.78l3.76-2.71z"></path>
                        </svg>
                        Processing...
                    </span>
                </button>
            </form>

        </div>
    </div>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</body>
</html>
<?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/admin/login.blade.php ENDPATH**/ ?>