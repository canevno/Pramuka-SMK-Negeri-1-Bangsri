
<?php $__env->startSection('title', 'Kelola Absensi'); ?>
<?php $__env->startSection('page-heading', 'Kelola Absensi'); ?>
<?php $__env->startSection('page-description', 'Pantau kehadiran peserta, verifikasi petugas, dan ringkas data mingguan/bulanan/tahunan.'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Section Ringkasan Statistik -->
    <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="grid gap-5 lg:grid-cols-4">
            <div class="rounded-[1.75rem] border border-slate-200 bg-slate-50 p-5">
                <p class="text-xs uppercase tracking-[0.18em] text-slate-500">Total Absensi</p>
                <p class="mt-4 text-3xl font-semibold text-slate-950"><?php echo e(number_format($totalCount ?? 0)); ?></p>
            </div>
            <div class="rounded-[1.75rem] border border-slate-200 bg-slate-50 p-5">
                <p class="text-xs uppercase tracking-[0.18em] text-slate-500">Minggu ini</p>
                <p class="mt-4 text-3xl font-semibold text-slate-950"><?php echo e(number_format($weeklyCount ?? 0)); ?></p>
                <p class="mt-2 text-sm text-slate-500"><?php echo e($currentWeekLabel ?? ''); ?></p>
            </div>
            <div class="rounded-[1.75rem] border border-slate-200 bg-slate-50 p-5">
                <p class="text-xs uppercase tracking-[0.18em] text-slate-500">Bulan ini</p>
                <p class="mt-4 text-3xl font-semibold text-slate-950"><?php echo e(number_format($monthlyCount ?? 0)); ?></p>
                <p class="mt-2 text-sm text-slate-500"><?php echo e($currentMonthKey ?? ''); ?></p>
            </div>
            <div class="rounded-[1.75rem] border border-slate-200 bg-slate-50 p-5">
                <p class="text-xs uppercase tracking-[0.18em] text-slate-500">Tahun ini</p>
                <p class="mt-4 text-3xl font-semibold text-slate-950"><?php echo e(number_format($yearlyCount ?? 0)); ?></p>
                <p class="mt-2 text-sm text-slate-500"><?php echo e($currentYear ?? ''); ?></p>
            </div>
        </div>
    </section>

    <!-- Section Rekam Absensi Terbaru -->
    <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-slate-950">Rekam Absensi Terbaru</h2>
                <p class="mt-1 text-sm text-slate-500">Ringkasan rekap absensi per tanggal, kelas, dan ambalan.</p>
            </div>
        </div>

        <div class="mt-6 overflow-hidden rounded-[1.75rem] border border-slate-200 bg-white">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm text-slate-700">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Tanggal</th>
                            <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Kelas</th>
                            <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Ambalan</th>
                            <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Petugas</th>
                            <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Status</th>
                            <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recapRecords ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td class="px-4 py-4"><?php echo e($r['record_date']); ?></td>
                                <td class="px-4 py-4"><?php echo e($r['kelas']); ?></td>
                                <td class="px-4 py-4"><?php echo e($r['ambalan']); ?></td>
                                <td class="px-4 py-4"><?php echo e($r['petugas']); ?></td>
                                <td class="px-4 py-4">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($r['status'] ?? '') === 'Selesai'): ?>
                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold bg-emerald-100 text-emerald-700"><?php echo e($r['status']); ?></span>
                                    <?php else: ?>
                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold bg-amber-100 text-amber-700"><?php echo e($r['status']); ?></span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td class="px-4 py-4">
                                    <button type="button"
                                            onclick="bukaDetailAbsensi('<?php echo e(trim($r['record_date'])); ?>', '<?php echo e(trim($r['kelas'])); ?>', '<?php echo e(trim($r['ambalan'])); ?>')"
                                            class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-lg transition">
                                        Detail
                                    </button>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-sm text-slate-500">Belum ada rekap absensi.</td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Section Daftar Petugas -->
    <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-slate-950">Daftar Petugas Absensi</h2>
                <p class="mt-1 text-sm text-slate-500">Ringkasan petugas berdasarkan rekam absensi.</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">
                    Aktif = dalam 14 hari terakhir
                </span>

                <button type="button"
                    onclick="document.getElementById('modalTambahPetugas').classList.remove('hidden')"
                    class="px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg shadow-xs transition-all flex items-center gap-1 cursor-pointer">
                    <span class="text-sm font-bold">+</span> Tambah Petugas
                </button>
            </div>
        </div>

        <div class="mt-6 overflow-hidden rounded-[1.75rem] border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm text-slate-700">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Nama Petugas</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">NTA</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Kelas Petugas</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Keaktifan</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Terakhir Melakukan</th>
                        <th class="px-4 py-3 uppercase tracking-[0.12em] text-slate-500">Jumlah Rekam</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs bg-white">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $petugasList ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 font-semibold text-gray-900">
                                <?php echo e($item->nama); ?>

                            </td>
                            <td class="px-4 py-3 font-mono text-gray-500">
                                <?php echo e($item->nta); ?>

                            </td>
                            <td class="px-4 py-3 text-gray-700">
                                <?php echo e($item->kelas_petugas); ?>

                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2.5">
                                    <button type="button"
                                        onclick="togglePetugasStatus(this, '<?php echo e($item->id); ?>')"
                                        data-active="<?php echo e($item->is_active ? '1' : '0'); ?>"
                                        class="js-btn-switch relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-emerald-500/50 <?php echo e($item->is_active ? 'bg-emerald-500' : 'bg-slate-300'); ?>"
                                        role="switch"
                                        aria-checked="<?php echo e($item->is_active ? 'true' : 'false'); ?>"
                                        title="Klik untuk <?php echo e($item->is_active ? 'menonaktifkan' : 'mengaktifkan'); ?>">
                                        <span class="js-switch-thumb pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow-md ring-0 transition duration-200 ease-in-out <?php echo e($item->is_active ? 'translate-x-5' : 'translate-x-0'); ?>"></span>
                                    </button>
                                    <span class="js-status-label text-xs font-semibold <?php echo e($item->is_active ? 'text-emerald-600' : 'text-slate-400'); ?>">
                                        <?php echo e($item->is_active ? 'Aktif' : 'Nonaktif'); ?>

                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-gray-500">
                                <?php echo e($item->terakhir_melakukan ? \Carbon\Carbon::parse($item->terakhir_melakukan)->translatedFormat('d F Y H:i') : 'Belum Pernah'); ?>

                            </td>
                            <td class="px-4 py-3 text-gray-500">
                                <?php echo e($item->rekam_count ?? 0); ?>

                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                                Belum ada data petugas terverifikasi di database.
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

<!-- Modal Detail Absensi -->
<div id="modalDetailAbsensi" class="fixed inset-0 z-50 items-center justify-center bg-slate-900/50 p-4 backdrop-blur-sm" style="display: none;">
    <div class="w-full max-w-2xl rounded-3xl bg-white p-6 shadow-2xl border border-slate-200 flex flex-col max-h-[90vh]">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div>
                <h3 class="text-lg font-bold text-slate-900">Rincian Absensi & Iuran</h3>
                <p class="text-xs text-slate-500 mt-0.5" id="mInfoSubheader">Memuat data...</p>
            </div>
            <button type="button" onclick="tutupDetailModal()" class="text-2xl font-bold text-slate-400 hover:text-slate-600 leading-none">&times;</button>
        </div>

        <div class="my-4 grid grid-cols-2 md:grid-cols-4 gap-3">
            <div class="p-3 bg-slate-50 border border-slate-100 rounded-2xl">
                <p class="text-[11px] font-medium text-slate-500 uppercase">Tgl / Bln / Thn</p>
                <p class="text-xs font-bold text-slate-800 mt-1" id="mTanggal">-</p>
            </div>
            <div class="p-3 bg-slate-50 border border-slate-100 rounded-2xl">
                <p class="text-[11px] font-medium text-slate-500 uppercase">Kelas</p>
                <p class="text-xs font-bold text-slate-800 mt-1" id="mKelas">-</p>
            </div>
            <div class="p-3 bg-slate-50 border border-slate-100 rounded-2xl">
                <p class="text-[11px] font-medium text-slate-500 uppercase">Ambalan</p>
                <p class="text-xs font-bold text-slate-800 mt-1" id="mAmbalan">-</p>
            </div>
            <div class="p-3 bg-emerald-50 border border-emerald-100 rounded-2xl">
                <p class="text-[11px] font-semibold text-emerald-700 uppercase">Total Uang Iuran</p>
                <p class="text-xs font-extrabold text-emerald-900 mt-1" id="mTotalIuran">Rp 0</p>
            </div>
        </div>

        <div id="mLoading" class="py-8 text-center">
            <div class="inline-block h-6 w-6 animate-spin rounded-full border-2 border-emerald-600 border-t-transparent"></div>
            <p class="text-xs text-slate-500 mt-2">Mengambil data peserta...</p>
        </div>

        <div id="mContent" class="overflow-y-auto pr-1 flex-1 space-y-2" style="display: none;">
            <div class="rounded-2xl border border-slate-200 overflow-hidden">
                <table class="min-w-full divide-y divide-slate-200 text-left text-xs">
                    <thead class="bg-slate-50 text-slate-600 font-semibold">
                        <tr>
                            <th class="px-4 py-2.5">No</th>
                            <th class="px-4 py-2.5">Nama Peserta</th>
                            <th class="px-4 py-2.5">Keterangan</th>
                            <th class="px-4 py-2.5 text-right">Uang Iuran</th>
                        </tr>
                    </thead>
                    <tbody id="mTbodyPeserta" class="divide-y divide-slate-100 bg-white text-slate-700"></tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 flex items-center justify-end gap-2">
            <!-- Tombol Export Word (Di Samping Export Excel) -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($absensi) && $absensi->id): ?>
                <a href="<?php echo e(route('admin.absensi.exportWord', $absensi->id)); ?>" 
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
            <?php else: ?>
                <a href="#" onclick="exportModalWord()" 
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export Word
            </a>

            <!-- Tombol Export Excel yang Sudah Ada -->
            <a href="<?php echo e(route('admin.absensi.export', $absensi->id ?? null)); ?>" class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg">
                Export Excel
            </a>

            <!-- Tombol Tutup -->
            <button type="button" onclick="tutupDetailModal()" class="px-4 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- Modal Tambah Petugas -->
<div id="modalTambahPetugas" class="hidden fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-xs p-4">
    <div class="bg-white rounded-xl max-w-md w-full p-6 shadow-xl border border-gray-200">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-base font-bold text-gray-900">Tambah Petugas Absensi</h3>
            <button type="button" onclick="document.getElementById('modalTambahPetugas').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-lg">&times;</button>
        </div>

        <form method="POST" action="<?php echo e(route('admin.petugas.store')); ?>" class="space-y-3">
            <?php echo csrf_field(); ?>
            <div>
                <label class="block text-xs font-semibold mb-1 text-gray-700">Nama Petugas</label>
                <input type="text" name="nama" required class="w-full border border-gray-300 px-3 py-2 text-xs rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Contoh: cewek">
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1 text-gray-700">NTA Petugas</label>
                <input type="text" name="nta" required class="w-full border border-gray-300 px-3 py-2 text-xs rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="11.20.03.240409.0001">
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1 text-gray-700">Kelas Petugas</label>
                <input type="text" name="kelas_petugas" required class="w-full border border-gray-300 px-3 py-2 text-xs rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="X MPLB 1">
            </div>
            <div class="flex justify-end gap-2 pt-3">
                <button type="button" onclick="document.getElementById('modalTambahPetugas').classList.add('hidden')" class="px-3 py-1.5 bg-gray-200 text-gray-700 text-xs rounded-lg">Batal</button>
                <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
var activeDetailParams = { date: '', kelas: '', ambalan: '' };

function bukaDetailAbsensi(tanggal, kelas, ambalan) {
    var cleanTanggal = (tanggal || '').toString().trim();
    var cleanKelas = (kelas || '').toString().trim();
    var cleanAmbalan = (ambalan || '').toString().trim();

    activeDetailParams = { date: cleanTanggal, kelas: cleanKelas, ambalan: cleanAmbalan };

    var modal = document.getElementById('modalDetailAbsensi');
    var loading = document.getElementById('mLoading');
    var content = document.getElementById('mContent');

    document.getElementById('mTanggal').textContent = cleanTanggal;
    document.getElementById('mKelas').textContent = cleanKelas;
    document.getElementById('mAmbalan').textContent = cleanAmbalan;
    document.getElementById('mInfoSubheader').textContent = 'Kelas ' + cleanKelas + ' • ' + cleanAmbalan;

    modal.style.display = 'flex';
    loading.style.display = 'block';
    content.style.display = 'none';

    var url = '/admin/absensi/detail-data?date=' + encodeURIComponent(cleanTanggal) + '&kelas=' + encodeURIComponent(cleanKelas) + '&ambalan=' + encodeURIComponent(cleanAmbalan);

    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(function(res) {
        if (!res.ok) throw new Error('HTTP Status: ' + res.status);
        return res.json();
    })
    .then(function(data) {
        loading.style.display = 'none';
        if (data.success) {
            document.getElementById('mTotalIuran').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(data.total_iuran || 0);
            var tbody = document.getElementById('mTbodyPeserta');
            tbody.innerHTML = '';

            if (data.peserta && data.peserta.length > 0) {
                data.peserta.forEach(function(p, index) {
                    var status = (p.status || '-').toLowerCase();
                    var statusBadge = '<span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-700">Alpa</span>';

                    if (status === 'hadir') statusBadge = '<span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">Hadir</span>';
                    else if (status === 'izin') statusBadge = '<span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700">Izin</span>';
                    else if (status === 'sakit') statusBadge = '<span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700">Sakit</span>';

                    var row = '<tr class="hover:bg-slate-50 transition">' +
                        '<td class="px-4 py-2.5 font-medium text-slate-500">' + (index + 1) + '</td>' +
                        '<td class="px-4 py-2.5 font-semibold text-slate-900">' + p.nama + '</td>' +
                        '<td class="px-4 py-2.5">' + statusBadge + '</td>' +
                        '<td class="px-4 py-2.5 text-right font-semibold text-slate-800">Rp ' + new Intl.NumberFormat('id-ID').format(p.iuran || 0) + '</td>' +
                    '</tr>';
                    tbody.innerHTML += row;
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="4" class="text-center py-6 text-slate-400">Tidak ada daftar siswa untuk rekap ini.</td></tr>';
            }
            content.style.display = 'block';
        }
    })
    .catch(function() {
        loading.style.display = 'none';
        content.style.display = 'block';
        document.getElementById('mTbodyPeserta').innerHTML = '<tr><td colspan="4" class="text-center py-6 text-rose-500">Gagal mengambil rincian data peserta.</td></tr>';
    });
}

function tutupDetailModal() {
    var modal = document.getElementById('modalDetailAbsensi');
    if (modal) modal.style.display = 'none';
}

function exportModalExcel() {
    if (!activeDetailParams.date) return;
    var url = "/admin/absensi/export" 
        + "?date=" + encodeURIComponent(activeDetailParams.date) 
        + "&kelas=" + encodeURIComponent(activeDetailParams.kelas) 
        + "&ambalan=" + encodeURIComponent(activeDetailParams.ambalan);
    window.location.href = url;
}

function exportModalWord() {
    if (!activeDetailParams.date) return;
    var url = "/admin/absensi/export-word"
        + "?date=" + encodeURIComponent(activeDetailParams.date)
        + "&kelas=" + encodeURIComponent(activeDetailParams.kelas)
        + "&ambalan=" + encodeURIComponent(activeDetailParams.ambalan);
    window.location.href = url;
}

function togglePetugasStatus(btn, id) {
    var isCurrentlyActive = btn.getAttribute('data-active') === '1';
    var newStatus = !isCurrentlyActive;

    fetch('/admin/petugas/' + id + '/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ is_active: newStatus })
    })
    .then(function(res) { return res.json(); })
    .then(function(data) {
        if (data.success) {
            btn.setAttribute('data-active', newStatus ? '1' : '0');
            var thumb = btn.querySelector('.js-switch-thumb');
            var label = btn.parentElement.querySelector('.js-status-label');

            if (newStatus) {
                btn.classList.remove('bg-slate-300');
                btn.classList.add('bg-emerald-500');
                thumb.classList.remove('translate-x-0');
                thumb.classList.add('translate-x-5');
                if (label) {
                    label.textContent = 'Aktif';
                    label.className = 'js-status-label text-xs font-semibold text-emerald-600';
                }
            } else {
                btn.classList.remove('bg-emerald-500');
                btn.classList.add('bg-slate-300');
                thumb.classList.remove('translate-x-5');
                thumb.classList.add('translate-x-0');
                if (label) {
                    label.textContent = 'Nonaktif';
                    label.className = 'js-status-label text-xs font-semibold text-slate-400';
                }
            }
        }
    });
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/admin/absensi.blade.php ENDPATH**/ ?>