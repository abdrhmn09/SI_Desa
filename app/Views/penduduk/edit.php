<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center gap-2 mb-3">
    <a href="<?= site_url('penduduk') ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h5 class="mb-0 fw-bold"><?= esc($title) ?></h5>
        <small class="text-muted">NIK: <?= esc($penduduk['nik']) ?></small>
    </div>
</div>

<?php if (!empty($errors)): ?>
<div class="alert alert-danger">
    <ul class="mb-0 ps-3"><?php foreach ($errors as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <form action="<?= site_url('penduduk/update/'.$penduduk['id']) ?>" method="post">
            <?= csrf_field() ?>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">NIK <span class="text-danger">*</span></label>
                    <input type="text" name="nik" class="form-control font-monospace" maxlength="16"
                        value="<?= old('nik', $penduduk['nik']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lengkap" class="form-control"
                        value="<?= old('nama_lengkap', $penduduk['nama_lengkap']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kartu Keluarga</label>
                    <select name="kartu_keluarga_id" class="form-select">
                        <option value="">-- Tanpa KK --</option>
                        <?php foreach ($kartuKeluarga as $kk): ?>
                        <option value="<?= $kk['id'] ?>"
                            <?= old('kartu_keluarga_id', $penduduk['kartu_keluarga_id']) == $kk['id'] ? 'selected' : '' ?>>
                            <?= esc($kk['no_kk']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Hubungan Keluarga</label>
                    <select name="hubungan_keluarga" class="form-select">
                        <option value="">-- Pilih --</option>
                        <?php foreach (['Kepala Keluarga','Istri','Anak','Famili Lain','Lainnya'] as $h): ?>
                        <option value="<?= $h ?>" <?= old('hubungan_keluarga', $penduduk['hubungan_keluarga']) === $h ? 'selected' : '' ?>><?= $h ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control" value="<?= old('tempat_lahir', $penduduk['tempat_lahir']) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="<?= old('tanggal_lahir', $penduduk['tanggal_lahir']) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select">
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki" <?= old('jenis_kelamin', $penduduk['jenis_kelamin']) === 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="Perempuan" <?= old('jenis_kelamin', $penduduk['jenis_kelamin']) === 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Agama</label>
                    <select name="agama" class="form-select">
                        <option value="">-- Pilih --</option>
                        <?php foreach (['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $a): ?>
                        <option value="<?= $a ?>" <?= old('agama', $penduduk['agama']) === $a ? 'selected' : '' ?>><?= $a ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Pendidikan</label>
                    <select name="pendidikan" class="form-select">
                        <option value="">-- Pilih --</option>
                        <?php foreach (['Tidak/Belum Sekolah','SD/Sederajat','SMP/Sederajat','SMA/Sederajat','D1/D2/D3','S1','S2','S3'] as $p): ?>
                        <option value="<?= $p ?>" <?= old('pendidikan', $penduduk['pendidikan']) === $p ? 'selected' : '' ?>><?= $p ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status Kawin</label>
                    <select name="status_kawin" class="form-select">
                        <option value="">-- Pilih --</option>
                        <?php foreach (['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati'] as $s): ?>
                        <option value="<?= $s ?>" <?= old('status_kawin', $penduduk['status_kawin']) === $s ? 'selected' : '' ?>><?= $s ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Pekerjaan</label>
                    <input type="text" name="pekerjaan" class="form-control" value="<?= old('pekerjaan', $penduduk['pekerjaan']) ?>">
                </div>
            </div>
            <hr class="my-4">
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning"><i class="bi bi-save me-1"></i> Perbarui</button>
                <a href="<?= site_url('penduduk') ?>" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
