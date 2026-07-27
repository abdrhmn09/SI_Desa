<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center gap-2 mb-3">
    <a href="<?= site_url('artikel') ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h5 class="mb-0 fw-bold"><?= esc($title) ?></h5>
        <small class="text-muted">Edit artikel: <?= esc($artikel['judul']) ?></small>
    </div>
</div>

<?php if (!empty($errors)): ?>
<div class="alert alert-danger"><ul class="mb-0 ps-3"><?php foreach ($errors as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <form action="<?= site_url('artikel/update/'.$artikel['id']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-semibold">Judul Artikel <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control"
                        value="<?= old('judul', $artikel['judul']) ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                    <select name="kategori" class="form-select" required>
                        <?php foreach (['Berita','Pengumuman','Agenda'] as $k): ?>
                        <option value="<?= $k ?>" <?= old('kategori', $artikel['kategori']) === $k ? 'selected' : '' ?>><?= $k ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="draft" <?= old('status', $artikel['status']) === 'draft' ? 'selected' : '' ?>>Draft</option>
                        <option value="published" <?= old('status', $artikel['status']) === 'published' ? 'selected' : '' ?>>Published</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Gambar Baru (opsional)</label>
                    <?php if ($artikel['gambar']): ?>
                    <div class="mb-2">
                        <img src="<?= site_url('uploads/artikel/'.$artikel['gambar']) ?>" class="img-thumbnail" style="height:60px">
                        <div class="form-text">Gambar saat ini</div>
                    </div>
                    <?php endif; ?>
                    <input type="file" name="gambar" class="form-control" accept="image/jpeg,image/png,image/webp">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Isi Artikel <span class="text-danger">*</span></label>
                    <textarea name="isi" class="form-control" rows="12" required><?= old('isi', $artikel['isi']) ?></textarea>
                </div>
            </div>
            <hr class="my-4">
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning"><i class="bi bi-save me-1"></i> Perbarui</button>
                <a href="<?= site_url('artikel') ?>" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
