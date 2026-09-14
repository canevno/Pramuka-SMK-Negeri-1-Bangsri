@extends('admin.layouts.app')

@section('title', $title)

@section('page-heading', $title)
@section('page-description', $description)

@section('content')
<section class="space-y-6">
    {{-- Header Section --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-[#0a0a0a]">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-500 dark:text-gray-500">
                    Modul Admin
                </p>
                <h2 class="mt-2 text-xl font-bold text-gray-900 dark:text-white">
                    {{ $title }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-500">
                    {{ $description }}
                </p>
            </div>
            @if(isset($publicRoute) && isset($publicLabel))
                <a href="{{ $publicRoute }}" class="inline-flex items-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2 text-xs font-semibold text-emerald-700 transition hover:bg-emerald-100 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300 dark:hover:bg-emerald-500/20">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    {{ $publicLabel }}
                </a>
            @endif
        </div>
    </div>

    {{-- Stats Cards --}}
    @if(!empty($stats))
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach($stats as $stat)
                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition hover:shadow-md dark:border-gray-800 dark:bg-[#0a0a0a]">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-gray-500 dark:text-gray-500">
                        {{ $stat['label'] }}
                    </p>
                    <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                        {{ $stat['value'] }}
                    </p>
                    <p class="mt-1 text-[10px] text-gray-500 dark:text-gray-600">
                        {{ $stat['caption'] ?? 'Terbaru' }}
                    </p>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Table --}}
    @if(!empty($table))
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-[#0a0a0a]">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm text-gray-600 dark:text-gray-300">
                    <thead class="bg-gray-50 text-[10px] uppercase tracking-[0.12em] text-gray-600 dark:bg-[#111111] dark:text-gray-400">
                        <tr>
                            @foreach($table['headers'] as $header)
                                <th class="px-5 py-3.5 font-semibold">{{ $header }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-800 dark:bg-[#0a0a0a]">
                        @foreach($table['rows'] as $row)
                            <tr class="transition hover:bg-gray-50 dark:hover:bg-[#111111]">
                                @foreach($row as $cell)
                                    <td class="px-5 py-3.5 text-sm">{{ $cell }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- Form --}}
    @if(!empty($formFields))
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-[#0a0a0a]">
            <div class="mb-5 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">
                        Formulir {{ $title }}
                    </h3>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-500">
                        Lengkapi data di bawah ini
                    </p>
                </div>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    Siap diproses
                </span>
            </div>
            <form class="grid gap-4 md:grid-cols-2">
                @foreach($formFields as $field)
                    <label class="block {{ $field['full'] ?? false ? 'md:col-span-2' : '' }}">
                        <span class="mb-1.5 block text-[10px] font-semibold uppercase tracking-[0.12em] text-gray-500 dark:text-gray-500">
                            {{ $field['label'] }}
                        </span>
                        @if(($field['type'] ?? 'text') === 'textarea')
                            <textarea rows="4" class="w-full rounded-xl border border-gray-200 bg-white px-3.5 py-2.5 text-sm text-gray-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-800 dark:bg-[#111111] dark:text-gray-100 dark:focus:border-indigo-500" placeholder="{{ $field['placeholder'] ?? '' }}"></textarea>
                        @elseif(($field['type'] ?? 'text') === 'select')
                            <select class="w-full rounded-xl border border-gray-200 bg-white px-3.5 py-2.5 text-sm text-gray-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-800 dark:bg-[#111111] dark:text-gray-100 dark:focus:border-indigo-500">
                                @foreach($field['options'] ?? [] as $option)
                                    <option>{{ $option }}</option>
                                @endforeach
                            </select>
                        @else
                            <input type="{{ $field['type'] ?? 'text' }}" class="w-full rounded-xl border border-gray-200 bg-white px-3.5 py-2.5 text-sm text-gray-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-800 dark:bg-[#111111] dark:text-gray-100 dark:focus:border-indigo-500" placeholder="{{ $field['placeholder'] ?? '' }}" />
                        @endif
                    </label>
                @endforeach
                <div class="md:col-span-2 flex justify-end pt-2">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-xs font-semibold text-white shadow-sm shadow-indigo-500/30 transition hover:bg-indigo-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan {{ $title }}
                    </button>
                </div>
            </form>
        </div>
    @endif

    {{-- Empty State --}}
    @if(empty($stats) && empty($table) && empty($formFields))
        <div class="rounded-2xl border-2 border-dashed border-gray-200 bg-white p-10 text-center dark:border-gray-800 dark:bg-[#0a0a0a]">
            <div class="mx-auto w-12 h-12 rounded-full bg-indigo-50 flex items-center justify-center dark:bg-indigo-500/10">
                <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
            </div>
            <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                Halaman <strong class="text-gray-900 dark:text-white">{{ $title }}</strong> sedang aktif dan siap dikembangkan sesuai kebutuhan modul.
            </p>
        </div>
    @endif
</section>
@endsection