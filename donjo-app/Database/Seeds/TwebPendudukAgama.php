<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TwebPendudukAgama extends Seeder
{
    public function run()
    {
        $this->db->query("INSERT INTO `tweb_penduduk_agama` (`id`, `nama`) VALUES
        (1, 'ISLAM'),
        (2, 'KRISTEN'),
        (3, 'KATHOLIK'),
        (4, 'HINDU'),
        (5, 'BUDHA'),
        (6, 'KHONGHUCU'),
        (7, 'LAINNYA (Kepercayaan Terhadap Tuhan YME)');");
    }
}
