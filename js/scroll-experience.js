(() => {
    const ready = () => {
        const progress = document.querySelector('.tf-scroll-progress');
        const dot = document.querySelector('.tf-scroll-dot');
        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        const updateIndicator = () => {
            if (!progress || !dot) return;
            const available = document.documentElement.scrollHeight - window.innerHeight;
            const percentage = available > 0 ? Math.min((window.scrollY / available) * 100, 100) : 0;
            progress.style.height = `${percentage}%`;
            dot.style.top = `${percentage}%`;
        };

        updateIndicator();
        window.addEventListener('scroll', updateIndicator, { passive: true });
        window.addEventListener('resize', updateIndicator);

        let lenisInstance = null;
        if (window.Lenis && !reduceMotion) {
            lenisInstance = new Lenis({ duration: 1.15, smoothWheel: true, smoothTouch: false });
            gsap.ticker.add((time) => lenisInstance.raf(time * 1000));
            gsap.ticker.lagSmoothing(0);
        }

        const scrollToTarget = (target) => {
            if (lenisInstance) {
                lenisInstance.scrollTo(target, { offset: 0, duration: 1.15 });
            } else {
                target.scrollIntoView({ behavior: reduceMotion ? 'auto' : 'smooth', block: 'start' });
            }
        };

        const navigator = document.querySelector('.tf-scroll-indicator');
        const navStopsContainer = document.querySelector('.tf-nav-stops');
        const navLabel = document.querySelector('.tf-nav-label');
        const sections = Array.from(document.querySelectorAll('main > section, body > section'));
        const homeLabels = ['HOME', 'WHY TORQUE FLOW', 'SERVICES', 'BY THE NUMBERS', 'FEATURED SERVICES', 'THE STANDARD'];
        const cleanLabel = (value) => value.replace(/\s+/g, ' ').replace(/[.]/g, '').trim().slice(0, 30);
        const getLabel = (section, index) => {
            if (document.body.classList.contains('page-home')) return homeLabels[index] || `SECTION ${index + 1}`;
            const source = section.querySelector('.section-tag, .section-label, .about-label, .contact-label, .standard-label, .precision-label, .services-section-number, h1, h2');
            return cleanLabel(source?.textContent || `SECTION ${index + 1}`) || `SECTION ${index + 1}`;
        };

        if (navigator && navStopsContainer && sections.length > 1) {
            navigator.classList.add('tf-site-navigator');
            const activate = (index) => {
                const stops = Array.from(navStopsContainer.children);
                stops.forEach((stop, stopIndex) => {
                    const active = stopIndex === index;
                    stop.classList.toggle('is-active', active);
                    active ? stop.setAttribute('aria-current', 'true') : stop.removeAttribute('aria-current');
                });
                if (navLabel) navLabel.textContent = getLabel(sections[index], index);
            };

            sections.forEach((section, index) => {
                const label = getLabel(section, index);
                const stop = document.createElement('button');
                stop.type = 'button';
                stop.className = 'tf-nav-stop';
                stop.setAttribute('aria-label', `Go to ${label}`);
                stop.innerHTML = `<span>${String(index).padStart(2, '0')}</span>`;
                stop.addEventListener('click', () => scrollToTarget(section));
                navStopsContainer.appendChild(stop);
            });

            activate(0);

            const updateActiveSection = () => {
                const focusY = window.innerHeight * 0.45;
                let activeIndex = 0;
                let minDistance = Infinity;

                sections.forEach((section, index) => {
                    const rect = section.getBoundingClientRect();
                    if (rect.top <= focusY && rect.bottom >= focusY) {
                        activeIndex = index;
                        minDistance = 0;
                    } else if (minDistance !== 0) {
                        const dist = Math.min(Math.abs(rect.top - focusY), Math.abs(rect.bottom - focusY));
                        if (dist < minDistance) {
                            minDistance = dist;
                            activeIndex = index;
                        }
                    }
                });

                activate(activeIndex);
            };

            window.addEventListener('scroll', updateActiveSection, { passive: true });
            window.addEventListener('resize', updateActiveSection);
            if (lenisInstance) {
                lenisInstance.on('scroll', updateActiveSection);
            }
            updateActiveSection();
        }

        // Handle internal hash anchor links with Lenis
        document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
            anchor.addEventListener('click', (e) => {
                const hash = anchor.getAttribute('href');
                if (!hash || hash === '#') return;
                const target = document.querySelector(hash);
                if (target) {
                    e.preventDefault();
                    scrollToTarget(target);
                }
            });
        });

        if (!window.gsap || !window.ScrollTrigger || reduceMotion) return;

        gsap.registerPlugin(ScrollTrigger);

        if (lenisInstance) {
            lenisInstance.on('scroll', () => {
                ScrollTrigger.update();
                updateIndicator();
            });
        }

        // Keep the original understated section entrance everywhere on the site.
        gsap.utils.toArray('section').forEach((section) => {
            gsap.fromTo(section, { opacity: 0.85, y: 30 }, {
                opacity: 1,
                y: 0,
                duration: 1,
                ease: 'power2.out',
                scrollTrigger: {
                    trigger: section,
                    start: 'top 85%',
                    end: 'top 55%',
                    scrub: 0.8
                }
            });
        });

        if (!document.body.classList.contains('page-home')) return;

        const hero = document.querySelector('[data-scene]');
        const heroCopy = document.querySelector('.tf-hero-copy');
        const header = document.querySelector('header');
        if (hero && heroCopy) {
            gsap.timeline()
                .fromTo(header, { yPercent: -120, autoAlpha: 0 }, { yPercent: 0, autoAlpha: 1, duration: 0.8, ease: 'power3.out' })
                .fromTo('.hero-title h2, .hero-title p, .scroll', { y: 34, autoAlpha: 0 }, { y: 0, autoAlpha: 1, duration: 0.85, stagger: 0.09, ease: 'power3.out' }, '-=0.3');

            gsap.to(heroCopy, { yPercent: -35, scale: 0.82, opacity: 0.15, ease: 'none', scrollTrigger: { trigger: hero, start: 'top top', end: 'bottom top', scrub: true } });
            gsap.to('.tf-hero-orbit-one', { rotate: 23, xPercent: 18, ease: 'none', scrollTrigger: { trigger: hero, start: 'top top', end: 'bottom top', scrub: true } });
            gsap.to('.tf-hero-orbit-two', { rotate: -30, xPercent: -22, ease: 'none', scrollTrigger: { trigger: hero, start: 'top top', end: 'bottom top', scrub: true } });

            window.addEventListener('pointermove', (event) => {
                if (window.innerWidth < 768) return;
                const x = (event.clientX / window.innerWidth - 0.5) * 2;
                const y = (event.clientY / window.innerHeight - 0.5) * 2;
                gsap.to(heroCopy, { rotateY: x * 5, rotateX: y * -4, x: x * 12, duration: 0.8, ease: 'power2.out', transformPerspective: 900 });
            }, { passive: true });
        }

    };

    document.readyState === 'loading' ? document.addEventListener('DOMContentLoaded', ready) : ready();
})();
