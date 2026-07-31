<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="fw-bold mb-0">Sejarah Kepemimpinan</h4>
        <p class="text-muted small mb-0">Daftar tokoh yang pernah memimpin desa, ditampilkan sebagai timeline di halaman publik.</p>
    </div>
    <a href="<?= site_url('sejarah/create') ?>" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> Tambah Data
    </a>
</div>

<div class="card">
    <div class="card-header">Daftar Sejarah Kepemimpinan</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th style="width:50px">#</th>
                        <th>Nama</th>
                        <th>Masa Jabatan</th>
                        <th>Keterangan</th>
                        <th style="width:160px" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($sejarah)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-clock-history fs-3 d-block mb-2"></i>
                                Belum ada data sejarah kepemimpinan.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($sejarah as $i => $sk): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td class="fw-semibold"><?= esc($sk['nama']) ?></td>
                            <td><span class="badge bg-secondary"><?= esc($sk['masa_jabatan']) ?></span></td>
                            <td class="text-muted small"><?= esc(mb_substr($sk['keterangan'] ?? '-', 0, 80)) ?><?= (mb_strlen($sk['keterangan'] ?? '') > 80) ? '...' : '' ?></td>
                            <td class="text-end">
                                <a href="<?= site_url('sejarah/' . $sk['id']) ?>" class="btn btn-sm btn-outline-secondary" title="Lihat">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="<?= site_url('sejarah/' . $sk['id'] . '/edit') ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="<?= site_url('sejarah/' . $sk['id'] . '/delete') ?>" method="post" class="d-inline"
                                      onsubmit="return confirm('Hapus data \'<?= esc($sk['nama'], 'js') ?>\' dari sejarah kepemimpinan?');">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>