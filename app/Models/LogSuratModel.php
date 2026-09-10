<?php

namespace App\Models;

use CodeIgniter\Model;

class LogSuratModel extends Model
{
    protected $table            = 'log_surat';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'penduduk_id',
        'jenis_surat_id',
        'nomor_surat',
        'data_isian',          
        'status',              
        'ditandatangani_oleh', 
        'tanggal_cetak',
        'keterangan',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Ambil seluruh riwayat surat (Untuk Admin/Kades)
     */
    public function getRiwayatLengkap()
    {
        return $this->select('log_surat.*, penduduk.nama_lengkap, penduduk.nik, jenis_surat.nama_surat, jenis_surat.kode_surat')
            ->join('penduduk', 'penduduk.id = log_surat.penduduk_id')
            ->join('jenis_surat', 'jenis_surat.id = log_surat.jenis_surat_id')
            ->orderBy('log_surat.created_at', 'DESC')
            ->findAll();
    }

    /**
     * Ambil pengajuan yang berstatus Menunggu
     */
    public function getPengajuanMenunggu()
    {
        return $this->select('log_surat.*, penduduk.nama_lengkap, penduduk.nik, jenis_surat.nama_surat, jenis_surat.kode_surat')
            ->join('penduduk', 'penduduk.id = log_surat.penduduk_id')
            ->join('jenis_surat', 'jenis_surat.id = log_surat.jenis_surat_id')
            ->where('log_surat.status', 'Menunggu')
            ->orderBy('log_surat.created_at', 'ASC')
            ->findAll();
    }

    /**
     * Ambil riwayat khusus milik satu penduduk
     */
    public function getRiwayatPenduduk($pendudukId)
    {
        return $this->select('log_surat.*, jenis_surat.nama_surat, jenis_surat.kode_surat')
            ->join('jenis_surat', 'jenis_surat.id = log_surat.jenis_surat_id')
            ->where('log_surat.penduduk_id', $pendudukId)
            ->orderBy('log_surat.created_at', 'DESC')
            ->findAll();
    }

    public function countMenunggu(): int
    {
        return $this->where('status', 'Menunggu')->countAllResults();
    }

/**
     * Fungsi Cerdas: Generate Nomor Surat Otomatis
     */
    public function generateNomorSurat($formatNomor, $kodeKlasifikasi = '')
    {
        $tahunIni = date('Y');
        
        // Menghitung jumlah surat yang disetujui di tahun ini untuk mendapatkan urutan baru.
        // Cara ini lebih tahan banting (bulletproof) dibandingkan memotong string (explode).
        $jumlahSuratTahunIni = $this->where('status', 'Disetujui')
                                    ->like('tanggal_cetak', $tahunIni, 'after')
                                    ->countAllResults();
        
        $noUrut = $jumlahSuratTahunIni + 1;
        $noUrutStr = str_pad($noUrut, 3, '0', STR_PAD_LEFT); 

        $bulanRomawi = $this->getBulanRomawi(date('n'));

        // Replace tag dinamis ke format asli (termasuk tag baru [KODE_KLASIFIKASI])
        $nomorJadi = str_replace(
            ['[NO_URUT]', '[BULAN]', '[TAHUN]', '[KODE_KLASIFIKASI]'], 
            [$noUrutStr, $bulanRomawi, $tahunIni, $kodeKlasifikasi], 
            $formatNomor
        );

        return $nomorJadi;
    }

    private function getBulanRomawi($bulan)
    {
        $map = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        return $map[$bulan];
    }
}