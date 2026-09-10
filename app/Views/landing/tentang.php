<!-- ═══════════════════════════ TENTANG ═══════════════════════════ -->
<section class="tentang-section py-6" id="tentang">
    <div class="container">
        <!-- Header / Title -->
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="section-tag justify-content-center">Selayang Pandang</div>
            <h2 class="section-title">Profil & Narasi <span class="text-gradient">Desa <?= esc($identitas['nama_desa'] ?? 'Kami') ?></span></h2>
            <p class="section-desc mx-auto" style="max-width:700px">
                Mengenal lebih dekat sejarah, visi & misi, kondisi geografis, demografi, serta identitas resmi Pemerintahan Desa <?= esc($identitas['nama_desa'] ?? 'Kami') ?>.
            </p>
        </div>

        <div class="row g-4">
            <!-- Left Column: Narasi & Profil Utama -->
            <div class="col-lg-7 col-xl-8 d-flex flex-column gap-4">
                
                <!-- Sejarah Desa -->
                <?php if (!empty($identitas['sejarah'])): ?>
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white" data-aos="fade-up">
                    <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                        <div style="width:48px; height:48px; background:var(--green-light); border-radius:14px; display:flex; align-items:center; justify-content:center" class="flex-shrink-0">
                            <i class="bi bi-journal-text fs-4 text-green-mid"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0 text-green-dark">Sejarah & Asal-Usul Desa</h4>
                            <small class="text-muted">Latar belakang historis terbentuknya Desa <?= esc($identitas['nama_desa'] ?? '') ?></small>
                        </div>
                    </div>
                    <div class="history-text">
                        <?= nl2br(esc($identitas['sejarah'])) ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Visi & Misi Desa -->
                <?php if (!empty($identitas['visi_misi'])): ?>
                <div class="visi-misi-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="small fw-bold text-uppercase mb-3" style="letter-spacing:2px; opacity:0.9">
                        <i class="bi bi-lightbulb-fill me-2 text-warning"></i>Visi & Misi Desa
                    </div>
                    <div style="font-size:1.15rem; font-style:italic; position:relative; z-index:1; line-height:1.8">
                        "<?= nl2br(esc($identitas['visi_misi'])) ?>"
                    </div>
                </div>
                <?php endif; ?>

                <!-- Geografis & Demografi Grid -->
                <?php if (!empty($identitas['geografis']) || !empty($identitas['demografi'])): ?>
                <div class="row g-4">
                    <?php if (!empty($identitas['geografis'])): ?>
                    <div class="col-md-<?= !empty($identitas['demografi']) ? '6' : '12' ?>" data-aos="fade-up" data-aos-delay="150">
                        <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div style="width:42px; height:42px; background:rgba(33, 113, 76, 0.1); border-radius:12px; display:flex; align-items:center; justify-content:center" class="flex-shrink-0">
                                    <i class="bi bi-geo-alt-fill fs-5 text-green-mid"></i>
                                </div>
                                <h5 class="fw-bold mb-0 text-green-dark">Kondisi Geografis</h5>
                            </div>
                            <div class="text-muted" style="line-height:1.7">
                                <?= nl2br(esc($identitas['geografis'])) ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($identitas['demografi'])): ?>
                    <div class="col-md-<?= !empty($identitas['geografis']) ? '6' : '12' ?>" data-aos="fade-up" data-aos-delay="200">
                        <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div style="width:42px; height:42px; background:rgba(251, 189, 50, 0.15); border-radius:12px; display:flex; align-items:center; justify-content:center" class="flex-shrink-0">
                                    <i class="bi bi-people-fill fs-5 text-warning"></i>
                                </div>
                                <h5 class="fw-bold mb-0 text-green-dark">Kondisi Demografi</h5>
                            </div>
                            <div class="text-muted" style="line-height:1.7">
                                <?= nl2br(esc($identitas['demografi'])) ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

            </div>

            <!-- Right Column: Informasi Identitas Resmi Desa -->
            <div class="col-lg-5 col-xl-4" data-aos="fade-left" data-aos-delay="200">
                <div class="profile-info-card sticky-lg-top" style="top: 100px;">
                    <div class="d-flex align-items-center gap-3 mb-4 pb-4 border-bottom">
                        <?php 
                            $logoSrc = base_url('logoDesa.png');
                            if (!empty($identitas['logo'])) {
                                if (file_exists(FCPATH . 'uploads/' . $identitas['logo'])) {
                                    $logoSrc = base_url('uploads/' . $identitas['logo']);
                                } elseif (file_exists(FCPATH . $identitas['logo'])) {
                                    $logoSrc = base_url($identitas['logo']);
                                }
                            }
                        ?>
                        <img src="<?= $logoSrc ?>" alt="Logo Desa" style="width:50px; height:50px; object-fit:contain;" class="flex-shrink-0">
                        <div>
                            <h5 class="fw-bold mb-1">Informasi Desa</h5>
                            <p class="text-muted small mb-0">Identitas Resmi Pemerintahan</p>
                        </div>
                    </div>

                    <?php
                    $infoItems = [
                        ['icon' => 'bi-building',      'label' => 'Nama Desa',        'value' => $identitas['nama_desa'] ?? null],
                        ['icon' => 'bi-hash',          'label' => 'Kode Desa',        'value' => $identitas['kode_desa'] ?? null],
                        ['icon' => 'bi-person-badge',  'label' => 'Kepala Desa',      'value' => $identitas['nama_kepala_desa'] ?? null],
                        ['icon' => 'bi-card-heading',  'label' => 'NIP Kepala Desa',  'value' => $identitas['nip_kepala_desa'] ?? null],
                        ['icon' => 'bi-geo',           'label' => 'Kecamatan',        'value' => $identitas['kecamatan'] ?? null],
                        ['icon' => 'bi-map',           'label' => 'Kabupaten',        'value' => $identitas['kabupaten'] ?? null],
                        ['icon' => 'bi-flag',          'label' => 'Provinsi',         'value' => $identitas['provinsi'] ?? null],
                        ['icon' => 'bi-mailbox',       'label' => 'Kode Pos',         'value' => $identitas['kodepos'] ?? null],
                        ['icon' => 'bi-geo-alt',       'label' => 'Alamat Kantor',    'value' => $identitas['alamat_kantor'] ?? null],
                        ['icon' => 'bi-envelope',      'label' => 'Email',            'value' => $identitas['email'] ?? null],
                        ['icon' => 'bi-telephone',     'label' => 'Telepon',          'value' => $identitas['telepon'] ?? null],
                    ];
                    foreach ($infoItems as $item): 
                        if (empty($item['value'])) continue;
                    ?>
                    <div class="info-item py-2">
                        <div class="info-label text-muted small">
                            <i class="bi <?= esc($item['icon']) ?> text-green-mid"></i>
                            <?= esc($item['label']) ?>
                        </div>
                        <div class="info-value text-end small"><?= esc($item['value']) ?></div>
                    </div>
                    <?php endforeach; ?>

                    <!-- Social Media Links -->
                    <?php 
                    $hasSocial = !empty($identitas['facebook']) || !empty($identitas['instagram']) || !empty($identitas['youtube']) || !empty($identitas['twitter']);
                    if ($hasSocial): 
                    ?>
                    <div class="pt-4 mt-3 border-top text-center">
                        <div class="small fw-bold text-muted mb-3 text-uppercase" style="letter-spacing:1px">Media Sosial Resmi</div>
                        <div class="d-flex justify-content-center gap-2">
                            <?php if (!empty($identitas['facebook'])): ?>
                                <a href="<?= esc($identitas['facebook']) ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-circle" title="Facebook"><i class="bi bi-facebook"></i></a>
                            <?php endif; ?>
                            <?php if (!empty($identitas['instagram'])): ?>
                                <a href="<?= esc($identitas['instagram']) ?>" target="_blank" class="btn btn-sm btn-outline-danger rounded-circle" title="Instagram"><i class="bi bi-instagram"></i></a>
                            <?php endif; ?>
                            <?php if (!empty($identitas['youtube'])): ?>
                                <a href="<?= esc($identitas['youtube']) ?>" target="_blank" class="btn btn-sm btn-outline-danger rounded-circle" title="YouTube"><i class="bi bi-youtube"></i></a>
                            <?php endif; ?>
                            <?php if (!empty($identitas['twitter'])): ?>
                                <a href="<?= esc($identitas['twitter']) ?>" target="_blank" class="btn btn-sm btn-outline-dark rounded-circle" title="Twitter / X"><i class="bi bi-twitter-x"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>