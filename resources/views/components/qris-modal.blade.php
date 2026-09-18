<div id="qris-modal" class="fixed inset-0 z-[90] hidden items-center justify-center p-4"
    role="dialog" aria-modal="true" aria-labelledby="qris-modal-title">
    <div class="absolute inset-0 bg-brand-950/70 backdrop-blur-sm" data-qris-close></div>

    <div data-qris-card
        class="relative w-full max-w-md scale-95 overflow-hidden rounded-3xl bg-white opacity-0 shadow-2xl transition-all duration-300">
        <button type="button" data-qris-close
            class="absolute right-4 top-4 z-10 grid h-10 w-10 place-items-center rounded-full bg-white/90 text-brand-900 shadow-md ring-1 ring-brand-950/10 transition hover:bg-white"
            aria-label="Tutup pembayaran QRIS">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="h-5 w-5">
                <path d="M18 6 6 18M6 6l12 12"/>
            </svg>
        </button>

        <div class="bg-gradient-to-br from-brand-800 to-brand-950 px-6 py-6 text-center text-white">
            <span class="inline-flex items-center gap-2 rounded-full bg-white/15 px-4 py-1.5 text-xs font-bold uppercase tracking-[0.14em] ring-1 ring-white/20">
                <svg viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4 text-emerald-300"><path d="M8 10h8v8H8z"/><rect x="3" y="6" width="18" height="12" rx="2"/></svg>
                Pembayaran QRIS
            </span>
            <h3 id="qris-modal-title" class="mt-3 font-display text-lg font-semibold">Bayar Pesanan Anda</h3>
        </div>

        <div class="px-6 py-6">
            <div class="mx-auto w-fit rounded-2xl bg-white p-3 ring-1 ring-brand-950/10 shadow-sm">
                <img data-qris-image src="" alt="QRIS Mahligai Bakery"
                    class="h-52 w-52 object-contain">
            </div>

            <div class="mt-5 space-y-2 rounded-2xl bg-cream-50 p-4 ring-1 ring-brand-950/5">
                <div class="flex justify-between text-sm">
                    <span class="text-brand-950/60">Total Pesanan</span>
                    <span data-qris-total class="font-semibold text-brand-950">Rp0</span>
                </div>
                <div class="flex justify-between text-sm" data-qris-fee-row>
                    <span class="text-brand-950/60">Biaya QRIS</span>
                    <span data-qris-fee class="font-semibold text-brand-950">Rp0</span>
                </div>
                <div class="flex justify-between border-t border-brand-950/10 pt-2">
                    <span class="font-semibold text-brand-900">Total Bayar</span>
                    <span data-qris-payable class="font-display text-lg font-bold text-brand-700">Rp0</span>
                </div>
            </div>

            <div class="mt-4 rounded-2xl border border-dashed border-brand-950/15 bg-brand-50/50 p-4 text-xs leading-relaxed text-brand-950/70">
                <p class="font-bold text-brand-900">Instruksi Pembayaran:</p>
                <ol class="mt-1.5 list-decimal space-y-1 pl-4">
                    <li>Buka aplikasi e-wallet atau m-banking Anda.</li>
                    <li>Pilih menu <strong>QRIS</strong> / <strong>Scan</strong>.</li>
                    <li>Scan kode QRIS di atas.</li>
                    <li>Periksa tagihan lalu selesaikan pembayaran.</li>
                    <li>Klik <strong>Konfirmasi Pembayaran</strong> setelah selesai.</li>
                </ol>
            </div>

            <div class="mt-5 flex flex-col gap-2.5 sm:flex-row">
                <button type="button" data-qris-back
                    class="inline-flex flex-1 items-center justify-center gap-2 rounded-full border-2 border-brand-950/10 px-5 py-3 text-sm font-semibold text-brand-700 transition hover:bg-brand-50">
                    Kembali
                </button>
                <button type="button" data-qris-confirm
                    class="btn-gradient inline-flex flex-1 items-center justify-center gap-2 rounded-full px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-brand-600/20">
                    Konfirmasi Pembayaran
                </button>
            </div>

            <p data-qris-confirmed class="mt-4 hidden rounded-xl bg-emerald-100 px-4 py-3 text-center text-xs font-semibold text-emerald-800"></p>
        </div>
    </div>
</div>
