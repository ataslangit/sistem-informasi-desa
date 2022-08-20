<?php

namespace App\Models;

use CodeIgniter\Model;

class First_gallery_m extends Model
{
    public function paging($p = 1)
    {
        $sql      = "SELECT COUNT(id) AS id FROM gambar_gallery WHERE enabled=1 AND tipe='0'";
        $query    = $this->db->query($sql);
        $row      = $query->getRowArray();
        $jml_data = $row['id'];

        $this->load->library('paging');
        $cfg['page']     = $p;
        $cfg['per_page'] = 8;
        $cfg['num_rows'] = $jml_data;
        $this->paging->init($cfg);

        return $this->paging;
    }

    public function gallery_show($offset = 0, $limit = 50)
    {
        $paging_sql = ' LIMIT ' . $offset . ',' . $limit;

        $sql = "SELECT * FROM gambar_gallery WHERE enabled=1 AND tipe='0' ";
        $sql .= $paging_sql;

        $query = $this->db->query($sql);

        return $query->getResultArray();
    }

    public function paging2($gal = 0, $p = 1)
    {
        $sql      = 'SELECT COUNT(id) AS id FROM gambar_gallery WHERE enabled=1 AND parrent=?';
        $query    = $this->db->query($sql, $gal);
        $row      = $query->getRowArray();
        $jml_data = $row['id'];

        $this->load->library('paging');
        $cfg['page']     = $p;
        $cfg['per_page'] = 8;
        $cfg['num_rows'] = $jml_data;
        $this->paging->init($cfg);

        return $this->paging;
    }

    public function sub_gallery_show($gal = 0, $offset = 0, $limit = 50)
    {
        $paging_sql = ' LIMIT ' . $offset . ',' . $limit;

        $sql = "SELECT * FROM gambar_gallery WHERE ((enabled='1') AND ((parrent='" . $gal . "') OR (id='" . $gal . "'))) ";
        $sql .= $paging_sql;

        $query = $this->db->query($sql);

        return $query->getResultArray();
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
