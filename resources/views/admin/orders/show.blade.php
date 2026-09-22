@extends('layouts.admin')

@section('title', 'Detail Pesanan '.$order->order_number)

@section('content')
    <div class="no-print flex flex-col gap-3">
        <a href="{{ route('admin.orders.index') }}" class="inline-flex w-fit items-center gap-1.5 text-sm font-semibold text-brand-600 transition hover:text-brand-800">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="m12 19-7-7 7-7M5 12h14"/></svg>
            Kembali ke Daftar
        </a>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="font-display text-2xl font-semibold text-brand-950">{{ $order->order_number }}</h1>
                    <span class="grid h-10 w-10 place-items-center rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 text-sm font-bold text-white">#{{ $order->queue_number }}</span>
                </div>
                <p class="mt-1 text-sm text-brand-950/55">Dibuat {{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div class="flex flex-wrap gap-2">
                @if ($order->customer)
                    <a href="{{ route('admin.chat') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-700">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2Z"/></svg>
                        Buka Chat Pelanggan
                    </a>
                @endif
                <a href="{{ $order->wa_order_link }}" target="_blank" rel="noopener"
                    class="inline-flex items-center justify-center gap-2 rounded-full bg-emerald-500 px-5 py-2.5 text-sm font-semibold text-white shadow-md transition hover:bg-emerald-600">
                    <svg viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4"><path d="M12 2a9.9 9.9 0 0 0-8.5 14.9L2 22l5.3-1.4A10 10 0 1 0 12 2Z"/></svg>
                    Hubungi via WhatsApp
                </a>
            </div>
        </div>
    </div>

    @if (session('status'))
        <div class="no-print mt-6 rounded-2xl bg-emerald-100 px-4 py-3 text-sm font-semibold text-emerald-800 ring-1 ring-emerald-200">
            {{ session('status') }}
        </div>
    @endif

    <div class="no-print mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
        {{-- Kolom kiri: data pelanggan & status --}}
        <div class="flex flex-col gap-6 lg:col-span-1">
            <div class="rounded-3xl bg-white p-5 shadow-soft ring-1 ring-brand-950/5">
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
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-xs text-brand-950/45">Metode Pembayaran</dt>
                        <dd>
                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $order->payment_method === 'qris' ? 'bg-emerald-100 text-emerald-700' : 'bg-sky-100 text-sky-700' }}">
                                {{ $order->payment_method_label }}
                            </span>
                        </dd>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-xs text-brand-950/45">Akun Pelanggan</dt>
                        <dd class="text-right">
                            @if ($order->customer)
                                <a href="{{ route('admin.chat') }}" class="font-semibold text-brand-600 hover:underline">{{ $order->customer->name }}</a>
                            @else
                                <span class="font-semibold text-brand-950/45">Tanpa akun</span>
                            @endif
                        </dd>
                    </div>
                    <div class="grid grid-cols-2 gap-3 border-t border-brand-950/5 pt-3">
                        <div>
                            <dt class="text-xs text-brand-950/45">Tanggal Pesan</dt>
                            <dd class="mt-0.5 font-semibold text-brand-950">{{ $order->created_at->format('d M Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-brand-950/45">Jam Pesan</dt>
                            <dd class="mt-0.5 font-semibold text-brand-950">{{ $order->created_at->format('H:i') }}</dd>
                        </div>
                    </div>
                    @if ($order->pickup_date || $order->pickup_time)
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <dt class="text-xs text-brand-950/45">Tgl Pengambilan</dt>
                                <dd class="mt-0.5 font-semibold text-brand-950">{{ $order->pickup_date?->format('d M Y') ?: '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-brand-950/45">Jam Pengambilan</dt>
                                <dd class="mt-0.5 font-semibold text-brand-950">{{ $order->pickup_time ? substr((string) $order->pickup_time, 0, 5) : '—' }}</dd>
                            </div>
                        </div>
                    @endif
                    @if ($order->bakery_request)
                        <div class="border-t border-brand-950/5 pt-3">
                            <dt class="text-xs text-brand-950/45">Request Bakery</dt>
                            <dd class="mt-1 whitespace-pre-wrap rounded-xl bg-amber-50 px-3 py-2 text-sm font-medium text-amber-900 ring-1 ring-amber-200">{{ $order->bakery_request }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            <div id="ubah-status" class="scroll-mt-24 rounded-3xl bg-white p-5 shadow-soft ring-1 ring-brand-950/5">
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

        {{-- Kolom kanan: rincian, pembayaran & struk --}}
        <div class="flex flex-col gap-6 lg:col-span-2">
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

            <div id="struk" class="scroll-mt-24 rounded-3xl bg-white p-6 shadow-soft ring-1 ring-brand-950/5">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <h2 class="text-xs font-bold uppercase tracking-[0.2em] text-brand-600">Struk Pesanan</h2>
                        <p class="mt-1 text-sm text-brand-950/50">Klik "Cetak Struk" untuk mencetak sebagai bukti pengambilan.</p>
                    </div>
                    <button type="button" data-print-struk-trigger
                        class="inline-flex items-center justify-center gap-2 rounded-full bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-700">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8" rx="1"/></svg>
                        Cetak Struk
                    </button>
                </div>
                <div class="mt-6">
                    <x-order-receipt :order="$order" />
                </div>
            </div>
        </div>
    </div>

    {{-- Isi yang dicetak: hanya struk (satunya) --}}
    <div class="print-only">
        <x-order-receipt :order="$order" />
    </div>
@endsection