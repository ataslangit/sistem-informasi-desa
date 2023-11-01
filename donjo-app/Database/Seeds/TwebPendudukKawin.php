<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TwebPendudukKawin extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('tweb_penduduk_kawin');

        $builder->insertBatch([
            ['id' => 1, 'nama' => 'BELUM KAWIN'],
            ['id' => 2, 'nama' => 'KAWIN'],
            ['id' => 3, 'nama' => 'CERAI HIDUP'],
            ['id' => 4, 'nama' => 'CERAI MATI'],
        ]);
    }
}
