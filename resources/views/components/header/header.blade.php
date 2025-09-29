<header id="site-header" class="bg-white border-b border-gray-500/50 relative">
    <div id="header-inner"
        class="max-w-[1440px] mx-auto px-4 md:px-12 lg:px-4 flex items-center justify-between h-18 relative">
        {{-- Логотип --}}
        <x-header.partials.logo />

        {{-- Меню для десктопа --}}
        <x-header.partials.desktop_menu />

        {{-- Иконки справа (появляются на lg и выше) --}}
        <x-header.partials.icons_info />

        {{-- Кнопка-бургер для мобильных и планшетов --}}
        <x-header.partials.burger_button />
    </div>

    {{-- обильное меню вынесено из контейнера --}}
    <x-header.partials.mobile_menu />
</header>