<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TwebPendudukPendidikanKk extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('tweb_penduduk_pendidikan_kk');

        $builder->insertBatch([
            ['id' => 1, 'nama' => 'TIDAK / BELUM SEKOLAH'],
            ['id' => 2, 'nama' => 'BELUM TAMAT SD/SEDERAJAT'],
            ['id' => 3, 'nama' => 'TAMAT SD / SEDERAJAT'],
            ['id' => 4, 'nama' => 'SLTP/SEDERAJAT'],
            ['id' => 5, 'nama' => 'SLTA / SEDERAJAT'],
            ['id' => 6, 'nama' => 'DIPLOMA I / II'],
            ['id' => 7, 'nama' => 'AKADEMI/ DIPLOMA III/S. MUDA'],
            ['id' => 8, 'nama' => 'DIPLOMA IV/ STRATA I'],
            ['id' => 9, 'nama' => 'STRATA II'],
            ['id' => 10, 'nama' => 'STRATA III'],
        ]);
    }
}
