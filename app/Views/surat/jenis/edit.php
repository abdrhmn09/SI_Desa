<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <a href="<?= site_url('surat/jenis') ?>" class="btn btn-sm btn-light mb-3">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
    <h4 class="fw-bold mb-1">Edit Jenis Surat</h4>
    <p class="text-muted small mb-0">Perbarui template dan pengaturan <strong><?= esc($jenis['nama_surat']) ?></strong></p>
</div>

<?php if (session()->getFlashdata('error')): ?>
<div class="alert alert-danger border-0 shadow-sm"><i class="bi bi-exclamation-circle-fill me-2"></i><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>
<?php if (!empty(session()->getFlashdata('errors'))): ?>
<div class="alert alert-danger border-0 shadow-sm">
    <ul class="mb-0 ps-3">
        <?php foreach (session()->getFlashdata('errors') as $err): ?>
        <li><?= esc($err) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<form action="<?= site_url('surat/jenis/update/' . $jenis['id']) ?>" method="post">
    <?= csrf_field() ?>
    <div class="row g-4">
        <!-- Info Dasar -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold border-bottom-0 pt-4">
                    <i class="bi bi-info-circle text-primary me-2"></i>Informasi Dasar
                </div>
                <div class="card-body pt-2">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Surat <span class="text-danger">*</span></label>
                        <input type="text" name="nama_surat" class="form-control"
                            value="<?= old('nama_surat', $jenis['nama_surat']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kode Surat <span class="text-danger">*</span></label>
                        <input type="text" name="kode_surat" class="form-control text-uppercase"
                            value="<?= old('kode_surat', $jenis['kode_surat']) ?>" required
                            style="text-transform:uppercase">
                        <div class="form-text">Contoh nomor surat: <code><?= esc($jenis['kode_surat']) ?>/001/<?= date('Y') ?></code></div>
                    </div>
                </div>
            </div>

            <!-- Panduan -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white fw-bold border-bottom-0 pt-4">
                    <i class="bi bi-question-circle text-info me-2"></i>Tag Statis Tersedia
                </div>
                <div class="card-body pt-2">
                    <div class="d-flex flex-wrap gap-1 mb-2">
                        <?php foreach (['[nama]','[nik]','[tempat_lahir]','[tanggal_lahir]','[pekerjaan]','[alamat]','[agama]','[jenis_kelamin]','[status_kawin]','[nomor_surat]','[tanggal_cetak]'] as $tag): ?>
                        <code class="small bg-success-subtle text-success px-1 rounded"><?= $tag ?></code>
                        <?php endforeach; ?>
                    </div>
                    <p class="small text-muted mb-0">Tag dinamis: gunakan <code>[nama_field]</code> sesuai <code>name</code> di JSON form fields.</p>
                </div>
            </div>
        </div>

        <!-- Template & Form Fields -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 pt-4">
                    <div class="fw-bold"><i class="bi bi-code-square text-success me-2"></i>Form Fields (JSON)</div>
                </div>
                <div class="card-body pt-2">
                    <textarea name="form_fields" class="form-control font-monospace" rows="8"><?= old('form_fields', $jenis['form_fields']) ?></textarea>
                    <div class="form-text">Kosongkan jika tidak ada isian tambahan.</div>
                </div>
            </div>
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white border-bottom-0 pt-4">
                    <div class="fw-bold"><i class="bi bi-file-earmark-richtext text-warning me-2"></i>Template Surat (HTML)</div>
                </div>
                <div class="card-body pt-2">
                    <textarea name="template_surat" class="form-control font-monospace" rows="16"><?= old('template_surat', $jenis['template_surat']) ?></textarea>
                </div>
            </div>
        </div>

        <div class="col-12 d-flex gap-2 justify-content-end">
            <a href="<?= site_url('surat/jenis') ?>" class="btn btn-light px-4 rounded-pill">Batal</a>
            <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold">
                <i class="bi bi-save me-1"></i>Simpan Perubahan
            </button>
        </div>
    </div>
</form>

<?= $this->endSection() ?>
