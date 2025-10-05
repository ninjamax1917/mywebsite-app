@extends('layouts.app')

@section('content')
    <div x-data="{ showBackTop: false, threshold: 0 }" x-init="threshold = $refs.firstSection ? $refs.firstSection.offsetHeight : 500" @scroll.window="showBackTop = window.scrollY > threshold">
        <div class="py-8 md:py-8 lg:py-16" x-ref="firstSection">
            <section>
                <x-home_partials.section_main />
                <x-home_partials.section_services />
                <x-home_partials.section_our_competencies />
                <x-home_partials.section_work />
                <x-home_partials.section_our_projects />
                <x-home_partials.section_map />
            </section>
        </div>

        <!-- Кнопка «наверх» (независимо от Alpine) -->
        <button id="back-to-top" type="button" aria-label="Наверх"
            class="cursor-pointer fixed z-50 bottom-6 right-6 md:bottom-8 md:right-8 inline-flex items-center justify-center
           w-[3.6rem] h-[3.6rem] md:w-[3.9rem] md:h-[3.9rem] bg-blue-500 text-white shadow-lg
           transition-all duration-300 ease-in-out transform hover:scale-105 hover:bg-blue-600 hover:shadow-2xl focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="50" height="50" fill="currentColor"
                stroke="currentColor" stroke-width="0.8" stroke-linejoin="round" stroke-linecap="round" aria-hidden="true"
                focusable="false">
                <path d="M4 12l1.41 1.41L11 7.83V20h2V7.83l5.59 5.58L20 12l-8-8-8 8z" />
            </svg>
        </button>

        <style>
            /* Плавная анимация скругления кнопки «Наверх» */
            #back-to-top {
                border-radius: 50%;
                transition: border-radius 420ms cubic-bezier(.2, .7, .2, 1),
                    background-color 300ms cubic-bezier(.2, .7, .2, 1),
                    box-shadow 300ms cubic-bezier(.2, .7, .2, 1),
                    transform 300ms cubic-bezier(.2, .7, .2, 1);
                will-change: border-radius, transform;
            }

            #back-to-top:hover {
                border-radius: 0;
            }

            @media (prefers-reduced-motion: reduce) {
                #back-to-top {
                    transition: background-color 200ms ease, box-shadow 200ms ease;
                }
            }
        </style>

        <script>
            (function() {
                const btn = document.getElementById('back-to-top');
                if (!btn) return;

                const threshold = 300; // фиксированный порог появления
                function toggle() {
                    btn.style.display = (window.scrollY > threshold) ? 'flex' : 'none';
                }

                window.addEventListener('scroll', toggle, {
                    passive: true
                });
                document.addEventListener('scroll', toggle, {
                    passive: true
                });
                window.addEventListener('load', toggle, {
                    passive: true
                });

                // Убираем обрамление при нажатии
                btn.addEventListener('mousedown', function() {
                    this.blur();
                });
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    this.blur();
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });

                // init
                toggle();
            })();
        </script>
    </div>
@endsection
