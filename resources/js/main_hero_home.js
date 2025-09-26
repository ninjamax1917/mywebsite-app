document.addEventListener('DOMContentLoaded', function () {

    // Анимация заголовка: поочередное плавное появление сверху вниз
    (function animateHeroTitle() {
        const lines = document.querySelectorAll('.hero-title span');
        if (!lines.length) return;
        const delayBetween = 180; // ms между строками
        lines.forEach((el, i) => {
            // на всякий случай установим начальное состояние, если его нет
            el.classList.add('-translate-y-6', 'opacity-0');
            el.style.willChange = 'transform, opacity';
            setTimeout(() => {
                el.classList.remove('-translate-y-6', 'opacity-0');
                el.classList.add('translate-y-0', 'opacity-100');
            }, i * delayBetween);
        });
    })();

    // Карусель изображений
    const imgs = document.querySelectorAll('.hero-carousel img');
    if (!imgs.length) return;
    let current = 0;
    const intervalMs = 3000;

    // гарантируем начальное состояние
    imgs.forEach((img, i) => {
        img.style.willChange = 'opacity';
        img.setAttribute('aria-hidden', i === current ? 'false' : 'true');

        // fallback: гарантируем абсолютное позиционирование и cover
        if (getComputedStyle(img).position === 'static') {
            img.style.position = 'absolute';
            img.style.inset = '0';
            img.style.width = '100%';
            img.style.height = '100%';
            img.style.objectFit = 'cover';
        }

        // явные inline-стили для z-index и opacity (фолбек, если классы не применяются)
        img.style.zIndex = i === current ? '2' : '1';
        img.style.opacity = i === current ? '1' : '0';

        // поддерживаем Tailwind-классы
        if (i === current) {
            img.classList.add('opacity-100');
            img.classList.remove('opacity-0');
        } else {
            img.classList.add('opacity-0');
            img.classList.remove('opacity-100');
        }
    });

    setInterval(() => {
        const next = (current + 1) % imgs.length;

        // скрываем текущий
        imgs[current].classList.remove('opacity-100');
        imgs[current].classList.add('opacity-0');
        imgs[current].setAttribute('aria-hidden', 'true');
        imgs[current].style.opacity = '0';
        imgs[current].style.zIndex = '1';

        // показываем следующий
        imgs[next].classList.remove('opacity-0');
        imgs[next].classList.add('opacity-100');
        imgs[next].setAttribute('aria-hidden', 'false');
        imgs[next].style.opacity = '1';
        imgs[next].style.zIndex = '2';

        current = next;
    }, intervalMs);
});


