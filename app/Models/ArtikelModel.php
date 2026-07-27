<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtikelModel extends Model
{
    protected $table            = 'artikel';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'judul', 'slug', 'isi', 'gambar', 'kategori', 'status', 'penulis',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Generate slug unik dari judul.
     */
    public function makeSlug(string $judul, ?int $excludeId = null): string
    {
        $slug = url_title($judul, '-', true);
        $original = $slug;
        $i = 1;
        while (true) {
            $q = $this->where('slug', $slug);
            if ($excludeId) $q = $q->where('id !=', $excludeId);
            if ($q->countAllResults() === 0) break;
            $slug = $original . '-' . $i++;
        }
        return $slug;
    }

    /** Ambil artikel published saja untuk landing page. */
    public function getPublished(int $limit = 6): array
    {
        return $this->where('status', 'published')
                    ->orderBy('created_at', 'DESC')
                    ->findAll($limit);
    }
}
