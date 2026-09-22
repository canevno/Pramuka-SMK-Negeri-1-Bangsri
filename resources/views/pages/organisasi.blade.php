@extends('layouts.frontend')

@section('content')
<div class="min-h-screen bg-slate-50 py-10 text-slate-900">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8 lg:p-10">
            <div class="mb-8 text-center">
                <p class="mb-2 text-sm font-semibold uppercase tracking-[0.2em] text-[#0D1B2A]">Organisasi</p>
                <h1 class="text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">Struktur dan Kepengurusan</h1>
            </div>

            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
                <a href="{{ route('pembina') }}" class="group rounded-2xl border border-slate-200 bg-slate-50 p-4 transition hover:-translate-y-1 hover:border-[#0D1B2A] hover:shadow-md">
                    <div class="mb-4 overflow-hidden rounded-xl">
                        <img src="{{ asset('images/visimisi/visimisi1.jpg') }}" alt="Pembina" class="h-44 w-full object-cover transition duration-300 group-hover:scale-105">
                    </div>
                    <h2 class="text-lg font-bold text-slate-900">Pembina</h2>
                    <p class="mt-2 text-sm text-slate-600">Pimpinan pembina serta pendamping kegiatan dan program ambalan.</p>
                </a>

                <a href="{{ route('dewan-kehormatan') }}" class="group rounded-2xl border border-slate-200 bg-slate-50 p-4 transition hover:-translate-y-1 hover:border-[#0D1B2A] hover:shadow-md">
                    <div class="mb-4 overflow-hidden rounded-xl">
                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&q=80&w=900" alt="Dewan Kehormatan" class="h-44 w-full object-cover transition duration-300 group-hover:scale-105">
                    </div>
                    <h2 class="text-lg font-bold text-slate-900">Dewan Kehormatan</h2>
                    <p class="mt-2 text-sm text-slate-600">Pengawas etika, integritas, dan pengambilan keputusan organisasi.</p>
                </a>

                <a id="dewan-ambalan" href="{{ route('dewan-ambalan') }}" class="group rounded-2xl border border-slate-200 bg-slate-50 p-4 transition hover:-translate-y-1 hover:border-[#0D1B2A] hover:shadow-md">
                    <div class="mb-4 overflow-hidden rounded-xl">
                        <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=900" alt="Dewan Ambalan" class="h-44 w-full object-cover transition duration-300 group-hover:scale-105">
                    </div>
                    <h2 class="text-lg font-bold text-slate-900">Dewan Ambalan</h2>
                    <p class="mt-2 text-sm text-slate-600">Perwakilan anggota yang mendorong program kerja dan pembinaan ambalan.</p>
                </a>

                <a href="{{ route('anggota-dewan') }}" class="group rounded-2xl border border-slate-200 bg-slate-50 p-4 transition hover:-translate-y-1 hover:border-[#0D1B2A] hover:shadow-md">
                    <div class="mb-4 overflow-hidden rounded-xl">
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&q=80&w=900" alt="Anggota Dewan" class="h-44 w-full object-cover transition duration-300 group-hover:scale-105">
                    </div>
                    <h2 class="text-lg font-bold text-slate-900">Anggota Dewan</h2>
                    <p class="mt-2 text-sm text-slate-600">Kelompok pengurus serta pelaksana program di lingkungan ambalan.</p>
                </a>
            </div>

            <div class="mt-8 rounded-2xl border border-slate-200 bg-slate-100 p-5 sm:p-6">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#0D1B2A]">Mitra</p>
                        <h2 class="mt-1 text-2xl font-bold text-slate-900">Kolaborasi & dukungan</h2>
                    </div>
                    <a href="{{ route('mitra') }}" class="inline-flex items-center justify-center rounded-xl bg-[#0D1B2A] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#142334]">Lihat Mitra</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
