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

    <div class="mt-6">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between" role="search">
            <div class="relative w-full sm:max-w-sm">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="pointer-events-none absolute top-1/2 left-3.5 h-4.5 w-4.5 -translate-y-1/2 text-brand-950/35"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari nomor pesanan, nama, atau WhatsApp…"
                    class="w-full rounded-full border-0 bg-white py-2.5 pr-4 pl-10 text-sm text-brand-950 shadow-soft ring-1 ring-brand-950/10 transition placeholder:text-brand-950/35 focus:ring-2 focus:ring-brand-400">
            </div>
            @if (request('search'))
                <a href="{{ route('admin.orders.index') }}" class="text-sm font-semibold text-brand-600 hover:underline">Reset pencarian</a>
            @endif
        </form>
    </div>

    <div class="mt-4 overflow-hidden rounded-3xl bg-white shadow-soft ring-1 ring-brand-950/5">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1200px] text-left text-sm">
                <thead>
                    <tr class="border-b border-brand-950/10 bg-cream-50 text-xs font-bold uppercase tracking-wide text-brand-950/50">
                        <th class="px-4 py-4">No.</th>
                        <th class="px-4 py-4">Nomor Pesanan</th>
                        <th class="px-4 py-4">Nomor Urut</th>
                        <th class="px-4 py-4">Nama Pelanggan</th>
                        <th class="px-4 py-4">WhatsApp</th>
                        <th class="px-4 py-4">Produk</th>
                        <th class="px-4 py-4">Total</th>
                        <th class="px-4 py-4">Tanggal Pesan</th>
                        <th class="px-4 py-4">Jam Pesan</th>
                        <th class="px-4 py-4">Tgl Pengambilan</th>
                        <th class="px-4 py-4">Jam Pengambilan</th>
                        <th class="px-4 py-4">Metode</th>
                        <th class="px-4 py-4">Status Bayar</th>
                        <th class="px-4 py-4">Status Pesanan</th>
                        <th class="px-4 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-950/5">
                    @forelse ($orders as $index => $order)
                        <tr class="align-top transition hover:bg-brand-50/40">
                            <td class="px-4 py-4 text-brand-950/50">{{ $orders->firstItem() + $index }}</td>
                            <td class="px-4 py-4 font-semibold text-brand-950">{{ $order->order_number }}</td>
                            <td class="px-4 py-4">
                                <span class="grid h-9 w-9 place-items-center rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 text-xs font-bold text-white">#{{ $order->queue_number }}</span>
                            </td>
                            <td class="px-4 py-4 font-semibold text-brand-950">{{ $order->customer_name }}</td>
                            <td class="px-4 py-4 text-brand-950/60">{{ $order->customer_phone }}</td>
                            <td class="px-4 py-4 text-xs leading-relaxed text-brand-950/65">
                                @php
                                    $products = collect($order->order_data ?? [])
                                        ->map(fn ($item) => trim(($item['variant'] ?? '').' '.($item['package'] ?? '')).' x'.($item['quantity'] ?? 1))
                                        ->filter();
                                @endphp
                                @if ($products->isNotEmpty())
                                    <ul class="space-y-0.5">
                                        @foreach ($products as $line)
                                            <li>{{ $line }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-brand-950/40">—</span>
                                @endif
                                @if ($order->bakery_request)
                                    <span class="mt-1 inline-block rounded-md bg-amber-50 px-2 py-0.5 font-semibold text-amber-700">Ada request</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 font-display font-bold text-brand-800">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                            <td class="px-4 py-4 text-brand-950/55">{{ $order->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-4 text-brand-950/55">{{ $order->created_at->format('H:i') }}</td>
                            <td class="px-4 py-4 text-brand-950/55">{{ $order->pickup_date?->format('d M Y') ?: '—' }}</td>
                            <td class="px-4 py-4 text-brand-950/55">{{ $order->pickup_time ? substr((string) $order->pickup_time, 0, 5) : '—' }}</td>
                            <td class="px-4 py-4">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $order->payment_method === 'qris' ? 'bg-emerald-100 text-emerald-700' : 'bg-sky-100 text-sky-700' }}">
                                    {{ $order->payment_method_label }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <span class="inline-flex rounded-full bg-brand-100 px-3 py-1 text-xs font-bold text-brand-700">{{ $order->payment_status_label }}</span>
                            </td>
                            <td class="px-4 py-4">
                                <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-700">{{ $order->order_status_label }}</span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex flex-col items-end gap-1.5">
                                    <a href="{{ route('admin.orders.show', $order) }}"
                                        class="inline-flex items-center gap-1.5 rounded-full bg-brand-600 px-3.5 py-2 text-xs font-semibold text-white transition hover:bg-brand-700">
                                        Lihat Detail
                                    </a>
                                    <a href="{{ route('admin.orders.show', $order) }}#struk"
                                        class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 px-3.5 py-2 text-xs font-semibold text-brand-700 ring-1 ring-brand-950/10 transition hover:bg-brand-100">
                                        Lihat Struk
                                    </a>
                                    <a href="{{ route('admin.orders.show', $order) }}#ubah-status"
                                        class="inline-flex items-center gap-1.5 rounded-full bg-white px-3.5 py-2 text-xs font-semibold text-brand-800 ring-1 ring-brand-950/10 transition hover:bg-cream-100">
                                        Ubah Status
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="15" class="px-5 py-16 text-center">
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
