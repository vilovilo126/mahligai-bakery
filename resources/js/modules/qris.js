const qrisModal = document.getElementById('qris-modal');
const body = document.body;

if (qrisModal) {
    const qrisImage = qrisModal.querySelector('[data-qris-image]');
    const qrisOrderNo = qrisModal.querySelector('[data-qris-order-no]');
    const qrisItems = qrisModal.querySelector('[data-qris-items]');
    const qrisItemsList = qrisModal.querySelector('[data-qris-items-list]');
    const qrisSubtotal = qrisModal.querySelector('[data-qris-subtotal]');
    const qrisFee = qrisModal.querySelector('[data-qris-fee]');
    const qrisPayable = qrisModal.querySelector('[data-qris-payable]');

    const fmt = (n) => 'Rp' + Number(n || 0).toLocaleString('id-ID');

    function lineLabel(item) {
        return (item.package || item.variant || 'Produk') + ' x' + (item.quantity || 1);
    }

    function show(data) {
        const order = data || {};
        const total = Number(order.total || 0);
        const subtotal = Number(order.subtotal || 0);
        const fee = Number(order.qris_fee || 0);

        qrisImage.src = order.qris_image || '';
        qrisOrderNo.textContent = order.order_number || '#—';
        qrisSubtotal.textContent = fmt(subtotal);
        qrisFee.textContent = fmt(fee);

        // Nominal yang harus dibayar harus sama persis dengan Total Pembayaran.
        qrisPayable.textContent = fmt(total);

        const hasItems = Array.isArray(order.order_data) && order.order_data.length > 0;
        qrisItems?.classList.toggle('hidden', !hasItems);

        if (hasItems) {
            qrisItemsList.innerHTML = order.order_data.map((item) => {
                const addOns = (item.add_ons || []).length
                    ? item.add_ons.map((a) => `<li class="text-xs text-brand-700">+ ${a.name}</li>`).join('')
                    : '';

                return `
                    <li class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-brand-950">${lineLabel(item)}</p>
                            ${addOns ? `<ul class="mt-1 space-y-0.5">${addOns}</ul>` : ''}
                        </div>
                        <span class="shrink-0 text-sm font-bold text-brand-700">${fmt(item.subtotal)}</span>
                    </li>
                `;
            }).join('');
        }

        qrisModal.classList.remove('hidden');
        qrisModal.classList.add('flex');
        body.classList.add('overflow-hidden');
        requestAnimationFrame(() => qrisModal.querySelector('[data-qris-card]')?.classList.replace('scale-95', 'scale-100'));
        requestAnimationFrame(() => qrisModal.querySelector('[data-qris-card]')?.classList.remove('opacity-0'));
    }

    function close() {
        const card = qrisModal.querySelector('[data-qris-card]');
        card?.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            qrisModal.classList.add('hidden');
            qrisModal.classList.remove('flex');
        }, 200);
        body.classList.remove('overflow-hidden');
    }

    window.addEventListener('qris:open', (event) => {
        show(event.detail);
    });

    qrisModal.querySelectorAll('[data-qris-close]').forEach((btn) => btn.addEventListener('click', close));

    // Tombol bayar pada halaman detail pesanan (memuat ulang data pesanan dari server)
    document.querySelectorAll('[data-customer-pay]').forEach((btn) => {
        btn.addEventListener('click', async (event) => {
            const orderId = btn.dataset.customerPay;
            if (!orderId) return;
            event.preventDefault();
            try {
                const response = await fetch(`/customer/orders/${orderId}/json`, { headers: { Accept: 'application/json' } });
                const data = await response.json();
                if (!response.ok || !data.success) return;
                const order = data.order || {};
                if (order.payment_method === 'qris') {
                    show(order);
                } else {
                    window.open(order.wa_link, '_blank');
                }
            } catch (e) {
                // abaikan
            }
        });
    });
}