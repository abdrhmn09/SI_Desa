<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <a href="<?= site_url('surat/jenis') ?>" class="btn btn-sm btn-light mb-3">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
    <h4 class="fw-bold mb-1">Tambah Jenis Surat</h4>
    <p class="text-muted small mb-0">Definisikan jenis surat baru beserta template dan form isian dinamisnya</p>
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

<form action="<?= site_url('surat/jenis/store') ?>" method="post">
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
                            placeholder="Contoh: Surat Keterangan Domisili"
                            value="<?= old('nama_surat') ?>" required>
                        <div class="form-text">Nama lengkap jenis surat yang akan ditampilkan kepada penduduk</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kode Surat <span class="text-danger">*</span></label>
                        <input type="text" name="kode_surat" class="form-control text-uppercase"
                            placeholder="Contoh: SKD"
                            value="<?= old('kode_surat') ?>" required
                            style="text-transform:uppercase">
                        <div class="form-text">Kode singkat untuk nomor surat (misal: SKD/001/2025)</div>
                    </div>
                </div>
            </div>

            <!-- Panduan Form Fields -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white fw-bold border-bottom-0 pt-4">
                    <i class="bi bi-question-circle text-info me-2"></i>Panduan Form Fields (JSON)
                </div>
                <div class="card-body pt-2">
                    <p class="small text-muted">Field dinamis ditulis dalam format JSON array. Contoh:</p>
                    <pre class="bg-light rounded p-3 small mb-3" style="font-size:.78rem">[
  {
    "name": "keperluan",
    "label": "Keperluan",
    "type": "text"
  },
  {
    "name": "tujuan",
    "label": "Tujuan / Alamat Tujuan",
    "type": "textarea"
  }
]</pre>
                    <p class="small text-muted mb-1"><strong>Tag Statis Tersedia di Template:</strong></p>
                    <div class="d-flex flex-wrap gap-1">
                        <?php foreach (['[nama]','[nik]','[tempat_lahir]','[tanggal_lahir]','[pekerjaan]','[alamat]','[agama]','[jenis_kelamin]','[status_kawin]','[nomor_surat]','[tanggal_cetak]'] as $tag): ?>
                        <code class="small bg-success-subtle text-success px-1 rounded"><?= $tag ?></code>
                        <?php endforeach; ?>
                    </div>
                    <p class="small text-muted mt-2 mb-0">Tag dinamis: gunakan <code>[nama_field]</code> sesuai <code>name</code> di JSON.</p>
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
                    <textarea name="form_fields" class="form-control font-monospace" rows="8"
                        placeholder='[{"name":"keperluan","label":"Keperluan","type":"text"}]'><?= old('form_fields') ?></textarea>
                    <div class="form-text">Kosongkan jika tidak ada isian tambahan selain data identitas penduduk.</div>
                </div>
            </div>
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white border-bottom-0 pt-4">
                    <div class="fw-bold"><i class="bi bi-file-earmark-richtext text-warning me-2"></i>Template Surat (HTML)</div>
                </div>
                <div class="card-body pt-2">
                    <textarea name="template_surat" class="form-control font-monospace" rows="16"
                        placeholder="Tulis template HTML surat di sini. Gunakan tag [nama], [nik], dll."><?= old('template_surat') ?></textarea>
                    <div class="form-text">Tulis HTML murni. Gunakan tag yang tersedia di panduan sebelah kiri.</div>
                </div>
            </div>
        </div>

        <div class="col-12 d-flex gap-2 justify-content-end">
            <a href="<?= site_url('surat/jenis') ?>" class="btn btn-light px-4 rounded-pill">Batal</a>
            <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold">
                <i class="bi bi-save me-1"></i>Simpan Jenis Surat
            </button>
        </div>
    </div>
</form>

<?= $this->endSection() ?>
