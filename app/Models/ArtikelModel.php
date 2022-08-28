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

    /**
     * Builder untuk ambil data artikel
     *
     * @return $this
     */
    public function ambilPos()
    {
        $this->builder()
            ->select('artikel.*')
            ->join('user u', 'artikel.id_user=u.id', 'left')
            ->join('kategori k', 'artikel.id_kategori=k.id', 'left')
            ->where(['artikel.enabled' => '1', 'k.tipe' => '1', 'artikel.headline != 1' => null, 'k.kategori != "teks_berjalan"' => null]);

        return $this;
    }
}
