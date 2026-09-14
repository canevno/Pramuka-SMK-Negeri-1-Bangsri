@extends('layouts.frontend')

@section('content')
<div class="bg-slate-50 text-slate-900 pt-8 pb-16 min-h-screen">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <div class="rounded-2xl bg-white border border-slate-200 p-6 shadow-sm">
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-4">Hasil Pencarian</h1>
            <p class="text-slate-700 mb-4">Hasil pencarian untuk: <strong>{{ $q }}</strong></p>

            @if(empty($q))
                <p class="text-sm text-slate-600">Masukkan kata kunci untuk mencari halaman.</p>
            @elseif(empty($results))
                <p class="text-sm text-slate-600">Tidak ditemukan hasil yang sesuai.</p>
            @else
                <ul class="space-y-3">
                    @foreach($results as $r)
                        <li>
                            <a href="{{ $r['route'] }}" class="text-blue-600 hover:underline">{{ $r['title'] }}</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
