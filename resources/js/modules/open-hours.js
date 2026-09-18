const statusPill = document.getElementById('open-status');

if (statusPill) {
    const openMinutes = Number.parseInt(statusPill.dataset.open ?? '', 10) || 7 * 60;
    const closeMinutes = Number.parseInt(statusPill.dataset.close ?? '', 10) || 22 * 60;
    const label = statusPill.querySelector('[data-status-label]');
    const time = statusPill.querySelector('[data-status-time]');

    function tick() {
        const now = new Date();
        const minutes = now.getHours() * 60 + now.getMinutes();
        const isOpen = minutes >= openMinutes && minutes < closeMinutes;

        statusPill.classList.toggle('is-open', isOpen);
        statusPill.classList.toggle('is-closed', !isOpen);

        if (label) {
            label.textContent = isOpen ? 'BUKA SEKARANG' : 'TUTUP';
        }

        if (time) {
            time.textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        }
    }

    tick();
    setInterval(tick, 30_000);
}

const today = new Date().getDay();
document.querySelectorAll('[data-day]').forEach((row) => {
    if (Number.parseInt(row.dataset.day, 10) === today) {
        row.classList.add('is-today');
    }
});