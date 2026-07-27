<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="mb-0 fw-bold"><?= esc($title) ?></h5>
        <small class="text-muted">Data pejabat dan struktur organisasi pemerintahan desa</small>
    </div>
    <a href="<?= site_url('pemerintahan/create') ?>" class="btn btn-success btn-sm">
        <i class="bi bi-person-plus me-1"></i> Tambah Pejabat
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr><th>#</th><th>Foto</th><th>Jabatan</th><th>Nama Pejabat</th><th>Tahun</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    <?php if (empty($struktur)): ?>
                    <tr><td colspan="6" class="text-center py-4 text-muted"><i class="bi bi-inbox fs-3 d-block mb-2"></i>Belum ada data struktur pemerintahan</td></tr>
                    <?php else: ?>
                    <?php foreach ($struktur as $i => $s): ?>
                    <tr>
                        <td class="text-muted small"><?= $i + 1 ?></td>
                        <td>
                            <?php if (!empty($s['foto'])): ?>
                            <img src="<?= base_url('uploads/pejabat/'.$s['foto']) ?>"
                                class="rounded-circle" style="width:40px;height:40px;object-fit:cover"
                                onerror="this.outerHTML='<div class=\'rounded-circle bg-secondary-subtle d-flex align-items-center justify-content-center\' style=\'width:40px;height:40px\'><i class=\'bi bi-person\'></i></div>'">
                            <?php else: ?>
                            <div class="rounded-circle bg-secondary-subtle d-flex align-items-center justify-content-center" style="width:40px;height:40px">
                                <i class="bi bi-person text-secondary"></i>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td class="fw-semibold"><?= esc($s['nama_jabatan']) ?></td>
                        <td><?= esc($s['nama_pejabat']) ?></td>
                        <td><span class="badge bg-secondary-subtle text-secondary"><?= esc($s['tahun']) ?></span></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?= site_url('pemerintahan/edit/'.$s['id']) ?>" class="btn btn-xs btn-outline-warning"><i class="bi bi-pencil"></i></a>
                                <button class="btn btn-xs btn-outline-danger"
                                    onclick="confirmDelete('<?= site_url('pemerintahan/delete/'.$s['id']) ?>', '<?= esc($s['nama_jabatan'], 'js') ?>')">
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
</div>

<form id="deleteForm" method="post" style="display:none"><?= csrf_field() ?><input type="hidden" name="_method" value="DELETE"></form>
<div class="modal fade" id="deleteModal" tabindex="-1"><div class="modal-dialog modal-sm"><div class="modal-content">
    <div class="modal-header"><h6 class="modal-title">Hapus Data</h6><button class="btn-close" data-bs-dismiss="modal"></button></div>
    <div class="modal-body">Hapus jabatan <strong id="deleteName"></strong>?</div>
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
