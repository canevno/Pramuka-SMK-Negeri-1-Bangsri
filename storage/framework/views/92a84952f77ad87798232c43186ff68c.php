

<?php $__env->startSection('title', 'Galeri Visual — Moodboard Exhibition'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $galleryItems = $galleryItems ?? \App\Models\GalleryItem::query()
        ->where('is_published', true)
        ->orderByDesc('is_featured')
        ->orderByDesc('published_at')
        ->orderByDesc('id')
        ->get();

    $resolveGalleryImage = function ($path) {
        if (empty($path)) {
            return asset('images/gallery/default.jpg');
        }

        $normalized = trim((string) $path);
        $normalized = str_replace('\\', '/', $normalized);
        $normalized = ltrim($normalized, '/');

        if (str_starts_with($normalized, 'http')) {
            return $normalized;
        }

        if (str_starts_with($normalized, 'public/')) {
            $normalized = preg_replace('#^public/#', '', $normalized);
        }

        if (str_starts_with($normalized, 'storage/')) {
            return asset($normalized);
        }

        if (str_starts_with($normalized, 'gallery/')) {
            return \Illuminate\Support\Facades\Storage::url($normalized);
        }

        if (str_contains($normalized, '/storage/')) {
            return asset(ltrim($normalized, '/'));
        }

        if (str_contains($normalized, 'storage/')) {
            return asset($normalized);
        }

        return asset($normalized);
    };
?>

<main class="w-full min-h-screen bg-[#f4f3ef] dark:bg-gray-950 text-neutral-900 dark:text-white py-10 px-4 sm:px-6 md:px-10 lg:px-16 transition-colors duration-200">
    <div class="mx-auto max-w-6xl">
        <div class="mb-8 text-center">
            <h1 class="mt-3 text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl md:text-5xl">
                Dokumentasi Kegiatan Pramuka
            </h1>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($galleryItems->isEmpty()): ?>
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white/60 p-10 text-center text-sm text-slate-600 dark:border-slate-700 dark:bg-slate-900/40 dark:text-slate-300">
                Belum ada foto yang dipublikasikan. Silakan unggah foto dari panel admin terlebih dahulu.
            </div>
        <?php else: ?>
            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:gap-4 lg:grid-cols-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $galleryItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $imageUrl = $resolveGalleryImage($item->image); ?>

                    <div class="group cursor-pointer overflow-hidden rounded-2xl border border-slate-200 bg-neutral-200 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md dark:border-gray-800 dark:bg-neutral-800"
                         onclick="openModal('<?php echo e($imageUrl); ?>', '<?php echo e(addslashes($item->title ?: ($item->alt_text ?: 'Galeri Pramuka'))); ?>', '<?php echo e(addslashes($item->location ?: '')); ?>')">
                        <div class="aspect-[4/3] overflow-hidden">
                            <img src="<?php echo e($imageUrl); ?>"
                                 alt="<?php echo e($item->alt_text ?: $item->title); ?>"
                                 class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div id="imageModal" class="fixed inset-0 z-50 hidden bg-black/90 backdrop-blur-md flex items-center justify-center p-4 md:p-8" onclick="closeModal()">
        <button type="button" class="absolute top-6 right-8 text-white/70 hover:text-white text-4xl font-light focus:outline-none z-10" onclick="closeModal()">
            &times;
        </button>

        <div class="relative max-w-5xl max-h-[90vh] flex flex-col items-center justify-center" onclick="event.stopPropagation()">
            <img id="modalImage" src="" alt="" class="max-w-full max-h-[75vh] object-contain shadow-2xl rounded-sm">
            <div class="mt-4 flex flex-col items-center gap-2 text-center">
                <p id="modalCaption" class="text-white/80 font-serif italic text-xs md:text-sm tracking-widest uppercase"></p>
                <p id="modalLocation" class="hidden max-w-full px-3 text-[10px] font-medium uppercase tracking-[0.16em] text-slate-200 sm:text-xs"></p>
                <button type="button" id="downloadBtn" onclick="triggerDownload()" class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 hover:bg-white/20 text-white text-xs font-mono uppercase tracking-wider rounded-md border border-white/20 backdrop-blur-sm transition-all cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                    </svg>
                    <span>Unduh Gambar</span>
                </button>
            </div>
        </div>
    </div>
</main>

<script>
    let activeImageSrc = '';
    let activeCaption = '';

    function openModal(imageSrc, caption, location = '') {
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        const modalCaption = document.getElementById('modalCaption');
        const modalLocation = document.getElementById('modalLocation');

        activeImageSrc = imageSrc;
        activeCaption = caption;

        modalImg.src = imageSrc;
        modalCaption.textContent = caption;

        if (location && location.trim()) {
            const cleanLocation = location.trim();
            const compactLocation = cleanLocation.length > 60
                ? cleanLocation.slice(0, 57).trim() + '...'
                : cleanLocation;

            modalLocation.textContent = 'Lokasi: ' + compactLocation;
            modalLocation.classList.remove('hidden');
        } else {
            modalLocation.textContent = '';
            modalLocation.classList.add('hidden');
        }

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    async function triggerDownload() {
        if (!activeImageSrc) return;

        const btn = document.getElementById('downloadBtn');
        const originalText = btn.innerHTML;
        btn.innerText = 'Mengunduh...';

        try {
            const response = await fetch(activeImageSrc);
            const blob = await response.blob();
            const blobUrl = window.URL.createObjectURL(blob);

            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = blobUrl;

            const filename = (activeCaption ? activeCaption.toLowerCase().replace(/[^a-z0-9]/g, '-') : 'foto-galeri') + '.jpg';
            a.download = filename;

            document.body.appendChild(a);
            a.click();

            window.URL.revokeObjectURL(blobUrl);
            document.body.removeChild(a);
        } catch (error) {
            window.open(activeImageSrc, '_blank');
        } finally {
            btn.innerHTML = originalText;
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeModal();
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/pages/gallery.blade.php ENDPATH**/ ?>