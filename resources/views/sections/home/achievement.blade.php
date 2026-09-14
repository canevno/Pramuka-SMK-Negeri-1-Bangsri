<section id="prestasi" class="py-16 sm:py-20 bg-white dark:bg-gray-950 transition-colors duration-200">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white font-['Poppins'] mb-3 tracking-tight">
                PRESTASI
            </h2>
            <p class="text-slate-600 dark:text-slate-400 text-base max-w-2xl mx-auto">
                Pencapaian dan penghargaan yang telah diraih oleh civitas akademika SMK Negeri 1 Bangsri.
            </p>
        </div>

        <!-- Category Navigation Buttons (Monochrome) -->
        <div class="mb-12 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
            <a href="{{ route('prestasi.ranting') }}" class="rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-gray-900 px-4 py-3 text-center text-sm font-semibold text-slate-800 dark:text-slate-200 transition hover:bg-slate-900 hover:text-white dark:hover:bg-white dark:hover:text-slate-900">
                Tingkat Ranting
            </a>
            <a href="{{ route('prestasi.cabang') }}" class="rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-gray-900 px-4 py-3 text-center text-sm font-semibold text-slate-800 dark:text-slate-200 transition hover:bg-slate-900 hover:text-white dark:hover:bg-white dark:hover:text-slate-900">
                Tingkat Cabang
            </a>
            <a href="{{ route('prestasi.jateng') }}" class="rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-gray-900 px-4 py-3 text-center text-sm font-semibold text-slate-800 dark:text-slate-200 transition hover:bg-slate-900 hover:text-white dark:hover:bg-white dark:hover:text-slate-900">
                Tingkat Jateng
            </a>
            <a href="{{ route('prestasi.nasional') }}" class="rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-gray-900 px-4 py-3 text-center text-sm font-semibold text-slate-800 dark:text-slate-200 transition hover:bg-slate-900 hover:text-white dark:hover:bg-white dark:hover:text-slate-900">
                Tingkat Nasional
            </a>
        </div>

        @php
            $achievements = App\Support\AchievementStore::all();
        @endphp

        <!-- Achievement Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($achievements as $achievement)
                <article class="bg-white dark:bg-gray-900 rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden flex flex-col h-full transition hover:border-slate-400 dark:hover:border-slate-600">
                    <!-- Card Image -->
                    <div class="h-44 bg-slate-100 dark:bg-slate-800 flex-shrink-0">
                        <img src="{{ asset($achievement['image'] ?? 'images/achievement/prestasi1.jpg') }}" 
                             alt="{{ $achievement['title'] }}" 
                             class="w-full h-full object-cover"
                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($achievement['title']) }}&background=1e293b&color=fff&size=400'">
                    </div>
                    
                    <!-- Card Content -->
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="font-bold text-slate-900 dark:text-white text-base leading-snug mb-1 line-clamp-2">
                            {{ $achievement['title'] }}
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-3">
                            {{ $achievement['category'] }} — {{ $achievement['year'] }}
                        </p>
                        <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed flex-grow line-clamp-3">
                            {{ $achievement['description'] }}
                        </p>
                        
                        <!-- Bottom Link -->
                        <div class="pt-3 mt-4 border-t border-slate-100 dark:border-slate-800">
                            <span class="text-xs font-medium text-slate-500 dark:text-slate-400">
                                Lihat Detail →
                            </span>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>