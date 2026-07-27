<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($artikel['judul']) ?> — <?= esc($identitas['nama_desa'] ?? 'Desa') ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f8fafc; }
        .navbar { background: #1a4731 !important; }
        .navbar-brand { color: #fff !important; font-weight: 800; }
        .artikel-body { line-height: 1.9; font-size: 1.05rem; }
        .artikel-body p { margin-bottom: 1.2rem; }
        .kategori-badge { font-size: .8rem; }
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
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= site_url('/') ?>">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="<?= site_url('/') ?>#berita">Berita</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Artikel</li>
                </ol>
            </nav>

            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <?php if (!empty($artikel['gambar'])): ?>
                <img src="<?= site_url('uploads/artikel/'.$artikel['gambar']) ?>"
                    class="w-100" style="max-height:400px;object-fit:cover"
                    onerror="this.style.display='none'">
                <?php endif; ?>
                <div class="card-body p-4 p-md-5">
                    <?php $colors = ['Berita'=>'primary','Pengumuman'=>'warning','Agenda'=>'info']; ?>
                    <span class="badge bg-<?= $colors[$artikel['kategori']] ?? 'secondary' ?> kategori-badge mb-3">
                        <?= esc($artikel['kategori']) ?>
                    </span>
                    <h1 class="fw-bold mb-3" style="font-size:clamp(1.4rem,3vw,2rem)"><?= esc($artikel['judul']) ?></h1>
                    <div class="d-flex gap-3 text-muted small mb-4 flex-wrap">
                        <span><i class="bi bi-person me-1"></i><?= esc($artikel['penulis'] ?? 'Admin') ?></span>
                        <span><i class="bi bi-calendar me-1"></i><?= date('d F Y', strtotime($artikel['created_at'] ?? 'now')) ?></span>
                    </div>
                    <hr class="mb-4">
                    <div class="artikel-body">
                        <?= nl2br(esc($artikel['isi'])) ?>
                    </div>
                    <hr class="mt-5">
                    <a href="<?= site_url('/') ?>" class="btn btn-outline-success">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<footer style="background:#1a4731;color:rgba(255,255,255,.7)" class="py-3 mt-5">
    <div class="container text-center small">
        &copy; <?= date('Y') ?> Desa <?= esc($identitas['nama_desa'] ?? 'Kami') ?> — SI Desa
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
