<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP — SI Desa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background: linear-gradient(135deg,#1a4731,#2d7a56); min-height:100vh; display:flex; align-items:center; justify-content:center; }
        .card { border:none; border-radius:1rem; box-shadow:0 20px 60px rgba(0,0,0,.3); width:100%; max-width:420px; }
        .card-header { background:#1a4731; color:#fff; border-radius:1rem 1rem 0 0 !important; text-align:center; padding:1.5rem; }
        .form-control:focus { border-color:#2d7a56; box-shadow:0 0 0 .25rem rgba(45,122,86,.2); }
        .btn-primary { background:#1a4731; border-color:#1a4731; }
        .btn-primary:hover { background:#2d7a56; border-color:#2d7a56; }
        .otp-input { letter-spacing: .5rem; font-size: 1.5rem; text-align: center; }
    </style>
</head>
<body>
<div class="card">
    <div class="card-header">
        <i class="bi bi-shield-check fs-3"></i>
        <h5 class="mt-1 mb-0 fw-bold">Verifikasi OTP</h5>
        <small class="opacity-75">Masukkan kode yang dikirim ke email Anda</small>
    </div>
    <div class="card-body p-4">
        <?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?><div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>
        <form action="<?= site_url('verify-otp') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-4">
                <label class="form-label fw-semibold">Kode OTP</label>
                <input type="text" name="otp" class="form-control otp-input" maxlength="6" placeholder="______" required autocomplete="one-time-code">
                <div class="form-text">Kode berlaku selama 15 menit.</div>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check2-circle me-1"></i> Verifikasi</button>
            </div>
        </form>
        <div class="text-center mt-3 d-flex flex-column gap-2">
            <div>
                <a href="<?= site_url('forgot-password') ?>" class="text-muted small">Kirim ulang kode</a>
            </div>
            <a href="<?= site_url('/') ?>" class="text-success small fw-semibold mt-1"><i class="bi bi-house me-1"></i> Kembali ke Beranda</a>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
