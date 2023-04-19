<?php

namespace App\Models;

use CodeIgniter\Model;

class Pamong extends Model
{
    protected $table            = 'tweb_desa_pamong';
    protected $primaryKey       = 'pamong_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'pamong_id',
        'pamong_nama',
        'pamong_nip',
        'pamong_nik',
        'jabatan',
        'pamong_status',
        'pamong_tgl_terdaftar',
    ];

    /**
     * Builder untuk status
     *
     * @return $this
     */
    public function status(int $status = 0)
    {
        if ($status > 0) {
            $this->builder()->where('pamong_status', $status);
        }

        return $this;
    }

    /**
     * Builder untuk filter
     *
     * @return $this
     */
    public function search(string $cari = '')
    {
        $this->builder()->like('pamong_nama', $cari)
            ->orLike('pamong_nip', $cari)
            ->orLike('pamong_nik', $cari);

        return $this;
    }

    public function autocomplete()
    {
        $sql = 'SELECT pamong_nama FROM tweb_desa_pamong
					UNION SELECT pamong_nip FROM tweb_desa_pamong
					UNION SELECT pamong_nik FROM tweb_desa_pamong';
        $query = $this->db->query($sql);
        $data  = $query->getResultArray();

        $i    = 0;
        $outp = '';

        while ($i < count($data)) {
            $outp .= ",'" . $data[$i]['pamong_nama'] . "'";
            $i++;
        }
        $outp = substr($outp, 1);

        return '[' . $outp . ']';
    }
}
