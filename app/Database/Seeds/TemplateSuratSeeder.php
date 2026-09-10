<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TemplateSuratSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $headerHtml = <<<HTML
<div style="position: relative; text-align: center; margin-bottom: 5px;">
    <img src="[logo_url]" style="position: absolute; left: 10px; top: 0; width: 75px; height: auto;">
    <div style="text-align: center; width: 100%;">
        <div style="font-size: 14pt; font-weight: bold; text-transform: uppercase;">PEMERINTAH KABUPATEN [kabupaten]</div>
        <div style="font-size: 14pt; font-weight: bold; text-transform: uppercase;">KECAMATAN [kecamatan]</div>
        <div style="font-size: 18pt; font-weight: bold; text-transform: uppercase; margin-top: 2px; margin-bottom: 2px;">GAMPONG [nama_desa]</div>
        <div style="font-size: 11pt; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px;">KEMUKIMAN BATEE KURENG</div>
    </div>
</div>
<hr style="border: none; border-top: 4px solid #000; margin-top: 8px; margin-bottom: 25px;">
HTML;

        // 1. Surat Keterangan Kurang Mampu / Miskin
        $skkmHtml = $headerHtml . <<<HTML
<div style="text-align: center; margin-bottom: 30px;">
    <h3 style="margin: 0; font-size: 14pt; font-weight: bold; text-decoration: underline; text-transform: uppercase;">SURAT KETERANGAN KURANG MAMPU/MISKIN</h3>
    <div style="font-size: 11pt; margin-top: 3px;">Nomor : [nomor_surat]</div>
</div>
<p style="text-indent: 40px; text-align: justify; line-height: 1.6; margin-bottom: 20px;">
    Keuchik Gampong [nama_desa] Kemukiman Batee Kureng Kecamatan [kecamatan] Kabupaten [kabupaten], dengan ini menerangkan bahwa :
</p>
<table style="width: 100%; margin-left: 40px; margin-bottom: 20px; line-height: 1.8; border-collapse: collapse;">
    <tr><td style="width: 180px;">Nama</td><td style="width: 15px;">:</td><td><strong>[nama]</strong></td></tr>
    <tr><td>NIK</td><td>:</td><td>[nik]</td></tr>
    <tr><td>Tempat / Tgl. lahir</td><td>:</td><td>[tempat_lahir], [tanggal_lahir]</td></tr>
    <tr><td>Jenis Kelamin</td><td>:</td><td>[jenis_kelamin]</td></tr>
    <tr><td>Pekerjaan</td><td>:</td><td>[pekerjaan]</td></tr>
    <tr><td style="vertical-align: top;">Alamat</td><td style="vertical-align: top;">:</td><td>Gampong [nama_desa]<br>Kecamatan [kecamatan] Kabupaten [kabupaten]</td></tr>
</table>
<p style="text-indent: 40px; text-align: justify; line-height: 1.6; margin-bottom: 20px;">
    Benar yang namanya tersebut diatas Adalah penduduk Gampong [nama_desa] Kemukiman Batee Kureng Kecamatan [kecamatan] Kabupaten [kabupaten], yang berkehidupan sosial ekonominya <strong>Kurang Mampu / Miskin</strong> .
</p>
<p style="text-indent: 40px; text-align: justify; line-height: 1.6; margin-bottom: 40px;">
    Demikianlah surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan seperlunya.
</p>
<div style="float: right; text-align: center; width: 280px; margin-top: 20px;">
    <div>[nama_desa], [tanggal_cetak]</div>
    <div style="margin-bottom: 70px;">Keuchiek Gampong [nama_desa]</div>
    <div><strong style="text-decoration: underline; text-transform: uppercase;">( [nama_kepala_desa] )</strong></div>
</div>
<div style="clear: both;"></div>
HTML;

        // 2. Surat Keterangan Usaha
        $skuHtml = $headerHtml . <<<HTML
<div style="text-align: center; margin-bottom: 30px;">
    <h3 style="margin: 0; font-size: 14pt; font-weight: bold; text-decoration: underline; text-transform: uppercase;">SURAT KETERANGAN USAHA</h3>
    <div style="font-size: 11pt; margin-top: 3px;">Nomor : [nomor_surat]</div>
</div>
<p style="text-indent: 40px; text-align: justify; line-height: 1.6; margin-bottom: 20px;">
    Keuchik Gampong [nama_desa] Kemukiman Batee Kureng Kecamatan [kecamatan] Kabupaten [kabupaten], dengan ini menerangkan bahwa :
</p>
<table style="width: 100%; margin-left: 40px; margin-bottom: 20px; line-height: 1.8; border-collapse: collapse;">
    <tr><td style="width: 180px;">Nama</td><td style="width: 15px;">:</td><td><strong>[nama]</strong></td></tr>
    <tr><td>NIK</td><td>:</td><td>[nik]</td></tr>
    <tr><td>Tempat/Tgl. Lahir</td><td>:</td><td>[tempat_lahir], [tanggal_lahir]</td></tr>
    <tr><td>Jenis Kelamin</td><td>:</td><td>[jenis_kelamin]</td></tr>
    <tr><td>Status Perkawinan</td><td>:</td><td>[status_kawin]</td></tr>
    <tr><td>Pekerjaan</td><td>:</td><td>[pekerjaan]</td></tr>
    <tr><td style="vertical-align: top;">Alamat</td><td style="vertical-align: top;">:</td><td>Gampong [nama_desa]<br>Kecamatan [kecamatan] Kabupaten [kabupaten]</td></tr>
</table>
<p style="text-indent: 40px; text-align: justify; line-height: 1.6; margin-bottom: 20px;">
    Benar yang tersebut namanya di atas adalah penduduk Gampong [nama_desa] Kemukiman Batee Kureng Kecamatan [kecamatan] Kabupaten [kabupaten], dan sepengetahuan kami ianya mempunyai Usaha di Bidang <strong>[bidang_usaha]</strong> yang sudah berjalan sejak tahun <strong>[tahun_mulai]</strong> sampai dengan sekarang.
</p>
<p style="text-indent: 40px; text-align: justify; line-height: 1.6; margin-bottom: 40px;">
    Demikianlah surat keterangan ini dibuat dengan sebenarnya agar dapat dipergunakan seperlunya.
</p>
<div style="float: right; text-align: center; width: 280px; margin-top: 20px;">
    <div>[nama_desa], [tanggal_cetak]</div>
    <div style="margin-bottom: 70px;">Keuchik Gampong [nama_desa]</div>
    <div><strong style="text-decoration: underline; text-transform: uppercase;">( [nama_kepala_desa] )</strong></div>
</div>
<div style="clear: both;"></div>
HTML;

        // 3. Surat Keterangan Kematian
        $skKematianHtml = $headerHtml . <<<HTML
<div style="text-align: center; margin-bottom: 30px;">
    <h3 style="margin: 0; font-size: 14pt; font-weight: bold; text-decoration: underline; text-transform: uppercase;">SURAT KETERANGAN KEMATIAN</h3>
    <div style="font-size: 11pt; margin-top: 3px;">Nomor : [nomor_surat]</div>
</div>
<p style="text-indent: 40px; text-align: justify; line-height: 1.6; margin-bottom: 20px;">
    Keuchik Gampong [nama_desa] Kemukiman Batee Kureng Kecamatan [kecamatan] Kabupaten [kabupaten] dengan ini menerangkan bahwa :
</p>
<table style="width: 100%; margin-left: 40px; margin-bottom: 20px; line-height: 1.8; border-collapse: collapse;">
    <tr><td style="width: 180px;">Nama</td><td style="width: 15px;">:</td><td><strong>[nama]</strong></td></tr>
    <tr><td>NIK</td><td>:</td><td>[nik]</td></tr>
    <tr><td>Tempat/ Tgl. Lahir</td><td>:</td><td>[tempat_lahir], [tanggal_lahir]</td></tr>
    <tr><td>Jenis Kelamin</td><td>:</td><td>[jenis_kelamin]</td></tr>
    <tr><td>Pekerjaan</td><td>:</td><td>[pekerjaan]</td></tr>
    <tr><td style="vertical-align: top;">Alamat</td><td style="vertical-align: top;">:</td><td>Gampong [nama_desa]<br>Kecamatan [kecamatan] Kabupaten [kabupaten]</td></tr>
</table>
<p style="text-indent: 40px; text-align: justify; line-height: 1.6; margin-bottom: 20px;">
    Benar yang tersebut namanya di atas adalah penduduk Gampong [nama_desa] Kemukiman Batee Kureng Kecamatan [kecamatan] Kabupaten [kabupaten] dan menurut sepengetahuan kami telah meninggal dunia pada :
</p>
<table style="width: 100%; margin-left: 40px; margin-bottom: 20px; line-height: 1.8; border-collapse: collapse;">
    <tr><td style="width: 180px;">Hari / Tanggal</td><td style="width: 15px;">:</td><td><strong>[waktu_meninggal]</strong></td></tr>
    <tr><td>Tempat</td><td>:</td><td>[tempat_meninggal]</td></tr>
    <tr><td>Dikebumikan</td><td>:</td><td>[lokasi_makam]</td></tr>
</table>
<p style="text-indent: 40px; text-align: justify; line-height: 1.6; margin-bottom: 40px;">
    Demikian surat keterangan meninggal ini dibuat dengan sebenarnya untuk dapat dipergunakan seperlunya.
</p>
<div style="float: right; text-align: center; width: 280px; margin-top: 20px;">
    <div>[nama_desa], [tanggal_cetak]</div>
    <div style="margin-bottom: 70px;">Keuchik Gampong [nama_desa]</div>
    <div><strong style="text-decoration: underline; text-transform: uppercase;">( [nama_kepala_desa] )</strong></div>
</div>
<div style="clear: both;"></div>
HTML;

        // 4. Surat Keterangan Penduduk
        $skpHtml = $headerHtml . <<<HTML
<div style="text-align: center; margin-bottom: 30px;">
    <h3 style="margin: 0; font-size: 14pt; font-weight: bold; text-decoration: underline; text-transform: uppercase;">SURAT KETERANGAN PENDUDUK</h3>
    <div style="font-size: 11pt; margin-top: 3px;">Nomor : [nomor_surat]</div>
</div>
<p style="text-indent: 40px; text-align: justify; line-height: 1.6; margin-bottom: 20px;">
    Keuchiek Gampong [nama_desa] Kemukiman Batee Kureng Kecamatan [kecamatan] Kabupaten [kabupaten], dengan ini menerangkan bahwa :
</p>
<table style="width: 100%; margin-left: 40px; margin-bottom: 20px; line-height: 1.8; border-collapse: collapse;">
    <tr><td style="width: 180px;">Nama</td><td style="width: 15px;">:</td><td><strong>[nama]</strong></td></tr>
    <tr><td>NIK</td><td>:</td><td>[nik]</td></tr>
    <tr><td>Tempat / Tgl. Lahir</td><td>:</td><td>[tempat_lahir], [tanggal_lahir]</td></tr>
    <tr><td>Jenis Kelamin</td><td>:</td><td>[jenis_kelamin]</td></tr>
    <tr><td>Status Perkawinan</td><td>:</td><td>[status_kawin]</td></tr>
    <tr><td>Agama</td><td>:</td><td>[agama]</td></tr>
    <tr><td>Pekerjaan</td><td>:</td><td>[pekerjaan]</td></tr>
    <tr><td style="vertical-align: top;">Alamat</td><td style="vertical-align: top;">:</td><td>Gampong [nama_desa]<br>Kecamatan [kecamatan] Kabupaten [kabupaten]</td></tr>
</table>
<p style="text-indent: 40px; text-align: justify; line-height: 1.6; margin-bottom: 20px;">
    Benar yang tersebut namanya di atas adalah penduduk Gampong [nama_desa] Kemukiman Batee Kureng Kecamatan [kecamatan] Kabupaten [kabupaten]. surat ini diberikan sebagai pengganti Kartu Tanda Penduduk ( KTP ) yang sedang dalam proses pembuatan.
</p>
<p style="text-indent: 40px; text-align: justify; line-height: 1.6; margin-bottom: 40px;">
    Demikianlah surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan seperlunya.
</p>
<div style="float: right; text-align: center; width: 280px; margin-top: 20px;">
    <div>[nama_desa], [tanggal_cetak]</div>
    <div style="margin-bottom: 70px;">Keuchiek Gampong [nama_desa]</div>
    <div><strong style="text-decoration: underline; text-transform: uppercase;">( [nama_kepala_desa] )</strong></div>
</div>
<div style="clear: both;"></div>
HTML;

        // 5. Surat Keterangan Janda
        $skJandaHtml = $headerHtml . <<<HTML
<div style="text-align: center; margin-bottom: 30px;">
    <h3 style="margin: 0; font-size: 14pt; font-weight: bold; text-decoration: underline; text-transform: uppercase;">SURAT KETERANGAN JANDA</h3>
    <div style="font-size: 11pt; margin-top: 3px;">Nomor : [nomor_surat]</div>
</div>
<p style="text-indent: 40px; text-align: justify; line-height: 1.6; margin-bottom: 20px;">
    Geuchiek Gampong [nama_desa] Kemukiman Bate Kureung Kecamatan [kecamatan] Kabupaten [kabupaten], dengan ini menerangkan bahwa :
</p>
<table style="width: 100%; margin-left: 40px; margin-bottom: 20px; line-height: 1.8; border-collapse: collapse;">
    <tr><td style="width: 180px;">Nama</td><td style="width: 15px;">:</td><td><strong>[nama]</strong></td></tr>
    <tr><td>Tempat/Tgl Lahir</td><td>:</td><td>[tempat_lahir] / [tanggal_lahir]</td></tr>
    <tr><td>Agama</td><td>:</td><td>[agama]</td></tr>
    <tr><td>Pekerjaan</td><td>:</td><td>[pekerjaan]</td></tr>
    <tr><td style="vertical-align: top;">Alamat</td><td style="vertical-align: top;">:</td><td>Gampong [nama_desa]<br>Kecamatan [kecamatan] Kabupaten [kabupaten]</td></tr>
</table>
<p style="text-indent: 40px; text-align: justify; line-height: 1.6; margin-bottom: 20px;">
    Benar yang tersebut namanya di atas adalah penduduk Gampong [nama_desa] Kemukiman Bate Kureung Kecamatan [kecamatan] Kabupaten [kabupaten], dan sampai saat dikeluarkan surat keterangan ini yang besangkutan masih berstatus Janda .
</p>
<p style="text-indent: 40px; text-align: justify; line-height: 1.6; margin-bottom: 40px;">
    Demikianlah surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan seperlunya.
</p>
<div style="float: right; text-align: center; width: 280px; margin-top: 20px;">
    <div>[nama_desa], [tanggal_cetak]</div>
    <div style="margin-bottom: 70px;">Keuchiek Gampong [nama_desa]</div>
    <div><strong style="text-decoration: underline; text-transform: uppercase;">( [nama_kepala_desa] )</strong></div>
</div>
<div style="clear: both;"></div>
HTML;

        // 6. Surat Keterangan Domisili
        $skdHtml = $headerHtml . <<<HTML
<div style="text-align: center; margin-bottom: 30px;">
    <h3 style="margin: 0; font-size: 14pt; font-weight: bold; text-decoration: underline; text-transform: uppercase;">SURAT KETERANGAN DOMISILI</h3>
    <div style="font-size: 11pt; margin-top: 3px;">Nomor : [nomor_surat]</div>
</div>
<p style="text-indent: 40px; text-align: justify; line-height: 1.6; margin-bottom: 20px;">
    Keuchiek Gampong [nama_desa] Kemukiman Batee Kureng Kecamatan [kecamatan] Kabupaten [kabupaten], dengan ini menerangkan bahwa :
</p>
<table style="width: 100%; margin-left: 40px; margin-bottom: 20px; line-height: 1.8; border-collapse: collapse;">
    <tr><td style="width: 180px;">Nama</td><td style="width: 15px;">:</td><td><strong>[nama]</strong></td></tr>
    <tr><td>Tempat / Tgl. Lahir</td><td>:</td><td>[tempat_lahir], [tanggal_lahir]</td></tr>
    <tr><td>Jenis Kelamin</td><td>:</td><td>[jenis_kelamin]</td></tr>
    <tr><td>Agama</td><td>:</td><td>[agama]</td></tr>
    <tr><td>Pekerjaan</td><td>:</td><td>[pekerjaan]</td></tr>
    <tr><td style="vertical-align: top;">Alamat</td><td style="vertical-align: top;">:</td><td>Gampong [nama_desa]<br>Kecamatan [kecamatan] Kabupaten [kabupaten]</td></tr>
</table>
<p style="text-indent: 40px; text-align: justify; line-height: 1.6; margin-bottom: 20px;">
    Benar yang tersebut namanya di atas sampai dengan saat ini yang bersangkutan masih berdomisili / menetap di Gampong [nama_desa] Kec. [kecamatan].
</p>
<p style="text-indent: 40px; text-align: justify; line-height: 1.6; margin-bottom: 40px;">
    Demikianlah surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan seperlunya.
</p>
<div style="float: right; text-align: center; width: 280px; margin-top: 20px;">
    <div>[nama_desa], [tanggal_cetak]</div>
    <div style="margin-bottom: 70px;">Keuchiek Gampong [nama_desa]</div>
    <div><strong style="text-decoration: underline; text-transform: uppercase;">( [nama_kepala_desa] )</strong></div>
</div>
<div style="clear: both;"></div>
HTML;

        // 7. Surat Keterangan Anak Yatim
        $skYatimHtml = $headerHtml . <<<HTML
<div style="text-align: center; margin-bottom: 30px;">
    <h3 style="margin: 0; font-size: 14pt; font-weight: bold; text-decoration: underline; text-transform: uppercase;">SURAT KETERANGAN ANAK YATIM</h3>
    <div style="font-size: 11pt; margin-top: 3px;">Nomor : [nomor_surat]</div>
</div>
<p style="text-indent: 40px; text-align: justify; line-height: 1.6; margin-bottom: 20px;">
    Keuchik Gampong [nama_desa] Kemukiman Batee Kureng Kecamatan [kecamatan] Kabupaten [kabupaten], dengan ini menerangkan bahwa :
</p>
<table style="width: 100%; margin-left: 40px; margin-bottom: 20px; line-height: 1.8; border-collapse: collapse;">
    <tr><td style="width: 180px;">Nama</td><td style="width: 15px;">:</td><td><strong>[nama]</strong></td></tr>
    <tr><td>Tempat / Tgl. lahir</td><td>:</td><td>[tempat_lahir], [tanggal_lahir]</td></tr>
    <tr><td>Jenis Kelamin</td><td>:</td><td>[jenis_kelamin]</td></tr>
    <tr><td style="vertical-align: top;">Alamat</td><td style="vertical-align: top;">:</td><td>Gampong [nama_desa]<br>Kecamatan [kecamatan] Kabupaten [kabupaten]</td></tr>
    <tr><td>Nama Ayah (Alm)</td><td>:</td><td>[nama_ayah]</td></tr>
    <tr><td>Nama Ibu</td><td>:</td><td>[nama_ibu]</td></tr>
</table>
<p style="text-indent: 40px; text-align: justify; line-height: 1.6; margin-bottom: 20px;">
    Benar yang namanya tersebut diatas adalah penduduk Gampong [nama_desa] Kemukiman Batee Kureng Kecamatan [kecamatan] Kabupaten [kabupaten], dan ianya benar seorang <strong>Anak Yatim</strong>.
</p>
<p style="text-indent: 40px; text-align: justify; line-height: 1.6; margin-bottom: 40px;">
    Demikianlah surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan seperlunya.
</p>
<div style="float: right; text-align: center; width: 280px; margin-top: 20px;">
    <div>[nama_desa], [tanggal_cetak]</div>
    <div style="margin-bottom: 70px;">Keuchik Gampong [nama_desa]</div>
    <div><strong style="text-decoration: underline; text-transform: uppercase;">( [nama_kepala_desa] )</strong></div>
</div>
<div style="clear: both;"></div>
HTML;

        // 8. Surat Keterangan Kehilangan
        $skKehilanganHtml = $headerHtml . <<<HTML
<div style="text-align: center; margin-bottom: 30px;">
    <h3 style="margin: 0; font-size: 14pt; font-weight: bold; text-decoration: underline; text-transform: uppercase;">SURAT KETERANGAN KEHILANGAN</h3>
    <div style="font-size: 11pt; margin-top: 3px;">Nomor : [nomor_surat]</div>
</div>
<p style="text-indent: 40px; text-align: justify; line-height: 1.6; margin-bottom: 20px;">
    Keuchik Gampong [nama_desa] Kemukiman Batee Kureng Kecamatan [kecamatan] Kabupaten [kabupaten], dengan ini menerangkan bahwa :
</p>
<table style="width: 100%; margin-left: 40px; margin-bottom: 20px; line-height: 1.8; border-collapse: collapse;">
    <tr><td style="width: 180px;">Nama</td><td style="width: 15px;">:</td><td><strong>[nama]</strong></td></tr>
    <tr><td>NIK</td><td>:</td><td>[nik]</td></tr>
    <tr><td>Tempat / Tgl. lahir</td><td>:</td><td>[tempat_lahir], [tanggal_lahir]</td></tr>
    <tr><td>Pekerjaan</td><td>:</td><td>[pekerjaan]</td></tr>
    <tr><td style="vertical-align: top;">Alamat</td><td style="vertical-align: top;">:</td><td>Gampong [nama_desa]<br>Kecamatan [kecamatan] Kabupaten [kabupaten]</td></tr>
</table>
<p style="text-indent: 40px; text-align: justify; line-height: 1.6; margin-bottom: 20px;">
    Berdasarkan laporan dari yang bersangkutan, ianya telah kehilangan <strong>[barang_hilang]</strong>. Surat keterangan ini kami keluarkan sebagai persyaratan untuk mengurus kembali berkas/barang yang hilang tersebut.
</p>
<p style="text-indent: 40px; text-align: justify; line-height: 1.6; margin-bottom: 40px;">
    Demikianlah surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan seperlunya.
</p>
<div style="float: right; text-align: center; width: 280px; margin-top: 20px;">
    <div>[nama_desa], [tanggal_cetak]</div>
    <div style="margin-bottom: 70px;">Keuchik Gampong [nama_desa]</div>
    <div><strong style="text-decoration: underline; text-transform: uppercase;">( [nama_kepala_desa] )</strong></div>
</div>
<div style="clear: both;"></div>
HTML;

        // 9. Surat Keterangan Belum Pernah Menikah
        $skBelumMenikahHtml = $headerHtml . <<<HTML
<div style="text-align: center; margin-bottom: 30px;">
    <h3 style="margin: 0; font-size: 14pt; font-weight: bold; text-decoration: underline; text-transform: uppercase;">SURAT KETERANGAN BELUM PERNAH MENIKAH</h3>
    <div style="font-size: 11pt; margin-top: 3px;">Nomor : [nomor_surat]</div>
</div>
<p style="text-indent: 40px; text-align: justify; line-height: 1.6; margin-bottom: 20px;">
    Keuchik Gampong [nama_desa] Kemukiman Batee Kureng Kecamatan [kecamatan] Kabupaten [kabupaten], dengan ini menerangkan bahwa :
</p>
<table style="width: 100%; margin-left: 40px; margin-bottom: 20px; line-height: 1.8; border-collapse: collapse;">
    <tr><td style="width: 180px;">Nama</td><td style="width: 15px;">:</td><td><strong>[nama]</strong></td></tr>
    <tr><td>NIK</td><td>:</td><td>[nik]</td></tr>
    <tr><td>Tempat / Tgl. lahir</td><td>:</td><td>[tempat_lahir], [tanggal_lahir]</td></tr>
    <tr><td>Agama</td><td>:</td><td>[agama]</td></tr>
    <tr><td>Pekerjaan</td><td>:</td><td>[pekerjaan]</td></tr>
    <tr><td style="vertical-align: top;">Alamat</td><td style="vertical-align: top;">:</td><td>Gampong [nama_desa]<br>Kecamatan [kecamatan] Kabupaten [kabupaten]</td></tr>
</table>
<p style="text-indent: 40px; text-align: justify; line-height: 1.6; margin-bottom: 20px;">
    Benar yang namanya tersebut diatas adalah penduduk Gampong [nama_desa] Kemukiman Batee Kureng Kecamatan [kecamatan] Kabupaten [kabupaten]. Sepengetahuan kami hingga surat keterangan ini dikeluarkan, yang bersangkutan <strong>belum pernah menikah</strong> dengan siapapun.
</p>
<p style="text-indent: 40px; text-align: justify; line-height: 1.6; margin-bottom: 40px;">
    Demikianlah surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan seperlunya.
</p>
<div style="float: right; text-align: center; width: 280px; margin-top: 20px;">
    <div>[nama_desa], [tanggal_cetak]</div>
    <div style="margin-bottom: 70px;">Keuchik Gampong [nama_desa]</div>
    <div><strong style="text-decoration: underline; text-transform: uppercase;">( [nama_kepala_desa] )</strong></div>
</div>
<div style="clear: both;"></div>
HTML;

        // -- DAFTAR INSERT DATABASE -- //
        $templates = [
            [
                'kode_surat'       => 'SKKM',
                'kode_klasifikasi' => '2010',
                'format_nomor'     => '[NO_URUT] / BLKB / [KODE_KLASIFIKASI] / [BULAN] / [TAHUN]', 
                'nama_surat'       => 'Surat Keterangan Kurang Mampu/Miskin',
                'template_surat'   => $skkmHtml,
                'form_fields'      => json_encode([]),
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'kode_surat'       => 'SKAY',
                'kode_klasifikasi' => '2010',
                'format_nomor'     => '[NO_URUT] / BLKB / [KODE_KLASIFIKASI] / [BULAN] / [TAHUN]', 
                'nama_surat'       => 'Surat Keterangan Anak Yatim',
                'template_surat'   => $skYatimHtml,
                'form_fields'      => json_encode([]),
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'kode_surat'       => 'SKK',
                'kode_klasifikasi' => '2010',
                'format_nomor'     => '[NO_URUT] / [KODE_KLASIFIKASI] / BLKB / [BULAN] / [TAHUN]', 
                'nama_surat'       => 'Surat Keterangan Kehilangan',
                'template_surat'   => $skKehilanganHtml,
                'form_fields'      => json_encode([
                    [
                        'name'        => 'barang_hilang',
                        'label'       => 'Barang / Dokumen yang Hilang',
                        'type'        => 'text',
                        'required'    => true,
                        'placeholder' => 'Contoh: KTP dan STNK'
                    ]
                ]),
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'kode_surat'       => 'SKBPM',
                'kode_klasifikasi' => '2010',
                'format_nomor'     => '[NO_URUT] / BLKB / [KODE_KLASIFIKASI] / [BULAN] / [TAHUN]', 
                'nama_surat'       => 'Surat Keterangan Belum Pernah Menikah',
                'template_surat'   => $skBelumMenikahHtml,
                'form_fields'      => json_encode([]),
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'kode_surat'       => 'SKD',
                'kode_klasifikasi' => '2032',
                'format_nomor'     => '[NO_URUT] / BLKB / [KODE_KLASIFIKASI] / [BULAN] / [TAHUN]', 
                'nama_surat'       => 'Surat Keterangan Domisili',
                'template_surat'   => $skdHtml,
                'form_fields'      => json_encode([]),
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'kode_surat'       => 'SKJ',
                'kode_klasifikasi' => '2032',
                'format_nomor'     => '[NO_URUT] / BLKB / [KODE_KLASIFIKASI] / [BULAN] / [TAHUN]', 
                'nama_surat'       => 'Surat Keterangan Janda',
                'template_surat'   => $skJandaHtml,
                'form_fields'      => json_encode([]),
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'kode_surat'       => 'SKP',
                'kode_klasifikasi' => '2032',
                'format_nomor'     => '[NO_URUT] / BLKB / [KODE_KLASIFIKASI] / [BULAN] / [TAHUN]', 
                'nama_surat'       => 'Surat Keterangan Penduduk',
                'template_surat'   => $skpHtml,
                'form_fields'      => json_encode([]),
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'kode_surat'       => 'SKM',
                'kode_klasifikasi' => '2010',
                'format_nomor'     => '[NO_URUT] / [KODE_KLASIFIKASI] / BLKB / [BULAN] / [TAHUN]', 
                'nama_surat'       => 'Surat Keterangan Kematian',
                'template_surat'   => $skKematianHtml,
                'form_fields'      => json_encode([
                    [
                        'name'        => 'waktu_meninggal',
                        'label'       => 'Hari / Tanggal Meninggal',
                        'type'        => 'text',
                        'required'    => true,
                        'placeholder' => 'Contoh: Rabu, 23 November 2022'
                    ],
                    [
                        'name'        => 'tempat_meninggal',
                        'label'       => 'Tempat Meninggal',
                        'type'        => 'text',
                        'required'    => true,
                        'placeholder' => 'Contoh: Dusun Kuta Harapan Gampong Blang Kubu'
                    ],
                    [
                        'name'        => 'lokasi_makam',
                        'label'       => 'Dikebumikan Di',
                        'type'        => 'text',
                        'required'    => true,
                        'placeholder' => 'Contoh: Pemakaman Umum Gampong Blang Kubu Kec. Peudada'
                    ]
                ]),
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'kode_surat'       => 'SKU',
                'kode_klasifikasi' => '2010',
                'format_nomor'     => '[NO_URUT] / BLKB / [KODE_KLASIFIKASI] / [BULAN] / [TAHUN]',
                'nama_surat'       => 'Surat Keterangan Usaha',
                'template_surat'   => $skuHtml,
                'form_fields'      => json_encode([
                    [
                        'name'        => 'bidang_usaha',
                        'label'       => 'Bidang Usaha',
                        'type'        => 'text',
                        'required'    => true,
                        'placeholder' => 'Contoh: Jual Beli Ikan dan Usaha Boat ikan'
                    ],
                    [
                        'name'        => 'tahun_mulai',
                        'label'       => 'Tahun Mulai Beroperasi',
                        'type'        => 'number',
                        'required'    => true,
                        'placeholder' => 'Contoh: 2017'
                    ]
                ]),
                'created_at'       => $now,
                'updated_at'       => $now,
            ]
        ];

        $db = \Config\Database::connect();
        $builder = $db->table('jenis_surat');

        foreach ($templates as $t) {
            $existing = $builder->where('kode_surat', $t['kode_surat'])->get()->getRowArray();
            if ($existing) {
                $builder->where('id', $existing['id'])->update($t);
            } else {
                $builder->insert($t);
            }
        }
    }
}