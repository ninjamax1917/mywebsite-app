@php
    $contactShouldOpen = session('contact_success') || $errors->any() || old('name') || old('phone') || old('date');
@endphp
<section id="connection" class="bg-blue-500 pt-10 pb-6 sm:pt-16 sm:pb-8 lg:pt-16 lg:pb-16 scroll-animate">
    <div class="container-custom">
        <div id="contact-toggle-area" aria-controls="contact-collapsible"
            class="relative w-full flex items-center md:items-start justify-center md:justify-center mb-2 md:mb-6 select-none pr-0 md:pr-0">
            <h2 data-reveal data-reveal-delay="0"
                class="text-center font-montserrat text-3xl md:text-4xl font-extrabold text-gray-200">
                <span class="block sm:inline">СВЯЗАТЬСЯ</span>
                <span class="block sm:inline">С&nbsp;НАМИ</span>
            </h2>
            <div id="contact-collapse-toggle" type="button" aria-expanded="{{ $contactShouldOpen ? 'true' : 'false' }}"
                aria-controls="contact-collapsible"
                class="absolute right-0 top-1/2 -translate-y-1/2 md:static md:translate-y-0 md:mt-1 inline-flex items-center justify-center w-10 h-10 text-gray-100 transition md:ml-6 lg:ml-0 lg:hidden"
                title="Показать/скрыть форму">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                    class="chevron transition-transform duration-300 ease-out w-16 h-16 text-white -translate-y-1"
                    fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true">
                    <path d="M6 9l6 6 6-6" />
                </svg>
            </div>
        </div>

        <div id="contact-collapsible" class="mobile-collapsible md:max-h-none md:opacity-100 md:pointer-events-auto"
            data-open="{{ $contactShouldOpen ? 'true' : 'false' }}">
            <p class="max-w-2xl mx-auto text-center text-gray-100/90 font-open-sans text-base md:text-lg mb-6 md:mb-8"
                data-reveal data-reveal-delay="120">
                Оставьте свои контактные данные, и мы свяжемся с вами в удобное время.
            </p>

            @if (session('contact_success'))
                <div class="max-w-xl mx-auto mb-6 bg-green-600/90 text-white px-4 py-3" role="status">
                    {{ session('contact_success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="max-w-xl mx-auto mb-6 bg-red-600/90 text-white px-4 py-3 rounded" role="alert">
                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('contact.store') }}" method="POST" class="contact-form max-w-xl mx-auto grid gap-5"
                data-reveal data-reveal-delay="200" novalidate>
                @csrf
                <div class="contact-msg-wrapper space-y-3" aria-live="polite"></div>
                <div class="grid gap-2">
                    <input id="contact-name" name="name" type="text" required maxlength="120"
                        value="{{ old('name') }}"
                        class="font-semibold field-input w-full bg-transparent text-white appearance-none border-b border-white/90 focus:border-white focus:outline-none transition px-0 py-2"
                        placeholder="Ваше имя*" aria-describedby="error-name">
                    <p id="error-name" data-error-for="name" class="field-error text-xs min-h-[1.25rem]"></p>
                </div>

                <div class="grid gap-2">
                    <input id="contact-phone" name="phone" type="tel" required maxlength="40"
                        value="{{ old('phone') }}"
                        class="field-input w-full bg-transparent font-semibold text-white appearance-none border-b border-white/90 focus:border-white focus:outline-none transition px-0 py-2"
                        placeholder="Телефон*" aria-describedby="error-phone">
                    <p id="error-phone" data-error-for="phone" class="field-error text-xs min-h-[1.25rem]"></p>
                </div>

                <div class="grid gap-2">
                    <div class="date-wrapper relative" data-has-value="{{ old('date') ? 'true' : 'false' }}">
                        <input id="contact-date" name="date" type="date" value="{{ old('date') }}"
                            class="field-input date-input w-full bg-transparent font-semibold text-white appearance-none border-b border-white/90 focus:border-white focus:outline-none transition px-0 py-2"
                            aria-describedby="error-date" autocomplete="off">
                        <span class="date-ph select-none">Дата</span>
                        <button type="button"
                            class="date-calendar-btn absolute inset-y-0 right-0 flex items-center justify-center px-0"
                            aria-label="Открыть календарь" tabindex="-1">
                            <svg viewBox="0 0 24 24" class="w-6 h-6 text-white opacity-80 hover:opacity-100 transition"
                                fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg>
                        </button>
                    </div>
                    <p id="error-date" data-error-for="date" class="field-error text-xs min-h-[1.25rem]"></p>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="submit-btn inline-flex items-center justify-center w-full rounded-4xl bg-[#232323] text-gray-100 font-montserrat font-semibold tracking-wide px-6 py-3 hover:rounded-none focus:outline-none transition-all duration-400 cursor-pointer disabled:opacity-60 disabled:cursor-not-allowed">
                        <span class="btn-text">Отправить</span>
                        <span
                            class="btn-spinner hidden ml-2 h-5 w-5 border-2 border-white/70 border-t-transparent rounded-full animate-spin"></span>
                    </button>
                </div>
                <p class="text-[13px] leading-snug text-gray-100/80 mt-1">
                    Нажимая «Отправить», вы соглашаетесь с обработкой
                    <a href="{{ url('/privacy') }}" target="_blank" rel="noopener noreferrer"
                        class="underline hover:text-white">
                        персональных данных
                    </a>.
                </p>
            </form>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ===== Collapsible logic (mobile + tablet < 1024px) =====
        const collapsible = document.getElementById('contact-collapsible');
        const toggleBtn = document.getElementById('contact-collapse-toggle');
        const toggleArea = document.getElementById('contact-toggle-area');

        function isLargeScreen() { // считаем что на >= 1024 форма всегда открыта
            return window.matchMedia('(min-width: 1024px)').matches;
        }

        function applyState(open) {
            if (!collapsible) return;
            collapsible.dataset.open = open ? 'true' : 'false';
            if (toggleBtn) toggleBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
            if (toggleArea) toggleArea.setAttribute('aria-expanded', open ? 'true' : 'false');
            const chev = toggleBtn?.querySelector('.chevron');
            if (chev) {
                chev.classList.toggle('rotate-180', open);
            }
        }

        function initCollapsible() {
            if (!collapsible) return;
            if (isLargeScreen()) {
                applyState(true);
                return;
            }
            const shouldBeOpen = collapsible.dataset.open === 'true';
            applyState(shouldBeOpen);
        }

        function toggleCollapsible() {
            if (isLargeScreen()) return;
            const openNow = collapsible.dataset.open === 'true';
            applyState(!openNow);
        }
        if (toggleBtn) toggleBtn.addEventListener('click', toggleCollapsible);

        // --- Управление кликабельностью заголовка только на мобильных/планшетах (<1024px) ---
        let headerToggleEnabled = false;
        const headerClickHandler = (e) => {
            if (e.target.closest('#contact-collapse-toggle')) return; // не дублируем клик кнопки
            toggleCollapsible();
        };
        const headerKeyHandler = (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                toggleCollapsible();
            }
        };

        function enableHeaderToggle() {
            if (!toggleArea || headerToggleEnabled) return;
            toggleArea.setAttribute('role', 'button');
            toggleArea.setAttribute('tabindex', '0');
            toggleArea.setAttribute('aria-expanded', collapsible?.dataset.open === 'true' ? 'true' : 'false');
            toggleArea.classList.add('cursor-pointer');
            toggleArea.addEventListener('click', headerClickHandler);
            toggleArea.addEventListener('keydown', headerKeyHandler);
            headerToggleEnabled = true;
        }

        function disableHeaderToggle() {
            if (!toggleArea || !headerToggleEnabled) return;
            toggleArea.removeAttribute('role');
            toggleArea.removeAttribute('tabindex');
            toggleArea.removeAttribute('aria-expanded');
            toggleArea.classList.remove('cursor-pointer');
            toggleArea.addEventListener('click', headerClickHandler);
            toggleArea.removeEventListener('click', headerClickHandler);
            toggleArea.removeEventListener('keydown', headerKeyHandler);
            headerToggleEnabled = false;
        }

        function updateHeaderInteractivity() {
            if (isLargeScreen()) {
                disableHeaderToggle();
            } else {
                enableHeaderToggle();
            }
        }
        updateHeaderInteractivity();
        window.addEventListener('resize', () => {
            const wasLarge = toggleBtn?.getAttribute('data-prev-large') === 'true';
            const nowLarge = isLargeScreen();
            if (wasLarge !== nowLarge) {
                applyState(nowLarge ? true : (collapsible.dataset.open === 'true'));
            }
            if (toggleBtn) toggleBtn.setAttribute('data-prev-large', nowLarge ? 'true' : 'false');
            updateHeaderInteractivity();
        });
        initCollapsible();

        const form = document.querySelector('#connection form.contact-form');
        if (!form) return;
        const msgWrap = form.querySelector('.contact-msg-wrapper');
        const submitBtn = form.querySelector('.submit-btn');
        const btnText = form.querySelector('.btn-text');
        const btnSpinner = form.querySelector('.btn-spinner');
        const errorSpans = form.querySelectorAll('.field-error');
        const phoneInput = form.querySelector('#contact-phone');

        function setLoading(state) {
            if (!submitBtn) return;
            submitBtn.disabled = state;
            if (btnSpinner) btnSpinner.classList.toggle('hidden', !state);
            if (btnText) btnText.textContent = state ? 'Отправка...' : 'Отправить';
        }

        function clearFieldErrors() {
            errorSpans.forEach(s => {
                s.textContent = '';
                s.removeAttribute('data-error-active');
            });
            form.querySelectorAll('.field-input').forEach(inp => {
                inp.classList.remove('border-red-500', 'border-b-2', 'error');
                inp.removeAttribute('aria-invalid');
            });
        }

        function clearSingleFieldError(input) {
            const name = input.getAttribute('name');
            const span = form.querySelector(`[data-error-for="${name}"]`);
            if (span) {
                span.textContent = '';
                span.removeAttribute('data-error-active');
            }
            input.classList.remove('border-red-500', 'border-b-2', 'error');
            input.removeAttribute('aria-invalid');
        }

        function ensureErrorStyles() {
            if (document.getElementById('contact-error-styles')) return;
            const style = document.createElement('style');
            style.id = 'contact-error-styles';
            style.textContent = `
            #connection .field-error[data-error-active="true"] { position: relative; display: inline-block; background: #dc2626; color:#fff; padding:4px 10px 5px; border-radius:6px; font-weight:500; line-height:1.2; box-shadow:0 4px 10px -2px rgba(0,0,0,.25); }
            #connection .field-error[data-error-active="true"]:before { content:""; position:absolute; top:-6px; left:14px; width:0; height:0; border-left:6px solid transparent; border-right:6px solid transparent; border-bottom:6px solid #dc2626; }
            #connection .field-error { font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont; }
            #connection .mobile-collapsible { transition: max-height .5s cubic-bezier(.4,0,.2,1), opacity .35s ease; overflow:hidden; }
            #connection .mobile-collapsible[data-open="false"] { max-height:0; opacity:0; pointer-events:none; }
            #connection .mobile-collapsible[data-open="true"] { max-height:4000px; opacity:1; }
            #connection .field-input { border-width:0 0 1px 0; transition: border-color .25s ease, border-bottom-width .25s ease; position:relative; }
            #connection .field-input.error { border-bottom:2px solid #ef4444 !important; }
            #connection .field-input::placeholder { color:rgba(255,255,255,0.75); opacity:1; transition: opacity .30s ease, color .30s ease; }
            #connection .field-input:focus::placeholder { opacity:0; }
            /* Scroll reveal справа налево */
            #connection.scroll-animate { opacity:0; transform:translateX(80px); transition:opacity .8s ease, transform .8s cubic-bezier(.25,.8,.25,1); }
            #connection.scroll-animate.in-view { opacity:1; transform:translateX(0); }
            #connection .date-wrapper { position:relative; }
            #connection .date-wrapper input[type="date"] { color-scheme: dark; position:relative; z-index:2; background:transparent; }
            #connection .date-wrapper input[type="date"]::-webkit-calendar-picker-indicator { opacity:0; display:none; }
            /* Стили кастомного плейсхолдера */
            #connection .date-wrapper .date-ph { position:absolute; left:0; top:50%; transform:translateY(-50%); font-weight:600; font-size:0.875rem; line-height:1; pointer-events:none; color:rgba(255,255,255,0.75); transition:opacity .05s linear; }
            #connection .date-wrapper.pre-activate .date-ph { opacity:0; }
            /* Прячем нативный шаблон формата пока поле пустое и НЕ в фокусе */
            /* Прячем нативный шаблон формата пока нет значения и пользователь еще не инициировал взаимодействие */
            #connection .date-wrapper:not([data-has-value="true"]):not(.pre-activate):not(.focus) input[type="date"] { color:transparent; caret-color:transparent; }
            #connection .date-wrapper:not([data-has-value="true"]):not(.pre-activate):not(.focus) input[type="date"]::-webkit-datetime-edit { color:transparent; }
            /* Когда произошло нажатие (pre-activate), фокус или есть значение – показываем нативный текст */
            #connection .date-wrapper.pre-activate .date-ph,
            #connection .date-wrapper.focus .date-ph,
            #connection .date-wrapper[data-has-value="true"] .date-ph { opacity:0; }
            #connection .date-wrapper .date-calendar-btn { z-index:3; background:transparent; color:#fff; }
            #connection .date-wrapper .date-calendar-btn:focus { outline: none; }
            #connection .date-wrapper .date-calendar-btn svg { pointer-events:none; }
            @keyframes fieldBounce {0%{transform:translateY(0);}30%{transform:translateY(-4px);}55%{transform:translateY(0);}100%{transform:translateY(0);} }
            #connection .field-input.focus-bounce { animation: fieldBounce .40s cubic-bezier(.34,1.56,.64,1); }
        `;
            document.head.appendChild(style);
        }
        ensureErrorStyles();

        function setFieldError(field, message) {
            const span = form.querySelector(`[data-error-for="${field}"]`);
            const input = form.querySelector(`[name="${field}"]`);
            if (span) {
                span.textContent = message;
                span.dataset.errorActive = 'true';
            }
            if (input) {
                input.classList.add('error');
                input.setAttribute('aria-invalid', 'true');
            }
        }

        // ===== PHONE MASK =====
        function formatPhoneMask(raw) {
            let digits = raw.replace(/\D/g, '');
            if (digits.startsWith('8')) digits = '7' + digits.slice(1);
            if (!digits.startsWith('7')) digits = '7' + digits; // принудительно к +7
            digits = digits.slice(0, 11); // 1 + 10 цифр
            const core = digits.slice(1);
            const p1 = core.slice(0, 3);
            const p2 = core.slice(3, 6);
            const p3 = core.slice(6, 8);
            const p4 = core.slice(8, 10);
            let result = '+7';
            result += ' (' + p1.padEnd(3, '_') + ')';
            result += ' ' + (p2 ? p2.padEnd(3, '_') : '___');
            result += ' ' + (p3 ? p3.padEnd(2, '_') : '__');
            result += ' ' + (p4 ? p4.padEnd(2, '_') : '__');
            return result;
        }

        function isPhoneComplete(masked) {
            return masked.indexOf('_') === -1;
        }

        if (phoneInput) {
            phoneInput.addEventListener('focus', () => {
                if (!phoneInput.value.trim()) {
                    phoneInput.value = formatPhoneMask('');
                    requestAnimationFrame(() => {
                        let pos = phoneInput.value.indexOf('_');
                        if (pos === -1) pos = phoneInput.value.length;
                        phoneInput.setSelectionRange(pos, pos);
                    });
                }
            });
            phoneInput.addEventListener('input', () => {
                const digits = phoneInput.value.replace(/\D/g, '');
                phoneInput.value = formatPhoneMask(digits);
                const firstUnderscore = phoneInput.value.indexOf('_');
                if (firstUnderscore !== -1) {
                    phoneInput.setSelectionRange(firstUnderscore, firstUnderscore);
                }
                if (phoneInput.getAttribute('aria-invalid') === 'true') {
                    const digitsCount = digits.length;
                    if (digitsCount >= 6) {
                        clearSingleFieldError(phoneInput);
                    }
                }
            });
            phoneInput.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace') {
                    const start = phoneInput.selectionStart;
                    if (start) {
                        for (let i = start - 1; i >= 0; i--) {
                            if (/\d|_/.test(phoneInput.value[i])) {
                                const arr = phoneInput.value.split('');
                                arr[i] = '_';
                                phoneInput.value = arr.join('');
                                phoneInput.setSelectionRange(i, i);
                                e.preventDefault();
                                break;
                            }
                        }
                    }
                }
            });
            phoneInput.addEventListener('blur', () => {
                // Если оставили только маску или неполный номер — очищаем поле чтобы placeholder вернулся
                if (!isPhoneComplete(phoneInput.value) || phoneInput.value === formatPhoneMask('')) {
                    phoneInput.value = '';
                }
            });
        }

        // ===== Поле даты: placeholder 'Дата' + маска только при фокусе =====
        (function initDateField() {
            const dateInput = form.querySelector('#contact-date');
            if (!dateInput) return;
            const wrap = dateInput.closest('.date-wrapper');
            if (!wrap) return;
            const calendarBtn = wrap.querySelector('.date-calendar-btn');

            function updateState() {
                wrap.setAttribute('data-has-value', dateInput.value ? 'true' : 'false');
            }
            updateState();

            // Моментальное скрытие плейсхолдера при нажатии (еще до фокуса)
            dateInput.addEventListener('pointerdown', () => {
                if (!dateInput.value) wrap.classList.add('pre-activate');
            });
            dateInput.addEventListener('focus', () => {
                wrap.classList.add('focus');
            });
            dateInput.addEventListener('blur', () => {
                wrap.classList.remove('focus');
                if (!dateInput.value) wrap.classList.remove('pre-activate');
                updateState();
            });
            dateInput.addEventListener('input', updateState);
            dateInput.addEventListener('change', updateState);
            if (calendarBtn) {
                calendarBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    if (typeof dateInput.showPicker === 'function') dateInput.showPicker();
                    else dateInput.focus();
                });
            }
        })();
        // Анимация подпрыгивания нижнего бордера при фокусе
        form.querySelectorAll('.field-input').forEach(inp => {
            inp.addEventListener('focus', () => {
                inp.classList.remove('focus-bounce');
                void inp.offsetWidth; // reflow для рестарта анимации
                inp.classList.add('focus-bounce');
            });
        });

        // Очистка ошибки при вводе в другие поля (name/date)
        form.querySelectorAll('.field-input').forEach(inp => {
            if (inp.id === 'contact-phone') return;
            inp.addEventListener('input', () => {
                if (inp.getAttribute('aria-invalid') === 'true') {
                    clearSingleFieldError(inp);
                }
            });
            inp.addEventListener('blur', () => {
                if (inp.value.trim() && inp.getAttribute('aria-invalid') === 'true') {
                    clearSingleFieldError(inp);
                }
            });
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (msgWrap) msgWrap.innerHTML = '';
            clearFieldErrors();

            const phoneVal = phoneInput ? phoneInput.value.trim() : '';
            if (phoneInput && !isPhoneComplete(phoneVal)) {
                setFieldError('phone', 'Заполните номер полностью');
                phoneInput.focus();
                return;
            }

            const formData = new FormData(form);
            if (phoneInput) {
                formData.set('phone', phoneVal.replace(/_/g, '').replace(/\s+/g, ' '));
            }
            setLoading(true);
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: formData
            }).then(async (res) => {
                let data = {};
                try {
                    data = await res.json();
                } catch (e) {}
                if (!res.ok) {
                    if (data && data.errors) {
                        Object.entries(data.errors).forEach(([field, messages]) => {
                            setFieldError(field, messages[0]);
                        });
                        const firstErrorInput = form.querySelector('[aria-invalid="true"]');
                        if (firstErrorInput) firstErrorInput.focus();
                    } else {
                        if (msgWrap) msgWrap.innerHTML =
                            `<div class=\"bg-red-600/90 text-white px-4 py-3 rounded text-sm\">Произошла ошибка. Повторите позже.</div>`;
                    }
                } else {
                    if (msgWrap) msgWrap.innerHTML =
                        `<div class=\"bg-green-600/90 text-white px-4 py-3 text-sm font-medium\">${data.message || 'Заявка отправлена.'}</div>`;
                    form.reset();
                    if (phoneInput) phoneInput.value = '';
                    clearFieldErrors();
                }
            }).catch(() => {
                if (msgWrap) msgWrap.innerHTML =
                    `<div class=\"bg-red-600/90 text-white px-4 py-3 rounded text-sm\">Сеть недоступна. Проверьте соединение.</div>`;
            }).finally(() => {
                setLoading(false);
            });
        });
        // Scroll reveal наблюдатель
        const section = document.getElementById('connection');
        if (section) {
            function makeVisible() {
                section.classList.add('in-view');
            }
            if ('IntersectionObserver' in window) {
                const io = new IntersectionObserver((entries, obs) => {
                    entries.forEach(en => {
                        if (en.isIntersecting) {
                            makeVisible();
                            obs.disconnect();
                        }
                    });
                }, {
                    root: null,
                    threshold: 0.2
                });
                io.observe(section);
            } else {
                // fallback
                setTimeout(makeVisible, 150);
            }
        }
    });
</script>
