<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center gap-2 mb-3">
    <a href="<?= site_url('pemerintahan') ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h5 class="mb-0 fw-bold"><?= esc($title) ?></h5>
        <small class="text-muted">Tambah data pejabat / jabatan baru</small>
    </div>
</div>

<?php if (!empty($errors)): ?>
<div class="alert alert-danger"><ul class="mb-0 ps-3"><?php foreach ($errors as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body">
                <form action="<?= site_url('pemerintahan/store') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Jabatan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_jabatan" class="form-control"
                            value="<?= old('nama_jabatan') ?>"
                            placeholder="Contoh: Kepala Desa, Sekretaris Desa..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Pejabat <span class="text-danger">*</span></label>
                        <input type="text" name="nama_pejabat" class="form-control"
                            value="<?= old('nama_pejabat') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tahun / Periode <span class="text-danger">*</span></label>
                        <input type="text" name="tahun" class="form-control"
                            value="<?= old('tahun', date('Y')) ?>"
                            placeholder="Contoh: 2024 atau 2020-2025" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Foto (opsional)</label>
                        <input type="file" name="foto" class="form-control" accept="image/jpeg,image/png,image/webp">
                        <div class="form-text">JPG, PNG, WEBP — Max 2 MB.</div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success"><i class="bi bi-save me-1"></i> Simpan</button>
                        <a href="<?= site_url('pemerintahan') ?>" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
