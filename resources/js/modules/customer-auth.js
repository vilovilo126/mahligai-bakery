// Toggle menu akun pelanggan di navbar
document.querySelectorAll('[data-customer-menu-toggle]').forEach((toggle) => {
    const menu = document.querySelector('[data-customer-menu]');
    const close = (event) => {
        if (menu && !menu.classList.contains('hidden') && !toggle.contains(event.target) && !menu.contains(event.target)) {
            menu.classList.add('hidden');
            toggle.setAttribute('aria-expanded', 'false');
        }
    };
    toggle.addEventListener('click', (event) => {
        event.stopPropagation();
        if (!menu) return;
        const isOpen = !menu.classList.contains('hidden');
        menu.classList.toggle('hidden', isOpen);
        toggle.setAttribute('aria-expanded', String(!isOpen));
    });
    document.addEventListener('click', close);
});