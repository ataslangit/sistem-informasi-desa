<?php

namespace App\Models;

use App\Models\BaseModel as Model;

class Config extends Model
{
    protected $table = 'config';

    public function get_data(bool $return_array = false)
    {
        $query = $this->db->get($this->table);

        if ($return_array) {
            return $query->result_array();
        }

        return $query->row_array();
    }
}
