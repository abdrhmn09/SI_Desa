<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="mb-0 fw-bold"><?= esc($title) ?></h5>
        <small class="text-muted">Kelola data kependudukan</small>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= site_url('penduduk/export-page') ?>" class="btn btn-outline-success btn-sm">
            <i class="bi bi-file-earmark-excel me-1"></i> Ekspor Excel
        </a>
        <a href="<?= site_url('penduduk/create') ?>" class="btn btn-success btn-sm">
            <i class="bi bi-person-plus me-1"></i> Tambah Penduduk
        </a>
    </div>
</div>

<!-- Filter -->
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="get" class="row g-2 align-items-end">
            <div class="col-md-4">
                <input type="text" name="cari" class="form-control form-control-sm" placeholder="Cari NIK atau nama..." value="<?= esc($cari ?? '') ?>">
            </div>
            <div class="col-md-2">
                <select name="jk" class="form-select form-select-sm">
                    <option value="">Semua JK</option>
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
            <div class="col-md-2">
                <select name="verifikasi" class="form-select form-select-sm">
                    <option value="">Semua Verifikasi</option>
                    <option value="1" <?= ($filterVerifikasi ?? '') === '1' ? 'selected' : '' ?>>Terverifikasi</option>
                    <option value="0" <?= ($filterVerifikasi ?? '') === '0' ? 'selected' : '' ?>>Belum Diverifikasi</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-1">
                <button type="submit" class="btn btn-sm btn-primary flex-fill"><i class="bi bi-search"></i> Filter</button>
                <a href="<?= site_url('penduduk') ?>" class="btn btn-sm btn-outline-secondary flex-fill"><i class="bi bi-x"></i> Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NIK</th>
                        <th>Nama Lengkap</th>
                        <th>No KK</th>
                        <th>Hubungan</th>
                        <th>JK</th>
                        <th>Akun Tautan</th>
                        <th>Status Data</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($penduduk)): ?>
                    <tr><td colspan="9" class="text-center py-4 text-muted"><i class="bi bi-inbox fs-3 d-block mb-2"></i>Tidak ada data penduduk</td></tr>
                    <?php else: ?>
                    <?php foreach ($penduduk as $i => $p): ?>
                    <tr>
                        <td class="text-muted small"><?= $i + 1 ?></td>
                        <td><span class="font-monospace small"><?= esc($p['nik']) ?></span></td>
                        <td>
                            <div class="fw-semibold"><?= esc($p['nama_lengkap']) ?></div>
                            <small class="text-muted"><?= esc($p['tempat_lahir'] ?? '-') ?>, <?= esc($p['tanggal_lahir'] ?? '-') ?></small>
                        </td>
                        <td class="small"><?= esc($p['no_kk'] ?? '-') ?></td>
                        <td><span class="badge bg-secondary-subtle text-secondary"><?= esc($p['hubungan_keluarga'] ?? '-') ?></span></td>
                        <td>
                            <?php if ($p['jenis_kelamin'] === 'Laki-laki'): ?>
                                <span class="badge bg-primary-subtle text-primary"><i class="bi bi-gender-male"></i></span>
                            <?php elseif ($p['jenis_kelamin'] === 'Perempuan'): ?>
                                <span class="badge bg-danger-subtle text-danger"><i class="bi bi-gender-female"></i></span>
                            <?php else: ?>-<?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($p['linked_user'])): ?>
                                <span class="badge bg-info-subtle text-info"><i class="bi bi-person-check me-1"></i><?= esc($p['linked_user']) ?></span>
                            <?php else: ?>
                                <span class="text-muted small">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($p['is_verified']): ?>
                                <span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle-fill me-1"></i>Verified</span>
                            <?php else: ?>
                                <span class="badge bg-warning-subtle text-warning"><i class="bi bi-clock me-1"></i>Belum Verif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <!-- Tombol Verifikasi / Batal Verifikasi -->
                                <?php if ($p['is_verified']): ?>
                                    <a href="<?= site_url('penduduk/verifikasi/'.$p['id']) ?>" class="btn btn-xs btn-outline-secondary" title="Batalkan Verifikasi"><i class="bi bi-x-circle"></i></a>
                                <?php else: ?>
                                    <a href="<?= site_url('penduduk/verifikasi/'.$p['id']) ?>" class="btn btn-xs btn-success" title="Verifikasi Data"><i class="bi bi-check-lg"></i></a>
                                <?php endif; ?>

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
