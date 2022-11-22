<?php

class KategoriModel extends CI_Model
{
    protected $table = 'kategori';

    public function get($id = 0)
    {
        $sql   = "SELECT a.kategori FROM {$this->table} a WHERE a.id=?";
        $query = $this->db->query($sql, $id);
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        } else {
            $data = false;
        }

        return $data;
    }
}
