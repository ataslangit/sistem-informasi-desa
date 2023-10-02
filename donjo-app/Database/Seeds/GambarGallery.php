<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GambarGallery extends Seeder
{
    public function run()
    {
        $this->db->query("INSERT INTO `gambar_gallery` (`id`, `parrent`, `gambar`, `nama`, `enabled`, `tgl_upload`, `tipe`) VALUES
        (1, 0, '2017 02 - Contoh Foto SID 3.10 c.jpg', 'Contoh Album 1', 1, '2017-02-05 18:20:55', 0),
        (2, 1, '2017 02 - Contoh Foto SID 3.10 b.jpg', 'Desa 1', 1, '2017-02-05 18:21:20', 2),
        (3, 0, '2017 02 - Contoh Foto SID 3.10 d.jpg', 'Contoh Album 2', 1, '2017-02-05 18:37:03', 0),
        (4, 1, '2017 02 - Contoh Foto SID 3.10 d.jpg', 'Desa 2', 1, '2017-02-05 18:37:28', 2),
        (5, 3, '2017 02 - Contoh Foto SID 3.10 c.jpg', 'Tani 1', 1, '2017-02-05 18:37:56', 2),
        (6, 3, '2017 02 - Contoh Foto SID 3.10.jpg', 'Tani 2', 1, '2017-02-05 18:38:12', 2);");
    }
}
