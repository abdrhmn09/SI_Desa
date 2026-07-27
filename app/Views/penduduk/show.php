<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center gap-2 mb-3">
    <a href="<?= site_url('penduduk') ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h5 class="mb-0 fw-bold"><?= esc($title) ?></h5>
        <small class="text-muted">Detail data kependudukan</small>
    </div>
    <div class="ms-auto">
        <a href="<?= site_url('penduduk/edit/'.$penduduk['id']) ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil me-1"></i> Edit</a>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Data Pribadi</div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-0">
                    <tr><th class="text-muted fw-normal" style="width:35%">NIK</th><td class="fw-bold font-monospace"><?= esc($penduduk['nik']) ?></td></tr>
                    <tr><th class="text-muted fw-normal">Nama Lengkap</th><td class="fw-bold"><?= esc($penduduk['nama_lengkap']) ?></td></tr>
                    <tr><th class="text-muted fw-normal">Jenis Kelamin</th><td><?= esc($penduduk['jenis_kelamin'] ?? '-') ?></td></tr>
                    <tr><th class="text-muted fw-normal">Tempat, Tgl Lahir</th><td><?= esc($penduduk['tempat_lahir'] ?? '-') ?>, <?= esc($penduduk['tanggal_lahir'] ?? '-') ?></td></tr>
                    <tr><th class="text-muted fw-normal">Agama</th><td><?= esc($penduduk['agama'] ?? '-') ?></td></tr>
                    <tr><th class="text-muted fw-normal">Pendidikan</th><td><?= esc($penduduk['pendidikan'] ?? '-') ?></td></tr>
                    <tr><th class="text-muted fw-normal">Pekerjaan</th><td><?= esc($penduduk['pekerjaan'] ?? '-') ?></td></tr>
                    <tr><th class="text-muted fw-normal">Status Kawin</th><td><?= esc($penduduk['status_kawin'] ?? '-') ?></td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">Data Keluarga</div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-0">
                    <tr><th class="text-muted fw-normal">No KK</th><td class="font-monospace small"><?= esc($penduduk['no_kk'] ?? '-') ?></td></tr>
                    <tr><th class="text-muted fw-normal">Hubungan</th><td><?= esc($penduduk['hubungan_keluarga'] ?? '-') ?></td></tr>
                    <tr><th class="text-muted fw-normal">RT/RW</th><td><?= esc($penduduk['rt'] ?? '-') ?>/<?= esc($penduduk['rw'] ?? '-') ?></td></tr>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-header">Metadata</div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-0">
                    <tr><th class="text-muted fw-normal small">Dibuat</th><td class="small"><?= esc($penduduk['created_at'] ?? '-') ?></td></tr>
                    <tr><th class="text-muted fw-normal small">Diperbarui</th><td class="small"><?= esc($penduduk['updated_at'] ?? '-') ?></td></tr>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
