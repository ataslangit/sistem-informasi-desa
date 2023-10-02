<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TwebPendudukWarganegara extends Seeder
{
    public function run()
    {
        $this->db->query("INSERT INTO `tweb_penduduk_warganegara` (`id`, `nama`) VALUES
        (1, 'WNI'),
        (2, 'WNA'),
        (3, 'DUA KEWARGANEGARAAN');");
    }
}
