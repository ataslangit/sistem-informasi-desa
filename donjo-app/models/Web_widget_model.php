<?php

class Web_widget_model extends CI_Model
{
    public function get_widget()
    {
        $sql   = 'SELECT * FROM widget limit 1';
        $query = $this->db->query($sql);

        return $query->row_array();
    }

    public function update($id = 0)
    {
        $data = $_POST;

        $sql   = 'SELECT * FROM widget WHERE 1 ';
        $query = $this->db->query($sql);
        $hasil = $query->result_array();

        if ($hasil) {
            $this->db->where('id', $id);
            $outp = $this->db->update('widget', $data);
        } else {
            $outp = $this->db->insert('widget', $data);
        }

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }
}
