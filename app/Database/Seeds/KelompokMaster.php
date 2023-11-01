<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KelompokMaster extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('kelompok_master');

        $builder->insertBatch([
            ['id' => 1, 'kelompok' => 'Kelompok Tani', 'deskripsi' => 'ent'],
            ['id' => 2, 'kelompok' => 'Dasa Wisma', 'deskripsi' => 'Oye'],
            ['id' => 3, 'kelompok' => 'Jagongan', 'deskripsi' => 'OOO'],
        ]);
    }
}
