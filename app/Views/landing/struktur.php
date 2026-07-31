<!-- ═══════════════════════════ STRUKTUR PEMERINTAHAN ═══════════════════════════ -->
<?php if (!empty($struktur)): ?>
<section class="struktur-section py-6" id="struktur">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="section-tag justify-content-center">Pimpinan Desa</div>
            <h2 class="section-title">Perangkat Desa</h2>
            <p class="section-desc mx-auto" style="max-width:600px">Pemerintahan yang berdedikasi melayani masyarakat dengan integritas dan sepenuh hati.</p>
        </div>
        <div class="row g-4 justify-content-center">
            <?php foreach ($struktur as $i => $s): ?>
            <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="<?= ($i % 4) * 100 ?>">
                <div class="pejabat-card">
                    <div class="pejabat-avatar-wrap">
                        <div class="pejabat-ring"></div>
                        <?php if (!empty($s['foto'])): ?>
                        <img src="<?= base_url('uploads/pejabat/' . $s['foto']) ?>"
                            class="pejabat-avatar" alt="<?= esc($s['nama_pejabat']) ?>"
                            onerror="this.outerHTML='<div class=\'pejabat-avatar bg-success-subtle d-flex align-items-center justify-content-center\'><i class=\'bi bi-person-fill fs-1 text-success\'></i></div>'">
                        <?php else: ?>
                        <div class="pejabat-avatar bg-success-subtle d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-fill fs-1 text-success"></i>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="px-2">
                        <h6 class="fw-800 mb-1 text-truncate"><?= esc($s['nama_pejabat']) ?></h6>
                        <p class="text-green-mid small fw-bold mb-3 text-uppercase" style="letter-spacing:1px; font-size:0.7rem"><?= esc($s['nama_jabatan']) ?></p>
                        <span class="badge rounded-pill bg-white border text-muted px-3 py-2 fw-semibold" style="font-size:0.65rem">Masa Jabatan: <?= esc($s['tahun']) ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>