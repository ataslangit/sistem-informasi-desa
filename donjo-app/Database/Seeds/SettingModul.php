<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SettingModul extends Seeder
{
    public function run()
    {
        $this->db->query("INSERT INTO `setting_modul` (`id`, `modul`, `url`, `aktif`, `ikon`, `urut`, `level`, `hidden`) VALUES
        (1, 'SID Home', 'hom_desa', 1, 'go-home-5.png', 1, 2, 1),
        (2, 'Penduduk', 'penduduk/clear', 1, 'preferences-contact-list.png', 2, 2, 0),
        (3, 'Statistik', 'statistik', 1, 'statistik.png', 3, 2, 0),
        (4, 'Cetak Surat', 'surat', 1, 'applications-office-5.png', 4, 2, 0),
        (5, 'Analisis', 'analisis_master/clear', 1, 'analysis.png', 5, 2, 0),
        (6, 'Bantuan', 'program_bantuan', 2, 'program.png', 6, 2, 0),
        (7, 'Persil', 'data_persil/clear', 2, 'persil.png', 7, 2, 0),
        (8, 'Plan', 'plan', 2, 'plan.png', 8, 2, 0),
        (9, 'Peta', 'gis', 2, 'gis.png', 9, 2, 0),
        (10, 'SMS', 'sms', 2, 'mail-send-receive.png', 10, 2, 0),
        (11, 'Pengguna', 'man_user/clear', 1, 'system-users.png', 11, 1, 1),
        (12, 'Database', 'database', 1, 'database.png', 12, 1, 0),
        (13, 'Admin Web', 'web/clear', 1, 'message-news.png', 13, 4, 0),
        (14, 'Laporan', 'lapor', 1, 'mail-reply-all.png', 14, 2, 0);");
    }
}
