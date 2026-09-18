<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#0f2618">
        <meta name="description" content="Mahligai Bakery — bakery premium di Denpasar, Bali. Roti artisan, pastry, dan cake dengan bahan pilihan. Rasa hangat, kualitas istimewa.">

        <title>@yield('title', 'Mahligai Bakery — Rasa Hangat, Kualitas Istimewa')</title>

        <meta property="og:type" content="website">
        <meta property="og:site_name" content="Mahligai Bakery">
        <meta property="og:title" content="Mahligai Bakery — Rasa Hangat, Kualitas Istimewa">
        <meta property="og:description" content="Bakery premium di Denpasar, Bali. Sourdough, croissant, cake, donat & cookies dengan bahan pilihan.">
        <meta property="og:image" content="{{ asset('images/hero/hero-bakery.svg') }}">

        <link rel="icon" type="image/svg+xml"
            href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Crect width='24' height='24' rx='6' fill='%23347f4a'/%3E%3Cpath d='M4 17.5C4 11.5 8 8 12 8C16 8 20 11.5 20 17.5C20 18.3 16.7 19 12 19C7.3 19 4 18.3 4 17.5Z' fill='%23fff'/%3E%3Cpath d='M8.5 12.5 L10.5 11.4 M11 14.3 L13.4 13.2 M13.6 15.2 L15.9 14.1' stroke='%232b663d' stroke-width='1' stroke-linecap='round'/%3E%3C/svg%3E">

        @fonts

        @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/js/app.js'])
    </head>
    <body class="overflow-x-hidden bg-cream-50 font-sans text-brand-950 antialiased">
        <x-navbar />

        @yield('content')

        <x-footer />
        <x-chatbot />
        <x-product-detail-modal />
        <x-qris-modal />
    </body>
</html>