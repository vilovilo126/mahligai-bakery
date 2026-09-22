const modal = document.getElementById('product-modal');
const body = document.body;

if (modal) {
    const modalCategory = modal.querySelector('[data-modal-category]');
    const modalName = modal.querySelector('[data-modal-name]');
    const modalDescription = modal.querySelector('[data-modal-description]');
    const modalNoteWrap = modal.querySelector('[data-modal-note-wrap]');
    const modalNote = modal.querySelector('[data-modal-note]');
    const modalPackages = modal.querySelector('[data-modal-packages]');
    const modalPackagesList = modal.querySelector('[data-modal-packages-list]');
    const modalPackageNote = modal.querySelector('[data-modal-package-note]');
    const modalAddOns = modal.querySelector('[data-modal-addons]');
    const modalAddOnsList = modal.querySelector('[data-modal-addons-list]');
    const modalCloseButtons = modal.querySelectorAll('[data-modal-close]');

    const stepCustomize = modal.querySelector('[data-modal-step="customize"]');
    const stepCheckout = modal.querySelector('[data-modal-step="checkout"]');
    const btnOpenCheckout = modal.querySelector('[data-open-checkout]');
    const btnAddToCart = modal.querySelector('[data-add-to-cart]');
    const btnClearCart = modal.querySelector('[data-clear-cart]');
    const cartPill = modal.querySelector('[data-cart-pill]');
    const cartPillText = modal.querySelector('[data-cart-pill-text]');
    const btnBackCustomize = modal.querySelector('[data-back-customize]');
    const btnSubmitOrder = modal.querySelector('[data-submit-order]');
    const submitSpinner = modal.querySelector('[data-submit-spinner]');
    const submitLabel = modal.querySelector('[data-submit-label]');
    const qtyMinus = modal.querySelector('[data-qty-minus]');
    const qtyPlus = modal.querySelector('[data-qty-plus]');
    const qtyValue = modal.querySelector('[data-qty-value]');

    // Step 3: sukses & struk
    const stepReceipt = modal.querySelector('[data-modal-step="receipt"]');
    const receiptRoot = modal.querySelector('[data-receipt-root]');
    const receiptPay = modal.querySelector('[data-receipt-pay]');
    const receiptPayLabel = modal.querySelector('[data-receipt-pay-label]');
    const receiptClose = modal.querySelector('[data-receipt-close]');

    // Footer ringkasan produk (step 1)
    const lineSubtotal = modal.querySelector('[data-line-subtotal]');
    const lineQris = modal.querySelector('[data-line-qris]');
    const lineQrisRow = modal.querySelector('[data-line-qris-row]');
    const lineTotal = modal.querySelector('[data-line-total]');

    // Footer ringkasan pesanan (step 2 / checkout)
    const orderSubtotal = modal.querySelector('[data-order-subtotal]');
    const orderQris = modal.querySelector('[data-order-qris]');
    const orderQrisRow = modal.querySelector('[data-order-qris-row]');
    const orderTotal = modal.querySelector('[data-order-total]');

    const checkoutError = modal.querySelector('[data-checkout-error]');
    const checkoutForm = modal.querySelector('#checkout-form');
    const cartList = modal.querySelector('[data-cart-list]');
    const cartEmpty = modal.querySelector('[data-cart-empty]');
    const errorName = modal.querySelector('[data-error-name]');
    const errorPhone = modal.querySelector('[data-error-phone]');
    const errorPickupDate = modal.querySelector('[data-error-pickup-date]');
    const errorPickupTime = modal.querySelector('[data-error-pickup-time]');
    const pickupDate = modal.querySelector('#checkout-pickup-date');
    const pickupTime = modal.querySelector('#checkout-pickup-time');
    const addonOnlyNote = modal.querySelector('[data-addon-only-note]');

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    let current = null;
    let quantity = 1;
    let selectedPackage = null;
    let selectedAddOns = [];
    let cart = [];

    const fmt = (n) => 'Rp' + Number(n || 0).toLocaleString('id-ID');

    const phoneRegex = /^(\+?62|0)8[0-9]{8,13}$/;

    function paymentMethod() {
        return checkoutForm?.querySelector('input[name="payment_method"]:checked')?.value || 'qris';
    }

    function setImage() {
        // Tidak menggunakan panel gambar di versi modal ini, hanya teks.
    }

    function resetState() {
        quantity = 1;
        qtyValue.textContent = '1';
        selectedPackage = null;
        selectedAddOns = [];
    }

    function renderPackages() {
        if (!current || !Array.isArray(current.packages) || current.packages.length === 0) {
            modalPackages?.classList.add('hidden');
            modalPackageNote?.classList.add('hidden');
            return;
        }

        modalPackagesList.innerHTML = current.packages.map((p, i) => `
            <label class="flex cursor-pointer items-center justify-between gap-3 rounded-2xl bg-brand-50 px-4 py-3 ring-1 ring-brand-950/5 transition has-[:checked]:bg-brand-100 has-[:checked]:ring-brand-600">
                <div class="flex items-center gap-3">
                    <input type="radio" name="order-package" value="${i}" ${selectedPackage === p.name ? 'checked' : ''}
                        class="h-4 w-4 accent-brand-600">
                    <div>
                        <p class="text-sm font-semibold text-brand-900">${p.name}</p>
                        ${p.note ? `<p class="mt-0.5 text-xs text-brand-950/55">${p.note}</p>` : ''}
                    </div>
                </div>
                <span class="shrink-0 font-display text-sm font-bold text-brand-700">${p.price}</span>
            </label>
        `).join('');

        modalPackages?.classList.remove('hidden');

        if (current.package_note) {
            modalPackageNote.textContent = current.package_note;
            modalPackageNote.classList.remove('hidden');
        } else {
            modalPackageNote?.classList.add('hidden');
        }

        modalPackagesList.querySelectorAll('input[name="order-package"]').forEach((radio) => {
            radio.addEventListener('change', () => {
                if (radio.checked) {
                    selectedPackage = current.packages[Number(radio.value)].name;
                    renderAddOns();
                    compute();
                }
            });
        });
    }

    function renderAddOns() {
        if (!current || !Array.isArray(current.add_ons) || current.add_ons.length === 0) {
            modalAddOns?.classList.add('hidden');
            return;
        }

        modalAddOnsList.innerHTML = current.add_ons.map((a, i) => `
            <label class="flex cursor-pointer items-center justify-between gap-3 rounded-2xl bg-brand-50 px-4 py-3 ring-1 ring-brand-950/5 transition has-[:checked]:bg-brand-100 has-[:checked]:ring-brand-600">
                <div class="flex items-center gap-3">
                    <input type="checkbox" data-addon-check value="${i}" ${selectedAddOns.includes(a.name) ? 'checked' : ''}
                        class="h-4 w-4 rounded accent-brand-600">
                    <div>
                        <p class="text-sm font-semibold text-brand-900">${a.name}</p>
                        ${a.note ? `<p class="mt-0.5 text-xs text-brand-950/55">${a.note}</p>` : ''}
                    </div>
                </div>
                <span class="shrink-0 font-display text-sm font-bold text-brand-700">${a.price}</span>
            </label>
        `).join('');

        modalAddOns?.classList.remove('hidden');

        modalAddOnsList.querySelectorAll('[data-addon-check]').forEach((checkbox) => {
            checkbox.addEventListener('change', () => {
                const name = current.add_ons[Number(checkbox.value)].name;
                if (checkbox.checked) {
                    if (!selectedAddOns.includes(name)) selectedAddOns.push(name);
                } else {
                    selectedAddOns = selectedAddOns.filter((n) => n !== name);
                }
                compute();
            });
        });
    }

    function basePrice() {
        if (selectedPackage && Array.isArray(current.packages)) {
            const p = current.packages.find((x) => x.name === selectedPackage);
            if (p) return p.price_raw || 0;
        }
        return current.price_raw || 0;
    }

    function baseQris() {
        if (selectedPackage && Array.isArray(current.packages)) {
            const p = current.packages.find((x) => x.name === selectedPackage);
            if (p) return p.qris_fee_raw || 0;
        }
        return current.qris_fee_raw || 0;
    }

    function selectedAddOnObjects() {
        return (current.add_ons || []).filter((a) => selectedAddOns.includes(a.name));
    }

    // Hitung ringkasan produk yang sedang dikustomisasi (step 1).
    function compute() {
        const base = basePrice();
        const baseQ = baseQris();
        const addonSum = selectedAddOnObjects().reduce((sum, a) => sum + (a.price_raw || 0), 0);
        const addonQris = selectedAddOnObjects().reduce((sum, a) => sum + (a.qris_fee_raw || 0), 0);

        const subtotal = base * quantity + addonSum;
        const qris = baseQ * quantity + addonQris;
        const total = subtotal + (paymentMethod() === 'qris' ? qris : 0);

        lineSubtotal.textContent = fmt(subtotal);
        lineQris.textContent = fmt(qris);
        lineQrisRow?.classList.toggle('hidden', paymentMethod() !== 'qris');
        lineTotal.textContent = fmt(total);
    }

    // Hitung total seluruh keranjang (tanpa readback dari harga string).
    function cartTotals() {
        return cart.reduce((acc, line) => ({
            subtotal: acc.subtotal + line.subtotal,
            qris: acc.qris + line.qris,
        }), { subtotal: 0, qris: 0 });
    }

    function applyOrderTotals() {
        const { subtotal, qris } = cartTotals();
        const applyFee = paymentMethod() === 'qris';
        const total = subtotal + (applyFee ? qris : 0);

        orderSubtotal.textContent = fmt(subtotal);
        orderQris.textContent = fmt(qris);
        orderQrisRow?.classList.toggle('hidden', !applyFee);
        orderTotal.textContent = fmt(total);

        compute();
    }

    // Label produk untuk keranjang & pesan WhatsApp.
    function lineLabel(line) {
        return line.package || line.variant || line.name;
    }

    function cartKey(line) {
        return JSON.stringify({
            group_id: line.group_id,
            variant: line.variant || null,
            package: line.package || null,
            add_ons: line.add_ons.map((a) => a.name).sort(),
        });
    }

    function addCurrentToCart() {
        const hasVariant = current?.variant_name;
        const hasPackage = Boolean(selectedPackage);

        if (!hasVariant && !hasPackage) {
            checkoutError.textContent = 'Silakan pilih varian atau paket terlebih dahulu.';
            checkoutError.classList.remove('hidden');
            return;
        }

        const base = basePrice();
        if (base <= 0 && selectedAddOns.length === 0) {
            checkoutError.textContent = 'Produk ini belum memiliki harga. Silakan pilih paket terlebih dahulu.';
            checkoutError.classList.remove('hidden');
            return;
        }

        const baseQ = baseQris();
        const addOns = selectedAddOnObjects().map((a) => ({
            name: a.name,
            price_raw: a.price_raw || 0,
            qris_fee_raw: a.qris_fee_raw || 0,
        }));

        const line = {
            group_id: current.group_id,
            group_title: current.group_title,
            variant: hasVariant && !selectedPackage ? current.variant_name : null,
            package: selectedPackage || null,
            name: current.variant_name || current.name,
            unit_price_raw: base,
            qris_fee_raw: baseQ,
            add_ons: addOns,
            quantity,
            subtotal: base * quantity + addOns.reduce((s, a) => s + a.price_raw, 0),
            qris: baseQ * quantity + addOns.reduce((s, a) => s + a.qris_fee_raw, 0),
        };

        line.subtotal = Number(line.subtotal);
        line.qris = Number(line.qris);

        const key = cartKey(line);
        const existing = cart.find((l) => cartKey(l) === key);

        if (existing) {
            existing.quantity = Math.min(999, existing.quantity + line.quantity);
            existing.subtotal = existing.unit_price_raw * existing.quantity
                + existing.add_ons.reduce((s, a) => s + a.price_raw, 0);
            existing.qris = existing.qris_fee_raw * existing.quantity
                + existing.add_ons.reduce((s, a) => s + a.qris_fee_raw, 0);
        } else {
            cart.push(line);
        }

        checkoutError?.classList.add('hidden');
        renderCartSummary();
    }

    function renderCartSummary() {
        const isEmpty = cart.length === 0;

        cartEmpty?.classList.toggle('hidden', !isEmpty);

        if (isEmpty) {
            cartList.innerHTML = '';
        } else {
            cartList.innerHTML = cart.map((line, index) => `
                <div class="rounded-2xl bg-cream-50 p-3.5 ring-1 ring-brand-950/5">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-brand-950">${lineLabel(line)}</p>
                            <p class="mt-0.5 text-xs text-brand-950/50">${line.group_title || ''} · x${line.quantity}</p>
                            ${line.add_ons.length
                                ? `<ul class="mt-1.5 space-y-0.5">
                                    ${line.add_ons.map((a) => `<li class="text-xs text-brand-700">+ ${a.name}</li>`).join('')}
                                   </ul>`
                                : ''}
                        </div>
                        <div class="shrink-0 text-right">
                            <p class="text-sm font-bold text-brand-700">${fmt(line.subtotal)}</p>
                            <button type="button" data-remove-cart="${index}"
                                class="mt-1 text-xs font-semibold text-rose-600 transition hover:text-rose-700">
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        cartList.querySelectorAll('[data-remove-cart]').forEach((btn) => {
            btn.addEventListener('click', () => {
                cart.splice(Number(btn.dataset.removeCart), 1);
                renderCartSummary();
                applyOrderTotals();
            });
        });

        const itemCount = cart.reduce((n, l) => n + l.quantity, 0);
        cartPill?.classList.toggle('hidden', isEmpty);
        cartPill?.classList.toggle('flex', !isEmpty);
        if (!isEmpty) {
            const { subtotal, qris } = cartTotals();
            cartPillText.textContent = `${itemCount} item · ${fmt(subtotal + qris)}`;
        }

        btnOpenCheckout.disabled = isEmpty;
        btnOpenCheckout.classList.toggle('disabled:cursor-not-allowed', isEmpty);
    }

    function showStep(name) {
        const steps = { customize: stepCustomize, checkout: stepCheckout, receipt: stepReceipt };
        Object.entries(steps).forEach(([key, el]) => {
            if (el) el.classList.toggle('hidden', key !== name);
        });

        // Selalu mulai dari atas saat pindah langkah agar tombol konfirmasi tidak menutupi konten.
        const activeStep = steps[name];
        if (activeStep) {
            const bodyEl = activeStep.querySelector('.flex-1.overflow-y-auto');
            if (bodyEl) bodyEl.scrollTop = 0;
        }
    }

    function openModal(detail) {
        current = detail || {};
        resetState();
        setImage();
        checkoutError?.classList.add('hidden');
        errorName?.classList.add('hidden');
        errorPhone?.classList.add('hidden');
        errorPickupDate?.classList.add('hidden');
        errorPickupTime?.classList.add('hidden');

        modalName.textContent = current.name || '';
        modalCategory.textContent = current.group_title || '';
        modalDescription.textContent = current.description || '';

        if (current.note) {
            modalNote.textContent = current.note;
            modalNoteWrap?.classList.remove('hidden');
        } else {
            modalNoteWrap?.classList.add('hidden');
        }

        if (current.is_addon_only) {
            renderPackages();
            renderAddOns();
            modalPackages?.classList.add('hidden');
            modalAddOns?.classList.add('hidden');
            btnAddToCart?.classList.add('hidden');
            btnOpenCheckout?.classList.add('hidden');
            addonOnlyNote.textContent = 'Additional ini ditambahkan melalui varian/paket terkait pada pemesanan.';
            addonOnlyNote.classList.remove('hidden');
        } else {
            btnAddToCart?.classList.remove('hidden');
            btnOpenCheckout?.classList.remove('hidden');
            addonOnlyNote?.classList.add('hidden');
            renderPackages();
            renderAddOns();
        }

        compute();
        renderCartSummary();
        setDefaultPickup();
        showStep('customize');

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        body.classList.add('overflow-hidden');
        requestAnimationFrame(() => modal.querySelector('[data-modal-card]')?.classList.replace('scale-95', 'scale-100'));
        requestAnimationFrame(() => modal.querySelector('[data-modal-card]')?.classList.remove('opacity-0'));
    }

    function closeModal() {
        if (!modal) return;
        const card = modal.querySelector('[data-modal-card]');
        card?.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 200);
        body.classList.remove('overflow-hidden');
    }

    function toISODate(date) {
        return date.toLocaleDateString('en-CA');
    }

    function setDefaultPickup() {
        if (pickupDate) {
            pickupDate.min = toISODate(new Date());
            if (!pickupDate.value) {
                pickupDate.value = pickupDate.min;
            }
        }
        if (!pickupTime?.value) {
            pickupTime.value = '10:00';
        }
    }

    document.querySelectorAll('[data-product-card][data-detail]').forEach((card) => {
        card.addEventListener('click', () => {
            try {
                const detail = JSON.parse(card.dataset.detail);
                openModal(detail);
            } catch (e) {
                console.error('Gagal membaca detail produk:', e);
            }
        });
    });

    modalCloseButtons.forEach((btn) => btn.addEventListener('click', closeModal));

    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeModal();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });

    qtyPlus?.addEventListener('click', () => {
        quantity = Math.min(999, quantity + 1);
        qtyValue.textContent = quantity;
        compute();
    });

    qtyMinus?.addEventListener('click', () => {
        quantity = Math.max(1, quantity - 1);
        qtyValue.textContent = quantity;
        compute();
    });

    btnAddToCart?.addEventListener('click', () => {
        if (current.is_addon_only) return;
        checkoutError?.classList.add('hidden');
        addCurrentToCart();
    });

    btnClearCart?.addEventListener('click', () => {
        cart = [];
        renderCartSummary();
        applyOrderTotals();
    });

    btnOpenCheckout?.addEventListener('click', () => {
        if (current.is_addon_only) return;
        if (cart.length === 0) return;
        checkoutError?.classList.add('hidden');
        errorName?.classList.add('hidden');
        errorPhone?.classList.add('hidden');
        errorPickupDate?.classList.add('hidden');
        errorPickupTime?.classList.add('hidden');
        renderCartSummary();
        applyOrderTotals();
        setDefaultPickup();
        showStep('checkout');
    });

    btnBackCustomize?.addEventListener('click', () => {
        showStep('customize');
    });

    checkoutForm?.querySelectorAll('input[name="payment_method"]').forEach((radio) => {
        radio.addEventListener('change', () => {
            if (radio.checked) {
                applyOrderTotals();
            }
        });
    });

    function setSubmitting(loading) {
        if (!btnSubmitOrder) return;
        btnSubmitOrder.disabled = loading;
        submitSpinner?.classList.toggle('hidden', !loading);
        if (submitLabel) submitLabel.textContent = loading ? 'Memproses…' : 'Konfirmasi Pesanan';
    }

    function renderReceipt(order) {
        const money = (n) => 'Rp' + Number(n || 0).toLocaleString('id-ID');
        const fmtDate = (d) => {
            if (!d) return '';
            const date = new Date(d + 'T00:00:00');
            return date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
        };

        const items = Array.isArray(order.order_data) ? order.order_data : [];
        const itemRows = items.map((item) => `
            <li class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <p class="font-semibold leading-snug text-brand-950">${(item.package || item.variant || item.name || 'Produk')} <span class="text-brand-950/50">× ${item.quantity}</span></p>
                    ${(item.add_ons || []).length ? `<ul class="mt-1 space-y-0.5">
                        ${item.add_ons.map((a) => `<li class="text-xs text-brand-950/55">+ ${a.name}</li>`).join('')}
                    </ul>` : ''}
                </div>
                <span class="shrink-0 font-semibold text-brand-900">${money(item.subtotal)}</span>
            </li>
        `).join('');

        receiptRoot.innerHTML = `
            <div class="mx-auto w-full max-w-sm overflow-hidden rounded-2xl border border-dashed border-brand-950/20 bg-white shadow-sm">
                <div class="border-b border-dashed border-brand-950/15 bg-cream-50 px-5 py-4 text-center">
                    <p class="font-display text-lg font-bold text-brand-900">Mahligai Bakery</p>
                    <p class="text-xs text-brand-950/50">Renon, Denpasar Selatan, Bali</p>
                </div>
                <div class="space-y-1.5 px-5 py-4 text-sm">
                    <div class="flex justify-between">
                        <span class="text-brand-950/55">No. Pesanan</span>
                        <span class="font-bold text-brand-950">${order.order_number || '—'}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-brand-950/55">Nomor Urut</span>
                        <span class="font-bold text-brand-600">#${order.queue_number || '—'}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-brand-950/55">Nama</span>
                        <span class="font-semibold text-brand-950">${order.customer_name || '—'}</span>
                    </div>
                    ${order.customer_phone ? `<div class="flex justify-between">
                        <span class="text-brand-950/55">WhatsApp</span>
                        <span class="font-semibold text-brand-950">${order.customer_phone}</span>
                    </div>` : ''}
                    <div class="flex justify-between">
                        <span class="text-brand-950/55">Pengambilan</span>
                        <span class="font-semibold text-brand-950">${order.pickup_date ? `${fmtDate(order.pickup_date)}` + (order.pickup_time ? ` · ${order.pickup_time}` : '') : '—'}</span>
                    </div>
                </div>
                <div class="border-t border-dashed border-brand-950/15 px-5 py-4">
                    <p class="text-[0.65rem] font-bold uppercase tracking-[0.2em] text-brand-600">Rincian Pesanan</p>
                    <ul class="mt-3 space-y-3 text-sm">${itemRows || '<li class="text-xs text-brand-950/45">Tidak ada item.</li>'}</ul>
                </div>
                <div class="border-t border-dashed border-brand-950/15 px-5 py-4">
                    <dl class="space-y-1.5 text-sm">
                        <div class="flex justify-between text-brand-950/60">
                            <dt>Subtotal</dt>
                            <dd class="font-semibold text-brand-950">${money(order.subtotal)}</dd>
                        </div>
                        ${Number(order.qris_fee) > 0 ? `<div class="flex justify-between text-brand-950/60">
                            <dt>Biaya QRIS</dt>
                            <dd class="font-semibold text-brand-950">${money(order.qris_fee)}</dd>
                        </div>` : ''}
                        <div class="mt-2 flex items-center justify-between border-t border-brand-950/15 pt-2">
                            <dt class="font-bold text-brand-950">Total</dt>
                            <dd class="font-display text-lg font-bold text-brand-700">${money(order.total)}</dd>
                        </div>
                    </dl>
                    <div class="mt-4 flex flex-wrap items-center gap-2">
                        <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-[0.7rem] font-bold text-amber-700">${order.payment_status_label || 'Menunggu Pembayaran'}</span>
                        <span class="inline-flex rounded-full bg-brand-100 px-3 py-1 text-[0.7rem] font-bold text-brand-700">${order.order_status_label || ''}</span>
                    </div>
                </div>
                ${order.bakery_request ? `<div class="border-t border-dashed border-brand-950/15 px-5 py-4">
                    <p class="text-[0.65rem] font-bold uppercase tracking-[0.2em] text-brand-600">Request Bakery</p>
                    <p class="mt-1.5 text-sm leading-relaxed text-brand-950/70">${order.bakery_request}</p>
                </div>` : ''}
            </div>
        `;

        const isQris = order.payment_method === 'qris';
        if (receiptPay) {
            receiptPay.classList.toggle('hidden', false);
            receiptPay.classList.toggle('inline-flex', true);
            receiptPayLabel.textContent = isQris ? 'Bayar via QRIS' : 'Bayar via WhatsApp';
            receiptPay.onclick = () => {
                if (isQris) {
                    window.dispatchEvent(new CustomEvent('qris:open', { detail: order }));
                } else {
                    window.open(order.wa_link, '_blank');
                }
            };
        }
    }

    btnSubmitOrder?.addEventListener('click', async () => {
        const nameInput = checkoutForm?.querySelector('#checkout-name');
        const phoneInput = checkoutForm?.querySelector('#checkout-phone');
        const name = nameInput?.value.trim();
        const phone = phoneInput?.value.trim();
        const paymentMethodValue = paymentMethod();
        const pickupDateValue = pickupDate?.value;
        const pickupTimeValue = pickupTime?.value;
        const bakeryRequest = checkoutForm?.querySelector('#checkout-bakery-request')?.value.trim() || null;

        errorName?.classList.add('hidden');
        errorPhone?.classList.add('hidden');
        errorPickupDate?.classList.add('hidden');
        errorPickupTime?.classList.add('hidden');
        checkoutError?.classList.add('hidden');

        let valid = true;

        if (!name) {
            errorName.textContent = 'Nama wajib diisi.';
            errorName.classList.remove('hidden');
            valid = false;
        }

        if (!phone) {
            errorPhone.textContent = 'Nomor WhatsApp wajib diisi.';
            errorPhone.classList.remove('hidden');
            valid = false;
        } else if (!phoneRegex.test(phone)) {
            errorPhone.textContent = 'Nomor WhatsApp tidak valid. Gunakan format Indonesia (contoh: 08113996988).';
            errorPhone.classList.remove('hidden');
            valid = false;
        }

        if (!pickupDateValue) {
            errorPickupDate.textContent = 'Tanggal pengambilan wajib diisi.';
            errorPickupDate.classList.remove('hidden');
            valid = false;
        } else if (pickupDateValue < toISODate(new Date())) {
            errorPickupDate.textContent = 'Tanggal pengambilan tidak boleh di masa lalu.';
            errorPickupDate.classList.remove('hidden');
            valid = false;
        }

        if (!pickupTimeValue) {
            errorPickupTime.textContent = 'Jam pengambilan wajib diisi.';
            errorPickupTime.classList.remove('hidden');
            valid = false;
        }

        if (cart.length === 0) {
            checkoutError.textContent = 'Minimal harus ada satu produk yang dipesan.';
            checkoutError.classList.remove('hidden');
            valid = false;
        }

        if (!valid) return;

        const payload = {
            customer_name: name,
            customer_phone: phone,
            payment_method: paymentMethodValue,
            pickup_date: pickupDateValue,
            pickup_time: pickupTimeValue,
            bakery_request: bakeryRequest,
            items: cart.map((line) => ({
                group_id: line.group_id,
                variant: line.variant,
                package: line.package,
                add_ons: line.add_ons.map((a) => a.name),
                quantity: line.quantity,
            })),
        };

        setSubmitting(true);

        try {
            const response = await fetch('/orders', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify(payload),
            });

            const data = await response.json().catch(() => ({}));

            if (!response.ok || !data.success) {
                let message = data.message || 'Gagal menyimpan pesanan. Silakan coba lagi.';

                if (data.errors?.customer_phone) {
                    errorPhone.textContent = Array.isArray(data.errors.customer_phone)
                        ? data.errors.customer_phone[0]
                        : data.errors.customer_phone;
                    errorPhone.classList.remove('hidden');
                    message = '';
                }

                if (data.errors?.pickup_date) {
                    errorPickupDate.textContent = Array.isArray(data.errors.pickup_date)
                        ? data.errors.pickup_date[0]
                        : data.errors.pickup_date;
                    errorPickupDate.classList.remove('hidden');
                    message = '';
                }

                if (message) {
                    checkoutError.textContent = message;
                    checkoutError.classList.remove('hidden');
                }

                setSubmitting(false);
                return;
            }

            const order = data.order || {};
            cart = [];
            renderCartSummary();
            renderReceipt(order);
            showStep('receipt');
        } catch (e) {
            checkoutError.textContent = 'Terjadi kesalahan koneksi. Silakan coba lagi.';
            checkoutError.classList.remove('hidden');
            setSubmitting(false);
        }
    });

    receiptClose?.addEventListener('click', closeModal);
}