<?php

namespace App\Models;

use Kenjis\CI3Compatible\Core\CI_Model as Model;

class Config extends Model
{
    protected $table = 'config';

    public function __construct()
    {
        $this->load->database('default');
    }

    public function insert($data)
    {
        $outp = $this->db->insert($this->table, $data);
        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }

    public function update_(int $id, $data)
    {
        $this->db->where('id', $id);
        $outp = $this->db->update($this->table, $data);

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
