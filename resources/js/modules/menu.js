const nav = document.querySelector('[data-menu-nav]');

if (nav) {
    const links = Array.from(nav.querySelectorAll('[data-menu-link]'));
    const sections = links
        .map((link) => document.getElementById('menu-'.concat(link.dataset.menuLink)))
        .filter(Boolean);

    function setActive(id) {
        links.forEach((link) => {
            const isActive = link.dataset.menuLink === id;
            link.classList.toggle('bg-brand-600', isActive);
            link.classList.toggle('text-white', isActive);
            link.classList.toggle('shadow-sm', isActive);
            link.classList.toggle('hover:bg-brand-50', !isActive);
            link.classList.toggle('hover:text-brand-700', !isActive);
            link.classList.toggle('text-brand-800', !isActive);
            link.setAttribute('aria-current', isActive ? 'true' : 'false');
        });
    }

    function currentSection() {
        const offset = 160;
        let active = links[0]?.dataset?.menuLink;

        sections.forEach((section) => {
            if (section.getBoundingClientRect().top <= offset) {
                const id = section.id.replace('menu-', '');
                if (id) active = id;
            }
        });

        return active;
    }

    function onScroll() {
        setActive(currentSection());
    }

    links.forEach((link) => {
        link.addEventListener('click', () => {
            const target = document.getElementById('menu-'.concat(link.dataset.menuLink));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                history.replaceState(null, '', '#menu-'.concat(link.dataset.menuLink));
            }
        });
    });

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
}
