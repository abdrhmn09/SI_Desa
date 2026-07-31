<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="<?= site_url('penduduk') ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h5 class="mb-0 fw-bold"><?= esc($title) ?></h5>
        <small class="text-muted">Detail data kependudukan & profil diri</small>
    </div>
    <div class="ms-auto d-flex gap-2">
        <?php if ($penduduk['is_verified']): ?>
            <a href="<?= site_url('penduduk/verifikasi/'.$penduduk['id']) ?>" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-x-circle me-1"></i> Batalkan Verifikasi
            </a>
        <?php else: ?>
            <a href="<?= site_url('penduduk/verifikasi/'.$penduduk['id']) ?>" class="btn btn-sm btn-success fw-semibold">
                <i class="bi bi-check-lg me-1"></i> Verifikasi Data Ini
            </a>
        <?php endif; ?>
        <a href="<?= site_url('penduduk/edit/'.$penduduk['id']) ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil me-1"></i> Edit</a>
    </div>
</div>

<div class="row g-3">
    <!-- KOLOM KIRI (Data Pribadi & Orang Tua) -->
    <div class="col-md-8">
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-white fw-bold text-primary border-bottom py-3">
                <i class="bi bi-person-vcard me-2"></i>Data Pribadi & Kependudukan
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-0">
                    <tr><th class="text-muted fw-normal" style="width:35%">NIK</th><td class="fw-bold font-monospace"><?= esc($penduduk['nik']) ?></td></tr>
                    <tr><th class="text-muted fw-normal">Nama Lengkap</th><td class="fw-bold text-dark"><?= esc($penduduk['nama_lengkap']) ?></td></tr>
                    <tr><th class="text-muted fw-normal">Jenis Kelamin</th><td><?= esc($penduduk['jenis_kelamin'] ?? '-') ?></td></tr>
                    <tr><th class="text-muted fw-normal">Tempat, Tgl Lahir</th><td><?= esc($penduduk['tempat_lahir'] ?? '-') ?>, <?= esc($penduduk['tanggal_lahir'] ?? '-') ?></td></tr>
                    <tr><th class="text-muted fw-normal">Agama</th><td><?= esc($penduduk['agama'] ?? '-') ?></td></tr>
                    <tr><th class="text-muted fw-normal">Golongan Darah</th><td><span class="badge bg-light text-dark border"><?= esc($penduduk['golongan_darah'] ?? 'Tidak Tahu') ?></span></td></tr>
                    <tr><th class="text-muted fw-normal">Pendidikan</th><td><?= esc($penduduk['pendidikan'] ?? '-') ?></td></tr>
                    <tr><th class="text-muted fw-normal">Pekerjaan</th><td><?= esc($penduduk['pekerjaan'] ?? '-') ?></td></tr>
                    <tr><th class="text-muted fw-normal">Status Kawin</th><td><?= esc($penduduk['status_kawin'] ?? '-') ?></td></tr>
                    <tr><th class="text-muted fw-normal">Kewarganegaraan</th><td><?= esc($penduduk['kewarganegaraan'] ?? 'WNI') ?></td></tr>
                    <tr><th class="text-muted fw-normal">Status Tinggal</th><td><?= esc($penduduk['status_tinggal'] ?? '-') ?></td></tr>
                </table>
            </div>
        </div>

        <!-- Data Orang Tua -->
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-white fw-bold text-primary border-bottom py-3">
                <i class="bi bi-people me-2"></i>Data Orang Tua
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-0">
                    <tr><th class="text-muted fw-normal" style="width:35%">Nama Ayah</th><td><?= esc($penduduk['nama_ayah'] ?? '-') ?> <?= !empty($penduduk['nik_ayah']) ? '('.esc($penduduk['nik_ayah']).')' : '' ?></td></tr>
                    <tr><th class="text-muted fw-normal">Nama Ibu Kandung</th><td><?= esc($penduduk['nama_ibu'] ?? '-') ?> <?= !empty($penduduk['nik_ibu']) ? '('.esc($penduduk['nik_ibu']).')' : '' ?></td></tr>
                </table>
            </div>
        </div>

        <!-- Sesama KK -->
        <?php if (!empty($sesamaKK)): ?>
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold text-primary border-bottom py-3">
                <i class="bi bi-house-door me-2"></i>Anggota Keluarga Sesama KK
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Nama Lengkap</th>
                                <th>Hubungan</th>
                                <th>JK</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sesamaKK as $s): ?>
                            <tr>
                                <td class="font-monospace small"><?= esc($s['nik']) ?></td>
                                <td><a href="<?= site_url('penduduk/show/'.$s['id']) ?>" class="fw-semibold text-decoration-none"><?= esc($s['nama_lengkap']) ?></a></td>
                                <td><span class="badge bg-secondary-subtle text-secondary"><?= esc($s['hubungan_keluarga']) ?></span></td>
                                <td><?= esc($s['jenis_kelamin']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- KOLOM KANAN (Status Verifikasi, Akun Login, Kontak, & KK) -->
    <div class="col-md-4">
        <!-- Status Verifikasi Data -->
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-white fw-bold text-primary border-bottom py-3">
                <i class="bi bi-shield-check me-2"></i>Status Data Admin
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Status Verifikasi:</small>
                    <?php if ($penduduk['is_verified']): ?>
                        <span class="badge bg-success-subtle text-success p-2 w-100 fs-6"><i class="bi bi-check-circle-fill me-1"></i>Terverifikasi</span>
                    <?php else: ?>
                        <span class="badge bg-warning-subtle text-warning p-2 w-100 fs-6"><i class="bi bi-clock me-1"></i>Belum Diverifikasi</span>
                    <?php endif; ?>
                </div>
                <div>
                    <small class="text-muted d-block mb-1">Akun Login Tautan:</small>
                    <?php if (!empty($penduduk['linked_username'])): ?>
                        <div class="p-2 bg-light rounded border">
                            <div class="fw-bold text-dark"><i class="bi bi-person-circle me-1"></i><?= esc($penduduk['linked_username']) ?></div>
                            <small class="text-muted"><?= esc($penduduk['linked_email'] ?? '') ?></small>
                        </div>
                    <?php else: ?>
                        <div class="p-2 bg-light rounded text-muted small text-center">Belum ditautkan ke akun login warga</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Kontak & Bansos -->
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-white fw-bold text-primary border-bottom py-3">
                <i class="bi bi-telephone me-2"></i>Kontak & Status Bansos
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <th class="text-muted fw-normal">No. HP / WA</th>
                        <td>
                            <?php if (!empty($penduduk['no_hp'])): ?>
                                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $penduduk['no_hp']) ?>" target="_blank" class="text-success text-decoration-none fw-semibold">
                                    <i class="bi bi-whatsapp me-1"></i><?= esc($penduduk['no_hp']) ?>
                                </a>
                            <?php else: ?>-<?php endif; ?>
                        </td>
                    </tr>
                    <tr><th class="text-muted fw-normal">Email</th><td><?= esc($penduduk['email_penduduk'] ?? '-') ?></td></tr>
                    <tr>
                        <th class="text-muted fw-normal">Penerima DTKS</th>
                        <td>
                            <?php if ($penduduk['is_dtks']): ?>
                                <span class="badge bg-success">Ya (Terdaftar)</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Tidak</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Kartu Keluarga -->
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-white fw-bold text-primary border-bottom py-3">
                <i class="bi bi-card-heading me-2"></i>Kartu Keluarga
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-0">
                    <tr><th class="text-muted fw-normal">No KK</th><td class="font-monospace fw-bold"><?= esc($penduduk['no_kk'] ?? '-') ?></td></tr>
                    <tr><th class="text-muted fw-normal">Hubungan</th><td><span class="badge bg-primary-subtle text-primary"><?= esc($penduduk['hubungan_keluarga'] ?? '-') ?></span></td></tr>
                    <tr><th class="text-muted fw-normal">Alamat</th><td><?= esc($penduduk['alamat_kk'] ?? '-') ?></td></tr>
                    <tr><th class="text-muted fw-normal">RT / RW</th><td>RT <?= esc($penduduk['rt'] ?? '-') ?> / RW <?= esc($penduduk['rw'] ?? '-') ?></td></tr>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
