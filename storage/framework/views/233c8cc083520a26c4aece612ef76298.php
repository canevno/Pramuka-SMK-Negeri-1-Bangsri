

<?php $__env->startSection('content'); ?>
<div class="max-w-full mx-auto px-2 py-8 sm:px-4 lg:px-6">
    <h1 class="text-2xl font-bold mb-4 text-center">Absensi Anggota Kelas X</h1>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('absensi_success')): ?>
        <div id="absensi-toast" class="fixed top-4 right-4 z-50 max-w-sm w-full rounded-3xl border border-slate-200 bg-white px-5 py-4 shadow-lg text-slate-900 transition-all duration-300 ease-out opacity-0 translate-x-3">
            <div class="flex items-center justify-between gap-3">
                <p class="text-sm font-semibold text-slate-900">Submit Success</p>
                <button type="button" id="absensi-toast-close" class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-slate-200 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900 focus:outline-none">×</button>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('absensi_verified')): ?>
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <p class="text-sm text-green-900">
                Terverifikasi sebagai petugas absensi: <strong><?php echo e(session('absensi_verified.name')); ?></strong> (Kelas <strong><?php echo e(session('absensi_verified.kelas')); ?></strong>)
            </p>
            <form method="POST" action="<?php echo e(route('absensi.forget')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="px-3 py-1 text-xs bg-red-600 hover:bg-red-700 text-white font-medium rounded transition">Logout Verifikasi</button>
            </form>
        </div>

        <form method="POST" action="<?php echo e(route('absensi.submit')); ?>" id="absensi-form" class="space-y-4 bg-white dark:bg-gray-800 p-2.5 sm:p-6 rounded-lg shadow-sm">
            <?php echo csrf_field(); ?>

            
            <input type="hidden" name="bulan" id="hidden_bulan" value="<?php echo e($bulanAktif ?? ''); ?>">
            <input type="hidden" name="tanggal" id="hidden_tanggal" value="<?php echo e($tanggalAktif ?? ''); ?>">
            <input type="hidden" name="tahun" id="hidden_tahun" value="<?php echo e($tahunAktif ?? ''); ?>">
            <input type="hidden" name="participant_kelas" id="hidden_participant_kelas" value="<?php echo e($namaKelas ?? ''); ?>">
            <input type="hidden" name="participant_ambalan" id="hidden_participant_ambalan" value="<?php echo e($ambalan ?? ''); ?>">
            
            
            <div class="grid grid-cols-3 gap-3">
                <div class="relative">
                    <button type="button" id="bulanDropdownTrigger" aria-haspopup="listbox" aria-expanded="false" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-left text-sm text-slate-900 shadow-sm transition duration-150 ease-in-out hover:border-slate-400 focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200">
                        <span class="dropdown-label">Bulan</span>
                    </button>
                    <input type="hidden" name="bulan" id="bulanDropdownValue" value="" required>
                    <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-slate-500">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.292l3.71-4.06a.75.75 0 111.1 1.02l-4.25 4.657a.75.75 0 01-1.1 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div id="bulanDropdownOptions" class="absolute z-30 mt-2 hidden w-full max-h-60 overflow-auto rounded-lg border border-slate-200 bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <button type="button" data-bulan="<?php echo e($m); ?>" class="bulan-option w-full px-4 py-2 text-left text-sm text-slate-700 transition hover:bg-slate-100 hover:text-slate-900 focus:bg-slate-100 focus:outline-none">
                                <?php echo e($m); ?>

                            </button>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </div>

                <input id="input_tanggal" name="tanggal" type="number" min="1" max="31" placeholder="Tanggal" autocomplete="off" aria-label="Tanggal" required class="border border-slate-300 px-3 py-2 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-slate-200 focus:border-slate-400 focus:outline-none" />
                
                <input id="input_tahun" name="tahun" type="number" min="2000" max="2100" placeholder="Tahun" autocomplete="off" aria-label="Tahun" required class="border border-slate-300 px-3 py-2 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-slate-200 focus:border-slate-400 focus:outline-none" />
            </div>

            
            <div class="grid grid-cols-1 gap-3 mt-4 sm:grid-cols-[auto_1fr_1fr] sm:items-center">
                <span class="text-sm font-medium text-slate-700 dark:text-slate-200">Kelas</span>
                
                <div class="relative">
                    <button type="button" id="kelasDropdownTrigger" aria-haspopup="listbox" aria-expanded="false" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm text-slate-900 shadow-sm transition duration-150 ease-in-out hover:border-slate-400 focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200 flex items-center justify-between">
                        <span class="dropdown-label truncate">Pilih Kelas</span>
                        <span class="pointer-events-none flex items-center text-slate-500 ml-3">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.292l3.71-4.06a.75.75 0 111.1 1.02l-4.25 4.657a.75.75 0 01-1.1 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </button>
                    <input type="hidden" name="participant_kelas" id="kelasDropdownValue" value="" required>
                    <div id="kelasDropdownOptions" class="absolute z-30 mt-2 hidden w-full overflow-hidden rounded-lg border border-slate-200 bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                        <?php
                            $petugasKelas = session('absensi_verified.kelas');
                            $listKelas = ['X PPLG 1', 'X PPLG 2', 'X AKL 1', 'X AKL 2', 'X TO 1', 'X TO 2', 'X PM 1', 'X PM 2', 'X MPLB 1', 'X MPLB 2', 'X MPLB 3'];
                            $filteredKelas = $petugasKelas ? [$petugasKelas] : $listKelas;
                        ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $filteredKelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kelas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <button type="button" data-kelas="<?php echo e($kelas); ?>" class="kelas-option w-full px-4 py-2 text-left text-sm text-slate-700 transition hover:bg-slate-100 hover:text-slate-900 focus:bg-slate-100 focus:outline-none">
                                <?php echo e($kelas); ?>

                            </button>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </div>

                <div class="relative">
                    <button type="button" id="ambalanDropdownTrigger" aria-haspopup="listbox" aria-expanded="false" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm text-slate-900 shadow-sm transition duration-150 ease-in-out hover:border-slate-400 focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200 flex items-center justify-between">
                        <span class="dropdown-label truncate">Ambalan</span>
                        <span class="pointer-events-none flex items-center text-slate-500 ml-3">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.292l3.71-4.06a.75.75 0 111.1 1.02l-4.25 4.657a.75.75 0 01-1.1 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </button>
                    <input type="hidden" name="participant_ambalan" id="ambalanDropdownValue" value="" required>
                    <div id="ambalanDropdownOptions" class="absolute z-30 mt-2 hidden w-full overflow-hidden rounded-lg border border-slate-200 bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Putra', 'Putri']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ambalan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <button type="button" data-ambalan="<?php echo e($ambalan); ?>" class="ambalan-option w-full px-4 py-2 text-left text-sm text-slate-700 transition hover:bg-slate-100 hover:text-slate-900 focus:bg-slate-100 focus:outline-none">
                                <?php echo e($ambalan); ?>

                            </button>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </div>
            </div>

            
            <div id="absensi-roster-section" class="hidden">
                <div class="overflow-x-auto mt-4 sm:rounded-lg">
                    <table class="w-full table-fixed sm:table-auto divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="w-[45%] sm:w-auto px-1.5 sm:px-3 py-2 text-left text-[10px] sm:text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="w-[35%] sm:w-auto px-0.5 sm:px-3 py-2 text-center text-[10px] sm:text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                                <th class="w-[20%] sm:w-auto px-0.5 sm:px-3 py-2 text-center text-[10px] sm:text-xs font-medium text-gray-500 uppercase tracking-wider">Iuran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $roster; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr class="attendance-row hover:bg-slate-50" data-row-kelas="<?php echo e($student['kelas']); ?>" data-row-ambalan="<?php echo e($student['ambalan']); ?>">
                                    <td class="px-1.5 sm:px-3 py-2 sm:py-3 text-[11px] sm:text-sm text-gray-800">
                                        <div class="font-medium leading-tight break-words pr-1 sm:pr-0"><?php echo e($student['name']); ?></div>
                                        
                                        <input type="hidden" name="participant_name[<?php echo e($student['id']); ?>]" value="<?php echo e($student['name']); ?>">
                                    </td>
                                    <td class="px-0.5 sm:px-3 py-2 sm:py-3">
                                        <div class="grid grid-cols-4 gap-[2px] sm:gap-2">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Hadir' => 'H', 'Izin' => 'I', 'Sakit' => 'S', 'Alpha' => 'A']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                <label class="toggle-label cursor-pointer rounded sm:rounded-md border border-gray-300 bg-white flex items-center justify-center px-0.5 py-1 sm:px-2 sm:py-1 text-[9px] sm:text-xs font-medium text-slate-700 transition-colors whitespace-nowrap min-w-0">
                                                    <input type="radio" name="status[<?php echo e($student['id']); ?>]" value="<?php echo e($status); ?>" class="sr-only toggle-radio" <?php echo e($status === 'Hadir' ? 'checked' : ''); ?> required>
                                                    <?php echo e($label); ?>

                                                </label>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="px-0.5 sm:px-3 py-2 sm:py-3">
                                        <div class="grid grid-cols-2 gap-[2px] sm:gap-2">
                                            <label class="toggle-label cursor-pointer rounded sm:rounded-md border border-gray-300 bg-white flex items-center justify-center px-0.5 py-1 sm:px-2 sm:py-1 text-[9px] sm:text-xs font-medium text-slate-700 transition-colors whitespace-nowrap min-w-0">
                                                <input type="radio" name="iuran[<?php echo e($student['id']); ?>]" value="Ya" class="sr-only toggle-radio" checked required>
                                                Ya
                                            </label>
                                            <label class="toggle-label cursor-pointer rounded sm:rounded-md border border-gray-300 bg-white flex items-center justify-center px-0.5 py-1 sm:px-2 sm:py-1 text-[9px] sm:text-xs font-medium text-slate-700 transition-colors whitespace-nowrap min-w-0">
                                                <input type="radio" name="iuran[<?php echo e($student['id']); ?>]" value="Tidak" class="sr-only toggle-radio" required>
                                                Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr id="absensi-empty-row" class="hidden bg-white">
                                <td colspan="3" class="px-3 py-6 text-center text-sm text-slate-500">Belum / tidak ada daftar</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="absensi-helper-text" class="mt-3 text-sm text-slate-600">Silahkan cek kembali kebenaran data yang Anda masukkan sebelum di-submit.</div>
                <div id="absensi-submit-button" class="mt-3 flex flex-col items-stretch gap-3 sm:flex-row sm:justify-end sm:items-center">
                    <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white font-medium rounded-lg transition">Submit Kelas</button>
                </div>
            </div>

            <div id="absensi-no-data" class="mt-3 text-sm text-slate-600 hidden">Belum / tidak ada daftar</div>
        </form>

    <?php else: ?>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
            <p class="mb-4 text-sm text-slate-700 dark:text-slate-300">
                Verifikasi petugas terlebih dahulu dengan memasukkan <strong>Nama Petugas, Kelas X Yang Di Absen, dan NTA Petugas</strong>.
            </p>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('absensi_verify_error')): ?>
                <div class="mb-3 p-3 bg-red-50 border border-red-200 text-sm text-red-600 rounded-lg">
                    <?php echo e(session('absensi_verify_error')); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <form method="POST" action="<?php echo e(route('absensi.verify')); ?>" class="space-y-3">
                <?php echo csrf_field(); ?>
                <div>
                    <label for="verify_name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nama Petugas</label>
                    <input id="verify_name" name="name" type="text" autocomplete="name" required class="w-full border border-slate-300 px-3 py-2 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-slate-200 focus:border-slate-400 focus:outline-none" />
                </div>
                <div>
                    <label for="verify_kelas" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Kelas yang diabsen</label>
                    <input id="verify_kelas" name="kelas" type="text" autocomplete="off" required class="w-full border border-slate-300 px-3 py-2 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-slate-200 focus:border-slate-400 focus:outline-none" />
                </div>
                <div>
                    <label for="verify_nta" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">NTA Petugas</label>
                    <input id="verify_nta" name="nta" type="text" autocomplete="off" required class="w-full border border-slate-300 px-3 py-2 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-slate-200 focus:border-slate-400 focus:outline-none" />
                </div>
                <div class="flex justify-end pt-2">
                    <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg text-sm transition">Verifikasi</button>
                </div>
            </form>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggleLabels = document.querySelectorAll('.toggle-label');
    function updateToggleStyles() {
        toggleLabels.forEach(label => {
            const input = label.querySelector('.toggle-radio');
            if (input && input.checked) {
                label.classList.add('bg-slate-700', 'border-slate-700', 'text-white');
                label.classList.remove('bg-white', 'border-gray-300', 'text-slate-700');
            } else {
                label.classList.remove('bg-slate-700', 'border-slate-700', 'text-white');
                label.classList.add('bg-white', 'border-gray-300', 'text-slate-700');
            }
        });
    }

    document.querySelectorAll('.toggle-radio').forEach(radio => {
        radio.addEventListener('change', function () {
            // Logika Otomatisasi Iuran berdasarkan Keterangan Absensi
            if (this.name.startsWith('status[')) {
                const tr = this.closest('tr');
                if (tr) {
                    if (this.value !== 'Hadir') {
                        // Jika Izin / Sakit / Alpha -> Otomatis "Tidak"
                        const iuranTidakRadio = tr.querySelector('input[name^="iuran["][value="Tidak"]');
                        if (iuranTidakRadio) iuranTidakRadio.checked = true;
                    } else {
                        // Jika dikembalikan ke "Hadir" -> Otomatis "Ya"
                        const iuranYaRadio = tr.querySelector('input[name^="iuran["][value="Ya"]');
                        if (iuranYaRadio) iuranYaRadio.checked = true;
                    }
                }
            }
            updateToggleStyles();
        });
    });
    updateToggleStyles();

    const kelasDropdownTrigger = document.getElementById('kelasDropdownTrigger');
    const kelasDropdownOptions = document.getElementById('kelasDropdownOptions');
    const kelasDropdownValue = document.getElementById('kelasDropdownValue');
    const ambalanDropdownTrigger = document.getElementById('ambalanDropdownTrigger');
    const ambalanDropdownOptions = document.getElementById('ambalanDropdownOptions');
    const ambalanDropdownValue = document.getElementById('ambalanDropdownValue');
    const bulanDropdownTrigger = document.getElementById('bulanDropdownTrigger');
    const bulanDropdownOptions = document.getElementById('bulanDropdownOptions');
    const bulanDropdownValue = document.getElementById('bulanDropdownValue');

    function updateDropdownLabel(trigger, label) {
        const labelSpan = trigger.querySelector('.dropdown-label');
        if (labelSpan) {
            labelSpan.textContent = label;
        } else {
            trigger.textContent = label;
        }
    }

    function setupCustomDropdown(trigger, optionsContainer, valueInput, optionClass, datasetKey) {
        if (!trigger || !optionsContainer || !valueInput) return;

        trigger.addEventListener('click', (e) => {
            e.stopPropagation();
            const isHidden = optionsContainer.classList.contains('hidden');
            
            [kelasDropdownOptions, ambalanDropdownOptions, bulanDropdownOptions].forEach(opt => opt && opt.classList.add('hidden'));
            
            if (isHidden) {
                optionsContainer.classList.remove('hidden');
                trigger.setAttribute('aria-expanded', 'true');
            } else {
                trigger.setAttribute('aria-expanded', 'false');
            }
        });

        optionsContainer.querySelectorAll(optionClass).forEach(button => {
            button.addEventListener('click', () => {
                const selectedValue = button.dataset[datasetKey];
                valueInput.value = selectedValue;
                updateDropdownLabel(trigger, selectedValue);
                optionsContainer.classList.add('hidden');
                trigger.setAttribute('aria-expanded', 'false');
                filterRosterRows();
            });
        });
    }

    setupCustomDropdown(kelasDropdownTrigger, kelasDropdownOptions, kelasDropdownValue, '.kelas-option', 'kelas');
    setupCustomDropdown(ambalanDropdownTrigger, ambalanDropdownOptions, ambalanDropdownValue, '.ambalan-option', 'ambalan');
    setupCustomDropdown(bulanDropdownTrigger, bulanDropdownOptions, bulanDropdownValue, '.bulan-option', 'bulan');

    document.addEventListener('click', (event) => {
        [
            { trigger: kelasDropdownTrigger, opts: kelasDropdownOptions },
            { trigger: ambalanDropdownTrigger, opts: ambalanDropdownOptions },
            { trigger: bulanDropdownTrigger, opts: bulanDropdownOptions }
        ].forEach(({ trigger, opts }) => {
            if (opts && trigger && !trigger.contains(event.target) && !opts.contains(event.target)) {
                opts.classList.add('hidden');
                trigger.setAttribute('aria-expanded', 'false');
            }
        });
    });

    if (kelasDropdownOptions) {
        const availableKelas = kelasDropdownOptions.querySelectorAll('.kelas-option');
        if (availableKelas.length === 1) {
            const lockedClass = availableKelas[0].dataset.kelas;
            kelasDropdownValue.value = lockedClass;
            updateDropdownLabel(kelasDropdownTrigger, lockedClass);

            if (kelasDropdownTrigger) {
                kelasDropdownTrigger.classList.add('bg-slate-100', 'cursor-not-allowed', 'opacity-70');
                kelasDropdownTrigger.style.pointerEvents = 'none';
                const arrowIcon = kelasDropdownTrigger.querySelector('svg');
                if (arrowIcon) arrowIcon.style.display = 'none';
            }
        }
    }

    function filterRosterRows() {
        const selectedKelas = kelasDropdownValue ? kelasDropdownValue.value.trim().toLowerCase() : '';
        const selectedAmbalan = ambalanDropdownValue ? ambalanDropdownValue.value.trim().toLowerCase() : '';
        const rows = document.querySelectorAll('.attendance-row');
        const emptyRow = document.getElementById('absensi-empty-row');
        const rosterSection = document.getElementById('absensi-roster-section');
        const noDataMessage = document.getElementById('absensi-no-data');
        let visibleCount = 0;

        rows.forEach(row => {
            const rowKelas = (row.dataset.rowKelas || '').trim().toLowerCase();
            const rowAmbalan = (row.dataset.rowAmbalan || '').trim().toLowerCase();
            const visible = selectedKelas !== '' && selectedAmbalan !== '' && rowKelas === selectedKelas && rowAmbalan === selectedAmbalan;

            row.style.display = visible ? '' : 'none';

            // Aktifkan input jika visible, dan nonaktifkan jika tersembunyi
            row.querySelectorAll('input').forEach(input => {
                input.disabled = !visible;
            });

            if (visible) visibleCount++;
        });

        if (emptyRow) {
            emptyRow.classList.toggle('hidden', visibleCount > 0);
        }

        const hasSelection = selectedKelas !== '' && selectedAmbalan !== '';
        const hasData = hasSelection && visibleCount > 0;

        if (rosterSection) rosterSection.classList.toggle('hidden', !hasData);
        if (noDataMessage) noDataMessage.classList.toggle('hidden', !hasSelection || hasData);
    }

    filterRosterRows();

    const toast = document.getElementById('absensi-toast');
    const closeBtn = document.getElementById('absensi-toast-close');

    if (toast) {
        requestAnimationFrame(() => {
            toast.classList.remove('opacity-0', 'translate-x-3');
            toast.classList.add('opacity-100', 'translate-x-0');
        });

        function hideToast() {
            toast.classList.remove('opacity-100', 'translate-x-0');
            toast.classList.add('opacity-0', 'translate-x-3');
            toast.addEventListener('transitionend', () => toast.remove(), { once: true });
        }

        if (closeBtn) closeBtn.addEventListener('click', hideToast);
        setTimeout(hideToast, 2500);
    }
});
</script>
<script>
// Disable submit button after click to prevent duplicate submissions
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('#absensi-form');
    if (form) {
        form.addEventListener('submit', function (e) {
            const btnSubmit = this.querySelector('button[type="submit"]');
            if (btnSubmit) {
                btnSubmit.disabled = true;
                btnSubmit.innerText = 'Menyimpan...';
            }
        });
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/pages/absensi.blade.php ENDPATH**/ ?>