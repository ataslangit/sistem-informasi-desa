<?php

namespace App\Models;

use App\Models\BaseModel as Model;

class Config extends Model
{
    protected $table = 'config';

    public function insert($data)
    {
        $outp = $this->db->insert($this->table, $data);
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
}
