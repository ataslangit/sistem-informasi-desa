<?php

class First_slide_m extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function slide_show()
    {
        $sql   = 'SELECT * FROM gambar_slide WHERE enabled=?';
        $query = $this->db->query($sql, 1);

        return $query->result_array();
    }
}
