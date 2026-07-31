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
        // Data dasar
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
        'golongan_darah',
        'kewarganegaraan',
        'status_tinggal',
        // Data orang tua
        'nik_ayah',
        'nama_ayah',
        'nik_ibu',
        'nama_ibu',
        // Data kontak
        'no_hp',
        'email_penduduk',
        // Status
        'is_dtks',
        'is_verified',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // ---------------------------------------------------------------
    // Query Helpers
    // ---------------------------------------------------------------

    /** Ambil semua anggota keluarga berdasarkan kartu_keluarga_id */
    public function getByKartuKeluarga(int $kkId): array
    {
        return $this->where('kartu_keluarga_id', $kkId)->findAll();
    }

    /**
     * Ambil data penduduk lengkap beserta info KK — untuk daftar admin.
     * Mendukung filter dinamis dari parameter array.
     *
     * @param array $filter  Key: nama kolom penduduk, value: nilai filter
     */
    public function getAllWithKK(array $filter = []): array
    {
        $builder = $this->db->table('penduduk p')
            ->select('p.*, kk.no_kk, kk.alamat, kk.dusun, kk.rt, kk.rw')
            ->join('kartu_keluarga kk', 'kk.id = p.kartu_keluarga_id', 'left');

        // Filter dinamis
        $enumFilters = ['jenis_kelamin', 'agama', 'pendidikan', 'pekerjaan',
                        'status_kawin', 'golongan_darah', 'kewarganegaraan',
                        'status_tinggal', 'hubungan_keluarga'];
        foreach ($enumFilters as $col) {
            if (!empty($filter[$col])) {
                $builder->where("p.$col", $filter[$col]);
            }
        }
        if (isset($filter['is_dtks']) && $filter['is_dtks'] !== '') {
            $builder->where('p.is_dtks', (int) $filter['is_dtks']);
        }
        if (!empty($filter['dusun'])) {
            $builder->where('kk.dusun', $filter['dusun']);
        }

        return $builder->orderBy('p.nama_lengkap', 'ASC')->get()->getResultArray();
    }

    /** Ambil penduduk berdasarkan NIK (unique) */
    public function findByNik(string $nik): ?array
    {
        return $this->where('nik', $nik)->first() ?: null;
    }
}