<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-pen-fill text-success me-2"></i>Persetujuan Surat</h4>
        <p class="text-muted small mb-0">Daftar pengajuan surat yang menunggu tanda tangan Kepala Desa</p>
    </div>
    <a href="<?= site_url('surat/semua') ?>" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-clock-history me-1"></i>Semua Riwayat
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
<div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
    <i class="bi bi-exclamation-circle-fill me-2"></i><?= session()->getFlashdata('error') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 border-bottom">
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-warning text-dark fs-6"><?= count($pengajuan) ?></span>
            <span class="fw-semibold">Pengajuan Menunggu Persetujuan</span>
        </div>
    </div>
    <div class="card-body p-0">
        <?php if (empty($pengajuan)): ?>
        <div class="text-center py-5 text-muted">
            <i class="bi bi-inbox fs-1 d-block mb-3 text-success opacity-50"></i>
            <p class="fw-semibold">Tidak ada pengajuan yang menunggu persetujuan</p>
            <p class="small">Semua surat sudah diproses.</p>
        </div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Tgl Pengajuan</th>
                        <th>Pemohon</th>
                        <th>Jenis Surat</th>
                        <th>Data Isian</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pengajuan as $i => $row): ?>
                    <tr>
                        <td class="ps-4 text-muted small"><?= $i + 1 ?></td>
                        <td>
                            <div class="fw-semibold small"><?= date('d M Y', strtotime($row['created_at'])) ?></div>
                            <div class="text-muted" style="font-size:.75rem"><?= date('H:i', strtotime($row['created_at'])) ?> WIB</div>
                        </td>
                        <td>
                            <div class="fw-semibold"><?= esc($row['nama_lengkap']) ?></div>
                            <div class="small text-muted">NIK: <?= esc($row['nik']) ?></div>
                        </td>
                        <td>
                            <span class="badge bg-primary bg-opacity-10 text-primary py-2 px-3">
                                <?= esc($row['nama_surat']) ?>
                            </span>
                            <div class="text-muted" style="font-size:.75rem">Kode: <?= esc($row['kode_surat']) ?></div>
                        </td>
                        <td>
                            <?php $isian = json_decode($row['data_isian'], true) ?? []; ?>
                            <?php if (!empty($isian)): ?>
                            <ul class="list-unstyled small mb-0">
                                <?php foreach ($isian as $key => $val): ?>
                                <li>
                                    <span class="text-muted"><?= esc(ucfirst(str_replace('_', ' ', $key))) ?>:</span>
                                    <strong class="ms-1"><?= esc($val) ?></strong>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php else: ?>
                            <span class="text-muted small fst-italic">Tidak ada isian tambahan</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-2 justify-content-center">
                                <!-- Preview -->
                                <a href="<?= site_url('surat/preview/' . $row['id']) ?>" target="_blank"
                                    class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    <i class="bi bi-eye me-1"></i>Preview
                                </a>
                                <!-- Setujui -->
                                <form action="<?= site_url('surat/setujui/' . $row['id']) ?>" method="post"
                                    onsubmit="return confirm('Setujui dan terbitkan nomor surat untuk <?= esc($row['nama_lengkap']) ?>?');">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">
                                        <i class="bi bi-pen me-1"></i>ACC
                                    </button>
                                </form>
                                <!-- Tolak -->
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                    data-bs-toggle="modal" data-bs-target="#modalTolak<?= $row['id'] ?>">
                                    <i class="bi bi-x-circle me-1"></i>Tolak
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Modal Tolak -->
                    <div class="modal fade" id="modalTolak<?= $row['id'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header border-0">
                                    <h6 class="modal-title fw-bold">Tolak Pengajuan Surat</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="<?= site_url('surat/tolak/' . $row['id']) ?>" method="post">
                                    <?= csrf_field() ?>
                                    <div class="modal-body">
                                        <p class="text-muted small">Pengajuan dari <strong><?= esc($row['nama_lengkap']) ?></strong> untuk <strong><?= esc($row['nama_surat']) ?></strong> akan ditolak.</p>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Alasan Penolakan</label>
                                            <textarea name="alasan" class="form-control" rows="3"
                                                placeholder="Contoh: Berkas tidak lengkap, harap melengkapi..." required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">
                                            <i class="bi bi-x-circle me-1"></i>Tolak Pengajuan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>