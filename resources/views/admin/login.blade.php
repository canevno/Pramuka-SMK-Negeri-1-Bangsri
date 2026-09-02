<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Scoutmind — Admin Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="bg-neutral-950 text-neutral-100 font-sans antialiased min-h-screen selection:bg-purple-500/30 selection:text-purple-200">

    <div class="min-h-screen w-full flex items-center justify-center bg-gray-100 px-6 py-12">
        <div x-data="{ showPassword:false, isSubmitting:false }" class="max-w-sm w-full">
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-black">
                <div class="flex flex-col items-center gap-3">
                    <div class="w-20 h-20 rounded-lg bg-transparent flex items-center justify-center">
                        <img src="{{ asset('images/logos/smklogo.png') }}" alt="SMK Logo" class="h-16 w-16 object-contain" onerror="this.style.display='none'">
                    </div>
                    <h2 class="text-lg font-semibold text-gray-900">Masuk untuk melanjutkan</h2>
                    <p class="text-xs text-gray-500">Selamat Datang Ke Dashboard Admin Pramuka ESKASABA</p>
                </div>

                @if($errors->any())
                    <div class="mt-4 rounded-md bg-red-50 border border-red-100 px-3 py-2 text-sm text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.submit') }}" @submit="isSubmitting = true" class="mt-6 space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-lg bg-white border border-black px-3 py-2 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-indigo-500" placeholder="Email">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" name="password" required class="w-full rounded-lg bg-white border border-black px-3 py-2 text-sm text-gray-900 pr-10 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-indigo-500" placeholder="Password">
                            <button type="button" @click="showPassword = !showPassword" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="showPassword" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.02 10.02 0 013.982-.863c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21M3 3l18 18"/></svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" :disabled="isSubmitting" class="w-full bg-black text-white rounded-lg py-2 text-sm font-semibold">
                        <span x-show="!isSubmitting">Sign In</span>
                        <span x-show="isSubmitting" x-cloak>Processing...</span>
                    </button>
                </form>

                
            </div>
        </div>
    </div>

    @livewireScripts
</body>
</html>