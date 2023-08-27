<?php

use App\Models\BaseModel as Model;

class First_slide_m extends Model
{
    public function slide_show()
    {
        $sql   = 'SELECT * FROM gambar_slide WHERE enabled=?';
        $query = $this->db->query($sql, 1);

        return $query->result_array();
    }
}
