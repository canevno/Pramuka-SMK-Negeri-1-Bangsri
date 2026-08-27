

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto px-4 py-10 sm:px-6 lg:px-8">
    <div class="mb-10 text-center lg:text-left">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white">Pendaftaran Bantara</h1>
    </div>

    <div class="grid gap-8 lg:grid-cols-[1fr_320px]">
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm dark:border-slate-700 dark:bg-gray-900">
            <form method="POST" action="<?php echo e(route('pendaftaran-bantara.submit')); ?>" enctype="multipart/form-data" class="space-y-6">
                <?php echo csrf_field(); ?>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-200">Nama Lengkap</label>
                    <input type="text" name="nama" required class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition duration-150 ease-in-out focus:border-slate-500 focus:ring-2 focus:ring-slate-200 dark:border-slate-700 dark:bg-slate-950 dark:text-white" placeholder="Nama lengkap peserta" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-200"> Kelas</label>
                    <input id="kelasInput" type="text" name="kelas" required class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition duration-150 ease-in-out focus:border-slate-500 focus:ring-2 focus:ring-slate-200 dark:border-slate-700 dark:bg-slate-950 dark:text-white" placeholder="Contoh: X PPLG 1" />
                    <p id="kelasError" class="mt-2 text-sm text-red-600 hidden">Kelas harus dimulai dengan <strong>X</strong> atau <strong>10</strong> (contoh: "X PPLG 1" atau "10 PPLG"). Kelas seperti "XI" tidak diterima.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-200">Jenis Kelamin</label>
                    <div class="relative mt-2">
                        <button type="button" id="jenisKelaminDropdownTrigger" aria-haspopup="listbox" aria-expanded="false" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-left text-sm text-slate-900 shadow-sm transition duration-150 ease-in-out hover:border-slate-400 focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200 dark:border-slate-700 dark:bg-slate-950 dark:text-white">
                            <span class="dropdown-label">Pilih jenis kelamin</span>
                            <span class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-slate-500 dark:text-slate-400">
                                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.292l3.71-4.06a.75.75 0 111.1 1.02l-4.25 4.657a.75.75 0 01-1.1 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </button>
                        <input type="hidden" name="jenis_kelamin" id="jenisKelaminDropdownValue" required>
                        <div id="jenisKelaminDropdownOptions" class="absolute z-30 mt-2 hidden w-full overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-lg ring-1 ring-black ring-opacity-5 dark:border-slate-700 dark:bg-slate-900">
                            <button type="button" data-value="Laki-laki" class="w-full px-4 py-3 text-left text-sm text-slate-700 transition hover:bg-slate-100 hover:text-slate-900 focus:bg-slate-100 focus:outline-none dark:text-slate-200 dark:hover:bg-slate-800 dark:hover:text-white">Laki-laki</button>
                            <button type="button" data-value="Perempuan" class="w-full px-4 py-3 text-left text-sm text-slate-700 transition hover:bg-slate-100 hover:text-slate-900 focus:bg-slate-100 focus:outline-none dark:text-slate-200 dark:hover:bg-slate-800 dark:hover:text-white">Perempuan</button>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 shadow-sm dark:border-slate-700 dark:bg-slate-900">
                    <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100 mb-3">Detail Domisili & Data Pribadi</h3>

                    <div class="grid gap-4 grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-200">RT</label>
                            <input type="text" name="rt" required class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition duration-150 ease-in-out focus:border-slate-500 focus:ring-2 focus:ring-slate-200 dark:border-slate-700 dark:bg-slate-950 dark:text-white" placeholder="Contoh: 01" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-200">RW</label>
                            <input type="text" name="rw" required class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition duration-150 ease-in-out focus:border-slate-500 focus:ring-2 focus:ring-slate-200 dark:border-slate-700 dark:bg-slate-950 dark:text-white" placeholder="Contoh: 02" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-200">Kecamatan</label>
                        <input type="text" name="kecamatan" required class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition duration-150 ease-in-out focus:border-slate-500 focus:ring-2 focus:ring-slate-200 dark:border-slate-700 dark:bg-slate-950 dark:text-white" placeholder="Kecamatan" />
                    </div>

                    <div class="grid gap-4 md:grid-cols-2 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-200">Kabupaten</label>
                            <input type="text" name="kabupaten" required class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition duration-150 ease-in-out focus:border-slate-500 focus:ring-2 focus:ring-slate-200 dark:border-slate-700 dark:bg-slate-950 dark:text-white" placeholder="Kabupaten" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-200">Tempat, Tanggal Lahir</label>
                            <input type="text" name="tempat_tanggal_lahir" required class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition duration-150 ease-in-out focus:border-slate-500 focus:ring-2 focus:ring-slate-200 dark:border-slate-700 dark:bg-slate-950 dark:text-white" placeholder="Contoh: Bangsri, 10 Januari 2010" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-200">Alasan / Motivasi</label>
                        <textarea name="motivasi" rows="4" required class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition duration-150 ease-in-out focus:border-slate-500 focus:ring-2 focus:ring-slate-200 dark:border-slate-700 dark:bg-slate-950 dark:text-white" placeholder="Jelaskan alasan dan motivasi Anda mendaftar Bantara"></textarea>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-200">Nomor WhatsApp</label>
                    <input type="tel" name="whatsapp" required class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition duration-150 ease-in-out focus:border-slate-500 focus:ring-2 focus:ring-slate-200 dark:border-slate-700 dark:bg-slate-950 dark:text-white" placeholder="08xx xxxx xxxx" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-200">Nomor Orang Tua</label>
                    <input type="tel" name="nomor_orang_tua" required class="mt-2 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition duration-150 ease-in-out focus:border-slate-500 focus:ring-2 focus:ring-slate-200 dark:border-slate-700 dark:bg-slate-950 dark:text-white" placeholder="08xx xxxx xxxx" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-200">Upload Foto Surat Izin Orang Tua + TTD</label>
                    <label for="surat_izin" id="suratLabel" class="mt-2 flex cursor-pointer flex-col items-center justify-center rounded-3xl border-2 border-dashed border-slate-300 bg-white px-6 py-10 text-center transition hover:border-slate-400 focus-within:border-slate-400 focus-within:ring-2 focus-within:ring-slate-200 dark:border-slate-700 dark:bg-slate-950 dark:text-white">
                        <img id="suratPreviewIcon" src="/upload.png" alt="Upload icon" class="h-8 w-8 object-contain text-slate-400" />
                        <span id="suratLabelText" class="mt-4 text-sm font-semibold text-slate-900 dark:text-white">Klik atau drag gambar di sini</span>
                        <span id="suratLabelHint" class="mt-2 text-xs text-slate-500 dark:text-slate-400">JPG, PNG, WebP — maks 5MB</span>
                    </label>
                    <input id="surat_izin" type="file" name="surat_izin" accept="image/*,.pdf" required class="sr-only" />
                    <div id="suratPreview" class="mt-3 hidden w-full rounded-2xl bg-white p-3 shadow-sm border border-slate-200">
                        <img id="suratPreviewImg" src="" alt="Preview" class="mx-auto max-h-48 object-contain" />
                    </div>
                    <p id="suratHelpText" class="mt-2 text-sm text-slate-500 dark:text-slate-400">Upload foto surat izin dari orang tua yang sudah ditandatangani.</p>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div class="text-sm text-slate-500 dark:text-slate-400">Periksa kembali data sebelum mengirim.</div>
                    <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Daftar Sekarang</button>
                </div>
            </form>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('pendaftaran_success')): ?>
                <div id="pendaftaran-toast" class="fixed inset-0 z-50 pointer-events-none hidden">
                    <div id="pendaftaran-toast-card" class="fixed top-4 right-4 pointer-events-auto max-w-sm w-full rounded-3xl border border-slate-200 bg-white px-5 py-4 shadow-lg text-slate-900 transition-all duration-160 ease-out opacity-0 translate-x-3" style="will-change:transform,opacity;backface-visibility:hidden;">
                        <div class="flex items-center justify-between gap-3">
                            <p class="text-sm font-semibold text-slate-900">Pendaftaran Berhasil</p>
                            <button id="pendaftaran-toast-close" class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-400/40">×</button>
                        </div>
                    </div>
                </div>
                <script>
                    (function(){
                        var toast = document.getElementById('pendaftaran-toast');
                        var toastCard = document.getElementById('pendaftaran-toast-card');
                        var closeBtn = document.getElementById('pendaftaran-toast-close');
                        if (!toast || !toastCard) return;
                        if (toast.dataset.handled === '1') return;
                        toast.dataset.handled = '1';
                        toast.classList.remove('hidden');
                        toast.classList.add('pointer-events-none');
                        toastCard.style.opacity = '0';
                        toastCard.style.transform = 'translateX(12px)';
                        void toastCard.offsetWidth;
                        toastCard.style.transition = 'opacity 160ms ease-out, transform 160ms ease-out';
                        toastCard.style.opacity = '1';
                        toastCard.style.transform = 'translateX(0)';

                        function hideToast() {
                            toastCard.classList.add('pointer-events-none');
                            toastCard.style.opacity = '0';
                            toastCard.style.transform = 'translateX(12px)';
                            toastCard.addEventListener('transitionend', function(){ if (toast) toast.remove(); }, { once: true });
                        }

                        if (closeBtn) {
                            closeBtn.addEventListener('click', hideToast);
                        }
                        setTimeout(hideToast, 900);
                    })();
                </script>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <aside class="order-first lg:order-0 lg:sticky lg:top-28 lg:self-start px-4 py-6 lg:px-8 lg:py-8 lg:text-left">
            <h2 class="text-xl font-semibold text-slate-900 dark:text-white text-center lg:text-left">Informasi Pendaftaran</h2>
            <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300 text-justify">Halaman ini digunakan untuk mendaftar anggota baru Bantara. Isi informasi dengan benar agar proses verifikasi berjalan lancar.</p>
            <div class="mt-6 space-y-4 text-sm text-slate-600 dark:text-slate-300 text-justify">
                <div>
                    <strong class="block text-slate-900 dark:text-white">Syarat :</strong>
                    <ul class="mt-2 list-disc pl-5 space-y-1">
                        <li>Terdaftar sebagai siswa SMK Negeri 1 Bangsri.</li>
                        <li>Merupakan Siswa Kelas X dari berbagai jurusan.</li>
                        <li>Memiliki niat dan semangat yang tinggi.</li>
                        <li>Dapat Melengkapi Form pendaftaran di bawah ini.</li>
                    </ul>
                </div>
            </div>
        </aside>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const jenisKelaminTrigger = document.getElementById('jenisKelaminDropdownTrigger');
    const jenisKelaminOptions = document.getElementById('jenisKelaminDropdownOptions');
    const jenisKelaminValue = document.getElementById('jenisKelaminDropdownValue');

    if (jenisKelaminTrigger && jenisKelaminOptions && jenisKelaminValue) {
        jenisKelaminTrigger.addEventListener('click', function () {
            const isHidden = jenisKelaminOptions.classList.toggle('hidden');
            jenisKelaminTrigger.setAttribute('aria-expanded', String(!isHidden));
        });

        jenisKelaminOptions.querySelectorAll('button[data-value]').forEach(button => {
            button.addEventListener('click', function () {
                const selectedValue = button.dataset.value;
                jenisKelaminValue.value = selectedValue;
                const label = jenisKelaminTrigger.querySelector('.dropdown-label');
                if (label) {
                    label.textContent = selectedValue;
                }
                jenisKelaminOptions.classList.add('hidden');
                jenisKelaminTrigger.setAttribute('aria-expanded', 'false');
            });
        });

        document.addEventListener('click', function (event) {
            if (!jenisKelaminTrigger.contains(event.target) && !jenisKelaminOptions.contains(event.target)) {
                jenisKelaminOptions.classList.add('hidden');
                jenisKelaminTrigger.setAttribute('aria-expanded', 'false');
            }
        });
    }

    const kelasInput = document.getElementById('kelasInput');
    const kelasError = document.getElementById('kelasError');
    const form = document.querySelector('form[enctype="multipart/form-data"]');

    function validateKelas(value) {
        if (!value) return false;
        const v = value.trim().toUpperCase();
        return /^(X(\b|\s)|10(\b|\s))/.test(v);
    }

    if (kelasInput && kelasError) {
        kelasInput.addEventListener('input', function () {
            if (validateKelas(kelasInput.value)) {
                kelasError.classList.add('hidden');
            } else {
                kelasError.classList.remove('hidden');
            }
        });
    }

    const suratInput = document.getElementById('surat_izin');
    const suratPreview = document.getElementById('suratPreview');
    const suratPreviewImg = document.getElementById('suratPreviewImg');
    const suratLabelText = document.getElementById('suratLabelText');
    const suratLabel = document.getElementById('suratLabel');
    const suratPreviewIcon = document.getElementById('suratPreviewIcon');

    if (suratInput && suratLabel) {
        suratInput.addEventListener('change', function (e) {
            const file = e.target.files && e.target.files[0];
            if (!file) {
                suratLabel.style.backgroundImage = '';
                if (suratPreviewIcon) suratPreviewIcon.style.display = '';
                if (suratLabelText) { suratLabelText.textContent = 'Klik atau drag gambar di sini'; suratLabelText.style.display = ''; }
                const suratLabelHint = document.getElementById('suratLabelHint');
                if (suratLabelHint) suratLabelHint.style.display = '';
                if (suratPreview) {
                    suratPreview.classList.add('hidden');
                    suratPreviewImg.src = '';
                }
                const suratHelpText = document.getElementById('suratHelpText');
                if (suratHelpText) suratHelpText.style.display = '';
                return;
            }
            if (!file.type.startsWith('image/')) {
                if (suratLabelText) suratLabelText.textContent = 'File bukan gambar. Jika PDF, tidak ada preview.';
                suratLabel.style.backgroundImage = '';
                const suratLabelHint = document.getElementById('suratLabelHint');
                if (suratLabelHint) suratLabelHint.style.display = '';
                if (suratPreview) {
                    suratPreview.classList.add('hidden');
                    suratPreviewImg.src = '';
                }
                if (suratPreviewIcon) suratPreviewIcon.style.display = '';
                const suratHelpText = document.getElementById('suratHelpText');
                if (suratHelpText) suratHelpText.style.display = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = function (ev) {
                suratLabel.style.backgroundImage = `url(${ev.target.result})`;
                suratLabel.style.backgroundSize = 'contain';
                suratLabel.style.backgroundPosition = 'center';
                suratLabel.style.backgroundRepeat = 'no-repeat';
                if (suratPreviewIcon) suratPreviewIcon.style.display = 'none';
                if (suratLabelText) suratLabelText.style.display = 'none';
                const suratLabelHint = document.getElementById('suratLabelHint');
                if (suratLabelHint) suratLabelHint.style.display = 'none';
                const suratHelpText = document.getElementById('suratHelpText');
                if (suratHelpText) suratHelpText.style.display = 'none';
                if (suratPreview) {
                    suratPreview.classList.add('hidden');
                    suratPreviewImg.src = '';
                }
            };
            reader.readAsDataURL(file);
        });
    }

    if (form) {
        var toast = document.getElementById('pendaftaran-toast');
        var toastCard = document.getElementById('pendaftaran-toast-card');
        var closeBtn = document.getElementById('pendaftaran-toast-close');

        function hideToast() {
            try {
                if (!toast || !toastCard) return;
                toastCard.classList.add('pointer-events-none');
                toastCard.style.opacity = '0';
                toastCard.style.transform = 'translateX(12px)';
                toastCard.addEventListener('transitionend', function(){ if (toast) toast.remove(); }, { once: true });
            } catch (err) {
                console.error('hideToast error', err);
            }
        }

        function showToast() {
            try {
                if (!toast || !toastCard) return;
                if (toast.dataset.handled === '1') return;
                toast.dataset.handled = '1';
                toast.classList.remove('hidden');
                toast.classList.add('pointer-events-none');
                toastCard.style.opacity = '0';
                toastCard.style.transform = 'translateX(12px)';
                void toastCard.offsetWidth;
                toastCard.style.transition = 'opacity 160ms ease-out, transform 160ms ease-out';
                toastCard.style.opacity = '1';
                toastCard.style.transform = 'translateX(0)';
                if (closeBtn) closeBtn.addEventListener('click', hideToast);
                setTimeout(hideToast, 900);
            } catch (err) {
                console.error('showToast error', err);
            }
        }

        try {
            var submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.addEventListener('click', function () {
                    try { showToast(); } catch (err) { console.error('submitBtn click error', err); }
                });
            }
        } catch (err) {
            console.error('attach submitBtn listener error', err);
        }

        form.addEventListener('submit', function (e) {
            try {
                if (kelasInput && !validateKelas(kelasInput.value)) {
                    e.preventDefault();
                    if (kelasError) kelasError.classList.remove('hidden');
                    if (kelasInput) kelasInput.focus();
                    return;
                }

                var action = form.getAttribute('action') || '';
                if (!action.trim() || action.trim() === '#') {
                    showToast();
                    return;
                }
            } catch (err) {
                console.error('form submit handler error', err);
            }
        });
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/pages/pendaftaran-bantara.blade.php ENDPATH**/ ?>