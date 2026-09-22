@extends('layouts.admin')

@section('title', 'Pelanggan')

@section('content')
    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-display text-2xl font-semibold text-brand-950">Pelanggan</h1>
            <p class="mt-1 text-sm text-brand-950/55">Pelanggan unik yang sudah melakukan pesanan di Mahligai Bakery.</p>
        </div>
        <span class="inline-flex items-center gap-2 rounded-full bg-brand-100 px-4 py-1.5 text-xs font-bold text-brand-700">
            {{ $customers->count() }} pelanggan
        </span>
    </div>

    <div class="mt-6 overflow-hidden rounded-3xl bg-white shadow-soft ring-1 ring-brand-950/5">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-brand-950/10 bg-cream-50 text-xs font-bold uppercase tracking-wide text-brand-950/50">
                        <th class="px-5 py-4">Pelanggan</th>
                        <th class="px-5 py-4">Nomor WhatsApp</th>
                        <th class="px-5 py-4">Jumlah Pesanan</th>
                        <th class="px-5 py-4">Pesanan Terakhir</th>
                        <th class="px-5 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-950/5">
                    @forelse ($customers as $customer)
                        @php
                            $latestOrder = $customer->orders->sortByDesc('id')->first();
                        @endphp
                        <tr class="transition hover:bg-brand-50/40">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-gradient-to-br from-brand-500 to-brand-700 text-sm font-bold text-white">
                                        {{ mb_strtoupper(mb_substr($customer->name, 0, 1)) }}
                                    </span>
                                    <p class="font-semibold text-brand-950">{{ $customer->name }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-brand-950/70">{{ $latestOrder?->customer_phone ?: '—' }}</td>
                            <td class="px-5 py-4">
                                <span class="inline-flex rounded-full bg-brand-100 px-3 py-1 text-xs font-bold text-brand-700">{{ $customer->orders_count }}</span>
                            </td>
                            <td class="px-5 py-4 text-xs text-brand-950/55">
                                @if ($latestOrder)
                                    {{ $latestOrder->created_at->format('d M Y, H:i') }}
                                    <span class="mt-0.5 block font-semibold text-brand-700">#{{ $latestOrder->queue_number }} · MB-{{ str_pad((string) $latestOrder->id, 4, '0', STR_PAD_LEFT) }}</span>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    @if ($latestOrder?->customer_phone)
                                        <a href="{{ \App\Support\OrderHelper::waLink($latestOrder->customer_phone, 'Halo '.$customer->name.', kami dari Mahligai Bakery.') }}"
                                            target="_blank" rel="noopener"
                                            class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-full bg-emerald-500 px-3.5 py-2 text-xs font-semibold text-white transition hover:bg-emerald-600">
                                            <svg viewBox="0 0 24 24" fill="currentColor" class="h-3.5 w-3.5"><path d="M12 2a9.9 9.9 0 0 0-8.5 14.9L2 22l5.3-1.4A10 10 0 1 0 12 2Z"/></svg>
                                            Hubungi WA
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-16 text-center">
                                <p class="text-base font-semibold text-brand-950/60">Belum ada pelanggan.</p>
                                <p class="mt-1 text-sm text-brand-950/40">Pelanggan yang sudah memesan akan muncul di sini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection