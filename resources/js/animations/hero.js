import { gsap } from "gsap";

export function initHeroAnimations() {
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduceMotion) {
        return;
    }

    const af = document.querySelector('.hero-logo-af');
    const ds = document.querySelector('.hero-logo-ds');
    const logos = [af, ds].filter(Boolean);

    if (!logos.length) {
        return;
    }

    gsap.from(logos, {
        duration: 0.9,
        autoAlpha: 0,
        y: 22,
        scale: 0.96,
        stagger: 0.14,
        ease: 'power2.out'
    });

    gsap.from('.hero-text p:first-child', {
        duration: 0.6,
        autoAlpha: 0,
        y: 12,
        ease: 'power2.out',
        delay: 0.2
    });

    gsap.from('.hero-text p:last-child', {
        duration: 0.6,
        autoAlpha: 0,
        y: 12,
        ease: 'power2.out',
        delay: 0.3
    });

    gsap.to(logos, {
        y: -8,
        duration: 6,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut',
        stagger: 0.25
    });

    if (window.innerWidth >= 1024) {
        gsap.to('.icon-ambalan-1', {
            y: -30,
            duration: 8,
            repeat: -1,
            yoyo: true,
            ease: 'sine.inOut'
        });

        gsap.to('.icon-ambalan-2', {
            y: -22,
            duration: 10,
            repeat: -1,
            yoyo: true,
            ease: 'sine.inOut'
        });

        const container = document.querySelector('.hero-section');
        if (container) {
            container.addEventListener('pointermove', (event) => {
                const rect = container.getBoundingClientRect();
                const dx = (event.clientX - (rect.left + rect.width / 2)) / rect.width;
                const dy = (event.clientY - (rect.top + rect.height / 2)) / rect.height;
                if (af) gsap.to(af, { x: dx * 18, y: dy * 10, duration: 0.6, ease: 'power3.out' });
                if (ds) gsap.to(ds, { x: dx * -18, y: dy * 10, duration: 0.6, ease: 'power3.out' });
            });
            container.addEventListener('pointerleave', () => {
                logos.forEach((logo) => gsap.to(logo, { x: 0, y: 0, duration: 0.8, ease: 'power3.out' }));
            });
        }

        logos.forEach((logo) => {
            logo.style.willChange = 'transform';
            logo.addEventListener('pointerenter', () => gsap.to(logo, { scale: 1.06, rotation: 2, duration: 0.35 }));
            logo.addEventListener('pointerleave', () => gsap.to(logo, { scale: 1, rotation: 0, duration: 0.6, ease: 'elastic.out(1, 0.6)' }));
        });
    }

    gsap.from('.hero-button', {
        duration: 0.6,
        scale: 0.95,
        autoAlpha: 0,
        ease: 'back.out(1.4)',
        delay: 0.5
    });
}
