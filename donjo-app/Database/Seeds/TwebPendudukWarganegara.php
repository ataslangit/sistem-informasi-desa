<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TwebPendudukWarganegara extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('tweb_penduduk_warganegara');

        $builder->insertBatch([
            ['id' => 1, 'nama' => 'WNI'],
            ['id' => 2, 'nama' => 'WNA'],
            ['id' => 3, 'nama' => 'DUA KEWARGANEGARAAN'],
        ]);
    }
}
