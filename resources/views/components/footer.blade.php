<footer class="relative overflow-hidden bg-brand-950 pt-16 text-white">
    <div class="pointer-events-none absolute -left-24 -top-24 h-72 w-72 rounded-full bg-brand-600/10 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-32 right-0 h-80 w-80 rounded-full bg-emerald-500/10 blur-3xl"></div>

    <div class="relative mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-12 pb-12 sm:grid-cols-2 lg:grid-cols-4">
            <div class="sm:col-span-2 lg:col-span-2">
                <x-brand-mark class="text-white" />
                <p class="mt-5 max-w-md text-sm leading-relaxed text-white/60">
                    Toko roti & bakery premium di Denpasar, Bali. Setiap camilan kami dibuat dengan bahan berkualitas
                    dan penuh cinta untuk menghadirkan rasa hangat yang istimewa setiap hari.
                </p>
                <div class="mt-6 flex items-center gap-3">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/5 text-white/70 ring-1 ring-white/10 transition hover:bg-white/10" title="Rating Google">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4"><path d="M12 2l2.9 6.6 7.1.6-5.4 4.7 1.6 7L12 17l-6.2 3.9 1.6-7L2 9.2l7.1-.6L12 2z"/></svg>
                    </span>
                    <span class="text-sm">
                        <strong class="font-display">4,6/5</strong>
                        <span class="text-white/50">· dari 195 ulasan</span>
                    </span>
                </div>
            </div>

            <div>
                <h3 class="text-xs font-bold uppercase tracking-[0.24em] text-white/40">Menu</h3>
                <ul class="mt-5 space-y-3 text-sm">
                    <li><a href="#beranda" class="text-white/65 transition hover:text-white">Beranda</a></li>
                    <li><a href="#tentang" class="text-white/65 transition hover:text-white">Tentang Kami</a></li>
                    <li><a href="#cerita" class="text-white/65 transition hover:text-white">Cerita Kami</a></li>
                    <li><a href="#galeri" class="text-white/65 transition hover:text-white">Galeri</a></li>
                    <li><a href="#lokasi" class="text-white/65 transition hover:text-white">Lokasi</a></li>
                    <li><a href="#kontak" class="text-white/65 transition hover:text-white">Kontak</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-xs font-bold uppercase tracking-[0.24em] text-white/40">Kontak</h3>
                <ul class="mt-5 space-y-3 text-sm text-white/65">
                    <li class="flex items-start gap-3">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="mt-0.5 h-4 w-4 shrink-0 text-brand-400"><path d="M12 21s-7-5.5-7-11a7 7 0 1 1 14 0c0 5.5-7 11-7 11Z"/><circle cx="12" cy="10" r="2.5"/></svg>
                        <span>Jl. Tukad Barito Timur No.99,<br>Renon, Denpasar Selatan,<br>Bali 80226</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="mt-0.5 h-4 w-4 shrink-0 text-brand-400"><path d="M4 6h16v12H4z" rx="2"/><path d="m4 7 8 6 8-6"/></svg>
                        <a href="mailto:hello@mahligai-bakery.co.id" class="transition hover:text-white">hello@mahligai-bakery.co.id</a>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="mt-0.5 h-4 w-4 shrink-0 text-brand-400"><path d="M12 2a9.9 9.9 0 0 0-8.5 14.9L2 22l5.3-1.4A10 10 0 1 0 12 2Zm5.1 14.1c-.2.6-1.2 1.2-1.7 1.2-.5.1-1 .2-3.3-.7-2.8-1.1-4.6-4-4.7-4.2-.1-.2-1.1-1.5-1.1-2.9s.7-2 1-2.3c.2-.3.5-.3.7-.3h.5c.2 0 .4 0 .6.5l.9 2.2c.1.2.1.4 0 .6l-.4.6-.5.5c-.2.2-.3.4-.1.7.2.3.8 1.4 1.8 2.3 1.3 1.2 2.3 1.5 2.7 1.7.3.2.5.1.7-.1l1-1.2c.2-.3.4-.2.7-.1l2.2 1c.3.2.5.3.6.4.1.2.1.6-.1 1Z"/></svg>
                        <a href="https://wa.me/{{ config('business.whatsapp_number') }}" target="_blank" rel="noopener" class="transition hover:text-white">{{ config('business.whatsapp_display') }}</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="flex flex-col items-center justify-between gap-3 border-t border-white/10 py-6 text-xs text-white/45 sm:flex-row">
            <p>&copy; {{ date('Y') }} Mahligai Bakery. Seluruh hak cipta dilindungi.</p>
            <p>Rasa Hangat, Kualitas Istimewa</p>
        </div>
    </div>
</footer>