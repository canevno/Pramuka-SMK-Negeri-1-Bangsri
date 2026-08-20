

<?php $__env->startSection('content'); ?>
<section class="py-12 bg-white transition-colors duration-200">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="mt-6 text-4xl sm:text-5xl font-bold tracking-tight text-slate-900 max-w-4xl mx-auto">Kabar Kegiatan dan Prestasi Terbaru</h1>
            <p class="mt-5 max-w-2xl mx-auto text-sm leading-7 text-slate-500">Ikuti berita terbaru dari kegiatan, lomba, dan program pengembangan karakter anggota Pramuka SMK Negeri 1 Bangsri.</p>
        </div>

        <div class="grid gap-8 md:grid-cols-[minmax(0,1fr)_minmax(0,1fr)] lg:grid-cols-[1.1fr_1.8fr_0.9fr]">
            <!-- Hero center on desktop, top on tablet/mobile -->
            <div class="order-1 md:col-span-2 lg:order-2 lg:col-span-1 space-y-6">
                <article class="overflow-hidden rounded-2xl border border-slate-300 bg-white shadow-sm transition duration-300 hover:shadow-md">
                    <div class="px-6 py-3">
                        <p class="text-[10px] uppercase tracking-[0.35em] font-semibold text-slate-400">Article</p>
                    </div>
                    <div class="overflow-hidden">
                        <img src="<?php echo e(asset('images/hero/imagehero1.png')); ?>" alt="Membangun Karakter Melalui Disiplin Kepanduan" class="w-full h-[180px] object-cover object-top transition duration-500 hover:scale-105">
                    </div>
                    <div class="px-6 py-4 text-left">
                        <h2 class="text-2xl sm:text-3xl font-bold leading-tight text-slate-900">Membangun Karakter Melalui Disiplin Kepanduan</h2>
                        <p class="mt-3 max-w-xl text-sm leading-6 text-slate-500">Pramuka SMK Negeri 1 Bangsri memperkuat karakter generasi muda melalui kegiatan disiplin kepanduan, latihan lapangan, dan nilai-nilai kebersamaan.</p>
                        <div class="mt-4 flex items-center gap-2 text-xs text-slate-400 uppercase tracking-[0.2em]">
                            <span>21 Juli 2026</span>
                            <span class="inline-flex h-0.5 w-0.5 rounded-full bg-slate-300"></span>
                            <span>5 menit baca</span>
                        </div>
                    </div>
                </article>

                <article class="overflow-hidden rounded-2xl border border-slate-300 bg-white shadow-sm transition duration-300 hover:shadow-md">
                    <div class="px-6 py-3">
                        <p class="text-[10px] uppercase tracking-[0.35em] font-semibold text-slate-400">Article</p>
                    </div>
                    <div class="overflow-hidden">
                        <img src="<?php echo e(asset('images/hero/imagehero6.png')); ?>" alt="Kegiatan Peningkatan Keterampilan Kepanduan" class="w-full h-[180px] object-cover object-top transition duration-500 hover:scale-105">
                    </div>
                    <div class="px-6 py-4 text-left">
                        <h2 class="text-2xl sm:text-3xl font-bold leading-tight text-slate-900">Peningkatan Keterampilan Kepanduan Melalui Pelatihan Lapangan</h2>
                        <p class="mt-3 max-w-xl text-sm leading-6 text-slate-500">Para peserta mengikuti pelatihan lapangan intensif untuk meningkatkan keterampilan kepramukaan dan membangun kemampuan kerja sama tim.</p>
                        <div class="mt-4 flex items-center gap-2 text-xs text-slate-400 uppercase tracking-[0.2em]">
                            <span>28 Agustus 2026</span>
                            <span class="inline-flex h-0.5 w-0.5 rounded-full bg-slate-300"></span>
                            <span>4 menit baca</span>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Left column cards -->
            <div class="space-y-4 order-2 lg:order-1">
                <div class="px-2 py-1">
                    <h2 class="text-lg font-semibold text-slate-900">Berita Terbaru</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-500">Kabar terbaru tentang kegiatan di pangkalan SMKN 1 Bangsri.</p>
                </div>
                <article class="group overflow-hidden rounded-xl border border-slate-300 bg-white shadow-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-md cursor-pointer">
                    <div class="flex flex-col gap-3 p-4 md:flex-row md:items-center">
                        <div class="min-w-0 flex-1">
                            <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-slate-500">Kegiatan</p>
                            <h3 class="mt-2 text-lg font-semibold leading-tight text-slate-900">Persiapan Jambore Cabang Jepara 2024</h3>
                            <p class="mt-2 text-[11px] text-slate-400 uppercase tracking-[0.2em]">Januari 3, 2024</p>
                        </div>
                        <div class="h-32 w-full overflow-hidden bg-slate-100 md:w-32 md:h-32">
                            <img src="<?php echo e(asset('images/hero/imagehero.png')); ?>" alt="Persiapan Jambore Cabang" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        </div>
                    </div>
                </article>

                <article class="group overflow-hidden rounded-xl border border-slate-300 bg-white shadow-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-md cursor-pointer">
                    <div class="flex flex-col gap-3 p-4 md:flex-row md:items-center">
                        <div class="min-w-0 flex-1">
                            <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-slate-500">Pelatihan</p>
                            <h3 class="mt-2 text-lg font-semibold leading-tight text-slate-900">Pelatihan Dasar Bantara</h3>
                            <p class="mt-2 text-[11px] text-slate-400 uppercase tracking-[0.2em]">Februari 12, 2024</p>
                        </div>
                        <div class="h-32 w-full overflow-hidden bg-slate-100 md:w-32 md:h-32">
                            <img src="<?php echo e(asset('images/logokegiatan1.png')); ?>" alt="Pelatihan Dasar Bantara" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        </div>
                    </div>
                </article>

                <article class="group overflow-hidden rounded-xl border border-slate-300 bg-white shadow-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-md cursor-pointer">
                    <div class="flex flex-col gap-3 p-4 md:flex-row md:items-center">
                        <div class="min-w-0 flex-1">
                            <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-slate-500">Pengumuman</p>
                            <h3 class="mt-2 text-lg font-semibold leading-tight text-slate-900">Pembukaan Ekspedisi Alam dan Orientasi Lapangan 2026</h3>
                            <p class="mt-2 text-[11px] text-slate-400 uppercase tracking-[0.2em]">Juli 1, 2026</p>
                        </div>
                        <div class="h-32 w-full overflow-hidden bg-slate-100 md:w-32 md:h-32">
                            <img src="<?php echo e(asset('images/hero/imagehero2.png')); ?>" alt="Ekspedisi Alam" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        </div>
                    </div>
                </article>

                <article class="group overflow-hidden rounded-xl border border-slate-300 bg-white shadow-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-md cursor-pointer">
                    <div class="flex flex-col gap-3 p-4 md:flex-row md:items-center">
                        <div class="min-w-0 flex-1">
                            <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-slate-500">Kegiatan</p>
                            <h3 class="mt-2 text-lg font-semibold leading-tight text-slate-900">Aksi Sosial dan Penghijauan Lapangan Sekolah</h3>
                            <p class="mt-2 text-[11px] text-slate-400 uppercase tracking-[0.2em]">Agustus 3, 2026</p>
                        </div>
                        <div class="h-32 w-full overflow-hidden bg-slate-100 md:w-32 md:h-32">
                            <img src="<?php echo e(asset('images/hero/imagehero3.png')); ?>" alt="Penghijauan Lapangan" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        </div>
                    </div>
                </article>
            </div>

            <!-- Right column popular list -->
            <aside class="space-y-6 order-3 lg:order-3">
                <div class="">
                    <div class="px-2 py-1">
                        <h2 class="text-lg font-semibold text-slate-900">Berita Populer</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-500">Artikel yang paling banyak dibaca oleh komunitas kami.</p>
                    </div>
                    <div class="mt-3 space-y-4">
                        <!-- Mobile-first: match bottom news card size; Desktop (lg) will keep compact sidebar look -->
                        <article class="mx-auto w-full max-w-full overflow-hidden rounded-xl border border-slate-300 bg-white shadow-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-md flex flex-row items-center gap-4 p-4 lg:flex-col lg:items-start lg:p-4">
                            <a href="#" class="flex items-center gap-4 w-full">
                                <div class="h-[110px] w-[110px] flex-shrink-0 overflow-hidden bg-slate-100 rounded-l-xl lg:rounded-l-none lg:rounded-t-xl lg:w-20 lg:h-20">
                                    <img src="<?php echo e(asset('images/logokegiatan2.png')); ?>" alt="Penerimaan Tamu Ambalan" class="h-full w-full object-cover">
                                </div>
                                <div class="p-2.5 space-y-2 flex-1">
                                    <p class="text-[9px] font-semibold uppercase tracking-[0.35em] text-slate-500">Kegiatan</p>
                                    <h3 class="text-sm font-semibold leading-tight text-slate-900">Penerimaan Tamu Ambalan 2024 Berlangsung Meriah</h3>
                                    <p class="text-[10px] uppercase tracking-[0.25em] text-slate-400">Januari 12, 2024</p>
                                </div>
                            </a>
                        </article>

                        <article class="mx-auto w-full max-w-full overflow-hidden rounded-xl border border-slate-300 bg-white shadow-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-md flex flex-row items-center gap-4 p-4 lg:flex-col lg:items-start lg:p-4">
                            <a href="#" class="flex items-center gap-4 w-full">
                                <div class="h-[110px] w-[110px] flex-shrink-0 overflow-hidden bg-slate-100 rounded-l-xl lg:rounded-l-none lg:rounded-t-xl lg:w-20 lg:h-20">
                                    <img src="<?php echo e(asset('images/hero/imagehero1.png')); ?>" alt="Prestasi Pramuka" class="h-full w-full object-cover">
                                </div>
                                <div class="p-2.5 space-y-2 flex-1">
                                    <p class="text-[9px] font-semibold uppercase tracking-[0.35em] text-slate-500">Prestasi</p>
                                    <h3 class="text-sm font-semibold leading-tight text-slate-900">Prestasi Pramuka SMK Negeri 1 Bangsri</h3>
                                    <p class="text-[10px] uppercase tracking-[0.25em] text-slate-400">Maret 8, 2024</p>
                                </div>
                            </a>
                        </article>

                        <article class="mx-auto w-full max-w-full overflow-hidden rounded-xl border border-slate-300 bg-white shadow-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-md flex flex-row items-center gap-4 p-4 lg:flex-col lg:items-start lg:p-4">
                            <a href="#" class="flex items-center gap-4 w-full">
                                <div class="h-[110px] w-[110px] flex-shrink-0 overflow-hidden bg-slate-100 rounded-l-xl lg:rounded-l-none lg:rounded-t-xl lg:w-20 lg:h-20">
                                    <img src="<?php echo e(asset('images/logo/smklogo.png')); ?>" alt="Lomba Kepramukaan" class="h-full w-full object-cover">
                                </div>
                                <div class="p-2.5 space-y-2 flex-1">
                                    <p class="text-[9px] font-semibold uppercase tracking-[0.35em] text-slate-500">Kepanduan</p>
                                    <h3 class="text-sm font-semibold leading-tight text-slate-900">Lomba Kepramukaan dan Penguatan Karakter</h3>
                                    <p class="text-[10px] uppercase tracking-[0.25em] text-slate-400">April 16, 2024</p>
                                </div>
                            </a>
                        </article>

                        <article class="mx-auto w-full max-w-full overflow-hidden rounded-xl border border-slate-300 bg-white shadow-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-md flex flex-row items-center gap-4 p-4 lg:flex-col lg:items-start lg:p-4">
                            <a href="#" class="flex items-center gap-4 w-full">
                                <div class="h-[110px] w-[110px] flex-shrink-0 overflow-hidden bg-slate-100 rounded-l-xl lg:rounded-l-none lg:rounded-t-xl lg:w-20 lg:h-20">
                                    <img src="<?php echo e(asset('images/hero/imagehero.png')); ?>" alt="Bakti Lingkungan" class="h-full w-full object-cover">
                                </div>
                                <div class="p-2.5 space-y-2 flex-1">
                                    <p class="text-[9px] font-semibold uppercase tracking-[0.35em] text-slate-500">Kegiatan</p>
                                    <h3 class="text-sm font-semibold leading-tight text-slate-900">Kegiatan Bakti Lingkungan dan Aksi Sosial Donor Darah</h3>
                                    <p class="text-[10px] uppercase tracking-[0.25em] text-slate-400">Mei 5, 2024</p>
                                </div>
                            </a>
                        </article>
                    </div>
                </div>
            </aside>
        </div>

        <section class="mt-16">
            <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $newsItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <article class="mx-auto w-full max-w-full lg:max-w-[260px] overflow-hidden rounded-xl border border-slate-300 bg-white shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-lg flex flex-row items-center gap-4 lg:flex-col lg:items-start">
                        <div class="h-[110px] w-[110px] overflow-hidden bg-slate-100 shrink-0 rounded-l-xl lg:rounded-l-none lg:rounded-t-xl lg:w-full lg:h-[8rem]">
                            <img src="<?php echo e(asset($item['image'])); ?>" alt="<?php echo e($item['alt']); ?>" class="h-full w-full object-cover">
                        </div>
                        <div class="p-2.5 space-y-2 flex-1">
                            <p class="text-[7px] font-semibold uppercase tracking-[0.3em] text-slate-500"><?php echo e($item['category']); ?></p>
                            <h3 class="text-sm font-semibold leading-snug text-slate-900"><?php echo e($item['title']); ?></h3>
                            <p class="text-[8px] uppercase tracking-[0.25em] text-slate-400"><?php echo e($item['date']); ?></p>
                            <p class="text-[11px] leading-5 text-slate-600"><?php echo e($item['description']); ?></p>
                        </div>
                    </article>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </section>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/pages/news.blade.php ENDPATH**/ ?>