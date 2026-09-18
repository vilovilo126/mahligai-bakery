const slider = document.querySelector('[data-testimonials]');

if (slider) {
    const track = slider.querySelector('[data-testimonial-track]');
    const dotsWrap = slider.querySelector('[data-testimonial-dots]');
    const slides = Array.from(track?.querySelectorAll('[data-testimonial-slide]') ?? []);
    const prev = slider.querySelector('[data-testimonial-prev]');
    const next = slider.querySelector('[data-testimonial-next]');

    let current = 0;
    let timer = null;

    function visibleCount() {
        if (window.innerWidth >= 1024) {
            return 3;
        }

        if (window.innerWidth >= 640) {
            return 2;
        }

        return 1;
    }

    function maxIndex() {
        return Math.max(0, slides.length - visibleCount());
    }

    function goTo(index) {
        current = Math.min(Math.max(0, index), maxIndex());
        track.style.transform = `translateX(-${current * (100 / visibleCount())}%)`;

        dotsWrap?.querySelectorAll('button').forEach((dot, i) => {
            dot.classList.toggle('bg-brand-700', i === current);
            dot.classList.toggle('bg-brand-300', i !== current);
        });

        prev?.toggleAttribute('disabled', current <= 0);
        next?.toggleAttribute('disabled', current >= maxIndex());
    }

    function buildDots() {
        if (!dotsWrap) {
            return;
        }

        dotsWrap.innerHTML = '';

        for (let i = 0; i <= maxIndex(); i += 1) {
            const dot = document.createElement('button');
            dot.type = 'button';
            dot.className = 'h-2.5 w-2.5 rounded-full transition-colors duration-300';
            dot.setAttribute('aria-label', `Ke testimoni ${i + 1}`);
            dot.addEventListener('click', () => goTo(i));
            dotsWrap.appendChild(dot);
        }

        goTo(current);
    }

    function restartTimer() {
        if (timer) {
            window.clearInterval(timer);
        }

        timer = window.setInterval(() => {
            goTo(current < maxIndex() ? current + 1 : 0);
        }, 5000);
    }

    prev?.addEventListener('click', () => {
        goTo(current - 1);
        restartTimer();
    });

    next?.addEventListener('click', () => {
        goTo(current + 1);
        restartTimer();
    });

    slider.addEventListener('mouseenter', () => window.clearInterval(timer));
    slider.addEventListener('mouseleave', restartTimer);

    window.addEventListener('resize', buildDots);

    buildDots();
    restartTimer();
}