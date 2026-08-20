@extends('layouts.frontend')

@section('title', 'Galeri Visual — Digital Exhibition')

@section('content')

<main
    data-page="gallery"
    class="w-full bg-white text-neutral-900 selection:bg-neutral-900 selection:text-white overflow-x-hidden"
>

    {{-- VIEWPORT 1: HERO (QUIET ENTRY) --}}
    <section id="hero" class="relative w-full h-screen min-h-[650px] flex flex-col justify-center items-center p-6 md:p-12 bg-white text-center overflow-hidden border-b border-neutral-900">
        {{-- Fullscreen Atmospheric Photo --}}
        <figure class="absolute inset-0 w-full h-full z-0 overflow-hidden">
            <img 
                src="https://images.unsplash.com/photo-1510312305653-8ed496efae75?q=80&w=2000&auto=format&fit=crop" 
                alt="Suasana fajar perkemahan" 
                class="w-full h-full object-cover filter grayscale contrast-125 opacity-35"
                loading="eager"
            />
        </figure>

        {{-- Hero Heading & Subheading --}}
        <header class="relative z-10 max-w-5xl mx-auto space-y-6">
            <h1 class="text-5xl md:text-8xl lg:text-9xl font-light tracking-tight uppercase text-white leading-none">
                Langkah Pertama
            </h1>
            <p class="text-sm md:text-base font-serif italic text-neutral-400 tracking-wide max-w-md mx-auto">
                Pameran Visual Pramuka SMK Negeri 1 Bangsri.
            </p>
        </header>

        <!-- TODO: Add subtle scroll-down cursor indicator post-presentation -->
    </section>

    {{-- VIEWPORT 2: FEATURED STORY (SINGLE LANDSCAPE) --}}
    <section id="featured-story" class="w-full min-h-screen flex flex-col justify-center items-center py-20 px-6 md:px-12 lg:px-20 bg-white border-b border-white-900">
        <div class="w-full max-w-7xl mx-auto flex flex-col items-center">
            <figure class="w-full aspect-[16/9] md:aspect-[21/9] overflow-hidden bg-white-900">
                <img 
                    src="https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?q=80&w=2000&auto=format&fit=crop" 
                    alt="Penjelajahan medan luar ruangan" 
                    class="w-full h-full object-cover filter grayscale contrast-125"
                    loading="lazy"
                />
            </figure>

            <h2 class="text-xs md:text-sm font-mono uppercase tracking-[0.4em] text-white-400 mt-8 text-center">
                Menembus Belantara
            </h2>
        </div>
    </section>

    {{-- VIEWPORT 3: HUMAN SPOTLIGHT (PORTRAIT & HIGH NEGATIVE SPACE) --}}
    <section id="human-spotlight" class="w-full min-h-screen flex items-center justify-center py-20 px-6 md:px-12 bg-white border-b border-white-900">
        <div class="w-full max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-12 gap-12 md:gap-20 items-center">
            <figure class="md:col-span-6 md:col-start-2">
                <div class="aspect-[3/4] max-w-xs md:max-w-sm mx-auto overflow-hidden bg-white">
                    <img 
                        src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=1200&auto=format&fit=crop" 
                        alt="Potret anggota Pramuka" 
                        class="w-full h-full object-cover filter grayscale contrast-130"
                        loading="lazy"
                    />
                </div>
            </figure>

            <article class="md:col-span-4 flex flex-col justify-center">
                <blockquote class="text-base md:text-lg font-serif italic text-white-300 leading-relaxed">
                    "Komitmen sejati tidak pernah diucapkan, tetapi selalu ditepati di lapangan."
                </blockquote>
            </article>
        </div>
    </section>

    {{-- VIEWPORT 4: BROTHERHOOD (LANDSCAPE + OFFSET PORTRAIT) --}}
    <section id="brotherhood" class="w-full min-h-screen flex flex-col justify-center py-24 px-6 md:px-16 lg:px-24 bg-white-950 border-b border-white-900">
        <div class="w-full max-w-6xl mx-auto relative">
            <figure class="w-full max-w-4xl aspect-[16/9] overflow-hidden bg-white-900">
                <img 
                    src="https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?q=80&w=1600&auto=format&fit=crop" 
                    alt="Kebersamaan di perkemahan" 
                    class="w-full h-full object-cover filter grayscale contrast-125"
                    loading="lazy"
                />
            </figure>

            <figure class="w-48 md:w-72 aspect-[3/4] overflow-hidden bg-white ml-auto -mt-16 md:-mt-32 mr-0 md:mr-8 relative z-10 border-4 ">
                <img 
                    src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?q=80&w=800&auto=format&fit=crop" 
                    alt="Momen hangat ikatan persaudaraan" 
                    class="w-full h-full object-cover filter grayscale contrast-120"
                    loading="lazy"
                />
            </figure>

            <h2 class="text-xs font-mono uppercase tracking-[0.4em] text-neutral-500 mt-6">
                Ikatan Persaudaraan
            </h2>
        </div>
    </section>

    {{-- VIEWPORT 5: HONOR (CLIMAX FEATURE) --}}
    <section id="honor" class="w-full min-h-screen flex flex-col justify-center items-center py-20 px-6 md:px-12 bg-white border-b border-white text-center">
        <div class="w-full max-w-6xl mx-auto flex flex-col items-center">
            <figure class="w-full aspect-[16/9] md:aspect-[21/9] overflow-hidden bg-white">
                <img 
                    src="https://images.unsplash.com/photo-1532375810709-75b1da00537c?q=80&w=2000&auto=format&fit=crop" 
                    alt="Sakralitas kehormatan upacara" 
                    class="w-full h-full object-cover filter grayscale contrast-130"
                    loading="lazy"
                />
            </figure>

            <h2 class="text-xs md:text-sm font-mono uppercase tracking-[0.4em] text-neutral-300 mt-8">
                Kehormatan Tradisi & Sakralitas Upacara
            </h2>
        </div>
    </section>

    {{-- VIEWPORT 6: ARCHIVE (EDITORIAL MUSEUM LIST) --}}
    <section id="archive" class="w-full min-h-screen flex flex-col justify-center py-24 px-6 md:px-16 lg:px-32 bg-white border-b border-white">
        <div class="w-full max-w-5xl mx-auto">
            <header class="mb-16 border-b border-neutral-900 pb-6">
                <h2 class="text-xs font-mono uppercase tracking-[0.4em] text-neutral-500">
                    Arsip Museum / Catatan Perjalanan
                </h2>
            </header>

            <div class="divide-y divide-neutral-900">
                <!-- TODO: Connect list items to dynamic database loop -->
                <article class="py-6 flex items-center justify-between group hover:px-2 transition-all">
                    <span class="text-xs md:text-sm font-mono text-neutral-500 w-20">2026</span>
                    <h3 class="text-base md:text-xl font-light uppercase text-neutral-200 group-hover:text-white transition-colors flex-1 px-4">
                        Bakti Lingkungan & Kemah Karya
                    </h3>
                    <figure class="w-16 h-12 md:w-24 md:h-16 bg-white overflow-hidden flex-shrink-0">
                        <img 
                            src="https://images.unsplash.com/photo-1516939884455-1445c8652f83?q=80&w=400&auto=format&fit=crop" 
                            alt="Bakti Lingkungan" 
                            class="w-full h-full object-cover filter grayscale opacity-70 group-hover:opacity-100 transition-opacity"
                            loading="lazy"
                        />
                    </figure>
                </article>

                <article class="py-6 flex items-center justify-between group hover:px-2 transition-all">
                    <span class="text-xs md:text-sm font-mono text-neutral-500 w-20">2025</span>
                    <h3 class="text-base md:text-xl font-light uppercase text-neutral-200 group-hover:text-white transition-colors flex-1 px-4">
                        Pelantikan Bantara Penjelajahan Wanarosotan
                    </h3>
                    <figure class="w-16 h-12 md:w-24 md:h-16 bg-white overflow-hidden flex-shrink-0">
                        <img 
                            src="https://images.unsplash.com/photo-1517649763962-0c623266010b?q=80&w=400&auto=format&fit=crop" 
                            alt="Pelantikan Bantara" 
                            class="w-full h-full object-cover filter grayscale opacity-70 group-hover:opacity-100 transition-opacity"
                            loading="lazy"
                        />
                    </figure>
                </article>

                <article class="py-6 flex items-center justify-between group hover:px-2 transition-all">
                    <span class="text-xs md:text-sm font-mono text-neutral-500 w-20">2025</span>
                    <h3 class="text-base md:text-xl font-light uppercase text-neutral-200 group-hover:text-white transition-colors flex-1 px-4">
                        Ekspedisi Navigasi Gunung Muria
                    </h3>
                    <figure class="w-16 h-12 md:w-24 md:h-16 bg-white  overflow-hidden flex-shrink-0">
                        <img 
                            src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?q=80&w=400&auto=format&fit=crop" 
                            alt="Ekspedisi Muria" 
                            class="w-full h-full object-cover filter grayscale opacity-70 group-hover:opacity-100 transition-opacity"
                            loading="lazy"
                        />
                    </figure>
                </article>

                <article class="py-6 flex items-center justify-between group hover:px-2 transition-all">
                    <span class="text-xs md:text-sm font-mono text-neutral-500 w-20">2024</span>
                    <h3 class="text-base md:text-xl font-light uppercase text-neutral-200 group-hover:text-white transition-colors flex-1 px-4">
                        Gelar Ketangkasan Pionering Utama
                    </h3>
                    <figure class="w-16 h-12 md:w-24 md:h-16 bg-white overflow-hidden flex-shrink-0">
                        <img 
                            src="https://images.unsplash.com/photo-1526772662000-3f88f10405ff?q=80&w=400&auto=format&fit=crop" 
                            alt="Gelar Ketangkasan" 
                            class="w-full h-full object-cover filter grayscale opacity-70 group-hover:opacity-100 transition-opacity"
                            loading="lazy"
                        />
                    </figure>
                </article>
            </div>
        </div>
    </section>

    {{-- VIEWPORT 7: CLOSING (FULLSCREEN HERO & SINGLE CTA) --}}
    <section id="closing" class="relative w-full h-screen min-h-[650px] flex flex-col justify-center items-center p-6 md:p-12 bg-white text-center overflow-hidden">
        <figure class="absolute inset-0 w-full h-full z-0 overflow-hidden">
            <img 
                src="https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?q=80&w=2000&auto=format&fit=crop" 
                alt="Siluet horizon penutup" 
                class="w-full h-full object-cover filter grayscale contrast-130 opacity-30"
                loading="lazy"
            />
        </figure>

        <div class="relative z-10 max-w-4xl mx-auto space-y-10">
            <h2 class="text-4xl md:text-7xl lg:text-8xl font-light uppercase tracking-tight text-white leading-tight">
                Cerita Masa Depan
            </h2>
            
            <div>
                <a href="/profil" class="inline-block px-8 py-4 border border-neutral-400 text-xs font-mono uppercase tracking-[0.3em] text-white hover:bg-white hover:text-black hover:border-white transition-all">
                    Jelajahi Profil
                </a>
            </div>
        </div>
        

        <!-- TODO: Integrate modal lightboxes post-presentation if required -->
    </section>

</main>

@endsection