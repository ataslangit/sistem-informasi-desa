<?php

namespace App\Models;

use App\Models\BaseModel as Model;

class AnalisisPeriode extends Model
{
    protected $table = 'analisis_periode';

    public function list_periode()
    {
        $query = $this->db->get_where($this->table, ['id_master' => $_SESSION['analisis_master']]);

        return $query->result_array();
    }
}
