<div id="customer-chat" class="fixed inset-0 z-[90] hidden items-end justify-center sm:items-center sm:p-4"
    role="dialog" aria-modal="true" aria-labelledby="customer-chat-title">
    <div class="absolute inset-0 bg-brand-950/70 backdrop-blur-sm" data-chat-close></div>

    <div data-chat-card
        class="relative flex h-[80dvh] w-full max-w-lg scale-95 flex-col overflow-hidden rounded-t-3xl bg-white opacity-0 shadow-2xl transition-all duration-300 sm:h-[70dvh] sm:rounded-3xl">
        {{-- Header --}}
        <div class="flex items-center justify-between gap-3 bg-gradient-to-br from-brand-700 to-brand-950 px-5 py-4 text-white">
            <div class="flex items-center gap-3">
                <span class="grid h-10 w-10 place-items-center rounded-full bg-white/15 ring-1 ring-white/20">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2Z"/></svg>
                </span>
                <div>
                    <h3 id="customer-chat-title" class="font-display text-base font-semibold">Admin Mahligai Bakery</h3>
                    <p class="text-xs text-white/70">Kami balas secepatnya</p>
                </div>
            </div>
            <button type="button" data-chat-close
                class="grid h-9 w-9 place-items-center rounded-full bg-white/10 ring-1 ring-white/20 transition hover:bg-white/20" aria-label="Tutup chat">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="h-4.5 w-4.5"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Pesan --}}
        <div data-chat-messages class="min-h-0 flex-1 space-y-3 overflow-y-auto bg-cream-50 px-4 py-5"></div>

        {{-- Input --}}
        <form data-chat-form class="flex items-end gap-2 border-t border-brand-950/10 bg-white px-4 py-3">
            <textarea data-chat-input rows="1" maxlength="2000"
                placeholder="Tulis pertanyaan Anda…"
                class="max-h-32 flex-1 resize-none rounded-2xl bg-cream-100 px-4 py-3 text-sm text-brand-950 ring-1 ring-brand-950/10 transition placeholder:text-brand-950/35 focus:ring-2 focus:ring-brand-400 focus:outline-none"></textarea>
            <button type="submit" data-chat-send
                class="btn-gradient grid h-11 w-11 shrink-0 place-items-center rounded-full text-white shadow-lg shadow-brand-600/20 disabled:opacity-40"
                aria-label="Kirim pesan">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
            </button>
        </form>
    </div>
</div>