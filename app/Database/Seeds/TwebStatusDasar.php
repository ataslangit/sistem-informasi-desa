<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TwebStatusDasar extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('tweb_status_dasar');

        $builder->insertBatch([
            ['id' => 1, 'nama' => 'HIDUP'],
            ['id' => 2, 'nama' => 'MATI'],
            ['id' => 3, 'nama' => 'PINDAH'],
        ]);
    }
}
