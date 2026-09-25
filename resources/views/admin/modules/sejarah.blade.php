@extends('admin.layouts.app')

@section('title', $title ?? 'Kelola Profil Sejarah')
@section('page-heading', $title ?? 'Kelola Profil Sejarah')
@section('page-description', $description ?? 'Atur konten sejarah yang tampil di halaman Tentang Kami.')

@section('content')
    <div class="space-y-6">
        @if (session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 dark:border-emerald-900/60 dark:bg-emerald-950/30 dark:text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        @include('admin.modules.partials.module-shell', [
            'title' => $title ?? 'Kelola Profil Sejarah',
            'description' => $description ?? 'Atur bagian sejarah agar konten tampil rapi dan mudah dikelola di halaman Tentang Kami.',
            'publicRoute' => $publicRoute ?? route('about'),
            'publicLabel' => $publicLabel ?? 'Lihat Halaman Tentang Kami',
            'stats' => $stats ?? [
                ['label' => 'Bagian', 'value' => '4', 'caption' => 'Kepanduan Dunia, Indonesia, Pramuka, AD-ART'],
                ['label' => 'Judul', 'value' => '4', 'caption' => 'Setiap bagian memiliki judul utama'],
                ['label' => 'Konten', 'value' => '4', 'caption' => 'Isi dapat diubah sesuai kebutuhan'],
                ['label' => 'Tampilan', 'value' => 'Responsif', 'caption' => 'Desktop dan mobile'],
            ],
        ])

        <form action="{{ route('admin.sejarah.store') }}" method="POST" class="space-y-6">
            @csrf

            @php
                $historySections = [
                    ['key' => 'history_kepanduan_dunia', 'label' => 'Kepanduan Dunia'],
                    ['key' => 'history_kepanduan_indonesia', 'label' => 'Kepanduan Indonesia'],
                    ['key' => 'history_gerakan_pramuka', 'label' => 'Gerakan Pramuka'],
                    ['key' => 'history_ad_art_munas_2023', 'label' => 'AD - ART Munas 2023'],
                ];

                $defaultHistorySections = $defaultHistorySections ?? [
                    'history_kepanduan_dunia' => ['title' => 'Kepanduan Dunia', 'content' => ''],
                    'history_kepanduan_indonesia' => ['title' => 'Kepanduan Indonesia', 'content' => ''],
                    'history_gerakan_pramuka' => ['title' => 'Gerakan Pramuka', 'content' => ''],
                    'history_ad_art_munas_2023' => ['title' => 'AD - ART Munas 2023', 'content' => ''],
                ];
            @endphp

            <div class="rounded-[2rem] border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-6">
                <div class="mb-5 flex items-center justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Formulir Sejarah</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Ubah judul dan konten untuk tiap bagian sejarah yang ditampilkan di halaman profil.</p>
                    </div>
                    <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.14em] text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">Live</span>
                </div>

                <div class="grid gap-4 lg:grid-cols-2">
                    @foreach ($historySections as $section)
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-700 dark:bg-slate-800/40">
                            <h4 class="mb-3 text-sm font-semibold uppercase tracking-[0.16em] text-slate-600 dark:text-slate-300">{{ $section['label'] }}</h4>

                            <div class="space-y-3">
                                <div>
                                    <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Judul</label>
                                    <input
                                        type="text"
                                        name="{{ $section['key'] }}_title"
                                        value="{{ old($section['key'] . '_title', $settings[$section['key'] . '_title'] ?? $defaultHistorySections[$section['key']]['title'] ?? '') }}"
                                        placeholder="Judul bagian sejarah"
                                        class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white"
                                    >
                                </div>

                                <div>
                                    <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Konten</label>
                                    <textarea
                                        name="{{ $section['key'] }}_content"
                                        rows="7"
                                        placeholder="Tulis isi sejarah..."
                                        class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white"
                                    >{{ old($section['key'] . '_content', $settings[$section['key'] . '_content'] ?? $defaultHistorySections[$section['key']]['content'] ?? '') }}</textarea>
                                </div>

                                @if(in_array($section['key'], ['history_kepanduan_dunia', 'history_kepanduan_indonesia', 'history_gerakan_pramuka']))
                                    <div class="space-y-2 border-t border-slate-200 pt-3 dark:border-slate-700">
                                        <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Gambar</label>
                                        @php
                                            $imageKey = $section['key'] . '_image';
                                            $uploadedImage = $settings[$imageKey] ?? null;
                                        @endphp
                                        @if(!empty($uploadedImage))
                                            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white dark:border-slate-700">
                                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($uploadedImage) }}" alt="{{ $section['label'] }}" class="h-28 w-full object-cover">
                                            </div>
                                        @endif
                                        <input
                                            type="file"
                                            name="{{ $imageKey }}"
                                            accept="image/*"
                                            class="block w-full text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-slate-900 file:px-3 file:py-2 file:text-sm file:font-medium file:text-white dark:text-slate-300 dark:file:bg-white dark:file:text-slate-900"
                                        >
                                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Format JPG, PNG, WEBP, maksimal 5MB.</p>
                                    </div>
                                @endif

                                @if($section['key'] === 'history_ad_art_munas_2023')
                                    <div class="space-y-2 border-t border-slate-200 pt-3 dark:border-slate-700">
                                        <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">File PDF</label>
                                        @if(!empty($settings['history_ad_art_munas_2023_file']))
                                            <div class="flex items-center justify-between gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-2 text-xs text-emerald-700 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300">
                                                <span class="truncate">{{ basename($settings['history_ad_art_munas_2023_file']) }}</span>
                                                <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($settings['history_ad_art_munas_2023_file']) }}" target="_blank" class="font-semibold underline">Lihat</a>
                                            </div>
                                        @endif
                                        <input
                                            type="file"
                                            name="history_ad_art_munas_2023_file"
                                            accept="application/pdf"
                                            class="block w-full text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-slate-900 file:px-3 file:py-2 file:text-sm file:font-medium file:text-white dark:text-slate-300 dark:file:bg-white dark:file:text-slate-900"
                                        >
                                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Format PDF, maksimal 10MB.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-700 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-200">
                        Simpan Profil Sejarah
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
