<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#0f2618">

        <title>@yield('title', 'Admin') · Mahligai Bakery</title>

        @fonts

        @vite(['resources/css/app.css', 'resources/css/custom.css'])
    </head>
    <body class="bg-cream-50 font-sans text-brand-950 antialiased">
        <header class="border-b border-brand-950/10 bg-white">
            <div class="mx-auto flex w-full max-w-6xl items-center justify-between gap-4 px-4 py-4 sm:px-6">
                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-2.5">
                    <span class="grid h-9 w-9 place-items-center rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 text-white">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="M4 17.5C4 11.5 8 8 12 8c4 0 8 3.5 8 9.5 0 .8-1.3 1.5-4 1.5H8c-2.7 0-4-.7-4-1.5Z"/></svg>
                    </span>
                    <div>
                        <p class="font-display text-base font-semibold leading-tight">Mahligai Bakery</p>
                        <p class="text-xs text-brand-950/50">Panel Admin</p>
                    </div>
                </a>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 rounded-full border border-brand-950/10 px-4 py-2 text-sm font-semibold text-brand-700 transition hover:bg-brand-50">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="m12 19-7-7 7-7M5 12h14"/></svg>
                    Kembali ke Website
                </a>
            </div>
        </header>

        <main class="mx-auto w-full max-w-6xl px-4 py-8 sm:px-6">
            @yield('content')
        </main>
    </body>
</html>
