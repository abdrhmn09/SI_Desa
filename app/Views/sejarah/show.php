<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">Detail Sejarah Kepemimpinan</h4>
    <a href="<?= site_url('sejarah') ?>" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3 text-muted">Nama Tokoh</dt>
            <dd class="col-sm-9 fw-semibold"><?= esc($sejarah['nama']) ?></dd>

            <dt class="col-sm-3 text-muted">Masa Jabatan</dt>
            <dd class="col-sm-9"><span class="badge bg-secondary"><?= esc($sejarah['masa_jabatan']) ?></span></dd>

            <dt class="col-sm-3 text-muted">Keterangan</dt>
            <dd class="col-sm-9"><?= nl2br(esc($sejarah['keterangan'] ?? '-')) ?></dd>
        </dl>
    </div>
    <div class="card-footer bg-white d-flex gap-2">
        <a href="<?= site_url('sejarah/' . $sejarah['id'] . '/edit') ?>" class="btn btn-primary btn-sm">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
        <form action="<?= site_url('sejarah/' . $sejarah['id'] . '/delete') ?>" method="post" class="d-inline"
              onsubmit="return confirm('Hapus data \'<?= esc($sejarah['nama'], 'js') ?>\' dari sejarah kepemimpinan?');">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-outline-danger btn-sm">
                <i class="bi bi-trash me-1"></i> Hapus
            </button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>