<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center gap-2 mb-3">
    <a href="<?= site_url('galeri') ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h5 class="mb-0 fw-bold"><?= esc($title) ?></h5>
        <small class="text-muted">Edit data foto galeri</small>
    </div>
</div>

<?php if (!empty($errors)): ?>
<div class="alert alert-danger"><ul class="mb-0 ps-3"><?php foreach ($errors as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body">
                <form action="<?= site_url('galeri/update/'.$foto['id']) ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Foto <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control"
                            value="<?= old('judul', $foto['judul']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"><?= old('deskripsi', $foto['deskripsi']) ?></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Foto Saat Ini</label>
                        <?php if ($foto['file_gambar']): ?>
                        <div class="mb-2">
                            <img src="<?= base_url('uploads/galeri/'.$foto['file_gambar']) ?>" class="img-thumbnail" style="max-height:150px">
                        </div>
                        <?php endif; ?>
                        <label class="form-label fw-semibold">Ganti Foto (opsional)</label>
                        <input type="file" name="file_gambar" class="form-control" accept="image/jpeg,image/png,image/webp">
                        <div class="form-text">Kosongkan jika tidak ingin mengganti foto.</div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning"><i class="bi bi-save me-1"></i> Perbarui</button>
                        <a href="<?= site_url('galeri') ?>" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
