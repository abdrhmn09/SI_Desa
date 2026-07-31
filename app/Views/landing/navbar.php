<!-- ═══════════════════════════ NAVBAR ═══════════════════════════ -->
<nav class="navbar navbar-expand-lg sticky-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="#beranda">
            <div class="brand-logo"><i class="bi bi-house-heart-fill text-white" style="font-size:.9rem"></i></div>
            <?= esc($identitas['nama_desa'] ?? 'Desa Kami') ?>
        </a>
        <button class="navbar-toggler border-0 p-1" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <i class="bi bi-list fs-4" style="color: var(--brown-dark);"></i>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav mx-auto gap-1">
                <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
                <li class="nav-item"><a class="nav-link" href="#sejarah-pemimpin">Sejarah Pemimpin</a></li>
                <li class="nav-item"><a class="nav-link" href="#layanan">Layanan</a></li>
                <li class="nav-item"><a class="nav-link" href="#struktur">Pemerintahan</a></li>
                <li class="nav-item"><a class="nav-link" href="#berita">Berita</a></li>
                <li class="nav-item"><a class="nav-link" href="#galeri">Galeri</a></li>
            </ul>
            <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
                <a class="nav-link btn-nav-login" href="<?= site_url('login') ?>">
                    <i class="bi bi-box-arrow-in-right me-1"></i>Masuk
                </a>
                <a class="nav-link btn-nav-daftar" href="<?= site_url('register') ?>">
                    <i class="bi bi-person-plus me-1"></i>Daftar
                </a>
            </div>
        </div>
    </div>
</nav>