<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita &amp; Pengumuman — <?= esc($identitas['nama_desa'] ?? 'Desa') ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f8fafc; }
        .navbar { background: #1a4731 !important; }
        .navbar-brand { color: #fff !important; font-weight: 800; }
        .artikel-card { border-radius: 20px; overflow: hidden; height: 100%; transition: .3s; }
        .artikel-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(0,0,0,.08); }
        .artikel-img { height: 200px; overflow: hidden; }
        .artikel-img img { width: 100%; height: 100%; object-fit: cover; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg mb-0">
    <div class="container">
        <a class="navbar-brand" href="<?= site_url('/') ?>">
            <i class="bi bi-house-heart-fill me-2"></i><?= esc($identitas['nama_desa'] ?? 'Desa') ?>
        </a>
        <a href="<?= site_url('/') ?>" class="btn btn-sm btn-outline-light ms-auto">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</nav>

<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= site_url('/') ?>">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Berita</li>
        </ol>
    </nav>

    <h1 class="fw-bold mb-4">Berita &amp; Pengumuman</h1>

    <?php if (empty($artikel)): ?>
        <div class="alert alert-light border text-center py-5">
            <i class="bi bi-newspaper fs-1 text-muted d-block mb-2"></i>
            Belum ada berita yang diterbitkan.
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($artikel as $a): ?>
            <div class="col-md-6 col-lg-4">
                <?php $slugArtikel = !empty($a['slug']) ? $a['slug'] : $a['id']; ?>
                <a href="<?= site_url('artikel/' . $slugArtikel) ?>" class="text-decoration-none text-reset">
                    <div class="artikel-card border shadow-sm">
                        <div class="artikel-img">
                            <?php if (!empty($a['gambar'])): ?>
                            <img src="<?= base_url('uploads/artikel/' . $a['gambar']) ?>" alt="<?= esc($a['judul'] ?? '') ?>" loading="lazy">
                            <?php else: ?>
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-success-subtle">
                                <i class="bi bi-newspaper fs-1 text-success"></i>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="p-3">
                            <span class="badge bg-secondary mb-2"><?= esc($a['kategori'] ?? '') ?></span>
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

        <?php if (isset($pager)): ?>
        <div class="mt-5 d-flex justify-content-center">
            <?= $pager->links() ?>
        </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<footer style="background:#1a4731;color:rgba(255,255,255,.7)" class="py-3 mt-5">
    <div class="container text-center small">
        &copy; <?= date('Y') ?> Desa <?= esc($identitas['nama_desa'] ?? 'Kami') ?> — SI Desa
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>