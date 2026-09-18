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
    const modalClose = modal.querySelector('[data-modal-close]');

    const stepCustomize = modal.querySelector('[data-modal-step="customize"]');
    const stepCheckout = modal.querySelector('[data-modal-step="checkout"]');
    const btnOpenCheckout = modal.querySelector('[data-open-checkout]');
    const btnBackCustomize = modal.querySelector('[data-back-customize]');
    const btnSubmitOrder = modal.querySelector('[data-submit-order]');
    const qtyMinus = modal.querySelector('[data-qty-minus]');
    const qtyPlus = modal.querySelector('[data-qty-plus]');
    const qtyValue = modal.querySelector('[data-qty-value]');
    const orderSubtotal = modal.querySelector('[data-order-subtotal]');
    const orderQris = modal.querySelector('[data-order-qris]');
    const orderQrisRow = modal.querySelector('[data-order-qris-row]');
    const orderTotal = modal.querySelector('[data-order-total]');
    const addonOnlyNote = modal.querySelector('[data-addon-only-note]');
    const checkoutError = modal.querySelector('[data-checkout-error]');
    const checkoutForm = modal.querySelector('#checkout-form');

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    let current = null;
    let quantity = 1;
    let selectedPackage = null;
    let selectedAddOns = [];

    const fmt = (n) => 'Rp' + Number(n || 0).toLocaleString('id-ID');

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

    function compute() {
        const base = basePrice();
        const baseQ = baseQris();
        const addonSum = (current.add_ons || []).reduce((sum, a) => sum + (selectedAddOns.includes(a.name) ? (a.price_raw || 0) : 0), 0);
        const addonQris = (current.add_ons || []).reduce((sum, a) => sum + (selectedAddOns.includes(a.name) ? (a.qris_fee_raw || 0) : 0), 0);

        const subtotal = base * quantity + addonSum;
        const qris = baseQ * quantity + addonQris;
        const total = subtotal + qris;

        orderSubtotal.textContent = fmt(subtotal);
        orderQris.textContent = fmt(qris);
        orderQrisRow?.classList.toggle('hidden', qris === 0);
        orderTotal.textContent = fmt(total);
    }

    function showStep(name) {
        const show = name === 'checkout' ? stepCheckout : stepCustomize;
        const hide = name === 'checkout' ? stepCustomize : stepCheckout;
        show?.classList.remove('hidden');
        hide?.classList.add('hidden');
    }

    function openModal(detail) {
        current = detail || {};
        resetState();
        setImage();

        modalName.textContent = current.name || '';
        modalCategory.textContent = current.group_title || '';
        modalDescription.textContent = current.description || '';

        if (current.note) {
            modalNote.textContent = current.note;
            modalNoteWrap?.classList.remove('hidden');
        } else {
            modalNoteWrap?.classList.add('hidden');
        }

        // Default: jika produk adalah paket (buka dari kartu paket) atau hanya punya paket.
        if (current.is_addon_only) {
            renderPackages();
            renderAddOns();
            modalPackages?.classList.add('hidden');
            modalAddOns?.classList.add('hidden');
            btnOpenCheckout?.classList.add('hidden');
            addonOnlyNote.textContent = 'Additional ini ditambahkan melalui varian/paket terkait pada pemesanan.';
            addonOnlyNote.classList.remove('hidden');
        } else {
            btnOpenCheckout?.classList.remove('hidden');
            addonOnlyNote?.classList.add('hidden');
            renderPackages();
            renderAddOns();
        }

        compute();

        stepCustomize?.classList.remove('hidden');
        stepCheckout?.classList.add('hidden');

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

    modalClose?.addEventListener('click', closeModal);

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

    btnOpenCheckout?.addEventListener('click', () => {
        if (current.is_addon_only) return;
        checkoutError?.classList.add('hidden');
        showStep('checkout');
    });

    btnBackCustomize?.addEventListener('click', () => {
        showStep('customize');
    });

    btnSubmitOrder?.addEventListener('click', async () => {
        const name = checkoutForm?.querySelector('#checkout-name')?.value.trim();
        const phone = checkoutForm?.querySelector('#checkout-phone')?.value.trim();
        const paymentMethod = checkoutForm?.querySelector('input[name="payment_method"]:checked')?.value || 'qris';

        if (!name || !phone) {
            checkoutError.textContent = 'Mohon isi nama dan nomor WhatsApp Anda.';
            checkoutError.classList.remove('hidden');
            return;
        }

        const payload = {
            customer_name: name,
            customer_phone: phone,
            payment_method: paymentMethod,
            items: [{
                group_id: current.group_id,
                variant: current.variant_name && !selectedPackage ? current.variant_name : null,
                package: selectedPackage || null,
                add_ons: selectedAddOns,
                quantity,
            }],
        };

        btnSubmitOrder.disabled = true;
        btnSubmitOrder.textContent = 'Memproses…';

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
                checkoutError.textContent = data.message || 'Gagal menyimpan pesanan. Silakan coba lagi.';
                checkoutError.classList.remove('hidden');
                btnSubmitOrder.disabled = false;
                btnSubmitOrder.textContent = 'Konfirmasi Pesanan';
                return;
            }

            closeModal();

            if (data.order.payment_method === 'qris') {
                window.dispatchEvent(new CustomEvent('qris:open', { detail: data.order }));
            } else {
                const msg = 'Halo Mahligai Bakery, saya ingin mengonfirmasi pesanan saya. Total: Rp' + Number(data.order.total).toLocaleString('id-ID') + '.';
                const phone = modal.getAttribute('data-wa-number');
                window.open('https://wa.me/' + phone + '?text=' + encodeURIComponent(msg), '_blank');
            }
        } catch (e) {
            checkoutError.textContent = 'Terjadi kesalahan koneksi. Silakan coba lagi.';
            checkoutError.classList.remove('hidden');
            btnSubmitOrder.disabled = false;
            btnSubmitOrder.textContent = 'Konfirmasi Pesanan';
        }
    });
}
