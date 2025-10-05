<section class="mt-20 pt-12 lg:pt-12 border-t border-gray-300 md:mb-10 lg:mb-10" aria-labelledby="services-heading">
    <div class="container-custom">
        <div class="text-center mb-8">
            <h2 id="services-heading"
                class="font-montserrat text-3xl md:text-4xl lg:text-4xl font-extrabold text-gray-800 mb-2 transition-transform transition-opacity duration-700 ease-out opacity-0 translate-x-8 will-change-transform will-change-opacity"
                data-delay="0">
                НАШИ УСЛУГИ
            </h2>
            <p class="animate-on-scroll text-sm md:text-xl lg:text-base text-gray-600 max-w-2xl mx-auto transition-transform transition-opacity duration-700 ease-out"
                data-delay="120">
                Комплексные решения в области безопасности, электрики и сетевой инфраструктуры для бизнеса и частных
                клиентов.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-10 services-grid pt-5">

            {{-- Видеонаблюдение --}}
            <article role="article" aria-labelledby="svc-1" tabindex="0"
                class="group block bg-white rounded-none shadow-sm overflow-hidden border border-transparent hover:border-blue-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 transition-colors">
                <div class="card-inner animate-on-scroll" data-delay="240">
                    <img src="{{ asset('images/main_services/видео.jpg') }}" alt="Видеонаблюдение"
                        class="w-full h-44 sm:h-56 object-cover animate-child" style="object-position:10% 35%;"
                        loading="lazy">
                    <div class="p-6">
                        <h3 id="svc-1"
                            class="animate-child text-xl md:text-2xl lg:text-2xl font-semibold mb-2 text-gray-900 transition-transform transition-opacity duration-500 ease-out group-hover:text-blue-600">
                            Видеонаблюдение
                        </h3>
                        <p class="animate-child sm:text-sm md:text-base lg:text-base text-gray-800">Проектирование,
                            монтаж и обслуживание
                            систем видеонаблюдения для объектов любой сложности.</p>
                    </div>
                </div>
            </article>

            {{-- Противопожарная автоматика --}}
            <article role="article" aria-labelledby="svc-2" tabindex="0"
                class="group block bg-white rounded-none shadow-sm overflow-hidden border border-transparent hover:border-blue-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 transition-colors">
                <div class="card-inner animate-on-scroll" data-delay="320">
                    <img src="{{ asset('images/main_services/Пожарка.jpg') }}" alt="Противопожарная автоматика"
                        class="w-full h-44 sm:h-56 object-cover animate-child" style="object-position:10% 65%;"
                        loading="lazy">
                    <div class="p-6">
                        <h3 id="svc-2"
                            class="animate-child text-xl md:text-2xl lg:text-2xl font-semibold mb-2 text-gray-900 transition-transform transition-opacity duration-500 ease-out group-hover:text-blue-600">
                            Пожарная автоматика
                        </h3>
                        <p class="animate-child sm:text-sm md:text-base lg:text-base text-gray-800">Комплексные решения
                            по обнаружению и автоматическому реагированию на пожарные ситуации.</p>
                    </div>
                </div>
            </article>

            {{-- Сетевые решения --}}
            <article role="article" aria-labelledby="svc-3" tabindex="0"
                class="group block bg-white rounded-none shadow-sm overflow-hidden border border-transparent hover:border-blue-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 transition-colors">
                <div class="card-inner animate-on-scroll" data-delay="400">
                    <img src="{{ asset('images/main_services/Сети.jpg') }}" alt="Сетевые решения"
                        class="w-full h-44 sm:h-56 object-cover animate-child" loading="lazy">
                    <div class="p-6">
                        <h3 id="svc-3"
                            class="animate-child text-xl md:text-2xl lg:text-2xl font-semibold mb-2 text-gray-900 transition-transform transition-opacity duration-500 ease-out group-hover:text-blue-600">
                            Сетевые решения
                        </h3>
                        <p class="animate-child sm:text-sm md:text-base lg:text-base text-gray-800">Проектирование и
                            развёртывание LAN/WAN, Wi‑Fi и оптических сетей под ключ.</p>
                    </div>
                </div>
            </article>

            {{-- Безопасность --}}
            <article role="article" aria-labelledby="svc-4" tabindex="0"
                class="group block bg-white rounded-none shadow-sm overflow-hidden border border-transparent hover:border-blue-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 transition-colors">
                <div class="card-inner animate-on-scroll" data-delay="480">
                    <img src="{{ asset('images/main_services/безопасность.jpg') }}" alt="Безопасность"
                        class="w-full h-44 sm:h-56 object-cover animate-child" loading="lazy">
                    <div class="p-6">
                        <h3 id="svc-4"
                            class="animate-child text-xl md:text-2xl lg:text-2xl font-semibold mb-2 text-gray-900 transition-transform transition-opacity duration-500 ease-out group-hover:text-blue-600">
                            Безопасность
                        </h3>
                        <p class="animate-child sm:text-sm md:text-base lg:text-base text-gray-800">Системы контроля
                            доступа, сигнализации и комплексная интеграция безопасности.</p>
                    </div>
                </div>
            </article>

            {{-- Электромонтаж --}}
            <article role="article" aria-labelledby="svc-5" tabindex="0"
                class="group block bg-white rounded-none shadow-sm overflow-hidden border border-transparent hover:border-blue-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 transition-colors">
                <div class="card-inner animate-on-scroll" data-delay="560">
                    <img src="{{ asset('images/main_services/электрика.jpg') }}" alt="Электромонтаж"
                        class="w-full h-44 sm:h-56 object-cover animate-child" style="object-position:10% 55%;"
                        loading="lazy">
                    <div class="p-6">
                        <h3 id="svc-5"
                            class="animate-child text-xl md:text-2xl lg:text-2xl font-semibold mb-2 text-gray-900 transition-transform transition-opacity duration-500 ease-out group-hover:text-blue-600">
                            Электромонтаж
                        </h3>
                        <p class="animate-child sm:text-sm md:text-base lg:text-base text-gray-800">Полный цикл
                            электромонтажных работ: от проектирования до ввода в эксплуатацию.</p>
                    </div>
                </div>
            </article>

            {{-- Электролаборатория --}}
            <article role="article" aria-labelledby="svc-6" tabindex="0"
                class="group block bg-white rounded-none shadow-sm overflow-hidden border border-transparent hover:border-blue-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 transition-colors">
                <div class="card-inner animate-on-scroll" data-delay="640">
                    <img src="{{ asset('images/main_services/Лаборатория.jpg') }}" alt="Электролаборатория"
                        class="w-full h-44 sm:h-56 object-cover animate-child" style="object-position:10% 70%;"
                        loading="lazy">
                    <div class="p-6">
                        <h3 id="svc-6"
                            class="animate-child text-xl md:text-2xl lg:text-2xl font-semibold mb-2 text-gray-900 transition-transform transition-opacity duration-500 ease-out group-hover:text-blue-600">
                            Электролаборатория
                        </h3>
                        <p class="animate-child sm:text-sm md:text-base lg:text-base text-gray-800">Испытания и
                            измерения электроустановок, оформление отчётной документации.</p>
                    </div>
                </div>
            </article>

        </div>
    </div>
</section>
