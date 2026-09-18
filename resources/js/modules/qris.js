const qrisModal = document.getElementById('qris-modal');
const body = document.body;

if (qrisModal) {
    const qrisImage = qrisModal.querySelector('[data-qris-image]');
    const qrisTotal = qrisModal.querySelector('[data-qris-total]');
    const qrisFee = qrisModal.querySelector('[data-qris-fee]');
    const qrisFeeRow = qrisModal.querySelector('[data-qris-fee-row]');
    const qrisPayable = qrisModal.querySelector('[data-qris-payable]');
    const qrisBack = qrisModal.querySelector('[data-qris-back]');
    const qrisConfirm = qrisModal.querySelector('[data-qris-confirm]');
    const qrisConfirmed = qrisModal.querySelector('[data-qris-confirmed]');

    const fmt = (n) => 'Rp' + Number(n || 0).toLocaleString('id-ID');

    function show(data) {
        const order = data || {};
        const total = Number(order.total || 0);
        const fee = Number(order.qris_fee || 0);

        qrisImage.src = order.qris_image || '';
        qrisTotal.textContent = fmt(total);
        qrisFee.textContent = fmt(fee);
        qrisFeeRow?.classList.toggle('hidden', fee === 0);
        qrisPayable.textContent = fmt(total);
        qrisConfirmed?.classList.add('hidden');
        qrisConfirm.disabled = false;
        qrisConfirm.textContent = 'Konfirmasi Pembayaran';

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

    qrisBack?.addEventListener('click', close);
    qrisModal.querySelectorAll('[data-qris-close]').forEach((btn) => btn.addEventListener('click', close));

    qrisConfirm?.addEventListener('click', () => {
        qrisConfirmed.textContent = 'Terima kasih! Pembayaran Anda akan segera kami konfirmasi. Silakan hubungi kami melalui WhatsApp untuk memastikan pesanan.';
        qrisConfirmed.classList.remove('hidden');
        qrisConfirm.disabled = true;
        qrisConfirm.textContent = 'Pembayaran Dikonfirmasi';
    });
}
