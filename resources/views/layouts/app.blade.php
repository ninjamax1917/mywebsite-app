<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Мой сайт')</title>
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/images/icons/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/icons/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/icons/favicon_io/favicon-16x16.png">
    <link rel="manifest" href="/images/icons/favicon_io/site.webmanifest">

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body>
    @include('components.header.header')

    <div class="container mx-auto">
        @yield('content')
    </div>
    {{-- @include('components.footer') --}}
    @stack('scripts')

</body>

</html>
