@php
    $links = [
        ['href' => '#beranda', 'label' => 'Beranda'],
        ['href' => '#tentang', 'label' => 'Tentang Kami'],
        ['href' => '#produk', 'label' => 'Produk'],
        ['href' => '#galeri', 'label' => 'Galeri'],
        ['href' => '#lokasi', 'label' => 'Lokasi'],
        ['href' => '#kontak', 'label' => 'Kontak'],
    ];
@endphp

<header id="site-header" class="fixed inset-x-0 top-0 z-50">
    <div class="mx-auto flex w-full max-w-7xl items-center justify-between gap-6 px-4 py-3.5 sm:px-6 lg:px-8">
        <x-brand-mark />

        <nav class="hidden items-center gap-8 lg:flex" aria-label="Navigasi utama">
            @foreach ($links as $link)
                <a href="{{ $link['href'] }}"
                    class="hover-underline text-sm font-medium text-inherit opacity-90 transition-opacity hover:opacity-100">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="hidden lg:block">
            <a href="https://wa.me/{{ config('business.whatsapp_number') }}" target="_blank" rel="noopener"
                class="inline-flex items-center gap-2 rounded-full bg-white/10 px-5 py-2.5 text-sm font-semibold text-inherit ring-1 ring-white/25 backdrop-blur transition hover:bg-white/20">
                <svg viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4 opacity-80">
                    <path d="M12 2a9.9 9.9 0 0 0-8.5 14.9L2 22l5.3-1.4A10 10 0 1 0 12 2Zm5.1 14.1c-.2.6-1.2 1.2-1.7 1.2-.5.1-1 .2-3.3-.7-2.8-1.1-4.6-4-4.7-4.2-.1-.2-1.1-1.5-1.1-2.9s.7-2 1-2.3c.2-.3.5-.3.7-.3h.5c.2 0 .4 0 .6.5l.9 2.2c.1.2.1.4 0 .6l-.4.6-.5.5c-.2.2-.3.4-.1.7.2.3.8 1.4 1.8 2.3 1.3 1.2 2.3 1.5 2.7 1.7.3.2.5.1.7-.1l1-1.2c.2-.3.4-.2.7-.1l2.2 1c.3.2.5.3.6.4.1.2.1.6-.1 1Z"/>
                </svg>
                Hubungi Kami
            </a>
        </div>

        <button id="hamburger-btn" type="button"
            class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-white/10 text-inherit ring-1 ring-white/25 backdrop-blur lg:hidden"
            aria-label="Buka menu navigasi" aria-expanded="false" aria-controls="mobile-menu">
            <span class="relative block h-4 w-6">
                <span class="hamburger-line absolute left-0 top-0 block h-0.5 w-6 rounded-full bg-current"></span>
                <span class="hamburger-line absolute left-0 top-[7px] block h-0.5 w-6 rounded-full bg-current"></span>
                <span class="hamburger-line absolute left-0 top-[14px] block h-0.5 w-6 rounded-full bg-current"></span>
            </span>
        </button>
    </div>

    {{-- Mobile menu --}}
    <div id="mobile-menu" class="lg:hidden">
        <div class="mx-4 mb-3 rounded-2xl bg-white text-brand-900 shadow-soft ring-1 ring-brand-950/5 sm:mx-6">
            <nav class="flex flex-col gap-1 p-3" aria-label="Navigasi mobile">
                @foreach ($links as $link)
                    <a href="{{ $link['href'] }}"
                        class="rounded-xl px-4 py-3 text-sm font-medium text-brand-800 transition hover:bg-brand-50 hover:text-brand-700">
                        {{ $link['label'] }}
                    </a>
                @endforeach
                <a href="https://wa.me/{{ config('business.whatsapp_number') }}" target="_blank" rel="noopener"
                    class="mt-2 inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-brand-500 to-brand-700 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:brightness-105">
                    <svg viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                        <path d="M12 2a9.9 9.9 0 0 0-8.5 14.9L2 22l5.3-1.4A10 10 0 1 0 12 2Zm5.1 14.1c-.2.6-1.2 1.2-1.7 1.2-.5.1-1 .2-3.3-.7-2.8-1.1-4.6-4-4.7-4.2-.1-.2-1.1-1.5-1.1-2.9s.7-2 1-2.3c.2-.3.5-.3.7-.3h.5c.2 0 .4 0 .6.5l.9 2.2c.1.2.1.4 0 .6l-.4.6-.5.5c-.2.2-.3.4-.1.7.2.3.8 1.4 1.8 2.3 1.3 1.2 2.3 1.5 2.7 1.7.3.2.5.1.7-.1l1-1.2c.2-.3.4-.2.7-.1l2.2 1c.3.2.5.3.6.4.1.2.1.6-.1 1Z"/>
                    </svg>
                    Hubungi Kami
                </a>
            </nav>
        </div>
    </div>
</header>