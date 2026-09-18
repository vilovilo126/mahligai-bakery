@php
    $days = [
        1 => 'Senin',
        2 => 'Selasa',
        3 => 'Rabu',
        4 => 'Kamis',
        5 => 'Jumat',
        6 => 'Sabtu',
        0 => 'Minggu',
    ];
@endphp

<section id="lokasi" class="scroll-mt-20 bg-white py-20 sm:py-24 lg:py-28">
    <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading eyebrow="Lokasi & Jam Operasional"
            description="Di tengah kenyamanan Kota Denpasar. Mampirlah untuk menikmati aroma roti segar langsung dari oven kami.">
            Temukan Kami di Denpasar
        </x-section-heading>

        <div class="mt-12 grid grid-cols-1 gap-8 lg:grid-cols-5">
            {{-- Info panel --}}
            <div class="flex flex-col gap-8 lg:col-span-2">
                <div class="reveal reveal-left rounded-3xl bg-cream-50 p-7 ring-1 ring-brand-950/5">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <h3 class="font-display text-lg font-semibold text-brand-950">Jam Operasional</h3>
                        <span id="open-status" data-open="420" data-close="1320"
                            class="inline-flex items-center gap-2 rounded-full bg-brand-950/5 px-3.5 py-1.5 text-xs font-bold uppercase tracking-wider text-brand-800">
                            <span class="status-dot h-2 w-2 rounded-full"></span>
                            <span data-status-label>—</span>
                            <span class="font-normal text-brand-950/50" data-status-time></span>
                        </span>
                    </div>

                    <ul class="mt-6 space-y-1.5">
                        @foreach ($days as $dayNumber => $dayName)
                            <li class="hours-row flex items-center justify-between px-3 py-2 text-sm" data-day="{{ $dayNumber }}">
                                <span class="font-medium text-brand-950/80">{{ $dayName }}</span>
                                <span class="text-brand-950/55">07.00 — 22.00 WITA</span>
                            </li>
                        @endforeach
                    </ul>

                    <p class="mt-5 text-xs leading-relaxed text-brand-950/45">
                        Buka setiap hari, termasuk hari libur nasional.
                    </p>
                </div>

                <div class="reveal reveal-left rounded-3xl bg-gradient-to-br from-brand-800 to-brand-950 p-7 text-white shadow-soft" style="--reveal-delay:.12s">
                    <div class="flex items-start gap-4">
                        <span class="grid h-11 w-11 shrink-0 place-items-center rounded-2xl bg-white/10 ring-1 ring-white/20">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5"><path d="M12 21s-7-5.5-7-11a7 7 0 1 1 14 0c0 5.5-7 11-7 11Z"/><circle cx="12" cy="10" r="2.5"/></svg>
                        </span>
                        <div>
                            <h3 class="font-display text-lg font-semibold">Alamat Toko</h3>
                            <p class="mt-2 text-sm leading-relaxed text-white/70">
                                Jl. Tukad Barito Timur No.99, Renon,<br>
                                Denpasar Selatan, Kota Denpasar,<br>
                                Bali 80226
                            </p>
                            <a href="https://www.google.com/maps/search/?api=1&query=Jl.+Tukad+Barito+Timur+No.99+Renon+Denpasar+Bali"
                                target="_blank" rel="noopener"
                                class="mt-4 inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-xs font-semibold ring-1 ring-white/20 transition hover:bg-white/20">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-3.5 w-3.5"><path d="M9 18l-6 4M15 18l6 4M8 17.5A8 8 0 1 1 16 17.5L14 20a2 2 0 0 1-4 0l-2-2.5Z"/></svg>
                                Buka di Google Maps
                            </a>
                        </div>
                    </div>
                </div>

                <div class="reveal reveal-left flex items-center gap-4 rounded-3xl border border-brand-950/5 bg-white p-6 shadow-soft" style="--reveal-delay:.22s">
                    <span class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-amber-100 text-amber-600">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5"><path d="M12 2a9.9 9.9 0 0 0-8.5 14.9L2 22l5.3-1.4A10 10 0 1 0 12 2Zm5.1 14.1c-.2.6-1.2 1.2-1.7 1.2-.5.1-1 .2-3.3-.7-2.8-1.1-4.6-4-4.7-4.2-.1-.2-1.1-1.5-1.1-2.9s.7-2 1-2.3c.2-.3.5-.3.7-.3h.5c.2 0 .4 0 .6.5l.9 2.2c.1.2.1.4 0 .6l-.4.6-.5.5c-.2.2-.3.4-.1.7.2.3.8 1.4 1.8 2.3 1.3 1.2 2.3 1.5 2.7 1.7.3.2.5.1.7-.1l1-1.2c.2-.3.4-.2.7-.1l2.2 1c.3.2.5.3.6.4.1.2.1.6-.1 1Z"/></svg>
                    </span>
                    <p class="text-sm leading-relaxed text-brand-950/70">
                        <strong class="font-semibold text-brand-950">Pre-order tersedia via WhatsApp.</strong>
                        Persiapkan pesanan Anda sebelum berkunjung.
                    </p>
                </div>
            </div>

            {{-- Map --}}
            <div class="reveal reveal-right overflow-hidden rounded-[2rem] shadow-soft ring-1 ring-brand-950/5 lg:col-span-3">
                <div class="img-zoom relative h-full min-h-[22rem]">
                    <iframe
                        src="https://maps.google.com/maps?q=Jl.%20Tukad%20Barito%20Timur%20No.99%2C%20Renon%2C%20Denpasar%20Selatan%2C%20Bali%2080226&z=15&output=embed&hl=id"
                        title="Lokasi Mahligai Bakery di Google Maps"
                        class="h-full w-full border-0"
                        loading="lazy"
                        allowfullscreen
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>