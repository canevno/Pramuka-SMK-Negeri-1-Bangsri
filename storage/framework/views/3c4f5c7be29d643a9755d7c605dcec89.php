
<?php $__env->startSection('content'); ?>
<?php
$achievements = App\Support\AchievementStore::byLevel('ranting');
?>
<section class="bg-slate-50 py-16 dark:bg-slate-950">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div class="text-center md:text-left">
                <p class="text-[10px] font-bold uppercase tracking-[0.25em] text-slate-900 dark:text-white">Prestasi Ranting</p>
                <h1 class="mt-2 text-3xl font-black tracking-tight text-slate-900 dark:text-white md:text-4xl">Capaian Tingkat Ranting</h1>
            </div>
            <a href="<?php echo e(route('achievement')); ?>" class="hidden md:inline-flex items-center rounded-lg bg-slate-900 px-5 py-2.5 text-xs font-semibold text-white transition hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-200">
                Kembali ke Semua Prestasi
            </a>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($achievements): ?>
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-4 lg:grid-cols-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $achievements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $achievement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php
                        $imageUrl = asset($achievement['image'] ?? 'images/achievement/prestasi1.jpg');
                        $winnerSocialLink = trim((string) ($achievement['winner_social_link'] ?? ''));
                    ?>
                    <article class="overflow-hidden rounded-xl border border-slate-200 bg-white transition hover:border-slate-900 dark:border-slate-800 dark:bg-black dark:hover:border-white">
                        <button type="button" class="block w-full text-left" data-achievement-image="<?php echo e($imageUrl); ?>" data-achievement-title="<?php echo e(addslashes($achievement['title'] ?? 'Prestasi')); ?>" data-achievement-category="<?php echo e(addslashes($achievement['category'] ?? 'Prestasi')); ?>" data-achievement-winner="<?php echo e(addslashes($achievement['winner'] ?? 'Anggota')); ?>" data-achievement-winning-link="<?php echo e(addslashes($winnerSocialLink)); ?>" data-achievement-description="<?php echo e(addslashes($achievement['description'] ?? 'Prestasi yang membanggakan.')); ?>" onclick="openAchievementModal(this)">
                            <div class="h-44 overflow-hidden bg-slate-100 dark:bg-slate-900 sm:h-48">
                                <img src="<?php echo e($imageUrl); ?>" alt="<?php echo e($achievement['title']); ?>" class="h-full w-full object-cover grayscale transition duration-500 hover:grayscale-0" />
                            </div>
                            <div class="space-y-2 p-4">
                                <div class="flex items-center justify-between gap-3">
                                    <span class="rounded-full bg-slate-100 px-2 py-1 text-[9px] font-bold uppercase tracking-[0.12em] text-slate-700 dark:bg-slate-900 dark:text-slate-300">
                                        <?php echo e($achievement['category'] ?? 'Prestasi'); ?>

                                    </span>
                                    <span class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400"><?php echo e($achievement['year'] ?? now()->year); ?></span>
                                </div>
                                <h2 class="text-lg font-bold text-slate-900 dark:text-white"><?php echo e($achievement['title']); ?></h2>
                                <p class="text-xs font-medium text-slate-600 dark:text-slate-400">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($winnerSocialLink !== ''): ?>
                                        Pemenang: <a href="<?php echo e($winnerSocialLink); ?>" target="_blank" rel="noopener noreferrer" class="font-semibold underline decoration-slate-400 underline-offset-4 hover:text-slate-900 dark:hover:text-white"><?php echo e($achievement['winner'] ?? 'Anggota'); ?></a>
                                    <?php else: ?>
                                        Pemenang: <?php echo e($achievement['winner'] ?? 'Anggota'); ?>

                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </p>
                                <p class="text-xs leading-5 text-slate-600 dark:text-slate-400"><?php echo e($achievement['description'] ?? 'Prestasi yang membanggakan.'); ?></p>
                            </div>
                        </button>
                    </article>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php else: ?>
            <div class="rounded-lg border border-dashed border-slate-300 bg-white p-8 text-center text-slate-500 dark:border-slate-800 dark:bg-black dark:text-slate-400">
                Belum ada data prestasi tingkat ranting.
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div id="achievementModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/85 p-4 backdrop-blur-sm md:p-8" onclick="closeAchievementModal()">
            <button type="button" class="absolute right-5 top-5 text-3xl font-light text-white/75 transition hover:text-white" aria-label="Tutup detail prestasi" onclick="closeAchievementModal()">
                &times;
            </button>

            <div class="relative w-full max-w-5xl overflow-hidden rounded-2xl border border-white/10 bg-slate-950 shadow-2xl" onclick="event.stopPropagation()">
                <div class="flex flex-col lg:flex-row">
                    <div class="flex items-center justify-center bg-slate-900 lg:w-[62%]">
                        <img id="achievementModalImage" src="" alt="Detail prestasi" class="max-h-[72vh] w-full object-contain" />
                    </div>
                    <div class="flex flex-col justify-center space-y-3 p-5 text-left sm:p-6 lg:w-[38%] lg:p-7">
                        <div class="flex flex-wrap items-center gap-2">
                            <span id="achievementModalCategory" class="rounded-full bg-slate-800 px-2.5 py-1 text-[9px] font-bold uppercase tracking-[0.12em] text-slate-200"></span>
                            <span id="achievementModalYear" class="text-[9px] font-bold uppercase tracking-[0.12em] text-slate-400"></span>
                        </div>
                        <h3 id="achievementModalTitle" class="text-xl font-black text-white sm:text-2xl"></h3>
                        <div id="achievementModalWinner" class="text-sm text-slate-300"></div>
                        <p id="achievementModalDescription" class="text-sm leading-6 text-slate-300"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Kembali Khusus Mobile (Paling Bawah) -->
        <div class="mt-10 flex justify-center md:hidden">
            <a href="<?php echo e(route('achievement')); ?>" class="inline-flex items-center rounded-lg bg-slate-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-200">
                Kembali ke Semua Prestasi
            </a>
        </div>
    </div>
</section>

<script>
    function openAchievementModal(button) {
        const modal = document.getElementById('achievementModal');
        const image = document.getElementById('achievementModalImage');
        const title = document.getElementById('achievementModalTitle');
        const category = document.getElementById('achievementModalCategory');
        const year = document.getElementById('achievementModalYear');
        const winner = document.getElementById('achievementModalWinner');
        const description = document.getElementById('achievementModalDescription');

        image.src = button.dataset.achievementImage;
        title.textContent = button.dataset.achievementTitle;
        category.textContent = button.dataset.achievementCategory;
        year.textContent = '2024';
        winner.innerHTML = button.dataset.achievementWinner ? 'Pemenang: ' + button.dataset.achievementWinner : 'Pemenang: -';
        description.textContent = button.dataset.achievementDescription || 'Prestasi yang membanggakan.';

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    }

    function closeAchievementModal() {
        const modal = document.getElementById('achievementModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeAchievementModal();
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/pages/prestasi/ranting.blade.php ENDPATH**/ ?>