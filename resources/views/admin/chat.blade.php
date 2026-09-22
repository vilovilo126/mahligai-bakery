@extends('layouts.admin')

@section('title', 'Chat Pelanggan')

@section('content')
<div data-admin-chat-page class="overflow-hidden rounded-3xl bg-white shadow-soft ring-1 ring-brand-950/5">
    <div class="grid grid-cols-1 md:grid-cols-3">
        {{-- Daftar percakapan --}}
        <div class="border-b border-brand-950/5 md:border-b-0 md:border-r">
            <div class="border-b border-brand-950/5 bg-cream-50 px-4 py-3.5">
                <h2 class="text-xs font-bold uppercase tracking-[0.2em] text-brand-600">Percakapan</h2>
            </div>
            <div data-chat-list class="max-h-72 overflow-y-auto md:max-h-[66vh]">
                @forelse ($chats as $chat)
                    <button type="button" data-chat-item data-chat-id="{{ $chat->id }}"
                        data-customer-name="{{ $chat->customer?->name ?? 'Konsumen' }}"
                        class="flex w-full items-center gap-3 border-b border-brand-950/5 px-4 py-3 text-left transition hover:bg-brand-50">
                            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-gradient-to-br from-brand-500 to-brand-700 text-sm font-bold text-white">
                                {{ mb_strtoupper(mb_substr($chat->customer?->name ?? 'K', 0, 1)) }}
                            </span>
                            <span class="min-w-0 flex-1">
                                <span class="flex items-center justify-between gap-2">
                                    <span class="truncate text-sm font-semibold text-brand-950">{{ $chat->customer?->name ?? 'Konsumen' }}</span>
                                    @if ($chat->last_message_at)
                                        <span class="shrink-0 text-[0.65rem] text-brand-950/40">{{ $chat->last_message_at->diffForHumans() }}</span>
                                    @endif
                                </span>
                                <span class="mt-0.5 block truncate text-xs text-brand-950/50">{{ $chat->messages()->latest('id')->value('message') }}</span>
                            </span>
                            @if ($chat->unread_by_admin_count > 0)
                                <span data-chat-unread data-count="{{ $chat->unread_by_admin_count }}"
                                    class="grid h-5 min-w-5 shrink-0 place-items-center rounded-full bg-rose-500 px-1.5 text-[0.65rem] font-bold leading-5 text-white">
                                    {{ $chat->unread_by_admin_count }}
                                </span>
                            @endif
                    </button>
                @empty
                    <p class="px-4 py-10 text-center text-sm text-brand-950/45">Belum ada percakapan.</p>
                @endforelse
            </div>
        </div>

        {{-- Percakapan aktif --}}
        <div class="flex min-h-[60vh] flex-col md:col-span-2">
            <div data-chat-header class="flex items-center gap-3 border-b border-brand-950/5 bg-cream-50/80 px-4 py-3.5">
                <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-gradient-to-br from-brand-500 to-brand-700 text-sm font-bold text-white" data-chat-avatar>?</span>
                <div class="min-w-0">
                    <p class="truncate text-sm font-bold text-brand-950" data-chat-title>Pilih percakapan</p>
                    <p class="text-xs text-brand-950/45" data-chat-subtitle>Pesan pelanggan akan tampil di sini</p>
                </div>
            </div>

            <div data-chat-messages class="min-h-0 flex-1 space-y-3 overflow-y-auto bg-cream-50 px-4 py-5"></div>

            <form data-chat-form class="hidden items-end gap-2 border-t border-brand-950/10 bg-white px-4 py-3">
                <textarea data-chat-input rows="1" maxlength="2000" placeholder="Balas pesan…"
                    class="max-h-32 flex-1 resize-none rounded-2xl bg-cream-100 px-4 py-3 text-sm text-brand-950 ring-1 ring-brand-950/10 transition placeholder:text-brand-950/35 focus:ring-2 focus:ring-brand-400 focus:outline-none"></textarea>
                <button type="submit" data-chat-send
                    class="btn-gradient grid h-11 w-11 shrink-0 place-items-center rounded-full text-white shadow-lg shadow-brand-600/20 disabled:opacity-40"
                    aria-label="Kirim balasan">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection