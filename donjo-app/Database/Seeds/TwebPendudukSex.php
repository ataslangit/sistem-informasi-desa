<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TwebPendudukSex extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('tweb_penduduk_sex');

        $builder->insertBatch([
            ['id' => 1, 'nama' => 'LAKI-LAKI'],
            ['id' => 2, 'nama' => 'PEREMPUAN'],
        ]);
    }
}
