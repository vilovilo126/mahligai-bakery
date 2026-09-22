@php
    $keunggulan = [
        [
            'icon' => '<path d="M12 2l2 7.5L21.5 12 14 14.5 12 22l-2-7.5L2.5 12 10 9.5 12 2z"/><circle cx="17.5" cy="4" r="2.5"/>',
            'title' => 'Fresh Setiap Hari',
            'desc' => 'Roti dan kue dipanggang segar setiap pagi, langsung dari oven dapur kami.',
            'tone' => 'bg-amber-100 text-amber-600',
        ],
        [
            'icon' => '<path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>',
            'title' => 'Bahan Berkualitas',
            'desc' => 'Tepung premium, cokelat Belgia, dan mentega tawar asli untuk rasa yang konsisten.',
            'tone' => 'bg-emerald-100 text-emerald-700',
        ],
        [
            'icon' => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/>',
            'title' => 'Banyak Pilihan Roti',
            'desc' => 'Dari roti unyil, roti sisir, aneka roti, hingga roti tawar yang lengkap setiap hari.',
            'tone' => 'bg-brand-100 text-brand-700',
        ],
        [
            'icon' => '<path d="M9 5H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-5"/><rect x="9" y="3" width="6" height="4" rx="1"/><path d="M8 12h8M8 16h5"/>',
            'title' => 'Bisa Request Kebutuhan',
            'desc' => 'Pesan varian khusus atau kebutuhan acara Anda melalui layanan pre-order kami.',
            'tone' => 'bg-sky-100 text-sky-700',
        ],
        [
            'icon' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
            'title' => 'Pelayanan Pelanggan',
            'desc' => 'Tim kami sigap membantu memilih, memesan, dan merespons kebutuhan Anda.',
            'tone' => 'bg-rose-100 text-rose-600',
        ],
        [
            'icon' => '<path d="M12 21s-7-5.5-7-11a7 7 0 1 1 14 0c0 5.5-7 11-7 11Z"/><circle cx="12" cy="10" r="2.5"/>',
            'title' => 'Suasana Ramah Keluarga',
            'desc' => 'Toko kami nyaman untuk waktu santai bersama orang tersayang di Denpasar.',
            'tone' => 'bg-violet-100 text-violet-600',
        ],
    ];
@endphp

<section id="unggulan" class="scroll-mt-20 bg-cream-50 py-20 sm:py-24 lg:py-28">
    <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading eyebrow="Keunggulan" center
            description="Apa yang membuat Mahligai Bakery berbeda — dan dicintai pelanggan setiap hari.">
            Kenapa Pelanggan Memilih Kami
        </x-section-heading>

        <div class="mt-14 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($keunggulan as $index => $item)
                <div class="reveal reveal-up group rounded-3xl bg-white p-7 shadow-soft ring-1 ring-brand-950/5 transition hover:shadow-xl"
                    style="--reveal-delay:{{ $index * 0.07 }}s">
                    <span class="grid h-12 w-12 place-items-center rounded-2xl {{ $item['tone'] }} transition-transform duration-300 group-hover:scale-110 group-hover:-rotate-3">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">{!! $item['icon'] !!}</svg>
                    </span>
                    <h3 class="mt-5 font-display text-lg font-semibold text-brand-950">{{ $item['title'] }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-brand-950/60">{{ $item['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>