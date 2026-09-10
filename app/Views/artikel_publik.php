<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($artikel['judul']) ?> — <?= esc($identitas['nama_desa'] ?? 'Desa') ?></title>
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

        /* Article Hero Header */
        .article-hero {
            background: linear-gradient(135deg, var(--green-dark) 0%, var(--green) 100%);
            position: relative;
            overflow: hidden;
            color: #fff;
            padding: 3.5rem 0 3rem;
        }
        .article-hero::before {
            content: '';
            position: absolute; inset: 0;
            background-image: radial-gradient(rgba(255,255,255,0.06) 1px, transparent 1px);
            background-size: 32px 32px;
            z-index: 1;
        }
        .hero-inner { position: relative; z-index: 2; }

        .breadcrumb-item + .breadcrumb-item::before { color: rgba(255,255,255,0.4); }
        .breadcrumb-item a { color: rgba(255,255,255,0.75); text-decoration: none; font-weight: 600; }
        .breadcrumb-item a:hover { color: var(--gold); }
        .breadcrumb-item.active { color: var(--gold); font-weight: 700; }

        .kategori-badge {
            background: rgba(251, 189, 50, 0.15);
            border: 1px solid rgba(251, 189, 50, 0.3);
            color: var(--gold);
            padding: 0.4rem 1.1rem;
            border-radius: 100px;
            font-size: 0.8rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .article-title {
            font-size: clamp(1.6rem, 3.5vw, 2.5rem);
            font-weight: 900;
            line-height: 1.25;
            color: #ffffff;
            letter-spacing: -0.5px;
        }

        .article-meta {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            color: rgba(255,255,255,0.8);
            font-size: 0.9rem;
            font-weight: 500;
            flex-wrap: wrap;
        }

        /* Article Main Content */
        .article-card {
            background: #ffffff;
            border-radius: 24px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.04);
            overflow: hidden;
        }

        .featured-img-wrap {
            width: 100%;
            max-height: 480px;
            overflow: hidden;
            background: var(--green-light);
        }
        .featured-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .article-body {
            font-size: 1.08rem;
            line-height: 1.85;
            color: var(--slate-800);
        }
        .article-body p {
            margin-bottom: 1.35rem;
        }
        .article-body img {
            max-width: 100%;
            height: auto;
            border-radius: 16px;
            margin: 1.5rem 0;
            box-shadow: 0 8px 24px rgba(0,0,0,0.06);
        }
        .article-body blockquote {
            border-left: 4px solid var(--green-mid);
            background: var(--green-light);
            padding: 1.25rem 1.5rem;
            border-radius: 0 16px 16px 0;
            font-style: italic;
            margin: 1.5rem 0;
            color: var(--green-dark);
            font-weight: 600;
        }

        /* Share Bar */
        .share-btn {
            width: 40px; height: 40px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center; justify-content: center;
            color: #fff;
            font-size: 1.1rem;
            text-decoration: none;
            transition: transform 0.2s, opacity 0.2s;
        }
        .share-btn:hover { transform: translateY(-3px); opacity: 0.9; color: #fff; }
        .btn-wa { background: #25D366; }
        .btn-fb { background: #1877F2; }
        .btn-tw { background: #000000; }
        .btn-copy { background: var(--slate-600); border: none; cursor: pointer; }

        /* Sidebar Widgets */
        .widget-card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            margin-bottom: 1.5rem;
        }
        .widget-title {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--slate-900);
            padding-bottom: 0.75rem;
            margin-bottom: 1.25rem;
            border-bottom: 2px solid var(--green-light);
            position: relative;
        }
        .widget-title::after {
            content: '';
            position: absolute;
            bottom: -2px; left: 0;
            width: 40px; height: 2px;
            background: var(--green-mid);
        }

        .recent-item {
            display: flex;
            gap: 1rem;
            align-items: center;
            padding-bottom: 1rem;
            margin-bottom: 1rem;
            border-bottom: 1px solid #f1f5f9;
            text-decoration: none;
            color: inherit;
            transition: transform 0.2s;
        }
        .recent-item:last-child { border-bottom: none; padding-bottom: 0; margin-bottom: 0; }
        .recent-item:hover { transform: translateX(4px); }
        .recent-thumb {
            width: 70px; height: 70px;
            border-radius: 14px;
            overflow: hidden;
            flex-shrink: 0;
            background: var(--green-light);
        }
        .recent-thumb img {
            width: 100%; height: 100%; object-fit: cover;
        }
        .recent-title {
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--slate-900);
            line-height: 1.35;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            transition: color 0.2s;
        }
        .recent-item:hover .recent-title { color: var(--green-mid); }
        .recent-date {
            font-size: 0.75rem;
            color: var(--slate-500);
            margin-top: 0.25rem;
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
                <a href="<?= site_url('berita') ?>" class="btn btn-sm btn-outline-light rounded-pill px-3 fw-bold">
                    <i class="bi bi-arrow-left me-1"></i> Berita
                </a>
            </div>
        </div>
    </nav>

    <!-- Article Hero Banner -->
    <header class="article-hero">
        <div class="container hero-inner">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <nav aria-label="breadcrumb" class="mb-3">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="<?= site_url('/') ?>"><i class="bi bi-house-door me-1"></i>Beranda</a></li>
                            <li class="breadcrumb-item"><a href="<?= site_url('berita') ?>">Berita</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail Artikel</li>
                        </ol>
                    </nav>

                    <div class="mb-3">
                        <span class="kategori-badge">
                            <i class="bi bi-tag-fill me-1"></i><?= esc($artikel['kategori'] ?? 'Berita') ?>
                        </span>
                    </div>

                    <h1 class="article-title mb-4"><?= esc($artikel['judul']) ?></h1>

                    <div class="article-meta">
                        <span><i class="bi bi-person-circle me-2 text-warning"></i><?= esc($artikel['penulis'] ?? 'Admin Desa') ?></span>
                        <span><i class="bi bi-calendar3 me-2 text-warning"></i><?= date('d F Y', strtotime($artikel['created_at'] ?? 'now')) ?></span>
                        <span><i class="bi bi-clock me-2 text-warning"></i><?= max(1, (int) ceil(str_word_count(strip_tags($artikel['isi'] ?? '')) / 200)) ?> Menit Baca</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="row justify-content-center g-4">
                
                <!-- Main Article Column -->
                <div class="col-lg-8">
                    <article class="article-card mb-4">
                        <?php if (!empty($artikel['gambar'])): ?>
                        <div class="featured-img-wrap">
                            <img src="<?= base_url('uploads/artikel/' . $artikel['gambar']) ?>" alt="<?= esc($artikel['judul']) ?>">
                        </div>
                        <?php endif; ?>

                        <div class="p-4 p-md-5">
                            <div class="article-body">
                                <?= nl2br(esc($artikel['isi'])) ?>
                            </div>

                            <!-- Share Buttons -->
                            <hr class="my-4">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-bold small text-muted me-2">Bagikan:</span>
                                    <?php $currentUrl = current_url(); ?>
                                    <a href="https://api.whatsapp.com/send?text=<?= urlencode($artikel['judul'] . ' - ' . $currentUrl) ?>" target="_blank" class="share-btn btn-wa" title="Bagikan ke WhatsApp">
                                        <i class="bi bi-whatsapp"></i>
                                    </a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($currentUrl) ?>" target="_blank" class="share-btn btn-fb" title="Bagikan ke Facebook">
                                        <i class="bi bi-facebook"></i>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url=<?= urlencode($currentUrl) ?>&text=<?= urlencode($artikel['judul']) ?>" target="_blank" class="share-btn btn-tw" title="Bagikan ke X">
                                        <i class="bi bi-twitter-x"></i>
                                    </a>
                                    <button onclick="copyArticleLink()" class="share-btn btn-copy" id="copyBtn" title="Salin Tautan">
                                        <i class="bi bi-link-45deg"></i>
                                    </button>
                                </div>
                                <a href="<?= site_url('berita') ?>" class="btn btn-outline-success rounded-pill px-4 fw-bold">
                                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Berita
                                </a>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- Sidebar Column -->
                <div class="col-lg-4">

                    <!-- Recent Articles Widget -->
                    <?php if (!empty($latestArtikel)): ?>
                    <div class="widget-card">
                        <h3 class="widget-title">Artikel Terbaru</h3>
                        <div class="recent-list">
                            <?php foreach ($latestArtikel as $la): ?>
                            <?php $laSlug = !empty($la['slug']) ? $la['slug'] : $la['id']; ?>
                            <a href="<?= site_url('baca-artikel/' . $laSlug) ?>" class="recent-item">
                                <div class="recent-thumb">
                                    <?php if (!empty($la['gambar'])): ?>
                                        <img src="<?= base_url('uploads/artikel/' . $la['gambar']) ?>" alt="<?= esc($la['judul']) ?>">
                                    <?php else: ?>
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-success-subtle">
                                            <i class="bi bi-newspaper text-success fs-5"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <h4 class="recent-title"><?= esc($la['judul']) ?></h4>
                                    <div class="recent-date">
                                        <i class="bi bi-calendar3 me-1"></i><?= date('d M Y', strtotime($la['created_at'])) ?>
                                    </div>
                                </div>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Quick Village Contact Widget -->
                    <div class="widget-card bg-white">
                        <h3 class="widget-title">Pelayanan Desa</h3>
                        <p class="small text-muted mb-3">Membutuhkan informasi atau pengurusan surat keterangan secara online?</p>
                        <a href="<?= site_url('surat/pilih') ?>" class="btn btn-success w-100 rounded-pill fw-bold py-2 mb-2">
                            <i class="bi bi-file-earmark-text me-2"></i> Pengajuan Surat
                        </a>
                        <a href="<?= site_url('/') ?>#kontak" class="btn btn-light border w-100 rounded-pill fw-bold py-2">
                            <i class="bi bi-geo-alt me-2"></i> Kontak Kami
                        </a>
                    </div>

                </div>

            </div>
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
    <script>
        function copyArticleLink() {
            navigator.clipboard.writeText(window.location.href).then(function() {
                const btn = document.getElementById('copyBtn');
                btn.innerHTML = '<i class="bi bi-check2"></i>';
                btn.style.background = '#21714c';
                setTimeout(() => {
                    btn.innerHTML = '<i class="bi bi-link-45deg"></i>';
                    btn.style.background = '';
                }, 2000);
            });
        }
    </script>
</body>
</html>
