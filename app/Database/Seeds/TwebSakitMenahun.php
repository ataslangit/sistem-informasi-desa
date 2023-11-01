<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TwebSakitMenahun extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('tweb_sakit_menahun');

        $builder->insertBatch([
            ['id' => 1, 'nama' => 'JANTUNG'],
            ['id' => 2, 'nama' => 'LEVER'],
            ['id' => 3, 'nama' => 'PARU-PARU'],
            ['id' => 4, 'nama' => 'KANKER'],
            ['id' => 5, 'nama' => 'STROKE'],
            ['id' => 6, 'nama' => 'DIABETES MELITUS'],
            ['id' => 7, 'nama' => 'GINJAL'],
            ['id' => 8, 'nama' => 'MALARIA'],
            ['id' => 9, 'nama' => 'LEPRA/ KUSTA'],
            ['id' => 10, 'nama' => 'HIV/ AIDS'],
            ['id' => 11, 'nama' => 'GILA/STRESS'],
            ['id' => 12, 'nama' => 'TBC'],
            ['id' => 13, 'nama' => 'ASTHMA'],
            ['id' => 14, 'nama' => 'TIDAK ADA/ TIDAK SAKIT'],
        ]);
    }
}
