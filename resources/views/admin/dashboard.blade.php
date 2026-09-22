@extends('layouts.admin')

@section('title', 'Dasbor')

@section('content')
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div class="rounded-3xl bg-white p-5 shadow-soft ring-1 ring-brand-950/5">
            <p class="text-xs font-bold uppercase tracking-[0.16em] text-brand-950/45">Total Pesanan</p>
            <p class="mt-2 font-display text-3xl font-bold text-brand-900">{{ number_format($stats['total_orders'], 0, ',', '.') }}</p>
        </div>
        <div class="rounded-3xl bg-white p-5 shadow-soft ring-1 ring-brand-950/5">
            <p class="text-xs font-bold uppercase tracking-[0.16em] text-brand-950/45">Total Pelanggan</p>
            <p class="mt-2 font-display text-3xl font-bold text-brand-900">{{ number_format($stats['total_customers'], 0, ',', '.') }}</p>
        </div>
        <div class="rounded-3xl bg-white p-5 shadow-soft ring-1 ring-brand-950/5">
            <p class="text-xs font-bold uppercase tracking-[0.16em] text-brand-950/45">Pesanan Hari Ini</p>
            <p class="mt-2 font-display text-3xl font-bold text-brand-900">{{ number_format($stats['today_orders'], 0, ',', '.') }}</p>
        </div>
        <div class="rounded-3xl bg-white p-5 shadow-soft ring-1 ring-brand-950/5">
            <p class="text-xs font-bold uppercase tracking-[0.16em] text-amber-600">Menunggu Pembayaran</p>
            <p class="mt-2 font-display text-3xl font-bold text-amber-700">{{ number_format($stats['pending_orders'], 0, ',', '.') }}</p>
        </div>
        <div class="rounded-3xl bg-white p-5 shadow-soft ring-1 ring-brand-950/5">
            <p class="text-xs font-bold uppercase tracking-[0.16em] text-sky-600">Sedang Diproses</p>
            <p class="mt-2 font-display text-3xl font-bold text-sky-700">{{ number_format($stats['in_progress_orders'], 0, ',', '.') }}</p>
        </div>
        <div class="rounded-3xl bg-white p-5 shadow-soft ring-1 ring-brand-950/5">
            <p class="text-xs font-bold uppercase tracking-[0.16em] text-emerald-600">Siap Diambil</p>
            <p class="mt-2 font-display text-3xl font-bold text-emerald-700">{{ number_format($stats['ready_orders'], 0, ',', '.') }}</p>
        </div>
    </div>

    <a href="{{ route('admin.chat') }}" class="mt-4 flex items-center justify-between rounded-3xl bg-white p-5 shadow-soft ring-1 ring-brand-950/5 transition hover:shadow-lg">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.16em] text-rose-600">Chat Belum Dibaca</p>
            <p class="mt-1 text-sm text-brand-950/55">Percakapan pelanggan yang belum Anda lihat.</p>
        </div>
        <span class="grid h-12 w-12 place-items-center rounded-2xl bg-rose-600 font-display text-lg font-bold text-white">{{ number_format($stats['unread_chats'], 0, ',', '.') }}</span>
    </a>

    <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
        {{-- Pesanan terbaru --}}
        <div class="rounded-3xl bg-white p-6 shadow-soft ring-1 ring-brand-950/5">
            <div class="flex items-center justify-between gap-3">
                <h2 class="text-xs font-bold uppercase tracking-[0.2em] text-brand-600">Pesanan Terbaru</h2>
                <a href="{{ route('admin.orders.index') }}" class="text-xs font-semibold text-brand-600 hover:underline">Lihat semua</a>
            </div>

            <div class="mt-4 space-y-3">
                @forelse ($pendingOrders as $order)
                    <a href="{{ route('admin.orders.show', $order) }}" class="flex items-center gap-3 rounded-2xl bg-cream-50 p-3.5 ring-1 ring-brand-950/5 transition hover:bg-brand-50">
                        <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 text-xs font-bold text-white">#{{ $order->queue_number }}</span>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-semibold text-brand-950">{{ $order->customer_name }}</p>
                            <p class="mt-0.5 text-xs text-brand-950/50">{{ $order->order_number }} · {{ $order->pickup_label ?: $order->created_at->format('d M, H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-brand-800">Rp{{ number_format($order->total, 0, ',', '.') }}</p>
                            <span class="mt-1 inline-flex rounded-full bg-amber-100 px-2.5 py-0.5 text-[0.65rem] font-bold text-amber-700">{{ $order->payment_status_label }}</span>
                        </div>
                    </a>
                @empty
                    <p class="rounded-2xl bg-cream-50 px-4 py-8 text-center text-sm text-brand-950/45">Tidak ada pesanan tertunda.</p>
                @endforelse
            </div>
        </div>

        {{-- Aktivitas / notifikasi --}}
        <div class="rounded-3xl bg-white p-6 shadow-soft ring-1 ring-brand-950/5">
            <h2 class="text-xs font-bold uppercase tracking-[0.2em] text-brand-600">Aktivitas Terbaru</h2>
            <div class="mt-4 space-y-3">
                @forelse ($recentNotifications as $notification)
                    @php $data = $notification->data; @endphp
                    <div class="{{ $notification->read() ? '' : 'bg-brand-50/70' }} flex gap-3 rounded-2xl p-3 ring-1 ring-brand-950/5">
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-brand-900">{{ $data['title'] ?? 'Notifikasi' }}</p>
                            <p class="mt-0.5 line-clamp-2 text-xs text-brand-950/55">{{ $data['body'] ?? '' }}</p>
                            <p class="mt-1 text-[0.7rem] text-brand-950/40">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <p class="rounded-2xl bg-cream-50 px-4 py-8 text-center text-sm text-brand-950/45">Belum ada aktivitas.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection