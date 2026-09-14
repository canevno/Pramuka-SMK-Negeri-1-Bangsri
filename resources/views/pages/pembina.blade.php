@extends('layouts.frontend')

@section('content')
@php
    $activePembina = ($pembinas ?? collect())->where('is_active', true)->sortBy('sort_order')->values();
    $selectedPembinaId = $activePembina->first()?->id ?? null;
    $dewanAnggota = ($dewanAnggota ?? collect())->where('is_active', true)->sortBy('sort_order')->values();
@endphp

<div class="bg-slate-50 text-slate-900 pt-8 pb-16 min-h-screen" x-data="{ activeTab: 'pembina', selectedPembina: {{ $selectedPembinaId ?? 'null' }} }" x-init="if (window.location.hash === '#anggota-dewan') activeTab = 'anggota-dewan'">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <aside class="order-2 lg:order-1 lg:col-span-4 xl:col-span-3 lg:sticky lg:top-32 self-start z-10">
                <nav class="rounded-2xl border border-slate-200 bg-white p-3 shadow-sm">
                    <div>
                        <span class="block px-3 py-1 text-base font-bold text-slate-950 mb-1 border-b border-slate-100 pb-2">
                            Organisasi
                        </span>
                        <div class="space-y-1 mt-2">
                            <button @click="activeTab = 'pembina'"
                                :class="activeTab === 'pembina' ? 'bg-slate-100 text-slate-950 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-950'"
                                class="w-full text-left rounded-lg px-3 py-1.5 text-sm font-medium transition flex items-center justify-between">
                                <span>Pembina</span>
                            </button>

                            <button @click="activeTab = 'dewan-kehormatan'"
                                :class="activeTab === 'dewan-kehormatan' ? 'bg-slate-100 text-slate-950 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-950'"
                                class="w-full text-left rounded-lg px-3 py-1.5 text-sm font-medium transition flex items-center justify-between">
                                <span>Dewan Kehormatan</span>
                            </button>

                            <button @click="activeTab = 'dewan-ambalan'"
                                :class="activeTab === 'dewan-ambalan' ? 'bg-slate-100 text-slate-950 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-950'"
                                class="w-full text-left rounded-lg px-3 py-1.5 text-sm font-medium transition flex items-center justify-between">
                                <span>Dewan Ambalan</span>
                            </button>

                            <button @click="activeTab = 'anggota-dewan'"
                                :class="activeTab === 'anggota-dewan' ? 'bg-slate-100 text-slate-950 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-950'"
                                class="w-full text-left rounded-lg px-3 py-1.5 text-sm font-medium transition flex items-center justify-between">
                                <span>Anggota Dewan</span>
                            </button>

                            <button @click="activeTab = 'mitra'"
                                :class="activeTab === 'mitra' ? 'bg-slate-100 text-slate-950 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-950'"
                                class="w-full text-left rounded-lg px-3 py-1.5 text-sm font-medium transition flex items-center justify-between">
                                <span>Mitra</span>
                            </button>

                            <button @click="activeTab = 'alumni'"
                                :class="activeTab === 'alumni' ? 'bg-slate-100 text-slate-950 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-950'"
                                class="w-full text-left rounded-lg px-3 py-1.5 text-sm font-medium transition flex items-center justify-between">
                                <span>Alumni</span>
                            </button>
                        </div>
                    </div>
                </nav>
            </aside>

            <main class="order-1 lg:order-2 lg:col-span-8 xl:col-span-9">
                <div class="rounded-2xl bg-white border border-slate-200 p-6 sm:p-8 shadow-sm">
                    <div x-show="activeTab === 'pembina'" x-cloak>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-6 text-center lg:text-left">
                            Pembina Pramuka SMKN 1 Bangsri
                        </h1>

                        @if($activePembina->isEmpty())
                            <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-8 text-center text-slate-500">
                                Belum ada data pembina yang aktif untuk ditampilkan.
                            </div>
                        @else
                            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                                @foreach($activePembina as $pembina)
                                    @php
                                        $image = $pembina->photo_url ?: 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=600';
                                    @endphp

                                    <div @click="selectedPembina = (selectedPembina === {{ $pembina->id }} ? null : {{ $pembina->id }})"
                                        :class="selectedPembina === {{ $pembina->id }}
                                            ? 'bg-[#183a2d] border-[#183a2d] ring-2 ring-[#183a2d]'
                                            : 'bg-white border-slate-200 hover:border-slate-300'"
                                        class="relative rounded-2xl border p-2 cursor-pointer transition-all duration-300 select-none shadow-sm">
                                        <div class="relative overflow-hidden rounded-xl aspect-square bg-slate-100">
                                            <img src="{{ $image }}" alt="{{ $pembina->name }}" class="w-full h-full object-cover filter grayscale hover:grayscale-0 transition duration-300">

                                            <div x-show="selectedPembina === {{ $pembina->id }}"
                                                 x-transition:enter="transition ease-out duration-200"
                                                 x-transition:enter-start="opacity-0 scale-95 translate-x-2"
                                                 x-transition:enter-end="opacity-100 scale-100 translate-x-0"
                                                 class="absolute top-2.5 right-2.5 bg-[#a3e635] rounded-full py-2 px-1.5 flex flex-col items-center gap-2 shadow-md z-10">
                                                @if(!empty($pembina->phone))
                                                    <a href="tel:{{ preg_replace('/\s+/', '', $pembina->phone) }}" class="text-slate-950 hover:scale-125 transition p-0.5" aria-label="Telepon {{ $pembina->name }}">
                                                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M6.6 10.8c1.6 3.1 4.1 5.6 7.2 7.2l2.4-2.4c.3-.3.8-.4 1.2-.2 1.3.4 2.7.6 4.1.6.7 0 1.2.5 1.2 1.2v3.9c0 .7-.5 1.2-1.2 1.2C10.7 21.9 2.1 13.3 2.1 2.4c0-.7.5-1.2 1.2-1.2h3.9c.7 0 1.2.5 1.2 1.2 0 1.4.2 2.8.6 4.1.2.4.1.9-.2 1.2l-2.4 2.4z"/></svg>
                                                    </a>
                                                @endif
                                                @if(!empty($pembina->email))
                                                    <a href="mailto:{{ $pembina->email }}" class="text-slate-950 hover:scale-125 transition p-0.5" aria-label="Email {{ $pembina->name }}">
                                                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zm0 4-8 5-8-5V6l8 5 8-5v2z"/></svg>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="px-2 pt-2.5 pb-1">
                                            <h3 class="font-bold text-sm sm:text-base leading-tight transition-colors"
                                                :class="selectedPembina === {{ $pembina->id }} ? 'text-white' : 'text-slate-900'">
                                                {{ $pembina->name }}
                                            </h3>
                                            <p class="text-xs transition-colors mt-0.5"
                                               :class="selectedPembina === {{ $pembina->id }} ? 'text-emerald-300' : 'text-slate-500'">
                                                {{ $pembina->jabatan }}
                                            </p>
                                            @if(!empty($pembina->status))
                                                <p class="mt-2 text-[10px] font-semibold uppercase tracking-wide {{ $pembina->is_active ? 'text-emerald-400' : 'text-slate-400' }}">
                                                    {{ $pembina->status }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div x-show="activeTab === 'dewan-kehormatan'" x-cloak>
                        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-4">Dewan Kehormatan</h1>
                        <p class="text-slate-700 leading-relaxed mb-6">
                            Dewan Kehormatan bertugas menjaga integritas, kode etik, Kode Kehormatan Pramuka (Satya dan Darma), serta memberikan pertimbangan penghargaan dan pelanggaran disiplin.
                        </p>
                    </div>

                    <div x-show="activeTab === 'dewan-ambalan'" x-cloak>
                        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-4">Dewan Ambalan</h1>
                        <p class="text-slate-700 leading-relaxed mb-6">
                            Badan pengurus harian penegak yang merencanakan, mengelola, dan melaksanakan program kerja harian ambalan putra maupun putri.
                        </p>
                    </div>

                    <div id="anggota-dewan" x-show="activeTab === 'anggota-dewan'" x-cloak>
                        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-4">Anggota Dewan</h1>
                        <p class="text-slate-700 leading-relaxed mb-6">
                            Daftar seluruh fungsionaris dan anggota aktif yang masuk dalam struktur kepengurusan Dewan Ambalan periode berjalan.
                        </p>

                        @if($dewanAnggota->isEmpty())
                            <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-8 text-center text-slate-500">
                                Belum ada data anggota dewan yang aktif untuk ditampilkan.
                            </div>
                        @else
                            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                                @foreach($dewanAnggota as $member)
                                    @php
                                        $memberImage = $member->photo_url ?: 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=600';
                                    @endphp

                                    <div class="rounded-2xl border border-slate-200 bg-white p-2 shadow-sm">
                                        <div class="relative overflow-hidden rounded-xl aspect-square bg-slate-100">
                                            <img src="{{ $memberImage }}" alt="{{ $member->nama }}" class="h-full w-full object-cover">
                                            @if(!empty($member->status))
                                                <span class="absolute top-2 left-2 rounded-full bg-emerald-500/90 px-2 py-1 text-[10px] font-semibold uppercase tracking-wide text-white">
                                                    {{ $member->status }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="px-2 pt-3 pb-1">
                                            <h3 class="text-sm font-bold text-slate-900 sm:text-base">{{ $member->nama }}</h3>
                                            <p class="mt-1 text-xs text-slate-500">{{ $member->jabatan ?: 'Anggota Dewan' }}</p>
                                            @if(!empty($member->kelas_asal) || !empty($member->sangga) || !empty($member->sub_sangga))
                                                <p class="mt-2 text-[10px] font-medium uppercase tracking-[0.12em] text-slate-400">
                                                    {{ trim(implode(' • ', array_filter([$member->kelas_asal, $member->sangga, $member->sub_sangga]))) ?: 'Anggota aktif' }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div x-show="activeTab === 'mitra'" x-cloak>
                        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-4">Mitra Kerjasama</h1>
                        <p class="text-slate-700 leading-relaxed mb-6">
                            Informasi mengenai mitra eksternal, Kwartir Ranting/Cabang, instansi pemerintah, dan organisasi pendukung kegiatan ambalan.
                        </p>
                    </div>

                    <!-- Tab Alumni -->
                    <div x-show="activeTab === 'alumni'" x-cloak>
                        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-4">Alumni Ambalan</h1>
                        <p class="text-slate-700 leading-relaxed mb-6">
                            Wadah komunikasi dan ikatan alumni Pramuka Penegak yang terus memberikan dukungan serta bimbingan bagi ambalan.
                        </p>
                    </div>

                </div>
            </main>

        </div>
    </div>
</div>
@endsection