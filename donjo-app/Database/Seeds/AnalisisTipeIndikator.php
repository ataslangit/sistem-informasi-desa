<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AnalisisTipeIndikator extends Seeder
{
    public function run()
    {
        $this->db->query("INSERT INTO `analisis_tipe_indikator` (`id`, `tipe`) VALUES
        (1, 'Pilihan (Tunggal)'),
        (2, 'Pilihan (Multivalue)'),
        (3, 'Isian Angka'),
        (4, 'Isian Tulisan')");
    }
}
