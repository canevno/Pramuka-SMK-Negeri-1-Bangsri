@php
    $achievements = App\Support\AchievementStore::all();
@endphp

<section class="bg-white pt-8 pb-10 dark:bg-slate-950 transition-colors duration-200">
    <div class="mx-auto max-w-[1400px] px-2 sm:px-4 lg:px-6">
        <div class="mb-6 pb-4 text-center">
            <h2 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                Prestasi Pangkalan SMKN 1 Bangsri
            </h2>
            <p class="mx-auto mt-3 max-w-2xl text-sm text-slate-600 dark:text-slate-300">
                Kumpulan capaian dan kebanggaan siswa dari berbagai kegiatan dan lomba yang telah diraih.
            </p>
        </div>

        @if ($achievements)
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                @foreach ($achievements as $achievement)
                    @php
                        $image = $achievement['image'] ?? 'images/achievement/prestasi1.jpg';
                        $image = preg_replace('#^/?public/?#i', '', $image, 1) ?? $image;
                        $image = preg_replace('#^/?storage/?#i', '', $image, 1) ?? $image;
                        $image = preg_replace('#^/?storage/?#i', '', $image, 1) ?? $image;
                        $image = ltrim($image, '/');
                        $imageUrl = match (true) {
                            empty($image) => asset('images/achievement/prestasi1.jpg'),
                            filter_var($image, FILTER_VALIDATE_URL) => $image,
                            str_starts_with($image, 'storage/') => asset($image),
                            str_starts_with($image, 'images/') => asset($image),
                            default => asset('storage/' . ltrim($image, '/')),
                        };

                        // Tanggal: pakai 'date' jika ada, kalau tidak tampilkan tahun saja
                        try {
                            $dateLabel = ! empty($achievement['date'])
                                ? \Illuminate\Support\Carbon::parse($achievement['date'])->translatedFormat('d F Y')
                                : ($achievement['year'] ?? now()->year);
                        } catch (\Throwable $e) {
                            $dateLabel = $achievement['date'] ?? ($achievement['year'] ?? now()->year);
                        }

                        $location  = $achievement['location'] ?? null;
                        $instagram = $achievement['winner_social_link'] ?? null;
                        $detailUrl = route('prestasi', ['id' => $achievement['id'] ?? null]);
                    @endphp

                    <article class="group flex cursor-default flex-col overflow-hidden rounded-lg border border-slate-400 bg-white shadow-sm dark:border-slate-600 dark:bg-slate-900">
                        <div class="relative aspect-[16/11] w-full overflow-hidden bg-slate-100 dark:bg-slate-800">
                            <span class="absolute left-3 top-3 z-10 rounded bg-[#0D1B2A] px-2 py-1 text-[10px] font-black uppercase tracking-wider text-white">
                                {{ $achievement['year'] ?? now()->year }}
                            </span>

                            <img src="{{ $imageUrl }}" alt="{{ $achievement['title'] }}" class="h-full w-full object-cover">
                        </div>

                        <div class="flex flex-1 flex-col p-3.5 sm:p-4">
                            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-[#0D1B2A] dark:text-[#b9d6ff]">
                                {{ $achievement['category'] ?? 'Prestasi' }}
                            </p>

                            <h3 class="mt-2 text-sm font-bold leading-snug text-slate-900 line-clamp-2 dark:text-white sm:text-[0.96rem]">
                                {{ $achievement['title'] }}
                            </h3>

                            <div class="mt-3 space-y-2 pt-1 text-[11px] text-slate-600 dark:text-slate-300">
                                <div class="flex items-center gap-2">
                                    <svg class="h-3.5 w-3.5 shrink-0 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M8 2v3M16 2v3M3.5 9.5h17M5 5.5h14a1.5 1.5 0 011.5 1.5v11A1.5 1.5 0 0119 19.5H5A1.5 1.5 0 013.5 18V7A1.5 1.5 0 015 5.5z"/>
                                    </svg>
                                    <span class="font-medium">{{ $dateLabel }}</span>
                                </div>

                                @if ($location)
                                    <div class="flex items-center gap-2">
                                        <svg class="h-3.5 w-3.5 shrink-0 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M12 21s6-5.686 6-11a6 6 0 10-12 0c0 5.314 6 11 6 11z"/>
                                            <circle cx="12" cy="10" r="2.5"/>
                                        </svg>
                                        <span class="truncate">{{ $location }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-auto flex items-center gap-2 pt-3">
                                @if (! empty($instagram))
                                    <a href="{{ $instagram }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram"
                                       class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-slate-300 bg-white text-slate-600 transition hover:border-[#0D1B2A] hover:text-[#0D1B2A] dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300 dark:hover:border-[#b9d6ff] dark:hover:text-[#b9d6ff]">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                                        </svg>
                                    </a>
                                @endif

                                <a href="{{ $detailUrl }}"
                                   class="flex h-9 flex-1 items-center justify-center gap-1 rounded-xl bg-[#0D1B2A] px-3 text-[11px] font-bold text-white transition hover:bg-slate-700 dark:bg-[#b9d6ff] dark:text-[#0D1B2A] dark:hover:bg-white">
                                    Lihat Lengkap
                                    <span class="text-sm leading-none">&rsaquo;</span>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center dark:border-slate-700 dark:bg-slate-900">
                <p class="text-base font-semibold text-slate-900 dark:text-white">Belum ada data prestasi</p>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Data prestasi akan muncul di sini setelah ditambahkan oleh admin.</p>
            </div>
        @endif
    </div>
</section>