const lightbox = document.getElementById('gallery-lightbox');

if (lightbox) {
    const images = Array.from(document.querySelectorAll('[data-gallery-item]'));
    const lightboxImage = lightbox.querySelector('[data-lightbox-image]');
    const lightboxTitle = lightbox.querySelector('[data-lightbox-title]');
    const lightboxCounter = lightbox.querySelector('[data-lightbox-counter]');
    const lightboxPrev = lightbox.querySelector('[data-lightbox-prev]');
    const lightboxNext = lightbox.querySelector('[data-lightbox-next]');
    const lightboxClose = lightbox.querySelector('[data-lightbox-close]');
    const body = document.body;

    let current = 0;

    function render() {
        const item = images[current];
        lightboxImage.src = item.dataset.image;
        lightboxImage.alt = item.dataset.title;
        lightboxTitle.textContent = item.dataset.title;
        lightboxCounter.textContent = `${current + 1} / ${images.length}`;
    }

    function openAt(index) {
        current = (index + images.length) % images.length;
        render();
        lightbox.classList.remove('hidden');
        body.classList.add('overflow-hidden');
    }

    function close() {
        lightbox.classList.add('hidden');
        body.classList.remove('overflow-hidden');
    }

    function next() {
        openAt(current + 1);
    }

    function prev() {
        openAt(current - 1);
    }

    images.forEach((item, index) => {
        item.addEventListener('click', () => openAt(index));
    });

    lightboxNext?.addEventListener('click', next);
    lightboxPrev?.addEventListener('click', prev);
    lightboxClose?.addEventListener('click', close);

    lightbox.addEventListener('click', (event) => {
        if (event.target === lightbox) {
            close();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (lightbox.classList.contains('hidden')) {
            return;
        }

        if (event.key === 'Escape') {
            close();
        }

        if (event.key === 'ArrowRight') {
            next();
        }

        if (event.key === 'ArrowLeft') {
            prev();
        }
    });
}