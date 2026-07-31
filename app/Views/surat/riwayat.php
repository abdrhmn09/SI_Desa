<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-clock-history text-primary me-2"></i>Riwayat Surat Saya</h4>
        <p class="text-muted small mb-0">Pantau status semua pengajuan surat Anda</p>
    </div>
    <a href="<?= site_url('surat/pilih') ?>" class="btn btn-primary btn-sm rounded-pill px-4">
        <i class="bi bi-plus-circle me-1"></i>Ajukan Surat Baru
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

<?php if (empty($riwayat)): ?>
<div class="card border-0 shadow-sm">
    <div class="card-body text-center py-5">
        <i class="bi bi-envelope-paper fs-1 d-block mb-3 text-primary opacity-50"></i>
        <h5 class="fw-semibold">Belum Ada Pengajuan Surat</h5>
        <p class="text-muted small mb-4">Anda belum pernah mengajukan surat melalui sistem ini.</p>
        <a href="<?= site_url('surat/pilih') ?>" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-circle me-1"></i>Ajukan Surat Pertama Anda
        </a>
    </div>
</div>
<?php else: ?>
<div class="row g-3">
    <?php foreach ($riwayat as $row): ?>
    <?php
        $statusMap = [
            'Menunggu'  => ['class' => 'warning', 'icon' => 'hourglass-split'],
            'Disetujui' => ['class' => 'success', 'icon' => 'check-circle-fill'],
            'Ditolak'   => ['class' => 'danger',  'icon' => 'x-circle-fill'],
        ];
        $st = $statusMap[$row['status']] ?? ['class' => 'secondary', 'icon' => 'question-circle'];
    ?>
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="row align-items-center g-3">
                    <!-- Status Icon -->
                    <div class="col-auto">
                        <div class="rounded-circle bg-<?= $st['class'] ?>-subtle d-flex align-items-center justify-content-center"
                            style="width:50px;height:50px">
                            <i class="bi bi-<?= $st['icon'] ?> text-<?= $st['class'] ?> fs-4"></i>
                        </div>
                    </div>
                    <!-- Info -->
                    <div class="col">
                        <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                            <h6 class="fw-bold mb-0"><?= esc($row['nama_surat']) ?></h6>
                            <span class="badge bg-<?= $st['class'] ?> bg-opacity-15 text-<?= $st['class'] ?> border border-<?= $st['class'] ?>-subtle">
                                <?= esc($row['status']) ?>
                            </span>
                        </div>
                        <div class="text-muted small">
                            <i class="bi bi-calendar me-1"></i>Diajukan: <?= date('d M Y, H:i', strtotime($row['created_at'])) ?> WIB
                            <?php if (!empty($row['kode_surat'])): ?>
                            &nbsp;·&nbsp;<i class="bi bi-tag me-1"></i>Kode: <?= esc($row['kode_surat']) ?>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($row['nomor_surat'])): ?>
                        <div class="mt-1">
                            <span class="badge bg-success-subtle text-success border border-success-subtle">
                                <i class="bi bi-hash"></i> <?= esc($row['nomor_surat']) ?>
                            </span>
                        </div>
                        <?php endif; ?>
                        <?php if ($row['status'] === 'Ditolak' && !empty($row['keterangan'])): ?>
                        <div class="mt-2 p-2 bg-danger-subtle rounded small text-danger">
                            <i class="bi bi-info-circle me-1"></i><strong>Alasan Penolakan:</strong> <?= esc($row['keterangan']) ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <!-- Actions -->
                    <div class="col-auto">
                        <?php if ($row['status'] === 'Disetujui'): ?>
                        <a href="<?= site_url('surat/cetak/' . $row['id']) ?>" class="btn btn-success btn-sm rounded-pill px-3" target="_blank">
                            <i class="bi bi-printer me-1"></i>Cetak Surat
                        </a>
                        <?php elseif ($row['status'] === 'Menunggu'): ?>
                        <span class="text-muted small fst-italic">Sedang diproses...</span>
                        <?php else: ?>
                        <a href="<?= site_url('surat/pilih') ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                            <i class="bi bi-arrow-repeat me-1"></i>Ajukan Ulang
                        </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Detail Isian -->
                <?php $isian = json_decode($row['data_isian'], true) ?? []; ?>
                <?php if (!empty($isian)): ?>
                <hr class="my-3">
                <div class="row g-2">
                    <?php foreach ($isian as $key => $val): ?>
                    <div class="col-sm-6 col-md-4">
                        <div class="small text-muted"><?= esc(ucfirst(str_replace('_', ' ', $key))) ?></div>
                        <div class="small fw-semibold"><?= esc($val) ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?= $this->endSection() ?>
