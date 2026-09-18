@props([
    'eyebrow' => '',
    'description' => '',
    'center' => false,
    'light' => false,
])

<div class="{{ $center ? 'mx-auto text-center' : '' }} max-w-2xl">
    <p class="inline-flex items-center gap-2.5 text-xs font-bold uppercase tracking-[0.28em] {{ $light ? 'text-brand-300' : 'text-brand-600' }}">
        <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
        {{ $eyebrow }}
    </p>
    <h2 class="mt-4 font-display text-3xl font-semibold leading-tight tracking-tight sm:text-[2.6rem] {{ $light ? 'text-white' : 'text-brand-950' }}">
        {{ $slot }}
    </h2>
    @if ($description)
        <p class="mt-5 text-base leading-relaxed {{ $light ? 'text-white/70' : 'text-brand-950/60' }}">
            {{ $description }}
        </p>
    @endif
</div>