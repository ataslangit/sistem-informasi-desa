<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TwebCacat extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('tweb_cacat');

        $builder->insertBatch([
            ['id' => 1, 'nama' => 'CACAT FISIK'],
            ['id' => 2, 'nama' => 'CACAT NETRA/BUTA'],
            ['id' => 3, 'nama' => 'CACAT RUNGU/WICARA'],
            ['id' => 4, 'nama' => 'CACAT MENTAL/JIWA'],
            ['id' => 5, 'nama' => 'CACAT FISIK DAN MENTAL'],
            ['id' => 6, 'nama' => 'CACAT LAINNYA'],
            ['id' => 7, 'nama' => 'TIDAK CACAT'],
        ]);
    }
}
