<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AnalisisRefState extends Seeder
{
    public function run()
    {
        $this->db->query("INSERT INTO `analisis_ref_state` (`id`, `nama`) VALUES
            (1, 'Belum Entri / Pendataan'),
            (2, 'Sedang Dalam Pendataan'),
            (3, 'Selesai Entri / Pendataan')");
    }
}
