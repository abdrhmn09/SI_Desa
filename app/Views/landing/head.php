<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($identitas['nama_desa'] ?? 'Desa') ?> — Website Resmi Desa</title>
    <link rel="icon" type="image/png" href="<?= base_url('logoDesa.png') ?>">
    <meta name="description" content="<?= esc(mb_substr(strip_tags($identitas['visi_misi'] ?? $identitas['sejarah'] ?? 'Website resmi desa.'), 0, 160)) ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    <style>
        :root {
            --brown-dark:  #3E2723;
            --green-dark:  #0a2e1c;
            --green:       #164e33;
            --green-mid:   #21714c;
            --green-light: #f0f9f4;
            --gold:        #fbbd32;
            --gold-light:  #fffbeb;
            --slate-900:   #0f172a;
            --slate-800:   #1e293b;
            --slate-600:   #475569;
            --slate-500:   #64748b;
            --glass:       rgba(255, 255, 255, 0.85);
            --glass-dark:  rgba(10, 46, 28, 0.85);
        }

        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--slate-800);
            background: #ffffff;
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* ───────── NAVBAR ───────── */
        .navbar {
            background: transparent !important;
            padding: 1.25rem 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-bottom: 1px solid transparent;
        }
        .navbar.scrolled {
            background: var(--glass-dark) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 0.75rem 0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .navbar-brand {
            font-weight: 800;
            font-size: 1.25rem;
            color: var(--brown-dark) !important;
            letter-spacing: -0.5px;
        }
        /* Dipakai ulang di navbar & footer, jadi TIDAK di-scope ke .navbar-brand saja */
        .brand-logo {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, var(--gold), #e9962a);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 12px rgba(251, 189, 50, 0.3);
            flex-shrink: 0;
        }
        .nav-link {
            color: rgba(62, 39, 35, 0.85) !important;
            font-weight: 600;
            font-size: 0.925rem;
            padding: 0.5rem 1rem !important;
            transition: all 0.25s;
            position: relative;
        }
        .nav-link::after {
            content: '';
            position: absolute; bottom: 0; left: 1rem; right: 1rem;
            height: 2px; background: var(--gold);
            transform: scaleX(0); transition: transform 0.3s;
        }
        .nav-link:hover { color: var(--brown-dark) !important; }
        .nav-link:hover::after { transform: scaleX(1); }

        .btn-nav-login {
            color: var(--brown-dark) !important;
            font-weight: 700;
            padding: 0.5rem 1.25rem !important;
        }
        .btn-nav-daftar {
            background: var(--gold) !important;
            color: var(--green-dark) !important;
            border-radius: 10px;
            padding: 0.6rem 1.5rem !important;
            font-weight: 800;
            box-shadow: 0 4px 15px rgba(251, 189, 50, 0.25);
            transition: all 0.3s;
        }
        .btn-nav-daftar:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(251, 189, 50, 0.4); }

        /* ───────── HERO ───────── */
        .hero {
            position: relative;
            min-height: 100vh;
            padding-top: 100px;
            display: flex;
            align-items: center;
            background: radial-gradient(circle at top right, #1a5c38, #0a2e1c);
            overflow: hidden;
        }
        .hero-blob-1, .hero-blob-2 {
            position: absolute; border-radius: 50%; filter: blur(80px); z-index: 1; opacity: 0.4;
        }
        .hero-blob-1 { top: -10%; right: -5%; width: 500px; height: 500px; background: var(--gold); }
        .hero-blob-2 { bottom: -10%; left: -5%; width: 600px; height: 600px; background: var(--green-mid); }
        .hero-grid {
            position: absolute; inset: 0;
            background-image: radial-gradient(rgba(255,255,255,0.05) 1px, transparent 1px);
            background-size: 40px 40px;
            z-index: 1;
        }
        .hero-content { position: relative; z-index: 10; }

        .hero-eyebrow {
            display: inline-flex; align-items: center; gap: 0.6rem;
            background: rgba(251, 189, 50, 0.12);
            border: 1px solid rgba(251, 189, 50, 0.2);
            color: var(--gold);
            font-size: 0.85rem; font-weight: 800;
            padding: 0.5rem 1.25rem; border-radius: 100px;
            margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 1px;
        }
        .hero h1 {
            font-size: clamp(2.5rem, 6vw, 4.5rem);
            font-weight: 900; color: #fff;
            line-height: 1.05; letter-spacing: -2px; margin-bottom: 1.5rem;
        }
        .hero h1 span.highlight {
            background: linear-gradient(to right, var(--gold), #f9d371);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .hero-desc { color: rgba(255,255,255,0.75); font-size: 1.15rem; max-width: 540px; margin-bottom: 2.5rem; }

        .btn-hero-primary {
            background: var(--gold); color: var(--green-dark);
            padding: 1rem 2rem; border-radius: 14px; font-weight: 800;
            box-shadow: 0 10px 25px rgba(251, 189, 50, 0.3);
            transition: all 0.3s; border: none;
        }
        .btn-hero-primary:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(251, 189, 50, 0.5); color: var(--green-dark); }
        .btn-hero-secondary {
            background: rgba(255,255,255,0.1); color: #fff;
            padding: 1rem 2rem; border-radius: 14px; font-weight: 700;
            border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s;
        }
        .btn-hero-secondary:hover { background: rgba(255,255,255,0.15); border-color: rgba(255,255,255,0.4); color: #fff; }

        .hero-card-glass {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 28px; padding: 2rem;
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
        }
        .hero-stat-card {
            background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px; padding: 1.25rem; text-align: center;
            transition: transform 0.3s;
        }
        .hero-stat-card:hover { transform: translateY(-5px); background: rgba(255,255,255,0.08); }
        .stat-val { font-size: 2rem; font-weight: 900; color: #fff; line-height: 1; }
        .stat-label { font-size: 0.75rem; color: rgba(255,255,255,0.5); text-transform: uppercase; letter-spacing: 1px; margin-top: 0.4rem; }

        /* ───────── STAT STRIP ───────── */
        .stat-strip { background: #fff; padding: 2rem 0; border-bottom: 1px solid #f1f5f9; }
        .stat-box {
            display: flex; align-items: center; gap: 1.25rem; padding: 1rem;
            transition: transform 0.3s;
        }
        .stat-box:hover { transform: translateY(-3px); }
        .stat-box i {
            width: 60px; height: 60px; border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
        }
        .stat-box .num { font-size: 2.25rem; font-weight: 900; color: var(--green-dark); line-height: 1; letter-spacing: -1px; }
        .stat-box .lbl { font-size: 0.85rem; color: var(--slate-500); font-weight: 600; }

        /* ───────── SECTIONS ───────── */
        section { padding: 6rem 0; }
        .section-tag {
            display: inline-flex; align-items: center; gap: 0.5rem;
            color: var(--green-mid); font-weight: 800; font-size: 0.8rem;
            text-transform: uppercase; letter-spacing: 2px; margin-bottom: 0.75rem;
        }
        .section-tag::before { content: ""; width: 24px; height: 2px; background: var(--gold); border-radius: 2px; }
        .section-title { font-size: clamp(2rem, 4vw, 2.75rem); font-weight: 900; color: var(--green-dark); letter-spacing: -1px; margin-bottom: 1.5rem; }
        .section-desc { color: var(--slate-600); font-size: 1.1rem; margin-bottom: 2rem; }

        /* ───────── TENTANG & TIMELINE ───────── */
        .tentang-section { background: var(--green-light); }
        .history-text { font-size: 1.05rem; line-height: 1.8; color: var(--slate-600); }
        .visi-misi-card {
            background: linear-gradient(135deg, var(--green), var(--green-mid));
            border-radius: 24px; padding: 2.5rem; color: #fff; position: relative; overflow: hidden;
            box-shadow: 0 20px 40px rgba(22, 78, 51, 0.2);
        }
        .visi-misi-card::after {
            content: "\f471"; font-family: "bootstrap-icons";
            position: absolute; top: -10px; right: 20px; font-size: 8rem; opacity: 0.08;
        }
        .profile-info-card {
            background: #fff; border-radius: 24px; padding: 2.5rem;
            box-shadow: 0 15px 40px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;
        }
        .info-item {
            display: flex; justify-content: space-between; align-items: center;
            padding: 1rem 0; border-bottom: 1px solid #f1f5f9;
        }
        .info-item:last-child { border-bottom: none; }
        .info-label { display: flex; align-items: center; gap: 0.75rem; color: var(--slate-500); font-weight: 600; }
        .info-value { color: var(--green-dark); font-weight: 700; }

        /* TIMELINE SEJARAH KEPEMIMPINAN */
        .timeline {
            position: relative;
            padding-left: 2.5rem;
            border-left: 3px dashed var(--green-mid);
            margin: 2rem 0;
        }
        .timeline-item {
            position: relative;
            margin-bottom: 2rem;
        }
        .timeline-item:last-child { margin-bottom: 0; }
        .timeline-marker {
            position: absolute;
            left: -3.35rem;
            top: 0.2rem;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: var(--gold);
            border: 4px solid #fff;
            box-shadow: 0 0 0 4px var(--green-light);
            z-index: 2;
        }
        .timeline-content {
            background: #fff;
            padding: 1.5rem;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            border: 1px solid #f1f5f9;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .timeline-content:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.08);
            border-color: var(--green-mid);
        }

        /* ───────── LAYANAN ───────── */
        .layanan-card {
            background: #fff; border-radius: 24px; padding: 2.25rem;
            border: 1px solid #f1f5f9; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%; position: relative;
        }
        .layanan-card:hover {
            transform: translateY(-10px); border-color: var(--green-mid);
            box-shadow: 0 25px 60px rgba(33, 113, 76, 0.12);
        }
        .layanan-icon {
            width: 64px; height: 64px; border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.75rem; margin-bottom: 1.75rem;
        }
        .layanan-cta-banner {
            background: linear-gradient(135deg, var(--green-dark), var(--green-mid));
            border-radius: 32px; padding: 4rem; color: #fff;
            position: relative; overflow: hidden;
        }
        .layanan-cta-banner::before {
            content: ""; position: absolute; inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2v-4h4v-2h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2v-4h4v-2H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        /* ───────── PEMERINTAHAN ───────── */
        .pejabat-card {
            background: #fff; border-radius: 24px; padding: 1.5rem; text-align: center;
            border: 1px solid #f1f5f9; transition: all 0.3s;
        }
        .pejabat-card:hover { transform: translateY(-5px); box-shadow: 0 15px 35px rgba(0,0,0,0.08); border-color: var(--green-mid); }
        .pejabat-avatar-wrap {
            position: relative; width: 100px; height: 100px; margin: 0 auto 1.25rem;
        }
        .pejabat-avatar {
            width: 100px; height: 100px; border-radius: 50%; object-fit: cover;
            border: 4px solid var(--green-light); box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .pejabat-ring {
            position: absolute; inset: -6px; border-radius: 50%;
            border: 2px dashed rgba(33, 113, 76, 0.2);
            animation: rotate 20s linear infinite;
        }
        @keyframes rotate { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

        /* ───────── BERITA ───────── */
        .artikel-card {
            background: #fff; border-radius: 24px; overflow: hidden;
            border: 1px solid #f1f5f9; transition: all 0.4s; height: 100%;
        }
        .artikel-card:hover { transform: translateY(-8px); box-shadow: 0 25px 50px rgba(0,0,0,0.1); border-color: var(--green-mid); }
        .artikel-img { height: 240px; overflow: hidden; position: relative; }
        .artikel-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s; }
        .artikel-card:hover .artikel-img img { transform: scale(1.1); }
        .artikel-badge {
            position: absolute; top: 1.25rem; left: 1.25rem;
            padding: 0.4rem 1rem; border-radius: 100px; font-weight: 800; font-size: 0.7rem;
            text-transform: uppercase; letter-spacing: 1px; backdrop-filter: blur(8px);
        }

        /* ───────── GALERI COVER FLOW CAROUSEL ───────── */
        .galeri-carousel-wrap {
            position: relative;
            padding: 1.5rem 0;
            perspective: 1200px;
            overflow: hidden;
        }
        .galeri-carousel {
            display: flex;
            align-items: center;
            overflow-x: auto;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            padding: 3rem 35vw;
            cursor: grab;
            user-select: none;
        }
        .galeri-carousel::-webkit-scrollbar { display: none; }
        .galeri-carousel.cursor-grabbing { cursor: grabbing; scroll-behavior: auto; }
        .cover-flow-item {
            flex: 0 0 auto;
            width: 440px;
            height: 285px;
            margin: 0 18px;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.18);
            background: var(--slate-900);
            position: relative;
            transition: transform 0.35s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.35s ease, box-shadow 0.35s ease;
            transform-style: preserve-3d;
            will-change: transform, opacity;
            cursor: pointer;
        }
        .cover-flow-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            pointer-events: none;
            transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1);
        }
        .cover-flow-item:hover img {
            transform: scale(1.08);
        }
        .cover-flow-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(10, 46, 28, 0.92) 0%, rgba(10, 46, 28, 0.3) 55%, transparent 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 1.5rem;
            color: #fff;
            opacity: 0;
            transition: opacity 0.35s ease;
        }
        .cover-flow-item.is-center .cover-flow-overlay,
        .cover-flow-item:hover .cover-flow-overlay {
            opacity: 1;
        }
        @media (max-width: 768px) {
            .galeri-carousel {
                padding: 2.5rem 15vw;
            }
            .cover-flow-item {
                width: 300px;
                height: 195px;
                margin: 0 10px;
            }
        }

        /* ───────── FOOTER ───────── */
        footer { background: var(--green-dark); color: rgba(255,255,255,.65); padding-top: 5rem; }
        .peta-embed-wrap { border: 1px solid rgba(255,255,255,.1); }
        .footer-logo { font-size: 1.5rem; font-weight: 900; color: #fff; margin-bottom: 1.5rem; }
        .footer-link { color: #94a3b8; text-decoration: none; transition: 0.2s; font-weight: 500; }
        .footer-link:hover { color: var(--gold); }
        .footer-divider { border-color: rgba(255,255,255,.08); margin: 2rem 0 1.5rem; }
        .social-link {
            width: 44px; height: 44px; border-radius: 12px; background: rgba(255,255,255,0.05);
            display: flex; align-items: center; justify-content: center; color: #fff; transition: 0.3s;
        }
        .social-link:hover { background: var(--gold); color: var(--green-dark); transform: translateY(-3px); }

        /* ───────── UTILITAS ───────── */
        .text-gradient { background: linear-gradient(to right, var(--green-mid), var(--green-dark)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .bg-green-soft { background: var(--green-light); }
        .bg-gold { background-color: var(--gold) !important; }
        .text-green-mid { color: var(--green-mid) !important; }
        .text-green-dark { color: var(--green-dark) !important; }
        .fw-800 { font-weight: 800 !important; }
        .fw-900 { font-weight: 900 !important; }
        .z-index-1 { z-index: 1; }
        .rounded-4 { border-radius: 1.5rem !important; }
        .py-6 { padding-top: 6rem; padding-bottom: 6rem; }
        .mb-6 { margin-bottom: 4rem !important; }
    </style>
</head>