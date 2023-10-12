<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TwebDesaPamong extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('tweb_desa_pamong');

        $builder->insertBatch([
            [
                'pamong_id'     => 1, 'pamong_nama' => 'Jarwo', 'pamong_nip' => '',
                'pamong_nik'    => '', 'jabatan' => 'Kepala Desa',
                'pamong_status' => '1', 'pamong_tgl_terdaftar' => '2015-05-19',
            ],
            [
                'pamong_id'     => 2, 'pamong_nama' => 'Jarwo', 'pamong_nip' => '',
                'pamong_nik'    => '', 'jabatan' => '(A/n) Kepala Desa',
                'pamong_status' => '1', 'pamong_tgl_terdaftar' => '2015-05-19',
            ],
        ]);
    }
}
