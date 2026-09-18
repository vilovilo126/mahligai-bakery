@extends('layouts.admin')

@section('title', 'Daftar Pesanan')

@section('content')
    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-display text-2xl font-semibold text-brand-950">Daftar Pesanan</h1>
            <p class="mt-1 text-sm text-brand-950/55">Kelola pesanan masuk dari pelanggan Mahligai Bakery.</p>
        </div>
        <span class="inline-flex items-center gap-2 rounded-full bg-brand-100 px-4 py-1.5 text-xs font-bold text-brand-700">
            {{ $orders->total() }} pesanan
        </span>
    </div>

    @if (session('status'))
        <div class="mt-6 rounded-2xl bg-emerald-100 px-4 py-3 text-sm font-semibold text-emerald-800 ring-1 ring-emerald-200">
            {{ session('status') }}
        </div>
    @endif

    <div class="mt-6 overflow-hidden rounded-3xl bg-white shadow-soft ring-1 ring-brand-950/5">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-brand-950/10 bg-cream-50 text-xs font-bold uppercase tracking-wide text-brand-950/50">
                        <th class="px-5 py-4">Pelanggan</th>
                        <th class="px-5 py-4">Metode</th>
                        <th class="px-5 py-4">Total</th>
                        <th class="px-5 py-4">Status Pemesanan</th>
                        <th class="px-5 py-4">Status Pembayaran</th>
                        <th class="px-5 py-4">Waktu</th>
                        <th class="px-5 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-950/5">
                    @forelse ($orders as $order)
                        <tr class="align-top transition hover:bg-brand-50/40">
                            <td class="px-5 py-4">
                                <p class="font-semibold text-brand-950">{{ $order->customer_name }}</p>
                                <p class="mt-0.5 text-xs text-brand-950/55">{{ $order->customer_phone }}</p>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $order->payment_method === 'qris' ? 'bg-emerald-100 text-emerald-700' : 'bg-sky-100 text-sky-700' }}">
                                    {{ $order->payment_method_label }}
                                </span>
                            </td>
                            <td class="px-5 py-4 font-display font-bold text-brand-800">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                            <td class="px-5 py-4">
                                <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-700">
                                    {{ $order->order_status_label }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex rounded-full bg-brand-100 px-3 py-1 text-xs font-bold text-brand-700">
                                    {{ $order->payment_status_label }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-xs text-brand-950/55">{{ $order->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.orders.show', $order) }}"
                                        class="inline-flex items-center gap-1.5 rounded-full bg-brand-600 px-3.5 py-2 text-xs font-semibold text-white transition hover:bg-brand-700">
                                        Detail
                                    </a>
                                    <a href="{{ \App\Support\OrderHelper::waLink($order->customer_phone, \App\Support\OrderHelper::adminOrderMessage($order)) }}"
                                        target="_blank" rel="noopener"
                                        class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-full bg-emerald-500 px-3.5 py-2 text-xs font-semibold text-white transition hover:bg-emerald-600">
                                        <svg viewBox="0 0 24 24" fill="currentColor" class="h-3.5 w-3.5"><path d="M12 2a9.9 9.9 0 0 0-8.5 14.9L2 22l5.3-1.4A10 10 0 1 0 12 2Z"/></svg>
                                        Hubungi WA
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-16 text-center">
                                <p class="text-base font-semibold text-brand-950/60">Belum ada pesanan.</p>
                                <p class="mt-1 text-sm text-brand-950/40">Pesanan pelanggan akan muncul di sini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>
@endsection
