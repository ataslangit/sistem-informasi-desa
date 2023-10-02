<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TwebPendudukHubungan extends Seeder
{
    public function run()
    {
        $this->db->query("INSERT INTO `tweb_penduduk_hubungan` (`id`, `nama`) VALUES
        (1, 'KEPALA KELUARGA'),
        (2, 'SUAMI'),
        (3, 'ISTRI'),
        (4, 'ANAK'),
        (5, 'MENANTU'),
        (6, 'CUCU'),
        (7, 'ORANGTUA'),
        (8, 'MERTUA'),
        (9, 'FAMILI LAIN'),
        (10, 'PEMBANTU'),
        (11, 'LAINNYA');");
    }
}
