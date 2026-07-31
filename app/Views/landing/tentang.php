<!-- ═══════════════════════════ TENTANG ═══════════════════════════ -->
<section class="tentang-section py-6" id="tentang">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="section-tag">Selayang Pandang</div>
                <h2 class="section-title">Mengenal Desa <br><span class="text-gradient"><?= esc($identitas['nama_desa'] ?? 'Kami') ?></span></h2>
                <div class="history-text mb-5">
                    <?= nl2br(esc(mb_substr($identitas['sejarah'] ?? 'Desa kami memiliki sejarah panjang...', 0, 450))) ?>
                </div>
                <?php if (!empty($identitas['visi_misi'])): ?>
                <div class="visi-misi-card" data-aos="zoom-in" data-aos-delay="100">
                    <div class="small fw-bold text-uppercase mb-3" style="letter-spacing:2px; opacity:0.8">
                        <i class="bi bi-lightbulb-fill me-2"></i>Visi & Misi
                    </div>
                    <div style="font-size:1.1rem; font-style:italic; position:relative; z-index:1; line-height:1.7">
                        "<?= esc($identitas['visi_misi']) ?>"
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                <div class="profile-info-card">
                    <div class="d-flex align-items-center gap-4 mb-5 pb-4 border-bottom">
                        <div style="width:60px; height:60px; background:var(--green-light); border-radius:18px; display:flex; align-items:center; justify-content:center">
                            <i class="bi bi-building fs-3" style="color:var(--green-mid)"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Informasi Desa</h5>
                            <p class="text-muted small mb-0">Identitas Resmi Pemerintahan Desa</p>
                        </div>
                    </div>
                    <?php
                    $infoItems = [
                        ['icon' => 'bi-person-badge', 'label' => 'Kepala Desa', 'value' => $identitas['nama_kepala_desa'] ?? '-'],
                        ['icon' => 'bi-map',          'label' => 'Kecamatan',   'value' => $identitas['kecamatan'] ?? '-'],
                        ['icon' => 'bi-geo',          'label' => 'Kabupaten',   'value' => $identitas['kabupaten'] ?? '-'],
                        ['icon' => 'bi-flag',         'label' => 'Provinsi',    'value' => $identitas['provinsi'] ?? '-'],
                        ['icon' => 'bi-envelope',     'label' => 'Email',       'value' => $identitas['email'] ?? '-'],
                        ['icon' => 'bi-telephone',    'label' => 'Telepon',     'value' => $identitas['telepon'] ?? '-'],
                    ];
                    foreach ($infoItems as $item): ?>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="bi <?= esc($item['icon']) ?> text-green-mid"></i>
                            <?= esc($item['label']) ?>
                        </div>
                        <div class="info-value"><?= esc($item['value']) ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>