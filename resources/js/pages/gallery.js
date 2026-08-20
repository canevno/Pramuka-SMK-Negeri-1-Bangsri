import gsap from 'gsap';
import ScrollTrigger from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

/**
 * Editorial Exhibition Cinematic Scroll Engine
 * Architecture: Continuous Viewport-Based Timeline
 * Paradigm: Scroll as Narrative Controller (Pinning + Scrubbing + Overlapping)
 */
export function initGalleryMotion() {
    const main = document.querySelector('main');
    if (!main) return;

    // Use gsap.context for clean lifecycle & memory management (Laravel/Livewire safety)
    let ctx = gsap.context(() => {

        // ==========================================
        // 1. HERO TO FEATURED (Continuous Opening)
        // ==========================================
        // Smooth initial load reveal (Only runs once on enter)
        const heroLoadTl = gsap.timeline({ defaults: { ease: 'power3.out' } });
        heroLoadTl
            .fromTo('#hero figure img', { scale: 1.2, opacity: 0 }, { scale: 1.05, opacity: 0.35, duration: 2.0 })
            .fromTo('#hero h1', { y: 60, opacity: 0 }, { y: 0, opacity: 1, duration: 1.4 }, '-=1.6')
            .fromTo('#hero p', { y: 30, opacity: 0 }, { y: 0, opacity: 1, duration: 1.0 }, '-=1.0');

        // Scroll-driven Hero morphing into Viewport 2 (Featured Story)
        const heroScrollTl = gsap.timeline({
            scrollTrigger: {
                trigger: '#hero',
                start: 'top top',
                end: 'bottom top',
                scrub: 1,
                pin: true,
                pinSpacing: false
            }
        });

        heroScrollTl
            .to('#hero h1', { y: -100, opacity: 0, ease: 'power1.in' })
            .to('#hero p', { y: -60, opacity: 0, ease: 'power1.in' }, '<')
            .to('#hero figure img', { scale: 1.0, opacity: 0.1, yPercent: -10, ease: 'none' }, '<');


        // ==========================================
        // 2. FEATURED STORY (Depth & Transition)
        // ==========================================
        const featuredTl = gsap.timeline({
            scrollTrigger: {
                trigger: '#featured-story',
                start: 'top 80%',
                end: 'bottom top',
                scrub: 1
            }
        });

        featuredTl
            .fromTo('#featured-story figure', 
                { y: 100, scale: 0.95 }, 
                { y: 0, scale: 1, ease: 'none' }
            )
            .fromTo('#featured-story figure img', 
                { scale: 1.15 }, 
                { scale: 1.0, ease: 'none' }, 
                '<'
            )
            .fromTo('#featured-story h2', 
                { opacity: 0, y: 30 }, 
                { opacity: 1, y: 0, ease: 'power2.out' }, 
                '-=0.3'
            );


        // ==========================================
        // 3. HUMAN SPOTLIGHT (Emotional Pause & Pinning)
        // ==========================================
        // Pinning section to slow down reading rhythm for human portrait
        const spotlightTl = gsap.timeline({
            scrollTrigger: {
                trigger: '#human-spotlight',
                start: 'top top',
                end: '+=100%',
                scrub: 0.8,
                pin: true,
                anticipatePin: 1
            }
        });

        spotlightTl
            .fromTo('#human-spotlight figure', 
                { opacity: 0, scale: 0.9, y: 50 }, 
                { opacity: 1, scale: 1, y: 0, ease: 'power2.out' }
            )
            .fromTo('#human-spotlight figure img', 
                { scale: 1.1 }, 
                { scale: 1.0, ease: 'none' }, 
                '<'
            )
            .fromTo('#human-spotlight blockquote', 
                { opacity: 0, x: 40 }, 
                { opacity: 1, x: 0, ease: 'power2.out' }, 
                '-=0.4'
            )
            // Subtle transition out before releasing pin
            .to('#human-spotlight figure', { scale: 0.98, opacity: 0.8, ease: 'power1.in' }, '+=0.5')
            .to('#human-spotlight blockquote', { opacity: 0.5, ease: 'power1.in' }, '<');


        // ==========================================
        // 4. BROTHERHOOD (Asymmetrical Layering)
        // ==========================================
        const brotherhoodTl = gsap.timeline({
            scrollTrigger: {
                trigger: '#brotherhood',
                start: 'top 70%',
                end: 'bottom 20%',
                scrub: 1
            }
        });

        brotherhoodTl
            // Main Landscape Image Entrance
            .fromTo('#brotherhood figure:first-of-type', 
                { y: 80, opacity: 0.3 }, 
                { y: 0, opacity: 1, ease: 'none' }
            )
            // Offset Small Portrait Layer Shift (Parallax Overlap)
            .fromTo('#brotherhood figure:last-of-type', 
                { y: 140, x: -20, opacity: 0 }, 
                { y: -30, x: 0, opacity: 1, ease: 'none' }, 
                '-=0.6'
            )
            .fromTo('#brotherhood h2', 
                { opacity: 0, y: 20 }, 
                { opacity: 1, y: 0, ease: 'power2.out' }, 
                '-=0.4'
            );


        // ==========================================
        // 5. HONOR (Visual Climax - Scale & Presence)
        // ==========================================
        const honorTl = gsap.timeline({
            scrollTrigger: {
                trigger: '#honor',
                start: 'top top',
                end: '+=120%',
                scrub: 1,
                pin: true
            }
        });

        honorTl
            .fromTo('#honor figure', 
                { scale: 0.85, opacity: 0.2 }, 
                { scale: 1.0, opacity: 1, ease: 'power2.out' }
            )
            .fromTo('#honor figure img', 
                { scale: 1.25 }, 
                { scale: 1.0, ease: 'none' }, 
                '<'
            )
            .fromTo('#honor h2', 
                { opacity: 0, letterSpacing: '0.1em' }, 
                { opacity: 1, letterSpacing: '0.4em', ease: 'power2.out' }, 
                '-=0.3'
            )
            // Hold screen at full focus
            .to('#honor figure img', { filter: 'contrast(140%) grayscale(100%)', duration: 0.5 });


        // ==========================================
        // 6. ARCHIVE (Museum Exploration Flow)
        // ==========================================
        const archiveTl = gsap.timeline({
            scrollTrigger: {
                trigger: '#archive',
                start: 'top 75%',
                end: 'bottom 80%',
                scrub: 0.8
            }
        });

        archiveTl
            .fromTo('#archive header', 
                { opacity: 0, x: -30 }, 
                { opacity: 1, x: 0, ease: 'power2.out' }
            )
            .fromTo('#archive article', 
                { opacity: 0, y: 40, borderBottomColor: 'transparent' }, 
                { opacity: 1, y: 0, stagger: 0.2, ease: 'power2.out' }, 
                '-=0.2'
            );


        // ==========================================
        // 7. CLOSING (Grand Finale Transition)
        // ==========================================
        const closingTl = gsap.timeline({
            scrollTrigger: {
                trigger: '#closing',
                start: 'top 80%',
                end: 'bottom bottom',
                scrub: 1
            }
        });

        closingTl
            .fromTo('#closing figure img', 
                { opacity: 0, scale: 1.15 }, 
                { opacity: 0.3, scale: 1.0, ease: 'none' }
            )
            .fromTo('#closing h2', 
                { y: 80, opacity: 0 }, 
                { y: 0, opacity: 1, ease: 'power2.out' }, 
                '-=0.5'
            )
            .fromTo('#closing a', 
                { y: 40, opacity: 0 }, 
                { y: 0, opacity: 1, ease: 'power2.out' }, 
                '-=0.3'
            );

        // ==========================================
        // 8. INTERACTIVE HOVER STATES (Smooth Response)
        // ==========================================
        // Image subtle scale response
        const figures = document.querySelectorAll('figure');
        figures.forEach((fig) => {
            const img = fig.querySelector('img');
            if (!img) return;

            fig.addEventListener('mouseenter', () => {
                gsap.to(img, { scale: 1.03, duration: 0.6, ease: 'power2.out', overwrite: 'auto' });
            });

            fig.addEventListener('mouseleave', () => {
                gsap.to(img, { scale: 1.0, duration: 0.6, ease: 'power2.out', overwrite: 'auto' });
            });
        });

        // CTA Button Interactive State
        const ctaBtn = document.querySelector('#closing a');
        if (ctaBtn) {
            ctaBtn.addEventListener('mouseenter', () => {
                gsap.to(ctaBtn, { scale: 1.05, duration: 0.4, ease: 'power2.out', overwrite: 'auto' });
            });
            ctaBtn.addEventListener('mouseleave', () => {
                gsap.to(ctaBtn, { scale: 1.0, duration: 0.4, ease: 'power2.out', overwrite: 'auto' });
            });
        }

    }, main);

    return ctx;
}