<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="mb-0 fw-bold"><?= esc($title) ?></h5>
        <small class="text-muted">Kelola foto galeri desa</small>
    </div>
    <a href="<?= site_url('galeri/create') ?>" class="btn btn-success btn-sm">
        <i class="bi bi-cloud-upload me-1"></i> Upload Foto
    </a>
</div>

<?php if (empty($galeri)): ?>
<div class="card"><div class="card-body text-center py-5 text-muted">
    <i class="bi bi-images fs-1 d-block mb-2"></i>
    <p>Belum ada foto di galeri.</p>
    <a href="<?= site_url('galeri/create') ?>" class="btn btn-success btn-sm">Upload Foto Pertama</a>
</div></div>
<?php else: ?>
<div class="row g-3">
    <?php foreach ($galeri as $g): ?>
    <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="card h-100">
            <div style="height:180px;overflow:hidden;border-radius:.75rem .75rem 0 0;background:#f1f5f9">
                <img src="<?= base_url('uploads/galeri/'.$g['file_gambar']) ?>"
                    class="w-100 h-100" style="object-fit:cover"
                    onerror="this.style.display='none';this.parentElement.innerHTML='<div class=\'d-flex align-items-center justify-content-center h-100 text-muted\'><i class=\'bi bi-image fs-1\'></i></div>'">
            </div>
            <div class="card-body p-2">
                <div class="fw-semibold small text-truncate"><?= esc($g['judul']) ?></div>
                <?php if ($g['deskripsi']): ?>
                <div class="text-muted" style="font-size:.72rem;overflow:hidden;max-height:2.5em"><?= esc($g['deskripsi']) ?></div>
                <?php endif; ?>
                <div class="text-muted" style="font-size:.68rem"><?= esc(substr($g['created_at'] ?? '', 0, 10)) ?></div>
            </div>
            <div class="card-footer p-2 d-flex gap-1">
                <a href="<?= site_url('galeri/edit/'.$g['id']) ?>" class="btn btn-xs btn-outline-warning flex-fill"><i class="bi bi-pencil"></i> Edit</a>
                <button class="btn btn-xs btn-outline-danger flex-fill"
                    onclick="confirmDelete('<?= site_url('galeri/delete/'.$g['id']) ?>', '<?= esc($g['judul'], 'js') ?>')">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<div class="mt-2 text-muted small">Total: <?= count($galeri) ?> foto</div>
<?php endif; ?>

<form id="deleteForm" method="post" style="display:none"><?= csrf_field() ?><input type="hidden" name="_method" value="DELETE"></form>
<div class="modal fade" id="deleteModal" tabindex="-1"><div class="modal-dialog modal-sm"><div class="modal-content">
    <div class="modal-header"><h6 class="modal-title">Hapus Foto</h6><button class="btn-close" data-bs-dismiss="modal"></button></div>
    <div class="modal-body">Hapus foto <strong id="deleteName"></strong>?</div>
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
