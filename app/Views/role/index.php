<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="mb-0 fw-bold"><?= esc($title) ?></h5>
        <small class="text-muted">Kelola role dan hak akses pengguna sistem</small>
    </div>
</div>

<div class="row g-3">
    <?php if (empty($roles)): ?>
    <div class="col-12">
        <div class="card"><div class="card-body text-center py-5 text-muted">
            <i class="bi bi-shield-x fs-1 d-block mb-2"></i>
            <p>Belum ada role terdaftar.</p>
        </div></div>
    </div>
    <?php else: ?>
    <?php
    $roleColors = ['Administrator'=>'danger','Operator'=>'primary','Viewer'=>'secondary'];
    $roleIcons  = ['Administrator'=>'shield-fill-check','Operator'=>'person-workspace','Viewer'=>'eye'];
    ?>
    <?php foreach ($roles as $r): ?>
    <div class="col-md-6 col-lg-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-3 p-2 bg-<?= $roleColors[$r['nama_role']] ?? 'secondary' ?>-subtle">
                        <i class="bi bi-<?= $roleIcons[$r['nama_role']] ?? 'shield' ?> fs-4 text-<?= $roleColors[$r['nama_role']] ?? 'secondary' ?>"></i>
                    </div>
                    <div>
                        <div class="fw-bold"><?= esc($r['nama_role']) ?></div>
                        <div class="text-muted small"><?= esc($r['jumlah_permission'] ?? 0) ?> permission aktif</div>
                    </div>
                </div>
                <div class="progress mb-2" style="height:6px" title="<?= $r['jumlah_permission'] ?? 0 ?> permission">
                    <?php $pct = min(100, (($r['jumlah_permission'] ?? 0) / 10) * 100) ?>
                    <div class="progress-bar bg-<?= $roleColors[$r['nama_role']] ?? 'secondary' ?>" style="width:<?= $pct ?>%"></div>
                </div>
            </div>
            <div class="card-footer">
                <a href="<?= site_url('role/edit/'.$r['id']) ?>" class="btn btn-sm btn-outline-primary w-100">
                    <i class="bi bi-sliders me-1"></i> Atur Permissions
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
