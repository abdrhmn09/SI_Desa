<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="mb-0 fw-bold"><?= esc($title) ?></h5>
        <small class="text-muted">Kelola akun pengguna sistem</small>
    </div>
    <a href="<?= site_url('pengguna/create') ?>" class="btn btn-success btn-sm">
        <i class="bi bi-person-plus me-1"></i> Tambah Pengguna
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr><th>#</th><th>Username</th><th>Email</th><th>Role</th><th>Status</th><th>Dibuat</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                    <tr><td colspan="7" class="text-center py-4 text-muted"><i class="bi bi-inbox fs-3 d-block mb-2"></i>Belum ada pengguna</td></tr>
                    <?php else: ?>
                    <?php foreach ($users as $i => $u): ?>
                    <tr>
                        <td class="text-muted small"><?= $i + 1 ?></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center fw-bold"
                                    style="width:32px;height:32px;font-size:.75rem;color:#1a4731">
                                    <?= strtoupper(substr($u['username'], 0, 1)) ?>
                                </div>
                                <div>
                                    <div class="fw-semibold small"><?= esc($u['username']) ?></div>
                                    <?php if ($u['id'] == session()->get('user_id')): ?>
                                    <span class="badge bg-primary-subtle text-primary" style="font-size:.65rem">Anda</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td class="small"><?= esc($u['email'] ?? '-') ?></td>
                        <td><span class="badge bg-secondary-subtle text-secondary"><?= esc($u['nama_role'] ?? 'Tanpa Role') ?></span></td>
                        <td>
                            <?php if ($u['is_active']): ?>
                                <span class="badge bg-success-subtle text-success"><i class="bi bi-circle-fill" style="font-size:.5rem"></i> Aktif</span>
                            <?php else: ?>
                                <span class="badge bg-danger-subtle text-danger"><i class="bi bi-circle-fill" style="font-size:.5rem"></i> Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <td class="small"><?= esc(substr($u['created_at'] ?? '', 0, 10)) ?></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?= site_url('pengguna/edit/'.$u['id']) ?>" class="btn btn-xs btn-outline-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                                <a href="<?= site_url('pengguna/toggle-active/'.$u['id']) ?>" class="btn btn-xs btn-outline-<?= $u['is_active'] ? 'secondary' : 'success' ?>" title="<?= $u['is_active'] ? 'Nonaktifkan' : 'Aktifkan' ?>">
                                    <i class="bi bi-<?= $u['is_active'] ? 'pause-circle' : 'play-circle' ?>"></i>
                                </a>
                                <?php if ($u['id'] != session()->get('user_id')): ?>
                                <button class="btn btn-xs btn-outline-danger" title="Hapus"
                                    onclick="confirmDelete('<?= site_url('pengguna/delete/'.$u['id']) ?>', '<?= esc($u['username'], 'js') ?>')">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer text-muted small">Total: <?= count($users) ?> pengguna</div>
</div>

<form id="deleteForm" method="post" style="display:none"><?= csrf_field() ?><input type="hidden" name="_method" value="DELETE"></form>
<div class="modal fade" id="deleteModal" tabindex="-1"><div class="modal-dialog modal-sm"><div class="modal-content">
    <div class="modal-header"><h6 class="modal-title">Hapus Pengguna</h6><button class="btn-close" data-bs-dismiss="modal"></button></div>
    <div class="modal-body">Hapus pengguna <strong id="deleteName"></strong>? Tindakan ini tidak dapat dibatalkan.</div>
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
