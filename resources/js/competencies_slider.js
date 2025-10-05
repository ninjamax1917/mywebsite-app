import Swiper from "swiper";
import { Navigation, Pagination, A11y, Keyboard } from "swiper/modules";
import "swiper/swiper-bundle.css";

// Initialize Swiper for competencies section if present
export function initCompetenciesSwiper() {
    const container = document.querySelector(
        "[data-competencies-swiper] .our-competencies-swiper"
    );
    if (!container) return;

    // eslint-disable-next-line no-new
    // Ensure container doesn't exceed viewport on init
    container.style.maxWidth = "100%";
    container.style.boxSizing = "border-box";

    new Swiper(container, {
        modules: [Navigation, Pagination, A11y, Keyboard],
        slidesPerView: 1,
        spaceBetween: 12,
        centeredSlides: false,
        keyboard: { enabled: true },
        a11y: true,
        watchOverflow: true,
        pagination: {
            el: ".our-competencies-swiper .swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".our-competencies-swiper .swiper-button-next",
            prevEl: ".our-competencies-swiper .swiper-button-prev",
        },
        breakpoints: {
            480: { slidesPerView: 2, spaceBetween: 14 },
            640: { slidesPerView: 2.5, spaceBetween: 16 },
            768: { slidesPerView: 3, spaceBetween: 16 },
            1024: { slidesPerView: 4, spaceBetween: 18 },
            1280: { slidesPerView: 5, spaceBetween: 20 },
        },
        on: {
            resize(swiper) {
                swiper.update();
            },
        },
    });
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initCompetenciesSwiper);
} else {
    initCompetenciesSwiper();
}
