<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DataJenisPersil extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('data_persil_jenis');

        $builder->insertBatch([
            ['id'       => '1',
                'nama'  => 'Leter C',
                'ndesc' => 'Untuk tanah yang memiliki surat minim itu biasanya berupa leter C. Letter C ini diperoleh dari kantor desa dimana tanah itu berada, letter C ini merupakan tanda bukti berupa catatan yang berada di Kantor Desa atau Kelurahan.',
            ],
            ['id'       => '2',
                'nama'  => 'Leter D',
                'ndesc' => 'Leter D adalah',
            ],
            ['id'       => '4',
                'nama'  => 'SHM',
                'ndesc' => 'Sertifikat Hak Milik adalah bl ab a',
            ],
            ['id'       => '5',
                'nama'  => 'HGB',
                'ndesc' => 'Hak Guna Bangunan adalah',
            ],
        ]);
    }
}
