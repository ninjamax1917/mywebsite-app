import { initReveal } from './reveal.js';

document.addEventListener('DOMContentLoaded', function () {
    // reveal for hero area (lines, subtitle, cards)
    initReveal([
        { selector: '.hero-title', type: 'stagger-lines', delayBetween: 180 },
        { selector: '.hero-sub', type: 'slide-up', delay: 80 },
        { selector: '.hero-card', type: 'slide-in-x', delay: 80 }
    ], { threshold: 0.2 });

    // reveal for "Наши услуги" section:
    // heading slides from left, paragraph next, cards appear sequentially
    initReveal([
        { selector: '#services-heading', type: 'slide-in-x', delay: 0 },
        { selector: '#services-heading + p', type: 'slide-in-x', delay: 120 },
        // keep container stagger-children but increase delayBetween so on mobile items don't fire simultaneously
        { selector: '.services-grid', type: 'stagger-children', delay: 240, delayBetween: 180 }
    ], { threshold: 0.12 });

    // simple hero image carousel (existing behavior)
    const imgs = document.querySelectorAll('.hero-carousel img');
    if (!imgs.length) return;
    let current = 0;
    const intervalMs = 3000;

    imgs.forEach((img, i) => {
        img.style.willChange = 'opacity';
        img.style.transition = 'opacity 600ms ease';
        img.style.opacity = i === current ? '1' : '0';
        img.setAttribute('aria-hidden', i === current ? 'false' : 'true');
    });

    setInterval(() => {
        imgs[current].style.opacity = '0';
        imgs[current].setAttribute('aria-hidden', 'true');
        current = (current + 1) % imgs.length;
        imgs[current].style.opacity = '1';
        imgs[current].setAttribute('aria-hidden', 'false');
    }, intervalMs);
});