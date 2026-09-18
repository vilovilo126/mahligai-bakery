<section id="tentang" class="relative scroll-mt-20 overflow-hidden bg-cream-50 py-20 sm:py-24 lg:py-28">
    <div class="pointer-events-none absolute inset-0 bg-dots-dark opacity-50"></div>

    <div class="relative mx-auto grid w-full max-w-7xl grid-cols-1 items-center gap-14 px-4 sm:px-6 lg:grid-cols-2 lg:gap-20 lg:px-8">
        {{-- Visual --}}
        <div class="reveal reveal-left relative order-2 mx-auto w-full max-w-md lg:order-1 lg:max-w-none">
            <div class="absolute -left-8 -top-8 h-40 w-40 rounded-3xl bg-brand-100"></div>
            <div class="absolute -bottom-8 -right-8 h-48 w-48 rounded-[2rem] bg-amber-200/70"></div>

            <img src="{{ asset('images/about/about-baker.svg') }}" alt="Pembuat roti Mahligai Bakery"
                class="relative z-10 aspect-[4/5] w-full rounded-[2.5rem] object-cover shadow-soft ring-1 ring-brand-950/10">

            <div class="glass absolute -bottom-7 left-1/2 z-20 flex -translate-x-1/2 items-center gap-4 whitespace-nowrap rounded-2xl px-6 py-4 text-brand-950 shadow-xl">
                <span class="font-display text-4xl font-bold text-gradient-green">7</span>
                <span class="text-sm font-medium leading-tight text-brand-950/70">
                    Tahun Pengalaman<br>Memanggang dengan Cinta
                </span>
            </div>
        </div>

        {{-- Copy --}}
        <div class="order-1 lg:order-2">
            <x-section-heading eyebrow="Tentang Kami"
                description="Mahligai Bakery berdiri dari kecintaan terhadap olahan roti dan kue yang otentik. Kami memadukan teknik artisan dengan bahan-bahan segar pilihan untuk menciptakan rasa yang hangat dan istimewa di setiap gigitan.">
                Kisah Rasa Hangat<br class="hidden sm:block"> dari Dapur Kami
            </x-section-heading>

            <ul class="mt-9 grid grid-cols-1 gap-4 sm:grid-cols-2">
                <li class="reveal reveal-up flex items-start gap-3.5" style="--reveal-delay:.1s">
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-brand-600/10 text-brand-700">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="M12 2l2 7.5L21.5 12 14 14.5 12 22l-2-7.5L2.5 12 10 9.5 12 2z"/></svg>
                    </span>
                    <p class="text-sm leading-relaxed text-brand-950/70"><strong class="font-semibold text-brand-950">Bahan Pilihan.</strong> Tepung premium, cokelat Belgia, dan mentega tawar asli.</p>
                </li>
                <li class="reveal reveal-up flex items-start gap-3.5" style="--reveal-delay:.2s">
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-brand-600/10 text-brand-700">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                    </span>
                    <p class="text-sm leading-relaxed text-brand-950/70"><strong class="font-semibold text-brand-950">Selalu Segar.</strong> Dipanggang fresh setiap hari, langsung dari oven dapur kami.</p>
                </li>
                <li class="reveal reveal-up flex items-start gap-3.5" style="--reveal-delay:.3s">
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-brand-600/10 text-brand-700">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </span>
                    <p class="text-sm leading-relaxed text-brand-950/70"><strong class="font-semibold text-brand-950">Pelayanan Hangat.</strong> Tim kami siap membantu Anda memilih camilan favorit.</p>
                </li>
                <li class="reveal reveal-up flex items-start gap-3.5" style="--reveal-delay:.4s">
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-brand-600/10 text-brand-700">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="M12 2a5 5 0 0 1 5 5c0 2-2 3-2 5h-6c0-2-2-3-2-5a5 5 0 0 1 5-5Z"/><path d="M12 22c-2 0-3-1-3-2h6c0 1-1 2-3 2Z"/></svg>
                    </span>
                    <p class="text-sm leading-relaxed text-brand-950/70"><strong class="font-semibold text-brand-950">Ramah Keluarga.</strong> Suasana nyaman untuk waktu santai bersama orang tersayang.</p>
                </li>
            </ul>

            <a href="https://wa.me/{{ config('business.whatsapp_number') }}" target="_blank" rel="noopener"
                class="reveal reveal-up mt-10 inline-flex items-center gap-2 rounded-full border-2 border-brand-600 px-7 py-3 text-sm font-semibold text-brand-700 transition hover:bg-brand-600 hover:text-white"
                style="--reveal-delay:.5s">
                Cerita Kami Lebih Lanjut
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="relative mx-auto mt-20 max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 gap-x-6 gap-y-10 rounded-[2rem] border border-brand-950/5 bg-white px-6 py-10 text-center shadow-soft sm:grid-cols-4 sm:px-10">
            <div class="reveal reveal-scale">
                <p class="font-display text-4xl font-bold text-gradient-green" data-count="{{ $menuVariantCount }}">0</p>
                <p class="mt-2 text-xs font-semibold uppercase tracking-wider text-brand-950/50">Varian Menu</p>
            </div>
            <div class="reveal reveal-scale" style="--reveal-delay:.1s">
                <p class="font-display text-4xl font-bold text-gradient-green" data-count="4.6" data-decimals="1">0</p>
                <p class="mt-2 text-xs font-semibold uppercase tracking-wider text-brand-950/50">Rating Pelanggan</p>
            </div>
            <div class="reveal reveal-scale" style="--reveal-delay:.2s">
                <p class="font-display text-4xl font-bold text-gradient-green" data-count="195">0</p>
                <p class="mt-2 text-xs font-semibold uppercase tracking-wider text-brand-950/50">Ulasan Terpercaya</p>
            </div>
            <div class="reveal reveal-scale" style="--reveal-delay:.3s">
                <p class="font-display text-4xl font-bold text-gradient-green" data-count="15">0</p>
                <p class="mt-2 text-xs font-semibold uppercase tracking-wider text-brand-950/50">Jam Buka per Hari</p>
            </div>
        </div>
    </div>
</section>