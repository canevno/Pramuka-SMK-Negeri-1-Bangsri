<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Scoutmind — Admin Login</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="bg-neutral-950 text-neutral-100 font-sans antialiased min-h-screen selection:bg-purple-500/30 selection:text-purple-200">

    <div class="min-h-screen w-full flex flex-col lg:grid lg:grid-cols-12 lg:h-screen lg:overflow-hidden">

        <!-- SISI KIRI: Polos & Kosong -->
        <div class="hidden lg:block lg:col-span-7 bg-neutral-950 border-r border-neutral-800/80"></div>

        <!-- SISI KANAN: Form Login -->
        <div class="lg:col-span-5 p-6 sm:p-10 lg:p-12 flex flex-col justify-center bg-neutral-950 min-h-screen lg:min-h-0" 
             x-data="{ 
                 showPassword: false, 
                 selectedRole: '<?php echo e(old('role', '')); ?>', 
                 isSubmitting: false
             }">
            
            <div class="max-w-sm w-full mx-auto space-y-8">
                
                <!-- Logo Header -->
                <div class="flex items-center gap-2.5">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-neutral-900 border border-neutral-800 text-white font-bold text-sm">
                        <img src="<?php echo e(asset('images/logo.png')); ?>" 
                             alt="Logo Scoutmind" 
                             class="h-5 w-5 object-contain" 
                             onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');">
                        <svg class="hidden w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-semibold tracking-wider text-neutral-200 uppercase">Scoutmind</span>
                </div>

                <!-- Form Header -->
                <div>
                    <h1 class="text-xl font-bold tracking-tight text-white">Log In</h1>
                    <p class="text-xs text-neutral-400 mt-1">Masuk ke sistem administrator Scoutmind.</p>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                    <div class="rounded-xl bg-rose-500/10 border border-rose-500/20 px-3.5 py-2.5 text-xs text-rose-400">
                        <?php echo e($errors->first()); ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <!-- (Google login removed) -->

                <!-- Form Login Manual -->
                <form method="POST" action="<?php echo e(url('/admin/login')); ?>" @submit="isSubmitting = true" class="space-y-4">
                    <?php echo csrf_field(); ?>

                    <!-- Role Dropdown -->
                    <div>
                        <label class="block text-[11px] font-medium text-neutral-300 mb-1.5">Role / Jabatan</label>
                        <div class="relative">
                            <select name="role" x-model="selectedRole" required 
                                class="w-full rounded-xl bg-neutral-900 border border-neutral-800 px-3.5 py-2.5 text-xs text-neutral-200 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition appearance-none cursor-pointer">
                                <option value="" disabled class="text-neutral-500">Pilih Role</option>
                                <option value="super_admin" class="bg-neutral-900 text-neutral-200">Super Admin</option>
                                <option value="pembina" class="bg-neutral-900 text-neutral-200">Pembina</option>
                                <option value="dewan_ambalan" class="bg-neutral-900 text-neutral-200">Dewan Ambalan</option>
                                <option value="bendahara" class="bg-neutral-900 text-neutral-200">Bendahara</option>
                            </select>
                            <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-neutral-500">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Input Email -->
                    <div>
                        <label class="block text-[11px] font-medium text-neutral-300 mb-1.5">Email</label>
                        <input type="email" name="email" value="<?php echo e(old('email')); ?>" required 
                            class="w-full rounded-xl bg-neutral-900 border border-neutral-800 px-3.5 py-2.5 text-xs text-neutral-200 placeholder-neutral-600 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition" 
                            placeholder="Masukkan email" />
                    </div>

                    <!-- Input Password -->
                    <div>
                        <label class="block text-[11px] font-medium text-neutral-300 mb-1.5">Password</label>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" name="password" required 
                                class="w-full rounded-xl bg-neutral-900 border border-neutral-800 px-3.5 py-2.5 text-xs text-neutral-200 placeholder-neutral-600 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition pr-9" 
                                placeholder="••••••••" />
                            
                            <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-neutral-500 hover:text-neutral-300 transition">
                                <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="showPassword" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.02 10.02 0 013.982-.863c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21M3 3l18 18"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            :disabled="isSubmitting"
                            class="w-full rounded-xl bg-white py-2.5 text-xs font-semibold text-neutral-950 hover:bg-neutral-200 transition duration-200 active:scale-[0.98] shadow-sm !mt-6 flex items-center justify-center gap-2 cursor-pointer disabled:opacity-60">
                        <span x-show="!isSubmitting">Log In</span>
                        <span x-show="isSubmitting" x-cloak class="flex items-center gap-2">
                            <svg class="animate-spin h-3.5 w-3.5 text-neutral-950" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Memproses...
                        </span>
                    </button>
                </form>

            </div>

        </div>

    </div>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</body>
</html><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/admin/login.blade.php ENDPATH**/ ?>