<section id="where-to-find" class="pt-10 pb-6 sm:pt-16 sm:pb-8 lg:pt-16 lg:pb-0">
    <div class="container-custom">
        <h2 data-reveal data-reveal-delay="0"
            class="text-center font-montserrat text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">ГДЕ МЫ НАХОДИМСЯ
        </h2>

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
                class="inline-flex items-center justify-center w-full lg:w-auto px-6 lg:px-22 py-4 bg-blue-600 text-white text-md lg:text-lg font-semibold rounded-4xl hover:rounded-none transition-all duration-300 shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer text-center">
                Построить маршрут
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-map-icon lucide-map ml-3 md:ml-2 flex-shrink-0 relative top-0.5">
                    <path
                        d="M14.106 5.553a2 2 0 0 0 1.788 0l3.659-1.83A1 1 0 0 1 21 4.619v12.764a1 1 0 0 1-.553.894l-4.553 2.277a2 2 0 0 1-1.788 0l-4.212-2.106a2 2 0 0 0-1.788 0l-3.659 1.83A1 1 0 0 1 3 19.381V6.618a1 1 0 0 1 .553-.894l4.553-2.277a2 2 0 0 1 1.788 0z" />
                    <path d="M15 5.764v15" />
                    <path d="M9 3.236v15" />
                </svg>
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
