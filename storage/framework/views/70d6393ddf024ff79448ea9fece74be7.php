<nav class="sticky top-0 z-50 bg-white dark:bg-gray-950 border-b border-slate-300 dark:border-slate-500 transition-colors duration-200" x-data="{ mobileMenuOpen: false, profileOpen: false, profileTimer: null, adminOpen: false, adminTimer: null, orgOpen: false, orgTimer: null, prestasiOpen: false, prestasiTimer: null, eventOpen: false, eventTimer: null, publikasiOpen: false, publikasiTimer: null, mobileProfilOpen: false, mobileAdminOpen: false, mobileOrgOpen: false, mobilePrestasiOpen: false, mobileEventOpen: false, mobilePublikasiOpen: false }">
    <!-- TOP BAR -->
    <div class="border-b border-slate-300 dark:border-slate-500 transition-colors duration-200">
        <div class="mx-auto max-w-full px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center h-16 gap-4 relative">
                <!-- Mobile: School Logo + Text -->
                <div class="absolute left-0 flex items-center justify-center gap-2 lg:hidden">
                    <img src="<?php echo e(asset('images/logos/smklogo.png')); ?>" alt="Logo SMK" class="h-11 w-11 object-contain bg-transparent p-0 shadow-none">
                    <span class="text-[12px] font-black uppercase tracking-wide text-slate-900 leading-none">Pramuka ESKASABA</span>
                </div>

                <!-- Desktop: Ambalan Logos -->
                <div class="absolute left-0 hidden items-center gap-6 lg:flex">
                    <img src="/images/logos/aflogo.png" alt="Ambalan 1" class="h-10 w-10 object-contain hover:opacity-80 transition-opacity" title="Ambalan 1">
                    <img src="/images/logos/dslogo.png" alt="Ambalan 2" class="h-10 w-10 object-contain hover:opacity-80 transition-opacity" title="Ambalan 2">
                </div>

                <!-- Center: Logo -->
                <a class="flex items-center gap-2 text-base md:text-lg font-bold text-gray-900 dark:text-white hover:text-gray-700 dark:hover:text-gray-200 transition-colors text-center">
                    <span class="hidden sm:inline">Pramuka SMK Negeri 1 Bangsri</span>
                </a>

                <!-- Right: Search Bar + Dark Mode Toggle + Mobile Toggle -->
                <div class="absolute right-0 flex items-center gap-3">
                    <!-- Search Bar (Desktop Only) -->
                    <div class="hidden md:flex items-center bg-white dark:bg-gray-800 border-2 border-slate-300 dark:border-slate-500 px-3 py-2 w-40 lg:w-48 rounded-lg transition-colors duration-200 hover:border-blue-400 dark:hover:border-blue-500 focus-within:border-blue-400 dark:focus-within:border-blue-500">
                        <input 
                            type="text" 
                            name="q"
                            aria-label="Search"
                            placeholder="Cari..." 
                            class="bg-white dark:bg-gray-800 text-sm text-gray-700 dark:text-gray-300 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none w-full transition-colors duration-200"
                        >
                        <svg class="w-4 h-4 text-gray-600 dark:text-gray-400 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>

                    <!-- Mobile Menu Toggle (Hidden on lg+) -->
                    <button 
                        type="button"
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        :aria-expanded="mobileMenuOpen"
                        aria-controls="mobile-menu"
                        class="lg:hidden p-2.5 rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700 hover:shadow-lg dark:hover:shadow-lg active:scale-95 transition-all duration-200 shadow-sm dark:shadow-md border border-slate-300 dark:border-slate-500"
                        aria-label="Toggle menu"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M4 6h16M4 12h16M4 18h16"
                                :d="mobileMenuOpen ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                            />
                        </svg>
                    </button>
                </div>
        </div>
    </div>

    <!-- MAIN NAVIGATION -->
    <!-- Desktop Menu -->
    <div class="hidden lg:block border-t border-slate-300 dark:border-slate-500 transition-colors duration-200">
        <div class="mx-auto max-w-full px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center h-14">
                <div class="flex gap-8">
                    <a href="<?php echo e(route('home')); ?>" class="text-sm font-semibold text-gray-900 transition-colors uppercase tracking-wide hover:text-slate-900 dark:text-white dark:hover:text-blue-300">BERANDA</a>
                    <div
                        class="relative"
                        @mouseenter="clearTimeout(adminTimer); adminOpen = true; clearTimeout(profileTimer); profileOpen = false; clearTimeout(orgTimer); orgOpen = false"
                        @mouseleave="adminTimer = setTimeout(() => adminOpen = false, 120)"
                        @click.away="adminOpen = false"
                        @focusin="clearTimeout(adminTimer); adminOpen = true; clearTimeout(profileTimer); profileOpen = false; clearTimeout(orgTimer); orgOpen = false"
                        @focusout="if (!$el.contains($event.relatedTarget)) adminTimer = setTimeout(() => adminOpen = false, 120)"
                    >
                        <button
                            type="button"
                            @click="adminOpen = !adminOpen; profileOpen = false; orgOpen = false"
                            :aria-expanded="adminOpen"
                            class="flex items-center gap-1 text-sm font-semibold uppercase tracking-wide text-gray-900 transition-colors focus:outline-none dark:text-white dark:hover:text-white"
                        >
                            ADMINISTRASI
                            <svg class="h-4 w-4 transition-transform duration-200" :class="adminOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div
                            x-cloak
                            x-show="adminOpen"
                            x-transition:enter="transition ease-out duration-180"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-140"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-2"
                            class="absolute left-0 top-full z-50 mt-2 w-48 rounded-none border border-slate-300 bg-white p-2 shadow-lg dark:border-slate-600 dark:bg-gray-900"
                        >
                            <a href="<?php echo e(route('absensi.index')); ?>" class="block rounded-none px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-slate-100 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white">Absensi</a>
                            <a href="<?php echo e(route('pendaftaran-bantara')); ?>" class="block rounded-none px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-slate-100 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white">Pendaftaran Bantara</a>
                            <a href="<?php echo e(route('pendaftaran-laksana')); ?>" class="block rounded-none px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-slate-100 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white">Pendaftaran Laksana</a>
                        </div>
                    </div>
                    <div
                        class="relative"
                        @mouseenter="clearTimeout(profileTimer); profileOpen = true; clearTimeout(adminTimer); adminOpen = false; clearTimeout(orgTimer); orgOpen = false"
                        @mouseleave="profileTimer = setTimeout(() => profileOpen = false, 120)"
                        @click.away="profileOpen = false"
                        @focusin="clearTimeout(profileTimer); profileOpen = true; clearTimeout(adminTimer); adminOpen = false; clearTimeout(orgTimer); orgOpen = false"
                        @focusout="if (!$el.contains($event.relatedTarget)) profileTimer = setTimeout(() => profileOpen = false, 120)"
                    >
                        <button
                            type="button"
                            @click="profileOpen = !profileOpen; orgOpen = false"
                            :aria-expanded="profileOpen"
                            class="flex items-center gap-1 text-sm font-semibold uppercase tracking-wide text-gray-900 transition-colors focus:outline-none dark:text-white dark:hover:text-white"
                        >
                            PROFIL
                            <svg class="h-4 w-4 transition-transform duration-200" :class="profileOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div
                            x-cloak
                            x-show="profileOpen"
                            x-transition:enter="transition ease-out duration-180"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-140"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-2"
                            class="absolute left-0 top-full z-50 mt-2 w-48 rounded-none border border-slate-300 bg-white p-2 shadow-lg dark:border-slate-600 dark:bg-gray-900"
                        >
                            <a href="<?php echo e(route('about')); ?>" class="block rounded-none px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-slate-100 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white">Sejarah</a>
                            <a href="<?php echo e(route('visi-misi')); ?>" class="block rounded-none px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-slate-100 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white">Visi &amp; Misi</a>
                            <a href="<?php echo e(route('ambalan')); ?>" class="block rounded-none px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-slate-100 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white">Ambalan</a>
                        </div>
                    </div>
                    <div
                        class="relative"
                        @mouseenter="clearTimeout(orgTimer); orgOpen = true; clearTimeout(profileTimer); profileOpen = false"
                        @mouseleave="orgTimer = setTimeout(() => orgOpen = false, 120)"
                        @click.away="orgOpen = false"
                        @focusin="clearTimeout(orgTimer); orgOpen = true; clearTimeout(profileTimer); profileOpen = false"
                        @focusout="if (!$el.contains($event.relatedTarget)) orgTimer = setTimeout(() => orgOpen = false, 120)"
                    >
                        <button
                            type="button"
                            @click="orgOpen = !orgOpen; profileOpen = false"
                            :aria-expanded="orgOpen"
                            class="flex items-center gap-1 text-sm font-semibold uppercase tracking-wide text-gray-900 transition-colors focus:outline-none dark:text-white dark:hover:text-white"
                        >
                            ORGANISASI
                            <svg class="h-4 w-4 transition-transform duration-200" :class="orgOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div
                            x-cloak
                            x-show="orgOpen"
                            x-transition:enter="transition ease-out duration-180"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-140"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-2"
                            class="absolute left-0 top-full z-50 mt-2 w-64 rounded-none border border-slate-300 bg-white p-2 shadow-lg dark:border-slate-600 dark:bg-gray-900"
                        >
                            <a href="#" class="block rounded-none px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-slate-100 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white">Pembina</a>
                            <a href="#" class="block rounded-none px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-slate-100 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white">Dewan Kehormatan</a>
                            <a href="#" class="block rounded-none px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-slate-100 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white">Dewan Ambalan</a>
                            <a href="#" class="block rounded-none px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-slate-100 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white">Anggota Dewan</a>
                            <a href="#" class="block rounded-none px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-slate-100 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white">Mitra</a>
                            <a href="#" class="block rounded-none px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-slate-100 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white">Alumni</a>
                        </div>
                    </div>
                    <div
                        class="relative"
                        @mouseenter="clearTimeout(prestasiTimer); prestasiOpen = true; clearTimeout(profileTimer); profileOpen = false; clearTimeout(orgTimer); orgOpen = false; clearTimeout(eventTimer); eventOpen = false"
                        @mouseleave="prestasiTimer = setTimeout(() => prestasiOpen = false, 120)"
                        @click.away="prestasiOpen = false"
                        @focusin="clearTimeout(prestasiTimer); prestasiOpen = true; clearTimeout(profileTimer); profileOpen = false; clearTimeout(orgTimer); orgOpen = false; clearTimeout(eventTimer); eventOpen = false"
                        @focusout="if (!$el.contains($event.relatedTarget)) prestasiTimer = setTimeout(() => prestasiOpen = false, 120)"
                    >
                        <button
                            type="button"
                            @click="prestasiOpen = !prestasiOpen; profileOpen = false; orgOpen = false; eventOpen = false"
                            :aria-expanded="prestasiOpen"
                            class="flex items-center gap-1 text-sm font-semibold uppercase tracking-wide text-gray-900 transition-colors focus:outline-none dark:text-white dark:hover:text-white"
                        >
                            PRESTASI
                            <svg class="h-4 w-4 transition-transform duration-200" :class="prestasiOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div
                            x-cloak
                            x-show="prestasiOpen"
                            x-transition:enter="transition ease-out duration-180"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-140"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-2"
                            class="absolute left-0 top-full z-50 mt-2 w-52 rounded-none border border-slate-300 bg-white p-2 shadow-lg dark:border-slate-600 dark:bg-gray-900"
                        >
                            <a href="#" class="block rounded-none px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-slate-100 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white">Tingkat Ranting</a>
                            <a href="#" class="block rounded-none px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-slate-100 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white">Tingkat Cabang</a>
                            <a href="#" class="block rounded-none px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-slate-100 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white">Tingkat Daerah</a>
                            <a href="#" class="block rounded-none px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-slate-100 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white">Tingkat Nasional</a>
                        </div>
                    </div>
                    <div
                        class="relative"
                        @mouseenter="clearTimeout(eventTimer); eventOpen = true; clearTimeout(profileTimer); profileOpen = false; clearTimeout(orgTimer); orgOpen = false; clearTimeout(prestasiTimer); prestasiOpen = false; clearTimeout(publikasiTimer); publikasiOpen = false"
                        @mouseleave="eventTimer = setTimeout(() => eventOpen = false, 120)"
                        @click.away="eventOpen = false"
                        @focusin="clearTimeout(eventTimer); eventOpen = true; clearTimeout(profileTimer); profileOpen = false; clearTimeout(orgTimer); orgOpen = false; clearTimeout(prestasiTimer); prestasiOpen = false; clearTimeout(publikasiTimer); publikasiOpen = false"
                        @focusout="if (!$el.contains($event.relatedTarget)) eventTimer = setTimeout(() => eventOpen = false, 120)"
                    >
                        <button
                            type="button"
                            @click="eventOpen = !eventOpen; profileOpen = false; orgOpen = false; prestasiOpen = false; publikasiOpen = false"
                            :aria-expanded="eventOpen"
                            class="flex items-center gap-1 text-sm font-semibold uppercase tracking-wide text-gray-900 transition-colors focus:outline-none dark:text-white dark:hover:text-white"
                        >
                            EVENT
                            <svg class="h-4 w-4 transition-transform duration-200" :class="eventOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div
                            x-cloak
                            x-show="eventOpen"
                            x-transition:enter="transition ease-out duration-180"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-140"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-2"
                            class="absolute left-0 top-full z-50 mt-2 w-52 rounded-none border border-slate-300 bg-white p-2 shadow-lg dark:border-slate-600 dark:bg-gray-900"
                        >
                            <a href="#" class="block rounded-none px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-slate-100 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white">Event Internal</a>
                            <a href="#" class="block rounded-none px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-slate-100 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white">Satuan Karya</a>
                            <a href="#" class="block rounded-none px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-slate-100 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white">Perlombaan</a>
                            <a href="#" class="block rounded-none px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-slate-100 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white">Pelantikan</a>
                        </div>
                    </div>
                    <div
                        class="relative"
                        @mouseenter="clearTimeout(publikasiTimer); publikasiOpen = true; clearTimeout(profileTimer); profileOpen = false; clearTimeout(orgTimer); orgOpen = false; clearTimeout(prestasiTimer); prestasiOpen = false; clearTimeout(eventTimer); eventOpen = false"
                        @mouseleave="publikasiTimer = setTimeout(() => publikasiOpen = false, 120)"
                        @click.away="publikasiOpen = false"
                        @focusin="clearTimeout(publikasiTimer); publikasiOpen = true; clearTimeout(profileTimer); profileOpen = false; clearTimeout(orgTimer); orgOpen = false; clearTimeout(prestasiTimer); prestasiOpen = false; clearTimeout(eventTimer); eventOpen = false"
                        @focusout="if (!$el.contains($event.relatedTarget)) publikasiTimer = setTimeout(() => publikasiOpen = false, 120)"
                    >
                        <button
                            type="button"
                            @click="publikasiOpen = !publikasiOpen; profileOpen = false; orgOpen = false; prestasiOpen = false; eventOpen = false"
                            :aria-expanded="publikasiOpen"
                            class="flex items-center gap-1 text-sm font-semibold uppercase tracking-wide text-gray-900 transition-colors focus:outline-none dark:text-white dark:hover:text-white"
                        >
                            Publikasi
                            <svg class="h-4 w-4 transition-transform duration-200" :class="publikasiOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div
                            x-cloak
                            x-show="publikasiOpen"
                            x-transition:enter="transition ease-out duration-180"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-140"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-2"
                            class="absolute left-0 top-full z-50 mt-2 w-44 rounded-none border border-slate-300 bg-white p-2 shadow-lg dark:border-slate-600 dark:bg-gray-900"
                        >
                            <a href="<?php echo e(route('news')); ?>" class="block rounded-none px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-slate-100 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white">Berita</a>
                            <a href="<?php echo e(route('gallery')); ?>" class="block rounded-none px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-slate-100 hover:text-slate-900 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white">Galeri</a>
                        </div>
                    </div>
                    <a href="https://ayopramuka-kwarnas.id/" target="_blank" rel="noopener noreferrer" class="text-sm font-semibold uppercase tracking-wide text-gray-900 transition-colors hover:text-slate-900 dark:text-white dark:hover:text-blue-300">AyoKwarnas</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu (Visible only on mobile) -->
    <div
        id="mobile-menu"
        x-cloak
        x-show="mobileMenuOpen"
        @keydown.escape.window="mobileMenuOpen = false"
        class="lg:hidden fixed inset-0 z-50 overflow-hidden"
    >
        <div class="absolute inset-0 bg-black/30 backdrop-blur-sm transition-opacity" @click="mobileMenuOpen = false"></div>
        <div class="absolute inset-y-0 right-0 w-full max-w-sm bg-white dark:bg-gray-950 shadow-2xl overflow-y-auto border-l border-slate-200 dark:border-slate-800 transition-transform duration-300"
            x-show="mobileMenuOpen"
            x-transition:enter="transition-transform ease-out duration-300"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition-transform ease-in duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
        >
            <div class="px-4 py-4 sm:px-6">
                <div class="flex items-center justify-between">
                    <div class="text-base font-semibold uppercase text-gray-900 dark:text-white">Menu</div>
                    <button
                        type="button"
                        @click="mobileMenuOpen = false"
                        class="rounded-lg p-2 text-gray-600 hover:bg-slate-100 dark:text-gray-300 dark:hover:bg-slate-800 transition-colors"
                        aria-label="Close menu"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="mt-4">
                    <label class="sr-only" for="mobile-search">Cari</label>
                    <div class="flex items-center bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 px-3 py-3 rounded-2xl shadow-sm transition-colors duration-200 focus-within:border-blue-400 dark:focus-within:border-blue-500">
                        <svg class="w-5 h-5 text-slate-400 dark:text-slate-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input
                            id="mobile-search"
                            type="text"
                            placeholder="Cari..."
                            class="bg-transparent text-sm text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-500 focus:outline-none w-full"
                        >
                    </div>
                </div>

                <div class="mt-6 space-y-3 pb-6">
                    <a href="<?php echo e(route('home')); ?>" @click="mobileMenuOpen = false" class="block px-4 py-3 text-base font-semibold uppercase text-gray-900 transition-colors hover:text-slate-900 dark:text-white dark:hover:text-slate-200">BERANDA</a>

                    <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 overflow-hidden">
                        <button type="button" @click="mobileProfilOpen = !mobileProfilOpen" class="w-full flex items-center justify-between px-4 py-3 text-sm font-semibold uppercase text-gray-900 dark:text-white">
                            PROFIL
                            <svg class="h-4 w-4 transition-transform duration-200" :class="mobileProfilOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="mobileProfilOpen" x-transition class="space-y-1 border-t border-slate-200 dark:border-slate-800 px-4 py-2">
                            <a href="<?php echo e(route('about')); ?>" @click="mobileMenuOpen = false" class="block rounded-xl px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">Sejarah</a>
                            <a href="<?php echo e(route('visi-misi')); ?>" @click="mobileMenuOpen = false" class="block rounded-xl px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">Visi &amp; Misi</a>
                            <a href="<?php echo e(route('ambalan')); ?>" @click="mobileMenuOpen = false" class="block rounded-xl px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">Ambalan</a>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 overflow-hidden">
                        <button type="button" @click="mobileAdminOpen = !mobileAdminOpen" class="w-full flex items-center justify-between px-4 py-3 text-sm font-semibold uppercase text-gray-900 dark:text-white">
                            ADMINISTRASI
                            <svg class="h-4 w-4 transition-transform duration-200" :class="mobileAdminOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="mobileAdminOpen" x-transition class="space-y-1 border-t border-slate-200 dark:border-slate-800 px-4 py-2">
                            <a href="<?php echo e(route('absensi.index')); ?>" @click="mobileMenuOpen = false" class="block rounded-xl px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">Absensi</a>
                            <a href="<?php echo e(route('pendaftaran-bantara')); ?>" @click="mobileMenuOpen = false" class="block rounded-xl px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">Pendaftaran Bantara</a>
                            <a href="<?php echo e(route('pendaftaran-laksana')); ?>" @click="mobileMenuOpen = false" class="block rounded-xl px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">Pendaftaran Laksana</a>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 overflow-hidden">
                        <button type="button" @click="mobileOrgOpen = !mobileOrgOpen" class="w-full flex items-center justify-between px-4 py-3 text-sm font-semibold uppercase text-gray-900 dark:text-white">
                            ORGANISASI
                            <svg class="h-4 w-4 transition-transform duration-200" :class="mobileOrgOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="mobileOrgOpen" x-transition class="space-y-1 border-t border-slate-200 dark:border-slate-800 px-4 py-2">
                            <a href="#" @click="mobileMenuOpen = false" class="block rounded-xl px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">Pembina</a>
                            <a href="#" @click="mobileMenuOpen = false" class="block rounded-xl px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">Dewan Kehormatan</a>
                            <a href="#" @click="mobileMenuOpen = false" class="block rounded-xl px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">Dewan Ambalan</a>
                            <a href="#" @click="mobileMenuOpen = false" class="block rounded-xl px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">Anggota Dewan</a>
                            <a href="#" @click="mobileMenuOpen = false" class="block rounded-xl px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">Mitra</a>
                            <a href="#" @click="mobileMenuOpen = false" class="block rounded-xl px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">Alumni</a>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 overflow-hidden">
                        <button type="button" @click="mobilePrestasiOpen = !mobilePrestasiOpen" class="w-full flex items-center justify-between px-4 py-3 text-sm font-semibold uppercase text-gray-900 dark:text-white">
                            PRESTASI
                            <svg class="h-4 w-4 transition-transform duration-200" :class="mobilePrestasiOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="mobilePrestasiOpen" x-transition class="space-y-1 border-t border-slate-200 dark:border-slate-800 px-4 py-2">
                            <a href="#" @click="mobileMenuOpen = false" class="block rounded-xl px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">Tingkat Ranting</a>
                            <a href="#" @click="mobileMenuOpen = false" class="block rounded-xl px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">Tingkat Cabang</a>
                            <a href="#" @click="mobileMenuOpen = false" class="block rounded-xl px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">Tingkat Jateng</a>
                            <a href="#" @click="mobileMenuOpen = false" class="block rounded-xl px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">Tingkat Nasional</a>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 overflow-hidden">
                        <button type="button" @click="mobileEventOpen = !mobileEventOpen" class="w-full flex items-center justify-between px-4 py-3 text-sm font-semibold uppercase text-gray-900 dark:text-white">
                            EVENT
                            <svg class="h-4 w-4 transition-transform duration-200" :class="mobileEventOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="mobileEventOpen" x-transition class="space-y-1 border-t border-slate-200 dark:border-slate-800 px-4 py-2">
                            <a href="#" @click="mobileMenuOpen = false" class="block rounded-xl px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">Event Internal</a>
                            <a href="#" @click="mobileMenuOpen = false" class="block rounded-xl px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">Satuan Karya</a>
                            <a href="#" @click="mobileMenuOpen = false" class="block rounded-xl px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">Perlombaan</a>
                            <a href="#" @click="mobileMenuOpen = false" class="block rounded-xl px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">Pelantikan</a>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 overflow-hidden">
                        <button type="button" @click="mobilePublikasiOpen = !mobilePublikasiOpen" class="w-full flex items-center justify-between px-4 py-3 text-sm font-semibold uppercase text-gray-900 dark:text-white">
                            PUBLIKASI
                            <svg class="h-4 w-4 transition-transform duration-200" :class="mobilePublikasiOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="mobilePublikasiOpen" x-transition class="space-y-1 border-t border-slate-200 dark:border-slate-800 px-4 py-2">
                            <a href="<?php echo e(route('news')); ?>" @click="mobileMenuOpen = false" class="block rounded-xl px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">Berita</a>
                            <a href="<?php echo e(route('gallery')); ?>" @click="mobileMenuOpen = false" class="block rounded-xl px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-slate-100 dark:text-gray-200 dark:hover:bg-slate-800">Galeri</a>
                        </div>
                    </div>

                    <a href="https://ayopramuka-kwarnas.id/" target="_blank" rel="noopener noreferrer" @click="mobileMenuOpen = false" class="block rounded-2xl px-4 py-3 text-base font-semibold uppercase text-gray-900 transition-colors bg-slate-50 hover:bg-slate-100 dark:bg-slate-900 dark:text-white dark:hover:bg-slate-800">AyoKwarnas</a>
                </div>
            </div>
        </div>
    </div>
</nav>
<?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/components/navbar.blade.php ENDPATH**/ ?>