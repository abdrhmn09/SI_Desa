<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<?php if (session()->get('role_nama') === 'Penduduk'): ?>
    <div class="alert alert-info mb-4 border-0 shadow-sm d-flex align-items-center gap-3" style="background-color: #e0f2fe; color: #0369a1;">
        <i class="bi bi-person-badge fs-1"></i>
        <div>
            <h5 class="mb-1 fw-bold">Selamat Datang, <?= esc($penduduk['nama_lengkap'] ?? session()->get('username')) ?>!</h5>
            <p class="mb-0 small">Ini adalah panel informasi layanan kependudukan Anda. Anda dapat memantau riwayat pengajuan surat di sini.</p>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-4">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3" style="background:#e8f5e9">
                        <i class="bi bi-envelope-paper-fill fs-3 text-success"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Pengajuan Surat</div>
                        <div class="fs-3 fw-bold"><?= number_format($totalSuratSaya ?? 0) ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3" style="background:#fff3e0">
                        <i class="bi bi-clock-history fs-3 text-warning"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Surat Selesai (Bulan Ini)</div>
                        <div class="fs-3 fw-bold"><?= number_format($suratBulanIniSaya ?? 0) ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-xl-4">
            <div class="card h-100 border-primary border-opacity-25">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-lightning-charge-fill text-primary"></i> <span class="fw-semibold">Akses Cepat</span>
                    </div>
                    <div class="d-flex flex-column gap-2">
                        <a href="<?= site_url('surat/pilih') ?>" class="btn btn-sm btn-primary text-start"><i class="bi bi-plus-circle me-1"></i> Ajukan Surat Baru</a>
                        <a href="<?= site_url('penduduk') ?>" class="btn btn-sm btn-outline-secondary text-start"><i class="bi bi-person me-1"></i> Lihat Data Diri</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex align-items-center gap-2">
            <i class="bi bi-list-check text-success"></i> Riwayat Pengajuan Surat Anda
        </div>
        <div class="card-body p-0">
            <?php if (!empty($riwayatSuratSaya)): ?>
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nomor Surat</th>
                            <th>Jenis Surat</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($riwayatSuratSaya as $rs): ?>
                    <tr>
                        <td class="small fw-semibold"><?= esc($rs['nomor_surat']) ?></td>
                        <td class="small"><?= esc($rs['nama_surat']) ?></td>
                        <td class="small"><?= esc($rs['tanggal_cetak']) ?></td>
                        <td class="small"><span class="badge bg-success">Tercetak</span></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="p-4 text-center text-muted">
                <div class="rounded-circle bg-light d-inline-flex p-3 mb-2">
                    <i class="bi bi-inbox fs-3"></i>
                </div>
                <div class="d-block">Belum ada riwayat pengajuan surat.</div>
            </div>
            <?php endif; ?>
        </div>
    </div>

<?php else: ?>
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3" style="background:#e8f5e9">
                        <i class="bi bi-people-fill fs-3 text-success"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Penduduk</div>
                        <div class="fs-3 fw-bold"><?= number_format($totalPenduduk ?? 0) ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3" style="background:#e3f2fd">
                        <i class="bi bi-journal-bookmark-fill fs-3 text-primary"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Kartu Keluarga</div>
                        <div class="fs-3 fw-bold"><?= number_format($totalKK ?? 0) ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3" style="background:#fff3e0">
                        <i class="bi bi-envelope-paper-fill fs-3 text-warning"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Surat Tercetak (Bulan Ini)</div>
                        <div class="fs-3 fw-bold"><?= number_format($suratBulanIni ?? 0) ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3" style="background:#fce4ec">
                        <i class="bi bi-newspaper fs-3 text-danger"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Artikel Terpublikasi</div>
                        <div class="fs-3 fw-bold"><?= number_format($totalArtikel ?? 0) ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-5">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center gap-2">
                    <i class="bi bi-bar-chart-fill text-success"></i> Komposisi Penduduk
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="small fw-semibold"><i class="bi bi-gender-male text-primary me-1"></i>Laki-laki</span>
                            <span class="small"><?= $laki ?? 0 ?> jiwa</span>
                        </div>
                        <div class="progress" style="height:10px">
                            <div class="progress-bar bg-primary" style="width:<?= !empty($totalPenduduk) ? round($laki/$totalPenduduk*100) : 0 ?>%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="small fw-semibold"><i class="bi bi-gender-female text-danger me-1"></i>Perempuan</span>
                            <span class="small"><?= $perempuan ?? 0 ?> jiwa</span>
                        </div>
                        <div class="progress" style="height:10px">
                            <div class="progress-bar bg-danger" style="width:<?= !empty($totalPenduduk) ? round($perempuan/$totalPenduduk*100) : 0 ?>%"></div>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col">
                            <div class="fw-bold text-primary"><?= !empty($totalPenduduk) ? round($laki/$totalPenduduk*100) : 0 ?>%</div>
                            <div class="small text-muted">L</div>
                        </div>
                        <div class="col">
                            <div class="fw-bold text-danger"><?= !empty($totalPenduduk) ? round($perempuan/$totalPenduduk*100) : 0 ?>%</div>
                            <div class="small text-muted">P</div>
                        </div>
                        <div class="col">
                            <div class="fw-bold"><?= $totalPenduduk ?? 0 ?></div>
                            <div class="small text-muted">Total</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center gap-2">
                    <i class="bi bi-clock-history text-warning"></i> Log Surat Terbaru
                </div>
                <div class="card-body p-0">
                    <?php if (!empty($logSurat)): ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="table-light"><tr><th>Nomor Surat</th><th>Nama</th><th>Jenis</th><th>Tanggal</th></tr></thead>
                            <tbody>
                            <?php foreach ($logSurat as $ls): ?>
                            <tr>
                                <td class="small fw-semibold"><?= esc($ls['nomor_surat']) ?></td>
                                <td class="small"><?= esc($ls['nama_lengkap']) ?></td>
                                <td class="small"><?= esc($ls['nama_surat']) ?></td>
                                <td class="small"><?= esc($ls['tanggal_cetak']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="p-4 text-center text-muted"><i class="bi bi-inbox fs-3 d-block mb-2"></i>Belum ada surat tercetak</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex align-items-center gap-2">
                    <i class="bi bi-arrow-right-circle text-success"></i> Akses Cepat
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        <a href="<?= site_url('penduduk/create') ?>" class="btn btn-sm btn-outline-success"><i class="bi bi-person-plus me-1"></i>Tambah Penduduk</a>
                        <a href="<?= site_url('kartu-keluarga/create') ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-journal-plus me-1"></i>Tambah KK</a>
                        <a href="<?= site_url('surat/pilih') ?>" class="btn btn-sm btn-outline-warning"><i class="bi bi-envelope-paper me-1"></i>Cetak Surat</a>
                        <a href="<?= site_url('artikel/create') ?>" class="btn btn-sm btn-outline-danger"><i class="bi bi-plus-circle me-1"></i>Tulis Artikel</a>
                        <a href="<?= site_url('import') ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-file-earmark-arrow-up me-1"></i>Import Data</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex align-items-center gap-2">
                    <i class="bi bi-info-circle text-info"></i> Informasi Sistem
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0 small">
                        <li class="d-flex justify-content-between py-1 border-bottom"><span class="text-muted">Versi CI4</span><span class="fw-semibold"><?= CodeIgniter\CodeIgniter::CI_VERSION ?></span></li>
                        <li class="d-flex justify-content-between py-1 border-bottom"><span class="text-muted">PHP</span><span class="fw-semibold"><?= phpversion() ?></span></li>
                        <li class="d-flex justify-content-between py-1 border-bottom"><span class="text-muted">Database</span><span class="fw-semibold">MySQL</span></li>
                        <li class="d-flex justify-content-between py-1"><span class="text-muted">Server Time</span><span class="fw-semibold"><?= date('d M Y H:i') ?></span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>