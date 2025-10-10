import { initReveal } from './reveal';

document.addEventListener('DOMContentLoaded', function () {
    const siteLogo = document.querySelector('.site-logo');
    if (siteLogo) {
        siteLogo.style.willChange = 'opacity, transform';
        siteLogo.style.transition = 'opacity 1100ms cubic-bezier(.2,.7,.2,1), transform 1100ms cubic-bezier(.2,.7,.2,1)';
        siteLogo.style.transitionDelay = '80ms';
    }

    const headerIcons = document.querySelector('.header-icons');
    const ICON_TRANS_MS = 360;
    const ICON_STAGGER = 80;

    // timers for cleaning up concurrent animations
    let hideTimers = [];
    let showTimers = [];

    function clearHideTimers() {
        hideTimers.forEach(id => clearTimeout(id));
        hideTimers = [];
    }
    function clearShowTimers() {
        showTimers.forEach(id => clearTimeout(id));
        showTimers = [];
    }

    // prepare children transitions and initial inline opacity
    if (headerIcons) {
        headerIcons.style.willChange = 'opacity, transform';
        Array.from(headerIcons.children).forEach((it) => {
            it.style.willChange = 'opacity, transform';
            it.style.transition = `opacity ${ICON_TRANS_MS}ms cubic-bezier(.2,.7,.2,1), transform ${ICON_TRANS_MS}ms cubic-bezier(.2,.7,.2,1)`;
            const cs = window.getComputedStyle(it);
            if (cs.opacity) it.style.opacity = cs.opacity;
        });
        headerIcons.style.visibility = window.getComputedStyle(headerIcons).visibility || 'visible';
    }

    initReveal([
        { selector: '.site-logo', type: 'fade-in', delay: 120 },
        { selector: '.desktop-nav', type: 'stagger-children', delay: 220, delayBetween: 90 },
        { selector: '.header-icons', type: 'stagger-children', delay: 300, delayBetween: 110 }
    ], { threshold: 0.06 });

    function ensureContainerVisible() {
        if (!headerIcons) return;
        if (window.innerWidth >= 1024) {
            headerIcons.style.display = 'flex';
        } else {
            headerIcons.style.display = '';
        }
    }

    function hideHeaderIcons(stagger = true) {
        if (!headerIcons) return;
        clearShowTimers();
        clearHideTimers();
        ensureContainerVisible();
        headerIcons.style.visibility = 'visible';
        const items = Array.from(headerIcons.children);
        items.forEach((it, i) => {
            const delay = stagger ? i * ICON_STAGGER : 0;
            const id = setTimeout(() => {
                it.style.pointerEvents = 'none';
                it.style.opacity = '0';
            }, delay);
            hideTimers.push(id);
        });
        const totalDelay = (items.length - 1) * (stagger ? ICON_STAGGER : 0) + ICON_TRANS_MS;
        const idHide = setTimeout(() => {
            headerIcons.style.visibility = 'hidden';
        }, totalDelay + 20);
        hideTimers.push(idHide);
    }

    function showHeaderIcons(stagger = true) {
        if (!headerIcons) return;
        clearHideTimers();
        clearShowTimers();
        headerIcons.style.display = window.innerWidth >= 1024 ? 'flex' : '';
        headerIcons.style.visibility = 'visible';
        const items = Array.from(headerIcons.children);

        // Раньше мы режем всем opacity=0 перед анимацией — это и вызывает мигание.
        // Сейчас: анимируем только те элементы, которые реально скрыты (opacity <= 0.5).
        items.forEach((it, i) => {
            const computed = parseFloat(window.getComputedStyle(it).opacity || '0');
            const delay = stagger ? i * ICON_STAGGER : 0;

            if (computed > 0.5) {
                // уже видимы — просто убедиться, что pointerEvents включены и положение корректно
                it.style.opacity = '1';
                it.style.pointerEvents = '';
                if (it.classList.contains('translate-y-4')) {
                    it.classList.remove('translate-y-4');
                    it.classList.add('translate-y-0');
                }
            } else {
                // для скрытых элементов — запустить анимацию появления
                it.style.pointerEvents = 'none';
                it.style.opacity = '0';
                const id = setTimeout(() => {
                    it.style.opacity = '1';
                    if (it.classList.contains('translate-y-4')) {
                        it.classList.remove('translate-y-4');
                        it.classList.add('translate-y-0');
                    }
                    const reenable = setTimeout(() => { it.style.pointerEvents = ''; }, ICON_TRANS_MS);
                    showTimers.push(reenable);
                }, delay);
                showTimers.push(id);
            }
        });
    }

    (function initialShowIfNeeded() {
        if (!headerIcons) return;
        if (window.innerWidth < 1024) return;
        const anyVisible = Array.from(headerIcons.children).some(it => parseFloat(window.getComputedStyle(it).opacity) > 0.1);
        if (!anyVisible) {
            setTimeout(() => showHeaderIcons(true), 220);
        }
    })();

    (function ensureVisibleFallback() {
        if (headerIcons) {
            setTimeout(() => {
                const items = Array.from(headerIcons.children);
                items.forEach(it => {
                    it.style.opacity = '1';
                    it.classList.remove('opacity-0');
                    it.classList.add('opacity-100');
                    it.dataset.animated = '1';
                    it.style.pointerEvents = '';
                });
                headerIcons.style.visibility = 'visible';
                headerIcons.style.display = window.innerWidth >= 1024 ? 'flex' : '';
            }, 1400);
        }
    })();

    // --- header interactions ---
    const header = document.getElementById('site-header');
    const desktopNavEl = header ? header.querySelector('.desktop-nav') : null;
    const servicesLink = desktopNavEl ? desktopNavEl.querySelector('a#services-link') : null;
    const chev = servicesLink ? servicesLink.querySelector('svg#chev-services') : null;
    const dropdown = desktopNavEl ? desktopNavEl.querySelector('.services-dropdown') : null;

    // Mobile menu: lock page scroll when opened
    const mobileMenu = document.getElementById('mobile-menu');
    // try to find burger/toggle elements (common attributes/classes)
    const mobileToggles = Array.from(document.querySelectorAll('[aria-controls="mobile-menu"], [data-mobile-menu-toggle], .burger-button, #mobile-menu-toggle'));
    let mobileOpen = false;
    let _scrollY = 0;

    function lockBodyScroll() {
        _scrollY = window.scrollY || document.documentElement.scrollTop || 0;
        // prevent smooth scrolling jump on restore
        document.documentElement.style.scrollBehavior = 'auto';
        // fix body to prevent background scroll and preserve visual position
        document.body.style.position = 'fixed';
        document.body.style.top = `-${_scrollY}px`;
        document.body.style.left = '0';
        document.body.style.right = '0';
        document.body.style.width = '100%';
        // also hide overflow as extra safety
        document.documentElement.style.overflow = 'hidden';
        document.body.style.overflow = 'hidden';
    }

    function unlockBodyScroll() {
        // restore styles
        document.body.style.position = '';
        document.body.style.top = '';
        document.body.style.left = '';
        document.body.style.right = '';
        document.body.style.width = '';
        document.documentElement.style.overflow = '';
        document.body.style.overflow = '';
        // restore previous scroll position
        window.scrollTo(0, _scrollY);
        // clear the forced scrollBehavior
        document.documentElement.style.scrollBehavior = '';
    }

    function openMobileMenu() {
        if (!mobileMenu || mobileOpen) return;
        mobileMenu.classList.remove('translate-x-full', 'invisible', 'pointer-events-none');
        mobileMenu.classList.add('translate-x-0');
        mobileMenu.setAttribute('aria-hidden', 'false');
        mobileToggles.forEach(btn => { if (btn && btn.setAttribute) btn.setAttribute('aria-expanded', 'true'); });
        lockBodyScroll();
        mobileOpen = true;
    }

    function closeMobileMenu() {
        if (!mobileMenu || !mobileOpen) return;
        mobileMenu.classList.add('translate-x-full', 'invisible', 'pointer-events-none');
        mobileMenu.classList.remove('translate-x-0');
        mobileMenu.setAttribute('aria-hidden', 'true');
        mobileToggles.forEach(btn => { if (btn && btn.setAttribute) btn.setAttribute('aria-expanded', 'false'); });
        unlockBodyScroll();
        mobileOpen = false;
    }

    function toggleMobileMenu() { if (mobileOpen) closeMobileMenu(); else openMobileMenu(); }

    // Attach toggle handlers
    mobileToggles.forEach(btn => {
        try {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                toggleMobileMenu();
            });
        } catch (err) { /* ignore non-elements */ }
    });

    // close when clicking links inside mobile menu
    if (mobileMenu) {
        mobileMenu.querySelectorAll('a').forEach(a => {
            a.addEventListener('click', function (e) {
                try {
                    const href = a.getAttribute('href') || '';
                    const isEmptyOrHash = href === '' || href === '#' || href.startsWith('#');
                    const isJavascript = href.trim().toLowerCase().startsWith('javascript:');
                    const isToggle = a.hasAttribute('aria-controls') || a.dataset.noClose === '1' || a.classList.contains('mobile-submenu-toggle');

                    // Don't close for submenu toggles / hash anchors / javascript pseudo-links
                    if (isToggle || isEmptyOrHash || isJavascript) {
                        return;
                    }

                    // For real navigation links close the mobile menu
                    closeMobileMenu();
                } catch (err) {
                    // fail silently
                }
            });
        });
    }
    // close on escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            if (mobileOpen) closeMobileMenu();
        }
    });

    // close on outside click
    document.addEventListener('click', function (e) {
        if (!mobileOpen || !mobileMenu) return;
        const isClickInside = mobileMenu.contains(e.target) || mobileToggles.some(btn => btn.contains && btn.contains(e.target));
        if (!isClickInside) closeMobileMenu();
    });

    // close on resize to desktop
    window.addEventListener('resize', function () {
        if (window.innerWidth >= 1024 && mobileOpen) {
            closeMobileMenu();
        }
    });

    if (!header || !desktopNavEl || !servicesLink) return;

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
        hideHeaderIcons(true);
        servicesLink.setAttribute('aria-expanded', 'true');
    }

    function doCollapse() {
        if (originalHeight === null) return;
        header.classList.remove('expanded');
        header.classList.remove('dropdown-link-hover');
        header.style.height = originalHeight + 'px';
        if (chev) chev.style.transform = '';
        showHeaderIcons(true);
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

    servicesLink.addEventListener('pointerenter', function () {
        if (window.innerWidth >= 1024) expand();
    });
    servicesLink.addEventListener('focus', function () {
        if (window.innerWidth >= 1024) expand();
    });

    servicesLink.addEventListener('click', function (e) {
        if (window.innerWidth < 1024) return;
        e.preventDefault();
        if (header.classList.contains('expanded')) doCollapse();
        else expand();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && header.classList.contains('expanded')) doCollapse();
    });

    const topLevelLinks = desktopNavEl.querySelectorAll(':scope > a:not(#services-link)');
    topLevelLinks.forEach(link => {
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
        link.addEventListener('click', function () {
            doCollapse();
        });
    });

    header.addEventListener('pointerenter', function () {
        clearCollapseTimer();
    });
    header.addEventListener('pointerleave', function () {
        startCollapse(0);
    });

    if (dropdown) {
        dropdown.addEventListener('pointerenter', function () {
            clearCollapseTimer();
        });
        dropdown.addEventListener('pointerleave', function (e) {
            const to = e.relatedTarget;
            if (to && header.contains(to)) return;
            header.classList.remove('dropdown-link-hover');
            startCollapse(0);
        });

        dropdown.querySelectorAll('a').forEach(a => {
            a.addEventListener('pointerenter', function () {
                if (!(window.innerWidth >= 1024 && header.classList.contains('expanded'))) return;
                header.classList.add('dropdown-link-hover');
            });
            a.addEventListener('focus', function () {
                if (!(window.innerWidth >= 1024 && header.classList.contains('expanded'))) return;
                header.classList.add('dropdown-link-hover');
            });

            a.addEventListener('pointerleave', function (e) {
                const to = e.relatedTarget;
                if (to && dropdown.contains(to)) return;
                if (!(to && header.contains(to))) {
                    header.classList.remove('dropdown-link-hover');
                }
            });

            a.addEventListener('blur', function () {
                if (!dropdown.contains(document.activeElement)) {
                    header.classList.remove('dropdown-link-hover');
                }
            });

            a.addEventListener('click', function () {
                doCollapse();
            });
        });
    }

    document.addEventListener('click', function (e) {
        if (window.innerWidth < 1024) return;
        if (!desktopNavEl.contains(e.target)) {
            header.classList.remove('dropdown-link-hover');
            startCollapse(0);
        }
    });

    desktopNavEl.addEventListener('focusin', function (e) {
        if (window.innerWidth < 1024) return;
        // expand only when focus lands on Services link or its dropdown children
        const focused = e.target;
        if (servicesLink && (focused === servicesLink || servicesLink.contains(focused))) {
            expand();
            return;
        }
        if (dropdown && (focused === dropdown || dropdown.contains(focused))) {
            expand();
            return;
        }
    });

    desktopNavEl.addEventListener('focusout', function () {
        if (window.innerWidth < 1024) return;
        if (!desktopNavEl.contains(document.activeElement)) {
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
        showHeaderIcons(false);
    });

    // --- Управление направлением underline-анимации (сворачивание вправо) ---
    (function manageUnderlineDirection() {
        const underlineEls = Array.from(document.querySelectorAll('.underline-anim-nav, #services-link'));
        underlineEls.forEach(el => {
            // На вход курсора/фокус — показать линию слева-направо
            const onEnter = () => {
                el.classList.add('hovering');
                el.classList.remove('shrink-right');
            };
            // На выход — сжать к правому краю
            const onLeave = () => {
                el.classList.remove('hovering');
                // force reflow, чтобы браузер применил новый transform-origin до трансформации
                void el.offsetWidth;
                el.classList.add('shrink-right');
                // снять класс после завершения transition transform у псевдоэлемента —
                // слушаем у родителя, так как псевдоэлемент событий не шлёт
                let timeoutId = null;
                const cleanup = () => {
                    el.classList.remove('shrink-right');
                    el.removeEventListener('transitionend', onTransitionEnd, true);
                    if (timeoutId) clearTimeout(timeoutId);
                };
                const onTransitionEnd = (e) => {
                    if (e.propertyName === 'transform') {
                        cleanup();
                    }
                };
                el.addEventListener('transitionend', onTransitionEnd, true);
                // Фолбек-таймер, если transitionend не прилетит (0.6s > .45s)
                timeoutId = setTimeout(cleanup, 600);
            };

            el.addEventListener('pointerenter', onEnter);
            el.addEventListener('focus', onEnter);
            el.addEventListener('pointerleave', onLeave);
            el.addEventListener('blur', onLeave);
        });
    })();
});