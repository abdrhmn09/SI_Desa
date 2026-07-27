<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center gap-2 mb-3">
    <a href="<?= site_url('kartu-keluarga') ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h5 class="mb-0 fw-bold"><?= esc($title) ?></h5>
        <small class="text-muted">No KK: <?= esc($kk['no_kk']) ?></small>
    </div>
</div>

<?php if (!empty($errors)): ?>
<div class="alert alert-danger"><ul class="mb-0 ps-3"><?php foreach ($errors as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <form action="<?= site_url('kartu-keluarga/update/'.$kk['id']) ?>" method="post">
            <?= csrf_field() ?>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">No KK <span class="text-danger">*</span></label>
                    <input type="text" name="no_kk" class="form-control font-monospace" maxlength="16"
                        value="<?= old('no_kk', $kk['no_kk']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kepala Keluarga</label>
                    <select name="kepala_keluarga_id" class="form-select">
                        <option value="">-- Pilih (opsional) --</option>
                        <?php foreach ($penduduk as $p): ?>
                        <option value="<?= $p['id'] ?>"
                            <?= old('kepala_keluarga_id', $kk['kepala_keluarga_id']) == $p['id'] ? 'selected' : '' ?>>
                            <?= esc($p['nama_lengkap']) ?> (<?= esc($p['nik']) ?>)
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2"><?= old('alamat', $kk['alamat']) ?></textarea>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">RT</label>
                    <input type="text" name="rt" class="form-control" maxlength="5" value="<?= old('rt', $kk['rt']) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">RW</label>
                    <input type="text" name="rw" class="form-control" maxlength="5" value="<?= old('rw', $kk['rw']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tanggal Dikeluarkan</label>
                    <input type="date" name="tanggal_dikeluarkan" class="form-control"
                        value="<?= old('tanggal_dikeluarkan', $kk['tanggal_dikeluarkan']) ?>">
                </div>
            </div>
            <hr class="my-4">
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning"><i class="bi bi-save me-1"></i> Perbarui</button>
                <a href="<?= site_url('kartu-keluarga') ?>" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
