@props(['href' => '#beranda'])

<a href="{{ $href }}" class="group inline-flex items-center gap-3" aria-label="Mahligai Bakery">
    <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-brand-400 to-brand-800 shadow-md shadow-brand-950/30 transition-transform duration-300 group-hover:scale-105">
        <svg viewBox="0 0 24 24" fill="none" class="h-6 w-6">
            <path d="M4 17.5C4 11.5 8 8 12 8C16 8 20 11.5 20 17.5C20 18.3 16.7 19 12 19C7.3 19 4 18.3 4 17.5Z" fill="white"/>
            <path d="M8.5 12.5 L10.5 11.4 M11 14.3 L13.4 13.2 M13.6 15.2 L15.9 14.1" stroke="#2b663d" stroke-width="1" stroke-linecap="round"/>
        </svg>
    </span>
    <span class="font-display text-xl font-semibold tracking-tight text-inherit">Mahligai Bakery</span>
</a>