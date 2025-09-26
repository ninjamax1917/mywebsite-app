<header id="site-header" class="bg-white border-b border-gray-500/50 relative">
    <div id="header-inner"
        class="max-w-[1440px] mx-auto px-4 md:px-12 lg:px-4 flex items-center justify-between h-18 relative">
        <!-- Логотип -->
        <x-header.partials.logo />
        <!-- Меню для десктопа -->
        <x-header.partials.desktop_menu />

        <!-- Иконки справа (появляются на lg и выше) -->
        <div class="text-[#155DFC] header-icons hidden lg:flex items-center space-x-9 ml-4">
            <a href="tel:+71234567890" aria-label="Позвонить">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-phone-call-icon lucide-phone-call w-5 h-5">
                    <path d="M13 2a9 9 0 0 1 9 9" />
                    <path d="M13 6a5 5 0 0 1 5 5" />
                    <path
                        d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384" />
                </svg>
            </a>

            <a href="mailto:info@example.com" aria-label="Написать">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-mail-icon lucide-mail w-5 h-5">
                    <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7" />
                    <rect x="2" y="4" width="20" height="16" rx="2" />
                </svg>
            </a>

            <a href="/contacts" aria-label="Адрес">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-map-pin-icon lucide-map-pin w-5 h-5">
                    <path
                        d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                    <circle cx="12" cy="10" r="3" />
                </svg>
            </a>
        </div>
        <!-- Кнопка-бургер для мобильных и планшетов -->
        <x-header.partials.burger_button />
    </div>
    <!-- Мобильное меню вынесено из контейнера -->
    <x-header.partials.mobile_menu />
</header>
