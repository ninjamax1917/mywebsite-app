document.addEventListener('DOMContentLoaded', function () {
    const items = document.querySelectorAll('.animate-on-scroll');
    if (!items.length) return;

    const io = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            const el = entry.target;
            const isFromLeft = el.classList.contains('animate-from-left');

            // ограничиваем transition для входной анимации (не мешаем hover)
            el.style.willChange = 'transform, opacity';
            el.style.transitionProperty = 'transform, opacity';
            const elDuration = isFromLeft ? 700 : 1000; // header быстрее, карточки мягче
            el.style.transitionDuration = elDuration + 'ms';
            el.style.transitionTimingFunction = 'cubic-bezier(0.22, 1, 0.36, 1)';

            const index = Array.from(items).indexOf(el);
            const baseDelay = el.dataset.delay ? parseInt(el.dataset.delay, 10) : index * 160;
            el.style.transitionDelay = baseDelay + 'ms';

            // запуск: сдвиг слева для заголовка, снизу для карточек
            if (isFromLeft) {
                if (!el.classList.contains('-translate-x-6')) el.classList.add('-translate-x-6', 'opacity-0');
                el.classList.remove('-translate-x-6', 'opacity-0');
                el.classList.add('translate-x-0', 'opacity-100');
            } else {
                if (!el.classList.contains('translate-y-4')) el.classList.add('translate-y-4', 'opacity-0');
                el.classList.remove('translate-y-4', 'opacity-0');
                el.classList.add('translate-y-0', 'opacity-100');
            }

            // дочерние элементы карточки — стаггер
            if (!isFromLeft) {
                const children = el.querySelectorAll('.animate-child');
                const childDuration = 700;
                children.forEach((child, i) => {
                    child.style.willChange = 'transform, opacity';
                    child.style.transitionProperty = 'transform, opacity';
                    child.style.transitionDuration = childDuration + 'ms';
                    child.style.transitionTimingFunction = 'cubic-bezier(0.22, 1, 0.36, 1)';

                    const childDelay = baseDelay + 220 + i * 160;
                    child.style.transitionDelay = childDelay + 'ms';

                    // начальное состояние для дочерних
                    if (!child.classList.contains('translate-y-2')) child.classList.add('translate-y-2', 'opacity-0');
                    child.classList.remove('translate-y-2', 'opacity-0');
                    child.classList.add('translate-y-0', 'opacity-100');

                    // очистка inline-стилей дочерних после анимации
                    setTimeout(() => {
                        child.style.transitionDelay = '';
                        child.style.transitionProperty = '';
                        child.style.transitionDuration = '';
                        child.style.transitionTimingFunction = '';
                        child.style.willChange = '';
                    }, childDelay + childDuration + 120);
                });
            }

            // очистка inline-стилей элемента после анимации
            setTimeout(() => {
                el.style.transitionDelay = '';
                el.style.transitionProperty = '';
                el.style.transitionDuration = '';
                el.style.transitionTimingFunction = '';
                el.style.willChange = '';
            }, baseDelay + elDuration + 160);

            obs.unobserve(el);
        });
    }, { threshold: 0.12 });

    // начальные состояния
    items.forEach(el => {
        if (el.classList.contains('animate-from-left')) {
            el.classList.add('-translate-x-6', 'opacity-0');
        } else {
            el.classList.add('translate-y-4', 'opacity-0');
        }
        el.querySelectorAll('.animate-child').forEach(c => c.classList.add('translate-y-2', 'opacity-0'));
        io.observe(el);
    });
});