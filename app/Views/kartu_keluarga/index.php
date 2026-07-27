<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="mb-0 fw-bold"><?= esc($title) ?></h5>
        <small class="text-muted">Daftar kartu keluarga terdaftar</small>
    </div>
    <a href="<?= site_url('kartu-keluarga/create') ?>" class="btn btn-success btn-sm">
        <i class="bi bi-journal-plus me-1"></i> Tambah KK
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No KK</th>
                        <th>Kepala Keluarga</th>
                        <th>Alamat</th>
                        <th>RT / RW</th>
                        <th>Tgl Dikeluarkan</th>
                        <th>Anggota</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($kartuKeluarga)): ?>
                    <tr><td colspan="8" class="text-center py-4 text-muted"><i class="bi bi-inbox fs-3 d-block mb-2"></i>Belum ada data KK</td></tr>
                    <?php else: ?>
                    <?php foreach ($kartuKeluarga as $i => $kk): ?>
                    <tr>
                        <td class="text-muted small"><?= $i + 1 ?></td>
                        <td class="font-monospace fw-bold"><?= esc($kk['no_kk']) ?></td>
                        <td><?= esc($kk['nama_kepala'] ?? '-') ?></td>
                        <td class="small"><?= esc($kk['alamat'] ?? '-') ?></td>
                        <td class="small"><?= esc($kk['rt'] ?? '-') ?> / <?= esc($kk['rw'] ?? '-') ?></td>
                        <td class="small"><?= esc($kk['tanggal_dikeluarkan'] ?? '-') ?></td>
                        <td><span class="badge bg-primary-subtle text-primary"><?= esc($kk['jumlah_anggota'] ?? 0) ?> jiwa</span></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?= site_url('kartu-keluarga/edit/'.$kk['id']) ?>" class="btn btn-xs btn-outline-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                                <button class="btn btn-xs btn-outline-danger" title="Hapus"
                                    onclick="confirmDelete('<?= site_url('kartu-keluarga/delete/'.$kk['id']) ?>', '<?= esc($kk['no_kk'], 'js') ?>')">
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
    <div class="card-footer text-muted small">Total: <?= count($kartuKeluarga) ?> kartu keluarga</div>
</div>

<form id="deleteForm" method="post" style="display:none"><?= csrf_field() ?><input type="hidden" name="_method" value="DELETE"></form>
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-sm"><div class="modal-content">
        <div class="modal-header"><h6 class="modal-title">Konfirmasi Hapus</h6><button class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">Hapus KK <strong id="deleteName"></strong>?</div>
        <div class="modal-footer">
            <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button class="btn btn-sm btn-danger" id="deleteConfirm">Hapus</button>
        </div>
    </div></div>
</div>

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
