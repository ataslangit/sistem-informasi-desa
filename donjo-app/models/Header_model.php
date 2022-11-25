<?php

class Header_model extends CI_Model
{
    public function get_data()
    {
        // global variabel
        $outp['sasaran'] = ['1' => 'Penduduk', '2' => 'Keluarga / KK', '3' => 'Rumah Tangga', '4' => 'Kelompok/Organisasi Kemasyarakatan'];

        // Pembenahan per 13 Juli 15, sebelumnya ada notifikasi Error, saat $_SESSOIN['user'] nya kosong!
        $id    = @$_SESSION['user'];
        $sql   = 'SELECT nama,foto FROM user WHERE id=?';
        $query = $this->db->query($sql, $id);
        if ($query) {
            if ($query->num_rows() > 0) {
                $data         = $query->row_array();
                $outp['nama'] = $data['nama'];
                $outp['foto'] = $data['foto'];
            }
        }

        $sql          = 'SELECT * FROM config WHERE 1';
        $query        = $this->db->query($sql);
        $outp['desa'] = $query->row_array();

        $sql           = 'SELECT COUNT(id) AS jml FROM komentar WHERE id_artikel=775 AND enabled = 2;';
        $query         = $this->db->query($sql);
        $lap           = $query->row_array();
        $outp['lapor'] = $lap['jml'];

        $sql           = 'SELECT * FROM setting_modul WHERE aktif =  1 AND level >= ?;';
        $query         = $this->db->query($sql, $_SESSION['grup']);
        $modul         = $query->result_array();
        $outp['modul'] = $modul;

        return $outp;
    }

    public function init_penduduk()
    {
        $i = 1;

        $sql   = 'SELECT COUNT(id) AS jml FROM tweb_penduduk WHERE 1';
        $query = $this->db->query($sql);
        $data  = $query->row_array();
        $i     = $i * $data['jml'];

        $sql   = 'SELECT COUNT(id) AS jml FROM tweb_keluarga WHERE 1';
        $query = $this->db->query($sql);
        $data  = $query->row_array();
        //$i = $i*$data['jml'];

        $sql   = 'SELECT COUNT(id) AS jml FROM tweb_wil_clusterdesa WHERE 1';
        $query = $this->db->query($sql);
        $data  = $query->row_array();
        //$i = $i*$data['jml'];

        if ($i > 0) {
            return 1;
        }

        return 0;
    }
}
