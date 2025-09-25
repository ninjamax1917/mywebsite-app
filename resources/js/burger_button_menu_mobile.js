document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    const header = document.querySelector('header'); // читаем высоту, не модифицируем header

    if (!btn || !menu) return;

    // Позиционируем меню под header (только чтение высоты, не меняем header)
    const setMenuPosition = () => {
        if (!header) return;
        const headerRect = header.getBoundingClientRect();
        const headerHeight = Math.ceil(headerRect.height);
        menu.style.top = `${headerHeight}px`;
        menu.style.bottom = '0';
    };

    setMenuPosition();
    window.addEventListener('resize', setMenuPosition);

    // Если есть общий обработчик в mobile_menu.js — делегируем ему клик
    const delegatedToggle = document.getElementById('mobile-menu-toggle');

    // Фоллбек: плавное открытие/закрытие с учётом transitionend
    let isAnimating = false;
    const TRANSFORM_PROP = 'transform';

    // Инициализация aria & visibility (не трогаем header)
    const closedInitially = menu.classList.contains('translate-x-full');
    if (closedInitially) {
        menu.classList.add('invisible', 'pointer-events-none');
        menu.setAttribute('aria-hidden', 'true');
        btn.setAttribute('aria-expanded', 'false');
    } else {
        menu.classList.remove('invisible', 'pointer-events-none');
        menu.setAttribute('aria-hidden', 'false');
        btn.setAttribute('aria-expanded', 'true');
    }

    menu.addEventListener('transitionend', (ev) => {
        if (ev.propertyName !== TRANSFORM_PROP) return;
        // Если после transition menu смещено наружу — скрываем, иначе убираем скрывающие классы
        if (menu.classList.contains('translate-x-full')) {
            menu.classList.add('invisible', 'pointer-events-none');
            menu.setAttribute('aria-hidden', 'true');
        } else {
            menu.classList.remove('invisible', 'pointer-events-none');
            menu.setAttribute('aria-hidden', 'false');
        }
        isAnimating = false;
    });

    btn.addEventListener('click', (e) => {
        // анимация иконки
        btn.classList.toggle('open');

        // делегируем если есть внешний обработчик
        if (delegatedToggle) {
            delegatedToggle.click();
            return;
        }

        // fallback
        if (isAnimating) return;
        isAnimating = true;

        const isOpen = !menu.classList.contains('translate-x-full');

        if (isOpen) {
            // закрываем: запускаем смещение наружу, скрытие поставится по transitionend
            menu.classList.remove('translate-x-0');
            menu.classList.add('translate-x-full');
            btn.setAttribute('aria-expanded', 'false');
            // не трогаем header и не меняем глобальный overflow
            setTimeout(() => { if (isAnimating) isAnimating = false; }, 400);
        } else {
            // открываем: убираем invisible перед анимацией и запускаем смещение внутрь
            menu.classList.remove('invisible', 'pointer-events-none', 'translate-x-full');
            // форсируем reflow для корректного старта transition
            // eslint-disable-next-line no-unused-expressions
            menu.offsetHeight;
            menu.classList.add('translate-x-0');
            btn.setAttribute('aria-expanded', 'true');
            // не трогаем header и не меняем глобальный overflow
            setTimeout(() => { if (isAnimating) isAnimating = false; }, 400);
        }
    });
});