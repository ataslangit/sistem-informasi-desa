<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GambarGallery extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('gambar_gallery');

        $builder->insertBatch([
            [
                'id'         => 1,
                'parrent'    => 0,
                'gambar'     => '2017 02 - Contoh Foto SID 3.10 c.jpg',
                'nama'       => 'Contoh Album 1',
                'enabled'    => 1,
                'tgl_upload' => '2017-02-05 18:20:55',
                'tipe'       => 0,
            ],
            [
                'id'         => 2,
                'parrent'    => 1,
                'gambar'     => '2017 02 - Contoh Foto SID 3.10 b.jpg',
                'nama'       => 'Desa 1',
                'enabled'    => 1,
                'tgl_upload' => '2017-02-05 18:21:20',
                'tipe'       => 2,
            ],
            [
                'id'         => 3,
                'parrent'    => 0,
                'gambar'     => '2017 02 - Contoh Foto SID 3.10 d.jpg',
                'nama'       => 'Contoh Album 2',
                'enabled'    => 1,
                'tgl_upload' => '2017-02-05 18:37:03',
                'tipe'       => 0,
            ],
            [
                'id'         => 4,
                'parrent'    => 1,
                'gambar'     => '2017 02 - Contoh Foto SID 3.10 d.jpg',
                'nama'       => 'Desa 2',
                'enabled'    => 1,
                'tgl_upload' => '2017-02-05 18:37:28',
                'tipe'       => 2,
            ],
            [
                'id'         => 5,
                'parrent'    => 3,
                'gambar'     => '2017 02 - Contoh Foto SID 3.10 c.jpg',
                'nama'       => 'Tani 1',
                'enabled'    => 1,
                'tgl_upload' => '2017-02-05 18:37:56',
                'tipe'       => 2,
            ],
            [
                'id'         => 6,
                'parrent'    => 3,
                'gambar'     => '2017 02 - Contoh Foto SID 3.10.jpg',
                'nama'       => 'Tani 2',
                'enabled'    => 1,
                'tgl_upload' => '2017-02-05 18:38:12',
                'tipe'       => 2,
            ],
        ]);
    }
}
