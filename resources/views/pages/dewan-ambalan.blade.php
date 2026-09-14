@extends('layouts.frontend')

@section('content')
<div class="bg-slate-50 text-slate-900 pt-8 pb-16 min-h-screen">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <div class="rounded-2xl bg-white border border-slate-200 p-6 shadow-sm">
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-4">Dewan Ambalan</h1>
            <p class="text-slate-700 leading-relaxed">
                Halaman ini berisi struktur Dewan Ambalan, tugas setiap bagian, dan pertemuan rutin.
            </p>

            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                <div class="rounded-lg border p-4 bg-white">
                    <h3 class="font-semibold text-slate-900">Struktur</h3>
                    <p class="text-sm text-slate-600">Ketua, Wakil, Sekretaris, Bendahara, dan beberapa koordinator bidang.</p>
                </div>
                <div class="rounded-lg border p-4 bg-white">
                    <h3 class="font-semibold text-slate-900">Pertemuan Rutin</h3>
                    <p class="text-sm text-slate-600">Pertemuan mingguan pada hari Sabtu setelah apel.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
