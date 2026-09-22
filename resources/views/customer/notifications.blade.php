@extends('layouts.landing')

@section('title', 'Notifikasi · Mahligai Bakery')

@section('content')
    <main class="min-h-screen bg-cream-50 pt-28 pb-20 text-brand-950">
        <div class="mx-auto w-full max-w-3xl px-4 sm:px-6 lg:px-8">
            <a href="{{ route('menu') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-600 transition hover:text-brand-800">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="m12 19-7-7 7-7M5 12h14"/></svg>
                Kembali ke Menu
            </a>

            <div class="mt-4 flex items-center justify-between">
                <div>
                    <h1 class="font-display text-2xl font-semibold">Notifikasi</h1>
                    <p class="mt-1 text-sm text-brand-950/55">Pemberitahuan status pesanan & chat admin.</p>
                </div>
                @if ($notifications->isNotEmpty())
                    <button data-mark-all-read
                        class="text-sm font-semibold text-brand-600 transition hover:text-brand-800 hover:underline">
                        Tandai semua dibaca
                    </button>
                @endif
            </div>

            <div class="mt-8 space-y-3">
                @forelse ($notifications as $notification)
                    @php
                        $data = $notification->data;
                        $read = $notification->read();
                    @endphp
                    <div class="{{ $read ? 'bg-white' : 'border-l-4 border-brand-600 bg-brand-50/60' }} rounded-2xl p-5 shadow-soft ring-1 ring-brand-950/5">
                        @if (! $read)
                            <form action="{{ route('customer.notifications.readOne', $notification->id) }}" method="POST" class="float-right">
                                @csrf
                                <button type="submit" class="text-xs font-semibold text-brand-600 hover:underline">Tandai dibaca</button>
                            </form>
                        @endif
                        @if (! empty($data['url']))
                            <a href="{{ $data['url'] }}" class="block font-semibold text-brand-900 hover:underline">
                                {{ $data['title'] ?? 'Notifikasi' }}
                            </a>
                        @else
                            <p class="font-semibold text-brand-900">{{ $data['title'] ?? 'Notifikasi' }}</p>
                        @endif
                        <p class="mt-1 text-sm leading-relaxed text-brand-950/60">{{ $data['body'] ?? '' }}</p>
                        <p class="mt-2 text-xs text-brand-950/40">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <div class="rounded-3xl bg-white px-6 py-16 text-center shadow-soft ring-1 ring-brand-950/5">
                        <span class="mx-auto grid h-16 w-16 place-items-center rounded-full bg-brand-100 text-brand-600">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                        </span>
                        <p class="mt-4 text-base font-semibold text-brand-950/70">Belum ada notifikasi</p>
                        <p class="mt-1 text-sm text-brand-950/45">Notifikasi pesanan dan balasan admin akan tampil di sini.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $notifications->links() }}
            </div>
        </div>
    </main>

    <script data-mark-all>
        document.querySelector('[data-mark-all-read]')?.addEventListener('click', async () => {
            try {
                await fetch('{{ route('customer.notifications.read') }}', {
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