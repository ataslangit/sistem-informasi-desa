<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TwebPendudukUmur extends Seeder
{
    public function run()
    {
        $this->db->query("INSERT INTO `tweb_penduduk_umur` (`id`, `nama`, `dari`, `sampai`, `status`) VALUES
        (1, 'BALITA', 0, 5, 0),
        (2, 'ANAK-ANAK', 6, 17, 0),
        (3, 'DEWASA', 18, 30, 0),
        (4, 'TUA', 31, 120, 0),
        (6, 'Dibawah 1 Tahun', 0, 1, 1),
        (9, '2 s/d 4 Tahun', 2, 4, 1),
        (12, '5 s/d 9 Tahun', 5, 9, 1),
        (13, '10 s/d 14 Tah', 10, 14, 1),
        (14, '15 s/d 19 Tahun', 15, 19, 1),
        (15, '20 s/d 24 Tahun', 20, 24, 1),
        (16, '25 s/d 29 Tahun', 25, 29, 1),
        (17, '30 s/d 34 Tahun', 30, 34, 1),
        (18, '35 s/d 39 Tahun ', 35, 39, 1),
        (19, '40 s/d 44 Tahun', 40, 44, 1),
        (20, '45 s/d 49 Tahun', 45, 49, 1),
        (21, '50 s/d 54 Tahun', 50, 54, 1),
        (22, '55 s/d 59 Tahun', 55, 59, 1),
        (23, '60 s/d 64 Tahun', 60, 64, 1),
        (24, '65 s/d 69 Tahun', 65, 69, 1),
        (25, '70 s/d 74 Tahun', 70, 74, 1),
        (26, 'Diatas 75 Tahun', 75, 99999, 1);");
    }
}
