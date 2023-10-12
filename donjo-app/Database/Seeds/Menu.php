<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Menu extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('menu');

        $builder->insertBatch([
            [
                'id'        => 16,
                'nama'      => 'Profil Desa',
                'link'      => 'artikel/1',
                'tipe'      => 1,
                'parrent'   => 1,
                'link_tipe' => 0,
                'enabled'   => 1,
            ],
            [
                'id'        => 17,
                'nama'      => 'Pemerintahan Desa',
                'link'      => 'artikel/7',
                'tipe'      => 1,
                'parrent'   => 1,
                'link_tipe' => 0,
                'enabled'   => 1,
            ],
            [
                'id'        => 19,
                'nama'      => 'Lembaga Masyarakat Desa',
                'link'      => 'artikel/11',
                'tipe'      => 1,
                'parrent'   => 1,
                'link_tipe' => 0,
                'enabled'   => 1,
            ],
            [
                'id'        => 23,
                'nama'      => 'Teras Desa',
                'link'      => '',
                'tipe'      => 2,
                'parrent'   => 1,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 24,
                'nama'      => 'Data Desa',
                'link'      => 'artikel/20',
                'tipe'      => 1,
                'parrent'   => 1,
                'link_tipe' => 0,
                'enabled'   => 1,
            ],
            [
                'id'        => 31,
                'nama'      => 'Data Wilayah Administratif',
                'link'      => 'statistik/wilayah',
                'tipe'      => 3,
                'parrent'   => 24,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 32,
                'nama'      => 'Data Pendidikan dalam KK',
                'link'      => 'statistik/pendidikan-dalam-kk',
                'tipe'      => 3,
                'parrent'   => 24,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 33,
                'nama'      => 'Data Pendidikan Ditempuh',
                'link'      => 'statistik/pendidikan-ditempuh',
                'tipe'      => 3,
                'parrent'   => 24,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 34,
                'nama'      => 'Data Pekerjaan',
                'link'      => 'statistik/pekerjaan',
                'tipe'      => 3,
                'parrent'   => 24,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 35,
                'nama'      => 'Data Agama',
                'link'      => 'statistik/agama',
                'tipe'      => 3,
                'parrent'   => 24,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 36,
                'nama'      => 'Data Jenis Kelamin',
                'link'      => 'statistik/jenis-kelamin',
                'tipe'      => 3,
                'parrent'   => 24,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 40,
                'nama'      => 'Data Golongan Darah',
                'link'      => 'statistik/golongan-darah',
                'tipe'      => 3,
                'parrent'   => 24,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 51,
                'nama'      => 'Data Kelompok Umur',
                'link'      => 'statistik/kelompok-umur',
                'tipe'      => 3,
                'parrent'   => 24,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 54,
                'nama'      => 'Sejarah Desa',
                'link'      => 'artikel/2',
                'tipe'      => 3,
                'parrent'   => 16,
                'link_tipe' => 0,
                'enabled'   => 1,
            ],
            [
                'id'        => 57,
                'nama'      => 'Visi dan Misi',
                'link'      => 'artikel/22',
                'tipe'      => 3,
                'parrent'   => 17,
                'link_tipe' => 0,
                'enabled'   => 1,
            ],
            [
                'id'        => 58,
                'nama'      => 'Kepala Desa',
                'link'      => 'artikel/8',
                'tipe'      => 3,
                'parrent'   => 17,
                'link_tipe' => 0,
                'enabled'   => 1,
            ],
            [
                'id'        => 62,
                'nama'      => 'Berita Desa',
                'link'      => '',
                'tipe'      => 2,
                'parrent'   => 1,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 63,
                'nama'      => 'Agenda Desa',
                'link'      => 'artikel/41',
                'tipe'      => 2,
                'parrent'   => 1,
                'link_tipe' => 1,
                'enabled'   => 2,
            ],
            [
                'id'        => 64,
                'nama'      => 'Peraturan Desa',
                'link'      => 'peraturan',
                'tipe'      => 2,
                'parrent'   => 1,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 65,
                'nama'      => 'Panduan Layanan Desa',
                'link'      => '#',
                'tipe'      => 2,
                'parrent'   => 1,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 66,
                'nama'      => 'Produk Desa',
                'link'      => 'produk',
                'tipe'      => 2,
                'parrent'   => 1,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 68,
                'nama'      => 'Undang undang',
                'link'      => 'artikel/42',
                'tipe'      => 3,
                'parrent'   => 64,
                'link_tipe' => 1,
                'enabled'   => 2,
            ],
            [
                'id'        => 69,
                'nama'      => 'Peraturan Pemerintah',
                'link'      => 'artikel/43',
                'tipe'      => 3,
                'parrent'   => 64,
                'link_tipe' => 1,
                'enabled'   => 2,
            ],
            [
                'id'        => 70,
                'nama'      => 'Peraturan Daerah',
                'link'      => '',
                'tipe'      => 3,
                'parrent'   => 64,
                'link_tipe' => 1,
                'enabled'   => 2,
            ],
            [
                'id'        => 71,
                'nama'      => 'Peraturan Bupati',
                'link'      => '',
                'tipe'      => 3,
                'parrent'   => 64,
                'link_tipe' => 1,
                'enabled'   => 2,
            ],
            [
                'id'        => 72,
                'nama'      => 'Peraturan Bersama KaDes',
                'link'      => '',
                'tipe'      => 3,
                'parrent'   => 64,
                'link_tipe' => 1,
                'enabled'   => 2,
            ],
            [
                'id'        => 73,
                'nama'      => 'Informasi Publik',
                'link'      => '#',
                'tipe'      => 2,
                'parrent'   => 1,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 75,
                'nama'      => 'Rencana Kerja Anggaran',
                'link'      => '',
                'tipe'      => 3,
                'parrent'   => 73,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 76,
                'nama'      => 'RAPB Desa',
                'link'      => '',
                'tipe'      => 3,
                'parrent'   => 73,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 77,
                'nama'      => 'APB Desa',
                'link'      => '',
                'tipe'      => 3,
                'parrent'   => 73,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 78,
                'nama'      => 'DPA',
                'link'      => '',
                'tipe'      => 3,
                'parrent'   => 73,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 80,
                'nama'      => 'Kondisi Umum Desa',
                'link'      => 'artikel/3',
                'tipe'      => 3,
                'parrent'   => 16,
                'link_tipe' => 0,
                'enabled'   => 1,
            ],
            [
                'id'        => 84,
                'nama'      => 'LKMD',
                'link'      => 'artikel/62',
                'tipe'      => 3,
                'parrent'   => 18,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 85,
                'nama'      => 'PKK',
                'link'      => 'artikel/63',
                'tipe'      => 3,
                'parrent'   => 18,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 86,
                'nama'      => 'Karang Taruna',
                'link'      => 'artikel/64',
                'tipe'      => 3,
                'parrent'   => 18,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 87,
                'nama'      => 'RT RW',
                'link'      => 'artikel/65',
                'tipe'      => 3,
                'parrent'   => 18,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 88,
                'nama'      => 'Linmas',
                'link'      => 'artikel/70',
                'tipe'      => 3,
                'parrent'   => 18,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 89,
                'nama'      => 'TKP2KDes',
                'link'      => 'artikel/66',
                'tipe'      => 3,
                'parrent'   => 18,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 90,
                'nama'      => 'KPAD',
                'link'      => 'artikel/67',
                'tipe'      => 3,
                'parrent'   => 18,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 91,
                'nama'      => 'Kelompok Ternak',
                'link'      => 'artikel/68',
                'tipe'      => 3,
                'parrent'   => 18,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 92,
                'nama'      => 'Kelompok Tani',
                'link'      => 'artikel/69',
                'tipe'      => 3,
                'parrent'   => 18,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 93,
                'nama'      => 'Kelompok Ekonomi Lainya',
                'link'      => 'artikel/71',
                'tipe'      => 3,
                'parrent'   => 18,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 98,
                'nama'      => 'LKPJ',
                'link'      => 'D:\\PEMERINTAHAN\\diklat\\lkpj2014',
                'tipe'      => 3,
                'parrent'   => 73,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 99,
                'nama'      => 'LPPD',
                'link'      => '',
                'tipe'      => 3,
                'parrent'   => 73,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 100,
                'nama'      => 'ILPPD',
                'link'      => '',
                'tipe'      => 3,
                'parrent'   => 73,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 101,
                'nama'      => 'Peraturan Desa',
                'link'      => 'artikel/44',
                'tipe'      => 3,
                'parrent'   => 64,
                'link_tipe' => 1,
                'enabled'   => 2,
            ],
            [
                'id'        => 102,
                'nama'      => 'Peraturan Kepala Desa',
                'link'      => 'artikel/45',
                'tipe'      => 3,
                'parrent'   => 64,
                'link_tipe' => 1,
                'enabled'   => 2,
            ],
            [
                'id'        => 103,
                'nama'      => 'Keputusan Kepala Desa',
                'link'      => 'artikel/46',
                'tipe'      => 3,
                'parrent'   => 64,
                'link_tipe' => 1,
                'enabled'   => 2,
            ],
            [
                'id'        => 104,
                'nama'      => 'PBB',
                'link'      => '',
                'tipe'      => 3,
                'parrent'   => 73,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 106,
                'nama'      => 'Data Warga Negara',
                'link'      => 'statistik/warga-negara',
                'tipe'      => 3,
                'parrent'   => 24,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 109,
                'nama'      => 'Kontak Desa',
                'link'      => 'artikel/21',
                'tipe'      => 1,
                'parrent'   => 1,
                'link_tipe' => 0,
                'enabled'   => 1,
            ],
            [
                'id'        => 110,
                'nama'      => 'Status Perkawinan',
                'link'      => 'statistik/status-perkawinan',
                'tipe'      => 3,
                'parrent'   => 24,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 52,
                'nama'      => 'Data Analisis',
                'link'      => 'data_analisis',
                'tipe'      => 3,
                'parrent'   => 24,
                'link_tipe' => 1,
                'enabled'   => 1,
            ],
            [
                'id'        => 111,
                'nama'      => 'Masalah & Isu Strategis Desa',
                'link'      => 'artikel/4',
                'tipe'      => 3,
                'parrent'   => 16,
                'link_tipe' => 0,
                'enabled'   => 1,
            ],
            [
                'id'        => 112,
                'nama'      => 'Kebijakan Pembangunan Desa',
                'link'      => 'artikel/5',
                'tipe'      => 3,
                'parrent'   => 16,
                'link_tipe' => 0,
                'enabled'   => 1,
            ],
            [
                'id'        => 113,
                'nama'      => 'Kebijakan Keuangan Desa',
                'link'      => 'artikel/6',
                'tipe'      => 3,
                'parrent'   => 16,
                'link_tipe' => 0,
                'enabled'   => 1,
            ],
            [
                'id'        => 114,
                'nama'      => 'Perangkat Desa',
                'link'      => 'artikel/9',
                'tipe'      => 3,
                'parrent'   => 17,
                'link_tipe' => 0,
                'enabled'   => 1,
            ],
            [
                'id'        => 115,
                'nama'      => 'Badan Permusyawaratan Desa',
                'link'      => 'artikel/10',
                'tipe'      => 3,
                'parrent'   => 17,
                'link_tipe' => 0,
                'enabled'   => 1,
            ],
            [
                'id'        => 116,
                'nama'      => 'LPMD',
                'link'      => 'artikel/12',
                'tipe'      => 3,
                'parrent'   => 19,
                'link_tipe' => 0,
                'enabled'   => 1,
            ],
            [
                'id'        => 117,
                'nama'      => 'Lembaga Adat',
                'link'      => 'artikel/13',
                'tipe'      => 3,
                'parrent'   => 19,
                'link_tipe' => 0,
                'enabled'   => 1,
            ],
            [
                'id'        => 118,
                'nama'      => 'TP PKK',
                'link'      => 'artikel/14',
                'tipe'      => 3,
                'parrent'   => 19,
                'link_tipe' => 0,
                'enabled'   => 1,
            ],
            [
                'id'        => 119,
                'nama'      => 'BUMDes',
                'link'      => 'artikel/15',
                'tipe'      => 3,
                'parrent'   => 19,
                'link_tipe' => 0,
                'enabled'   => 1,
            ],
            [
                'id'        => 120,
                'nama'      => 'Karang Taruna',
                'link'      => 'artikel/16',
                'tipe'      => 3,
                'parrent'   => 19,
                'link_tipe' => 0,
                'enabled'   => 1,
            ],
            [
                'id'        => 121,
                'nama'      => 'RT/RW',
                'link'      => 'artikel/17',
                'tipe'      => 3,
                'parrent'   => 19,
                'link_tipe' => 0,
                'enabled'   => 1,
            ],
            [
                'id'        => 122,
                'nama'      => 'Linmas',
                'link'      => 'artikel/18',
                'tipe'      => 3,
                'parrent'   => 19,
                'link_tipe' => 0,
                'enabled'   => 1,
            ],
            [
                'id'        => 123,
                'nama'      => 'Lembaga Masyarakat Lainnya',
                'link'      => 'artikel/19',
                'tipe'      => 3,
                'parrent'   => 19,
                'link_tipe' => 0,
                'enabled'   => 1,
            ],
        ]);
    }
}
