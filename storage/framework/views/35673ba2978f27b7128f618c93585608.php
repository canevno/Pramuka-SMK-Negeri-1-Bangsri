<?php
    $heroItems = [];

    if (\Illuminate\Support\Facades\Schema::hasTable('hero_slides')) {
        $heroItems = \App\Models\HeroSlide::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get()
            ->map(function ($slide) {
                $image = $slide->image;
                if (! empty($image) && ! str_starts_with($image, 'http')) {
                    $image = asset($image);
                }

                return [
                    'image' => $image ?: asset('images/hero/kegiatan-1.jpg'),
                    'title' => $slide->title ?: 'Judul Slide',
                    'excerpt' => $slide->excerpt ?: 'Deskripsi slide hero belum diisi.',
                    'href' => $slide->href ?: route('news'),
                ];
            })
            ->values()
            ->all();
    }

    if (empty($heroItems)) {
        $heroItems = [
            ['image' => asset('images/hero/kegiatan-1.jpg'), 'title' => 'Upacara Pelantikan Ambalan Tahun Ajaran Baru', 'excerpt' => 'Prosesi pelantikan anggota baru Ambalan KH. Achmad Fauzan dan Dewi Sartika berlangsung khidmat di lapangan upacara SMK Negeri 1 Bangsri.', 'href' => route('news')],
            ['image' => asset('images/hero/kegiatan-2.jpg'), 'title' => 'Jadi Pengusaha Digital Tak Perlu Tunggu Lulus Sekolah', 'excerpt' => 'Peluang usaha digital dapat dimulai sejak dini, sambil belajar dan membangun kemandirian melalui kreativitas dan teknologi.', 'href' => route('news')],
            ['image' => asset('images/hero/kegiatan-3.jpg'), 'title' => 'Latihan Kepemimpinan dan Kedisiplinan Ambalan', 'excerpt' => 'Peserta didik mengikuti sesi pelatihan kepemimpinan, kerja sama, dan tanggung jawab dalam membentuk karakter yang kuat.', 'href' => route('news')],
            ['image' => asset('images/hero/kegiatan-4.jpg'), 'title' => 'Program Pemberdayaan Siswa untuk Kemandirian', 'excerpt' => 'Berbagai kegiatan produktif mendorong siswa untuk belajar mandiri, berinovasi, dan siap menghadapi tantangan masa depan.', 'href' => route('news')],
            ['image' => asset('images/hero/kegiatan-5.jpg'), 'title' => 'Semangat Kebersamaan dalam Kegiatan Sekolah', 'excerpt' => 'Kegiatan komunitas dan ekstrakurikuler memberi ruang bagi siswa untuk berkembang secara sosial, akademik, dan karakter.', 'href' => route('news')],
        ];
    }
?>

<section class="relative w-full overflow-hidden bg-gray-950" x-data="heroCarousel()" x-init="init()">
    <div class="relative aspect-[7.8/10] w-full sm:aspect-[16/9] lg:aspect-[21/9]">
        <template x-for="(item, index) in items" :key="index">
            <div x-show="active === index"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-500"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute inset-0">

                <img :src="item.image" :alt="item.title" class="absolute inset-0 h-full w-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-black/10"></div>

                <div class="absolute inset-0 flex items-center justify-center px-4 sm:px-12 lg:px-20">
                    <div class="w-full max-w-[270px] -translate-y-1 text-center sm:max-w-4xl">
                        <h1 class="font-sans text-[1.9rem] font-extrabold leading-[1.02] tracking-tight text-white sm:text-3xl lg:text-5xl"
                            x-text="item.title"></h1>

                        <p class="mx-auto mt-3 max-w-[17.5rem] text-[11px] font-medium leading-relaxed text-gray-200 sm:max-w-2xl sm:text-base"
                           x-text="item.excerpt"></p>

                        <a :href="item.href"
                           class="mt-4 inline-flex items-center justify-center gap-2 text-[11px] font-semibold text-white transition-all duration-200 hover:gap-3 sm:text-sm">
                            Baca Selengkapnya
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </template>

        <button @click="prev()" aria-label="Sebelumnya"
                class="absolute left-2 top-1/2 z-10 -translate-y-1/2 rounded-full bg-black/15 p-2 text-white/80 transition-colors hover:text-white sm:left-3">
            <svg class="h-6 w-6 sm:h-7 sm:w-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <button @click="next()" aria-label="Berikutnya"
                class="absolute right-2 top-1/2 z-10 -translate-y-1/2 rounded-full bg-black/15 p-2 text-white/80 transition-colors hover:text-white sm:right-3">
            <svg class="h-6 w-6 sm:h-7 sm:w-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        <div class="absolute bottom-4 left-1/2 z-10 flex -translate-x-1/2 gap-2">
            <template x-for="(item, index) in items" :key="'dot-'+index">
                <button @click="goTo(index)"
                        :aria-label="'Slide ' + (index + 1)"
                        class="h-2 rounded-full transition-all duration-300"
                        :class="active === index ? 'w-6 bg-white' : 'w-2 bg-white/40 hover:bg-white/60'"></button>
            </template>
        </div>
    </div>
</section>

<script>
function heroCarousel() {
    return {
        items: <?php echo json_encode($heroItems, 15, 512) ?>,
        active: 0,
        timer: null,
        init() {
            if (this.items.length > 0) {
                this.timer = setInterval(() => this.next(), 10000);
            }
        },
        next() {
            if (this.items.length === 0) return;
            this.active = (this.active + 1) % this.items.length;
            this.resetTimer();
        },
        prev() {
            if (this.items.length === 0) return;
            this.active = (this.active - 1 + this.items.length) % this.items.length;
            this.resetTimer();
        },
        goTo(index) {
            if (this.items.length === 0) return;
            this.active = index;
            this.resetTimer();
        },
        resetTimer() {
            clearInterval(this.timer);
            if (this.items.length > 0) {
                this.timer = setInterval(() => this.next(), 10000);
            }
        }
    }
}
</script><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/sections/home/hero.blade.php ENDPATH**/ ?>