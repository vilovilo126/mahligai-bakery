<section id="kontak" class="scroll-mt-20 bg-cream-50 pb-24 pt-4 sm:pb-28">
    <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="reveal reveal-scale relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-brand-800 via-brand-900 to-brand-950 px-6 py-16 text-center text-white shadow-soft sm:px-12 lg:py-20">
            <div class="pointer-events-none absolute inset-0 bg-dots opacity-30"></div>
            <div class="anim-blob pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full bg-brand-500/30 blur-3xl"></div>
            <div class="anim-blob pointer-events-none absolute -bottom-28 -left-28 h-72 w-72 rounded-full bg-emerald-400/20 blur-3xl" style="animation-delay:-8s"></div>

            <div class="relative mx-auto max-w-2xl">
                <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.24em] text-brand-200 backdrop-blur">
                    <span class="h-1.5 w-1.5 rounded-full bg-amber-400"></span>
                    Pesanan Di antar & Pre-order
                </span>
                <h2 class="mt-6 font-display text-3xl font-semibold leading-tight tracking-tight sm:text-4xl">
                    Siap Tergoda? Pesan<br class="hidden sm:block">
                    <span class="text-gradient-cream">Camilan Hangat Anda</span>
                </h2>
                <p class="mx-auto mt-5 max-w-xl text-base leading-relaxed text-white/70">
                    Hubungi kami melalui WhatsApp untuk bertanya, pre-order, atau memesan dalam jumlah besar.
                    Tim kami siap membantu setiap hari mulai pukul 07.00 WITA.
                </p>

                <div class="mt-9 flex flex-col items-center justify-center gap-3.5 sm:flex-row">
                    <a href="https://wa.me/{{ config('business.whatsapp_number') }}?text={{ rawurlencode(config('business.wa_order_message')) }}"
                        target="_blank" rel="noopener"
                        class="btn-gradient inline-flex w-full items-center justify-center gap-2.5 rounded-full bg-gradient-to-r from-emerald-500 to-emerald-600 px-8 py-4 text-sm font-semibold shadow-lg shadow-emerald-900/40 sm:w-auto">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                            <path d="M12 2a9.9 9.9 0 0 0-8.5 14.9L2 22l5.3-1.4A10 10 0 1 0 12 2Zm5.1 14.1c-.2.6-1.2 1.2-1.7 1.2-.5.1-1 .2-3.3-.7-2.8-1.1-4.6-4-4.7-4.2-.1-.2-1.1-1.5-1.1-2.9s.7-2 1-2.3c.2-.3.5-.3.7-.3h.5c.2 0 .4 0 .6.5l.9 2.2c.1.2.1.4 0 .6l-.4.6-.5.5c-.2.2-.3.4-.1.7.2.3.8 1.4 1.8 2.3 1.3 1.2 2.3 1.5 2.7 1.7.3.2.5.1.7-.1l1-1.2c.2-.3.4-.2.7-.1l2.2 1c.3.2.5.3.6.4.1.2.1.6-.1 1Z"/>
                        </svg>
                        Chat via WhatsApp
                    </a>
                    <a href="https://wa.me/{{ config('business.whatsapp_number') }}" target="_blank" rel="noopener"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-full border border-white/25 bg-white/5 px-8 py-4 text-sm font-semibold backdrop-blur transition hover:border-white/50 hover:bg-white/10 sm:w-auto">
                        {{ config('business.whatsapp_display') }}
                    </a>
                </div>

                <div class="mt-8 flex flex-wrap items-center justify-center gap-x-8 gap-y-3 text-xs text-white/55">
                    <span class="inline-flex items-center gap-2">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4 text-brand-300"><path d="M12 21s-7-5.5-7-11a7 7 0 1 1 14 0c0 5.5-7 11-7 11Z"/></svg>
                        {{ config('business.address') }}
                    </span>
                    <span class="inline-flex items-center gap-2">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4 text-brand-300"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                        {{ config('business.hours') }}
                    </span>
                    <span class="inline-flex items-center gap-2">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4 text-brand-300"><path d="M12 2l2 7.5L21.5 12 14 14.5 12 22l-2-7.5L2.5 12 10 9.5 12 2z"/></svg>
                        {{ config('business.price_range') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>