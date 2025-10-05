(function () {
    const API_KEY = "190294b3-c731-4c53-a1f8-f64bf48ce81b";
    const MAP_CONTAINER_ID = "yandex-map";
    const COORDS = [46.041753, 38.182621];
    const BLUE_600 = "#2563eb"; // tailwind text-blue-600
    let mapRef = null;
    let routeRef = null;

    // SVG-метка с буквой V (синяя), слегка опустим "V" и добавим лёгкую тень пину
    const ICON_SVG =
        '<?xml version="1.0" encoding="UTF-8"?>' +
        '<svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 44 44">' +
        "<defs>" +
        "<style><![CDATA[ .t{font:700 20px Montserrat, Arial, sans-serif; dominant-baseline:middle; text-anchor:middle; paint-order:stroke fill; stroke:#1e3a8a; stroke-width:.6px;} ]]></style>" +
        '<filter id="ds" x="-50%" y="-50%" width="200%" height="200%">' +
        '<feDropShadow dx="0" dy="1" stdDeviation="1.2" flood-color="#1e3a8a" flood-opacity="0.25"/>' +
        "</filter>" +
        "</defs>" +
        // Пин (круг с "хвостиком") с лёгкой тенью
        `<path d="M22 2c8.284 0 15 6.716 15 15 0 10.5-15 25-15 25S7 27.5 7 17C7 8.716 13.716 2 22 2z" fill="${BLUE_600}" filter="url(#ds)"/>` +
        // Буква V, чуть ниже
        '<text x="22" y="20" class="t" fill="#ffffff">V</text>' +
        "</svg>";
    const ICON_DATA_URI =
        "data:image/svg+xml;charset=UTF-8," + encodeURIComponent(ICON_SVG);

    function initMapOnce() {
        const el = document.getElementById(MAP_CONTAINER_ID);
        if (!el || el.dataset.inited === "1") return;
        el.dataset.inited = "1";

        ymaps.ready(function () {
            try {
                const map = new ymaps.Map(
                    MAP_CONTAINER_ID,
                    {
                        center: COORDS,
                        zoom: 16,
                        controls: ["zoomControl"],
                    },
                    {
                        suppressMapOpenBlock: true,
                    }
                );
                mapRef = map;

                // Кастомный баллун с кружком
                const BalloonContentLayout =
                    ymaps.templateLayoutFactory.createClass(
                        '<div style="display:flex;align-items:center;gap:12px;padding:8px 10px;">' +
                            `<span style="display:inline-block;width:10px;height:10px;border-radius:9999px;background:${BLUE_600};box-shadow:0 0 0 3px rgba(37,99,235,.18);"></span>` +
                            "<div style=\"font:500 14px 'Open Sans', Arial, sans-serif;color:#111827;line-height:1.35;\">" +
                            '<div style="font-weight:700;color:#1f2937;margin-bottom:2px;">Наш офис</div>' +
                            "<div>Краснодарский край, г. Приморско-Ахтарск, ул. Комсомольская, 66</div>" +
                            "</div>" +
                            "</div>"
                    );

                const placemark = new ymaps.Placemark(
                    COORDS,
                    {
                        balloonContentHeader: "Наш офис",
                        balloonContentBody:
                            "Краснодарский край, г. Приморско-Ахтарск, ул. Комсомольская, 66",
                        hintContent: "Наш офис",
                    },
                    {
                        iconLayout: "default#image",
                        iconImageHref: ICON_DATA_URI,
                        iconImageSize: [44, 44],
                        iconImageOffset: [-22, -44],
                    }
                );

                map.geoObjects.add(placemark);

                // Настроим поведение отдельно для десктопа и мобильных
                const wrapper = document.querySelector(".map-wrapper");
                const mqHover = window.matchMedia("(hover:hover)");
                const isDesktopHover =
                    mqHover.matches && window.innerWidth >= 1024;

                if (isDesktopHover) {
                    // Десктоп: карта серо-неактивна, включаем drag/scrollZoom только при наведении
                    map.behaviors.disable("drag");
                    map.behaviors.disable("scrollZoom");
                    if (wrapper) {
                        const enable = () => {
                            map.behaviors.enable("drag");
                            map.behaviors.enable("scrollZoom");
                        };
                        const disable = () => {
                            map.behaviors.disable("drag");
                            map.behaviors.disable("scrollZoom");
                        };
                        wrapper.addEventListener("pointerenter", enable);
                        wrapper.addEventListener("pointerleave", disable);
                    }
                } else {
                    // Мобильные/планшеты: разрешаем перетаскивание и зум pinch
                    map.behaviors.enable("drag");
                    map.behaviors.enable("multiTouch");
                    map.behaviors.disable("scrollZoom"); // колесо не нужно на тач-устройствах
                }
            } catch (e) {
                // fail silently
            }
        });
    }

    function openExternalRoute(fromCoords) {
        let url;
        if (Array.isArray(fromCoords) && fromCoords.length === 2) {
            url = `https://yandex.ru/maps/?rtext=${fromCoords[0]},${fromCoords[1]}~${COORDS[0]},${COORDS[1]}&rtt=auto`;
        } else {
            url = `https://yandex.ru/maps/?rtext=~${COORDS[0]},${COORDS[1]}&rtt=auto`;
        }
        window.open(url, "_blank", "noopener");
    }

    function buildRoute() {
        if (!navigator.geolocation) {
            openExternalRoute();
            return;
        }
        navigator.geolocation.getCurrentPosition(
            function (pos) {
                openExternalRoute([pos.coords.latitude, pos.coords.longitude]);
            },
            function () {
                openExternalRoute();
            },
            {
                enableHighAccuracy: true,
                timeout: 5000,
            }
        );
    }

    function loadApiAndInit() {
        if (window.ymaps && typeof ymaps.Map === "function") {
            initMapOnce();
            return;
        }

        // Уже загружается?
        const existing = document.querySelector(
            'script[src^="https://api-maps.yandex.ru/2.1/"]'
        );
        if (existing) {
            // подождать готовность
            const timer = setInterval(() => {
                if (window.ymaps && typeof ymaps.Map === "function") {
                    clearInterval(timer);
                    initMapOnce();
                }
            }, 120);
            setTimeout(() => clearInterval(timer), 10000);
            return;
        }

        const s = document.createElement("script");
        s.src = `https://api-maps.yandex.ru/2.1/?apikey=${API_KEY}&lang=ru_RU`;
        s.async = true;
        s.onload = initMapOnce;
        s.onerror = function () {
            // noop; можно добавить пользовательское уведомление об ошибке загрузки API
        };
        document.head.appendChild(s);
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", loadApiAndInit);
    } else {
        loadApiAndInit();
    }

    // Кнопка построения маршрута
    document.addEventListener("click", function (e) {
        const btn = e.target.closest("#map-build-route");
        if (btn) {
            e.preventDefault();
            buildRoute();
        }
    });

    // Анимации появления секции карты
    function initReveal() {
        const root = document.getElementById("where-to-find");
        if (!root) return;
        const items = root.querySelectorAll("[data-reveal]");
        if (!("IntersectionObserver" in window)) {
            items.forEach((el) => el.classList.add("revealed"));
            return;
        }
        const io = new IntersectionObserver(
            (entries, obs) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const el = entry.target;
                        const delay = parseInt(
                            el.getAttribute("data-reveal-delay") || "0",
                            10
                        );
                        setTimeout(
                            () => el.classList.add("revealed"),
                            isNaN(delay) ? 0 : delay
                        );
                        obs.unobserve(el);
                    }
                });
            },
            {
                threshold: 0.08,
                rootMargin: "0px 0px -8% 0px",
            }
        );
        items.forEach((el) => io.observe(el));
    }
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initReveal);
    } else {
        initReveal();
    }
})();
