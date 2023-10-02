<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DataPersilPeruntukan extends Seeder
{
    public function run()
    {
        $this->db->query("INSERT INTO `data_persil_peruntukan` (`id`, `nama`, `ndesc`) VALUES
        (1, 'Sawah', 'Sawah'),
        (2, 'Pekarangan', 'Pekarangan'),
        (3, 'Perumahan', 'Perumahan')");
    }
}
