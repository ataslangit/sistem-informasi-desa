<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TwebStatusDasar extends Seeder
{
    public function run()
    {
        $this->db->query("INSERT INTO `tweb_status_dasar` (`id`, `nama`) VALUES
        (1, 'HIDUP'),
        (2, 'MATI'),
        (3, 'PINDAH');");
    }
}
