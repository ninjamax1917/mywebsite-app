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
        const dropdownHeight = dropdown ? dropdown.getBoundingClientRect().height : 0;
        header.style.height = (originalHeight + dropdownHeight + 12) + 'px';
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
        // immediate collapse when pointer enters another top-level item
        link.addEventListener('pointerenter', function () {
            startCollapse(0);
        });
        link.addEventListener('focus', function () {
            startCollapse(0);
        });
        link.addEventListener('click', function () {
            doCollapse();
        });
    });

    // allow free movement inside expanded header:
    // - entering header cancels collapse timer
    // - leaving header schedules collapse
    header.addEventListener('pointerenter', function () {
        clearCollapseTimer();
    });
    header.addEventListener('pointerleave', function () {
        // pointer left header entirely -> collapse immediately
        startCollapse(0);
    });

    // dropdown behaviour: don't close while moving inside dropdown;
    // close when leaving dropdown to other top-level item or outside header
    if (dropdown) {
        dropdown.addEventListener('pointerenter', function () {
            clearCollapseTimer();
        });
        dropdown.addEventListener('pointerleave', function (e) {
            // if pointer moved to a top-level anchor -> collapse immediately
            const to = e.relatedTarget;
            if (to && desktopNav.contains(to) && to.tagName === 'A' && to !== servicesLink) {
                startCollapse(0);
                return;
            }
            // otherwise schedule collapse (user may move to header other area)
            startCollapse(0);
        });

        dropdown.querySelectorAll('a').forEach(a => {
            a.addEventListener('pointerenter', clearCollapseTimer);
            a.addEventListener('focus', clearCollapseTimer);
            a.addEventListener('click', function () {
                // click on a dropdown item should close header (navigate)
                doCollapse();
            });
        });
    }

    // click outside nav closes (desktop)
    document.addEventListener('click', function (e) {
        if (window.innerWidth < 1024) return;
        if (!desktopNav.contains(e.target)) startCollapse(0);
    });

    // keyboard focus handling on desktopNav
    desktopNav.addEventListener('focusin', function (e) {
        if (window.innerWidth < 1024) return;
        if (desktopNav.contains(e.target)) expand();
    });

    desktopNav.addEventListener('focusout', function () {
        if (window.innerWidth < 1024) return;
        if (!desktopNav.contains(document.activeElement)) startCollapse(0);
    });

    window.addEventListener('resize', function () {
        originalHeight = null;
        header.style.height = '';
        header.classList.remove('expanded');
        clearCollapseTimer();
        if (chev) chev.style.transform = '';
        servicesLink.setAttribute('aria-expanded', 'false');
    });
});