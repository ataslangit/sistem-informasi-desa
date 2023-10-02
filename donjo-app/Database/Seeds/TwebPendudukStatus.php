<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TwebPendudukStatus extends Seeder
{
    public function run()
    {
        $this->db->query("INSERT INTO `tweb_penduduk_status` (`id`, `nama`) VALUES
        (1, 'TETAP'),
        (2, 'TIDAK AKTIF'),
        (3, 'PENDUDUK DOMISILI'),
        (77, 'WARGA');");
    }
}
