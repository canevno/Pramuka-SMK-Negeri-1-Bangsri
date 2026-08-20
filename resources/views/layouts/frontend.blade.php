<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pramuka SMK Negeri 1 Bangsri</title>
    <link rel="icon" href="/images/logos/smklogo.png" type="image/png" sizes="32x32">
    <link rel="apple-touch-icon" href="/images/logos/smklogo.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="min-h-screen overflow-x-hidden bg-white dark:bg-gray-950 text-gray-900 dark:text-gray-100">

    @include('components.navbar')

    <main>
        @yield('content')
    </main>

    @include('components.footer')

    @stack('scripts')
    @livewireScripts
</body>
</html>