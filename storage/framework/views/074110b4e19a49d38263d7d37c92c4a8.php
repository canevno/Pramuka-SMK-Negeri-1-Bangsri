<?php
    $sambutanTitle = \App\Models\Setting::getValue('sambutan_title') ?: 'Sambutan Ketua Gugus Depan';
    $sambutanSubtitle = \App\Models\Setting::getValue('sambutan_subtitle') ?: 'Jepara, 17 Juni 2026';
    $sambutanDescription = \App\Models\Setting::getValue('sambutan_description') ?: 'Assalamualaikum Wr. Wb. Para pemuda Indonesia yang bercita-cita luhur, demi kualitas sumber daya manusia untuk masa depan bangsa yang lebih baik, pelajar dan pemuda harus memiliki karakter yang kuat. Dalam menghadapi tantangan arus globalisasi, pembelajaran tentang kepramukaan menjadi sangat penting. Website Pramuka Gugus Depan sebagai salah satu langkah nyata dalam menggali perkenalan dan memberikan teknologi informasi kepada pemuda. Website ini dibangun untuk membantu penyampaian informasi kegiatan pramuka kepada peserta didik dan orang tua.';
    $sambutanParagraphs = array_values(array_filter(array_map(function ($paragraph) {
        return trim($paragraph);
    }, preg_split('/\r\n|\r|\n\s*\n/', trim((string) $sambutanDescription))), static fn($paragraph) => $paragraph !== ''));
    if (empty($sambutanParagraphs)) {
        $sambutanParagraphs = [''];
    }

    $normalizeImagePath = function ($image) {
        if (empty($image)) {
            return null;
        }

        $clean = trim((string) $image);

        if ($clean === '') {
            return null;
        }

        if (str_starts_with($clean, 'http://') || str_starts_with($clean, 'https://')) {
            return $clean;
        }

        $clean = ltrim($clean, '/');

        if (str_starts_with($clean, 'storage/')) {
            return asset($clean);
        }

        return asset('storage/' . $clean);
    };

    $sambutanImage = $normalizeImagePath(\App\Models\Setting::getValue('sambutan_image'));
    $sambutanInstagram = \App\Models\Setting::getValue('sambutan_instagram');
    $sambutanFacebook = \App\Models\Setting::getValue('sambutan_facebook');
?>

<section class="w-full bg-white py-10 text-slate-800 md:py-14">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="mb-8 md:mb-10">
            <h2 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                <?php echo e($sambutanTitle); ?>

            </h2>
            <p class="mt-2 text-base text-slate-600 md:text-lg font-medium">
                <?php echo e($sambutanSubtitle); ?>

            </p>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12 items-start">
            
            <!-- Left: Photo Section -->
            <div class="md:col-span-1 flex justify-center md:justify-start">
                <div class="w-full max-w-xs">
                    <!-- Photo Container -->
                    <div class="mb-6 overflow-hidden rounded-lg border-2 border-slate-200 bg-gradient-to-br from-slate-100 to-slate-200 shadow-xl">
                        <img src="<?php echo e($sambutanImage ?: asset('images/logos/kagudep.png')); ?>" 
                             alt="<?php echo e($sambutanTitle); ?>" 
                             class="h-auto w-full max-h-[420px] object-contain">
                    </div>
                    
                    <!-- Name & Title -->
                    <div class="text-center">
                        <h3 class="text-xl font-semibold text-slate-900">
                            Shaifur Rizqi Zein, S.Pd.
                        </h3>
                        <p class="mt-1 text-sm font-medium text-slate-600">
                            Ketua Gugus Depan
                        </p>
                        <div class="mt-4 flex justify-center gap-4">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sambutanInstagram): ?>
                                <a href="<?php echo e($sambutanInstagram); ?>" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   class="inline-block text-slate-500 transition-colors duration-200 hover:text-pink-500">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"></path>
                                    </svg>
                                </a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sambutanFacebook): ?>
                                <a href="<?php echo e($sambutanFacebook); ?>" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   class="inline-block text-slate-500 transition-colors duration-200 hover:text-blue-500">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M8.29 20v-7.21H5.5V9.25h2.79V7.44c0-2.77 1.693-4.285 4.194-4.285 1.297 0 2.456.097 2.762.141v3.202h-1.894c-1.486 0-1.772.707-1.772 1.742v2.281h3.542l-.46 3.54h-3.082V20H8.29z"></path>
                                    </svg>
                                </a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Text Content -->
            <div class="md:col-span-2">
                <div class="prose prose-lg max-w-none">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $sambutanParagraphs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paragraph): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <p class="mb-4 last:mb-0 leading-relaxed text-justify font-medium text-slate-700">
                            <?php echo nl2br(e($paragraph)); ?>

                        </p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .prose {
        --tw-prose-body: rgb(51 65 85);
        --tw-prose-headings: rgb(15 23 42);
    }
</style>


<?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/sections/home/sambutan.blade.php ENDPATH**/ ?>