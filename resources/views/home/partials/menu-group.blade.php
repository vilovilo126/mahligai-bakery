@php
    $isTawar = $group['id'] === 'roti-tawar';
    $isUnyil = $group['id'] === 'roti-unyil';
    $isSisir = $group['id'] === 'roti-sisir';
    $isRegular = $group['id'] === 'aneka-roti';
@endphp

<section id="menu-{{ $group['id'] }}" class="scroll-mt-40 pt-16">
    <div class="flex flex-col gap-3">
        <p class="inline-flex items-center gap-2.5 text-xs font-bold uppercase tracking-[0.28em] text-brand-600">
            <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
            {{ $group['eyebrow'] }}
        </p>
        <div class="flex flex-wrap items-center gap-3">
            <h2 class="font-display text-2xl font-semibold tracking-tight text-brand-950 sm:text-3xl">{{ $group['title'] }}</h2>
            @if (!empty($group['badge']))
                <span class="inline-flex items-center gap-1.5 rounded-full bg-gradient-to-r from-amber-300 to-amber-400 px-3.5 py-1 text-[0.65rem] font-bold uppercase tracking-wide text-amber-950 shadow-md">
                    <svg viewBox="0 0 24 24" fill="currentColor" class="h-3.5 w-3.5"><path d="m12 2 2.6 5.3 5.9.9-4.3 4.1 1 5.8L12 15.8l-5.2 2.3 1-5.8L3.5 8.2l5.9-.9L12 2Z"/></svg>
                    {{ $group['badge'] }}
                </span>
            @endif
        </div>
        @if (!empty($group['description']))
            <p class="max-w-3xl text-base leading-relaxed text-brand-950/60">{{ $group['description'] }}</p>
        @endif
    </div>

    {{-- ================================================================
         ROTI UNYIL — varian tanpa foto (typography/icon/badge)
    ================================================================ --}}
    @if ($isUnyil)
        <div data-menu-anchor="{{ $group['id'] }}">
            <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                @foreach ($group['variants'] as $variant)
                    @include('home.partials.menu-variant-card', [
                        'variant' => $variant,
                        'group' => $group,
                        'image' => null,
                        'price' => null,
                    ])
                @endforeach
            </div>

            @include('home.partials.menu-packages', ['group' => $group])
        </div>

    {{-- ================================================================
         ROTI SISIR — varian grup (Klasik/Premium/Savoury)
    ================================================================ --}}
    @elseif ($isSisir)
        <div data-menu-anchor="{{ $group['id'] }}">
            <div class="mt-8 grid grid-cols-1 gap-6 md:grid-cols-3">
                @foreach ($group['variant_groups'] as $index => $variantGroup)
                    <div class="reveal reveal-up rounded-3xl bg-cream-50 p-6 ring-1 ring-brand-950/5" style="--reveal-delay:{{ $index * 0.07 }}s">
                        <div class="flex items-center gap-2.5">
                            <span class="grid h-9 w-9 place-items-center rounded-full bg-brand-100 text-brand-700">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M12 5v14M5 12h14"/></svg>
                            </span>
                            <h3 class="font-display text-lg font-semibold text-brand-900">{{ $variantGroup['label'] }}</h3>
                        </div>
                        <ul class="mt-5 space-y-2.5">
                            @foreach ($variantGroup['items'] as $variant)
                                <li>
                                    @include('home.partials.menu-variant-row', ['variant' => $variant, 'group' => $group])
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>

            @include('home.partials.menu-packages', ['group' => $group])
        </div>

    {{-- ================================================================
         ANEKA ROTI (REGULAR BREAD) — kartu dengan placeholder image
    ================================================================ --}}
    @elseif ($isRegular)
        <div data-menu-anchor="{{ $group['id'] }}">
            <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($group['variants'] as $variant)
                    @include('home.partials.menu-variant-card', [
                        'variant' => $variant,
                        'group' => $group,
                        'image' => $group['image'],
                        'price' => $variant['price'],
                    ])
                @endforeach
            </div>

            @if (!empty($group['add_ons']))
                @include('home.partials.menu-addons', ['group' => $group])
            @endif
        </div>

    {{-- ================================================================
         ANEKA ROTI (ROTI TAWAR) — dipisahkan visual dari Regular Bread
    ================================================================ --}}
    @elseif ($isTawar)
        <div data-menu-anchor="{{ $group['id'] }}">
            <div class="mt-8 overflow-hidden rounded-3xl bg-brand-950 p-6 text-white sm:p-8">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <span class="grid h-10 w-10 place-items-center rounded-full bg-white/10 text-brand-300">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="M4 15c0 2 2 3 8 3s8-1 8-3V9c0-2-2-3-8-3s-8 1-8 3zM4 15V9M20 15V9"/></svg>
                        </span>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.28em] text-brand-300">Roti Tawar & Lainnya</p>
                            <h3 class="font-display text-xl font-semibold">Pilih favorit Anda, potong rapi dan siap saji</h3>
                        </div>
                    </div>
                </div>
                <div class="mt-7 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($group['variants'] as $variant)
                        @include('home.partials.menu-variant-card', [
                            'variant' => $variant,
                            'group' => $group,
                            'image' => $group['image'],
                            'price' => $variant['price'],
                            'compact' => true,
                        ])
                    @endforeach
                </div>
            </div>

            @if (!empty($group['add_ons']))
                @include('home.partials.menu-addons', ['group' => $group])
            @endif
        </div>
    @endif
</section>
