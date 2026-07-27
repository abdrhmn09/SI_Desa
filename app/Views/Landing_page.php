<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($identitas['nama_desa'] ?? 'Desa') ?> — Website Resmi Desa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --green: #1a4731; --green-mid: #2d7a56; --green-light: #e8f5e9; }
        body { font-family: 'Segoe UI', sans-serif; }
        /* Navbar */
        .navbar { background: var(--green) !important; }
        .navbar-brand { font-weight: 800; color: #fff !important; font-size: 1.1rem; }
        .nav-link { color: rgba(255,255,255,.85) !important; }
        .nav-link:hover { color: #fff !important; }
        /* Hero */
        .hero {
            background: linear-gradient(135deg, var(--green) 0%, var(--green-mid) 100%);
            min-height: 90vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .hero-content { position: relative; z-index: 1; }
        .hero h1 { font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 900; color: #fff; line-height: 1.1; }
        .hero p { color: rgba(255,255,255,.85); font-size: 1.1rem; }
        .hero .badge-pill { background: rgba(255,255,255,.15); color: #fff; padding: .4rem .9rem; border-radius: 50px; font-size: .82rem; }
        /* Section */
        .section-title { font-size: 1.75rem; font-weight: 800; color: var(--green); }
        .section-subtitle { color: #64748b; }
        /* Stat cards */
        .stat-card { border: none; border-radius: 1rem; transition: transform .2s; }
        .stat-card:hover { transform: translateY(-4px); }
        /* Artikel card */
        .artikel-card { border: none; border-radius: 1rem; overflow: hidden; transition: box-shadow .2s; }
        .artikel-card:hover { box-shadow: 0 8px 30px rgba(0,0,0,.12); }
        .artikel-card .card-img-top { height: 180px; object-fit: cover; }
        /* Galeri */
        .galeri-img { border-radius: .75rem; overflow: hidden; aspect-ratio: 1; }
        .galeri-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .3s; }
        .galeri-img:hover img { transform: scale(1.05); }
        /* Struktur */
        .pejabat-card { border: none; border-radius: 1rem; text-align: center; transition: box-shadow .2s; }
        .pejabat-card:hover { box-shadow: 0 8px 30px rgba(0,0,0,.1); }
        .pejabat-avatar { width: 90px; height: 90px; border-radius: 50%; object-fit: cover; border: 3px solid var(--green-light); margin: 0 auto 1rem; display: block; }
        /* Footer */
        footer { background: var(--green); color: rgba(255,255,255,.8); }
        footer a { color: rgba(255,255,255,.7); text-decoration: none; }
        footer a:hover { color: #fff; }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="#">
            <i class="bi bi-house-heart-fill fs-5"></i>
            <?= esc($identitas['nama_desa'] ?? 'Desa') ?>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <i class="bi bi-list text-white fs-4"></i>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto gap-1">
                <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
                <li class="nav-item"><a class="nav-link" href="#struktur">Pemerintahan</a></li>
                <li class="nav-item"><a class="nav-link" href="#berita">Berita</a></li>
                <li class="nav-item"><a class="nav-link" href="#galeri">Galeri</a></li>
                <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
                <li class="nav-item d-flex align-items-center">
                    <a class="nav-link btn btn-sm btn-outline-light ms-2 px-3" href="<?= site_url('login') ?>"><i class="bi bi-box-arrow-in-right me-1"></i>Login</a>
                    <a class="nav-link btn btn-sm btn-light text-success ms-2 px-3 fw-bold" href="<?= site_url('register') ?>"><i class="bi bi-person-plus me-1"></i>Daftar</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="container hero-content py-5">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="badge-pill d-inline-block mb-3">
                    <i class="bi bi-geo-alt me-1"></i>
                    <?= esc(implode(', ', array_filter([$identitas['kecamatan'] ?? '', $identitas['kabupaten'] ?? '', $identitas['provinsi'] ?? '']))) ?: 'Indonesia' ?>
                </div>
                <h1>Selamat Datang di<br>Desa <?= esc($identitas['nama_desa'] ?? 'Kami') ?></h1>
                <p class="mt-3 mb-4"><?= esc(substr($identitas['visi_misi'] ?? 'Bersama membangun desa yang maju, mandiri, dan sejahtera untuk generasi mendatang.', 0, 180)) ?>...</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="#berita" class="btn btn-light btn-lg fw-semibold">
                        <i class="bi bi-newspaper me-2"></i>Baca Berita
                    </a>
                    <a href="#kontak" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-telephone me-2"></i>Hubungi Kami
                    </a>
                </div>
            </div>
            <div class="col-lg-5 mt-5 mt-lg-0 d-none d-lg-block text-center">
                <i class="bi bi-building-fill-check" style="font-size: 12rem; color: rgba(255,255,255,.15)"></i>
            </div>
        </div>
    </div>
</section>

<!-- STATISTIK -->
<section class="py-5 bg-white">
    <div class="container">

        <div class="row g-3 text-center">
            <div class="col-6 col-md-3">
                <div class="stat-card card p-4 shadow-sm">
                    <i class="bi bi-people-fill fs-1 text-success mb-2"></i>
                    <div class="fs-2 fw-bold text-success"><?= number_format($statPenduduk) ?></div>
                    <div class="text-muted">Jiwa</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card card p-4 shadow-sm">
                    <i class="bi bi-journal-bookmark-fill fs-1 text-primary mb-2"></i>
                    <div class="fs-2 fw-bold text-primary"><?= number_format($statKK) ?></div>
                    <div class="text-muted">Kartu Keluarga</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card card p-4 shadow-sm">
                    <i class="bi bi-newspaper fs-1 text-warning mb-2"></i>
                    <div class="fs-2 fw-bold text-warning"><?= number_format($statArtikel) ?></div>
                    <div class="text-muted">Artikel & Berita</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card card p-4 shadow-sm">
                    <i class="bi bi-camera-fill fs-1 text-danger mb-2"></i>
                    <div class="fs-2 fw-bold text-danger"><?= count($galeri ?? []) ?></div>
                    <div class="text-muted">Foto Galeri</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TENTANG DESA -->
<section class="py-5" id="tentang" style="background: var(--green-light)">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <div class="text-success small fw-bold text-uppercase mb-2">Tentang Desa</div>
                <h2 class="section-title mb-3">Desa <?= esc($identitas['nama_desa'] ?? 'Kami') ?></h2>
                <p class="text-muted mb-3">
                    <?= nl2br(esc($identitas['sejarah'] ?? 'Desa kami memiliki sejarah panjang dan kaya akan budaya lokal. Berdiri sejak lama, kami terus berinovasi untuk memberikan pelayanan terbaik kepada masyarakat.')) ?>
                </p>
                <?php if (!empty($identitas['visi_misi'])): ?>
                <div class="p-3 bg-white rounded-3 border-start border-4 border-success">
                    <div class="fw-bold text-success mb-1">Visi & Misi</div>
                    <p class="mb-0 small text-muted"><?= nl2br(esc(substr($identitas['visi_misi'], 0, 300))) ?>...</p>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-3 p-4">
                    <h6 class="fw-bold mb-3">Informasi Desa</h6>
                    <dl class="row mb-0">
                        <dt class="col-sm-4 text-muted fw-normal small">Kepala Desa</dt>
                        <dd class="col-sm-8 small fw-semibold"><?= esc($identitas['nama_kepala_desa'] ?? '-') ?></dd>
                        <dt class="col-sm-4 text-muted fw-normal small">Kecamatan</dt>
                        <dd class="col-sm-8 small"><?= esc($identitas['kecamatan'] ?? '-') ?></dd>
                        <dt class="col-sm-4 text-muted fw-normal small">Kabupaten</dt>
                        <dd class="col-sm-8 small"><?= esc($identitas['kabupaten'] ?? '-') ?></dd>
                        <dt class="col-sm-4 text-muted fw-normal small">Provinsi</dt>
                        <dd class="col-sm-8 small"><?= esc($identitas['provinsi'] ?? '-') ?></dd>
                        <dt class="col-sm-4 text-muted fw-normal small">Email</dt>
                        <dd class="col-sm-8 small"><?= esc($identitas['email'] ?? '-') ?></dd>
                        <dt class="col-sm-4 text-muted fw-normal small">Telepon</dt>
                        <dd class="col-sm-8 small"><?= esc($identitas['telepon'] ?? '-') ?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- STRUKTUR PEMERINTAHAN -->
<?php if (!empty($struktur)): ?>
<section class="py-5 bg-white" id="struktur">
    <div class="container">
        <div class="text-center mb-4">
            <div class="text-success small fw-bold text-uppercase mb-2">Struktur Organisasi</div>
            <h2 class="section-title">Pemerintahan Desa</h2>
            <p class="section-subtitle">Perangkat desa yang melayani masyarakat</p>
        </div>
        <div class="row g-3 justify-content-center">
            <?php foreach ($struktur as $s): ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="pejabat-card card p-3 shadow-sm">
                    <?php if (!empty($s['foto'])): ?>
                    <img src="<?= base_url('uploads/pejabat/'.$s['foto']) ?>" class="pejabat-avatar"
                        onerror="this.outerHTML='<div class=\'pejabat-avatar bg-success-subtle d-flex align-items-center justify-content-center\'><i class=\'bi bi-person fs-2 text-success\'></i></div>'">
                    <?php else: ?>
                    <div class="pejabat-avatar bg-success-subtle d-flex align-items-center justify-content-center">
                        <i class="bi bi-person fs-2 text-success"></i>
                    </div>
                    <?php endif; ?>
                    <div class="fw-bold small"><?= esc($s['nama_pejabat']) ?></div>
                    <div class="text-muted" style="font-size:.78rem"><?= esc($s['nama_jabatan']) ?></div>
                    <span class="badge bg-success-subtle text-success mt-1" style="font-size:.65rem"><?= esc($s['tahun']) ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- BERITA & ARTIKEL -->
<?php if (!empty($artikel)): ?>
<section class="py-5" id="berita" style="background: #f8fafc">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <div class="text-success small fw-bold text-uppercase mb-1">Informasi Terkini</div>
                <h2 class="section-title mb-0">Berita & Pengumuman</h2>
            </div>
        </div>
        <div class="row g-3">
            <?php foreach ($artikel as $a): ?>
            <div class="col-md-4">
                <div class="artikel-card card h-100 shadow-sm">
                    <?php if ($a['gambar']): ?>
                    <img src="<?= base_url('uploads/artikel/'.$a['gambar']) ?>" class="card-img-top" style="height:200px;object-fit:cover"
                        onerror="this.style.display='none'">
                    <?php else: ?>
                    <div class="d-flex align-items-center justify-content-center" style="height:140px;background:var(--green-light)">
                        <i class="bi bi-newspaper fs-2 text-success"></i>
                    </div>
                    <?php endif; ?>
                    <div class="card-body">
                        <?php $colors = ['Berita'=>'primary','Pengumuman'=>'warning','Agenda'=>'info']; ?>
                        <span class="badge bg-<?= $colors[$a['kategori']] ?? 'secondary' ?> mb-2"><?= esc($a['kategori']) ?></span>
                        <h6 class="fw-bold"><?= esc($a['judul']) ?></h6>
                        <p class="text-muted small"><?= esc(substr(strip_tags($a['isi']), 0, 120)) ?>...</p>
                    </div>
                    <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
                        <span class="text-muted small"><i class="bi bi-calendar me-1"></i><?= esc(substr($a['created_at'] ?? '', 0, 10)) ?></span>
                        <a href="<?= site_url('baca-artikel/'.$a['slug']) ?>" class="btn btn-sm btn-outline-success">Baca</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- GALERI -->
<?php if (!empty($galeri)): ?>
<section class="py-5 bg-white" id="galeri">
    <div class="container">
        <div class="text-center mb-4">
            <div class="text-success small fw-bold text-uppercase mb-1">Galeri</div>
            <h2 class="section-title">Foto Desa</h2>
        </div>
        <div class="row g-2">
            <?php foreach ($galeri as $g): ?>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="galeri-img shadow-sm">
                    <img src="<?= base_url('uploads/galeri/'.$g['file_gambar']) ?>"
                        alt="<?= esc($g['judul']) ?>"
                        onerror="this.parentElement.style.background='#f1f5f9';this.style.display='none'">
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- VIDEO -->
<?php if (!empty($videos)): ?>
<section class="py-5" style="background: var(--green-light)" id="video">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="section-title">Video Desa</h2>
        </div>
        <div class="row g-3 justify-content-center">
            <?php foreach ($videos as $v): ?>
            <?php if (!empty($v['embed_url'])): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="ratio ratio-16x9">
                        <iframe src="<?= esc($v['embed_url']) ?>" allowfullscreen title="<?= esc($v['judul']) ?>"></iframe>
                    </div>
                    <div class="card-body py-2">
                        <div class="fw-semibold small"><?= esc($v['judul']) ?></div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- PETA -->
<?php if (!empty($identitas['embed_peta'])): ?>
<section class="py-0" id="kontak">
    <div class="container-fluid p-0">
        <?= $identitas['embed_peta'] ?>
    </div>
</section>
<?php endif; ?>

<!-- FOOTER -->
<footer class="py-4" id="<?= empty($identitas['embed_peta']) ? 'kontak' : '' ?>">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <h6 class="text-white fw-bold mb-3"><i class="bi bi-house-heart-fill me-2"></i>Desa <?= esc($identitas['nama_desa'] ?? 'Kami') ?></h6>
                <p class="small"><?= esc($identitas['alamat_kantor'] ?? 'Kantor Desa') ?></p>
                <p class="small"><?= esc(implode(', ', array_filter([$identitas['kecamatan'] ?? '', $identitas['kabupaten'] ?? '']))) ?></p>
            </div>
            <div class="col-md-4">
                <h6 class="text-white fw-bold mb-3">Kontak</h6>
                <?php if (!empty($identitas['email'])): ?>
                <p class="small"><i class="bi bi-envelope me-2"></i><a href="mailto:<?= esc($identitas['email']) ?>"><?= esc($identitas['email']) ?></a></p>
                <?php endif; ?>
                <?php if (!empty($identitas['telepon'])): ?>
                <p class="small"><i class="bi bi-telephone me-2"></i><?= esc($identitas['telepon']) ?></p>
                <?php endif; ?>
            </div>
            <div class="col-md-4">
                <h6 class="text-white fw-bold mb-3">Media Sosial</h6>
                <div class="d-flex gap-3 flex-wrap">
                    <?php if (!empty($identitas['facebook'])): ?>
                    <a href="<?= esc($identitas['facebook']) ?>" target="_blank"><i class="bi bi-facebook fs-5"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($identitas['instagram'])): ?>
                    <a href="<?= esc($identitas['instagram']) ?>" target="_blank"><i class="bi bi-instagram fs-5"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($identitas['youtube'])): ?>
                    <a href="<?= esc($identitas['youtube']) ?>" target="_blank"><i class="bi bi-youtube fs-5"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($identitas['twitter'])): ?>
                    <a href="<?= esc($identitas['twitter']) ?>" target="_blank"><i class="bi bi-twitter-x fs-5"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <hr class="border-white border-opacity-25 my-3">
        <div class="text-center small">&copy; <?= date('Y') ?> Desa <?= esc($identitas['nama_desa'] ?? 'Kami') ?> — Powered by SI Desa</div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
