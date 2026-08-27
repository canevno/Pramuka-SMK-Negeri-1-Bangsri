<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', $title ?? 'Dashboard Admin') - Scoutmind</title>
    
    <!-- Script Anti-FOUC -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Google Font: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        [x-cloak] { display: none !important; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        /* Custom Scrollbar Premium */
        .custom-scrollbar { scrollbar-width: thin; scrollbar-color: rgba(148, 163, 184, 0.3) transparent; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; height: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(148, 163, 184, 0.3); border-radius: 999px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(148, 163, 184, 0.5); }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(71, 85, 105, 0.5); }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(71, 85, 105, 0.8); }
        /* Hide scrollbar visuals across admin while keeping scrolling functional */
        /* Targets only elements using the .custom-scrollbar utility to avoid global side-effects */
        .custom-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .custom-scrollbar::-webkit-scrollbar { display: none; }
        /* Utility to hide scrollbar visuals for specific containers (keeps scrolling) */
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        #notif-detail-modal,
        #notif-detail-modal > div,
        #pendaftaran-detail-backdrop,
        #pendaftaran-detail-card,
        #pendaftaran-detail-backdrop > div {
            z-index: 2147483647 !important;
        }
    </style>
</head>

<body 
    x-data="{ 
        theme: localStorage.getItem('theme') || 'light',
        sidebarOpen: false,
        setTheme(val) {
            this.theme = val;
            localStorage.setItem('theme', val);
            if (val === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
    }"
    class="h-screen bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100 antialiased selection:bg-indigo-500/30 selection:text-indigo-900 dark:selection:bg-indigo-500/30 dark:selection:text-indigo-100 transition-colors duration-200"
>
    <div class="flex h-screen overflow-hidden">
        
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity 
             class="fixed inset-0 z-30 bg-slate-950/50 backdrop-blur-sm md:hidden" x-cloak></div>

        <!-- SIDEBAR -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
               class="fixed inset-y-0 left-0 z-40 flex h-full w-64 flex-col border-r border-slate-200 bg-white transition-transform duration-300 ease-in-out md:relative md:translate-x-0 dark:border-slate-800 dark:bg-slate-900">
            
            <div class="flex flex-col h-full">
                <!-- Header Admin Profile -->
                <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-100 dark:border-slate-800">
                    <div class="relative">
                        <img src="{{ asset('images/logos/smklogo.png') }}" alt="Logo" class="h-9 w-9 rounded-lg object-cover ring-2 ring-slate-100 dark:ring-slate-800" />
                        <span class="absolute -bottom-0.5 -right-0.5 h-3 w-3 rounded-full bg-emerald-500 ring-2 ring-white dark:ring-slate-900"></span>
                    </div>
                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-slate-900 dark:text-slate-100">Administrator</p>
                        <p class="truncate text-xs font-medium text-slate-500 dark:text-slate-400">Scoutmind Admin</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="ml-2">
                        @csrf
                        <button type="submit" class="rounded-lg px-3 py-2 text-sm text-slate-600 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800">Logout</button>
                    </form>
                </div>

                <!-- Navigation List -->
                <nav class="flex-1 space-y-1 overflow-y-auto custom-scrollbar px-3 py-4">
                    @php
                        $menu = [
                            ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z'],
                            ['label' => 'Berita', 'route' => 'admin.news', 'icon' => 'M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5'],
                            ['label' => 'Agenda', 'route' => 'admin.agenda', 'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5'],
                            ['section' => 'Administrasi'],
                            ['label' => 'Absensi', 'route' => 'admin.absensi', 'icon' => 'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.25-2.142V5.25'],
                            ['label' => 'Pendaftaran Bantara', 'route' => 'admin.pendaftaran', 'icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z'],
                            ['label' => 'Pendaftaran Laksana', 'route' => 'admin.pendaftaran-laksana', 'icon' => 'M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0111.25 2.25h1.5c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C6.845 4.01 6 4.973 6 6.108V8.25m8.25-2.142V5.25'],
                            ['label' => 'Galeri', 'route' => 'admin.gallery', 'icon' => 'M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z'],
                            ['label' => 'Prestasi', 'route' => 'admin.prestasi', 'icon' => 'M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.504-1.125-1.125-1.125h-6.75a1.125 1.125 0 00-1.125 1.125V18.75m9.75-14.25c0-.621-.504-1.125-1.125-1.125H8.25C7.629 3.375 7.125 3.879 7.125 4.5v3a5.25 5.25 0 0010.5 0v-3z'],
                            ['label' => 'Pembina', 'route' => 'admin.pembina', 'icon' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z'],
                            ['label' => 'Anggota', 'route' => 'admin.anggota', 'icon' => 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a6.002 6.002 0 00-.94 3.197M12 12.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z'],
                            // ['label' => 'Download', 'route' => 'admin.downloads', 'icon' => 'M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3'],
                            ['label' => 'Komentar', 'route' => 'admin.comments', 'icon' => 'M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z'],
                            ['label' => 'Pengguna', 'route' => 'admin.users', 'icon' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z'],
                            ['label' => 'Pengaturan', 'route' => 'admin.settings', 'icon' => 'M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 010 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 010-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.281z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
                        ];
                    @endphp

                    @foreach($menu as $item)
                        @if(isset($item['section']))
                            <div class="px-3 pt-6 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                {{ $item['section'] }}
                            </div>
                        @else
                            @php $active = request()->routeIs($item['route']); @endphp
                            <a href="{{ route($item['route']) }}" 
                               class="group relative flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-all duration-200 
                                      {{ $active 
                                          ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400' 
                                          : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-100' }}">
                                
                                @if($active)
                                    <div class="absolute left-0 top-1/2 h-6 w-1 -translate-y-1/2 rounded-r-full bg-indigo-600 dark:bg-indigo-500"></div>
                                @endif

                                <svg class="h-5 w-5 shrink-0 transition-colors {{ $active ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/>
                                </svg>
                                <span class="truncate">{{ $item['label'] }}</span>
                            </a>
                        @endif
                    @endforeach
                </nav>

                <!-- Theme Switcher -->
                <div class="border-t border-slate-100 p-4 dark:border-slate-800">
                    <div class="flex rounded-lg bg-slate-100 p-1 dark:bg-slate-800">
                        <button type="button" @click="setTheme('light')"
                                :class="theme === 'light' ? 'bg-white text-slate-900 shadow-sm dark:bg-slate-700 dark:text-slate-100' : 'text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200'"
                                class="flex-1 flex items-center justify-center gap-1.5 rounded-md py-1.5 text-xs font-semibold transition-all">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m0 13.5V21m8.966-8.966h-2.25M4.284 12H2.034m15.364 6.364l-1.591-1.591M6.759 6.759L5.168 5.168m12.728 0l-1.591 1.591M6.759 17.241l-1.591 1.591M12 18a6 6 0 100-12 6 6 0 000 12z"/></svg>
                            Light
                        </button>
                        <button type="button" @click="setTheme('dark')"
                                :class="theme === 'dark' ? 'bg-white text-slate-900 shadow-sm dark:bg-slate-700 dark:text-slate-100' : 'text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200'"
                                class="flex-1 flex items-center justify-center gap-1.5 rounded-md py-1.5 text-xs font-semibold transition-all">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"/></svg>
                            Dark
                        </button>
                    </div>
                </div>
            </div>
        </aside>

        <!-- KONTEN UTAMA -->
        <div class="flex flex-1 flex-col overflow-hidden">
            
            <!-- Header Bar -->
            <header class="flex h-16 items-center justify-between border-b border-slate-200 bg-white/80 px-4 backdrop-blur-xl dark:border-slate-800 dark:bg-slate-900/80 md:px-8">
                <div class="flex items-center gap-4">
                    <!-- Mobile Menu Toggle -->
                    <button @click="sidebarOpen = true" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800 md:hidden">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
                    </button>

                    <!-- Search Bar -->
                    <div class="relative hidden w-full max-w-sm md:block">
                        <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                        <input type="text" placeholder="Cari menu atau data..." class="w-full rounded-lg border border-slate-200 bg-slate-50 py-2 pl-9 pr-10 text-sm text-slate-900 placeholder-slate-400 transition-all focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:placeholder-slate-500 dark:focus:border-indigo-500 dark:focus:bg-slate-900" />
                        <kbd class="absolute right-2 top-1/2 -translate-y-1/2 rounded border border-slate-200 bg-white px-1.5 py-0.5 text-[10px] font-semibold text-slate-400 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-500">⌘K</kbd>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Notification Bell -->
                    <div class="relative z-[80]" x-data="{ openNotif: false }">
                        <button @click="openNotif = !openNotif" type="button" class="relative rounded-lg p-2 text-slate-500 transition-colors hover:bg-slate-100 hover:text-slate-700 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                            </svg>
                            <span id="notif-badge" class="absolute right-1.5 top-1.5 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[9px] font-bold text-white ring-2 ring-white dark:ring-slate-900" style="display: none;">
                                <span id="notif-badge-text"></span>
                            </span>
                        </button>

                        <!-- Notification Dropdown (Strict Dark Mode) -->
                        <div x-show="openNotif" @click.away="openNotif = false" x-transition 
                             class="absolute right-0 z-[90] mt-2 w-80 origin-top-right rounded-xl border border-slate-200 bg-white shadow-xl shadow-slate-950/5 dark:border-slate-800 dark:bg-slate-900 dark:shadow-slate-950/50" style="display: none;">
                            <div class="flex items-center justify-between border-b border-slate-100 px-4 py-3 dark:border-slate-800">
                                <h4 class="text-sm font-semibold text-slate-900 dark:text-slate-100">Notifikasi</h4>
                                @if(isset($unreadCount) && $unreadCount > 0)
                                    <form method="POST" action="{{ route('admin.notifications.readAll') }}">
                                        @csrf
                                        <button type="submit" class="text-xs font-medium text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300">Tandai Dibaca</button>
                                    </form>
                                @endif
                            </div>

                            <div id="notif-list" class="max-h-72 overflow-y-auto custom-scrollbar divide-y divide-slate-100 dark:divide-slate-800">
                                @forelse($unreadNotifications ?? [] as $notif)
                                    <div class="cursor-pointer px-4 py-3 transition-colors hover:bg-slate-50 dark:hover:bg-slate-800/50 {{ !$notif->is_read ? 'bg-indigo-50/50 dark:bg-indigo-500/5' : '' }}">
                                        <div class="flex items-start gap-3">
                                            <span class="mt-1.5 h-2 w-2 shrink-0 rounded-full {{ $notif->type === 'warning' ? 'bg-amber-500' : ($notif->type === 'success' ? 'bg-emerald-500' : 'bg-blue-500') }}"></span>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs font-semibold text-slate-900 dark:text-slate-100">{{ $notif->title }}</p>
                                                <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400 line-clamp-2">{{ $notif->message }}</p>
                                                <time class="notif-time mt-1.5 block text-[10px] font-medium text-slate-400 dark:text-slate-500" datetime="{{ $notif->created_at->toIso8601String() }}" data-time="{{ $notif->created_at->toIso8601String() }}">{{ $notif->created_at->diffForHumans() }}</time>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="flex flex-col items-center justify-center px-4 py-8 text-center">
                                        <svg class="h-8 w-8 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                                        <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">Tidak ada notifikasi baru.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto custom-scrollbar bg-slate-50 p-4 dark:bg-slate-950 md:p-8">
                @if(isset($slot) && $slot->isNotEmpty())
                    {{ $slot }}
                @else
                    @yield('content')
                @endif
            </main>
        </div>
    </div>

    <!-- Modal Detail Notifikasi (Strict Dark Mode) -->
    <div id="notif-detail-modal" class="fixed inset-0 hidden items-center justify-center bg-slate-950/60 p-4 backdrop-blur-sm" style="z-index: 2147483647 !important;">
        <div class="w-full max-w-md rounded-2xl border border-slate-200 bg-white p-6 shadow-2xl dark:border-slate-800 dark:bg-slate-900 dark:shadow-slate-950/50" style="z-index: 2147483647 !important;">
            <div class="flex items-start justify-between">
                <div class="pr-4">
                    <h3 id="notif-detail-title" class="text-base font-bold text-slate-900 dark:text-slate-100">Title</h3>
                    <time id="notif-detail-time" class="mt-1 block text-xs text-slate-500 dark:text-slate-400"></time>
                </div>
                <button type="button" onclick="closeNotifModal()" class="rounded-lg p-1 text-slate-400 transition-colors hover:bg-slate-100 hover:text-slate-600 dark:hover:bg-slate-800 dark:hover:text-slate-200">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="mt-4 text-sm leading-relaxed text-slate-600 dark:text-slate-300" id="notif-detail-message">Message</div>
            <div class="mt-6 flex justify-end">
                <button type="button" onclick="closeNotifModal()" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-all hover:bg-indigo-700 active:scale-95 dark:bg-indigo-600 dark:hover:bg-indigo-500">Tutup</button>
            </div>
        </div>
    </div>

    @stack('modals')

    <script>
        // [LOGIKA NOTIFIKASI ASLI ANDA DIPERTAHANKAN 100%]
        function updateNotifTimes() {
            document.querySelectorAll('.notif-time').forEach(function(el) {
                var timeStr = el.getAttribute('data-time') || el.getAttribute('datetime');
                if (!timeStr) return;
                var then = new Date(timeStr);
                var now = new Date();
                var diff = Math.floor((now - then) / 1000);

                var unit = 'second';
                var value = diff;
                if (diff >= 31536000) { value = Math.floor(diff / 31536000); unit = 'year'; }
                else if (diff >= 2592000) { value = Math.floor(diff / 2592000); unit = 'month'; }
                else if (diff >= 86400) { value = Math.floor(diff / 86400); unit = 'day'; }
                else if (diff >= 3600) { value = Math.floor(diff / 3600); unit = 'hour'; }
                else if (diff >= 60) { value = Math.floor(diff / 60); unit = 'minute'; }

                var text;
                if (value === 0 && unit === 'second') text = 'baru saja';
                else if (unit === 'year') text = value + ' tahun lalu';
                else if (unit === 'month') text = value + ' bulan lalu';
                else if (unit === 'day') text = value + ' hari lalu';
                else if (unit === 'hour') text = value + ' jam lalu';
                else if (unit === 'minute') text = value + ' menit lalu';
                else text = value + ' detik lalu';

                el.textContent = text;
            });
        }

        function pollNotifications() {
            fetch('{{ route('admin.notifications.fetch') }}', {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            }).then(function(res) {
                if (!res.ok) return;
                return res.json();
            }).then(function(data) {
                if (!data || !data.success) return;

                var count = data.unreadCount || 0;
                var badge = document.getElementById('notif-badge');
                var badgeText = document.getElementById('notif-badge-text');
                if (count > 0) {
                    badge.style.display = 'flex';
                    badgeText.textContent = count > 9 ? '9+' : count;
                } else {
                    badge.style.display = 'none';
                }

                var list = document.getElementById('notif-list');
                if (!list) return;
                var html = '';
                if (data.notifications && data.notifications.length > 0) {
                    data.notifications.forEach(function(n) {
                        var color = n.type === 'warning' ? 'bg-amber-500' : (n.type === 'success' ? 'bg-emerald-500' : 'bg-blue-500');
                        var time = new Date(n.created_at).toLocaleString();
                        html += '<div class="cursor-pointer px-4 py-3 transition-colors hover:bg-slate-50 dark:hover:bg-slate-800/50 ' + (n.is_read ? '' : 'bg-indigo-50/50 dark:bg-indigo-500/5') + '">'
                            + '<div class="flex items-start gap-3">'
                            + '<span class="mt-1.5 h-2 w-2 shrink-0 rounded-full ' + color + '"></span>'
                            + '<div class="flex-1 min-w-0">'
                            + '<p class="text-xs font-semibold text-slate-900 dark:text-slate-100">' + escapeHtml(n.title) + '</p>'
                            + '<p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400 line-clamp-2">' + escapeHtml(n.message) + '</p>'
                            + '<time class="notif-time mt-1.5 block text-[10px] font-medium text-slate-400 dark:text-slate-500" datetime="' + n.created_at + '" data-time="' + n.created_at + '">' + time + '</time>'
                            + '</div></div></div>';
                    });
                } else {
                    html = '<div class="flex flex-col items-center justify-center px-4 py-8 text-center"><svg class="h-8 w-8 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg><p class="mt-2 text-xs text-slate-500 dark:text-slate-400">Tidak ada notifikasi baru.</p></div>';
                }
                list.innerHTML = html;
                
                updateNotifTimes();

                document.querySelectorAll('#notif-list > div').forEach(function(el){
                    el.onclick = function(){
                        var idx = Array.prototype.indexOf.call(el.parentNode.children, el);
                        var item = (data.notifications && data.notifications[idx]) ? data.notifications[idx] : null;
                        if (item) openNotifDetail(item.id, item.title, item.message, item.created_at);
                    };
                });
            }).catch(function(err){ console.error('notif poll err', err); });
        }

        function escapeHtml(text) {
            if (!text) return '';
            return text.replace(/[&<>"'`]/g, function (s) { 
                return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":"&#39;","`":"&#96;"})[s]; 
            });
        }

        function openNotifDetail(id, title, message, created_at) {
            fetch('/admin/notifications/' + id + '/read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            }).then(function(res){ return res.json(); }).then(function(data){
                var cnt = data.unreadCount || 0;
                var badge = document.getElementById('notif-badge');
                var badgeText = document.getElementById('notif-badge-text');
                if (cnt > 0) { badge.style.display = 'flex'; badgeText.textContent = cnt > 9 ? '9+' : cnt; } else { badge.style.display = 'none'; }
                pollNotifications();
            }).catch(function(e){ console.error('mark read err', e); });

            document.getElementById('notif-detail-title').textContent = title || '';
            document.getElementById('notif-detail-message').textContent = message || '';
            document.getElementById('notif-detail-time').textContent = new Date(created_at).toLocaleString();
            var modal = document.getElementById('notif-detail-modal');
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
            modal.style.zIndex = '2147483647';
            modal.style.position = 'fixed';
            var modalCard = modal.querySelector('div');
            if (modalCard) {
                modalCard.style.zIndex = '2147483647';
            }
        }

        function closeNotifModal(){ 
            var modal = document.getElementById('notif-detail-modal');
            modal.classList.add('hidden'); 
            modal.style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', function () {
            updateNotifTimes();
            setInterval(updateNotifTimes, 30000);
            setInterval(pollNotifications, 6000);
            setTimeout(pollNotifications, 1200);
        });
    </script>
    @livewireScripts
    @stack('scripts')
</body>
</html>