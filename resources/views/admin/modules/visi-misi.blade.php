@extends('admin.layouts.app')

@section('title', $title ?? 'Kelola Visi & Misi')
@section('page-heading', $title ?? 'Kelola Visi & Misi')
@section('page-description', $description ?? 'Atur konten visi dan misi yang tampil di halaman profil.')

@section('content')
    <div class="space-y-6">
        @if (session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 dark:border-emerald-900/60 dark:bg-emerald-950/30 dark:text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        @include('admin.modules.partials.module-shell', [
            'title' => $title ?? 'Kelola Visi & Misi',
            'description' => $description ?? 'Atur isi visi dan misi agar dapat dikelola dengan cepat dan tampil secara real-time di halaman profil.',
            'publicRoute' => $publicRoute ?? route('visi-misi'),
            'publicLabel' => $publicLabel ?? 'Lihat Halaman Visi & Misi',
            'stats' => $stats ?? [
                ['label' => 'Kwarnas', 'value' => '1', 'caption' => 'Konten utama'],
                ['label' => 'Pangkalan', 'value' => '1', 'caption' => 'Konten utama'],
                ['label' => 'Tampilan', 'value' => 'Live', 'caption' => 'Update persis di frontend'],
                ['label' => 'Status', 'value' => 'Aktif', 'caption' => 'Siap dipublikasi'],
            ],
        ])

        <form action="{{ route('admin.visi-misi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            @php
                $defaultSections = [
                    'visi_misi_kwarnas' => [
                        'title' => 'Visi, Misi, Dan Tujuan Kwartir Nasional (Kwarnas)',
                        'description' => 'Gerakan Pramuka sebagai organisasi pendidikan nonformal yang turut berperan dalam pendidikan kaum muda Indonesia. Tanggung jawab utama yang dihadapi adalah bagaimana menempatkan Pramuka sebagai bagian penting dalam lingkungan strategis Indonesia serta memposisikan kegiatan Pramuka sebagai centre of excellence bagi para pemuda.',
                    ],
                    'visi_misi_pangkalan' => [
                        'title' => 'Visi, Misi, Dan Tujuan Ambalan Pangkalan',
                        'description' => 'Mewujudkan Pramuka Penegak yang berkarakter luhur, cerdas, mandiri, berwawasan global, serta berlandaskan Tri Satya dan Dasa Darma.',
                    ],
                ];
            @endphp

            <div class="grid gap-6 lg:grid-cols-2">
                @foreach (['visi_misi_kwarnas' => 'Kwarnas', 'visi_misi_pangkalan' => 'Pangkalan'] as $key => $label)
                    @php
                        $logoValue = old($key . '_logo', $settings[$key . '_logo'] ?? null);
                    @endphp

                    <div class="rounded-[2rem] border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-6">
                        <div class="mb-5 flex items-center justify-between gap-3">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">{{ $label }}</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400">Ubah judul, logo, dan deskripsi yang tampil di bagian ini.</p>
                            </div>
                            <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.14em] text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">Live</span>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Judul</label>
                                <input
                                    type="text"
                                    name="{{ $key }}_title"
                                    value="{{ old($key . '_title', $settings[$key . '_title'] ?? $defaultSections[$key]['title']) }}"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white"
                                >
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Logo</label>
                                @if (!empty($logoValue))
                                    <div class="mb-3 flex items-center justify-center rounded-xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-700 dark:bg-slate-800/60">
                                        <img src="{{ Str::startsWith($logoValue, 'http') ? $logoValue : asset('storage/' . $logoValue) }}" alt="Logo {{ $label }}" class="max-h-24 w-auto object-contain">
                                    </div>
                                @endif
                                <input
                                    type="file"
                                    name="{{ $key }}_logo"
                                    accept="image/*"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition file:mr-3 file:rounded-md file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-sm file:font-medium file:text-slate-700 hover:file:bg-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:file:bg-slate-800 dark:file:text-slate-200"
                                >
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-semibold uppercase tracking-[0.12em] text-slate-500 dark:text-slate-400">Deskripsi</label>
                                <textarea
                                    name="{{ $key }}_description"
                                    rows="8"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white"
                                >{{ old($key . '_description', $settings[$key . '_description'] ?? $defaultSections[$key]['description']) }}</textarea>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-700 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-200">
                    Simpan Visi & Misi
                </button>
            </div>
        </form>
    </div>
@endsection
