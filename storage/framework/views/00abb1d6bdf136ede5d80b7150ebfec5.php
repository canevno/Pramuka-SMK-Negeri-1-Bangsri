<?php $__env->startSection('title', 'Dashboard Admin'); ?>
<?php $__env->startSection('page-heading', 'Dashboard'); ?>
<?php $__env->startSection('page-description', 'Selamat datang kembali, Admin. Panel ini dirancang untuk tata kelola sederhana, profesional, dan fokus.'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <section class="rounded-[1.75rem] border border-slate-200 bg-white p-4 shadow-sm">
        <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.32em] text-slate-400">Dashboard</p>
                <h1 class="mt-2 text-2xl font-semibold text-slate-950">Selamat datang kembali, Admin.</h1>
                <p class="mt-1 max-w-2xl text-sm text-slate-500">Kelola anggota, berita, galeri, dan pendaftaran dengan tampilan yang bersih dan profesional.</p>
            </div>
            <div class="inline-flex items-center gap-2 rounded-3xl bg-slate-50 px-3 py-2 text-sm text-slate-700 shadow-sm">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700">S</span>
                <div>
                    <p class="font-semibold text-slate-950">Scoutmind</p>
                    <p class="text-xs text-slate-500">Laporan premium</p>
                </div>
            </div>
        </div>

        <div class="mt-3 grid gap-2 sm:grid-cols-2 xl:grid-cols-5">
            <a href="<?php echo e(route('admin.anggota')); ?>" class="group rounded-[1.5rem] border border-slate-200 bg-slate-50 p-3 shadow-sm transition hover:border-emerald-200 hover:bg-white">
                <div class="flex items-center justify-between gap-2">
                    <div class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <span class="inline-flex rounded-full bg-white px-3 py-1 text-[10px] font-semibold text-emerald-700 shadow-sm">+12 dari bulan lalu</span>
                </div>
                <p class="mt-3 text-sm text-slate-500">Total Anggota</p>
                <p class="mt-2 text-2xl font-semibold text-slate-950"><?php echo e($usersCount); ?></p>
            </a>
            <a href="<?php echo e(route('admin.news')); ?>" class="group rounded-[1.5rem] border border-slate-200 bg-slate-50 p-3 shadow-sm transition hover:border-emerald-200 hover:bg-white">
                <div class="flex items-center justify-between gap-2">
                    <div class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12a3 3 0 0 1 3 3v12a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6a3 3 0 0 1 3-3zm2.25 4.5h7.5m-7.5 3h7.5"/></svg>
                    </div>
                    <span class="inline-flex rounded-full bg-white px-2.5 py-1 text-[10px] font-semibold text-emerald-700 shadow-sm">+8 dari bulan lalu</span>
                </div>
                <p class="mt-3 text-sm text-slate-500">Total Berita</p>
                <p class="mt-2 text-2xl font-semibold text-slate-950"><?php echo e($newsCount); ?></p>
            </a>
            <a href="<?php echo e(route('admin.gallery')); ?>" class="group rounded-[1.5rem] border border-slate-200 bg-slate-50 p-3 shadow-sm transition hover:border-emerald-200 hover:bg-white">
                <div class="flex items-center justify-between gap-2">
                    <div class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M4 5.25h15.75V19.5H4V5.25zm3 9l3-4 2.25 3 2.25-2.25L18 16.5"/></svg>
                    </div>
                    <span class="inline-flex rounded-full bg-white px-2.5 py-1 text-[10px] font-semibold text-emerald-700 shadow-sm">+15 dari bulan lalu</span>
                </div>
                <p class="mt-3 text-sm text-slate-500">Total Galeri</p>
                <p class="mt-2 text-2xl font-semibold text-slate-950"><?php echo e($galleryCount); ?></p>
            </a>
            <a href="<?php echo e(route('admin.pendaftaran')); ?>" class="group rounded-[1.5rem] border border-slate-200 bg-slate-50 p-4 shadow-sm transition hover:border-emerald-200 hover:bg-white">
                <div class="flex items-center justify-between gap-2">
                    <div class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M9 2.25h6A2.25 2.25 0 0 1 17.25 4.5v15a2.25 2.25 0 0 1-2.25 2.25H9A2.25 2.25 0 0 1 6.75 19.5V4.5A2.25 2.25 0 0 1 9 2.25zm0 3h6m-4.5 6h3m-3 4.5h3"/></svg>
                    </div>
                    <span class="inline-flex rounded-full bg-white px-2.5 py-1 text-[10px] font-semibold text-emerald-700 shadow-sm">+6 dari bulan lalu</span>
                </div>
                <p class="mt-3 text-sm text-slate-500">Total Pendaftaran</p>
                <p class="mt-2 text-2xl font-semibold text-slate-950"><?php echo e($registrationCount); ?></p>
            </a>
            <a href="<?php echo e(route('admin.absensi')); ?>" class="group rounded-[1.5rem] border border-slate-200 bg-slate-50 p-4 shadow-sm transition hover:border-emerald-200 hover:bg-white">
                <div class="flex items-center justify-between gap-2">
                    <div class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M4 5.25h16.5v13.5H4V5.25zm2.25 4.5h11.25m-11.25 4.5h11.25m-11.25 4.5h7.5"/></svg>
                    </div>
                    <span class="inline-flex rounded-full bg-white px-2.5 py-1 text-[10px] font-semibold text-emerald-700 shadow-sm">Data real-time</span>
                </div>
                <p class="mt-3 text-sm text-slate-500">Total Absensi</p>
                <p class="mt-2 text-2xl font-semibold text-slate-950"><?php echo e($attendanceCount); ?></p>
            </a>
        </div>
    </section>

    <section class="grid gap-3 xl:grid-cols-[1.7fr_1fr]">
        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-slate-950">Statistik Pengunjung</h2>
                    <p class="mt-1 text-sm text-slate-500">Performa pengunjung dalam 7 hari terakhir.</p>
                </div>
                <select class="rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700 outline-none">
                    <option>7 Hari Terakhir</option>
                    <option>30 Hari Terakhir</option>
                    <option>90 Hari Terakhir</option>
                </select>
            </div>
            <div class="mt-4 h-[210px] rounded-[1.5rem] bg-slate-50 p-3">
                <div class="h-full rounded-[1.5rem] bg-white p-3 shadow-sm">
                    <svg viewBox="0 0 100 55" class="h-full w-full">
                        <defs>
                            <linearGradient id="areaGradient" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#ecfdf5" />
                                <stop offset="100%" stop-color="#ffffff" />
                            </linearGradient>
                        </defs>
                        <path d="M0,42 L10,38 L20,30 L30,32 L40,24 L50,28 L60,16 L70,22 L80,18 L90,12 L100,18 L100,55 L0,55 Z" fill="url(#areaGradient)" stroke="none" />
                        <path d="M0,42 L10,38 L20,30 L30,32 L40,24 L50,28 L60,16 L70,22 L80,18 L90,12 L100,18" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <circle cx="0" cy="42" r="1.8" fill="#10b981" />
                        <circle cx="10" cy="38" r="1.8" fill="#10b981" />
                        <circle cx="20" cy="30" r="1.8" fill="#10b981" />
                        <circle cx="30" cy="32" r="1.8" fill="#10b981" />
                        <circle cx="40" cy="24" r="1.8" fill="#10b981" />
                        <circle cx="50" cy="28" r="1.8" fill="#10b981" />
                        <circle cx="60" cy="16" r="1.8" fill="#10b981" />
                        <circle cx="70" cy="22" r="1.8" fill="#10b981" />
                        <circle cx="80" cy="18" r="1.8" fill="#10b981" />
                        <circle cx="90" cy="12" r="1.8" fill="#10b981" />
                        <circle cx="100" cy="18" r="1.8" fill="#10b981" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex items-center justify-between gap-2">
                <div>
                    <h2 class="text-lg font-semibold text-slate-950">Aktivitas Terbaru</h2>
                    <p class="mt-1 text-sm text-slate-500">Rekaman terbaru dari sistem.</p>
                </div>
                <button class="rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100">Lihat semua</button>
            </div>
            <div class="mt-4 space-y-3">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $latestAttendanceRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="flex gap-4">
                        <div class="mt-1 h-3 w-3 rounded-full bg-emerald-500"></div>
                        <div>
                            <p class="font-medium text-slate-950"><?php echo e($record->participant_name); ?> — <?php echo e($record->status); ?></p>
                            <p class="mt-1 text-sm text-slate-500"><?php echo e($record->participant_kelas); ?> • <?php echo e($record->created_at->translatedFormat('d M Y H:i')); ?></p>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-3 text-sm text-slate-500">
                        Belum ada data absensi yang tersimpan.
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </section>

    <section class="grid gap-3 xl:grid-cols-[1.3fr_0.95fr]">
        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-slate-950">Pendaftaran Terbaru</h2>
                    <p class="mt-1 text-sm text-slate-500">Kelola status pendaftaran dengan cepat.</p>
                </div>
                <button class="rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100">Lihat semua</button>
            </div>
            <div class="mt-4 overflow-hidden rounded-[1.5rem] border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm text-slate-700">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-3 py-2 font-semibold uppercase tracking-[0.12em] text-slate-500">Nama</th>
                            <th class="px-3 py-2 font-semibold uppercase tracking-[0.12em] text-slate-500">Golongan</th>
                            <th class="px-3 py-2 font-semibold uppercase tracking-[0.12em] text-slate-500">Tanggal</th>
                            <th class="px-3 py-2 font-semibold uppercase tracking-[0.12em] text-slate-500">Status</th>
                            <th class="px-3 py-2 font-semibold uppercase tracking-[0.12em] text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [['name'=>'Siti Aisyah','group'=>'Penggalang','date'=>'27 Mei 2025','status'=>'Menunggu','badge'=>'bg-amber-100 text-amber-700'],['name'=>'Andi Pratama','group'=>'Penegak','date'=>'27 Mei 2025','status'=>'Disetujui','badge'=>'bg-emerald-100 text-emerald-700'],['name'=>'Rizky Maulana','group'=>'Penggalang','date'=>'26 Mei 2025','status'=>'Menunggu','badge'=>'bg-amber-100 text-amber-700'],['name'=>'Dewi Lestari','group'=>'Penegak','date'=>'26 Mei 2025','status'=>'Ditolak','badge'=>'bg-rose-100 text-rose-700']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td class="px-3 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700"><?php echo e(strtoupper(substr($item['name'],0,1))); ?></div>
                                        <div>
                                            <p class="font-semibold text-slate-950"><?php echo e($item['name']); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-2 py-2 text-slate-600"><?php echo e($item['group']); ?></td>
                                <td class="px-2 py-2 text-slate-600"><?php echo e($item['date']); ?></td>
                                <td class="px-2 py-2">
                                    <span class="inline-flex rounded-full px-3 py-1 text-[10px] font-semibold <?php echo e($item['badge']); ?>"><?php echo e($item['status']); ?></span>
                                </td>
                                <td class="px-2 py-2">
                                    <button class="inline-flex h-8 w-8 items-center justify-center rounded-2xl border border-slate-200 text-slate-500 transition hover:bg-slate-100">
                                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M12 7.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm0 5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm0 5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/></svg>
                                    </button>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-base font-semibold text-slate-950">Berita Terbaru</h2>
                    <p class="mt-1 text-sm text-slate-500">Konten terbaru yang dipublikasi.</p>
                </div>
                <button class="rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100">Lihat semua</button>
            </div>
            <div class="mt-4 space-y-3">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [['title'=>'Perkemahan Sabtu-Minggu Gugus Depan','date'=>'27 Mei 2025'],['title'=>'Pramuka SMKN 1 Bangsri Raih Juara Umum','date'=>'25 Mei 2025'],['title'=>'Latihan Rutin Ambalan Soedirman','date'=>'24 Mei 2025']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $news): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="flex gap-3 rounded-3xl border border-slate-200 bg-slate-50 p-3">
                        <div class="h-10 w-10 rounded-2xl bg-emerald-100"></div>
                        <div class="flex-1">
                            <p class="font-semibold text-slate-950"><?php echo e($news['title']); ?></p>
                            <div class="mt-2 flex items-center gap-2 text-xs text-slate-500">
                                <span><?php echo e($news['date']); ?></span>
                                <span class="inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                                <span>Dipublikasi</span>
                            </div>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/dashboard.blade.php ENDPATH**/ ?>