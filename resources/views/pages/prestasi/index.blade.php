@extends('layouts.frontend')

@section('content')
    <section class="bg-slate-50 py-16 dark:bg-slate-950">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8 text-center md:text-left">
                <p class="text-[10px] font-bold uppercase tracking-[0.25em] text-slate-900 dark:text-white">Prestasi</p>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900 dark:text-white md:text-4xl">Semua Capaian Prestasi</h1>
            </div>

            @include('sections.home.achievement')
        </div>
    </section>
@endsection
