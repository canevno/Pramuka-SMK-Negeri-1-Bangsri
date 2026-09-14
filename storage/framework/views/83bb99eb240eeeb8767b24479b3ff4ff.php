<section id="prestasi" class="py-16 sm:py-20 bg-white dark:bg-gray-950 transition-colors duration-200">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-8 sm:mb-10">
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white font-['Poppins'] mb-2 tracking-tight">
                PRESTASI
            </h2>
            <p class="text-slate-600 dark:text-slate-400 text-sm sm:text-base max-w-xl mx-auto">
                Pencapaian dan penghargaan yang telah diraih oleh pramuka SMK Negeri 1 Bangsri.
            </p>
        </div>


        <?php
            $achievements = App\Support\AchievementStore::all();
        ?>

        <!-- Achievement Cards Grid -->
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-4 lg:grid-cols-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $achievements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $achievement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <?php
                    $detailRoute = match (strtolower(trim((string) ($achievement['category'] ?? '')))) {
                        'tingkat ranting', 'ranting' => route('prestasi.ranting'),
                        'tingkat cabang', 'cabang' => route('prestasi.cabang'),
                        'tingkat jateng', 'jateng', 'tingkat jawa tengah', 'jawa tengah', 'daerah' => route('prestasi.jateng'),
                        'tingkat nasional', 'nasional' => route('prestasi.nasional'),
                        default => route('achievement'),
                    };
                    $winnerSocialLink = trim((string) ($achievement['winner_social_link'] ?? ''));
                ?>

                <article class="bg-white dark:bg-gray-900 rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden flex flex-col h-full transition hover:border-slate-400 dark:hover:border-slate-600">
                    <!-- Card Image -->
                    <div class="h-36 sm:h-40 bg-slate-100 dark:bg-slate-800 flex-shrink-0">
                        <img src="<?php echo e(asset($achievement['image'] ?? 'images/achievement/prestasi1.jpg')); ?>" 
                             alt="<?php echo e($achievement['title']); ?>" 
                             class="w-full h-full object-cover"
                             onerror="this.src='https://ui-avatars.com/api/?name=<?php echo e(urlencode($achievement['title'])); ?>&background=1e293b&color=fff&size=400'">
                    </div>
                    
                    <!-- Card Content -->
                    <div class="p-4 flex flex-col flex-grow">
                        <h3 class="font-bold text-slate-900 dark:text-white text-sm sm:text-base leading-snug mb-1 line-clamp-2">
                            <?php echo e($achievement['title']); ?>

                        </h3>
                        <p class="text-[10px] sm:text-xs text-slate-500 dark:text-slate-400 mb-2">
                            <?php echo e($achievement['category']); ?> — <?php echo e($achievement['year']); ?>

                        </p>

                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed flex-grow line-clamp-3">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($winnerSocialLink !== ''): ?>
                                Pemenang: <a href="<?php echo e($winnerSocialLink); ?>" target="_blank" rel="noopener noreferrer" class="font-semibold text-slate-900 underline decoration-slate-400 underline-offset-4 hover:text-slate-600 dark:text-white dark:hover:text-slate-200">
                                    <?php echo e($achievement['winner'] ?? 'Anggota'); ?>

                                </a>
                            <?php else: ?>
                                Pemenang: <?php echo e($achievement['winner'] ?? 'Anggota'); ?>

                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </p>
                        
                        <!-- Bottom Link -->
                        <div class="pt-2 mt-3 border-t border-slate-100 dark:border-slate-800">
                            <a href="<?php echo e($detailRoute); ?>" class="group inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-2 py-1.5 text-slate-800 shadow-sm transition-all duration-200 hover:scale-[0.98] hover:border-slate-400 hover:shadow-sm dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:border-slate-500">
                                <span class="px-2 text-[12px] sm:text-[13px] font-medium tracking-normal text-slate-900 dark:text-white">View all</span>
                                <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-slate-900 text-sm font-medium text-white transition-colors duration-200 group-hover:bg-slate-700 dark:bg-white dark:text-slate-900 dark:group-hover:bg-slate-200">
                                    →
                                </span>
                            </a>
                        </div>
                    </div>
                </article>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </div>
</section><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/sections/home/achievement.blade.php ENDPATH**/ ?>