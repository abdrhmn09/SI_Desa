<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center gap-2 mb-3">
    <div>
        <h5 class="mb-0 fw-bold"><?= esc($title) ?></h5>
        <small class="text-muted">Upload file Excel untuk mengimpor data kependudukan secara massal</small>
    </div>
</div>

<!-- Statistik -->
<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="card text-center">
            <div class="card-body py-3">
                <div class="fs-2 fw-bold text-success"><?= number_format($totalPenduduk) ?></div>
                <div class="text-muted small">Total Penduduk</div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card text-center">
            <div class="card-body py-3">
                <div class="fs-2 fw-bold text-primary"><?= number_format($totalKK) ?></div>
                <div class="text-muted small">Total KK</div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card text-center">
            <div class="card-body py-3">
                <div class="fs-2 fw-bold text-warning"><?= number_format($totalPendudukTanpaKK) ?></div>
                <div class="text-muted small">Penduduk Tanpa KK</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Import Penduduk -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-people text-success"></i> Import Data Penduduk
            </div>
            <div class="card-body">
                <p class="text-muted small">Upload file Excel (.xlsx) berisi data penduduk sesuai format template.</p>
                <div class="alert alert-info small p-2">
                    <i class="bi bi-info-circle me-1"></i>
                    Kolom: NIK, Nama, No KK, Hubungan, Tempat Lahir, Tgl Lahir, JK, Agama, Pendidikan, Pekerjaan, Status Kawin
                </div>
                <form action="<?= site_url('import/penduduk') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <input type="file" name="file_excel" class="form-control" accept=".xlsx,.xls" required>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="bi bi-upload me-1"></i> Upload & Import
                        </button>
                        <a href="<?= site_url('import/template-penduduk') ?>" class="btn btn-outline-success btn-sm">
                            <i class="bi bi-download me-1"></i> Download Template
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Import KK -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-journal-bookmark text-primary"></i> Import Data Kartu Keluarga
            </div>
            <div class="card-body">
                <p class="text-muted small">Upload file Excel (.xlsx) berisi data kartu keluarga sesuai format template.</p>
                <div class="alert alert-info small p-2">
                    <i class="bi bi-info-circle me-1"></i>
                    Kolom: No KK, Alamat, Dusun, RT, RW, Tanggal Dikeluarkan
                </div>
                <form action="<?= site_url('import/kk') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <input type="file" name="file_excel" class="form-control" accept=".xlsx,.xls" required>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="bi bi-upload me-1"></i> Upload & Import
                        </button>
                        <a href="<?= site_url('import/template-kk') ?>" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-download me-1"></i> Download Template
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header d-flex align-items-center gap-2">
        <i class="bi bi-exclamation-triangle text-warning"></i> Panduan Import
    </div>
    <div class="card-body">
        <ol class="mb-0 small">
            <li>Download template yang tersedia.</li>
            <li>Isi data sesuai format kolom di template (jangan mengubah header).</li>
            <li>Simpan file dalam format <strong>.xlsx</strong>.</li>
            <li>Upload file dan tunggu proses import selesai.</li>
            <li>Data yang sudah ada (NIK/No KK duplikat) akan <strong>dilewati</strong>, bukan ditimpa.</li>
        </ol>
    </div>
</div>

<?= $this->endSection() ?>
