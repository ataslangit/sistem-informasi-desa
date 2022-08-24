<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtikelModel extends Model
{
    protected $table            = 'artikel';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['gambar', 'isi', 'enabled', 'tgl_upload',
        'id_kategori', 'id_user', 'judul', 'headline', 'gambar1', 'gambar2',
        'gambar3', 'dokumen', 'link_dokumen',
    ];
}
