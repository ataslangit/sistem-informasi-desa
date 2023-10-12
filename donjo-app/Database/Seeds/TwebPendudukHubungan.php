<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TwebPendudukHubungan extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('tweb_penduduk_hubungan');

        $builder->insertBatch([
            ['id' => 1, 'nama' => 'KEPALA KELUARGA'],
            ['id' => 2, 'nama' => 'SUAMI'],
            ['id' => 3, 'nama' => 'ISTRI'],
            ['id' => 4, 'nama' => 'ANAK'],
            ['id' => 5, 'nama' => 'MENANTU'],
            ['id' => 6, 'nama' => 'CUCU'],
            ['id' => 7, 'nama' => 'ORANGTUA'],
            ['id' => 8, 'nama' => 'MERTUA'],
            ['id' => 9, 'nama' => 'FAMILI LAIN'],
            ['id' => 10, 'nama' => 'PEMBANTU'],
            ['id' => 11, 'nama' => 'LAINNYA'],
        ]);
    }
}
