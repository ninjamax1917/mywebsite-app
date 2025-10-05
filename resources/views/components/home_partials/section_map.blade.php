<section id="where-to-find" class="pt-10 pb-6 sm:pt-16 sm:pb-8 lg:pt-16 lg:pb-0">
    <div class="container-custom">
        <h2 data-reveal data-reveal-delay="0"
            class="text-center font-montserrat text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">ГДЕ НАС НАЙТИ</h2>

        <!-- Информация (над картой). На десктопе — в две колонки -->
        <div class="pt-1 mb-4 lg:mb-4" data-reveal data-reveal-delay="120">
            <div class="bg-white p-4">
                <dl class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-2xl font-semibold uppercase tracking-wide text-gray-800">АДРЕС</dt>
                        <dd class="mt-1 text-gray-900">город Приморско-Ахтарск, <br> ул. Комсомольская, 66
                        </dd>
                    </div>
                    <div>
                        <dt class="text-2xl font-semibold uppercase tracking-wide text-gray-800">ГРАФИК РАБОТЫ</dt>
                        <dd class="mt-1 text-gray-900">8:00 — 17:00<br><span class="text-gray-600">Выходные дни:
                                Сб–Вс</span></dd>
                    </div>
                </dl>
                <!-- Кнопка перенесена под карту -->
            </div>
        </div>

        <!-- Карта на всю ширину контейнера -->
        <div class="map-wrapper relative" data-reveal data-reveal-delay="160">
            <div id="yandex-map"
                class="w-full h-80 md:h-[28rem] lg:h-[32rem] rounded-lg overflow-hidden shadow-lg bg-gray-100"></div>
            <noscript>
                <p class="mt-4 text-sm text-gray-600">Для просмотра карты включите JavaScript. Наш адрес: Краснодарский
                    край, город Приморско-Ахтарск, ул. Комсомольская, 66.</p>
            </noscript>
        </div>
        <div class="mt-6 flex items-center justify-start" data-reveal data-reveal-delay="220">
            <button id="map-build-route" type="button"
                class="inline-flex items-center justify-center px-8 py-4 bg-blue-600 text-white text-md font-semibold rounded-4xl hover:rounded-none transition-all duration-300 shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
                Построить маршрут
            </button>
        </div>
    </div>

    <style>
        /* Делает карту на десктопах серой и неактивной, активируется при ховере */
        @media (hover: hover) and (min-width: 1024px) {
            #yandex-map {
                filter: grayscale(100%);
                pointer-events: none;
                transition: filter 300ms cubic-bezier(.2, .7, .2, 1);
            }

            .map-wrapper:hover #yandex-map {
                filter: none;
                pointer-events: auto;
            }
        }

        /* Reveal-анимации для секции карты */
        #where-to-find [data-reveal] {
            opacity: 0;
            transform: translateY(16px);
            transition: opacity 700ms cubic-bezier(.2, .7, .2, 1), transform 700ms cubic-bezier(.2, .7, .2, 1);
            will-change: opacity, transform;
        }

        #where-to-find [data-reveal].revealed {
            opacity: 1;
            transform: none;
        }
    </style>
</section>
