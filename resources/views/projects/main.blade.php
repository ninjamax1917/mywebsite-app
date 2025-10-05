@php($title = 'Проекты')
@extends('layouts.app')

@section('content')
    <section class="container-custom py-16 text-gray-800">
        <h1 class="text-3xl md:text-4xl font-extrabold mb-10 text-gray-800">Все проекты</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            @foreach ($cases as $slug => $item)
                <article class="group">
                    <a href="{{ route('projects.show', $slug) }}" class="block relative overflow-hidden h-80 shadow">
                        <img src="{{ $item['cover'] }}" alt="{{ $item['title'] }}"
                            class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-500"
                            loading="lazy">
                        <div class="absolute inset-x-0 bottom-0 bg-black/50 backdrop-blur-sm p-4">
                            <h2 class="text-xl font-semibold">{{ $item['title'] }}</h2>
                            <p class="text-sm opacity-80">{{ $item['short'] }}</p>
                        </div>
                    </a>
                    @if (!empty($item['badges']))
                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach ($item['badges'] as $b)
                                <span
                                    class="bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded border border-gray-300">{{ $b }}</span>
                            @endforeach
                        </div>
                    @endif
                </article>
            @endforeach
        </div>
    </section>
@endsection
