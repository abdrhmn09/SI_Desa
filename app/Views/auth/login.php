<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SI Desa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background: linear-gradient(135deg, #1a4731 0%, #2d7a56 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { border: none; border-radius: 1rem; box-shadow: 0 20px 60px rgba(0,0,0,.3); width: 100%; max-width: 400px; }
        .login-header { background: #1a4731; color: #fff; border-radius: 1rem 1rem 0 0; padding: 2rem; text-align: center; }
        .login-header i { font-size: 2.5rem; }
        .login-body { padding: 2rem; }
        .form-control:focus { border-color: #2d7a56; box-shadow: 0 0 0 .25rem rgba(45,122,86,.2); }
        .btn-primary { background: #1a4731; border-color: #1a4731; }
        .btn-primary:hover { background: #2d7a56; border-color: #2d7a56; }
    </style>
</head>
<body>
<div class="login-card card">
    <div class="login-header">
        <i class="bi bi-house-heart-fill"></i>
        <h4 class="mt-2 mb-0 fw-bold">SI Desa</h4>
        <small class="opacity-75">Sistem Informasi Desa</small>
    </div>
    <div class="login-body">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <h5 class="fw-bold mb-1">Masuk ke Akun Anda</h5>
        <p class="text-muted small mb-4">Masukkan kredensial untuk mengakses sistem</p>

        <form action="<?= site_url('login') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label fw-semibold">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" name="username" class="form-control <?= (isset($validation) && $validation->hasError('username')) ? 'is-invalid' : '' ?>"
                        value="<?= old('username') ?>" placeholder="Masukkan username" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" id="pwd" class="form-control" placeholder="Masukkan password" required>
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePwd()">
                        <i class="bi bi-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                </button>
            </div>
        </form>
        <div class="text-center mt-3 d-flex flex-column gap-2">
            <div>
                <a href="<?= site_url('forgot-password') ?>" class="text-muted small">Lupa password?</a>
                <span class="text-muted mx-1">&bull;</span>
                <a href="<?= site_url('register') ?>" class="text-muted small">Belum punya akun? Daftar</a>
            </div>
            <a href="<?= site_url('/') ?>" class="text-success small fw-semibold mt-2"><i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda</a>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePwd() {
    const p = document.getElementById('pwd');
    const i = document.getElementById('eyeIcon');
    if (p.type === 'password') { p.type = 'text'; i.className = 'bi bi-eye-slash'; }
    else { p.type = 'password'; i.className = 'bi bi-eye'; }
}
</script>
</body>
</html>
