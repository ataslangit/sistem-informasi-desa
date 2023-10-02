<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TwebSakitMenahun extends Seeder
{
    public function run()
    {
        $this->db->query("INSERT INTO `tweb_sakit_menahun` (`id`, `nama`) VALUES
        (1, 'JANTUNG'),
        (2, 'LEVER'),
        (3, 'PARU-PARU'),
        (4, 'KANKER'),
        (5, 'STROKE'),
        (6, 'DIABETES MELITUS'),
        (7, 'GINJAL'),
        (8, 'MALARIA'),
        (9, 'LEPRA/ KUSTA'),
        (10, 'HIV/ AIDS'),
        (11, 'GILA/STRESS'),
        (12, 'TBC'),
        (13, 'ASTHMA'),
        (14, 'TIDAK ADA/ TIDAK SAKIT');");
    }
}
