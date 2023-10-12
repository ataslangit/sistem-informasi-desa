<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TwebRtmHubungan extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('tweb_rtm_hubungan');

        $builder->insertBatch([
            ['id' => 1, 'nama' => 'Kepala Rumah Tangga'],
            ['id' => 2, 'nama' => 'Anggota'],
        ]);
    }
}
