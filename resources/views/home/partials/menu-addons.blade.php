@php
    $inPackages = $inPackages ?? false;
    $groupTitle = $group['title'] ?? '';

    $addOnDetails = collect($group['add_ons'])->mapWithKeys(fn ($a, $i) => [
        $i => [
            'image' => null,
            'name' => $a['name'],
            'group_id' => $group['id'] ?? null,
            'description' => 'Biaya tambahan (additional) untuk pelengkap pesanan '.$groupTitle.'.',
            'price' => '+ Rp'.number_format($a['price'], 0, ',', '.'),
            'price_raw' => $a['price'],
            'per_pcs' => false,
            'note' => $a['note'] ?? null,
            'variant_name' => $a['name'],
            'group_title' => $groupTitle,
            'is_addon_only' => true,
            'packages' => [],
            'package_note' => null,
            'add_ons' => [],
        ],
    ])->all();
@endphp

<div class="mt-8" data-menu-addons>
    <div class="flex flex-wrap items-center gap-3">
        <h3 class="font-display text-lg font-semibold text-brand-950 sm:text-xl">Additional</h3>
        <span class="rounded-full bg-amber-100 px-3 py-1 text-[0.65rem] font-bold uppercase tracking-wide text-amber-800">
            Tambahan & Kemasan
        </span>
    </div>

    <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($group['add_ons'] as $index => $addOn)
            <div class="group card-lift flex cursor-pointer items-center justify-between gap-3 rounded-2xl border border-dashed border-brand-950/15 bg-white/60 p-4 transition hover:border-brand-300 hover:bg-white"
                data-product-card
                data-detail='@json($addOnDetails[$index])'>
                <div class="flex items-start gap-3">
                    <span class="mt-0.5 grid h-8 w-8 shrink-0 place-items-center rounded-full bg-brand-50 text-brand-600 transition group-hover:bg-brand-600 group-hover:text-white">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M12 5v14M5 12h14"/></svg>
                    </span>
                    <p class="text-sm font-semibold leading-snug text-brand-900">{{ $addOn['name'] }}</p>
                </div>
                <div class="shrink-0 text-right">
                    <span class="font-display text-base font-bold text-brand-700">+ Rp{{ number_format($addOn['price'], 0, ',', '.') }}</span>
                    @if (!empty($addOn['note']))
                        <p class="text-[0.62rem] font-semibold uppercase tracking-wide text-brand-950/40">{{ $addOn['note'] }}</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
