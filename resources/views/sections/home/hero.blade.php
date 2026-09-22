@php
    $heroSlides = [];
    $normalizeHeroImage = function ($image) {
        if (empty($image)) {
            return null;
        }

        $clean = trim((string) $image);

        if ($clean === '') {
            return null;
        }

        if (str_starts_with($clean, 'http://') || str_starts_with($clean, 'https://')) {
            return $clean;
        }

        $clean = ltrim($clean, '/');

        if (str_starts_with($clean, 'storage/')) {
            return asset($clean);
        }

        return asset('storage/' . $clean);
    };

    $heroSettingImages = [];
    foreach ([1, 2, 3] as $slot) {
        $image = $normalizeHeroImage(\App\Models\Setting::getValue('hero_image_' . $slot));

        if ($image) {
            $heroSettingImages[] = $image;
        }
    }

    if (count($heroSettingImages) < 3) {
        $legacyImage = $normalizeHeroImage(\App\Models\Setting::getValue('hero_image'));

        if ($legacyImage && ! in_array($legacyImage, $heroSettingImages, true)) {
            $heroSettingImages[] = $legacyImage;
        }
    }

    if (! empty($heroSettingImages)) {
        $heroSlides = array_map(function ($image) {
            return [
                'image' => $image,
                'title' => 'Hero slide',
                'excerpt' => '',
                'href' => route('news'),
            ];
        }, array_slice($heroSettingImages, 0, 3));
    }

    if (empty($heroSlides) && \Illuminate\Support\Facades\Schema::hasTable('hero_slides')) {
        $heroSlides = \App\Models\HeroSlide::query()
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
                    'excerpt' => $slide->excerpt ?: '',
                    'href' => $slide->href ?: route('news'),
                ];
            })
            ->take(3)
            ->values()
            ->all();
    }

    if (empty($heroSlides)) {
        $heroSlides = [
            ['image' => asset('images/hero/kegiatan-1.jpg'), 'title' => 'Hero 1', 'excerpt' => '', 'href' => route('news')],
            ['image' => asset('images/hero/kegiatan-2.jpg'), 'title' => 'Hero 2', 'excerpt' => '', 'href' => route('news')],
            ['image' => asset('images/hero/kegiatan-3.jpg'), 'title' => 'Hero 3', 'excerpt' => '', 'href' => route('news')],
        ];
    }
@endphp

<section class="relative w-full overflow-hidden bg-white" x-data="heroCarousel()" x-init="init()">
    <div class="relative mx-auto w-full max-w-[1920px] overflow-hidden bg-white" style="aspect-ratio: 1920 / 600;">
        <template x-for="(item, index) in items" :key="index">
            <div class="absolute inset-0 transition-all duration-700 ease-in-out"
                 :class="active === index ? 'translate-x-0 opacity-100 z-10' : 'translate-x-5 opacity-0 z-0'">
                <img :src="item.image" :alt="item.title" class="h-full w-full object-contain bg-white" style="max-height: 600px;">
            </div>
        </template>
    </div>
</section>

<script>
function heroCarousel() {
    return {
        items: @json($heroSlides),
        active: 0,
        timer: null,
        init() {
            if (this.items.length > 0) {
                this.timer = setInterval(() => this.next(), 15000);
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
                this.timer = setInterval(() => this.next(), 15000);
            }
        }
    }
}
</script>