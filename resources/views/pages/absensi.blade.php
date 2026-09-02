@extends('layouts.frontend')

@section('content')
<div class="max-w-full mx-auto px-2 py-8 sm:px-4 lg:px-6">
    <h1 class="text-2xl font-bold mb-4 text-center">Absensi Anggota Kelas X</h1>

    @if(session('absensi_success'))
        <div id="absensi-toast" class="fixed top-4 right-4 z-50 max-w-sm w-full rounded-3xl border border-slate-200 bg-white px-5 py-4 shadow-lg text-slate-900 transition-all duration-300 ease-out">
            <div class="flex items-center justify-between gap-3">
                <p class="text-sm font-semibold text-slate-900">{{ session('absensi_success') }}</p>
                <button type="button" id="absensi-toast-close" class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-slate-200 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900 focus:outline-none">×</button>
            </div>
        </div>
    @endif

    {{-- TAHAP 1: VERIFIKASI PETUGAS ABSENSI --}}
    @if(! session()->has('absensi_verified'))
        <div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow-md border border-slate-100">
            <h2 class="text-xl font-bold mb-1 text-slate-800">Verifikasi Petugas Absensi</h2>
            <p class="text-xs text-slate-500 mb-5">Silakan masukkan NTA dan pilih Sangga Anda untuk melanjutkan ke form absensi.</p>
            
            @if(session('absensi_verify_error'))
                <div class="bg-red-50 border border-red-200 text-red-700 text-sm p-3 rounded-lg mb-4">
                    {{ session('absensi_verify_error') }}
                </div>
            @endif

            <form action="{{ route('absensi.verify') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">NTA Petugas <span class="text-red-500">*</span></label>
                    <input type="text" name="nta" required class="w-full border border-slate-300 p-2.5 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" placeholder="Contoh: 12345678" value="{{ old('nta') }}">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Pilih Sangga <span class="text-red-500">*</span></label>
                    <select name="sangga" required class="w-full border border-slate-300 p-2.5 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white">
                        <option value="" disabled selected>-- Pilih Sangga --</option>
                        @if(isset($sanggaList) && count($sanggaList) > 0)
                            @foreach($sanggaList as $sanggaItem)
                                <option value="{{ $sanggaItem }}">{{ $sanggaItem }}</option>
                            @endforeach
                        @else
                            <option value="Perintis">Perintis</option>
                            <option value="Penegas">Penegas</option>
                            <option value="Pencoba">Pencoba</option>
                            <option value="Pendobrak">Pendobrak</option>
                            <option value="Pelaksana">Pelaksana</option>
                        @endif
                    </select>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg font-semibold text-sm transition shadow-sm mt-2">
                    Verifikasi & Lanjut Tahap 2
                </button>
            </form>
        </div>

    {{-- TAHAP 2: INPUT ABSENSI --}}
    @else
        @php
            $officerAmbalan = session('absensi_verified.ambalan', $selectedAmbalan ?? '');
            $ambalanLabel = ($officerAmbalan === 'PA' || strtolower($officerAmbalan) === 'putra') ? 'Putra (PA)' : (($officerAmbalan === 'PI' || strtolower($officerAmbalan) === 'putri') ? 'Putri (PI)' : 'Umum');
        @endphp

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6 bg-emerald-50 p-4 border border-emerald-200 rounded-xl">
            <div>
                <p class="text-sm text-emerald-900">
                    Petugas Aktif: <strong>{{ session('absensi_verified.name') }}</strong> 
                    <span class="text-xs text-emerald-700">
                        (NTA: {{ session('absensi_verified.nta') }} | Sangga: <strong>{{ session('absensi_verified.sangga') }}</strong> | Ambalan: <strong>{{ $ambalanLabel }}</strong>)
                    </span>
                </p>
            </div>
            <form action="{{ route('absensi.logoutPetugas') }}" method="POST">
                @csrf
                <button type="submit" class="text-xs bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg transition font-medium">Ganti Petugas</button>
            </form>
        </div>

        <form method="POST" action="{{ route('absensi.submit') }}" id="absensi-form" class="space-y-4 bg-white dark:bg-gray-800 p-2.5 sm:p-6 rounded-lg shadow-sm">
            @csrf

            <input type="hidden" name="participant_ambalan" value="{{ $officerAmbalan }}">

            {{-- Date Inputs --}}
            <div class="grid grid-cols-3 gap-3">
                <div class="relative">
                    <button type="button" id="bulanDropdownTrigger" aria-haspopup="listbox" aria-expanded="false" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-left text-sm text-slate-900 shadow-sm transition hover:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200">
                        <span class="dropdown-label">Bulan</span>
                    </button>
                    <input type="hidden" name="bulan" id="bulanDropdownValue" value="">
                    <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-slate-500">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.292l3.71-4.06a.75.75 0 111.1 1.02l-4.25 4.657a.75.75 0 01-1.1 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" /></svg>
                    </div>
                    <div id="bulanDropdownOptions" class="absolute z-30 mt-2 hidden w-full max-h-60 overflow-auto rounded-lg border border-slate-200 bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                        @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $m)
                            <button type="button" data-bulan="{{ $m }}" class="bulan-option w-full px-4 py-2 text-left text-sm text-slate-700 hover:bg-slate-100 focus:outline-none">
                                {{ $m }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <input id="input_tanggal" name="tanggal" type="number" min="1" max="31" placeholder="Tanggal" autocomplete="off" required class="border border-slate-300 px-3 py-2 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-slate-200 focus:outline-none" value="{{ date('j') }}" />
                <input id="input_tahun" name="tahun" type="number" min="2000" max="2100" placeholder="Tahun" autocomplete="off" required class="border border-slate-300 px-3 py-2 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-slate-200 focus:outline-none" value="{{ date('Y') }}" />
            </div>

            {{-- Sub Sangga Dropdown --}}
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
                        @php
                            $namaSanggaAktif = session('absensi_verified.sangga', 'Sangga');
                            $rawSubList = collect($roster ?? [])->pluck('sub_sangga')->filter()->unique()->values();
                            if($rawSubList->isEmpty()) {
                                $rawSubList = collect(['1', '2', '3', '4', '5']);
                            }
                        @endphp
                        @foreach($rawSubList as $subItem)
                            @php
                                $cleanNumber = preg_replace('/[^0-9]/', '', $subItem);
                                $displayLabel = $cleanNumber ? ($namaSanggaAktif . ' ' . $cleanNumber) : $subItem;
                            @endphp
                            <button type="button" data-subsangga="{{ $subItem }}" data-display="{{ $displayLabel }}" class="subsangga-option w-full px-4 py-2 text-left text-sm text-slate-700 hover:bg-slate-100 focus:outline-none">
                                {{ $displayLabel }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Table Roster --}}
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
                            @foreach($roster as $student)
                                <tr class="attendance-row hover:bg-slate-50" 
                                    data-row-subsangga="{{ $student['sub_sangga'] }}" 
                                    data-row-sangga="{{ $student['sangga'] }}" 
                                    data-row-ambalan="{{ $student['ambalan'] }}">
                                    <td class="px-1.5 sm:px-3 py-2 sm:py-3 text-[11px] sm:text-sm text-gray-800">
                                        <div class="font-medium leading-tight break-words">{{ $student['name'] }}</div>
                                        <div class="text-[10px] text-slate-400">Kelas: {{ $student['kelas'] }} | {{ $student['sangga'] }} {{ $student['sub_sangga'] }}</div>
                                        <input type="hidden" name="participant_name[{{ $student['id'] }}]" value="{{ $student['name'] }}">
                                    </td>
                                    <td class="px-0.5 sm:px-3 py-2 sm:py-3">
                                        <div class="grid grid-cols-4 gap-[2px] sm:gap-2">
                                            @foreach(['Hadir' => 'H', 'Izin' => 'I', 'Sakit' => 'S', 'Alpha' => 'A'] as $status => $label)
                                                <label class="toggle-label cursor-pointer rounded border border-gray-300 bg-white flex items-center justify-center px-0.5 py-1 sm:px-2 sm:py-1 text-[9px] sm:text-xs font-medium text-slate-700 transition-colors">
                                                    <input type="radio" name="status[{{ $student['id'] }}]" value="{{ $status }}" class="sr-only toggle-radio" {{ $status === 'Hadir' ? 'checked' : '' }} required>
                                                    {{ $label }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-0.5 sm:px-3 py-2 sm:py-3">
                                        <div class="grid grid-cols-2 gap-[2px] sm:gap-2">
                                            <label class="toggle-label cursor-pointer rounded border border-gray-300 bg-white flex items-center justify-center px-0.5 py-1 sm:px-2 sm:py-1 text-[9px] sm:text-xs font-medium text-slate-700 transition-colors">
                                                <input type="radio" name="iuran[{{ $student['id'] }}]" value="Ya" class="sr-only toggle-radio" checked required>
                                                Ya
                                            </label>
                                            <label class="toggle-label cursor-pointer rounded border border-gray-300 bg-white flex items-center justify-center px-0.5 py-1 sm:px-2 sm:py-1 text-[9px] sm:text-xs font-medium text-slate-700 transition-colors">
                                                <input type="radio" name="iuran[{{ $student['id'] }}]" value="Tidak" class="sr-only toggle-radio" required>
                                                Tidak
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
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
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Toast Auto-Close & Dismiss Logic
    const toast = document.getElementById('absensi-toast');
    const toastCloseBtn = document.getElementById('absensi-toast-close');
    if (toast) {
        if (toastCloseBtn) {
            toastCloseBtn.addEventListener('click', () => toast.remove());
        }
        setTimeout(() => toast.remove(), 4000);
    }

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
            if (this.name.startsWith('status[')) {
                const tr = this.closest('tr');
                if (tr) {
                    if (this.value !== 'Hadir') {
                        const iuranTidak = tr.querySelector('input[name^="iuran["][value="Tidak"]');
                        if (iuranTidak) iuranTidak.checked = true;
                    } else {
                        const iuranYa = tr.querySelector('input[name^="iuran["][value="Ya"]');
                        if (iuranYa) iuranYa.checked = true;
                    }
                }
            }
            updateToggleStyles();
        });
    });
    updateToggleStyles();

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

    // Default bulan ke bulan saat ini
    if (bulanDropdownValue) {
        const months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        const currentMonthName = months[new Date().getMonth()];
        bulanDropdownValue.value = currentMonthName;
        updateDropdownLabel(bulanDropdownTrigger, currentMonthName);
    }

    function filterRosterRows() {
        const selectedSubSangga = (subSanggaDropdownValue ? subSanggaDropdownValue.value : '').trim().toLowerCase();

        const rows = document.querySelectorAll('.attendance-row');
        const emptyRow = document.getElementById('absensi-empty-row');
        const rosterSection = document.getElementById('absensi-roster-section');
        const noDataMessage = document.getElementById('absensi-no-data');
        let visibleCount = 0;

        rows.forEach(row => {
            const rowSub = (row.dataset.rowSubsangga || '').trim().toLowerCase();
            const rowSangga = (row.dataset.rowSangga || '').trim().toLowerCase();

            const rowSubNumber = rowSub.replace(/[^0-9]/g, '');
            const rowSanggaNumber = rowSangga.replace(/[^0-9]/g, '');
            const selectedSubNumber = selectedSubSangga.replace(/[^0-9]/g, '');

            const matchSub = (selectedSubSangga !== '') && (
                rowSub === selectedSubSangga ||
                (rowSubNumber !== '' && rowSubNumber === selectedSubNumber) ||
                (rowSanggaNumber !== '' && rowSanggaNumber === selectedSubNumber) ||
                rowSub.includes(selectedSubSangga)
            );

            row.style.display = matchSub ? '' : 'none';
            row.querySelectorAll('input').forEach(input => {
                input.disabled = !matchSub;
            });

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
                noDataMessage.textContent = 'Belum / tidak ada data anggota untuk Sub Sangga ini.';
            } else if (!hasSelection) {
                noDataMessage.textContent = 'Silahkan pilih Sub Sangga terlebih dahulu.';
            }
        }
    }

    filterRosterRows();
});
</script>
@endpush