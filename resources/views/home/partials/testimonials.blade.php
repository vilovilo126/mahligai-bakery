<section id="testimoni" class="relative scroll-mt-20 overflow-hidden bg-gradient-to-b from-cream-100 to-cream-200 py-20 sm:py-24 lg:py-28">
    <div class="pointer-events-none absolute inset-0 bg-dots-dark opacity-40"></div>
    <div class="anim-blob pointer-events-none absolute -left-24 top-16 h-72 w-72 rounded-full bg-brand-200/60 blur-3xl"></div>

    <div class="relative mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading eyebrow="Kata Mereka"
            description="Pengalaman menyenangkan dari para pelanggan setia yang sudah merasakan hangatnya Mahligai Bakery."
            center>
            Apa Kata Pelanggan Kami
        </x-section-heading>

        <div class="mt-12" data-testimonials>
            <div class="overflow-hidden">
                <div data-testimonial-track class="flex">
                    @forelse ($testimonials as $testimonial)
                        <div data-testimonial-slide class="w-full shrink-0 px-3 sm:w-1/2 lg:w-1/3">
                            <figure class="flex h-full flex-col rounded-3xl bg-white p-7 shadow-soft ring-1 ring-brand-950/5">
                                <div class="flex items-center gap-1" aria-label="Rating {{ $testimonial->rating }} dari 5">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg viewBox="0 0 24 24" fill="currentColor"
                                            class="h-4 w-4 {{ $i <= $testimonial->rating ? 'text-amber-400' : 'text-brand-950/15' }}">
                                            <path d="M12 2l2.9 6.6 7.1.6-5.4 4.7 1.6 7L12 17l-6.2 3.9 1.6-7L2 9.2l7.1-.6L12 2z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <blockquote class="mt-4 flex-1 text-sm leading-relaxed text-brand-950/70">
                                    &ldquo;{{ $testimonial->comment }}&rdquo;
                                </blockquote>
                                <figcaption class="mt-6 flex items-center gap-3 border-t border-brand-950/5 pt-5">
                                    <span class="grid h-11 w-11 shrink-0 place-items-center overflow-hidden rounded-full bg-brand-100 ring-2 ring-white">
                                        <img src="{{ asset($testimonial->avatar) }}" alt="{{ $testimonial->name }}" loading="lazy" class="h-full w-full object-cover">
                                    </span>
                                    <div>
                                        <p class="font-display text-sm font-semibold text-brand-950">{{ $testimonial->name }}</p>
                                        <p class="text-xs text-brand-950/45">Pelanggan Bahagia</p>
                                    </div>
                                </figcaption>
                            </figure>
                        </div>
                    @empty
                        <p class="w-full px-4 py-16 text-center text-brand-950/50">Belum ada ulasan pelanggan.</p>
                    @endforelse
                </div>
            </div>

            <div class="mt-9 flex items-center justify-center gap-4">
                <button type="button" data-testimonial-prev
                    class="grid h-10 w-10 place-items-center rounded-full border border-brand-950/15 bg-white text-brand-800 transition hover:border-brand-600 hover:bg-brand-600 hover:text-white disabled:pointer-events-none disabled:opacity-35"
                    aria-label="Testimoni sebelumnya">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="m15 18-6-6 6-6"/></svg>
                </button>
                <div data-testimonial-dots class="flex items-center gap-2"></div>
                <button type="button" data-testimonial-next
                    class="grid h-10 w-10 place-items-center rounded-full border border-brand-950/15 bg-white text-brand-800 transition hover:border-brand-600 hover:bg-brand-600 hover:text-white disabled:pointer-events-none disabled:opacity-35"
                    aria-label="Testimoni berikutnya">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="m9 18 6-6-6-6"/></svg>
                </button>
            </div>
        </div>
    </div>
</section>