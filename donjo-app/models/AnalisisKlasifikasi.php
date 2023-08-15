<?php

namespace App\Models;

use App\Models\BaseModel as Model;

class AnalisisKlasifikasi extends Model
{
    protected $table = 'analisis_klasifikasi';

    public function insert()
    {
        $data              = $_POST;
        $data['id_master'] = $_SESSION['analisis_master'];
        $outp              = $this->db->insert($this->table, $data);

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function update(int $id)
    {
        $data              = $_POST;
        $data['id_master'] = $_SESSION['analisis_master'];
        $this->db->where('id', $id);
        $outp = $this->db->update($this->table, $data);
        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function delete(int $id)
    {
        $this->db->where('id', $id);
        $outp = $this->db->delete($this->table);

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function delete_all()
    {
        $id_cb = $_POST['id_cb'];

        if (count($id_cb)) {
            foreach ($id_cb as $id) {
                $outp = $this->db->delete($this->table, ['id' => $id]);
            }
        } else {
            $outp = false;
        }

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function get_analisis_klasifikasi(int $id)
    {
        $query = $this->db->get_where($this->table, ['id' => $id]);

        return $query->row_array();
    }

    /**
     * Fungsi ini digunakan untuk menghasilkan data untuk proses autocomplete.
     */
    public function autocomplete(): string
    {
        // Mengambil data nama dari tabel
        $query = $this->db->select('nama')->get($this->table);
        $data  = $query->result_array();

        $i    = 0;
        $outp = '';

        // Menggabungkan nama-nama dalam format autocomplete
        while ($i < count($data)) {
            $outp .= ',"' . $data[$i]['nama'] . '"';
            $i++;
        }
        $outp = strtolower(substr($outp, 1));

        return '[' . $outp . ']';
    }
}
