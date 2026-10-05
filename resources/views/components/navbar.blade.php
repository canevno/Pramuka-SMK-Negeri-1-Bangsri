<nav style="font-family: 'Inter', 'Segoe UI', 'Helvetica Neue', Arial, sans-serif; visibility: visible;"
    x-cloak
    class="sticky inset-x-0 top-0 z-50 border-b border-slate-200 bg-white text-slate-900 shadow-sm transition-colors duration-200"
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
                { value: 'organisasi', paths: ['/pembina', '/dewan-kehormatan', '/dewan-ambalan', '/anggota-dewan'] },
                { value: 'event', paths: ['/event'] },
                { value: 'berita', paths: ['/berita', '/galeri', '/prestasi', '/prestasi/ranting', '/prestasi/cabang', '/prestasi/jateng', '/prestasi/nasional'] },
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
            <a href="{{ route('home') }}" class="flex min-w-0 items-center gap-2 sm:gap-3 lg:w-65 lg:shrink-0">
                <img src="{{ asset('images/logos/smklogo.png') }}" alt="Logo" class="h-8 w-8 shrink-0 object-contain sm:h-10 sm:w-10 lg:h-12 lg:w-12">
                <div class="min-w-0 leading-tight">
                    <div class="truncate text-[1.15rem] font-semibold tracking-tight text-slate-900 dark:text-white sm:text-[0.9rem] lg:text-[1.05rem] xl:text-[1.2rem]">
                        PRAMUKA ESKASABA
                    </div>
                </div>
            </a>

            <!-- Center: Desktop Navigation -->
            <div class="hidden lg:flex flex-1 items-center justify-center gap-3 xl:gap-5">

                <!-- Beranda -->
                <a href="{{ route('home') }}"
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
                        <a href="{{ route('about') }}" @click="activeNav = 'profil'" class="flex items-center gap-2.5 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-slate-50 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white rounded-md transition-colors">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"></path>
                            </svg>
                            Sejarah Kepanduan
                        </a>
                        <a href="{{ route('visi-misi') }}" @click="activeNav = 'profil'" class="flex items-center gap-2.5 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-slate-50 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white rounded-md transition-colors">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5"></path>
                            </svg>
                            Visi &amp; Misi
                        </a>
                        <a href="{{ route('ambalan') }}" @click="activeNav = 'profil'" class="flex items-center gap-2.5 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-slate-50 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white rounded-md transition-colors">
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
                        <a href="{{ route('absensi.index') }}" @click="activeNav = 'admin'" class="flex items-center gap-2.5 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-slate-50 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white rounded-md transition-colors">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75"></path>
                            </svg>
                            Absensi
                        </a>
                        <a href="{{ route('pendaftaran-bantara') }}" @click="activeNav = 'admin'" class="flex items-center gap-2.5 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-slate-50 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white rounded-md transition-colors">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM3 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 019.374 21c-2.331 0-4.512-.645-6.374-1.766z"></path>
                            </svg>
                            Pendaftaran Bantara
                        </a>
                        <a href="{{ route('pendaftaran-laksana') }}" @click="activeNav = 'admin'" class="flex items-center gap-2.5 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-slate-50 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white rounded-md transition-colors">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"></path>
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
                        <a href="{{ route('pembina') }}" @click="activeNav = 'organisasi'" class="flex items-center gap-2.5 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-slate-50 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white rounded-md transition-colors">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Pembina
                        </a>
                        <a href="{{ route('dewan-kehormatan') }}" @click="activeNav = 'organisasi'" class="flex items-center gap-2.5 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-slate-50 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white rounded-md transition-colors">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"></path>
                            </svg>
                            Dewan Kehormatan
                        </a>
                        <a href="{{ route('dewan-ambalan') }}" @click="activeNav = 'organisasi'" class="flex items-center gap-2.5 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-slate-50 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white rounded-md transition-colors">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z"></path>
                            </svg>
                            Dewan Ambalan
                        </a>
                        <a href="{{ route('anggota-dewan') }}" @click="activeNav = 'organisasi'" class="flex items-center gap-2.5 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-slate-50 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white rounded-md transition-colors">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z"></path>
                            </svg>
                            Anggota Dewan
                        </a>
                        <!-- Mitra removed: resource deleted -->
                        <!-- Alumni removed per request -->
                    </div>
                </div>

                <!-- Event -->
                <a href="{{ route('event') }}" @click="activeNav = 'event'" :class="activeNav === 'event' ? 'text-[14px] font-medium tracking-tight text-slate-900 border-b-2 border-slate-900 pb-0.5 dark:text-white dark:border-white' : 'text-[14px] font-medium tracking-tight text-slate-700 border-b-2 border-transparent pb-0.5 transition-colors hover:text-slate-600 dark:text-slate-200 dark:hover:text-blue-300'">Event</a>

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
                        Publikasi
                        <svg class="h-4 w-4 transition-transform duration-200" :class="publikasiOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-cloak x-show="publikasiOpen"
                        x-transition:enter="transition ease-out duration-180" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-140" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
                        class="dropdown-menu absolute left-0 top-full z-50 mt-2 w-56 rounded-lg border border-slate-200 bg-white p-2 shadow-xl dark:border-slate-700 dark:bg-gray-900">
                        <a href="{{ route('news') }}" @click="activeNav = 'berita'" class="flex items-center gap-2.5 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-slate-50 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white rounded-md transition-colors">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"></path>
                            </svg>
                            Berita
                        </a>
                        <a href="{{ route('gallery') }}" @click="activeNav = 'berita'" class="flex items-center gap-2.5 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-slate-50 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white rounded-md transition-colors">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path>
                            </svg>
                            Galeri
                        </a>
                        <a href="{{ route('prestasi') }}" @click="activeNav = 'berita'" class="flex items-center gap-2.5 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-slate-50 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white rounded-md transition-colors">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 002.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 012.916.52 6.003 6.003 0 01-5.395 4.972m0 0a6.726 6.726 0 01-2.749 1.35m0 0a6.772 6.772 0 01-3.044 0"></path>
                            </svg>
                            Prestasi
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
    <div id="mobile-menu" x-cloak x-show="mobileMenuOpen" @keydown.escape.window="mobileMenuOpen = false" class="lg:hidden fixed inset-0 z-50 overflow-hidden">
        <div class="absolute inset-0 bg-black/30 backdrop-blur-sm transition-opacity" @click="mobileMenuOpen = false"></div>
        <div class="mobile-menu-panel absolute inset-y-0 right-0 w-full max-w-sm bg-white dark:bg-gray-950 shadow-2xl overflow-y-auto border-l border-slate-200 dark:border-slate-800 transition-transform duration-300"
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
                    <form action="{{ route('search') }}" method="get" class="flex items-center bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 px-3 py-3 rounded-2xl shadow-sm transition-colors duration-200 focus-within:border-blue-400 dark:focus-within:border-blue-500">
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
                    <a href="{{ route('home') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-4 py-3 text-base font-bold text-gray-900 transition-colors hover:bg-slate-50 dark:text-white dark:hover:bg-slate-900 rounded-xl">
                        <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"></path>
                        </svg>
                        Beranda
                    </a>

                    <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 overflow-hidden">
                        <button type="button" @click="mobileProfilOpen = !mobileProfilOpen" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold text-gray-900 dark:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                            <span class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"></path>
                                </svg>
                                Profil
                            </span>
                            <svg class="h-4 w-4 transition-transform duration-200" :class="mobileProfilOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="mobileProfilOpen" x-transition class="mobile-submenu space-y-1 border-t border-slate-200 dark:border-slate-800 px-4 py-2">
                            <a href="{{ route('about') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 rounded-xl px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"></path>
                                </svg>
                                Sejarah Sekolah
                            </a>
                            <a href="{{ route('visi-misi') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 rounded-xl px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5"></path>
                                </svg>
                                Visi &amp; Misi
                            </a>
                            <a href="{{ route('ambalan') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 rounded-xl px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">
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
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path>
                                </svg>
                                Administrasi
                            </span>
                            <svg class="h-4 w-4 transition-transform duration-200" :class="mobileAdminOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="mobileAdminOpen" x-transition class="mobile-submenu space-y-1 border-t border-slate-200 dark:border-slate-800 px-4 py-2">
                            <a href="{{ route('absensi.index') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 rounded-xl px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75"></path>
                                </svg>
                                Absensi
                            </a>
                            <a href="{{ route('pendaftaran-bantara') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 rounded-xl px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM3 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 019.374 21c-2.331 0-4.512-.645-6.374-1.766z"></path>
                                </svg>
                                Pendaftaran Bantara
                            </a>
                            <a href="{{ route('pendaftaran-laksana') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 rounded-xl px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"></path>
                                </svg>
                                Pendaftaran Laksana
                            </a>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 overflow-hidden">
                        <button type="button" @click="mobileOrgOpen = !mobileOrgOpen" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold text-gray-900 dark:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                            <span class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z"></path>
                                </svg>
                                Organisasi
                            </span>
                            <svg class="h-4 w-4 transition-transform duration-200" :class="mobileOrgOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="mobileOrgOpen" x-transition class="mobile-submenu space-y-1 border-t border-slate-200 dark:border-slate-800 px-4 py-2">
                            <a href="{{ route('pembina') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 rounded-xl px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Pembina
                            </a>
                            <a href="{{ route('dewan-kehormatan') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 rounded-xl px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"></path>
                                </svg>
                                Dewan Kehormatan
                            </a>
                            <a href="{{ route('dewan-ambalan') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 rounded-xl px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z"></path>
                                </svg>
                                Dewan Ambalan
                            </a>
                            <a href="{{ route('anggota-dewan') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 rounded-xl px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z"></path>
                                </svg>
                                Anggota Dewan
                            </a>
                                <!-- Mitra removed: resource deleted -->
                            <!-- Alumni removed per request -->
                        </div>
                    </div>

                    <a href="{{ route('event') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 rounded-2xl px-4 py-3 text-base font-bold text-gray-900 transition-colors bg-slate-50 hover:bg-slate-100 dark:bg-slate-900 dark:text-white dark:hover:bg-slate-800">
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
                                Publikasi
                            </span>
                            <svg class="h-4 w-4 transition-transform duration-200" :class="mobilePublikasiOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="mobilePublikasiOpen" x-transition class="mobile-submenu space-y-1 border-t border-slate-200 dark:border-slate-800 px-4 py-2">
                            <a href="{{ route('news') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 rounded-xl px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"></path>
                                </svg>
                                Berita
                            </a>
                            <a href="{{ route('gallery') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 rounded-xl px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path>
                                </svg>
                                Galeri
                            </a>
                            <a href="{{ route('prestasi') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 rounded-xl px-4 py-2 text-sm text-gray-700 hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 002.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 012.916.52 6.003 6.003 0 01-5.395 4.972m0 0a6.726 6.726 0 01-2.749 1.35m0 0a6.772 6.772 0 01-3.044 0"></path>
                                </svg>
                                Prestasi
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
</nav>