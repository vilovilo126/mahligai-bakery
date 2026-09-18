<div id="product-modal" class="fixed inset-0 z-[80] hidden items-center justify-center p-0 sm:p-4"
    role="dialog" aria-modal="true" aria-labelledby="product-modal-title"
    data-wa-number="{{ config('business.whatsapp_number') }}">
    <div class="absolute inset-0 bg-brand-950/70 backdrop-blur-sm" data-modal-close></div>

    <div data-modal-card
        class="relative flex max-h-[100dvh] w-full max-w-3xl scale-95 flex-col overflow-hidden bg-white opacity-0 shadow-2xl transition-all duration-300 sm:max-h-[90dvh] sm:rounded-3xl">

        <button type="button" data-modal-close
            class="absolute right-4 top-4 z-20 grid h-10 w-10 place-items-center rounded-full bg-white/90 text-brand-900 shadow-md ring-1 ring-brand-950/10 transition hover:bg-white"
            aria-label="Tutup detail produk">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="h-5 w-5">
                <path d="M18 6 6 18M6 6l12 12"/>
            </svg>
        </button>

        {{-- STEP 1: Kustomisasi Produk --}}
        <div data-modal-step="customize" class="flex min-h-0 flex-1 flex-col">
            {{-- Header ringkas --}}
            <div class="border-b border-brand-950/5 bg-cream-50/60 px-5 pb-4 pt-5 sm:px-7">
                <div class="flex items-center gap-3">
                    <span data-modal-image-mobile class="hidden"></span>
                    <div class="min-w-0">
                        <p data-modal-category class="text-[0.65rem] font-bold uppercase tracking-[0.22em] text-brand-600"></p>
                        <h3 id="product-modal-title" data-modal-name class="mt-1 truncate font-display text-xl font-semibold leading-tight text-brand-950 sm:text-2xl"></h3>
                    </div>
                </div>
            </div>

            <div class="min-h-0 flex-1 overflow-y-auto px-5 py-5 sm:px-7">
                <p data-modal-description class="text-sm leading-relaxed text-brand-950/70"></p>

                <div data-modal-note-wrap class="mt-2 hidden">
                    <p data-modal-note class="text-xs font-medium text-brand-600"></p>
                </div>

                {{-- Paket: radio pilihan --}}
                <div data-modal-packages class="mt-6 hidden">
                    <h4 class="text-xs font-bold uppercase tracking-[0.24em] text-brand-600">Pilih Paket</h4>
                    <div data-modal-packages-list class="mt-3 space-y-2.5"></div>
                    <p data-modal-package-note class="mt-3 hidden rounded-xl bg-cream-100 p-3 text-xs font-semibold leading-relaxed text-brand-900"></p>
                </div>

                {{-- Additional: checkbox pilihan --}}
                <div data-modal-addons class="mt-6 hidden">
                    <h4 class="text-xs font-bold uppercase tracking-[0.24em] text-brand-600">Additional</h4>
                    <div data-modal-addons-list class="mt-3 space-y-2.5"></div>
                </div>

                {{-- Kuantitas --}}
                <div class="mt-6 flex items-center justify-between rounded-2xl bg-cream-50 px-4 py-3 ring-1 ring-brand-950/5">
                    <span class="text-sm font-semibold text-brand-800">Jumlah</span>
                    <div class="flex items-center gap-3">
                        <button type="button" data-qty-minus
                            class="grid h-9 w-9 place-items-center rounded-full bg-white text-brand-700 ring-1 ring-brand-950/10 transition hover:bg-brand-600 hover:text-white" aria-label="Kurangi jumlah">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" class="h-4 w-4"><path d="M5 12h14"/></svg>
                        </button>
                        <span data-qty-value class="w-8 text-center font-display text-lg font-bold text-brand-950">1</span>
                        <button type="button" data-qty-plus
                            class="grid h-9 w-9 place-items-center rounded-full bg-white text-brand-700 ring-1 ring-brand-950/10 transition hover:bg-brand-600 hover:text-white" aria-label="Tambah jumlah">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" class="h-4 w-4"><path d="M12 5v14M5 12h14"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Footer ringkasan --}}
            <div class="border-t border-brand-950/5 bg-white px-5 py-4 sm:px-7">
                <div class="space-y-1.5 pb-3 text-sm">
                    <div class="flex justify-between text-brand-950/70">
                        <span>Subtotal</span>
                        <span data-order-subtotal class="font-semibold text-brand-950">Rp0</span>
                    </div>
                    <div class="flex justify-between text-brand-950/70" data-order-qris-row>
                        <span>Biaya QRIS</span>
                        <span data-order-qris class="font-semibold text-brand-950">Rp0</span>
                    </div>
                    <div class="flex justify-between border-t border-brand-950/10 pt-2">
                        <span class="font-semibold text-brand-900">Total</span>
                        <span data-order-total class="font-display text-xl font-bold text-brand-700">Rp0</span>
                    </div>
                </div>
                <button type="button" data-open-checkout
                    class="btn-gradient inline-flex w-full items-center justify-center gap-2 rounded-full px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand-600/20">
                    Lanjut ke Pembayaran
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
                </button>
                <p data-addon-only-note class="mt-3 hidden text-center text-xs text-brand-950/50"></p>
            </div>
        </div>

        {{-- STEP 2: Checkout --}}
        <div data-modal-step="checkout" class="hidden min-h-0 flex-1 flex-col">
            <div class="border-b border-brand-950/5 bg-cream-50/60 px-5 pb-4 pt-5 sm:px-7">
                <div class="flex items-center gap-3">
                    <button type="button" data-back-customize
                        class="grid h-9 w-9 place-items-center rounded-full bg-white text-brand-700 ring-1 ring-brand-950/10 transition hover:bg-brand-50" aria-label="Kembali">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="m12 19-7-7 7-7M5 12h14"/></svg>
                    </button>
                    <div>
                        <h3 class="font-display text-lg font-semibold text-brand-950">Data Diri & Pembayaran</h3>
                        <p class="text-xs text-brand-950/50">Lengkapi untuk mengirim pesanan</p>
                    </div>
                </div>
            </div>

            <div class="min-h-0 flex-1 overflow-y-auto px-5 py-5 sm:px-7">
                <form id="checkout-form" class="space-y-4">
                    @csrf
                    <div>
                        <label for="checkout-name" class="text-xs font-semibold text-brand-800">Nama Lengkap</label>
                        <input type="text" id="checkout-name" name="customer_name" required maxlength="255"
                            placeholder="Nama Anda"
                            class="mt-1.5 w-full rounded-2xl bg-cream-100 px-4 py-3 text-sm text-brand-950 ring-1 ring-brand-950/10 transition placeholder:text-brand-950/35 focus:ring-2 focus:ring-brand-400 focus:outline-none">
                    </div>
                    <div>
                        <label for="checkout-phone" class="text-xs font-semibold text-brand-800">Nomor WhatsApp</label>
                        <input type="tel" id="checkout-phone" name="customer_phone" required maxlength="20"
                            placeholder="08xxxxxxxxxx"
                            class="mt-1.5 w-full rounded-2xl bg-cream-100 px-4 py-3 text-sm text-brand-950 ring-1 ring-brand-950/10 transition placeholder:text-brand-950/35 focus:ring-2 focus:ring-brand-400 focus:outline-none">
                    </div>

                    <div>
                        <span class="text-xs font-semibold text-brand-800">Metode Pembayaran</span>
                        <div class="mt-2 grid grid-cols-1 gap-2.5 sm:grid-cols-2">
                            <label class="flex cursor-pointer items-center gap-3 rounded-2xl border-2 border-transparent bg-brand-50 p-3.5 ring-1 ring-brand-950/10 transition has-[:checked]:border-brand-600 has-[:checked]:bg-brand-100">
                                <input type="radio" name="payment_method" value="qris" checked class="h-4 w-4 accent-brand-600">
                                <span class="flex items-center gap-2 text-sm font-semibold text-brand-900">
                                    <svg viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-emerald-600"><path d="M8 10h8v8H8z"/><rect x="3" y="6" width="18" height="12" rx="2"/></svg>
                                    QRIS
                                </span>
                            </label>
                            <label class="flex cursor-pointer items-center gap-3 rounded-2xl border-2 border-transparent bg-brand-50 p-3.5 ring-1 ring-brand-950/10 transition has-[:checked]:border-brand-600 has-[:checked]:bg-brand-100">
                                <input type="radio" name="payment_method" value="wa" class="h-4 w-4 accent-brand-600">
                                <span class="flex items-center gap-2 text-sm font-semibold text-brand-900">
                                    <svg viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-emerald-500"><path d="M12 2a9.9 9.9 0 0 0-8.5 14.9L2 22l5.3-1.4A10 10 0 1 0 12 2Z"/></svg>
                                    WhatsApp
                                </span>
                            </label>
                        </div>
                    </div>
                </form>
            </div>

            <div class="border-t border-brand-950/5 bg-white px-5 py-4 sm:px-7">
                <div class="mb-4 space-y-1.5 text-sm">
                    <div class="flex justify-between text-brand-950/70">
                        <span>Subtotal</span>
                        <span data-order-subtotal class="font-semibold text-brand-950">Rp0</span>
                    </div>
                    <div class="flex justify-between text-brand-950/70" data-order-qris-row>
                        <span>Biaya QRIS</span>
                        <span data-order-qris class="font-semibold text-brand-950">Rp0</span>
                    </div>
                    <div class="flex justify-between border-t border-brand-950/10 pt-2">
                        <span class="font-semibold text-brand-900">Total Pembayaran</span>
                        <span data-order-total class="font-display text-xl font-bold text-brand-700">Rp0</span>
                    </div>
                </div>
                <button type="button" data-submit-order
                    class="btn-gradient inline-flex w-full items-center justify-center gap-2 rounded-full px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand-600/20">
                    Konfirmasi Pesanan
                </button>
                <p data-checkout-error class="mt-3 hidden rounded-xl bg-rose-100 px-4 py-2.5 text-xs font-semibold text-rose-700"></p>
            </div>
        </div>
    </div>
</div>
