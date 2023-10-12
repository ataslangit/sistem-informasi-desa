<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TwebPendudukAgama extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('tweb_penduduk_agama');

        $builder->insertBatch([
            ['id' => 1, 'nama' => 'ISLAM'],
            ['id' => 2, 'nama' => 'KRISTEN'],
            ['id' => 3, 'nama' => 'KATHOLIK'],
            ['id' => 4, 'nama' => 'HINDU'],
            ['id' => 5, 'nama' => 'BUDHA'],
            ['id' => 6, 'nama' => 'KHONGHUCU'],
            ['id' => 7, 'nama' => 'LAINNYA (Kepercayaan Terhadap Tuhan YME)'],
        ]);
    }
}
