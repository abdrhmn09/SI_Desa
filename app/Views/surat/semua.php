<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-archive-fill text-secondary me-2"></i>Semua Riwayat Surat</h4>
        <p class="text-muted small mb-0">Rekap lengkap semua pengajuan surat dari seluruh penduduk</p>
    </div>
    <a href="<?= site_url('surat/persetujuan') ?>" class="btn btn-warning btn-sm rounded-pill px-3">
        <i class="bi bi-pen me-1"></i>Menunggu Persetujuan
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
    <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <span class="fw-semibold">Total: <?= count($riwayat) ?> surat</span>
        <div class="input-group" style="max-width:250px">
            <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-search text-muted"></i></span>
            <input type="text" id="searchInput" class="form-control border-start-0 ps-0" placeholder="Cari nama / jenis surat...">
        </div>
    </div>
    <div class="card-body p-0">
        <?php if (empty($riwayat)): ?>
        <div class="text-center py-5 text-muted">
            <i class="bi bi-inbox fs-1 d-block mb-3 opacity-50"></i>
            <p class="fw-semibold">Belum ada riwayat surat</p>
        </div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="tabelSurat">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Tgl Pengajuan</th>
                        <th>Pemohon</th>
                        <th>Jenis Surat</th>
                        <th>Nomor Surat</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($riwayat as $i => $row): ?>
                    <?php
                        $statusClass = [
                            'Menunggu'  => 'warning',
                            'Disetujui' => 'success',
                            'Ditolak'   => 'danger',
                        ][$row['status']] ?? 'secondary';
                    ?>
                    <tr class="searchable-row">
                        <td class="ps-4 text-muted small"><?= $i + 1 ?></td>
                        <td class="small"><?= date('d M Y', strtotime($row['created_at'])) ?></td>
                        <td>
                            <div class="fw-semibold small"><?= esc($row['nama_lengkap']) ?></div>
                            <div class="text-muted" style="font-size:.75rem">NIK: <?= esc($row['nik']) ?></div>
                        </td>
                        <td class="small"><?= esc($row['nama_surat']) ?></td>
                        <td>
                            <?php if (!empty($row['nomor_surat'])): ?>
                            <code class="small"><?= esc($row['nomor_surat']) ?></code>
                            <?php else: ?>
                            <span class="text-muted small">—</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge bg-<?= $statusClass ?>-subtle text-<?= $statusClass ?> border border-<?= $statusClass ?>-subtle">
                                <?= esc($row['status']) ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <?php if ($row['status'] === 'Disetujui'): ?>
                            <a href="<?= site_url('surat/cetak/' . $row['id']) ?>" class="btn btn-sm btn-success rounded-pill px-3" target="_blank">
                                <i class="bi bi-printer"></i>
                            </a>
                            <?php elseif ($row['status'] === 'Menunggu'): ?>
                            <form action="<?= site_url('surat/setujui/' . $row['id']) ?>" method="post" class="d-inline"
                                onsubmit="return confirm('Setujui surat ini?');">
                                <?= csrf_field() ?>
                                <button class="btn btn-sm btn-success rounded-pill px-3" title="ACC">
                                    <i class="bi bi-pen"></i>
                                </button>
                            </form>
                            <?php else: ?>
                            <span class="text-muted small">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.getElementById('searchInput')?.addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.searchable-row').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>

<?= $this->endSection() ?>
