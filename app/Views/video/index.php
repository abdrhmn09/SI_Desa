<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="mb-0 fw-bold"><?= esc($title) ?></h5>
        <small class="text-muted">Kelola link video desa (YouTube/Vimeo)</small>
    </div>
    <a href="<?= site_url('video/create') ?>" class="btn btn-success btn-sm">
        <i class="bi bi-plus-circle me-1"></i> Tambah Video
    </a>
</div>

<div class="row g-3">
    <?php if (empty($videos)): ?>
    <div class="col-12">
        <div class="card"><div class="card-body text-center py-5 text-muted">
            <i class="bi bi-play-btn fs-1 d-block mb-2"></i>
            <p>Belum ada video terdaftar.</p>
            <a href="<?= site_url('video/create') ?>" class="btn btn-success btn-sm">Tambah Video Pertama</a>
        </div></div>
    </div>
    <?php else: ?>
    <?php foreach ($videos as $v): ?>
    <div class="col-md-6 col-xl-4">
        <div class="card h-100">
            <?php if (!empty($v['embed_url'])): ?>
            <div class="ratio ratio-16x9" style="border-radius:.75rem .75rem 0 0;overflow:hidden">
                <iframe src="<?= esc($v['embed_url']) ?>" allowfullscreen title="<?= esc($v['judul']) ?>"></iframe>
            </div>
            <?php else: ?>
            <div class="d-flex align-items-center justify-content-center bg-light" style="height:200px;border-radius:.75rem .75rem 0 0">
                <i class="bi bi-play-circle fs-1 text-muted"></i>
            </div>
            <?php endif; ?>
            <div class="card-body">
                <h6 class="fw-bold mb-1"><?= esc($v['judul']) ?></h6>
                <?php if ($v['deskripsi']): ?>
                <p class="text-muted small mb-2"><?= esc($v['deskripsi']) ?></p>
                <?php endif; ?>
                <a href="<?= esc($v['url_video']) ?>" target="_blank" class="text-muted" style="font-size:.72rem">
                    <i class="bi bi-link-45deg"></i> <?= esc(substr($v['url_video'], 0, 50)) ?>...
                </a>
            </div>
            <div class="card-footer d-flex gap-1">
                <a href="<?= site_url('video/edit/'.$v['id']) ?>" class="btn btn-sm btn-outline-warning flex-fill"><i class="bi bi-pencil me-1"></i>Edit</a>
                <button class="btn btn-sm btn-outline-danger flex-fill"
                    onclick="confirmDelete('<?= site_url('video/delete/'.$v['id']) ?>', '<?= esc($v['judul'], 'js') ?>')">
                    <i class="bi bi-trash me-1"></i>Hapus
                </button>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
</div>

<form id="deleteForm" method="post" style="display:none"><?= csrf_field() ?><input type="hidden" name="_method" value="DELETE"></form>
<div class="modal fade" id="deleteModal" tabindex="-1"><div class="modal-dialog modal-sm"><div class="modal-content">
    <div class="modal-header"><h6 class="modal-title">Hapus Video</h6><button class="btn-close" data-bs-dismiss="modal"></button></div>
    <div class="modal-body">Hapus video <strong id="deleteName"></strong>?</div>
    <div class="modal-footer">
        <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-sm btn-danger" id="deleteConfirm">Hapus</button>
    </div>
</div></div></div>

<?= $this->section('scripts') ?>
<script>
function confirmDelete(url, name) {
    document.getElementById('deleteName').textContent = name;
    document.getElementById('deleteConfirm').onclick = () => { const f = document.getElementById('deleteForm'); f.action = url; f.submit(); };
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>
