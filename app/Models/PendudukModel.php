<?php

namespace App\Models;

use CodeIgniter\Model;

class PendudukModel extends Model
{
    protected $table            = 'penduduk';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'nik',
        'nama_lengkap',
        'kartu_keluarga_id',
        'hubungan_keluarga',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'pendidikan',
        'pekerjaan',
        'status_kawin',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Helper: ambil semua anggota keluarga berdasarkan kartu_keluarga_id
    public function getByKartuKeluarga(int $kkId)
    {
        return $this->where('kartu_keluarga_id', $kkId)->findAll();
    }
}