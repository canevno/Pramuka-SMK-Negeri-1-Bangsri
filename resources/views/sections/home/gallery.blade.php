<section class="py-24 bg-white dark:bg-gray-950 transition-colors duration-200">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-2">
                Galleri Kegiatan
            </h2>
        </div>

        <!-- Main Gallery Layout -->
        <div class="hidden lg:grid lg:grid-cols-12 gap-8 items-start">
            <!-- Left: Images Grid (75-80%) -->
            <div class="col-span-9">
                <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-4">Kegiatan Bulan Agustus 2026</p>
                <div class="grid grid-cols-3 gap-4">
                    <img src="{{ asset('images/gallery/g1 (1).jpeg') }}" 
                         alt="Gallery 1"
                         class="w-full h-48 object-cover border-2 border-slate-300 dark:border-slate-500 hover:scale-105 transition-transform duration-300">
                    <img src="{{ asset('images/gallery/g1 (2).jpeg') }}" 
                         alt="Gallery 2"
                         class="w-full h-48 object-cover border-2 border-slate-300 dark:border-slate-500 hover:scale-105 transition-transform duration-300">
                    <img src="{{ asset('images/gallery/g1 (3).jpeg') }}" 
                         alt="Gallery 3"
                         class="w-full h-48 object-cover border-2 border-slate-300 dark:border-slate-500 hover:scale-105 transition-transform duration-300">
                    <img src="{{ asset('images/gallery/g1 (4).jpeg') }}" 
                         alt="Gallery 4"
                         class="w-full h-48 object-cover border-2 border-slate-300 dark:border-slate-500 hover:scale-105 transition-transform duration-300">
                    <img src="{{ asset('images/gallery/g1 (5).jpeg') }}" 
                         alt="Gallery 5"
                         class="w-full h-48 object-cover border-2 border-slate-300 dark:border-slate-500 hover:scale-105 transition-transform duration-300">
                    <img src="{{ asset('images/gallery/g1 (6).jpeg') }}" 
                         alt="Gallery 6"
                         class="w-full h-48 object-cover border-2 border-slate-300 dark:border-slate-500 hover:scale-105 transition-transform duration-300">
                </div>
            </div>

            <!-- Right: Content & Timeline (20-25%) -->
            <div class="col-span-3 border-l-2 border-slate-300 dark:border-slate-500 pl-8">
                <div class="space-y-6">
                    <div>
                        <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-1">
                            Kebersamaan
                        </h3>
                        <p class="text-lg font-bold text-gray-800 dark:text-gray-200">
                            Kami Dalam
                        </p>
                        <p class="text-lg font-bold text-gray-700 dark:text-gray-300">
                            Berbagai Kegiatan
                        </p>
                    </div>

                    <!-- Timeline -->
                    <div class="pt-4">
                        <p class="text-gray-700 dark:text-gray-400 text-xs leading-relaxed mb-4">
                            Dokumentasi momen kebersamaan dalam berbagai kegiatan pramuka yang menunjukkan antusiasme dan dedikasi seluruh anggota.
                        </p>
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 bg-gray-800 dark:bg-gray-400 rounded-full"></div>
                            <p class="text-sm font-bold text-gray-800 dark:text-gray-200">Tahun 2025 - 2026</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Layout -->
        <div class="lg:hidden space-y-6">
            <!-- Label -->
            <p class="text-sm font-semibold text-gray-600 dark:text-gray-400">Dokumentasi Kegiatan</p>
            
            <!-- Images Grid Mobile -->
            <div class="grid grid-cols-3 gap-3">
                <img src="{{ asset('images/gallery/g1 (1).jpeg') }}" alt="Gallery 1" class="w-full h-28 object-cover border-2 border-slate-300 dark:border-slate-500">
                <img src="{{ asset('images/gallery/g1 (2).jpeg') }}" alt="Gallery 2" class="w-full h-28 object-cover border-2 border-slate-300 dark:border-slate-500">
                <img src="{{ asset('images/gallery/g1 (3).jpeg') }}" alt="Gallery 3" class="w-full h-28 object-cover border-2 border-slate-300 dark:border-slate-500">
                <img src="{{ asset('images/gallery/g1 (4).jpeg') }}" alt="Gallery 4" class="w-full h-28 object-cover border-2 border-slate-300 dark:border-slate-500">
                <img src="{{ asset('images/gallery/g1 (5).jpeg') }}" alt="Gallery 5" class="w-full h-28 object-cover border-2 border-slate-300 dark:border-slate-500">
                <img src="{{ asset('images/gallery/g1 (6).jpeg') }}" alt="Gallery 6" class="w-full h-28 object-cover border-2 border-slate-300 dark:border-slate-500">
            </div>

            <!-- Content Mobile -->
            <div class="space-y-4 border-l-2 border-slate-300 dark:border-slate-500 pl-4">
                <div>
                    <h3 class="text-xl font-black text-gray-900 dark:text-white mb-1">
                        Kebersamaan
                    </h3>
                    <p class="text-base font-bold text-gray-800 dark:text-gray-200">
                        Kami Dalam Berbagai Kegiatan
                    </p>
                </div>

                <!-- Timeline Mobile -->
                <div>
                    <p class="text-gray-700 dark:text-gray-400 text-xs mb-3 leading-relaxed">
                        Dokumentasi momen kebersamaan dalam berbagai kegiatan pramuka yang menunjukkan antusiasme dan dedikasi seluruh anggota.
                    </p>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 bg-gray-800 dark:bg-gray-400 rounded-full"></div>
                        <p class="text-sm font-bold text-gray-800 dark:text-gray-200">Tahun 2026</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Show More Button -->
        <div class="text-center mt-16">
            <a href="/galeri" class="inline-block px-8 py-3 border-2 border-slate-300 dark:border-slate-500 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:border-blue-600 dark:hover:border-blue-400 font-semibold transition-colors">
                Tampilkan Selengkapnya
            </a>
        </div>
    </div>
</section>
