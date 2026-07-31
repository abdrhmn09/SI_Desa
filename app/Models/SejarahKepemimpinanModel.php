<?php

namespace App\Models;

use CodeIgniter\Model;

class SejarahKepemimpinanModel extends Model
{
    protected $table            = 'sejarah_kepemimpinan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama', 'masa_jabatan', 'keterangan'];
    protected $useTimestamps    = true;
}