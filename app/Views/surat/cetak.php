<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Surat</title>
    <style>
        /* Pengaturan Kertas Ukuran A4 / F4 standar Balai Desa */
        @page {
            size: A4;
            margin: 2cm 2.5cm; /* Margin atas, bawah, kiri, kanan */
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }
        /* Mode Layar (Saat dilihat di browser sebelum print) */
        @media screen {
            body {
                max-width: 21cm; /* Lebar A4 */
                margin: 2cm auto;
                padding: 2cm 2.5cm;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
            }
        }
        /* Utility Classes yang mungkin dipakai admin di TinyMCE */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .fw-bold { font-weight: bold; }
        .mt-5 { margin-top: 3rem; }
        table { width: 100%; border-collapse: collapse; }
    </style>
</head>
<body onload="window.print()">

    <?= $html_surat ?>

</body>
</html>