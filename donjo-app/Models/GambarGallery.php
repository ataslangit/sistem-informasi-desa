<?php

namespace App\Models;

use App\Libraries\Paging;
use CodeIgniter\Model;

class GambarGallery extends Model
{
    protected $table            = 'gambar_gallery';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'parrent',
        'gambar',
        'nama',
        'enabled',
        'tgl_upload',
        'tipe',
    ];

    /**
     * Builder untuk menampilkan isi album gallery
     *
     * @return $this
     */
    public function subGalleryShow(int $albumGallery)
    {
        $this->builder()
            ->groupStart()
            ->where(['enabled' => '1'])
            ->groupStart()
            ->where('parrent', $albumGallery)
            ->orWhere('id', $albumGallery)
            ->groupEnd()
            ->groupEnd();

        return $this;
    }

    public function paging($p = 1)
    {
        $paging = new Paging();

        $sql      = "SELECT COUNT(id) AS id FROM gambar_gallery WHERE enabled=1 AND tipe='0'";
        $query    = $this->db->query($sql);
        $row      = $query->getRowArray();
        $jml_data = $row['id'];

        $cfg['page']     = $p;
        $cfg['per_page'] = 8;
        $cfg['num_rows'] = $jml_data;

        $paging->init($cfg);

        return $paging;
    }

    public function paging2($gal = 0, $p = 1)
    {
        $paging = new Paging();

        $sql      = 'SELECT COUNT(id) AS id FROM gambar_gallery WHERE enabled=1 AND parrent=?';
        $query    = $this->db->query($sql, $gal);
        $row      = $query->getRowArray();
        $jml_data = $row['id'];

        $cfg['page']     = $p;
        $cfg['per_page'] = 8;
        $cfg['num_rows'] = $jml_data;

        $paging->init($cfg);

        return $paging;
    }

    public function get_parrent($parrent)
    {
        $sql   = "SELECT * FROM gambar_gallery WHERE id='{$parrent}'";
        $query = $this->db->query($sql);

        return $query->getRowArray();
    }

    public function gallery_widget()
    {
        $sql   = "SELECT * FROM gambar_gallery WHERE enabled='1' ORDER BY RAND() LIMIT 4";
        $query = $this->db->query($sql);

        return $query->getResultArray();
    }
}