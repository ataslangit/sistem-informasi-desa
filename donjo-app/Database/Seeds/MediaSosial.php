<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MediaSosial extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('media_sosial');

        $builder->insertBatch([
            [
                'id'      => 1,
                'gambar'  => 'fb.png',
                'link'    => 'https://www.facebook.com/combine.ri',
                'nama'    => 'Facebook',
                'enabled' => 1,
            ],
            [
                'id'      => 2,
                'gambar'  => 'twt.png',
                'link'    => 'https://twitter.com/combineri',
                'nama'    => 'Twitter',
                'enabled' => 1,
            ],
            [
                'id'      => 3,
                'gambar'  => 'goo.png',
                'link'    => 'https://plus.google.com/u/0/104218605911096018855',
                'nama'    => 'Google Pluss',
                'enabled' => 1,
            ],
            [
                'id'      => 4,
                'gambar'  => 'yb.png',
                'link'    => 'http://www.youtube.com/channel/UCk3eN9fI_eLGYzAn_lOlgXQ',
                'nama'    => 'Youtube',
                'enabled' => 1,
            ],
            [
                'id'      => 5,
                'gambar'  => 'ins.png',
                'link'    => 'http://instagram.com/combine_ri',
                'nama'    => 'Instagram',
                'enabled' => 1,
            ],
        ]);
    }
}
