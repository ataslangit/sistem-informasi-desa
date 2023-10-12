<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TwebPendudukPendidikan extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('tweb_penduduk_pendidikan');

        $builder->insertBatch([
            ['id' => 1, 'nama' => 'BELUM MASUK TK/KELOMPOK BERMAIN'],
            ['id' => 2, 'nama' => 'SEDANG TK/KELOMPOK BERMAIN'],
            ['id' => 3, 'nama' => 'TIDAK PERNAH SEKOLAH'],
            ['id' => 4, 'nama' => 'SEDANG SD/SEDERAJAT'],
            ['id' => 5, 'nama' => 'TIDAK TAMAT SD/SEDERAJAT'],
            ['id' => 6, 'nama' => 'SEDANG SLTP/SEDERAJAT'],
            ['id' => 7, 'nama' => 'SEDANG SLTA/SEDERAJAT'],
            ['id' => 8, 'nama' => 'SEDANG D-1/SEDERAJAT'],
            ['id' => 9, 'nama' => 'SEDANG D-2/SEDERAJAT'],
            ['id' => 10, 'nama' => 'SEDANG D-3/SEDERAJAT'],
            ['id' => 11, 'nama' => 'SEDANG S-1/SEDERAJAT'],
            ['id' => 12, 'nama' => 'SEDANG S-2/SEDERAJAT'],
            ['id' => 13, 'nama' => 'SEDANG S-3/SEDERAJAT'],
            ['id' => 14, 'nama' => 'SEDANG SLB A/SEDERAJAT'],
            ['id' => 15, 'nama' => 'SEDANG SLB B/SEDERAJAT'],
            ['id' => 16, 'nama' => 'SEDANG SLB C/SEDERAJAT'],
            ['id' => 17, 'nama' => 'TIDAK DAPAT MEMBACA DAN MENULIS'],
            ['id' => 18, 'nama' => 'TIDAK SEDANG SEKOLAH'],
        ]);
    }
}
