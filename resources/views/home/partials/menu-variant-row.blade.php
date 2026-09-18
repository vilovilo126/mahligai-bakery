@php
    $detail = [
        'image' => null,
        'name' => $variant['name'],
        'group_id' => $group['id'] ?? null,
        'description' => $group['description'] ?? '',
        'price' => 'Rp'.number_format($variant['price'], 0, ',', '.'),
        'price_raw' => $variant['price'],
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

<button type="button" data-product-card data-detail='@json($detail)'
    class="group flex w-full items-center justify-between gap-3 rounded-2xl bg-white p-3 text-left ring-1 ring-brand-950/5 transition hover:ring-brand-300 hover:shadow-sm">
    <div>
        <p class="text-sm font-semibold text-brand-900">{{ $variant['name'] }}</p>
        <div class="mt-0.5 flex items-center gap-2">
            <span class="font-display text-base font-bold text-brand-700">Rp{{ number_format($variant['price'], 0, ',', '.') }}</span>
            @if (!empty($variant['per_pcs']))
                <span class="text-[0.62rem] font-semibold uppercase tracking-wide text-brand-950/40">Per Pcs</span>
            @endif
        </div>
    </div>
    <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-brand-50 text-brand-600 transition group-hover:bg-brand-600 group-hover:text-white" aria-hidden="true">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
    </span>
</button>
