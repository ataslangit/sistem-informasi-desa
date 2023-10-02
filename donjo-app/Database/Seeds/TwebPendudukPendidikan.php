<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TwebPendudukPendidikan extends Seeder
{
    public function run()
    {
        $this->db->query("INSERT INTO `tweb_penduduk_pendidikan` (`id`, `nama`) VALUES
        (1, 'BELUM MASUK TK/KELOMPOK BERMAIN'),
        (2, 'SEDANG TK/KELOMPOK BERMAIN'),
        (3, 'TIDAK PERNAH SEKOLAH'),
        (4, 'SEDANG SD/SEDERAJAT'),
        (5, 'TIDAK TAMAT SD/SEDERAJAT'),
        (6, 'SEDANG SLTP/SEDERAJAT'),
        (7, 'SEDANG SLTA/SEDERAJAT'),
        (8, 'SEDANG D-1/SEDERAJAT'),
        (9, 'SEDANG D-2/SEDERAJAT'),
        (10, 'SEDANG D-3/SEDERAJAT'),
        (11, 'SEDANG S-1/SEDERAJAT'),
        (12, 'SEDANG S-2/SEDERAJAT'),
        (13, 'SEDANG S-3/SEDERAJAT'),
        (14, 'SEDANG SLB A/SEDERAJAT'),
        (15, 'SEDANG SLB B/SEDERAJAT'),
        (16, 'SEDANG SLB C/SEDERAJAT'),
        (17, 'TIDAK DAPAT MEMBACA DAN MENULIS'),
        (18, 'TIDAK SEDANG SEKOLAH');");
    }
}
