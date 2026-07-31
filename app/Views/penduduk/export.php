<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-file-earmark-excel text-success me-2"></i>Ekspor Data Kependudukan</h4>
        <p class="text-muted small mb-0">Pilih kriteria filter untuk menyesuaikan data penduduk yang akan diunduh dalam format Excel (.xlsx)</p>
    </div>
    <div>
        <a href="<?= site_url('penduduk') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Data Penduduk
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom py-3">
        <h6 class="fw-bold mb-0 text-primary"><i class="bi bi-funnel me-2"></i>Filter Parameter Data</h6>
    </div>
    <form action="<?= site_url('penduduk/export') ?>" method="get" target="_blank">
        <div class="card-body p-4">
            <div class="row g-3">
                <!-- Jenis Kelamin -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select">
                        <option value="">-- Semua Jenis Kelamin --</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

                <!-- Agama -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Agama</label>
                    <select name="agama" class="form-select">
                        <option value="">-- Semua Agama --</option>
                        <?php foreach (['Islam','Kristen Protestan','Kristen Katolik','Hindu','Buddha','Konghucu','Lainnya'] as $ag): ?>
                        <option value="<?= $ag ?>"><?= $ag ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Dusun -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Dusun / Wilayah</label>
                    <select name="dusun" class="form-select">
                        <option value="">-- Semua Dusun --</option>
                        <?php foreach ($dusunList as $dusun): ?>
                        <option value="<?= esc($dusun) ?>"><?= esc($dusun) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Pendidikan -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Pendidikan Terakhir</label>
                    <select name="pendidikan" class="form-select">
                        <option value="">-- Semua Pendidikan --</option>
                        <?php foreach (['Belum Sekolah','Tidak Tamat SD','SD/Sederajat','SMP/Sederajat','SMA/SMK/Sederajat','D1/D2/D3','S1/D4','S2','S3','Lainnya'] as $pend): ?>
                        <option value="<?= $pend ?>"><?= $pend ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Pekerjaan -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Pekerjaan</label>
                    <select name="pekerjaan" class="form-select">
                        <option value="">-- Semua Pekerjaan --</option>
                        <?php foreach (['Belum/Tidak Bekerja','Petani/Peternak','Nelayan','PNS/TNI/Polri','Karyawan Swasta','Wiraswasta/Pedagang','Buruh Harian Lepas','Ibu Rumah Tangga','Pelajar/Mahasiswa','Pensiunan','Lainnya'] as $pek): ?>
                        <option value="<?= $pek ?>"><?= $pek ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Status Perkawinan -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status Perkawinan</label>
                    <select name="status_kawin" class="form-select">
                        <option value="">-- Semua Status Perkawinan --</option>
                        <?php foreach (['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati'] as $sk): ?>
                        <option value="<?= $sk ?>"><?= $sk ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Golongan Darah -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Golongan Darah</label>
                    <select name="golongan_darah" class="form-select">
                        <option value="">-- Semua Golongan Darah --</option>
                        <?php foreach (['A','B','AB','O','Tidak Tahu'] as $gd): ?>
                        <option value="<?= $gd ?>"><?= $gd ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Kewarganegaraan -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Kewarganegaraan</label>
                    <select name="kewarganegaraan" class="form-select">
                        <option value="">-- Semua Kewarganegaraan --</option>
                        <option value="WNI">WNI</option>
                        <option value="WNA">WNA</option>
                    </select>
                </div>

                <!-- Status Tinggal -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status Tinggal</label>
                    <select name="status_tinggal" class="form-select">
                        <option value="">-- Semua Status Tinggal --</option>
                        <?php foreach (['Tetap','Kontrak','Kos','Domisili Sementara'] as $st): ?>
                        <option value="<?= $st ?>"><?= $st ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Hubungan Keluarga -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Hubungan Keluarga</label>
                    <select name="hubungan_keluarga" class="form-select">
                        <option value="">-- Semua Hubungan Keluarga --</option>
                        <?php foreach (['Kepala Keluarga','Istri','Anak','Famili Lain','Lainnya'] as $hk): ?>
                        <option value="<?= $hk ?>"><?= $hk ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Status DTKS / Bansos -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Status Penerima Bansos (DTKS)</label>
                    <select name="is_dtks" class="form-select">
                        <option value="">-- Semua Status DTKS --</option>
                        <option value="1">Terdaftar DTKS / Bansos (Ya)</option>
                        <option value="0">Tidak Terdaftar (Tidak)</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="card-footer bg-white border-top py-3 d-flex justify-content-between align-items-center">
            <span class="text-muted small">
                <i class="bi bi-info-circle me-1"></i> Biarkan filter kosong jika ingin mengekspor seluruh data penduduk.
            </span>
            <button type="submit" class="btn btn-success fw-semibold px-4">
                <i class="bi bi-file-earmark-excel me-2"></i> Download File Excel
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
