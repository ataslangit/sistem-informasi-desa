<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TwebPendudukSex extends Seeder
{
    public function run()
    {
        $this->db->query("INSERT INTO `tweb_penduduk_sex` (`id`, `nama`) VALUES
        (1, 'LAKI-LAKI'),
        (2, 'PEREMPUAN');");
    }
}
