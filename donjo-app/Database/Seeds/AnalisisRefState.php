<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AnalisisRefState extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('analisis_ref_state');

        $builder->insertBatch([
            ['id' => 1, 'nama' => 'Belum Entri / Pendataan'],
            ['id' => 2, 'nama' => 'Sedang Dalam Pendataan'],
            ['id' => 3, 'nama' => 'Selesai Entri / Pendataan'],
        ]);
    }
}
