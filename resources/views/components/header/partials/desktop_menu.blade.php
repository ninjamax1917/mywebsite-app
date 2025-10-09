<nav class="desktop-nav font-open-sans font-medium hidden lg:flex lg:absolute lg:left-1/2 lg:transform lg:-translate-x-1/2 space-x-10"
    role="menubar" aria-label="Главное меню">
    {{-- Top-level items are initially hidden for reveal --}}
    <a id="services-link" href="#"
        class="underline-anim-nav text-gray-800 transition-colors inline-flex items-center gap-2 group whitespace-nowrap opacity-0 translate-y-4"
        aria-expanded="false" role="button" aria-haspopup="true">
        <span class="leading-none underline-target">Услуги</span>
        <svg id="chev-services" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            class="chevron w-4 h-4 ml-1 self-center inline-block transform duration-300" aria-hidden="true"
            focusable="false">
            <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                d="m19.5 8.25-7.5 7.5-7.5-7.5" />
        </svg>
    </a>

    <!-- services dropdown (горизонтально) — submenu not animated by top-level reveal -->
    <div class="services-dropdown" role="menu" aria-label="Услуги">
        <a class="underline-anim-nav text-gray-800 transition-colors inline-flex items-center gap-2 group"
            role="menuitem" href="#">Видеонаблюдение</a>
        <a class="underline-anim-nav text-gray-800 transition-colors inline-flex items-center gap-2 group"
            role="menuitem" href="#">Пожарная автоматика</a>
        <a class="underline-anim-nav text-gray-800 transition-colors inline-flex items-center gap-2 group"
            role="menuitem" href="#">Сетевые решения</a>
        <a class="underline-anim-nav text-gray-800 transition-colors inline-flex items-center gap-2 group"
            role="menuitem" href="#">Безопасность</a>
        <a class="underline-anim-nav text-gray-800 transition-colors inline-flex items-center gap-2 group"
            role="menuitem" href="#">Электромонтаж</a>
        <a class="underline-anim-nav text-gray-800 transition-colors inline-flex items-center gap-2 group"
            role="menuitem" href="#">Электролаборатория</a>
    </div>

    <a href="about"
        class="underline-anim-nav text-gray-800 transition-colors inline-flex items-center gap-2 group opacity-0 translate-y-4"
        role="menuitem">О нас</a>
    <a href="#"
        class="underline-anim-nav text-gray-800 transition-colors inline-flex items-center gap-2 group opacity-0 translate-y-4"
        role="menuitem">Проекты</a>
    <a href="#"
        class="underline-anim-nav text-gray-800 transition-colors inline-flex items-center gap-2 group opacity-0 translate-y-4"
        role="menuitem">Контакты</a>
</nav>
