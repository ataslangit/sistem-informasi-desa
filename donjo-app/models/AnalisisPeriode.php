<?php

namespace App\Models;

use App\Models\BaseModel as Model;

class AnalisisPeriode extends Model
{
    protected $table = 'analisis_periode';

    public function list_periode()
    {
        $query = $this->db->get_where($this->table, [
            'id_master' => $_SESSION['analisis_master'],
        ]);

        return $query->result_array();
    }

    public function get_aktif_periode()
    {
        $query = $this->db->get_where($this->table, [
            'aktif'     => '1',
            'id_master' => $_SESSION['analisis_master'],
        ]);
        $data = $query->row_array();

        return $data['id'];
    }
}
