<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="mb-0 fw-bold"><?= esc($title) ?></h5>
        <small class="text-muted">Kelola artikel, berita, dan pengumuman desa</small>
    </div>
    <a href="<?= site_url('artikel/create') ?>" class="btn btn-success btn-sm">
        <i class="bi bi-plus-circle me-1"></i> Tulis Artikel
    </a>
</div>

<!-- Filter -->
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="get" class="row g-2 align-items-end">
            <div class="col-md-5">
                <input type="text" name="cari" class="form-control form-control-sm" placeholder="Cari judul..." value="<?= esc($cari ?? '') ?>">
            </div>
            <div class="col-md-3">
                <select name="kategori" class="form-select form-select-sm">
                    <option value="">Semua Kategori</option>
                    <?php foreach (['Berita','Pengumuman','Agenda'] as $k): ?>
                    <option value="<?= $k ?>" <?= ($kategori ?? '') === $k ? 'selected' : '' ?>><?= $k ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-1">
                <button type="submit" class="btn btn-sm btn-primary flex-fill"><i class="bi bi-search"></i></button>
                <a href="<?= site_url('artikel') ?>" class="btn btn-sm btn-outline-secondary flex-fill"><i class="bi bi-x"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr><th>#</th><th>Judul</th><th>Kategori</th><th>Status</th><th>Penulis</th><th>Tanggal</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    <?php if (empty($artikel)): ?>
                    <tr><td colspan="7" class="text-center py-4 text-muted"><i class="bi bi-inbox fs-3 d-block mb-2"></i>Belum ada artikel</td></tr>
                    <?php else: ?>
                    <?php foreach ($artikel as $i => $a): ?>
                    <tr>
                        <td class="text-muted small"><?= $i + 1 ?></td>
                        <td>
                            <div class="fw-semibold small"><?= esc($a['judul']) ?></div>
                            <div class="text-muted" style="font-size:.72rem">slug: <?= esc($a['slug']) ?></div>
                        </td>
                        <td>
                            <?php $colors = ['Berita'=>'primary','Pengumuman'=>'warning','Agenda'=>'info']; ?>
                            <span class="badge bg-<?= $colors[$a['kategori']] ?? 'secondary' ?>-subtle text-<?= $colors[$a['kategori']] ?? 'secondary' ?>">
                                <?= esc($a['kategori']) ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($a['status'] === 'published'): ?>
                                <span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>Published</span>
                            <?php else: ?>
                                <span class="badge bg-secondary-subtle text-secondary">Draft</span>
                            <?php endif; ?>
                        </td>
                        <td class="small"><?= esc($a['penulis'] ?? '-') ?></td>
                        <td class="small"><?= esc(substr($a['created_at'] ?? '', 0, 10)) ?></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?= site_url('artikel/show/'.$a['id']) ?>" class="btn btn-xs btn-outline-info" title="Lihat"><i class="bi bi-eye"></i></a>
                                <a href="<?= site_url('artikel/edit/'.$a['id']) ?>" class="btn btn-xs btn-outline-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                                <button class="btn btn-xs btn-outline-danger" title="Hapus"
                                    onclick="confirmDelete('<?= site_url('artikel/delete/'.$a['id']) ?>', '<?= esc($a['judul'], 'js') ?>')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer text-muted small">Total: <?= count($artikel) ?> artikel</div>
</div>

<form id="deleteForm" method="post" style="display:none"><?= csrf_field() ?><input type="hidden" name="_method" value="DELETE"></form>
<div class="modal fade" id="deleteModal" tabindex="-1"><div class="modal-dialog modal-sm"><div class="modal-content">
    <div class="modal-header"><h6 class="modal-title">Konfirmasi Hapus</h6><button class="btn-close" data-bs-dismiss="modal"></button></div>
    <div class="modal-body">Hapus artikel <strong id="deleteName"></strong>?</div>
    <div class="modal-footer">
        <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-sm btn-danger" id="deleteConfirm">Hapus</button>
    </div>
</div></div></div>

<?= $this->section('scripts') ?>
<style>.btn-xs{padding:.2rem .4rem;font-size:.75rem}</style>
<script>
function confirmDelete(url, name) {
    document.getElementById('deleteName').textContent = name;
    document.getElementById('deleteConfirm').onclick = () => { const f = document.getElementById('deleteForm'); f.action = url; f.submit(); };
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>
