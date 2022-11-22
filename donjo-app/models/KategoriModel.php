<?php

class KategoriModel extends CI_Model
{
    protected $table = 'kategori';

    /**
     * Ambil data kategori berdasarkan ID kategori
     *
     * @param int $id ID kategori
     *
     * @return array|false False jika tidak ditemukan
     */
    public function get(int $id)
    {
        $this->db->select('kategori');
        $this->db->where('id', $id);

        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return false;
    }

    public function getList()
    {
        $query = $this->db->order_by('urut', 'ASC')->get($this->table);

        return $query->result_array();
    }
}
