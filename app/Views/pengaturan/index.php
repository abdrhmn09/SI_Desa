<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center gap-2 mb-3">
    <div>
        <h5 class="mb-0 fw-bold"><?= esc($title) ?></h5>
        <small class="text-muted">Atur identitas dan profil desa Anda</small>
    </div>
</div>

<form action="<?= site_url('pengaturan/update') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul class="mb-0 ps-3"><?php foreach (session()->getFlashdata('errors') as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul>
    </div>
    <?php endif; ?>

    <!-- Identitas Dasar -->
    <div class="card mb-3">
        <div class="card-header d-flex align-items-center gap-2">
            <i class="bi bi-building text-success"></i> Identitas Desa
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Desa <span class="text-danger">*</span></label>
                    <input type="text" name="nama_desa" class="form-control"
                        value="<?= old('nama_desa', $identitas['nama_desa'] ?? '') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kode Desa</label>
                    <input type="text" name="kode_desa" class="form-control"
                        value="<?= old('kode_desa', $identitas['kode_desa'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Kepala Desa</label>
                    <input type="text" name="nama_kepala_desa" class="form-control"
                        value="<?= old('nama_kepala_desa', $identitas['nama_kepala_desa'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">NIP Kepala Desa</label>
                    <input type="text" name="nip_kepala_desa" class="form-control"
                        value="<?= old('nip_kepala_desa', $identitas['nip_kepala_desa'] ?? '') ?>">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Alamat Kantor</label>
                    <textarea name="alamat_kantor" class="form-control" rows="2"><?= old('alamat_kantor', $identitas['alamat_kantor'] ?? '') ?></textarea>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Provinsi</label>
                    <input type="text" name="provinsi" class="form-control"
                        value="<?= old('provinsi', $identitas['provinsi'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Kabupaten/Kota</label>
                    <input type="text" name="kabupaten" class="form-control"
                        value="<?= old('kabupaten', $identitas['kabupaten'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Kecamatan</label>
                    <input type="text" name="kecamatan" class="form-control"
                        value="<?= old('kecamatan', $identitas['kecamatan'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Kode Pos</label>
                    <input type="text" name="kodepos" class="form-control" maxlength="10"
                        value="<?= old('kodepos', $identitas['kodepos'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Logo Desa (URL/Nama File)</label>
                    <input type="text" name="logo" class="form-control"
                        value="<?= old('logo', $identitas['logo'] ?? '') ?>"
                        placeholder="Nama file logo yang diupload...">
                </div>
            </div>
        </div>
    </div>

    <!-- Kontak -->
    <div class="card mb-3">
        <div class="card-header d-flex align-items-center gap-2">
            <i class="bi bi-telephone text-info"></i> Kontak & Media Sosial
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control"
                        value="<?= old('email', $identitas['email'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Telepon</label>
                    <input type="text" name="telepon" class="form-control"
                        value="<?= old('telepon', $identitas['telepon'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold"><i class="bi bi-facebook me-1 text-primary"></i>Facebook</label>
                    <input type="url" name="facebook" class="form-control"
                        value="<?= old('facebook', $identitas['facebook'] ?? '') ?>" placeholder="https://facebook.com/...">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold"><i class="bi bi-instagram me-1 text-danger"></i>Instagram</label>
                    <input type="url" name="instagram" class="form-control"
                        value="<?= old('instagram', $identitas['instagram'] ?? '') ?>" placeholder="https://instagram.com/...">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold"><i class="bi bi-youtube me-1 text-danger"></i>YouTube</label>
                    <input type="url" name="youtube" class="form-control"
                        value="<?= old('youtube', $identitas['youtube'] ?? '') ?>" placeholder="https://youtube.com/...">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold"><i class="bi bi-twitter-x me-1"></i>Twitter/X</label>
                    <input type="url" name="twitter" class="form-control"
                        value="<?= old('twitter', $identitas['twitter'] ?? '') ?>" placeholder="https://twitter.com/...">
                </div>
            </div>
        </div>
    </div>

    <!-- Profil Desa -->
    <div class="card mb-3">
        <div class="card-header d-flex align-items-center gap-2">
            <i class="bi bi-file-text text-warning"></i> Profil & Narasi Desa
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Sejarah Desa</label>
                    <textarea name="sejarah" class="form-control" rows="5"><?= old('sejarah', $identitas['sejarah'] ?? '') ?></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Visi & Misi</label>
                    <textarea name="visi_misi" class="form-control" rows="5"><?= old('visi_misi', $identitas['visi_misi'] ?? '') ?></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kondisi Geografis</label>
                    <textarea name="geografis" class="form-control" rows="4"><?= old('geografis', $identitas['geografis'] ?? '') ?></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kondisi Demografi</label>
                    <textarea name="demografi" class="form-control" rows="4"><?= old('demografi', $identitas['demografi'] ?? '') ?></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Embed Peta Google Maps</label>
                    <textarea name="embed_peta" class="form-control" rows="3"
                        placeholder="&lt;iframe src=&quot;...&quot;&gt;&lt;/iframe&gt;"><?= old('embed_peta', $identitas['embed_peta'] ?? '') ?></textarea>
                    <div class="form-text">Salin kode embed dari Google Maps.</div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-success btn-lg">
            <i class="bi bi-save me-1"></i> Simpan Pengaturan
        </button>
    </div>
</form>

<?= $this->endSection() ?>
