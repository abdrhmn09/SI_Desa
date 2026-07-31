<!-- ═══════════════════════════ GALERI & VIDEO ═══════════════════════════ -->
<?php if (!empty($galeri) || !empty($videos)): ?>
<section class="bg-green-soft py-6" id="galeri">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="section-tag justify-content-center">Dokumentasi</div>
            <h2 class="section-title">Galeri &amp; Video Desa</h2>
            <p class="section-desc mx-auto" style="max-width:600px">Kumpulan momen dan kegiatan yang telah didokumentasikan oleh pemerintah desa.</p>
        </div>

        <?php if (!empty($galeri)): ?>
        <div class="galeri-grid-3 <?= !empty($videos) ? 'mb-6' : '' ?>">
            <?php foreach ($galeri as $i => $g): ?>
            <?php $urlGambar = base_url('uploads/galeri/' . ($g['file_gambar'] ?? '')); ?>
            <div class="galeri-grid-item" data-aos="zoom-in" data-aos-delay="<?= ($i % 6) * 80 ?>"
                 data-img="<?= esc($urlGambar, 'attr') ?>"
                 data-caption="<?= esc($g['judul'] ?? '') ?>"
                 role="button" tabindex="0">
                <img src="<?= $urlGambar ?>" alt="<?= esc($g['judul'] ?? 'Galeri Desa') ?>" loading="lazy">
                <?php if (!empty($g['judul'])): ?>
                <div class="galeri-grid-overlay"><?= esc($g['judul']) ?></div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($videos)): ?>
        <h4 class="fw-bold text-green-dark mb-4" data-aos="fade-up">
            <i class="bi bi-play-circle-fill text-green-mid me-2"></i>Video Profil Desa
        </h4>
        <div class="row g-4">
            <?php foreach ($videos as $i => $v): ?>
            <?php if (empty($v['embed_url'])) continue; ?>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                <div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow-sm">
                    <iframe src="<?= esc($v['embed_url'], 'attr') ?>" title="Video Profil Desa" allowfullscreen loading="lazy"></iframe>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php if (!empty($galeri)): ?>
<!-- Modal Lightbox Galeri -->
<div class="modal fade" id="galleryLightbox" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="lightbox-close" data-bs-dismiss="modal" aria-label="Tutup">
                    <i class="bi bi-x-lg"></i>
                </button>
                <button type="button" class="lightbox-nav prev" id="lightboxPrev" aria-label="Sebelumnya">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <img id="lightboxImage" src="" alt="" class="img-fluid rounded-4" style="max-height:85vh;">
                <button type="button" class="lightbox-nav next" id="lightboxNext" aria-label="Berikutnya">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php endif; ?>