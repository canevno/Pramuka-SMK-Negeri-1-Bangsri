import { gsap } from "gsap";
import { initGalleryMotion } from "./pages/gallery.js";
import { initHeroAnimations } from "./animations/hero.js";
import Alpine from 'alpinejs';

window.gsap = gsap;
window.Alpine = Alpine;
Alpine.start();

document.addEventListener("DOMContentLoaded", () => {
    const gallery = document.querySelector('[data-page="gallery"]');
    const hero = document.querySelector('.hero-section');

    if (gallery) {
        initGalleryMotion();
    }

    if (hero) {
        initHeroAnimations();
    }
});