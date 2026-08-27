@extends('layouts.frontend')

@section('content')
<section class="py-20 bg-white transition-colors duration-200">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <p class="text-xs uppercase tracking-[0.35em] font-semibold text-slate-500">Berita Pramuka</p>
            <h1 class="mt-6 text-4xl sm:text-5xl font-bold tracking-tight text-slate-900 max-w-4xl mx-auto">Kabar Kegiatan dan Prestasi Terbaru</h1>
            <p class="mt-5 max-w-2xl mx-auto text-sm leading-7 text-slate-500">Ikuti berita terbaru dari kegiatan, lomba, dan program pengembangan karakter anggota Pramuka SMK Negeri 1 Bangsri.</p>
        </div>

        <div class="grid gap-8 md:grid-cols-[minmax(0,1fr)_minmax(0,1fr)] lg:grid-cols-[1.1fr_1.8fr_0.9fr]">
            <!-- Hero center on desktop, top on tablet/mobile -->
            <article class="order-1 md:col-span-2 lg:order-2 lg:col-span-1 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-300 hover:shadow-md">
                <div class="px-6 py-4">
                    <p class="text-[10px] uppercase tracking-[0.35em] font-semibold text-slate-400">Article</p>
                </div>
                <div class="overflow-hidden">
                    <img src="{{ asset('images/hero/imagehero1.png') }}" alt="Membangun Karakter Melalui Disiplin Kepanduan" class="w-full h-[340px] object-cover transition duration-500 hover:scale-105">
                </div>
                <div class="px-6 py-6 text-left">
                    <h2 class="text-3xl sm:text-4xl font-bold leading-tight text-slate-900">Membangun Karakter Melalui Disiplin Kepanduan</h2>
                    <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-500">Pramuka SMK Negeri 1 Bangsri memperkuat karakter generasi muda melalui kegiatan disiplin kepanduan, latihan lapangan, dan nilai-nilai kebersamaan.</p>
                    <div class="mt-6 flex items-center gap-2 text-xs text-slate-400 uppercase tracking-[0.2em]">
                        <span>21 Juli 2026</span>
                        <span class="inline-flex h-0.5 w-0.5 rounded-full bg-slate-300"></span>
                        <span>5 menit baca</span>
                    </div>
                </div>
            </article>

            <!-- Left column cards -->
            <div class="space-y-4 order-2 lg:order-1">
                <article class="group overflow-hidden rounded-none border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-md cursor-pointer">
                    <div class="flex flex-col gap-3 p-4 md:flex-row md:items-center">
                        <div class="min-w-0 flex-1">
                            <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-slate-500">Kegiatan</p>
                            <h3 class="mt-2 text-lg font-semibold leading-tight text-slate-900">Persiapan Jambore Cabang Jepara 2024</h3>
                            <p class="mt-2 text-[11px] text-slate-400 uppercase tracking-[0.2em]">Januari 3, 2024</p>
                        </div>
                        <div class="h-32 w-full overflow-hidden bg-slate-100 md:w-32 md:h-32">
                            <img src="{{ asset('images/hero/imagehero.png') }}" alt="Persiapan Jambore Cabang" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        </div>
                    </div>
                </article>

                <article class="group overflow-hidden rounded-none border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-md cursor-pointer">
                    <div class="flex flex-col gap-3 p-4 md:flex-row md:items-center">
                        <div class="min-w-0 flex-1">
                            <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-slate-500">Pelatihan</p>
                            <h3 class="mt-2 text-lg font-semibold leading-tight text-slate-900">Pelatihan Dasar Bantara</h3>
                            <p class="mt-2 text-[11px] text-slate-400 uppercase tracking-[0.2em]">Februari 12, 2024</p>
                        </div>
                        <div class="h-32 w-full overflow-hidden bg-slate-100 md:w-32 md:h-32">
                            <img src="{{ asset('images/logokegiatan1.png') }}" alt="Pelatihan Dasar Bantara" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        </div>
                    </div>
                </article>
            </div>

            <!-- Right column popular list -->
            <aside class="space-y-6 order-3 lg:order-3">
                <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-slate-900">Berita Populer</h2>
                        <p class="mt-3 text-sm leading-6 text-slate-500">Artikel yang paling banyak dibaca oleh komunitas kami.</p>
                    </div>
                    <div class="divide-y divide-slate-200 px-6">
                        <a href="#" class="flex items-center gap-4 py-5 transition hover:text-slate-900">
                            <div class="min-w-0 flex-1">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-slate-500">Kegiatan</p>
                                <h3 class="mt-2 text-sm font-semibold leading-tight text-slate-900">Penerimaan Tamu Ambalan 2024 Berlangsung Meriah</h3>
                                <p class="mt-2 text-xs text-slate-400">Januari 12, 2024</p>
                            </div>
                            <div class="h-16 w-24 overflow-hidden rounded-2xl bg-slate-100">
                                <img src="{{ asset('images/logokegiatan2.png') }}" alt="Penerimaan Tamu Ambalan" class="h-full w-full object-cover">
                            </div>
                        </a>
                        <a href="#" class="flex items-center gap-4 py-5 transition hover:text-slate-900">
                            <div class="min-w-0 flex-1">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-slate-500">Prestasi</p>
                                <h3 class="mt-2 text-sm font-semibold leading-tight text-slate-900">Prestasi Pramuka SMK Negeri 1 Bangsri</h3>
                                <p class="mt-2 text-xs text-slate-400">Maret 8, 2024</p>
                            </div>
                            <div class="h-16 w-24 overflow-hidden rounded-2xl bg-slate-100">
                                <img src="{{ asset('images/hero/imagehero1.png') }}" alt="Prestasi Pramuka" class="h-full w-full object-cover">
                            </div>
                        </a>
                        <a href="#" class="flex items-center gap-4 py-5 transition hover:text-slate-900">
                            <div class="min-w-0 flex-1">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-slate-500">Kepanduan</p>
                                <h3 class="mt-2 text-sm font-semibold leading-tight text-slate-900">Lomba Kepramukaan dan Penguatan Karakter</h3>
                                <p class="mt-2 text-xs text-slate-400">April 16, 2024</p>
                            </div>
                            <div class="h-16 w-24 overflow-hidden rounded-2xl bg-slate-100">
                                <img src="{{ asset('images/logo/smklogo.png') }}" alt="Lomba Kepramukaan" class="h-full w-full object-cover">
                            </div>
                        </a>
                        <a href="#" class="flex items-center gap-4 py-5 transition hover:text-slate-900">
                            <div class="min-w-0 flex-1">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-slate-500">Kegiatan</p>
                                <h3 class="mt-2 text-sm font-semibold leading-tight text-slate-900">Kegiatan Bakti Lingkungan dan Aksi Sosial Donor Darah</h3>
                                <p class="mt-2 text-xs text-slate-400">Mei 5, 2024</p>
                            </div>
                            <div class="h-16 w-24 overflow-hidden rounded-2xl bg-slate-100">
                                <img src="{{ asset('images/hero/imagehero.png') }}" alt="Bakti Lingkungan" class="h-full w-full object-cover">
                            </div>
                        </a>
                        <a href="#" class="flex items-center gap-4 py-5 transition hover:text-slate-900">
                            <div class="min-w-0 flex-1">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-slate-500">Perkemahan</p>
                                <h3 class="mt-2 text-sm font-semibold leading-tight text-slate-900">Perkemahan Blok dan Pelantikan Bantara Laksana</h3>
                                <p class="mt-2 text-xs text-slate-400">Juli 28, 2024</p>
                            </div>
                            <div class="h-16 w-24 overflow-hidden rounded-2xl bg-slate-100">
                                <img src="{{ asset('images/logos/smklogo.png') }}" alt="Perkemahan Blok" class="h-full w-full object-cover">
                            </div>
                        </a>
                    </div>
                </div>
            </aside>
        </div>

        <section class="mt-16">
            <div class="grid gap-0.5 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
                @foreach ($newsItems as $item)
                    <article class="mx-auto w-full max-w-[260px] overflow-hidden rounded-none border border-slate-200 bg-white shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-lg">
                        <div class="h-[8rem] overflow-hidden bg-slate-100">
                            <img src="{{ asset($item['image']) }}" alt="{{ $item['alt'] }}" class="h-full w-full object-cover">
                        </div>
                        <div class="p-2.5 space-y-2">
                            <p class="text-[7px] font-semibold uppercase tracking-[0.3em] text-slate-500">{{ $item['category'] }}</p>
                            <h3 class="text-sm font-semibold leading-snug text-slate-900">{{ $item['title'] }}</h3>
                            <p class="text-[8px] uppercase tracking-[0.25em] text-slate-400">{{ $item['date'] }}</p>
                            <p class="text-[11px] leading-5 text-slate-600">{{ $item['description'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    </div>
</section>
@endsection
