@extends('layouts.frontend')

@section('content')
@php
    $members = collect($members ?? [])->filter(fn ($item) => ! empty($item['name'] ?? null))->values();
    $selectedMemberId = $members->isNotEmpty() ? 0 : 'null';
@endphp

<div class="bg-slate-50 text-slate-900 pt-8 pb-16 min-h-screen" x-data="{ selectedMember: {{ $selectedMemberId }} }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <aside class="order-2 lg:order-1 lg:col-span-4 xl:col-span-3 lg:sticky lg:top-32 self-start z-10">
                <nav class="rounded-2xl border border-slate-200 bg-white p-3 shadow-sm">
                    <div>
                        <span class="block px-3 py-1 text-base font-bold text-slate-950 mb-1 border-b border-slate-100 pb-2">
                            Organisasi
                        </span>
                        <div class="space-y-1 mt-2">
                            <a href="{{ route('pembina') }}" class="block w-full rounded-lg px-3 py-1.5 text-left text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-slate-950 {{ request()->routeIs('pembina') ? 'bg-slate-100 font-bold text-slate-950' : '' }}"><span>Pembina</span></a>
                            <a href="{{ route('dewan-kehormatan') }}" class="block w-full rounded-lg px-3 py-1.5 text-left text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-slate-950 {{ request()->routeIs('dewan-kehormatan') ? 'bg-slate-100 font-bold text-slate-950' : '' }}"><span>Dewan Kehormatan</span></a>
                            <a href="{{ route('dewan-ambalan') }}" class="block w-full rounded-lg px-3 py-1.5 text-left text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-slate-950 {{ request()->routeIs('dewan-ambalan') ? 'bg-slate-100 font-bold text-slate-950' : '' }}"><span>Dewan Ambalan</span></a>
                            <a href="{{ route('anggota-dewan') }}" class="block w-full rounded-lg px-3 py-1.5 text-left text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-slate-950 {{ request()->routeIs('anggota-dewan') ? 'bg-slate-100 font-bold text-slate-950' : '' }}"><span>Anggota Dewan</span></a>
                            <a href="{{ route('mitra') }}" class="block w-full rounded-lg px-3 py-1.5 text-left text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-slate-950 {{ request()->routeIs('mitra') ? 'bg-slate-100 font-bold text-slate-950' : '' }}"><span>Mitra</span></a>
                            <a href="{{ route('alumni') }}" class="block w-full rounded-lg px-3 py-1.5 text-left text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-slate-950 {{ request()->routeIs('alumni') ? 'bg-slate-100 font-bold text-slate-950' : '' }}"><span>Alumni</span></a>
                        </div>
                    </div>
                </nav>
            </aside>

            <main class="order-1 lg:order-2 lg:col-span-8 xl:col-span-9">
                <div class="rounded-2xl bg-white border border-slate-200 p-6 sm:p-8 shadow-sm">
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-6 text-center lg:text-left">
                        Dewan Kehormatan
                    </h1>

                    @if($members->isEmpty())
                        <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-8 text-center text-slate-500">
                            Belum ada data dewan kehormatan yang aktif untuk ditampilkan.
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-3">
                            @foreach($members as $index => $member)
                                @php
                                    $image = $member['photo_url'] ?? 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=600';
                                    $description = trim((string) ($member['description'] ?? $member['bio'] ?? '')) ?: 'Anggota aktif yang menjaga integritas dan etika dalam organisasi.';
                                @endphp

                                <div @click="selectedMember = (selectedMember === {{ $index }} ? null : {{ $index }})"
                                    :class="selectedMember === {{ $index }}
                                        ? 'bg-[#183a2d] border-[#183a2d] ring-2 ring-[#183a2d]'
                                        : 'bg-white border-slate-200 hover:border-slate-300'"
                                    class="relative rounded-xl border p-1.5 cursor-pointer transition-all duration-300 select-none shadow-sm lg:scale-[0.96] lg:hover:scale-[0.97]">
                                    <div class="relative overflow-hidden rounded-lg aspect-square bg-slate-100">
                                        <img src="{{ $image }}" alt="{{ $member['name'] ?? 'Dewan Kehormatan' }}" class="w-full h-full object-cover transition duration-300"
                                            :class="selectedMember === {{ $index }} ? 'grayscale-0' : 'grayscale hover:grayscale-0'">
                                    </div>

                                    <div class="px-2 pt-2.5 pb-1">
                                        <h3 class="font-bold text-sm sm:text-base leading-tight transition-colors"
                                            :class="selectedMember === {{ $index }} ? 'text-white' : 'text-slate-900'">
                                            {{ $member['name'] ?? 'Nama' }}
                                        </h3>
                                        <p class="text-xs transition-colors mt-0.5"
                                           :class="selectedMember === {{ $index }} ? 'text-emerald-300' : 'text-slate-500'">
                                            {{ $member['jabatan'] ?? 'Anggota' }}
                                        </p>
                                        <p class="mt-2 text-[11px] leading-relaxed transition-colors"
                                           :class="selectedMember === {{ $index }} ? 'text-emerald-100' : 'text-slate-600'">
                                            {{ Str::limit($description, 110) }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>
</div>
@endsection
