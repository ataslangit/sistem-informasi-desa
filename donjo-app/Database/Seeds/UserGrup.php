<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserGrup extends Seeder
{
    public function run()
    {
        $this->db->query("INSERT INTO `user_grup` (`id`, `nama`) VALUES
        (1, 'Administrator'),
        (2, 'Operator'),
        (3, 'Redaksi'),
        (4, 'Kontributor');");
    }
}
