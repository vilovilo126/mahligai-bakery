<div id="qris-modal" class="fixed inset-0 z-[90] hidden items-center justify-center p-4"
    role="dialog" aria-modal="true" aria-labelledby="qris-modal-title">
    <div class="absolute inset-0 bg-brand-950/70 backdrop-blur-sm" data-qris-close></div>

    <div data-qris-card
        class="relative flex max-h-[100dvh] w-full max-w-md scale-95 flex-col overflow-hidden rounded-3xl bg-white opacity-0 shadow-2xl transition-all duration-300 sm:max-h-[92dvh]">
        <button type="button" data-qris-close
            class="absolute right-4 top-4 z-10 grid h-10 w-10 place-items-center rounded-full bg-white/90 text-brand-900 shadow-md ring-1 ring-brand-950/10 transition hover:bg-white"
            aria-label="Tutup pembayaran QRIS">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="h-5 w-5">
                <path d="M18 6 6 18M6 6l12 12"/>
            </svg>
        </button>

        <div class="bg-gradient-to-br from-brand-800 to-brand-950 px-6 py-6 text-center text-white">
            <span class="inline-flex items-center gap-2 rounded-full bg-white/15 px-4 py-1.5 text-xs font-bold uppercase tracking-[0.14em] ring-1 ring-white/20">
                <img src="{{ asset('images/payment/qris-logo.svg') }}" alt="Logo QRIS" class="h-4 w-4 object-contain">
                Pembayaran QRIS
            </span>
            <h3 id="qris-modal-title" class="mt-3 font-display text-lg font-semibold">Bayar Pesanan Anda</h3>
            <p class="mt-1 text-sm text-white/70">No. Pesanan: <span data-qris-order-no class="font-bold text-white">#—</span></p>
            <p class="mt-1 inline-flex items-center gap-1.5 rounded-full bg-amber-400/20 px-3 py-1 text-xs font-bold text-amber-200 ring-1 ring-amber-300/30">
                <svg viewBox="0 0 24 24" fill="currentColor" class="h-3.5 w-3.5"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm1 15h-2v-6h2Zm0-8h-2V7h2Z"/></svg>
                Menunggu Pembayaran
            </p>
        </div>

        <div class="min-h-0 flex-1 overflow-y-auto px-6 py-6">
            <div class="mx-auto w-fit rounded-2xl bg-white p-3 ring-1 ring-brand-950/10 shadow-sm">
                <img data-qris-image src="" alt="QRIS Mahligai Bakery"
                    class="h-48 w-48 object-contain sm:h-52 sm:w-52">
            </div>

            <div data-qris-items class="mt-5 hidden rounded-2xl bg-cream-50 p-4 ring-1 ring-brand-950/5">
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-brand-600">Ringkasan Pesanan</p>
                <ul data-qris-items-list class="mt-3 space-y-2.5 text-sm"></ul>
            </div>

            <div class="mt-5 space-y-2 rounded-2xl bg-cream-50 p-4 ring-1 ring-brand-950/5">
                <div class="flex justify-between text-sm">
                    <span class="text-brand-950/60">Subtotal</span>
                    <span data-qris-subtotal class="font-semibold text-brand-950">Rp0</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-brand-950/60">Biaya QRIS</span>
                    <span data-qris-fee class="font-semibold text-brand-950">Rp0</span>
                </div>
                <div class="flex justify-between border-t border-brand-950/10 pt-2">
                    <span class="font-semibold text-brand-900">Total Bayar</span>
                    <span data-qris-payable class="font-display text-xl font-bold text-brand-700">Rp0</span>
                </div>
            </div>

            <div class="mt-4 rounded-2xl border border-dashed border-brand-950/15 bg-brand-50/50 p-4 text-xs leading-relaxed text-brand-950/70">
                <p class="font-bold text-brand-900">Instruksi Pembayaran:</p>
                <ol class="mt-1.5 list-decimal space-y-1 pl-4">
                    <li>Buka aplikasi e-wallet atau m-banking Anda.</li>
                    <li>Pilih menu <strong>QRIS</strong> / <strong>Scan</strong>.</li>
                    <li>Scan kode QRIS di atas.</li>
                    <li>Periksa tagihan lalu selesaikan pembayaran.</li>
                    <li>Status pembayaran akan dikonfirmasi oleh admin kami.</li>
                </ol>
            </div>
        </div>
    </div>
</div>