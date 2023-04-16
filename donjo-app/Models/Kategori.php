<?php

namespace App\Models;

use CodeIgniter\Model;

class Kategori extends Model
{
    protected $table            = 'kategori';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'kategori',
        'tipe',
        'urut',
        'enabled',
        'parrent',
    ];

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
