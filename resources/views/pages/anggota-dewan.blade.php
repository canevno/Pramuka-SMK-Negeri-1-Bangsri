@extends('layouts.frontend')

@section('content')
@php
    $activeMembers = collect($dewanAnggota ?? [])->where('is_active', true)->sortBy(fn ($item) => [$item->sort_order ?? 0, $item->nama ?? ''])->values();
@endphp

<div class="min-h-screen bg-slate-50 px-4 py-10 text-slate-900 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">
        <div class="mb-8 text-center">
            <p class="text-xs font-bold uppercase tracking-[0.28em] text-emerald-700">Struktur Organisasi</p>
            <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Anggota Dewan</h1>
            <p class="mx-auto mt-3 max-w-2xl text-sm text-slate-600 sm:text-base">
                Daftar anggota dewan yang aktif dan terdaftar dalam struktur kepengurusan periode berjalan.
            </p>
        </div>

        @if($activeMembers->isEmpty())
            <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-10 text-center text-slate-500 shadow-sm">
                Belum ada data anggota dewan yang aktif untuk ditampilkan.
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
                @foreach($activeMembers as $item)
                    @php
                        $image = $item->photo_url ?: 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=800';
                    @endphp

                    <article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:shadow-md">
                        <div class="relative h-64 overflow-hidden bg-slate-100">
                            <img src="{{ $image }}" alt="{{ $item->nama }}" class="h-full w-full object-cover">
                            <span class="absolute right-3 top-3 rounded-full bg-emerald-500/90 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-white">
                                {{ $item->status ?? 'Aktif' }}
                            </span>
                        </div>

                        <div class="space-y-3 p-5">
                            <div>
                                <h2 class="text-xl font-bold text-slate-900">{{ $item->nama }}</h2>
                                <p class="mt-1 text-sm font-medium text-emerald-700">{{ $item->jabatan ?: 'Anggota Dewan' }}</p>
                            </div>

                            <div class="space-y-1 text-sm text-slate-600">
                                <p><span class="font-semibold text-slate-800">Kelas:</span> {{ $item->kelas_asal ?: '-' }}</p>
                                <p><span class="font-semibold text-slate-800">Sangga:</span> {{ $item->sangga ?: '-' }}</p>
                                <p><span class="font-semibold text-slate-800">Sub Sangga:</span> {{ $item->sub_sangga ?: '-' }}</p>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
