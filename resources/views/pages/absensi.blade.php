@extends('layouts.frontend')

@section('content')
<div class="max-w-full mx-auto px-2 py-8 sm:px-4 lg:px-6">
    <h1 class="text-2xl font-bold mb-4 text-center">Absensi anggota kelas X</h1>

    @if(session('absensi_success'))
        <div id="absensi-toast" class="fixed inset-0 z-50 pointer-events-none hidden">
            <div id="absensi-toast-card" class="fixed top-4 right-4 pointer-events-auto max-w-sm w-full rounded-3xl border border-slate-200 bg-white px-5 py-4 shadow-lg text-slate-900 transition-all duration-160 ease-out opacity-0 translate-x-3" style="will-change:transform,opacity;backface-visibility:hidden;">
                <div class="flex items-center justify-between gap-3">
                    <p class="text-sm font-semibold text-slate-900">Submit Success</p>
                    <button id="absensi-toast-close" class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-400/40">×</button>
                </div>
            </div>
        </div>
    @endif
    @if(session('absensi_success'))
        <script>
            (function(){
                // Immediate, small self-contained toast injector to minimize render delay.
                var toast = document.getElementById('absensi-toast');
                var toastCard = document.getElementById('absensi-toast-card');
                if (!toast || !toastCard) return;

                // If DOMContentLoaded handler already ran, prevent double-show by marking handled
                if (toast.dataset.handled === '1') return;
                toast.dataset.handled = '1';

                // Make wrapper visible but keep it pointer-events-none so it won't block UI
                toast.classList.remove('hidden');
                toast.classList.add('pointer-events-none');

                // Use inline styles for the fast first paint and force reflow
                toastCard.style.opacity = '0';
                toastCard.style.transform = 'translateX(12px)';
                void toastCard.offsetWidth;

                // Show synchronously (no rAF) for best reliability on slow LCP
                toastCard.style.transition = 'opacity 160ms ease-out, transform 160ms ease-out';
                toastCard.style.opacity = '1';
                toastCard.style.transform = 'translateX(0)';

                // Auto-hide after short delay and remove DOM node after transition
                setTimeout(function(){
                    toastCard.style.opacity = '0';
                    toastCard.style.transform = 'translateX(12px)';
                    toastCard.addEventListener('transitionend', function(){ if (toast) toast.remove(); }, { once: true });
                }, 900);
            })();
        </script>
    @endif

    @if(session('absensi_verified'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-sm">Terverifikasi sebagai petugas absensi : <strong>{{ session('absensi_verified.name') }}</strong> Kelas <strong>{{ session('absensi_verified.kelas') }}</strong>.</p>
            <form method="POST" action="{{ route('absensi.forget') }}" class="mt-2">
                @csrf
                <button type="submit" class="px-3 py-1 text-sm bg-red-500 text-white rounded">Logout Verifikasi</button>
            </form>
        </div>

        <form method="POST" action="{{ route('absensi.submit') }}" class="space-y-4 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
            @csrf
            <div class="grid grid-cols-3 gap-3">
                <div class="relative">
                    <button type="button" id="bulanDropdownTrigger" aria-haspopup="listbox" aria-expanded="false" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-left text-sm text-slate-900 shadow-sm transition duration-150 ease-in-out hover:border-slate-400 focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200">
                        Bulan
                    </button>
                    <input type="hidden" name="bulan" id="bulanDropdownValue" value="" required>
                    <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-slate-500">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.292l3.71-4.06a.75.75 0 111.1 1.02l-4.25 4.657a.75.75 0 01-1.1 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div id="bulanDropdownOptions" class="absolute z-30 mt-2 hidden w-full max-h-60 overflow-auto rounded-lg border border-slate-200 bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                        @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $m)
                            <button type="button" data-bulan="{{ $m }}" class="bulan-option w-full px-4 py-2 text-left text-sm text-slate-700 transition hover:bg-slate-100 hover:text-slate-900 focus:bg-slate-100 focus:outline-none">
                                {{ $m }}
                            </button>
                        @endforeach
                    </div>
                </div>
                <input id="input_tanggal" name="tanggal" type="number" min="1" max="31" placeholder="Tanggal" autocomplete="off" aria-label="Tanggal" required class="border px-3 py-2 rounded" />
                <input id="input_tahun" name="tahun" type="number" min="2000" max="2100" placeholder="Tahun" autocomplete="off" aria-label="Tahun" required class="border px-3 py-2 rounded" />
            </div>

            <div class="grid grid-cols-1 gap-3 mt-4 sm:grid-cols-[auto_1fr_auto] sm:items-center">
               <span class="text-sm font-medium">Kelas</span> 
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
                       {{-- SMART DROPDOWN: Filter kelas sesuai sesi login petugas --}}
                            @php
                                $petugasKelas = session('absensi_verified.kelas');
                                $listKelas = ['X PPLG 1', 'X PPLG 2', 'X AKL 1', 'X AKL 2', 'X TO 1', 'X TO 2', 'X PM 1', 'X PM 2', 'X MPLB 1', 'X MPLB 2', 'X MPLB 3'];
                                $filteredKelas = $petugasKelas ? [$petugasKelas] : $listKelas;
                            @endphp
                            @foreach($filteredKelas as $kelas)
                            <button type="button" data-kelas="{{ $kelas }}" class="kelas-option w-full px-4 py-2 text-left text-sm text-slate-700 transition hover:bg-slate-100 hover:text-slate-900 focus:bg-slate-100 focus:outline-none">
                                {{ $kelas }}
                            </button>
                        @endforeach
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
                    <input type="hidden" name="participant_ambalan" id="ambalanDropdownValue" value="">
                    <div id="ambalanDropdownOptions" class="absolute z-30 mt-2 hidden w-full overflow-hidden rounded-lg border border-slate-200 bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                        @foreach(['Putra', 'Putri'] as $ambalan)
                            <button type="button" data-ambalan="{{ $ambalan }}" class="ambalan-option w-full px-4 py-2 text-left text-sm text-slate-700 transition hover:bg-slate-100 hover:text-slate-900 focus:bg-slate-100 focus:outline-none">
                                {{ $ambalan }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <div id="absensi-roster-section" class="hidden">
                <div class="overflow-x-auto mt-4 sm:rounded-lg">
                    <table class="min-w-full table-auto divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-1 sm:px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                                <th class="px-3 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Iuran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($roster as $student)
                                <tr class="attendance-row hover:bg-slate-50" data-row-kelas="{{ $student['kelas'] }}" data-row-ambalan="{{ $student['ambalan'] }}">
                                    <td class="px-1 sm:px-3 py-3 text-sm text-gray-700 pl-0 sm:pl-3">
                                            <div class="truncate font-medium">{{ $student['name'] }}</div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="grid grid-cols-4 gap-2">
                                                @foreach(['Hadir' => 'H', 'Izin' => 'I', 'Sakit' => 'S', 'Alpha' => 'A'] as $status => $label)
                                                        <label class="toggle-label cursor-pointer rounded-md border border-gray-300 bg-white flex items-center justify-center px-2 py-1 text-xs font-medium text-slate-700 transition-colors">
                                                        <input type="radio" name="status[{{ $student['id'] }}]" value="{{ $status }}" class="sr-only toggle-radio" {{ $status === 'Hadir' ? 'checked' : '' }} required>
                                                        {{ $label }}
                                                    </label>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="grid grid-cols-2 gap-2">
                                                    <label class="toggle-label cursor-pointer rounded-md border border-gray-300 bg-white flex items-center justify-center px-2 py-1 text-xs font-medium text-slate-700 transition-colors">
                                                    <input type="radio" name="iuran[{{ $student['id'] }}]" value="Ya" class="sr-only toggle-radio" checked required>
                                                    Ya
                                                </label>
                                                    <label class="toggle-label cursor-pointer rounded-md border border-gray-300 bg-white flex items-center justify-center px-2 py-1 text-xs font-medium text-slate-700 transition-colors">
                                                    <input type="radio" name="iuran[{{ $student['id'] }}]" value="Tidak" class="sr-only toggle-radio" required>
                                                    Tidak
                                                </label>
                                        </div>
                                    </td>
                                    <input type="hidden" name="participant_name[{{ $student['id'] }}]" value="{{ $student['name'] }}">
                                </tr>
                            @endforeach
                            <tr id="absensi-empty-row" class="hidden bg-white">
                                <td colspan="3" class="px-3 py-6 text-center text-sm text-slate-500">Belum / tidak ada daftar</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="absensi-no-data" class="mt-3 text-sm text-slate-600 hidden">Belum / tidak ada daftar</div>
                <div id="absensi-helper-text" class="mt-3 text-sm text-slate-600">Silahkan cek kembali kebenaran data yang anda masukan sebelum di submit</div>
                <div id="absensi-submit-button" class="mt-3 flex flex-col items-stretch gap-3 sm:flex-row sm:justify-end sm:items-center">
                    <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-slate-800 text-white rounded-lg">Submit Kelas</button>
                </div>
            </div>
        </form>

    @else
        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
            <p class="mb-4">Verifikasi petugas terlebih dahulu dengan memasukkan <strong>Nama Petugas, Kelas X Yang Di Absen, dan NTA Petugas</strong>.</p>
            @if(session('absensi_verify_error'))
                <div class="mb-3 text-sm text-red-600">{{ session('absensi_verify_error') }}</div>
            @endif
            <form method="POST" action="{{ route('absensi.verify') }}" class="space-y-3">
                @csrf
                <div>
                    <label for="verify_name" class="block text-sm font-medium mb-1">Nama Petugas</label>
                    <input id="verify_name" name="name" type="text" autocomplete="name" required class="w-full border px-3 py-2 rounded" />
                </div>
                <div>
                    <label for="verify_kelas" class="block text-sm font-medium mb-1">Kelas yang diabsen</label>
                    <input id="verify_kelas" name="kelas" type="text" autocomplete="off" required class="w-full border px-3 py-2 rounded" />
                </div>
                <div>
                    <label for="verify_nta" class="block text-sm font-medium mb-1">NTA Petugas</label>
                    <input id="verify_nta" name="nta" type="text" autocomplete="off" required class="w-full border px-3 py-2 rounded" />
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Verifikasi</button>
                </div>
            </form>
        </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggleRadios = document.querySelectorAll('.toggle-radio');
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

    toggleRadios.forEach(radio => radio.addEventListener('change', updateToggleStyles));
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

    function setupCustomDropdown(trigger, optionsContainer, valueInput, optionClass, datasetKey) {
        if (!trigger || !optionsContainer || !valueInput) return;

        trigger.addEventListener('click', () => {
            const isHidden = optionsContainer.classList.toggle('hidden');
            trigger.setAttribute('aria-expanded', String(!isHidden));
        });

        optionsContainer.querySelectorAll(optionClass).forEach(button => {
            button.addEventListener('click', () => {
                const selectedValue = button.dataset[datasetKey];
                valueInput.value = selectedValue;
                if (trigger.querySelector('.dropdown-label')) {
                    updateDropdownLabel(trigger, selectedValue);
                    
                } else {
                    trigger.textContent = selectedValue;
                }
                optionsContainer.classList.add('hidden');
                trigger.setAttribute('aria-expanded', 'false');
                filterRosterRows();
            });
        });

        document.addEventListener('click', (event) => {
            if (!trigger.contains(event.target) && !optionsContainer.contains(event.target)) {
                optionsContainer.classList.add('hidden');
                trigger.setAttribute('aria-expanded', 'false');
            }
        });
    }

    setupCustomDropdown(kelasDropdownTrigger, kelasDropdownOptions, kelasDropdownValue, '.kelas-option', 'kelas');
    setupCustomDropdown(ambalanDropdownTrigger, ambalanDropdownOptions, ambalanDropdownValue, '.ambalan-option', 'ambalan');
    setupCustomDropdown(bulanDropdownTrigger, bulanDropdownOptions, bulanDropdownValue, '.bulan-option', 'bulan');

    // Keep the dropdown label text in the button when selected
    function updateDropdownLabel(trigger, label) {
        const labelSpan = trigger.querySelector('.dropdown-label');
        if (labelSpan) {
            labelSpan.textContent = label;
        }
    }
    // === TAMBAHAN AUTO-LOCK KELAS ===
    if (kelasDropdownOptions) {
        const availableKelas = kelasDropdownOptions.querySelectorAll('.kelas-option');
        if (availableKelas.length === 1) {
            const lockedClass = availableKelas[0].dataset.kelas;

            // Isi input tersembunyi
            kelasDropdownValue.value = lockedClass;

            // Ubah label tombol dropdown
            updateDropdownLabel(kelasDropdownTrigger, lockedClass);

            // Kunci tombol agar tidak bisa diklik dan beri efek warna abu-abu
            if (kelasDropdownTrigger) {
                kelasDropdownTrigger.classList.add('bg-slate-100', 'cursor-not-allowed', 'opacity-70');
                kelasDropdownTrigger.style.pointerEvents = 'none';

                // Sembunyikan icon panah bawah (opsional)
                const arrowIcon = kelasDropdownTrigger.querySelector('svg');
                if (arrowIcon) arrowIcon.style.display = 'none';
            }
        }
    }

    // === AKHIR TAMBAHAN AUTO-LOCK ===

    function filterRosterRows() {
        const selectedKelas = kelasDropdownValue ? kelasDropdownValue.value : '';
        const selectedAmbalan = ambalanDropdownValue ? ambalanDropdownValue.value : '';
        const rows = document.querySelectorAll('.attendance-row') || [];
        const emptyRow = document.getElementById('absensi-empty-row');
        const rosterSection = document.getElementById('absensi-roster-section');
        const noDataMessage = document.getElementById('absensi-no-data');
        const helperText = document.getElementById('absensi-helper-text');
        const submitButton = document.getElementById('absensi-submit-button');
        let visibleCount = 0;

        rows.forEach(row => {
            const rowKelas = row.dataset.rowKelas;
            const rowAmbalan = row.dataset.rowAmbalan;
            const visible = selectedKelas && selectedAmbalan && rowKelas === selectedKelas && rowAmbalan === selectedAmbalan;

            row.style.display = visible ? '' : 'none';

            const inputs = row.querySelectorAll('input');
            inputs.forEach(input => {
                input.disabled = !visible;
            });

            if (visible) visibleCount++;
        });

        if (emptyRow) {
            emptyRow.classList.toggle('hidden', visibleCount > 0);
        }

        const hasSelection = selectedKelas && selectedAmbalan;
        const hasData = hasSelection && visibleCount > 0;

        if (rosterSection) {
            rosterSection.classList.toggle('hidden', !hasData);
        }
        if (noDataMessage) {
            noDataMessage.classList.toggle('hidden', !hasSelection || hasData);
        }
        if (helperText) {
            helperText.classList.toggle('hidden', !hasData);
        }
        if (submitButton) {
            submitButton.classList.toggle('hidden', !hasData);
        }
    }

    // Initialize empty state when page loads
    filterRosterRows();

    // Toast show/hide logic
    const toast = document.getElementById('absensi-toast');
    const toastCard = document.getElementById('absensi-toast-card');
    if (toast && toastCard) {
        // ensure wrapper is visible but non-interactive
        toast.classList.remove('hidden');
        toast.classList.add('pointer-events-none');
        // show the card with transform + opacity reliably:
        // force a reflow then remove hidden classes on a short timeout
        toast.classList.remove('hidden');
        // force layout to ensure transition will run
        void toastCard.offsetWidth;
        setTimeout(() => {
            toastCard.classList.remove('opacity-0', 'translate-x-3');
        }, 10);

        const closeBtn = document.getElementById('absensi-toast-close');
        function hideToast() {
            // disable card pointer events while hiding
            toastCard.classList.add('pointer-events-none');
            toastCard.classList.add('opacity-0', 'translate-x-3');
            toastCard.addEventListener('transitionend', () => toast.remove(), { once: true });
        }
        if (closeBtn) closeBtn.addEventListener('click', hideToast);
        // auto hide after 900ms for snappier feedback
        setTimeout(hideToast, 900);
    }
});
</script>
@endpush

