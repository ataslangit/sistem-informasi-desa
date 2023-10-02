<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TwebDesaPamong extends Seeder
{
    public function run()
    {
        $this->db->query("INSERT INTO `tweb_desa_pamong` (`pamong_id`, `pamong_nama`, `pamong_nip`, `pamong_nik`, `jabatan`, `pamong_status`, `pamong_tgl_terdaftar`) VALUES
        (1, 'Jarwo', '', '', 'Kepala Desa', '1', '2015-05-19'),
        (2, 'Jarwo', '', '', '(A/n) Kepala Desa', '1', '2015-05-19');");
    }
}
