<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="mb-0 fw-bold"><?= esc($title) ?></h5>
        <small class="text-muted">Kelola data kependudukan</small>
    </div>
    <a href="<?= site_url('penduduk/create') ?>" class="btn btn-success btn-sm">
        <i class="bi bi-person-plus me-1"></i> Tambah Penduduk
    </a>
</div>

<!-- Filter -->
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="get" class="row g-2 align-items-end">
            <div class="col-md-5">
                <input type="text" name="cari" class="form-control form-control-sm" placeholder="Cari NIK atau nama..." value="<?= esc($cari ?? '') ?>">
            </div>
            <div class="col-md-3">
                <select name="jk" class="form-select form-select-sm">
                    <option value="">Semua Jenis Kelamin</option>
                    <option value="Laki-laki" <?= ($filterJK ?? '') === 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                    <option value="Perempuan" <?= ($filterJK ?? '') === 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="hubungan" class="form-select form-select-sm">
                    <option value="">Semua Hubungan</option>
                    <?php foreach (['Kepala Keluarga','Istri','Anak','Famili Lain','Lainnya'] as $h): ?>
                    <option value="<?= $h ?>" <?= ($filterHubungan ?? '') === $h ? 'selected' : '' ?>><?= $h ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-1">
                <button type="submit" class="btn btn-sm btn-primary flex-fill"><i class="bi bi-search"></i></button>
                <a href="<?= site_url('penduduk') ?>" class="btn btn-sm btn-outline-secondary flex-fill"><i class="bi bi-x"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NIK</th>
                        <th>Nama Lengkap</th>
                        <th>No KK</th>
                        <th>Hubungan</th>
                        <th>JK</th>
                        <th>Tempat / Tanggal Lahir</th>
                        <th>Agama</th>
                        <th>Status Kawin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($penduduk)): ?>
                    <tr><td colspan="10" class="text-center py-4 text-muted"><i class="bi bi-inbox fs-3 d-block mb-2"></i>Tidak ada data penduduk</td></tr>
                    <?php else: ?>
                    <?php foreach ($penduduk as $i => $p): ?>
                    <tr>
                        <td class="text-muted small"><?= $i + 1 ?></td>
                        <td><span class="font-monospace small"><?= esc($p['nik']) ?></span></td>
                        <td class="fw-semibold"><?= esc($p['nama_lengkap']) ?></td>
                        <td class="small"><?= esc($p['no_kk'] ?? '-') ?></td>
                        <td><span class="badge bg-secondary-subtle text-secondary"><?= esc($p['hubungan_keluarga'] ?? '-') ?></span></td>
                        <td>
                            <?php if ($p['jenis_kelamin'] === 'Laki-laki'): ?>
                                <span class="badge bg-primary-subtle text-primary"><i class="bi bi-gender-male"></i></span>
                            <?php elseif ($p['jenis_kelamin'] === 'Perempuan'): ?>
                                <span class="badge bg-danger-subtle text-danger"><i class="bi bi-gender-female"></i></span>
                            <?php else: ?>-<?php endif; ?>
                        </td>
                        <td class="small"><?= esc($p['tempat_lahir'] ?? '-') ?>, <?= esc($p['tanggal_lahir'] ?? '-') ?></td>
                        <td class="small"><?= esc($p['agama'] ?? '-') ?></td>
                        <td class="small"><?= esc($p['status_kawin'] ?? '-') ?></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?= site_url('penduduk/show/'.$p['id']) ?>" class="btn btn-xs btn-outline-info" title="Detail"><i class="bi bi-eye"></i></a>
                                <a href="<?= site_url('penduduk/edit/'.$p['id']) ?>" class="btn btn-xs btn-outline-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                                <button type="button" class="btn btn-xs btn-outline-danger" title="Hapus"
                                    onclick="confirmDelete('<?= site_url('penduduk/delete/'.$p['id']) ?>', '<?= esc($p['nama_lengkap'], 'js') ?>')">
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
    <div class="card-footer text-muted small">Total: <?= count($penduduk) ?> penduduk</div>
</div>

<!-- Modal Hapus -->
<form id="deleteForm" method="post" style="display:none">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="DELETE">
</form>
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header"><h6 class="modal-title">Konfirmasi Hapus</h6><button class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">Hapus data <strong id="deleteName"></strong>?</div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-sm btn-danger" id="deleteConfirm">Hapus</button>
            </div>
        </div>
    </div>
</div>

<?= $this->section('scripts') ?>
<style>.btn-xs{padding:.2rem .4rem;font-size:.75rem}</style>
<script>
function confirmDelete(url, name) {
    document.getElementById('deleteName').textContent = name;
    document.getElementById('deleteConfirm').onclick = () => {
        const f = document.getElementById('deleteForm');
        f.action = url; f.submit();
    };
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>
