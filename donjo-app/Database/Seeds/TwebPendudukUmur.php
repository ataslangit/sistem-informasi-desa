<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TwebPendudukUmur extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('tweb_penduduk_umur');

        $builder->insertBatch([
            ['id' => 1, 'nama' => 'BALITA', 'dari' => 0, 'sampai' => 5, 'status' => 0],
            ['id' => 2, 'nama' => 'ANAK-ANAK', 'dari' => 6, 'sampai' => 17, 'status' => 0],
            ['id' => 3, 'nama' => 'DEWASA', 'dari' => 18, 'sampai' => 30, 'status' => 0],
            ['id' => 4, 'nama' => 'TUA', 'dari' => 31, 'sampai' => 120, 'status' => 0],
            ['id' => 6, 'nama' => 'Dibawah 1 Tahun', 'dari' => 0, 'sampai' => 1, 'status' => 1],
            ['id' => 9, 'nama' => '2 s/d 4 Tahun', 'dari' => 2, 'sampai' => 4, 'status' => 1],
            ['id' => 12, 'nama' => '5 s/d 9 Tahun', 'dari' => 5, 'sampai' => 9, 'status' => 1],
            ['id' => 13, 'nama' => '10 s/d 14 Tah', 'dari' => 10, 'sampai' => 14, 'status' => 1],
            ['id' => 14, 'nama' => '15 s/d 19 Tahun', 'dari' => 15, 'sampai' => 19, 'status' => 1],
            ['id' => 15, 'nama' => '20 s/d 24 Tahun', 'dari' => 20, 'sampai' => 24, 'status' => 1],
            ['id' => 16, 'nama' => '25 s/d 29 Tahun', 'dari' => 25, 'sampai' => 29, 'status' => 1],
            ['id' => 17, 'nama' => '30 s/d 34 Tahun', 'dari' => 30, 'sampai' => 34, 'status' => 1],
            ['id' => 18, 'nama' => '35 s/d 39 Tahun ', 'dari' => 35, 'sampai' => 39, 'status' => 1],
            ['id' => 19, 'nama' => '40 s/d 44 Tahun', 'dari' => 40, 'sampai' => 44, 'status' => 1],
            ['id' => 20, 'nama' => '45 s/d 49 Tahun', 'dari' => 45, 'sampai' => 49, 'status' => 1],
            ['id' => 21, 'nama' => '50 s/d 54 Tahun', 'dari' => 50, 'sampai' => 54, 'status' => 1],
            ['id' => 22, 'nama' => '55 s/d 59 Tahun', 'dari' => 55, 'sampai' => 59, 'status' => 1],
            ['id' => 23, 'nama' => '60 s/d 64 Tahun', 'dari' => 60, 'sampai' => 64, 'status' => 1],
            ['id' => 24, 'nama' => '65 s/d 69 Tahun', 'dari' => 65, 'sampai' => 69, 'status' => 1],
            ['id' => 25, 'nama' => '70 s/d 74 Tahun', 'dari' => 70, 'sampai' => 74, 'status' => 1],
            ['id' => 26, 'nama' => 'Diatas 75 Tahun', 'dari' => 75, 'sampai' => 99999, 'status' => 1],
        ]);
    }
}
