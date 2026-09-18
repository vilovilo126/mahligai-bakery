<section id="beranda"
    class="relative flex min-h-screen items-center overflow-hidden bg-gradient-to-br from-brand-900 via-brand-950 to-[#0a1a10] pb-16 pt-32 text-white lg:pb-24">
    {{-- Decorative background --}}
    <div class="pointer-events-none absolute inset-0 bg-dots opacity-40"></div>
    <div class="anim-blob pointer-events-none absolute -right-40 -top-40 h-[34rem] w-[34rem] rounded-full bg-brand-500/25 blur-3xl"></div>
    <div class="anim-blob pointer-events-none absolute -bottom-48 -left-24 h-[30rem] w-[30rem] rounded-full bg-emerald-400/15 blur-3xl" style="animation-delay:-8s"></div>

    <div class="relative mx-auto grid w-full max-w-7xl grid-cols-1 items-center gap-14 px-4 sm:px-6 lg:grid-cols-2 lg:gap-10 lg:px-8">
        {{-- Copy --}}
        <div class="text-center lg:text-left">
            <span class="anim-fade-up inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.24em] text-brand-200 backdrop-blur"
                style="animation-delay:0.05s">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                Bakery Premium di Bali
            </span>

            <h1 class="anim-fade-up mt-6 font-display text-4xl font-semibold leading-[1.12] tracking-tight sm:text-5xl lg:text-[3.6rem]"
                style="animation-delay:0.15s">
                Rasa Hangat,<br>
                <span class="text-gradient-cream">Kualitas Istimewa</span>
            </h1>

            <p class="anim-fade-up mx-auto mt-6 max-w-xl text-base leading-relaxed text-white/70 sm:text-lg lg:mx-0"
                style="animation-delay:0.28s">
                Di Mahligai Bakery, setiap kue dan roti dipanggang segar setiap hari dengan bahan-bahan pilihan.
                Temukan camilan favorit Anda — dari sourdough artisan hingga cream cake lembut yang meleleh di mulut.
            </p>

            <div class="anim-fade-up mt-9 flex flex-col items-center gap-3.5 sm:flex-row sm:justify-center lg:justify-start"
                style="animation-delay:0.4s">
                <a href="#produk"
                    class="btn-gradient group inline-flex w-full items-center justify-center gap-2 rounded-full px-7 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand-900/40 sm:w-auto">
                    Lihat Produk
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="h-4 w-4 transition-transform duration-300 group-hover:translate-y-0.5">
                        <path d="M12 5v14m-7-7 7 7 7-7"/>
                    </svg>
                </a>
                <a href="#tentang"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-full border border-white/25 bg-white/5 px-7 py-3.5 text-sm font-semibold text-white backdrop-blur transition hover:border-white/50 hover:bg-white/10 sm:w-auto">
                    Tentang Kami
                </a>
            </div>

            {{-- Quick facts --}}
            <div class="anim-fade-up mt-12 hidden grid-cols-3 gap-6 border-t border-white/10 pt-7 text-left lg:grid"
                style="animation-delay:0.55s">
                <div>
                    <p class="font-display text-2xl font-bold">12+</p>
                    <p class="mt-1 text-xs uppercase tracking-wider text-white/50">Varian Produk</p>
                </div>
                <div>
                    <p class="font-display text-2xl font-bold">4,6/5</p>
                    <p class="mt-1 text-xs uppercase tracking-wider text-white/50">Rating Pelanggan</p>
                </div>
                <div>
                    <p class="font-display text-2xl font-bold">07.00</p>
                    <p class="mt-1 text-xs uppercase tracking-wider text-white/50">Buka Setiap Hari</p>
                </div>
            </div>
        </div>

        {{-- Visual --}}
        <div class="anim-fade-in relative mx-auto w-full max-w-md lg:max-w-none" style="animation-delay:0.3s">
            <div class="relative aspect-square">
                <img src="{{ asset('images/hero/hero-bakery.svg') }}" alt="Koleksi produk Mahligai Bakery"
                    class="anim-float relative z-10 h-full w-full rounded-[2.5rem] object-cover shadow-2xl shadow-brand-950/50 ring-1 ring-white/20">

                {{-- Floating rating card --}}
                <div class="glass anim-float-sm absolute -left-4 top-10 z-20 flex items-center gap-3 rounded-2xl px-4 py-3 text-brand-950 shadow-xl sm:-left-8"
                    style="animation-delay:-1.5s">
                    <span class="grid h-10 w-10 place-items-center rounded-full bg-amber-300">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-amber-950"><path d="M12 2l2.9 6.6 7.1.6-5.4 4.7 1.6 7L12 17l-6.2 3.9 1.6-7L2 9.2l7.1-.6L12 2z"/></svg>
                    </span>
                    <div>
                        <p class="font-display text-lg font-bold leading-none">4,6 / 5</p>
                        <p class="mt-1 text-[0.68rem] uppercase tracking-wide text-brand-950/60">195+ ulasan pelanggan</p>
                    </div>
                </div>

                {{-- Floating badge --}}
                <div class="glass anim-float-sm absolute -right-3 bottom-16 z-20 flex items-center gap-3 rounded-2xl px-4 py-3 text-brand-950 shadow-xl sm:-right-6"
                    style="animation-delay:.5s">
                    <span class="grid h-10 w-10 place-items-center rounded-full bg-brand-100">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5 text-brand-700"><path d="M12 2l2 7.5L21.5 12 14 14.5 12 22l-2-7.5L2.5 12 10 9.5 12 2z"/></svg>
                    </span>
                    <div>
                        <p class="font-display text-lg font-bold leading-none">100% Segar</p>
                        <p class="mt-1 text-[0.68rem] uppercase tracking-wide text-brand-950/60">Dipanggang setiap hari</p>
                    </div>
                </div>

                {{-- Floating open badge --}}
                <div class="glass-dark anim-float-sm absolute bottom-4 left-1/2 z-20 -translate-x-1/2 rounded-full px-5 py-2.5 text-sm font-semibold text-white shadow-xl"
                    style="animation-delay:1s">
                    <span class="mr-2 inline-block h-2 w-2 rounded-full bg-emerald-400"></span>
                    Buka Setiap Hari · 07.00 – 22.00 WITA
                </div>
            </div>
        </div>
    </div>

    {{-- Scroll hint --}}
    <a href="#tentang" class="absolute bottom-5 left-1/2 hidden -translate-x-1/2 flex-col items-center gap-1.5 text-white/40 transition hover:text-white lg:flex"
        aria-label="Gulir ke bawah">
        <span class="text-[0.65rem] font-semibold uppercase tracking-[0.3em]">Scroll</span>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 animate-bounce"><path d="M12 5v14m-7-7 7 7 7-7"/></svg>
    </a>
</section>