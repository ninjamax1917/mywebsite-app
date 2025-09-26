document.addEventListener('DOMContentLoaded', function () {
    const header = document.getElementById('site-header');
    const desktopNav = header ? header.querySelector('.desktop-nav') : null;
    const servicesLink = desktopNav ? desktopNav.querySelector('a#services-link') : null;
    const chev = servicesLink ? servicesLink.querySelector('svg#chev-services') : null;
    const dropdown = desktopNav ? desktopNav.querySelector('.services-dropdown') : null;

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
        if (window.innerWidth < 1024) return;
        ensureOriginalHeight();
        clearCollapseTimer();
        header.classList.add('expanded');

        const finalHeight = Math.round(originalHeight * 2.3);
        requestAnimationFrame(() => {
            header.style.height = finalHeight + 'px';
        });

        if (chev) chev.style.transform = 'rotate(180deg)';
        servicesLink.setAttribute('aria-expanded', 'true');
    }

    function doCollapse() {
        if (originalHeight === null) return;
        header.classList.remove('expanded');
        header.classList.remove('dropdown-link-hover');
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

    // open on hover/focus of services (desktop)
    servicesLink.addEventListener('pointerenter', function () {
        if (window.innerWidth >= 1024) expand();
    });
    servicesLink.addEventListener('focus', function () {
        if (window.innerWidth >= 1024) expand();
    });

    // toggle on click (desktop)
    servicesLink.addEventListener('click', function (e) {
        if (window.innerWidth < 1024) return;
        e.preventDefault();
        if (header.classList.contains('expanded')) doCollapse();
        else expand();
    });

    // Escape closes
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && header.classList.contains('expanded')) doCollapse();
    });

    // top-level links: only direct children anchors (excluding services-link)
    const topLevelLinks = desktopNav.querySelectorAll(':scope > a:not(#services-link)');

    topLevelLinks.forEach(link => {
        // при наведении или фокусе на одном из разделов — закрываем header
        link.addEventListener('pointerenter', function () {
            if (window.innerWidth >= 1024 && header.classList.contains('expanded')) {
                startCollapse(0);
            }
        });
        link.addEventListener('focus', function () {
            if (window.innerWidth >= 1024 && header.classList.contains('expanded')) {
                startCollapse(0);
            }
        });
        // клик по разделу — немедленно закрыть (навигация)
        link.addEventListener('click', function () {
            doCollapse();
        });
    });

    // allow free movement inside expanded header:
    header.addEventListener('pointerenter', function () {
        clearCollapseTimer();
    });
    header.addEventListener('pointerleave', function () {
        startCollapse(0);
    });

    // dropdown behaviour: добавляем/убираем подсветку остальных элементов при hover/focus подпункта
    if (dropdown) {
        dropdown.addEventListener('pointerenter', function () {
            clearCollapseTimer();
        });
        dropdown.addEventListener('pointerleave', function (e) {
            const to = e.relatedTarget;
            if (to && header.contains(to)) {
                return;
            }
            // ушли из dropdown за пределы header -> убрать эффект
            header.classList.remove('dropdown-link-hover');
            startCollapse(0);
        });

        dropdown.querySelectorAll('a').forEach(a => {
            // при наведении на подпункт — затемняем все остальные
            a.addEventListener('pointerenter', function () {
                if (!(window.innerWidth >= 1024 && header.classList.contains('expanded'))) return;
                header.classList.add('dropdown-link-hover');
            });
            a.addEventListener('focus', function () {
                if (!(window.innerWidth >= 1024 && header.classList.contains('expanded'))) return;
                header.classList.add('dropdown-link-hover');
            });

            // если указатель ушёл к другому элементу внутри dropdown — не убирать класс
            a.addEventListener('pointerleave', function (e) {
                const to = e.relatedTarget;
                if (to && dropdown.contains(to)) return;
                // если ушли из dropdown полностью — убрать класс
                if (!(to && header.contains(to))) {
                    header.classList.remove('dropdown-link-hover');
                }
            });

            a.addEventListener('blur', function () {
                // если фокус не внутри dropdown -> убрать класс
                if (!dropdown.contains(document.activeElement)) {
                    header.classList.remove('dropdown-link-hover');
                }
            });

            a.addEventListener('click', function () {
                // click on a dropdown item should close header (navigate)
                doCollapse();
            });
        });
    }

    // click outside nav closes (desktop)
    document.addEventListener('click', function (e) {
        if (window.innerWidth < 1024) return;
        if (!desktopNav.contains(e.target)) {
            header.classList.remove('dropdown-link-hover');
            startCollapse(0);
        }
    });

    // keyboard focus handling on desktopNav
    desktopNav.addEventListener('focusin', function (e) {
        if (window.innerWidth < 1024) return;
        if (desktopNav.contains(e.target)) expand();
    });

    desktopNav.addEventListener('focusout', function () {
        if (window.innerWidth < 1024) return;
        if (!desktopNav.contains(document.activeElement)) {
            header.classList.remove('dropdown-link-hover');
            startCollapse(0);
        }
    });

    window.addEventListener('resize', function () {
        originalHeight = null;
        header.style.height = '';
        header.classList.remove('expanded');
        header.classList.remove('dropdown-link-hover');
        clearCollapseTimer();
        if (chev) chev.style.transform = '';
        servicesLink.setAttribute('aria-expanded', 'false');
    });
});