<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AnalisisTipeIndikator extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('analisis_tipe_indikator');

        $builder->insertBatch([
            ['id' => '1', 'tipe' => 'Pilihan (Tunggal)'],
            ['id' => '2', 'tipe' => 'Pilihan (Multivalue)'],
            ['id' => '3', 'tipe' => 'Isian Angka'],
            ['id' => '4', 'tipe' => 'Isian Tulisan'],
        ]);
    }
}
