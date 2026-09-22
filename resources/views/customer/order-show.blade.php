@extends('layouts.landing')

@section('title', 'Detail Pesanan · Mahligai Bakery')

@section('content')
    <main class="min-h-screen bg-cream-50 pt-28 pb-20 text-brand-950">
        <div class="mx-auto w-full max-w-4xl px-4 sm:px-6 lg:px-8">
            <a href="{{ route('customer.orders') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-600 transition hover:text-brand-800">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="m12 19-7-7 7-7M5 12h14"/></svg>
                Kembali ke Pesanan Saya
            </a>

            <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h1 class="font-display text-2xl font-semibold">{{ $order->order_number }}</h1>
                    <p class="mt-1 text-sm text-brand-950/55">
                        Dibuat {{ $order->created_at->format('d M Y, H:i') }} · Nomor Urut #{{ $order->queue_number }}
                    </p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ $order->wa_order_link }}" target="_blank" rel="noopener"
                        class="inline-flex items-center gap-2 rounded-full border-2 border-emerald-500/25 bg-emerald-500/10 px-5 py-2.5 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-500/20">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4"><path d="M12 2a9.9 9.9 0 0 0-8.5 14.9L2 22l5.3-1.4A10 10 0 1 0 12 2Z"/></svg>
                        Chat WhatsApp
                    </a>
                    <button type="button" data-chat-open
                        class="inline-flex items-center gap-2 rounded-full border-2 border-brand-600/20 bg-white px-5 py-2.5 text-sm font-semibold text-brand-700 transition hover:bg-brand-50">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2Z"/></svg>
                        Buka Chat
                    </button>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
                {{-- Struk --}}
                <div>
                    <h2 class="text-xs font-bold uppercase tracking-[0.2em] text-brand-600">Struk Pesanan</h2>
                    <div class="mt-3">
                        <x-order-receipt :order="$order" />
                    </div>
                </div>

                {{-- Ringkasan status & aksi bayar --}}
                <div class="space-y-6">
                    <div class="rounded-3xl bg-white p-6 shadow-soft ring-1 ring-brand-950/5">
                        <h2 class="text-xs font-bold uppercase tracking-[0.2em] text-brand-600">Status Pesanan</h2>
                        <dl class="mt-4 space-y-3 text-sm">
                            <div class="flex items-center justify-between">
                                <dt class="text-brand-950/55">Status Pemesanan</dt>
                                <dd class="font-semibold">{{ $order->order_status_label }}</dd>
                            </div>
                            <div class="flex items-center justify-between">
                                <dt class="text-brand-950/55">Status Pembayaran</dt>
                                <dd class="font-semibold">{{ $order->payment_status_label }}</dd>
                            </div>
                            <div class="flex items-center justify-between">
                                <dt class="text-brand-950/55">Metode</dt>
                                <dd class="font-semibold">{{ $order->payment_method_label }}</dd>
                            </div>
                            @if ($order->pickup_label)
                                <div class="flex items-center justify-between">
                                    <dt class="text-brand-950/55">Pengambilan</dt>
                                    <dd class="font-semibold">{{ $order->pickup_label }}</dd>
                                </div>
                            @endif
                            <div class="flex items-center justify-between border-t border-brand-950/10 pt-3">
                                <dt class="font-semibold text-brand-900">Total</dt>
                                <dd class="font-display text-lg font-bold text-brand-700">Rp{{ number_format($order->total, 0, ',', '.') }}</dd>
                            </div>
                        </dl>

                        @if ($order->payment_status === 'belum_bayar')
                            <a href="{{ $order->payment_method === 'qris' ? '#' : $order->wa_order_link }}"
                                data-customer-pay={{ $order->id }}
                                class="btn-gradient mt-5 inline-flex w-full items-center justify-center gap-2 rounded-full px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand-600/20">
                                {{ $order->payment_method === 'qris' ? 'Lihat QRIS & Bayar' : 'Bayar via WhatsApp' }}
                            </a>
                            <p class="mt-2 text-center text-xs text-brand-950/45">Pembayaran Anda akan dikonfirmasi admin setelah selesai.</p>
                        @endif
                    </div>

                    @if ($order->bakery_request)
                        <div class="rounded-3xl bg-amber-50 p-6 ring-1 ring-amber-200">
                            <h2 class="text-xs font-bold uppercase tracking-[0.2em] text-amber-700">Request Bakery</h2>
                            <p class="mt-2 text-sm leading-relaxed text-amber-900">{{ $order->bakery_request }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection