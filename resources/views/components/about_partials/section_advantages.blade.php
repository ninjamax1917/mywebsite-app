@php
    $advantages = [
        [
            'main' => '01',
            'title' => 'ИНДИВИДУАЛЬНЫЙ ПОДХОД К КАЖДОМУ ПРОЕКТУ',
            'text' =>
                'Мы создаем решения, которые учитывают специфику вашего объекта. Наши специалисты тщательно анализируют особенности проекта и разрабатывают оптимальную стратегию реализации.',
        ],
        [
            'main' => '02',
            'title' => 'ПОЛНЫЙ ЦИКЛ',
            'text' =>
                'От первого эскиза до финальной сдачи объекта — мы берём на себя все этапы работы. Вы получаете единого ответственного партнёра, который гарантирует безупречное качество на каждом этапе реализации проекта.',
        ],
        [
            'main' => '03',
            'title' => 'КВАЛИФИЦИРОВАННЫЙ ПЕРСОНАЛ',
            'text' =>
                'В нашей команде — только сертифицированные специалисты с профильным образованием и обширным практическим опытом. Мы регулярно повышаем квалификацию наших сотрудников и следим за новыми тенденциями в отрасли.',
        ],
        [
            'main' => '04',
            'title' => 'СОВРЕМЕННОЕ ОБОРУДОВАНИЕ И МАТЕРИАЛЫ',
            'text' =>
                'Мы работаем с передовым оборудованием и используем только сертифицированные материалы от проверенных производителей. Это позволяет нам гарантировать высокое качество и долговечность результатов нашей работы.',
        ],
        [
            'main' => '05',
            'title' => 'КАЧЕСТВО И НАДЁЖНОСТЬ',
            'text' =>
                'Мы строго соблюдаем все отраслевые стандарты и нормы. Каждый этап работы проходит многоступенчатый контроль качества, что обеспечивает безупречный результат и уверенность в итоговом результате.',
        ],
        [
            'main' => '06',
            'title' => 'ГАРАНТИЙНАЯ ПОДДЕРЖКА',
            'text' =>
                'Мы несём ответственность за качество выполненных работ и предоставляем полную гарантийную поддержку. Ваша удовлетворённость — наш главный приоритет.',
        ],
    ];
@endphp

<section class="mt-20 pt-12 lg:pt-12 border-t border-gray-300 md:mb-10 lg:mb-10" aria-labelledby="advantages-heading"
    data-advantages-section>
    <div class="container-custom">
        <h2 id="advantages-heading" data-reveal data-delay="0"
            class="text-center font-montserrat text-3xl md:text-4xl font-extrabold text-gray-900 mb-2">
            НАШИ ПРЕИМУЩЕСТВА
        </h2>
        <p class="text-center text-sm md:text-base text-gray-600 max-w-3xl mx-auto" data-reveal data-delay="80">
            Ключевые особенности нашей работы, за которые нас выбирают клиенты
        </p>

        <div class="relative mt-10" data-advantages-swiper>
            <div class="swiper our-advantages-swiper">
                <div class="swiper-wrapper">
                    @foreach ($advantages as $item)
                        <div class="swiper-slide" data-reveal data-delay="{{ $loop->index * 30 + 60 }}">
                            <article class="adv-card h-full w-full p-5 sm:p-6">
                                <header class="flex flex-col items-start gap-3">
                                    @if (!empty($item['main']))
                                        <h4
                                            class="text-7xl font-montserrat text-blue-600 font-bold tracking-wide {{ $loop->last ? 'no-line' : '' }}">
                                            {{ $item['main'] }}
                                        </h4>
                                    @endif
                                    <h3 class="text-lg md:text-2xl font-semibold text-gray-900 leading-snug min-w-0">
                                        {{ $item['title'] }}
                                    </h3>
                                </header>
                                <p class="mt-3 text-gray-800 text-md leading-relaxed">
                                    {{ $item['text'] }}
                                </p>
                            </article>
                        </div>
                    @endforeach
                </div>

                <!-- Индикаторы пагинации (для мобильных/планшетов) -->
                <div class="swiper-pagination" aria-hidden="false"></div>

                <!-- Стрелки навигации (скрыты на мобильных/планшетах, видны на десктопе) -->
                <div class="hidden lg:flex swiper-nav-inline" role="group" aria-label="Навигация слайдера">
                    <button class="swiper-button-prev" type="button" aria-label="Предыдущий слайд">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="28" height="28"
                            fill="currentColor" aria-hidden="true" focusable="false">
                            <path d="M4 12l1.41 1.41L11 7.83V20h2V7.83l5.59 5.58L20 12l-8-8-8 8z"
                                transform="rotate(-90 12 12)" />
                        </svg>
                    </button>

                    <button class="swiper-button-next" type="button" aria-label="Следующий слайд">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="28" height="28"
                            fill="currentColor" aria-hidden="true" focusable="false">
                            <path d="M4 12l1.41 1.41L11 7.83V20h2V7.83l5.59 5.58L20 12l-8-8-8 8z"
                                transform="rotate(90 12 12)" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <noscript>
            <ul role="list" class="mt-10 space-y-4">
                @foreach ($advantages as $item)
                    <li class="flex items-start gap-3">
                        <div class="min-w-0">
                            <strong class="text-xl text-gray-800">{{ $item['title'] }}:</strong>
                            <p class="mt-1 block text-gray-800 text-md leading-relaxed">
                                {{ $item['text'] }}
                            </p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </noscript>
    </div>

    <style>
        /* Контейнер слайдера — запрещаем горизонтальное переполнение и даём место под пагинацию */
        .our-advantages-swiper {
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
            overflow-x: hidden;
            overflow-y: visible !important;
            padding-bottom: 1.5rem;
        }

        .our-advantages-swiper .swiper-wrapper,
        .our-advantages-swiper .swiper-slide {
            min-width: 0;
            /* чтобы содержимое корректно ужималось */
        }

        /* Пагинация: линии вместо точек */
        .our-advantages-swiper .swiper-pagination {
            position: static !important;
            margin-top: 1.25rem;
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            z-index: 20;
            align-items: center;
            padding: 0.25rem 0;
        }

        .our-advantages-swiper .swiper-pagination-bullet {
            width: 28px;
            height: 3px;
            background: rgba(59, 130, 246, 0.9);
            /* gray-900 @ 18% */
            opacity: 1;
            border-radius: 9999px;
            transition: transform .18s ease, background-color .18s ease, width .18s ease;
            box-shadow: none;
        }

        .our-advantages-swiper .swiper-pagination-bullet-active {
            background: rgba(59, 130, 246, 1.0);
            width: 40px;
            transform: scaleY(1.25);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.10);
        }

        /* Прячем пагинацию на десктопах, т.к. там используем стрелки */
        @media (min-width: 1024px) {
            .our-advantages-swiper .swiper-pagination {
                display: none !important;
            }
        }

        /* Кнопки стрелок (позиционирование по краям по умолчанию, для inline-навигации ниже есть переопределения) */
        .our-advantages-swiper .swiper-button-prev,
        .our-advantages-swiper .swiper-button-next {
            position: absolute;
            top: 50%;
            --arrow-shift: calc(-90% - 6px);
            transform: translateY(var(--arrow-shift));
            width: 3.5rem;
            height: 3.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #111827;
            /* gray-900 */
            border: none;
            cursor: pointer;
            z-index: 30;
        }

        /* Перестраховка: скрываем любые стрелки на мобильных/планшетах, даже если Swiper добавит их сам */
        @media (max-width: 1023.98px) {

            .our-advantages-swiper .swiper-button-prev,
            .our-advantages-swiper .swiper-button-next {
                display: none !important;
            }
        }

        :root {
            --advantages-arrows-gap: clamp(0.15rem, 0.9vw, 0.75rem);
        }

        .our-advantages-swiper .swiper-button-prev {
            left: var(--advantages-arrows-gap);
        }

        .our-advantages-swiper .swiper-button-next {
            right: var(--advantages-arrows-gap);
        }

        /* Inline-навигация стрелками под слайдером */
        .our-advantages-swiper .swiper-nav-inline {
            position: static !important;
            margin-top: 3.25rem;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 0.75rem;
            z-index: 20;
            padding: 0.25rem 0;
        }

        /* Сами стрелки */
        .our-advantages-swiper .swiper-nav-inline .swiper-button-prev,
        .our-advantages-swiper .swiper-nav-inline .swiper-button-next {
            position: static;
            transform: none;
            width: 4.5rem;
            height: 4.5rem;
            z-index: 1;
        }

        @media (min-width: 768px) {
            :root {
                --advantages-arrows-gap: clamp(0.35rem, 0.9vw, 1rem);
            }

            .our-advantages-swiper .swiper-button-prev {
                left: var(--advantages-arrows-gap);
            }

            .our-advantages-swiper .swiper-button-next {
                right: var(--advantages-arrows-gap);
            }
        }

        /* Убираем дефолтные иконки Swiper */
        .our-advantages-swiper .swiper-button-prev::after,
        .our-advantages-swiper .swiper-button-next::after {
            display: none;
        }

        /* Disabled в inline-навигации без смещения */
        .our-advantages-swiper .swiper-nav-inline .swiper-button-disabled {
            transform: none !important;
        }

        /* Линия от центра элемента 'main' до конца карточки */
        .our-advantages-swiper .adv-card header h4 {
            display: flex;
            align-items: center;
            /* выравниваем линию по вертикальному центру текста */
            line-height: 1;
            /* плотнее вокруг цифр */
            width: 100%;
            /* растягиваем h4 на всю ширину карточки */
        }

        .our-advantages-swiper .adv-card header h4::after {
            content: "";
            flex: 1 1 auto;
            /* тянем линию до правого края */
            height: 1px;
            /* толщина линии */
            background: currentColor;
            /* цвет как у текста (синие цифры) */
            opacity: 0.9;
            /* чуть мягче */
            margin-left: 0.75rem;
            /* отступ между цифрой и линией */
            min-width: 15rem;
            /* небольшая минимальная длина на узких экранах */
        }

        /* У последнего не рисуем линию вообще */
        .our-advantages-swiper .adv-card header h4.no-line::after {
            content: none !important;
        }

        /* На очень узких экранах (375px): больше отступ от текста и короче минимальная линия */
        @media (max-width: 400px) {
            .our-advantages-swiper .adv-card header h4 {
                margin-bottom: 0.75rem;
            }

            .our-advantages-swiper .adv-card header h4::after {
                min-width: 6rem;
                margin-left: 1rem;
            }
        }

        /* Reveal анимация для этой секции */
        [data-advantages-section] [data-reveal] {
            will-change: transform, opacity, filter;
            transition: opacity 500ms cubic-bezier(.25, .65, .25, 1),
                transform 500ms cubic-bezier(.25, .65, .25, 1),
                filter 520ms cubic-bezier(.25, .65, .25, 1);
        }

        [data-advantages-section] [data-reveal].reveal-init {
            opacity: 0;
            transform: translateY(16px) scale(.985);
            filter: blur(2px) saturate(.9);
        }

        [data-advantages-section] [data-reveal].reveal-in {
            opacity: 1;
            transform: translateY(0) scale(1);
            filter: blur(0) saturate(1);
        }

        @media (prefers-reduced-motion: reduce) {
            [data-advantages-section] [data-reveal] {
                transition: none !important;
            }

            [data-advantages-section] [data-reveal].reveal-init {
                opacity: 1 !important;
                transform: none !important;
                filter: none !important;
            }
        }
    </style>

    <script>
        // Имитация hover-анимации кнопок на тач-устройствах
        (function() {
            const root = document.querySelector('[data-advantages-swiper]');
            if (!root) return;
            const btns = root.querySelectorAll(
                '.our-advantages-swiper .swiper-button-prev, .our-advantages-swiper .swiper-button-next');
            if (!btns.length) return;
            let isTouch = matchMedia('(hover: none)').matches;
            if (!isTouch) return;
            btns.forEach(btn => {
                btn.addEventListener('touchstart', () => {
                    btn.classList.add('touch-animate');
                    setTimeout(() => btn.classList.remove('touch-animate'), 240);
                }, {
                    passive: true
                });
            });
        })();

        // Reveal-эффект при скролле
        (function() {
            const startTime = performance.now();
            const root = document.querySelector('[data-advantages-section]');
            if (!root) return;
            const nodes = Array.from(root.querySelectorAll('[data-reveal]'));
            if (!nodes.length) return;
            const reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            if (!reduce) nodes.forEach(el => el.classList.add('reveal-init'));

            const reveal = (el) => {
                let delay = parseInt(el.getAttribute('data-delay') || '0', 10);
                if (reduce) {
                    el.classList.remove('reveal-init');
                    el.classList.add('reveal-in');
                    return;
                }
                if (el.classList.contains('swiper-slide')) {
                    const t = performance.now() - startTime;
                    delay = t > 700 ? 0 : Math.min(delay, 220);
                }
                el.style.transitionDelay = delay + 'ms';
                requestAnimationFrame(() => {
                    el.classList.add('reveal-in');
                    el.classList.remove('reveal-init');
                });
            };

            const viewportH = window.innerHeight || document.documentElement.clientHeight;
            nodes.forEach(el => {
                const r = el.getBoundingClientRect();
                if (r.top < viewportH * 0.85) reveal(el);
            });

            if (reduce) return;

            const io = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        reveal(entry.target);
                        obs.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.15
            });

            nodes.forEach(el => {
                if (!el.classList.contains('reveal-in')) io.observe(el);
            });
        })();
    </script>
</section>
