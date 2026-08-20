<div class="p-6">
    <!-- Header & Tombol Tambah -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Daftar Petugas Absensi</h1>
            <p class="text-xs text-gray-500 dark:text-zinc-400">Ringkasan petugas yang memiliki hak akses mencatat absensi.</p>
        </div>
        <section class="rounded-[2rem] border border-slate-100 bg-white p-6 shadow-xs dark:bg-[#0A0A0A] dark:border-[#262626]">
            <!-- HEADER TABEL -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Daftar Petugas Absensi</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Ringkasan petugas berdasarkan rekam absensi.</p>
                </div>

                <div class="flex items-center gap-3">
                    <!-- BADGE AKTIFF -->
                    <span class="px-3 py-1.5 bg-slate-100 dark:bg-gray-700 text-slate-600 dark:text-gray-300 rounded-full text-xs font-medium">
                        Aktif = dalam 14 hari terakhir
                    </span>

                    <!-- TOMBOL TAMBAH PETUGAS -->
                    <button type="button" 
                        wire:click="$set('showModal', true)"
                        class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl transition-all shadow-xs flex items-center gap-1.5 cursor-pointer">
                        <span class="text-sm font-bold">+</span> Tambah Petugas
                    </button>
                </div>
            </div>

            <!-- ALERT SUKSES -->
            @if (session()->has('success'))
                <div class="mb-4 p-3 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-xl text-xs font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <!-- TABEL DATA PETUGAS -->
            <div class="overflow-x-auto rounded-2xl border border-slate-100 dark:border-gray-700">
                <table class="w-full text-left text-xs text-slate-600 dark:text-gray-300">
                    <thead class="bg-slate-50 dark:bg-gray-700/50 uppercase font-semibold text-slate-400 dark:text-gray-400 border-b border-slate-100 dark:border-gray-700">
                        <tr>
                            <th class="px-4 py-3">NAMA PETUGAS</th>
                            <th class="px-4 py-3">NTA</th>
                            <th class="px-4 py-3">KELAS PETUGAS</th>
                            <th class="px-4 py-3">KEAKTIFAN</th>
                            <th class="px-4 py-3">TERAKHIR MELAKUKAN</th>
                            <th class="px-4 py-3">JUMLAH REKAM</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-gray-700">
                        @forelse($petugasList as $item)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-gray-700/30 transition-colors">
                                <td class="px-4 py-3 font-semibold text-slate-800 dark:text-white">{{ $item->nama }}</td>
                                <td class="px-4 py-3 font-mono text-slate-500 dark:text-gray-400">{{ $item->nta }}</td>
                                <td class="px-4 py-3">{{ $item->kelas_petugas }}</td>
                                <td class="px-4 py-3">
                                    <!-- TOMBOL TOGGLE KEAKTIFAN INTERAKTIF -->
                                    <button 
                                        type="button" 
                                        wire:click="toggleStatus({{ $item->id }})"
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold transition-all cursor-pointer {{ $item->is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-400' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400' }}"
                                        title="Klik untuk mengubah status">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $item->is_active ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                                        {{ $item->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </button>
                                </td>
                                <td class="px-4 py-3 text-slate-500 dark:text-gray-400">
                                    {{ $item->terakhir_melakukan ? \Carbon\Carbon::parse($item->terakhir_melakukan)->translatedFormat('d F Y H:i') : '-' }}
                                </td>
                                <td class="px-4 py-3 font-semibold">{{ $item->attendance_records_count ?? 0 }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-slate-400">Belum ada data petugas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- MODAL POPUP TAMBAH PETUGAS -->
            @if($showModal)
                <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-xs p-4">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 dark:border-gray-700">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-base font-bold text-slate-900 dark:text-white">Tambah Petugas Absensi</h3>
                            <button type="button" wire:click="$set('showModal', false)" class="text-slate-400 hover:text-slate-600 dark:hover:text-white text-xl">&times;</button>
                        </div>

                        <form wire:submit.prevent="simpanPetugas" class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-gray-300 mb-1">Nama Petugas</label>
                                <input type="text" wire:model="nama" required class="w-full px-3 py-2 text-xs border rounded-xl bg-slate-50 dark:bg-gray-700 border-slate-200 dark:border-gray-600 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Contoh: cewek">
                                @error('nama') <span class="text-[10px] text-red-500 mt-0.5 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-gray-300 mb-1">NTA Petugas</label>
                                <input type="text" wire:model="nta" required class="w-full px-3 py-2 text-xs border rounded-xl bg-slate-50 dark:bg-gray-700 border-slate-200 dark:border-gray-600 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="11.20.03.240409.0001">
                                @error('nta') <span class="text-[10px] text-red-500 mt-0.5 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-gray-300 mb-1">Kelas Petugas</label>
                                <input type="text" wire:model="kelas_petugas" required class="w-full px-3 py-2 text-xs border rounded-xl bg-slate-50 dark:bg-gray-700 border-slate-200 dark:border-gray-600 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="X MPLB 1">
                                @error('kelas_petugas') <span class="text-[10px] text-red-500 mt-0.5 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex justify-end gap-2 pt-2">
                                <button type="button" wire:click="$set('showModal', false)" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-slate-700 dark:text-gray-300 text-xs rounded-xl transition-colors">Batal</button>
                                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl transition-colors">Simpan Petugas</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </section>
