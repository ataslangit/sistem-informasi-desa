<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MediaSosial extends Seeder
{
    public function run()
    {
        $this->db->query("INSERT INTO `media_sosial` (`id`, `gambar`, `link`, `nama`, `enabled`) VALUES
        (1, 'fb.png', 'https://www.facebook.com/combine.ri', 'Facebook', 1),
        (2, 'twt.png', 'https://twitter.com/combineri', 'Twitter', 1),
        (3, 'goo.png', 'https://plus.google.com/u/0/104218605911096018855', 'Google Pluss', 1),
        (4, 'yb.png', 'http://www.youtube.com/channel/UCk3eN9fI_eLGYzAn_lOlgXQ', 'Youtube', 1),
        (5, 'ins.png', 'http://instagram.com/combine_ri', 'Instagram', 1);");
    }
}
