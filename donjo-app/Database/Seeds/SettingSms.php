<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SettingSms extends Seeder
{
    public function run()
    {
        $this->db->query("INSERT INTO `setting_sms` (`autoreply_text`) VALUES
        ('Terima kasih pesan Anda telah kami terima.');");
    }
}
