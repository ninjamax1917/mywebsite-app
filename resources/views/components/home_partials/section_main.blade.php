<main>
    <div class="container-custom py-0">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center md:items-start">
            <!-- Текст -->
            <div class="lg:col-span-6">
                <h1
                    class="font-montserrat text-4xl sm:text-4xl md:text-7xl font-extrabold leading-tight text-gray-900 mb-4 hero-title">
                    <span
                        class="block text-gray-800 transform -translate-y-6 opacity-0 transition-all duration-700 ease-out">Проектируем,</span>
                    <span
                        class="block text-gray-800 transform -translate-y-6 opacity-0 transition-all duration-700 ease-out">монтируем&nbsp;и</span>
                    <span
                        class="block text-gray-800 transform -translate-y-6 opacity-0 transition-all duration-700 ease-out">сопровождаем</span>
                    <span
                        class="block text-blue-600 transform -translate-y-6 opacity-0 transition-all duration-700 ease-out">инженерные</span>
                    <span
                        class="block text-blue-600 transform -translate-y-6 opacity-0 transition-all duration-700 ease-out">системы</span>
                </h1>

                <h2
                    class="text-2xs font-semibold md:text-xl text-gray-600 mb-4 hero-sub transform translate-y-4 opacity-0 transition-all duration-700 ease-out">
                    в городе Приморско-Ахтарск и по всему Краснодарскому краю
                </h2>

                <p
                    class="text-sm text-gray-600 mb-6 leading-relaxed hero-sub transform translate-y-4 opacity-0 transition-all duration-700 ease-out">
                    Производство работ по проектированию, монтажу и обслуживанию электроснабжения, электрооборудования,
                    проивопожарной автоматики, охранных систем, видеонаблюдения, СКУД, домофонии, вентиляции и
                    кондиционирования.
                </p>

                <div
                    class="flex flex-wrap gap-3 items-center hero-sub transform translate-y-4 opacity-0 transition-all duration-700 ease-out">
                    <a href="tel:+79282547147"
                        class="inline-flex items-center justify-center px-5 py-3 bg-blue-600 text-white text-md font-semibold rounded-4xl hover:rounded-none transition-all duration-300 shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        aria-label="Позвонить для расчета проекта">Рассчитать проект</a>
                </div>

                <!-- доверие / быстрые факты -->
                <div
                    class="mt-8 flex flex-wrap gap-6 text-sm text-gray-600 hero-sub transform translate-y-4 opacity-0 transition-all duration-700 ease-out">
                    <div class="flex items-center gap-3">
                        <strong class="text-gray-900"><span class="js-counter" data-target="20"
                                data-duration="1400">0</span>+</strong>
                        <span>лет опыта</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <strong class="text-gray-900"><span class="js-counter" data-target="700"
                                data-duration="1400">0</span>+</strong>
                        <span>реализованных объектов</span>
                    </div>
                </div>
            </div>

            <!-- Карусель фото справа -->
            <div class="lg:col-span-6 flex justify-center lg:justify-center md:mt-6">
                <div
                    class="hero-card relative w-full max-w-md sm:max-w-lg md:max-w-full lg:max-w-full h-116 md:h-[44rem] lg:h-[44rem] rounded-lg overflow-hidden shadow-lg bg-gray-100 mx-auto opacity-0 transition-all duration-700 ease-out">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/10 via-transparent to-transparent pointer-events-none">
                    </div>

                    <div class="hero-carousel relative w-full h-full">
                        <img src="{{ asset('images/icons/hero_section_main/видеонаблюдение.jpg') }}"
                            alt="видеонаблюдение"
                            class="absolute inset-0 w-full h-full object-cover transition-opacity duration-700 ease-in-out opacity-100"
                            aria-hidden="false">
                        <img src="{{ asset('images/icons/hero_section_main/интернет.jpg') }}" alt="интернет"
                            class="absolute inset-0 w-full h-full object-cover transition-opacity duration-700 ease-in-out opacity-0"
                            aria-hidden="true">
                        <img src="{{ asset('images/icons/hero_section_main/камера.jpg') }}" alt="камера"
                            class="absolute inset-0 w-full h-full object-cover transition-opacity duration-700 ease-in-out opacity-0"
                            aria-hidden="true">
                        <img src="{{ asset('images/icons/hero_section_main/лаборатория.jpeg') }}" alt="лаборатория"
                            class="absolute inset-0 w-full h-full object-cover transition-opacity duration-700 ease-in-out opacity-0"
                            aria-hidden="true">
                        <img src="{{ asset('images/icons/hero_section_main/сервер.jpg') }}" alt="сервер"
                            class="absolute inset-0 w-full h-full object-cover transition-opacity duration-700 ease-in-out opacity-0"
                            aria-hidden="true">
                        <img src="{{ asset('images/icons/hero_section_main/электрика.jpg') }}" alt="электрика"
                            class="absolute inset-0 w-full h-full object-cover transition-opacity duration-700 ease-in-out opacity-0"
                            aria-hidden="true">
                        <img src="{{ asset('images/icons/hero_section_main/Электрошкаф.jpg') }}" alt="Электрошкаф"
                            class="absolute inset-0 w-full h-full object-cover transition-opacity duration-700 ease-in-out opacity-100"
                            aria-hidden="false">
                        <img src="{{ asset('images/icons/hero_section_main/Точка доступа.jpg') }}" alt="Точка доступа"
                            class="absolute inset-0 w-full h-full object-cover transition-opacity duration-700 ease-in-out opacity-100"
                            aria-hidden="false">
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
