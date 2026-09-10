<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Surat</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        html, body {
            width: 210mm;
            min-height: 297mm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            background-color: #fff;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        @media screen {
            body {
                max-width: 21cm;
                margin: 2cm auto;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
                background: #eee;
            }
            .print-sheet {
                margin: 2cm auto;
            }
        }
        @media print {
            .print-sheet {
                box-shadow: none;
                margin: 0;
            }
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .fw-bold { font-weight: bold; }
        .mt-5 { margin-top: 3rem; }
        table { width: 100%; border-collapse: collapse; }
        .print-sheet {
            width: 210mm;
            min-height: 297mm;
            background: #fff;
            padding: 2.5cm 2cm 2cm 2.5cm;
            box-sizing: border-box;
        }
    </style>
</head>
<body onload="window.print()">
    <div class="print-sheet">
        <?= $html_surat ?>
    </div>

</body>
</html>