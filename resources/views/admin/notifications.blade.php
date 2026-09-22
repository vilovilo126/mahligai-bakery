@extends('layouts.admin')

@section('title', 'Notifikasi')

@section('content')
    <div class="rounded-3xl bg-white p-6 shadow-soft ring-1 ring-brand-950/5">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h1 class="font-display text-xl font-semibold text-brand-950">Notifikasi</h1>
                <p class="mt-1 text-sm text-brand-950/55">Pesanan baru, chat pelanggan & aktivitas lainnya.</p>
            </div>
            @if ($notifications->isNotEmpty())
                <button data-mark-all-read class="shrink-0 text-sm font-semibold text-brand-600 transition hover:text-brand-800 hover:underline">
                    Tandai semua dibaca
                </button>
            @endif
        </div>

        <div class="mt-6 space-y-3">
            @forelse ($notifications as $notification)
                @php
                    $data = $notification->data;
                    $read = $notification->read();
                @endphp
                <div class="{{ $read ? 'bg-white ring-1 ring-brand-950/5' : 'border-l-4 border-brand-600 bg-brand-50/60 ring-1 ring-brand-950/5' }} rounded-2xl p-5">
                    @if (! $read)
                        <form action="{{ route('admin.notifications.readOne', $notification->id) }}" method="POST" class="float-right">
                            @csrf
                            <button type="submit" class="text-xs font-semibold text-brand-600 hover:underline">Tandai dibaca</button>
                        </form>
                    @endif
                    @if (! empty($data['url']))
                        <a href="{{ $data['url'] }}" class="block font-semibold text-brand-900 hover:underline">{{ $data['title'] ?? 'Notifikasi' }}</a>
                    @else
                        <p class="font-semibold text-brand-900">{{ $data['title'] ?? 'Notifikasi' }}</p>
                    @endif
                    <p class="mt-1 text-sm leading-relaxed text-brand-950/60">{{ $data['body'] ?? '' }}</p>
                    <p class="mt-2 text-xs text-brand-950/40">{{ $notification->created_at->diffForHumans() }}</p>
                </div>
            @empty
                <p class="rounded-2xl bg-cream-50 px-4 py-12 text-center text-sm text-brand-950/45">Belum ada notifikasi.</p>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    </div>

    <script data-mark-all>
        document.querySelector('[data-mark-all-read]')?.addEventListener('click', async () => {
            try {
                await fetch('{{ route('admin.notifications.read') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                        Accept: 'application/json',
                    },
                });
            } finally {
                window.location.reload();
            }
        });
    </script>
@endsection