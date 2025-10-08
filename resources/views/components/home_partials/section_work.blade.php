<section class="mt-5 pt-10 lg:pt-10">
    <div class="container-custom">
        <div class="text-center mb-8">
            <h2 id="services-heading"
                class="font-montserrat text-3xl md:text-4xl lg:text-4xl font-extrabold text-gray-800 mb-2 transition-transform transition-opacity duration-700 ease-out opacity-0 translate-x-8 will-change-transform will-change-opacity"
                data-delay="0">
                ЭТАПЫ РАБОТ
            </h2>
        </div>

        <div class="pt-6 max-w-full mx-auto">
            <!-- Контейнер для динамического рендера (без рамки и скруглений, визуальные разрывы внутри wrapper) -->
            <div id="work-accordion" class="w-full" role="tablist" aria-label="Этапы работ"></div>
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
            color 520ms cubic-bezier(.2, .6, .2, 1),
            stroke 520ms cubic-bezier(.2, .6, .2, 1);
        -webkit-transition: -webkit-transform 220ms cubic-bezier(.2, .9, .2, 1),
            color 520ms cubic-bezier(.2, .6, .2, 1),
            stroke 520ms cubic-bezier(.2, .6, .2, 1);
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
        transition: color 520ms cubic-bezier(.2, .6, .2, 1);
        -webkit-transition: color 520ms cubic-bezier(.2, .6, .2, 1);
        will-change: color;
    }

    /* Дополнительная мелочь: если используется utility-класс tailwind для цвета,
       браузер всё равно плавно анимирует свойство color благодаря переходу выше. */

    /* Плавное «гашение» соседних элементов при наведении на один
       Управляется классами контейнера/элемента: has-hover на #work-accordion и is-hover на .accordion-btn */
    #work-accordion.has-hover .accordion-btn:not(.is-hover):not([aria-expanded="true"]) .accordion-title,
    #work-accordion.has-hover .accordion-btn:not(.is-hover):not([aria-expanded="true"]) .icon {
        color: rgb(156 163 175);
        /* text-gray-400 */
        transition-delay: 40ms;
        /* лёгкая задержка, чтобы переход между соседями был мягче */
    }

    #work-accordion.has-hover .accordion-btn.is-hover .accordion-title,
    #work-accordion.has-hover .accordion-btn.is-hover .icon {
        transition-delay: 0ms;
        color: rgb(31 41 55);
        /* text-gray-800 */
    }

    /* Подсветка активного (hover/focus) элемента целиком: при наведении — text-gray-800 */
    #work-accordion .accordion-btn.is-hover {
        color: rgb(31 41 55);
        /* text-gray-800 */
    }

    /* При открытии: и кнопка, и заголовок, и иконка становятся синими */
    #work-accordion .accordion-btn[aria-expanded="true"],
    #work-accordion .accordion-btn[aria-expanded="true"] .accordion-title,
    #work-accordion .accordion-btn[aria-expanded="true"] .icon {
        color: rgb(37 99 235);
    }

    /* Весь wrapper кликабелен (делегирует на внутреннюю кнопку) */
    #work-accordion .accordion-wrapper {
        cursor: pointer;
        background: #ffffff;
        position: relative;
    }

    /* Небольшой визуальный разрыв (gap) создаём псевдо-прозрачной вставкой через margin-bottom,
       но вся зона остаётся кликабельной за счёт делегирования на кнопку */
    #work-accordion .accordion-wrapper {
        margin-bottom: 10px;
    }

    #work-accordion .accordion-wrapper:last-child {
        margin-bottom: 0;
    }
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
            // wrapper без внешних отступов и внутреннего padding (вся «пустота» внутри padding кнопки)
            wrapper.className =
                'accordion-wrapper font-open-sans text-lg overflow-hidden transition-colors duration-300 transition-transform transition-opacity ease-out duration-500 opacity-0 translate-x-8 will-change-transform will-change-opacity border-t border-l border-gray-300';
            // ступенчатая задержка для плавного появления каждого элемента
            wrapper.dataset.delay = String(120 * idx);

            const h3 = document.createElement('h3');

            const btn = document.createElement('button');
            btn.type = 'button';
            // Увеличенный вертикальный padding создает визуальный «воздух», оставаясь кликабельным
            btn.className =
                'text-gray-800 font-montserrat text-lg lg:text-2xl accordion-btn w-full flex items-center justify-between px-5 py-5 lg:py-6 text-left bg-white hover:bg-gray-50 focus:outline-none';
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

            // Делегируем клик по пустой зоне wrapper на кнопку, чтобы «пролётов» не было
            wrapper.addEventListener('click', (e) => {
                // Если клик пришел не из кнопки или ее потомков — инициируем клик по кнопке
                if (!btn.contains(e.target)) {
                    btn.click();
                }
            });
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
                wrap.classList.add('border-gray-200');
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
                            openWrap.classList.add('border-gray-200');
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
                            currentWrapClose.classList.add('border-gray-200');
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
                            currentWrap.classList.remove('border-gray-200');
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

        // Плавное поведение наведения без массовых перерасчётов цветов в JS
        const accContainer = document.getElementById('work-accordion');

        function updateHoverContainerState() {
            const any = buttons.some(b => b.classList.contains('is-hover'));
            if (!accContainer) return;
            if (any) accContainer.classList.add('has-hover');
            else accContainer.classList.remove('has-hover');
        }

        if (accContainer) {
            accContainer.addEventListener('pointerleave', () => {
                buttons.forEach(b => b.classList.remove('is-hover'));
                accContainer.classList.remove('has-hover');
            });
        }

        buttons.forEach(btn => {
            btn.addEventListener('pointerenter', () => {
                btn.classList.add('is-hover');
                updateHoverContainerState();
            });
            btn.addEventListener('pointerleave', () => {
                btn.classList.remove('is-hover');
                updateHoverContainerState();
            });
            btn.addEventListener('focus', () => {
                btn.classList.add('is-hover');
                updateHoverContainerState();
            });
            btn.addEventListener('blur', () => {
                btn.classList.remove('is-hover');
                updateHoverContainerState();
            });
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
