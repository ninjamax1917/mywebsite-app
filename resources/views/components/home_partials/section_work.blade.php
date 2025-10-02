<section class="mt-20 pt-12 lg:pt-12 border-t border-gray-300">
    <div class="max-w-[1440px] mx-auto px-0 md:px-0 lg:px-20">
        <div class="text-center mb-8">
            <h2 id="services-heading"
                class="font-montserrat text-3xl md:text-4xl lg:text-4xl font-extrabold text-gray-800 mb-2 transition-transform transition-opacity duration-700 ease-out opacity-0 translate-x-8 will-change-transform will-change-opacity"
                data-delay="0">
                ЭТАПЫ РАБОТ
            </h2>
        </div>

        <div class="pt-6 max-w-full mx-auto">
            <!-- Контейнер для динамического рендера -->
            <div class="space-y-[10px]" id="work-accordion" role="tablist" aria-label="Этапы работ"></div>
        </div>
    </div>
</section>

<!-- Добавлено: явный курсор pointer для кнопок аккордеона и более плавная смена цвета -->
<style>
    /* Гарантируем pointer при наведении на .accordion-btn */
    .accordion-btn {
        cursor: pointer;
    }

    /*
      Плавные переходы:
      - color влияет на stroke у SVG через stroke="currentColor"
      - добавляем анимацию для stroke явно, на случай браузеров, где это нужно
      - увеличиваем время и сглаживание для более мягкого перехода
    */
    .icon {
        transition: transform 220ms cubic-bezier(.2, .9, .2, 1),
            color 420ms cubic-bezier(.2, .6, .2, 1),
            stroke 420ms cubic-bezier(.2, .6, .2, 1);
        -webkit-transition: -webkit-transform 220ms cubic-bezier(.2, .9, .2, 1),
            color 420ms cubic-bezier(.2, .6, .2, 1),
            stroke 420ms cubic-bezier(.2, .6, .2, 1);
        transform-origin: center center;
        transform-box: fill-box;
        display: inline-block;
        will-change: transform, color, stroke;
    }

    /* При открытии (aria-expanded="true") поворачиваем плюс на 45°, чтобы он стал «×» */
    .accordion-btn[aria-expanded="true"] .icon {
        transform: rotate(45deg);
    }

    /* Плавная смена цвета заголовков аккордеона — более длительная и мягкая */
    .accordion-title {
        transition: color 420ms cubic-bezier(.2, .6, .2, 1);
        -webkit-transition: color 420ms cubic-bezier(.2, .6, .2, 1);
        will-change: color;
    }

    /* Дополнительная мелочь: если используется utility-класс tailwind для цвета,
       браузер всё равно плавно анимирует свойство color благодаря переходу выше. */
</style>

<script>
    const accordionData = [{
            title: '1. Обследование объекта',
            content: 'Осмотр объекта, замеры, изучение проектной документации смежных разделов и сбор всей информации для расчета сметы и составления плана работ'
        },
        {
            title: '2. Согласование',
            content: 'Утверждение сметы, сроков и материалов. Подписание договора и согласование деталей. Предоплата только за материалы.'
        },
        {
            title: '3. Производство работ',
            content: 'Выполнение работ согласно договору, технического задания, сметы и нормативных документов.'
        },
        {
            title: '4. Сдача',
            content: 'Приёмка работ, передача документации и финальная оплата после сдачи работ.'
        }
    ];

    // Рендер аккордеона: внешний panel + внутренний .panel-inner для GPU-анимации
    function renderAccordion(containerId, data) {
        const container = document.getElementById(containerId);
        if (!container) return;
        container.innerHTML = '';

        data.forEach((item, idx) => {
            const id = idx + 1;

            const wrapper = document.createElement('div');
            wrapper.id = `wrapper-${id}`;
            wrapper.className =
                'font-open-sans text-lg p-2 border-t border-l border-gray-300 overflow-hidden transition-colors duration-300 transition-transform transition-opacity ease-out duration-500 opacity-0 translate-x-8 will-change-transform will-change-opacity';
            // ступенчатая задержка для плавного появления каждого элемента
            wrapper.dataset.delay = String(120 * idx);

            const h3 = document.createElement('h3');

            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className =
                'text-gray-800 font-montserrat text-lg lg:text-2xl accordion-btn w-full flex items-center justify-between px-4 py-3 text-left bg-white hover:bg-gray-50 focus:outline-none';
            btn.setAttribute('data-target', `panel-${id}`);
            btn.id = `tab-${id}`;
            btn.dataset.wrapper = wrapper.id;
            btn.setAttribute('aria-controls', `panel-${id}`);
            btn.setAttribute('aria-expanded', 'false');

            // Плюс — превращается в × при добавлении aria-expanded="true"
            btn.innerHTML = `<span class="accordion-title transition-colors duration-300 font-semibold">${item.title}</span>
                <svg class="icon w-7 h-7 lg:w-9 lg:h-9" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>`;

            h3.appendChild(btn);

            // внешний контейнер — max-height + containment
            const panel = document.createElement('div');
            panel.id = `panel-${id}`;
            panel.setAttribute('role', 'region');
            panel.setAttribute('aria-labelledby', `tab-${id}`);
            panel.className = 'overflow-hidden';
            panel.style.display = 'none';
            panel.style.overflow = 'hidden';
            panel.dataset.animating = 'idle'; // idle | opening | closing
            panel.style.maxHeight = '0px';
            panel.style.transition = 'max-height 260ms cubic-bezier(.2,.9,.2,1)';
            panel.style.contain = 'layout paint';
            panel.style.willChange = 'max-height';

            // внутренний блок: переносим отступы сюда, не анимируем transform/opacity
            const inner = document.createElement('div');
            inner.className = 'panel-inner px-4 py-3';
            inner.innerText = item.content;

            panel.appendChild(inner);
            wrapper.appendChild(h3);
            wrapper.appendChild(panel);
            container.appendChild(wrapper);
        });
    }

    // вычислить полную контентную высоту панели
    function computePanelContentHeight(panel) {
        return panel.scrollHeight;
    }

    // Открытие панели
    function openPanel(panel) {
        if (!panel) return;
        if (panel.dataset.animating === 'opening') return;
        panel.dataset.animating = 'opening';

        panel.style.display = '';
        panel.style.pointerEvents = 'none';
        panel.style.willChange = 'max-height';

        const targetHeight = computePanelContentHeight(panel) + 1; // +1px для субпикселей

        const startHeight = parseFloat(getComputedStyle(panel).maxHeight) || 0;
        panel.style.maxHeight = startHeight + 'px';

        requestAnimationFrame(() => {
            panel.style.maxHeight = targetHeight + 'px';
        });

        const onPanelEnd = (e) => {
            if (e.target === panel && e.propertyName === 'max-height') {
                panel.style.maxHeight = '';
                panel.dataset.animating = 'idle';
                panel.style.pointerEvents = '';
                panel.style.willChange = 'auto';
                panel.removeEventListener('transitionend', onPanelEnd);
            }
        };
        panel.addEventListener('transitionend', onPanelEnd);
    }

    // Закрытие панели (с форсированным reflow и синхронизацией)
    function closePanel(panel) {
        if (!panel) return;
        if (panel.dataset.animating === 'closing') return;
        panel.dataset.animating = 'closing';
        panel.style.pointerEvents = 'none';
        panel.style.willChange = 'max-height';

        // Зафиксировать текущую высоту как стартовую точку анимации
        const currentHeight = panel.scrollHeight;
        panel.style.maxHeight = currentHeight + 'px';

        // Форсируем reflow, чтобы браузер применил стартовые значения
        panel.getBoundingClientRect();

        // Схлопывание контейнера
        requestAnimationFrame(() => {
            panel.style.maxHeight = '0px';
        });

        const onPanelEnd = (e) => {
            if (e.target === panel && e.propertyName === 'max-height') {
                panel.style.display = 'none';
                panel.style.maxHeight = '';
                panel.dataset.animating = 'idle';
                panel.style.pointerEvents = '';
                panel.style.willChange = 'auto';
                panel.removeEventListener('transitionend', onPanelEnd);
            }
        };
        panel.addEventListener('transitionend', onPanelEnd);
    }

    // FLIP-анимация для footer (компенсация сдвига)
    function flipFooterAnimation(doChanges) {
        const footer = document.querySelector('footer');
        if (!footer) {
            doChanges();
            return;
        }
        const first = footer.getBoundingClientRect();
        doChanges();
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                const last = footer.getBoundingClientRect();
                const deltaY = last.top - first.top;
                if (!deltaY) return;
                const dur = 260;
                footer.style.transition = `transform ${dur}ms cubic-bezier(.2,.9,.2,1)`;
                footer.style.transform = `translateY(${-deltaY}px)`;
                footer.getBoundingClientRect();
                footer.style.transform = '';
                const cleanup = () => {
                    footer.style.transition = '';
                    footer.removeEventListener('transitionend', cleanup);
                };
                footer.addEventListener('transitionend', cleanup);
            });
        });
    }

    // Инициализация
    function initAccordion() {
        renderAccordion('work-accordion', accordionData);

        const buttons = Array.from(document.querySelectorAll('.accordion-btn'));
        if (!buttons.length) return;

        buttons.forEach((btn) => {
            const panel = document.getElementById(btn.dataset.target);
            btn.setAttribute('aria-expanded', 'false');
            if (panel) {
                panel.style.display = 'none';
                panel.style.maxHeight = '0px';
            }
            // Не скрываем inner: анимируем только max-height у панели
            const wrap = document.getElementById(btn.dataset.wrapper);
            if (wrap) {
                wrap.classList.remove('border-blue-600');
                wrap.classList.add('border-gray-300');
            }
            const title = btn.querySelector('.accordion-title');
            const icon = btn.querySelector('.icon');
            if (title) title.classList.remove('text-blue-600', 'text-gray-400');
            if (icon) icon.classList.remove('text-blue-600', 'text-gray-400');
        });

        buttons.forEach((btn) => {
            btn.addEventListener('click', () => {
                const currentlyOpenBtn = buttons.find(b => b.getAttribute('aria-expanded') === 'true');
                const isOpen = btn.getAttribute('aria-expanded') === 'true';

                flipFooterAnimation(() => {
                    if (currentlyOpenBtn && currentlyOpenBtn !== btn) {
                        currentlyOpenBtn.setAttribute('aria-expanded', 'false');
                        const openPanelEl = document.getElementById(currentlyOpenBtn.dataset
                            .target);
                        if (openPanelEl) closePanel(openPanelEl);
                        const openWrap = document.getElementById(currentlyOpenBtn.dataset
                            .wrapper);
                        if (openWrap) {
                            openWrap.classList.remove('border-blue-600');
                            openWrap.classList.add('border-gray-300');
                        }
                        const openTitle = currentlyOpenBtn.querySelector('.accordion-title');
                        const openIcon = currentlyOpenBtn.querySelector('.icon');
                        if (openTitle) openTitle.classList.remove('text-blue-600');
                        if (openIcon) openIcon.classList.remove('text-blue-600');
                    }

                    if (isOpen) {
                        btn.setAttribute('aria-expanded', 'false');
                        const panelToClose = document.getElementById(btn.dataset.target);
                        if (panelToClose) closePanel(panelToClose);
                        const currentWrapClose = document.getElementById(btn.dataset.wrapper);
                        if (currentWrapClose) {
                            currentWrapClose.classList.remove('border-blue-600');
                            currentWrapClose.classList.add('border-gray-300');
                        }
                        const currentTitleClose = btn.querySelector('.accordion-title');
                        const currentIconClose = btn.querySelector('.icon');
                        if (currentTitleClose) currentTitleClose.classList.remove(
                            'text-blue-600');
                        if (currentIconClose) currentIconClose.classList.remove(
                            'text-blue-600');
                    } else {
                        btn.setAttribute('aria-expanded', 'true');
                        const panelToOpen = document.getElementById(btn.dataset.target);
                        if (panelToOpen) openPanel(panelToOpen);
                        const currentWrap = document.getElementById(btn.dataset.wrapper);
                        if (currentWrap) {
                            currentWrap.classList.remove('border-gray-300');
                            currentWrap.classList.add('border-blue-600');
                        }
                        const currentTitle = btn.querySelector('.accordion-title');
                        const currentIcon = btn.querySelector('.icon');
                        if (currentTitle) currentTitle.classList.add('text-blue-600');
                        if (currentIcon) currentIcon.classList.add('text-blue-600');
                    }
                });
            });
        });

        // При наведении / фокусе на один объект — остальные становятся text-gray-400 (плавно), и иконки тоже
        function fadeOthers(activeBtn) {
            buttons.forEach(b => {
                if (b === activeBtn) return;
                const t = b.querySelector('.accordion-title');
                const ic = b.querySelector('.icon');
                // удалить возможные конфликтующие цветовые классы и поставить серый
                if (t) {
                    t.classList.remove('text-gray-600', 'text-gray-800', 'text-blue-600');
                    t.classList.add('text-gray-400');
                }
                if (ic) {
                    ic.classList.remove('text-gray-600', 'text-gray-800', 'text-blue-600');
                    ic.classList.add('text-gray-400');
                }
            });
        }

        function clearFade() {
            buttons.forEach(b => {
                const t = b.querySelector('.accordion-title');
                const ic = b.querySelector('.icon');
                if (t) t.classList.remove('text-gray-400');
                if (ic) ic.classList.remove('text-gray-400');
            });
        }
        buttons.forEach(btn => {
            btn.addEventListener('pointerenter', () => fadeOthers(btn));
            btn.addEventListener('pointerleave', clearFade);
            btn.addEventListener('focus', () => fadeOthers(btn));
            btn.addEventListener('blur', clearFade);
        });

        // После инициализации аккордеона запускаем анимацию появления при скролле
        initWorkReveal();
    }

    document.addEventListener('DOMContentLoaded', initAccordion);

    // Анимация появления секции и элементов при скролле (выезд справа -> налево)
    function initWorkReveal() {
        const reduceMotion = typeof window !== 'undefined' && window.matchMedia && window.matchMedia(
            '(prefers-reduced-motion: reduce)').matches;

        const heading = document.getElementById('services-heading');
        const items = Array.from(document.querySelectorAll('#work-accordion > div[id^="wrapper-"]'));

        // helper: применить финальное состояние мгновенно
        const showInstant = (el) => {
            if (!el) return;
            el.classList.remove('opacity-0', 'translate-x-8');
            el.classList.add('opacity-100', 'translate-x-0');
            el.dataset.animated = '1';
        };

        if (reduceMotion) {
            if (heading) showInstant(heading);
            items.forEach(showInstant);
            return;
        }

        // Убедимся, что у наблюдаемых элементов есть начальные классы
        if (heading && !heading.classList.contains('opacity-0')) {
            heading.classList.add('opacity-0', 'translate-x-8');
        }
        items.forEach((el) => {
            if (!el.classList.contains('opacity-0')) {
                el.classList.add('opacity-0', 'translate-x-8');
            }
        });

        const threshold = 0.18;
        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                const el = entry.target;
                if (el.dataset.animated === '1') {
                    obs.unobserve(el);
                    return;
                }

                const baseDelay = 60; // базовая задержка
                const elDelay = el.dataset && el.dataset.delay ? parseInt(el.dataset.delay, 10) : 0;

                el.style.willChange = 'transform, opacity';
                setTimeout(() => {
                    el.classList.remove('opacity-0', 'translate-x-8');
                    el.classList.add('opacity-100', 'translate-x-0');
                    el.dataset.animated = '1';
                    // небольшая задержка очистки will-change после завершения перехода
                    setTimeout(() => {
                        el.style.willChange = 'auto';
                    }, 500);
                }, baseDelay + elDelay);

                obs.unobserve(el);
            });
        }, {
            threshold
        });

        if (heading) observer.observe(heading);
        items.forEach(el => observer.observe(el));
    }
</script>
