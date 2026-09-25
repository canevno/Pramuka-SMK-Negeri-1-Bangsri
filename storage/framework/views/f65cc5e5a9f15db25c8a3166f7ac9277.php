<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="h-full bg-gray-50 dark:bg-black">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    
    <title><?php echo $__env->yieldContent('title', $title ?? 'Dashboard Admin'); ?> - Scoutmind</title>

    <script>
        (function () {
            function getStoredTheme() {
                try {
                    const savedTheme = localStorage.getItem('theme') || localStorage.getItem('color-theme');
                    if (savedTheme === 'dark' || savedTheme === 'light') {
                        return savedTheme;
                    }
                } catch (e) {}

                return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }

            function applyTheme(theme) {
                const root = document.documentElement;
                const isDark = theme === 'dark';
                root.classList.toggle('dark', isDark);
                root.style.colorScheme = isDark ? 'dark' : 'light';
                try {
                    localStorage.setItem('theme', theme);
                    localStorage.setItem('color-theme', theme);
                } catch (e) {}
            }

            applyTheme(getStoredTheme());

            document.addEventListener('livewire:navigated', function () {
                applyTheme(getStoredTheme());
            });
        })();
    </script>
    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>


    <style>
        /* Hide scrollbar di sidebar tapi tetap bisa scroll */
        .nav-scrollable {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        .nav-scrollable::-webkit-scrollbar {
            display: none;
        }
        
        /* Custom scrollbar untuk dropdown */
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #374151; border-radius: 10px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #1f2937; }
        
        /* Theme switching should feel instant; avoid global transitions across every element. */
        html, body,
        #admin-shell,
        aside,
        header,
        nav,
        main,
        section,
        button,
        a,
        input,
        select,
        textarea {
            transition: background-color 0ms linear, border-color 0ms linear, color 0ms linear, box-shadow 0ms linear !important;
        }

        /* Sticky sidebar */
        .sidebar-sticky {
            position: sticky;
            top: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .nav-scrollable {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar-fixed-header,
        .sidebar-fixed-footer {
            flex-shrink: 0;
        }

        /* Professional Fixed Navbar */
        .navbar-sticky {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(229, 231, 235, 0.6);
        }

        @media (min-width: 1024px) {
            .navbar-sticky {
                left: 15rem;
                width: calc(100% - 15rem);
            }
        }

        .dark .navbar-sticky {
            border-bottom: 1px solid rgba(31, 41, 55, 0.6);
        }

        /* Theme toggle active state */
        .theme-btn-active {
            background-color: white !important;
            color: #111827 !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .dark .theme-btn-active {
            background-color: #1f2937 !important;
            color: #f9fafb !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.3);
        }

        html.dark,
        .dark body,
        .dark #admin-shell {
            background-color: #0b1120 !important;
            color: #e5e7eb !important;
        }

        .dark .bg-white,
        .dark .bg-white\/90,
        .dark .bg-slate-50,
        .dark .bg-gray-50,
        .dark .bg-gray-100,
        .dark [class*="bg-white"],
        .dark [class*="bg-slate-50"],
        .dark [class*="bg-gray-50"],
        .dark [class*="bg-gray-100"] {
            background-color: #111827 !important;
        }

        .dark .border-gray-200,
        .dark .border-slate-200,
        .dark .dark\:border-gray-800,
        .dark .dark\:border-slate-800,
        .dark [class*="border-gray-200"],
        .dark [class*="border-slate-200"] {
            border-color: rgba(148, 163, 184, 0.2) !important;
        }

        .dark .text-gray-900,
        .dark .text-slate-900,
        .dark [class*="text-gray-900"],
        .dark [class*="text-slate-900"] {
            color: #f8fafc !important;
        }

        .dark .text-gray-700,
        .dark .text-slate-700,
        .dark [class*="text-gray-700"],
        .dark [class*="text-slate-700"] {
            color: #d1d5db !important;
        }

        /* Remove blue admin focus highlight */
        :focus,
        :focus-visible {
            outline: none !important;
            box-shadow: none !important;
        }

        input:focus,
        select:focus,
        textarea:focus,
        button:focus,
        a:focus,
        [role="button"]:focus,
        [tabindex]:focus {
            outline: none !important;
            box-shadow: none !important;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: rgba(148, 163, 184, 0.9) !important;
        }

        .dark input:focus,
        .dark select:focus,
        .dark textarea:focus {
            border-color: rgba(148, 163, 184, 0.75) !important;
        }

    </style>
</head>
<body id="admin-shell" class="h-full font-sans antialiased text-gray-800 dark:text-gray-200" x-data="{ fullscreen: false, mobileSidebarOpen: false }">

    <div class="min-h-full flex">

        <!-- Mobile Backdrop -->
        <div x-show="mobileSidebarOpen" x-cloak
             @click="mobileSidebarOpen = false"
             class="fixed inset-0 z-30 bg-slate-900/40 backdrop-blur-sm lg:hidden"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
        </div>

        <!-- ================= SIDEBAR ================= -->
        <aside class="hidden lg:flex lg:flex-shrink-0">
            <div class="sidebar-sticky w-60 border-r border-gray-200 dark:border-gray-800 bg-white dark:bg-[#0a0a0a]">
                
                <div class="sidebar-fixed-header h-14 flex items-center px-5 border-b border-gray-200 dark:border-gray-800">
                    <div class="flex items-center space-x-2.5">
                        <img src="<?php echo e(asset('images/logos/smklogo.png')); ?>" alt="Logo SMK" class="h-8 w-8 object-contain rounded-md bg-white p-0.5 shadow-sm" />
                        <div>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">Scoutmind</p>
                            <p class="text-[10px] text-gray-500 dark:text-gray-500">Admin Panel</p>
                        </div>
                    </div>
                </div>

                <nav class="nav-scrollable custom-scrollbar px-3 py-4">
                    <?php
                        $menu = [
                            ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z'],
                            ['label' => 'Berita', 'route' => 'admin.news', 'icon' => 'M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5'],
                            ['label' => 'Hero', 'route' => 'admin.hero', 'icon' => 'M4.5 18.75V5.25A2.25 2.25 0 016.75 3h10.5a2.25 2.25 0 012.25 2.25v13.5m-15 0h15M7.5 7.5h9m-9 3h9m-9 3h6'],
                            ['label' => 'Timeline', 'route' => 'admin.timeline', 'icon' => 'M12 6v6l4 2m4-2a8 8 0 11-16 0 8 8 0 0116 0z'],
                            ['section' => 'Administrasi'],
                            ['label' => 'Absensi', 'route' => 'admin.absensi', 'icon' => 'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.25-2.142V5.25'],
                            ['label' => 'Petugas', 'route' => 'admin.petugas', 'icon' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z'],
                            ['label' => 'Pendaftaran Bantara', 'route' => 'admin.pendaftaran', 'icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z'],
                            ['label' => 'Pendaftaran Laksana', 'route' => 'admin.pendaftaran-laksana', 'icon' => 'M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0111.25 2.25h1.5c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C6.845 4.01 6 4.973 6 6.108V8.25m8.25-2.142V5.25'],
                            ['label' => 'Galeri', 'route' => 'admin.gallery', 'icon' => 'M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z'],
                            ['label' => 'Pembina', 'route' => 'admin.pembina', 'icon' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z'],
                            ['label' => 'Dewan Ambalan', 'route' => 'admin.dewan-ambalan', 'icon' => 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a6.002 6.002 0 00-.94 3.197M12 12.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z'],
                            ['label' => 'Anggota Dewan', 'route' => 'admin.anggota', 'icon' => 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a6.002 6.002 0 00-.94 3.197M12 12.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z'],
                            ['label' => 'Mitra', 'route' => 'admin.mitra', 'icon' => 'M5.25 6.75A2.25 2.25 0 017.5 4.5h9a2.25 2.25 0 012.25 2.25v10.5A2.25 2.25 0 0116.5 19.5h-9a2.25 2.25 0 01-2.25-2.25V6.75zm2.25 1.5h6.75m-6.75 3h9m-9 3h4.5'],
                            ['label' => 'Alumni', 'route' => 'admin.alumni', 'icon' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z'],
                            ['label' => 'Pengaturan', 'route' => 'admin.settings', 'icon' => 'M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 010 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 010-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.281z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
                        ];
                    ?>

                    <ul class="space-y-0.5">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($item['section'])): ?>
                                <li class="pt-4 pb-1.5">
                                    <p class="px-2.5 text-[10px] font-semibold text-gray-400 dark:text-gray-600 uppercase tracking-wider">
                                        <?php echo e($item['section']); ?>

                                    </p>
                                </li>
                            <?php else: ?>
                                <?php $active = request()->routeIs($item['route']); ?>
                                <li>
                                    <a href="<?php echo e(route($item['route'])); ?>" wire:navigate
                                       class="group flex items-center px-2.5 py-2 text-xs font-medium rounded-md transition-all duration-150 
                                       <?php echo e($active 
                                          ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/30 dark:text-emerald-300 shadow-sm' 
                                          : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-900 dark:hover:text-gray-200'); ?>">
                                        <svg class="mr-2.5 h-4 w-4 flex-shrink-0 <?php echo e($active ? 'text-emerald-700 dark:text-emerald-400' : 'text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300'); ?>" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="<?php echo e($item['icon']); ?>"/>
                                        </svg>
                                        <?php echo e($item['label']); ?>

                                    </a>
                                </li>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </ul>
                </nav>

                <div class="sidebar-fixed-footer border-t border-gray-200 dark:border-gray-800 px-3 py-3">
                    <div class="flex items-center space-x-2.5">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-600 to-green-700 flex items-center justify-center text-white text-xs font-bold shadow-sm">
                                A
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-gray-900 dark:text-white truncate">Administrator</p>
                            <p class="text-[10px] text-gray-500 dark:text-gray-500 truncate">Scoutmind Admin</p>
                        </div>
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="p-1.5 text-gray-400 hover:text-red-500 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/20 rounded-md transition-colors" title="Logout">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <!-- ================= MAIN CONTENT ================= -->
        <div class="flex flex-col flex-1 min-w-0 overflow-hidden">
            
            <!-- Professional Sticky Navbar -->
            <header class="navbar-sticky h-16 flex items-center justify-between px-4 sm:px-6 bg-white/90 dark:bg-[#0a0a0a]/90">
                
                <!-- Left: Mobile menu + Breadcrumb -->
                <div class="flex items-center gap-3 flex-1 min-w-0">
                    <button type="button" class="lg:hidden inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-600 shadow-sm hover:bg-gray-100 dark:border-gray-800 dark:bg-gray-950 dark:text-gray-300 dark:hover:bg-gray-900"
                            @click="mobileSidebarOpen = !mobileSidebarOpen" aria-label="Buka menu admin">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <nav class="hidden md:flex items-center space-x-2 text-xs min-w-0">
                        <a href="<?php echo e(route('dashboard')); ?>" wire:navigate class="flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </a>
                        <svg class="w-3 h-3 text-gray-300 dark:text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="font-semibold text-gray-900 dark:text-white truncate">
                            <?php echo $__env->yieldContent('page-title', 'Dashboard'); ?>
                        </span>
                    </nav>

                    <span class="md:hidden text-sm font-semibold text-gray-900 truncate dark:text-white">
                        <?php echo $__env->yieldContent('page-title', 'Dashboard'); ?>
                    </span>
                </div>

                <!-- Right: Actions -->
                <div class="flex items-center gap-2 sm:gap-2.5">
                    
                    <!-- Theme Toggle -->
                    <div class="flex items-center bg-gray-100 dark:bg-gray-900 p-1 rounded-lg border border-gray-200 dark:border-gray-800">
                        <button id="theme-light" class="theme-btn px-2 py-1 text-[10px] font-semibold rounded-md transition-all">
                            <svg class="w-3 h-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </button>
                        <button id="theme-dark" class="theme-btn px-2 py-1 text-[10px] font-semibold rounded-md transition-all">
                            <svg class="w-3 h-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </button>
                    </div>

                    <!-- Fullscreen Toggle -->
                    <button @click="toggleFullscreen()" class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-900 transition-colors" title="Fullscreen">
                        <svg x-show="!fullscreen" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                        </svg>
                        <svg x-show="fullscreen" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 9V4.5M9 9H4.5M9 9L3.75 3.75M9 15v4.5M9 15H4.5M9 15l-5.25 5.25M15 9h4.5M15 9V4.5M15 9l5.25-5.25M15 15h4.5M15 15v4.5m0-4.5l5.25 5.25" />
                        </svg>
                    </button>

                    <!-- Notifications -->
                    <div class="relative z-50" x-data="{ open: false }" @click.away="open = false">
                        <button type="button" id="admin-notification-toggle" x-on:click.stop="open = !open" aria-expanded="false" :aria-expanded="open" aria-controls="admin-notification-panel" class="relative p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-900 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($unreadCount) && $unreadCount > 0): ?>
                                <span class="absolute top-1 right-1 w-1.5 h-1.5 bg-red-500 rounded-full ring-2 ring-white dark:ring-[#0a0a0a]"></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </button>

                        <div id="admin-notification-panel" x-show="open" x-cloak class="absolute right-0 mt-2 w-[min(17rem,calc(100vw-1rem))] max-w-[calc(100vw-1rem)] sm:w-80 bg-white dark:bg-[#0a0a0a] rounded-xl shadow-2xl border border-gray-200 dark:border-gray-800 z-50 overflow-hidden">
                            <div class="flex items-center justify-between border-b border-gray-100 px-3 py-2.5 dark:border-gray-800 sm:px-4 sm:py-3">
                                <h3 class="text-[10px] font-bold uppercase tracking-wider text-gray-900 dark:text-white sm:text-xs">Notifikasi</h3>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($unreadCount) && $unreadCount > 0): ?>
                                    <span class="text-[9px] font-semibold text-emerald-700 dark:text-emerald-400 sm:text-[10px]"><?php echo e($unreadCount); ?> Belum Dibaca</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div class="max-h-80 overflow-y-auto custom-scrollbar sm:max-h-96">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $unreadNotifications ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <a href="<?php echo e(route('admin.notifications.visit', $notif)); ?>" class="block border-b border-gray-100 px-3 py-2.5 transition hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-gray-900/50 last:border-0 sm:px-4 sm:py-3">
                                        <p class="text-[11px] font-semibold text-gray-900 dark:text-white sm:text-xs"><?php echo e($notif->title ?? 'Notifikasi'); ?></p>
                                        <p class="mt-1 line-clamp-2 text-[9.5px] text-gray-500 dark:text-gray-500 sm:text-[10px]"><?php echo e($notif->message ?? 'Tidak ada pesan'); ?></p>
                                        <p class="mt-1.5 text-[8.5px] text-gray-400 dark:text-gray-600 sm:text-[10px]"><?php echo e(isset($notif->created_at) ? $notif->created_at->diffForHumans() : 'Baru saja'); ?></p>
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="px-3 py-6 text-center sm:px-4 sm:py-8">
                                        <svg class="mx-auto h-7 w-7 text-gray-300 dark:text-gray-700 sm:h-8 sm:w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <p class="mt-2 text-[10px] font-medium text-gray-500 dark:text-gray-600 sm:text-xs">Tidak ada notifikasi</p>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div class="border-t border-gray-100 px-2 py-2 dark:border-gray-800 sm:px-3">
                                <a href="<?php echo e(route('admin.notifications.index')); ?>" class="block rounded-lg px-2.5 py-2 text-center text-[9px] font-semibold text-slate-700 transition hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-900 sm:px-3 sm:text-[10px]">
                                    Lihat semua notifikasi
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- User Profile Dropdown -->
                    <div class="relative z-50" x-data="{ open: false }" @click.away="open = false">
                        <?php
                            $adminUser = auth()->user();
                            $adminInitials = $adminUser?->initials() ?: 'A';
                            $adminAvatar = $adminUser?->profilePhotoUrl() ?: 'https://ui-avatars.com/api/?name=' . urlencode($adminUser?->name ?: 'Admin') . '&background=084d97&color=fff';
                        ?>
                        <button type="button" @click.stop="open = !open" :aria-expanded="open" class="flex items-center gap-2 pl-2 pr-1 py-1 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-900 transition-colors">
                            <div class="relative">
                                <img src="<?php echo e($adminAvatar); ?>" alt="<?php echo e($adminUser?->name ?? 'Admin'); ?>" class="h-8 w-8 rounded-full object-cover ring-2 ring-white dark:ring-[#0a0a0a] shadow-sm">
                                <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-600 border-2 border-white dark:border-[#0a0a0a] rounded-full"></span>
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-xs font-semibold text-gray-900 dark:text-white leading-tight"><?php echo e($adminUser?->name ?? 'Administrator'); ?></p>
                                <p class="text-[10px] text-gray-500 dark:text-gray-500 leading-tight"><?php echo e($adminUser?->jabatan ?? 'Super Admin'); ?></p>
                            </div>
                            <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="open" x-cloak class="absolute right-0 mt-2 w-[min(16rem,calc(100vw-1.5rem))] max-w-[calc(100vw-1.5rem)] sm:w-64 bg-white dark:bg-[#0a0a0a] rounded-xl shadow-2xl border border-gray-200 dark:border-gray-800 z-50 overflow-hidden">
                            <div class="p-4 border-b border-gray-100 dark:border-gray-800 bg-gradient-to-br from-emerald-50 to-green-50 dark:from-emerald-950/30 dark:to-green-950/20">
                                <div class="flex items-center gap-3">
                                    <img src="<?php echo e($adminAvatar); ?>" alt="<?php echo e($adminUser?->name ?? 'Admin'); ?>" class="h-10 w-10 rounded-full object-cover ring-2 ring-white dark:ring-[#0a0a0a] shadow-md">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-gray-900 dark:text-white truncate"><?php echo e($adminUser?->name ?? 'Administrator'); ?></p>
                                        <p class="text-[10px] text-gray-500 dark:text-gray-400 truncate"><?php echo e($adminUser?->email ?? 'admin@scoutmind.id'); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 space-y-1">
                                <a href="<?php echo e(route('admin.profile.edit')); ?>" wire:navigate class="flex items-center gap-2.5 px-2.5 py-2 text-xs text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900 rounded-lg transition-colors">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a7.5 7.5 0 0115 0"/></svg>
                                    Edit Profil
                                </a>
                                <a href="<?php echo e(route('admin.settings')); ?>" wire:navigate class="flex items-center gap-2.5 px-2.5 py-2 text-xs text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900 rounded-lg transition-colors">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    Pengaturan
                                </a>
                            </div>
                            <div class="border-t border-gray-200 dark:border-gray-800 p-2">
                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="w-full flex items-center gap-2.5 px-2.5 py-2 text-xs text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/20 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-4 pt-20 sm:p-6 sm:pt-20 dark:bg-black">
                <div class="mx-auto max-w-7xl">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($slot) && is_object($slot) && method_exists($slot, 'isNotEmpty') && $slot->isNotEmpty()): ?>
                        <?php echo e($slot); ?>

                    <?php else: ?>
                        <?php echo $__env->yieldContent('content'); ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </main>
        </div>

        <!-- Mobile Sidebar -->
        <aside x-show="mobileSidebarOpen" x-cloak
               x-transition:enter="transition ease-out duration-200"
               x-transition:enter-start="-translate-x-full opacity-0"
               x-transition:enter-end="translate-x-0 opacity-100"
               x-transition:leave="transition ease-in duration-150"
               x-transition:leave-start="translate-x-0 opacity-100"
               x-transition:leave-end="-translate-x-full opacity-0"
               class="fixed inset-y-0 left-0 z-40 w-72 max-w-[82vw] border-r border-gray-200 bg-white shadow-2xl dark:border-gray-800 dark:bg-[#0a0a0a] lg:hidden">
            <div class="flex h-16 items-center justify-between border-b border-gray-200 px-4 dark:border-gray-800">
                <div class="flex items-center space-x-2.5">
                    <img src="<?php echo e(asset('images/logos/smklogo.png')); ?>" alt="Logo SMK" class="h-8 w-8 object-contain rounded-md bg-white p-0.5 shadow-sm" />
                    <div>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">Scoutmind</p>
                        <p class="text-[10px] text-gray-500 dark:text-gray-500">Admin Panel</p>
                    </div>
                </div>
                <button type="button" @click="mobileSidebarOpen = false" class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:hover:bg-gray-900 dark:hover:text-gray-200">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="nav-scrollable custom-scrollbar px-3 py-4">
                <?php
                    $mobileMenu = [
                        ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z'],
                        ['label' => 'Berita', 'route' => 'admin.news', 'icon' => 'M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5'],
                        ['label' => 'Hero', 'route' => 'admin.hero', 'icon' => 'M4.5 18.75V5.25A2.25 2.25 0 016.75 3h10.5a2.25 2.25 0 012.25 2.25v13.5m-15 0h15M7.5 7.5h9m-9 3h9m-9 3h6'],
                        ['label' => 'Timeline', 'route' => 'admin.timeline', 'icon' => 'M12 6v6l4 2m4-2a8 8 0 11-16 0 8 8 0 0116 0z'],
                        ['section' => 'Administrasi'],
                        ['label' => 'Absensi', 'route' => 'admin.absensi', 'icon' => 'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.25-2.142V5.25'],
                        ['label' => 'Petugas', 'route' => 'admin.petugas', 'icon' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z'],
                        ['label' => 'Pendaftaran Bantara', 'route' => 'admin.pendaftaran', 'icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z'],
                        ['label' => 'Pendaftaran Laksana', 'route' => 'admin.pendaftaran-laksana', 'icon' => 'M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0111.25 2.25h1.5c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C6.845 4.01 6 4.973 6 6.108V8.25m8.25-2.142V5.25'],
                        ['label' => 'Galeri', 'route' => 'admin.gallery', 'icon' => 'M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z'],
                        ['label' => 'Pembina', 'route' => 'admin.pembina', 'icon' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z'],
                        ['label' => 'Dewan Ambalan', 'route' => 'admin.dewan-ambalan', 'icon' => 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a6.002 6.002 0 00-.94 3.197M12 12.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z'],
                        ['label' => 'Anggota Dewan', 'route' => 'admin.anggota', 'icon' => 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a6.002 6.002 0 00-.94 3.197M12 12.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z'],
                        ['label' => 'Mitra', 'route' => 'admin.mitra', 'icon' => 'M5.25 6.75A2.25 2.25 0 017.5 4.5h9a2.25 2.25 0 012.25 2.25v10.5A2.25 2.25 0 0116.5 19.5h-9a2.25 2.25 0 01-2.25-2.25V6.75zm2.25 1.5h6.75m-6.75 3h9m-9 3h4.5'],
                        ['label' => 'Alumni', 'route' => 'admin.alumni', 'icon' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z'],
                        ['label' => 'Pengaturan', 'route' => 'admin.settings', 'icon' => 'M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 010 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 010-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.281z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
                    ];
                ?>

                <ul class="space-y-0.5">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $mobileMenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($item['section'])): ?>
                            <li class="pt-4 pb-1.5">
                                <p class="px-2.5 text-[10px] font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-600">
                                    <?php echo e($item['section']); ?>

                                </p>
                            </li>
                        <?php else: ?>
                            <?php $active = request()->routeIs($item['route']); ?>
                            <li>
                                <a href="<?php echo e(route($item['route'])); ?>" wire:navigate @click="mobileSidebarOpen = false"
                                   class="group flex items-center rounded-md px-2.5 py-2 text-xs font-medium transition-all duration-150 <?php echo e($active ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/30 dark:text-emerald-300 shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-900 dark:hover:text-gray-200'); ?>">
                                    <svg class="mr-2.5 h-4 w-4 flex-shrink-0 <?php echo e($active ? 'text-emerald-700 dark:text-emerald-400' : 'text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300'); ?>" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="<?php echo e($item['icon']); ?>"/>
                                    </svg>
                                    <?php echo e($item['label']); ?>

                                </a>
                            </li>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </ul>
            </nav>

            <div class="border-t border-gray-200 px-3 py-3 dark:border-gray-800">
                <div class="flex items-center space-x-2.5 rounded-xl bg-gray-50 p-2.5 dark:bg-gray-950/60">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-br from-emerald-600 to-green-700 text-xs font-bold text-white shadow-sm">
                        A
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-xs font-semibold text-gray-900 dark:text-white">Administrator</p>
                        <p class="truncate text-[10px] text-gray-500 dark:text-gray-500">Super Admin</p>
                    </div>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="rounded-md p-1.5 text-gray-400 transition-colors hover:bg-red-50 hover:text-red-500 dark:hover:bg-red-950/20 dark:hover:text-red-400" title="Logout">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>
    </div>

    <!-- ================= TOAST ================= -->
    <div x-data="{ show: false, title: '', message: '' }" 
         x-on:show-toast.window="show = true; title = $event.detail.title; message = $event.detail.message; setTimeout(() => show = false, 5000)"
         x-show="show" 
         x-transition
         class="fixed bottom-5 right-5 z-50 w-full max-w-sm bg-white dark:bg-[#0a0a0a] rounded-xl shadow-2xl border border-gray-200 dark:border-gray-800 p-4 hidden">
        <div class="flex items-start space-x-3">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-950/30 flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-700 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            <div class="flex-1">
                <h3 class="text-xs font-semibold text-gray-900 dark:text-white" x-text="title"></h3>
                <p class="text-[10px] text-gray-500 dark:text-gray-500 mt-1" x-text="message"></p>
            </div>
            <button @click="show = false" class="text-[10px] text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 font-medium px-2 py-1 rounded hover:bg-gray-100 dark:hover:bg-gray-900">Tutup</button>
        </div>
    </div>

    <?php echo $__env->yieldPushContent('modals'); ?>

    <script>
        // Theme Switcher
        const themeLight = document.getElementById('theme-light');
        const themeDark = document.getElementById('theme-dark');

        function updateThemeButtons() {
            if (!themeLight || !themeDark) {
                return;
            }

            const isDark = document.documentElement.classList.contains('dark');
            if (isDark) {
                themeDark.classList.add('theme-btn-active');
                themeLight.classList.remove('theme-btn-active');
            } else {
                themeLight.classList.add('theme-btn-active');
                themeDark.classList.remove('theme-btn-active');
            }
        }

        function applyStoredAdminTheme() {
            try {
                const storedTheme = localStorage.getItem('theme') || localStorage.getItem('color-theme');
                const isDark = storedTheme === 'dark' || (!storedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches);
                document.documentElement.classList.toggle('dark', isDark);
                document.documentElement.style.colorScheme = isDark ? 'dark' : 'light';
            } catch (e) {
                document.documentElement.classList.remove('dark');
                document.documentElement.style.colorScheme = 'light';
            }
            updateThemeButtons();
        }

        applyStoredAdminTheme();

        if (themeLight) {
            themeLight.addEventListener('click', function() {
                document.documentElement.classList.remove('dark');
                document.documentElement.style.colorScheme = 'light';
                localStorage.setItem('theme', 'light');
                localStorage.setItem('color-theme', 'light');
                updateThemeButtons();
            });
        }

        if (themeDark) {
            themeDark.addEventListener('click', function() {
                document.documentElement.classList.add('dark');
                document.documentElement.style.colorScheme = 'dark';
                localStorage.setItem('theme', 'dark');
                localStorage.setItem('color-theme', 'dark');
                updateThemeButtons();
            });
        }

        document.addEventListener('livewire:navigated', function () {
            applyStoredAdminTheme();
        });

        // Fullscreen Toggle
        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch(() => {});
            } else {
                document.exitFullscreen().catch(() => {});
            }
        }

        document.addEventListener('fullscreenchange', () => {
            const adminShell = document.getElementById('admin-shell');
            if (adminShell && adminShell.__x) {
                adminShell.__x.$data.fullscreen = !!document.fullscreenElement;
            }
        });

        setInterval(() => {
            const path = window.location.pathname;
            if (!path.startsWith('/admin')) {
                return;
            }

            fetch('/admin/notifications', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then((response) => response.ok ? response.text() : null)
                .catch(() => null);
        }, 30000);

    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views\admin\layouts\app.blade.php ENDPATH**/ ?>