<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'SI Desa') ?> — SI Desa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --sidebar-bg: #1a4731;
            --sidebar-hover: #256346;
            --sidebar-active: #2d7a56;
            --sidebar-width: 260px;
            --topbar-height: 60px;
        }
        body { background: #f0f4f8; font-family: 'Segoe UI', sans-serif; }
        /* Sidebar */
        #sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0; left: 0;
            z-index: 1040;
            transition: transform .25s ease;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }
        #sidebar .brand {
            padding: 1.1rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,.12);
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: .6rem;
        }
        #sidebar .brand span { font-size: 1.15rem; font-weight: 700; letter-spacing: .5px; }
        #sidebar .brand small { font-size: .7rem; opacity: .7; display: block; }
        .sidebar-label {
            color: rgba(255,255,255,.45);
            font-size: .68rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 1rem 1.25rem .3rem;
            font-weight: 700;
        }
        #sidebar .nav-link {
            color: rgba(255,255,255,.8);
            padding: .5rem 1.25rem;
            border-radius: 0;
            font-size: .875rem;
            display: flex;
            align-items: center;
            gap: .6rem;
            transition: background .15s;
        }
        #sidebar .nav-link:hover { background: var(--sidebar-hover); color: #fff; }
        #sidebar .nav-link.active { background: var(--sidebar-active); color: #fff; font-weight: 600; }
        #sidebar .nav-link i { font-size: 1rem; width: 1.2rem; }
        /* Topbar */
        #content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        #topbar {
            height: var(--topbar-height);
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            gap: 1rem;
            position: sticky;
            top: 0;
            z-index: 1030;
            box-shadow: 0 1px 4px rgba(0,0,0,.06);
        }
        #topbar .page-title { font-weight: 600; font-size: 1rem; color: #1e293b; flex: 1; }
        .user-chip {
            display: flex; align-items: center; gap: .5rem;
            background: #f1f5f9; border-radius: 50px;
            padding: .3rem .8rem;
            font-size: .82rem; color: #334155;
        }
        .user-chip .avatar {
            width: 28px; height: 28px; border-radius: 50%;
            background: var(--sidebar-bg); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: .75rem; font-weight: 700;
        }
        /* Main */
        .main-content { flex: 1; padding: 1.5rem; }
        /* Cards */
        .card { border: none; border-radius: .75rem; box-shadow: 0 1px 4px rgba(0,0,0,.08); }
        .card-header { background: #fff; border-bottom: 1px solid #f1f5f9; border-radius: .75rem .75rem 0 0 !important; padding: 1rem 1.25rem; font-weight: 600; }
        /* Table */
        .table th { font-size: .8rem; text-transform: uppercase; letter-spacing: .5px; color: #64748b; background: #f8fafc; }
        /* Badges */
        .badge { font-weight: 500; }
        /* Responsive */
        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.open { transform: translateX(0); }
            #content { margin-left: 0; }
        }
        /* Overlay */
        #overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.4); z-index: 1039; }
        #overlay.show { display: block; }
    </style>
    <?= $this->renderSection('styles') ?>
</head>
<body>

<div id="overlay"></div>

<?php
    $roleId = session()->get('role_id');
    $userPermissions = [];
    
    // Ambil daftar permission berdasarkan role user jika user memiliki role
    if ($roleId) {
        $roleModel = new \App\Models\RoleModel();
        $userPermissions = $roleModel->getPermissions($roleId);
    }

    // Helper function sederhana (closure) untuk mengecek permission
    $hasPermission = function(string $perm) use ($userPermissions) {
        // Jika user punya 'akses_semua_modul', langsung beri akses (Bypass/Superadmin)
        if (in_array('akses_semua_modul', $userPermissions)) {
            return true;
        }
        return in_array($perm, $userPermissions);
    };
?>

<nav id="sidebar">
    <a href="<?= site_url('/') ?>" class="brand">
        <i class="bi bi-house-heart-fill fs-4"></i>
        <div>
            <span>SI Desa</span>
            <small>Sistem Informasi Desa</small>
        </div>
    </a>

    <div class="sidebar-label">Utama</div>
    <a href="<?= site_url('dashboard') ?>" class="nav-link <?= (uri_string() === 'dashboard') ? 'active' : '' ?>">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <?php if ($hasPermission('kelola_kependudukan')): ?>
    <div class="sidebar-label">Kependudukan</div>
    <a href="<?= site_url('penduduk') ?>" class="nav-link <?= (str_starts_with(uri_string(), 'penduduk')) ? 'active' : '' ?>">
        <i class="bi bi-people"></i> Data Penduduk
    </a>
    <a href="<?= site_url('kartu-keluarga') ?>" class="nav-link <?= (str_starts_with(uri_string(), 'kartu-keluarga')) ? 'active' : '' ?>">
        <i class="bi bi-journal-bookmark"></i> Kartu Keluarga
    </a>
    <a href="<?= site_url('import') ?>" class="nav-link <?= (str_starts_with(uri_string(), 'import')) ? 'active' : '' ?>">
        <i class="bi bi-file-earmark-arrow-up"></i> Import Data
    </a>
    <?php endif; ?>

    <?php if ($hasPermission('kelola_surat')): ?>
    <div class="sidebar-label">Pelayanan</div>
    <a href="<?= site_url('surat/pilih') ?>" class="nav-link <?= (str_starts_with(uri_string(), 'surat')) ? 'active' : '' ?>">
        <i class="bi bi-envelope-paper"></i> Cetak Surat
    </a>
    <?php endif; ?>

    <?php if ($hasPermission('kelola_artikel') || $hasPermission('kelola_galeri')): ?>
    <div class="sidebar-label">Konten & Informasi</div>
        <?php if ($hasPermission('kelola_artikel')): ?>
        <a href="<?= site_url('artikel') ?>" class="nav-link <?= (str_starts_with(uri_string(), 'artikel')) ? 'active' : '' ?>">
            <i class="bi bi-newspaper"></i> Artikel & Berita
        </a>
        <?php endif; ?>
        
        <?php if ($hasPermission('kelola_galeri')): ?>
        <a href="<?= site_url('galeri') ?>" class="nav-link <?= (str_starts_with(uri_string(), 'galeri')) ? 'active' : '' ?>">
            <i class="bi bi-images"></i> Galeri Foto
        </a>
        <a href="<?= site_url('video') ?>" class="nav-link <?= (str_starts_with(uri_string(), 'video')) ? 'active' : '' ?>">
            <i class="bi bi-play-btn"></i> Video
        </a>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($hasPermission('akses_pengaturan_aplikasi')): ?>
    <div class="sidebar-label">Administrasi</div>
    <a href="<?= site_url('pemerintahan') ?>" class="nav-link <?= (str_starts_with(uri_string(), 'pemerintahan')) ? 'active' : '' ?>">
        <i class="bi bi-diagram-3"></i> Struktur Pemerintahan
    </a>
    <a href="<?= site_url('pengaturan') ?>" class="nav-link <?= (str_starts_with(uri_string(), 'pengaturan')) ? 'active' : '' ?>">
        <i class="bi bi-gear"></i> Pengaturan Desa
    </a>
    <?php endif; ?>

    <?php if ($hasPermission('manajemen_pengguna')): ?>
    <div class="sidebar-label">Pengguna</div>
    <a href="<?= site_url('pengguna') ?>" class="nav-link <?= (str_starts_with(uri_string(), 'pengguna')) ? 'active' : '' ?>">
        <i class="bi bi-person-badge"></i> Manajemen Pengguna
    </a>
    <a href="<?= site_url('role') ?>" class="nav-link <?= (str_starts_with(uri_string(), 'role')) ? 'active' : '' ?>">
        <i class="bi bi-shield-lock"></i> Role & Hak Akses
    </a>
    <?php endif; ?>

    <div class="mt-auto p-3 border-top border-white border-opacity-10">
        <a href="<?= site_url('logout') ?>" class="nav-link text-danger">
            <i class="bi bi-box-arrow-left"></i> Keluar
        </a>
    </div>
</nav>

<!-- MAIN CONTENT -->
<div id="content">
    <div id="topbar">
        <button class="btn btn-sm btn-light d-md-none" id="sidebarToggle">
            <i class="bi bi-list fs-5"></i>
        </button>
        <div class="page-title"><?= esc($title ?? 'SI Desa') ?></div>
        <div class="user-chip">
            <div class="avatar"><?= strtoupper(substr(session()->get('username') ?? 'U', 0, 1)) ?></div>
            <div>
                <div class="fw-600" style="font-weight:600"><?= esc(session()->get('username') ?? '') ?></div>
                <div style="font-size:.7rem;opacity:.7"><?= esc(session()->get('role_nama') ?? '') ?></div>
            </div>
        </div>
    </div>

    <div class="main-content">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-check-circle-fill"></i>
                <?= esc(session()->getFlashdata('success')) ?>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <?= esc(session()->getFlashdata('error')) ?>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center gap-2 mb-1"><i class="bi bi-exclamation-triangle-fill"></i><strong>Terjadi kesalahan:</strong></div>
                <ul class="mb-0 ps-3">
                    <?php foreach (session()->getFlashdata('errors') as $err): ?>
                        <li><?= esc($err) ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const toggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    if (toggle) {
        toggle.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        });
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
        });
    }
</script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
