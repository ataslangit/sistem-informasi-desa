<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TwebPendudukStatus extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('tweb_penduduk_status');

        $builder->insertBatch([
            ['id' => 1, 'nama' => 'TETAP'],
            ['id' => 2, 'nama' => 'TIDAK AKTIF'],
            ['id' => 3, 'nama' => 'PENDUDUK DOMISILI'],
            ['id' => 77, 'nama' => 'WARGA'],
        ]);
    }
}
