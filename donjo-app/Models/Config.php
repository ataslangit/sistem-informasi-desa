<?php

namespace App\Models;

use CodeIgniter\Model;

class Config extends Model
{
    protected $table            = 'config';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama_desa', 'kode_desa', 'nama_kepala_desa',
        'nip_kepala_desa', 'kode_pos', 'nama_kecamatan',
        'kode_kecamatan', 'nama_kepala_camat',
        'nip_kepala_camat', 'nama_kabupaten',
        'kode_kabupaten', 'nama_propinsi', 'kode_propinsi',
        'logo', 'lat', 'lng', 'zoom', 'map_tipe', 'path',
        'alamat_kantor', 'g_analytic', 'regid', 'macid',
        'email_desa', 'gapi_key',
    ];

    /*
    public function insert($data)
    {
        $outp = $this->db->insert($this->table, $data);
        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function update_(int $id, $data)
    {
        $this->db->where('id', $id);
        $outp = $this->db->update($this->table, $data);

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function get_data(bool $return_array = false)
    {
        $query = $this->db->get($this->table);

        if ($return_array) {
            return $query->result_array();
        }

        return $query->row_array();
    }
    */
}
