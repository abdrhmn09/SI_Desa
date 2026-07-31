<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-collection-fill text-primary me-2"></i>Manajemen Jenis Surat</h4>
        <p class="text-muted small mb-0">Kelola template dan jenis surat yang tersedia di sistem</p>
    </div>
    <a href="<?= site_url('surat/jenis/create') ?>" class="btn btn-primary btn-sm rounded-pill px-4">
        <i class="bi bi-plus-circle me-1"></i>Tambah Jenis Surat
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
    <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
<div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm">
    <i class="bi bi-exclamation-circle-fill me-2"></i><?= session()->getFlashdata('error') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="row g-3">
    <?php if (empty($jenisSurat)): ?>
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-collection fs-1 d-block mb-3 text-primary opacity-50"></i>
                <h5 class="fw-semibold">Belum Ada Jenis Surat</h5>
                <p class="text-muted small mb-4">Tambahkan jenis surat pertama agar penduduk bisa mengajukan surat.</p>
                <a href="<?= site_url('surat/jenis/create') ?>" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-plus-circle me-1"></i>Tambah Sekarang
                </a>
            </div>
        </div>
    </div>
    <?php else: ?>
    <?php foreach ($jenisSurat as $js): ?>
    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-start gap-3">
                    <div class="bg-primary bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width:48px;height:48px">
                        <i class="bi bi-envelope-paper text-primary fs-4"></i>
                    </div>
                    <div class="flex-grow-1 min-width-0">
                        <h6 class="fw-bold mb-1 text-truncate"><?= esc($js['nama_surat']) ?></h6>
                        <code class="small text-muted"><?= esc($js['kode_surat']) ?></code>
                        <div class="mt-2 d-flex gap-2 flex-wrap">
                            <?php $fields = json_decode($js['form_fields'] ?? '[]', true) ?? []; ?>
                            <span class="badge bg-light text-muted border">
                                <i class="bi bi-input-cursor me-1"></i><?= count($fields) ?> field
                            </span>
                            <?php if (!empty($js['template_surat'])): ?>
                            <span class="badge bg-success-subtle text-success border border-success-subtle">
                                <i class="bi bi-check me-1"></i>Ada template
                            </span>
                            <?php else: ?>
                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle">
                                <i class="bi bi-exclamation me-1"></i>Belum ada template
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top d-flex gap-2">
                <a href="<?= site_url('surat/jenis/edit/' . $js['id']) ?>" class="btn btn-outline-primary btn-sm flex-grow-1 rounded-pill">
                    <i class="bi bi-pencil me-1"></i>Edit
                </a>
                <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3"
                    data-bs-toggle="modal" data-bs-target="#modalHapus<?= $js['id'] ?>">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>

        <!-- Modal Hapus -->
        <div class="modal fade" id="modalHapus<?= $js['id'] ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content border-0 shadow">
                    <div class="modal-body text-center py-4">
                        <i class="bi bi-trash-fill text-danger fs-1 d-block mb-3"></i>
                        <h6 class="fw-bold">Hapus Jenis Surat?</h6>
                        <p class="text-muted small mb-0">
                            <strong><?= esc($js['nama_surat']) ?></strong> akan dihapus permanen beserta template-nya.
                        </p>
                    </div>
                    <div class="modal-footer border-0 justify-content-center gap-2 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <form action="<?= site_url('surat/jenis/delete/' . $js['id']) ?>" method="post">
                            <?= csrf_field() ?>
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger rounded-pill px-4">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
