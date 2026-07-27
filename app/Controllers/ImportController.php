<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PendudukModel;
use App\Models\KartuKeluargaModel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ImportController extends BaseController
{
    protected PendudukModel $pendudukModel;
    protected KartuKeluargaModel $kkModel;

    public function __construct()
    {
        $this->pendudukModel = new PendudukModel();
        $this->kkModel       = new KartuKeluargaModel();
    }

    // ===================================================================
    // HALAMAN UTAMA IMPORT
    // ===================================================================
    public function index()
    {
        return view('import/index', [
            'title'                  => 'Import Data Excel',
            'totalPenduduk'          => $this->pendudukModel->countAllResults(),
            'totalKK'                => $this->kkModel->countAllResults(),
            'totalPendudukTanpaKK'   => $this->pendudukModel->where('kartu_keluarga_id', null)->countAllResults(),
        ]);
    }

    // ===================================================================
    // TEMPLATE DOWNLOAD
    // ===================================================================

    /**
     * Download template Excel untuk data Penduduk
     */
    public function templatePenduduk()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Penduduk');

        // Header baris 1 - judul
        $sheet->mergeCells('A1:K1');
        $sheet->setCellValue('A1', 'TEMPLATE IMPORT DATA PENDUDUK - SI DESA');
        $sheet->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 13, 'color' => ['rgb' => 'FFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '1E40AF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Header baris 2 - instruksi
        $sheet->mergeCells('A2:K2');
        $sheet->setCellValue('A2', 'Petunjuk: Isi data mulai baris ke-4. Jangan ubah/hapus baris header. NIK harus 16 digit angka. No KK harus sudah terdaftar di sistem.');
        $sheet->getStyle('A2')->applyFromArray([
            'font'      => ['italic' => true, 'size' => 9, 'color' => ['rgb' => '92400E']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'FEF3C7']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'wrapText' => true],
        ]);
        $sheet->getRowDimension(2)->setRowHeight(30);

        // Header kolom
        $headers = ['NIK (16 digit)*', 'Nama Lengkap*', 'No KK', 'Hubungan Keluarga', 'Tempat Lahir', 'Tanggal Lahir (YYYY-MM-DD)', 'Jenis Kelamin', 'Agama', 'Pendidikan', 'Pekerjaan', 'Status Kawin'];
        $cols = ['A','B','C','D','E','F','G','H','I','J','K'];

        foreach ($headers as $i => $header) {
            $sheet->setCellValue($cols[$i].'3', $header);
        }
        $sheet->getStyle('A3:K3')->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '2563EB']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'wrapText' => true],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CBD5E1']]],
        ]);
        $sheet->getRowDimension(3)->setRowHeight(35);

        // Contoh data
        $contoh = [
            ['3578010101900001', 'Budi Santoso', '3578010101000001', 'Kepala Keluarga', 'Surabaya', '1990-01-01', 'Laki-laki', 'Islam', 'SMA/Sederajat', 'Petani', 'Kawin'],
            ['3578010101950002', 'Siti Aminah', '3578010101000001', 'Istri', 'Surabaya', '1995-05-12', 'Perempuan', 'Islam', 'SMA/Sederajat', 'Ibu Rumah Tangga', 'Kawin'],
            ['3578010101200003', 'Ahmad Fauzi', '3578010101000001', 'Anak', 'Surabaya', '2020-03-20', 'Laki-laki', 'Islam', 'Tidak/Belum Sekolah', '-', 'Belum Kawin'],
        ];
        foreach ($contoh as $i => $row) {
            $rowNum = 4 + $i;
            foreach ($row as $j => $val) {
                $sheet->setCellValueExplicit($cols[$j].$rowNum, $val, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            }
            $sheet->getStyle("A{$rowNum}:K{$rowNum}")->applyFromArray([
                'fill'    => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'F0FDF4']],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'D1FAE5']]],
                'font'    => ['color' => ['rgb' => '166534'], 'italic' => true],
            ]);
        }

        // Lebar kolom
        $widths = [20, 28, 20, 20, 18, 24, 16, 12, 22, 20, 16];
        foreach ($widths as $i => $w) {
            $sheet->getColumnDimension($cols[$i])->setWidth($w);
        }

        // Sheet referensi nilai valid
        $refSheet = $spreadsheet->createSheet();
        $refSheet->setTitle('Referensi Nilai');
        $refs = [
            ['Hubungan Keluarga', ['Kepala Keluarga','Istri','Anak','Famili Lain','Lainnya']],
            ['Jenis Kelamin', ['Laki-laki','Perempuan']],
            ['Agama', ['Islam','Kristen','Katholik','Hindu','Buddha','Konghucu','Lainnya']],
            ['Pendidikan', ['Tidak/Belum Sekolah','SD/Sederajat','SMP/Sederajat','SMA/Sederajat','D1/D2/D3','S1','S2','S3']],
            ['Status Kawin', ['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati']],
        ];
        $refRow = 1;
        foreach ($refs as [$label, $vals]) {
            $refSheet->setCellValue('A'.$refRow, $label);
            $refSheet->getStyle('A'.$refRow)->getFont()->setBold(true);
            foreach ($vals as $k => $val) {
                $refSheet->setCellValue(chr(66+$k).$refRow, $val);
            }
            $refRow++;
        }
        $refSheet->getColumnDimension('A')->setWidth(22);

        $spreadsheet->setActiveSheetIndex(0);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="template_import_penduduk.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }

    /**
     * Download template Excel untuk data Kartu Keluarga
     */
    public function templateKK()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Kartu Keluarga');

        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A1', 'TEMPLATE IMPORT DATA KARTU KELUARGA - SI DESA');
        $sheet->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 13, 'color' => ['rgb' => 'FFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '065F46']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(30);

        $sheet->mergeCells('A2:F2');
        $sheet->setCellValue('A2', 'Petunjuk: Isi data mulai baris ke-4. No KK harus unik 16 digit. RT/RW maksimal 3 digit. Tanggal format YYYY-MM-DD.');
        $sheet->getStyle('A2')->applyFromArray([
            'font'      => ['italic' => true, 'size' => 9],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'D1FAE5']],
        ]);
        $sheet->getRowDimension(2)->setRowHeight(25);

        $headers = ['No KK (16 digit)*', 'Alamat', 'RT', 'RW', 'Tanggal Dikeluarkan (YYYY-MM-DD)', 'NIK Kepala Keluarga (Opsional)'];
        foreach ($headers as $i => $h) {
            $sheet->setCellValue(chr(65+$i).'3', $h);
        }
        $sheet->getStyle('A3:F3')->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '059669']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'wrapText' => true],
        ]);
        $sheet->getRowDimension(3)->setRowHeight(35);

        // Contoh
        $sheet->setCellValueExplicit('A4', '3578010101000001', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValue('B4', 'Jl. Merdeka No. 1 RT 001 RW 002');
        $sheet->setCellValueExplicit('C4', '001', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValueExplicit('D4', '002', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValue('E4', '2020-01-01');
        $sheet->setCellValueExplicit('F4', '3578010101900001', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->getStyle('A4:F4')->applyFromArray([
            'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'ECFDF5']],
            'font' => ['color' => ['rgb' => '065F46'], 'italic' => true],
        ]);

        foreach ([22, 38, 8, 8, 28, 22] as $i => $w) {
            $sheet->getColumnDimension(chr(65+$i))->setWidth($w);
        }

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="template_import_kartu_keluarga.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }

    // ===================================================================
    // PROSES IMPORT PENDUDUK
    // ===================================================================
    public function importPenduduk()
    {
        $file = $this->request->getFile('file_excel');

        if (! $file || ! $file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid atau belum dipilih.');
        }

        $allowedTypes = ['xlsx', 'xls', 'csv'];
        if (! in_array(strtolower($file->getClientExtension()), $allowedTypes)) {
            return redirect()->back()->with('error', 'Format file tidak didukung. Gunakan .xlsx, .xls, atau .csv');
        }

        try {
            $spreadsheet = IOFactory::load($file->getTempName());
            $sheet       = $spreadsheet->getActiveSheet();
            $rows        = $sheet->toArray(null, true, true, false);

            // Abaikan 3 baris pertama (judul, instruksi, header)
            $dataRows = array_slice($rows, 3);

            // Batasi jumlah baris maksimum untuk mencegah timeout
            $maxRows = 1000;
            if (count($dataRows) > $maxRows) {
                return redirect()->back()->with('error', "File terlalu besar. Maksimal {$maxRows} baris per sekali import. File Anda memiliki " . count($dataRows) . " baris.");
            }

            $berhasil  = 0;
            $gagal     = 0;
            $errors    = [];

            foreach ($dataRows as $lineNum => $row) {
                $actualLine = $lineNum + 4; // baris sebenarnya di excel

                // Skip baris kosong
                if (empty(trim((string)($row[0] ?? ''))) && empty(trim((string)($row[1] ?? '')))) {
                    continue;
                }

                $nik          = trim((string)($row[0] ?? ''));
                $namaLengkap  = trim((string)($row[1] ?? ''));
                $noKK         = trim((string)($row[2] ?? ''));
                $hubungan     = trim((string)($row[3] ?? ''));
                $tempatLahir  = trim((string)($row[4] ?? ''));
                $tglLahir     = trim((string)($row[5] ?? ''));
                $jenisKelamin = trim((string)($row[6] ?? ''));
                $agama        = trim((string)($row[7] ?? ''));
                $pendidikan   = trim((string)($row[8] ?? ''));
                $pekerjaan    = trim((string)($row[9] ?? ''));
                $statusKawin  = trim((string)($row[10] ?? ''));

                // Validasi wajib
                if (empty($nik) || strlen($nik) !== 16 || !ctype_digit($nik)) {
                    $errors[] = "Baris {$actualLine}: NIK '{$nik}' tidak valid (harus 16 digit angka).";
                    $gagal++;
                    continue;
                }
                if (empty($namaLengkap)) {
                    $errors[] = "Baris {$actualLine}: Nama Lengkap tidak boleh kosong.";
                    $gagal++;
                    continue;
                }
                if ($this->pendudukModel->where('nik', $nik)->countAllResults() > 0) {
                    $errors[] = "Baris {$actualLine}: NIK {$nik} sudah terdaftar, dilewati.";
                    $gagal++;
                    continue;
                }

                // Cari kartu_keluarga_id dari No KK
                $kkId = null;
                if (!empty($noKK)) {
                    $kk = $this->kkModel->where('no_kk', $noKK)->first();
                    if ($kk) {
                        $kkId = $kk['id'];
                    } else {
                        $errors[] = "Baris {$actualLine}: No KK '{$noKK}' tidak ditemukan. Data penduduk tetap disimpan tanpa KK.";
                    }
                }

                // Normalisasi tanggal
                $tanggalLahir = null;
                if (!empty($tglLahir)) {
                    // Handle format Excel numeric date
                    if (is_numeric($tglLahir)) {
                        $tanggalLahir = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((float)$tglLahir)->format('Y-m-d');
                    } else {
                        $parsed = date_create($tglLahir);
                        $tanggalLahir = $parsed ? $parsed->format('Y-m-d') : null;
                    }
                }

                $validHubungan   = ['Kepala Keluarga','Istri','Anak','Famili Lain','Lainnya'];
                $validJK         = ['Laki-laki','Perempuan'];
                $validAgama      = ['Islam','Kristen','Katholik','Hindu','Buddha','Konghucu','Lainnya'];
                $validPendidikan = ['Tidak/Belum Sekolah','SD/Sederajat','SMP/Sederajat','SMA/Sederajat','D1/D2/D3','S1','S2','S3'];
                $validStatus     = ['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati'];

                $this->pendudukModel->save([
                    'nik'               => $nik,
                    'nama_lengkap'      => $namaLengkap,
                    'kartu_keluarga_id' => $kkId,
                    'hubungan_keluarga' => in_array($hubungan, $validHubungan) ? $hubungan : null,
                    'tempat_lahir'      => $tempatLahir ?: null,
                    'tanggal_lahir'     => $tanggalLahir,
                    'jenis_kelamin'     => in_array($jenisKelamin, $validJK) ? $jenisKelamin : null,
                    'agama'             => in_array($agama, $validAgama) ? $agama : null,
                    'pendidikan'        => in_array($pendidikan, $validPendidikan) ? $pendidikan : null,
                    'pekerjaan'         => $pekerjaan ?: null,
                    'status_kawin'      => in_array($statusKawin, $validStatus) ? $statusKawin : null,
                ]);
                $berhasil++;
            }

            $msg = "Import selesai: {$berhasil} data berhasil diimpor.";
            if ($gagal > 0) $msg .= " {$gagal} data gagal/dilewati.";

            return redirect()->to('/import')
                ->with('success', $msg)
                ->with('import_errors', $errors);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membaca file: ' . $e->getMessage());
        }
    }

    // ===================================================================
    // PROSES IMPORT KARTU KELUARGA
    // ===================================================================
    public function importKK()
    {
        $file = $this->request->getFile('file_excel');

        if (! $file || ! $file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid atau belum dipilih.');
        }

        $allowedTypes = ['xlsx', 'xls', 'csv'];
        if (! in_array(strtolower($file->getClientExtension()), $allowedTypes)) {
            return redirect()->back()->with('error', 'Format file tidak didukung. Gunakan .xlsx, .xls, atau .csv');
        }

        try {
            $spreadsheet = IOFactory::load($file->getTempName());
            $sheet       = $spreadsheet->getActiveSheet();
            $rows        = $sheet->toArray(null, true, true, false);

            $dataRows = array_slice($rows, 3);

            // Batasi jumlah baris maksimum untuk mencegah timeout
            $maxRows = 2000;
            if (count($dataRows) > $maxRows) {
                return redirect()->back()->with('error', "File terlalu besar. Maksimal {$maxRows} baris per sekali import.");
            }

            $berhasil = 0;
            $gagal    = 0;
            $errors   = [];

            foreach ($dataRows as $lineNum => $row) {
                $actualLine = $lineNum + 4;

                if (empty(trim((string)($row[0] ?? '')))) continue;

                $noKK           = trim((string)($row[0] ?? ''));
                $alamat         = trim((string)($row[1] ?? ''));
                $rt             = trim((string)($row[2] ?? ''));
                $rw             = trim((string)($row[3] ?? ''));
                $tglDikeluarkan = trim((string)($row[4] ?? ''));
                $nikKepala      = trim((string)($row[5] ?? ''));

                if (empty($noKK)) {
                    $errors[] = "Baris {$actualLine}: No KK tidak boleh kosong.";
                    $gagal++;
                    continue;
                }

                if ($this->kkModel->where('no_kk', $noKK)->countAllResults() > 0) {
                    $errors[] = "Baris {$actualLine}: No KK '{$noKK}' sudah terdaftar, dilewati.";
                    $gagal++;
                    continue;
                }

                // Cari kepala keluarga dari NIK
                $kepalaId = null;
                if (!empty($nikKepala)) {
                    $kepala = $this->pendudukModel->where('nik', $nikKepala)->first();
                    if ($kepala) {
                        $kepalaId = $kepala['id'];
                    } else {
                        $errors[] = "Baris {$actualLine}: NIK kepala keluarga '{$nikKepala}' tidak ditemukan. KK tetap disimpan tanpa kepala.";
                    }
                }

                // Normalisasi tanggal
                $tanggalDikeluarkan = null;
                if (!empty($tglDikeluarkan)) {
                    if (is_numeric($tglDikeluarkan)) {
                        $tanggalDikeluarkan = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((float)$tglDikeluarkan)->format('Y-m-d');
                    } else {
                        $parsed = date_create($tglDikeluarkan);
                        $tanggalDikeluarkan = $parsed ? $parsed->format('Y-m-d') : null;
                    }
                }

                $this->kkModel->save([
                    'no_kk'               => $noKK,
                    'alamat'              => $alamat ?: null,
                    'rt'                  => $rt ?: null,
                    'rw'                  => $rw ?: null,
                    'tanggal_dikeluarkan' => $tanggalDikeluarkan,
                    'kepala_keluarga_id'  => $kepalaId,
                ]);
                $berhasil++;
            }

            $msg = "Import selesai: {$berhasil} KK berhasil diimpor.";
            if ($gagal > 0) $msg .= " {$gagal} data gagal/dilewati.";

            return redirect()->to('/import')
                ->with('success', $msg)
                ->with('import_errors', $errors);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membaca file: ' . $e->getMessage());
        }
    }
}
