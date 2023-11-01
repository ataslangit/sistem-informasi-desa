<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TwebGolonganDarah extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('tweb_golongan_darah');

        $builder->insertBatch([
            ['id' => 1, 'nama' => 'A'],
            ['id' => 2, 'nama' => 'B'],
            ['id' => 3, 'nama' => 'AB'],
            ['id' => 4, 'nama' => 'O'],
            ['id' => 5, 'nama' => 'A+'],
            ['id' => 6, 'nama' => 'A-'],
            ['id' => 7, 'nama' => 'B+'],
            ['id' => 8, 'nama' => 'B-'],
            ['id' => 9, 'nama' => 'AB+'],
            ['id' => 10, 'nama' => 'AB-'],
            ['id' => 11, 'nama' => 'O+'],
            ['id' => 12, 'nama' => 'O-'],
            ['id' => 13, 'nama' => 'TIDAK TAHU'],
        ]);
    }
}
