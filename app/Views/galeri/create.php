<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center gap-2 mb-3">
    <a href="<?= site_url('galeri') ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h5 class="mb-0 fw-bold"><?= esc($title) ?></h5>
        <small class="text-muted">Upload foto baru ke galeri desa</small>
    </div>
</div>

<?php if (!empty($errors)): ?>
<div class="alert alert-danger"><ul class="mb-0 ps-3"><?php foreach ($errors as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body">
                <form action="<?= site_url('galeri/store') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Foto <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control" value="<?= old('judul') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi (opsional)</label>
                        <textarea name="deskripsi" class="form-control" rows="3"><?= old('deskripsi') ?></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">File Foto <span class="text-danger">*</span></label>
                        <div class="border-2 border-dashed rounded-3 p-4 text-center" style="border-style:dashed!important;border-color:#cbd5e1!important;cursor:pointer" onclick="document.getElementById('fileInput').click()">
                            <i class="bi bi-cloud-upload fs-2 text-muted d-block mb-2"></i>
                            <div class="text-muted small">Klik untuk memilih foto</div>
                            <div class="text-muted" style="font-size:.72rem">JPG, PNG, WEBP — Max 5 MB</div>
                        </div>
                        <input type="file" id="fileInput" name="file_gambar" class="d-none" accept="image/jpeg,image/png,image/webp" required onchange="previewImage(this)">
                        <div id="imgPreview" class="mt-2" style="display:none">
                            <img id="previewImg" class="img-thumbnail" style="max-height:200px">
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success"><i class="bi bi-upload me-1"></i> Upload</button>
                        <a href="<?= site_url('galeri') ?>" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->section('scripts') ?>
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imgPreview').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>
