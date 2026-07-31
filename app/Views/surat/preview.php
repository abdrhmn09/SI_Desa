<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<?php
    $statusInfo = [
        'Menunggu'  => ['class' => 'warning', 'icon' => 'hourglass-split', 'text' => 'Menunggu persetujuan — nomor surat akan diterbitkan otomatis setelah di-ACC.'],
        'Disetujui' => ['class' => 'success', 'icon' => 'check-circle-fill', 'text' => 'Sudah disetujui dan siap dicetak.'],
        'Ditolak'   => ['class' => 'danger',  'icon' => 'x-circle-fill',     'text' => 'Pengajuan ini sudah ditolak.'],
    ];
    $status = $statusInfo[$pengajuan['status']] ?? ['class' => 'secondary', 'icon' => 'question-circle', 'text' => ''];
?>

<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-eye-fill text-primary me-2"></i>Preview Surat</h4>
        <p class="text-muted small mb-0">
            <?= esc($jenisSurat['nama_surat']) ?> — <?= esc($penduduk['nama_lengkap']) ?>
        </p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= site_url('surat/persetujuan') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Persetujuan
        </a>
        <?php if ($pengajuan['status'] === 'Disetujui'): ?>
        <a href="<?= site_url('surat/cetak/' . $pengajuan['id']) ?>" target="_blank" class="btn btn-success btn-sm">
            <i class="bi bi-printer me-1"></i> Cetak
        </a>
        <?php endif; ?>
    </div>
</div>

<div class="alert alert-<?= $status['class'] ?> border-0 shadow-sm d-flex align-items-center gap-2">
    <i class="bi bi-<?= $status['icon'] ?> fs-5"></i>
    <div>
        Status pengajuan: <strong><?= esc($pengajuan['status']) ?></strong>
        <?php if ($status['text']): ?> — <?= esc($status['text']) ?><?php endif; ?>
    </div>
</div>

<?php if ($pengajuan['status'] === 'Menunggu'): ?>
<div class="d-flex gap-2 mb-4">
    <form action="<?= site_url('surat/setujui/' . $pengajuan['id']) ?>" method="post"
          onsubmit="return confirm('Setujui dan terbitkan nomor surat untuk <?= esc($penduduk['nama_lengkap'], 'js') ?>?');">
        <?= csrf_field() ?>
        <button type="submit" class="btn btn-success rounded-pill px-4">
            <i class="bi bi-pen me-1"></i> Setujui Surat Ini
        </button>
    </form>
    <button type="button" class="btn btn-outline-danger rounded-pill px-4"
            data-bs-toggle="modal" data-bs-target="#modalTolakPreview">
        <i class="bi bi-x-circle me-1"></i> Tolak
    </button>
</div>

<!-- Modal Tolak (dari halaman preview) -->
<div class="modal fade" id="modalTolakPreview" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h6 class="modal-title fw-bold">Tolak Pengajuan Surat</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= site_url('surat/tolak/' . $pengajuan['id']) ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <p class="text-muted small">
                        Pengajuan dari <strong><?= esc($penduduk['nama_lengkap']) ?></strong>
                        untuk <strong><?= esc($jenisSurat['nama_surat']) ?></strong> akan ditolak.
                    </p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alasan Penolakan</label>
                        <textarea name="alasan" class="form-control" rows="3"
                            placeholder="Contoh: Berkas tidak lengkap, harap melengkapi..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-x-circle me-1"></i> Tolak Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom py-3">
        <i class="bi bi-file-earmark-text me-2 text-muted"></i>Preview Isi Surat
    </div>
    <!-- Tambahkan overflow-x: auto agar bisa di-scroll ke samping di layar HP -->
    <div class="card-body p-3 p-md-4" style="background: #e9ecef; overflow-x: auto;">
        <!-- Kertas A4 Wrapper -->
        <div class="bg-white mx-auto shadow" 
             style="
                width: 210mm; /* Lebar pasti A4 */
                min-height: 297mm; /* Tinggi pasti A4 */
                padding: 2.5cm 2cm 2cm 2.5cm; /* Margin standar surat: Atas 2.5, Kanan 2, Bawah 2, Kiri 2.5 */
                font-family: 'Times New Roman', Times, serif; 
                font-size: 12pt; 
                line-height: 1.5; 
                color: #000;
                box-sizing: border-box; /* Memastikan padding tidak menambah total lebar kertas */
                position: relative;
             ">
            <?= $html_surat ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>