<header class="bg-white shadow-md">
    <div class="container mx-auto px-4 flex items-center justify-between h-">
        <!-- Логотип -->
        <x-header.partials.logo />
        <!-- Меню для десктопа -->
        <nav class="hidden md:flex space-x-6">
            <a href="#" class="text-gray-600 hover:text-blue-600">Главная</a>
            <a href="#" class="text-gray-600 hover:text-blue-600">Услуги</a>
            <a href="#" class="text-gray-600 hover:text-blue-600">Камеры города</a>
            <a href="#" class="text-gray-600 hover:text-blue-600">Контакты</a>
        </nav>
        <!-- Кнопка-бургер для мобильных -->
        <button id="mobile-menu-btn" class="md:hidden text-gray-600 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>
    <!-- Мобильное меню -->
    <nav id="mobile-menu" class="md:hidden hidden px-4 pb-4">
        <a href="#" class="block py-2 text-gray-600 hover:text-blue-600">Главная</a>
        <a href="#" class="block py-2 text-gray-600 hover:text-blue-600">Услуги</a>
        <a href="#" class="block py-2 text-gray-600 hover:text-blue-600">Камеры города</a>
        <a href="#" class="block py-2 text-gray-600 hover:text-blue-600">Контакты</a>
    </nav>
    <script>
        // filepath: inline script
        document.getElementById('mobile-menu-btn').onclick = function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        };
    </script>
</header>
