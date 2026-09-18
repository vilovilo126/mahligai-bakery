@extends('layouts.admin')

@section('title', 'Detail Pesanan #'.$order->id)

@section('content')
    <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-600 transition hover:text-brand-800">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="m12 19-7-7 7-7M5 12h14"/></svg>
        Kembali ke Daftar
    </a>

    <div class="mt-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-display text-2xl font-semibold text-brand-950">Pesanan #{{ $order->id }}</h1>
            <p class="mt-1 text-sm text-brand-950/55">Dibuat {{ $order->created_at->format('d M Y, H:i') }}</p>
        </div>
        <a href="{{ \App\Support\OrderHelper::waLink($order->customer_phone, \App\Support\OrderHelper::adminOrderMessage($order)) }}"
            target="_blank" rel="noopener"
            class="inline-flex items-center justify-center gap-2 rounded-full bg-emerald-500 px-5 py-2.5 text-sm font-semibold text-white shadow-md transition hover:bg-emerald-600">
            <svg viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4"><path d="M12 2a9.9 9.9 0 0 0-8.5 14.9L2 22l5.3-1.4A10 10 0 1 0 12 2Z"/></svg>
            Hubungi via WhatsApp
        </a>
    </div>

    @if (session('status'))
        <div class="mt-6 rounded-2xl bg-emerald-100 px-4 py-3 text-sm font-semibold text-emerald-800 ring-1 ring-emerald-200">
            {{ session('status') }}
        </div>
    @endif

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
        {{-- Kolom kiri: detail pelanggan & status --}}
        <div class="space-y-6 lg:col-span-1">
            <div class="rounded-3xl bg-white p-6 shadow-soft ring-1 ring-brand-950/5">
                <h2 class="text-xs font-bold uppercase tracking-[0.2em] text-brand-600">Data Pelanggan</h2>
                <dl class="mt-4 space-y-3 text-sm">
                    <div>
                        <dt class="text-xs text-brand-950/45">Nama</dt>
                        <dd class="mt-0.5 font-semibold text-brand-950">{{ $order->customer_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-brand-950/45">Nomor WhatsApp</dt>
                        <dd class="mt-0.5 font-semibold text-brand-950">{{ $order->customer_phone }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-brand-950/45">Metode Pembayaran</dt>
                        <dd class="mt-0.5">
                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $order->payment_method === 'qris' ? 'bg-emerald-100 text-emerald-700' : 'bg-sky-100 text-sky-700' }}">
                                {{ $order->payment_method_label }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-soft ring-1 ring-brand-950/5">
                <h2 class="text-xs font-bold uppercase tracking-[0.2em] text-brand-600">Perbarui Status</h2>
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="mt-4 space-y-4">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label for="order_status" class="text-xs font-semibold text-brand-950/60">Status Pemesanan</label>
                        <select name="order_status" id="order_status" class="mt-1.5 w-full rounded-xl border-0 bg-cream-100 px-3 py-2.5 text-sm text-brand-950 ring-1 ring-brand-950/10 focus:ring-2 focus:ring-brand-400">
                            @foreach (\App\Models\Order::ORDER_STATUSES as $value => $label)
                                <option value="{{ $value }}" @selected($order->order_status === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="payment_status" class="text-xs font-semibold text-brand-950/60">Status Pembayaran</label>
                        <select name="payment_status" id="payment_status" class="mt-1.5 w-full rounded-xl border-0 bg-cream-100 px-3 py-2.5 text-sm text-brand-950 ring-1 ring-brand-950/10 focus:ring-2 focus:ring-brand-400">
                            @foreach (\App\Models\Order::PAYMENT_STATUSES as $value => $label)
                                <option value="{{ $value }}" @selected($order->payment_status === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="w-full rounded-full bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-700">
                        Simpan Status
                    </button>
                </form>
            </div>
        </div>

        {{-- Kolom kanan: rincian pesanan & total --}}
        <div class="space-y-6 lg:col-span-2">
            <div class="rounded-3xl bg-white p-6 shadow-soft ring-1 ring-brand-950/5">
                <h2 class="text-xs font-bold uppercase tracking-[0.2em] text-brand-600">Rincian Pesanan</h2>
                <div class="mt-5 space-y-5">
                    @forelse ($order->order_data ?? [] as $item)
                        <div class="rounded-2xl bg-cream-50 p-4 ring-1 ring-brand-950/5">
                            <div class="flex flex-wrap items-start justify-between gap-2">
                                <div>
                                    <p class="font-display font-semibold text-brand-950">
                                        {{ $item['variant'] ?? $item['package'] ?? 'Produk' }}
                                    </p>
                                    <p class="mt-0.5 text-xs text-brand-950/50">{{ $item['group_title'] ?? '' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-brand-700">x{{ $item['quantity'] }}</p>
                                    <p class="text-xs text-brand-950/50">Rp{{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                                </div>
                            </div>

                            @if (! empty($item['add_ons']))
                                <div class="mt-3 border-t border-brand-950/10 pt-3">
                                    <p class="text-xs font-semibold text-brand-950/50">Additional:</p>
                                    <ul class="mt-1.5 space-y-1">
                                        @foreach ($item['add_ons'] as $addOn)
                                            <li class="flex justify-between text-xs text-brand-700">
                                                <span>{{ $addOn['name'] }}</span>
                                                <span>+ Rp{{ number_format($addOn['price'], 0, ',', '.') }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <p class="mt-1.5 text-right text-xs font-bold text-brand-700">Subtotal Additional: Rp{{ number_format($item['add_ons_total'], 0, ',', '.') }}</p>
                                </div>
                            @endif

                            @if (($item['qris_fee'] ?? 0) > 0)
                                <p class="mt-2 text-right text-xs font-semibold text-brand-900">Biaya QRIS: Rp{{ number_format($item['qris_fee'], 0, ',', '.') }}</p>
                            @endif
                        </div>
                    @empty
                        <p class="text-sm text-brand-950/50">Tidak ada data pesanan.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-3xl bg-gradient-to-br from-brand-800 to-brand-950 p-6 text-white shadow-soft">
                <h2 class="text-xs font-bold uppercase tracking-[0.2em] text-brand-300">Ringkasan Pembayaran</h2>
                <dl class="mt-4 space-y-2.5 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-white/70">Subtotal</dt>
                        <dd class="font-semibold">Rp{{ number_format($order->subtotal, 0, ',', '.') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-white/70">Biaya Additional</dt>
                        <dd class="font-semibold">Rp{{ number_format($order->add_ons_total, 0, ',', '.') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-white/70">Biaya QRIS</dt>
                        <dd class="font-semibold">Rp{{ number_format($order->qris_fee, 0, ',', '.') }}</dd>
                    </div>
                    <div class="mt-2 flex justify-between border-t border-white/15 pt-3">
                        <dt class="font-semibold">Total Pembayaran</dt>
                        <dd class="font-display text-xl font-bold">Rp{{ number_format($order->total, 0, ',', '.') }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
@endsection
