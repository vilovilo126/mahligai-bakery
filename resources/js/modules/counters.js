const counterObserver = new IntersectionObserver(
    (entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) {
                return;
            }

            const element = entry.target;
            const target = Number.parseFloat(element.dataset.count ?? '0') || 0;
            const decimals = Number.parseInt(element.dataset.decimals ?? '0', 10) || 0;
            const duration = 1400;
            const start = performance.now();
            const formatter = new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: decimals,
                maximumFractionDigits: decimals,
            });

            function frame(now) {
                const progress = Math.min((now - start) / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 3);

                element.textContent = formatter.format(target * eased);

                if (progress < 1) {
                    requestAnimationFrame(frame);
                }
            }

            requestAnimationFrame(frame);
            counterObserver.unobserve(element);
        });
    },
    { threshold: 0.6 },
);

document.querySelectorAll('[data-count]').forEach((element) => counterObserver.observe(element));