<?php

namespace App\Models;

use Kenjis\CI3Compatible\Core\CI_Model;

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

    /**
     * Ambil data semua kategori dan diurutkan berdasarkan 'urut'
     *
     * @return array
     */
    public function getList()
    {
        $query = $this->db->order_by('urut', 'ASC')->get($this->table);

        return $query->result_array();
    }

    /**
     * Ambil data kategori berdasarkan tipe
     *
     * @param int $tipe Tipe Kategori
     *
     * @return array
     */
    public function getByType(int $tipe = 1)
    {
        $query = $this->db->where('tipe', $tipe)->get($this->table);

        return $query->result_array();
    }

    /**
     * Hapus kategori
     *
     * @param int $id ID Kategori
     *
     * @return void
     */
    public function hapus(int $id)
    {
        $this->db->delete($this->table, ['id' => $id]);

        if ($this->db->affected_rows() > -1) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }
}
