@php
    $compact = $compact ?? false;
    $image = $image ?? null;

    $detail = [
        'image' => $image ? asset($image) : null,
        'name' => $variant['name'],
        'group_id' => $group['id'] ?? null,
        'description' => $group['description'] ?? '',
        'price' => $price !== null ? 'Rp'.number_format($price, 0, ',', '.') : null,
        'price_raw' => $price,
        'per_pcs' => $variant['per_pcs'] ?? false,
        'note' => $variant['note'] ?? null,
        'variant_name' => $variant['name'],
        'group_title' => $group['title'],
        'packages' => collect($group['packages'] ?? [])->map(function ($p) {
            return [
                'name' => $p['name'],
                'price' => 'Rp'.number_format($p['price'], 0, ',', '.'),
                'price_raw' => $p['price'],
                'qris_fee_raw' => $p['qris_fee'] ?? 0,
                'note' => $p['note'] ?? null,
            ];
        })->values()->all(),
        'package_note' => $group['package_note'] ?? null,
        'add_ons' => collect($group['add_ons'] ?? [])->map(function ($a) {
            return [
                'name' => $a['name'],
                'price' => 'Rp'.number_format($a['price'], 0, ',', '.'),
                'price_raw' => $a['price'],
                'qris_fee_raw' => $a['qris_fee'] ?? 0,
                'note' => $a['note'] ?? null,
            ];
        })->values()->all(),
    ];
@endphp

<article data-product-card data-detail='@json($detail)'
    class="group cursor-pointer {{ $compact ? '' : 'reveal reveal-up' }}">
    <div class="card-lift relative flex h-full flex-col overflow-hidden rounded-3xl bg-white shadow-soft ring-1 ring-brand-950/5 transition hover:shadow-xl">
        @if ($image)
            <div class="img-zoom relative overflow-hidden">
                <img src="{{ asset($image) }}" alt="{{ $variant['name'] }}" loading="lazy"
                    class="aspect-[4/3] w-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-brand-950/15 to-transparent"></div>
            </div>
        @else
            <div class="bg-dots-dark relative flex aspect-[4/3] items-center justify-center overflow-hidden bg-brand-50">
                <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-brand-200/40 blur-2xl"></div>
                <div class="absolute -bottom-10 -left-8 h-28 w-28 rounded-full bg-cream-200/60 blur-2xl"></div>
                <span class="relative grid h-16 w-16 place-items-center rounded-2xl bg-white text-brand-600 shadow-sm ring-1 ring-brand-950/5 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-3">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8"><path d="M17.5 19a9 9 0 1 1-6.8-8.5M15 10l4-4M13 5h6v6"/></svg>
                </span>
            </div>
        @endif

        <div class="flex flex-1 flex-col p-5">
            <p class="text-[0.66rem] font-bold uppercase tracking-[0.18em] text-brand-500">{{ $group['eyebrow'] }}</p>
            <h3 class="mt-1.5 font-display text-base font-semibold leading-snug text-brand-950 transition-colors group-hover:text-brand-700">
                {{ $variant['name'] }}
            </h3>

            @if ($price !== null)
                <div class="mt-3 flex items-center justify-between">
                    <span class="font-display text-lg font-bold text-brand-700">Rp{{ number_format($price, 0, ',', '.') }}</span>
                    @if (!empty($variant['per_pcs']))
                        <span class="text-[0.65rem] font-semibold uppercase tracking-wide text-brand-950/45">Per Pcs</span>
                    @endif
                </div>
            @else
                <p class="mt-1 text-xs text-brand-950/45">Tersedia dalam paket & additional di bawah</p>
            @endif

            @if (!empty($variant['note']))
                <p class="mt-2 text-xs font-medium text-brand-600">{{ $variant['note'] }}</p>
            @endif

            <div class="mt-auto pt-4">
                <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-600 transition group-hover:text-brand-700">
                    Lihat Detail
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 transition-transform group-hover:translate-x-0.5"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
                </span>
            </div>
        </div>
    </div>
</article>
