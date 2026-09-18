@php
    $items = ['Roti Sourdough', 'Croissant', 'Cake & Dessert', 'Donat', 'Cookies', 'Pastry', 'Brownies', 'Cinnamon Roll'];
@endphp

<div class="relative overflow-hidden border-y border-white/10 bg-brand-900 py-4 text-white">
    <div class="marquee-track anim-marquee items-center gap-8">
        @for ($i = 0; $i < 2; $i++)
            @foreach ($items as $item)
                <span class="inline-flex shrink-0 items-center gap-8">
                    <span class="font-display text-sm font-semibold uppercase tracking-[0.2em] text-white/80">{{ $item }}</span>
                    <svg viewBox="0 0 24 24" fill="currentColor" class="h-3.5 w-3.5 text-brand-400"><path d="M12 3l2.9 6.6 7.1.6-5.4 4.7 1.6 7L12 17l-6.2 3.9 1.6-7L2 9.2l7.1-.6L12 3z"/></svg>
                </span>
            @endforeach
        @endfor
    </div>
</div>