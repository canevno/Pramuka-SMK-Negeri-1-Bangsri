

<?php $__env->startSection('content'); ?>
<div class="max-w-full mx-auto px-4 py-8 sm:px-4 lg:px-6">
    <h1 class="text-2xl font-bold mb-4 text-center">ABSENSI ANGGOTA</h1>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('absensi_success')): ?>
        <div id="absensi-toast" role="status" aria-live="polite" class="fixed bottom-4 left-4 right-4 z-[70] w-auto max-w-md rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-xl text-slate-900 transition-all duration-300 ease-out pointer-events-auto sm:top-4 sm:right-4 sm:bottom-auto sm:left-auto sm:w-full sm:max-w-sm sm:px-5 sm:py-4 sm:rounded-3xl">
            <div class="flex items-center justify-between gap-3">
                <p class="text-sm font-semibold text-slate-900 leading-5"><?php echo e(session('absensi_success')); ?></p>
                <button type="button" id="absensi-toast-close" class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-slate-200 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900 focus:outline-none">×</button>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! session()->has('absensi_verified')): ?>
        <div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow-md border border-slate-100">
            <h2 class="text-xl font-bold mb-1 text-slate-800">Verifikasi Petugas Absensi</h2>
            <p class="text-xs text-slate-500 mb-5">Silakan masukkan NTA, pilih Ambalan, dan Sangga Anda untuk melanjutkan ke form absensi.</p>
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('absensi_verify_error')): ?>
                <div class="bg-red-50 border border-red-200 text-red-700 text-sm p-3 rounded-lg mb-4">
                    <?php echo e(session('absensi_verify_error')); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <form id="absensi-verify-form" action="<?php echo e(route('absensi.verify')); ?>" method="POST" class="space-y-4">
                <?php echo csrf_field(); ?>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Nama Petugas</label>
                    <input type="text" name="name" required class="w-full border border-slate-300 p-2.5 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-[#0D1B2A] focus:border-[#0D1B2A] outline-none" placeholder="Contoh: Canevno" value="<?php echo e(old('name')); ?>">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Kelas Petugas</label>
                    <input type="text" name="kelas" required class="w-full border border-slate-300 p-2.5 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-[#0D1B2A] focus:border-[#0D1B2A] outline-none" placeholder="Contoh: XI PPLG 1" value="<?php echo e(old('kelas')); ?>">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">NTA Petugas</label>
                    <input type="text" name="nta" required class="w-full border border-slate-300 p-2.5 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-[#0D1B2A] focus:border-[#0D1B2A] outline-none" placeholder="Contoh: 11.20.03.000000.0001" value="<?php echo e(old('nta')); ?>">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Pilih Ambalan</label>
                    <select name="ambalan" required class="w-full border border-slate-300 p-2.5 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-[#0D1B2A] focus:border-[#0D1B2A] outline-none bg-white">
                        <option value="" disabled selected>-- Pilih Ambalan --</option>
                        <option value="PA" <?php echo e(old('ambalan') === 'PA' ? 'selected' : ''); ?>>Putra (PA)</option>
                        <option value="PI" <?php echo e(old('ambalan') === 'PI' ? 'selected' : ''); ?>>Putri (PI)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Pilih Sangga </label>
                    <select name="sangga" required class="w-full border border-slate-300 p-2.5 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-[#0D1B2A] focus:border-[#0D1B2A] outline-none bg-white">
                        <option value="" disabled selected>-- Pilih Sangga --</option>
                        <?php
                            $defaultSangga = ['Perintis', 'Penegas', 'Pencoba', 'Pendobrak'];
                            $listSangga = (isset($sanggaList) && count($sanggaList) > 0) ? $sanggaList : $defaultSangga;
                        ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $listSangga; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sanggaItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($sanggaItem); ?>" <?php echo e(old('sangga') === $sanggaItem || session('absensi_verified.sangga') === $sanggaItem ? 'selected' : ''); ?>><?php echo e($sanggaItem); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </select>
                </div>

                <button type="submit" class="mt-2 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white shadow-sm transition-all hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100 group">
                    <span>Verifikasi & Lanjut Tahap 2</span>
                    <svg class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </button>
            </form>
        </div>

    
    <?php else: ?>
        <?php
            $officerAmbalan = session('absensi_verified.ambalan', $selectedAmbalan ?? '');
            $ambalanLabel = ($officerAmbalan === 'PA' || strtolower($officerAmbalan) === 'putra') ? 'Putra (PA)' : (($officerAmbalan === 'PI' || strtolower($officerAmbalan) === 'putri') ? 'Putri (PI)' : 'Umum');
            $activeSangga = trim((string) session('absensi_verified.sangga', 'Perintis'));
            $indoMonths = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
            $currentMonthName = $indoMonths[(int)date('n') - 1];
        ?>

        <div class="mb-6 flex justify-end">
            <form action="<?php echo e(route('absensi.forget')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="rounded-lg bg-[#0D1B2A] px-3 py-1.5 text-xs font-medium text-white transition hover:bg-blue-900">Kembali Tahap 1</button>
            </form>
        </div>

        <form method="POST" action="<?php echo e(route('absensi.submit')); ?>" id="absensi-form" class="space-y-4 bg-white dark:bg-gray-800 p-2.5 sm:p-6 rounded-lg shadow-sm">
            <?php echo csrf_field(); ?>

            <input type="hidden" name="participant_ambalan" value="<?php echo e($officerAmbalan); ?>">
            <input type="hidden" name="participant_kelas" value="<?php echo e(session('absensi_verified.kelas', '')); ?>">

            
            <div class="grid grid-cols-3 gap-3">
                <div class="relative">
                    <button type="button" id="bulanDropdownTrigger" aria-haspopup="listbox" aria-expanded="false" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-left text-sm text-slate-900 shadow-sm transition hover:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200">
                        <span class="dropdown-label"><?php echo e($currentMonthName); ?></span>
                    </button>
                    <input type="hidden" name="bulan" id="bulanDropdownValue" value="<?php echo e($currentMonthName); ?>">
                    <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-slate-500">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.292l3.71-4.06a.75.75 0 111.1 1.02l-4.25 4.657a.75.75 0 01-1.1 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" /></svg>
                    </div>
                    <div id="bulanDropdownOptions" class="absolute z-30 mt-2 hidden w-full max-h-60 overflow-auto rounded-lg border border-slate-200 bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $indoMonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button type="button" data-bulan="<?php echo e($m); ?>" class="bulan-option w-full px-4 py-2 text-left text-sm text-slate-700 hover:bg-slate-100 focus:outline-none">
                                <?php echo e($m); ?>

                            </button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <input id="input_tanggal" name="tanggal" type="number" min="1" max="31" placeholder="Tanggal" autocomplete="off" required class="border border-slate-300 px-3 py-2 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-slate-200 focus:outline-none" value="<?php echo e(date('j')); ?>" />
                <input id="input_tahun" name="tahun" type="number" min="2000" max="2100" placeholder="Tahun" autocomplete="off" required class="border border-slate-300 px-3 py-2 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-slate-200 focus:outline-none" value="<?php echo e(date('Y')); ?>" />
            </div>

            
            <div class="grid grid-cols-1 gap-3 mt-4 sm:grid-cols-[auto_1fr] sm:items-center">
                <span class="text-sm font-medium text-slate-700 dark:text-slate-200">Sub Sangga</span>
                
                <div class="relative">
                    <button type="button" id="subSanggaDropdownTrigger" aria-haspopup="listbox" aria-expanded="false" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm text-slate-900 shadow-sm hover:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200 flex items-center justify-between">
                        <span class="dropdown-label truncate">Pilih Sub Sangga</span>
                        <span class="pointer-events-none flex items-center text-slate-500 ml-3">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.292l3.71-4.06a.75.75 0 111.1 1.02l-4.25 4.657a.75.75 0 01-1.1 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" /></svg>
                        </span>
                    </button>
                    <input type="hidden" name="participant_sub_sangga" id="subSanggaDropdownValue" value="">
                    <div id="subSanggaDropdownOptions" class="absolute z-30 mt-2 hidden w-full overflow-hidden rounded-lg border border-slate-200 bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                        <?php
                            $namaSanggaAktif = session('absensi_verified.sangga', 'Sangga');
                            $rawSubList = collect($roster ?? [])
                                ->pluck('sub_sangga')
                                ->filter(fn ($value) => filled($value))
                                ->unique()
                                ->sortBy(fn ($value) => (int) $value)
                                ->values()
                                ->all();

                            if (empty($rawSubList)) {
                                $rawSubList = ['1', '2', '3', '4', '5'];
                            }
                        ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $rawSubList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $displayLabel = $namaSanggaAktif . ' ' . $subItem;
                            ?>
                            <button type="button" data-subsangga="<?php echo e($subItem); ?>" data-display="<?php echo e($displayLabel); ?>" class="subsangga-option w-full px-4 py-2 text-left text-sm text-slate-700 hover:bg-slate-100 focus:outline-none">
                                <?php echo e($displayLabel); ?>

                            </button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>

            
            <div id="absensi-roster-section" class="hidden">
                <div class="overflow-x-auto mt-4 sm:rounded-lg">
                    <table class="w-full table-fixed sm:table-auto divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="w-[45%] sm:w-auto px-1.5 sm:px-3 py-2 text-left text-[10px] sm:text-xs font-medium text-gray-500 uppercase">Nama</th>
                                <th class="w-[35%] sm:w-auto px-0.5 sm:px-3 py-2 text-center text-[10px] sm:text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                                <th class="w-[20%] sm:w-auto px-0.5 sm:px-3 py-2 text-center text-[10px] sm:text-xs font-medium text-gray-500 uppercase">Iuran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $roster; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $idx = $loop->index;
                                    $studentName = $student['nama'] ?? $student['name'] ?? '';
                                    $studentKelas = $student['kelas_asal'] ?? $student['kelas'] ?? '';
                                ?>
                                <tr class="attendance-row hover:bg-slate-50" 
                                    data-row-subsangga="<?php echo e($student['sub_sangga'] ?? ''); ?>" 
                                    data-row-sangga="<?php echo e($student['sangga'] ?? ''); ?>" 
                                    data-row-ambalan="<?php echo e($student['ambalan'] ?? ''); ?>">
                                    
                                    <td class="px-1.5 sm:px-3 py-2 sm:py-3 text-[11px] sm:text-sm text-gray-800">
                                        <div class="font-medium leading-tight wrap-break-word"><?php echo e($studentName); ?></div>
                                        <input type="hidden" name="participant_id[<?php echo e($idx); ?>]" value="<?php echo e($student['id'] ?? ''); ?>">
                                        <input type="hidden" name="participant_name[<?php echo e($idx); ?>]" value="<?php echo e($studentName); ?>">
                                        <input type="hidden" name="participant_kelas[<?php echo e($idx); ?>]" value="<?php echo e($student['kelas_asal_real'] ?? $student['kelas_asal'] ?? $student['kelas'] ?? session('absensi_verified.kelas', '')); ?>">
                                        <input type="hidden" name="participant_ambalan[<?php echo e($idx); ?>]" value="<?php echo e($student['ambalan'] ?? $officerAmbalan); ?>">
                                        <input type="hidden" name="participant_sangga[<?php echo e($idx); ?>]" class="participant-sangga-field" value="<?php echo e($student['sangga'] ?? session('absensi_verified.sangga', 'Perintis')); ?>">
                                    </td>

                                    
                                    <td class="px-0.5 sm:px-3 py-2 sm:py-3">
                                        <div class="grid grid-cols-4 gap-0.5 sm:gap-2">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['Hadir' => 'H', 'Izin' => 'I', 'Sakit' => 'S', 'Alpha' => 'A']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php $radioId = "status_{$idx}_{$status}"; ?>
                                                <label for="<?php echo e($radioId); ?>" class="cursor-pointer select-none">
                                                    <input type="radio" id="<?php echo e($radioId); ?>" name="status[<?php echo e($idx); ?>]" value="<?php echo e($status); ?>" class="peer sr-only" <?php echo e($status === 'Hadir' ? 'checked' : ''); ?> required>
                                                    <span class="flex items-center justify-center px-0.5 py-1.5 sm:px-2 sm:py-1.5 text-[10px] sm:text-xs font-semibold rounded border border-gray-300 bg-white text-slate-700 transition-all hover:bg-slate-100 peer-checked:bg-slate-800 peer-checked:border-slate-800 peer-checked:text-white">
                                                        <?php echo e($label); ?>

                                                    </span>
                                                </label>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </td>

                                    
                                    <td class="px-0.5 sm:px-3 py-2 sm:py-3">
                                        <div class="grid grid-cols-2 gap-0.5 sm:gap-2">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['Ya', 'Tidak']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iuranVal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php $iuranId = "iuran_{$idx}_{$iuranVal}"; ?>
                                                <label for="<?php echo e($iuranId); ?>" class="cursor-pointer select-none">
                                                    <input type="radio" id="<?php echo e($iuranId); ?>" name="iuran[<?php echo e($idx); ?>]" value="<?php echo e($iuranVal); ?>" class="peer sr-only" <?php echo e($iuranVal === 'Ya' ? 'checked' : ''); ?> required>
                                                    <span class="flex items-center justify-center px-0.5 py-1.5 sm:px-2 sm:py-1.5 text-[10px] sm:text-xs font-semibold rounded border border-gray-300 bg-white text-slate-700 transition-all hover:bg-slate-100 peer-checked:bg-slate-800 peer-checked:border-slate-800 peer-checked:text-white">
                                                        <?php echo e($iuranVal); ?>

                                                    </span>
                                                </label>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </td>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <tr id="absensi-empty-row" class="hidden bg-white">
                                <td colspan="3" class="px-3 py-6 text-center text-sm text-slate-500">Belum / tidak ada daftar anggota untuk Sub Sangga ini</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="absensi-submit-button" class="mt-4 flex justify-end">
                    <button type="submit" class="w-full sm:w-auto px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white font-medium rounded-lg transition shadow">Submit Absensi</button>
                </div>
            </div>

            <div id="absensi-no-data" class="mt-4 text-center py-6 text-sm text-slate-500 bg-slate-50 rounded-lg border border-dashed border-slate-200">
                Silahkan pilih Sub Sangga terlebih dahulu.
            </div>
        </form>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const activeSanggaName = <?php echo json_encode(session('absensi_verified.sangga', 'Perintis'), 512) ?>;
    const toast = document.getElementById('absensi-toast');
    const toastCloseBtn = document.getElementById('absensi-toast-close');
    if (toast) {
        if (toastCloseBtn) {
            toastCloseBtn.addEventListener('click', () => toast.remove());
        }
        setTimeout(() => toast.remove(), 4000);
    }

    // Otomatisasi penyesuaian iuran per baris jika status siswa diubah
    const absensiForm = document.getElementById('absensi-form');
    if (absensiForm) {
        absensiForm.addEventListener('change', function (e) {
            const radio = e.target;
            if (!radio || !radio.name || !radio.name.startsWith('status[')) return;

            const tr = radio.closest('tr');
            if (!tr) return;

            if (radio.value === 'Hadir') {
                const iuranYa = tr.querySelector('input[name^="iuran["][value="Ya"]');
                if (iuranYa) iuranYa.checked = true;
            } else {
                const iuranTidak = tr.querySelector('input[name^="iuran["][value="Tidak"]');
                if (iuranTidak) iuranTidak.checked = true;
            }
        });
    }

    const subSanggaDropdownTrigger = document.getElementById('subSanggaDropdownTrigger');
    const subSanggaDropdownOptions = document.getElementById('subSanggaDropdownOptions');
    const subSanggaDropdownValue = document.getElementById('subSanggaDropdownValue');

    const bulanDropdownTrigger = document.getElementById('bulanDropdownTrigger');
    const bulanDropdownOptions = document.getElementById('bulanDropdownOptions');
    const bulanDropdownValue = document.getElementById('bulanDropdownValue');

    function updateDropdownLabel(trigger, label) {
        if (!trigger) return;
        const labelSpan = trigger.querySelector('.dropdown-label');
        if (labelSpan) labelSpan.textContent = label;
    }

    function setupCustomDropdown(trigger, optionsContainer, valueInput, optionClass, datasetKey) {
        if (!trigger || !optionsContainer || !valueInput) return;

        trigger.addEventListener('click', (e) => {
            e.stopPropagation();
            const isHidden = optionsContainer.classList.contains('hidden');
            [subSanggaDropdownOptions, bulanDropdownOptions].forEach(opt => opt && opt.classList.add('hidden'));
            
            if (isHidden) {
                optionsContainer.classList.remove('hidden');
                trigger.setAttribute('aria-expanded', 'true');
            }
        });

        optionsContainer.querySelectorAll(optionClass).forEach(button => {
            button.addEventListener('click', () => {
                const selectedValue = button.dataset[datasetKey];
                const displayLabel = button.dataset.display || selectedValue;
                valueInput.value = selectedValue;
                updateDropdownLabel(trigger, displayLabel);
                optionsContainer.classList.add('hidden');
                trigger.setAttribute('aria-expanded', 'false');
                filterRosterRows();
            });
        });
    }

    setupCustomDropdown(subSanggaDropdownTrigger, subSanggaDropdownOptions, subSanggaDropdownValue, '.subsangga-option', 'subsangga');
    setupCustomDropdown(bulanDropdownTrigger, bulanDropdownOptions, bulanDropdownValue, '.bulan-option', 'bulan');

    document.addEventListener('click', (event) => {
        [
            { trigger: subSanggaDropdownTrigger, opts: subSanggaDropdownOptions },
            { trigger: bulanDropdownTrigger, opts: bulanDropdownOptions }
        ].forEach(({ trigger, opts }) => {
            if (opts && trigger && !trigger.contains(event.target) && !opts.contains(event.target)) {
                opts.classList.add('hidden');
            }
        });
    });

    function filterRosterRows() {
        const selectedSubSangga = (subSanggaDropdownValue ? subSanggaDropdownValue.value : '').trim();

        const rows = document.querySelectorAll('.attendance-row');
        const emptyRow = document.getElementById('absensi-empty-row');
        const rosterSection = document.getElementById('absensi-roster-section');
        const noDataMessage = document.getElementById('absensi-no-data');
        let visibleCount = 0;

        rows.forEach(row => {
            const rowSub = (row.dataset.rowSubsangga || '').trim();
            const matchSub = (selectedSubSangga !== '') && (
                rowSub === selectedSubSangga || 
                rowSub.endsWith(selectedSubSangga) || 
                rowSub.includes(selectedSubSangga) ||
                !rowSub
            );

            row.style.display = matchSub ? '' : 'none';

            const inputs = row.querySelectorAll('input');
            inputs.forEach(input => {
                input.disabled = !matchSub;
            });

            const sanggaField = row.querySelector('.participant-sangga-field');
            if (sanggaField) {
                const selectedLabel = selectedSubSangga ? `${activeSanggaName} ${selectedSubSangga}` : (sanggaField.value || activeSanggaName);
                sanggaField.value = selectedLabel;
            }

            if (matchSub) visibleCount++;
        });

        if (emptyRow) {
            emptyRow.classList.toggle('hidden', visibleCount > 0);
        }

        const hasSelection = selectedSubSangga !== '';
        const hasData = hasSelection && visibleCount > 0;

        if (rosterSection) rosterSection.classList.toggle('hidden', !hasData);
        if (noDataMessage) {
            noDataMessage.classList.toggle('hidden', hasData);
            if (hasSelection && visibleCount === 0) {
                noDataMessage.textContent = 'Belum ada data anggota untuk Sub Sangga ini.';
            } else if (!hasSelection) {
                noDataMessage.textContent = 'Silahkan pilih Sub Sangga terlebih dahulu.';
            }
        }
    }

    filterRosterRows();
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var verifyForm = document.getElementById('absensi-verify-form');
    if (!verifyForm) return;

    verifyForm.addEventListener('submit', function (e) {
        try {
            var nta = verifyForm.querySelector('input[name="nta"]');
            var ambalan = verifyForm.querySelector('select[name="ambalan"]');
            var sangga = verifyForm.querySelector('select[name="sangga"]');
            var ntaVal = nta ? nta.value.trim() : '';
            var ambalanVal = ambalan ? ambalan.value : '';
            var sanggaVal = sangga ? sangga.value : '';

            if (!ntaVal || !ambalanVal || !sanggaVal) {
                e.preventDefault();
                alert('Silakan isi NTA, pilih Ambalan, dan pilih Sangga sebelum melanjutkan.');
                return false;
            }

            setTimeout(function () {
                if (!verifyForm.__submitted) {
                    verifyForm.__submitted = true;
                    verifyForm.submit();
                }
            }, 50);
        } catch (err) {
            console.warn('Verify form helper error', err);
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views\pages\absensi.blade.php ENDPATH**/ ?>