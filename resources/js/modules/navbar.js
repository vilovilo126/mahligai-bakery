const header = document.getElementById('site-header');
const hamburger = document.getElementById('hamburger-btn');
const mobileMenu = document.getElementById('mobile-menu');

let menuOpen = false;

function updateNavbar() {
    if (!header) {
        return;
    }

    header.classList.toggle('is-scrolled', window.scrollY > 48);
}

function setMenu(open) {
    menuOpen = open;

    document.body.classList.toggle('overflow-hidden', open);
    hamburger?.classList.toggle('is-active', open);
    hamburger?.setAttribute('aria-expanded', String(open));
    mobileMenu?.classList.toggle('open', open);
}

window.addEventListener('scroll', updateNavbar, { passive: true });
updateNavbar();

hamburger?.addEventListener('click', () => setMenu(!menuOpen));

mobileMenu?.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', () => setMenu(false));
});

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && menuOpen) {
        setMenu(false);
    }
});