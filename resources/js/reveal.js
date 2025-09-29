export function initReveal(rules = [], options = {}) {
    const threshold = options.threshold ?? 0.18;
    const reduceMotion = typeof window !== 'undefined' && window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (reduceMotion) {
        // If user prefers reduced motion — reveal immediately (no transitions)
        rules.forEach(rule => {
            document.querySelectorAll(rule.selector).forEach(el => {
                if (rule.type === 'stagger-lines') {
                    el.querySelectorAll('span').forEach(ln => {
                        ln.classList.remove('-translate-y-6', 'opacity-0');
                        ln.classList.add('translate-y-0', 'opacity-100');
                        ln.dataset.animated = '1';
                    });
                } else if (rule.type === 'stagger-children') {
                    Array.from(el.querySelectorAll(':scope > *')).forEach(it => {
                        it.classList.remove('translate-y-4', 'opacity-0');
                        it.classList.add('translate-y-0', 'opacity-100');
                        it.dataset.animated = '1';
                    });
                } else if (rule.type === 'slide-up') {
                    el.classList.remove('translate-y-4', 'opacity-0');
                    el.classList.add('translate-y-0', 'opacity-100');
                    el.dataset.animated = '1';
                } else if (rule.type === 'slide-in-x') {
                    el.classList.remove('translate-x-8', 'opacity-0');
                    el.classList.add('translate-x-0', 'opacity-100');
                    el.dataset.animated = '1';
                } else if (rule.type === 'fade-in') {
                    el.classList.remove('opacity-0', '-translate-y-1');
                    el.classList.add('opacity-100', 'translate-y-0');
                    el.dataset.animated = '1';
                } else {
                    el.dataset.animated = '1';
                }
            });
        });
        return { observer: null };
    }

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            const el = entry.target;
            const rule = el.__revealRule;
            if (!rule) {
                obs.unobserve(el);
                return;
            }

            const type = rule.type || 'slide-up';

            if (type === 'stagger-lines') {
                const lines = el.querySelectorAll('span');
                const delayBetween = rule.delayBetween ?? 180;
                lines.forEach((ln, i) => {
                    ln.classList.add('-translate-y-6', 'opacity-0');
                    ln.style.willChange = 'transform, opacity';
                    setTimeout(() => {
                        ln.classList.remove('-translate-y-6', 'opacity-0');
                        ln.classList.add('translate-y-0', 'opacity-100');
                        ln.dataset.animated = '1';
                    }, (rule.delay ?? 0) + i * delayBetween);
                });
            } else if (type === 'stagger-children') {
                const items = Array.from(el.querySelectorAll(':scope > *'));
                const delayBetween = rule.delayBetween ?? 120;
                items.forEach((it, i) => {
                    it.classList.add('translate-y-4', 'opacity-0');
                    it.style.willChange = 'transform, opacity';
                    setTimeout(() => {
                        it.classList.remove('translate-y-4', 'opacity-0');
                        it.classList.add('translate-y-0', 'opacity-100');
                        it.dataset.animated = '1';
                    }, (rule.delay ?? 80) + i * delayBetween);
                });
            } else if (type === 'slide-up') {
                if (!el.dataset.animated) {
                    el.style.willChange = 'transform, opacity';
                    // prefer per-element data-delay if present
                    const elDelay = el.dataset && el.dataset.delay ? parseInt(el.dataset.delay, 10) : (rule.delay ?? 80);
                    setTimeout(() => {
                        el.classList.remove('translate-y-4', 'opacity-0');
                        el.classList.add('translate-y-0', 'opacity-100');
                        el.dataset.animated = '1';
                    }, elDelay);
                }
            } else if (type === 'slide-in-x') {
                if (!el.dataset.animated) {
                    el.style.willChange = 'transform, opacity';
                    const elDelay = el.dataset && el.dataset.delay ? parseInt(el.dataset.delay, 10) : (rule.delay ?? 80);
                    setTimeout(() => {
                        el.classList.remove('translate-x-8', 'opacity-0');
                        el.classList.add('translate-x-0', 'opacity-100');
                        el.dataset.animated = '1';
                    }, elDelay);
                }
            } else if (type === 'fade-in') {
                if (!el.dataset.animated) {
                    el.style.willChange = 'opacity, transform';
                    const elDelay = el.dataset && el.dataset.delay ? parseInt(el.dataset.delay, 10) : (rule.delay ?? 40);
                    setTimeout(() => {
                        el.classList.remove('opacity-0', '-translate-y-1');
                        el.classList.add('opacity-100', 'translate-y-0');
                        el.dataset.animated = '1';
                    }, elDelay);
                }
            }

            obs.unobserve(el);
        });
    }, { threshold });

    // register rules: attach rule pointer and ensure initial classes
    rules.forEach(rule => {
        document.querySelectorAll(rule.selector).forEach(el => {
            el.__revealRule = rule;

            if (rule.type === 'stagger-lines') {
                const lines = el.querySelectorAll('span');
                lines.forEach(ln => ln.classList.add('-translate-y-6', 'opacity-0'));
            } else if (rule.type === 'stagger-children') {
                Array.from(el.querySelectorAll(':scope > *')).forEach(it => it.classList.add('translate-y-4', 'opacity-0'));
            } else if (rule.type === 'slide-up') {
                // keep initial state only if not already present
                if (!el.classList.contains('translate-y-4') && !el.classList.contains('opacity-0')) {
                    el.classList.add('translate-y-4', 'opacity-0');
                }
            } else if (rule.type === 'slide-in-x') {
                if (!el.classList.contains('translate-x-8') && !el.classList.contains('opacity-0')) {
                    el.classList.add('translate-x-8', 'opacity-0');
                }
            } else if (rule.type === 'fade-in') {
                el.classList.add('opacity-0', '-translate-y-1');
            }

            observer.observe(el);
        });
    });

    return { observer };
}