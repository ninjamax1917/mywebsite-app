// ...existing code...
document.addEventListener('DOMContentLoaded', function () {
    var mobileMenu = document.getElementById('mobile-menu');
    var servicesLink = mobileMenu ? mobileMenu.querySelector('#services-link') : null;
    var submenu = mobileMenu ? mobileMenu.querySelector('#services-submenu') : null;
    var chev = mobileMenu ? mobileMenu.querySelector('#chev-services') : null;

    if (!mobileMenu || !servicesLink || !submenu || !chev) return;

    // Утилита: затемнить/восстановить остальные top-level ссылки (только внутри mobileMenu)
    function dimOtherLinks(dim) {
        var links = mobileMenu.querySelectorAll('.mobile-menu-link');
        links.forEach(function (link) {
            if (link === servicesLink) return;
            if (dim) {
                link.classList.remove('text-gray-200');
                link.classList.add('text-gray-500');
            } else {
                link.classList.remove('text-gray-500');
                link.classList.add('text-gray-200');
            }
        });
    }

    // Пользовательские настройки анимации
    var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (reduceMotion) {
        servicesLink.addEventListener('click', function (e) {
            e.preventDefault();
            var isHidden = submenu.classList.toggle('hidden');
            if (!isHidden) submenu.style.display = 'block'; else submenu.style.display = 'none';
            chev.classList.toggle('rotate-180');
            servicesLink.setAttribute('aria-expanded', (!isHidden).toString());
            // подсветка пока открыт
            if (!isHidden) {
                servicesLink.style.color = '#0077FF';
                dimOtherLinks(true);
            } else {
                servicesLink.style.color = '';
                dimOtherLinks(false);
            }
        });
        return;
    }

    // Подготовка анимации подменю
    submenu.style.overflow = 'hidden';
    submenu.style.transition = 'max-height 280ms ease';

    // Плавный поворот стрелки
    chev.style.transition = 'transform 420ms ease';
    chev.style.transformOrigin = '50% 50%';

    // Будем управлять общим углом вращения
    var angle = 0;

    // Нормализуем начальное состояние
    var initiallyHidden = submenu.classList.contains('hidden');
    if (initiallyHidden) {
        submenu.classList.remove('hidden');
        submenu.style.display = 'none';
        submenu.style.maxHeight = '0px';
        submenu.dataset.open = 'false';
        servicesLink.setAttribute('aria-expanded', 'false');
        angle = 0;
        chev.style.transform = 'rotate(' + angle + 'deg)';
        servicesLink.style.color = '';
        dimOtherLinks(false);
    } else {
        submenu.style.display = 'block';
        submenu.style.maxHeight = submenu.scrollHeight + 'px';
        submenu.dataset.open = 'true';
        servicesLink.setAttribute('aria-expanded', 'true');
        angle = 180;
        chev.style.transform = 'rotate(' + angle + 'deg)';
        servicesLink.style.color = '#0077FF';
        dimOtherLinks(true);
    }

    var animating = false;
    var extra = 360; // дополнительный полный оборот
    var baseFlip = 180; // базовый переворот

    servicesLink.addEventListener('click', function (e) {
        e.preventDefault();
        if (animating) return;

        var isOpen = submenu.dataset.open === 'true';

        if (!isOpen) {
            // Открытие
            submenu.style.display = 'block';
            submenu.style.maxHeight = '0px';
            // принудительный reflow
            // eslint-disable-next-line no-unused-expressions
            submenu.offsetHeight;
            animating = true;
            requestAnimationFrame(function () {
                submenu.style.maxHeight = submenu.scrollHeight + 'px';
            });
            submenu.dataset.open = 'true';
            servicesLink.setAttribute('aria-expanded', 'true');

            // добавляем базовый переворот + дополнительный полный оборот (вперед)
            angle += baseFlip + extra;
            chev.style.transform = 'rotate(' + angle + 'deg)';

            // подсветка пока открыт
            servicesLink.style.color = '#0077FF';
            dimOtherLinks(true);
        } else {
            // Закрытие — если maxHeight == '' (auto), сначала выставим текущую высоту
            if (!submenu.style.maxHeight) {
                submenu.style.maxHeight = submenu.scrollHeight + 'px';
                // принудительный reflow
                // eslint-disable-next-line no-unused-expressions
                submenu.offsetHeight;
            }
            animating = true;
            requestAnimationFrame(function () {
                submenu.style.maxHeight = '0px';
            });
            submenu.dataset.open = 'false';
            servicesLink.setAttribute('aria-expanded', 'false');

            // при закрытии поворачиваем в обратную сторону на базовый переворот + дополнительный полный оборот
            angle -= (baseFlip + extra);
            chev.style.transform = 'rotate(' + angle + 'deg)';

            // убрать подсветку после закрытия
            servicesLink.style.color = '';
            dimOtherLinks(false);
        }
    });

    submenu.addEventListener('transitionend', function (ev) {
        if (ev.propertyName !== 'max-height') return;
        animating = false;
        if (submenu.dataset.open === 'true') {
            submenu.style.maxHeight = '';
        } else {
            submenu.style.display = 'none';
        }
    });
});