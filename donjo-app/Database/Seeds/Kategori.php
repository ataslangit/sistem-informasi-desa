<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Kategori extends Seeder
{
    public function run()
    {
        $this->db->query("INSERT INTO `kategori` (`id`, `kategori`, `tipe`, `urut`, `enabled`, `parrent`) VALUES
        (1, 'Berita ', 1, 1, 1, 0),
        (4, 'Agenda ', 2, 2, 1, 0),
        (5, 'Produk Hukum', 2, 5, 1, 0),
        (6, 'Perencanaan & Penganggaran', 2, 6, 1, 0),
        (8, 'Laporan', 2, 3, 1, 0),
        (18, 'Panduan Layanan Publik', 1, 0, 1, 0),
        (17, 'teks_berjalan', 1, 0, 1, 0),
        (19, 'Potensi & Produk Usaha', 1, 0, 1, 0);");
    }
}
