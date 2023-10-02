<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TwebGolonganDarah extends Seeder
{
    public function run()
    {
        $this->db->query("INSERT INTO `tweb_golongan_darah` (`id`, `nama`) VALUES
        (1, 'A'),
        (2, 'B'),
        (3, 'AB'),
        (4, 'O'),
        (5, 'A+'),
        (6, 'A-'),
        (7, 'B+'),
        (8, 'B-'),
        (9, 'AB+'),
        (10, 'AB-'),
        (11, 'O+'),
        (12, 'O-'),
        (13, 'TIDAK TAHU');");
    }
}
