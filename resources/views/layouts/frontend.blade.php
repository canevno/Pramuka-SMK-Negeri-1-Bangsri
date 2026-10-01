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

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
    <style>
        [x-cloak] { display: none !important; }
        html { background: #ffffff; }
        body {
            background: #ffffff !important;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.12s ease, visibility 0.12s ease;
        }
        body.ready {
            opacity: 1;
            visibility: visible;
        }

        main,
        main > div,
        main > section,
        section,
        .bg-slate-50,
        .bg-slate-100,
        .bg-gray-50,
        .bg-gray-100 {
            background-color: #ffffff !important;
        }
    </style>
</head>
<body class="min-h-screen overflow-x-hidden bg-white dark:bg-gray-950 text-gray-900 dark:text-gray-100">

    @include('components.navbar')

    <main>
        @hasSection('content')
            @yield('content')
        @else
            {{-- Support component-style usage: render slot when used as <x-layouts.frontend> --}}
            @if (isset($slot))
                {{ $slot }}
            @endif
        @endif
    </main>

    @include('components.back-to-top')
    @include('components.footer')
    @include('components.mobile-bottom-nav')

    @stack('scripts')
    @livewireScripts
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
</html>