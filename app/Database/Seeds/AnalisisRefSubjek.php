<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AnalisisRefSubjek extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('analisis_ref_subjek');

        $builder->insertBatch([
            ['id' => '1', 'subjek' => 'Penduduk'],
            ['id' => '2', 'subjek' => 'Keluarga / KK'],
            ['id' => '3', 'subjek' => 'Rumah Tangga'],
            ['id' => '4', 'subjek' => 'Kelompok'],
        ]);
    }
}
