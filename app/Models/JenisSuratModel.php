<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisSuratModel extends Model
{
    protected $table            = 'jenis_surat';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    // UBAH ALLOWED FIELDS
    protected $allowedFields = [
        'kode_surat',
        'nama_surat',
        'template_surat',
        'kode_klasifikasi', // DITAMBAHKAN
        'format_nomor',     // DITAMBAHKAN
        'form_fields',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}