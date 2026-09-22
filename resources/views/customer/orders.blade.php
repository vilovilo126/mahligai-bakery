@extends('layouts.landing')

@section('title', 'Pesanan Saya · Mahligai Bakery')

@section('content')
    <main class="min-h-screen bg-cream-50 pt-28 pb-20 text-brand-950">
        <div class="mx-auto w-full max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <a href="{{ route('menu') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-600 transition hover:text-brand-800">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="m12 19-7-7 7-7M5 12h14"/></svg>
                        Kembali ke Menu
                    </a>
                    <h1 class="mt-3 font-display text-2xl font-semibold sm:text-3xl">Pesanan Saya</h1>
                    <p class="mt-1 text-sm text-brand-950/55">Halo {{ $customer->name }}, berikut riwayat pesanan Anda.</p>
                </div>
                <button type="button" data-chat-open
                    class="inline-flex w-fit items-center gap-2 rounded-full border-2 border-brand-600/20 bg-white px-5 py-2.5 text-sm font-semibold text-brand-700 transition hover:bg-brand-50">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2Z"/></svg>
                    Buka Chat
                </button>
            </div>

            <div class="mt-8 space-y-4">
                @forelse ($orders as $order)
                    <a href="{{ route('customer.orders.show', $order) }}"
                        class="block rounded-3xl bg-white p-5 shadow-soft ring-1 ring-brand-950/5 transition hover:-translate-y-0.5 hover:shadow-lg sm:p-6">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex items-center gap-4">
                                <span class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-gradient-to-br from-brand-500 to-brand-700 font-display text-sm font-bold text-white">
                                    #{{ $order->queue_number }}
                                </span>
                                <div>
                                    <p class="font-display font-semibold text-brand-950">{{ $order->order_number }}</p>
                                    <p class="mt-0.5 text-xs text-brand-950/50">{{ $order->pickup_label ? 'Ambil '.$order->pickup_label : $order->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            <div class="flex flex-wrap items-center gap-2 sm:justify-end">
                                <span class="inline-flex rounded-full {{ $order->payment_method === 'qris' ? 'bg-emerald-100 text-emerald-700' : 'bg-sky-100 text-sky-700' }} px-3 py-1 text-xs font-bold">{{ $order->payment_method_label }}</span>
                                <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-700">{{ $order->payment_status_label }}</span>
                                <span class="inline-flex rounded-full bg-brand-100 px-3 py-1 text-xs font-bold text-brand-700">{{ $order->order_status_label }}</span>
                                <p class="font-display text-base font-bold text-brand-800">Rp{{ number_format($order->total, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="rounded-3xl bg-white px-6 py-16 text-center shadow-soft ring-1 ring-brand-950/5">
                        <span class="mx-auto grid h-16 w-16 place-items-center rounded-full bg-brand-100 text-brand-600">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18M16 10a4 4 0 0 1-8 0"/></svg>
                        </span>
                        <p class="mt-4 text-base font-semibold text-brand-950/70">Belum ada pesanan</p>
                        <p class="mt-1 text-sm text-brand-950/45">Pesanan yang Anda buat akan muncul di sini beserta nomor urutnya.</p>
                        <a href="{{ route('menu') }}#produk" class="btn-gradient mt-6 inline-flex items-center gap-2 rounded-full px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-brand-600/20">
                            Mulai Pesan
                        </a>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        </div>
    </main>
@endsection