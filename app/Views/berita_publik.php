<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita &amp; Pengumuman — <?= esc($identitas['nama_desa'] ?? 'Desa') ?></title>
    <link rel="icon" type="image/png" href="<?= base_url('logoDesa.png') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --green-dark:  #0a2e1c;
            --green:       #164e33;
            --green-mid:   #21714c;
            --green-light: #f0f9f4;
            --gold:        #fbbd32;
            --slate-900:   #0f172a;
            --slate-800:   #1e293b;
            --slate-600:   #475569;
            --slate-500:   #64748b;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--slate-800);
            background-color: #f8fafc;
            line-height: 1.6;
        }

        /* Navbar */
        .public-navbar {
            background: var(--green-dark);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 0.85rem 0;
        }
        .brand-logo {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, var(--gold), #e9962a);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 12px rgba(251, 189, 50, 0.3);
        }

        /* Page Banner */
        .page-banner {
            background: linear-gradient(135deg, var(--green-dark) 0%, var(--green) 100%);
            position: relative;
            overflow: hidden;
            color: #fff;
            padding: 3.5rem 0 3rem;
        }
        .page-banner::before {
            content: '';
            position: absolute; inset: 0;
            background-image: radial-gradient(rgba(255,255,255,0.06) 1px, transparent 1px);
            background-size: 32px 32px;
            z-index: 1;
        }
        .banner-content { position: relative; z-index: 2; }
        
        .breadcrumb-item + .breadcrumb-item::before { color: rgba(255,255,255,0.4); }
        .breadcrumb-item a { color: rgba(255,255,255,0.75); text-decoration: none; font-weight: 600; }
        .breadcrumb-item a:hover { color: var(--gold); }
        .breadcrumb-item.active { color: var(--gold); font-weight: 700; }

        /* Category Filter Pills */
        .filter-pill {
            background: #fff;
            color: var(--slate-600);
            border: 1px solid #e2e8f0;
            padding: 0.55rem 1.35rem;
            border-radius: 100px;
            font-weight: 700;
            font-size: 0.875rem;
            transition: all 0.25s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.02);
        }
        .filter-pill:hover, .filter-pill.active {
            background: var(--green-mid);
            color: #fff;
            border-color: var(--green-mid);
            box-shadow: 0 6px 18px rgba(33, 113, 76, 0.25);
            transform: translateY(-2px);
        }

        /* Article Cards */
        .artikel-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        }
        .artikel-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(10, 46, 28, 0.12);
            border-color: rgba(33, 113, 76, 0.3);
        }
        .artikel-img-wrap {
            height: 220px;
            overflow: hidden;
            position: relative;
            background: var(--green-light);
        }
        .artikel-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .artikel-card:hover .artikel-img-wrap img {
            transform: scale(1.08);
        }
        .artikel-badge {
            position: absolute;
            top: 1rem; left: 1rem;
            background: rgba(10, 46, 28, 0.85);
            backdrop-filter: blur(8px);
            color: var(--gold);
            padding: 0.35rem 0.85rem;
            border-radius: 100px;
            font-size: 0.725rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .artikel-date-badge {
            position: absolute;
            bottom: 1rem; right: 1rem;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            color: var(--slate-800);
            padding: 0.3rem 0.75rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 700;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }

        .artikel-content {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        .artikel-title {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--slate-900);
            margin-bottom: 0.75rem;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            transition: color 0.2s;
        }
        .artikel-card:hover .artikel-title {
            color: var(--green-mid);
        }
        .artikel-excerpt {
            color: var(--slate-600);
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 1.25rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .artikel-footer {
            margin-top: auto;
            padding-top: 1rem;
            border-top: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.825rem;
            color: var(--slate-500);
        }

        /* Custom Pagination */
        .pagination { gap: 0.4rem; justify-content: center; }
        .page-item .page-link {
            border: 1px solid #e2e8f0;
            border-radius: 10px !important;
            color: var(--slate-700);
            font-weight: 700;
            padding: 0.6rem 1rem;
            transition: all 0.2s;
        }
        .page-item.active .page-link {
            background-color: var(--green-mid);
            border-color: var(--green-mid);
            color: #fff;
            box-shadow: 0 4px 12px rgba(33, 113, 76, 0.3);
        }
        .page-item .page-link:hover {
            background-color: var(--green-light);
            color: var(--green-dark);
            border-color: rgba(33, 113, 76, 0.3);
        }

        /* Footer */
        footer {
            background: var(--green-dark);
            color: rgba(255, 255, 255, 0.7);
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Header Navbar -->
    <nav class="navbar public-navbar">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="<?= site_url('/') ?>">
                <?php 
                    $logoSrc = base_url('logoDesa.png');
                    if (!empty($identitas['logo']) && file_exists(FCPATH . 'uploads/' . $identitas['logo'])) {
                        $logoSrc = base_url('uploads/' . $identitas['logo']);
                    }
                ?>
                <img src="<?= $logoSrc ?>" alt="Logo <?= esc($identitas['nama_desa'] ?? 'Desa') ?>" style="height: 38px; width: auto; object-fit: contain;">
                <span class="text-white fw-bold fs-5"><?= esc($identitas['nama_desa'] ?? 'Desa Kami') ?></span>
            </a>
            <div class="d-flex align-items-center gap-2">
                <a href="<?= site_url('/') ?>" class="btn btn-sm btn-outline-light rounded-pill px-3 fw-bold">
                    <i class="bi bi-arrow-left me-1"></i> Beranda
                </a>
            </div>
        </div>
    </nav>

    <!-- Page Hero Banner -->
    <header class="page-banner">
        <div class="container banner-content">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?= site_url('/') ?>"><i class="bi bi-house-door me-1"></i>Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Berita &amp; Pengumuman</li>
                </ol>
            </nav>
            <h1 class="fw-900 display-6 text-white mb-2">Berita &amp; Informasi Desa</h1>
            <p class="mb-0 text-white-50 fs-6 max-w-600">
                Temukan pengumuman penting, berita terkini, dan agenda kegiatan resmi masyarakat Desa <?= esc($identitas['nama_desa'] ?? '') ?>.
            </p>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow-1 py-5">
        <div class="container">

            <!-- Filter Categories -->
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4 pb-2 border-bottom">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <a href="<?= site_url('berita') ?>" class="filter-pill <?= empty($kategori) ? 'active' : '' ?>">
                        <i class="bi bi-grid-fill"></i> Semua
                    </a>
                    <?php if (!empty($kategoriList)): ?>
                        <?php foreach ($kategoriList as $kat): ?>
                        <a href="<?= site_url('berita?kategori=' . urlencode($kat)) ?>" class="filter-pill <?= ($kategori === $kat) ? 'active' : '' ?>">
                            <?php if ($kat === 'Berita'): ?><i class="bi bi-newspaper"></i>
                            <?php elseif ($kat === 'Pengumuman'): ?><i class="bi bi-mega-phone"></i>
                            <?php elseif ($kat === 'Agenda'): ?><i class="bi bi-calendar-event"></i>
                            <?php endif; ?>
                            <?= esc($kat) ?>
                        </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <?php if (!empty($kategori)): ?>
                <div class="text-muted small">
                    Kategori: <span class="fw-bold text-dark"><?= esc($kategori) ?></span>
                    <a href="<?= site_url('berita') ?>" class="text-danger ms-2 text-decoration-none"><i class="bi bi-x-circle-fill"></i> Reset</a>
                </div>
                <?php endif; ?>
            </div>

            <!-- Articles Grid -->
            <?php if (empty($artikel)): ?>
                <div class="card border-0 shadow-sm rounded-4 text-center py-5 my-4">
                    <div class="card-body py-5">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center p-4 mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-newspaper fs-1 text-muted"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">Belum Ada Berita</h4>
                        <p class="text-muted mb-4">Belum ada artikel atau pengumuman yang diterbitkan untuk kategori ini.</p>
                        <a href="<?= site_url('berita') ?>" class="btn btn-outline-success rounded-pill px-4 fw-bold">
                            Lihat Semua Berita
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="row g-4 mb-5">
                    <?php foreach ($artikel as $a): ?>
                    <?php $slugArtikel = !empty($a['slug']) ? $a['slug'] : $a['id']; ?>
                    <div class="col-md-6 col-lg-4">
                        <a href="<?= site_url('baca-artikel/' . $slugArtikel) ?>" class="text-decoration-none">
                            <div class="artikel-card">
                                <div class="artikel-img-wrap">
                                    <?php if (!empty($a['gambar'])): ?>
                                        <img src="<?= base_url('uploads/artikel/' . $a['gambar']) ?>" alt="<?= esc($a['judul'] ?? '') ?>" loading="lazy">
                                    <?php else: ?>
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-success-subtle">
                                            <i class="bi bi-newspaper fs-1 text-success opacity-50"></i>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <span class="artikel-badge">
                                        <?= esc($a['kategori'] ?? 'Berita') ?>
                                    </span>
                                    
                                    <?php if (!empty($a['created_at'])): ?>
                                    <span class="artikel-date-badge">
                                        <i class="bi bi-calendar3 me-1"></i><?= date('d M Y', strtotime($a['created_at'])) ?>
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="artikel-content">
                                    <h2 class="artikel-title"><?= esc($a['judul'] ?? 'Tanpa Judul') ?></h2>
                                    <p class="artikel-excerpt">
                                        <?= esc(mb_substr(strip_tags($a['ringkasan'] ?? $a['isi'] ?? ''), 0, 120)) ?>...
                                    </p>
                                    <div class="artikel-footer">
                                        <span><i class="bi bi-person me-1"></i><?= esc($a['penulis'] ?? 'Admin Desa') ?></span>
                                        <span class="fw-bold text-success">Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <?php if (isset($pager)): ?>
                <div class="d-flex justify-content-center mt-4">
                    <?= $pager->links() ?>
                </div>
                <?php endif; ?>
            <?php endif; ?>

        </div>
    </main>

    <!-- Footer -->
    <footer class="py-4 mt-auto">
        <div class="container text-center small">
            <div class="mb-2">
                <span class="fw-bold text-white"><?= esc($identitas['nama_desa'] ?? 'Desa Kami') ?></span> — Sistem Informasi &amp; Pelayanan Desa
            </div>
            <div>&copy; <?= date('Y') ?> All rights reserved.</div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>