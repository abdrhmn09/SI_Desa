<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center gap-2 mb-3">
    <a href="<?= site_url('video') ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h5 class="mb-0 fw-bold"><?= esc($title) ?></h5>
        <small class="text-muted">Tambah link video YouTube atau Vimeo</small>
    </div>
</div>

<?php if (!empty($errors)): ?>
<div class="alert alert-danger"><ul class="mb-0 ps-3"><?php foreach ($errors as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body">
                <form action="<?= site_url('video/store') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Video <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control" value="<?= old('judul') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">URL Video <span class="text-danger">*</span></label>
                        <input type="url" name="url_video" class="form-control"
                            value="<?= old('url_video') ?>"
                            placeholder="https://www.youtube.com/watch?v=..." required>
                        <div class="form-text">Masukkan URL lengkap dari YouTube atau Vimeo.</div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Deskripsi (opsional)</label>
                        <textarea name="deskripsi" class="form-control" rows="3"><?= old('deskripsi') ?></textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success"><i class="bi bi-save me-1"></i> Simpan</button>
                        <a href="<?= site_url('video') ?>" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
