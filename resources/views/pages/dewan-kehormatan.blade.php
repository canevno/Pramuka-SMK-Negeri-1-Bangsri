@extends('layouts.frontend')

@section('content')
<div class="bg-slate-50 text-slate-900 pt-8 pb-16 min-h-screen">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <div class="rounded-2xl bg-white border border-slate-200 p-6 shadow-sm">
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-4">Dewan Kehormatan</h1>
            <p class="text-slate-700 leading-relaxed">
                Halaman ini memuat tugas, anggota, dan keputusan yang diambil oleh Dewan Kehormatan.
            </p>

            <div class="mt-6">
                <ul class="list-disc pl-5 text-slate-700">
                    <li>Menegakkan kode etik dan tata tertib organisasi.</li>
                    <li>Menangani pelanggaran internal dan rekomendasi sanksi.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
