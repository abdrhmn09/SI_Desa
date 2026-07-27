<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex align-items-center gap-2">
        <i class="bi bi-check-circle-fill text-success fs-5"></i> 
        <h5 class="mb-0 fw-bold">Menunggu Persetujuan Kepala Desa</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tgl Pengajuan</th>
                        <th>Pemohon</th>
                        <th>Jenis Surat</th>
                        <th>Keperluan/Isian</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pengajuan as $row): ?>
                    <tr>
                        <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
                        <td>
                            <div class="fw-semibold"><?= esc($row['nama_lengkap']) ?></div>
                            <div class="small text-muted">NIK: <?= esc($row['nik']) ?></div>
                        </td>
                        <td><span class="badge bg-primary bg-opacity-10 text-primary"><?= esc($row['nama_surat']) ?></span></td>
                        <td>
                            <ul class="list-unstyled small mb-0">
                                <?php 
                                    $isian = json_decode($row['data_isian'], true) ?? [];
                                    foreach($isian as $key => $val):
                                ?>
                                    <li><strong><?= esc(ucfirst(str_replace('_', ' ', $key))) ?>:</strong> <?= esc($val) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                        <td class="text-center">
                            <form action="<?= site_url('admin/surat/setujui/' . $row['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui dan menerbitkan surat ini?');">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">
                                    <i class="bi bi-pen me-1"></i> Tanda Tangani & ACC
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>