<!-- ═══════════════════════════ LAYANAN SURAT ═══════════════════════════ -->
<section class="layanan-section bg-green-soft py-6" id="layanan">
    <div class="container">
        <div class="row align-items-end mb-5">
            <div class="col" data-aos="fade-up">
                <div class="section-tag">Pelayanan Publik</div>
                <h2 class="section-title mb-0">Layanan Surat Digital</h2>
            </div>
            <div class="col-auto d-none d-md-block" data-aos="fade-up">
                <a href="<?= site_url('login') ?>" class="btn btn-outline-success rounded-pill px-4 fw-bold">
                    Lihat Semua Layanan <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
        <div class="row g-4">
            <?php foreach (($layanan ?? []) as $i => $l): ?>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                <div class="layanan-card">
                    <div class="layanan-icon" style="background:<?= esc($l['color'], 'attr') ?>; color:<?= esc($l['ic_color'], 'attr') ?>">
                        <i class="bi <?= esc($l['icon']) ?>"></i>
                    </div>
                    <h5 class="fw-bold mb-3"><?= esc($l['title']) ?></h5>
                    <p class="text-muted small mb-4"><?= esc($l['desc']) ?></p>
                    <a href="<?= site_url('login') ?>" class="btn btn-link p-0 text-decoration-none fw-bold text-green-mid">
                        Ajukan Sekarang <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="layanan-cta-banner mt-6" data-aos="zoom-in">
            <div class="row align-items-center position-relative z-index-1">
                <div class="col-lg-7">
                    <h2 class="fw-900 mb-3">Layanan Cepat & Transparan</h2>
                    <p class="fs-5 opacity-75 mb-0">Daftarkan akun Anda untuk mulai mengajukan surat secara online. Pantau status pengajuan kapanpun dan dimanapun.</p>
                </div>
                <div class="col-lg-5 text-lg-end mt-4 mt-lg-0">
                    <div class="d-flex flex-wrap gap-3 justify-content-lg-end">
                        <a href="<?= site_url('register') ?>" class="btn btn-hero-primary px-4 py-3">
                            <i class="bi bi-person-plus-fill me-2"></i>Daftar Sekarang
                        </a>
                        <a href="<?= site_url('login') ?>" class="btn btn-hero-secondary px-4 py-3">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk Akun
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>