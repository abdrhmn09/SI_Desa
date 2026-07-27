<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center gap-2 mb-3">
    <a href="<?= site_url('artikel') ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h5 class="mb-0 fw-bold"><?= esc($title) ?></h5>
    </div>
    <div class="ms-auto d-flex gap-2">
        <a href="<?= site_url('baca-artikel/'.$artikel['slug']) ?>" target="_blank" class="btn btn-sm btn-outline-info">
            <i class="bi bi-box-arrow-up-right me-1"></i> Lihat Publik
        </a>
        <a href="<?= site_url('artikel/edit/'.$artikel['id']) ?>" class="btn btn-sm btn-warning">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card">
            <?php if ($artikel['gambar']): ?>
            <img src="<?= site_url('uploads/artikel/'.$artikel['gambar']) ?>" class="card-img-top" style="max-height:300px;object-fit:cover">
            <?php endif; ?>
            <div class="card-body">
                <h4 class="fw-bold mb-2"><?= esc($artikel['judul']) ?></h4>
                <div class="d-flex gap-2 mb-3 flex-wrap">
                    <?php $colors = ['Berita'=>'primary','Pengumuman'=>'warning','Agenda'=>'info']; ?>
                    <span class="badge bg-<?= $colors[$artikel['kategori']] ?? 'secondary' ?>">
                        <?= esc($artikel['kategori']) ?>
                    </span>
                    <?php if ($artikel['status'] === 'published'): ?>
                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Published</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Draft</span>
                    <?php endif; ?>
                    <span class="text-muted small"><i class="bi bi-person me-1"></i><?= esc($artikel['penulis'] ?? '-') ?></span>
                    <span class="text-muted small"><i class="bi bi-calendar me-1"></i><?= esc(substr($artikel['created_at'] ?? '', 0, 10)) ?></span>
                </div>
                <hr>
                <div style="line-height:1.8"><?= nl2br(esc($artikel['isi'])) ?></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">Informasi Artikel</div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-0">
                    <tr><th class="text-muted fw-normal small">ID</th><td class="small"><?= $artikel['id'] ?></td></tr>
                    <tr><th class="text-muted fw-normal small">Slug</th><td class="small font-monospace"><?= esc($artikel['slug']) ?></td></tr>
                    <tr><th class="text-muted fw-normal small">Dibuat</th><td class="small"><?= esc($artikel['created_at'] ?? '-') ?></td></tr>
                    <tr><th class="text-muted fw-normal small">Diperbarui</th><td class="small"><?= esc($artikel['updated_at'] ?? '-') ?></td></tr>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
