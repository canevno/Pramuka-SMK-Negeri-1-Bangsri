@extends('layouts.frontend')
@section('content')
@php
$achievements = App\Support\AchievementStore::byLevel('jateng');
@endphp
<section class="bg-slate-50 py-16 dark:bg-slate-950">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-10 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div class="text-center md:text-left">
                <p class="text-xs font-bold uppercase tracking-[0.25em] text-slate-900 dark:text-white">Prestasi Jateng</p>
                <h1 class="mt-3 text-4xl font-black tracking-tight text-slate-900 dark:text-white">Capaian Tingkat Jateng</h1>
            </div>
            <a href="{{ route('achievement') }}" class="hidden md:inline-flex items-center rounded-lg bg-slate-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-200">
                Kembali ke Semua Prestasi
            </a>
        </div>
        @if($achievements)
            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                @foreach($achievements as $achievement)
                    <article class="overflow-hidden rounded-lg border border-slate-200 bg-white transition hover:border-slate-900 dark:border-slate-800 dark:bg-black dark:hover:border-white">
                        <div class="h-52 overflow-hidden bg-slate-100 dark:bg-slate-900">
                            <img src="{{ asset($achievement['image'] ?? 'images/achievement/prestasi1.jpg') }}" alt="{{ $achievement['title'] }}" class="h-full w-full object-cover grayscale hover:grayscale-0 transition duration-500" />
                        </div>
                        <div class="space-y-3 p-5">
                            <div class="flex items-center justify-between gap-3">
                                <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.12em] text-slate-700 dark:bg-slate-900 dark:text-slate-300">
                                    {{ $achievement['category'] ?? 'Prestasi' }}
                                </span>
                                <span class="text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400">{{ $achievement['year'] ?? now()->year }}</span>
                            </div>
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">{{ $achievement['title'] }}</h2>
                            <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Pemenang: {{ $achievement['winner'] ?? 'Anggota' }}</p>
                            <p class="text-sm leading-6 text-slate-600 dark:text-slate-400">{{ $achievement['description'] ?? 'Prestasi yang membanggakan.' }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="rounded-lg border border-dashed border-slate-300 bg-white p-8 text-center text-slate-500 dark:border-slate-800 dark:bg-black dark:text-slate-400">
                Belum ada data prestasi tingkat Jateng.
            </div>
        @endif

        <!-- Tombol Kembali Khusus Mobile (Paling Bawah) -->
        <div class="mt-10 flex justify-center md:hidden">
            <a href="{{ route('achievement') }}" class="inline-flex items-center rounded-lg bg-slate-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-200">
                Kembali ke Semua Prestasi
            </a>
        </div>
    </div>
</section>
@endsection