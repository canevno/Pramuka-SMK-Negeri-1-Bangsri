<button
    type="button"
    x-data="{
        visible: false,
        onScroll() {
            this.visible = window.scrollY > 300;
        },
        scrollTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }"
    x-init="onScroll(); window.addEventListener('scroll', () => onScroll(), { passive: true });"
    x-show="visible"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 scale-90"
    x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-90"
    @click="scrollTop()"
    aria-label="Kembali ke atas"
    class="fixed bottom-20 right-4 z-70 flex h-12 w-12 items-center justify-center rounded-full bg-[#0D1B2A] text-white shadow-none ring-0 transition hover:bg-slate-800 lg:bottom-6 lg:right-6"
>
    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M12 19V5"></path>
        <path d="m5 12 7-7 7 7"></path>
    </svg>
</button>
