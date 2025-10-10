# Скопировать пример в рабочий .env
cp .env.example .env

# Сгенерировать APP_KEY
./vendor/bin/sail php artisan key:generate

# Применить миграции
./vendor/bin/sail php artisan migrate



@php
    $advantages = [
        [
            'title' => 'Индивидуальный подход к каждому проекту',
            'text' =>
                'Мы создаем решения, которые учитывают специфику вашего объекта. Наши специалисты тщательно анализируют особенности проекта и разрабатывают оптимальную стратегию реализации.',
        ],
        [
            'title' => 'Полный цикл',
            'text' =>
                'От первого эскиза до финальной сдачи объекта — мы берём на себя все этапы работы. Вы получаете единого ответственного партнёра, который гарантирует безупречное качество на каждом этапе реализации проекта.',
        ],
        [
            'title' => 'Квалифицированный персонал',
            'text' =>
                'В нашей команде — только сертифицированные специалисты с профильным образованием и обширным практическим опытом. Мы регулярно повышаем квалификацию наших сотрудников и следим за новыми тенденциями в отрасли.',
        ],
        [
            'title' => 'Современное оборудование и материалы',
            'text' =>
                'Мы работаем с передовым оборудованием и используем только сертифицированные материалы от проверенных производителей. Это позволяет нам гарантировать высокое качество и долговечность результатов нашей работы.',
        ],
        [
            'title' => 'Качество и надежность',
            'text' =>
                'Мы строго соблюдаем все отраслевые стандарты и нормы. Каждый этап работы проходит многоступенчатый контроль качества, что обеспечивает безупречный результат и уверенность в итоговом результате.',
        ],
        [
            'title' => 'Гарантийная поддержка',
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
                            <article
                                class="adv-card h-full w-full bg-white border border-gray-200 rounded-xl shadow-sm p-5 sm:p-6">
                                <header class="flex items-start gap-3">
                                    <h3 class="text-lg md:text-xl font-semibold text-gray-900 leading-snug min-w-0">
                                        {{ $item['title'] }}
                                    </h3>
                                </header>
                                <p class="mt-3 text-gray-800 text-sm md:text-base leading-relaxed">
                                    {{ $item['text'] }}
                                </p>
                            </article>
                        </div>
                    @endforeach
                </div>

                <div class="swiper-pagination" aria-hidden="false"></div>

                <button class="swiper-button-prev hidden md:flex" type="button" aria-label="Предыдущий слайд">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="28" height="28"
                        fill="currentColor" aria-hidden="true" focusable="false">
                        <path d="M4 12l1.41 1.41L11 7.83V20h2V7.83l5.59 5.58L20 12l-8-8-8 8z"
                            transform="rotate(-90 12 12)" />
                    </svg>
                </button>

                <button class="swiper-button-next hidden md:flex" type="button" aria-label="Следующий слайд">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="28" height="28"
                        fill="currentColor" aria-hidden="true" focusable="false">
                        <path d="M4 12l1.41 1.41L11 7.83V20h2V7.83l5.59 5.58L20 12l-8-8-8 8z"
                            transform="rotate(90 12 12)" />
                    </svg>
                </button>
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
            gap: 0.5rem;
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

        /* Кнопки стрелок */
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
            background: #ffffff;
            color: #111827;
            /* gray-900 */
            border: none;
            cursor: pointer;
            z-index: 30;
            box-shadow: 0 8px 18px -4px rgba(0, 0, 0, 0.20), 0 2px 6px rgba(0, 0, 0, 0.18);
            border-radius: 50%;
            transition: border-radius 420ms cubic-bezier(.2, .7, .2, 1),
                background-color 300ms cubic-bezier(.2, .7, .2, 1),
                box-shadow 300ms cubic-bezier(.2, .7, .2, 1),
                transform 300ms cubic-bezier(.2, .7, .2, 1),
                opacity 200ms ease;
            will-change: border-radius, transform;
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

        /* Hover на десктопах */
        @media (hover: hover) and (pointer: fine) {

            .our-advantages-swiper .swiper-button-prev:hover,
            .our-advantages-swiper .swiper-button-next:hover {
                border-radius: 0.75rem;
                background: #f3f4f6;
                /* gray-100 */
                transform: translateY(var(--arrow-shift)) scale(1.05);
                box-shadow: 0 10px 26px -6px rgba(0, 0, 0, 0.25), 0 4px 12px rgba(0, 0, 0, 0.18);
            }
        }

        /* Тач: лёгкий эффект tap */
        @media (hover: none) {

            .our-advantages-swiper .swiper-button-prev,
            .our-advantages-swiper .swiper-button-next {
                border-radius: 50%;
                background: #ffffff;
                transform: translateY(var(--arrow-shift));
                transition: border-radius 360ms cubic-bezier(.2, .7, .2, 1),
                    background-color 280ms cubic-bezier(.2, .7, .2, 1),
                    box-shadow 280ms cubic-bezier(.2, .7, .2, 1),
                    transform 260ms cubic-bezier(.2, .7, .2, 1),
                    opacity 200ms ease;
            }

            .our-advantages-swiper .swiper-button-prev.touch-animate,
            .our-advantages-swiper .swiper-button-next.touch-animate {
                border-radius: 0.75rem;
                background: #f3f4f6;
                transform: translateY(var(--arrow-shift)) scale(1.05);
                box-shadow: 0 10px 26px -6px rgba(0, 0, 0, 0.25), 0 4px 12px rgba(0, 0, 0, 0.18);
            }

            .our-advantages-swiper .swiper-button-prev:hover,
            .our-advantages-swiper .swiper-button-next:hover {
                border-radius: 50%;
                background: #ffffff;
                transform: translateY(var(--arrow-shift));
            }
        }

        .our-advantages-swiper .swiper-button-prev:active,
        .our-advantages-swiper .swiper-button-next:active {
            transform: translateY(var(--arrow-shift)) scale(0.95);
        }

        .our-advantages-swiper .swiper-button-prev:focus-visible,
        .our-advantages-swiper .swiper-button-next:focus-visible {
            outline: 2px solid #93c5fd;
            /* blue-300 */
            outline-offset: 2px;
        }

        .our-advantages-swiper .swiper-button-disabled {
            opacity: 0.35;
            cursor: not-allowed;
            box-shadow: 0 4px 10px -2px rgba(0, 0, 0, 0.18), 0 1px 4px rgba(0, 0, 0, 0.16);
            transform: translateY(var(--arrow-shift)) !important;
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


кнопки стрелок я хочу расположить на одной высоте с текстом "НАШИ ПРЕИМУЩЕСТВА", но чтобы они были прижаты к правой части экрана