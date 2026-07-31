<!-- ═══════════════════════════ HERO ═══════════════════════════ -->
<section class="hero" id="beranda">
    <div class="hero-grid"></div>
    <div class="hero-blob-1"></div>
    <div class="hero-blob-2"></div>
    <div class="container hero-content py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="hero-eyebrow">
                    <i class="bi bi-geo-alt-fill"></i>
                    <?= esc(implode(', ', array_filter([$identitas['kecamatan'] ?? '', $identitas['kabupaten'] ?? '']))) ?: 'Indonesia' ?>
                </div>
                <h1 class="mb-4">
                    Selamat Datang<br>di Desa
                    <span class="highlight"><?= esc($identitas['nama_desa'] ?? 'Kami') ?></span>
                </h1>
                <p class="hero-desc mb-5">
                    <?= esc(mb_substr(strip_tags($identitas['visi_misi'] ?? 'Bersama membangun desa yang maju, mandiri, dan sejahtera untuk seluruh masyarakat.'), 0, 180)) ?>...
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="#berita" class="btn btn-hero-primary">
                        <i class="bi bi-newspaper me-2"></i>Berita Terbaru
                    </a>
                    <a href="#layanan" class="btn btn-hero-secondary">
                        <i class="bi bi-envelope-paper me-2"></i>Layanan Surat
                    </a>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block" data-aos="fade-left">
                <div class="hero-card-glass p-4">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="hero-stat-card">
                                <div class="stat-val counter" data-target="<?= (int) ($statPenduduk ?? 0) ?>">0</div>
                                <div class="stat-label">Penduduk</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="hero-stat-card">
                                <div class="stat-val counter" data-target="<?= (int) ($statKK ?? 0) ?>">0</div>
                                <div class="stat-label">Keluarga</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="hero-stat-card">
                                <div class="stat-val counter" data-target="<?= (int) ($statArtikel ?? 0) ?>">0</div>
                                <div class="stat-label">Artikel</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="hero-stat-card">
                                <div class="stat-val counter" data-target="<?= count($galeri ?? []) ?>">0</div>
                                <div class="stat-label">Galeri</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>