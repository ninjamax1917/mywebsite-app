@extends('layouts.app')

@section('content')
    @php
        // Ожидается: $case (array), $slug (string)
        $images = $case['images'] ?? [];
        // Если cover присутствует и не совпадает с первым изображением — добавить его в начало
        if (!empty($case['cover'])) {
            $coverPath = $case['cover'];
            // Нормализуем относительный путь если передан абсолютный URL
            if (!str_starts_with($coverPath, 'images/')) {
                // Попытка вырезать base URL
                $base = asset('');
                $coverPath = str_replace($base, '', $coverPath);
            }
            if (!empty($images)) {
                if ($images[0] !== $coverPath) {
                    array_unshift($images, $coverPath);
                }
            } else {
                $images = [$coverPath];
            }
        }
        $slidesPayload = [];
        foreach ($images as $p) {
            $slidesPayload[] = [
                'src' => asset($p),
                'alt' => ($case['title'] ?? 'Project') . ' image',
            ];
        }
    @endphp
    <section class="container-custom py-10 md:py-14 text-gray-800">
        <div class="flex items-center justify-between flex-wrap gap-4 mb-6">
            <a href="{{ route('projects.index') }}"
                class="text-sm uppercase tracking-wide text-blue-400 hover:text-blue-300">← Все проекты</a>
            <div class="flex gap-3 text-sm opacity-70">
                <span>#{{ $slug }}</span>
                @if (!empty($case['created_at']))
                    <span>{{ $case['created_at'] }}</span>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-12 gap-10">
            <!-- Левая колонка: Hero + Thumbnails -->
            <div class="xl:col-span-6 2xl:col-span-7">
                <div class="space-y-5">
                    <div
                        class="overflow-hidden rounded-xl bg-gray-900 relative shadow-lg ring-1 ring-white/5 h-[320px] sm:h-[400px] md:h-[480px] lg:h-[540px] xl:h-[620px] 2xl:h-[680px]">
                        <!-- Hero image: высота управляется через h-[...] классы выше -->
                        <img id="heroImage" src="{{ $slidesPayload[0]['src'] ?? '' }}"
                            alt="{{ $slidesPayload[0]['alt'] ?? 'hero image' }}"
                            class="w-full h-full object-cover transition duration-500" loading="eager" fetchpriority="high">
                    </div>
                    @if (count($slidesPayload) > 1)
                        <div class="grid grid-cols-5 md:grid-cols-6 lg:grid-cols-7 gap-2" id="thumbBar">
                            @foreach ($slidesPayload as $i => $slide)
                                <button data-full="{{ $slide['src'] }}" data-alt="{{ $slide['alt'] }}"
                                    data-index="{{ $i }}"
                                    class="group relative aspect-square overflow-hidden rounded-lg ring-2 ring-transparent hover:ring-blue-400 focus:outline-none focus:ring-blue-500 transition">
                                    <img src="{{ $slide['src'] }}" alt="{{ $slide['alt'] }} thumbnail"
                                        class="object-cover w-full h-full group-hover:scale-105 transition duration-300"
                                        loading="lazy">
                                    <span class="absolute inset-0 bg-blue-500/0 group-[.active]:bg-blue-500/10"></span>
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <!-- Правая колонка: Контент -->
            <div class="xl:col-span-6 2xl:col-span-5 flex flex-col">
                <header>
                    <h1 class="text-3xl md:text-4xl font-extrabold leading-tight text-gray-800">
                        {{ $case['title'] }}</h1>
                    @if (!empty($case['short']))
                        <p class="mt-4 text-lg leading-relaxed text-gray-700">{{ $case['short'] }}</p>
                    @endif
                </header>

                <div class="mt-10 flex-1 space-y-6">
                    @if (!empty($case['description_html']))
                        <article
                            class="prose max-w-none prose-p:leading-relaxed prose-headings:font-semibold text-gray-800">
                            {!! $case['description_html'] !!}
                        </article>
                    @elseif(!empty($case['description']))
                        <article class="space-y-4 leading-relaxed text-base md:text-lg max-w-none text-gray-800">
                            @foreach ((array) $case['description'] as $para)
                                <p>{{ $para }}</p>
                            @endforeach
                        </article>
                    @else
                        <p class="text-sm italic text-gray-500">Описание будет добавлено позже.</p>
                    @endif
                </div>

                @if (!empty($neighbors))
                    <nav class="mt-12 flex flex-wrap justify-between gap-4 border-t border-white/10 pt-6 text-sm">
                        @if (!empty($neighbors['prev']))
                            <a href="{{ route('projects.show', $neighbors['prev']['slug']) }}"
                                class="text-blue-400 hover:text-blue-300">← {{ $neighbors['prev']['title'] }}</a>
                        @else
                            <span></span>
                        @endif
                        @if (!empty($neighbors['next']))
                            <a href="{{ route('projects.show', $neighbors['next']['slug']) }}"
                                class="text-blue-400 hover:text-blue-300">{{ $neighbors['next']['title'] }} →</a>
                        @endif
                    </nav>
                @endif
            </div>
        </div>
    </section>

    <script>
        (function() {
            const hero = document.getElementById('heroImage');
            const bar = document.getElementById('thumbBar');
            if (!hero || !bar) return;
            const buttons = Array.from(bar.querySelectorAll('button[data-full]'));
            let activeIndex = 0;
            const activate = (idx) => {
                const btn = buttons[idx];
                if (!btn) return;
                const src = btn.getAttribute('data-full');
                const alt = btn.getAttribute('data-alt');
                if (src) {
                    // Плавная смена
                    hero.classList.add('opacity-0');
                    setTimeout(() => {
                        hero.src = src;
                        if (alt) hero.alt = alt;
                        hero.classList.remove('opacity-0');
                    }, 140);
                }
                buttons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                activeIndex = idx;
            };
            buttons.forEach((b, i) => {
                b.addEventListener('click', () => activate(i));
                b.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        activate(i);
                    }
                });
                b.setAttribute('tabindex', '0');
                b.setAttribute('aria-label', 'Показать изображение ' + (i + 1));
            });
            if (buttons.length) {
                buttons[0].classList.add('active');
            }
        })();
    </script>
@endsection
