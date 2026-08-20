@extends('admin.layouts.app')
@section('title', $title)
@section('page-heading', $title)
@section('page-description', $description)

@section('content')
<section class="rounded-[2rem] border border-slate-200 bg-white dark:bg-[#0A0A0A] dark:border-[#262626] p-6">
    <div class="space-y-4">
        <h2 class="text-xl font-semibold text-slate-950 dark:text-white">{{ $title }}</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400">{{ $description }}</p>

        @if(isset($publicRoute) && isset($publicLabel))
            <div class="rounded-3xl border border-dashed border-slate-200 dark:border-[#262626] bg-slate-50 dark:bg-[#171717] p-5 text-sm text-slate-600 dark:text-slate-300">
                <p class="mb-3 font-semibold text-slate-900 dark:text-white">Hubungkan dengan halaman publik:</p>
                <a href="{{ $publicRoute }}" class="inline-flex items-center rounded-2xl border border-emerald-200 bg-emerald-50 dark:bg-[#171717] px-4 py-2 text-sm font-semibold text-emerald-700 dark:text-emerald-300 transition hover:bg-emerald-100">{{ $publicLabel }}</a>
            </div>
        @endif

        @if(isset($fields))
            <div class="rounded-3xl border border-slate-200 dark:border-[#262626] bg-slate-50 dark:bg-[#171717] p-5 text-sm text-slate-600 dark:text-slate-300">
                <p class="mb-3 font-semibold text-slate-900 dark:text-white">Input yang perlu dilengkapi oleh admin:</p>
                <ul class="list-disc space-y-2 pl-5">
                    @foreach($fields as $field)
                        <li>{{ $field }}</li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="rounded-3xl border border-dashed border-slate-200 dark:border-[#262626] bg-slate-50 dark:bg-[#171717] p-8 text-sm text-slate-600 dark:text-slate-300">
                Halaman ini adalah placeholder untuk modul <strong class="dark:text-white">{{ $title }}</strong>. Silakan kembangkan fungsionalitas CRUD sesuai kebutuhan.
            </div>
        @endif
    </div>
</section>
@endsection