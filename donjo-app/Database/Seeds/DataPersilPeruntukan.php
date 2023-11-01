<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DataPersilPeruntukan extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('data_persil_peruntukan');

        $builder->insertBatch([
            ['id' => '1', 'nama' => 'Sawah', 'ndesc' => 'Sawah'],
            ['id' => '2', 'nama' => 'Pekarangan', 'ndesc' => 'Pekarangan'],
            ['id' => '3', 'nama' => 'Perumahan', 'ndesc' => 'Perumahan'],
        ]);
    }
}
