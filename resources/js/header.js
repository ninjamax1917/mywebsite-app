document.addEventListener('DOMContentLoaded', function () {
    const header = document.getElementById('site-header');
    const desktopNav = header ? header.querySelector('.desktop-nav') : null;
    const servicesLink = desktopNav ? desktopNav.querySelector('a#services-link') : null;
    const chev = servicesLink ? servicesLink.querySelector('svg#chev-services') : null;

    if (!header || !desktopNav || !servicesLink) return;

    let originalHeight = null;
    let collapseTimeout = null;
    const COLLAPSE_DELAY = 120;

    function ensureOriginalHeight() {
        if (originalHeight === null) {
            originalHeight = header.getBoundingClientRect().height;
            header.style.height = originalHeight + 'px';
        }
    }

    function expand() {
        // запрещаем открытие для мобильных (бургер)
        if (window.innerWidth < 1024) return;

        ensureOriginalHeight();
        clearCollapseTimer();
        header.classList.add('expanded');
        // Множитель можно подправить под реальный выпадающий контент
        header.style.height = (originalHeight * 2) + 'px';
        if (chev) chev.style.transform = 'rotate(180deg)';
        servicesLink.setAttribute('aria-expanded', 'true');
    }

    function doCollapse() {
        if (originalHeight === null) return;
        header.classList.remove('expanded');
        header.style.height = originalHeight + 'px';
        if (chev) chev.style.transform = '';
        servicesLink.setAttribute('aria-expanded', 'false');
    }

    function startCollapse(delay = COLLAPSE_DELAY) {
        clearCollapseTimer();
        collapseTimeout = setTimeout(doCollapse, delay);
    }

    function clearCollapseTimer() {
        if (collapseTimeout) {
            clearTimeout(collapseTimeout);
            collapseTimeout = null;
        }
    }

    // Открывать при наведении / фокусе на "Услуги" (desktop only inside handler)
    servicesLink.addEventListener('mouseenter', function () {
        if (window.innerWidth >= 1024) expand();
    });
    servicesLink.addEventListener('focus', function () {
        if (window.innerWidth >= 1024) expand();
    });

    // Если пользователь наведёт на другой пункт меню — закрываем сразу
    const otherLinks = desktopNav.querySelectorAll('a:not(#services-link)');
    otherLinks.forEach(link => {
        link.addEventListener('mouseenter', function () {
            startCollapse(0);
        });
        link.addEventListener('focus', function () {
            startCollapse(0);
        });
    });

    // Пока курсор внутри header — отменяем отложенное закрытие
    header.addEventListener('mouseenter', function () {
        clearCollapseTimer();
    });
    header.addEventListener('mouseleave', function () {
        startCollapse(0);
    });

    // Клавиатурная навигация — слушаем только desktop-nav и только для desktop viewport
    desktopNav.addEventListener('focusin', function (e) {
        if (window.innerWidth < 1024) return;
        // если фокус внутри desktop-nav — открываем
        if (desktopNav.contains(e.target)) expand();
    });

    desktopNav.addEventListener('focusout', function () {
        if (window.innerWidth < 1024) return;
        if (!desktopNav.contains(document.activeElement)) startCollapse(0);
    });

    // При ресайзе сбрасываем состояние (и предотвращаем открытие в mobile)
    window.addEventListener('resize', function () {
        originalHeight = null;
        header.style.height = '';
        header.classList.remove('expanded');
        clearCollapseTimer();
        if (chev) chev.style.transform = '';
        servicesLink.setAttribute('aria-expanded', 'false');
    });
});