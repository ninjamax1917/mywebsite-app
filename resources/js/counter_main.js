document.addEventListener('DOMContentLoaded', function () {
    const counters = document.querySelectorAll('.js-counter');
    counters.forEach(el => {
        const target = parseInt(el.dataset.target, 10) || 0;
        const duration = parseInt(el.dataset.duration, 10) || 1000;
        const startTime = performance.now();

        const tick = (now) => {
            const progress = Math.min((now - startTime) / duration, 1);
            const value = Math.floor(progress * target);
            el.textContent = value;
            if (progress < 1) {
                requestAnimationFrame(tick);
            } else {
                el.textContent = target;
            }
        };

        requestAnimationFrame(tick);
    });
});