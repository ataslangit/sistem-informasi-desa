<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DataJenisPersil extends Seeder
{
    public function run()
    {
        $this->db->query("INSERT INTO `data_persil_jenis` (`id`, `nama`, `ndesc`) VALUES
        (1, 'Leter C', 'Untuk tanah yang memiliki surat minim itu biasanya berupa leter C. Letter C ini diperoleh dari kantor desa dimana tanah itu berada, letter C ini merupakan tanda bukti berupa catatan yang berada di Kantor Desa atau Kelurahan.'),
        (2, 'Leter D', 'Leter D adalah'),
        (4, 'SHM', 'Sertifikat Hak Milik adalah bl ab a'),
        (5, 'HGB', 'Hak Guna Bangunan adalah')");
    }
}
