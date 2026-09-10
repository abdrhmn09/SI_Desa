<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Surat — <?= esc($nomorSurat) ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; color: #000; background: #f5f5f5; }
        .page { width: 210mm; min-height: 297mm; margin: 0 auto; background: #fff; padding: 20mm 25mm; position: relative; }
        .header { display: flex; align-items: center; border-bottom: 3px solid #000; padding-bottom: 8px; margin-bottom: 15px; gap: 15px; }
        .header .logo { width: 70px; height: 70px; border: 1px solid #ccc; display: flex; align-items: center; justify-content: center; font-size: 9pt; color: #666; }
        .header .kop { flex: 1; text-align: center; }
        .header .kop h2 { font-size: 14pt; text-transform: uppercase; margin-bottom: 2px; }
        .header .kop h3 { font-size: 16pt; font-weight: 900; text-transform: uppercase; margin-bottom: 2px; }
        .header .kop p { font-size: 9pt; }
        .judul { text-align: center; margin: 20px 0 5px; }
        .judul h4 { font-size: 13pt; text-transform: uppercase; font-weight: bold; text-decoration: underline; }
        .nomor { text-align: center; font-size: 11pt; margin-bottom: 20px; }
        .pembuka { margin-bottom: 20px; line-height: 1.8; }
        table.data { width: 100%; border-collapse: collapse; margin: 15px 0; }
        table.data td { padding: 4px 8px; vertical-align: top; }
        table.data td:first-child { width: 35%; }
        table.data td:nth-child(2) { width: 5%; text-align: center; }
        .penutup { margin: 20px 0; line-height: 1.8; }
        .ttd { display: flex; justify-content: flex-end; margin-top: 30px; }
        .ttd-box { text-align: center; width: 250px; }
        .ttd-box .ruang { height: 80px; }
        .footer-note { margin-top: 40px; font-size: 9pt; color: #666; border-top: 1px solid #ccc; padding-top: 8px; }
        @media print {
            body { background: none; }
            .page { margin: 0; box-shadow: none; padding: 15mm 20mm; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
<div class="no-print" style="background:#1a4731;color:#fff;padding:10px 20px;display:flex;align-items:center;gap:12px;">
    <span style="font-weight:bold">📄 Preview Surat — Siap Cetak</span>
    <button onclick="window.print()" style="margin-left:auto;padding:6px 18px;background:#fff;color:#1a4731;border:none;border-radius:4px;font-weight:bold;cursor:pointer">🖨️ Cetak</button>
    <a href="<?= site_url('surat/pilih') ?>" style="padding:6px 18px;background:rgba(255,255,255,.2);color:#fff;border-radius:4px;text-decoration:none;font-size:.9rem">← Kembali</a>
</div>

<div class="page">
    <div class="header">
        <div class="logo">LOGO</div>
        <div class="kop">
            <h2>Pemerintah Desa</h2>
            <h3><?= esc($jenisSurat['nama_surat'] ?? 'Surat Keterangan') ?></h3>
            <p>Kec. — Kab. — Prov. Indonesia</p>
            <p>Email: desa@desa.id | Telp: —</p>
        </div>
    </div>

    <div class="judul">
        <h4><?= esc($jenisSurat['nama_surat'] ?? 'Surat Keterangan') ?></h4>
    </div>
    <div class="nomor">Nomor: <?= esc($nomorSurat) ?></div>

    <div class="pembuka">
        <p>Yang bertanda tangan di bawah ini, Kepala Desa, menerangkan bahwa:</p>
    </div>

    <table class="data">
        <tr><td>Nama Lengkap</td><td>:</td><td><strong><?= esc($penduduk['nama_lengkap']) ?></strong></td></tr>
        <tr><td>NIK</td><td>:</td><td><?= esc($penduduk['nik']) ?></td></tr>
        <tr><td>Tempat / Tgl Lahir</td><td>:</td><td><?= esc($penduduk['tempat_lahir'] ?? '-') ?>, <?= esc($penduduk['tanggal_lahir'] ?? '-') ?></td></tr>
        <tr><td>Jenis Kelamin</td><td>:</td><td><?= esc($penduduk['jenis_kelamin'] ?? '-') ?></td></tr>
        <tr><td>Agama</td><td>:</td><td><?= esc($penduduk['agama'] ?? '-') ?></td></tr>
        <tr><td>Pekerjaan</td><td>:</td><td><?= esc($penduduk['pekerjaan'] ?? '-') ?></td></tr>
        <tr><td>Status Kawin</td><td>:</td><td><?= esc($penduduk['status_kawin'] ?? '-') ?></td></tr>
    </table>

    <div class="penutup">
        <p>adalah benar warga kami yang berdomisili di wilayah desa ini dan berkelakuan baik serta tidak pernah tersangkut perkara kriminal apapun.</p>
        <br>
        <p>Surat keterangan ini dibuat atas permintaan yang bersangkutan untuk digunakan sebagaimana mestinya.</p>
    </div>

    <div class="ttd">
        <div class="ttd-box">
            <p>Dikeluarkan di: Desa</p>
            <p>Tanggal: <?= esc($tanggalCetak) ?></p>
            <br>
            <p>Kepala Desa,</p>
            <div class="ruang"></div>
            <p><strong>________________________</strong></p>
        </div>
    </div>

    <?php 
        $identitasModel = new \App\Models\IdentitasDesaModel();
        $identitasApp = $identitasModel->getIdentitas();
        $namaDesaApp = !empty($identitasApp['nama_desa']) ? $identitasApp['nama_desa'] : 'Pemerintah Desa';
    ?>
    <div class="footer-note">
        Dokumen ini diterbitkan secara digital oleh <?= esc($namaDesaApp) ?>. No. Surat: <?= esc($nomorSurat) ?>
    </div>
</div>
</body>
</html>
