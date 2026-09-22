<section id="cerita" class="scroll-mt-20 bg-white py-20 sm:py-24 lg:py-28">
    <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading eyebrow="Cerita Kami" center
            description="Di balik setiap roti yang keluar dari oven, ada kisah tentang kesabaran, ketelitian, dan cinta terhadap cita rasa.">
            Perjalanan Rasa dari Dapur Mahligai
        </x-section-heading>

        <div class="mt-14 grid grid-cols-1 items-center gap-12 lg:grid-cols-2 lg:gap-20">
            {{-- Visual --}}
            <div class="reveal reveal-left relative mx-auto w-full max-w-md lg:max-w-none">
                <div class="absolute -left-6 -top-6 h-36 w-36 rounded-3xl bg-brand-100"></div>
                <div class="absolute -bottom-6 -right-6 h-44 w-44 rounded-[2rem] bg-amber-200/70"></div>

                <img src="{{ asset('images/about/about-baker.svg') }}" alt="Cerita Mahligai Bakery"
                    class="relative z-10 aspect-[4/5] w-full rounded-[2.5rem] object-cover shadow-soft ring-1 ring-brand-950/10">

                <div class="glass absolute bottom-10 left-1/2 z-20 w-max max-w-[15rem] -translate-x-1/2 whitespace-normal rounded-2xl px-6 py-4 text-center text-brand-950 shadow-xl">
                    <p class="font-display text-base font-semibold leading-snug">&ldquo;Dibuat segar hari ini, dengan hati.&rdquo;</p>
                </div>
            </div>

            {{-- Cerita --}}
            <div class="reveal reveal-right space-y-6 text-base leading-relaxed text-brand-950/70">
                <p>
                    Mahligai Bakery lahir dari alasan sederhana: setiap orang berhak menikmati roti yang
                    hangat, lembut, dan dibuat dari bahan-bahan terbaik. Dari dapur kecil di Denpasar, kami
                    mulai meracik adonan setiap pagi — menunggu ragi bekerja, memanggang dengan api yang
                    tepat, dan menyajikan aroma yang menggugah selera.
                </p>
                <p>
                    Kami percaya kualitas tidak bisa dipaksakan. Karena itu setiap resep kami pelajari
                    berulang kali, bahan pilihan kami datangkan langsung, dan proses pembuatan kami jaga
                    tetap sederhana namun penuh perhatian. Hasilnya adalah roti yang konsisten lembut,
                    manis, dan menyenangkan di setiap gigitan.
                </p>
                <p>
                    Saat Anda berbelanja di Mahligai Bakery, Anda bukan sekadar membeli roti — Anda menjadi
                    bagian dari cerita kami. Cerita tentang keluarga, tentang pagi yang hangat, dan tentang
                    cara terbaik merayakan momen kecil bersama orang tersayang.
                </p>

                <div class="mt-8 flex flex-col gap-4 border-t border-brand-950/10 pt-8 sm:flex-row sm:gap-8">
                    <div class="flex items-start gap-3.5">
                        <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-brand-600/10 text-brand-700">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="M12 2l2 7.5L21.5 12 14 14.5 12 22l-2-7.5L2.5 12 10 9.5 12 2z"/></svg>
                        </span>
                        <p class="text-sm leading-relaxed text-brand-950/70"><strong class="font-semibold text-brand-950">Terbukti kualitas.</strong> Segar, lembut, dan konsisten setiap hari.</p>
                    </div>
                    <div class="flex items-start gap-3.5">
                        <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-brand-600/10 text-brand-700">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </span>
                        <p class="text-sm leading-relaxed text-brand-950/70"><strong class="font-semibold text-brand-950">Pelayanan hangat.</strong> Kami bantu Anda menemukan camilan favorit.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>