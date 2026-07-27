<?php

namespace App\Models;

use CodeIgniter\Model;

class IdentitasDesaModel extends Model
{
        protected $table            = 'identitas_desa';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'nama_desa',
        'kode_desa',
        'nama_kepala_desa',
        'nip_kepala_desa',
        'alamat_kantor',
        'logo',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kodepos',
        'sejarah',
        'visi_misi',
        'geografis',
        'demografi',
        'email',
        'telepon',
        'facebook',
        'instagram',
        'youtube',
        'twitter',
        'embed_peta'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Helper: karena tabel ini cuma 1 baris, ambil datanya langsung tanpa perlu ID
    public function getIdentitas()
    {
        return $this->first();
    }
}
