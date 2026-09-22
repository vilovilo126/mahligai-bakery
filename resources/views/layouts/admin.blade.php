<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#0f2618">

        <title>@yield('title', 'Panel Admin') · Mahligai Bakery</title>

        @fonts

        @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/js/admin.js'])
    </head>
    <body class="bg-cream-50 font-sans text-brand-950 antialiased">
        @php
            $admin = auth()->user();
            $navItems = [
                ['route' => 'admin.dashboard', 'label' => 'Dasbor', 'icon' => '<path d="M3 13h8V3H3Zm0 8h8v-6H3Zm10 0h8v-8h-8Zm0-14v4h8V3Z"/>'],
                ['route' => 'admin.orders.index', 'label' => 'Pesanan', 'icon' => '<path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18M16 10a4 4 0 0 1-8 0"/>'],
                ['route' => 'admin.customers', 'label' => 'Pelanggan', 'icon' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>'],
                ['route' => 'admin.chat', 'label' => 'Chat', 'icon' => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2Z"/>', 'badge' => 'chat'],
                ['route' => 'admin.notifications', 'label' => 'Notifikasi', 'icon' => '<path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>', 'badge' => 'notif'],
                ['route' => 'admin.profile', 'label' => 'Profil Saya', 'icon' => '<path d="M12 8a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm0 3c-6 0-10 3.5-10 7a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3c0-3.5-4-7-10-7Z"/>'],
            ];
            $current = request()->route()?->getName();
        @endphp

        {{-- Overlay mobile --}}
        <div data-admin-overlay class="fixed inset-0 z-40 hidden bg-brand-950/50 backdrop-blur-sm lg:hidden"></div>

        {{-- Sidebar --}}
        <aside data-admin-sidebar class="admin-sidebar fixed inset-y-0 left-0 z-50 flex w-64 flex-col bg-gradient-to-b from-brand-950 to-brand-900 text-white">
            <div class="flex items-center gap-2.5 px-5 py-5">
                <span class="grid h-10 w-10 place-items-center rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 text-white">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="M4 17.5C4 11.5 8 8 12 8c4 0 8 3.5 8 9.5 0 .8-1.3 1.5-4 1.5H8c-2.7 0-4-.7-4-1.5Z"/></svg>
                </span>
                <div>
                    <p class="font-display text-base font-semibold leading-tight">Mahligai Bakery</p>
                    <p class="text-xs text-white/50">Panel Admin</p>
                </div>
                <button type="button" data-admin-sidebar-close class="ml-auto grid h-9 w-9 place-items-center rounded-xl bg-white/10 ring-1 ring-white/15 transition hover:bg-white/20 lg:hidden" aria-label="Tutup menu">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="h-4 w-4"><path d="M18 6 6 18M6 6l12 12"/></svg>
                </button>
            </div>

            <nav class="mt-2 flex-1 space-y-1 px-3" aria-label="Navigasi admin">
                @foreach ($navItems as $item)
                    <a href="{{ route($item['route']) }}"
                        class="admin-nav-link {{ $current === $item['route'] || (($item['route'] === 'admin.orders.index') && str_starts_with((string) $current, 'admin.orders')) ? 'is-active' : '' }} relative flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-white/75 transition hover:bg-white/10 hover:text-white">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">{!! $item['icon'] !!}</svg>
                        {{ $item['label'] }}
                        @if (($item['badge'] ?? null) === 'chat')
                            <span data-admin-unread-chat class="ml-auto hidden min-w-5 rounded-full bg-rose-500 px-1.5 py-0.5 text-center text-[0.65rem] font-bold leading-4 text-white">0</span>
                        @elseif (($item['badge'] ?? null) === 'notif')
                            <span data-admin-unread-notif class="ml-auto hidden min-w-5 rounded-full bg-rose-500 px-1.5 py-0.5 text-center text-[0.65rem] font-bold leading-4 text-white">0</span>
                        @endif
                    </a>
                @endforeach
                <a href="{{ route('menu') }}" target="_blank" rel="noopener"
                    class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-white/55 transition hover:bg-white/10 hover:text-white">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="M10 13a5 5 0 0 0 7.5.5l3-3a5 5 0 0 0-7-7l-1.7 1.7"/><path d="M14 11a5 5 0 0 0-7.5-.5l-3 3a5 5 0 0 0 7 7l1.7-1.7"/></svg>
                    Lihat Website
                </a>
            </nav>

            <div class="border-t border-white/10 p-3">
                <div class="flex items-center gap-3 rounded-xl bg-white/5 px-3 py-2.5">
                    <span class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-gradient-to-br from-brand-500 to-brand-700 text-sm font-bold text-white">
                        {{ mb_strtoupper(mb_substr($admin?->name ?? 'A', 0, 1)) }}
                    </span>
                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-white">{{ $admin?->name }}</p>
                        <p class="text-[0.7rem] text-white/45">{{ '@'.($admin?->username ?? 'admin') }}</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="ml-auto">
                        @csrf
                        <button type="submit" class="grid h-9 w-9 place-items-center rounded-xl bg-white/10 text-white/70 transition hover:bg-white/20 hover:text-white" aria-label="Keluar">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="m16 17 5-5-5-5M21 12H9"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Konten --}}
        <div id="admin-content" class="lg:pl-64">
            <header class="sticky top-0 z-30 border-b border-brand-950/10 bg-white/90 backdrop-blur">
                <div class="flex items-center gap-3 px-4 py-3.5 sm:px-6">
                    <button type="button" data-admin-sidebar-toggle class="grid h-10 w-10 place-items-center rounded-xl bg-brand-50 text-brand-700 ring-1 ring-brand-950/10 transition hover:bg-brand-100 lg:hidden" aria-label="Buka menu">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="h-5 w-5"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>

                    <div class="min-w-0">
                        <p class="truncate font-display text-lg font-semibold">@yield('title', 'Panel Admin')</p>
                    </div>

                    <div class="ml-auto flex items-center gap-2">
                        <div class="relative">
                            <button type="button" data-admin-notif-toggle
                                class="relative grid h-10 w-10 place-items-center rounded-xl bg-brand-50 text-brand-700 ring-1 ring-brand-950/10 transition hover:bg-brand-100" aria-label="Notifikasi">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                                <span data-admin-notif-badge class="absolute right-1.5 top-1.5 hidden min-w-4 rounded-full bg-rose-500 px-1 text-center text-[0.6rem] font-bold leading-4 text-white ring-2 ring-white"></span>
                            </button>
                            <div data-admin-notif-dropdown class="absolute right-0 top-12 z-50 hidden w-80 overflow-hidden rounded-2xl bg-white text-brand-950 shadow-2xl ring-1 ring-brand-950/10">
                                <div class="flex items-center justify-between border-b border-brand-950/10 bg-cream-50 px-4 py-3">
                                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-brand-600">Notifikasi</p>
                                    <a href="{{ route('admin.notifications') }}" class="text-xs font-semibold text-brand-700 hover:underline">Lihat Semua</a>
                                </div>
                                <div data-admin-notif-list class="max-h-80 overflow-y-auto"></div>
                            </div>
                        </div>
                        <a href="{{ route('admin.chat') }}"
                            class="relative hidden h-10 w-10 place-items-center rounded-xl bg-brand-50 text-brand-700 ring-1 ring-brand-950/10 transition hover:bg-brand-100 sm:grid" aria-label="Chat">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2Z"/></svg>
                            <span data-admin-chat-topbadge class="absolute right-1.5 top-1.5 hidden h-2.5 w-2.5 rounded-full bg-rose-500 ring-2 ring-white"></span>
                        </a>
                    </div>
                </div>
            </header>

            <main class="mx-auto w-full max-w-6xl px-4 py-8 sm:px-6">
                @yield('content')
            </main>
        </div>
    </body>
</html>