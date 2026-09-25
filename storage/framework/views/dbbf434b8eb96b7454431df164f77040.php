<nav style="font-family: 'Inter', 'Segoe UI', 'Helvetica Neue', Arial, sans-serif; visibility: hidden;"
    x-cloak
    class="sticky top-0 z-50 border-b border-slate-200 bg-white text-slate-900 shadow-sm transition-colors duration-200"
    x-data="{
        activeNav: 'home',
        mobileMenuOpen: false,
        profileOpen: false, profileTimer: null,
        adminOpen: false, adminTimer: null,
        orgOpen: false, orgTimer: null,
        publikasiOpen: false, publikasiTimer: null,
        mobileProfilOpen: false, mobileAdminOpen: false, mobileOrgOpen: false, mobilePublikasiOpen: false,
        resetDropdownStates() {
            this.profileOpen = false;
            this.adminOpen = false;
            this.orgOpen = false;
            this.publikasiOpen = false;
            this.mobileProfilOpen = false;
            this.mobileAdminOpen = false;
            this.mobileOrgOpen = false;
            this.mobilePublikasiOpen = false;
            clearTimeout(this.profileTimer); this.profileTimer = null;
            clearTimeout(this.adminTimer); this.adminTimer = null;
            clearTimeout(this.orgTimer); this.orgTimer = null;
            clearTimeout(this.publikasiTimer); this.publikasiTimer = null;
        },
        syncActiveNav() {
            const path = window.location.pathname.replace(/\/+$/, '') || '/';
            const matchers = [
                { value: 'home', paths: ['/'] },
                { value: 'profil', paths: ['/tentang-kami', '/visi-misi', '/ambalan'] },
                { value: 'admin', paths: ['/absensi', '/pendaftaran-bantara', '/pendaftaran-laksana'] },
                { value: 'organisasi', paths: ['/pembina', '/dewan-kehormatan', '/dewan-ambalan', '/anggota-dewan', '/mitra'] },
                { value: 'event', paths: ['/event'] },
                { value: 'berita', paths: ['/berita', '/galeri'] },
            ];

            const matched = matchers.find(item => item.paths.some(p => path === p || path.startsWith(p + '/')));
            this.activeNav = matched ? matched.value : 'home';
        },
        init() {
            this.$nextTick(() => {
                this.resetDropdownStates();
                this.syncActiveNav();
                this.$el.style.visibility = 'visible';
            });

            window.addEventListener('pageshow', () => {
                this.resetDropdownStates();
                this.syncActiveNav();
            });
        },
        closeAllExcept(current) {
            const timers = { admin: 'adminTimer', profile: 'profileTimer', org: 'orgTimer', publikasi: 'publikasiTimer' };
            const opens  = { admin: 'adminOpen',  profile: 'profileOpen',  org: 'orgOpen',  publikasi: 'publikasiOpen' };
            Object.keys(opens).forEach(key => {
                if (key !== current) { clearTimeout(this[timers[key]]); this[opens[key]] = false; }
            });
        }
    }"
>
    <style>
        nav > .mx-auto a,
        nav > .mx-auto button,
        nav > .mx-auto span,
        nav > .mx-auto div,
        nav > .mx-auto svg,
        nav > .mx-auto .text-slate-900,
        nav > .mx-auto .text-slate-700,
        nav > .mx-auto .text-slate-500,
        nav > .mx-auto .text-slate-400,
        nav > .mx-auto .text-gray-700,
        nav > .mx-auto .text-gray-900,
        nav > .mx-auto .text-white {
            color: #0f172a !important;
        }

        nav .dropdown-menu,
        nav .dropdown-menu a,
        nav .dropdown-menu button,
        nav .dropdown-menu span,
        nav .dropdown-menu div,
        nav .dropdown-menu svg,
        nav .dropdown-menu .text-slate-400,
        nav .dropdown-menu .text-gray-700,
        nav .dropdown-menu .text-gray-900,
        nav .mobile-menu-panel,
        nav .mobile-menu-panel a,
        nav .mobile-menu-panel button,
        nav .mobile-menu-panel span,
        nav .mobile-menu-panel div,
        nav .mobile-menu-panel svg,
        nav .mobile-menu-panel .text-slate-500,
        nav .mobile-menu-panel .text-slate-400,
        nav .mobile-submenu,
        nav .mobile-submenu a,
        nav .mobile-submenu button,
        nav .mobile-submenu span,
        nav .mobile-submenu div,
        nav .mobile-submenu svg,
        nav .mobile-submenu .text-slate-400 {
            color: #0f172a !important;
        }

        nav .border-slate-300,
        nav .border-slate-200,
        nav .border-slate-800,
        nav .border-slate-700 {
            border-color: rgba(15, 23, 42, 0.12) !important;
        }
    </style>

    <!-- SINGLE ROW: Logo + Title (left) / Nav Menu (right) -->
    <div class="mx-auto w-full max-w-350 px-3 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center gap-3 sm:h-20 sm:gap-6 lg:gap-8">

            <!-- Left: Logo and Site Title -->
            <a href="<?php echo e(route('home')); ?>" class="flex min-w-0 items-center gap-2 sm:gap-3 lg:w-65 lg:shrink-0">
                <img src="<?php echo e(asset('images/logos/smklogo.png')); ?>" alt="Logo" class="h-8 w-8 shrink-0 object-contain sm:h-10 sm:w-10 lg:h-12 lg:w-12">
                <div class="min-w-0 leading-tight">
                    <div class="truncate text-[1.15rem] font-semibold tracking-tight text-slate-900 dark:text-white sm:text-[0.9rem] lg:text-[1.05rem] xl:text-[1.2rem]">
                        PRAMUKA ESKASABA
                    </div>
                </div>
            </a>

            <!-- Center: Desktop Navigation -->
            <div class="hidden lg:flex flex-1 items-center justify-center gap-3 xl:gap-5">

                <!-- Beranda -->
                <a href="<?php echo e(route('home')); ?>"
                   @click="activeNav = 'home'"
                   :class="activeNav === 'home' ? 'text-[14px] font-medium tracking-tight text-slate-900 border-b-2 border-slate-900 pb-0.5 dark:text-white dark:border-white' : 'text-[14px] font-medium tracking-tight text-slate-700 border-b-2 border-transparent pb-0.5 transition-colors hover:text-slate-600 dark:text-slate-200 dark:hover:text-blue-300'">
                    Beranda
                </a>

                <!-- PROFIL dropdown -->
                <div class="relative"
                    @mouseenter="clearTimeout(profileTimer); profileOpen = true; closeAllExcept('profile')"
                    @mouseleave="profileTimer = setTimeout(() => profileOpen = false, 120)"
                    @click.away="profileOpen = false"
                    @focusin="clearTimeout(profileTimer); profileOpen = true; closeAllExcept('profile')"
                    @focusout="if (!$el.contains($event.relatedTarget)) profileTimer = setTimeout(() => profileOpen = false, 120)"
                >
                    <button type="button" @click="activeNav = 'profil'; profileOpen = !profileOpen; closeAllExcept('profile')" :aria-expanded="profileOpen"
                        :class="activeNav === 'profil' ? 'flex items-center gap-1 text-[14px] font-medium tracking-tight text-slate-900 border-b-2 border-slate-900 pb-0.5 focus:outline-none dark:text-white dark:border-white' : 'flex items-center gap-1 text-[14px] font-medium tracking-tight text-slate-700 border-b-2 border-transparent pb-0.5 transition-colors hover:text-slate-600 focus:outline-none dark:text-slate-200 dark:hover:text-blue-300'">
                        Profil
                        <svg class="h-4 w-4 transition-transform duration-200" :class="profileOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-cloak x-show="profileOpen"
                        x-transition:enter="transition ease-out duration-180" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-140" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
                        class="dropdown-menu absolute left-0 top-full z-50 mt-2 w-64 rounded-lg border border-slate-200 bg-white p-2 shadow-xl dark:border-slate-700 dark:bg-gray-900">
                        <a href="<?php echo e(route('about')); ?>" @click="activeNav = 'profil'" class="flex items-center gap-2.5 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-slate-50 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white rounded-md transition-colors">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.001 9.001 0 008.716-6.747M12 21a9.001 9.001 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"></path>
                            </svg>
                            Sejarah Kepanduan
                        </a>
                        <a href="<?php echo e(route('visi-misi')); ?>" @click="activeNav = 'profil'" class="flex items-center gap-2.5 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-slate-50 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white rounded-md transition-colors">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Visi &amp; Misi
                        </a>
                        <a href="<?php echo e(route('ambalan')); ?>" @click="activeNav = 'profil'" class="flex items-center gap-2.5 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-slate-50 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white rounded-md transition-colors">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                            </svg>
                            Ambalan
                        </a>
                    </div>
                </div>

                <!-- ADMINISTRASI dropdown -->
                <div class="relative"
                    @mouseenter="clearTimeout(adminTimer); adminOpen = true; closeAllExcept('admin')"
                    @mouseleave="adminTimer = setTimeout(() => adminOpen = false, 120)"
                    @click.away="adminOpen = false"
                    @focusin="clearTimeout(adminTimer); adminOpen = true; closeAllExcept('admin')"
                    @focusout="if (!$el.contains($event.relatedTarget)) adminTimer = setTimeout(() => adminOpen = false, 120)"
                >
                    <button type="button" @click="activeNav = 'admin'; adminOpen = !adminOpen; closeAllExcept('admin')" :aria-expanded="adminOpen"
                        :class="activeNav === 'admin' ? 'flex items-center gap-1 text-[14px] font-medium tracking-tight text-slate-900 border-b-2 border-slate-900 pb-0.5 focus:outline-none dark:text-white dark:border-white' : 'flex items-center gap-1 text-[14px] font-medium tracking-tight text-slate-700 border-b-2 border-transparent pb-0.5 transition-colors hover:text-slate-600 focus:outline-none dark:text-slate-200 dark:hover:text-blue-300'">
                        Administrasi
                        <svg class="h-4 w-4 transition-transform duration-200" :class="adminOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-cloak x-show="adminOpen"
                        x-transition:enter="transition ease-out duration-180" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-140" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
                        class="dropdown-menu absolute left-0 top-full z-50 mt-2 w-64 rounded-lg border border-slate-200 bg-white p-2 shadow-xl dark:border-slate-700 dark:bg-gray-900">
                        <a href="<?php echo e(route('absensi.index')); ?>" @click="activeNav = 'admin'" class="flex items-center gap-2.5 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-slate-50 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white rounded-md transition-colors">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"></path>
                            </svg>
                            Absensi
                        </a>
                        <a href="<?php echo e(route('pendaftaran-bantara')); ?>" @click="activeNav = 'admin'" class="flex items-center gap-2.5 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-slate-50 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white rounded-md transition-colors">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.25A7.25 7.25 0 0111.25 12h1.5A7.25 7.25 0 0120 19.25v.75H4v-.75z"></path>
                            </svg>
                            Pendaftaran Bantara
                        </a>
                        <a href="<?php echo e(route('pendaftaran-laksana')); ?>" @click="activeNav = 'admin'" class="flex items-center gap-2.5 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-slate-50 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white rounded-md transition-colors">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.25A7.25 7.25 0 0111.25 12h1.5A7.25 7.25 0 0120 19.25v.75H4v-.75z"></path>
                            </svg>
                            Pendaftaran Laksana
                        </a>
                    </div>
                </div>

                <!-- ORGANISASI dropdown -->
                <div class="relative"
                    @mouseenter="clearTimeout(orgTimer); orgOpen = true; closeAllExcept('org')"
                    @mouseleave="orgTimer = setTimeout(() => orgOpen = false, 120)"
                    @click.away="orgOpen = false"
                    @focusin="clearTimeout(orgTimer); orgOpen = true; closeAllExcept('org')"
                    @focusout="if (!$el.contains($event.relatedTarget)) orgTimer = setTimeout(() => orgOpen = false, 120)"
                >
                    <button type="button" @click="activeNav = 'organisasi'; orgOpen = !orgOpen; closeAllExcept('org')" :aria-expanded="orgOpen"
                        :class="activeNav === 'organisasi' ? 'flex items-center gap-1 text-[14px] font-medium tracking-tight text-slate-900 border-b-2 border-slate-900 pb-0.5 focus:outline-none dark:text-white dark:border-white' : 'flex items-center gap-1 text-[14px] font-medium tracking-tight text-slate-700 border-b-2 border-transparent pb-0.5 transition-colors hover:text-slate-600 focus:outline-none dark:text-slate-200 dark:hover:text-blue-300'">
                        Organisasi
                        <svg class="h-4 w-4 transition-transform duration-200" :class="orgOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-cloak x-show="orgOpen"
                        x-transition:enter="transition ease-out duration-180" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-140" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
                        class="dropdown-menu absolute left-0 top-full z-50 mt-1 w-64 rounded-lg border border-slate-200 bg-white p-2 shadow-xl dark:border-slate-700 dark:bg-gray-900">
                        <a href="<?php echo e(route('pembina')); ?>" @click="activeNav = 'organisasi'" class="flex items-center gap-2.5 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-slate-50 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white rounded-md transition-colors">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path>
                            </svg>
                            Pembina
                        </a>
                        <a href="<?php echo e(route('dewan-kehormatan')); ?>" @click="activeNav = 'organisasi'" class="flex items-center gap-2.5 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-slate-50 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white rounded-md transition-colors">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"></path>
                            </svg>
                            Dewan Kehormatan
                        </a>
                        <a href="<?php echo e(route('dewan-ambalan')); ?>" @click="activeNav = 'organisasi'" class="flex items-center gap-2.5 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-slate-50 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white rounded-md transition-colors">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605"></path>
                            </svg>
                            Dewan Ambalan
                        </a>
                        <a href="<?php echo e(route('anggota-dewan')); ?>" @click="activeNav = 'organisasi'" class="flex items-center gap-2.5 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-slate-50 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white rounded-md transition-colors">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"></path>
                            </svg>
                            Anggota Dewan
                        </a>
                        <a href="<?php echo e(route('mitra')); ?>" @click="activeNav = 'organisasi'" class="flex items-center gap-2.5 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-slate-50 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white rounded-md transition-colors">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"></path>
                            </svg>
                            Mitra
                        </a>
                        <a href="<?php echo e(route('alumni')); ?>" @click="activeNav = 'organisasi'" class="flex items-center gap-2.5 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-slate-50 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white rounded-md transition-colors">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"></path>
                            </svg>
                            Alumni
                        </a>
                    </div>
                </div>

                <!-- Event -->
                <a href="<?php echo e(route('event')); ?>" @click="activeNav = 'event'" :class="activeNav === 'event' ? 'text-[14px] font-medium tracking-tight text-slate-900 border-b-2 border-slate-900 pb-0.5 dark:text-white dark:border-white' : 'text-[14px] font-medium tracking-tight text-slate-700 border-b-2 border-transparent pb-0.5 transition-colors hover:text-slate-600 dark:text-slate-200 dark:hover:text-blue-300'">Event</a>

                <!-- PUBLIKASI dropdown -->
                <div class="relative"
                    @mouseenter="clearTimeout(publikasiTimer); publikasiOpen = true; closeAllExcept('publikasi')"
                    @mouseleave="publikasiTimer = setTimeout(() => publikasiOpen = false, 120)"
                    @click.away="publikasiOpen = false"
                    @focusin="clearTimeout(publikasiTimer); publikasiOpen = true; closeAllExcept('publikasi')"
                    @focusout="if (!$el.contains($event.relatedTarget)) publikasiTimer = setTimeout(() => publikasiOpen = false, 120)"
                >
                    <button type="button" @click="activeNav = 'berita'; publikasiOpen = !publikasiOpen; closeAllExcept('publikasi')" :aria-expanded="publikasiOpen"
                        :class="activeNav === 'berita' ? 'flex items-center gap-1 text-[14px] font-medium tracking-tight text-slate-900 border-b-2 border-slate-900 pb-0.5 focus:outline-none dark:text-white dark:border-white' : 'flex items-center gap-1 text-[14px] font-medium tracking-tight text-slate-700 border-b-2 border-transparent pb-0.5 transition-colors hover:text-slate-600 focus:outline-none dark:text-slate-200 dark:hover:text-blue-300'">
                        Berita
                        <svg class="h-4 w-4 transition-transform duration-200" :class="publikasiOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-cloak x-show="publikasiOpen"
                        x-transition:enter="transition ease-out duration-180" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-140" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
                        class="dropdown-menu absolute left-0 top-full z-50 mt-2 w-56 rounded-lg border border-slate-200 bg-white p-2 shadow-xl dark:border-slate-700 dark:bg-gray-900">
                        <a href="<?php echo e(route('news')); ?>" @click="activeNav = 'berita'" class="flex items-center gap-2.5 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-slate-50 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white rounded-md transition-colors">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"></path>
                            </svg>
                            Berita
                        </a>
                        <a href="<?php echo e(route('gallery')); ?>" @click="activeNav = 'berita'" class="flex items-center gap-2.5 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-slate-50 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white rounded-md transition-colors">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path>
                            </svg>
                            Galeri
                        </a>
                    </div>
                </div>

                <!-- AyoKwarnas -->
                <a href="https://ayopramuka-kwarnas.id/" target="_blank" rel="noopener noreferrer" @click="activeNav = 'ayokwarnas'" :class="activeNav === 'ayokwarnas' ? 'text-[14px] font-medium tracking-tight text-slate-900 border-b-2 border-slate-900 pb-0.5 dark:text-white dark:border-white' : 'text-[14px] font-medium tracking-tight text-slate-700 border-b-2 border-transparent pb-0.5 transition-colors hover:text-slate-600 dark:text-slate-200 dark:hover:text-blue-300'">AyoKwarnas</a>
            </div>

            <!-- Mobile toggle -->
            <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" :aria-expanded="mobileMenuOpen" aria-controls="mobile-menu"
                class="lg:hidden ml-auto mr-0 flex h-9 w-9 items-center justify-center rounded-lg border-0 bg-transparent p-0 text-gray-700 shadow-none ring-0 outline-none hover:bg-slate-100 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-slate-400 dark:text-white dark:hover:bg-slate-800 dark:hover:text-gray-200 active:scale-95 transition-all duration-200"
                aria-label="Toggle menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path :d="mobileMenuOpen ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" x-cloak x-show="mobileMenuOpen" @keydown.escape.window="mobileMenuOpen = false" class="lg:hidden fixed inset-0 z-[70] overflow-hidden">
        <div class="absolute inset-0 bg-black/30 backdrop-blur-sm transition-opacity" @click="mobileMenuOpen = false"></div>
        <div class="mobile-menu-panel relative z-[70] absolute inset-y-0 right-0 w-full max-w-sm bg-white dark:bg-gray-950 shadow-2xl overflow-y-auto border-l border-slate-200 dark:border-slate-800 transition-transform duration-300 pointer-events-auto"
            x-show="mobileMenuOpen"
            x-transition:enter="transition-transform ease-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition-transform ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">
            <div class="px-4 py-4 sm:px-6">
                <div class="flex items-center justify-between">
                    <div class="text-base font-bold text-gray-900 dark:text-white">Menu</div>
                    <button type="button" @click="mobileMenuOpen = false" class="rounded-lg p-2 text-gray-600 hover:bg-slate-100 dark:text-gray-300 dark:hover:bg-slate-800 transition-colors" aria-label="Close menu">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="mt-4">
                    <label class="sr-only" for="mobile-search">Cari</label>
                    <form action="<?php echo e(route('search')); ?>" method="get" class="flex items-center bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 px-3 py-3 rounded-2xl shadow-sm transition-colors duration-200 focus-within:border-blue-400 dark:focus-within:border-blue-500">
                        <svg class="w-5 h-5 text-slate-400 dark:text-slate-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
                        </svg>
                        <input id="mobile-search" type="text" name="q" placeholder="Cari..." class="bg-transparent text-sm text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-500 focus:outline-none w-full">
                        <button type="submit" class="ml-2 text-slate-500 dark:text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
                            </svg>
                        </button>
                    </form>
                </div>

                <div class="mt-6 space-y-2 pb-6">
                    <a href="<?php echo e(route('home')); ?>" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-4 py-3 text-base font-bold text-gray-900 transition-colors hover:bg-slate-50 dark:text-white dark:hover:bg-slate-900 rounded-xl">
                        <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"></path>
                        </svg>
                        Beranda
                    </a>

                    <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 overflow-hidden">
                        <button type="button" @click="mobileProfilOpen = !mobileProfilOpen" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold text-gray-900 dark:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                            <span class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path>
                                </svg>
                                Profil
                            </span>
                            <svg class="h-4 w-4 transition-transform duration-200" :class="mobileProfilOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="mobileProfilOpen" x-transition class="mobile-submenu space-y-1 border-t border-slate-200 dark:border-slate-800 px-4 py-2">
                            <a href="<?php echo e(route('about')); ?>" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 rounded-xl px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.001 9.001 0 008.716-6.747M12 21a9.001 9.001 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"></path>
                                </svg>
                                Sejarah Sekolah
                            </a>
                            <a href="<?php echo e(route('visi-misi')); ?>" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 rounded-xl px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Visi &amp; Misi
                            </a>
                            <a href="<?php echo e(route('ambalan')); ?>" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 rounded-xl px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                                </svg>
                                Ambalan
                            </a>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 overflow-hidden">
                        <button type="button" @click="mobileAdminOpen = !mobileAdminOpen" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold text-gray-900 dark:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                            <span class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"></path>
                                </svg>
                                Administrasi
                            </span>
                            <svg class="h-4 w-4 transition-transform duration-200" :class="mobileAdminOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="mobileAdminOpen" x-transition class="mobile-submenu space-y-1 border-t border-slate-200 dark:border-slate-800 px-4 py-2">
                            <a href="<?php echo e(route('absensi.index')); ?>" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 rounded-xl px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"></path>
                                </svg>
                                Absensi
                            </a>
                            <a href="<?php echo e(route('pendaftaran-bantara')); ?>" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 rounded-xl px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.25A7.25 7.25 0 0111.25 12h1.5A7.25 7.25 0 0120 19.25v.75H4v-.75z"></path>
                                </svg>
                                Pendaftaran Bantara
                            </a>
                            <a href="<?php echo e(route('pendaftaran-laksana')); ?>" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 rounded-xl px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.25A7.25 7.25 0 0111.25 12h1.5A7.25 7.25 0 0120 19.25v.75H4v-.75z"></path>
                                </svg>
                                Pendaftaran Laksana
                            </a>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 overflow-hidden">
                        <button type="button" @click="mobileOrgOpen = !mobileOrgOpen" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold text-gray-900 dark:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                            <span class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                                </svg>
                                Organisasi
                            </span>
                            <svg class="h-4 w-4 transition-transform duration-200" :class="mobileOrgOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="mobileOrgOpen" x-transition class="mobile-submenu space-y-1 border-t border-slate-200 dark:border-slate-800 px-4 py-2">
                            <a href="<?php echo e(route('pembina')); ?>" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 rounded-xl px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path>
                                </svg>
                                Pembina
                            </a>
                            <a href="<?php echo e(route('dewan-kehormatan')); ?>" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 rounded-xl px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"></path>
                                </svg>
                                Dewan Kehormatan
                            </a>
                            <a href="<?php echo e(route('dewan-ambalan')); ?>" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 rounded-xl px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605"></path>
                                </svg>
                                Dewan Ambalan
                            </a>
                            <a href="<?php echo e(route('anggota-dewan')); ?>" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 rounded-xl px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"></path>
                                </svg>
                                Anggota Dewan
                            </a>
                            <a href="<?php echo e(route('mitra')); ?>" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 rounded-xl px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"></path>
                                </svg>
                                Mitra
                            </a>
                            <a href="#" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 rounded-xl px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"></path>
                                </svg>
                                Alumni
                            </a>
                        </div>
                    </div>

                    <a href="<?php echo e(route('event')); ?>" @click="mobileMenuOpen = false" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-base font-bold text-gray-900 transition-colors bg-slate-50 hover:bg-slate-100 dark:bg-slate-900 dark:text-white dark:hover:bg-slate-800">
                        <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"></path>
                        </svg>
                        Event
                    </a>

                    <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 overflow-hidden">
                        <button type="button" @click="mobilePublikasiOpen = !mobilePublikasiOpen" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold text-gray-900 dark:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                            <span class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"></path>
                                </svg>
                                Berita
                            </span>
                            <svg class="h-4 w-4 transition-transform duration-200" :class="mobilePublikasiOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="mobilePublikasiOpen" x-transition class="mobile-submenu space-y-1 border-t border-slate-200 dark:border-slate-800 px-4 py-2">
                            <a href="<?php echo e(route('news')); ?>" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 rounded-xl px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"></path>
                                </svg>
                                Berita
                            </a>
                            <a href="<?php echo e(route('gallery')); ?>" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 rounded-xl px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path>
                                </svg>
                                Galeri
                            </a>
                        </div>
                    </div>

                    <a href="https://ayopramuka-kwarnas.id/" target="_blank" rel="noopener noreferrer" @click="mobileMenuOpen = false" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-base font-bold text-gray-900 transition-colors bg-slate-50 hover:bg-slate-100 dark:bg-slate-900 dark:text-white dark:hover:bg-slate-800">
                        <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"></path>
                        </svg>
                        AyoKwarnas
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views\components\navbar.blade.php ENDPATH**/ ?>