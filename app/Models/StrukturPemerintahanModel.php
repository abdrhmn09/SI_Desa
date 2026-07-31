<?php

namespace App\Models;

use CodeIgniter\Model;

class StrukturPemerintahanModel extends Model
{
    protected $table            = 'struktur_pemerintahan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'nama_jabatan',
        'nama_pejabat',
        'tahun',
        'foto',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}