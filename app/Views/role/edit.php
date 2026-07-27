<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center gap-2 mb-3">
    <a href="<?= site_url('role') ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h5 class="mb-0 fw-bold"><?= esc($title) ?></h5>
        <small class="text-muted">Role: <strong><?= esc($role['nama_role']) ?></strong></small>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-shield-lock text-primary"></i>
                Daftar Permission untuk <strong class="ms-1"><?= esc($role['nama_role']) ?></strong>
            </div>
            <div class="card-body">
                <form action="<?= site_url('role/update-permissions/'.$role['id']) ?>" method="post">
                    <?= csrf_field() ?>
                    <?php if (empty($permissions)): ?>
                        <p class="text-muted">Belum ada permission terdaftar di sistem.</p>
                    <?php else: ?>
                    <div class="row g-2">
                        <?php foreach ($permissions as $p): ?>
                        <div class="col-md-6">
                            <label class="d-flex align-items-start gap-2 p-3 border rounded-2 cursor-pointer permission-item <?= $p['aktif'] ? 'border-primary bg-primary bg-opacity-10' : '' ?>">
                                <input type="checkbox" name="permissions[]" value="<?= $p['id'] ?>"
                                    class="form-check-input mt-0 flex-shrink-0 perm-check"
                                    <?= $p['aktif'] ? 'checked' : '' ?>>
                                <div>
                                    <div class="fw-semibold small text-capitalize">
                                        <?= esc(str_replace('_', ' ', $p['nama_permission'])) ?>
                                    </div>
                                    <div class="text-muted" style="font-size:.72rem;font-family:monospace">
                                        <?= esc($p['nama_permission']) ?>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <hr>
                    <div class="d-flex gap-2 align-items-center">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan Permissions</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="toggleAll">Pilih Semua</button>
                    </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">Info Role</div>
            <div class="card-body">
                <dl class="mb-0">
                    <dt class="text-muted fw-normal small">Nama Role</dt>
                    <dd class="fw-bold"><?= esc($role['nama_role']) ?></dd>
                    <dt class="text-muted fw-normal small">Permission Aktif</dt>
                    <dd><span id="activeCount"><?= count(array_filter($permissions, fn($p) => $p['aktif'])) ?></span> dari <?= count($permissions) ?></dd>
                </dl>
            </div>
        </div>
    </div>
</div>

<?= $this->section('scripts') ?>
<style>
.permission-item { cursor: pointer; transition: background .15s; }
.permission-item:has(.perm-check:checked) { border-color: #0d6efd !important; background: rgba(13,110,253,.07) !important; }
</style>
<script>
let allSelected = false;
document.getElementById('toggleAll').addEventListener('click', function() {
    allSelected = !allSelected;
    document.querySelectorAll('.perm-check').forEach(c => c.checked = allSelected);
    this.textContent = allSelected ? 'Batalkan Semua' : 'Pilih Semua';
    updateCount();
});
document.querySelectorAll('.perm-check').forEach(c => c.addEventListener('change', updateCount));
function updateCount() {
    document.getElementById('activeCount').textContent = document.querySelectorAll('.perm-check:checked').length;
}
</script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>
