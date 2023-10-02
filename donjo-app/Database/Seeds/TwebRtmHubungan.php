<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TwebRtmHubungan extends Seeder
{
    public function run()
    {
        $this->db->query("INSERT INTO `tweb_rtm_hubungan` (`id`, `nama`) VALUES
        (1, 'Kepala Rumah Tangga'),
        (2, 'Anggota');");
    }
}
