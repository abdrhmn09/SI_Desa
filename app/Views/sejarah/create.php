<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<div class="mb-3">
    <h4 class="fw-bold mb-0">Tambah Sejarah Kepemimpinan</h4>
    <p class="text-muted small mb-0">Data ini akan tampil di timeline "Sejarah Kepemimpinan" pada halaman publik.</p>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= site_url('sejarah') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="nama" class="form-label fw-semibold">Nama Tokoh</label>
                <input type="text" name="nama" id="nama" class="form-control"
                       value="<?= old('nama') ?>" placeholder="Contoh: Bapak Suryadi" required>
            </div>

            <div class="mb-3">
                <label for="masa_jabatan" class="form-label fw-semibold">Masa Jabatan</label>
                <input type="text" name="masa_jabatan" id="masa_jabatan" class="form-control"
                       value="<?= old('masa_jabatan') ?>" placeholder="Contoh: 2010 - 2016" required>
            </div>

            <div class="mb-4">
                <label for="keterangan" class="form-label fw-semibold">Keterangan <span class="text-muted fw-normal">(opsional)</span></label>
                <textarea name="keterangan" id="keterangan" class="form-control" rows="4"
                          placeholder="Catatan singkat mengenai masa kepemimpinan, prestasi, atau hal penting lainnya."><?= old('keterangan') ?></textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
                <a href="<?= site_url('sejarah') ?>" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>