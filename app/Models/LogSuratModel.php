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

    // TAMBAHKAN ALLOWED FIELDS BARU
    protected $allowedFields = [
        'penduduk_id',
        'jenis_surat_id',
        'nomor_surat',
        'data_isian',          // Ditambah
        'status',              // Ditambah
        'ditandatangani_oleh', // Ditambah
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
        return $this->select('log_surat.*, penduduk.nama_lengkap, penduduk.nik, jenis_surat.nama_surat')
            ->join('penduduk', 'penduduk.id = log_surat.penduduk_id')
            ->join('jenis_surat', 'jenis_surat.id = log_surat.jenis_surat_id')
            ->orderBy('log_surat.created_at', 'DESC')
            ->findAll();
    }

    /**
     * Ambil riwayat khusus milik satu penduduk yang sedang login
     */
    public function getRiwayatPenduduk($pendudukId)
    {
        return $this->select('log_surat.*, jenis_surat.nama_surat')
            ->join('jenis_surat', 'jenis_surat.id = log_surat.jenis_surat_id')
            ->where('log_surat.penduduk_id', $pendudukId)
            ->orderBy('log_surat.created_at', 'DESC')
            ->findAll();
    }
}