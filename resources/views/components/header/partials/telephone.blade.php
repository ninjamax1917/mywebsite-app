{{-- Телефон в шапке. По умолчанию темный. При раскрытом хедере (#site-header.expanded) — светлый фон и темный текст. --}}
<style>
    /* Плавная смена цветов при раскрытии меню "Услуги" */
    #site-header.expanded .header-telephone {
        background-color: rgb(209 213 219);
        /* tailwind gray-300 */
        color: rgb(31 41 55);
        /* tailwind gray-800 */
    }

    #site-header.expanded .header-telephone a {
        color: inherit;
    }

    /* Когда свёрнут — наследуем начальные util-классы (bg-gray-800 text-gray-100) */
    /* Ничего больше не нужно, так как спецификатор выше перекрывает только в expanded */
    @media (prefers-reduced-motion: no-preference) {
        .header-telephone {
            transition: background-color 520ms cubic-bezier(.2, .7, .2, 1), color 520ms cubic-bezier(.2, .7, .2, 1), border-radius 520ms cubic-bezier(.2, .7, .2, 1);
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .header-telephone {
            transition: none;
        }
    }
</style>

<a href="tel:+71234567890" aria-label="Позвонить"
    class="header-telephone font-montserrat font-semibold bg-blue-600 text-gray-100 hidden lg:flex items-center gap-0 ml-4 rounded-4xl overflow-hidden hover:rounded-none px-3 py-1 cursor-pointer">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
        class="size-6" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
    </svg>

    <span class="inline-block px-2 py-0.5 text-lg leading-none">+7 (918) 254 71 47</span>
</a>
