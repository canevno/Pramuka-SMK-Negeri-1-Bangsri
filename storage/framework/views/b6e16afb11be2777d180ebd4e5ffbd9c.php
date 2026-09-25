<div class="p-6">
    <!-- Header Page -->
    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Daftar Petugas Absensi</h1>
        <p class="text-xs text-gray-500 dark:text-zinc-400">Ringkasan petugas yang memiliki hak akses mencatat absensi.</p>
    </div>

    <!-- 4 CARD STATISTIK ABSENSI -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-6">
        <!-- 1. TOTAL ABSENSI (Anak / Siswa) -->
        <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-xs dark:border-[#262626] dark:bg-[#0A0A0A]">
            <span class="text-xs font-semibold tracking-wider text-slate-400 uppercase dark:text-gray-400">
                TOTAL ABSENSI
            </span>
            <div class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">
                <?php echo e(number_format($totalAbsensiAnak ?? 0, 0, ',', '.')); ?>

            </div>
            <p class="mt-2 text-xs font-medium text-slate-500 dark:text-gray-400">
                Total record siswa
            </p>
        </div>

        <!-- 2. MINGGU INI (Sesi Rekam Kelas) -->
        <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-xs dark:border-[#262626] dark:bg-[#0A0A0A]">
            <span class="text-xs font-semibold tracking-wider text-slate-400 uppercase dark:text-gray-400">
                MINGGU INI
            </span>
            <div class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">
                <?php echo e(number_format($rekamMingguIni ?? 0, 0, ',', '.')); ?>

            </div>
            <p class="mt-2 text-xs font-medium text-slate-500 dark:text-gray-400">
                <?php echo e($currentWeekLabel ?? '-'); ?>

            </p>
        </div>

        <!-- 3. BULAN INI (Sesi Rekam Kelas) -->
        <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-xs dark:border-[#262626] dark:bg-[#0A0A0A]">
            <span class="text-xs font-semibold tracking-wider text-slate-400 uppercase dark:text-gray-400">
                BULAN INI
            </span>
            <div class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">
                <?php echo e(number_format($rekamBulanIni ?? 0, 0, ',', '.')); ?>

            </div>
            <p class="mt-2 text-xs font-medium text-slate-500 dark:text-gray-400">
                <?php echo e($currentMonthKey ?? '-'); ?>

            </p>
        </div>

        <!-- 4. TAHUN INI (Sesi Rekam Kelas) -->
        <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-xs dark:border-[#262626] dark:bg-[#0A0A0A]">
            <span class="text-xs font-semibold tracking-wider text-slate-400 uppercase dark:text-gray-400">
                TAHUN INI
            </span>
            <div class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">
                <?php echo e(number_format($rekamTahunIni ?? 0, 0, ',', '.')); ?>

            </div>
            <p class="mt-2 text-xs font-medium text-slate-500 dark:text-gray-400">
                Tahun <?php echo e($currentYearLabel ?? date('Y')); ?>

            </p>
        </div>
    </div>

    <!-- TABEL UTAMA PETUGAS -->
    <section class="rounded-[2rem] border border-slate-100 bg-white p-6 shadow-xs dark:bg-[#0A0A0A] dark:border-[#262626]">
        <!-- HEADER TABEL -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Daftar Petugas Absensi</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">Ringkasan petugas berdasarkan rekam absensi.</p>
            </div>

            <div class="flex items-center gap-3">
                <span class="px-3 py-1.5 bg-slate-100 dark:bg-gray-700 text-slate-600 dark:text-gray-300 rounded-full text-xs font-medium">
                    Aktif = dalam 14 hari terakhir
                </span>

                <button type="button" 
                    wire:click="$set('showModal', true)"
                    class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl transition-all shadow-xs flex items-center gap-1.5 cursor-pointer">
                    <span class="text-sm font-bold">+</span> Tambah Petugas
                </button>
            </div>
        </div>

        <!-- ALERT SUKSES -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('success')): ?>
            <div class="mb-4 p-3 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-xl text-xs font-medium">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <!-- TABEL DATA PETUGAS -->
        <div class="overflow-x-auto rounded-2xl border border-slate-100 dark:border-gray-700">
            <table class="w-full text-left text-xs text-slate-600 dark:text-gray-300">
                <thead class="bg-slate-50 dark:bg-gray-700/50 uppercase font-semibold text-slate-400 dark:text-gray-400 border-b border-slate-100 dark:border-gray-700">
                    <tr>
                        <th class="px-4 py-3">NAMA PETUGAS</th>
                        <th class="px-4 py-3">NTA</th>
                        <th class="px-4 py-3">KELAS PETUGAS</th>
                        <th class="px-4 py-3">ABSENSI PETUGAS</th>
                        <th class="px-4 py-3">KEAKTIFAN</th>
                        <th class="px-4 py-3">TERAKHIR MELAKUKAN</th>
                        <th class="px-4 py-3 text-center">JUMLAH REKAM</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-gray-700">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $petugasList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-gray-700/30 transition-colors">
                            <td class="px-4 py-3 font-semibold text-slate-800 dark:text-white"><?php echo e($item->nama); ?></td>
                            <td class="px-4 py-3 font-mono text-slate-500 dark:text-gray-400"><?php echo e($item->nta); ?></td>
                            <td class="px-4 py-3"><?php echo e($item->kelas_petugas); ?></td>
                            <td class="px-4 py-3">
                                <span class="px-2.5 py-1 rounded-lg text-[11px] font-semibold <?php echo e(strtoupper($item->jenis_kelamin) === 'L' ? 'bg-blue-100 text-blue-700 dark:bg-blue-950/60 dark:text-blue-400' : 'bg-pink-100 text-pink-700 dark:bg-pink-950/60 dark:text-pink-400'); ?>">
                                    <?php echo e(strtoupper($item->jenis_kelamin) === 'L' ? 'Laki-Laki (PA)' : 'Perempuan (PI)'); ?>

                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <button 
                                    type="button" 
                                    wire:click="toggleStatus(<?php echo e($item->id); ?>)"
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold transition-all cursor-pointer <?php echo e($item->is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-400' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400'); ?>"
                                    title="Klik untuk mengubah status">
                                    <span class="w-1.5 h-1.5 rounded-full <?php echo e($item->is_active ? 'bg-emerald-500' : 'bg-gray-400'); ?>"></span>
                                    <?php echo e($item->is_active ? 'Aktif' : 'Tidak Aktif'); ?>

                                </button>
                            </td>
                            <td class="px-4 py-3 text-slate-500 dark:text-gray-400">
                                <?php echo e($item->terakhir_melakukan ? \Carbon\Carbon::parse($item->terakhir_melakukan)->translatedFormat('d F Y H:i') : '-'); ?>

                            </td>
                            <td class="px-4 py-3 font-semibold text-center">
                                <span class="inline-flex items-center justify-center rounded-full bg-slate-100 px-2.5 py-1 text-xs font-bold text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                                    <?php echo e($item->jumlah_rekam ?? 0); ?>

                                </span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-slate-400">Belum ada data petugas.</td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- MODAL POPUP TAMBAH PETUGAS -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showModal): ?>
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-xs p-4">
                <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 dark:border-gray-700">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">Tambah Petugas Absensi</h3>
                        <button type="button" wire:click="$set('showModal', false)" class="text-slate-400 hover:text-slate-600 dark:hover:text-white text-xl">&times;</button>
                    </div>

                    <form wire:submit.prevent="simpanPetugas" class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-gray-300 mb-1">Nama Petugas</label>
                            <input type="text" wire:model="nama" required class="w-full px-3 py-2 text-xs border rounded-xl bg-slate-50 dark:bg-gray-700 border-slate-200 dark:border-gray-600 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Contoh: Nama Petugas">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-[10px] text-red-500 mt-0.5 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-gray-300 mb-1">NTA Petugas</label>
                            <input type="text" wire:model="nta" required class="w-full px-3 py-2 text-xs border rounded-xl bg-slate-50 dark:bg-gray-700 border-slate-200 dark:border-gray-600 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="11.20.03.240409.0001">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['nta'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-[10px] text-red-500 mt-0.5 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-gray-300 mb-1">Kelas Petugas</label>
                            <input type="text" wire:model="kelas_petugas" required class="w-full px-3 py-2 text-xs border rounded-xl bg-slate-50 dark:bg-gray-700 border-slate-200 dark:border-gray-600 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="X MPLB 1">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['kelas_petugas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-[10px] text-red-500 mt-0.5 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <!-- JENIS KELAMIN / ABSENSI PETUGAS (DITAMBAHKAN) -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-gray-300 mb-1">Jenis Kelamin / Absensi Petugas</label>
                            <select wire:model="jenis_kelamin" required class="w-full px-3 py-2 text-xs border rounded-xl bg-slate-50 dark:bg-gray-700 border-slate-200 dark:border-gray-600 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="L">Laki-Laki (Putra / PA)</option>
                                <option value="P">Perempuan (Putri / PI)</option>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['jenis_kelamin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-[10px] text-red-500 mt-0.5 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div class="flex justify-end gap-2 pt-2">
                            <button type="button" wire:click="$set('showModal', false)" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-slate-700 dark:text-gray-300 text-xs rounded-xl transition-colors">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl transition-colors">Simpan Petugas</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </section>

    <!-- MODAL RINCIAN ABSENSI & IURAN -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showModalDetail): ?>
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4 overflow-y-auto">
            <!-- Container Card Modal -->
            <div class="relative w-full max-w-2xl rounded-3xl bg-white p-6 shadow-2xl dark:bg-zinc-900 dark:border dark:border-zinc-800 my-8">
                
                <!-- Modal Header -->
                <div class="flex items-start justify-between border-b border-slate-100 pb-4 dark:border-zinc-800">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Rincian Absensi & Iuran</h3>
                        <p class="text-xs text-slate-500 dark:text-zinc-400">
                            Kelas <?php echo e($selectedKelas ?? '-'); ?> • <?php echo e($selectedAmbalan ?? '-'); ?>

                        </p>
                    </div>
                    <button type="button" 
                        wire:click="$set('showModalDetail', false)" 
                        class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-700 dark:hover:bg-zinc-800 dark:hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Modal Content Wrapper -->
                <div class="mt-5 space-y-5">
                    <!-- 4 Stats Ringkas Dalam Modal -->
                    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
                        <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-3 dark:border-zinc-800 dark:bg-zinc-800/50">
                            <span class="block text-[10px] font-semibold uppercase tracking-wider text-slate-400">TANGGAL</span>
                            <span class="mt-1 block text-xs font-bold text-slate-800 dark:text-white"><?php echo e($selectedTanggal ?? '-'); ?></span>
                        </div>

                        <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-3 dark:border-zinc-800 dark:bg-zinc-800/50">
                            <span class="block text-[10px] font-semibold uppercase tracking-wider text-slate-400">KELAS</span>
                            <span class="mt-1 block text-xs font-bold text-slate-800 dark:text-white"><?php echo e($selectedKelas ?? '-'); ?></span>
                        </div>

                        <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-3 dark:border-zinc-800 dark:bg-zinc-800/50">
                            <span class="block text-[10px] font-semibold uppercase tracking-wider text-slate-400">AMBALAN</span>
                            <span class="mt-1 block text-xs font-bold text-slate-800 dark:text-white"><?php echo e($selectedAmbalan ?? '-'); ?></span>
                        </div>

                        <div class="rounded-xl border border-emerald-100 bg-emerald-50/60 p-3 dark:border-emerald-950 dark:bg-emerald-950/30">
                            <span class="block text-[10px] font-semibold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">TOTAL IURAN</span>
                            <span class="mt-1 block text-xs font-bold text-emerald-700 dark:text-emerald-300">
                                Rp <?php echo e(number_format($selectedTotalIuran ?? 0, 0, ',', '.')); ?>

                            </span>
                        </div>
                    </div>

                    <!-- Tabel Data Peserta dengan Fixed Max Height Scroll -->
                    <div class="max-h-[50vh] overflow-y-auto rounded-2xl border border-slate-100 dark:border-zinc-800">
                        <table class="w-full text-left text-xs text-slate-600 dark:text-zinc-300">
                            <thead class="sticky top-0 bg-slate-50 font-semibold uppercase text-slate-400 dark:bg-zinc-800 dark:text-zinc-400">
                                <tr>
                                    <th class="px-4 py-3 text-center w-12">No</th>
                                    <th class="px-4 py-3">Nama Peserta</th>
                                    <th class="px-4 py-3 text-center">Keterangan</th>
                                    <th class="px-4 py-3 text-right">Uang Iuran</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-zinc-800">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $detailList ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="hover:bg-slate-50/60 dark:hover:bg-zinc-800/40">
                                        <td class="px-4 py-2.5 text-center font-medium text-slate-400"><?php echo e($index + 1); ?></td>
                                        <td class="px-4 py-2.5 font-semibold text-slate-800 dark:text-white"><?php echo e($row->participant_name); ?></td>
                                        <td class="px-4 py-2.5 text-center">
                                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-semibold
                                                <?php echo e($row->status === 'Hadir' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-400' : 'bg-amber-100 text-amber-700 dark:bg-amber-950/60 dark:text-amber-400'); ?>">
                                                <?php echo e($row->status); ?>

                                            </span>
                                        </td>
                                        <td class="px-4 py-2.5 text-right font-semibold text-slate-700 dark:text-zinc-300">
                                            Rp <?php echo e(number_format($row->iuran_amount ?? 0, 0, ',', '.')); ?>

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="4" class="px-4 py-6 text-center text-slate-400">Tidak ada rincian data.</td>
                                    </tr>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Modal Footer Buttons -->
                <div class="mt-6 flex items-center justify-end gap-2 border-t border-slate-100 pt-4 dark:border-zinc-800">
                    <button type="button" 
                        wire:click="exportWord" 
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-xl transition-colors cursor-pointer">
                        📝 Word
                    </button>
                    <button type="button" 
                        wire:click="exportExcel" 
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-medium rounded-xl transition-colors cursor-pointer">
                        📊 Excel
                    </button>
                    <button type="button" 
                        wire:click="$set('showModalDetail', false)" 
                        class="px-4 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-slate-700 dark:text-zinc-300 text-xs font-medium rounded-xl transition-colors cursor-pointer">
                        Tutup
                    </button>
                </div>

            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views\livewire\admin\daftar-petugas.blade.php ENDPATH**/ ?>