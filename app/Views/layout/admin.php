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
            text-decoration: none;
        }
        #sidebar .nav-link:hover { background: var(--sidebar-hover); color: #fff; }
        #sidebar .nav-link.active { background: var(--sidebar-active); color: #fff; font-weight: 600; }
        #sidebar .nav-link i { font-size: 1rem; width: 1.2rem; }
        
        /* Dropdown/Collapse Icon Animation */
        .collapse-icon {
            margin-left: auto;
            transition: transform 0.3s ease;
            font-size: 0.8rem !important;
        }
        /* Putar icon panah jika aria-expanded="true" */
        #sidebar .nav-link[aria-expanded="true"] .collapse-icon {
            transform: rotate(180deg);
        }
        /* Sub-menu styling */
        .collapse .nav-link {
            padding-left: 2.8rem !important; /* Indentasi untuk sub-menu */
            font-size: 0.825rem;
            background: rgba(0,0,0,0.1);
        }

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
        
        /* Main & Cards */
        .main-content { flex: 1; padding: 1.5rem; }
        .card { border: none; border-radius: .75rem; box-shadow: 0 1px 4px rgba(0,0,0,.08); }
        .card-header { background: #fff; border-bottom: 1px solid #f1f5f9; border-radius: .75rem .75rem 0 0 !important; padding: 1rem 1.25rem; font-weight: 600; }
        .table th { font-size: .8rem; text-transform: uppercase; letter-spacing: .5px; color: #64748b; background: #f8fafc; }
        .badge { font-weight: 500; }
        
        /* Responsive */
        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.open { transform: translateX(0); }
            #content { margin-left: 0; }
        }
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
    
    if ($roleId) {
        $roleModel = new \App\Models\RoleModel();
        $userPermissions = $roleModel->getPermissions($roleId);
    }

    $hasPermission = function(string $perm) use ($userPermissions) {
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
    <a href="<?= site_url('profil') ?>" class="nav-link <?= (uri_string() === 'profil') ? 'active' : '' ?>">
        <i class="bi bi-person-vcard"></i> Profil Data Diri
    </a>

    <!-- DROPDOWN KEPENDUDUKAN -->
    <?php if ($hasPermission('kelola_kependudukan')): ?>
        <?php 
            // Cek apakah ada submenu kependudukan yang aktif
            $isPendudukActive = str_starts_with(uri_string(), 'penduduk') || str_starts_with(uri_string(), 'kartu-keluarga') || str_starts_with(uri_string(), 'import'); 
        ?>
        <a href="#menuKependudukan" data-bs-toggle="collapse" aria-expanded="<?= $isPendudukActive ? 'true' : 'false' ?>" class="nav-link <?= $isPendudukActive ? 'active' : '' ?>">
            <i class="bi bi-people"></i> Kependudukan
            <i class="bi bi-chevron-down collapse-icon"></i>
        </a>
        <div class="collapse <?= $isPendudukActive ? 'show' : '' ?>" id="menuKependudukan">
            <a href="<?= site_url('penduduk') ?>" class="nav-link <?= (str_starts_with(uri_string(), 'penduduk')) ? 'active' : '' ?>">
                Data Penduduk
            </a>
            <a href="<?= site_url('kartu-keluarga') ?>" class="nav-link <?= (str_starts_with(uri_string(), 'kartu-keluarga')) ? 'active' : '' ?>">
                Kartu Keluarga
            </a>
            <a href="<?= site_url('import') ?>" class="nav-link <?= (str_starts_with(uri_string(), 'import')) ? 'active' : '' ?>">
                Import Data
            </a>
        </div>
    <?php endif; ?>

    <!-- DROPDOWN PELAYANAN SURAT (HANYA UNTUK PENDUDUK / BUKAN ADMIN) -->
    <!-- DITAMBAHKAN: && !$hasPermission('kelola_surat_admin') agar admin tidak melihat dropdown ini -->
    <?php if ($hasPermission('kelola_surat_penduduk') && !$hasPermission('kelola_surat_admin')): ?>
        <?php 
            $isPelayananActive = uri_string() === 'surat/pilih' || str_starts_with(uri_string(), 'surat/form') || uri_string() === 'surat/riwayat';
        ?>
        <a href="#menuPelayanan" data-bs-toggle="collapse" aria-expanded="<?= $isPelayananActive ? 'true' : 'false' ?>" class="nav-link <?= $isPelayananActive ? 'active' : '' ?>">
            <i class="bi bi-envelope-paper"></i> Pelayanan Surat
            <i class="bi bi-chevron-down collapse-icon"></i>
        </a>
        <div class="collapse <?= $isPelayananActive ? 'show' : '' ?>" id="menuPelayanan">
            <a href="<?= site_url('surat/pilih') ?>" class="nav-link <?= (uri_string() === 'surat/pilih' || str_starts_with(uri_string(), 'surat/form')) ? 'active' : '' ?>">
                Ajukan Surat
            </a>
            <a href="<?= site_url('surat/riwayat') ?>" class="nav-link <?= (uri_string() === 'surat/riwayat') ? 'active' : '' ?>">
                Riwayat Saya
            </a>
        </div>
    <?php endif; ?>

    <!-- DROPDOWN KELOLA SURAT ADMIN -->
    <?php if ($hasPermission('kelola_surat_admin')): ?>
        <?php 
            $isAdminSuratActive = str_starts_with(uri_string(), 'surat/persetujuan') || str_starts_with(uri_string(), 'surat/semua') || str_starts_with(uri_string(), 'surat/jenis');
        ?>
        <a href="#menuAdminSurat" data-bs-toggle="collapse" aria-expanded="<?= $isAdminSuratActive ? 'true' : 'false' ?>" class="nav-link <?= $isAdminSuratActive ? 'active' : '' ?>">
            <i class="bi bi-mailbox"></i> Kelola Surat
            <i class="bi bi-chevron-down collapse-icon"></i>
        </a>
        <div class="collapse <?= $isAdminSuratActive ? 'show' : '' ?>" id="menuAdminSurat">
            <a href="<?= site_url('surat/persetujuan') ?>" class="nav-link <?= (str_starts_with(uri_string(), 'surat/persetujuan')) ? 'active' : '' ?>">
                Persetujuan
            </a>
            <a href="<?= site_url('surat/semua') ?>" class="nav-link <?= (str_starts_with(uri_string(), 'surat/semua')) ? 'active' : '' ?>">
                Semua Riwayat
            </a>
            <a href="<?= site_url('surat/jenis') ?>" class="nav-link <?= (str_starts_with(uri_string(), 'surat/jenis')) ? 'active' : '' ?>">
                Jenis Surat
            </a>
        </div>
    <?php endif; ?>

    <!-- DROPDOWN KONTEN & INFORMASI -->
    <?php if ($hasPermission('kelola_artikel') || $hasPermission('kelola_galeri') || $hasPermission('kelola_sejarah')): ?>
        <?php 
            $isKontenActive = str_starts_with(uri_string(), 'artikel') || str_starts_with(uri_string(), 'galeri') || str_starts_with(uri_string(), 'video') || str_starts_with(uri_string(), 'sejarah');
        ?>
        <a href="#menuKonten" data-bs-toggle="collapse" aria-expanded="<?= $isKontenActive ? 'true' : 'false' ?>" class="nav-link <?= $isKontenActive ? 'active' : '' ?>">
            <i class="bi bi-newspaper"></i> Konten & Info
            <i class="bi bi-chevron-down collapse-icon"></i>
        </a>
        <div class="collapse <?= $isKontenActive ? 'show' : '' ?>" id="menuKonten">
            <?php if ($hasPermission('kelola_artikel')): ?>
                <a href="<?= site_url('artikel') ?>" class="nav-link <?= (str_starts_with(uri_string(), 'artikel')) ? 'active' : '' ?>">
                    Artikel & Berita
                </a>
            <?php endif; ?>
            <?php if ($hasPermission('kelola_galeri')): ?>
                <a href="<?= site_url('galeri') ?>" class="nav-link <?= (str_starts_with(uri_string(), 'galeri')) ? 'active' : '' ?>">
                    Galeri Foto
                </a>
                <a href="<?= site_url('video') ?>" class="nav-link <?= (str_starts_with(uri_string(), 'video')) ? 'active' : '' ?>">
                    Video
                </a>
            <?php endif; ?>
            <?php if ($hasPermission('kelola_artikel')): ?>
                <a href="<?= site_url('sejarah') ?>" class="nav-link <?= (str_starts_with(uri_string(), 'sejarah')) ? 'active' : '' ?>">
                    Sejarah Kepemimpinan
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- DROPDOWN ADMINISTRASI -->
    <?php if ($hasPermission('akses_pengaturan_aplikasi')): ?>
        <?php 
            $isAdministrasiActive = str_starts_with(uri_string(), 'pemerintahan') || str_starts_with(uri_string(), 'pengaturan');
        ?>
        <a href="#menuAdministrasi" data-bs-toggle="collapse" aria-expanded="<?= $isAdministrasiActive ? 'true' : 'false' ?>" class="nav-link <?= $isAdministrasiActive ? 'active' : '' ?>">
            <i class="bi bi-diagram-3"></i> Administrasi
            <i class="bi bi-chevron-down collapse-icon"></i>
        </a>
        <div class="collapse <?= $isAdministrasiActive ? 'show' : '' ?>" id="menuAdministrasi">
            <a href="<?= site_url('pemerintahan') ?>" class="nav-link <?= (str_starts_with(uri_string(), 'pemerintahan')) ? 'active' : '' ?>">
                Struktur Pemerintahan
            </a>
            <a href="<?= site_url('pengaturan') ?>" class="nav-link <?= (str_starts_with(uri_string(), 'pengaturan')) ? 'active' : '' ?>">
                Pengaturan Desa
            </a>
        </div>
    <?php endif; ?>

    <!-- DROPDOWN PENGGUNA -->
    <?php if ($hasPermission('manajemen_pengguna')): ?>
        <?php 
            $isPenggunaActive = str_starts_with(uri_string(), 'pengguna') || str_starts_with(uri_string(), 'role');
        ?>
        <a href="#menuPengguna" data-bs-toggle="collapse" aria-expanded="<?= $isPenggunaActive ? 'true' : 'false' ?>" class="nav-link <?= $isPenggunaActive ? 'active' : '' ?>">
            <i class="bi bi-person-badge"></i> Pengguna
            <i class="bi bi-chevron-down collapse-icon"></i>
        </a>
        <div class="collapse <?= $isPenggunaActive ? 'show' : '' ?>" id="menuPengguna">
            <a href="<?= site_url('pengguna') ?>" class="nav-link <?= (str_starts_with(uri_string(), 'pengguna')) ? 'active' : '' ?>">
                Manajemen Pengguna
            </a>
            <a href="<?= site_url('role') ?>" class="nav-link <?= (str_starts_with(uri_string(), 'role')) ? 'active' : '' ?>">
                Role & Hak Akses
            </a>
        </div>
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