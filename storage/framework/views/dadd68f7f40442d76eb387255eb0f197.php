<footer class="bg-[#0D1B2A] pb-16 text-slate-100 md:pb-10">
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 sm:py-10 lg:px-8">
        <div class="grid grid-cols-2 gap-10 lg:grid-cols-[1.7fr_1fr_1fr_1fr]">
            <div class="col-span-2 space-y-4 lg:col-span-1">
                <div class="min-h-10">
                    <h2 id="footer-typing-title" data-text="Dewan Ambalan Tahun 2026" class="text-2xl font-bold text-white"></h2>
                </div>
                <p class="max-w-sm text-sm leading-6 text-slate-300">
                    Website resmi Gugus Depan 03.161 dan 03.162 Pangkalan SMK Negeri 1 Bangsri untuk kegiatan, prestasi, dan informasi anggota.
                </p>
                <div class="mt-4 w-52 mx-auto lg:mx-0 overflow-hidden rounded border-2 border-slate-500">
                    <img src="/images/hero/imagehero1.png" alt="Pramuka SMK Negeri 1 Bangsri" class="w-full h-full object-contain block">
                </div>
            </div>

            <div class="col-span-1">
                    <h3 class="mb-6 text-sm font-semibold uppercase tracking-[.18em] text-slate-400">Tautan</h3>
                    <ul class="space-y-3 text-sm text-slate-200">
                    <li><a href="<?php echo e(route('home')); ?>" class="text-sm font-semibold text-white hover:text-slate-300 transition-colors uppercase tracking-wide">Beranda</a></li>
                    <li><a href="<?php echo e(route('about')); ?>" class="text-sm font-semibold text-white hover:text-slate-300 transition-colors uppercase tracking-wide">Tentang Kami</a></li>
                    <li><a href="<?php echo e(route('gallery')); ?>" class="text-sm font-semibold text-white hover:text-slate-300 transition-colors uppercase tracking-wide">Galeri</a></li>
                    <li><a href="<?php echo e(route('contact')); ?>" class="text-sm font-semibold text-white hover:text-slate-300 transition-colors uppercase tracking-wide">Kontak</a></li>
                </ul>
            </div>

            <div class="col-span-1">
                    <h3 class="mb-6 text-sm font-semibold uppercase tracking-[.18em] text-slate-400">Program</h3>
                    <ul class="space-y-3 text-sm text-slate-200">
                    <li><a href="<?php echo e(route('pembina')); ?>#anggota-dewan" class="text-sm font-semibold text-white hover:text-slate-300 transition-colors uppercase tracking-wide">Anggota Dewan</a></li>
                    <li><a href="<?php echo e(route('achievement')); ?>" class="text-sm font-semibold text-white hover:text-slate-300 transition-colors uppercase tracking-wide">Prestasi</a></li>
                    <li><a href="<?php echo e(route('event')); ?>" class="text-sm font-semibold text-white hover:text-slate-300 transition-colors uppercase tracking-wide">Event</a></li>
                    <li><a href="<?php echo e(route('news')); ?>" class="text-sm font-semibold text-white hover:text-slate-300 transition-colors uppercase tracking-wide">Berita</a></li>
                </ul>
            </div>

            <div class="col-span-2 lg:col-span-1 lg:h-full lg:items-start">
                <div class="h-full flex flex-col justify-start gap-4">
                    <h3 class="mb-6 text-sm font-semibold uppercase tracking-[.18em] text-slate-400 text-center lg:text-left">Media Sosial</h3>
                    <ul class="grid grid-cols-3 gap-3 justify-items-center text-sm lg:grid-cols-2 lg:gap-4 lg:-mt-3">
                        <li class="order-1 lg:order-1">
                            <a href="https://instagram.com/pramuka_smksaba" target="_blank" class="inline-flex w-full max-w-[260px] justify-center items-center gap-2 px-3 py-2 text-slate-200 transition hover:text-white">
                                <svg viewBox="0 0 24 24" class="h-5 w-5 fill-current" aria-hidden="true"><path d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2Zm0 1.5A4.25 4.25 0 0 0 3.5 7.75v8.5A4.25 4.25 0 0 0 7.75 20.5h8.5A4.25 4.25 0 0 0 20.5 16.25v-8.5A4.25 4.25 0 0 0 16.25 3.5h-8.5Zm8.75 2.5a.75.75 0 1 1 0 1.5.75.75 0 0 1 0-1.5ZM12 7.25a4.75 4.75 0 1 1 0 9.5 4.75 4.75 0 0 1 0-9.5Zm0 1.5a3.25 3.25 0 1 0 0 6.5 3.25 3.25 0 0 0 0-6.5Z"/></svg>
                                <span>Instagram</span>
                            </a>
                        </li>
                        <li class="order-2 lg:order-2">
                            <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex w-full max-w-[260px] justify-center items-center gap-2 px-3 py-2 text-slate-200 transition hover:text-white">
                                <img src="<?php echo e(asset('whatsapp.svg')); ?>" alt="WhatsApp" class="h-5 w-5 brightness-0 invert" />
                                <span>WhatsApp</span>
                            </a>
                        </li>
                        <li class="order-3 lg:order-3">
                            <a href="https://facebook.com/scouteskasaba" target="_blank" class="inline-flex w-full max-w-[260px] justify-center items-center gap-2 px-3 py-2 text-slate-200 transition hover:text-white">
                                <svg viewBox="0 0 24 24" class="h-5 w-5 fill-current" aria-hidden="true"><path d="M15.12 3H8.88C6.57 3 5 4.57 5 6.88v4.74H3v3.75h2v6.63h4.12v-6.63h2.73l.43-3.75h-3.16V7.38c0-1.08.29-1.82 1.79-1.82h1.63V3Z"/></svg>
                                <span>Facebook</span>
                            </a>
                        </li>
                        <li class="order-5 lg:order-4">
                            <a href="https://x.com/scouteskasaba" target="_blank" class="inline-flex w-full max-w-[260px] justify-center items-center gap-2 px-3 py-2 text-slate-200 transition hover:text-white">
                                <img src="<?php echo e(asset('x.svg')); ?>" alt="X" class="h-5 w-5 brightness-0 invert" />
                                <span>Twitter</span>
                            </a>
                        </li>
                        <li class="order-6 lg:order-5">
                            <a href="https://youtube.com/scouteskasaba6141" target="_blank" class="inline-flex w-full max-w-[260px] justify-center items-center gap-2 px-3 py-2 text-slate-200 transition hover:text-white">
                                <svg viewBox="0 0 24 24" class="h-5 w-5 fill-current" aria-hidden="true"><path d="M21.8 7.05a2.4 2.4 0 0 0-1.69-1.7C18.5 5 12 5 12 5s-6.5 0-8.11.35A2.4 2.4 0 0 0 2.2 7.05 25.9 25.9 0 0 0 2 12a25.9 25.9 0 0 0 .2 4.95 2.4 2.4 0 0 0 1.69 1.7C5.5 19 12 19 12 19s6.5 0 8.11-.35a2.4 2.4 0 0 0 1.69-1.7A25.9 25.9 0 0 0 22 12a25.9 25.9 0 0 0-.2-4.95Zm-12.4 8.8V7.15l6.2 4.35-6.2 4.35Z"/></svg>
                                <span>YouTube</span>
                            </a>
                        </li>
                        <li class="order-4 lg:order-6">
                            <a href="https://tiktok.com/pramukasmkn1bangsri" target="_blank" class="inline-flex w-full max-w-[260px] justify-center items-center gap-2 px-3 py-2 text-slate-200 transition hover:text-white">
                                <img src="<?php echo e(asset('tiktok.svg')); ?>" alt="TikTok" class="h-5 w-5 brightness-0 invert" />
                                <span>TikTok</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="mt-8 border-t-2 border-slate-600 pt-6 text-sm text-slate-400">
            <div class="grid gap-4 text-center sm:grid-cols-3 sm:text-left sm:items-center">
                <p class="w-full sm:w-auto">&copy; <?php echo e(date('Y')); ?> Pramuka SMK Negeri 1 Bangsri. Hak cipta dilindungi.</p>
                <div class="w-full text-center text-xs sm:text-center sm:text-sm">
                    <span>Dikembangkan oleh</span>
                    <div class="mt-1 flex flex-wrap justify-center items-center gap-2 text-slate-400">
                        <a href="https://instagram.com/vndprilln" target="_blank" class="text-slate-400 hover:text-white">Evand Aprilliano</a>
                        <span class="text-slate-500">•</span>
                        <a href="https://instagram.com/levalvnn" target="_blank" class="text-slate-400 hover:text-white">Fahlevi Alvian Permana</a>
                        <span class="text-slate-500">•</span>
                        <a href="https://instagram.com/rreedka_" target="_blank" class="text-slate-400 hover:text-white">Reykhandika Ibnu Ula</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const title = document.getElementById('footer-typing-title');
            if (!title) return;

            const text = title.dataset.text || title.textContent.trim();
            let started = false;

            const typeText = () => {
                if (started) return;
                started = true;

                const content = document.createElement('span');
                title.innerHTML = '';
                title.appendChild(content);

                let index = 0;
                const interval = setInterval(() => {
                    if (index < text.length) {
                        content.textContent += text[index];
                        index++;
                    } else {
                        clearInterval(interval);
                    }
                }, 70);
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        typeText();
                        observer.disconnect();
                    }
                });
            }, { threshold: 0, rootMargin: '0px 0px -100px 0px' });

            observer.observe(title);
        });
    </script>
</footer>
<?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views/components/footer.blade.php ENDPATH**/ ?>