@props(['order' => null])

@php
    $isModel = $order instanceof \App\Models\Order;

    $number = $isModel ? $order->order_number : ($order['order_number'] ?? '');
    $queue = $isModel ? $order->queue_number : ($order['queue_number'] ?? '');
    $customerName = $isModel ? $order->customer_name : ($order['customer_name'] ?? '');
    $customerPhone = $isModel ? $order->customer_phone : ($order['customer_phone'] ?? '');
    $method = $isModel ? $order->payment_method : ($order['payment_method'] ?? '');
    $methodLabel = $isModel ? $order->payment_method_label : ($order['payment_method_label'] ?? $method);
    $paymentStatus = $isModel ? $order->payment_status_label : ($order['payment_status_label'] ?? $order['payment_status'] ?? '');
    $orderStatus = $isModel ? $order->order_status_label : ($order['order_status_label'] ?? $order['order_status'] ?? '');
    $pickup = $isModel ? $order->pickup_label : ($order['pickup_label'] ?? '');
    $bakeryRequest = $isModel ? $order->bakery_request : ($order['bakery_request'] ?? '');
    $createdAt = $isModel ? $order->created_at?->format('d M Y H:i') : ($order['created_at'] ?? '');
    $items = $isModel ? ($order->order_data ?? []) : ($order['order_data'] ?? []);
    $subtotal = (int) ($isModel ? $order->subtotal : ($order['subtotal'] ?? 0));
    $addOnsTotal = (int) ($isModel ? $order->add_ons_total : ($order['add_ons_total'] ?? 0));
    $qrisFee = (int) ($isModel ? $order->qris_fee : ($order['qris_fee'] ?? 0));
    $total = (int) ($isModel ? $order->total : ($order['total'] ?? 0));
@endphp

<div class="mx-auto w-full max-w-sm overflow-hidden rounded-2xl border border-dashed border-brand-950/20 bg-white shadow-sm">
    {{-- Kop struk --}}
    <div class="border-b border-dashed border-brand-950/15 bg-cream-50 px-5 py-4 text-center">
        <p class="font-display text-lg font-bold text-brand-900">Mahligai Bakery</p>
        <p class="text-xs text-brand-950/50">Renon, Denpasar Selatan, Bali</p>
        <p class="mt-2 text-xs font-semibold text-brand-950/60">{{ $createdAt }}</p>
    </div>

    <div class="space-y-1.5 px-5 py-4 text-sm">
        <div class="flex justify-between">
            <span class="text-brand-950/55">No. Pesanan</span>
            <span class="font-bold text-brand-950">{{ $number ?: '—' }}</span>
        </div>
        @if ($queue)
            <div class="flex justify-between">
                <span class="text-brand-950/55">Nomor Urut</span>
                <span class="font-bold text-brand-600">#{{ $queue }}</span>
            </div>
        @endif
        <div class="flex justify-between">
            <span class="text-brand-950/55">Nama</span>
            <span class="font-semibold text-brand-950">{{ $customerName ?: '—' }}</span>
        </div>
        @if ($customerPhone)
            <div class="flex justify-between">
                <span class="text-brand-950/55">WhatsApp</span>
                <span class="font-semibold text-brand-950">{{ $customerPhone }}</span>
            </div>
        @endif
        @if ($pickup)
            <div class="flex justify-between">
                <span class="text-brand-950/55">Pengambilan</span>
                <span class="font-semibold text-brand-950">{{ $pickup }}</span>
            </div>
        @endif
    </div>

    {{-- Daftar item --}}
    <div class="border-t border-dashed border-brand-950/15 px-5 py-4">
        <p class="text-[0.65rem] font-bold uppercase tracking-[0.2em] text-brand-600">Rincian Pesanan</p>
        <ul class="mt-3 space-y-3 text-sm">
            @forelse ($items as $item)
                <li class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="font-semibold leading-snug text-brand-950">
                            {{ $item['variant'] ?? $item['package'] ?? 'Produk' }} <span class="text-brand-950/50">× {{ $item['quantity'] }}</span>
                        </p>
                        @if (! empty($item['add_ons']))
                            <ul class="mt-1 space-y-0.5">
                                @foreach ($item['add_ons'] as $addOn)
                                    <li class="text-xs text-brand-950/55">+ {{ $addOn['name'] }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <span class="shrink-0 font-semibold text-brand-900">Rp{{ number_format($item['subtotal'] ?? 0, 0, ',', '.') }}</span>
                </li>
            @empty
                <li class="text-xs text-brand-950/45">Tidak ada item.</li>
            @endforelse
        </ul>
    </div>

    {{-- Total --}}
    <div class="border-t border-dashed border-brand-950/15 px-5 py-4">
        <dl class="space-y-1.5 text-sm">
            <div class="flex justify-between text-brand-950/60">
                <dt>Subtotal</dt>
                <dd class="font-semibold text-brand-950">Rp{{ number_format($subtotal, 0, ',', '.') }}</dd>
            </div>
            @if ($addOnsTotal > 0)
                <div class="flex justify-between text-brand-950/60">
                    <dt>Additional</dt>
                    <dd class="font-semibold text-brand-950">Rp{{ number_format($addOnsTotal, 0, ',', '.') }}</dd>
                </div>
            @endif
            @if ($qrisFee > 0)
                <div class="flex justify-between text-brand-950/60">
                    <dt>Biaya QRIS</dt>
                    <dd class="font-semibold text-brand-950">Rp{{ number_format($qrisFee, 0, ',', '.') }}</dd>
                </div>
            @endif
            <div class="mt-2 flex items-center justify-between border-t border-brand-950/15 pt-2">
                <dt class="font-bold text-brand-950">Total</dt>
                <dd class="font-display text-lg font-bold text-brand-700">Rp{{ number_format($total, 0, ',', '.') }}</dd>
            </div>
        </dl>

        <div class="mt-4 flex flex-wrap items-center gap-2">
            <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-[0.7rem] font-bold text-amber-700">{{ $paymentStatus }}</span>
            <span class="inline-flex rounded-full bg-brand-100 px-3 py-1 text-[0.7rem] font-bold text-brand-700">{{ $orderStatus }}</span>
            <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-[0.7rem] font-bold text-emerald-700">{{ $methodLabel }}</span>
        </div>
    </div>

    @if ($bakeryRequest)
        <div class="border-t border-dashed border-brand-950/15 px-5 py-4">
            <p class="text-[0.65rem] font-bold uppercase tracking-[0.2em] text-brand-600">Request Bakery</p>
            <p class="mt-1.5 text-sm leading-relaxed text-brand-950/70">{{ $bakeryRequest }}</p>
        </div>
    @endif

    <div class="border-t border-dashed border-brand-950/15 bg-cream-50 px-5 py-3 text-center">
        <p class="text-[0.7rem] text-brand-950/45">Terima kasih telah memesan di Mahligai Bakery</p>
    </div>
</div>