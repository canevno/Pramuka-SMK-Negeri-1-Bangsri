@extends('layouts.frontend')

@section('content')
    <!-- Hero -->
    <section class="bg-white text-slate-950">
        <div class="mx-auto max-w-6xl px-6 py-16 sm:px-8 sm:py-20 lg:px-10 lg:py-24">
            <div class="grid gap-10 lg:grid-cols-2 lg:items-center">
                <div>
                    <p class="text-sm uppercase tracking-[0.4em] text-slate-500">Tentang Kami</p>
                    <h1 class="mt-4 text-4xl font-bold tracking-tight text-slate-950 sm:text-5xl font-poppins">
                        Pramuka SMK Negeri 1 Bangsri
                    </h1>
                    <p class="mt-6 max-w-2xl text-base leading-8 text-slate-600 sm:text-lg">
                        Gugus Depan 03.161 &amp; 03.162 adalah wadah pembentukan karakter dan kepemimpinan generasi muda. Berada di Jl. KH. Achmad Fauzan No. 17 Krasak, Jepara, kami fokus pada disiplin, tanggung jawab, dan kepedulian sosial.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="#visi-misi" class="rounded-full border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-slate-100">
                            Visi &amp; Misi
                        </a>
                        <a href="#kegiatan" class="rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                            Kegiatan &amp; Galeri
                        </a>
                    </div>
                </div>

                <div class="flex justify-center">
                    <div class="w-full overflow-hidden rounded-3xl border border-slate-200/80 bg-slate-100 shadow-sm sm:max-w-md">
                        <img src="{{ asset('images/hero/imagehero1.png') }}" alt="Pramuka activity" class="w-full h-auto object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision & Mission -->
    <section id="visi-misi" class="bg-slate-50 text-slate-950">
        <div class="mx-auto max-w-6xl px-6 py-16 sm:px-8 lg:px-10">
            <div class="grid gap-8 lg:grid-cols-3 lg:gap-10">
                <div class="lg:col-span-1">
                    <p class="text-sm uppercase tracking-[0.4em] text-slate-500">Nilai Inti</p>
                    <h2 class="mt-4 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">
                        Visi dan misi kami dalam satu pandangan.
                    </h2>
                </div>

                <div class="lg:col-span-2 space-y-6">
                    <div class="rounded-3xl bg-white p-8 shadow-sm shadow-slate-200/40">
                        <p class="text-sm uppercase tracking-[0.35em] text-slate-500">Visi</p>
                        <p class="mt-4 text-lg leading-8 text-slate-700">
                            Menjadi pramuka sekolah yang berkarakter, berwawasan, dan berkontribusi positif bagi masyarakat.
                        </p>
                    </div>
                    <div class="rounded-3xl bg-white p-8 shadow-sm shadow-slate-200/40">
                        <p class="text-sm uppercase tracking-[0.35em] text-slate-500">Misi</p>
                        <ul class="mt-4 space-y-3 text-base leading-7 text-slate-700">
                            <li>Menanamkan nilai kepramukaan dalam kehidupan sehari-hari.</li>
                            <li>Menyelenggarakan pembinaan dan pelatihan yang konsisten.</li>
                            <li>Mendorong kepedulian sosial dan pelestarian lingkungan.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="bg-white text-slate-950">
        <div class="mx-auto max-w-6xl px-6 py-16 sm:px-8 lg:px-10">
            <div class="grid gap-4 sm:grid-cols-3">
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-8 text-center">
                    <p class="text-4xl font-bold text-slate-950">8+</p>
                    <p class="mt-3 text-sm uppercase tracking-[0.35em] text-slate-500">Tahun aktif</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-8 text-center">
                    <p class="text-4xl font-bold text-slate-950">2</p>
                    <p class="mt-3 text-sm uppercase tracking-[0.35em] text-slate-500">Ambalan utama</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-8 text-center">
                    <p class="text-4xl font-bold text-slate-950">300+</p>
                    <p class="mt-3 text-sm uppercase tracking-[0.35em] text-slate-500">Anggota dan alumni</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Activities -->
    <section id="kegiatan" class="bg-slate-950 text-white">
        <div class="mx-auto max-w-6xl px-6 py-16 sm:px-8 lg:px-10">
            <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.4em] text-slate-400">Program Unggulan</p>
                    <h2 class="mt-4 text-3xl font-bold tracking-tight text-white sm:text-4xl">
                        Kegiatan utama kami.
                    </h2>
                </div>
                <a href="/galeri" class="rounded-full border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                    Lihat Galeri
                </a>
            </div>

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div class="rounded-3xl bg-slate-900 p-7">
                    <p class="text-sm uppercase tracking-[0.35em] text-slate-400">Latihan</p>
                    <h3 class="mt-4 text-xl font-semibold text-white">Pengembangan rutin</h3>
                    <p class="mt-3 text-slate-300 leading-7">
                        Latihan mingguan untuk menumbuhkan keterampilan teknis, kerja tim, dan jiwa kepemimpinan.
                    </p>
                </div>
                <div class="rounded-3xl bg-slate-900 p-7">
                    <p class="text-sm uppercase tracking-[0.35em] text-slate-400">Kemah</p>
                    <h3 class="mt-4 text-xl font-semibold text-white">Kerja bakti</h3>
                    <p class="mt-3 text-slate-300 leading-7">
                        Kegiatan kemah yang menguatkan solidaritas dan pengalaman sosial di lapangan.
                    </p>
                </div>
                <div class="rounded-3xl bg-slate-900 p-7">
                    <p class="text-sm uppercase tracking-[0.35em] text-slate-400">Pengabdian</p>
                    <h3 class="mt-4 text-xl font-semibold text-white">Aksi sosial</h3>
                    <p class="mt-3 text-slate-300 leading-7">
                        Inisiatif untuk mendukung masyarakat dan menjaga lingkungan sekitar.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="bg-slate-50 text-slate-950">
        <div class="mx-auto max-w-6xl px-6 py-16 sm:px-8 lg:px-10">
            <div class="rounded-3xl bg-white p-8 shadow-sm shadow-slate-200">
                <div class="grid gap-6 lg:grid-cols-2 lg:items-center">
                    <div>
                        <p class="text-sm uppercase tracking-[0.4em] text-slate-500">Gabung Bersama Kami</p>
                        <h2 class="mt-4 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">
                            Bergabunglah dalam perjalanan pembentukan karakter.
                        </h2>
                    </div>
                    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                        <a href="/kontak" class="rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                            Hubungi Kami
                        </a>
                        <a href="/pendaftaran" class="rounded-full border border-slate-950 px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-slate-100">
                            Daftar Anggota
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
