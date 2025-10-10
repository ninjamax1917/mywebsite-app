import Swiper from "swiper";
import { Navigation, Pagination, A11y, Keyboard } from "swiper/modules";
import "swiper/swiper-bundle.css";

// Initialize Swiper for advantages section if present
export function initAdvantagesSwiper() {
    const container = document.querySelector(
        "[data-advantages-swiper] .our-advantages-swiper"
    );
    if (!container) return;

    Swiper.use([Navigation, Pagination, A11y, Keyboard]);

    // eslint-disable-next-line no-new
    new Swiper(container, {
        // На мобильных: 1 слайд на экран — чтобы пагинация работала корректно
        slidesPerView: 1,
        slidesPerGroup: 1,
        spaceBetween: 16,
        centeredSlides: false,
        watchOverflow: true,
        a11y: { enabled: true },
        keyboard: { enabled: true },

        pagination: {
            el: ".our-advantages-swiper .swiper-pagination",
            clickable: true,
        },

        navigation: {
            nextEl: ".our-advantages-swiper .swiper-button-next",
            prevEl: ".our-advantages-swiper .swiper-button-prev",
        },

        // Планшеты/десктопы: показываем 2 слайда и листаем группами по 2,
        // чтобы количество буллетов соответствовало «страницам», а не каждому слайду
        breakpoints: {
            480: { slidesPerView: 1, slidesPerGroup: 1, spaceBetween: 16 },
            640: { slidesPerView: 2, slidesPerGroup: 2, spaceBetween: 18 },
            768: { slidesPerView: 2, slidesPerGroup: 2, spaceBetween: 20 },
            1024: { slidesPerView: 2, slidesPerGroup: 2, spaceBetween: 24 },
            1280: { slidesPerView: 2, slidesPerGroup: 2, spaceBetween: 28 },
        },

        on: {
            resize(swiper) {
                swiper.update();
            },
            // При смене брейкпоинтов перерендерим пагинацию, чтобы пересчитать буллеты
            breakpoint(swiper) {
                if (swiper.pagination && swiper.pagination.render) {
                    swiper.pagination.render();
                    swiper.pagination.update();
                }
            },
        },
    });
}

// Auto-init on DOM ready if imported directly in the page bundle
if (typeof document !== "undefined") {
    document.addEventListener("DOMContentLoaded", initAdvantagesSwiper);
}

// In case of Vite HMR / late import
try { initAdvantagesSwiper(); } catch (_e) { }
