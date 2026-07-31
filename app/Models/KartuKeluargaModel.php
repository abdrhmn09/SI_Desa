<?php

namespace App\Models;

use CodeIgniter\Model;

class KartuKeluargaModel extends Model
{
    protected $table            = 'kartu_keluarga';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'no_kk',
        'kepala_keluarga_id',
        'alamat',
        'dusun',
        'rt',
        'rw',
        'tanggal_dikeluarkan',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}