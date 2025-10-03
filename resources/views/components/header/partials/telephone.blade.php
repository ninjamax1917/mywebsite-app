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

<div
    class="header-telephone font-montserrat font-semibold bg-gray-800 text-gray-100 hidden lg:flex items-center space-x-9 ml-4 rounded-4xl overflow-hidden hover:rounded-none">
    <a href="tel:+71234567890" aria-label="Позвонить" class="inline-block px-4 py-1.5">+7 (918) 254 71 47</a>
</div>
