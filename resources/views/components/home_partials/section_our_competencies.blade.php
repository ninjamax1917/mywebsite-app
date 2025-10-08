@php
    use Illuminate\Support\Facades\File;

    // Directory with license & certificate preview images
    $licenseDir = public_path('licenses');

    // External links for specific items that do not have PDF counterparts
    $externalLinks = [
        'Разрешение на производство работ по проектированию МЧС' =>
            'https://digital.mchs.gov.ru/fgpn/cert/project/Т002-00101-23/00650390',
        'Разрешение на производство работ МЧС' => 'https://digital.mchs.gov.ru/fgpn/license/23-06-2024-004469',
    ];

    $licenses = [];

    if (is_dir($licenseDir)) {
        $imageExtensions = ['jpg', 'jpeg', 'png'];
        $rawFiles = File::files($licenseDir);

        // Collect one image per base name
        $imagesByBase = [];
        foreach ($rawFiles as $file) {
            $ext = strtolower($file->getExtension());
            if (!in_array($ext, $imageExtensions, true)) {
                continue;
            }
            $filename = $file->getFilename();
            $base = pathinfo($filename, PATHINFO_FILENAME);
            // Prefer jpg over png when both exist (arbitrary simple rule)
            if (
                !isset($imagesByBase[$base]) ||
                (str_ends_with(strtolower($filename), '.jpg') &&
                    !str_ends_with(strtolower($imagesByBase[$base]), '.jpg'))
            ) {
                $imagesByBase[$base] = $filename;
            }
        }

        ksort($imagesByBase, SORT_NATURAL | SORT_FLAG_CASE);

        foreach ($imagesByBase as $base => $imageFilename) {
            $pdfFilename = $base . '.pdf';
            $pdfPath = $licenseDir . DIRECTORY_SEPARATOR . $pdfFilename;
            $isExternal = false;
            if (isset($externalLinks[$base])) {
                $href = $externalLinks[$base];
                $isExternal = true;
            } elseif (file_exists($pdfPath)) {
                $href = asset('licenses/' . rawurlencode($pdfFilename));
            } else {
                // Fallback: open the image itself if no PDF/external link
                $href = asset('licenses/' . rawurlencode($imageFilename));
            }

            $licenses[] = [
                'title' => $base,
                'image' => asset('licenses/' . rawurlencode($imageFilename)),
                'href' => $href,
                'external' => $isExternal,
            ];
        }
    }
@endphp

<section class="relative w-full py-10 md:py-12 text-gray-300" data-competencies-section
    style="background:#232323; box-shadow:0 0 0 100vmax #232323; clip-path:inset(0 -100vmax);">

    <style>
        /* Пагинация: оставляем тени видно, но запрещаем горизонтальное переполнение */
        .our-competencies-swiper {
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
            /* разрешаем видимость по вертикали, но скрываем по горизонтали,
               чтобы свайпер не вылезал за контейнер */
            overflow-x: hidden;
            overflow-y: visible !important;
            padding-bottom: 1.5rem;
            /* место под пагинацию */
        }

        .our-competencies-swiper .swiper-pagination {
            position: static !important;
            margin-top: 2rem;
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            z-index: 20;
            align-items: center;
            padding: 0.25rem 0;
        }

        /* Пагинация — современные линии вместо буллетов */
        .our-competencies-swiper .swiper-pagination-bullet {
            width: 28px;
            height: 3px;
            background: rgba(229, 231, 235, 0.45);
            /* светлая линия */
            opacity: 1;
            border-radius: 9999px;
            transition: transform .18s ease, background-color .18s ease, width .18s ease;
            box-shadow: none;
        }

        .our-competencies-swiper .swiper-pagination-bullet-active {
            background: #e5e7eb;
            /* ярче для активного */
            width: 40px;
            transform: scaleY(1.3);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        }

        /* =====================  КАСТОМНЫЕ СТРЕЛКИ  ===================== */
        .our-competencies-swiper .swiper-button-prev,
        .our-competencies-swiper .swiper-button-next {
            position: absolute;
            top: 50%;
            /* Подняли стрелки на 10px: используем переменную с учётом будущих трансформаций */
            --arrow-shift: calc(-90% - 10px);
            transform: translateY(var(--arrow-shift));
            width: 3.9rem;
            /* +15% */
            height: 3.9rem;
            /* +15% */
            display: flex;
            align-items: center;
            justify-content: center;
            background: #232323;
            /* фон кнопки */
            color: #ffffff;
            /* цвет иконки */
            border: none;
            cursor: pointer;
            z-index: 30;
            box-shadow: 0 8px 18px -4px rgba(0, 0, 0, 0.35), 0 2px 6px rgba(0, 0, 0, 0.25);
            border-radius: 50%;
            transition: border-radius 420ms cubic-bezier(.2, .7, .2, 1),
                background-color 300ms cubic-bezier(.2, .7, .2, 1),
                box-shadow 300ms cubic-bezier(.2, .7, .2, 1),
                transform 300ms cubic-bezier(.2, .7, .2, 1),
                opacity 200ms ease;
            will-change: border-radius, transform;
        }

        /* Кнопки по краям ВНУТРИ контейнера */
        :root {
            --competencies-arrows-gap: clamp(0.15rem, 0.9vw, 0.75rem);
        }

        .our-competencies-swiper .swiper-button-prev {
            left: var(--competencies-arrows-gap);
        }

        .our-competencies-swiper .swiper-button-next {
            right: var(--competencies-arrows-gap);
        }

        @media (min-width: 768px) {
            :root {
                --competencies-arrows-gap: clamp(0.35rem, 0.9vw, 1rem);
            }

            .our-competencies-swiper .swiper-button-prev {
                left: var(--competencies-arrows-gap);
            }

            .our-competencies-swiper .swiper-button-next {
                right: var(--competencies-arrows-gap);
            }
        }

        /* Убираем стандартные иконки Swiper */
        .our-competencies-swiper .swiper-button-prev::after,
        .our-competencies-swiper .swiper-button-next::after {
            display: none;
        }

        /* Ховер-эффект (квадрат) только для устройств с реальным hover */
        @media (hover: hover) and (pointer: fine) {

            .our-competencies-swiper .swiper-button-prev:hover,
            .our-competencies-swiper .swiper-button-next:hover {
                border-radius: 0;
                background: #2f2f2f;
                /* чуть светлее при :hover */
                transform: translateY(var(--arrow-shift)) scale(1.06);
                box-shadow: 0 10px 26px -6px rgba(0, 0, 0, 0.45), 0 4px 12px rgba(0, 0, 0, 0.25);
            }
        }

        /* Тач-устройства: показываем лёгкий эффект по tap через .touch-animate (убрали !important чтобы не блокировать) */
        @media (hover: none) {

            .our-competencies-swiper .swiper-button-prev,
            .our-competencies-swiper .swiper-button-next {
                border-radius: 50%;
                background: #232323;
                transform: translateY(var(--arrow-shift));
                transition: border-radius 360ms cubic-bezier(.2, .7, .2, 1),
                    background-color 280ms cubic-bezier(.2, .7, .2, 1),
                    box-shadow 280ms cubic-bezier(.2, .7, .2, 1),
                    transform 260ms cubic-bezier(.2, .7, .2, 1),
                    opacity 200ms ease;
            }

            /* Tap без задержек (hover на мобильных не срабатывает) */
            .our-competencies-swiper .swiper-button-prev.touch-animate,
            .our-competencies-swiper .swiper-button-next.touch-animate {
                border-radius: 0;
                background: #2f2f2f;
                transform: translateY(var(--arrow-shift)) scale(1.06);
                box-shadow: 0 10px 26px -6px rgba(0, 0, 0, 0.45), 0 4px 12px rgba(0, 0, 0, 0.25);
            }

            /* На тач hover псевдо-класс может иногда всплывать — нормализуем */
            .our-competencies-swiper .swiper-button-prev:hover,
            .our-competencies-swiper .swiper-button-next:hover {
                border-radius: 50%;
                background: #232323;
                transform: translateY(var(--arrow-shift));
            }
        }

        .our-competencies-swiper .swiper-button-prev:active,
        .our-competencies-swiper .swiper-button-next:active {
            transform: translateY(var(--arrow-shift)) scale(0.95);
        }

        .our-competencies-swiper .swiper-button-prev:focus-visible,
        .our-competencies-swiper .swiper-button-next:focus-visible {
            outline: 2px solid #93c5fd;
            /* light blue ring */
            outline-offset: 2px;
        }

        .our-competencies-swiper .swiper-button-disabled {
            opacity: 0.35;
            cursor: not-allowed;
            box-shadow: 0 4px 10px -2px rgba(0, 0, 0, 0.25), 0 1px 4px rgba(0, 0, 0, 0.2);
            transform: translateY(var(--arrow-shift)) !important;
        }

        /* Состояние принудительной анимации для тач (добавляется JS-класс .touch-animate) */
        .our-competencies-swiper .swiper-button-prev.touch-animate,
        .our-competencies-swiper .swiper-button-next.touch-animate {
            border-radius: 0;
            background: #2f2f2f;
            transform: translateY(var(--arrow-shift)) scale(1.06);
            box-shadow: 0 10px 26px -6px rgba(0, 0, 0, 0.45), 0 4px 12px rgba(0, 0, 0, 0.25);
        }

        @media (prefers-reduced-motion: reduce) {

            .our-competencies-swiper .swiper-button-prev,
            .our-competencies-swiper .swiper-button-next {
                transition: background-color 200ms ease, box-shadow 200ms ease, opacity 200ms ease;
            }
        }

        /* Плавное изменение цвета текста названий лицензий */
        [data-competencies-section] .competency-title {
            transition: color 520ms cubic-bezier(.2, .7, .2, 1);
        }

        [data-competencies-section] a.group:hover .competency-title,
        [data-competencies-section] a.group:focus .competency-title,
        [data-competencies-section] a.group:focus-visible .competency-title {
            color: #3b82f6;
            /* blue-500 */
        }

        /* Плавная смена цвета самой карточки при наведении */
        [data-competencies-section] .license-card {
            transition: background-color 420ms cubic-bezier(.2, .7, .2, 1),
                border-color 420ms cubic-bezier(.2, .7, .2, 1),
                box-shadow 420ms cubic-bezier(.2, .7, .2, 1);
        }

        [data-competencies-section] a.group:hover .license-card,
        [data-competencies-section] a.group:focus .license-card,
        [data-competencies-section] a.group:focus-visible .license-card {
            background: #f1f5f9;
            /* slate-100 */
            border-color: #cbd5e1;
            /* slate-300 */
            box-shadow: 0 6px 18px -4px rgba(0, 0, 0, 0.25), 0 2px 6px rgba(0, 0, 0, 0.18);
        }

        @media (prefers-reduced-motion: reduce) {
            [data-competencies-section] .competency-title {
                transition: none;
            }
        }
    </style>

    <div class="mx-auto w-full max-w-[1440px] px-4 sm:px-6 lg:px-8">
        <div class="relative z-10 text-center mb-8">
            <h2 id="competencies-heading"
                class="font-montserrat text-3xl md:text-4xl lg:text-4xl font-extrabold text-gray-200 mb-2" data-reveal
                data-delay="0">
                НАШИ КОМПЕТЕНЦИИ
            </h2>
            <h3 class="text-sm md:text-lg font-normal leading-relaxed text-gray-300/90 mt-4 max-w-3xl mx-auto"
                data-reveal data-delay="120">
                Ознакомьтесь с нашими лицензиями и сертификатами, которые гарантируют высокий уровень наших услуг и
                квалификацию сотрудников
            </h3>
        </div>

        @if (empty($licenses))
            <p class="text-sm text-gray-400">Файлы лицензий и сертификатов временно недоступны.</p>
        @else
            <div class="relative" data-competencies-swiper>
                <div class="swiper our-competencies-swiper">
                    <div class="swiper-wrapper">
                        @foreach ($licenses as $doc)
                            {{-- Ускоренные задержки: меньше шаг и базовое значение для более быстрого появления --}}
                            <div class="swiper-slide" data-reveal data-delay="{{ $loop->index * 30 + 60 }}">
                                <a href="{{ $doc['href'] }}" target="_blank" rel="noopener" class="block group"
                                    aria-label="Открыть документ: {{ $doc['title'] }}">
                                    <div
                                        class="license-card aspect-[3/4] w-full overflow-hidden border border-gray-200 bg-white shadow-sm">
                                        <img src="{{ $doc['image'] }}" alt="{{ $doc['title'] }}" loading="lazy"
                                            class="h-full w-full object-cover" />
                                    </div>
                                    <p class="mt-3 text-center text-md font-medium text-gray-200 competency-title">
                                        {{ $doc['title'] }}</p>

                                </a>
                            </div>
                        @endforeach
                    </div>

                    {{-- Пагинация будет в потоке и смещена вниз благодаря CSS выше --}}
                    <div class="swiper-pagination" aria-hidden="false"></div>

                    {{-- Современные стрелки; показываются на md+ (markup оставляет классы hidden md:flex для tailwind) --}}
                    <button class="swiper-button-prev hidden md:flex" type="button" aria-label="Предыдущий слайд">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30" height="30"
                            fill="currentColor" aria-hidden="true" focusable="false">
                            <!-- Используем ту же стрелку что и наверх, но повёрнутую влево -->
                            <path d="M4 12l1.41 1.41L11 7.83V20h2V7.83l5.59 5.58L20 12l-8-8-8 8z"
                                transform="rotate(-90 12 12)" />
                        </svg>
                    </button>

                    <button class="swiper-button-next hidden md:flex" type="button" aria-label="Следующий слайд">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30" height="30"
                            fill="currentColor" aria-hidden="true" focusable="false">
                            <!-- Та же стрелка, но повёрнутая вправо -->
                            <path d="M4 12l1.41 1.41L11 7.83V20h2V7.83l5.59 5.58L20 12l-8-8-8 8z"
                                transform="rotate(90 12 12)" />
                        </svg>
                    </button>
                </div>
            </div>

            <script>
                // Включаем имитацию hover анимации на тач-устройствах кратковременно
                (function() {
                    const swiperEl = document.querySelector('[data-competencies-swiper]');
                    if (!swiperEl) return;
                    const btns = swiperEl.querySelectorAll(
                        '.our-competencies-swiper .swiper-button-prev, .our-competencies-swiper .swiper-button-next');
                    if (!btns.length) return;
                    let isTouch = matchMedia('(hover: none)').matches;
                    if (!isTouch) return; // только для тач
                    btns.forEach(btn => {
                        btn.addEventListener('touchstart', () => {
                            btn.classList.add('touch-animate');
                            // быстрое удаление чтобы не "залипало" (но визуально дергается как hover)
                            setTimeout(() => {
                                btn.classList.remove('touch-animate');
                            }, 240); // синхронизировано с transition ~240ms воспринимается живо
                        }, {
                            passive: true
                        });
                    });
                })();
            </script>

            <noscript>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 mt-6">
                    @foreach ($licenses as $doc)
                        <a href="{{ $doc['href'] }}" target="_blank" rel="noopener" class="block">
                            <img src="{{ $doc['image'] }}" alt="{{ $doc['title'] }}"
                                class="w-full rounded border border-gray-200" />
                            <span class="mt-2 block text-sm">{{ $doc['title'] }}@if ($doc['external'])
                                    (внешняя ссылка)
                                @endif
                            </span>
                        </a>
                    @endforeach
                </div>
            </noscript>
        @endif
    </div>
</section>

<style>
    /* ==== REVEAL ANIMATION (SCROLL & ON-LOAD) ==== */
    [data-competencies-section] [data-reveal] {
        will-change: transform, opacity, filter;
        /* Сокращена длительность для более быстрого появления */
        transition: opacity 520ms cubic-bezier(.25, .65, .25, 1),
            transform 520ms cubic-bezier(.25, .65, .25, 1),
            filter 540ms cubic-bezier(.25, .65, .25, 1);
    }

    [data-competencies-section] [data-reveal].reveal-init {
        opacity: 0;
        transform: translateY(18px) scale(.985);
        filter: blur(3px) saturate(.85);
    }

    [data-competencies-section] [data-reveal].reveal-in {
        opacity: 1;
        transform: translateY(0) scale(1);
        filter: blur(0) saturate(1);
    }

    @media (prefers-reduced-motion: reduce) {
        [data-competencies-section] [data-reveal] {
            transition: none !important;
        }

        [data-competencies-section] [data-reveal].reveal-init {
            opacity: 1 !important;
            transform: none !important;
            filter: none !important;
        }
    }
</style>

<script>
    (function() {
        const startTime = performance.now();
        const root = document.querySelector('[data-competencies-section]');
        if (!root) return;
        const nodes = Array.from(root.querySelectorAll('[data-reveal]'));
        if (!nodes.length) return;
        const reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        // Add initial state
        if (!reduce) {
            nodes.forEach(el => el.classList.add('reveal-init'));
        }

        const reveal = (el) => {
            let delay = parseInt(el.getAttribute('data-delay') || '0', 10);
            if (reduce) {
                el.classList.remove('reveal-init');
                el.classList.add('reveal-in');
                return;
            }
            // Если это слайд свайпера и прошло уже >700мс от загрузки (значит пользователь свайпает/листает) — убираем задержку
            if (el.classList.contains('swiper-slide')) {
                const t = performance.now() - startTime;
                if (t > 700) {
                    delay = 0;
                } else {
                    // Ограничиваем максимально для первых кадров
                    delay = Math.min(delay, 240);
                }
            }
            el.style.transitionDelay = delay + 'ms';
            requestAnimationFrame(() => {
                el.classList.add('reveal-in');
                el.classList.remove('reveal-init');
            });
        };

        // Fallback: reveal above the fold immediately
        const viewportH = window.innerHeight || document.documentElement.clientHeight;
        nodes.forEach(el => {
            const r = el.getBoundingClientRect();
            if (r.top < viewportH * 0.85) {
                reveal(el);
            }
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

{{-- #232323 --}}
