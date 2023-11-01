<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SettingSms extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('setting_sms');

        $builder->insert(['autoreply_text' => 'Terima kasih pesan Anda telah kami terima.']);
    }
}
