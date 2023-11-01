<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Kategori extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('kategori');

        $builder->insertBatch([
            ['id' => '1', 'kategori' => 'Berita ', 'tipe' => 1, 'urut' => 1, 'enabled' => 1, 'parrent' => 0],
            ['id' => '4', 'kategori' => 'Agenda ', 'tipe' => 2, 'urut' => 2, 'enabled' => 1, 'parrent' => 0],
            ['id' => '5', 'kategori' => 'Produk Hukum', 'tipe' => 2, 'urut' => 5, 'enabled' => 1, 'parrent' => 0],
            ['id' => '6', 'kategori' => 'Perencanaan & Penganggaran', 'tipe' => 2, 'urut' => 6, 'enabled' => 1, 'parrent' => 0],
            ['id' => '8', 'kategori' => 'Laporan', 'tipe' => 2, 'urut' => 3, 'enabled' => 1, 'parrent' => 0],
            ['id' => '18', 'kategori' => 'Panduan Layanan Publik', 'tipe' => 1, 'urut' => 0, 'enabled' => 1, 'parrent' => 0],
            ['id' => '17', 'kategori' => 'teks_berjalan', 'tipe' => 1, 'urut' => 0, 'enabled' => 1, 'parrent' => 0],
            ['id' => '19', 'kategori' => 'Potensi & Produk Usaha', 'tipe' => 1, 'urut' => 0, 'enabled' => 1, 'parrent' => 0],
        ]);
    }
}
