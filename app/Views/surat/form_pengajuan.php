<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <a href="<?= site_url('surat/pilih') ?>" class="btn btn-sm btn-light mb-3">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <h4 class="fw-bold text-primary">Pengajuan <?= esc($jenis['nama_surat']) ?></h4>
            </div>
            
            <div class="card-body p-4">
                <div class="alert alert-info border-0 d-flex align-items-center mb-4">
                    <i class="bi bi-info-circle-fill fs-4 me-3"></i>
                    <div class="small">
                        Data identitas diri Anda (Nama, NIK, Tempat/Tgl Lahir, dll) akan ditarik secara otomatis oleh sistem. Silakan isi form rincian keperluan di bawah ini.
                    </div>
                </div>

                <form action="<?= site_url('surat/submit/' . $jenis['id']) ?>" method="post">
                    <?= csrf_field() ?>

                    <?php 
                        // Decode JSON dari database menjadi Array PHP
                        $fields = json_decode($jenis['form_fields'], true); 
                        if ($fields):
                            foreach ($fields as $field): 
                    ?>
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><?= esc($field['label']) ?> <span class="text-danger">*</span></label>
                            
                            <?php if($field['type'] == 'textarea'): ?>
                                <textarea name="isian[<?= esc($field['name']) ?>]" class="form-control" rows="3" required></textarea>
                            <?php else: ?>
                                <input type="<?= esc($field['type']) ?>" name="isian[<?= esc($field['name']) ?>]" class="form-control" required>
                            <?php endif; ?>
                        </div>
                    <?php 
                            endforeach; 
                        else:
                    ?>
                        <p class="text-muted fst-italic">Tidak ada isian tambahan yang diperlukan untuk surat ini.</p>
                    <?php endif; ?>

                    <hr class="my-4">
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                        <i class="bi bi-send me-1"></i> Ajukan Surat Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>