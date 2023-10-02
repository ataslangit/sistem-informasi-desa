<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AnalisisRefSubjek extends Seeder
{
    public function run()
    {
        $this->db->query("INSERT INTO `analisis_ref_subjek` (`id`, `subjek`) VALUES
            (1, 'Penduduk'),
            (2, 'Keluarga / KK'),
            (3, 'Rumah Tangga'),
            (4, 'Kelompok')");
    }
}
