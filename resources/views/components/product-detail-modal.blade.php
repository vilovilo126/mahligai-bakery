<div id="product-modal" class="fixed inset-0 z-[80] hidden items-end justify-center p-0 sm:items-center sm:p-4"
    role="dialog" aria-modal="true" aria-labelledby="product-modal-title">
    <div class="absolute inset-0 bg-brand-950/70 backdrop-blur-sm" data-modal-close></div>

    <div data-modal-card
        class="relative flex max-h-[100dvh] w-full max-w-3xl scale-95 flex-col overflow-hidden bg-white opacity-0 shadow-2xl transition-all duration-300 rounded-t-3xl sm:max-h-[90dvh] sm:rounded-3xl">

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
            <div class="shrink-0 border-b border-brand-950/5 bg-cream-50/60 px-5 pb-4 pt-5 sm:px-7">
                <div class="flex items-center gap-3">
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
            <div class="shrink-0 border-t border-brand-950/5 bg-white px-5 py-4 sm:px-7">
                <div class="space-y-1.5 pb-3 text-sm">
                    <div class="flex justify-between text-brand-950/70">
                        <span>Subtotal Produk Ini</span>
                        <span data-line-subtotal class="font-semibold text-brand-950">Rp0</span>
                    </div>
                    <div class="flex justify-between text-brand-950/70" data-line-qris-row>
                        <span>Biaya QRIS</span>
                        <span data-line-qris class="font-semibold text-brand-950">Rp0</span>
                    </div>
                    <div class="flex justify-between border-t border-brand-950/10 pt-2">
                        <span class="font-semibold text-brand-900">Total Produk Ini</span>
                        <span data-line-total class="font-display text-lg font-bold text-brand-700">Rp0</span>
                    </div>
                </div>

                <div data-cart-pill class="mb-3 hidden items-center justify-between rounded-2xl bg-brand-50 px-4 py-2.5 text-sm ring-1 ring-brand-950/5">
                    <span class="font-semibold text-brand-900" data-cart-pill-text></span>
                    <button type="button" data-clear-cart class="text-xs font-semibold text-brand-600 underline-offset-2 transition hover:text-brand-800 hover:underline">
                        Kosongkan
                    </button>
                </div>

                <div class="flex flex-col gap-2.5 sm:flex-row">
                    <button type="button" data-add-to-cart
                        class="inline-flex flex-1 items-center justify-center gap-2 rounded-full border-2 border-brand-600/20 bg-brand-50 px-6 py-3.5 text-sm font-semibold text-brand-700 transition hover:bg-brand-100">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M12 5v14M5 12h14"/></svg>
                        Tambah ke Keranjang
                    </button>
                    <button type="button" data-open-checkout
                        class="btn-gradient inline-flex flex-1 items-center justify-center gap-2 rounded-full px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand-600/20 disabled:cursor-not-allowed disabled:opacity-40">
                        Lanjut ke Pembayaran
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
                    </button>
                </div>
                <p data-addon-only-note class="mt-3 hidden text-center text-xs text-brand-950/50"></p>
            </div>
        </div>

        {{-- STEP 2: Data Diri & Pembayaran --}}
        <div data-modal-step="checkout" class="hidden min-h-0 flex flex-1 flex-col">
            <div class="shrink-0 border-b border-brand-950/5 bg-cream-50/60 px-5 pb-4 pt-5 sm:px-7">
                <div class="flex items-center gap-3">
                    <button type="button" data-back-customize
                        class="grid h-9 w-9 place-items-center rounded-full bg-white text-brand-700 ring-1 ring-brand-950/10 transition hover:bg-brand-50" aria-label="Kembali">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="m12 19-7-7 7-7M5 12h14"/></svg>
                    </button>
                    <div class="min-w-0 pr-10">
                        <h3 class="font-display text-lg font-semibold text-brand-950">Data Diri & Pembayaran</h3>
                        <p class="text-xs text-brand-950/50">Periksa pesanan lalu lengkapi data Anda</p>
                    </div>
                </div>
            </div>

            <div class="min-h-0 flex-1 overflow-y-auto px-5 py-5 pb-safe sm:px-7">
                {{-- Ringkasan pesanan (cart) --}}
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-[0.24em] text-brand-600">Ringkasan Pesanan</h4>
                    <div data-cart-list class="mt-3 space-y-3"></div>
                    <p data-cart-empty class="mt-3 hidden rounded-2xl bg-cream-100 px-4 py-3 text-sm font-semibold text-brand-700">
                        Keranjang Anda masih kosong. Silakan pilih produk terlebih dahulu.
                    </p>
                </div>

                {{-- Data diri --}}
                <form id="checkout-form" class="mt-7 space-y-4">
                    @csrf
                    <div>
                        <label for="checkout-name" class="text-xs font-semibold text-brand-800">Nama Lengkap</label>
                        <input type="text" id="checkout-name" name="customer_name" required maxlength="255"
                            value="{{ auth()->user()?->name ?? '' }}"
                            placeholder="Nama Anda"
                            class="mt-1.5 w-full rounded-2xl bg-cream-100 px-4 py-3 text-sm text-brand-950 ring-1 ring-brand-950/10 transition placeholder:text-brand-950/35 focus:ring-2 focus:ring-brand-400 focus:outline-none">
                        <p data-error-name class="mt-1.5 hidden text-xs font-semibold text-rose-600"></p>
                    </div>
                    <div>
                        <label for="checkout-phone" class="text-xs font-semibold text-brand-800">Nomor WhatsApp</label>
                        <input type="tel" id="checkout-phone" name="customer_phone" required maxlength="20"
                            value="{{ auth()->user()?->whatsapp_number ?? '' }}"
                            placeholder="08xxxxxxxxxx"
                            class="mt-1.5 w-full rounded-2xl bg-cream-100 px-4 py-3 text-sm text-brand-950 ring-1 ring-brand-950/10 transition placeholder:text-brand-950/35 focus:ring-2 focus:ring-brand-400 focus:outline-none">
                        <p data-error-phone class="mt-1.5 hidden text-xs font-semibold text-rose-600"></p>
                    </div>

                    <div>
                        <span class="text-xs font-semibold text-brand-800">Jadwal Pengambilan</span>
                        <div class="mt-2 grid grid-cols-1 gap-2.5 sm:grid-cols-2">
                            <div>
                                <label for="checkout-pickup-date" class="mb-1 block text-xs text-brand-950/55">Tanggal</label>
                                <input type="date" id="checkout-pickup-date" name="pickup_date" required
                                    class="w-full rounded-2xl bg-cream-100 px-4 py-3 text-sm text-brand-950 ring-1 ring-brand-950/10 transition focus:ring-2 focus:ring-brand-400 focus:outline-none">
                                <p data-error-pickup-date class="mt-1.5 hidden text-xs font-semibold text-rose-600"></p>
                            </div>
                            <div>
                                <label for="checkout-pickup-time" class="mb-1 block text-xs text-brand-950/55">Jam</label>
                                <input type="time" id="checkout-pickup-time" name="pickup_time" required
                                    class="w-full rounded-2xl bg-cream-100 px-4 py-3 text-sm text-brand-950 ring-1 ring-brand-950/10 transition focus:ring-2 focus:ring-brand-400 focus:outline-none">
                                <p data-error-pickup-time class="mt-1.5 hidden text-xs font-semibold text-rose-600"></p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="checkout-bakery-request" class="text-xs font-semibold text-brand-800">Request untuk Bakery <span class="font-normal text-brand-950/45">(opsional)</span></label>
                        <textarea id="checkout-bakery-request" name="bakery_request" rows="2" maxlength="1000"
                            placeholder="Contoh: tolong jangan terlalu manis / tulis pesan di kue"
                            class="mt-1.5 w-full resize-none rounded-2xl bg-cream-100 px-4 py-3 text-sm text-brand-950 ring-1 ring-brand-950/10 transition placeholder:text-brand-950/35 focus:ring-2 focus:ring-brand-400 focus:outline-none"></textarea>
                    </div>

                    <div>
                        <span class="text-xs font-semibold text-brand-800">Metode Pembayaran</span>
                        <div class="mt-2 grid grid-cols-1 gap-2.5 sm:grid-cols-2">
                            <label class="flex cursor-pointer items-center gap-3 rounded-2xl border-2 border-brand-950/10 bg-white p-3.5 ring-1 ring-brand-950/5 transition has-[:checked]:border-brand-600 has-[:checked]:bg-brand-50 has-[:checked]:ring-brand-600">
                                <input type="radio" name="payment_method" value="qris" checked class="peer h-4 w-4 accent-brand-600">
                                <span class="flex items-center gap-2.5 text-sm font-semibold text-brand-900">
                                    <img src="{{ asset('images/payment/qris-logo.svg') }}" alt="Logo QRIS"
                                        class="h-8 w-8 shrink-0 rounded-lg bg-white object-contain ring-1 ring-brand-950/10">
                                    QRIS
                                </span>
                            </label>
                            <label class="flex cursor-pointer items-center gap-3 rounded-2xl border-2 border-brand-950/10 bg-white p-3.5 ring-1 ring-brand-950/5 transition has-[:checked]:border-brand-600 has-[:checked]:bg-brand-50 has-[:checked]:ring-brand-600">
                                <input type="radio" name="payment_method" value="wa" class="peer h-4 w-4 accent-brand-600">
                                <span class="flex items-center gap-2.5 text-sm font-semibold text-brand-900">
                                    <span class="grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-emerald-50 ring-1 ring-brand-950/10">
                                        <svg viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-emerald-600"><path d="M12 2a9.9 9.9 0 0 0-8.5 14.9L2 22l5.3-1.4A10 10 0 1 0 12 2Z"/></svg>
                                    </span>
                                    WhatsApp
                                </span>
                            </label>
                        </div>
                    </div>

                    {{-- Rincian pembayaran --}}
                    <div class="rounded-2xl bg-cream-50 p-4 ring-1 ring-brand-950/5">
                        <h4 class="text-xs font-bold uppercase tracking-[0.24em] text-brand-600">Rincian Pembayaran</h4>
                        <div class="mt-3 space-y-1.5 text-sm">
                            <div class="flex justify-between text-brand-950/70">
                                <span>Subtotal</span>
                                <span data-order-subtotal class="font-semibold text-brand-950">Rp0</span>
                            </div>
                            <div class="flex justify-between text-brand-950/70" data-order-qris-row>
                                <span>Biaya QRIS</span>
                                <span data-order-qris class="font-semibold text-brand-950">Rp0</span>
                            </div>
                            <div class="mt-2 flex items-center justify-between rounded-2xl bg-gradient-to-r from-brand-700 to-brand-900 px-4 py-3 text-white">
                                <span class="text-sm font-bold">Total Pembayaran</span>
                                <span data-order-total class="font-display text-xl font-bold text-white">Rp0</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="shrink-0 border-t border-brand-950/5 bg-white px-5 py-4 pb-safe sm:px-7">
                <button type="button" data-submit-order
                    class="btn-gradient inline-flex w-full items-center justify-center gap-2 rounded-full px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand-600/20 disabled:cursor-not-allowed disabled:opacity-60">
                    <svg data-submit-spinner class="hidden h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4Z"></path>
                    </svg>
                    <span data-submit-label>Konfirmasi Pesanan</span>
                </button>
                <p data-checkout-error class="mt-3 hidden rounded-xl bg-rose-100 px-4 py-2.5 text-xs font-semibold text-rose-700"></p>
            </div>
        </div>

        {{-- STEP 3: Sukses & Struk --}}
        <div data-modal-step="receipt" class="hidden min-h-0 flex flex-1 flex-col overflow-y-auto">
            <div class="px-5 py-8 text-center sm:px-7">
                <span class="success-check mx-auto grid h-16 w-16 place-items-center rounded-full bg-emerald-500 text-white">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8"><path d="M20 6 9 17l-5-5"/></svg>
                </span>
                <h3 class="mt-4 font-display text-xl font-semibold text-brand-950">Pesanan Berhasil Dibuat!</h3>
                <p class="mt-1 text-sm text-brand-950/55">Terima kasih! Berikut struk pesanan Anda.</p>
            </div>

            <div data-receipt-root class="px-5 sm:px-7"></div>

            <div class="space-y-2.5 px-5 py-6 sm:px-7">
                <button type="button" data-receipt-pay
                    class="btn-gradient hidden w-full items-center justify-center gap-2 rounded-full px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand-600/20">
                    <svg viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4"><path d="M12 2a9.9 9.9 0 0 0-8.5 14.9L2 22l5.3-1.4A10 10 0 1 0 12 2Z"/></svg>
                    <span data-receipt-pay-label>Bayar via WhatsApp</span>
                </button>
                <div class="grid grid-cols-1 gap-2.5 sm:grid-cols-2">
                    <a href="{{ route('customer.orders') }}" class="inline-flex items-center justify-center gap-2 rounded-full border-2 border-brand-600/20 bg-brand-50 px-6 py-3 text-sm font-semibold text-brand-700 transition hover:bg-brand-100">
                        Lihat Pesanan Saya
                    </a>
                    <button type="button" data-receipt-close class="inline-flex items-center justify-center gap-2 rounded-full border-2 border-brand-950/10 bg-white px-6 py-3 text-sm font-semibold text-brand-800 transition hover:bg-cream-100">
                        Selesai
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>