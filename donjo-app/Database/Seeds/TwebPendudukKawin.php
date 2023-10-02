<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TwebPendudukKawin extends Seeder
{
    public function run()
    {
        $this->db->query("INSERT INTO `tweb_penduduk_kawin` (`id`, `nama`) VALUES
        (1, 'BELUM KAWIN'),
        (2, 'KAWIN'),
        (3, 'CERAI HIDUP'),
        (4, 'CERAI MATI');");
    }
}
