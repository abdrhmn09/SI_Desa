<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({ duration: 650, once: true, offset: 60 });

    // Navbar berubah gaya saat discroll
    const nav = document.getElementById('mainNav');
    window.addEventListener('scroll', () => {
        nav.classList.toggle('scrolled', window.scrollY > 60);
    });

    // Animasi angka statistik di Hero (sebelumnya diam di 0 karena belum ada JS)
    (() => {
        const counters = document.querySelectorAll('.counter');
        if (!counters.length) return;

        const animateCounter = (el) => {
            const target = parseInt(el.dataset.target, 10) || 0;
            const duration = 1200;
            const startTime = performance.now();

            const step = (now) => {
                const progress = Math.min((now - startTime) / duration, 1);
                el.textContent = Math.floor(progress * target).toLocaleString('id-ID');
                if (progress < 1) {
                    requestAnimationFrame(step);
                } else {
                    el.textContent = target.toLocaleString('id-ID');
                }
            };
            requestAnimationFrame(step);
        };

        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        counters.forEach((el) => observer.observe(el));
    })();

    // Lightbox galeri foto (modal + tombol navigasi prev/next)
    (() => {
        const items = Array.from(document.querySelectorAll('.galeri-grid-item'));
        const modalEl = document.getElementById('galleryLightbox');
        if (!items.length || !modalEl) return;

        const modal = new bootstrap.Modal(modalEl);
        const imgEl = document.getElementById('lightboxImage');
        let currentIndex = 0;

        const showImage = (index) => {
            currentIndex = (index + items.length) % items.length;
            const item = items[currentIndex];
            imgEl.src = item.dataset.img;
            imgEl.alt = item.dataset.caption || '';
        };

        items.forEach((item, index) => {
            const open = () => { showImage(index); modal.show(); };
            item.addEventListener('click', open);
            item.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); open(); }
            });
        });

        document.getElementById('lightboxPrev').addEventListener('click', () => showImage(currentIndex - 1));
        document.getElementById('lightboxNext').addEventListener('click', () => showImage(currentIndex + 1));

        document.addEventListener('keydown', (e) => {
            if (!modalEl.classList.contains('show')) return;
            if (e.key === 'ArrowLeft') showImage(currentIndex - 1);
            if (e.key === 'ArrowRight') showImage(currentIndex + 1);
        });
    })();
</script>