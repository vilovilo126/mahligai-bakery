document.querySelectorAll('[data-carousel]').forEach((carousel) => {
    const track = carousel.querySelector('[data-carousel-track]');
    const prev = carousel.querySelector('[data-carousel-prev]');
    const next = carousel.querySelector('[data-carousel-next]');

    if (!track) {
        return;
    }

    const firstItem = track.querySelector('[data-carousel-item]');

    function step() {
        return firstItem ? firstItem.getBoundingClientRect().width + 24 : 300;
    }

    function visibleCount() {
        if (window.innerWidth >= 1280) {
            return 4;
        }

        if (window.innerWidth >= 1024) {
            return 3;
        }

        if (window.innerWidth >= 640) {
            return 2;
        }

        return 1;
    }

    function update() {
        const max = track.scrollWidth - track.clientWidth;

        prev?.toggleAttribute('disabled', track.scrollLeft <= 4);
        next?.toggleAttribute('disabled', track.scrollLeft >= max - 4);
    }

    next?.addEventListener('click', () => {
        track.scrollBy({ left: step() * visibleCount() * 0.8, behavior: 'smooth' });
    });

    prev?.addEventListener('click', () => {
        track.scrollBy({ left: -(step() * visibleCount() * 0.8), behavior: 'smooth' });
    });

    track.addEventListener('scroll', update, { passive: true });
    window.addEventListener('resize', update);
    update();
});