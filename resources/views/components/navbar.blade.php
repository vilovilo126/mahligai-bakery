@php
    $customer = auth()->user();

    $guestLinks = [
        ['href' => '#beranda', 'label' => 'Beranda'],
        ['href' => '#tentang', 'label' => 'Tentang Kami'],
        ['href' => '#cerita', 'label' => 'Cerita Kami'],
        ['href' => '#galeri', 'label' => 'Galeri'],
        ['href' => '#lokasi', 'label' => 'Lokasi'],
        ['href' => '#kontak', 'label' => 'Kontak'],
    ];

    $customerLinks = [
        ['href' => '#beranda', 'label' => 'Beranda'],
        ['href' => '#produk', 'label' => 'Menu'],
        ['href' => route('customer.orders'), 'label' => 'Pesanan Saya'],
        ['href' => route('customer.notifications'), 'label' => 'Notifikasi'],
    ];

    $isCustomer = $customer?->is_customer ?? false;
    $links = $isCustomer ? $customerLinks : $guestLinks;
    $brandHref = $customer ? ($isCustomer ? route('menu') : route('admin.dashboard')) : '#beranda';
@endphp

<header id="site-header" class="fixed inset-x-0 top-0 z-50">
    <div class="mx-auto flex w-full max-w-7xl items-center justify-between gap-4 px-4 py-3.5 sm:px-6 lg:px-8">
        <x-brand-mark :href="$brandHref" />

        <nav class="hidden items-center gap-8 lg:flex" aria-label="Navigasi utama">
            @foreach ($links as $link)
                <a href="{{ $link['href'] }}"
                    class="hover-underline text-sm font-medium text-inherit opacity-90 transition-opacity hover:opacity-100">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="hidden items-center gap-2.5 lg:flex">
            @auth
                @if ($isCustomer)
                    <div data-customer-nav class="relative">
                        <button type="button" data-notif-toggle
                            class="relative grid h-11 w-11 place-items-center rounded-xl bg-white/10 text-inherit ring-1 ring-white/25 backdrop-blur transition hover:bg-white/20"
                            aria-label="Notifikasi">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                            <span data-notif-unread class="absolute right-1.5 top-1.5 hidden min-w-4 rounded-full bg-rose-500 px-1 text-center text-[0.6rem] font-bold leading-4 text-white ring-2 ring-white/60"></span>
                        </button>

                        <div data-notif-dropdown class="absolute right-0 top-14 z-50 hidden w-80 overflow-hidden rounded-2xl bg-white text-brand-950 shadow-2xl ring-1 ring-brand-950/10">
                            <div class="flex items-center justify-between border-b border-brand-950/10 bg-cream-50 px-4 py-3">
                                <p class="text-xs font-bold uppercase tracking-[0.16em] text-brand-600">Notifikasi</p>
                                <a href="{{ route('customer.notifications') }}" class="text-xs font-semibold text-brand-700 hover:underline">Lihat Semua</a>
                            </div>
                            <div data-notif-list class="max-h-80 overflow-y-auto">
                                <p data-notif-empty class="px-4 py-8 text-center text-sm text-brand-950/45">Belum ada notifikasi.</p>
                            </div>
                        </div>
                    </div>

                    <div data-customer-nav class="relative">
                        <button type="button" data-customer-menu-toggle
                            class="inline-flex items-center gap-2 rounded-full bg-white/10 py-1.5 pl-1.5 pr-4 text-inherit ring-1 ring-white/25 backdrop-blur transition hover:bg-white/20"
                            aria-haspopup="true" aria-expanded="false">
                            <span class="grid h-8 w-8 place-items-center rounded-full bg-gradient-to-br from-brand-500 to-brand-700 text-sm font-bold text-white">{{ mb_strtoupper(mb_substr($customer->name, 0, 1)) }}</span>
                            <span class="max-w-28 truncate text-sm font-semibold">{{ $customer->name }}</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" class="h-4 w-4 opacity-70"><path d="m6 9 6 6 6-6"/></svg>
                        </button>

                        <div data-customer-menu class="absolute right-0 top-14 z-50 hidden w-56 overflow-hidden rounded-2xl bg-white text-brand-950 shadow-2xl ring-1 ring-brand-950/10">
                            <div class="border-b border-brand-950/10 px-4 py-3">
                                <p class="truncate text-sm font-bold">{{ $customer->name }}</p>
                                <p class="text-xs text-brand-950/45">Akun Pelanggan</p>
                            </div>
                            <nav class="p-1.5 text-sm">
                                <a href="{{ route('customer.orders') }}" class="flex items-center gap-2.5 rounded-xl px-3 py-2.5 text-brand-800 transition hover:bg-brand-50">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-4.5 w-4.5"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18M16 10a4 4 0 0 1-8 0"/></svg>
                                    Pesanan Saya
                                </a>
                                <a href="{{ route('customer.notifications') }}" class="flex items-center gap-2.5 rounded-xl px-3 py-2.5 text-brand-800 transition hover:bg-brand-50">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-4.5 w-4.5"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                                    Notifikasi
                                </a>
                                <button type="button" data-chat-open class="flex w-full items-center gap-2.5 rounded-xl px-3 py-2.5 text-left text-brand-800 transition hover:bg-brand-50">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-4.5 w-4.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2Z"/></svg>
                                    Chat dengan Admin
                                </button>
                            </nav>
                            <form action="{{ route('logout') }}" method="POST" class="border-t border-brand-950/10 p-1.5">
                                @csrf
                                <button type="submit" class="flex w-full items-center gap-2.5 rounded-xl px-3 py-2.5 text-left text-sm text-rose-600 transition hover:bg-rose-50">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-4.5 w-4.5"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="m16 17 5-5-5-5M21 12H9"/></svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('admin.dashboard') }}"
                        class="inline-flex items-center gap-2 rounded-full bg-white/10 px-5 py-2.5 text-sm font-semibold text-inherit ring-1 ring-white/25 backdrop-blur transition hover:bg-white/20">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
                        Dasbor
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-full bg-white/10 px-5 py-2.5 text-sm font-semibold text-inherit ring-1 ring-white/25 backdrop-blur transition hover:bg-white/20">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="m16 17 5-5-5-5M21 12H9"/></svg>
                            Keluar
                        </button>
                    </form>
                @endif
            @else
                <a href="{{ route('login') }}"
                    class="inline-flex items-center gap-2 rounded-full bg-white/10 px-5 py-2.5 text-sm font-semibold text-inherit ring-1 ring-white/25 backdrop-blur transition hover:bg-white/20">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><path d="m10 17 5-5-5-5M15 12H3"/></svg>
                    Masuk
                </a>
            @endauth

            @guest
                <a href="https://wa.me/{{ config('business.whatsapp_number') }}" target="_blank" rel="noopener"
                    class="hidden items-center gap-2 rounded-full bg-white/10 px-5 py-2.5 text-sm font-semibold text-inherit ring-1 ring-white/25 backdrop-blur transition hover:bg-white/20 xl:inline-flex">
                    <svg viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4 opacity-80">
                        <path d="M12 2a9.9 9.9 0 0 0-8.5 14.9L2 22l5.3-1.4A10 10 0 1 0 12 2Z"/>
                    </svg>
                    Hubungi Kami
                </a>
            @endguest
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
            @auth
                @if ($isCustomer)
                    <div class="flex items-center gap-3 border-b border-brand-950/5 p-3">
                        <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-gradient-to-br from-brand-500 to-brand-700 text-sm font-bold text-white">{{ mb_strtoupper(mb_substr($customer->name, 0, 1)) }}</span>
                        <div class="min-w-0">
                            <p class="truncate text-sm font-bold text-brand-950">{{ $customer->name }}</p>
                            <p class="text-xs text-brand-950/45">Akun Pelanggan</p>
                        </div>
                        <button type="button" data-chat-open class="ml-auto grid h-9 w-9 place-items-center rounded-full bg-brand-50 text-brand-700 transition hover:bg-brand-100" aria-label="Buka chat">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-4.5 w-4.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2Z"/></svg>
                        </button>
                    </div>
                    <nav class="flex flex-col gap-1 p-3" aria-label="Navigasi mobile">
                        @foreach ($links as $link)
                            <a href="{{ $link['href'] }}"
                                class="rounded-xl px-4 py-3 text-sm font-medium text-brand-800 transition hover:bg-brand-50 hover:text-brand-700">
                                {{ $link['label'] }}
                            </a>
                        @endforeach
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="mt-1 w-full rounded-xl bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-600 transition hover:bg-rose-100">Keluar</button>
                        </form>
                    </nav>
                @else
                    <nav class="flex flex-col gap-1 p-3" aria-label="Navigasi mobile">
                        @foreach ($links as $link)
                            <a href="{{ $link['href'] }}"
                                class="rounded-xl px-4 py-3 text-sm font-medium text-brand-800 transition hover:bg-brand-50 hover:text-brand-700">
                                {{ $link['label'] }}
                            </a>
                        @endforeach
                        <a href="{{ route('admin.dashboard') }}" class="rounded-xl px-4 py-3 text-sm font-medium text-brand-800 transition hover:bg-brand-50 hover:text-brand-700">Dasbor Admin</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="mt-1 w-full rounded-xl bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-600 transition hover:bg-rose-100">Keluar</button>
                        </form>
                    </nav>
                @endif
            @else
                <nav class="flex flex-col gap-1 p-3" aria-label="Navigasi mobile">
                    @foreach ($links as $link)
                        <a href="{{ $link['href'] }}"
                            class="rounded-xl px-4 py-3 text-sm font-medium text-brand-800 transition hover:bg-brand-50 hover:text-brand-700">
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                    <a href="{{ route('login') }}"
                        class="mt-2 inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-brand-500 to-brand-700 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:brightness-105">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><path d="m10 17 5-5-5-5M15 12H3"/></svg>
                        Masuk untuk Pesan
                    </a>
                </nav>
            @endauth
        </div>
    </div>
</header>