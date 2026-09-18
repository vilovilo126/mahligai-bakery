<section id="produk" class="scroll-mt-20 bg-white py-20 sm:py-24 lg:py-28">
    <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading eyebrow="Menu Kami" center
            description="Jelajahi katalog lengkap Mahligai Bakery — dari Roti Unyil mungil yang penuh rasa, Roti Sisir lembut yang jadi favorit, hingga aneka roti reguler dan roti tawar yang dibuat segar setiap hari.">
            Katalog Menu Mahligai Bakery
        </x-section-heading>

        {{-- Navigasi kategori --}}
        <div class="sticky top-16 z-30 -mx-4 mt-12 px-4 sm:mx-0 sm:px-0" data-menu-nav>
            <div class="glass flex gap-2 overflow-x-auto rounded-2xl p-2 shadow-soft ring-1 ring-brand-950/5 no-scrollbar">
                @foreach ($menuGroups as $group)
                    <a href="#menu-{{ $group['id'] }}" data-menu-link="{{ $group['id'] }}"
                        class="whitespace-nowrap rounded-xl px-5 py-2.5 text-sm font-semibold text-brand-800 transition hover:bg-brand-50 hover:text-brand-700">
                        {{ $group['nav'] }}
                    </a>
                @endforeach
            </div>
        </div>

        @foreach ($menuGroups as $group)
            @include('home.partials.menu-group', ['group' => $group, 'loopIndex' => $loop->index])
        @endforeach

        <p class="mt-14 text-center text-sm text-brand-950/45">
            Klik kartu produk untuk melihat detail varian, paket, dan additional.
        </p>
    </div>
</section>
