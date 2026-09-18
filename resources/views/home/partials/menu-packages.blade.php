@php
    $packagesHeading = $group['packages_heading'] ?? null;
    $packagesDescription = $group['packages_description'] ?? null;

    $mountMenuDetail = fn (string $name, int $rawPrice, string $description, ?string $note): array => [
        'image' => null,
        'name' => $name,
        'group_id' => $group['id'] ?? null,
        'description' => $description,
        'price' => 'Rp'.number_format($rawPrice, 0, ',', '.'),
        'price_raw' => $rawPrice,
        'per_pcs' => false,
        'note' => $note ?? null,
        'variant_name' => $name,
        'group_title' => $group['title'],
        'packages' => collect($group['packages'])->map(fn ($p) => [
            'name' => $p['name'],
            'price' => 'Rp'.number_format($p['price'], 0, ',', '.'),
            'price_raw' => $p['price'],
            'qris_fee_raw' => $p['qris_fee'] ?? 0,
            'note' => $p['note'] ?? null,
        ])->values()->all(),
        'package_note' => $group['package_note'] ?? null,
        'add_ons' => collect($group['add_ons'])->map(fn ($a) => [
            'name' => $a['name'],
            'price' => 'Rp'.number_format($a['price'], 0, ',', '.'),
            'price_raw' => $a['price'],
            'qris_fee_raw' => $a['qris_fee'] ?? 0,
            'note' => $a['note'] ?? null,
        ])->values()->all(),
    ];

    $packageDetails = collect($group['packages'])->mapWithKeys(fn ($p, $i) => [
        $i => $mountMenuDetail(
            $p['name'],
            $p['price'],
            $packagesDescription ?? ($group['description'] ?? ''),
            $p['note'] ?? null,
        ),
    ])->all();
@endphp

<div class="mt-12" data-menu-packages>
    <div class="flex flex-col gap-2">
        <div class="flex flex-wrap items-center gap-3">
            <h3 class="font-display text-xl font-semibold text-brand-950 sm:text-2xl">{{ $packagesHeading }}</h3>
            <span class="rounded-full bg-brand-100 px-3 py-1 text-[0.65rem] font-bold uppercase tracking-wide text-brand-700">Pilihan Paket</span>
        </div>
        @if ($packagesDescription)
            <p class="max-w-3xl text-sm leading-relaxed text-brand-950/60">{{ $packagesDescription }}</p>
        @endif
    </div>

    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @foreach ($group['packages'] as $index => $package)
            <div class="group card-lift relative flex cursor-pointer flex-col overflow-hidden rounded-3xl bg-white p-6 ring-1 ring-brand-950/5 shadow-soft transition hover:ring-brand-300"
                data-product-card
                data-detail='@json($packageDetails[$index])'>
                <div class="absolute right-0 top-0 h-24 w-24 rounded-bl-full bg-brand-50 transition-colors group-hover:bg-brand-100"></div>
                <div class="relative">
                    <span class="font-display text-lg font-bold leading-tight text-brand-950">{{ $package['name'] }}</span>
                    <div class="mt-3 flex items-end gap-1">
                        <span class="font-display text-3xl font-bold tracking-tight text-brand-700">Rp{{ number_format($package['price'], 0, ',', '.') }}</span>
                    </div>
                    @if (!empty($package['note']))
                        <p class="mt-3 text-xs font-medium leading-relaxed text-brand-950/55">{{ $package['note'] }}</p>
                    @endif
                    <span class="mt-4 inline-flex items-center gap-1.5 text-xs font-semibold text-brand-600">
                        Lihat Detail
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 transition-transform group-hover:translate-x-0.5"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
                    </span>
                </div>
            </div>
        @endforeach
    </div>

    @if (!empty($group['package_note']))
        <div class="mt-5 flex items-start gap-3 rounded-2xl bg-cream-100 p-4 ring-1 ring-brand-950/5">
            <span class="mt-0.5 grid h-7 w-7 shrink-0 place-items-center rounded-full bg-brand-600 text-white">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M12 9v4M12 17h.01M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z"/></svg>
            </span>
            <p class="text-xs font-semibold leading-relaxed text-brand-900">{{ $group['package_note'] }}</p>
        </div>
    @endif

    @if (!empty($group['add_ons']))
        @include('home.partials.menu-addons', ['group' => $group, 'inPackages' => true])
    @endif
</div>
