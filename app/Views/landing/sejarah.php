<!-- ═══════════════════════════ SEJARAH KEPEMIMPINAN ═══════════════════════════ -->
<?php if (!empty($sejarah)): ?>
<section class="py-6" id="sejarah-pemimpin">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="section-tag justify-content-center">Jejak Sejarah</div>
            <h2 class="section-title">Sejarah Kepemimpinan Desa</h2>
            <p class="section-desc mx-auto" style="max-width:600px">Daftar tokoh-tokoh hebat yang pernah memimpin dan berjasa dalam membangun desa dari masa ke masa.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="timeline">
                    <?php foreach ($sejarah as $i => $sk): ?>
                    <div class="timeline-item" data-aos="fade-up" data-aos-delay="<?= ($i % 5) * 100 ?>">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="fw-bold mb-0 text-green-dark">
                                    <i class="bi bi-person-fill me-2 text-success"></i><?= esc($sk['nama']) ?>
                                </h5>
                                <span class="badge bg-gold text-dark fw-bold px-3 py-2" style="font-size: 0.8rem;">
                                    Masa Jabatan: <?= esc($sk['masa_jabatan']) ?>
                                </span>
                            </div>
                            <?php if (!empty($sk['keterangan'])): ?>
                            <p class="text-muted small mb-0 mt-2"><?= esc($sk['keterangan']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>