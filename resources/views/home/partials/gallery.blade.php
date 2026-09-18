<section id="galeri" class="scroll-mt-20 bg-cream-100 py-20 sm:py-24 lg:py-28">
    <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col items-start justify-between gap-8 sm:flex-row sm:items-end">
            <x-section-heading eyebrow="Galeri"
                description="Momen-momen hangat di balik mahligai kami — mulai dari proses memanggang hingga tampilan manis yang siap dinikmati.">
                Sekilas dari Toko Kami
            </x-section-heading>

            <a href="https://wa.me/{{ config('business.whatsapp_number') }}" target="_blank" rel="noopener"
                class="inline-flex shrink-0 items-center gap-2 rounded-full border-2 border-brand-600 px-6 py-3 text-sm font-semibold text-brand-700 transition hover:bg-brand-600 hover:text-white">
                Kunjungi Kami
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
            </a>
        </div>

        <div class="mt-12 columns-1 gap-6 sm:columns-2 lg:columns-3 [&>*]:mb-6">
            @forelse ($galleries as $index => $item)
                <figure data-gallery-item
                    data-image="{{ asset($item->image) }}"
                    data-title="{{ $item->title }}"
                    class="reveal reveal-up group cursor-pointer break-inside-avoid overflow-hidden rounded-3xl bg-white shadow-soft ring-1 ring-brand-950/5"
                    style="--reveal-delay:{{ min($index, 5) * 0.07 }}s">
                    <div class="img-zoom relative">
                        <img src="{{ asset($item->image) }}" alt="{{ $item->title }}" loading="lazy"
                            class="w-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-brand-950/60 via-transparent to-transparent opacity-0 transition-opacity duration-500 group-hover:opacity-100"></div>
                        <div class="absolute inset-x-0 bottom-0 translate-y-3 p-5 opacity-0 transition-all duration-500 group-hover:translate-y-0 group-hover:opacity-100">
                            <span class="inline-flex items-center gap-2 rounded-full bg-white/90 px-3 py-1 text-[0.65rem] font-semibold uppercase tracking-wider text-brand-700 backdrop-blur">
                                <span class="h-1.5 w-1.5 rounded-full bg-brand-500"></span>
                                {{ $item->category }}
                            </span>
                            <figcaption class="mt-2 font-display text-base font-semibold text-white">{{ $item->title }}</figcaption>
                        </div>
                        <span class="absolute right-4 top-4 grid h-9 w-9 place-items-center rounded-full bg-white/20 text-white opacity-0 backdrop-blur transition group-hover:opacity-100"
                            aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        </span>
                    </div>
                </figure>
            @empty
                <p class="px-4 py-16 text-center text-brand-950/50">Galeri sedang diperbarui — kembali lagi nanti.</p>
            @endforelse
        </div>
    </div>

    {{-- Lightbox --}}
    <div id="gallery-lightbox" class="fixed inset-0 z-[60] hidden items-center justify-center p-4 sm:p-6"
        role="dialog" aria-modal="true" aria-label="Tampilan galeri">
        <div class="lightbox-backdrop absolute inset-0 bg-brand-950/80 backdrop-blur-sm"></div>

        <button type="button" data-lightbox-close
            class="absolute right-5 top-5 z-10 grid h-11 w-11 place-items-center rounded-full bg-white/10 text-white ring-1 ring-white/20 transition hover:bg-white/20"
            aria-label="Tutup galeri">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="h-5 w-5"><path d="M18 6 6 18M6 6l12 12"/></svg>
        </button>

        <button type="button" data-lightbox-prev
            class="absolute left-3 top-1/2 z-10 grid h-12 w-12 -translate-y-1/2 place-items-center rounded-full bg-white/10 text-white ring-1 ring-white/20 transition hover:bg-white/20 sm:left-6"
            aria-label="Gambar sebelumnya">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6"><path d="m15 18-6-6 6-6"/></svg>
        </button>
        <button type="button" data-lightbox-next
            class="absolute right-3 top-1/2 z-10 grid h-12 w-12 -translate-y-1/2 place-items-center rounded-full bg-white/10 text-white ring-1 ring-white/20 transition hover:bg-white/20 sm:right-6"
            aria-label="Gambar berikutnya">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6"><path d="m9 18 6-6-6-6"/></svg>
        </button>

        <figure class="relative z-10 flex max-h-full w-full max-w-4xl flex-col gap-3">
            <img data-lightbox-image src="" alt="" class="max-h-[72vh] w-full rounded-2xl object-contain shadow-2xl">
            <figcaption class="flex items-center justify-between px-1 text-sm text-white/85">
                <span data-lightbox-title class="font-display font-medium"></span>
                <span data-lightbox-counter class="shrink-0 text-white/55"></span>
            </figcaption>
        </figure>
    </div>
</section>