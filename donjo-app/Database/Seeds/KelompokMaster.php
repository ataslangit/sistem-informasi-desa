<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KelompokMaster extends Seeder
{
    public function run()
    {
        $this->db->query("INSERT INTO `kelompok_master` (`id`, `kelompok`, `deskripsi`) VALUES
        (1, 'Kelompok Tani', 'ent'),
        (2, 'Dasa Wisma', 'Oye'),
        (3, 'Jagongan', 'OOO');");
    }
}
