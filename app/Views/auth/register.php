<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — SI Desa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background: linear-gradient(135deg, #1a4731 0%, #2d7a56 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem 0; }
        .card { border: none; border-radius: 1rem; box-shadow: 0 20px 60px rgba(0,0,0,.3); width: 100%; max-width: 440px; }
        .card-header { background: #1a4731; color: #fff; border-radius: 1rem 1rem 0 0 !important; text-align: center; padding: 1.5rem; }
        .form-control:focus { border-color: #2d7a56; box-shadow: 0 0 0 .25rem rgba(45,122,86,.2); }
        .btn-primary { background: #1a4731; border-color: #1a4731; }
        .btn-primary:hover { background: #2d7a56; border-color: #2d7a56; }
    </style>
</head>
<body>
<div class="card">
    <div class="card-header">
        <i class="bi bi-house-heart-fill fs-3"></i>
        <h5 class="mt-1 mb-0 fw-bold">Daftar Akun — SI Desa</h5>
    </div>
    <div class="card-body p-4">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('validation')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    <?php foreach (session()->getFlashdata('validation')->getErrors() as $e): ?>
                        <li><?= esc($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form action="<?= site_url('register') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label fw-semibold">NIK (Nomor Induk Kependudukan)</label>
                <input type="text" name="nik" class="form-control" value="<?= old('nik') ?>" maxlength="16" required>
                <div class="form-text">Masukkan 16 digit NIK Anda sesuai KTP/KK. NIK digunakan sebagai username saat login.</div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Konfirmasi Password</label>
                <input type="password" name="password_confirm" class="form-control" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary"><i class="bi bi-person-plus me-1"></i> Daftar</button>
            </div>
        </form>
        <div class="text-center mt-3 d-flex flex-column gap-2">
            <div>
                <a href="<?= site_url('login') ?>" class="text-muted small">Sudah punya akun? Masuk</a>
            </div>
            <a href="<?= site_url('/') ?>" class="text-success small fw-semibold mt-2"><i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda</a>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
