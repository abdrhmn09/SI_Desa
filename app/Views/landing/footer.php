<!-- ═══════════════════════════ FOOTER ═══════════════════════════ -->
<footer class="pt-5 pb-4" id="kontak">
    <div class="container">
        <div class="row g-5 pb-4">
            <div class="col-lg-4 col-md-6">
                <div class="footer-brand d-flex align-items-center gap-2 mb-3">
                    <div class="brand-logo"><i class="bi bi-house-heart-fill text-white" style="font-size:.9rem"></i></div>
                    <span class="text-white fw-bold">Desa <?= esc($identitas['nama_desa'] ?? 'Kami') ?></span>
                </div>
                <p class="small mb-3" style="line-height:1.75">
                    <?= esc($identitas['alamat_kantor'] ?? 'Kantor Desa') ?><br>
                    <?= esc(implode(', ', array_filter([$identitas['kecamatan'] ?? '', $identitas['kabupaten'] ?? '', $identitas['provinsi'] ?? '']))) ?>
                </p>
                <h6 class="text-white fw-bold mb-3">Kontak</h6>
                <ul class="list-unstyled small mb-3">
                    <?php if (!empty($identitas['email'])): ?>
                    <li class="mb-2"><i class="bi bi-envelope me-2"></i><?= esc($identitas['email']) ?></li>
                    <?php endif; ?>
                    <?php if (!empty($identitas['telepon'])): ?>
                    <li class="mb-2"><i class="bi bi-telephone me-2"></i><?= esc($identitas['telepon']) ?></li>
                    <?php endif; ?>
                </ul>
                <?php
                $sosmed = [
                    'facebook'  => ['icon' => 'bi-facebook',  'url' => $identitas['facebook'] ?? ''],
                    'instagram' => ['icon' => 'bi-instagram', 'url' => $identitas['instagram'] ?? ''],
                    'youtube'   => ['icon' => 'bi-youtube',   'url' => $identitas['youtube'] ?? ''],
                    'twitter'   => ['icon' => 'bi-twitter-x', 'url' => $identitas['twitter'] ?? ''],
                ];
                $sosmedAktif = array_filter($sosmed, static fn ($s) => !empty($s['url']));
                ?>
                <?php if (!empty($sosmedAktif)): ?>
                <div class="d-flex gap-2 mt-3">
                    <?php foreach ($sosmedAktif as $s): ?>
                    <a href="<?= esc($s['url'], 'attr') ?>" target="_blank" rel="noopener" class="social-link">
                        <i class="bi <?= esc($s['icon']) ?>"></i>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-6 col-md-3 col-lg-2">
                <h6 class="text-white fw-bold mb-3">Navigasi</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#tentang" class="footer-link">Tentang Desa</a></li>
                    <li class="mb-2"><a href="#sejarah-pemimpin" class="footer-link">Sejarah Pemimpin</a></li>
                    <li class="mb-2"><a href="#layanan" class="footer-link">Layanan Surat</a></li>
                    <li class="mb-2"><a href="#struktur" class="footer-link">Pemerintahan</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-3 col-lg-2">
                <h6 class="text-white fw-bold mb-3">Informasi</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#berita" class="footer-link">Berita</a></li>
                    <li class="mb-2"><a href="#galeri" class="footer-link">Galeri</a></li>
                    <li class="mb-2"><a href="<?= site_url('login') ?>" class="footer-link">Masuk Akun</a></li>
                    <li class="mb-2"><a href="<?= site_url('register') ?>" class="footer-link">Daftar Akun</a></li>
                </ul>
            </div>
            <div class="col-md-12 col-lg-4">
                <?php
                // Kolom `embed_peta` bisa berisi:
                // 1) URL embed langsung (mis. dari "Sematkan peta" > salin src), atau
                // 2) potongan HTML <iframe ...> lengkap hasil copy-paste dari Google Maps.
                // Ambil src-nya saja lalu tampilkan lewat iframe milik kita sendiri —
                // supaya kita bisa pakai esc(...,'attr') dan tidak menampilkan HTML
                // mentah dari database apa adanya.
                $embedPeta    = trim($identitas['embed_peta'] ?? '');
                $petaSrc      = null;
                if ($embedPeta !== '') {
                    if (stripos($embedPeta, '<iframe') !== false) {
                        preg_match('/src="([^"]+)"/i', $embedPeta, $match);
                        $petaSrc = $match[1] ?? null;
                    } else {
                        $petaSrc = $embedPeta;
                    }
                }
                ?>
                <?php if (!empty($petaSrc)): ?>
                <h6 class="text-white fw-bold mb-2 mt-4">Lokasi Kami</h6>
                <div class="peta-embed-wrap ratio ratio-16x9 rounded-4 overflow-hidden">
                    <iframe src="<?= esc($petaSrc, 'attr') ?>"
                            title="Peta Lokasi Desa <?= esc($identitas['nama_desa'] ?? '') ?>"
                            loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <hr class="footer-divider">
        <div class="text-center pt-2">
            <span class="small" style="color:rgba(255,255,255,.4)">
                &copy; <?= date('Y') ?> Desa <?= esc($identitas['nama_desa'] ?? 'Kami') ?>. Semua hak dilindungi.
            </span>
        </div>
    </div>
</footer>