<!-- ═══════════════════════════ BERITA ═══════════════════════════ -->
<?php if (!empty($artikel)): ?>
<section class="py-6" id="berita">
    <div class="container">
        <div class="row align-items-end mb-5">
            <div class="col" data-aos="fade-up">
                <div class="section-tag">Informasi Terkini</div>
                <h2 class="section-title mb-0">Berita &amp; Pengumuman</h2>
            </div>
            <div class="col-auto d-none d-md-block" data-aos="fade-up">
                <!-- TODO: sesuaikan rute daftar-semua-artikel di app/Config/Routes.php -->
                <a href="<?= site_url('berita') ?>" class="btn btn-outline-success rounded-pill px-4 fw-bold">
                    Lihat Semua Berita <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
        <div class="row g-4">
            <?php foreach ($artikel as $i => $a): ?>
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                <?php $slugArtikel = !empty($a['slug']) ? $a['slug'] : $a['id']; ?>
                <a href="<?= site_url('artikel/' . $slugArtikel) ?>" class="text-decoration-none text-reset">
                    <div class="artikel-card">
                        <div class="artikel-img">
                            <?php if (!empty($a['gambar'])): ?>
                            <img src="<?= base_url('uploads/artikel/' . $a['gambar']) ?>" alt="<?= esc($a['judul'] ?? '') ?>" loading="lazy">
                            <?php else: ?>
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-success-subtle">
                                <i class="bi bi-newspaper fs-1 text-success"></i>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($a['created_at'])): ?>
                            <span class="artikel-badge bg-white text-green-dark">
                                <?= esc(date('d M Y', strtotime($a['created_at']))) ?>
                            </span>
                            <?php endif; ?>
                        </div>
                        <div class="p-4">
                            <h5 class="fw-bold mb-2 text-dark"><?= esc($a['judul'] ?? 'Tanpa Judul') ?></h5>
                            <p class="text-muted small mb-0">
                                <?= esc(mb_substr(strip_tags($a['ringkasan'] ?? $a['isi'] ?? ''), 0, 110)) ?>...
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>