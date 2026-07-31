<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<style>
.profil-hero {
    background: linear-gradient(135deg, #1e3a5f 0%, #2d6a9f 100%);
    border-radius: 16px;
    padding: 2rem;
    color: white;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
}
.profil-hero::before {
    content: '';
    position: absolute;
    top: -50px; right: -50px;
    width: 200px; height: 200px;
    border-radius: 50%;
    background: rgba(255,255,255,0.06);
}
.avatar-circle {
    width: 72px; height: 72px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 2rem;
    border: 3px solid rgba(255,255,255,0.4);
}
.link-nik-card {
    background: linear-gradient(135deg, #fff3cd, #ffeeba);
    border: 2px dashed #f0a500;
    border-radius: 16px;
    padding: 2rem;
    text-align: center;
}
.nav-tabs-custom .nav-link {
    color: #6c757d;
    border: none;
    border-bottom: 3px solid transparent;
    padding: .75rem 1.25rem;
    font-weight: 500;
    transition: all .2s;
}
.nav-tabs-custom .nav-link.active {
    color: #1e3a5f;
    border-bottom-color: #1e3a5f;
    background: transparent;
}
.nav-tabs-custom .nav-link:hover:not(.active) {
    color: #2d6a9f;
    border-bottom-color: #c9d8ec;
}
.section-label {
    font-size: .7rem;
    font-weight: 700;
    letter-spacing: .08em;
    color: #6c757d;
    text-transform: uppercase;
    margin-bottom: .75rem;
    padding-bottom: .4rem;
    border-bottom: 2px solid #e9ecef;
}
.badge-verified {
    background: #d1fae5; color: #065f46;
    padding: .3rem .8rem; border-radius: 20px; font-size: .78rem; font-weight: 600;
}
.badge-unverified {
    background: #fef3c7; color: #92400e;
    padding: .3rem .8rem; border-radius: 20px; font-size: .78rem; font-weight: 600;
}
.readonly-info {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: .75rem 1rem;
    color: #495057;
    font-size: .9rem;
}
</style>

<!-- ===== HERO ===== -->
<div class="profil-hero">
    <div class="d-flex align-items-center gap-3">
        <div class="avatar-circle">
            <i class="bi bi-person-fill"></i>
        </div>
        <div>
            <h4 class="fw-bold mb-1">
                <?php if ($penduduk): ?>
                    <?= esc($penduduk['nama_lengkap']) ?>
                    <?php if ($penduduk['is_verified']): ?>
                        <span class="badge-verified ms-2"><i class="bi bi-check-circle-fill me-1"></i>Terverifikasi</span>
                    <?php else: ?>
                        <span class="badge-unverified ms-2"><i class="bi bi-clock me-1"></i>Belum Diverifikasi</span>
                    <?php endif; ?>
                <?php else: ?>
                    Profil Belum Dikaitkan
                <?php endif; ?>
            </h4>
            <p class="mb-0 opacity-75 small">
                <?php if ($penduduk): ?>
                    NIK: <?= esc($penduduk['nik']) ?> &nbsp;|&nbsp; NIK sudah terhubung ke akun ini
                <?php else: ?>
                    Tautkan NIK Anda untuk mulai mengisi data diri
                <?php endif; ?>
            </p>
        </div>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert alert-success border-0 shadow-sm d-flex align-items-center gap-2 mb-3">
    <i class="bi bi-check-circle-fill text-success"></i>
    <?= esc(session()->getFlashdata('success')) ?>
</div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
<div class="alert alert-danger border-0 shadow-sm mb-3">
    <i class="bi bi-exclamation-triangle-fill me-2"></i>
    <?= esc(session()->getFlashdata('error')) ?>
</div>
<?php endif; ?>

<?php if (isset($errors) && !empty($errors)): ?>
<div class="alert alert-danger border-0 shadow-sm mb-3">
    <div class="fw-semibold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>Perhatikan kesalahan berikut:</div>
    <ul class="mb-0 ps-3">
        <?php foreach ($errors as $err): ?><li><?= esc($err) ?></li><?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<!-- ===== LINK NIK (jika belum terhubung) ===== -->
<?php if (!$penduduk): ?>
<div class="link-nik-card mb-4">
    <i class="bi bi-link-45deg display-4 text-warning mb-3 d-block"></i>
    <h5 class="fw-bold mb-1">Tautkan NIK Anda</h5>
    <p class="text-muted small mb-3">
        Masukkan 16 digit NIK sesuai KTP Anda. Data penduduk Anda harus sudah didaftarkan oleh admin desa terlebih dahulu.
    </p>
    <?php if ($nikError): ?>
        <div class="alert alert-danger py-2"><small><?= esc($nikError) ?></small></div>
    <?php endif; ?>
    <form action="<?= site_url('profil/link-akun') ?>" method="post" class="d-flex gap-2 justify-content-center flex-wrap">
        <?= csrf_field() ?>
        <input type="text" name="nik" class="form-control" style="max-width:240px;"
               placeholder="Masukkan 16 digit NIK"
               maxlength="16" pattern="\d{16}"
               title="NIK harus 16 digit angka" required>
        <button type="submit" class="btn btn-warning fw-semibold px-4">
            <i class="bi bi-link me-1"></i> Tautkan NIK
        </button>
    </form>
</div>
<?php else: ?>

<!-- ===== FORM PROFIL (jika sudah terhubung) ===== -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
        <ul class="nav nav-tabs-custom" id="profilTab" role="tablist">
            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tab-kependudukan"><i class="bi bi-person-vcard me-1"></i> Kependudukan</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-alamat"><i class="bi bi-geo-alt me-1"></i> Alamat</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-ortu"><i class="bi bi-people me-1"></i> Orang Tua</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-kontak"><i class="bi bi-telephone me-1"></i> Kontak & Lainnya</a></li>
        </ul>
    </div>

    <form action="<?= site_url('profil/simpan') ?>" method="post" id="formProfil">
        <?= csrf_field() ?>
        <div class="card-body p-4">
            <div class="tab-content">

                <!-- ============ TAB 1: KEPENDUDUKAN ============ -->
                <div class="tab-pane fade show active" id="tab-kependudukan">
                    <div class="section-label">Data Kependudukan Dasar</div>
                    <div class="row g-3">
                        <!-- NIK (readonly) -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">NIK <span class="text-muted small">(dari KTP)</span></label>
                            <div class="readonly-info"><i class="bi bi-lock-fill me-2 text-muted"></i><?= esc($penduduk['nik']) ?></div>
                        </div>
                        <!-- Nama Lengkap (readonly) -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <div class="readonly-info"><?= esc($penduduk['nama_lengkap']) ?></div>
                        </div>
                        <!-- No KK (readonly) -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">No. Kartu Keluarga</label>
                            <div class="readonly-info"><?= esc($kk['no_kk'] ?? '-') ?></div>
                        </div>
                        <!-- Hubungan (readonly) -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Hubungan dalam Keluarga</label>
                            <div class="readonly-info"><?= esc($penduduk['hubungan_keluarga'] ?? '-') ?></div>
                        </div>

                        <!-- Tempat Lahir -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control"
                                   value="<?= old('tempat_lahir', $penduduk['tempat_lahir'] ?? '') ?>"
                                   placeholder="Contoh: Bireuen">
                        </div>
                        <!-- Tanggal Lahir -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control"
                                   value="<?= old('tanggal_lahir', $penduduk['tanggal_lahir'] ?? '') ?>">
                        </div>
                        <!-- Jenis Kelamin -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select">
                                <option value="">-- Pilih --</option>
                                <?php foreach (['Laki-laki','Perempuan'] as $jk): ?>
                                <option value="<?= $jk ?>" <?= old('jenis_kelamin', $penduduk['jenis_kelamin'] ?? '') == $jk ? 'selected' : '' ?>><?= $jk ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- Agama -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Agama</label>
                            <select name="agama" class="form-select">
                                <option value="">-- Pilih --</option>
                                <?php foreach (['Islam','Kristen Protestan','Kristen Katolik','Hindu','Buddha','Konghucu','Lainnya'] as $ag): ?>
                                <option value="<?= $ag ?>" <?= old('agama', $penduduk['agama'] ?? '') == $ag ? 'selected' : '' ?>><?= $ag ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- Golongan Darah -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Golongan Darah</label>
                            <select name="golongan_darah" class="form-select">
                                <option value="">-- Pilih --</option>
                                <?php foreach (['A','B','AB','O','Tidak Tahu'] as $gd): ?>
                                <option value="<?= $gd ?>" <?= old('golongan_darah', $penduduk['golongan_darah'] ?? '') == $gd ? 'selected' : '' ?>><?= $gd ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- Pendidikan -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Pendidikan Terakhir</label>
                            <select name="pendidikan" class="form-select">
                                <option value="">-- Pilih --</option>
                                <?php foreach (['Belum Sekolah','Tidak Tamat SD','SD/Sederajat','SMP/Sederajat','SMA/SMK/Sederajat','D1/D2/D3','S1/D4','S2','S3','Lainnya'] as $pend): ?>
                                <option value="<?= $pend ?>" <?= old('pendidikan', $penduduk['pendidikan'] ?? '') == $pend ? 'selected' : '' ?>><?= $pend ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- Pekerjaan -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Pekerjaan</label>
                            <select name="pekerjaan" class="form-select">
                                <option value="">-- Pilih --</option>
                                <?php foreach (['Belum/Tidak Bekerja','Petani/Peternak','Nelayan','PNS/TNI/Polri','Karyawan Swasta','Wiraswasta/Pedagang','Buruh Harian Lepas','Ibu Rumah Tangga','Pelajar/Mahasiswa','Pensiunan','Lainnya'] as $pek): ?>
                                <option value="<?= $pek ?>" <?= old('pekerjaan', $penduduk['pekerjaan'] ?? '') == $pek ? 'selected' : '' ?>><?= $pek ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- Status Kawin -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Status Perkawinan</label>
                            <select name="status_kawin" class="form-select">
                                <option value="">-- Pilih --</option>
                                <?php foreach (['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati'] as $sk): ?>
                                <option value="<?= $sk ?>" <?= old('status_kawin', $penduduk['status_kawin'] ?? '') == $sk ? 'selected' : '' ?>><?= $sk ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- Kewarganegaraan -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Kewarganegaraan</label>
                            <select name="kewarganegaraan" class="form-select">
                                <option value="WNI" <?= old('kewarganegaraan', $penduduk['kewarganegaraan'] ?? 'WNI') == 'WNI' ? 'selected' : '' ?>>WNI (Warga Negara Indonesia)</option>
                                <option value="WNA" <?= old('kewarganegaraan', $penduduk['kewarganegaraan'] ?? '') == 'WNA' ? 'selected' : '' ?>>WNA (Warga Negara Asing)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- ============ TAB 2: ALAMAT ============ -->
                <div class="tab-pane fade" id="tab-alamat">
                    <div class="section-label">Data Alamat & Domisili</div>
                    <div class="alert alert-info border-0 bg-light-blue py-2 mb-3 small">
                        <i class="bi bi-info-circle me-2"></i>
                        Data alamat (RT/RW, dusun) diambil dari Kartu Keluarga Anda. Hubungi admin desa jika ada yang tidak sesuai.
                    </div>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Alamat Lengkap (dari KK)</label>
                            <div class="readonly-info"><?= esc($kk['alamat'] ?? '-') ?></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Dusun</label>
                            <div class="readonly-info"><?= esc($kk['dusun'] ?? '-') ?></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">RT</label>
                            <div class="readonly-info"><?= esc($kk['rt'] ?? '-') ?></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">RW</label>
                            <div class="readonly-info"><?= esc($kk['rw'] ?? '-') ?></div>
                        </div>
                        <!-- Status Tinggal (bisa diisi sendiri) -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status Tinggal</label>
                            <select name="status_tinggal" class="form-select">
                                <option value="">-- Pilih --</option>
                                <?php foreach (['Tetap','Kontrak','Kos','Domisili Sementara'] as $st): ?>
                                <option value="<?= $st ?>" <?= old('status_tinggal', $penduduk['status_tinggal'] ?? '') == $st ? 'selected' : '' ?>><?= $st ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- ============ TAB 3: ORANG TUA ============ -->
                <div class="tab-pane fade" id="tab-ortu">
                    <div class="section-label">Data Orang Tua</div>
                    <p class="text-muted small mb-3">Data ini dibutuhkan untuk penerbitan surat-surat resmi seperti Surat Kelahiran dan Keterangan Ahli Waris.</p>
                    <div class="row g-3">
                        <div class="col-12"><h6 class="fw-bold text-primary"><i class="bi bi-person me-1"></i> Data Ayah</h6></div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">NIK Ayah</label>
                            <input type="text" name="nik_ayah" class="form-control" maxlength="16"
                                   value="<?= old('nik_ayah', $penduduk['nik_ayah'] ?? '') ?>"
                                   placeholder="16 digit (jika ada)">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Nama Lengkap Ayah</label>
                            <input type="text" name="nama_ayah" class="form-control"
                                   value="<?= old('nama_ayah', $penduduk['nama_ayah'] ?? '') ?>"
                                   placeholder="Nama sesuai KTP">
                        </div>
                        <div class="col-12 mt-2"><h6 class="fw-bold text-danger"><i class="bi bi-person me-1"></i> Data Ibu Kandung</h6></div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">NIK Ibu</label>
                            <input type="text" name="nik_ibu" class="form-control" maxlength="16"
                                   value="<?= old('nik_ibu', $penduduk['nik_ibu'] ?? '') ?>"
                                   placeholder="16 digit (jika ada)">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Nama Lengkap Ibu Kandung</label>
                            <input type="text" name="nama_ibu" class="form-control"
                                   value="<?= old('nama_ibu', $penduduk['nama_ibu'] ?? '') ?>"
                                   placeholder="Nama ibu kandung sesuai KTP">
                        </div>
                    </div>
                </div>

                <!-- ============ TAB 4: KONTAK & LAINNYA ============ -->
                <div class="tab-pane fade" id="tab-kontak">
                    <div class="section-label">Data Kontak & Tambahan</div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">No. HP / WhatsApp</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-whatsapp text-success"></i></span>
                                <input type="text" name="no_hp" class="form-control"
                                       value="<?= old('no_hp', $penduduk['no_hp'] ?? '') ?>"
                                       placeholder="Contoh: 08123456789" maxlength="15">
                            </div>
                            <div class="form-text">Digunakan untuk notifikasi status surat.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email_penduduk" class="form-control"
                                       value="<?= old('email_penduduk', $penduduk['email_penduduk'] ?? '') ?>"
                                       placeholder="nama@email.com">
                            </div>
                        </div>

                        <div class="col-12 mt-2">
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_dtks" id="isDtks"
                                               <?= old('is_dtks') || ($penduduk['is_dtks'] ?? 0) ? 'checked' : '' ?>>
                                        <label class="form-check-label fw-semibold" for="isDtks">
                                            Terdaftar sebagai Penerima Bantuan Sosial (DTKS)
                                        </label>
                                    </div>
                                    <div class="form-text mt-1">
                                        Centang jika Anda terdaftar dalam Data Terpadu Kesejahteraan Sosial (DTKS) / penerima bansos dari pemerintah.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- end tab-content -->
        </div>

        <!-- FOOTER FORM -->
        <div class="card-footer bg-white border-top d-flex justify-content-between align-items-center">
            <span class="text-muted small">
                <i class="bi bi-shield-check me-1 text-success"></i>
                Data Anda tersimpan aman dan hanya digunakan untuk keperluan administrasi desa.
            </span>
            <button type="submit" class="btn btn-primary px-4 fw-semibold" id="btnSimpan">
                <i class="bi bi-floppy me-1"></i> Simpan Semua Perubahan
            </button>
        </div>
    </form>
</div>

<?php endif; ?>

<script>
// Pertahankan tab aktif setelah submit
document.addEventListener('DOMContentLoaded', function () {
    const savedTab = sessionStorage.getItem('profilActiveTab');
    if (savedTab) {
        const tabEl = document.querySelector(`[href="${savedTab}"]`);
        if (tabEl) new bootstrap.Tab(tabEl).show();
    }
    document.querySelectorAll('#profilTab .nav-link').forEach(tab => {
        tab.addEventListener('shown.bs.tab', e => {
            sessionStorage.setItem('profilActiveTab', e.target.getAttribute('href'));
        });
    });

    // Loading state saat submit
    document.getElementById('formProfil')?.addEventListener('submit', function () {
        const btn = document.getElementById('btnSimpan');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
    });
});
</script>

<?= $this->endSection() ?>
