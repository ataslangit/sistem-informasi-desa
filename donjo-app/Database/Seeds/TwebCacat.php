<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TwebCacat extends Seeder
{
    public function run()
    {
        $this->db->query("INSERT INTO `tweb_cacat` (`id`, `nama`) VALUES
        (1, 'CACAT FISIK'),
        (2, 'CACAT NETRA/BUTA'),
        (3, 'CACAT RUNGU/WICARA'),
        (4, 'CACAT MENTAL/JIWA'),
        (5, 'CACAT FISIK DAN MENTAL'),
        (6, 'CACAT LAINNYA'),
        (7, 'TIDAK CACAT');");
    }
}
