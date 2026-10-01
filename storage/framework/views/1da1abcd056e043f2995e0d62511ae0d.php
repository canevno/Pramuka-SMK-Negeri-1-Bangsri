<div x-data="themeToggle()" @keydown.space.prevent="toggle()" x-cloak class="inline-block">
    <div class="relative inline-flex rounded-full border border-white">
        <button
            @click="toggle()"
            :class="isDark ? 'bg-[#3E3E3A]' : 'bg-[#cdccd1]'"
            class="relative w-14 h-7 rounded-full  dark:bg-gray-820 transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-1 active:outline-none"
            style="outline: none;"
            aria-label="Toggle theme"
        >
        <!-- Sliding circle background with icon inside -->
        <div
            :style="{
                transform: isDark ? 'translateX(28px)' : 'translateX(2px)',
            }"
            class="absolute top-0.5 w-6 h-6 bg-white rounded-full transition-transform duration-0 ease-in-out shadow-sm flex items-center justify-center overflow-hidden pointer-events-none"
        >
            <!-- Sun icon (day mode) -->
            <svg
                x-cloak
                x-show="!isDark"
                width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" 
                class="text-[#706f6c] pointer-events-none"
                style="stroke-linecap: round; stroke-linejoin: round;"
            >
                <circle cx="12" cy="12" r="5" />
                <line x1="12" y1="1" x2="12" y2="3" />
                <line x1="12" y1="21" x2="12" y2="23" />
                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64" />
                <line x1="18.36" y1="18.36" x2="19.78" y2="19.78" />
                <line x1="1" y1="12" x2="3" y2="12" />
                <line x1="21" y1="12" x2="23" y2="12" />
                <line x1="4.22" y1="19.78" x2="5.64" y2="18.36" />
                <line x1="18.36" y1="5.64" x2="19.78" y2="4.22" />
            </svg>

            <!-- Moon icon (night mode) -->
            <svg
                x-cloak
                x-show="isDark"
                width="16" height="16" viewBox="0 0 24 24" fill="currentColor" 
                class="text-[#A1A09A] pointer-events-none"
            >
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" />
            </svg>
        </div>
    </button>
</div>

<script>
    function themeToggle() {
        return {
            isDark: (() => {
                const savedTheme = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                return savedTheme ? savedTheme === 'dark' : prefersDark;
            })(),

            init() {
                // Initialize theme from localStorage or system preference
                const savedTheme = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                if (savedTheme) {
                    this.isDark = savedTheme === 'dark';
                } else {
                    this.isDark = prefersDark;
                }

                this.applyTheme();
            },

            toggle() {
                this.isDark = !this.isDark;
                this.applyTheme();
            },

            applyTheme() {
                const htmlElement = document.documentElement;

                if (this.isDark) {
                    htmlElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                } else {
                    htmlElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                }
            },
        };
    }
</script>
<?php /**PATH C:\Users\Lenovo\Pramuka01\resources\views\components\theme-toggle.blade.php ENDPATH**/ ?>