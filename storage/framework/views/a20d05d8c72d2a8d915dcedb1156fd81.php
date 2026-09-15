

<?php $__env->startSection('content'); ?>
<?php
    $activePembina = ($pembinas ?? collect())->where('is_active', true)->sortBy('sort_order')->values();
    $selectedPembinaId = $activePembina->first()?->id ?? null;
    $dewanAnggota = ($dewanAnggota ?? collect())->where('is_active', true)->sortBy('sort_order')->values();
?>

<div class="bg-slate-50 text-slate-900 pt-8 pb-16 min-h-screen" x-data="{ activeTab: 'pembina', selectedPembina: <?php echo e($selectedPembinaId ?? 'null'); ?> }" x-init="if (window.location.hash === '#anggota-dewan') activeTab = 'anggota-dewan'">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <aside class="order-2 lg:order-1 lg:col-span-4 xl:col-span-3 lg:sticky lg:top-32 self-start z-10">
                <nav class="rounded-2xl border border-slate-200 bg-white p-3 shadow-sm">
                    <div>
                        <span class="block px-3 py-1 text-base font-bold text-slate-950 mb-1 border-b border-slate-100 pb-2">
                            Organisasi
                        </span>
                        <div class="space-y-1 mt-2">
                            <a href="<?php echo e(route('pembina')); ?>"
                                class="block w-full rounded-lg px-3 py-1.5 text-left text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-slate-950 <?php echo e(request()->routeIs('pembina') ? 'bg-slate-100 font-bold text-slate-950' : ''); ?>">
                                <span>Pembina</span>
                            </a>

                            <a href="<?php echo e(route('dewan-kehormatan')); ?>"
                                class="block w-full rounded-lg px-3 py-1.5 text-left text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-slate-950 <?php echo e(request()->routeIs('dewan-kehormatan') ? 'bg-slate-100 font-bold text-slate-950' : ''); ?>">
                                <span>Dewan Kehormatan</span>
                            </a>

                            <a href="<?php echo e(route('dewan-ambalan')); ?>"
                                class="block w-full rounded-lg px-3 py-1.5 text-left text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-slate-950 <?php echo e(request()->routeIs('dewan-ambalan') ? 'bg-slate-100 font-bold text-slate-950' : ''); ?>">
                                <span>Dewan Ambalan</span>
                            </a>

                            <a href="<?php echo e(route('anggota-dewan')); ?>"
                                class="block w-full rounded-lg px-3 py-1.5 text-left text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-slate-950 <?php echo e(request()->routeIs('anggota-dewan') ? 'bg-slate-100 font-bold text-slate-950' : ''); ?>">
                                <span>Anggota Dewan</span>
                            </a>

                            <a href="<?php echo e(route('mitra')); ?>"
                                class="block w-full rounded-lg px-3 py-1.5 text-left text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-slate-950 <?php echo e(request()->routeIs('mitra') ? 'bg-slate-100 font-bold text-slate-950' : ''); ?>">
                                <span>Mitra</span>
                            </a>

                            <a href="<?php echo e(route('alumni')); ?>"
                                class="block w-full rounded-lg px-3 py-1.5 text-left text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-slate-950 <?php echo e(request()->routeIs('alumni') ? 'bg-slate-100 font-bold text-slate-950' : ''); ?>">
                                <span>Alumni</span>
                            </a>
                        </div>
                    </div>
                </nav>
            </aside>

            <main class="order-1 lg:order-2 lg:col-span-8 xl:col-span-9">
                <div class="rounded-2xl bg-white border border-slate-200 p-6 sm:p-8 shadow-sm">
                    <div x-show="activeTab === 'pembina'" x-cloak>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-6 text-center lg:text-left">
                            Pembina Pramuka SMKN 1 Bangsri
                        </h1>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activePembina->isEmpty()): ?>
                            <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-8 text-center text-slate-500">
                                Belum ada data pembina yang aktif untuk ditampilkan.
                            </div>
                        <?php else: ?>
                            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $activePembina; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pembina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <?php
                                        $image = $pembina->photo_url ?: 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=600';
                                    ?>

                                    <?php
                                        $description = trim((string) ($pembina->bio ?? '')) ?: 'Pembina aktif yang membimbing dan mengarahkan kegiatan Pramuka agar berjalan optimal.';
                                    ?>

                                    <div @click="selectedPembina = (selectedPembina === <?php echo e($pembina->id); ?> ? null : <?php echo e($pembina->id); ?>)"
                                        :class="selectedPembina === <?php echo e($pembina->id); ?>

                                            ? 'bg-[#183a2d] border-[#183a2d] ring-2 ring-[#183a2d]'
                                            : 'bg-white border-slate-200 hover:border-slate-300'"
                                        class="relative rounded-xl border p-1.5 cursor-pointer transition-all duration-300 select-none shadow-sm lg:scale-[0.96] lg:hover:scale-[0.97]">
                                        <div class="relative overflow-hidden rounded-lg aspect-square bg-slate-100">
                                            <img src="<?php echo e($image); ?>" alt="<?php echo e($pembina->name); ?>" class="w-full h-full object-cover transition duration-300"
                                                :class="selectedPembina === <?php echo e($pembina->id); ?> ? 'grayscale-0' : 'grayscale hover:grayscale-0'">
                                        </div>

                                        <div class="px-2 pt-2 pb-1">
                                            <h3 class="font-bold text-sm leading-tight transition-colors"
                                                :class="selectedPembina === <?php echo e($pembina->id); ?> ? 'text-white' : 'text-slate-900'">
                                                <?php echo e($pembina->name); ?>

                                            </h3>
                                            <p class="text-[11px] transition-colors mt-0.5"
                                               :class="selectedPembina === <?php echo e($pembina->id); ?> ? 'text-emerald-300' : 'text-slate-500'">
                                                <?php echo e($pembina->jabatan); ?>

                                            </p>
                                            <p class="mt-2 text-[10.5px] leading-relaxed transition-colors"
                                               :class="selectedPembina === <?php echo e($pembina->id); ?> ? 'text-emerald-100' : 'text-slate-600'">
                                                <?php echo e(Str::limit($description, 100)); ?>

                                            </p>
                                        </div>
                                    </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div x-show="activeTab === 'dewan-kehormatan'" x-cloak>
                        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-4">Dewan Kehormatan</h1>
                        <p class="text-slate-700 leading-relaxed mb-6">
                            Dewan Kehormatan bertugas menjaga integritas, kode etik, Kode Kehormatan Pramuka (Satya dan Darma), serta memberikan pertimbangan penghargaan dan pelanggaran disiplin.
                        </p>
                    </div>

                    <div x-show="activeTab === 'dewan-ambalan'" x-cloak>
                        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-4">Dewan Ambalan</h1>
                        <p class="text-slate-700 leading-relaxed mb-6">
                            Badan pengurus harian penegak yang merencanakan, mengelola, dan melaksanakan program kerja harian ambalan putra maupun putri.
                        </p>
                    </div>

                    <div id="anggota-dewan" x-show="activeTab === 'anggota-dewan'" x-cloak>
                        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-4">Anggota Dewan</h1>
                        <p class="text-slate-700 leading-relaxed mb-6">
                            Daftar seluruh fungsionaris dan anggota aktif yang masuk dalam struktur kepengurusan Dewan Ambalan periode berjalan.
                        </p>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dewanAnggota->isEmpty()): ?>
                            <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-8 text-center text-slate-500">
                                Belum ada data anggota dewan yang aktif untuk ditampilkan.
                            </div>
                        <?php else: ?>
                            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $dewanAnggota; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <?php
                                        $memberImage = $member->photo_url ?: 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=600';
                                    ?>

                                    <div class="rounded-2xl border border-slate-200 bg-white p-2 shadow-sm">
                                        <div class="relative overflow-hidden rounded-xl aspect-square bg-slate-100">
                                            <img src="<?php echo e($memberImage); ?>" alt="<?php echo e($member->nama); ?>" class="h-full w-full object-cover">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($member->status)): ?>
                                                <span class="absolute top-2 left-2 rounded-full bg-emerald-500/90 px-2 py-1 text-[10px] font-semibold uppercase tracking-wide text-white">
                                                    <?php echo e($member->status); ?>

                                                </span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>

                                        <div class="px-2 pt-3 pb-1">
                                            <h3 class="text-sm font-bold text-slate-900 sm:text-base"><?php echo e($member->nama); ?></h3>
                                            <p class="mt-1 text-xs text-slate-500"><?php echo e($member->jabatan ?: 'Anggota Dewan'); ?></p>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($member->kelas_asal) || !empty($member->sangga) || !empty($member->sub_sangga)): ?>
                                                <p class="mt-2 text-[10px] font-medium uppercase tracking-[0.12em] text-slate-400">
                                                    <?php echo e(trim(implode(' • ', array_filter([$member->kelas_asal, $member->sangga, $member->sub_sangga]))) ?: 'Anggota aktif'); ?>

                                                </p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div x-show="activeTab === 'mitra'" x-cloak>
                        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-4">Mitra Kerjasama</h1>
                        <p class="text-slate-700 leading-relaxed mb-6">
                            Informasi mengenai mitra eksternal, Kwartir Ranting/Cabang, instansi pemerintah, dan organisasi pendukung kegiatan ambalan.
                        </p>
                    </div>

                    <!-- Tab Alumni -->
                    <div x-show="activeTab === 'alumni'" x-cloak>
                        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-4">Alumni Ambalan</h1>
                        <p class="text-slate-700 leading-relaxed mb-6">
                            Wadah komunikasi dan ikatan alumni Pramuka Penegak yang terus memberikan dukungan serta bimbingan bagi ambalan.
                        </p>
                    </div>

                </div>
            </main>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/pages/pembina.blade.php ENDPATH**/ ?>