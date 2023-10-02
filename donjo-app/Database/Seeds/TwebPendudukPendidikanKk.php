<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TwebPendudukPendidikanKk extends Seeder
{
    public function run()
    {
        $this->db->query("INSERT INTO `tweb_penduduk_pendidikan_kk` (`id`, `nama`) VALUES
        (1, 'TIDAK / BELUM SEKOLAH'),
        (2, 'BELUM TAMAT SD/SEDERAJAT'),
        (3, 'TAMAT SD / SEDERAJAT'),
        (4, 'SLTP/SEDERAJAT'),
        (5, 'SLTA / SEDERAJAT'),
        (6, 'DIPLOMA I / II'),
        (7, 'AKADEMI/ DIPLOMA III/S. MUDA'),
        (8, 'DIPLOMA IV/ STRATA I'),
        (9, 'STRATA II'),
        (10, 'STRATA III');");
    }
}
