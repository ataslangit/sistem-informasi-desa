<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserGrup extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('user_grup');

        $builder->insertBatch([
            ['id' => 1, 'nama' => 'Administrator'],
            ['id' => 2, 'nama' => 'Operator'],
            ['id' => 3, 'nama' => 'Redaksi'],
            ['id' => 4, 'nama' => 'Kontributor'],
        ]);
    }
}
