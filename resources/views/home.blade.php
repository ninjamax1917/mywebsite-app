@extends('layouts.app')

@section('content')
    <div x-data="{ showBackTop: false, threshold: 0 }" x-init="threshold = $refs.firstSection ? $refs.firstSection.offsetHeight : 500" @scroll.window="showBackTop = window.scrollY > threshold">
        <div class="py-8 md:py-8 lg:py-16" x-ref="firstSection">
            <section>
                <x-home_partials.section_main />
                <x-home_partials.section_services />
                <x-home_partials.section_work />
                <x-home_partials.section_our_projects />
            </section>
        </div>
    </div>
@endsection
