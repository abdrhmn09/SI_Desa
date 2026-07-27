<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Pilih Layanan Surat</h4>
</div>

<div class="row g-4">
    <?php foreach ($jenisSurat as $js): ?>
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-elevate">
            <div class="card-body text-center p-4">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex p-3 mb-3">
                    <i class="bi bi-envelope-paper fs-2"></i>
                </div>
                <h5 class="fw-bold"><?= esc($js['nama_surat']) ?></h5>
                <p class="text-muted small mb-4">
                    Kode: <?= esc($js['kode_surat']) ?>
                </p>
                <a href="<?= site_url('surat/form/' . $js['id']) ?>" class="btn btn-primary w-100 rounded-pill">
                    <i class="bi bi-pencil-square me-1"></i> Buat Surat Ini
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>