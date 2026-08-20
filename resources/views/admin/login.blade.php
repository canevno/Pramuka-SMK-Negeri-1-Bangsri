<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - Scoutmind</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>[x-cloak]{display:none!important}</style>
</head>
<body class="min-h-screen bg-slate-950 text-white">
    <div class="flex min-h-screen items-center justify-center px-4 py-12">
        <div class="w-full max-w-md rounded-3xl border border-white/10 bg-slate-900/90 p-8 shadow-2xl shadow-black/20 backdrop-blur-sm">
            <div class="mb-8 text-center">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-white text-slate-950">
                    <svg viewBox="0 0 24 24" class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 7v4a4 4 0 0 0 4 4h2"></path>
                        <path d="M17 17h2a4 4 0 0 0 4-4V7"></path>
                        <path d="M9 7V4a3 3 0 0 1 3-3h0a3 3 0 0 1 3 3v3"></path>
                        <path d="M8 12h8"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-semibold">Log in to your account</h1>
                <p class="mt-2 text-sm text-slate-400">Enter your email and password below to log in.</p>
            </div>

            @if($errors->any())
                <div class="mb-4 rounded-xl bg-red-600/10 px-4 py-3 text-sm text-red-200">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ url('/admin/login') }}">
                @csrf
                <div class="space-y-5">
                    <label class="block text-sm font-medium text-slate-300">
                        Email address
                        <input type="email" name="email" required class="mt-2 w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-white outline-none focus:border-white/50 focus:ring-2 focus:ring-white/10" placeholder="email@example.com" />
                    </label>
                    <label class="block text-sm font-medium text-slate-300">
                        Password
                        <input type="password" name="password" required class="mt-2 w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-white outline-none focus:border-white/50 focus:ring-2 focus:ring-white/10" placeholder="Password" />
                    </label>
                    <button class="w-full rounded-2xl bg-white py-3 text-sm font-semibold text-slate-950 transition hover:bg-slate-100">Log in</button>
                </div>
            </form>
        </div>
    </div>
    @livewireScripts
</body>
</html>
