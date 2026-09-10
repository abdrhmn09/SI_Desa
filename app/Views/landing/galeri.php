<!-- ═══════════════════════════ GALERI & VIDEO ═══════════════════════════ -->
<?php if (!empty($galeri) || !empty($videos)): ?>
<?php
    // Persiapkan data galeri untuk Infinite Scroll
    $galeriItems = !empty($galeri) ? $galeri : [];
    $galeriCount = count($galeriItems);
    $infiniteGaleri = [];
    if ($galeriCount > 0) {
        $repeats = max(4, (int)ceil(16 / $galeriCount));
        for ($r = 0; $r < $repeats; $r++) {
            foreach ($galeriItems as $origIndex => $g) {
                $g['_orig_index'] = $origIndex;
                $infiniteGaleri[] = $g;
            }
        }
    }
?>
<section class="bg-green-soft py-6 position-relative overflow-hidden" id="galeri">
    <div class="container">
        <div class="text-center mb-4" data-aos="fade-up">
            <div class="section-tag justify-content-center">Galeri Foto Desa</div>
            <h2 class="section-title">Pesona Alam &amp; Kehangatan Warga</h2>
            <p class="section-desc mx-auto" style="max-width:640px">
                Jendela visual komunitas kami. Setiap sudut bercerita tentang keindahan alam dan kearifan lokal yang terjaga.
            </p>
        </div>
    </div>

    <?php if (!empty($infiniteGaleri)): ?>
    <!-- Cover Flow Horizontal Carousel (Infinite Scroll) -->
    <div class="galeri-carousel-wrap mb-5" data-aos="fade-up" data-aos-delay="100">

        <div class="galeri-carousel" id="galleryCarousel">
            <?php foreach ($infiniteGaleri as $i => $g): ?>
            <?php 
                $fileName = $g['file_gambar'] ?? '';
                $urlGambar = base_url('logoDesa.png');
                if (!empty($fileName)) {
                    if (file_exists(FCPATH . 'uploads/galeri/' . $fileName)) {
                        $urlGambar = base_url('uploads/galeri/' . $fileName);
                    } elseif (file_exists(FCPATH . $fileName)) {
                        $urlGambar = base_url($fileName);
                    }
                }
                $judul = $g['judul'] ?? 'Pesona Desa';
                $keterangan = $g['keterangan'] ?? '';
                $origIndex = $g['_orig_index'] ?? 0;
            ?>
            <div class="cover-flow-item galeri-grid-item" 
                 data-img="<?= esc($urlGambar, 'attr') ?>"
                 data-caption="<?= esc($judul, 'attr') ?>"
                 data-orig-index="<?= $origIndex ?>"
                 role="button" 
                 tabindex="0">
                <img src="<?= $urlGambar ?>" 
                     alt="<?= esc($judul, 'attr') ?>" 
                     loading="lazy" 
                     decoding="async"
                     onerror="this.onerror=null; this.src='<?= base_url('logoDesa.png') ?>';">
                <div class="cover-flow-overlay">
                    <h5 class="fw-bold mb-1 text-white text-truncate"><?= esc($judul) ?></h5>
                    <?php if (!empty($keterangan)): ?>
                    <p class="small text-white-50 mb-0 text-truncate"><?= esc($keterangan) ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Quote Banner -->
    <div class="container mb-5">
        <div class="visi-misi-card text-center p-4 p-md-5" data-aos="zoom-in">
            <i class="bi bi-quote fs-1 text-warning mb-2 d-block opacity-75"></i>
            <h4 class="fw-bold italic text-white mx-auto mb-3" style="max-width: 800px; font-style: italic; line-height: 1.6;">
                "Keindahan sejati bukan terletak pada kemegahan, melainkan pada ketulusan senyum warga dan hijaunya nafas alam kami."
            </h4>
            <span class="badge bg-gold text-dark fw-bold px-3 py-2" style="font-size: 0.85rem; letter-spacing: 1px;">
                DESA <?= esc(strtoupper($identitas['nama_desa'] ?? 'KAMI')) ?>
            </span>
        </div>
    </div>

    <!-- Video Section -->
    <?php if (!empty($videos)): ?>
    <div class="container">
        <h4 class="fw-bold text-green-dark mb-4 text-center text-md-start" data-aos="fade-up">
            <i class="bi bi-play-circle-fill text-green-mid me-2"></i>Dokumentasi &amp; Video Profil Desa
        </h4>
        <div class="row g-4">
            <?php foreach ($videos as $i => $v): ?>
            <?php if (empty($v['embed_url'])) continue; ?>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                <div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow-sm">
                    <iframe src="<?= esc($v['embed_url'], 'attr') ?>" title="<?= esc($v['judul'] ?? 'Video Profil Desa') ?>" allowfullscreen loading="lazy"></iframe>
                </div>
                <?php if (!empty($v['judul'])): ?>
                <h6 class="fw-bold mt-2 text-green-dark text-truncate"><?= esc($v['judul']) ?></h6>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</section>

<?php if (!empty($galeri)): ?>
<!-- Script Cover Flow Infinite Scroll -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const carousel = document.getElementById('galleryCarousel');
    if (!carousel) return;

    const items = Array.from(carousel.querySelectorAll('.cover-flow-item'));
    const totalItems = items.length;
    const originalCount = <?= (int)$galeriCount ?>;
    if (!totalItems || originalCount <= 0) return;

    let ticking = false;
    let isAdjustingScroll = false;

    // Single set width calculation (width of original count items)
    function getSetWidth() {
        if (totalItems < 2) return 0;
        const itemWidth = items[0].offsetWidth + 36; // width + margin
        return itemWidth * originalCount;
    }

    // Infinite Loop check
    function checkInfiniteLoop() {
        if (isAdjustingScroll) return;
        const setWidth = getSetWidth();
        if (setWidth <= 0) return;

        // If near end (scrolled too far right), jump back by 1 set width
        if (carousel.scrollLeft >= setWidth * 2.5) {
            isAdjustingScroll = true;
            carousel.style.scrollBehavior = 'auto';
            carousel.scrollLeft -= setWidth;
            carousel.style.scrollBehavior = 'smooth';
            isAdjustingScroll = false;
        } 
        // If near start (scrolled too far left), jump forward by 1 set width
        else if (carousel.scrollLeft <= setWidth * 0.5) {
            isAdjustingScroll = true;
            carousel.style.scrollBehavior = 'auto';
            carousel.scrollLeft += setWidth;
            carousel.style.scrollBehavior = 'smooth';
            isAdjustingScroll = false;
        }
    }

    // Update coverflow position, depth-scale, rotation, and opacity
    function updateCoverFlow() {
        checkInfiniteLoop();

        const carouselRect = carousel.getBoundingClientRect();
        const centerX = carouselRect.left + carouselRect.width / 2;

        items.forEach((item) => {
            const itemRect = item.getBoundingClientRect();
            const itemCenter = itemRect.left + itemRect.width / 2;
            const distanceFromCenter = Math.abs(centerX - itemCenter);
            const maxDistance = carouselRect.width / 2;

            const normalizedDistance = Math.min(distanceFromCenter / maxDistance, 1);

            // Scale: ~1.25 in center, drops down to 0.78 at edges
            const scale = 1.25 - (normalizedDistance * 0.45);
            const rotationY = (itemCenter < centerX ? 1 : -1) * (normalizedDistance * 18);
            const zIndex = Math.round(100 - normalizedDistance * 100);
            const opacity = Math.max(0.45, 1 - (normalizedDistance * 0.45));

            item.style.transform = `scale(${scale}) rotateY(${rotationY}deg)`;
            item.style.zIndex = zIndex;
            item.style.opacity = opacity;

            if (normalizedDistance < 0.2) {
                item.classList.add('is-center');
            } else {
                item.classList.remove('is-center');
            }
        });
        ticking = false;
    }

    function requestTick() {
        if (!ticking) {
            requestAnimationFrame(updateCoverFlow);
            ticking = true;
        }
    }

    carousel.addEventListener('scroll', requestTick, { passive: true });
    window.addEventListener('resize', requestTick, { passive: true });

    // Scroll to middle set on initial load
    function centerInitial() {
        const middleIndex = Math.floor(totalItems / 2);
        const targetItem = items[middleIndex] || items[0];
        if (targetItem) {
            const scrollPos = targetItem.offsetLeft - (carousel.clientWidth / 2) + (targetItem.clientWidth / 2);
            carousel.style.scrollBehavior = 'auto';
            carousel.scrollLeft = Math.max(0, scrollPos);
            carousel.style.scrollBehavior = 'smooth';
        }
        updateCoverFlow();
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                centerInitial();
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.2 });

    observer.observe(carousel);

    // Mouse drag scrolling functionality
    let isDown = false;
    let startX;
    let scrollLeftPos;
    let isDragging = false;

    carousel.addEventListener('mousedown', (e) => {
        isDown = true;
        isDragging = false;
        carousel.classList.add('cursor-grabbing');
        startX = e.pageX - carousel.offsetLeft;
        scrollLeftPos = carousel.scrollLeft;
    });

    carousel.addEventListener('mouseleave', () => {
        isDown = false;
        carousel.classList.remove('cursor-grabbing');
    });

    carousel.addEventListener('mouseup', () => {
        isDown = false;
        carousel.classList.remove('cursor-grabbing');
    });

    carousel.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        isDragging = true;
        const x = e.pageX - carousel.offsetLeft;
        const walk = (x - startX) * 1.8;
        carousel.scrollLeft = scrollLeftPos - walk;
    });



    // Scroll item to center on click
    items.forEach((item) => {
        item.addEventListener('click', () => {
            if (isDragging) return;
            const scrollPos = item.offsetLeft - (carousel.clientWidth / 2) + (item.clientWidth / 2);
            carousel.scrollTo({ left: scrollPos, behavior: 'smooth' });
        });
    });
});
</script>
<?php endif; ?>
<?php endif; ?>